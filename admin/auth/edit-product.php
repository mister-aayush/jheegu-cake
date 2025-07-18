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

    $product_image = $_FILES["image"] ?? '';
    $product_name = $_POST['name'] ?? '';
    $product_description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';


    if (empty($product_image) || empty($price) || empty($product_name)||empty($product_description)) {
        $error = "Please fill in all required fields.";
    } else {
        $updateQuery = "UPDATE menu SET `image-url` = ?, description = ?,`item-name` = ?, price = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, 'sssd', $image_path, $product_name, $product_description, $price);
        if (mysqli_stmt_execute($updateStmt)) {
            header('Location: dashboard.php');
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
    <link rel="stylesheet" href="../src/output.css">
</head>

<body class="bg-pink-50 p-8">

    <section class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto mt-6">
        <?php if (isset($error)): ?>
            <p class="mb-4 text-red-600"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <h2 class="text-xl font-semibold mb-4 text-gray-800"> Edit Product</h2>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">


            <div>
                <img
                    src="http://localhost:8080/Jheegu-Cake/admin/dashboard/<?php echo $product['image-url']; ?>"
                    alt="<?php echo $item['item-name']; ?>"
                    class="my-10 h-40 object-contain rounded-xl border border-pink-200 bg-white" />
                <input type="file" id="image" name="image" accept="image/*" required
                    value=""
                    class=" w-full text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200" />
            </div>

            <div>
                <label class="block mb-2 font-semibold" for="item-name">Cake Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['item-name']) ?>" class="w-full border px-3 py-2 rounded mb-4"  />
            </div>


            <div>
                <label class="block mb-2 font-semibold" for="description">Description</label>
                <textarea id="description" name="description" type="text" rows="3" 
                    class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
            <?php echo ($product['description']); ?>
    </textarea>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1" for="price">Price </label>
                <input type="number" id="price" name="price" 
                
                    class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500" 
                    value="<?= htmlspecialchars($product['price']); ?>" />
            </div>




            <div class="pt-2">
                <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">Update Product</button>
                <a href="../dashboard/dashboard.php" class="ml-4 text-pink-600 hover:underline">Cancel</a>
            </div>

        </form>
    </section>
</body>

</html>