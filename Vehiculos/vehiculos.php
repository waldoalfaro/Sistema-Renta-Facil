<?php

session_start();

include '../conexion.php';
include '../seguridad.php';
include '../menu.php';


$sql = "SELECT * FROM vehiculos";
$resultado = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="p-4 sm:ml-64">
        
    
        <a href="#" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#ModalRegVehiculo">
            <i class="fa-solid fa-plus"></i> Agregar vehiculo  
        </a>
    

<div class="table-responsive">
<table class="table table-hover table-bordered text-center" style="margin-top: 20px;">
    <thead class="bg-info text-white">
        <tr>
            <th>N</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Color</th>
            <th>Placa</th>
            <th>Año</th>
            <th>Asientos</th>
            <th>Aire Acondicionado</th>
            <th>Foto</th>
            <th>Estado</th>
            <th colspan="2">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $conta = 1;
        while ($row = $resultado->fetch_assoc()):
        
        ?>
        <tr>
            <td><?= $conta++ ?></td>
            <td><?= $row['marca'] ?></td>
            <td><?= $row['modelo'] ?></td>
            <td><?= $row['color'] ?></td>
            <td><?= $row['placa'] ?></td>
            <td><?= $row['anio'] ?></td>
            <td><?= $row['asientos'] ?></td>
            <td><?= $row['aire_acondicionado'] ?></td>
            <td>
                <?php if (!empty($row['foto'])): ?>
                    <img src="../FotosSubidas/<?= $row['foto'] ?>" alt="Foto Vehículo" width="100">
                <?php else: ?>
                    <span>Sin foto</span>
                <?php endif; ?>
            </td>
            <td>
              <select onchange="cambiarEstado(<?= $row['id_vehiculo'] ?>, this.value)">
                <option value="Disponible" <?= $row['estado'] == 'Disponible' ? 'selected' : '' ?>>Disponible</option>
                <option value="No disponible" <?= $row['estado'] == 'No disponible' ? 'selected' : '' ?>>No disponible</option>
                <option value="Mantenimiento" <?= $row['estado'] == 'Mantenimiento' ? 'selected' : '' ?>>Mantenimiento</option>
                <option value="De baja" <?= $row['estado'] == 'De baja' ? 'selected' : '' ?>>De baja</option>
              </select>
            </td>
            <td></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
    
</table>
</div>
</div>

<div class="modal fade" id="ModalRegVehiculo" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal más ancho -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Vehículo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="ValidarVehiculo.php" method="POST" enctype="multipart/form-data">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Marca</label>
              <input type="text" class="form-control" name="marca" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Modelo</label>
              <input type="text" class="form-control" name="modelo" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Color</label>
              <input type="text" class="form-control" name="color" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Placa</label>
              <input type="text" class="form-control" name="placa" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Año</label>
              <input type="number" class="form-control" name="anio" min="1900" max="2099" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Asientos</label>
              <input type="number" class="form-control" name="asientos" min="1" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Aire Acondicionado</label>
              <select class="form-control" name="aire" required>
                <option value="">Seleccione</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Agregar Foto</label>
              <input type="file" class="form-control" name="foto" accept="image/*">
            </div>
            <div class="col-md-6">
              <label class="form-label">Estado</label>
              <select class="form-control" name="estado" required>
                <option value="">Seleccione</option>
                <option value="Disponible">Disponible</option>
                <option value="No disponible">No disponible</option>
                <option value="Mantenimiento">Mantenimiento</option>
                <option value="De baja">De baja</option>
              </select>
            </div>

          </div>

          <div class="mt-3">
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

   



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>


<script>


function cambiarEstado(idVehiculo, nuevoEstado) {
    fetch('cambiar_estado.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + idVehiculo + '&estado=' + nuevoEstado
    })
    .then(response => response.text())
    .then(data => {
        alert('Estado actualizado correctamente');
        // opcional: refrescar tabla o cambiar color de fila
    });
}


</script>