<?php 

include '../conexion.php';
include '../seguridad.php';


$registro_por_pagina = 5;
$pagina_actual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

$inicio = ($pagina_actual - 1) * $registro_por_pagina;

$sql = " SELECT u.id_reservacion, u.solicitante_nombre, u.solicitante_dui, solicitante_telefono, u.solicitante_correo, u.fecha_inicio_solicitada, u.fecha_fin_solicitada, u.dias_solicitados, u.documentosDui, u.licencia, u.observaciones, u.estado, CONCAT(t.marca, ' ', t.modelo) AS nombre_vehiculo
         From reservaciones u
         JOIN vehiculos t ON u.id_vehiculo = t.id_vehiculo
         ORDER BY U.id_reservacion DESC LIMIT $inicio, $registro_por_pagina";
$resultado = $conn->query($sql);

$total_resultado = $conn->query("SELECT COUNT(*) AS total FROM reservaciones");
$total_fila = $total_resultado->fetch_assoc();
$total_registros = $total_fila['total'];
$total_paginas = ceil($total_registros / $registro_por_pagina);

?> 

<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reservaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
      <div class="h-16 sm:h-20"></div>

    <div class="max-w-7xl mx-auto">
        <!-- Header mejorado -->
        <div class="bg-gradient-to-r from-gray-700 to-gray-700 rounded-lg shadow-lg p-6 mb-6 fade-in">
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

       <div class="mb-6 fade-in">
         <button type="button" onclick="abrirModal()" 
            class="inline-flex items-center px-6 py-3 bg-gradient-to-r rounded-lg shadow-lg bg-gradient-to-r from-gray-600 to-gray-600 ...">
            <i class="fas fa-check-circle"></i>
            Registrar una reserva
        </button>
      </div>



