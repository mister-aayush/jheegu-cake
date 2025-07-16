<?php
include '../db-conn.php';
$query = "SELECT * FROM menu";
$stmt =  mysqli_prepare($conn, $query);

mysqli_execute($stmt);
$mysqli_result =  mysqli_stmt_get_result($stmt);

for ($i = 0; $i < mysqli_num_rows($mysqli_result); $i++) {
  $data =  mysqli_fetch_assoc($mysqli_result);
  $datas[] = $data;
}


?>
<!-- Featured Cakes -->
<section class="max-w-7xl mx-auto px-4 py-16">
  <h3 class="text-4xl font-extrabold text-pink-800 mb-12 text-center tracking-wide">
    Our Specialties
  </h3>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
    <?php if (count($datas) > 0): ?>
      <?php foreach ($datas as $item): ?>
        <!-- Cake Card -->
        <div class="bg-white rounded-2xl shadow-md p-4 hover:shadow-xl transition-shadow duration-300 text-center">
          <img
            src="http://localhost:8080/Jheegu-Cake/<?php echo $item['image-url']; ?>"
            alt="<?php echo $item['item-name']; ?>"
            class="rounded-xl w-full h-48 object-cover mb-4" />

          <h4 class="text-xl font-extrabold text-pink-800 capitalize mb-1">
            <?php echo $item['item-name']; ?>
          </h4>

          <div class="text-lg font-semibold text-pink-800 mb-3">
            Rs.<?php echo $item['price']; ?>
          </div>
      
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center col-span-3 text-gray-500 text-lg">No data found!!!</p>
    <?php endif; ?>
  </div>
</section>
