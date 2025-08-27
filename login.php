<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">


<!-- component -->
<div class="flex h-screen flex gap-60">
  <!-- Left Pane -->
  <div class="hidden lg:flex items-center justify-center flex-1  text-black">
    <div class="max-w-md text-center">
      <img src="Logo.png" alt="Placeholder Image" class="object-cover w-full h-full">
      </div>
  </div>
  <!-- Right Pane -->
  <div class="w-full bg-gray-100 lg:w-1/2 flex items-center justify-center">
    <div class="max-w-md w-full p-6">
      <h1 class="text-3xl font-semibold mb-6 text-black text-center">LOGIN</h1>
      <?php if (isset($_SESSION['error'])): ?>
      <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
      </div>
    <?php endif; ?>


      <h1 class="text-sm font-semibold mb-6 text-gray-500 text-center"> </h1>
      <div class="mt-4 flex flex-col lg:flex-row items-center justify-between">
        
      </div>
      <form action="#" method="POST" class="space-y-4">
        <!-- Your form elements go here -->
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700">Usuario</label>
          <input type="text"  name="usuario" class="mt-1 p-2 w-full border rounded-md focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input type="password"  name="clave" class="mt-1 p-2 w-full border rounded-md focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300">
        </div>
        <div>
          <button type="submit" class="w-full bg-black text-white p-2 rounded-md hover:bg-gray-800 focus:outline-none focus:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors duration-300">Iniciar</button>
        </div>
      </form>
      
    </div>
  </div>
</div>
</body>
</html>

