<?php 

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header('Location: dashboard.php');
    exit();
}
$product_image = $_FILES["image"];
$product_name = $_POST['name'];
$product_description = $_POST['description'];
$price = $_POST['price'];
$image_path = "";


if(isset($product_image) && $product_image['error'] == 0){
    $upload_dir = "product-uploads/";
    $image_name = time() . '_' . basename($product_image['name']);
    $target_path = $upload_dir . $image_name;

    if(move_uploaded_file($product_image['tmp_name'], $target_path )){
        $image_path  = $target_path;
    }
}

include '../db-conn.php';


$query = "INSERT INTO menu (`image-url`, `item-name`, description, price) VALUES (?, ?, ?, ?)";
$abc = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($abc, "sssi", $image_path, $product_name, $product_description, $price);
mysqli_stmt_execute($abc);


header("Location: dashboard.php?path=menu");




?>