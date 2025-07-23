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

$datas = [];
while ($row = mysqli_fetch_assoc($mysqli_result)) {
  $datas[] = $row;
}
?>

<!-- Featured Cakes -->
<section class="max-w-7xl mx-auto px-4 py-16 pb-24 flex-grow">
  <h3 class="text-4xl font-extrabold text-pink-800 mb-12 text-center tracking-wide">
    Our Specialties
  </h3>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 items-start">
    <?php if (count($datas) > 0): ?>
      <?php foreach ($datas as $item): ?>
        <div class="bg-white rounded-2xl shadow-xl hover:0shadow-2xl transition-shadow duration-300 p-6 flex flex-col justify-between">
          <img
            src="http://localhost:8080/Jheegu-Cake/admin/dashboard/<?php echo $item['image-url']; ?>"
            alt="<?php echo $item['item-name']; ?>"
            class="w-full h-40 object-contain rounded-xl border border-pink-200 bg-white" />

          <h4 class="text-2xl font-bold text-pink-700 mb-2"><?php echo $item['item-name']; ?></h4>

          <div class="text-xl font-medium text-pink-800 mb-3">
            Rs.<?php echo $item['price'] ?>
          </div>

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
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center col-span-3 text-gray-500 text-lg">No data found!!!</p>
    <?php endif; ?>
  </div>

  <!-- Order Popup -->
  
  <div id="cakeOrder" class="fixed inset-0 bg-white/30 items-center justify-center z-50 hidden px-2">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 relative max-h-[95vh] overflow-y-auto">
      <!-- Close popup -->
      <button onclick="closeOrderpopup()" class="absolute top-3 right-4 text-2xl text-gray-600">&times;</button>

      <div id="orderSuccessMsg" class=" hidden mb-4 p-3 bg-green-100 text-green-800 rounded text-center font-semibold">
        🎉 Your order was placed successfully!
      </div>

      
      <form id="cakeOrderForm" action="../admin/dashboard/orders.php" method="POST">
        <!-- PAGE 1 -->
        <div id="formPage1">
          <img id="cakeImage" src="" alt="Cake" class="w-full h-40 object-contain rounded-xl border border-pink-200 bg-white">
          <h3 id="cakeTitle" class="text-2xl font-bold text-pink-800 mb-2"></h3>

          <div class="text-lg font-semibold text-gray-700 mb-2">
            Rs. <span id="cakePriceDisplay"></span>
          </div>

          <p id="cakeDescription" class="text-gray-600 text-sm mb-4"></p>

          <label class="block text-sm font-medium text-gray-700 mb-1">Select Pound:</label>
          <select name="pound" id="pound" class="w-full border rounded px-3 py-2 mb-4" required>
            <option value="1">1 Pound</option>
            <option value="2">2 Pound</option>
            <option value="3">3 Pound</option>
            <option value="4">4 Pound</option>
            <option value="5">5 Pound</option>
          </select>

          <label class="block text-sm font-medium text-gray-700 mb-1">Egg Option:</label>
          <div class="flex flex-wrap gap-4 mb-4">
            <label><input type="radio" name="egg_option" value="Egg" required> Egg</label>
            <label><input type="radio" name="egg_option" value="Eggless"> Eggless</label>
          </div>

          <label for="cake_message" class="block text-sm font-medium text-gray-700 mb-1">Message on Cake:</label>
          <textarea name="cake_message" id="cake_message" placeholder="Happy Birthday Aayush!" rows="2" class="w-full border rounded px-3 py-2 mb-4"></textarea>

          <!-- Hidden Inputs -->
          <input type="hidden" name="cake_id" id="CakeId">
          <input type="hidden" name="cake_name" id="CakeName">
          <input type="hidden" name="cake_base_price" id="CakeBasePrice">
          <input type="hidden" name="cake_price" id="CakePrice">

          <button type="button" onclick="goToPage2()" class="w-full bg-pink-700 text-white py-2 rounded-full hover:bg-pink-600">
            Next
          </button>
        </div>

        <!-- PAGE 2 -->
        <div id="formPage2" class="hidden">
          <h3 class="text-xl font-bold text-pink-800 mb-4">Customer Details</h3>

          <label class="block text-sm font-medium text-gray-700 mb-1">Full Name:</label>
          <input type="text" name="full_name" required class="w-full border rounded px-3 py-2 mb-4">

          <label class="block text-sm font-medium text-gray-700 mb-1">Location:</label>
          <input type="text" name="location" required class="w-full border rounded px-3 py-2 mb-4">

          <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number:</label>
          <input type="text" name="contact" required class="w-full border rounded px-3 py-2 mb-4">

          <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method:</label>
          <select name="payment_method" required class="w-full border rounded px-3 py-2 mb-6">
            <option value="COD">Cash on Delivery</option>
            <option value="Esewa">Esewa</option>
            <option value="Khalti">Khalti</option>
          </select>

          <div class="flex justify-between gap-4">
            <button type="button" onclick="goToPage1()" class="w-full bg-gray-300 text-black py-2 rounded-full hover:bg-gray-400">Back</button>
            <button type="submit" onclick="alert('Order place Sucessful!');" class="w-full bg-pink-700 text-white py-2 rounded-full hover:bg-pink-600">Confirm Order</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<script>
  let basePrice = 0;

  function openOrderPopup(id, name, price, description, imageUrl) {
    document.getElementById('cakeOrder').classList.remove('hidden');
    document.getElementById('cakeOrder').classList.add('flex');

    document.getElementById('CakeId').value = id;
    document.getElementById('CakeName').value = name;
    document.getElementById('CakeBasePrice').value = price;
    document.getElementById('CakePrice').value = price;

    basePrice = parseInt(price);
    updatePrice();

    document.getElementById('cakeImage').src = imageUrl;
    document.getElementById('cakeTitle').textContent = name;
    document.getElementById('cakePriceDisplay').textContent = price;
    document.getElementById('cakeDescription').textContent = description;

    goToPage1();
    document.getElementById('pound').addEventListener('change', updatePrice);
  }

  function closeOrderpopup() {
    document.getElementById('cakeOrder').classList.add('hidden');
  }

  function updatePrice() {
    const pound = parseInt(document.getElementById('pound').value);
    const totalPrice = basePrice * pound;
    document.getElementById('cakePriceDisplay').textContent = totalPrice;
    document.getElementById('CakePrice').value = totalPrice;
  }

  function goToPage2() {
    document.getElementById('formPage1').classList.add('hidden');
    document.getElementById('formPage2').classList.remove('hidden');
  }

  function goToPage1() {
    document.getElementById('formPage2').classList.add('hidden');
    document.getElementById('formPage1').classList.remove('hidden');
  }

  function orderSuccessMsg(){

  }
</script>
