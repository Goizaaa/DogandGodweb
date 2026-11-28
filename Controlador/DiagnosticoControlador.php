<?php
require_once __DIR__ . "/../Modelo/DiagnosticoModelo.php";

class DiagnosticoControlador
{
    public function registrar(PDO $conexion, array $datos): string
    {
        $detalles = trim($datos["detalles_diagnosticos"] ?? "");
        $analisis = trim($datos["analisis_clinicos"] ?? "");
        if ($detalles === "" || $this->longitud($detalles) > 100 || $this->longitud($analisis) > 100) {
            throw new InvalidArgumentException("Completa el diagnóstico y revisa que cada campo tenga máximo 100 caracteres.");
        }

        $idDiagnostico = "DIAG-" . strtoupper(bin2hex(random_bytes(12)));
        (new DiagnosticoModelo())->crear($conexion, $idDiagnostico, [
            "fecha_diagnostico" => $datos["fecha_diagnostico"],
            "analisis_clinicos" => $analisis,
            "detalles_diagnosticos" => $detalles
        ]);
        return $idDiagnostico;
    }

    private function longitud(string $valor): int
    {
        return function_exists("mb_strlen") ? mb_strlen($valor, "UTF-8") : strlen($valor);
    }
}
