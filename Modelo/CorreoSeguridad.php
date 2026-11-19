<?php

class CorreoSeguridad {
    public static function enviarCodigo(string $destino, string $nombre, string $codigo, string $proposito): bool {
        $autoload = __DIR__ . '/../vendor/autoload.php';
        if (!is_file($autoload)) return false;
        require_once $autoload;

        $host = getenv('SISTEMVET_SMTP_HOST') ?: 'smtp.gmail.com';
        $usuario = getenv('SISTEMVET_SMTP_USER');
        $clave = getenv('SISTEMVET_SMTP_PASSWORD');
        $puerto = (int)(getenv('SISTEMVET_SMTP_PORT') ?: 465);
        if (!$usuario || !$clave) return false;

        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $host;
            $mail->SMTPAuth = true;
            $mail->Username = $usuario;
            $mail->Password = $clave;
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $puerto;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($usuario, 'Veterinaria Dog&God');
            $mail->addAddress($destino, $nombre);
            $mail->isHTML(true);
            $mail->Subject = 'Código de ' . $proposito;
            $mail->Body = '<p>Hola ' . htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') . '.</p>'
                . '<p>Tu código para ' . htmlspecialchars($proposito, ENT_QUOTES, 'UTF-8') . ' es:</p>'
                . '<p style="font-size:32px;font-weight:bold;letter-spacing:8px">' . $codigo . '</p>'
                . '<p>Vence en 10 minutos. Si no solicitaste este código, ignora este correo.</p>';
            $mail->AltBody = "Tu código para $proposito es $codigo. Vence en 10 minutos.";
            $mail->send();
            return true;
        } catch (Throwable $e) {
            error_log('Error al enviar código de seguridad: ' . $e->getMessage());
            return false;
        }
    }
}
