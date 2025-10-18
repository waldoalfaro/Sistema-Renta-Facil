<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recuperar Contraseña</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-company min-h-screen flex items-center justify-center p-4">
  <div class="glass-effect rounded-3xl shadow-2xl p-8 w-full max-w-md">
    <h1 class="text-2xl font-bold mb-4 text-center">Recuperar Contraseña</h1>

    <?php if(isset($_SESSION['recuperar_error'])): ?>
      <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded">
        <?= $_SESSION['recuperar_error']; unset($_SESSION['recuperar_error']); ?>
      </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['recuperar_exito'])): ?>
      <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4 rounded">
        <?= $_SESSION['recuperar_exito']; unset($_SESSION['recuperar_exito']); ?>
      </div>
    <?php endif; ?>

    <form action="enviar_recuperacion.php" method="POST" class="space-y-4">
      <label class="block text-sm font-semibold text-gray-700">Correo registrado:</label>
      <input type="email" name="email" placeholder="Ingresa tu correo" required
        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500">

      <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-xl hover:bg-green-600">
        Enviar enlace de recuperación
      </button>
    </form>
  </div>
</body>
</html>
