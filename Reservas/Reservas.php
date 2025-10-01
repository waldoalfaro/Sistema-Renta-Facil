<?php 

include '../conexion.php';
include '../seguridad.php';

$sql = " SELECT u.id_reservacion, u.solicitante_nombre, u.solicitante_dui, solicitante_telefono, u.solicitante_correo, u.fecha_inicio_solicitada, u.fecha_fin_solicitada, u.dias_solicitados, CONCAT(t.marca, ' ', t.modelo) AS nombre_vehiculo
         From reservaciones u
         JOIN vehiculos t ON u.id_vehiculo = t.id_vehiculo";


$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<?php include '../menu.php' ?>

 <div class="p-4 sm:ml-64">

  <div class="page-header">
                <h1 class="page-title">
                    <i class=""></i> Gestión de categorias de Vehiculos
                </h1>
                <p class="page-subtitle">Modulo para agregar ó editar categorias..</p>
            </div>

    <table class="table table-hover table-bordered text-center" style="margin-top: 20px;">
    <thead class="bg-info text-white">
        <tr>
            <th>N</th>
            <th>marca y modelo </th>
            <th>Nombre</th>
            <th>Dui</th>
            <th>Email</th>
            <th>Telefono</th>
            <th>Fecha inicio</th>
            <th>Fecha fin</th>
            <th>Dias solicitados </th>
            <th colspan="3">Acciones</th>
        </tr>
    </thead>
    <tbody>
        
        <?php 
        $contador = 1;
        while ($row = $resultado->fetch_assoc()):  ?>
            <tr>
                <td><?= $contador++ ?></td>
               <td><?= $row['nombre_vehiculo']  ?></td>
               <td><?= $row['solicitante_nombre']  ?></td>
                <td><?= $row['solicitante_dui']?></td>
                <td><?= $row['solicitante_correo']?></td>
                <td><?= $row['solicitante_telefono']?></td>
                <td><?= $row['fecha_inicio_solicitada']?></td>
                <td><?= $row['fecha_fin_solicitada']?></td>
                <td><?= $row['dias_solicitados']?></td>
                <td>
                    <a href="" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                    <a href="">aceptar</a>
                    <a href="">Realizar contracto</a>
                </td>
              </tr>
        <?php endwhile; ?>


    </tbody>
</table>


 </div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>