<?php

session_start();

include '../conexion.php';
include '../seguridad.php';
include '../menu.php';

$sql = "SELECT * FROM vehiculos ORDER BY id_vehiculo DESC";
$resultado = $conn->query($sql);


$sqlTipos = "SELECT * FROM categorias";
$resultadoTipos = $conn->query($sqlTipos);





?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Vehículos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="p-4 sm:ml-64 ">
        <div class="main-container animate__animated animate__fadeIn">
            
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-car"></i> Gestión de Vehículos
                </h1>
                <p class="page-subtitle">Administra tu flota de vehículos de manera eficiente</p>
            </div>
            
            <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?= $_SESSION['tipo_mensaje'] === 'success' ? 'success' : ($_SESSION['tipo_mensaje'] === 'info' ? 'info' : 'danger') ?> alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                <i class="fas fa-<?= $_SESSION['tipo_mensaje'] === 'success' ? 'check-circle' : ($_SESSION['tipo_mensaje'] === 'info' ? 'info-circle' : 'exclamation-triangle') ?>"></i>
                <?= $_SESSION['mensaje'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
                unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); 
            endif; 
            ?>
            
            <div class="text-center">
                <button class="add-vehicle-btn animate__animated animate__pulse animate__infinite" data-bs-toggle="modal" data-bs-target="#ModalRegVehiculo">
                    <i class="fas fa-plus-circle"></i> Agregar Nuevo Vehículo
                </button>
            </div>
            
            <div class="row g-4">
                <?php 
                $contador = 0;
                while ($row = $resultado->fetch_assoc()): 
                    $contador++;
                ?>
                <div class="col-lg-6 col-xl-4">
                    <div class="vehicle-card animate__animated animate__fadeInUp" style="animation-delay: <?= $contador * 0.1 ?>s;">
                        
                        <!-- Estado Badge -->
                        <div class="status-badge status-<?= strtolower(str_replace(' ', '-', $row['estado'])) ?>">
                            <?= $row['estado'] ?>
                        </div>
                        
                        <!-- Imagen del vehículo -->
                        <div class="position-relative overflow-hidden">
                            <?php if (!empty($row['foto'])): ?>
                                <img src="../FotosSubidas/<?= htmlspecialchars($row['foto']) ?>" 
                                     alt="<?= htmlspecialchars($row['marca'] . ' ' . $row['modelo']) ?>" 
                                     class="card-image">
                            <?php else: ?>
                                <div class="no-image-placeholder">
                                    <i class="fas fa-car"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Contenido de la tarjeta -->
                        <div class="card-content">
                            
                            <!-- Título del vehículo -->
                            <h3 class="vehicle-title">
                                <i class="fas fa-car text-primary"></i>
                                <?= htmlspecialchars($row['marca'] . ' ' . $row['modelo']) ?>
                            </h3>
                            
                            <!-- Detalles del vehículo -->
                            <div class="vehicle-details">
                                <div class="detail-item">
                                    <i class="fas fa-palette detail-icon"></i>
                                    <span class="detail-label">Color</span>
                                    <span class="detail-value"><?= htmlspecialchars($row['color']) ?></span>
                                </div>
                                
                                <div class="detail-item">
                                    <i class="fas fa-id-card detail-icon"></i>
                                    <span class="detail-label">Placa</span>
                                    <span class="detail-value"><?= htmlspecialchars($row['placa']) ?></span>
                                </div>
                                
                                <div class="detail-item">
                                    <i class="fas fa-calendar-alt detail-icon"></i>
                                    <span class="detail-label">Año</span>
                                    <span class="detail-value"><?= htmlspecialchars($row['anio']) ?></span>
                                </div>
                                
                                <div class="detail-item">
                                    <i class="fas fa-users detail-icon"></i>
                                    <span class="detail-label">Asientos</span>
                                    <span class="detail-value"><?= htmlspecialchars($row['asientos']) ?></span>
                                </div>
                                
                                <div class="detail-item">
                                    <i class="fas fa-snowflake detail-icon"></i>
                                    <span class="detail-label">A/C</span>
                                    <span class="detail-value">
                                        <?= $row['aire_acondicionado'] ? 
                                            '<i class="fas fa-check text-success"></i> Sí' : 
                                            '<i class="fas fa-times text-danger"></i> No' ?>
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-id-card detail-icon"></i>
                                    <span class="detail-label">Precio por dia</span>
                                    <span class="detail-value"><?= htmlspecialchars($row['precio_dia']) ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-id-card detail-icon"></i>
                                    <span class="detail-label">Combustible</span>
                                    <span class="detail-value"><?= htmlspecialchars($row['combustible']) ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-id-card detail-icon"></i>
                                    <span class="detail-label">Gps</span>
                                    <span class="detail-value"><?= htmlspecialchars($row['gps']) ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-id-card detail-icon"></i>
                                    <span class="detail-label">Seguro</span>
                                    <span class="detail-value"><?= htmlspecialchars($row['seguro']) ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-id-card detail-icon"></i>
                                    <span class="detail-label">Vin</span>
                                    <span class="detail-value"><?= htmlspecialchars($row['vin']) ?></span>
                                </div>
                                <div class="detail-item">
                                    <i class="fas fa-tools detail-icon"></i>
                                    <span class="detail-label">Daños</span>
                                    <span class="detail-value">
                                        <?php
                                        $idVehiculo = $row['id_vehiculo'];
                                        $consulta = $conn->query("SELECT ubicacion_dano, tipo_dano FROM vehiculos_danos WHERE id_vehiculo = $idVehiculo");

                                        if ($consulta->num_rows > 0) {
                                            echo "<ul class='mb-0'>";
                                            while ($dano = $consulta->fetch_assoc()) {
                                                echo "<li>" . htmlspecialchars($dano['ubicacion_dano']) . " - " . htmlspecialchars($dano['tipo_dano']) . "</li>";
                                            }
                                            echo "</ul>";
                                        } else {
                                            echo "No hay daños registrados";
                                        }
                                        ?>
                                    </span>
                                </div>

                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ModalEditarVehiculo" 
                                        data-id="<?= $row["id_vehiculo"] ?>" data-marca="<?= $row["marca"] ?>" data-modelo="<?= $row["modelo"] ?>" 
                                        data-color="<?= $row["color"] ?>" data-placa="<?= $row["placa"] ?>" data-anio="<?= $row["anio"] ?>"
                                        data-asientos="<?= $row["asientos"] ?>"   data-foto="<?= $row["foto"] ?>"  data-precio_dia="<?= $row["precio_dia"] ?>"
                                        data-combustible="<?= $row["combustible"] ?>" data-gps="<?= $row["gps"] ?>" data-seguro="<?= $row["seguro"] ?>" data-vin="<?= $row["vin"] ?>" >
                                        <i class="fa-solid fa-edit"></i> Editar
                                </a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['id_vehiculo'] ?>)"> 
                                    <i class="fa-solid fa-trash"></i>Eliminar
                                </a>
                            </div>
                            
                            <!-- Selector de estado -->
                            <div class="mt-2">
                                <label class="form-label fw-bold" style="font-size: 0.85rem;">
                                    <i class="fas fa-cog"></i> Estado:
                                </label>
                                <select class="status-selector" 
                                        onchange="cambiarEstado(<?= $row['id_vehiculo'] ?>, this.value)"
                                        data-vehicle-id="<?= $row['id_vehiculo'] ?>">
                                    <option value="Disponible" <?= $row['estado'] == 'Disponible' ? 'selected' : '' ?>>
                                        🟢 Disponible
                                    </option>
                                    <option value="No disponible" <?= $row['estado'] == 'No disponible' ? 'selected' : '' ?>>
                                        🔴 No disponible
                                    </option>
                                    <option value="Mantenimiento" <?= $row['estado'] == 'Mantenimiento' ? 'selected' : '' ?>>
                                        🟡 Mantenimiento
                                    </option>
                                    <option value="De baja" <?= $row['estado'] == 'De baja' ? 'selected' : '' ?>>
                                        ⚫ De baja
                                    </option>
                                </select>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
                
                <?php if ($contador == 0): ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-car-side" style="font-size: 4rem; color: #cbd5e1;"></i>
                        <h3 class="mt-3 text-muted">No hay vehículos registrados</h3>
                        <p class="text-muted">Comienza agregando tu primer vehículo</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
        </div>
    </div>

    <!-- Loading Spinner -->
    <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

    <!-- Modal para agregar vehículo -->
    <div class="modal fade" id="ModalRegVehiculo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle"></i> Agregar Nuevo Vehículo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="ValidarVehiculo.php" method="POST" enctype="multipart/form-data" id="vehicleForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-car text-primary"></i> Marca
                                </label>
                                <input type="text" class="form-control" name="marca" required placeholder="Ej: Toyota, Honda">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-tag text-success"></i> Modelo
                                </label>
                                <input type="text" class="form-control" name="modelo" required placeholder="Ej: Corolla, Civic">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-palette text-info"></i> Color
                                </label>
                                <input type="text" class="form-control" name="color" required placeholder="Ej: Blanco, Negro">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-id-card text-warning"></i> Placa
                                </label>
                                <input type="text" class="form-control" name="placa" required placeholder="Ej: ABC-123">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt text-primary"></i> Año
                                </label>
                                <input type="number" class="form-control" name="anio" min="1900" max="2099" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-users text-success"></i> Asientos
                                </label>
                                <input type="number" class="form-control" name="asientos" min="1" max="50" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-snowflake text-info"></i> Aire Acondicionado
                                </label>
                                <select class="form-control" name="aire" required>
                                    <option value="">Seleccione</option>
                                    <option value="1">✅ Sí</option>
                                    <option value="0">❌ No</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-cog text-warning"></i> Estado
                                </label>
                                <select class="form-control" name="estado" required>
                                    <option value="">Seleccione</option>
                                    <option value="Disponible">🟢 Disponible</option>
                                    <option value="No disponible">🔴 No disponible</option>
                                    <option value="Mantenimiento">🟡 Mantenimiento</option>
                                    <option value="De baja">⚫ De baja</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-cog text-warning"></i> categoria
                                </label>
                                <select class="form-control" name="id_categoria" required>
                                    <option value="">Seleccione un tipo</option>
                                            <?php while ($row = $resultadoTipos->fetch_assoc()): ?>
                                                <option value="<?= $row['id_categoria'] ?>"><?= $row['nombre_categoria'] ?></option>
                                            <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-users text-success"></i> Precio por dia del vehiculo
                                </label>
                                <input type="number" class="form-control" name="precio_dia"  required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-snowflake text-info"></i>Tipo de Combustible
                                </label>
                                <select class="form-control" name="combustible" required>
                                    <option value="">Seleccione</option>
                                    <option value="Gasolina">Gasolina</option>
                                    <option value="Diesel">Diesel</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-snowflake text-info"></i>Gps
                                </label>
                                <select class="form-control" name="gps" required>
                                    <option value="">Seleccione</option>
                                    <option value="Si">SI</option>
                                    <option value="No">NO</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-snowflake text-info"></i>Seguro
                                </label>
                                <select class="form-control" name="seguro" required>
                                    <option value="">Seleccione</option>
                                    <option value="Si">SI</option>
                                    <option value="No">NO</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-users text-success"></i> Vin
                                </label>
                                <input type="number" class="form-control" name="vin"  required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-cog text-warning"></i> Ubicasion del daño
                                </label>
                               <select class="form-control" id="ubicacion_dano" name="ubicacion_dano[]" multiple>
                                    <option value="">Seleccione ubicación</option>
                                    <?php
                                    // Traemos solo las ubicaciones distintas
                                    $queryUbicaciones = $conn->query("SELECT DISTINCT ubicacion_dano FROM categorias_dano ORDER BY ubicacion_dano");
                                    while ($row = $queryUbicaciones->fetch_assoc()):
                                    ?>
                                        <option value="<?= $row['ubicacion_dano'] ?>"><?= $row['ubicacion_dano'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                             <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-cog text-warning"></i> Tipo del daño
                                </label>
                               <select class="form-control" id="tipo_dano" name="tipo_dano[]" multiple>
                                    <option value="">Seleccione tipo de daño</option>
                                </select>

                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-camera text-primary"></i> Foto del Vehículo
                                </label>
                                <input type="file" class="form-control" name="foto" accept="image/*">
                                <small class="text-muted">Formatos aceptados: JPG, PNG, GIF (Max. 5MB)</small>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save"></i> Guardar Vehículo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




   <div class="modal fade" id="ModalEditarVehiculo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Vehiculo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="EditarVehiculo.php" method="POST" enctype="multipart/form-data">
                  <div class="row g-3">
                    <input type="hidden" id="edit_idvehiculo" name="id_vehiculo">

                    <div class="col-md-6">
                        <label for="edit_marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="edit_marca" name="marca" required>
                    </div>

                    <div class="col-md-6">
                        <label for="edit_modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="edit_modelo" name="modelo" required>
                    </div>

                    <div class="col-md-6">
                        <label for="edit_color" class="form-label">Color</label>
                        <input type="text" class="form-control" id="edit_color" name="color" required>
                    </div>

                    <div class="col-md-6">
                        <label for="edit_placa" class="form-label">Placa</label>
                        <input type="text" class="form-control" id="edit_placa" name="placa" required>
                    </div>

                    <div class="col-md-6">
                        <label for="edit_anio" class="form-label">Año</label>
                        <input type="number" class="form-control" id="edit_anio" name="anio" required>
                    </div>

                    <div class="col-md-6">
                        <label for="edit_asientos" class="form-label">Asientos</label>
                        <input type="number" class="form-control" id="edit_asientos" name="asientos"  min="1" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_precio_dia" class="form-label">precio por dia </label>
                        <input type="number" class="form-control" id="edit_precio_dia" name="precio_dia" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_combustible" class="form-label">Combustible</label>
                        <select class="form-control" id="edit_combustible"  name="combustible" required>
                                    <option value="">Seleccione</option>
                                    <option value="Gasolina">Gasolina</option>
                                    <option value="Diesel">Diesel</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_gps" class="form-label">Gps</label>
                        <select class="form-control" id="edit_gps" name="gps" required>
                                    <option value="">Seleccione</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_seguro" class="form-label">Seguro</label>
                        <select class="form-control" id="edit_seguro" name="seguro" required>
                                    <option value="">Seleccione</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_vin" class="form-label">Vin</label>
                        <input type="text" class="form-control" id="edit_vin" name="vin" required>
                    </div>
                    <div class="col-md-6">
                        <label>Ubicación del daño</label>
                        <select id="ubicacion_dano" name="ubicacion_dano[]" multiple class="form-control">
                            <option value="">Seleccione ubicación</option>
                            <?php
                            $queryUbicaciones = $conn->query("SELECT DISTINCT ubicacion_dano FROM categorias_dano ORDER BY ubicacion_dano");
                            while($row = $queryUbicaciones->fetch_assoc()):
                            ?>
                                <option value="<?= $row['ubicacion_dano'] ?>"><?= $row['ubicacion_dano'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Tipo de daño</label>
                        <select id="tipo_dano" name="tipo_dano[]" multiple class="form-control">
                            <option value="">Seleccione tipo de daño</option>
                        </select>
                    </div>


                    <input type="hidden" name="foto_actual" id="edit_foto_actual">

                    <!-- Campo de archivo -->
                    <div class="col-12">
                        <label for="edit_foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="edit_foto" name="foto" accept="image/*">
                        <br>
                        <img id="preview_foto" src="" alt="Vista previa" width="120" style="display:none; border:1px solid #ccc; padding:3px;">
                    </div>
                                    
                  </div>
                  <div class="mt-3">
                    <button type="submit" class="btn btn-warning">Guardar cambios</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Función para cambiar estado con efectos visuales
        function cambiarEstado(idVehiculo, nuevoEstado) {
            // Mostrar spinner
            document.querySelector('.loading-spinner').style.display = 'block';
            
            // Encontrar la tarjeta correspondiente
            const selector = document.querySelector(`select[data-vehicle-id="${idVehiculo}"]`);
            const card = selector.closest('.vehicle-card');
            const badge = card.querySelector('.status-badge');
            
            fetch('cambiar_estado.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'id=' + idVehiculo + '&estado=' + nuevoEstado
            })
            .then(response => response.text())
            .then(data => {
                // Ocultar spinner
                document.querySelector('.loading-spinner').style.display = 'none';
                
                // Actualizar badge visualmente
                const statusClass = 'status-' + nuevoEstado.toLowerCase().replace(' ', '-');
                badge.className = 'status-badge ' + statusClass;
                badge.textContent = nuevoEstado;
                
                // Efecto de éxito
                card.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    card.style.transform = '';
                }, 300);
                
                // Notificación de éxito
                showNotification('Estado actualizado correctamente', 'success');
            })
            .catch(error => {
                document.querySelector('.loading-spinner').style.display = 'none';
                showNotification('Error al actualizar el estado', 'error');
                console.error('Error:', error);
            });
        }
        
       
        
        // Variables para confirmación de eliminación
        let vehicleToDelete = null;
        
        // Función para confirmar eliminación
        function confirmarEliminar(idVehiculo, nombreVehiculo) {
            vehicleToDelete = idVehiculo;
            document.getElementById('vehicle_to_delete').textContent = nombreVehiculo;
            
            // Mostrar modal de confirmación
            const modal = new bootstrap.Modal(document.getElementById('ModalConfirmDelete'));
            modal.show();
        }
        
        // Función para eliminar vehículo
        function eliminarVehiculo() {
            if (!vehicleToDelete) return;
            
            document.querySelector('.loading-spinner').style.display = 'block';
            
            fetch('eliminar_vehiculo.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'id=' + vehicleToDelete
            })
            .then(response => response.json())
            .then(data => {
                document.querySelector('.loading-spinner').style.display = 'none';
                
                if (data.success) {
                    // Cerrar modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('ModalConfirmDelete'));
                    modal.hide();
                    
                    // Remover tarjeta con animación
                    const vehicleCard = document.querySelector(`select[data-vehicle-id="${vehicleToDelete}"]`).closest('.col-lg-6');
                    vehicleCard.style.transform = 'scale(0)';
                    vehicleCard.style.opacity = '0';
                    
                    setTimeout(() => {
                        vehicleCard.remove();
                        showNotification('Vehículo eliminado correctamente', 'success');
                        
                        // Si no quedan vehículos, mostrar mensaje
                        if (document.querySelectorAll('.vehicle-card').length === 0) {
                            location.reload();
                        }
                    }, 300);
                    
                } else {
                    showNotification(data.message || 'Error al eliminar el vehículo', 'error');
                }
                
                vehicleToDelete = null;
            })
            .catch(error => {
                document.querySelector('.loading-spinner').style.display = 'none';
                showNotification('Error al eliminar el vehículo', 'error');
                console.error('Error:', error);
                vehicleToDelete = null;
            });
        }
        
        // Función para ver detalles completos del vehículo
        
        
        // Event listener para confirmación de eliminación
       
        
        // Validación del formulario
       
        
        // Animaciones al cargar
      
        
        // Preview de imagen en el modal
      


var editModal = document.getElementById('ModalEditarVehiculo');

editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;

    // Tomar atributos del botón
    var id = button.getAttribute('data-id');
    var marca = button.getAttribute('data-marca');
    var modelo = button.getAttribute('data-modelo');
    var color = button.getAttribute('data-color');
    var placa = button.getAttribute('data-placa');
    var anio = button.getAttribute('data-anio');
    var asientos = button.getAttribute('data-asientos');
    var foto = button.getAttribute('data-foto');
    var precio_dia = button.getAttribute('data-precio_dia');
    var combustible = button.getAttribute('data-combustible');
    var gps = button.getAttribute('data-gps');
    var seguro = button.getAttribute('data-seguro');
    var vin = button.getAttribute('data-vin');

    // Referencias a inputs
    var modalId = editModal.querySelector('#edit_idvehiculo');
    var modalmarca = editModal.querySelector('#edit_marca');
    var modalmodelo = editModal.querySelector('#edit_modelo');
    var modalcolor = editModal.querySelector('#edit_color');
    var modalplaca = editModal.querySelector('#edit_placa');
    var modalanio = editModal.querySelector('#edit_anio');
    var modalasientos = editModal.querySelector('#edit_asientos');
    var modalfoto = editModal.querySelector('#edit_foto_actual');
    var modalprecio_dia = editModal.querySelector('#edit_precio_dia');
    var modalcombustible = editModal.querySelector('#edit_combustible');
    var modalgps = editModal.querySelector('#edit_gps');
    var modalseguro = editModal.querySelector('#edit_seguro');
    var modalvin = editModal.querySelector('#edit_vin');

    var ubicacionSelect = editModal.querySelector('#ubicacion_dano');
    var tipoSelect = editModal.querySelector('#tipo_dano');

    // Limpiar selects
    ubicacionSelect.value = null;
    tipoSelect.innerHTML = '<option value="">Seleccione tipo de daño</option>';

    // Traer todos los daños del vehículo
    fetch('obtener_danos.php?id_vehiculo=' + id) // <-- CORREGIDO: id
        .then(res => res.json())
        .then(data => {
            // Marcar las ubicaciones existentes
            for (let i = 0; i < ubicacionSelect.options.length; i++) {
                if (data.some(d => d.ubicacion_dano === ubicacionSelect.options[i].value)) {
                    ubicacionSelect.options[i].selected = true;
                }
            }

            // Traer todos los tipos de daño posibles (de todas las ubicaciones)
            fetch('obtener_tipos.php?ubicaciones=' + encodeURIComponent(JSON.stringify(
                Array.from(ubicacionSelect.selectedOptions).map(o => o.value)
            )))
            .then(res => res.json())
            .then(tipos => {
                tipos.forEach(tipo => {
                    let opt = document.createElement('option');
                    opt.value = tipo.tipo_dano;
                    opt.text = tipo.tipo_dano;

                    // Seleccionar si ya existe en los daños del vehículo
                    if(data.some(d => d.tipo_dano === tipo.tipo_dano && d.ubicacion_dano === tipo.ubicacion_dano)){
                        opt.selected = true;
                    }

                    tipoSelect.appendChild(opt);
                });
            });
        });

    // Mostrar preview de foto
    var preview = document.getElementById('preview_foto');
    if (foto && foto !== '') {
        preview.src = '../FotosSubidas/' + foto;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }

    // Asignar valores
    modalId.value = id;
    modalmarca.value = marca;
    modalmodelo.value = modelo;
    modalcolor.value = color;
    modalplaca.value = placa;
    modalanio.value = anio;
    modalasientos.value = asientos;
    modalfoto.value = foto;
    modalprecio_dia.value = precio_dia;
    modalcombustible.value = combustible;
    modalgps.value = gps;
    modalseguro.value = seguro;
    modalvin.value = vin;
});


        function confirmDelete(id) {
        if (confirm("¿Está seguro de que desea eliminar este usuario?")) {
            window.location.href = 'eliminar_vehiculo.php?id_vehiculo=' + id;
        }
    }






            document.getElementById('ubicacion_dano').addEventListener('change', function() {
                var ubicacion = this.value;
                var tipoSelect = document.getElementById('tipo_dano');

                // Limpiamos las opciones anteriores
                tipoSelect.innerHTML = '<option value="">Seleccione tipo de daño</option>';

                if(ubicacion) {
                    // Llamada AJAX a PHP que devuelve los tipos de daño según la ubicación
                    fetch('get_tipos_dano.php?ubicacion=' + encodeURIComponent(ubicacion))
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(function(tipo) {
                            var option = document.createElement('option');
                            option.value = tipo;
                            option.text = tipo;
                            tipoSelect.add(option);
                        });
                    });
                }
            });


    </script>
</body>
</html>


sc