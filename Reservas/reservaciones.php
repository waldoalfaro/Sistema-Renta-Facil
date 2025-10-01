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
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservar Vehículo - <?= htmlspecialchars($vehiculo['marca'] . ' ' . $vehiculo['modelo']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/es.global.min.js"></script>
  <link rel="stylesheet" href="reservas.css">
 
</head>
<body>
  <div class="container">
    <a href="../PaginaWeb.php" class="back-link">
      <span>⬅</span> Volver al catálogo
    </a>

    <h1>🚗 Reserva tu Vehículo Ideal</h1>

    <!-- Tarjeta de información del vehículo -->
    <div class="vehiculo-card">
      <div class="vehiculo-header">
        <div class="vehiculo-imagen-principal">
          <?php if (!empty($vehiculo['foto'])): ?>
            <img src="../FotosSubidas/<?= htmlspecialchars($vehiculo['foto']) ?>" 
                 alt="<?= htmlspecialchars($vehiculo['marca'] . ' ' . $vehiculo['modelo']) ?>">
          <?php else: ?>
            <div style="width:500px; height:350px; background:linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%); display:flex; align-items:center; justify-content:center; border-radius:15px; color:#9ca3af; font-size:80px;">
              🚗
            </div>
          <?php endif; ?>
        </div>

        <div class="vehiculo-detalles">
          <h2 class="vehiculo-titulo"><?= htmlspecialchars($vehiculo['marca'] . " " . $vehiculo['modelo']) ?></h2>
          
          <div class="vehiculo-specs">
            <div class="spec-item">
              <div class="spec-icon">📅</div>
              <div class="spec-info">
                <div class="spec-label">Año</div>
                <div class="spec-value"><?= htmlspecialchars($vehiculo['anio']) ?></div>
              </div>
            </div>

            <div class="spec-item">
              <div class="spec-icon">💰</div>
              <div class="spec-info">
                <div class="spec-label">Precio por día</div>
                <div class="spec-value">$<?= number_format($vehiculo['precio_dia'], 2) ?></div>
              </div>
            </div>

            <div class="spec-item">
              <div class="spec-icon">👥</div>
              <div class="spec-info">
                <div class="spec-label">Capacidad</div>
                <div class="spec-value"><?= number_format($vehiculo['asientos']) ?> asientos</div>
              </div>
            </div>

            <div class="spec-item">
              <div class="spec-icon">⭐</div>
              <div class="spec-info">
                <div class="spec-label">Estado</div>
                <div class="spec-value">Disponible</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Carrusel de fotos adicionales -->
    <?php if (!empty($fotos_adicionales)): ?>
    <div class="carrusel-section">
      <h3 class="carrusel-title">📸 Galería de Fotos</h3>
      <div class="carrusel-container">
        <div class="carrusel-wrapper" id="carruselWrapper">
          <?php foreach($fotos_adicionales as $i => $foto): ?>
            <div class="carrusel-slide">
              <img src="../FotosSubidas/<?= htmlspecialchars($foto) ?>" 
                   alt="Foto adicional <?= $i + 1 ?>">
            </div>
          <?php endforeach; ?>
        </div>
        
        <button class="carrusel-btn prev" onclick="cambiarSlide(-1)" aria-label="Anterior">‹</button>
        <button class="carrusel-btn next" onclick="cambiarSlide(1)" aria-label="Siguiente">›</button>
      </div>
      
      <div class="carrusel-indicadores" id="indicadores"></div>
    </div>
    <?php endif; ?>

    <!-- Calendario -->
    <div class="calendario-section">
      <h3 class="calendario-title">📅 Selecciona tus fechas</h3>
      <div id="calendar"></div>
    </div>

    <!-- Formulario de reserva -->
  <div class="formulario-reserva">
        
        <div class="form-group">
          <label>📆 Fecha de inicio:</label>
          <input type="text" id="fecha_inicio" name="fecha_inicio" readonly placeholder="Selecciona en el calendario">
        </div>

        <div class="form-group">
          <label>📆 Fecha de finalización:</label>
          <input type="text" id="fecha_fin" name="fecha_fin" readonly placeholder="Selecciona en el calendario">
        </div>

        <br>

        
    </div>
  </div>

 
          <button type="button" class="btn-reservar" onclick="abrirModal()">🎉 Confirmar Reserva</button>
      


 <div id="modalCliente" class="modal">
  <div class="modal-content">
    <span class="cerrar" onclick="cerrarModal()">&times;</span>
    <h2>📋 Datos del Cliente</h2>

    <form id="formCliente" method="POST" action="guardar_reserva.php">
      <input type="hidden" name="id_vehiculo" value="<?= $vehiculo['id_vehiculo'] ?>">
      <!-- inputs ocultos que realmente se envían -->
      <input type="hidden" name="fecha_inicio" id="modal_fecha_inicio">
      <input type="hidden" name="fecha_fin" id="modal_fecha_fin">

      <div class="form-group">
        <label>👤 Nombre completo:</label>
        <input type="text" name="nombre_cliente" required>
      </div>

      <div class="form-group">
        <label>🪪 DUI:</label>
        <input type="text" name="dui" required>
      </div>

      <div class="form-group">
        <label>📞 Teléfono:</label>
        <input type="tel" name="telefono_cliente" required>
      </div>

      <div class="form-group">
        <label>📧 Correo electrónico:</label>
        <input type="email" name="email_cliente" required>
      </div>

      <div class="form-group">
        <label>📆 Fecha de inicio:</label>
        <input type="text" id="modal_fecha_inicio_visible" readonly>
      </div>

      <div class="form-group">
        <label>📆 Fecha de finalización:</label>
        <input type="text" id="modal_fecha_fin_visible" readonly>
      </div>
      
      <div class="form-group">
        <label>📅 Días solicitados:</label>
        <input type="number" name="dias" required>
      </div>
      
      <br>
      <button type="submit" class="btn-reservar">✅ Confirmar Reserva</button>
    </form>
  </div>
</div>



<!-- JS Modal -->
<script>
function abrirModal() {
  // Pasar las fechas del formulario principal al modal
  const fechaInicio = document.getElementById('fecha_inicio').value;
  const fechaFin = document.getElementById('fecha_fin').value;

  document.getElementById('modal_fecha_inicio').value = fechaInicio;
  document.getElementById('modal_fecha_fin').value = fechaFin;
  document.getElementById('modal_fecha_inicio_visible').value = fechaInicio;
  document.getElementById('modal_fecha_fin_visible').value = fechaFin;

  document.getElementById("modalCliente").style.display = "flex";
}

function cerrarModal() {
  document.getElementById("modalCliente").style.display = "none";
}

// Cerrar modal si se hace clic fuera del contenido
window.onclick = function(event) {
  const modal = document.getElementById("modalCliente");
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

  <script>
    // Carrusel de imágenes
    let slideActual = 0;
    const totalSlides = <?= count($fotos_adicionales) ?>;

    function inicializarCarrusel() {
      // Crear indicadores
      const contenedorIndicadores = document.getElementById('indicadores');
      if (contenedorIndicadores) {
        for (let i = 0; i < totalSlides; i++) {
          const indicador = document.createElement('button');
          indicador.classList.add('indicador');
          if (i === 0) indicador.classList.add('active');
          indicador.onclick = () => irASlide(i);
          contenedorIndicadores.appendChild(indicador);
        }
      }
    }

    function cambiarSlide(direccion) {
      slideActual += direccion;
      
      if (slideActual < 0) {
        slideActual = totalSlides - 1;
      } else if (slideActual >= totalSlides) {
        slideActual = 0;
      }
      
      actualizarCarrusel();
    }

    function irASlide(index) {
      slideActual = index;
      actualizarCarrusel();
    }

    function actualizarCarrusel() {
      const wrapper = document.getElementById('carruselWrapper');
      if (wrapper) {
        wrapper.style.transform = `translateX(-${slideActual * 100}%)`;
      }
      
      // Actualizar indicadores
      const indicadores = document.querySelectorAll('.indicador');
      indicadores.forEach((ind, i) => {
        ind.classList.toggle('active', i === slideActual);
      });
    }

    // Soporte para swipe en móviles
    let touchStartX = 0;
    let touchEndX = 0;

    function handleSwipe() {
      if (touchEndX < touchStartX - 50) {
        cambiarSlide(1);
      }
      if (touchEndX > touchStartX + 50) {
        cambiarSlide(-1);
      }
    }

    const carruselContainer = document.querySelector('.carrusel-container');
    if (carruselContainer) {
      carruselContainer.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
      });

      carruselContainer.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
      });
    }

    // Calendario
    document.addEventListener('DOMContentLoaded', function() {
      inicializarCarrusel();
      
      let calendarEl = document.getElementById('calendar');
      let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        selectable: true,
        selectMirror: true,
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: ''
        },
        select: function(info) {
          document.getElementById('fecha_inicio').value = info.startStr;
          let endDate = new Date(info.end);
          endDate.setDate(endDate.getDate() - 1);
          document.getElementById('fecha_fin').value = endDate.toISOString().split('T')[0];
          
          // Efecto visual
          const inputs = document.querySelectorAll('#fecha_inicio, #fecha_fin');
          inputs.forEach(input => {
            input.style.borderColor = '#10b981';
            setTimeout(() => {
              input.style.borderColor = '#667eea';
            }, 500);
          });
        },
        height: 'auto',
        contentHeight: 'auto'
      });
      calendar.render();
    });
  </script>
</body>
</html>