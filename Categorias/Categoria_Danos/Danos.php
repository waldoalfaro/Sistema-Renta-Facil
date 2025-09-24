<?php
include '../../conexion.php';
include '../../seguridad.php';



// Número de registros por página
$registros_por_pagina = 5;

// Página actual (si no existe en GET, se pone en 1)
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

// Calcular el OFFSET
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Contar el total de registros
$total_result = $conn->query("SELECT COUNT(*) AS total FROM categorias_dano");
$total_fila = $total_result->fetch_assoc();
$total_registros = $total_fila['total'];

// Calcular total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Obtener los registros de la página actual
$sql = "SELECT * FROM categorias_dano ORDER BY id_categoria_dano DESC LIMIT $registros_por_pagina OFFSET $offset";
$resultado = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Daños</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../cate.css">

</head>
<body>
    <?php include '../../menu.php'; ?>

    <div class="p-4 sm:ml-64">

        <div class="page-header mb-4">
            <h1 class="page-title text-2xl font-bold">Gestión de Daños en Vehículos</h1>
            <p class="page-subtitle text-gray-600">Módulo para agregar, editar o eliminar daños según ubicación.</p>
        </div>

        <a href="#" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#ModalRegDano">
            <i class="fa-solid fa-plus"></i> Agregar Daño
        </a>

        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center align-middle" style="margin-top: 20px;">
                <thead class="bg-info text-white">
                    <tr>
                        <th>#</th>
                        <th>Ubicación del Daño</th>
                        <th>Tipo de Daño</th>
                        <th>Estado</th>
                        <th>Fecha Registro</th>
                        <?php if ($tipo == 'Administrador'): ?>
                        <th colspan="2">Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $contador = 1;
                    while ($row = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= $contador++ ?></td>
                            <td><?= htmlspecialchars($row['ubicacion_dano']) ?></td>
                            <td><?= htmlspecialchars($row['tipo_dano']) ?></td>
                            <td><?= $row['estado'] == 1 ? "Activo" : "Inactivo" ?></td>
                            <td><?= $row['fecha_registro'] ?></td>

                            <?php if ($tipo == 'Administrador'): ?>
                            <td>
                                
                                <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['id_categoria_dano'] ?>)">
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </a>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <!-- Navegación de Paginación -->
<div class="mt-4 d-flex justify-content-center">
    <nav>
        <ul class="pagination">
            <!-- Botón Anterior -->
            <?php if ($pagina_actual > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $pagina_actual - 1 ?>">Anterior</a>
                </li>
            <?php endif; ?>

            <!-- Números de páginas -->
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <li class="page-item <?= $i == $pagina_actual ? 'active' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <!-- Botón Siguiente -->
            <?php if ($pagina_actual < $total_paginas): ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $pagina_actual + 1 ?>">Siguiente</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>


        <!-- Modal Agregar -->
        <div class="modal fade" id="ModalRegDano" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Registrar un nuevo Daño</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="insertar_dano.php" method="POST">
                            <div class="mb-3">
                                <label for="ubicacion_dano" class="form-label">Ubicación del daño</label>
                                <input type="text" class="form-control" name="ubicacion_dano" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_dano" class="form-label">Tipo de daño</label>
                                <input type="text" class="form-control" name="tipo_dano" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select name="estado" class="form-control">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar -->
        <div class="modal fade" id="ModalEditDano" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Editar Daño</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="editar_dano.php" method="POST">
                            <input type="hidden" name="id_categoria_dano" id="edit_id">
                            <div class="mb-3">
                                <label for="edit_ubicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" name="ubicacion_dano" id="edit_ubicacion" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_tipo" class="form-label">Tipo de Daño</label>
                                <input type="text" class="form-control" name="tipo_dano" id="edit_tipo" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_estado" class="form-label">Estado</label>
                                <select name="estado" class="form-control" id="edit_estado">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    var editModal = document.getElementById('ModalEditDano');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        document.getElementById('edit_id').value = button.getAttribute('data-id');
        document.getElementById('edit_ubicacion').value = button.getAttribute('data-ubicacion');
        document.getElementById('edit_tipo').value = button.getAttribute('data-tipo');
        document.getElementById('edit_estado').value = button.getAttribute('data-estado');
    });

    function confirmDelete(id) {
        if (confirm("¿Está seguro de eliminar este registro?")) {
            window.location.href = 'eliminar_danos.php?id=' + id;
        }
    }
    </script>
</body>
</html>
