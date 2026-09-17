
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Consultar historial </title>
    <link rel="stylesheet" href="../Vista/modificar.css">
-
    <script src="../controlador/consultarHistorial.js"></script>
</head>

<body>

<header>
    
        <!--encabezado-->
        <?php include_once("include/header.php") ?>
        <!--fin encabezado-->

    </header>

    <main>
    <aside>
    <!--nav bar laterial-->
    <ul class="nav flex-column">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page"  id="btnGeneral">Informacion General</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="btnConsultas">Consultas realizadas</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="btnProcedimientos">Procedimientos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="btnLaboratorio">Resultados de laboratorio</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="btnRadiografias">Radiografías</a>
  </li>
  <li class="nav-item" >
    <a class="nav-link" onclick="location.href='modificarhist.php'">Modificar</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" onclick="location.href='eliminarhist.html'">Eliminar</a>
  </li>
</ul>
</aside>
<!-- terrmina nav bar laterial-->
      

        <section>
            <article id="informacionGeneral">
                <h2>Información General</h2>
                <table id="tabla" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre Mascota</th>
                            <th>Nombre Tutor</th>
                            <th>Especie</th>
                            <th>Raza</th>
                            <th>Fecha Nacimiento</th>
                            <th>Sexo</th>
                            <th>Esterilizado</th>
                            <th>Teléfono</th>
                        </tr>
                    </thead>
                    <tbody></tbody> 
                </table>
            </article>

            <article id="consultas">
                <h2>Consultas realizadas</h2>
                <table id="tablaConsultas">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Diagnóstico</th>
                            <th>Tratamiento</th>
                        </tr>
                    </thead>
                     <tbody></tbody>
                </table>
            </article>

            <article id="procedimientos">
                <h2>Procedimientos</h2>
                <table id="tablaProcedimientos">
                    <thead>
                        <tr>
                            <th>Procedimiento</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                     <tbody></tbody>
                </table>
            </article>

            <article id="laboratorio">
                <h2>Resultados de laboratorio</h2>
                <table id="tablaLaboratorio">
                    <thead>
                        <tr>
                            <th>Análisis: </th>
                            <th>Resultados</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                     <tbody></tbody>
                </table>
            </article>

            <article id="radiografias">
                <h2>Radiografías</h2>
                <table id="tablaRadiografias">
                    <thead>
                        <tr>
                            <th>Radiografía</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                     <tbody></tbody>
                </table>
            </article>
        </section>
        <input type="hidden" id="id_mascota" name="id_mascota">
    </main>
    <script>
        // Obtener el ID de la mascota (puede venir de la URL o del campo hidden)
        const urlParams = new URLSearchParams(window.location.search);
        const idMascota = urlParams.get('id_mascota') || document.getElementById("id_mascota")?.value || "id_mascota";
        
        // Guardar el ID en localStorage para usarlo en modificarhist.html
        localStorage.setItem("id_mascota_editar", idMascota);
        
        console.log("ID de mascota guardado en localStorage:", idMascota);
    </script>
</body>

</html>
