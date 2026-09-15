<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respaldo de Datos</title>
    <link rel="stylesheet" href="../vista/modificar.css">
</head>

<body>
<header>
    <h1>Respaldo de Datos</h1>
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
        <aside>
            <nav>
                <ul>
                    <li>Informacion General </li>
                    <li>Consultas realizadas</li>
                    <li>Procedimientos</li>
                    <li>Resultados de laboratorio</li>
                    <li>Radiografías</li>
                </ul>
            </nav>
        </aside>
        <section>
<!-- En tu archivo .php o .html de la vista -->
<div class="container">
    <h2>Gestión de Base de Datos</h2>
    <p>Haz clic abajo para descargar una copia de seguridad actual (.sql).</p>
    

    <form action="../Controlador/controladorrespaldo.php" method="POST">    <button type="submit" class="btn-backup">Generar Respaldo Ahora</button>
</form>

</div>

        </section>
    </main>



</body>

</html>