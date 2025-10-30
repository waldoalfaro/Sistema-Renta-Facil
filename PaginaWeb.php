<?php
include 'conexion.php';


$sql = "SELECT * FROM vehiculos";
$resultado = $conn->query($sql);


$sqlpromociones = "SELECT * FROM promociones";
$resultadopromociones = $conn->query($sqlpromociones);  

$logoData = $conn->query("SELECT ruta_imagen FROM configuracion_web WHERE tipo='logo'")->fetch_assoc();
$logo = $logoData ? $logoData['ruta_imagen'] : 'Logo.png';

$portadaData = $conn->query("SELECT ruta_imagen FROM configuracion_web WHERE tipo='portada'")->fetch_assoc();
$portada = $portadaData ? $portadaData['ruta_imagen'] : 'portada.jpg';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Renta Fácil</title>
    <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="pagina.css">

</head>

<body>
  <!-- Header con menú y logo -->
  <header class="header">
    <nav class="navbar">
      <div class="logo" style="display: flex; align-items: center;">
        <!-- Solo el logo en imagen -->
          <img src="<?php echo $logo; ?>" alt="Logo" style="width: 120px; height: auto;">

      </div>

      <button id="menu-btn" class="block md:hidden text-white focus:outline-none">
        <i class="fas fa-bars text-2xl"></i>
      </button>

      <ul class="nav-menu">
        <li><a href="#inicio">Inicio</a></li>
        <li><a href="#vehiculos">Vehículos</a></li>
        <li><a href="#nosotros">Nosotros</a></li>
        <li><a href="#promociones">Promociones</a></li>
        <li><a href="#contacto">Contacto</a></li>
        <li><a href="login.php">Sistema Administrativo</a></li>
      </ul>
    </nav>


    <ul id="mobile-menu" class="md:hidden hidden bg-black text-white text-center space-y-4 py-4">
      <li><a href="#inicio" class="block hover:text-yellow-500 transition">Inicio</a></li>
      <li><a href="#vehiculos" class="block hover:text-yellow-500 transition">Vehículos</a></li>
      <li><a href="#nosotros" class="block hover:text-yellow-500 transition">Nosotros</a></li>
      <li><a href="#promociones" class="block hover:text-yellow-500 transition">Promociones</a></li>
      <li><a href="#contacto" class="block hover:text-yellow-500 transition">Contacto</a></li>
      <li><a href="login.php" class="block hover:text-yellow-500 transition">Sistema Administrativo</a></li>
    </ul>
  </header>

  
  <!-- Sección de inicio -->
  <section id="inicio" class="hero" style="background-image: url('<?php echo $portada; ?>');"></section>
    <div class="hero-content">
      
      
    </div> 
  </section> 



<section id="vehiculos" class="vehicles-section py-12 bg-black">
  <div class="container mx-auto px-4 max-w-7xl">
    <h2 class="text-3xl font-bold mb-12 text-center text-white">
      Nuestros Vehículos
    </h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php 
      $counter = 0;
      while ($row = $resultado->fetch_assoc()): 
      ?>
      
      <!-- Tarjeta de Vehículo -->
      <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl overflow-hidden shadow-xl hover:shadow-yellow-500/30 transition-all duration-300 border border-gray-700 hover:border-yellow-500/50 transform hover:-translate-y-1">
        
        <!-- Imagen del Vehículo -->
        <div class="relative h-48 overflow-hidden">
          <?php if (!empty($row['foto'])): ?>
            <img src="FotosSubidas/<?= htmlspecialchars($row['foto']) ?>"
                 alt="<?= htmlspecialchars($row['marca'] . ' ' . $row['modelo']) ?>"
                 class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
          <?php else: ?>
            <div class="flex items-center justify-center h-full bg-gray-700 text-gray-400">
              <i class="fas fa-car text-5xl"></i>
            </div>
          <?php endif; ?>
          
          <!-- Badge de disponibilidad -->
          <div class="absolute top-3 right-3">
            <span class="bg-yellow-500 text-black px-3 py-1 rounded-full text-xs font-bold shadow-lg">
              DISPONIBLE
            </span>
          </div>
        </div>
        
        <!-- Contenido de la Tarjeta -->
        <div class="p-5">
          <!-- Título y Año -->
          <div class="mb-4">
            <h3 class="text-xl font-bold text-white mb-2 line-clamp-1">
              <?= htmlspecialchars($row['marca'] . ' ' . $row['modelo']) ?>
            </h3>
            
            <div class="inline-flex items-center bg-gray-700/50 px-3 py-1 rounded-lg">
              <i class="fas fa-calendar-alt text-yellow-500 text-sm mr-2"></i>
              <span class="text-white text-sm font-medium">
                <?= htmlspecialchars($row['anio']) ?>
              </span>
            </div>
          </div>
          
          <!-- Descripción compacta -->
          <p class="text-gray-400 text-sm mb-4 line-clamp-2">
            Vehículo en excelente estado, perfecto para tu próxima aventura.
          </p>
          
          <!-- Precio y Botón -->
          <div class="flex items-center justify-between pt-4 border-t border-gray-700">
            <div>
              <p class="text-gray-500 text-xs mb-0.5">Desde</p>
              <div class="flex items-baseline gap-1">
                <span class="text-2xl font-bold text-yellow-500">
                  $<?= number_format($row['precio_dia'], 2) ?>
                </span>
                <span class="text-gray-400 text-sm">/día</span>
              </div>
            </div>
            
            <a href="Reservas/reservaciones.php?id=<?= $row['id_vehiculo'] ?>"
               class="bg-yellow-500 text-black px-5 py-2.5 rounded-lg font-bold text-sm hover:bg-yellow-400 transition-all duration-300 shadow-md hover:shadow-yellow-500/50 transform hover:scale-105 inline-flex items-center gap-2">
              <i class="fas fa-calendar-check text-sm"></i>
              Reservar
            </a>
          </div>
        </div>
        
      </div>
      
      <?php 
      $counter++;
      endwhile; 
      ?>
    </div>
  </div>



  <!-- Mensaje Final -->
  <div class="flex items-center justify-center mt-16">
    <div class="text-center bg-gray-900 px-8 py-4 rounded-full border border-yellow-500/30">
      <p class="text-yellow-500 font-semibold text-lg">
        <i class="fas fa-star mr-2"></i>
        ¡Reserva tu vehículo para tu mejor plan!
        <i class="fas fa-star ml-2"></i>
      </p>
    </div>
  </div>
