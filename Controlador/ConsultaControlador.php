<?php
require_once __DIR__ . "/../Modelo/config.php";
require_once __DIR__ . "/../Modelo/ConsultaModelo.php";
require_once __DIR__ . "/DiagnosticoControlador.php";
require_once __DIR__ . "/TratamientoControlador.php";

header("Content-Type: application/json; charset=utf-8");

function responderConsulta(string $status, string $message, array $extra = [], int $httpCode = 200): void
{
    http_response_code($httpCode);
    echo json_encode(array_merge(["status" => $status, "message" => $message], $extra), JSON_UNESCAPED_UNICODE);
    exit;
}

function fechaConsultaValida(string $fecha): bool
{
    $valor = DateTime::createFromFormat("!Y-m-d", $fecha);
    return $valor !== false && $valor->format("Y-m-d") === $fecha;
}

function campoTextoConsulta(string $nombre): string
{
    $valor = $_POST[$nombre] ?? "";
    return is_string($valor) ? trim($valor) : "";
}

$conexion = null;
try {
    $conexion = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $modeloConsulta = new ConsultaModelo();
    $accion = campoTextoConsulta("accion");
    $idMascota = campoTextoConsulta("id_mascota");

    if ($accion === "listar_consultas") {
        if ($idMascota === "" || strlen($idMascota) > 25) {
            responderConsulta("error", "Identificador de mascota no válido.", [], 400);
        }
        responderConsulta("success", "Consultas cargadas.", [
            "data" => $modeloConsulta->obtenerPorMascota($conexion, $idMascota)
        ]);
    }

    if ($accion !== "guardar_consulta") {
        responderConsulta("error", "Operación no válida.", [], 400);
    }

    $fecha = campoTextoConsulta("fecha");
    $peso = campoTextoConsulta("peso_consulta");
    $temperatura = campoTextoConsulta("temperatura");
    $frecuenciaCardiaca = campoTextoConsulta("frecuencia_card");
    $idCita = campoTextoConsulta("id_cita");

    if ($idMascota === "" || strlen($idMascota) > 25 || !fechaConsultaValida($fecha)) {
        responderConsulta("error", "La mascota o la fecha de consulta no son válidas.", [], 400);
    }
    if (!preg_match("/^[1-9]\\d{0,9}$/", $peso)
        || ($temperatura !== "" && !preg_match("/^\\d{1,3}$/", $temperatura))
        || ($frecuenciaCardiaca !== "" && !preg_match("/^\\d{1,5}$/", $frecuenciaCardiaca))) {
        responderConsulta("error", "Revisa el peso, la temperatura y la frecuencia cardíaca.", [], 400);
    }
    if ($idCita !== "" && (strlen($idCita) > 100 || !preg_match("/^[A-Za-z0-9_-]+$/", $idCita))) {
        responderConsulta("error", "El identificador de la cita no es válido.", [], 400);
    }

    $datos = [
        "fecha" => $fecha,
        "temperatura" => $temperatura === "" ? null : $temperatura,
        "peso_consulta" => $peso,
        "frecuencia_card" => $frecuenciaCardiaca,
        "fecha_diagnostico" => $fecha,
        "analisis_clinicos" => campoTextoConsulta("analisis_clinicos"),
        "detalles_diagnosticos" => campoTextoConsulta("detalles_diagnosticos"),
        "nombre_medicamento" => campoTextoConsulta("nombre_medicamento"),
        "dosis" => campoTextoConsulta("dosis"),
        "frecuencia_administracion" => campoTextoConsulta("frecuencia_administracion"),
        "fecha_inicial" => campoTextoConsulta("fecha_inicial"),
        "fecha_final" => campoTextoConsulta("fecha_final"),
        "id_cita" => $idCita === "" ? null : $idCita
    ];

    $conexion->beginTransaction();
    $stmtMascota = $conexion->prepare("SELECT 1 FROM mascota WHERE id_mascota = ?");
    $stmtMascota->execute([$idMascota]);
    if (!$stmtMascota->fetchColumn()) {
        $conexion->rollBack();
        responderConsulta("error", "No se encontró la mascota seleccionada.", [], 404);
    }
    if ($idCita !== "") {
        $stmtCita = $conexion->prepare("SELECT 1 FROM cita WHERE id_cita = ?");
        $stmtCita->execute([$idCita]);
        if (!$stmtCita->fetchColumn()) {
            $conexion->rollBack();
            responderConsulta("error", "No se encontró la cita seleccionada.", [], 404);
        }
    }

    $idDiagnostico = (new DiagnosticoControlador())->registrar($conexion, $datos);
    $idTratamiento = (new TratamientoControlador())->registrar($conexion, $idDiagnostico, $datos);
    $idConsulta = "CONS-" . strtoupper(bin2hex(random_bytes(12)));
    $modeloConsulta->crear($conexion, $idConsulta, $idMascota, $idDiagnostico, $idTratamiento, $datos);
    $conexion->commit();

    responderConsulta("success", "Consulta, diagnóstico y tratamiento guardados correctamente.", [
        "id_consulta" => $idConsulta
    ]);
} catch (InvalidArgumentException $error) {
    if ($conexion instanceof PDO && $conexion->inTransaction()) {
        $conexion->rollBack();
    }
    responderConsulta("error", $error->getMessage(), [], 400);
} catch (PDOException $error) {
    if ($conexion instanceof PDO && $conexion->inTransaction()) {
        $conexion->rollBack();
    }
    error_log("Error al guardar consulta: " . $error->getMessage());
    responderConsulta("error", "No se pudo guardar la consulta en la base de datos.", [], 500);
}
