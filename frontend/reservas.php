<?php
// Inicializar mensaje vacío
$mensaje = "";

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar a la base de datos
    $conexion = new mysqli("localhost", "root", "yeison2006", "cafe", 3307); // ⚠️ Cambia estos datos

    // Verificar conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Recoger y limpiar los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Preparar consulta segura
    $stmt = $conexion->prepare("INSERT INTO reservas (nombre, email, fecha, hora) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $email, $fecha, $hora);

    // Ejecutar y verificar resultado
    if ($stmt->execute()) {
        $mensaje = "✅ ¡Reserva guardada correctamente!";
    } else {
        $mensaje = "❌ Error al guardar la reserva: " . $stmt->error;
    }

    // Cerrar conexiones
    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Ahora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-brown {
            background-color: #6f4e37 !important;
            color: white;
        }

        .navbar-brand {
            color: white !important;
            font-family: Georgia, 'Times New Roman', Times, serif;
        }

        .navbar-nav .nav-link {
            color: white !important;
            font-family: Georgia, 'Times New Roman', Times, serif;
        }

        .navbar-text {
            background-color: #6f4e37;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 25px;
            font-weight: bold;
            font-family: Georgia, 'Times New Roman', Times, serif;
            text-align: center;
        }

        /* Estilo elegante para el formulario */
        .form-reserva {
            background: #fff8f0;
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(111, 78, 55, 0.15);
            padding: 40px 30px 30px 30px;
            max-width: 450px;
            margin: 0 auto;
        }

        .form-reserva h1 {
            font-family: 'Georgia', serif;
            color: #6f4e37;
            font-weight: bold;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        .form-reserva .form-label {
            color: #6f4e37;
            font-weight: 500;
        }

        .form-reserva .form-control {
            border-radius: 10px;
            border: 1px solid #d1bfa7;
            box-shadow: none;
        }

        .form-reserva .btn-success {
            background-color: #6f4e37;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 18px;
            transition: background 0.2s;
        }

        .form-reserva .btn-success:hover {
            background-color: #543826;
        }

        .alert-info {
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-brown">
        <div class="container">
            <a class="navbar-brand">☕ Café La Loma</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.html">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="productos.html">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacto.html">Contacto</a></li>
                    <li class="nav-item"><a class="nav-link" href="reservas.php">Reservas</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="form-reserva">
            <h1 class="text-center mb-4">Reserva Ahora</h1>

            <?php if (!empty($mensaje)): ?>
                <div class="alert alert-info text-center"><?php echo $mensaje; ?></div>
            <?php endif; ?>

            <form action="reservas.php" method="POST" id="formReserva" novalidate>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" autocomplete="off" required
                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                    <div class="invalid-feedback">
                        Por favor ingresa un correo electrónico válido.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha de Reserva</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>
                <div class="mb-3">
                    <label for="hora" class="form-label">Hora de Reserva</label>
                    <input type="time" class="form-control" id="hora" name="hora" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Reservar Ahora</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Validación de email (ya existente)
    document.getElementById('formReserva').addEventListener('submit', function(event) {
        var emailInput = document.getElementById('email');
        if (!emailInput.checkValidity()) {
            emailInput.classList.add('is-invalid');
            event.preventDefault();
            event.stopPropagation();
        } else {
            emailInput.classList.remove('is-invalid');
        }
    });

    // Establecer fecha mínima para mañana
    window.addEventListener('DOMContentLoaded', function() {
        var fechaInput = document.getElementById('fecha');
        var hoy = new Date();
        hoy.setDate(hoy.getDate() + 1); // Siguiente día
        var yyyy = hoy.getFullYear();
        var mm = String(hoy.getMonth() + 1).padStart(2, '0');
        var dd = String(hoy.getDate()).padStart(2, '0');
        var minDate = yyyy + '-' + mm + '-' + dd;
        fechaInput.min = minDate;
    });
    </script>
</body>

</html>