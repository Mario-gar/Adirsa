<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    $mensaje = trim($_POST["mensaje"] ?? "");

    if (!$nombre || !$correo || !$mensaje) {
        header("Location: index.html?status=error");
        exit;
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.html?status=invalid_email");
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'soporte@adirsa.net';
        $mail->Password   = 'Avalle016*';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->setFrom('soporte@adirsa.net', 'ADIRSA Web');
        $mail->addAddress('soporte@adirsa.net');
        $mail->addReplyTo($correo, $nombre);

        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje desde la web';

        $mail->Body = "
            <h3>Nuevo contacto</h3>
            <p><strong>Nombre:</strong> " . htmlspecialchars($nombre) . "</p>
            <p><strong>Correo:</strong> " . htmlspecialchars($correo) . "</p>
            <p><strong>Teléfono:</strong> " . htmlspecialchars($telefono) . "</p>
            <p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($mensaje)) . "</p>
        ";

        $mail->send();
        header("Location: index.html?status=success");
        exit;

    } catch (Exception $e) {
        header("Location: index.html?status=error");
        exit;
    }
}

header("Location: index.html");
exit;