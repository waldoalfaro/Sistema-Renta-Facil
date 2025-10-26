<?php
include '../conexion.php';

$sql = "SELECT c.*, v.marca, v.modelo, v.placa 
        FROM contratos c
        INNER JOIN vehiculos v ON c.id_vehiculo = v.id_vehiculo
        ORDER BY c.fecha_creacion DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Contratos Registrados</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

<?php include '../menu.php'; ?>


<div class="p-4 sm:ml-64">
    <div class="h-16 sm:h-20"></div>

 <div class="max-w-7xl mx-auto">
        <div class="bg-gradient-to-r from-gray-700 to-gray-700 rounded-lg shadow-lg p-6 mb-6 fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                        <i class="fas fa-users"></i>
                        Gestión de Contratos 
                    </h1>
                    <p class="text-purple-100 mt-2">Administra y controla todos tus contratos</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <p class="text-white text-sm">Total de contratos</p>
                    </div>
                </div>
            </div>
        </div>

        

        
        <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-700 to-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Cliente
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Vehiculo
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Fechas
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                Dias
                            </th>
                             <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        $contador = 1;
                        while ($row = $result->fetch_assoc()): 
                            // Colores para tipos de usuario
                        ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 text-white font-bold text-sm shadow-md">
                                        <?= $contador++ ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                            
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-bold text-gray-900"><?= $row['cliente_nombre'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900"><?= $row['marca'].' '.$row['modelo'].' ('.$row['placa'].')' ?></span>
                
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-600"><?= $row['fecha_inicio'] ?> → <?= $row['fecha_fin'] ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                        
                                        <?= $row['dias_renta'] ?>
                                    </span>
                                </td>
                                 <td class="px-6 py-4 whitespace-nowrap text-center">
                                        
                                        <?= $row['total_contrato'] ?>
                                    </span>
                                </td>
                                <td>
                                     <a href="generar_contrato_pdf.php?id_contrato=<?= $row['id_contrato'] ?>" 
                               class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">
                               Descargar PDF
                            </a>
                                </td>
                               
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer info -->
        <div class="mt-6 text-center text-gray-600 text-sm">
            <p><i class="fas fa-info-circle mr-2"></i>Gestiona los permisos y accesos de cada usuario del sistema</p>
        </div>
    </div>
   
</div>



</body>
</html>





