<?php
require_once __DIR__ . '/../Modelo/crud.php';
require_once __DIR__ . '/../Modelo/CorreoSeguridad.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

class ControLogin {
    private Database $db;

    public function __construct() { $this->db = new Database(); }

    private function responder(bool $status, string $mensaje, array $extra = []): void {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array_merge(['status' => $status, 'mensaje' => $mensaje], $extra));
    }

    private function usuarioPorCorreo(string $correo): ?array {
        $conexion = $this->db->conexion();
        $correoSeguro = $conexion->real_escape_string(trim($correo));

        // Conserva la búsqueda del controlador anterior y usa normalización como respaldo.
        $usuarios = $this->db->read('usuarios', "correo = '$correoSeguro'");
        if (count($usuarios) === 0) {
            $usuarios = $this->db->read('usuarios', "LOWER(TRIM(correo)) = LOWER('$correoSeguro')");
        }
        return $usuarios[0] ?? null;
    }

    private function emitirCodigo(string $correo, string $nombre, string $proposito): bool {
        $codigo = (string) random_int(100000, 999999);
        $ok = CorreoSeguridad::enviarCodigo($correo, $nombre, $codigo, $proposito);
        if ($ok) {
            $_SESSION['codigo_seguridad'] = [
                'correo' => $correo,
                'hash' => password_hash($codigo, PASSWORD_DEFAULT),
                'proposito' => $proposito,
                'vence' => time() + 600,
                'intentos' => 0
            ];
        }
        return $ok;
    }

    public function iniciarSesion(string $correo, string $password): void {
        $usuario = $this->usuarioPorCorreo($correo);
        if (!$usuario) { $this->responder(false, 'El correo no está registrado'); return; }

        $guardada = (string)$usuario['password'];
        $coincide = password_verify($password, $guardada) || $guardada === $password || trim($guardada) === $password;
        if (!$coincide) { $this->responder(false, 'Contraseña incorrecta'); return; }
        session_regenerate_id(true);
        $_SESSION['usuario_autenticado'] = $usuario['correo'];
        unset($_SESSION['codigo_seguridad'], $_SESSION['recuperacion_confirmada']);
        $this->responder(true, 'Inicio de sesión correcto', ['correo' => $usuario['correo']]);
    }

    public function enviarCodigoRecuperacion(string $correo): void {
        $usuario = $this->usuarioPorCorreo($correo);
        if (!$usuario) { $this->responder(false, 'El correo no está registrado'); return; }
        if (!$this->emitirCodigo($usuario['correo'], $usuario['nombre'], 'recuperación de contraseña')) {
            $this->responder(false, 'No se pudo enviar el código. Revisa la configuración SMTP y vuelve a intentarlo.'); return;
        }
        $this->responder(true, 'Enviamos un código de 6 dígitos al correo de tu cuenta.');
    }

    public function verificarCodigo(string $codigo): void {
        $estado = $_SESSION['codigo_seguridad'] ?? null;
        if (!$estado || time() > $estado['vence']) { unset($_SESSION['codigo_seguridad']); $this->responder(false, 'El código venció. Solicita uno nuevo.'); return; }
        if (($estado['proposito'] ?? '') !== 'recuperación de contraseña') { unset($_SESSION['codigo_seguridad']); $this->responder(false, 'El código no corresponde a una recuperación de contraseña.'); return; }
        if (++$estado['intentos'] > 5) { unset($_SESSION['codigo_seguridad']); $this->responder(false, 'Se excedió el número de intentos. Solicita un código nuevo.'); return; }
        $_SESSION['codigo_seguridad'] = $estado;
        if (!preg_match('/^\d{6}$/', $codigo) || !password_verify($codigo, $estado['hash'])) { $this->responder(false, 'Código incorrecto.'); return; }
        $_SESSION['recuperacion_confirmada'] = ['correo' => $estado['correo'], 'vence' => time() + 600];
        unset($_SESSION['codigo_seguridad']);
        $this->responder(true, 'Código confirmado.', ['proposito' => 'recuperacion']);
    }

    public function actualizarPassword(string $password): void {
        $rec = $_SESSION['recuperacion_confirmada'] ?? null;
        if (!$rec || time() > $rec['vence']) { unset($_SESSION['recuperacion_confirmada']); $this->responder(false, 'La confirmación venció. Inicia de nuevo la recuperación.'); return; }
        if (strlen($password) < 8) { $this->responder(false, 'La contraseña debe tener al menos 8 caracteres.'); return; }
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->conexion()->prepare('UPDATE usuarios SET password = ? WHERE correo = ?');
        $stmt->bind_param('ss', $passwordHash, $rec['correo']);
        $ok = $stmt->execute() && $stmt->affected_rows > 0;
        $stmt->close();
        if ($ok) { unset($_SESSION['recuperacion_confirmada']); $this->responder(true, 'Contraseña actualizada correctamente'); }
        else { $this->responder(false, 'No se pudo actualizar la contraseña'); }
    }

    public function crearCuenta(string $correo, string $password, string $nombre, string $apellidoP, string $apellidoM): void {
        $correo = trim($correo);
        if ($this->usuarioPorCorreo($correo)) { $this->responder(false, 'El correo ya existe'); return; }

        try {
            $ok = $this->db->create('usuarios', [
                'correo' => $correo,
                'password' => $password,
                'nombre' => $nombre,
                'apellido_paterno' => $apellidoP,
                'apellido_materno' => $apellidoM
            ]);
        } catch (Throwable $e) {
            // Puede ocurrir una carrera: otro intento insertó el correo después de la comprobación.
            if ($this->usuarioPorCorreo($correo)) { $this->responder(false, 'El correo ya existe'); return; }
            error_log('Error al crear usuario: ' . $e->getMessage());
            $this->responder(false, 'No se pudo guardar la cuenta en la base de datos');
            return;
        }

        if (!$ok) { $this->responder(false, 'No se pudo guardar la cuenta en la base de datos'); return; }

        // El alta ya quedó guardada. Enlazar perfiles existentes es secundario y no debe
        // reportar el registro como fallido ni provocar un segundo intento duplicado.
        try {
            $usuario = $this->usuarioPorCorreo($correo);
            $idUsuario = $usuario['id_usuario'] ?? null;
            if ($idUsuario !== null) {
                $correoSeguro = $this->db->conexion()->real_escape_string($correo);
                $this->db->update('tutor', ['id_usuario'=>$idUsuario], "correo_tutor = '$correoSeguro' AND id_usuario IS NULL");
                $this->db->update('veterinario', ['id_usuario'=>$idUsuario], "correo_veterinario = '$correoSeguro' AND id_usuario IS NULL");
            }
        } catch (Throwable $e) {
            error_log('La cuenta se creó, pero falló el enlace de perfil: ' . $e->getMessage());
        }

        $this->responder(true, 'Cuenta creada correctamente');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ControLogin();
    if (isset($_POST['login'])) $controller->iniciarSesion(trim($_POST['correo'] ?? ''), (string)($_POST['password'] ?? ''));
    elseif (isset($_POST['enviar_codigo_recuperacion'])) $controller->enviarCodigoRecuperacion(trim($_POST['correo'] ?? ''));
    elseif (isset($_POST['verificar_codigo'])) $controller->verificarCodigo(trim($_POST['codigo'] ?? ''));
    elseif (isset($_POST['actualizar_password'])) $controller->actualizarPassword((string)($_POST['password'] ?? ''));
    elseif (isset($_POST['crear'])) $controller->crearCuenta(trim($_POST['correo'] ?? ''), (string)($_POST['password'] ?? ''), trim($_POST['nombre'] ?? ''), trim($_POST['apellido_paterno'] ?? ''), trim($_POST['apellido_materno'] ?? ''));
    else { header('Content-Type: application/json; charset=utf-8'); echo json_encode(['status'=>false, 'mensaje'=>'Solicitud no válida']); }
}
