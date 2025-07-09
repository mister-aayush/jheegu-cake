<?php

session_start();
$is_LoggedIn =  $_SESSION['is_loggedin'] ?? false;

if (!$is_LoggedIn) {
  header("Location: login.php");
  exit();
}

$path = $_GET['path'] ?? null;

?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Jheegu Cake - Admin Dashboard</title>
  <link rel="stylesheet" href="../src/output.css">
</head>

<body class="bg-gray-100 min-h-screen flex">
  `
  <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Jheegu Cake</title>
  <link rel="stylesheet" href="../src/output.css">
</head>
<body class="flex bg-gray-100 min-h-screen">

  <aside class="w-64 bg-white shadow-lg hidden md:flex flex-col">
    <div class="p-6 text-center border-b border-gray-200">
      <a href="dashboard.php">
      <h1 class="text-2xl font-bold text-pink-600"> Jheegu Cake</h1>
      </a>
    </div>
    <nav class="mt-6 space-y-1">
      <a href="?path=menu" class="flex items-center px-6 py-3 text-gray-700 hover:bg-pink-100 hover:text-pink-600">
     
        <svg class="w-5 h-5 mr-3 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v10.5a.75.75 0 01-.75.75H3.75A.75.75 0 013 20.25V9.75z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 22.5v-6h6v6" />
        </svg>
        Home
      </a>

      <a href="?path=add-quote" class="flex items-center px-6 py-3 text-gray-700 hover:bg-pink-100 hover:text-pink-600">
        
        <svg class="w-5 h-5 mr-3 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 5 9-5M3 17l9 5 9-5M3 7v10m18-10v10" />
        </svg>
        Orders
      </a>

      <a href="?path=add-product" class="flex items-center px-6 py-3 text-gray-700 hover:bg-pink-100 hover:text-pink-600">
        
        <svg class="w-5 h-5 mr-3 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Add Product
      </a>

      <a href="../adminLogin/logout-handle.php" class="flex items-center px-6 py-3 text-gray-700 hover:bg-pink-100 hover:text-pink-600">
  
        <svg class="w-5 h-5 mr-3 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 21V3a1 1 0 011-1h6" />
        </svg>
        Logout
      </a>
      
    </nav>
  </aside>

  <!-- Mobile Sidebar  -->
  <div class="md:hidden fixed top-0 left-0 w-full bg-white p-4 shadow flex justify-between items-center z-50">
    <h1 class="text-xl font-bold text-pink-600">Jheegu Cake</h1>
    <button onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">☰</button>
  </div>

  <!-- Mobile Menu -->
  <div id="mobileMenu" class="hidden md:hidden fixed top-16 left-0 w-64 bg-white shadow z-40">
    <nav class="space-y-1">
      <a href="?path=menu" class="flex items-center px-6 py-3 text-gray-700 hover:bg-pink-100 hover:text-pink-600">
        
        <svg class="w-5 h-5 mr-3 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75v10.5a.75.75 0 01-.75.75H3.75A.75.75 0 013 20.25V9.75z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 22.5v-6h6v6" />
        </svg>
        Home
      </a>

      <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-pink-100 hover:text-pink-600">
        
        <svg class="w-5 h-5 mr-3 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 5 9-5M3 17l9 5 9-5M3 7v10m18-10v10" />
        </svg>
        Orders
      </a>

      <a href="?path=add-product" class="flex items-center px-6 py-3 text-gray-700 hover:bg-pink-100 hover:text-pink-600">
        
        <svg class="w-5 h-5 mr-3 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        Add Product
      </a>

      <a href="../adminLogin/logout-handle.php" class="flex items-center px-6 py-3 text-gray-700 hover:bg-pink-100 hover:text-pink-600">
  
        <svg class="w-5 h-5 mr-3 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 21V3a1 1 0 011-1h6" />
        </svg>
        Logout
      </a>
     
    </nav>
  </div>
  



  <!-- Main Content -->
  <main class="flex-1 p-6 mt-16 md:mt-0" id="home">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Welcome, Admin 👋</h2>
    <div class="bg-white p-6 rounded-lg shadow-md">
      <?php
      if ($path === "add-product") {
        include("add-product.php");
      } else {
        include("menu.php");
      }
      ?>
    </div>
  </main>

</body>

</html>


