<?php
include 'conexion.php';


$sql = "SELECT * FROM vehiculos";
$resultado = $conn->query($sql)
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
  <link rel="stylesheet" href="pagina.css">

</head>

<body>
  <!-- Header con menú y logo -->
  <header class="header">
    <nav class="navbar">
      <div class="logo" style="display: flex; align-items: center;">
        <!-- Solo el logo en imagen -->
        <img src="logo1.jpg" alt="Logo de Renta Fácil" style="width: 120px; height: auto;">
      </div>

      <ul class="nav-menu">
        <li><a href="#inicio">Inicio</a></li>
        <li><a href="#vehiculos">Vehículos</a></li>
        <li><a href="#nosotros">Nosotros</a></li>
        <li><a href="#promociones">Promociones</a></li>
        <li><a href="#contacto">Contacto</a></li>
        <li><a href="login.php">Sistema Administrativo</a></li>
      </ul>
    </nav>
  </header>

  
  <!-- Sección de inicio -->
  <section id="inicio" class="hero">
    <div class="hero-content">
      <h1></h1>
      
      
    </div>
  </section> 




<section id="vehiculos" class="vehicles-section py-16 bg-black">
  <div class="container mx-auto px-4 max-w-7xl">
    <h2 class="text-4xl font-bold mb-16 text-center text-white">
      Nuestros Vehículos
    </h2>
    
    <div class="space-y-8">
      <?php 
      $counter = 0;
      while ($row = $resultado->fetch_assoc()): 
      ?>
      
      <!-- Tarjeta de Vehículo -->
      <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl overflow-hidden shadow-2xl hover:shadow-yellow-500/20 transition-all duration-300 border border-gray-700">
        <div class="flex flex-col md:flex-row">
          
          <!-- Información del Vehículo (Izquierda) -->
          <div class="w-full md:w-1/2 p-8 md:p-10 flex flex-col justify-between">
            <div>
              <div class="inline-block bg-yellow-500 text-black px-4 py-1 rounded-full text-sm font-bold mb-4">
                DISPONIBLE
              </div>
              
              <h3 class="text-3xl md:text-4xl font-bold text-white mb-4">
                <?= htmlspecialchars($row['marca'] . ' ' . $row['modelo']) ?>
              </h3>
              
              <div class="flex items-center gap-3 mb-6">
                <div class="bg-gray-700 px-4 py-2 rounded-lg">
                  <i class="fas fa-calendar-alt text-yellow-500 mr-2"></i>
                  <span class="text-white font-semibold">
                    Año <?= htmlspecialchars($row['anio']) ?>
                  </span>
                </div>
              </div>
              
              <p class="text-gray-300 text-lg mb-6 leading-relaxed">
                Haz clic en reservar para ver todos los detalles del vehículo y asegurar tu próxima aventura.
              </p>
            </div>
            
            <!-- Precio y Botón -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-6 pt-6 border-t border-gray-700">
              <div>
                <p class="text-gray-400 text-sm mb-1">Desde</p>
                <span class="text-3xl font-bold text-yellow-500">
                  $<?= number_format($row['precio_dia'], 2) ?>
                </span>
                <span class="text-gray-300 text-lg">/día</span>
              </div>
              
              <a href="Reservas/reservaciones.php?id=<?= $row['id_vehiculo'] ?>"
                 class="bg-yellow-500 text-black px-8 py-4 rounded-xl font-bold hover:bg-yellow-400 transition-all duration-300 w-full sm:w-auto text-center shadow-lg hover:shadow-yellow-500/50 transform hover:scale-105">
                <i class="fas fa-calendar-check mr-2"></i>
                Reservar Ahora
              </a>
            </div>
          </div>
          
          <!-- Imagen del Vehículo (Derecha) -->
          <div class="w-full md:w-1/2 h-72 md:h-96 relative">
            <?php if (!empty($row['foto'])): ?>
              <img src="FotosSubidas/<?= htmlspecialchars($row['foto']) ?>"
                   alt="<?= htmlspecialchars($row['marca'] . ' ' . $row['modelo']) ?>"
                   class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-gradient-to-l from-transparent to-gray-900/50"></div>
            <?php else: ?>
              <div class="flex items-center justify-center h-full bg-gray-700 text-gray-400">
                <i class="fas fa-car text-6xl"></i>
              </div>
            <?php endif; ?>
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
<section id="promociones-mes" class="py-16 bg-black">
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

    <?php
    // Conexión y consulta para obtener promociones activas
    // $query = "SELECT * FROM promociones WHERE activo = 1 AND fecha_fin >= CURDATE() ORDER BY fecha_inicio DESC";
    // $resultado_promo = $conn->query($query);
    
    // Si tienes promociones en la base de datos:
    if (isset($resultado_promo) && $resultado_promo->num_rows > 0):
    ?>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php while ($promo = $resultado_promo->fetch_assoc()): ?>
      
      <!-- Tarjeta de Promoción -->
      <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl overflow-hidden shadow-2xl hover:shadow-yellow-500/30 transition-all duration-300 border border-gray-700 hover:scale-105 transform">
        
        <!-- Imagen de la Promoción -->
        <div class="relative h-64 overflow-hidden bg-gray-700">
          <?php if (!empty($promo['imagen_promocion'])): ?>
            <img src="PromocionesSubidas/<?= htmlspecialchars($promo['imagen_promocion']) ?>" 
                 alt="<?= htmlspecialchars($promo['titulo']) ?>"
                 class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
          <?php else: ?>
            <div class="flex items-center justify-center h-full">
              <i class="fas fa-image text-gray-500 text-6xl"></i>
            </div>
          <?php endif; ?>
          
          <!-- Badge de Descuento -->
          <div class="absolute top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-full font-black text-xl shadow-lg transform rotate-12">
            -<?= htmlspecialchars($promo['descuento']) ?>%
          </div>
        </div>
        
        <!-- Contenido de la Promoción -->
        <div class="p-6">
          <h3 class="text-2xl font-bold text-white mb-3">
            <?= htmlspecialchars($promo['titulo']) ?>
          </h3>
          
          <p class="text-gray-300 mb-4 line-clamp-3">
            <?= htmlspecialchars($promo['descripcion']) ?>
          </p>
          
          <!-- Fecha de Vigencia -->
          <div class="flex items-center text-sm text-gray-400 mb-4">
            <i class="fas fa-calendar-alt text-yellow-500 mr-2"></i>
            Válido hasta: <?= date('d/m/Y', strtotime($promo['fecha_fin'])) ?>
          </div>
          
          <!-- Código Promocional -->
          <?php if (!empty($promo['codigo_promo'])): ?>
          <div class="bg-gray-700 px-4 py-2 rounded-lg mb-4 flex items-center justify-between">
            <span class="text-yellow-500 font-bold tracking-wider">
              <?= htmlspecialchars($promo['codigo_promo']) ?>
            </span>
            <button onclick="copyPromoCode('<?= htmlspecialchars($promo['codigo_promo']) ?>')" 
                    class="text-white hover:text-yellow-500 transition">
              <i class="fas fa-copy"></i>
            </button>
          </div>
          <?php endif; ?>
          
          <!-- Botón de Acción -->
          <a href="Reservas/reservaciones.php?promo=<?= $promo['id_promocion'] ?>" 
             class="block w-full bg-yellow-500 text-black text-center px-6 py-3 rounded-lg font-bold hover:bg-yellow-400 transition-all duration-300 shadow-lg">
            <i class="fas fa-tag mr-2"></i>
            Aplicar Promoción
          </a>
        </div>
      </div>
      
      <?php endwhile; ?>
    </div>
    
    <?php else: ?>
    
    <!-- Si no hay promociones activas o no tienes base de datos aún -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      
      <!-- Ejemplo de Promoción 1 -->
      <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl overflow-hidden shadow-2xl hover:shadow-yellow-500/30 transition-all duration-300 border border-gray-700 hover:scale-105 transform">
        <div class="relative h-64 overflow-hidden bg-gradient-to-br from-yellow-500 to-orange-600">
          <!-- Aquí va tu arte de promoción -->
          <div class="flex items-center justify-center h-full text-white p-6 text-center">
            <div>
              <i class="fas fa-car text-6xl mb-4"></i>
              <h3 class="text-3xl font-black mb-2">¡SÚPER OFERTA!</h3>
              <p class="text-xl">Renta por 7 días</p>
            </div>
          </div>
          <div class="absolute top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-full font-black text-xl shadow-lg transform rotate-12">
            -25%
          </div>
        </div>
        <div class="p-6">
          <h3 class="text-2xl font-bold text-white mb-3">
            Descuento Semanal
          </h3>
          <p class="text-gray-300 mb-4">
            Renta cualquier vehículo por 7 días y obtén 25% de descuento. ¡Ideal para tus viajes largos!
          </p>
          <div class="flex items-center text-sm text-gray-400 mb-4">
            <i class="fas fa-calendar-alt text-yellow-500 mr-2"></i>
            Válido todo el mes
          </div>
          <div class="bg-gray-700 px-4 py-2 rounded-lg mb-4 flex items-center justify-between">
            <span class="text-yellow-500 font-bold tracking-wider">SEMANAL25</span>
            <button onclick="copyPromoCode('SEMANAL25')" class="text-white hover:text-yellow-500 transition">
              <i class="fas fa-copy"></i>
            </button>
          </div>
          <a href="Reservas/reservaciones.php" class="block w-full bg-yellow-500 text-black text-center px-6 py-3 rounded-lg font-bold hover:bg-yellow-400 transition-all duration-300 shadow-lg">
            <i class="fas fa-tag mr-2"></i>
            Aplicar Promoción
          </a>
        </div>
      </div>
      
      <!-- Ejemplo de Promoción 2 -->
      <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl overflow-hidden shadow-2xl hover:shadow-yellow-500/30 transition-all duration-300 border border-gray-700 hover:scale-105 transform">
        <div class="relative h-64 overflow-hidden bg-gradient-to-br from-blue-600 to-purple-600">
          <div class="flex items-center justify-center h-full text-white p-6 text-center">
            <div>
              <i class="fas fa-gift text-6xl mb-4"></i>
              <h3 class="text-3xl font-black mb-2">CLIENTE NUEVO</h3>
              <p class="text-xl">Primera Renta</p>
            </div>
          </div>
          <div class="absolute top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-full font-black text-xl shadow-lg transform rotate-12">
            -15%
          </div>
        </div>
        <div class="p-6">
          <h3 class="text-2xl font-bold text-white mb-3">
            Bienvenida Especial
          </h3>
          <p class="text-gray-300 mb-4">
            ¿Primera vez con nosotros? Disfruta de 15% de descuento en tu primera renta. ¡Te esperamos!
          </p>
          <div class="flex items-center text-sm text-gray-400 mb-4">
            <i class="fas fa-calendar-alt text-yellow-500 mr-2"></i>
            Válido todo el mes
          </div>
          <div class="bg-gray-700 px-4 py-2 rounded-lg mb-4 flex items-center justify-between">
            <span class="text-yellow-500 font-bold tracking-wider">BIENVENIDO15</span>
            <button onclick="copyPromoCode('BIENVENIDO15')" class="text-white hover:text-yellow-500 transition">
              <i class="fas fa-copy"></i>
            </button>
          </div>
          <a href="Reservas/reservaciones.php" class="block w-full bg-yellow-500 text-black text-center px-6 py-3 rounded-lg font-bold hover:bg-yellow-400 transition-all duration-300 shadow-lg">
            <i class="fas fa-tag mr-2"></i>
            Aplicar Promoción
          </a>
        </div>
      </div>
      
      <!-- Ejemplo de Promoción 3 -->
      <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl overflow-hidden shadow-2xl hover:shadow-yellow-500/30 transition-all duration-300 border border-gray-700 hover:scale-105 transform">
        <div class="relative h-64 overflow-hidden bg-gradient-to-br from-green-600 to-teal-600">
          <div class="flex items-center justify-center h-full text-white p-6 text-center">
            <div>
              <i class="fas fa-users text-6xl mb-4"></i>
              <h3 class="text-3xl font-black mb-2">REFERIDOS</h3>
              <p class="text-xl">Comparte y Gana</p>
            </div>
          </div>
          <div class="absolute top-4 right-4 bg-red-600 text-white px-4 py-2 rounded-full font-black text-xl shadow-lg transform rotate-12">
            -20%
          </div>
        </div>
        <div class="p-6">
          <h3 class="text-2xl font-bold text-white mb-3">
            Programa de Referidos
          </h3>
          <p class="text-gray-300 mb-4">
            Refiere a un amigo y ambos obtienen 20% de descuento. ¡Mientras más compartes, más ahorras!
          </p>
          <div class="flex items-center text-sm text-gray-400 mb-4">
            <i class="fas fa-calendar-alt text-yellow-500 mr-2"></i>
            Promoción permanente
          </div>
          <div class="bg-gray-700 px-4 py-2 rounded-lg mb-4 flex items-center justify-between">
            <span class="text-yellow-500 font-bold tracking-wider">REFERIDO20</span>
            <button onclick="copyPromoCode('REFERIDO20')" class="text-white hover:text-yellow-500 transition">
              <i class="fas fa-copy"></i>
            </button>
          </div>
          <a href="Reservas/reservaciones.php" class="block w-full bg-yellow-500 text-black text-center px-6 py-3 rounded-lg font-bold hover:bg-yellow-400 transition-all duration-300 shadow-lg">
            <i class="fas fa-tag mr-2"></i>
            Aplicar Promoción
          </a>
        </div>
      </div>
      
    </div>
    
    <?php endif; ?>
    
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
  <footer class="footer">
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

  <script src="pagina.js"></script>
</body>

</html>