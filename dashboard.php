<?php
include 'seguridad.php';
include 'menu.php';
include 'conexion.php';

// Definir variable de usuario

// Contadores de registros
$totalVehiculos = $conn->query("SELECT COUNT(*) AS total FROM vehiculos")->fetch_assoc()['total'] ?? 0;
$totalReservas = $conn->query("SELECT COUNT(*) AS total FROM reservaciones")->fetch_assoc()['total'] ?? 0;

// Sumamos los distintos mantenimientos (si existen las tablas)
$totalMantenimientos = 0;
$tablasMantenimiento = ['mantenimientos', 'cambio_bateria', 'cambio_llantas'];

foreach ($tablasMantenimiento as $tabla) {
    $resultado = $conn->query("SHOW TABLES LIKE '$tabla'");
    if ($resultado && $resultado->num_rows > 0) {
        $fila = $conn->query("SELECT COUNT(*) AS total FROM $tabla")->fetch_assoc();
        $totalMantenimientos += intval($fila['total']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">


   

    <script>
        window.onload = function() {
            if (window.history && window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        };
    </script>






</head>
<body>


    <!-- 🔝 Barra superior -->



<!-- Espacio para que no tape el contenido -->
<div class="h-16 sm:h-20"></div>

    
    <div class="pt-20 p-4 sm:ml-64 bg-gray-50 min-h-screen">
  <div class="max-w-7xl mx-auto">
    <!-- Título -->
    <div class="text-center mb-10">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">Sonsonate Renta Fácil</h1>
      <p class="text-gray-500 text-lg">Sistema de Gestión de Renta de Vehículos</p>
    </div>

    <!-- Grid de Tarjetas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      
      <!-- Vehículos -->
      <div onclick="window.location.href='Vehiculos/vehiculos.php'" 
           class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow cursor-pointer p-6 text-center">
        <img src="Logo.png" alt="Vehículos" class="mx-auto mb-4 w-16 h-16 object-contain">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Lista de Carros</h3>
        <p class="text-gray-500 text-sm mb-4">Gestiona el inventario completo de vehículos</p>
        <div class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm inline-flex items-center justify-center gap-1">
          <span>Total:</span> <strong><?php echo $totalVehiculos; ?></strong>
        </div>
      </div>

      <!-- Reservaciones -->
      <div onclick="window.location.href='Reservas/Reservas.php'"
           class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow cursor-pointer p-6 text-center">
        <div class="text-yellow-600 text-4xl mb-3">
          <i class="fa-solid fa-calendar-check"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Reservaciones</h3>
        <p class="text-gray-500 text-sm mb-4">Consulta y gestiona todas las reservaciones</p>
        <div class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm inline-flex items-center justify-center gap-1">
          <span>Total:</span> <strong><?php echo $totalReservas; ?></strong>
        </div>
      </div>

      <!-- Reportes -->
      <div onclick="window.location.href='Reportes/reportes.php'"
           class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow cursor-pointer p-6 text-center">
        <div class="text-yellow-600 text-4xl mb-3">
          <i class="fa-solid fa-chart-line"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Reportes</h3>
        <p class="text-gray-500 text-sm mb-4">Visualiza graficas de como se manejan tus finanzas finanzas.</p>
       
      </div>

      <!-- Mantenimientos -->
      <div onclick="window.location.href='Mantenimientos/mantenimiento.php'"
           class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow cursor-pointer p-6 text-center">
        <div class="text-yellow-600 text-4xl mb-3">
          <i class="fa-solid fa-wrench"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Mantenimiento</h3>
        <p class="text-gray-500 text-sm mb-4">Control de mantenimiento de los vehículos</p>
        <div class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm inline-flex items-center justify-center gap-1">
          <span>Total:</span> <strong><?php echo $totalMantenimientos; ?></strong>
        </div>
      </div>

    </div>
    
  </div>
  

</div>


    






</body>
</html>


