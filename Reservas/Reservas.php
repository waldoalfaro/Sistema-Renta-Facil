<?php 

include '../conexion.php';
include '../seguridad.php';

$sql = " SELECT u.id_reservacion, u.solicitante_nombre, u.solicitante_dui, solicitante_telefono, u.solicitante_correo, u.fecha_inicio_solicitada, u.fecha_fin_solicitada, u.dias_solicitados, u.estado, CONCAT(t.marca, ' ', t.modelo) AS nombre_vehiculo
         From reservaciones u
         JOIN vehiculos t ON u.id_vehiculo = t.id_vehiculo";
         
$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reservaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        .status-badge {
            transition: all 0.3s ease;
        }
        .status-badge:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-50">
 
<?php include '../menu.php' ?>

<div class="p-4 sm:ml-64">
    <div class="max-w-7xl mx-auto">
        <!-- Header mejorado -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 mb-6 fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                        <i class="fas fa-calendar-check"></i>
                        Gestión de Reservaciones
                    </h1>
                    <p class="text-blue-100 mt-2">Administra y controla todas las reservaciones de vehículos</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <p class="text-white text-sm">Total de reservaciones</p>
                        <p class="text-3xl font-bold text-white"><?= $resultado->num_rows ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla responsive con diseño moderno -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-700 to-gray-900">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">#</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-car mr-2"></i>Vehículo
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-user mr-2"></i>Solicitante
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-id-card mr-2"></i>DUI
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-envelope mr-2"></i>Email
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-phone mr-2"></i>Teléfono
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-calendar-alt mr-2"></i>Inicio
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-calendar-alt mr-2"></i>Fin
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-clock mr-2"></i>Días
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-info-circle mr-2"></i>Estado
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-cog mr-2"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        $contador = 1;
                        while ($row = $resultado->fetch_assoc()): 
                            // Determinar color del estado
                            $estadoClasses = 'bg-gray-100 text-gray-800';
                            if ($row['estado'] == 'Aprobada') {
                                $estadoClasses = 'bg-green-100 text-green-800';
                            } elseif ($row['estado'] == 'Pendiente') {
                                $estadoClasses = 'bg-yellow-100 text-yellow-800';
                            } elseif ($row['estado'] == 'Rechazada') {
                                $estadoClasses = 'bg-red-100 text-red-800';
                            }
                        ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 font-semibold text-sm">
                                        <?= $contador++ ?>
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-car text-white"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900"><?= $row['nombre_vehiculo'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['solicitante_nombre'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600"><?= $row['solicitante_dui'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600"><?= $row['solicitante_correo'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600"><?= $row['solicitante_telefono'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= date('d/m/Y', strtotime($row['fecha_inicio_solicitada'])) ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= date('d/m/Y', strtotime($row['fecha_fin_solicitada'])) ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        <?= $row['dias_solicitados'] ?> días
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="status-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?= $estadoClasses ?>">
                                        <?= $row['estado'] ?>
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="aceptar_reserva_cliente.php?id=<?= $row['id_reservacion'] ?>" 
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-green-500 hover:bg-green-600 text-white transition-all duration-200 hover:scale-110 shadow-sm" title="Aprobar">
                                        <i class="fas fa-check text-sm"></i>
                                        </a>
                                        <a href="rechar_reserva.php?id=<?= $row['id_reservacion'] ?>" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-all duration-200 hover:scale-110 shadow-sm" title="Rechazar">
                                            <i class="fa-solid fa-xmark"></i>
                                        </a>
                                        <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white transition-all duration-200 hover:scale-110 shadow-sm" title="Enviar Email">
                                            <i class="fas fa-envelope text-sm"></i>
                                        </a>
                                        <a href="#" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-500 hover:bg-blue-600 text-white transition-all duration-200 hover:scale-110 shadow-sm" title="Realizar contrato">
                                            <i class="fas fa-pen-to-square text-sm"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer info -->
        <div class="mt-6 text-center text-gray-600 text-sm">
            <p><i class="fas fa-info-circle mr-2"></i>Última actualización: <?= date('d/m/Y H:i:s') ?></p>
        </div>
    </div>
</div>

</body>
</html>