<?php

$is_LoggedIn =  $_SESSION['is_loggedin'] ?? false;

if (!$is_LoggedIn) {
  header("Location: ../auth/login.php");
  exit();
}

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

<h2 class="text-2xl font-bold text-pink-700 mb-6 text-center">Menu Management Table</h2>

<?php if (!empty($datas)): ?>
  <div class="overflow-x-auto px-4 md:px-0">
    <table class="min-w-full bg-white rounded-lg overflow-hidden shadow">
      <thead class="bg-pink-100 text-pink-800">
        <tr>
          <th class="px-4 py-3 text-left text-sm font-semibold">ID</th>
          <th class="px-4 py-3 text-left text-sm font-semibold">Cake Image</th>
          <th class="px-4 py-3 text-left text-sm font-semibold">Cake Name</th>
          <th class="px-4 py-3 text-left text-sm font-semibold">Price (Rs)</th>
          <th class="px-4 py-3 text-left text-sm font-semibold">Description</th>
          <th class="px-4 py-3 text-sm font-semibold text-center">Actions</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 divide-y divide-pink-200">
        <?php foreach ($datas as $item): ?>
          <tr>
            <td class="px-4 py-3 text-sm"><?php echo $item['id']; ?></td>
            <td class="px-4 py-3">
              <img
                src="http://localhost:8080/Jheegu-Cake/admin/dashboard/<?php echo $item['image-url']; ?>"
                alt="<?php echo htmlspecialchars($item['item-name']); ?>"
                class="w-20 h-16 object-cover rounded border border-pink-200"
              />
            </td>
            <td class="px-4 py-3 text-sm capitalize"><?php echo htmlspecialchars($item['item-name']); ?></td>
            <td class="px-4 py-3 text-sm">Rs. <?php echo htmlspecialchars($item['price']); ?></td>
            <td class="px-4 py-3 text-sm max-w-xs truncate"><?php echo htmlspecialchars($item['description']); ?></td>
            <td class="px-4 py-3 flex flex-col sm:flex-row gap-2 justify-center items-center">
              <a href="../dashboard/edit-product.php?id=<?php echo urlencode($item['id']); ?>"
                 class="bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded text-sm text-center w-full sm:w-auto">
                Edit
              </a>
              <a href="../admin/auth/delete-product.php?id=<?php echo urlencode($item['id']); ?>"
                 onclick="return confirm('Are you sure you want to delete this item?');"
                 class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm text-center w-full sm:w-auto">
                Delete
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <p class="text-gray-500 text-sm mt-4 text-center">No menu items found.</p>
<?php endif; ?>

