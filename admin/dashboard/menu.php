<?php
include '../db-conn.php';
$query = "SELECT * FROM menu";
$stmt = mysqli_prepare($conn, $query);
mysqli_execute($stmt);
$mysqli_result = mysqli_stmt_get_result($stmt);

$datas = [];
while ($row = mysqli_fetch_assoc($mysqli_result)) {
  $datas[] = $row;
}
?>

<h2 class="text-2xl font-bold text-pink-700 mb-6 text-center">Now in display</h2>

<?php if (!empty($datas)): ?>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 px-4 md:px-0">
    <?php foreach ($datas as $item): ?>
      <div class="bg-white rounded-xl shadow-md p-4 flex flex-col">
        <img
          src="http://localhost:8080/Jheegu-Cake/admin/dashboard/<?php echo $item['image-url']; ?>"
          alt="<?php echo htmlspecialchars($item['item-name']); ?>"
          class="w-full h-48 md:h-56 object-cover rounded-lg border border-pink-200 mb-4"
          loading="lazy"
        />
        <h3 class="text-lg font-semibold text-pink-700 mb-1 capitalize break-words"><?php echo htmlspecialchars($item['item-name']); ?></h3>
        <p class="text-pink-700 font-semibold mb-4">Rs. <?php echo htmlspecialchars($item['price']); ?></p>
        
        <div class="mt-auto flex flex-col sm:flex-row justify-between gap-2">
          <a href="edit-product.php?id=<?php echo urlencode($item['id']); ?>"
             class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-black py-2 rounded text-sm cursor-pointer">
            Edit
          </a>
          <a href="delete-product.php?id=<?php echo urlencode($item['id']); ?>"
             onclick="return confirm('Are you sure you want to delete this item?');"
             class="flex-1 text-center bg-red-500 hover:bg-red-600 text-black py-2 rounded text-sm cursor-pointer">
            Delete
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <p class="text-gray-500 text-sm mt-4 text-center">No menu items found.</p>
<?php endif; ?>
