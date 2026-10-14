<?php
header('Content-Type: application/json');
require_once "../Modelo/ConsultaModelo.php";

$accion = $_REQUEST['accion'] ?? '';
$modelo = new ConsultaModelo();

if ($accion === 'guardar_consulta') {
    $datos = [
        'fecha'                     => $_POST['fecha'] ?? '',
        'temperatura'               => $_POST['temperatura'] ?? null,
        'peso_consulta'             => $_POST['peso_consulta'] ?? null,
        'frecuencia_card'           => $_POST['frecuencia_card'] ?? null,
        'detalles_diagnosticos'     => $_POST['detalles_diagnosticos'] ?? null,
        'analisis_clinicos'         => $_POST['analisis_clinicos'] ?? null,
        'nombre_medicamento'        => $_POST['nombre_medicamento'] ?? '',
        'dosis'                     => $_POST['dosis'] ?? '',
        'frecuencia_administracion' => $_POST['frecuencia_administracion'] ?? '',
        'fecha_inicial'             => $_POST['fecha_inicial'] ?? '',
        'fecha_final'               => $_POST['fecha_final'] ?? '',
        'id_cita'                   => $_POST['id_cita'] ?? null
    ];

    if (empty($datos['fecha']) || empty($datos['peso_consulta']) || empty($datos['nombre_medicamento'])) {
        echo json_encode(["status" => "error", "message" => "Por favor completa los campos obligatorios."]);
        exit;
    }

    $res = $modelo->registrarConsultaCompleta($datos);
    if ($res) {
        echo json_encode(["status" => "success", "message" => "Guardado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo completar el registro."]);
    }
    exit;
}

if ($accion === 'listar_consultas') {
    $consultas = $modelo->obtenerConsultasRegistradas();
    echo json_encode(["status" => "success", "data" => $consultas]);
    exit;
}