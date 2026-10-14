<!DOCTYPE html> 
<html lang="es">
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Registrar Expediente</title> 
    <script src="../controlador/cntrolRegistrar.js"></script> 
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261014-3">
</head> 
<body class="vista-formularios">
<header>
    <?php include_once("include/header.php") ?>
</header>
<main> 
    <form class="register-form" id="register-form"> 
        <label>Nombre de la mascota:</label> 
        <input type="text" name="nom_mascota" id="nomMascota"> 

        <label>Ingrese la especie:</label> 
        <input type="text" name="especie" id="especie"> 

        <label>Ingrese la raza:</label> 
        <input type="text" name="raza" id="raza"> 

        <label>Ingrese la fecha de nacimiento aproximada:</label> 
        <input type="date" name="fecha_adopcion" id="fecNac"> 

        <label>Ingrese el peso:</label> 
        <input type="text" name="peso_inicial" id="peso"> 

        <label>Sexo:</label> 
        <select id="mascota" name="sexo"> 
            <option value="Hembra">Hembra</option> 
            <option value="Macho">Macho</option> 
        </select> 

        <label>Esterilizado:</label> 
        <select id="esterilizado" name="esterilizado"> 
            <option value="1">Sí</option> 
            <option value="0">No</option> 
        </select> 

        <input type="hidden" id="id_mascota" name="id_mascota"> 

        <input type="submit" value="Registrar"> 
    </form> 
</main> 
</body> 
</html>


