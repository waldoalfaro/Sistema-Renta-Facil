<?php
session_start();
include '../conexion.php';
include '../seguridad.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibir y limpiar datos del formulario
    $marca = trim($_POST['marca']);
    $modelo = trim($_POST['modelo']);
    $color = trim($_POST['color']);
    $placa = trim($_POST['placa']);
    $anio = intval($_POST['anio']);
    $asientos = intval($_POST['asientos']);
    $aire = intval($_POST['aire']);
    $estado = trim($_POST['estado']);
    
    // Array para almacenar errores
    $errores = [];
    
    // Validaciones básicas
    if (empty($marca)) $errores[] = "La marca es obligatoria";
    if (empty($modelo)) $errores[] = "El modelo es obligatorio";
    if (empty($color)) $errores[] = "El color es obligatorio";
    if (empty($placa)) $errores[] = "La placa es obligatoria";
    if ($anio < 1900 || $anio > 2099) $errores[] = "El año debe estar entre 1900 y 2099";
    if ($asientos < 1 || $asientos > 50) $errores[] = "Los asientos deben estar entre 1 y 50";
    if (!in_array($aire, [0, 1])) $errores[] = "Valor de aire acondicionado no válido";
    if (!in_array($estado, ['Disponible', 'No disponible', 'Mantenimiento', 'De baja'])) {
        $errores[] = "Estado no válido";
    }
    
    // Verificar si la placa ya existe
    $sql_check = "SELECT id_vehiculo FROM vehiculos WHERE placa = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $placa);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows > 0) {
        $errores[] = "La placa ya está registrada";
    }
    $stmt_check->close();
    
    $nombre_foto = null;
    
    // Validar y procesar archivo de imagen
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (!in_array($extension, $extensiones_permitidas)) {
            $errores[] = "Solo se permiten archivos de imagen (JPG, PNG, GIF, WEBP)";
        } elseif ($foto['size'] > 5000000) { // 5MB máximo
            $errores[] = "La imagen no debe pesar más de 5MB";
        } else {
            // Generar nombre único para la foto
            $nombre_foto = 'vehiculo_' . time() . '_' . uniqid() . '.' . $extension;
            $ruta_completa = "../FotosSubidas/" . $nombre_foto;
            
            // Crear directorio si no existe
            if (!is_dir("../FotosSubidas/")) {
                mkdir("../FotosSubidas/", 0755, true);
            }
            
            if (!move_uploaded_file($foto['tmp_name'], $ruta_completa)) {
                $errores[] = "Error al subir la imagen";
                $nombre_foto = null;
            }
        }
    }
    
    // Si no hay errores, insertar en la base de datos
    if (empty($errores)) {
        $sql = "INSERT INTO vehiculos (marca, modelo, color, placa, anio, asientos, aire_acondicionado, estado, foto) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ssssiisss", 
                $marca, $modelo, $color, $placa, $anio, 
                $asientos, $aire, $estado, $nombre_foto
            );
            
            if ($stmt->execute()) {
                $_SESSION['mensaje'] = "Vehículo agregado exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al guardar el vehículo: " . $stmt->error;
                $_SESSION['tipo_mensaje'] = "error";
                
                // Eliminar archivo si falló la inserción
                if ($nombre_foto && file_exists("../FotosSubidas/" . $nombre_foto)) {
                    unlink("../FotosSubidas/" . $nombre_foto);
                }
            }
            
            $stmt->close();
        } else {
            $_SESSION['mensaje'] = "Error al preparar la consulta: " . $conn->error;
            $_SESSION['tipo_mensaje'] = "error";
        }
    } else {
        $_SESSION['mensaje'] = implode("<br>", $errores);
        $_SESSION['tipo_mensaje'] = "error";
        
        // Eliminar archivo si hubo errores de validación
        if ($nombre_foto && file_exists("../FotosSubidas/" . $nombre_foto)) {
            unlink("../FotosSubidas/" . $nombre_foto);
        }
    }
    
    $conn->close();
    
    // Redireccionar de vuelta a la página principal
    header("Location: vehiculos.php");
    exit();
    
} else {
    // Si no es POST, redireccionar
    header("Location: vehiculos.php");
    exit();
}
?>