<?php
session_start(); // <- necesario para leer $_SESSION['error']
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"> 
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="login.css">
  <!-- SweetAlert2 (alertas bonitas) -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- FontAwesome para el ícono del ojo (si ya lo usas desde otro lado, puedes quitarlo) -->
  <script src="https://kit.fontawesome.com/a2d9d6b33a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="bg-company min-h-screen flex items-center justify-end p-4  background-position: 100px 10px; /* 100px desde la izquierda, 200px desde arriba */
">
    
  <!-- Elementos decorativos flotantes -->
  <div class="fixed top-10 left-10 w-20 h-20 bg-yellow-400 rounded-full opacity-20 floating-animation"></div>
  <div class="fixed top-1/3 right-20 w-16 h-16 bg-green-500 rounded-full opacity-20 floating-animation" style="animation-delay: -2s;"></div>
  <div class="fixed bottom-20 left-1/4 w-12 h-12 bg-yellow-300 rounded-full opacity-20 floating-animation" style="animation-delay: -4s;"></div>

  <!-- Contenedor principal -->
  <div class="glass-effect rounded-3xl shadow-2xl p-8 w-full max-w-md transform hover:scale-105 transition-all duration-300">
    
    <!-- Header con logo y título -->
    <div class="text-center mb-8">
      <div class="mx-auto w-20 h-20 bg-gradient-to-r from-green-500 to-yellow-400 rounded-full flex items-center justify-center mb-4 pulse-border border-4">
        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
        </svg>
      </div>
      <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-yellow-500 bg-clip-text text-transparent">
        Bienvenido
      </h1>
      <p class="text-gray-600 mt-2">Accede a tu cuenta para continuar</p>
    </div>

    <!-- Mensaje de error (si existe) - lo dejamos pero no obligatorio -->
    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg mb-6 hidden" id="error-message">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm text-red-700" id="error-text">Error en las credenciales</p>
        </div>
      </div>
    </div>

    <!-- Formulario -->
    <!-- Deja la action que ya usas; si usas validar.php cámbialo aquí -->
    <form action="verificar.php" method="POST" class="space-y-6">
      
      <!-- Campo Usuario -->
      <div class="relative">
        <label for="usuario" class="block text-sm font-semibold text-gray-700 mb-2">
          <span class="flex items-center">
            <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            Nombre de Usuario
          </span>
        </label>
        <input 
          type="text" 
          name="usuario" 
          id="usuario"
          placeholder="Ingresa tu nombre de usuario"
          class="input-glow w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-all duration-300 bg-white"
          required
        >
        <p class="text-xs text-gray-500 mt-1 ml-2">💡 Usa el usuario que te proporcionó el administrador</p>
      </div>

      <!-- Campo Contraseña -->
     <!-- Campo Contraseña -->
<div class="relative">
  <label for="clave" class="block text-sm font-semibold text-gray-700 mb-2">
    <span class="flex items-center">
      <svg class="w-4 h-4 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
      </svg>
      Contraseña
    </span>
  </label>

  <!-- Campo de entrada -->
  <div class="relative">
    <input 
      type="password" 
      name="clave" 
      id="clave"
      placeholder="Ingresa tu contraseña segura"
      class="input-glow w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-yellow-500 focus:outline-none transition-all duration-300 bg-white pr-12"
      required
    >
    
   
  </div>
  <button type="button" id="togglePassword"
            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-yellow-600 focus:outline-none">
      <i class="fas fa-eye" id="icono_ojo"></i>
    </button>

  <p class="text-xs text-gray-500 mt-1 ml-2">🔐 Mantén tu contraseña segura</p>
</div>


      <!-- Botón de acceso -->
      <div class="pt-4">
        <button 
          type="submit" 
          class="btn-gradient w-full text-white font-bold py-3 px-6 rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50"
        >
          <span class="flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l5-5z" clip-rule="evenodd" />
            </svg>
            INICIAR SESIÓN
          </span>
        </button>
      </div>
    </form>

    <!-- Información adicional -->
    <div class="mt-8 pt-6 border-t border-gray-200">
      <div class="text-center space-y-2">
        <p class="text-xs text-gray-500">
          ¿Olvidaste tu contraseña? 
          <a href="Recuperar/recuperar.php" class="text-green-600 hover:text-green-700 font-semibold">Recupera tu contraseña</a>
        </p>
        <div class="flex items-center justify-center space-x-2 text-xs text-gray-400">
          <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
          </svg>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Mostrar/ocultar contraseña + cambiar icono
    const toggle = document.getElementById('togglePassword');
  const input = document.getElementById('clave');
  const icon = document.getElementById('icono_ojo');

  toggle.addEventListener('click', function() {
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  });

    // Mostrar alerta con SweetAlert2 si hay error en sesión (desde PHP)
    document.addEventListener('DOMContentLoaded', function() {
      <?php if (!empty($_SESSION['error'])): 
          // usamos json_encode para escapar correctamente el texto dentro de JS
          $err = json_encode($_SESSION['error']);
      ?>
        Swal.fire({
          icon: 'error',
          title: 'Error de inicio de sesión',
          text: <?= $err ?>,
          confirmButtonText: 'OK'
        });
        <?php unset($_SESSION['error']); // evitamos que aparezca otra vez ?>
      <?php endif; ?>
    });

    // Efectos adicionales de interactividad (dejé tu código intacto)
    document.querySelectorAll('input').forEach(input => {
      input.addEventListener('focus', function() {
        this.parentNode.classList.add('transform', 'scale-105');
      });
      
      input.addEventListener('blur', function() {
        this.parentNode.classList.remove('transform', 'scale-105');
      });
    });



    

  </script>
</body>
</html>
