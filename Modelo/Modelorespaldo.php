<?php 
class Modelorespaldo { 
    private $host = 'localhost'; 
    private $user = 'root'; 
    private $pass = ''; 
    private $dbname = 'bdveterinaria'; 

    public function crearBackup() { 
        $desktop = getenv('USERPROFILE') . DIRECTORY_SEPARATOR . 'Desktop';
        $backupDir = $desktop . DIRECTORY_SEPARATOR . 'RespaldoVeterinaria' . DIRECTORY_SEPARATOR;
        
        if (!file_exists($backupDir)) { 
            mkdir($backupDir, 0777, true); 
        } 
        
        $fecha = date("Y-m-d_H-i-s"); 
        $filename = $backupDir . $this->dbname . "_" . $fecha . ".sql"; 
        
        $dumpPath = 'C:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin\\mysqldump.exe';
        
        if (!file_exists($dumpPath)) {
            $dumpPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
        }
        if (!file_exists($dumpPath)) {
            $dumpPath = 'C:\\wamp64\\bin\\mysql\\mysql5.7.31\\bin\\mysqldump.exe';
        }
        
        // Comando para respaldo
        if(empty($this->pass)) {
            $command = "\"$dumpPath\" -u {$this->user} -h {$this->host} {$this->dbname} > \"$filename\" 2>&1";
        } else {
            $command = "\"$dumpPath\" -u {$this->user} -p{$this->pass} -h {$this->host} {$this->dbname} > \"$filename\" 2>&1";
        }
        
        $output = shell_exec($command);
        
        if (file_exists($filename) && filesize($filename) > 0) {
            return $filename;
        } else {
            // Registrar error para depuración
            error_log("Error backup: " . $output);
            return false;
        }
    } 
} 
?>