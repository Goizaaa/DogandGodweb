# Configurar códigos de seguridad en WAMP

PHPMailer se instala con Composer. En la raíz del proyecto ejecuta `composer install` al preparar otra copia del sistema.

El sistema usa Gmail SMTP con TLS implícito, puerto 465. `SISTEMVET_SMTP_USER` debe ser la cuenta Gmail que envía los mensajes; `SISTEMVET_SMTP_PASSWORD` debe ser su contraseña de aplicación. El código se envía al correo de la cuenta solicitante guardado en `usuarios.correo`.

Configura las variables en Windows desde una consola de PowerShell (sin incluir comillas adicionales en los valores):

```powershell
[Environment]::SetEnvironmentVariable('SISTEMVET_SMTP_HOST', 'smtp.gmail.com', 'Machine')
[Environment]::SetEnvironmentVariable('SISTEMVET_SMTP_PORT', '465', 'Machine')
[Environment]::SetEnvironmentVariable('SISTEMVET_SMTP_USER', 'tu-cuenta@gmail.com', 'Machine')
[Environment]::SetEnvironmentVariable('SISTEMVET_SMTP_PASSWORD', 'tu-contraseña-de-aplicación', 'Machine')
```

Después reinicia todos los servicios de WAMP (incluido Apache) para que PHP lea las variables. En Windows, definir variables de máquina puede requerir una consola con permisos de administrador. Mantén la contraseña fuera del repositorio y de archivos accesibles desde el navegador.

El código de seis dígitos vence en 10 minutos y se invalida tras cinco intentos fallidos. Para comprobar la entrega, inicia sesión o recuperación con una cuenta cuyo correo puedas abrir. Revisa también spam.

Como la contraseña de aplicación se compartió en la conversación, revócala en la cuenta de Google y genera una nueva antes de configurar el servidor.
