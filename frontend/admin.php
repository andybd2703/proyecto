<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "yeison2006", "cafe", 3307);

// Validar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consultar las reservas
$sql = "SELECT * FROM reservas ORDER BY creado_en DESC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas - Café La Loma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="icon" type="image/jpeg" href="../img/logocf.jpg">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4 text-center">📋 Reservas Recibidas</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Personas</th>
                        <th>Creado En</th>
                        <th>Celular</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado->num_rows > 0): ?>
                        <?php while($fila = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?= $fila["id"] ?></td>
                                <td><?= $fila["nombre"] ?></td>
                                <td><?= $fila["email"] ?></td>
                                <td><?= $fila["fecha"] ?></td>
                                <td><?= $fila["hora"] ?></td>
                                <td><?= $fila["personas"] ?></td>
                                <td><?= $fila["creado_en"] ?></td>
                                <td><?= $fila["celular"] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No hay reservas aún.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conexion->close();
?>
