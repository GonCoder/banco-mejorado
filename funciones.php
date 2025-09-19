<?php
// Funciones para gestión de clientes

require_once 'config.php';

/**
 * Verifica si un DNI ya existe en la base de datos
 */
function dniExiste($dni, $conexion) {
    $dni = mysqli_real_escape_string($conexion, $dni);
    $consulta = "SELECT COUNT(*) as total FROM cliente WHERE dni = '$dni'";
    $resultado = mysqli_query($conexion, $consulta);
    $fila = mysqli_fetch_assoc($resultado);
    return $fila['total'] > 0;
}

/**
 * Añade un nuevo cliente
 */
function agregarCliente($dni, $nombre, $direccion, $telefono, $conexion) {
    // Sanitizar entradas
    $dni = mysqli_real_escape_string($conexion, $dni);
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $direccion = mysqli_real_escape_string($conexion, $direccion);
    $telefono = mysqli_real_escape_string($conexion, $telefono);
    
    // Verificar si el DNI ya existe
    if (dniExiste($dni, $conexion)) {
        return ['exito' => false, 'mensaje' => 'Error: El DNI ya existe en el sistema.'];
    }
    
    // Insertar nuevo cliente
    $insertar = "INSERT INTO cliente (dni, nombre, direccion, telefono) 
                 VALUES ('$dni', '$nombre', '$direccion', '$telefono')";
    
    if (mysqli_query($conexion, $insertar)) {
        return ['exito' => true, 'mensaje' => 'Cliente añadido correctamente.'];
    } else {
        return ['exito' => false, 'mensaje' => 'Error al añadir el cliente: ' . mysqli_error($conexion)];
    }
}

/**
 * Elimina un cliente por DNI
 */
function eliminarCliente($dni, $conexion) {
    $dni = mysqli_real_escape_string($conexion, $dni);
    $eliminar = "DELETE FROM cliente WHERE dni = '$dni'";
    
    if (mysqli_query($conexion, $eliminar)) {
        return ['exito' => true, 'mensaje' => 'Cliente eliminado correctamente.'];
    } else {
        return ['exito' => false, 'mensaje' => 'Error al eliminar el cliente: ' . mysqli_error($conexion)];
    }
}

/**
 * Actualiza los datos de un cliente
 */
function actualizarCliente($dniNuevo, $nombre, $direccion, $telefono, $dniAntiguo, $conexion) {
    // Sanitizar entradas
    $dniNuevo = mysqli_real_escape_string($conexion, $dniNuevo);
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $direccion = mysqli_real_escape_string($conexion, $direccion);
    $telefono = mysqli_real_escape_string($conexion, $telefono);
    $dniAntiguo = mysqli_real_escape_string($conexion, $dniAntiguo);
    
    // Si el DNI ha cambiado, verificar que el nuevo no exista
    if ($dniNuevo !== $dniAntiguo && dniExiste($dniNuevo, $conexion)) {
        return ['exito' => false, 'mensaje' => 'Error: El nuevo DNI ya existe en el sistema.'];
    }
    
    $actualizar = "UPDATE cliente 
                   SET dni='$dniNuevo', nombre='$nombre', direccion='$direccion', telefono='$telefono' 
                   WHERE dni='$dniAntiguo'";
    
    if (mysqli_query($conexion, $actualizar)) {
        return ['exito' => true, 'mensaje' => 'Cliente actualizado correctamente.'];
    } else {
        return ['exito' => false, 'mensaje' => 'Error al actualizar el cliente: ' . mysqli_error($conexion)];
    }
}

/**
 * Obtiene todos los clientes ordenados según el criterio especificado
 */
function obtenerClientes($conexion, $ordenarPor = 'nombre', $direccionOrden = 'ASC') {
    // Validar campo de ordenación
    $camposValidos = ['dni', 'nombre', 'direccion', 'telefono'];
    if (!in_array($ordenarPor, $camposValidos)) {
        $ordenarPor = 'nombre';
    }
    
    // Validar dirección de ordenación
    $direccionOrden = strtoupper($direccionOrden) === 'DESC' ? 'DESC' : 'ASC';
    
    $consulta = "SELECT dni, nombre, direccion, telefono 
                 FROM cliente 
                 ORDER BY $ordenarPor $direccionOrden";
    
    return mysqli_query($conexion, $consulta);
}

/**
 * Obtiene los datos de un cliente específico
 */
function obtenerCliente($dni, $conexion) {
    $dni = mysqli_real_escape_string($conexion, $dni);
    $consulta = "SELECT * FROM cliente WHERE dni = '$dni'";
    $resultado = mysqli_query($conexion, $consulta);
    return mysqli_fetch_assoc($resultado);
}