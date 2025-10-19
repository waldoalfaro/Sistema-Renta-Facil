<?php include '../seguridad.php';  ?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="styles1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
</head>

<body>

<?php include "../menu.php";?>

<div class="p-4 sm:ml-64">
     <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1>Centro de Ayuda y Recursos</h1>
                </div>
                <nav class="nav">
                    <a href="#manuales" class="nav-link">Manuales</a>
                    <a href="#videos" class="nav-link">Videos Tutoriales</a>
                </nav>
            </div>
        </div>
    </header>


    <section class="credits-section">
        <div class="container">
            <div class="section-header">
                <h2 class="subtitle">Derechos y Créditos del Equipo</h2>
                <p class="description">Conoce al equipo de profesionales que hicieron posible este sistema</p>
            </div>

            <div class="team-grid">
                <!-- Integrante 1 - Scrum Master -->
                <div class="team-card">
                    <div class="card-image">
                        <img src=""
                            alt="Foto de perfil de Nelson Stanley Venis Moran, Scrum Master del equipo Sistema-Renta-Fácil">
                        <div class="card-overlay">
                            <div class="social-links">
                                <a href="mailto:nvenimoran@gmail.com" title="Enviar email a Nelson Moran"
                                    aria-label="Enviar email a Nelson Moran"><i class="fas fa-envelope"
                                        aria-hidden="true"></i></a>
                                <a href="#"
                                    onclick="alert('Actualiza este enlace con el perfil real de GitHub'); return false;"
                                    title="Ver perfil de GitHub de Nelson Moran"
                                    aria-label="Ver perfil de GitHub"><i class="fab fa-github"
                                        aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3 class="member-name">Nelson Stanley Venis</h3>
                        <p class="member-role">Scrum Master</p>
                        <div class="member-info">
                            <p><i class="fas fa-briefcase" aria-hidden="true"></i> Líder del equipo</p>
                            <p><i class="fas fa-envelope" aria-hidden="true"></i> <a
                                    href="mailto:nvenimoran@gmail.com">nvenimora@gmail.com</a></p>
                            <p><i class="fas fa-phone" aria-hidden="true"></i> <a href="tel:+521234567890">+52 123 456
                                    7890</a></p>
                        </div>
                        <p class="member-description">Responsable de facilitar el proceso Scrum y remover impedimentos
                            del equipo.</p>
                    </div>
                </div>

                <!-- Integrante 2 - Product Owner -->
                <div class="team-card">
                    <div class="card-image">
                        <img src="images/majano.jpg"
                            alt="Foto de perfil de José Elias Majano Lovato, Team Scrum Sistema-Renta-Fácil">
                        <div class="card-overlay">
                            <div class="social-links">
                                <a href="mailto:joselovato020@gmail.com.com" title="Enviar email a María José Lovato"
                                    aria-label="Enviar email a José Lovato"><i class="fas fa-envelope"
                                        aria-hidden="true"></i></a>
                               
                                <a href="#"
                                    onclick="alert('Actualiza este enlace con el perfil real de GitHub'); return false;"
                                    title="Ver perfil de GitHub de José Lovato"
                                    aria-label="Ver perfil de GitHub"><i class="fab fa-github"
                                        aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3 class="member-name">José Elias Majano</h3>
                        <p class="member-role">Team Scrum</p>
                        <div class="member-info">
                            <p><i class="fas fa-briefcase" aria-hidden="true"></i> Visión del producto</p>
                            <p><i class="fas fa-envelope" aria-hidden="true"></i> <a
                                    href="mailto:productowner@ejemplo.com">Joselovato020@gmail.com</a></p>
                            <p><i class="fas fa-phone" aria-hidden="true"></i> <a href="tel:+521234567891">+52 123 456
                                    7891</a></p>
                        </div>
                        <p class="member-description">Define la visión del producto y prioriza las funcionalidades del
                            sistema.</p>
                    </div>
                </div>

                

                <!-- Integrante 4 - Developer -->
                <div class="team-card">
                    <div class="card-image">
                        <img src=""
                            alt="Foto de perfil de Jose Oswaldo Alfaro Morales, Desarrollador del equipo Sistema-Renta-Fácil">
                        <div class="card-overlay">
                            <div class="social-links">
                                <a href="mailto:backend@ejemplo.com" title="Enviar email a Oswaldo Alfaro"
                                    aria-label="Enviar email a Oswaldo Alfaro"><i class="fas fa-envelope"
                                        aria-hidden="true"></i></a>
                                
                                <a href="#"
                                    onclick="alert('Actualiza este enlace con el perfil real de GitHub'); return false;"
                                    title="Ver perfil de GitHub de Oswaldo Alfaro"
                                    aria-label="Ver perfil de GitHub"><i class="fab fa-github"
                                        aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3 class="member-name">José Oswaldo Alfaro</h3>
                        <p class="member-role">Team Scrum</p>
                        <div class="member-info">
                            <p><i class="fas fa-briefcase" aria-hidden="true"></i> Lógica del negocio</p>
                            <p><i class="fas fa-envelope" aria-hidden="true"></i> <a
                                    href="mailto:backend@ejemplo.com">waldoalfa011@gmail.com</a></p>
                            <p><i class="fas fa-phone" aria-hidden="true"></i> <a href="tel:+521234567893">+52 123 456
                                    7893</a></p>
                        </div>
                        <p class="member-description">Desarrollo de base de datos y lógica de negocio del
                            sistema.</p>
                    </div>
                </div>

                <!-- Integrante 5 - Developer/Tester -->
                <div class="team-card">
                    <div class="card-image">
                        <img src="images/dennis.jpg"
                            alt="Foto de perfil de Dennis Sanchez, Team Scrum del equipo Sistema-Renta-Fácil">
                        <div class="card-overlay">
                            <div class="social-links">
                                <a href="mailto:sanchezdennis114@gmail.com" title="Enviar email Dennis Sanchez"
                                    aria-label="Enviar email a Dennis Sanchez"><i class="fas fa-envelope"
                                        aria-hidden="true"></i></a>
                                
                                <a href="#"
                                    onclick="alert('Actualiza este enlace con el perfil real de GitHub'); return false;"
                                    title="Ver perfil de GitHub de Dennis Sanchez"
                                    aria-label="Ver perfil de GitHub"><i class="fab fa-github"
                                        aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <h3 class="member-name">Dennis Steven Zaldaña</h3>
                        <p class="member-role">Team Scrum</p>
                        <div class="member-info">
                            <p><i class="fas fa-briefcase" aria-hidden="true"></i> Control de calidad</p>
                            <p><i class="fas fa-envelope" aria-hidden="true"></i> <a
                                    href="mailto:qa@ejemplo.com">sanchezdennis114@gmail.com</a></p>
                            <p><i class="fas fa-phone" aria-hidden="true"></i> <a href="tel:+521234567894">+52 123 456
                                    7894</a></p>
                        </div>
                        <p class="member-description">Aseguramiento de calidad, pruebas y validación del sistema.</p>
                    </div>
                </div>
            </div>

            <div class="footer-credits">
                <p>&copy; 2025 Sistema-Renta-Fácil. Todos los derechos reservados.</p>
                <p>Desarrollado con dedicación por nuestro equipo Scrum</p>
            </div>
        </div>
    </section>
</div>



   
</body>

</html>