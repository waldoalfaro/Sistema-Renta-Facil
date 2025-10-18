<?php
session_start();
require '../conexion.php';

if(!isset($_GET['token'])){
    die("Token inválido.");
}

$token = $_GET['token'];
$stmt = $conn->prepare("SELECT id_usuario, expira_token FROM usuarios WHERE token_recuperacion = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$resultado = $stmt->get_result();

if($resultado->num_rows !== 1){
    die("Token inválido o ya usado.");
}

$fila = $resultado->fetch_assoc();
$expira = strtotime($fila['expira_token']);
if(time() > $expira){
    die("El token ha expirado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Restablecer Contraseña</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-company min-h-screen flex items-center justify-center p-4">
<div class="glass-effect rounded-3xl shadow-2xl p-8 w-full max-w-md">
  <h1 class="text-2xl font-bold mb-4 text-center">Restablecer Contraseña</h1>

  <form action="guardar_contra.php" method="POST" class="space-y-4">
    <input type="hidden" name="id_usuario" value="<?= $fila['id_usuario'] ?>">
    <input type="hidden" name="token" value="<?= $token ?>">

    <label class="block text-sm font-semibold text-gray-700">Nueva contraseña:</label>
    <input type="password" name="clave" id="clave" placeholder="Nueva contraseña" required
      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500">
    
    <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-xl hover:bg-green-600">
      Restablecer Contraseña
    </button>
  </form>
</div>
</body>
</html>
