<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Consultar Tutores</title>
    <script src="../Controlador/cntrolTutor.js"></script>
</head>
<body>

<header>
    
        <!--encabezado-->
        <?php include_once("include/header.php") ?>
        <!--fin encabezado-->

    </header>

    <main class="listatut">
<section>
                <h2>Lista de Tutores</h2>
            <button class="btn-nuevo" onclick="location.href='registrartutor.html'">+ Nuevo Tutor</button>
                            <button class="btn-nuevo" onclick="location.href='asignarTutor.html'">Relacionar Mascota con Tutor</button>
</section>


                <table class="table table-hover" id="tablaTutores">
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

    </main>
</body>
</html>