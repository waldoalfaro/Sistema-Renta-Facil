<?php 

include '../../conexion.php';
include '../../seguridad.php';

$sql = "SELECT * FROM categorias";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../cate.css">

</head>
<body>
    <?php include '../../menu.php'; ?>

    <div class="p-4 sm:ml-64">

            <div class="page-header">
                <h1 class="page-title">
                    <i class=""></i> Gestión de categorias de Vehiculos
                </h1>
                <p class="page-subtitle">Modulo para agregar ó editar categorias..</p>
            </div>

            <a href="#" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#ModalRegCategoria">
                <i class="fa-solid fa-car-plus"></i> Agregar Categoria
            </a>

            <div class="table-responsive">
            <table class="table table-hover table-bordered text-center" style="margin-top: 20px;">
                <thead class="bg-info text-white">
                    <tr>
                        <th>N</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                         <?php if ($tipo == 'Administrador'): ?>
                        <th colspan="2">Acciones</th>
                         <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $contador = 1;
                    while ($row = $resultado->fetch_assoc()):  ?>
                        <tr>
                            <td><?= $contador++ ?></td>
                        <td><?= $row['nombre_categoria']  ?></td>
                        <td><?= $row['descripcion']  ?></td>
                        <?php if ($tipo == 'Administrador'): ?>
                        <td>
                            
                            <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ModalEditCategoria" 
                                data-id_categoria="<?= $row["id_categoria"] ?>" data-nombre_categoria="<?= $row["nombre_categoria"] ?>" data-descripcion="<?= $row["descripcion"] ?>" 
                                >
                                <i class="fa-solid fa-edit"></i> Editar
                                </a>
                                 |
                            <a href="#" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirmarEliminacion(<?= $row['id_categoria'] ?>)"> 
                                <i class="fa-solid fa-trash"></i>Eliminar</a>
                                
                        </td>
                        <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            </div> 


            <div class="modal fade" id="ModalRegCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Registrar una nueva Categoria</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="validar_categoria_vehiculo.php" method="POST">
                                <div class="mb-3">
                                    <label for="nombre_categoria" class="form-label">Nombre de la categoria</label>
                                    <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" required>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripcion </label>
                                    <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                                </div>
                                
                                <button type="submit" class="btn btn-warning">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="ModalEditCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar categoria</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <form action="Editar_categoria_vehiculo.php" method="POST">
                                <!-- ID oculto -->
                                <input type="hidden" id="edit_idcategoria" name="id_categoria">

                                <div class="mb-3">
                                    <label for="edit_nombre_categoria" class="form-label">Nombre de la categoria</label>
                                    <input type="text" class="form-control" id="edit_nombre_categoria" name="nombre_categoria" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_descripcion" class="form-label">descripcion</label>
                                    <input type="text" class="form-control" id="edit_descripcion" name="descripcion" required>
                                </div>

                                
                                <button type="submit" class="btn btn-warning">Guardar cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>  


     
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($_GET['eliminado']) && $_GET['eliminado'] == 1): ?>
<script>
Swal.fire({
    title: 'Usuario eliminado',
    text: 'El usuario fue eliminado correctamente.',
    icon: 'success',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Aceptar'
});
</script>
<?php endif; ?>

    <script>
        var editModal = document.getElementById('ModalEditCategoria');

editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // Botón que abrió el modal
    
    // Tomar atributos del botón
    var id = button.getAttribute('data-id_categoria');
    var nombre_categoria = button.getAttribute('data-nombre_categoria');
    var descripcion = button.getAttribute('data-descripcion');

    // Referenciar inputs dentro del modal
    var modalId = editModal.querySelector('#edit_idcategoria');
    var modalNombre_categoria = editModal.querySelector('#edit_nombre_categoria');
    var modalDescripcion = editModal.querySelector('#edit_descripcion');

    // Asignar valores
    modalId.value = id;
    modalNombre_categoria.value = nombre_categoria;
    modalDescripcion.value = descripcion;
});





   function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Eliminar categoría de vehículos?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('Eliminar_categoria.php?id_cate=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        Swal.fire('¡Eliminado!', data.message, 'success').then(() => {
                            location.reload(); // recarga la tabla
                        });
                    } else {
                        Swal.fire('No se puede eliminar', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Hubo un problema en la eliminación.', 'error');
                    console.error(error);
                });
        }
    });
}



    </script>
</body>
</html>