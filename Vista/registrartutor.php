<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Tutor</title>
    <link rel="stylesheet" href="../vista/modificar.css">
    <script src="../Controlador/cntrolTutor.js"></script>
</head>
<body>
<header>
    <h1>Registrar Tutor</h1>
    <nav>
        <button class="botonEncabezado" onclick="location.href='HomeVet.html'">Inicio</button>
        <button class="botonEncabezado" onclick="location.href='consultartutores.html'">Tutores</button>
        <button class="botonEncabezado" onclick="location.href='consultarhis.html'">Historiales</button>
        <button class="botonEncabezado" onclick="location.href='SolicitarCita.html'">Citas</button>
        <button class="botonEncabezado" onclick="location.href='respaldo.html'">Inventario</button>
        <button class="botonEncabezado" onclick="location.href='respaldo.html'">Configuración</button>
    </nav>
</header>
    <main>
        <form class="register-form" id="register-tutor-form">
            <label>Correo Electrónico:</label>
            <input type="email" name="correo_tutor" id="correoTutor" required>

            <label>Nombre del tutor:</label>
            <input type="text" name="nom_tutor" id="nomTutor" required>

            <label>Apellido Paterno:</label>
            <input type="text" name="app_tutor" id="appTutor" required>

            <label>Apellido Materno:</label>
            <input type="text" name="apm_tutor" id="apmTutor" required>

            <label>Teléfono:</label>
            <input type="text" name="numtel_tutor" id="numtelTutor" required>

            <label>Sexo:</label>
            <select id="sexoTutor" name="sexo">
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otro">Otro</option>
            </select>

            <label>Dirección:</label>
            <input type="text" name="direccion" id="direccionTutor" required>

            <input type="submit" value="Registrar Tutor">
        </form>
    </main>
</body>
</html>