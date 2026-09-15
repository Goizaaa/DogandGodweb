<?php
// Asegurar que no hay salida antes
ob_start();

require_once __DIR__ . '/../Modelo/Modelorespaldo.php';

class controladorrespaldo { 
    public function generar() {
        $model = new Modelorespaldo();
        $ruta = $model->crearBackup();
        
        // Limpiar cualquier salida previa
        ob_end_clean();
        
        if ($ruta && file_exists($ruta)) {
            // Solo mostrar alerta y redirigir. NADA de header('Content-Type...')
            echo '<script>alert("Respaldo guardado en el escritorio (carpeta RespaldoVeterinaria)."); window.location.href = "../Vista/HomeVet.html";</script>';
            exit;
        } else {
            echo '<script>alert("Error al generar respaldo. Revisa la ruta de mysqldump."); window.location.href = "../Vista/respaldo.html";</script>';
            exit;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new controladorrespaldo();
    $controller->generar();
}
?>