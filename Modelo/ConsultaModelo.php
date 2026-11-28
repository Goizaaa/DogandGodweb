<?php
class ConsultaModelo
{
    public function crear(PDO $conexion, string $idConsulta, string $idMascota, string $idDiagnostico, string $idTratamiento, array $datos): void
    {
        $sql = "INSERT INTO consulta
                    (id_consulta, fecha, temperatura, peso_consulta, id_diagnostico,
                     id_cita, id_mascota, datos_ad, id_tratamiento)
                VALUES (:id, :fecha, :temperatura, :peso, :diagnostico, :cita, :mascota, :datos_ad, :tratamiento)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ":id" => $idConsulta,
            ":fecha" => $datos["fecha"],
            ":temperatura" => $datos["temperatura"],
            ":peso" => $datos["peso_consulta"],
            ":diagnostico" => $idDiagnostico,
            ":cita" => $datos["id_cita"],
            ":mascota" => $idMascota,
            ":datos_ad" => $datos["frecuencia_card"] === "" ? null : "Frecuencia cardíaca: " . $datos["frecuencia_card"] . " ppm",
            ":tratamiento" => $idTratamiento
        ]);
    }

    public function obtenerPorMascota(PDO $conexion, string $idMascota): array
    {
        $sql = "SELECT c.id_consulta, c.fecha, c.temperatura, c.peso_consulta, c.datos_ad,
                       d.analisis_clinicos, d.detalles_diagnosticos,
                       t.nombre_medicamento, t.dosis, t.frecuencia_administracion,
                       t.fecha_inicial, t.fecha_final
                FROM consulta c
                LEFT JOIN diagnostico d ON d.id_diagnostico = c.id_diagnostico
                LEFT JOIN tratamiento t
                    ON t.id_tratamiento = c.id_tratamiento
                    OR (c.id_tratamiento IS NULL AND t.id_diagnostico = c.id_diagnostico)
                WHERE c.id_mascota = :mascota
                ORDER BY c.fecha DESC, c.id_consulta DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([":mascota" => $idMascota]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
