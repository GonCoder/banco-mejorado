<?php
session_start();
require_once 'funciones.php';

// Procesamiento de formularios ANTES de cualquier salida HTML
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'procesar.php';
}

// Obtener conexión
$conexion = obtenerConexion();

// Obtener parámetros de ordenación
$ordenarPor = $_GET['ordenar'] ?? 'nombre';
$direccion = $_GET['direccion'] ?? 'ASC';

// Determinar la dirección contraria para el próximo clic
$nuevaDireccion = ($direccion === 'ASC') ? 'DESC' : 'ASC';

// Obtener la acción actual si existe
$accion = $_POST["accion"] ?? $_GET["accion"] ?? "";
$dniModificar = $_POST["dni"] ?? $_GET["dni"] ?? "";

// Obtener lista de clientes ordenada
$clientes = obtenerClientes($conexion, $ordenarPor, $direccion);

// Obtener y limpiar mensajes de sesión
$mensaje = $_SESSION['mensaje'] ?? '';
$tipoMensaje = $_SESSION['tipo_mensaje'] ?? '';
unset($_SESSION['mensaje']);
unset($_SESSION['tipo_mensaje']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco Turing - Clientes</title>
    <link rel="stylesheet" href="styles.css">
    
</head>

<body>
    <h1>Banco Turing</h1>

    <div class="container">
        <h2>Gestión de clientes</h2>

        <?php if ($mensaje): ?>
            <div class="mensaje <?= $tipoMensaje ?>">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>

        <!-- Formulario para añadir cliente -->
        <?php if ($accion != "modificar"): ?>
            <form action="index.php" method="POST">
                <input type="text" name="dni" placeholder="DNI" required pattern="[0-9]{8}[A-Za-z]" title="Formato: 8 números y 1 letra">
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <input type="text" name="direccion" placeholder="Dirección" required>
                <input type="text" name="telefono" placeholder="Teléfono" required pattern="[0-9]{9}" title="9 dígitos">
                <input type="submit" value="Agregar Cliente">
                <input type="hidden" name="accion" value="add">
                <input type="reset" value="Borrar formulario y volver a empezar">
            </form>
        <?php endif; ?>

        <!-- Tabla clientes -->
        <table>
            <tr>
                <th>
                    <a href="?ordenar=dni&direccion=<?= $ordenarPor === 'dni' ? $nuevaDireccion : 'ASC' ?>" 
                       class="ordenar <?= $ordenarPor === 'dni' ? strtolower($direccion) : '' ?>">
                        DNI
                    </a>
                </th>
                <th>
                    <a href="?ordenar=nombre&direccion=<?= $ordenarPor === 'nombre' ? $nuevaDireccion : 'ASC' ?>" 
                       class="ordenar <?= $ordenarPor === 'nombre' ? strtolower($direccion) : '' ?>">
                        Nombre
                    </a>
                </th>
                <th>
                    <a href="?ordenar=direccion&direccion=<?= $ordenarPor === 'direccion' ? $nuevaDireccion : 'ASC' ?>" 
                       class="ordenar <?= $ordenarPor === 'direccion' ? strtolower($direccion) : '' ?>">
                        Dirección
                    </a>
                </th>
                <th>
                    <a href="?ordenar=telefono&direccion=<?= $ordenarPor === 'telefono' ? $nuevaDireccion : 'ASC' ?>" 
                       class="ordenar <?= $ordenarPor === 'telefono' ? strtolower($direccion) : '' ?>">
                        Teléfono
                    </a>
                </th>
                <th>Opciones</th>
            </tr>
            
            <?php while ($fila = mysqli_fetch_array($clientes)): ?>
                <?php if (($accion == 'modificar') && ($fila['dni'] == $dniModificar)): ?>
                    <tr class="resaltado">
                        <form action="index.php" method="POST">
                            <td><input type="text" name="dni" value="<?= htmlspecialchars($fila['dni']) ?>" required></td>
                            <td><input type="text" name="nombre" value="<?= htmlspecialchars($fila['nombre']) ?>" required></td>
                            <td><input type="text" name="direccion" value="<?= htmlspecialchars($fila['direccion']) ?>" required></td>
                            <td><input type="text" name="telefono" value="<?= htmlspecialchars($fila['telefono']) ?>" required></td>
                            <td>
                                <input type="hidden" name="accion" value="actualizar">
                                <input type="hidden" name="dniAntiguo" value="<?= htmlspecialchars($fila['dni']) ?>">
                                <input class="aceptar" type="submit" value="Aceptar">
                                <a href="index.php">
                                    <input class="cancelar-btn" type="button" value="Cancelar">
                                </a>
                            </td>
                        </form>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['dni']) ?></td>
                        <td><?= htmlspecialchars($fila['nombre']) ?></td>
                        <td><?= htmlspecialchars($fila['direccion']) ?></td>
                        <td><?= htmlspecialchars($fila['telefono']) ?></td>
                        <td>
                            <form action="index.php" method="POST" style="display: inline;">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="dni" value="<?= htmlspecialchars($fila['dni']) ?>">
                                <input class="eliminar" type="submit" value="Eliminar" 
                                       <?= $accion == 'modificar' ? 'disabled' : '' ?>
                                       onclick="return confirm('¿Está seguro de eliminar este cliente?');">
                            </form>
                            
                            <form action="index.php" method="POST" style="display: inline;">
                                <input type="hidden" name="accion" value="modificar">
                                <input type="hidden" name="dni" value="<?= htmlspecialchars($fila['dni']) ?>">
                                <input class="modificar" type="submit" value="Modificar" 
                                       <?= $accion == 'modificar' ? 'disabled' : '' ?>>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endwhile; ?>
        </table>
    </div>

    <footer>
        &copy; 2025 Banco Turing - Sistema de gestión de clientes
    </footer>
</body>

</html>

<?php
mysqli_close($conexion);
?>