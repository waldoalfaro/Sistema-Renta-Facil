<?php
include '../conexion.php';



// Verificamos que se recibieron los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    $id_vehiculo     = $_POST['id_vehiculo'];
    $nombre_cliente  = $_POST['nombre_cliente'];
    $dui             = $_POST['dui'];
    $telefono        = $_POST['telefono_cliente'];
    $email           = $_POST['email_cliente'];
    $fecha_inicio    = $_POST['fecha_inicio'];
    $fecha_fin       = $_POST['fecha_fin'];
    $dias            = $_POST['dias'];

    // Validación simple
    if (!$id_vehiculo || empty($nombre_cliente) || empty($email) || empty($telefono) || empty($fecha_inicio) || empty($fecha_fin)) {
        die("Todos los campos son obligatorios.");
    }

    // Preparar la consulta con prepared statements para seguridad
    $stmt = $conn->prepare("INSERT INTO reservaciones 
        (id_vehiculo, solicitante_nombre, solicitante_dui, solicitante_telefono, solicitante_correo, fecha_inicio_solicitada, fecha_fin_solicitada, dias_solicitados) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("issssssi", $id_vehiculo, $nombre_cliente, $dui, $telefono, $email, $fecha_inicio, $fecha_fin, $dias);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Reserva registrada correctamente'); window.location.href='../PaginaWeb.php';</script>";
    } else {
        echo "❌ Error al registrar la reserva: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    die("Acceso no permitido");
}
?>
