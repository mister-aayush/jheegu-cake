
<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    header('Location: login.php');
    exit();
}


$user_email = $_POST['email'];
$user_password = $_POST['password'];
 
include '../db-conn.php';

$query = "SELECT * FROM admin  WHERE email=? AND password=?";
$mysql_stmt =  mysqli_prepare($conn,  $query);
mysqli_stmt_bind_param($mysql_stmt,'ss', $user_email, $user_password);
mysqli_stmt_execute($mysql_stmt);
$mysql_result=  mysqli_stmt_get_result($mysql_stmt);

$data =  mysqli_fetch_assoc($mysql_result);



if($data) {

    session_start();
    $_SESSION['is_loggedin'] = true;
    header("Location: ../dashboard/dashboard.php");
} else {
    header("Location: login.php?error=email or password incorrect");
}