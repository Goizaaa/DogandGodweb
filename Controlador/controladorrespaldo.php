<?php
// Asegurar que no hay salida antes
ob_start();

require_once __DIR__ . '/../Modelo/Modelorespaldo.php';

class controladorrespaldo { 
    private function mostrarResultado($mensaje, $icono) {
        $mensajeSeguro = json_encode(
            $mensaje,
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
        );
        $iconoSeguro = json_encode($icono);

        echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Respaldo</title>'
            . '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body>'
            . '<script>Swal.fire({icon:' . $iconoSeguro . ',text:' . $mensajeSeguro . '})'
            . '.then(() => { window.location.href = "../Vista/HomeVet.php"; });</script>'
            . '</body></html>';
        exit;
    }

    public function generar() {
        $model = new Modelorespaldo();
        $ruta = $model->crearBackup();
        
        // Limpiar cualquier salida previa
        ob_end_clean();
        
        if ($ruta && file_exists($ruta)) {
            $this->mostrarResultado("Respaldo guardado en el escritorio (carpeta RespaldoVeterinaria).", "success");
        } else {
            $this->mostrarResultado("Error al generar respaldo. Revisa la ruta de mysqldump.", "error");
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new controladorrespaldo();
    $controller->generar();
}
?>