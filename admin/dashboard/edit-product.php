<?php
session_start();
include '../db-conn.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Invalid product ID.');
}

$id = intval($_GET['id']);

// Fetch product
$query = "SELECT * FROM menu WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    die('Product not found.');
}

$product = mysqli_fetch_assoc($result);

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_image = $_FILES['image'] ?? null;
    $product_name = $_POST['name'] ?? '';
    $product_description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';

    if (empty($product_name) || empty($product_description) || empty($price)) {
        $error = "Please fill in all required fields.";
    } else {
        $image_path = $product['image-url']; // default to existing

        // If new image uploaded
        if (!empty($product_image['name']) && $product_image['error'] == 0) {
            $uploadDir = 'product-uploads/';
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $image_name = time() . '_' . basename($product_image['name']);
            $target_path = $uploadDir . $image_name;

            if (move_uploaded_file($product_image['tmp_name'], $target_path)) {
                $image_path = $target_path;
                
                // Delete old image if it exists
                if (!empty($product['image-url']) && file_exists($product['image-url'])) {
                    unlink($product['image-url']);
                }
            } else {
                $error = "Failed to upload image.";
            }
        }

        // Update query
        if (!isset($error)) {
            $updateQuery = "UPDATE menu SET `image-url` = ?, `item-name` = ?, `description` = ?, `price` = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);
            
            if ($updateStmt) {
                mysqli_stmt_bind_param($updateStmt, 'sssii', $image_path, $product_name, $product_description, $price, $id);
                
                if (mysqli_stmt_execute($updateStmt)) {
                    header('Location: dashboard.php?path=menu');
                    exit;
                } else {
                    $error = "Failed to update product: " . mysqli_error($conn);
                }
                
                mysqli_stmt_close($updateStmt);
            } else {
                $error = "Error preparing statement: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Product</title>
    <link rel="stylesheet" href="../src/output.css">
</head>

<body class="bg-pink-50 p-4 sm:p-8">
<section class="bg-white p-4 sm:p-6 lg:p-8 rounded-lg shadow-md max-w-2xl mx-auto mt-4 sm:mt-6">
    <?php if (isset($error)): ?>
        <div class="mb-4 p-3 sm:p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
            <p class="text-sm sm:text-base"><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <h2 class="text-lg sm:text-xl lg:text-2xl font-semibold mb-4 sm:mb-6 text-gray-800">Edit Product</h2>

    <form method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-6">
        <!-- Current Image -->
        <div>
            <label class="block text-sm sm:text-base text-gray-700 font-medium mb-2">Current Image</label>
            <?php if (!empty($product['image-url']) && file_exists($product['image-url'])): ?>
                <div class="flex justify-center mb-4">
                    <img src="<?php echo htmlspecialchars($product['image-url']); ?>"
                         alt="<?php echo htmlspecialchars($product['item-name']); ?>"
                         class="h-32 sm:h-40 lg:h-48 w-auto object-contain rounded-xl border border-pink-200 bg-white shadow-sm" />
                </div>
            <?php else: ?>
                <div class="flex justify-center mb-4">
                    <div class="h-32 sm:h-40 lg:h-48 w-48 bg-gray-200 rounded-xl border border-pink-200 flex items-center justify-center">
                        <span class="text-gray-500 text-sm">No image available</span>
                    </div>
                </div>
            <?php endif; ?>
            
            <label class="block text-sm sm:text-base text-gray-700 font-medium mb-2" for="image">Upload New Image (optional)</label>
            <input type="file" id="image" name="image" accept="image/*"
                class="w-full text-sm sm:text-base file:mr-2 sm:file:mr-4 file:py-2 sm:file:py-3 file:px-3 sm:file:px-4 file:rounded-md file:border-0 file:text-sm file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-500" />
        </div>

        <!-- Cake Name -->
        <div>
            <label class="block text-sm sm:text-base text-gray-700 font-medium mb-2" for="name">Cake Name</label>
            <input type="text" id="name" name="name"
                   value="<?= htmlspecialchars($product['item-name']) ?>"
                   class="w-full text-sm sm:text-base border border-gray-300 px-3 sm:px-4 py-2 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500" required />
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm sm:text-base text-gray-700 font-medium mb-2" for="description">Description</label>
            <textarea id="description" name="description" rows="3"
                      class="w-full text-sm sm:text-base border border-gray-300 px-3 sm:px-4 py-2 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500 resize-none" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <!-- Price -->
        <div>
            <label class="block text-sm sm:text-base text-gray-700 font-medium mb-2" for="price">Price</label>
            <input type="number" id="price" name="price"
                   value="<?= htmlspecialchars($product['price']) ?>"
                   class="w-full text-sm sm:text-base border border-gray-300 px-3 sm:px-4 py-2 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500" required />
        </div>

        <!-- Actions -->
        <div class="pt-4 sm:pt-6 flex flex-col sm:flex-row gap-3 sm:gap-4">
            <button type="submit" class="w-full sm:w-auto bg-pink-600 text-white text-sm sm:text-base px-6 sm:px-8 py-3 sm:py-2 rounded-md hover:bg-pink-700 transition-all font-medium">Update Product</button>
            <a href="dashboard.php?path=menu" class="w-full sm:w-auto text-center sm:text-left text-pink-600 hover:text-pink-700 hover:underline py-2 px-4 border border-pink-600 hover:border-pink-700 rounded-md transition-all">Cancel</a>
        </div>
    </form>
</section>
</body>
</html>