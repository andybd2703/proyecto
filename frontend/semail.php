<?php
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $personas = $_POST['personas'] ?? '';

    if (!$email || !$nombre) {
        die('❌ Faltan datos para enviar el correo.');
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración del correo
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'tucorreo@gmail.com'; // pon aquí tu correo
        $mail->Password = 'tupassword';         // y tu app password si usás Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Info del correo
        $mail->setFrom('tucorreo@gmail.com', 'Café La Loma');
        $mail->addAddress($email, $nombre);

        $mail->isHTML(true);
        $mail->Subject = 'TU RESERVA HA SIDO CONFIRMADA';
        $mail->Body = "
            <h2>¡Hola $nombre!</h2>
            <p>Tu reserva ha sido confirmada con estos datos:</p>
            <ul>
                <li><strong>Fecha:</strong> $fecha</li>
                <li><strong>Hora:</strong> $hora</li>
                <li><strong>Personas:</strong> $personas</li>
                <li><strong>Email:</strong> $email</li>
            </ul>
            <p>¡Te esperamos en Café La Loma!</p>
        ";

        $mail->send();
        echo "✅ Correo enviado con éxito";
    } catch (Exception $e) {
        echo "❌ Error: {$mail->ErrorInfo}";
    }
} else {
    echo "❌ No se recibieron datos por POST.";
}
?>
