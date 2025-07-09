<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin login </title>
  <link rel="stylesheet" href="../src/output.css">
</head>

<body class="bg-purple-200 font-sans">
  <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">

    <div class="  bg-white border-2 p-20 mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <div class="border-2 sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="  text-center text-2xl/9 font-bold tracking-tight text-gray-900">Admin Login</h2>
      </div>

      <!-- form -->
      <form class="space-y-6" action="login-handle.php" method="POST">
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
          <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
          <div class="mt-2">
            <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
          </div>
        </div>
        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>

          </div>
          <div class="mt-2">
            <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
          </div>
        </div>

        <div>
          <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>