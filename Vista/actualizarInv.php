<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Actualizar Inventario</title>
    <link rel="stylesheet" href="../Vista/modificar.css">
    <script src="../Controlador/cntrl.js"></script>
</head>

<body>


    <main class="buscar">
        <section class="buscador">
            <label>Tipo:</label>
            <input type="text" name="buscarMascota" id="buscarMascota" placeholder="Buscar mascota">

            <label>Nombre tutor:</label>
            <input type="text" name="buscarTutor" id="buscarTutor" placeholder="Buscar tutor">
            
            <button id="btnBuscar">Buscar</button>
        </section>
        <h1>Esta es una prueba</h1>
        <div>
            <table id="tabla">
                <thead>
                    <tr>
                        <th>ID Mascota</th>
                        <th>Nombre Mascota</th>
                        <th>Especie</th>
                        <th>Raza</th>
                        <th>Fecha Adopcion</th>
                        <th>Sexo</th>
                        <th>Esterilizado</th>
                        <th>Nombre Tutor</th>
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