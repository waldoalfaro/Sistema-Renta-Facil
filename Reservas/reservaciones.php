<?php
include '../conexion.php';

// Obtenemos el vehículo seleccionado
$id = $_GET['id'] ?? null;
if (!$id) {
    die("Vehículo no seleccionado");
}

$sql = "SELECT * FROM vehiculos WHERE id_vehiculo = $id";
$result = $conn->query($sql);
$vehiculo = $result->fetch_assoc();

$fotos_adicionales = [];
$sqlFotos = "SELECT foto FROM vehiculos_fotos WHERE id_vehiculo = {$vehiculo['id_vehiculo']}";
$resultFotos = $conn->query($sqlFotos);
if ($resultFotos && $resultFotos->num_rows > 0) {
    while ($fila = $resultFotos->fetch_assoc()) {
        $fotos_adicionales[] = $fila['foto'];
    }
}

$reservas = [];
$reservassql = "SELECT fecha_inicio_solicitada, fecha_fin_solicitada FROM reservaciones WHERE id_vehiculo = $id AND estado='aceptada'";
$reserva = $conn->query($reservassql);
while ($fila = $reserva->fetch_assoc()) {
  $reservas [] = $fila;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservar Vehículo - <?= htmlspecialchars($vehiculo['marca'] . ' ' . $vehiculo['modelo']) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/es.global.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideIn {
      from { opacity: 0; transform: translateX(-20px); }
      to { opacity: 1; transform: translateX(0); }
    }
    .fade-in { animation: fadeIn 0.6s ease-out; }
    .slide-in { animation: slideIn 0.5s ease-out; }
    
    /* Galería de fotos mejorada */
    .imagen-principal {
      width: 100%;
      height: 400px;
      object-fit: cover;
      border-radius: 1rem;
      transition: all 0.3s ease;
    }
    
    .miniatura {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 0.5rem;
      cursor: pointer;
      transition: all 0.3s ease;
      border: 3px solid transparent;
    }
    
    .miniatura:hover {
      transform: scale(1.05);
      border-color: #7c3aed;
    }
    
    .miniatura.activa {
      border-color: #7c3aed;
      box-shadow: 0 0 0 2px rgba(124, 58, 237, 0.2);
    }
    
    @media (max-width: 640px) {
      .imagen-principal {
        height: 300px;
      }
      .miniatura {
        width: 60px;
        height: 60px;
      }
    }
    
    /* FullCalendar custom styles */
    .fc {
      border-radius: 1rem;
      overflow: hidden;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .fc-toolbar-title {
      font-size: 1.5rem !important;
      font-weight: 700 !important;
      color: #1f2937;
    }
    .fc-button {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
      border: none !important;
      border-radius: 0.5rem !important;
      font-weight: 600 !important;
      padding: 0.5rem 1rem !important;
    }
    .fc-button:hover {
      opacity: 0.9;
    }
    .fc-day-today {
      background: rgba(102, 126, 234, 0.1) !important;
    }
    .fc-daygrid-day:hover {
      background: rgba(102, 126, 234, 0.05);
      cursor: pointer;
    }
    
    /* Modal styles */ 
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(5px);
      align-items: center;
      justify-content: center;
    }
    .modal-content {
      background: white;
      padding: 2rem;
      border-radius: 1.5rem;
      width: 90%;
      max-width: 600px;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
      animation: fadeIn 0.3s ease-out;
    }
    .cerrar {
      color: #9ca3af;
      float: right;
      font-size: 2rem;
      font-weight: bold;
      cursor: pointer;
      transition: color 0.3s;
    }
    .cerrar:hover {
      color: #ef4444;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
  <div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Botón volver -->
    <a href="../PaginaWeb.php" class="inline-flex items-center gap-2 mb-6 px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-lg shadow-md transition-all duration-300 hover:shadow-lg hover:scale-105 slide-in">
      <i class="fas fa-arrow-left"></i>
      Volver al catálogo
    </a>

    <!-- Título principal -->
    <div class="text-center mb-8 fade-in">
      <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent mb-2">
        Reserva tu Vehículo Ideal
      </h1>
      <p class="text-gray-600 text-lg">Completa tu reserva en simples pasos</p>
    </div>

    <!-- Tarjeta de información del vehículo -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 fade-in">
      <div class="grid md:grid-cols-2 gap-6 p-6">
        <!-- Galería de imágenes mejorada -->
        <div class="space-y-4">
          <!-- Imagen principal -->
          <div class="relative group overflow-hidden rounded-xl shadow-lg">
            <?php 
            $foto_principal = !empty($vehiculo['foto']) ? $vehiculo['foto'] : null;
            ?>
            <img id="imagenPrincipal" 
                 src="../FotosSubidas/<?= htmlspecialchars($foto_principal) ?>" 
                 alt="<?= htmlspecialchars($vehiculo['marca'] . ' ' . $vehiculo['modelo']) ?>"
                 class="imagen-principal">
            
            <!-- Indicador de zoom -->
            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-2 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
              <i class="fas fa-search-plus text-purple-600"></i>
            </div>
          </div>
          
          <!-- Miniaturas -->
          <?php if (!empty($fotos_adicionales) || !empty($foto_principal)): ?>
          <div class="flex gap-2 overflow-x-auto pb-2">
            <!-- Miniatura de la foto principal -->
            <?php if (!empty($foto_principal)): ?>
            <img src="../FotosSubidas/<?= htmlspecialchars($foto_principal) ?>" 
                 alt="Principal" 
                 class="miniatura activa"
                 onclick="cambiarImagen(this, '../FotosSubidas/<?= htmlspecialchars($foto_principal) ?>')">
            <?php endif; ?>
            
            <!-- Miniaturas de fotos adicionales -->
            <?php foreach($fotos_adicionales as $foto): ?>
            <img src="../FotosSubidas/<?= htmlspecialchars($foto) ?>" 
                 alt="Foto adicional" 
                 class="miniatura"
                 onclick="cambiarImagen(this, '../FotosSubidas/<?= htmlspecialchars($foto) ?>')">
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
          
          <!-- Contador de fotos -->
          <div class="text-center text-sm text-gray-600">
            <i class="fas fa-images text-purple-600 mr-2"></i>
            <?= count($fotos_adicionales) + 1 ?> fotos disponibles
          </div>
        </div>

        <!-- Detalles del vehículo -->
        <div class="flex flex-col justify-center">
          <h2 class="text-3xl font-bold text-gray-800 mb-6">
            <?= htmlspecialchars($vehiculo['marca'] . " " . $vehiculo['modelo']) ?>
          </h2>
          
          <div class="grid grid-cols-2 gap-4">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl">
              <div class="flex items-center gap-3">
                <div class="bg-blue-500 text-white w-12 h-12 rounded-lg flex items-center justify-center">
                  <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                  <p class="text-xs text-gray-600 font-semibold">Año</p>
                  <p class="text-xl font-bold text-gray-800"><?= htmlspecialchars($vehiculo['anio']) ?></p>
                </div>
              </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl">
              <div class="flex items-center gap-3">
                <div class="bg-green-500 text-white w-12 h-12 rounded-lg flex items-center justify-center">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div>
                  <p class="text-xs text-gray-600 font-semibold">Precio por día</p>
                  <p class="text-xl font-bold text-gray-800">$<?= number_format($vehiculo['precio_dia'], 2) ?></p>
                </div>
              </div>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-xl">
              <div class="flex items-center gap-3">
                <div class="bg-purple-500 text-white w-12 h-12 rounded-lg flex items-center justify-center">
                  <i class="fas fa-users"></i>
                </div>
                <div>
                  <p class="text-xs text-gray-600 font-semibold">Capacidad</p>
                  <p class="text-xl font-bold text-gray-800"><?= number_format($vehiculo['asientos']) ?> asientos</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Calendario y formulario -->
    <div class="grid md:grid-cols-2 gap-8">
      <!-- Calendario -->
      <div class="bg-white rounded-2xl shadow-xl p-6 fade-in">
        <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
          <i class="fas fa-calendar-check text-purple-600"></i>
          Selecciona tus fechas
        </h3>
        <div id="calendar"></div>
      </div>

      <!-- Formulario de fechas -->
      <div class="bg-white rounded-2xl shadow-xl p-6 fade-in">
        <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
          <i class="fas fa-clipboard-list text-purple-600"></i>
          Resumen de Reserva
        </h3>
        <span>Toda la información es completamente confidencial, y solamente será utilizada con fines de realizar contrato.</span>
        
        <div class="space-y-4 mb-6 mt-4">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-calendar-day text-green-600 mr-2"></i>
              Fecha de inicio
            </label>
            <input type="text" id="fecha_inicio" readonly 
                   placeholder="Selecciona en el calendario"
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg bg-gray-50 text-gray-800 font-semibold focus:outline-none focus:border-purple-500 transition-colors">
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-calendar-day text-red-600 mr-2"></i>
              Fecha de finalización
            </label>
            <input type="text" id="fecha_fin" readonly 
                   placeholder="Selecciona en el calendario"
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg bg-gray-50 text-gray-800 font-semibold focus:outline-none focus:border-purple-500 transition-colors">
          </div>
        </div>

        <button type="button" onclick="abrirModal()" 
                class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2">
          <i class="fas fa-check-circle"></i>
          Confirmar Reserva
        </button>
      </div>
    </div>
  </div>

  <!-- Modal de datos del cliente -->
  <div id="modalCliente" class="modal">
    <div class="modal-content">
      <span class="cerrar" onclick="cerrarModal()">&times;</span>
      <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <i class="fas fa-user-edit text-purple-600"></i>
        Datos del Cliente
      </h2>

      <form id="formCliente" method="POST" action="guardar_reserva.php" class="space-y-4" enctype="multipart/form-data">
        <input type="hidden" name="id_vehiculo" value="<?= $vehiculo['id_vehiculo'] ?>">
        <input type="hidden" name="fecha_inicio" id="modal_fecha_inicio">
        <input type="hidden" name="fecha_fin" id="modal_fecha_fin">
        <input type="hidden" id="precio_por_dia" value="<?= $vehiculo['precio_dia'] ?>">
        <input type="hidden" id="total_pagar_hidden" name="total_pagar">

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-user text-blue-600 mr-2"></i>
            Nombre completo
          </label>
          <input type="text" name="nombre_cliente" required
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 transition-colors">
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-id-card text-green-600 mr-2"></i>
            DUI
          </label>
          <input type="text" name="dui" required
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 transition-colors">
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-phone text-orange-600 mr-2"></i> Teléfono
          </label>
          
          <div class="flex items-center">
            <span class="text-gray-600 font-medium mr-2">+503</span>
            <input 
              type="tel" 
              name="telefono_cliente" 
              id="telefono_cliente" 
              maxlength="9"
              required
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 transition-colors"
              placeholder="1234-5678"
              oninput="formatearTelefono(this)">
          </div>
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-envelope text-red-600 mr-2"></i>
            Correo electrónico
          </label>
          <input type="email" name="email_cliente" required
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 transition-colors">
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-calendar-day text-green-600 mr-2"></i>
            Fecha de inicio
          </label>
          <input type="text" id="modal_fecha_inicio_visible" readonly
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg bg-gray-50 text-gray-800 font-semibold">
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-calendar-day text-red-600 mr-2"></i>
            Fecha de finalización
          </label>
          <input type="text" id="modal_fecha_fin_visible" readonly
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg bg-gray-50 text-gray-800 font-semibold">
        </div>
        
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-clock text-purple-600 mr-2"></i>
            Días solicitados
          </label>
          <input type="number" id="dias" name="dias" readonly
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 transition-colors">
        </div>
        
        <div>
          <label class="block text-gray-700 font-semibold">Total a pagar</label>
          <input type="text" id="total_pagar" readonly class="border p-2 rounded w-full bg-green-100 font-bold text-green-700">
        </div>
        
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2"> 
            Documento - DUI
          </label>
          <input type="file" name="fotos_dui" accept="image/*" multiple
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 transition-colors">
          <small class="text-gray-500">Formatos aceptados: JPG, PNG, GIF (Max. 5MB)</small>
        </div>
        
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Documento - Licencia
          </label>
          <input type="file" name="fotos_licencia" accept="image/*" multiple
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 transition-colors">
          <small class="text-gray-500">Formatos aceptados: JPG, PNG, GIF (Max. 5MB)</small>
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Observaciones
          </label>
          <textarea name="observaciones" rows="3"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 transition-colors"></textarea>
          <small class="text-gray-500">Cuéntanos, ¿dónde quieres recibir tu vehículo o alguna duda que tengas?</small>
        </div>
        
        <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2 mt-6">
          <i class="fas fa-check-circle"></i>
          Confirmar Reserva
        </button>
      </form>
    </div>
  </div>

  <script>
    // Función para cambiar imagen principal
    function cambiarImagen(miniatura, rutaImagen) {
      // Cambiar la imagen principal
      document.getElementById('imagenPrincipal').src = rutaImagen;
      
      // Quitar clase activa de todas las miniaturas
      document.querySelectorAll('.miniatura').forEach(img => {
        img.classList.remove('activa');
      });
      
      // Agregar clase activa a la miniatura seleccionada
      miniatura.classList.add('activa');
    }

    // Formatear teléfono
    function formatearTelefono(input) {
      let valor = input.value.replace(/\D/g, '');
      valor = valor.substring(0, 8);
      if (valor.length > 4) {
        input.value = valor.substring(0, 4) + '-' + valor.substring(4);
      } else {
        input.value = valor;
      }
    }

    // Modal
    function abrirModal() {
      const fechaInicio = document.getElementById('fecha_inicio').value;
      const fechaFin = document.getElementById('fecha_fin').value;

      if (!fechaInicio || !fechaFin) {
        Swal.fire({
          icon: 'warning',
          title: 'Fechas incompletas',
          text: 'Por favor selecciona una fecha de inicio y una fecha de finalización antes de continuar.',
          confirmButtonColor: '#7c3aed',
        });
        return;
      }

      document.getElementById('modal_fecha_inicio').value = fechaInicio;
      document.getElementById('modal_fecha_fin').value = fechaFin;
      document.getElementById('modal_fecha_inicio_visible').value = fechaInicio;
      document.getElementById('modal_fecha_fin_visible').value = fechaFin;

      const inicio = new Date(fechaInicio);
      const fin = new Date(fechaFin);
      const diffTime = fin - inicio;
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

      document.querySelector('input[name="dias"]').value = diffDays;
      calcularDiasYTotal();
      document.getElementById("modalCliente").style.display = "flex";
    }

    function cerrarModal() {
      document.getElementById("modalCliente").style.display = "none";
    }

    document.getElementById('formCliente').addEventListener('submit', function (event) {
      event.preventDefault();
      Swal.fire({
        title: '¿Confirmar reserva?',
        text: 'Verifica que toda la información sea correcta antes de continuar.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#22c55e',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, registrar reserva',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submit();
        }
      });
    });

    window.onclick = function(event) {
      const modal = document.getElementById("modalCliente");
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    // Calendario
    document.addEventListener('DOMContentLoaded', function() {
      let calendarEl = document.getElementById('calendar');
      let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        selectable: true,
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: ''
        },
        events: [
          <?php foreach($reservas as $r): ?>
            {
              start: "<?= $r['fecha_inicio_solicitada'] ?>",
              end: "<?= date('Y-m-d', strtotime($r['fecha_fin_solicitada'] . ' +1 day')) ?>", 
              display: 'background',
              color: '#ff0303ff'
            },
          <?php endforeach; ?>
        ],
        select: function(info) {
          document.getElementById('fecha_inicio').value = info.startStr;
          let endDate = new Date(info.end);
          endDate.setDate(endDate.getDate() - 1);
          document.getElementById('fecha_fin').value = endDate.toISOString().split('T')[0];
        }
      });
      calendar.render();
    });

    // Calcular días y total
    function calcularDiasYTotal() {
      const fechaInicio = new Date(document.getElementById('modal_fecha_inicio_visible').value);
      const fechaFin = new Date(document.getElementById('modal_fecha_fin_visible').value);
      const precioDia = parseFloat(document.getElementById('precio_por_dia').value);

      if (!isNaN(fechaInicio) && !isNaN(fechaFin) && fechaFin >= fechaInicio) {
        const diffTime = Math.abs(fechaFin - fechaInicio);
        const dias = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        document.getElementById('dias').value = dias;

        const total = dias * precioDia;
        document.getElementById('total_pagar').value = `$ ${total.toFixed(2)}`;
        document.getElementById('total_pagar_hidden').value = total.toFixed(2);
      } else {
        document.getElementById('dias').value = '';
        document.getElementById('total_pagar').value = '';
        document.getElementById('total_pagar_hidden').value = '';
      }
    }

    document.getElementById('modal_fecha_inicio_visible').addEventListener('change', calcularDiasYTotal);
    document.getElementById('modal_fecha_fin_visible').addEventListener('change', calcularDiasYTotal);
  </script>
</body>
</html>