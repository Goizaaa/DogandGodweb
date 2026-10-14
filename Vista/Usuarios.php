<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios | Dog&amp;God</title>
    <script src="../Controlador/Usuari.js" defer></script>
    <script src="../Controlador/paginacionTablas.js?v=20261013-1" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261013-7">
</head>
<body class="vista-tablas">
<header>
    <?php include_once("include/header.php") ?>
</header>
    <main class="tabla-pagina-main">
      <section class="tabla-pagina-cabecera">
        <div>
            <p class="tabla-pagina-eyebrow">ADMINISTRACIÓN</p>
            <h1>Usuarios</h1>
            <p>Consulta y administra las cuentas registradas en el sistema.</p>
        </div>
      </section>
      <div class="tabla-contenedor">
        <table class="tabla-datos" id="tabla-usuarios">
            <thead>
            <tr>
                <th>id_usuario</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>Contraseña</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody id="cuerpo-tabla">
            </tbody>
        </table>
      </div>
    </main>
    
</body>
</html>

