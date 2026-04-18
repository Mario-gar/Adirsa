<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $mensaje = $_POST["mensaje"];

    if (!$nombre || !$correo || !$mensaje) {
        header("Location: index.html?status=error");
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // CONFIG HOSTINGER
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'soporte@adirsa.net'; // tu correo
        $mail->Password   = 'Avalle016*'; // tu contraseña real
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // ENVÍO
        $mail->setFrom('soporte@adirsa.net', 'ADIRSA Web');
        $mail->addAddress('soporte@adirsa.net');

        $mail->addReplyTo($correo, $nombre);

        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje desde la web';

        $mail->Body = "
            <h3>Nuevo contacto</h3>
            <p><strong>Nombre:</strong> $nombre</p>
            <p><strong>Correo:</strong> $correo</p>
            <p><strong>Teléfono:</strong> $telefono</p>
            <p><strong>Mensaje:</strong><br>$mensaje</p>
        ";

        $mail->send();

        header("Location: index.html?status=success");
        exit;

    } catch (Exception $e) {
        header("Location: index.html?status=error");
        exit;
    }
}