</section>
  
  

  <!-- area de promociones -->
<section id="promociones" class="py-16 bg-black">
  <div class="container mx-auto px-4 max-w-7xl">
    
    <!-- Encabezado de la Sección -->
    <div class="text-center mb-12">
      <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
        <i class="fas fa-percentage text-yellow-500 mr-3"></i>
        Promociones del Mes
      </h2>
      <p class="text-gray-400 text-xl">
        Sonsonate Renta Fácil - Ofertas Especiales
      </p>
    </div>





<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
  <?php while ($row = $resultadopromociones->fetch_assoc()): ?>
    <div class="relative bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-transform duration-300">
      
      <?php if (!empty($row['imagen'])): ?>
        <div class="overflow-hidden">
          <img src="uploads/configuracion/<?= htmlspecialchars($row['imagen']) ?>" 
               alt="Promoción"
               class="w-full h-auto object-contain transition-transform duration-500 hover:scale-105">
        </div>
      <?php else: ?>
        <div class="flex items-center justify-center bg-gray-100 text-gray-400 py-10">
          <i class="fas fa-image text-5xl"></i>
        </div>
      <?php endif; ?>

      <div class="p-4 bg-gray-800">
        <h3 class="text-white font-semibold text-lg mb-3 text-center">
          <?= htmlspecialchars($row['descripcion']) ?>
        </h3>
        <div class="flex justify-center">
          <a href="#" 
             class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-all duration-200">
            Más Información
            <i class="fa-brands fa-whatsapp ml-2"></i>
          </a>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>






  
      
      
    
   
    <!-- Mensaje Final -->
    <div class="flex items-center justify-center mt-16">
      <div class="text-center bg-gray-900 px-8 py-4 rounded-full border border-yellow-500/30">
        <p class="text-yellow-500 font-semibold text-lg">
          <i class="fas fa-star mr-2"></i>
          ¡Aprovecha nuestras promociones exclusivas en Sonsonate Renta Fácil!
          <i class="fas fa-star ml-2"></i>
        </p>
      </div>
    </div>
    
  </div>
</section>


