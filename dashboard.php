<?php
include 'seguridad.php';
include 'menu.php';

// Definir variable de usuario (evita el error de null en htmlspecialchars)
$usuario = $_SESSION['usuario'] ?? "Invitado";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="estilo.css">

    <!-- Font Awesome para el icono -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
       /* icono de bienvenido usuario  */
            .user-info {
                display: flex;
                flex-direction: column; /* coloca el icono arriba y el texto abajo */
                align-items: left;    /* centra ambos en el eje horizontal */
                margin-bottom: 20px;    /* espacio debajo */
                font-size: 18px;
                color: #070707ff;
            }

            .user-info i {
                font-size: 40px;  /* tamaño del icono */
                margin-bottom: 8px; /* espacio entre icono y texto */
            }


            .user-info span {
                font-size: 17px;   /* texto más grande */
                font-weight: bold;
                color: #0c0c0ca8;
            }

                </style>
</head>
<body>
    
   

    <div class="p-4 sm:ml-64">
        <div class="container">
             <!-- Caja de usuario -->
            <div class="user-info">
                <i class="fa fa-user-circle"></i>
                <div><span>Bienvenido, <?php echo htmlspecialchars($usuario); ?></span></div>
            </div>
            <h1>Sonsonate Renta Fácil</h1>
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