<?php
session_start();
include '../conexion.php';
include '../seguridad.php';

header('Content-Type: application/json');

// Verificar que se recibió el ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'ID del vehículo no proporcionado'
    ]);
    exit;
}

$id_vehiculo = intval($_GET['id']);

// Consulta preparada para obtener los datos del vehículo
$sql = "SELECT * FROM vehiculos WHERE id_vehiculo = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $id_vehiculo);
    
    if ($stmt->execute()) {
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $vehiculo = $resultado->fetch_assoc();
            
            echo json_encode([
                'success' => true,
                'vehiculo' => $vehiculo
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Vehículo no encontrado'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al ejecutar la consulta: ' . $stmt->error
        ]);
    }
    
    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al preparar la consulta: ' . $conn->error
    ]);
}

$conn->close();
?>