<!-- Área de Videos -->
<section class="bg-[#111] text-white py-16 px-4 text-center">
  <h2 class="text-3xl font-bold text-[#D4A574] mb-12">Nuestros Productos en Video</h2>

  <!-- Video 1 -->
  <div class="flex flex-col md:flex-row items-center justify-center gap-10 mb-16 max-w-6xl mx-auto">
    <!-- Video -->
    <div class="w-full md:w-1/2 flex justify-center">
      <video
        class="rounded-2xl shadow-xl w-[560px] h-[315px] max-w-full object-cover"
        controls>
        <source src="videos/video1.mp4" type="video/mp4">
        Tu navegador no soporta videos HTML5.
      </video>
    </div>
    <!-- Texto -->
    <div class="w-full md:w-1/2 text-left md:text-left text-center md:text-start max-w-md">
      <h3 class="text-2xl font-semibold text-[#D4A574] mb-3">Presentación de la empresa</h3>
      <p class="text-gray-300 leading-relaxed">
        Conoce nuestra historia, valores y el amor que ponemos en cada taza de café que preparamos para ti.
      </p>
    </div>
  </div>

  <!-- Video 2 (Invertido) -->
  <div class="flex flex-col md:flex-row-reverse items-center justify-center gap-10 mb-16 max-w-6xl mx-auto">
    <!-- Video -->
    <div class="w-full md:w-1/2 flex justify-center">
      <video
        class="rounded-2xl shadow-xl w-[560px] h-[315px] max-w-full object-cover"
        controls>
        <source src="videos/video2.mp4" type="video/mp4">
        Tu navegador no soporta videos HTML5.
      </video>
    </div>
    <!-- Texto -->
    <div class="w-full md:w-1/2 text-left md:text-left text-center md:text-start max-w-md">
      <h3 class="text-2xl font-semibold text-[#D4A574] mb-3">Producción y procesos</h3>
      <p class="text-gray-300 leading-relaxed">
        Descubre cómo seleccionamos los mejores granos y los procesos artesanales que hacen único nuestro café.
      </p>
    </div>
  </div>

  <!-- Video 3 -->
  <div class="flex flex-col md:flex-row items-center justify-center gap-10 max-w-6xl mx-auto">
    <!-- Video -->
    <div class="w-full md:w-1/2 flex justify-center">
      <video
        class="rounded-2xl shadow-xl w-[560px] h-[315px] max-w-full object-cover"
        controls>
        <source src="videos/video3.mp4" type="video/mp4">
        Tu navegador no soporta videos HTML5.
      </video>
    </div>
    <!-- Texto -->
    <div class="w-full md:w-1/2 text-left md:text-left text-center md:text-start max-w-md">
      <h3 class="text-2xl font-semibold text-[#D4A574] mb-3">Testimonios de clientes</h3>
      <p class="text-gray-300 leading-relaxed">
        Escucha las experiencias de nuestros clientes satisfechos y forma parte de nuestra comunidad cafetera.
      </p>
    </div>
  </div>
</section>


  <!-- Sección Nosotros (Misión, Visión, Valores) -->
  <section id="nosotros" class="about-section">
    <div class="container">
      <h2>Nosotros</h2>
      <div class="about-grid">
        <div class="about-card">
          <div class="icon">
            <i class="fas fa-bullseye"></i>
          </div>
          <h3>Misión</h3>
          <p>Brindar servicios de renta de vehículos de alta calidad, seguros y confiables, facilitando la movilidad de
            nuestros clientes con la mejor experiencia al precio más justo del mercado.</p>
        </div>
        <div class="about-card">
          <div class="icon">
            <i class="fas fa-eye"></i>
          </div>
          <h3>Visión</h3>
          <p>Ser la empresa líder en renta de vehículos en la región, reconocida por la excelencia en el servicio,
            innovación tecnológica y compromiso con la satisfacción del cliente.</p>
        </div>
        <div class="about-card">
          <div class="icon">
            <i class="fas fa-heart"></i>
          </div>
          <h3>Valores</h3>
          <p>Honestidad, responsabilidad, excelencia en el servicio, respeto al cliente, innovación constante y
            compromiso con la seguridad vial.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer id="contacto" class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-section">
          <h3>Renta Fácil</h3>
          <p>Tu mejor opción para rentar vehículos</p>
          <div class="social-links">
            <a href="https://www.facebook.com/share/163KWLk3vq/" target="_blank">
              <i class="fab fa-facebook"></i>
            </a>
            <a href="https://www.instagram.com/sonsorentafacil?igsh=YTlwbXlqN212Znhy" target="_blank">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="https://wa.me/50378678421?text=Hola%20quiero%20información%20sobre%20renta%20de%20vehículos"
              target="_blank">
              <i class="fab fa-whatsapp"></i>
            </a>
          </div>

        </div>
        <div class="footer-section">
          <h4>Contacto</h4>
          <p><i class="fas fa-phone"></i> +503 7867-8421</p>
          <p><i class="fas fa-envelope"></i> info@rentafacil.com</p>
          <p><i class="fas fa-map-marker-alt"></i>6 Av Norte , Sonsonate, Sonsonate, El Salvador
          </p>
        </div>
        <div class="footer-section">
          <h4>Horarios</h4>
          <p>Lunes a Domingo </p>
          <p>Atención a toda hora</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 Renta Fácil. Todos los derechos reservados.</p>
      </div>
    </div>
  </footer>




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

</body>

</html>

