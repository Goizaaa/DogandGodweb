<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InicioSesion</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- CSS del Formulario Signin -->
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261022-1">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../Controlador/InicioSes.js?v=20261119-1"></script>
</head>

<body class="text-center vista-inicio-sesion">




<!-- Inicio Sesion -->


    <section id="inicio" class="w-100">
        <main class="form-signin m-auto">
            <form action="" id="registro" class="login-card">
                <img class="mb-4" src="../recursos/dog_house_icon_125964.png" alt="" width="72" height="72">
                <h1 class="h3 mb-3 fw-normal">Inicio Sesión</h1>

                <div class="form-floating" style="background-color: #8b8a8a;">
                    <input type="email" class="form-control" name="usuarioU" id="correoU" placeholder="nombre@ejemplo.com">
                    <label for="correoU">Ingresa tu correo</label>
                    
                </div>

                <div class="form-floating" >
                    <input type="password" class="form-control" name="contraseñaU" id="contraU" placeholder="Contraseña">
                    <label for="contraU">Ingresa tu contraseña</label>
                    <div id="passwordHelpBlock" class="form-text">
  La contraseña debe tener entre 8 y 20 caracteres, incluir letras y números, y no tener espacios ni caracteres especiales o emojis.
</div>
                </div>

                <div class="mensaje mb-2"></div>

                <button class="w-100 btn btn-lg btn-primary" type="submit" id="iniciosesion">Iniciar sesión</button>
                <p class="mt-5 mb-3 text-muted">&copy; Derechos reservados a Veterinaria Dog&God</p>         
                  

     <p>
        <a id="abrerecuperar" href="#abrerecuperar">¿Olvidaste tu contraseña?</a>
    </p>
    <p>
        <a id="abrecrear" href="#abrecrear">¿No tienes cuenta?</a>
    </p>
            </form>
        </main>
    </section>

 <!-- Rescuperar -->


    <section id="recuperar" class="w-100">
        <main class="form-signin m-auto" style="background-color: #8b8a8a70; border-radius: 20px; padding: 30px;">
            <form action="" style="background-color: #8b8a8a70; border-radius: 20px; padding: 30px;">
                <h1 class="h3 mb-2 fw-normal">Recuperar de cuenta</h1>
                <p class="text-muted mb-3">Ingresa tu correo de confirmación</p>

                <div class="form-floating mb-3" >
                    <input type="email" class="form-control" name="usuarioD" id="usuarioD" placeholder="nombre@ejemplo.com">
                    <label for="usuarioD">Ingresa tu correo</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary mb-3" type="button" id="CONFIRMAR" >Confirmar</button>
            </form>
        </main>
    </section>
    
    <dialog id="modal-recuperacion" class="p-4 border-0 rounded-4 shadow" aria-labelledby="titulo-modal-recuperacion" style="width: min(100% - 2rem, 460px);">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h2 class="h4 mb-1" id="titulo-modal-recuperacion">Recuperar contraseña</h2>
                <p class="text-muted mb-0" id="instruccion-recuperacion">Ingresa el código de 6 dígitos que enviamos a tu correo.</p>
            </div>
            <button type="button" class="btn-close" id="cerrar-modal-recuperacion" aria-label="Cerrar"></button>
        </div>
        <div id="mensaje-recuperacion" class="alert mb-3" role="status" aria-live="polite" hidden></div>

        <div id="paso-codigo-recuperacion">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="usuarioC" placeholder="Código" inputmode="numeric" autocomplete="one-time-code" maxlength="6">
                <label for="usuarioC">Código de confirmación</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="button" id="ConfirC">Confirmar código</button>
        </div>

        <div id="paso-nueva-contrasena" hidden>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="contraseñaT" placeholder="Nueva contraseña" autocomplete="new-password">
                <label for="contraseñaT">Nueva contraseña</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="contraseñadTR" placeholder="Confirma tu contraseña" autocomplete="new-password">
                <label for="contraseñadTR">Confirma tu nueva contraseña</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="button" id="Restabtn">Guardar nueva contraseña</button>
        </div>
    </dialog>

<!-- crear cuenta -->
    <section id="crear" class="w-100">
        <main class="form-signin m-auto" style="max-width: 440px;">
            <form action="" style="background-color: #8b8a8a70; border-radius: 20px; padding: 30px;">
                <img class="mb-4" src="../recursos/dog_house_icon_125964.png" alt="" width="72" height="72">
                <h1 class="h3 mb-2 fw-normal">Crea tu cuenta</h1>
                <p class="text-muted mb-3">Ingresa tus datos para registrarte</p>
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" name="NombreUs" id="NomU" placeholder="Nombre">
                    <label for="NomU">Nombre(s)</label>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="APpUs" id="aPpU" placeholder="Apellido Paterno">
                            <label for="aPpU">Apellido Paterno</label>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="APmUs" id="aPmU" placeholder="Apellido Materno">
                            <label for="aPmU">Apellido Materno</label>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-2">
                    <input type="email" class="form-control" name="usuarioCI" id="usuarioCI" placeholder="correo@ejemplo.com">
                    <label for="usuarioCI">Correo electrónico</label>
                </div>
                <div class="form-floating mb-2">
                    <input type="email" class="form-control" name="usuarioaCI" id="usuarioaCI" placeholder="correo@ejemplo.com">
                    <label for="usuarioaCI">Confirma tu correo</label>
                </div>
                <div class="form-floating mb-2">
                    <input type="password" class="form-control" name="contraseñaCI" id="contraseñaCI" placeholder="Contraseña">
                    <label for="contraseñaCI">Contraseña</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="contraseñaa" id="contraseñaa" placeholder="Confirma tu contraseña">
                    <label for="contraseñaa">Confirma tu contraseña</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary mb-3" type="button" id="crearbtn">Crear cuenta</button>
            </form>
        </main>
    </section>


</body>
</html>
