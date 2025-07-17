<?php

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../auth/login.php');
    exit();
}
?>

<section class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto mt-6">
  <h2 class="text-xl font-semibold mb-4 text-gray-800"> Add New Product</h2>
  <form action="add-product-handle.php" method="POST"  enctype="multipart/form-data" class="space-y-4">
    

  <div>
      <label class="block text-gray-700 font-medium mb-1" for="image">Product Image</label>
      <input type="file" id="image" name="image" accept="image/*" required
        class="w-full text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200" />
    </div>

    <div>
      <label class="block text-gray-700 font-medium mb-1" for="name">Cake Name</label>
      <input type="text" id="name" name="name" required
        class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500" />
    </div>
    

    <div>
      <label class="block text-gray-700 font-medium mb-1" for="description">Description</label>
      <textarea id="description" name="description" rows="3" required
        class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"></textarea>
    </div>

    <div>
      <label class="block text-gray-700 font-medium mb-1" for="price">Price </label>
      <input type="number" id="price" name="price" required
        class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500" />
    </div>

   
    

    <div class="pt-2">
      <button type="submit"
        class="bg-pink-600 text-white px-6 py-2 rounded-md hover:bg-pink-700 transition-all">Upload Product</button>
    </div>
    
  </form>
</section>