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

    $product_image = $_FILES['image'] ?? null;
    $product_name = $_POST['name'] ?? '';
    $product_description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';

    if (empty($product_image['name']) || empty($product_name) || empty($product_description) || empty($price)) {
        $error = "Please fill in all required fields.";
    } else {
        // Save the uploaded image
        $uploadDir = '../dashboard/product-uploads';
        $image_name = time() . '_' . basename($product_image['name']);
        $image_path = $uploadDir . $image_name;

        if (move_uploaded_file($product_image['tmp_name'], $image_path)) {
        
            $updateQuery = "UPDATE menu SET `image-url` = ?, `item-name` = ?, `description` = ?, `price` = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);

            if ($updateStmt) {
                mysqli_stmt_bind_param($updateStmt, 'sssdi', $image_path, $product_name, $product_description, $price, $id);
                if (mysqli_stmt_execute($updateStmt)) {
                    header('Location: ../dashboard/dashboard.php');
                    exit;
                } else {
                    $error = "Failed to update product: " . mysqli_error($conn);
                }
            } else {
                $error = "Failed to prepare update statement: " . mysqli_error($conn);
            }
        } else {
            $error = "Failed to upload image.";
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

<body class="bg-pink-50 p-8">
    <section class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto mt-6">
        <?php if (isset($error)): ?>
            <p class="mb-4 text-red-600"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Product</h2>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <!-- Existing Image -->
            <div>
                <img src="../dashboard/<?php echo $product['image-url']; ?>" 
                     alt="<?php echo $product['item-name']; ?>"
                     class="my-4 h-40 object-contain rounded-xl border border-pink-200 bg-white" />
                <input type="file" id="image" name="image" accept="image/*" required
                    class="w-full text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200" />
            </div>

            <!-- Product Name -->
            <div>
                <label class="block mb-2 font-semibold" for="name">Cake Name</label>
                <input type="text" id="name" name="name" 
                       value="<?= htmlspecialchars($product['item-name']) ?>" 
                       class="w-full border px-3 py-2 rounded mb-4" />
            </div>

            <!-- Description -->
            <div>
                <label class="block mb-2 font-semibold" for="description">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <!-- Price -->
            <div>
                <label class="block text-gray-700 font-medium mb-1" for="price">Price</label>
                <input type="number" id="price" name="price" 
                       value="<?= htmlspecialchars($product['price']) ?>"
                       class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500" />
            </div>

            <!-- Buttons -->
            <div class="pt-2">
                <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">Update Product</button>
                <a href="../dashboard/dashboard.php" class="ml-4 text-pink-600 hover:underline">Cancel</a>
            </div>
        </form>
    </section>
</body>
</html>
