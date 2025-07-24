<?php
// Check if form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../../../frontend/index.php');
    exit();
}

// Include database connection
include '../../db-conn.php';

// Get form data and sanitize
$pound = intval($_POST['pound'] ?? 1);
$egg_option = mysqli_real_escape_string($conn, $_POST['egg_option'] ?? '');
$cake_message = mysqli_real_escape_string($conn, $_POST['cake_message'] ?? '');
$cake_name = mysqli_real_escape_string($conn, $_POST['cake_name'] ?? '');
$cake_price = intval($_POST['cake_price'] ?? 0);

$full_name = mysqli_real_escape_string($conn, $_POST['full_name'] ?? '');
$location = mysqli_real_escape_string($conn, $_POST['location'] ?? '');
$contact = mysqli_real_escape_string($conn, $_POST['contact'] ?? '');
$delivery_date = mysqli_real_escape_string($conn, $_POST['delivery_date'] ?? '');
$delivery_time = mysqli_real_escape_string($conn, $_POST['delivery_time'] ?? '');
$payment_method = mysqli_real_escape_string($conn, $_POST['payment_method'] ?? '');

// Combine delivery date and time
$delivery_datetime = $delivery_date . ' ' . $delivery_time;

// Validate required fields
if (empty($cake_name) || empty($full_name) || empty($location) || empty($contact) || empty($delivery_date) || empty($payment_method)) {
    die('Please fill in all required fields.');
}

// Start transaction
mysqli_autocommit($conn, false);

try {
    // Generate unique order number
    $order_no = 'ORD' . date('YmdHis') . rand(100, 999);
    
    // Insert into orderdetails table
    $order_query = "INSERT INTO orderdetails (orderNo, pound, eggOption, cakeMessage, cakeName, price) VALUES (?, ?, ?, ?, ?, ?)";
    $order_stmt = mysqli_prepare($conn, $order_query);
    
    if (!$order_stmt) {
        throw new Exception("Failed to prepare order statement: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($order_stmt, 'sisssi', $order_no, $pound, $egg_option, $cake_message, $cake_name, $cake_price);
    
    if (!mysqli_stmt_execute($order_stmt)) {
        throw new Exception("Failed to insert order details: " . mysqli_error($conn));
    }
    
    // Insert into customerDetails table
    $customer_query = "INSERT INTO customerdetails (customer_no, full_name, location, contact, delivery_date, payment_method) VALUES (?, ?, ?, ?, ?, ?)";
    $customer_stmt = mysqli_prepare($conn, $customer_query);
    
    if (!$customer_stmt) {
        throw new Exception("Failed to prepare customer statement: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($customer_stmt, 'ssssss', $order_no, $full_name, $location, $contact, $delivery_datetime, $payment_method);
    
    if (!mysqli_stmt_execute($customer_stmt)) {
        throw new Exception("Failed to insert customer details: " . mysqli_error($conn));
    }
    
    // Insert into order_status table (simplified)
    $status_query = "INSERT INTO order_status (order_no, customer_name, cake_name, pound, egg_option, delivery_date, cake_message, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
    $status_stmt = mysqli_prepare($conn, $status_query);
    
    if (!$status_stmt) {
        throw new Exception("Failed to prepare status statement: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($status_stmt, 'sssssss', $order_no, $full_name, $cake_name, $pound, $egg_option, $delivery_datetime, $cake_message);
    
    if (!mysqli_stmt_execute($status_stmt)) {
        throw new Exception("Failed to insert order status: " . mysqli_error($conn));
    }
    
    // Commit transaction
    mysqli_commit($conn);
    
    // Close statements
    mysqli_stmt_close($order_stmt);
    mysqli_stmt_close($customer_stmt);
    mysqli_stmt_close($status_stmt);
    
    // Redirect to success page with order number - FIXED PATH
    header("Location: order-success.php?order=" . urlencode($order_no));
    exit();
    
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);
    
    // Log error (in production, use proper logging)
    error_log("Order processing error: " . $e->getMessage());
    
    // Redirect back with error
    header("Location: ../../../frontend/index.php?error=" . urlencode("Failed to process order. Please try again."));
    exit();
}

// Close database connection
mysqli_close($conn);
?>