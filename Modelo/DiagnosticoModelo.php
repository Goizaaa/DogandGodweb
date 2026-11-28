<?php
class DiagnosticoModelo
{
    public function crear(PDO $conexion, string $idDiagnostico, array $datos): void
    {
        $sql = "INSERT INTO diagnostico
                    (id_diagnostico, fecha_diagnostico, analisis_clinicos, detalles_diagnosticos)
                VALUES (:id, :fecha, :analisis, :detalles)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ":id" => $idDiagnostico,
            ":fecha" => $datos["fecha_diagnostico"],
            ":analisis" => $datos["analisis_clinicos"] === "" ? null : $datos["analisis_clinicos"],
            ":detalles" => $datos["detalles_diagnosticos"]
        ]);
    }
}
