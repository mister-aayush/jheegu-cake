<section class="text-center py-16 bg-pink-100 px-4" id="menu">
  <h2 class="text-4xl font-extrabold text-pink-800 mb-4">Celebrate Every
    Occasion with a Cultural Twist</h2>
  <p class="text-lg text-gray-700 mb-6 max-w-3xl mx-auto">Delicious cakes made
    with love and tradition</p>

</section>
<?php
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
      <?php for ($j = 0; $j < count($datas); $j++):
        $item = $datas[$j];
      ?>
        <!-- Cake Card -->
        <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 p-6 flex flex-col justify-between">
          <img
            src="http://localhost:8080/Jheegu-Cake/<?php echo $item['image-url']; ?>"
            alt="Yomari Cake"
            class="rounded-xl mb-4 w-full h-52 object-cover" />

          <h4 class="text-2xl font-bold text-pink-700 mb-2">
            <?php echo $item['item-name']; ?>
          </h4>

          <div class="text-xl font-medium text-pink-800 mb-3">
            Rs.<?php echo $item['price'] ?>
          </div>

          <button
            class="text-sm text-pink-600 hover:underline mb-2 text-left"
            onclick="toggleDesc('<?php echo $item['id']; ?>')">
            See More
          </button>

          <p
            class="text-gray-700 text-sm mb-4 hidden transition-all duration-300 ease-in-out"
            id="desc-<?php echo $item['id']; ?>">
            <?php echo $item['description']; ?>
          </p>

          <a href="order.php?id=<?php echo $item['id']; ?>"
            class="mt-auto inline-block bg-pink-700 text-white text-center px-6 py-2 rounded-full hover:bg-pink-600 hover:scale-105 transition-transform duration-300">
            Order Now
          </a>
        </div>
      <?php endfor; ?>
    <?php else: ?>
      <p class="text-center col-span-3 text-gray-500 text-lg">No data found!!!</p>
    <?php endif; ?>
  </div>
</section>

<script>
  function toggleDesc(id) {
    const desc = document.getElementById('desc-' + id);
    const btn = document.getElementById('btn-' + id);

    if (desc.style.display === 'none') {
      desc.style.display = 'flex';
      btn.innerText = 'See Less';
    } else {
      desc.style.display = 'none';
      btn.innerText = 'See More';
    }
  }
</script>