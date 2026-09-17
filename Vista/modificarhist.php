<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Modificar historial</title>
    <link rel="stylesheet" href="../vista/modificar.css">
    <script src="../Controlador/modificarHistorial.js"></script>
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
    <a class="nav-link" onclick="location.href='eliminarhist.php'">Eliminar</a>
  </li>
</ul>
</aside>
<!-- terrmina nav bar laterial-->
 
 

<!-- formulario -->


<form class="row g-3" id="modificar">
  <div class="col-md-4">
    <label for="validationServer01" class="form-label">Peso:</label>
    <input type="text" id="peso" name="peso_inicial" class="form-control is-valid" required>
  </div>

  <div class="col-md-3">
    <label for="validationServer04" class="form-label">Esterilizado:</label>
    <select class="form-select is-invalid" id="esterilizado" name="esterilizado" aria-describedby="validationServer04Feedback" required>
        <option value="1">Si</option>
        <option value="0">No</option>    </select>
    <div id="validationServer04Feedback" class="invalid-feedback">
      Por favor seleccione una opción.
    </div>
  </div>


  <div class="col-12">
    <button id="btnModificar" class="btn btn-primary" type="submit">Aceptar</button>
  </div>
</form>
            
            <!-- Tu campo hidden indispensable -->
            <input type="hidden" id="id_mascota" name="id_mascota">
        </section>
    </main>

    <dialog id="modalConfirmar" style="padding: 20px; border-radius: 8px; border: 1px solid #ccc; text-align: center;">
        <h3>¿Confirmar cambios?</h3>
        <p>¿Estás seguro de que deseas actualizar el peso y estado de esterilización?</p>
        <button id="btnCancelarModal">Cancelar</button>
        <button id="btnAceptarModal" style="background-color: #4CAF50; color: white;">Sí, Guardar</button>
    </dialog>

    <dialog id="modalExito" style="padding: 20px; border-radius: 8px; border: 1px solid #ccc; text-align: center;">
        <h3>¡Éxito!</h3>
        <p>El expediente ha sido actualizado correctamente.</p>
        <button id="btnCerrarExito">OK</button>
    </dialog>
</body>
</html>
