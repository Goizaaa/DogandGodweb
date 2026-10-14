<?php
require_once "../config/conexion.php";

class ConsultaModelo {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function registrarConsultaCompleta($datos) {
        try {
            $this->db->beginTransaction();

            $id_diagnostico = "DIAG-" . time();
            $id_consulta = "CONS-" . time();
            $id_tratamiento = "TRAT-" . time();

            // 1. Inserción en 'diagnostico'
            $sqlDiag = "INSERT INTO diagnostico (id_diagnostico, fecha_diagnostico, analisis_clinicos, detalles_diagnosticos) 
                        VALUES (:id_diag, :fecha_diag, :analisis, :detalles)";
            $stmtDiag = $this->db->prepare($sqlDiag);
            $stmtDiag->execute([
                ':id_diag'     => $id_diagnostico,
                ':fecha_diag'  => !empty($datos['fecha']) ? $datos['fecha'] : NULL,
                ':analisis'    => !empty($datos['analisis_clinicos']) ? substr($datos['analisis_clinicos'], 0, 100) : NULL,
                ':detalles'    => !empty($datos['detalles_diagnosticos']) ? substr($datos['detalles_diagnosticos'], 0, 100) : NULL
            ]);

            // 2. Inserción en 'consulta'
            $sqlCons = "INSERT INTO consulta (id_consulta, fecha, temperatura, peso_consulta, frecuencia_card, id_diagnostico, id_cita) 
                        VALUES (:id_cons, :fecha, :temp, :peso, :freq, :id_diag, :id_cita)";
            $stmtCons = $this->db->prepare($sqlCons);
            $stmtCons->execute([
                ':id_cons'   => $id_consulta,
                ':fecha'     => $datos['fecha'],
                ':temp'      => !empty($datos['temperatura']) ? $datos['temperatura'] : NULL,
                ':peso'      => $datos['peso_consulta'],
                ':freq'      => !empty($datos['frecuencia_card']) ? $datos['frecuencia_card'] : NULL,
                ':id_diag'   => $id_diagnostico,
                ':id_cita'   => !empty($datos['id_cita']) ? $datos['id_cita'] : NULL
            ]);

            // 3. Inserción en 'tratamiento'
            $sqlTrat = "INSERT INTO tratamiento (id_tratamiento, frecuencia_administracion, fecha_inicial, fecha_final, nombre_medicamento, dosis, id_diagnostico) 
                        VALUES (:id_trat, :freq_admin, :fecha_ini, :fecha_fin, :medicamento, :dosis, :id_diag)";
            $stmtTrat = $this->db->prepare($sqlTrat);
            $stmtTrat->execute([
                ':id_trat'    => $id_tratamiento,
                ':freq_admin' => substr($datos['frecuencia_administracion'], 0, 100),
                ':fecha_ini'  => $datos['fecha_inicial'],
                ':fecha_fin'  => $datos['fecha_final'],
                ':medicamento' => substr($datos['nombre_medicamento'], 0, 100),
                ':dosis'      => substr($datos['dosis'], 0, 50),
                ':id_diag'    => $id_diagnostico
            ]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error BD: " . $e->getMessage());
            return false;
        }
    }

    // Consulta con JOIN uniendo consulta, diagnostico y tratamiento para la tabla del expediente
    public function obtenerConsultasRegistradas() {
        $sql = "SELECT 
                    c.fecha AS fecha,
                    COALESCE(d.detalles_diagnosticos, 'Sin diagnóstico') AS diagnostico,
                    CONCAT(t.nombre_medicamento, ' (', t.dosis, ') - ', t.frecuencia_administracion) AS tratamiento
                FROM consulta c
                LEFT JOIN diagnostico d ON c.id_diagnostico = d.id_diagnostico
                LEFT JOIN tratamiento t ON d.id_diagnostico = t.id_diagnostico
                ORDER BY c.fecha DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}