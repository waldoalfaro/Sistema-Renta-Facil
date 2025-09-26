<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Renta Fácil</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
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
        <img src="foto/logo1.jpg" alt="Logo de Renta Fácil" style="width: 120px; height: auto;">
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
      
      <button class="btn-primary">Ver Vehículos</button>
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
            <!--<a href="https://twitter.com/rentafacilsv" target="_blank">
    <i class="fab fa-twitter"></i>
  </a> -->
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
          <p>24/7</p>
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