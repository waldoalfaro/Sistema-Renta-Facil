<?php
$conn = new mysqli("localhost", "root", "", "Sistema_Renta_Facil");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
