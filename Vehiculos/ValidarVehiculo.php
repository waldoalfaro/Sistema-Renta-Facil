<?php

include '../conexion.php';
    $idcategoria = $_POST['id_categoria'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $color = $_POST['color'];
    $placa = $_POST['placa'];
    $año = $_POST['anio'];
    $asientos = $_POST['asientos'];
    $aire = $_POST['aire'];
    $estado = $_POST['estado'];
    $precio = $_POST['precio_dia'];
    $combustible = $_POST['combustible'];   
    $gps = $_POST['gps'];
    $seguro = $_POST['seguro'];
    $vin = $_POST['vin'];

$ubicaciones = $_POST['ubicacion_dano'] ?? [];
$tipos = $_POST['tipo_dano'] ?? [];

$fotoNombre = null;

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $fotoNombre = uniqid() . "_" . $_FILES['foto']['name'];
    $rutaTemp   = $_FILES['foto']['tmp_name'];
    $destino    = "../FotosSubidas/" . $fotoNombre;

    
    if (!is_dir("../FotosSubidas/")) {
        mkdir("../FotosSubidas/", 0777, true);
    }

    move_uploaded_file($rutaTemp, $destino);
}

    $revisar = $conn->query("SELECT id_vehiculo FROM vehiculos WHERE placa = '$placa'");
    if ($revisar->num_rows > 0) {
        echo "⚠️ Error: ya existe un vehículo con la placa $placa";
        exit;
    }
   
    $sql_insert = "INSERT INTO vehiculos (id_categoria, marca, modelo, color, placa, anio, asientos, aire_acondicionado, foto, estado, precio_dia, combustible, gps, seguro, vin)
    VALUES ('$idcategoria', '$marca', '$modelo', '$color', '$placa', '$año', '$asientos', '$aire', '$fotoNombre', '$estado', '$precio', '$combustible', '$gps', '$seguro', '$vin')";
    
    if ($conn->query($sql_insert) === TRUE) {
         $idVehiculo = $conn->insert_id;

        if (!empty($ubicaciones) && !empty($tipos)) {
        // Asegurarse que los arrays tengan la misma cantidad de elementos
        $count = min(count($ubicaciones), count($tipos));
        for ($i = 0; $i < $count; $i++) {
            $ubi = $conn->real_escape_string($ubicaciones[$i]);
            $tipo = $conn->real_escape_string($tipos[$i]);
            $conn->query("INSERT INTO vehiculos_danos (id_vehiculo, ubicacion_dano, tipo_dano) VALUES ('$idVehiculo', '$ubi', '$tipo')");
        }
    }

        header("Location: vehiculos.php");
        exit;
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }



?>