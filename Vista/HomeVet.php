<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Document</title>
        <link rel="stylesheet" href="../Vista/modificar.css"> 
</head>

<body>
    
<header>
    
        <!--encabezado-->
        <?php include_once("include/header.php") ?>
        <!--fin encabezado-->

    </header>

            <h2 style="border: 2px solid black; padding: 0%; text-align: center;">
            Hola Veterinario
        </h2>
        <button class="quehacer">
            ¿ QUE HACER?
        </button>

        <div class="home">
        <button class="quehome" onclick="location.href='consultartutores.html'">Tutores</button>
        <button class="quehome" onclick="location.href='Mascota.html'">Mascotas</button>
        <button class="quehome" onclick="location.href='registhist.html'">Expediente</button>
        <button class="quehome" onclick="location.href='buscarhist.html'">buscar por nombre</button>
        </div>

            <button class="quehacer" onclick="location.href='respaldo.html'">respaldo</button>

    
</body>
</html>