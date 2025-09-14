<?php
session_start();
include '../conexion.php';

if (isset($_GET['id_vehiculo'])){
    $id = $_GET['id_vehiculo'];

    $sql = "DELETE FROM vehiculos WHERE id_vehiculo = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id); 
        $stmt->execute();
        $stmt->close();
    }

    // Redirigir a la lista de usuarios
    header('Location: vehiculos.php');
    exit();

}
?>