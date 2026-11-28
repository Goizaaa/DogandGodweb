<?php
require_once __DIR__ . "/../Modelo/TratamientoModelo.php";

class TratamientoControlador
{
    public function registrar(PDO $conexion, string $idDiagnostico, array $datos): string
    {
        $medicamento = trim($datos["nombre_medicamento"] ?? "");
        $dosis = trim($datos["dosis"] ?? "");
        $frecuencia = trim($datos["frecuencia_administracion"] ?? "");
        $fechaInicial = trim($datos["fecha_inicial"] ?? "");
        $fechaFinal = trim($datos["fecha_final"] ?? "");
        $limitesValidos = $medicamento !== "" && $this->longitud($medicamento) <= 100
            && $dosis !== "" && $this->longitud($dosis) <= 50
            && $frecuencia !== "" && $this->longitud($frecuencia) <= 100;
        if (!$limitesValidos || !$this->fechaValida($fechaInicial) || !$this->fechaValida($fechaFinal) || $fechaFinal < $fechaInicial) {
            throw new InvalidArgumentException("Revisa medicamento, dosis, frecuencia y vigencia del tratamiento.");
        }

        $idTratamiento = "TRAT-" . strtoupper(bin2hex(random_bytes(12)));
        (new TratamientoModelo())->crear($conexion, $idTratamiento, $idDiagnostico, [
            "nombre_medicamento" => $medicamento,
            "dosis" => $dosis,
            "frecuencia_administracion" => $frecuencia,
            "fecha_inicial" => $fechaInicial,
            "fecha_final" => $fechaFinal
        ]);
        return $idTratamiento;
    }

    private function fechaValida(string $fecha): bool
    {
        $valor = DateTime::createFromFormat("!Y-m-d", $fecha);
        return $valor !== false && $valor->format("Y-m-d") === $fecha;
    }

    private function longitud(string $valor): int
    {
        return function_exists("mb_strlen") ? mb_strlen($valor, "UTF-8") : strlen($valor);
    }
}
