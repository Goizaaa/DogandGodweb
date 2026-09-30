<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cita</title>
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
            <label>Agregar Nueva Cita</label>
        </section>

        <div>
            <form id="frmAgregarCita">
                <label>Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>

                <label>Hora:</label>
                <input type="time" id="hora" name="hora" required>

                <label>Procedimiento / Servicio:</label>
                <select id="procedimiento" name="procedimiento" required>
                    <option value="Consulta Médica">Consulta Médica</option>
                    <option value="Estética">Estética</option>
                    <option value="Revisión">Revisión</option>
                    <option value="Vacunación">Vacunación</option>
                    <option value="Otro">Otro</option>
                </select>

                <label>Correo del Tutor:</label>
                <input type="email" id="correo_tutor" name="correo_tutor" placeholder="ejemplo@tutor.com" required>

                <label>Correo del Veterinario:</label>
                <input type="email" id="correo_veterinario" name="correo_veterinario" placeholder="ejemplo@vet.com" required>

                <section class="buscador">
                    <button type="submit" id="btnGuardar">Agendar Cita</button>
                    <button type="button" id="btnVolver" onclick="location.href='ConsultarCita.php'">Volver</button>
                </section>
            </form>
        </div>
    </main>

</body>

</html>