<!-- Modal Registrar Reserva (con scroll interno) -->
<div id="modalCliente" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 overflow-y-auto">
  <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl p-6 relative my-10 overflow-y-auto max-h-[90vh]">
    <button onclick="cerrarModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
      <i class="fas fa-times text-xl"></i>
    </button>
    
    <h2 class="text-xl font-bold mb-4 text-gray-700">
      <i class="fas fa-user-edit text-purple-600"></i> Nueva Reservación
    </h2>

    <form id="formCliente" method="POST" action="guardar_reserva_panel.php" class="space-y-4" enctype="multipart/form-data">
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          <i class="fas fa-car text-blue-600 mr-2"></i> Vehículo
        </label>
        <select name="id_vehiculo" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
          <option value="">Seleccione un vehículo</option>
          <?php
            $vehiculos = $conn->query("SELECT id_vehiculo, CONCAT(marca, ' ', modelo) AS nombre FROM vehiculos");
            while ($v = $vehiculos->fetch_assoc()):
          ?>
            <option value="<?= $v['id_vehiculo'] ?>"><?= htmlspecialchars($v['nombre']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          <i class="fas fa-user text-blue-600 mr-2"></i> Nombre completo
        </label>
        <input type="text" name="nombre_cliente" required
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          <i class="fas fa-id-card text-green-600 mr-2"></i> DUI
        </label>
        <input type="text" name="dui" required
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          <i class="fas fa-phone text-orange-600 mr-2"></i> Teléfono
        </label>
        <div class="flex items-center">
          <span class="text-gray-600 font-medium mr-2">+503</span>
          <input type="tel" name="telefono_cliente" id="telefono_cliente" maxlength="9" required
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"
                placeholder="1234-5678"
                oninput="formatearTelefono(this)">
        </div>
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          <i class="fas fa-envelope text-red-600 mr-2"></i> Correo electrónico
        </label>
        <input type="email" name="email_cliente" required
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
      </div>

      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-calendar-day text-green-600 mr-2"></i> Fecha de inicio
          </label>
          <input type="date" name="fecha_inicio" required
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-calendar-day text-red-600 mr-2"></i> Fecha de finalización
          </label>
          <input type="date" name="fecha_fin" required
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        </div>
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          <i class="fas fa-clock text-purple-600 mr-2"></i> Días solicitados
        </label>
        <input type="number" name="dias" required min="1"
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          <i class="fas fa-clock text-purple-600 mr-2"></i> Total a pagar
        </label>
        <input type="number" name="total_pagar" required min="1"
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Documento - DUI</label>
        <input type="file" name="fotos_dui" accept="image/*"
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        <small class="text-gray-500">Formatos aceptados: JPG, PNG, GIF (Max. 5MB)</small>
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Documento - Licencia</label>
        <input type="file" name="fotos_licencia" accept="image/*"
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
        <small class="text-gray-500">Formatos aceptados: JPG, PNG, GIF (Max. 5MB)</small>
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Observaciones</label>
        <textarea name="observaciones"
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500"></textarea>
        <small class="text-gray-500">Ejemplo: "Entregar en oficina central"</small>
      </div>

      <button type="submit"
        class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2 mt-6">
        <i class="fas fa-check-circle"></i> Guardar Reservación
      </button>
    </form>
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
                                <i class="fas fa-phone mr-2"></i>Tel
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
                                <i class="fas fa-clock mr-2"></i>Observaciones
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
                                    <div class="text-sm text-gray-600">+503 <?= $row['solicitante_telefono'] ?></div>
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
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600"><?= $row['observaciones'] ?></div>
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
                                        <a href="#"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white transition-all duration-200 hover:scale-110 shadow-sm" 
                                            title="Enviar Email"
                                            data-id="<?= $row['id_reservacion'] ?>"
                                            data-correo="<?= htmlspecialchars($row['solicitante_correo']) ?>"
                                            onclick="abrirModalCorreo(this)">
                                            <i class="fas fa-envelope text-sm"></i>
                                        </a>
                                        <a href="../Contratos/realizar_contrato.php?id_reservacion=<?= $row['id_reservacion'] ?>"
                                          class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-500 hover:bg-blue-600 text-white transition-all duration-200 hover:scale-110 shadow-sm"
                                          title="Realizar contrato">
                                          <i class="fas fa-pen-to-square text-sm"></i>
                                        </a>
                                        <a href="#"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-purple-500 hover:bg-purple-600 text-white transition-all duration-200 hover:scale-110 shadow-sm"
                                                title="Ver fotos"
                                                onclick="abrirModalFotos('<?= $row['documentosDui'] ?>', '<?= $row['licencia'] ?>')">
                                                <i class="fas fa-images text-sm"></i>
                                            </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex justify-center items-center mt-4 space-x-3">

 
  <a href="<?= ($pagina_actual > 1) ? '?pagina=' . ($pagina_actual - 1) : '#' ?>" 
     class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 
     <?= ($pagina_actual > 1) 
          ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' 
          : 'bg-gray-100 text-gray-400 cursor-not-allowed' ?>">
    <i class="fas fa-arrow-left"></i> Anterior
  </a>

  
  <a href="<?= ($pagina_actual < $total_paginas) ? '?pagina=' . ($pagina_actual + 1) : '#' ?>" 
     class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 
     <?= ($pagina_actual < $total_paginas) 
          ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' 
          : 'bg-gray-100 text-gray-400 cursor-not-allowed' ?>">
    Siguiente <i class="fas fa-arrow-right"></i>
  </a>
</div>


        <!-- Footer info -->
        <div class="mt-6 text-center text-gray-600 text-sm">
            <p><i class="fas fa-info-circle mr-2"></i>Última actualización: <?= date('d/m/Y H:i:s') ?></p>
        </div>
        </div>


 
    </div>
    
</div>
<!-- Modal Correo -->
<div id="modalCorreo" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl p-6">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-bold text-gray-800">Enviar correo al cliente</h2>
      <button onclick="cerrarModalCorreo()" class="text-gray-500 hover:text-gray-700">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <form method="POST" action="enviar_correo.php">
      <!-- Campo oculto para el correo -->
      <input type="hidden" name="correo" id="correoCliente">

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Mensaje</label>
        <textarea name="mensaje" rows="5" required
          class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-yellow-400"></textarea>
      </div>

      <div class="flex justify-end gap-2">
        <button type="button" onclick="cerrarModalCorreo()" 
          class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-800">Cancelar</button>
        <button type="submit" 
          class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white">Enviar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Ver Fotos -->
<div id="modalFotos" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
  <div class="bg-white w-full max-w-3xl rounded-2xl shadow-xl p-6 relative">
    <button onclick="cerrarModalFotos()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
      <i class="fas fa-times text-xl"></i>
    </button>
    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
      <i class="fas fa-images text-purple-500"></i> Fotos del Cliente
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="text-center">
        <h3 class="font-semibold text-gray-700 mb-2">DUI</h3>
        <img id="imgDUI" src="" alt="Foto DUI" class="w-full h-64 object-cover rounded-lg shadow-md border">
      </div>
      <div class="text-center">
        <h3 class="font-semibold text-gray-700 mb-2">Licencia</h3>
        <img id="imgLicencia" src="" alt="Foto Licencia" class="w-full h-64 object-cover rounded-lg shadow-md border">
      </div>
    </div>
  </div>


<script>
const params = new URLSearchParams(window.location.search);
if (params.get('reserva') === 'ok') {
  Swal.fire({
    icon: 'success',
    title: '¡Reserva registrada correctamente!',
    text: 'Tu reserva ha sido guardada con éxito. Nos pondremos en contacto contigo pronto.',
    confirmButtonColor: '#22c55e'
  });
} else if (params.get('reserva') === 'error') {
  Swal.fire({
    icon: 'error',
    title: 'Error al registrar la reserva',
    text: 'Ocurrió un problema al guardar la reserva. Intenta nuevamente más tarde.',
    confirmButtonColor: '#ef4444'
  });
}
</script>

<script>
  const menuBtn = document.getElementById('menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');

  menuBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });
