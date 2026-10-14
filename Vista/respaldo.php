<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respaldo de Datos</title>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261014-3">
</head>

<body class="vista-formularios">
<header>
    <?php include_once("include/header.php") ?>
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

