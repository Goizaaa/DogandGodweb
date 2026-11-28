<?php
class TratamientoModelo
{
    public function crear(PDO $conexion, string $idTratamiento, string $idDiagnostico, array $datos): void
    {
        $sql = "INSERT INTO tratamiento
                    (id_tratamiento, frecuencia_administracion, fecha_inicial, fecha_final,
                     nombre_medicamento, dosis, id_diagnostico)
                VALUES (:id, :frecuencia, :fecha_inicial, :fecha_final, :medicamento, :dosis, :diagnostico)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ":id" => $idTratamiento,
            ":frecuencia" => $datos["frecuencia_administracion"],
            ":fecha_inicial" => $datos["fecha_inicial"],
            ":fecha_final" => $datos["fecha_final"],
            ":medicamento" => $datos["nombre_medicamento"],
            ":dosis" => $datos["dosis"],
            ":diagnostico" => $idDiagnostico
        ]);
    }
}
