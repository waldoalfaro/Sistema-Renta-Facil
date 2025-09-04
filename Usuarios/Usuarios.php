<?php
session_start();

include "../menu.php";
require "../conexion.php";



$sql = " SELECT u.id_usuario, u.nombre, u.usuario, u.correo, t.nombre_tipo AS tipo_usuario
         From usuarios u
         JOIN tipos_usuario t ON u.id_tipo = t.id_tipo";

$resultado = $conn->query($sql);




$sqlTipos = "SELECT * FROM tipos_usuario";
$resultadoTipos = $conn->query($sqlTipos);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<div class="p-4 sm:ml-64">
<div class="container mt-5">
    <a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#ModalRegUsuario">
        <i class="fa-solid fa-user-plus"></i> Agregar Usuario
    </a>

</div>

<table class="table table-hover table-bordered text-center" style="margin-top: 20px;">
    <thead class="bg-info text-white">
        <tr>
            <th>N</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Email</th>
            <th colspan="2">Acciones</th>
        </tr>
    </thead>
    <tbody>
        
        <?php 
        $contador = 1;
        while ($row = $resultado->fetch_assoc()):  ?>
            <tr>
                <td><?= $contador++ ?></td>
               <td><?= $row['nombre']  ?></td>
               <td><?= $row['usuario']  ?></td>
               <td><?= $row['correo']  ?></td>
               <td></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>


<div class="modal fade" id="ModalRegUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="validar.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="clave" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="clave" name="clave" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Tipo Usuario</label>
                        <select class="form-control" name="id_tipo" id="nombre_tipo" required>
                            <option value="">Seleccione un tipo</option>
                                <?php while ($row = $resultadoTipos->fetch_assoc()): ?>
                                    <option value="<?= $row['id_tipo'] ?>"><?= $row['nombre_tipo'] ?></option>
                                <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    
    var editModal = document.getElementById('ModalEditUsuario');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; 
        var id = button.getAttribute('data-id');
        var usuario = button.getAttribute('data-usuario');
        var email = button.getAttribute('data-email');
        var tipo = button.getAttribute('data-tipo');

        

        modalId.value = id;
        modalUsuario.value = usuario;
        modalEmail.value = email;
        modalTipo.value = tipo;
    });


    

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
</div>
    



