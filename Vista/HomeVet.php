<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title> hOME</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/carousel/">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .carousel {
        margin-bottom: 4rem;
      }
      .carousel-caption {
        bottom: 3rem;
        z-index: 10;
      }
      .carousel-item {
        height: 36rem;
        background-color: #777;
      }
      .carousel-item > img {
        position: absolute;
        top: 0;
        left: 0;
        min-width: 100%;
        height: 36rem;
        object-fit: cover;
      }
      .marketing .col-lg-4 {
        margin-bottom: 1.5rem;
        text-align: center;
      }
      .marketing h2 {
        font-weight: 400;
      }
      .marketing .col-lg-4 p {
        margin-right: .75rem;
        margin-left: .75rem;
      }
      .featurette-divider {
        margin: 5rem 0;
      }
      .featurette-heading {
        font-weight: 300;
        line-height: 1;
        letter-spacing: -.05rem;
      }
      @media (min-width: 40em) {
        .carousel-caption p {
          margin-bottom: 1.25rem;
          font-size: 1.25rem;
          line-height: 1.4;
        }
        .featurette-heading {
          font-size: 50px;
        }
      }
      @media (min-width: 62em) {
        .featurette-heading {
          margin-top: 7rem;
        }
      }
    </style>
  </head>
  <body>
    
<header>
    <!-- Encabezado Dog&God -->
    <?php include_once("include/header.php") ?>
</header>

<main>

  <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="../recursos/citbann.png" alt="Expediente" width="800" height="800">
        <div class="container">
          <div class="carousel-caption text-start">
            <h1 style="color: black; background-color: rgba(121, 104, 104, 0.29);">Citas para hoy.</h1>
            <p style="color: black; background-color: rgba(121, 104, 104, 0.29);">Revisa tus citas programadas para el día de hoy.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Entrar</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="../recursos/invbann.png" alt="Inventario" width="800" height="800">
        <div class="container">
          <div class="carousel-caption">
            <h1>Revisa tu inventario.</h1>
            <p>Consulta el estado de tu inventario de medicamentos y productos.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Mirar</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img src="../recursos/bann1.png" alt="Expediente" width="800" height="800">
        

        <div class="container">
          <div class="carousel-caption text-end">
            
            <h1>Expedientes</h1>
            <p>Aqui consulta los expedientes de tus pacientes.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Explorar</a></p>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>
  </div>


  
  <div class="container marketing">

   
    <div class="text-center mb-5">
      <h2 style="border: 2px solid black; padding: 10px;">
        Hola Veterinario
      </h2>
      <div class="my-3">
        <h3>¿ QUE HACER?</h3>
      </div>
      
      <div class="my-3">
        <button class="btn btn-outline-dark" onclick="location.href='respaldo.html'">respaldo</button>
      </div>
    </div>

    <!-- Three columns of text below the carousel -->
    <div class="row">
      <div class="col-lg-4">
        <img class="rounded-circle" src="../recursos/icon1.jpg" alt="Inventario" width="140" height="140" style="object-fit: cover;">
        <h2>Inventario</h2>
        <p>Revisa en cada instante como esta tu inventario.</p>
        <p><a class="btn btn-secondary" href="actualizar_inventario.php">View details &raquo;</a></p>
      </div>
      <div class="col-lg-4">
        <img class="rounded-circle" src="../recursos/icon2.jpg" alt="Tutores" width="140" height="140" style="object-fit: cover;">
        <h2>Tutores</h2>
        <p>Administra la información de los tutores de tus pequeños pacientes.</p>
        <p><a class="btn btn-secondary" href="Usuarios.php">View details &raquo;</a></p>
      </div>
      <div class="col-lg-4">
        <img class="rounded-circle" src="../recursos/icon3.jpg" alt="Mascota" width="140" height="140" style="object-fit: cover;">

        <h2>Mascota</h2>
        <p>Administra la información de tus pequeños pacientes.</p>
        <p><a class="btn btn-secondary" href="Mascota.php">View details &raquo;</a></p>
      </div>
      <div class="col-lg-4">
        <img class="rounded-circle" src="../recursos/icon4.jpg" alt="Expedientes" width="140" height="140" style="object-fit: cover;">

        <h2>Expedientes</h2>
        <p>Puedes gestionar los expedientes de tus pacientes de manera eficiente.</p>
        <p><a class="btn btn-secondary" href="consultarhis.php">View details &raquo;</a></p>
      </div>
      <div class="col-lg-4">
        <img class="rounded-circle" src="../recursos/icon5.jpg" alt="Registrar Cita" width="140" height="140" style="object-fit: cover;">

        <h2>Registrar Cita</h2>
        <p>Revisa cuando tienes que ver a tus pacientes.</p>
        <p><a class="btn btn-secondary" href="ConsultarCita.php">View details &raquo;</a></p>
      </div>
      <div class="col-lg-4">
        <img class="rounded-circle" src="../recursos/icon6.jpg" alt="Buscar Historial" width="140" height="140" style="object-fit: cover;">

        <h2>Buscar Historial</h2>
        <p>Busca y consulta el historial médico de tus pacientes.</p>
        <p><a class="btn btn-secondary" href="buscarhist.php">View details &raquo;</a></p>
      </div>
    </div>



  </div>


  <!-- FOOTER -->
  <footer class="container">
    <p class="float-end"><a href="#">Back to top</a></p>
    <p>&copy; 2017–2021 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
  </footer>
</main>

    <!-- JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>