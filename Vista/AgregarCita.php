<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cita</title>
    <link rel="stylesheet" href="../Vista/modificar.css">
    <script src="../Controlador/cntrolCita.js"></script>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261012-4">
</head>

<body>
    <header>
        <!--encabezado-->
        <?php include_once("include/header.php") ?>
        <!--fin encabezado-->
    </header>

    <main class="buscar">
        <section class="buscador">
            <label>Agregar Nueva Cita</label>
        </section>

        <div style="max-width: 600px; margin: 20px auto; padding: 20px;">
            <form id="frmAgregarCita" style="display: flex; flex-direction: column; gap: 15px;">
                <div>
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" required style="width: 100%; padding: 8px;">
                </div>

                <div>
                    <label for="hora">Hora:</label>
                    <input type="time" id="hora" name="hora" required style="width: 100%; padding: 8px;">
                </div>

                <div>
                    <label for="procedimiento">Procedimiento / Servicio:</label>
                    <select id="procedimiento" name="procedimiento" required style="width: 100%; padding: 8px;">
                        <option value="Consulta Médica">Consulta Médica</option>
                        <option value="Estética">Estética</option>
                        <option value="Revisión">Revisión</option>
                        <option value="Vacunación">Vacunación</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div>
                    <label for="correo_tutor">Correo del Tutor:</label>
                    <input type="email" id="correo_tutor" name="correo_tutor" placeholder="ejemplo@tutor.com" required style="width: 100%; padding: 8px;">
                </div>

                <div>
                    <label for="correo_veterinario">Correo del Veterinario:</label>
                    <input type="email" id="correo_veterinario" name="correo_veterinario" placeholder="ejemplo@vet.com" required style="width: 100%; padding: 8px;">
                </div>

                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="submit" id="btnGuardarCita">Agendar Cita</button>
                    <a class="btn btn-secondary" href="ConsultarCita.php">Volver</a>
                </div>
            </form>
        </div>
    </main>

</body>

</html>

