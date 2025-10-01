<?php
include '../conexion.php';




$idcategoria = $_POST['id_categoria'];
$marca       = $_POST['marca'];
$modelo      = $_POST['modelo'];
$color       = $_POST['color'];
$placa       = $_POST['placa'];
$año         = $_POST['anio'];
$asientos    = $_POST['asientos'];
$aire        = $_POST['aire'];
$estado      = $_POST['estado'];
$precio      = $_POST['precio_dia'];
$combustible = $_POST['combustible'];   
$gps         = $_POST['gps'];
$seguro      = $_POST['seguro'];
$vin         = $_POST['vin'];

$ubicaciones = $_POST['ubicacion_dano'] ?? [];
$tipos       = $_POST['tipo_dano'] ?? [];


$revisar = $conn->query("SELECT id_vehiculo FROM vehiculos WHERE placa = '$placa'");
if ($revisar->num_rows > 0) {
    echo "⚠️ Error: ya existe un vehículo con la placa $placa";
    exit;
}


$fotosGuardadas = [];
$fotoPrincipalNombre = null;

if (!empty($_FILES['fotos']['name'][0])) {
    for ($i = 0; $i < count($_FILES['fotos']['name']); $i++) {
        if ($_FILES['fotos']['error'][$i] === UPLOAD_ERR_OK) {
            $nombreOriginal = $_FILES['fotos']['name'][$i];
            $fotoNombre = uniqid() . "_" . basename($nombreOriginal);
            $rutaTemp   = $_FILES['fotos']['tmp_name'][$i];
            $destino    = "../FotosSubidas/" . $fotoNombre;

            if (!is_dir("../FotosSubidas/")) {
                mkdir("../FotosSubidas/", 0777, true);
            }

            if (move_uploaded_file($rutaTemp, $destino)) {
                $fotosGuardadas[] = $fotoNombre;

                
                if ($i === 0) {
                    $fotoPrincipalNombre = $fotoNombre;
                }
            }
        }
    }
}

// Insertar vehículo con foto principal
$sql_insert = "INSERT INTO vehiculos 
(id_categoria, marca, modelo, color, placa, anio, asientos, aire_acondicionado, foto, estado, precio_dia, combustible, gps, seguro, vin)
VALUES 
('$idcategoria', '$marca', '$modelo', '$color', '$placa', '$año', '$asientos', '$aire', '$fotoPrincipalNombre', '$estado', '$precio', '$combustible', '$gps', '$seguro', '$vin')";

if ($conn->query($sql_insert) === TRUE) {
    $idVehiculo = $conn->insert_id;

    // Guardar todas las imágenes en vehiculos_fotos
    foreach ($fotosGuardadas as $foto) {
        $conn->query("INSERT INTO vehiculos_fotos (id_vehiculo, foto) VALUES ('$idVehiculo', '$foto')");
    }

    // Guardar daños si existen
    if (!empty($ubicaciones) && !empty($tipos)) {
        $count = min(count($ubicaciones), count($tipos));
        for ($i = 0; $i < $count; $i++) {
            $ubi  = $conn->real_escape_string($ubicaciones[$i]);
            $tipo = $conn->real_escape_string($tipos[$i]);
            $conn->query("INSERT INTO vehiculos_danos (id_vehiculo, ubicacion_dano, tipo_dano) 
                          VALUES ('$idVehiculo', '$ubi', '$tipo')");
        }
    }

    header("Location: vehiculos.php");
    exit;

} else {
    echo "Error: " . $sql_insert . "<br>" . $conn->error;
}
?>
