<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Registrar Expediente</title> 
    <link rel="stylesheet" href="../vista/modificar.css"> 
    <script src="../controlador/cntrolRegistrar.js"></script> 
</head> 
<body> 
<header>
    <h1>Registrar expediente</h1>
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
