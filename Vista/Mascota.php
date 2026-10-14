<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mascotas</title>
    <script src="../controlador/cntrl.js" defer></script>
    <script src="../Controlador/paginacionTablas.js?v=20261013-1" defer></script>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261014-3">
</head>
<body class="vista-tablas">
<header>
    <?php include_once("include/header.php") ?>
</header>
    <main class="tabla-pagina-main">
        <section class="tabla-pagina-cabecera">
            <div>
                <p class="tabla-pagina-eyebrow">PACIENTES</p>
                <h1>Mascotas registradas</h1>
                <p>Consulta los datos de los pacientes y accede a sus historiales.</p>
            </div>
        </section>
        <div class="tabla-contenedor">
            <table class="tabla-datos" id="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Especie</th>
                        <th>Raza</th>
                        <th>Fecha Nacimiento</th>
                        <th>Peso (kg)</th>
                        <th>Sexo</th>
                        <th>Esterilizado</th>
                        <th>Tutor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </main>
</body>
</html>

