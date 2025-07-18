<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Jheegu Cake</title>
  <link rel="stylesheet" href="../frontend/src/output.css">
</head>

<body class="bg-pink-50 font-sans flex flex-col min-h-screen">


  <nav>
    <header class="bg-white shadow">
      <div
        class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-pink-700"><a href="index.html">Jheegu
            Cake</a></h1>

        <!-- Hamburger Button  -->
        <button id="menu-btn" aria-label="Toggle menu"
          class="md:hidden text-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 rounded">
          <svg class="w-6 h-6" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        <!-- Navigation Links -->
        <nav id="menu" class="hidden md:flex space-x-4">
          <a href="#"
            class="text-gray-700 hover:text-pink-700 focus:ring-2 focus:ring-pink-500 rounded">Home</a>
          <a href="#menu" 
            class="text-gray-700 hover:text-pink-700 focus:ring-2 focus:ring-pink-500 rounded">Menu</a>
          <a href="#"
            class="text-gray-700 hover:text-pink-700 focus:ring-2 focus:ring-pink-500 rounded">Order</a>
          <a href="#"
            class="text-gray-700 hover:text-pink-700 focus:ring-2 focus:ring-pink-500 rounded">Contact</a>
        </nav>
      </div>

      <!-- Mobile menu  -->
      <nav id="mobile-menu" class="md:hidden px-4 pb-4 hidden space-y-2">
        <a href="#"
          class="block text-gray-700 hover:text-pink-700 focus:ring-2 focus:ring-pink-500 rounded">Home</a>
        <a href="#menu"
          class="block text-gray-700 hover:text-pink-700 focus:ring-2 focus:ring-pink-500 rounded">Menu</a>
        <a href="# "
          class="block text-gray-700 hover:text-pink-700 focus:ring-2 focus:ring-pink-500 rounded">Order</a>
        <a href="#"
          class="block text-gray-700 hover:text-pink-700 focus:ring-2 focus:ring-pink-500 rounded">Contact</a>
      </nav>
    </header>
  </nav>

  <!-- menu section -->
  <?php
  include("db-conn.php");
  include("menu.php");
  ?>


  <!-- Footer -->
  <footer class="bg-pink-100 text-gray-800 mt-16">
  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-8 text-sm">
    
    <div>
      <h2 class="text-lg font-semibold mb-4 text-pink-900">Contact Us</h2>
      <p>Email: <a href="mailto:info@example.com" class="text-pink-700 hover:underline">jheegucake@.com</a></p>
      <p>Phone: +977 9808823698</p>
      <p>Address: Gurjudhara, Kathmandu</p>
    </div>

    <div>
      <h2 class="text-lg font-semibold mb-4 text-pink-900">Quick Links</h2>
      <ul class="space-y-1">
        <li><a href="#" class="hover:text-pink-700">Home</a></li>
        <li><a href="#" class="hover:text-pink-700">About</a></li>
        <li><a href="#" class="hover:text-pink-700">Services</a></li>
        <li><a href="#" class="hover:text-pink-700">Products</a></li>
        <li><a href="#" class="hover:text-pink-700">Contact</a></li>
      </ul>
    </div>

    <div>
      <h2 class="text-lg font-semibold mb-4 text-pink-900">Follow Us</h2>
      <div class="flex space-x-4 text-xl">
        <a href="#" class="text-pink-700 hover:text-pink-900"><i class="fab fa-facebook-f"></i>facebook</a>  
        <a href="#" class="text-pink-700 hover:text-pink-900"><i class="fab fa-instagram"></i>Instagram</a>

      </div>
    </div>
  </div>

  <!-- Bottom Bar -->
  <div class="bg-white text-center py-4 text-sm text-pink-700 font-semibold">
    © 2023 Jheegu Cake. All rights reserved.
  </div>
</footer>




  <script>

    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>

</body>


</html>