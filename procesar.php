<?php
// Procesamiento de acciones del formulario

require_once 'funciones.php';

$conexion = obtenerConexion();
$resultado = null;

// Procesar acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST["accion"] ?? "";
    $dni = $_POST["dni"] ?? "";
    $nombre = $_POST["nombre"] ?? "";
    $direccion = $_POST["direccion"] ?? "";
    $telefono = $_POST["telefono"] ?? "";
    $dniAntiguo = $_POST["dniAntiguo"] ?? "";
    
    switch ($accion) {
        case 'add':
            if (!empty($dni) && !empty($nombre) && !empty($direccion) && !empty($telefono)) {
                $resultado = agregarCliente($dni, $nombre, $direccion, $telefono, $conexion);
                $_SESSION['mensaje'] = $resultado['mensaje'];
                $_SESSION['tipo_mensaje'] = $resultado['exito'] ? 'exito' : 'error';
            }
            break;
            
        case 'eliminar':
            if (!empty($dni)) {
                $resultado = eliminarCliente($dni, $conexion);
                $_SESSION['mensaje'] = $resultado['mensaje'];
                $_SESSION['tipo_mensaje'] = $resultado['exito'] ? 'exito' : 'error';
            }
            break;
            
        case 'actualizar':
            if (!empty($dni) && !empty($nombre) && !empty($direccion) && !empty($telefono)) {
                $resultado = actualizarCliente($dni, $nombre, $direccion, $telefono, $dniAntiguo, $conexion);
                $_SESSION['mensaje'] = $resultado['mensaje'];
                $_SESSION['tipo_mensaje'] = $resultado['exito'] ? 'exito' : 'error';
            }
            break;
    }
    
    // Redirigir para evitar reenvío del formulario
    if ($accion !== 'modificar') {
        header("Location: index.php");
        exit();
    }
}

mysqli_close($conexion);
