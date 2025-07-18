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
<section class="max-w-7xl mx-auto px-4 py-16 pb-24 flex-grow">

  <h3 class="text-4xl font-extrabold text-pink-800 mb-12 text-center tracking-wide">
    Our Specialties
  </h3>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 items-start">

    <?php if (count($datas) > 0): ?>
      <?php for ($j = 0; $j < count($datas); $j++):
        $item = $datas[$j];
      ?>
        <!-- Cake Card -->

        <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 p-6 flex flex-col justify-between">
          <img
            src="http://localhost:8080/Jheegu-Cake/admin/dashboard/<?php echo $item['image-url']; ?>"
            alt="<?php echo $item['item-name']; ?>"
            class="w-full h-40 object-contain rounded-xl border border-pink-200 bg-white" />

          <h4 class="text-2xl font-bold text-pink-700 mb-2">
            <?php echo $item['item-name']; ?>
          </h4>

          <div class="text-xl font-medium text-pink-800 mb-3">
            Rs.<?php echo $item['price'] ?>
          </div>


          <p
            class="text-gray-700 text-sm mb-4 hidden transition-all duration-300 ease-in-out"
            id="desc-<?php echo $item['id']; ?>">
            <?php echo $item['description']; ?>
          </p>

          <button
            onclick="openOrderPopup(
              '<?php echo $item['id']; ?>',
              '<?php echo $item['item-name']; ?>',
              '<?php echo $item['price']; ?>',
              '<?php echo $item['description']; ?>',
              'http://localhost:8080/Jheegu-Cake/admin/dashboard/<?php echo $item['image-url']; ?>'
            )"
            class="mt-auto inline-block bg-pink-700 text-white text-center px-6 py-2 rounded-full hover:bg-pink-600 hover:scale-105 transition-transform duration-300">
            Order Now
          </button>
        </div>
      <?php endfor; ?>
    <?php else: ?>
      <p class="text-center col-span-3 text-gray-500 text-lg">No data found!!!</p>
    <?php endif; ?>
  </div>


  <!-- popup-->
  <div id="cakeOrder" class="fixed inset-0 bg-white/30  items-center justify-center z-50 hidden">


    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 relative">

      <!-- Close popup -->
      <button onclick="closeOrderpopup()" class="absolute top-3 right-4 text-2xl text-gray-600">&times;</button>

      <form action="../admin/dashboard/orders.php" method="POST">
        <img id="cakeImage" src="" alt="Cake" class="w-full h-40 object-contain rounded-xl border border-pink-200 bg-white">
        <h3 id="cakeTitle" class="text-2xl font-bold text-pink-800 mb-2"></h3>
        <div class="text-lg font-semibold text-gray-700 mb-2">
          Rs. <span id="cakePrice"></span>
        </div>
        <p id="cakeDescription" class="text-gray-600 text-sm mb-4"></p>

        <label for="pound" class="block text-sm font-medium text-gray-700 mb-1">Select Pound:</label>
        <select name="pound" id="pound" class="w-full border rounded px-3 py-2 mb-4">
          <option value="1">1 Pound</option>
          <option value="2">2 Pound</option>
          <option value="3">3 Pound</option>
          <option value="4">4 Pound</option>
          <option value="5">5 Pound</option>
        </select>

        <label class="block text-sm font-medium text-gray-700 mb-1">Egg Option:</label>
        <div class="flex gap-4 mb-4">
          <label><input type="radio" name="egg_option" value="Egg" required> Egg</label>
          <label><input type="radio" name="egg_option" value="Eggless"> Eggless</label>
        </div>

        <!-- Hidden Inputs -->
        <input type="hidden" name="cake_id" id="CakeId">
        <input type="hidden" name="cake_name" id="CakeName">
        <input type="hidden" name="cake_price" id="CakePrice">

        <!-- Confirm Button -->
        <button type="submit" class="w-full bg-pink-700 text-white py-2 rounded-full hover:bg-pink-600">
          Confirm Order
        </button>
      </form>
    </div>
  </div>
</section>

<script>
  // function toggleDesc(id) {
  //   const desc = document.getElementById('desc-' + id);
  //   const btn = document.getElementById('btn-' + id);

  //   if (desc.style.display === 'none') {
  //     desc.style.display = 'flex';
  //     btn.innerText = 'See Less';
  //   } else {
  //     desc.style.display = 'none';
  //     btn.innerText = 'See More';
  //   }
  // }

  function openOrderPopup(id, name, price, description, imageUrl) {
    document.getElementById('cakeOrder').classList.remove('hidden');
    document.getElementById('cakeOrder').classList.add('flex');

    document.getElementById('CakeId').value = id;
    document.getElementById('CakeName').value = name;
    document.getElementById('CakePrice').value = price;

    document.getElementById('cakeImage').src = imageUrl;
    document.getElementById('cakeTitle').textContent = name;
    document.getElementById('cakePrice').textContent = price;
    document.getElementById('cakeDescription').textContent = description;
  }

  function closeOrderpopup() {
    document.getElementById('cakeOrder').classList.add('hidden');
  }
</script>