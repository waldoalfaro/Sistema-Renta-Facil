
<?php
include "menu.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="p-4 sm:ml-64">
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f1c40f 0%, #27ae60 25%, #2c3e50 50%, #f39c12 75%, #16a085 100%);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
            min-height: 100vh;
            padding: 20px;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            25% { background-position: 100% 50%; }
            50% { background-position: 100% 100%; }
            75% { background-position: 0% 100%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            border: 3px solid rgba(241, 196, 15, 0.3);
            backdrop-filter: blur(10px);
        }

        h1 {
            text-align: center;
            background: linear-gradient(45deg, #f1c40f, #27ae60, #2c3e50);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            font-size: 2.5em;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 50px;
            font-size: 1.2em;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .dashboard-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 3px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(241, 196, 15, 0.2), rgba(39, 174, 96, 0.1), transparent);
            transition: left 0.5s;
        }

        .dashboard-card:hover::before {
            left: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(241, 196, 15, 0.3);
            border-color: #f1c40f;
        }

        .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover .icon {
            transform: scale(1.1);
        }

        .card-title {
            font-size: 1.3em;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .card-description {
            color: #666;
            font-size: 0.9em;
            line-height: 1.4;
        }

        /* Iconos SVG inline con colores amarillo, verde y negro */
        .icon-cars {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23f1c40f'%3E%3Cpath d='M5 11l1.5-4.5h11L19 11m-1.5 5a1.5 1.5 0 01-3 0 1.5 1.5 0 013 0m-8 0a1.5 1.5 0 01-3 0 1.5 1.5 0 013 0M17.5 13v-2H19v2h-2zm-11 0v-2H5v2h1.5z'/%3E%3C/svg%3E");
        }

        .icon-clients {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2327ae60'%3E%3Cpath d='M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A1.5 1.5 0 0018.54 7H17c-.8 0-1.54.37-2 1l-3 4v2h2l2.54-3.4L18.5 18H20zM12.5 11.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5S11 9.17 11 10s.67 1.5 1.5 1.5zM5.5 6c1.11 0 2-.89 2-2s-.89-2-2-2-2 .89-2 2 .89 2 2 2zm1.5 1H5c-.8 0-1.54.37-2 1l-3 4v2h2l2.54-3.4L6.5 18H8v-6h2.5l-2.54-7.63A1.5 1.5 0 006.54 7z'/%3E%3C/svg%3E");
        }

        .icon-reservations {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%232c3e50'%3E%3Cpath d='M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z'/%3E%3C/svg%3E");
        }

        .icon-reports {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23f39c12'%3E%3Cpath d='M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z'/%3E%3C/svg%3E");
        }

        .icon-maintenance {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%2316a085'%3E%3Cpath d='M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z'/%3E%3C/svg%3E");
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            h1 {
                font-size: 2em;
            }
            
            .dashboard-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 20px;
            }
            
            .dashboard-card {
                padding: 20px;
            }
            
            .icon {
                width: 60px;
                height: 60px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sonsonate Renta Fácil</h1>
        <p class="subtitle">Sistema de Gestión de Renta de Vehículos</p>
        
        <div class="dashboard-grid">
            <div class="dashboard-card" onclick="window.location.href='lista_carros.php'">
                <div>
                    <img src="Logo.png" alt="">
                </div>
                <h3 class="card-title">Lista de Carros</h3>
                <p class="card-description">Gestiona el inventario completo de vehículos disponibles para renta</p>
            </div>

            <div class="dashboard-card" onclick="window.location.href='clientes.php'">
                <div class="icon icon-clients"></div>
                <h3 class="card-title">Clientes</h3>
                <p class="card-description">Administra la información de todos los clientes registrados</p>
            </div>

            <div class="dashboard-card" onclick="window.location.href='reservaciones.php'">
                <div class="icon icon-reservations"></div>
                <h3 class="card-title">Reservaciones</h3>
                <p class="card-description">Consulta y gestiona todas las reservaciones activas y pendientes</p>
            </div>

            <div class="dashboard-card" onclick="window.location.href='reportes.php'">
                <div class="icon icon-reports"></div>
                <h3 class="card-title">Reportes</h3>
                <p class="card-description">Genera reportes financieros y estadísticas del negocio</p>
            </div>

            <div class="dashboard-card" onclick="window.location.href='mantenimiento.php'">
                <div class="icon icon-maintenance"></div>
                <h3 class="card-title">Mantenimiento</h3>
                <p class="card-description">Control de mantenimiento y estado de los vehículos</p>
            </div>
        </div>
    </div>
</div>
   
    

    <script>
        // Añadir efecto de sonido al hacer click (opcional)
        document.querySelectorAll('.dashboard-card').forEach(card => {
            card.addEventListener('click', function() {
                // Efecto visual adicional al hacer click
                this.style.transform = 'translateY(-15px) scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        });
    </script>


<script src="scrip.js"></script>
</body>
</html>