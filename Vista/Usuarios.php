<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TabUsuarios</title>
    <link rel="stylesheet" href="../css/VUsuario.css">
    <script src="../Controlador/Usuari.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261012-4">
</head>
<body>
<header>
    <?php include_once("include/header.php") ?>
</header>
    <section id="Tabusuarios">
        <h1>Tabla de Usuarios</h1>
        <h2>Listado de Usuarios</h2>

        <table id="tabla-usuarios">
            <thead>
            <tr>
                <th>id_usuario</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>Contraseña</th>
            </tr>
            </thead>
            <tbody id="cuerpo-tabla">
   
        </table>



    </section>
    
</body>
</html>

