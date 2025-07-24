<?php


$is_LoggedIn =  $_SESSION['is_loggedin'] ?? false;

if (!$is_LoggedIn) {
  header("Location: ../auth/login.php");
  exit();
}
?>

<section class="bg-white p-4 sm:p-6 lg:p-8 rounded-lg shadow-md max-w-2xl mx-auto mt-4 sm:mt-6">
  <h2 class="text-lg sm:text-xl lg:text-2xl font-semibold mb-4 text-gray-800"> Add New Product</h2>
  <form action="add-product-handle.php" method="POST"  enctype="multipart/form-data" class="space-y-4 sm:space-y-6">
    

  <div>
      <label class="block text-sm sm:text-base text-gray-700 font-medium mb-2" for="image">Product Image</label>
      <input type="file" id="image" name="image" accept="image/*" required
        class="w-full text-sm sm:text-base text-gray-700 file:mr-2 sm:file:mr-4 file:py-2 sm:file:py-3 file:px-3 sm:file:px-4 file:rounded-md file:border-0 file:text-sm file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-500" />
    </div>

    <div>
      <label class="block text-sm sm:text-base text-gray-700 font-medium mb-2" for="name">Cake Name</label>
      <input type="text" id="name" name="name" required
        class="w-full text-sm sm:text-base border border-gray-300 px-3 sm:px-4 py-2 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500" />
    </div>
    

    <div>
      <label class="block text-sm sm:text-base text-gray-700 font-medium mb-2" for="description">Description</label>
      <textarea id="description" name="description" rows="3" required
        class="w-full text-sm sm:text-base border border-gray-300 px-3 sm:px-4 py-2 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500 resize-none"></textarea>
    </div>

    <div>
      <label class="block text-sm sm:text-base text-gray-700 font-medium mb-2" for="price">Price </label>
      <input type="number" id="price" name="price" required
        class="w-full text-sm sm:text-base border border-gray-300 px-3 sm:px-4 py-2 sm:py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500" />
    </div>

   
    

    <div class="pt-4 sm:pt-6">
      <button type="submit"
        class="w-full sm:w-auto bg-pink-600 text-white text-sm sm:text-base px-6 sm:px-8 py-3 sm:py-2 rounded-md hover:bg-pink-700 transition-all font-medium">Upload Product</button>
    </div>
    
  </form>
</section>