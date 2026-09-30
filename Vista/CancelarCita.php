<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Citas</title>
    <link rel="stylesheet" href="../Vista/modificar.css">
    <script src="../Controlador/cntrolCita.js"></script>
</head>

<body>
    <header>
        <!--encabezado-->
        <?php include_once("include/header.php") ?>
        <!--fin encabezado-->
    </header>

    <main class="buscar">
        <section class="buscador">
            <label>Citas registradas:</label>
            <a href="AgregarCita.php" style="text-decoration: none;">
                <button type="button" id="btnAgregarCita" style="padding: 8px 16px; cursor: pointer;">+ Agregar Cita</button>
            </a>
        </section>
         
        <div>
            <table class="table table-hover" id="tablaCitas">
                <thead>
                    <tr>
                        <th>ID Cita</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Procedimiento</th>
                        <th>Correo Tutor</th>
                        <th>Correo Veterinario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>