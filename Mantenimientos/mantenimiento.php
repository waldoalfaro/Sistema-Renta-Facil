<?php
include '../conexion.php';
include '../seguridad.php';


$sql = "SELECT id_vehiculo, modelo, placa FROM vehiculos WHERE estado = 'Mantenimiento'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Mantenimiento</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">

  <?php include '../menu.php'; ?>

  <div class="p-4 sm:ml-64">
    <div class="max-w-7xl mx-auto">
      <div class="bg-gradient-to-r from-yellow-600 to-yellow-800 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
              <i class="fas fa-calendar-check"></i>
              Gestión de Mantenimiento
            </h1>
            <p class="text-blue-100 mt-2">Administra y controla todos los mantenimientos de tus vehículos</p>
          </div>
        </div>
      </div>

      <!-- BOTÓN PARA MOSTRAR FORMULARIO -->
      <div class="mb-6">
        <button id="btnMostrarForm" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
          <i class="fa-solid fa-plus mr-2"></i>
          Agregar Nuevo Mantenimiento
        </button>
      </div>

      <!-- FORMULARIO OCULTO -->
      <div id="formContainer" class="hidden transition-all duration-500 ease-in-out">
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-yellow-200">
          <h5 class="text-xl font-bold mb-4 text-yellow-700 flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> Registrar Nuevo Mantenimiento
          </h5>

          <form action="ValidarVehiculo.php" method="POST" enctype="multipart/form-data" id="vehicleForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Vehículo</label>
                    <select name="id_vehiculo" class="form-select" required>
                        <option value="">Seleccione un vehículo...</option>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?= $row['id_vehiculo'] ?>">
                            <?= $row['modelo'] . " - " . $row['placa'] ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Tipo de daños</label>
                <input type="text" class="form-control" name="danios" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Fecha de último cambio de aceite</label>
                <input type="date" class="form-control" name="ultimo_aceite" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Próximo cambio de aceite en Kilometraje</label>
                <input type="text" class="form-control" name="proximo_aceite" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Observaciones de Daños</label>
                <textarea class="form-control" name="obs_danios"></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Observaciones de Reparaciones</label>
                <textarea class="form-control" name="obs_reparaciones"></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Reparado por</label>
                <input type="text" class="form-control" name="reparado_por" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-bold">Telefono</label>
                <input type="int" class="form-control" name="reparado_por" required>
              </div>
            </div>

            <div class="mt-4 text-center">
              <button type="submit" class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                <i class="fas fa-save"></i> Guardar Mantenimiento
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- LISTADO DE MANTENIMIENTOS -->
      <div class="container">
        <div class="content">
          <div class="search-bar mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="🔍 Buscar mantenimientos por modelo, año, o daño...">
          </div>

          <div class="vehicle-list bg-white rounded-lg p-4 shadow-md">
            <h2 class="text-lg font-bold mb-3 text-yellow-700">Lista de Mantenimientos</h2>
            <div id="vehicleContainer">
              <div class="empty-state text-center py-8 text-gray-500">
                <i class="fa-solid fa-clipboard-list text-5xl mb-3 text-yellow-400"></i>
                <h3 class="text-xl font-semibold">No hay mantenimientos registrados</h3>
                <p>Agrega tu primer mantenimiento usando el botón superior.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
  // Mostrar/Ocultar formulario
  document.getElementById('btnMostrarForm').addEventListener('click', function() {
    const form = document.getElementById('formContainer');
    form.classList.toggle('hidden');
    form.classList.toggle('animate-fadeIn');
  });
</script>

<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate-fadeIn {
    animation: fadeIn 0.4s ease-in-out;
  }
</style>

</body>
</html>
