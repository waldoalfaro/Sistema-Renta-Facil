<?php



include 'seguridad.php';
include 'menu.php';




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="estilo.css">



</head>
<body>
<div class="p-4 sm:ml-64">
    <div class="container">
        <h1>Sonsonate Renta Fácil</h1>
        <h1>Bienvenido <?= $_SESSION['usuario'] ?></h1>
        <p class="subtitle">Sistema de Gestión de Renta de Vehículos</p>
        
        <div class="dashboard-grid">
            <div class="dashboard-card" onclick="window.location.href='Vehiculos/vehiculos.php'">
                <div>
                    <img src="Logo.png" alt="">
                </div>
                <h3 class="card-title">Lista de Carros</h3>
                <p class="card-description">Gestiona el inventario completo de vehículos disponibles para renta</p>
            </div>

            <div class="dashboard-card" onclick="window.location.href='clientes.php'">
                <div class="icon icon-clients"></div>
                <h3 class="card-title">Clientes</h3>
                <p class="card-description">Administra la información de todos los clientes registrados</p>
            </div>

            <div class="dashboard-card" onclick="window.location.href='reservaciones.php'">
                <div class="icon icon-reservations"></div>
                <h3 class="card-title">Reservaciones</h3>
                <p class="card-description">Consulta y gestiona todas las reservaciones activas y pendientes</p>
            </div>

            <div class="dashboard-card" onclick="window.location.href='reportes.php'">
                <div class="icon icon-reports"></div>
                <h3 class="card-title">Reportes</h3>
                <p class="card-description">Genera reportes financieros y estadísticas del negocio</p>
            </div>

            <div class="dashboard-card" onclick="window.location.href='Mantenimiento/mantenimiento.php'">
                <div class="icon icon-maintenance"></div>
                <h3 class="card-title">Mantenimiento</h3>
                <p class="card-description">Control de mantenimiento y estado de los vehículos</p>
            </div>
        </div>
    </div>

</div>
   
    

    


</body>
</html>


