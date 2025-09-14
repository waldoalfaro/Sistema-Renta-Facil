<?php

session_start();

include '../conexion.php';
include '../seguridad.php';
include '../menu.php';

$sql = "SELECT * FROM vehiculos ORDER BY id_vehiculo DESC";
$resultado = $conn->query($sql);

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
    
    <style>
        :root {
            --primary-color: #3b82f6;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --dark-color: #1f2937;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 30px;
        }
        
        .vehicle-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .vehicle-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
       .card-image {
    width: 150px;       /* ancho fijo */
    height: auto;       /* mantiene proporción */
    border-radius: 8px; /* esquinas redondeadas opcional */
    object-fit: cover;  /* recorta si el contenedor es más pequeño */
}

        
        .vehicle-card:hover .card-image {
            transform: scale(1.05);
        }
        
        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .status-disponible {
            background: linear-gradient(45deg, #10b981, #34d399);
            color: white;
        }
        
        .status-no-disponible {
            background: linear-gradient(45deg, #ef4444, #f87171);
            color: white;
        }
        
        .status-mantenimiento {
            background: linear-gradient(45deg, #f59e0b, #fbbf24);
            color: white;
        }
        
        .status-de-baja {
            background: linear-gradient(45deg, #6b7280, #9ca3af);
            color: white;
        }
        
        .card-content {
            padding: 25px;
        }
        
        .vehicle-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .vehicle-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(12z0px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .detail-item {
    display: flex;
    align-items: center;
    gap: 6px;             /* Espacio entre icono y texto */
    padding: 4px 8px;     /* Menos relleno */
    font-size: 0.85rem;   /* Texto más pequeño */
    border: 1px solid #ddd;
    border-radius: 6px;
    max-width: 200px;     /* Controla el ancho máximo */
    background-color: #f9f9f9;
}
.detail-icon {
    font-size: 14px;      /* Icono más pequeño */
    color: #007bff;
}
.detail-label {
    font-weight: bold;
}
.detail-value {
    color: #333;
}
        
        .status-selector {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 100%;
        }
        
        .status-selector:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        
        .add-vehicle-btn {
            background: linear-gradient(45deg, #f59e0b, #fbbf24);
            border: none;
            border-radius: 15px;
            padding: 15px 30px;
            font-weight: 600;
            color: white;
            font-size: 1.1rem;
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }
        
        .add-vehicle-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(245, 158, 11, 0.4);
            background: linear-gradient(45deg, #d97706, #f59e0b);
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }
        
        .page-subtitle {
            color: #64748b;
            font-size: 1.2rem;
            font-weight: 500;
        }
        
        .no-image-placeholder {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 3rem;
        }
        
        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .modal-header {
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            color: white;
            border-radius: 20px 20px 0 0;
        }
        
        .form-control {
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        
        @media (max-width: 768px) {
            .vehicle-details {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .main-container {
                margin: 10px;
                padding: 20px;
            }
            
            .page-title {
                font-size: 2rem;
            }
        }
    </style>
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
                                <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ModalEditarVehiculo" 
                                        data-id="<?= $row["id_vehiculo"] ?>" data-marca="<?= $row["marca"] ?>" data-modelo="<?= $row["modelo"] ?>" 
                                        data-color="<?= $row["color"] ?>" data-placa="<?= $row["placa"] ?>" data-anio="<?= $row["anio"] ?>" data-asientos="<?= $row["asientos"] ?>" data-foto="<?= $row["foto"] ?>">
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
                      <label class="form-label">Foto nueva</label>
                      <input type="file" class="form-control" id="edit_foto" name="foto" accept="image/*">
                      <div class="mt-2">
                        <img id="preview_foto" src="" alt="Foto actual" class="img-thumbnail" style="max-width: 150px;">
                      </div>
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
                var button = event.relatedTarget; // Botón que abrió el modal
                
                // Tomar atributos del botón
                var id = button.getAttribute('data-id');
                var marca = button.getAttribute('data-marca');
                var modelo = button.getAttribute('data-modelo');
                var color = button.getAttribute('data-color');
                var placa = button.getAttribute('data-placa');
                var anio = button.getAttribute('data-anio');
                var asientos = button.getAttribute('data-asientos');
                var foto = button.getAttribute('data-foto');

                // Referenciar inputs dentro del modal
                var modalId = editModal.querySelector('#edit_idvehiculo');
                var modalmarca = editModal.querySelector('#edit_marca');
                var modalmodelo = editModal.querySelector('#edit_modelo');
                var modalcolor = editModal.querySelector('#edit_color');
                var modalplaca = editModal.querySelector('#edit_placa');
                var modalanio = editModal.querySelector('#edit_anio');
                var modalasientos = editModal.querySelector('#edit_asientos');

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
            });


        function confirmDelete(id) {
        if (confirm("¿Está seguro de que desea eliminar este usuario?")) {
            window.location.href = 'eliminar_vehiculo.php?id_vehiculo=' + id;
        }
    }
    </script>
</body>
</html>


sc