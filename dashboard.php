<?php
include 'seguridad.php';
include 'menu.php';
include 'conexion.php';

// Definir variable de usuario
$usuario = $_SESSION['usuario'] ?? "Invitado";

// Contadores de registros
$totalVehiculos = $conn->query("SELECT COUNT(*) AS total FROM vehiculos")->fetch_assoc()['total'] ?? 0;
$totalReservas = $conn->query("SELECT COUNT(*) AS total FROM reservaciones")->fetch_assoc()['total'] ?? 0;

// Sumamos los distintos mantenimientos (si existen las tablas)
$totalMantenimientos = 0;
$tablasMantenimiento = ['mantenimientos', 'cambio_bateria', 'cambio_llantas'];

foreach ($tablasMantenimiento as $tabla) {
    $resultado = $conn->query("SHOW TABLES LIKE '$tabla'");
    if ($resultado && $resultado->num_rows > 0) {
        $fila = $conn->query("SELECT COUNT(*) AS total FROM $tabla")->fetch_assoc();
        $totalMantenimientos += intval($fila['total']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


   

    <script>
        window.onload = function() {
            if (window.history && window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        };
    </script>




<style>
/* 🌐 En pantallas menores de 640px (modo móvil) */
@media (max-width: 640px) {
  #notifMenu {
    position: fixed !important;        /* ya no depende del botón */
    top: 30% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    width: 90% !important;
    max-height: 70vh !important;
    z-index: 9999 !important;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
  }
  #detalleReservacion {
  z-index: 10000 !important; /* más alto que el menú */
}
}
</style>

</head>
<body>


    <!-- 🔝 Barra superior -->
<nav class="fixed top-0 left-0 right-0 sm:left-64 bg-white border-b border-gray-200 shadow-md z-50">
  <div class="flex justify-between items-center px-4 sm:px-6 py-3">
    
    <!-- IZQUIERDA: Botón menú (solo visible en móviles) + Logo -->
    <div class="flex items-center gap-3">
      <!-- Botón hamburguesa -->
      <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
        aria-controls="logo-sidebar" type="button"
        class="inline-flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 sm:hidden">
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 
            0 010 1.5H2.75A.75.75 0 012 4.75zm0 
            10.5a.75.75 0 01.75-.75h7.5a.75.75 
            0 010 1.5h-7.5a.75.75 0 
            01-.75-.75zM2 10a.75.75 0 
            01.75-.75h14.5a.75.75 0 
            010 1.5H2.75A.75.75 0 
            012 10z"></path>
    </svg>
</button>

      <!-- Logo y título -->
      <img src="/Sistema-Renta-Facil/logo.png" alt="Logo" class="h-8 w-auto">
      <h1 class="hidden sm:block text-lg sm:text-xl font-bold text-gray-800">Panel de Control</h1>

    </div>

    

    <!-- DERECHA: Notificaciones y usuario -->
    <div class="flex items-center gap-4 sm:gap-6">
      <!-- Notificaciones -->

    <div class="relative inline-block">
  <button id="notifButton" class="text-gray-600 hover:text-yellow-600 focus:outline-none relative">
    <i class="fa-solid fa-bell text-xl"></i>
    <span id="notifCount"
      class="absolute -top-1 -right-2 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full hidden"></span>
  </button>

 
  <div id="notifMenu"
    class="hidden absolute right-0 z-50 mt-3 w-72 bg-white shadow-lg rounded-lg border border-gray-200">
    <div class="p-3 border-b font-semibold text-gray-700">Notificaciones</div>
    <ul id="notifList" class="max-h-60 overflow-y-auto"></ul>
  </div>


 
  <div id="detalleReservacion" 
     class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
  <div class="bg-white w-11/12 max-w-md rounded-lg shadow-lg p-4 overflow-y-auto max-h-[90vh]">
    <!-- Aquí se insertará el contenido desde JS -->
  </div>
</div>
</div>





      
      <!-- Usuario -->
      <div class="flex items-center gap-2 bg-gray-100 px-3 py-2 rounded-full">
        <i class="fa-solid fa-user text-gray-700"></i>
        <span class="text-sm font-medium text-gray-700 truncate max-w-[120px] sm:max-w-none">
          <?php echo htmlspecialchars($usuario); ?>
        </span>
      </div>
    </div>
  </div>
</nav>


<!-- Espacio para que no tape el contenido -->
<div class="h-16 sm:h-20"></div>

    
    <div class="pt-20 p-4 sm:ml-64 bg-gray-50 min-h-screen">
  <div class="max-w-7xl mx-auto">
    <!-- Título -->
    <div class="text-center mb-10">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">Sonsonate Renta Fácil</h1>
      <p class="text-gray-500 text-lg">Sistema de Gestión de Renta de Vehículos</p>
    </div>

    <!-- Grid de Tarjetas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      
      <!-- Vehículos -->
      <div onclick="window.location.href='Vehiculos/vehiculos.php'" 
           class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow cursor-pointer p-6 text-center">
        <img src="Logo.png" alt="Vehículos" class="mx-auto mb-4 w-16 h-16 object-contain">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Lista de Carros</h3>
        <p class="text-gray-500 text-sm mb-4">Gestiona el inventario completo de vehículos</p>
        <div class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm inline-flex items-center justify-center gap-1">
          <span>Total:</span> <strong><?php echo $totalVehiculos; ?></strong>
        </div>
      </div>

      <!-- Reservaciones -->
      <div onclick="window.location.href='Reservas/Reservas.php'"
           class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow cursor-pointer p-6 text-center">
        <div class="text-yellow-600 text-4xl mb-3">
          <i class="fa-solid fa-calendar-check"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Reservaciones</h3>
        <p class="text-gray-500 text-sm mb-4">Consulta y gestiona todas las reservaciones</p>
        <div class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm inline-flex items-center justify-center gap-1">
          <span>Total:</span> <strong><?php echo $totalReservas; ?></strong>
        </div>
      </div>

      <!-- Reportes -->
      <div onclick="window.location.href='reportes.php'"
           class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow cursor-pointer p-6 text-center">
        <div class="text-yellow-600 text-4xl mb-3">
          <i class="fa-solid fa-chart-line"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Reportes</h3>
        <p class="text-gray-500 text-sm mb-4">Genera reportes financieros y estadísticas</p>
        <div class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm inline-flex items-center justify-center gap-1">
          <i class="fas fa-file-chart-line"></i>
        </div>
      </div>

      <!-- Mantenimientos -->
      <div onclick="window.location.href='Mantenimientos/mantenimiento.php'"
           class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow cursor-pointer p-6 text-center">
        <div class="text-yellow-600 text-4xl mb-3">
          <i class="fa-solid fa-wrench"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-800 mb-2">Mantenimiento</h3>
        <p class="text-gray-500 text-sm mb-4">Control de mantenimiento de los vehículos</p>
        <div class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm inline-flex items-center justify-center gap-1">
          <span>Total:</span> <strong><?php echo $totalMantenimientos; ?></strong>
        </div>
      </div>

    </div>

    <!-- Sección de Gráficas -->
    <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Gráfica de Reservaciones -->
      

      <div class="bg-white rounded-2xl shadow-md p-6  h-[450px]">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">📄 Gráficas de estado</h2>
        <canvas id="graficaReservaciones" height="300" width="250"></canvas>
      </div>



    </div>

  </div>
  

</div>


<script src="/Sistema-Renta-Facil/abrimenu.js"></script>
    



<script>
document.addEventListener("DOMContentLoaded", () => {
  const notifButton = document.getElementById("notifButton");
  const notifMenu = document.getElementById("notifMenu");
  const notifCount = document.getElementById("notifCount");
  const notifList = document.getElementById("notifList");
  const detalleReservacion = document.getElementById("detalleReservacion");

 
  notifButton.addEventListener("click", (e) => {
    e.stopPropagation();
    notifMenu.classList.toggle("hidden");
    detalleReservacion.classList.add("hidden");
  });

  
  document.addEventListener("click", (e) => {
    if (!notifMenu.contains(e.target) && !notifButton.contains(e.target) && !detalleReservacion.contains(e.target)) {
      notifMenu.classList.add("hidden");
      detalleReservacion.classList.add("hidden");
    }
  });

  function cargarNotificaciones() {
    fetch("obtener_notificaciones.php")
      .then(res => res.json())
      .then(data => {
        notifList.innerHTML = "";
        let noLeidas = 0;

        if (data.length === 0) {
          notifList.innerHTML = `<li class="px-4 py-2 text-gray-500 text-sm">Sin notificaciones</li>`;
        } else {
          data.forEach(n => {
            if (n.leida == 0) noLeidas++;
            notifList.innerHTML += `
              <li data-id="${n.id}" class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm text-gray-700 border-b border-gray-100">
                <div>${n.mensaje}</div>
                <span class="text-xs text-gray-400">${n.fecha}</span>
              </li>`;
          });
        }

        notifCount.textContent = noLeidas > 0 ? noLeidas : "";
        notifCount.classList.toggle("hidden", noLeidas === 0);
      });
  }

  cargarNotificaciones();
  setInterval(cargarNotificaciones, 15000);

  notifList.addEventListener("click", (e) => {
    const item = e.target.closest("li[data-id]");
    if (!item) return;

    const id = item.dataset.id;

    fetch("marcar_leida.php?id=" + id)
      .then(() => cargarNotificaciones());


fetch("ver_notificacion.php?id=" + id)
  .then(res => {
    if (!res.ok) throw new Error("Respuesta HTTP " + res.status);
    return res.json();
  })
  .then(data => {
    console.log("ver_notificacion response:", data); 
    if (data.status === "ok") {
      const r = data.data;
      const modal = document.getElementById("detalleReservacion");
      const content = modal.querySelector("div");

      content.innerHTML = `
        <div class="p-5">
          <h2 class="text-lg font-bold text-gray-800 mb-3">Reservación #${r.id_reservacion}</h2>
          <p><strong>Vehículo:</strong> ${r.marca} ${r.modelo}</p>
          <p><strong>Cliente:</strong> ${r.solicitante_nombre}</p>
          <p><strong>DUI:</strong> ${r.solicitante_dui}</p>
          <p><strong>Teléfono:</strong> ${r.solicitante_telefono}</p>
          <p><strong>Correo:</strong> ${r.solicitante_correo ?? '—'}</p>
          <p><strong>Desde:</strong> ${r.fecha_inicio_solicitada}</p>
          <p><strong>Hasta:</strong> ${r.fecha_fin_solicitada}</p>
          <p><strong>Días:</strong> ${r.dias_solicitados}</p>
          <p><strong>Total a pagar:</strong> $${parseFloat(r.total_pagar).toFixed(2)}</p>

          <p><strong>Estado:</strong> 
            <span class="px-2 py-1 rounded text-white ${
              r.estado === 'pendiente' ? 'bg-yellow-500' :
              r.estado === 'aceptada' ? 'bg-green-600' : 'bg-red-600'
            }">${r.estado}</span>
          </p>
          <button id="cerrarDetalle" class="mt-4 bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700 w-full sm:w-auto">
            Cerrar
          </button>
        </div>
      `;

      modal.classList.remove("hidden");
      document.getElementById("cerrarDetalle").addEventListener("click", () => modal.classList.add("hidden"));
    } else {
      alert(data.message || "Error al obtener detalle");
    }
  })
  .catch(err => {
    console.error("Error fetch ver_notificacion:", err);
    alert("Error al cargar detalle. Revisa la consola (F12).");
  });

  });
});
</script>



</body>
</html>


<script>
fetch('Datos.php')
  .then(response => response.json())
  .then(data => {
    const ctx = document.getElementById('graficaReservaciones');
    new Chart(ctx, {
      type: 'pie', 
      data: {
        labels: data.labels,
        datasets: [{
          label: 'Reservaciones',
          data: data.data,
          backgroundColor: [
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(255, 99, 132, 0.7)'
          ],
          borderColor: '#fff',
          borderWidth: 1
        }]
      },
      options: {
        responsive: false,
        plugins: {
          legend: {
            position: 'bottom'
          },
          title: {
            display: true,
            text: 'Distribución de Reservaciones por Estado'
          }
        }
      }
    });
  });
</script>
