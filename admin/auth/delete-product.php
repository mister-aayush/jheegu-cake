<?php
include '../db-conn.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Invalid product ID.');
}

$id = intval($_GET['id']);

$query = "DELETE FROM menu WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt)) {
    header('Location: dashboard.php'); 
    exit;
} else {
    echo "Failed to delete product.";
}
?>
