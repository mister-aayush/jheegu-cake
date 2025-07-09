<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login - Jheegu Cake</title>
  <link rel="stylesheet" href="../src/output.css">
</head>

<body class="bg-pink-50 min-h-screen flex items-center justify-center px-4">

  <div class="bg-white w-full max-w-md p-8 rounded-lg shadow-md">
    <div class="text-center mb-6">
      <h1 class="text-2xl font-bold text-pink-600 flex items-center justify-center">
        <span class="ml-2">Jheegu Cake Admin Login</span>
      </h1>
    </div>

    <form action="login-handle.php" method="POST" class="space-y-5">
      <?php
      $error =  $_GET['error'] ?? null;
      if (isset($error)) { ?>

        <div class="my-4">
          <span class="bg-red-300 border-2 border-red-500 px-2 py-1 my-3 rounded-2xl">
            <?php echo $error; ?> </span>
        </div>

      <?php  }
      ?>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
        <input type="email" id="email" name="email" required
          class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500" />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" required
          class="w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500" />
      </div>

      <div>
        <button type="submit"
          class="w-full bg-pink-600 text-white py-2 px-4 rounded-md hover:bg-pink-700 transition duration-200">
          Login
        </button>
      </div>
    </form>
  </div>

</body>

</html>