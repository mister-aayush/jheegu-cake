<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Admin</title>
     <link rel="stylesheet" href="./src/output.css">
</head>
<body class="bg-purple-300 font-sans">

  <nav>
    <header class="bg-white shadow">
      <div
        class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-pink-700"><a href="index.php">Jheegu
            Cake</a></h1>

        <!-- Hamburger Button (visible on small screens) -->
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
          
          <a href="#"
            class="text-gray-700 hover:text-pink-700 focus:ring-2 focus:ring-pink-500 rounded">Orders</a>
          
        </nav>
      </div>

      <!-- Mobile menu  -->
      <nav id="mobile-menu" class="md:hidden px-4 pb-4 hidden space-y-2">
        <a href="#"
          class="block text-gray-700 hover:text-pink-700 focus:ring-2 focus:ring-pink-500 rounded">Home</a>
        
        <a href="# "
          class="block text-gray-700 hover:text-pink-700 focus:ring-2 focus:ring-pink-500 rounded">Orders</a>
       
      </nav>
    </header>
  </nav>
        
</body>
</html>
<script>

    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>