</script>

<script>
const params = new URLSearchParams(window.location.search);
if (params.get('reserva') === 'ok') {
  Swal.fire({
    icon: 'success',
    title: '¡Reserva registrada correctamente!',
    text: 'Tu reserva ha sido guardada con éxito. Nos pondremos en contacto contigo pronto.',
    confirmButtonColor: '#22c55e'
  });
} else if (params.get('reserva') === 'error') {
  Swal.fire({
    icon: 'error',
    title: 'Error al registrar la reserva',
    text: 'Ocurrió un problema al guardar la reserva. Intenta nuevamente más tarde.',
    confirmButtonColor: '#ef4444'
  });
}


</script>

<script>
if (window.history.replaceState) {
  const url = new URL(window.location);
  url.search = ''; 
  window.history.replaceState({}, document.title, url);
}
</script>

<script>
  function abrirModalCorreo(element) {
    let correo = element.getAttribute("data-correo");
    document.getElementById("correoCliente").value = correo;
    document.getElementById("modalCorreo").classList.remove("hidden");
  }

  function cerrarModalCorreo() {
    document.getElementById("modalCorreo").classList.add("hidden");
  }
</script>

<script>
function abrirModalFotos(fotoDui, fotoLicencia) {
  const modal = document.getElementById("modalFotos");
  const imgDUI = document.getElementById("imgDUI");
  const imgLicencia = document.getElementById("imgLicencia");

  // Asumiendo que las imágenes están en la carpeta "uploads/"
  imgDUI.src = "../uploads/" + fotoDui;
  imgLicencia.src = "../uploads/" + fotoLicencia;

  modal.classList.remove("hidden");
}

function cerrarModalFotos() {
  document.getElementById("modalFotos").classList.add("hidden");
}
</script>


<script>
function abrirModal() {
  document.getElementById("modalCliente").classList.remove("hidden");
}

function cerrarModal() {
  document.getElementById("modalCliente").classList.add("hidden");
}

// Formatear teléfono automáticamente
function formatearTelefono(input) {
  let valor = input.value.replace(/\D/g, ''); // eliminar no números
  if (valor.length > 4) {
    input.value = valor.slice(0, 4) + '-' + valor.slice(4, 8);
  } else {
    input.value = valor;
  }
}
</script>


</body>
</html>