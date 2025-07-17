<?php
include '../db-conn.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Invalid product ID.');
}

$id = intval($_GET['id']);

// Fetch existing data
$query = "SELECT * FROM menu WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    die('Product not found.');
}

$product = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['item-name'] ?? '';
    $price = $_POST['price'] ?? '';
    // Optional: handle image upload here

    // Simple validation (you can expand this)
    if (empty($name) || empty($price)) {
        $error = "Please fill in all required fields.";
    } else {
        $updateQuery = "UPDATE menu SET `item-name` = ?, price = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, 'sdi', $name, $price, $id);
        if (mysqli_stmt_execute($updateStmt)) {
            header('Location: dashboard.php'); // Redirect back to admin dashboard
            exit;
        } else {
            $error = "Failed to update product.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-pink-50 p-8">
    <h1 class="text-3xl font-bold mb-6">Edit Product</h1>

    <?php if (isset($error)): ?>
        <p class="mb-4 text-red-600"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" class="bg-white p-6 rounded shadow max-w-md">
        <label class="block mb-2 font-semibold" for="item-name">Item Name</label>
        <input type="text" id="item-name" name="item-name" value="<?= htmlspecialchars($product['item-name']) ?>" class="w-full border px-3 py-2 rounded mb-4" required />

        <label class="block mb-2 font-semibold" for="price">Price (Rs)</label>
        <input type="number" step="0.01" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" class="w-full border px-3 py-2 rounded mb-4" required />

        <!-- For image update, you can add file input here -->

        <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">Update Product</button>
        <a href="dashboard.php" class="ml-4 text-pink-600 hover:underline">Cancel</a>
    </form>
</body>
</html>
