<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cita</title>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261014-3">
</head>
<body class="vista-morada-vet">
<header>
    <?php include_once("include/header.php") ?>
</header>
    
    <h1>
       
    </h1>
    <h2>Registrar cita</h2>

    <div id="contenedor">
    <section id="formulario">
          <form>

                    <label>Fecha</label>
                    <input type="date" id="fecha">                   
                    <label>Hora</label>
                    <input type="time" id="hora">
                    <label>Servicio:</label>
                    <select id="servicio">
                        <option value="cita">Cita medica</option>
                        <option value="estetica">Estetica</option>
                        <option value="revisin">Revisión</option>
                        <option value="vacuna">Vacunación</option>
                        <option value="otro">Otro</option>
                    </select>


                    <label>Mascota:</label>
                    <select id="mascota">
                        <option value="gato">Kira</option>
                        <option value="perro">Nick</option>


                    </select>
      
            </form>
         <input type="submit" value="agendar cita">

        </section>

        <div id="imagen">
            <img src="../recursos/calendario.png" alt="">
        </div>

    </div>
</body>
</html>

