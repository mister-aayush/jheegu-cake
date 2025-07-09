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
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Jheegu Cake - Admin Dashboard</title>
  <link rel="stylesheet" href="../src/output.css">
</head>

<body class="bg-gray-100 min-h-screen flex">

  <!-- Sidebar -->
  <side class="w-64 bg-white shadow-md hidden md:block ">
    <div class="p-6 text-center border-b border-gray-200">
      <h1 class="text-2xl font-bold text-pink-600">Jheegu Cake</h1>
    </div>
    <nav class="mt-6">
      <a href="?path=menu" class="block py-2.5 px-6 text-gray-700 hover:bg-pink-100 hover:text-pink-600">🏠 Home</a>
      <a href="#" class="block py-2.5 px-6 text-gray-700 hover:bg-pink-100 hover:text-pink-600">📦 Orders</a>
      <a href="?path=add-product" class="block py-2.5 px-6 text-gray-700 hover:bg-pink-100 hover:text-pink-600">📦 Add Product</a>
      <a href="../adminLogin/logout-handle.php" class="block py-2.5 px-6 text-gray-700 hover:bg-pink-100 hover:text-pink-600">🚪 Logout</a>
    </nav>
  </side>

  <!-- Mobile Sidebar  -->
  <div class="md:hidden fixed top-0 left-0 z-50 w-full bg-white shadow-md flex justify-between items-center px-4 py-3">
    <h1 class="text-xl font-bold text-pink-600">Jheegu Cake</h1>
    <button onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
      ☰
    </button>
  </div>
  <div id="mobileMenu" class="hidden md:hidden absolute top-14 left-0 w-64 bg-white shadow-md z-40">
    <a href="#home" class="block py-2.5 px-6 text-gray-700 hover:bg-pink-100 hover:text-pink-600">🏠 Home</a>
    <a href="#" class="block py-2.5 px-6 text-gray-700 hover:bg-pink-100 hover:text-pink-600">📦 Orders</a>
    <a href="#" class="block py-2.5 px-6 text-gray-700 hover:bg-pink-100 hover:text-pink-600">📦 Add Product</a>
    <a href="../adminLogin/logout-handle.php" class="block py-2.5 px-6 text-gray-700 hover:bg-pink-100 hover:text-pink-600">🚪 Logout</a>
  </div>

  <!-- Main Content -->
  <main class="flex-1 p-6 mt-16 md:mt-0" id="home">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Welcome, Admin 👋</h2>
    <div class="bg-white p-6 rounded-lg shadow-md">
    <?php
                    if($path=== "add-product"){
                        include("add-product.php");
                    }
                    else{
                        include("menu.php");
                    }
                     ?>
    </div>
  </main>

</body>

</html>