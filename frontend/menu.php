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
<section class="max-w-7xl mx-auto px-4 py-12 border-2">
  <h3 class="text-2xl font-bold text-pink-800 mb-6 text-center">Our
    Specialties</h3>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <?php
    if (count($datas) > 0):


      for ($j = 0; $j < count($datas); $j++):
        $item = $datas[$j];
    ?>
        <!-- Cake Card -->
        <div class="bg-white rounded-2xl shadow p-4 ">
          <img src="http://localhost:8080/Jheegu-Cake/<?php echo $item['image-url']; ?>" alt="Yomari Cake"
            class="rounded-xl mb-4 w-full h-auto object-cover" />
          <h4 class="text-xl font-semibold text-pink-700"><?php echo $item['item-name']; ?></h4>

          <button
            class="text-gray-600 text-sm mt-2"
            id="btn-<?php echo $item['id']; ?>"
            onclick="toggleDesc('<?php echo $item['id']; ?>')">
            See More
          </button>

          <p
            class="text-gray-800 text-sm mt-2"
            id="desc-<?php echo $item['id']; ?>"
            style="display: none;">
            <?php echo $item['description']; ?>
          </p>

          <br>
          <?php echo $item['price'] ?><br>
          <a href="#"
            class="bg-pink-700 text-white px-6 py-2 rounded-full hover:bg-pink-800 focus:outline-none focus:ring-2 focus:ring-pink-600">
            Order Now</a>
        </div>
      <?php endfor;
    else: ?>

      <p class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">

        okk
      </p>
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