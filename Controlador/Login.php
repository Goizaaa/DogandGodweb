<?php

class Database {

    private string $host = "localhost";
    private string $user = "root";
    private string $password = "root";
    private string $dbname = "bdveterinaria";

    private mysqli $conn;



    public function __construct() {

        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->dbname
        );

        if ($this->conn->connect_error) {

            die("Error de conexion: " . $this->conn->connect_error);

        }
    }





    public function create(string $table, array $data): bool {

        $columns = implode(", ", array_keys($data));

        $placeholders = implode(", ", array_fill(0, count($data), "?"));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $stmt = $this->conn->prepare($sql);

        $types = str_repeat("s", count($data));

        $stmt->bind_param($types, ...array_values($data));

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }





    public function read(string $table, string $condition = "1"): array {

        $sql = "SELECT * FROM $table WHERE $condition";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        $result = $stmt->get_result();

        $stmt->close();

        return $result->fetch_all(MYSQLI_ASSOC);
    }





    public function update(string $table, array $data, string $condition): bool {

        $set = implode(", ", array_map(fn($key) => "$key = ?", array_keys($data)));

        $sql = "UPDATE $table SET $set WHERE $condition";

        $stmt = $this->conn->prepare($sql);

        $types = str_repeat("s", count($data));

        $stmt->bind_param($types, ...array_values($data));

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }





    public function delete(string $table, string $condition): bool {

        $sql = "DELETE FROM $table WHERE $condition";

        $stmt = $this->conn->prepare($sql);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }





    public function __destruct() {

        $this->conn->close();
    }
}







$db = new Database();

function mostrarMensajeLogin(string $mensaje, string $icono): void {
    $mensajeSeguro = json_encode(
        $mensaje,
        JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
    );
    $iconoSeguro = json_encode($icono);

    echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Inicio de sesión</title>'
        . '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script></head><body>'
        . '<script>Swal.fire({icon:' . $iconoSeguro . ',text:' . $mensajeSeguro . '})'
        . '.then(() => { window.location.href = "../Vista/InicioSesion.php"; });</script>'
        . '</body></html>';
    exit;
}






if ($_SERVER["REQUEST_METHOD"] == "POST") {




    
    if (isset($_POST["crear"])) {

        $correo = trim($_POST["correo"]);
        $password = trim($_POST["password"]);
        $nombre = trim($_POST["nombre"]);



        $buscarUsuario = $db->read(
            "usuarios",
            "correo = '$correo'"
        );

        if (count($buscarUsuario) > 0) {

            mostrarMensajeLogin("El correo ya esta registrado", "error");

        } else {

            $passwordSegura = password_hash(
                $password,
                PASSWORD_DEFAULT
            );



            $crearUsuario = $db->create(
                "usuarios",
                [
                    "correo" => $correo,
                    "password" => $passwordSegura,
                    "nombre" => $nombre
                ]
            );



            if ($crearUsuario) {

                mostrarMensajeLogin("Cuenta creada correctamente", "success");

            } else {

                mostrarMensajeLogin("Error al crear la cuenta", "error");
            }
        }
    }









    
    if (isset($_POST["login"])) {

        $correo = trim($_POST["correo"]);
        $password = trim($_POST["password"]);




        $buscarUsuario = $db->read(
            "usuarios",
            "correo = '$correo'"
        );




        if (count($buscarUsuario) > 0) {

            $usuario = $buscarUsuario[0];



            if (
                password_verify(
                    $password,
                    $usuario["password"]
                )
            ) {

                mostrarMensajeLogin("Inicio de sesion correcto", "success");

            } else {

                mostrarMensajeLogin("Contraseña incorrecta", "error");
            }

        } else {

            mostrarMensajeLogin("El usuario no existe", "error");
        }
    }
}

?>