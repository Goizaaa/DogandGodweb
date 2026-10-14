<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Consultar Tutores</title>
    <script src="../Controlador/cntrolTutor.js" defer></script>
    <script src="../Controlador/paginacionTablas.js?v=20261013-1" defer></script>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261013-7">
</head>
<body class="vista-tablas">

<header>
    
        <!--encabezado-->
        <?php include_once("include/header.php") ?>
        <!--fin encabezado-->

    </header>

    <main class="tabla-pagina-main">
        <section class="tabla-pagina-cabecera">
            <div>
                <p class="tabla-pagina-eyebrow">DIRECTORIO</p>
                <h1>Lista de tutores</h1>
                <p>Consulta y administra la información de los tutores registrados.</p>
            </div>
            <div class="tabla-pagina-acciones">
                <a class="btn-nuevo" href="registrartutor.php">+ Nuevo tutor</a>
                <a class="btn-nuevo btn-secundario" href="asignarTutor.php">Relacionar mascota con tutor</a>
            </div>
        </section>
        <div class="tabla-contenedor">
            <table class="tabla-datos" id="tablaTutores">
                    <thead>
                        <tr>
                            <th>Correo</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Teléfono</th>
                            <th>Sexo</th>
                            <th>Dirección</th>
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
