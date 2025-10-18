<?php



$tipo = $_SESSION['tipo']; 

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>


    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
   <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
   <span class="sr-only">Open sidebar</span>
   <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
   <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
   </svg>
</button>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30"></div>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
   <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
      <a href="/Sistema-Renta-Facil/dashboard.php" class="flex items-center ps-2.5 mb-5">
         <img src="/Sistema-Renta-Facil/logo.png" class="h-6 me-3 sm:h-7" alt="Flowbite Logo" />
         <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Renta Facil</span>
      </a>
      <ul class="space-y-2 font-medium">
         <?php if ($tipo == 'Administrador'): ?>
         <li>
            <a href="/Sistema-Renta-Facil/Usuarios/Usuarios.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <i class="fa-solid fa-users"></i>
               <span class="flex-1 ms-3 whitespace-nowrap">Usuarios</span>
             </a>
         </li>
          <?php endif; ?>
         <li>
            <a href="/Sistema-Renta-Facil/Vehiculos/Vehiculos.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <i class="fa-solid fa-car-side"></i>
               <span class="flex-1 ms-3 whitespace-nowrap">Vehiculos</span>
            </a>
         </li>
          <li>
            <a href="/Sistema-Renta-Facil/Reservas/Reservas.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
              <i class="fa-solid fa-book-open"></i>
               <span class="flex-1 ms-3 whitespace-nowrap">Reservaciones</span>
            </a>
         </li>
       <li class="relative">
         <!-- Botón principal -->
         <button id="btn-categorias" type="button"
               class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
               aria-expanded="false" aria-controls="submenu-categorias">
               <!-- icono -->
              <i class="fa-solid fa-layer-group"></i>

               <span class="flex-1 ms-3 text-left whitespace-nowrap">Categorias</span>

               <!-- Flecha (se rotará) -->
               <svg id="arrow-categorias" class="w-3 h-3 transition-transform" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
               </svg>
         </button>

         <!-- Submenú (oculto por defecto) -->
         <ul id="submenu-categorias" class="hidden py-2 space-y-1 pl-6">
            <li>
               <a href="/Sistema-Renta-Facil/Categorias/Categoria_Vehiculo/categorias_vehiculos.php"
                  class="block p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                  Categorías de Vehículos
               </a>
            </li>
            <li>
               <a href="/Sistema-Renta-Facil/Categorias/categoria_Danos/Danos.php"
                  class="block p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                  Categorías de Daños
               </a>
            </li>
         </ul>
       </li>
       <li>
            <a href="/Sistema-Renta-Facil/Mantenimientos/mantenimiento.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <i class="fa-solid fa-screwdriver-wrench"></i>
               <span class="flex-1 ms-3 whitespace-nowrap">Mantenimientos</span>
            </a>
         </li>

      <li class="relative">
         <!-- Botón principal -->
         <button id="btn-Historial" type="button"
               class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
               aria-expanded="false" aria-controls="submenu-Historial">
               <!-- icono -->
              <i class="fa-solid fa-layer-group"></i>

               <span class="flex-1 ms-3 text-left whitespace-nowrap">Historial</span>

               <!-- Flecha (se rotará) -->
               <svg id="arrow-Historial" class="w-3 h-3 transition-transform" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
               </svg>
         </button>

         <!-- Submenú (oculto por defecto) -->
         <ul id="submenu-Historial" class="hidden py-2 space-y-1 pl-6">
            <li>
               <a href="/Sistema-Renta-Facil/Historial/Cambio_Aceite/historialaceite.php"
                  class="block p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                  Cambios de aceite
               </a>
            </li>
            
         </ul>
       </li>


       
        
         <li>
            <a href="#" id="logout-btn" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <i class="fa-solid fa-arrow-right-from-bracket"></i>
               <span class="flex-1 ms-3 whitespace-nowrap">Salir</span>
            </a>
         </li>

         <li>
            <a href="/Sistema-Renta-Facil/ayuda/Ayuda.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
              <i class="fa-solid fa-book-open"></i>
               <span class="flex-1 ms-3 whitespace-nowrap">Ayudas</span>
            </a>
         </li>

         <li>
            <a href="/Sistema-Renta-Facil/Creditos/creditos.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
              <i class="fa-solid fa-book-open"></i>
               <span class="flex-1 ms-3 whitespace-nowrap">Creditos</span>
            </a>
         </li>
         <li>
            
         </li>
      </ul>
   </div>
</aside>
<script src="/Sistema-Renta-Facil/scrip.js"></script>
<script>
  (function(){
    const btn = document.getElementById('btn-categorias');
    const submenu = document.getElementById('submenu-categorias');
    const arrow = document.getElementById('arrow-categorias');

    // Toggle al hacer click
    btn.addEventListener('click', function (e) {
      const isHidden = submenu.classList.toggle('hidden'); 
      btn.setAttribute('aria-expanded', String(!isHidden));
      arrow.classList.toggle('rotate-180'); 
    });

    const links = Array.from(submenu.querySelectorAll('a'));
    const currentPath = window.location.pathname; 
    let opened = false;
    for (const a of links) {
      if (currentPath.endsWith(a.getAttribute('href')) || currentPath === new URL(a.href, location.origin).pathname) {
        
        submenu.classList.remove('hidden');
        btn.setAttribute('aria-expanded', 'true');
        arrow.classList.add('rotate-180');
        a.classList.add('bg-gray-200', 'dark:bg-gray-700'); 
        opened = true;
        break;
      }
    }

  })();



  (function(){
    const btn = document.getElementById('btn-Historial');
    const submenu = document.getElementById('submenu-Historial');
    const arrow = document.getElementById('arrow-Historial');

    // Toggle al hacer click
    btn.addEventListener('click', function (e) {
      const isHidden = submenu.classList.toggle('hidden'); 
      btn.setAttribute('aria-expanded', String(!isHidden));
      arrow.classList.toggle('rotate-180'); 
    });

    const links = Array.from(submenu.querySelectorAll('a'));
    const currentPath = window.location.pathname; 
    let opened = false;
    for (const a of links) {
      if (currentPath.endsWith(a.getAttribute('href')) || currentPath === new URL(a.href, location.origin).pathname) {
        
        submenu.classList.remove('hidden');
        btn.setAttribute('aria-expanded', 'true');
        arrow.classList.add('rotate-180');
        a.classList.add('bg-gray-200', 'dark:bg-gray-700'); 
        opened = true;
        break;
      }
    }

  })();
</script>
</body>
</html>


<script>
document.getElementById('logout-btn').addEventListener('click', function(e) {
    e.preventDefault();
    
    alertify.confirm('Confirmar Cierre de Sesión', 
        '¿Estás seguro de que deseas cerrar sesión?', 
        function() {
            alertify.success('Cerrando sesión...');
            setTimeout(() => {
                window.location.href = '/Sistema-Renta-Facil/salir.php';
            }, 1000);
        }, 
        function() {
            alertify.error('Operación cancelada');
        }
    );
});
</script>