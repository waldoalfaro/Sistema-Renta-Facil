<?php
include 'seguridad.php';
include 'menu.php';
include 'conexion.php';

// Definir variable de usuario
$usuario = $_SESSION['usuario'] ?? "Invitado";

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

    <style>
        .user-info {
            display: flex;
            flex-direction: column;
            align-items: left;
            margin-bottom: 20px;
            font-size: 18px;
            color: #070707ff;
        }
        .user-info i {
            font-size: 40px;
            margin-bottom: 8px;
        }
        .user-info span {
            font-size: 17px;
            font-weight: bold;
            color: #0c0c0ca8;
        }
    </style>

    <script>
        window.onload = function() {
            if (window.history && window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        };
    </script>
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
                <!-- Vehículos -->
                <div class="dashboard-card" onclick="window.location.href='Vehiculos/vehiculos.php'">
                    <div><img src="Logo.png" alt="" style="max-width: 80px; height: auto; margin: 0 auto 20px;"></div>
                    <h3 class="card-title">Lista de Carros</h3>
                    <p class="card-description">Gestiona el inventario completo de vehículos</p>
                    <span class="count-badge">
                        <span class="badge-label">Total:</span>
                        <strong><?php echo $totalVehiculos; ?></strong>
                    </span>
                </div>

                <!-- Reservaciones -->
                <div class="dashboard-card" onclick="window.location.href='Reservas/Reservas.php'">
                    <div class="icon icon-reservations"></div>
                    <h3 class="card-title">Reservaciones</h3>
                    <p class="card-description">Consulta y gestiona todas las reservaciones</p>
                    <span class="count-badge">
                        <span class="badge-label">Total:</span>
                        <strong><?php echo $totalReservas; ?></strong>
                    </span>
                </div>

                <!-- Reportes -->
                <div class="dashboard-card" onclick="window.location.href='reportes.php'">
                    <div class="icon icon-reports"></div>
                    <h3 class="card-title">Reportes</h3>
                    <p class="card-description">Genera reportes financieros y estadísticas</p>
                    <span class="count-badge no-count">
                        <i class="fas fa-file-chart-line" style="font-size: 1.5rem; color: white;"></i>
                    </span>
                </div>

                <!-- Mantenimientos -->
                <div class="dashboard-card" onclick="window.location.href='Mantenimientos/mantenimiento.php'">
                    <div class="icon icon-maintenance"></div>
                    <h3 class="card-title">Mantenimiento</h3>
                    <p class="card-description">Control de mantenimiento de los vehículos</p>
                    <span class="count-badge">
                        <span class="badge-label">Total:</span>
                        <strong><?php echo $totalMantenimientos; ?></strong>
                    </span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>