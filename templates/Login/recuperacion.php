<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../PHPMailer/Exception.php';
require '../../PHPMailer/PHPMailer.php';
require '../../PHPMailer/SMTP.php';

// Base de Datos
require '../../includes/config/database.php'; 
$db = conectarDB();

// Validar si se recibieron los datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener los datos del formulario
    $correo = mysqli_real_escape_string($db, $_POST['correoUsu']);

    // Preparar la consulta SQL utilizando sentencias preparadas
    $query = "SELECT * FROM Usuarios WHERE correoUsu = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $correo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $row = $resultado->fetch_assoc();

    // Validar si se encontró un usuario con los datos proporcionados
    if ($resultado->num_rows === 1) {
        $usuario = mysqli_fetch_assoc($resultado);
        // Enviar correo electrónico de recuperación de contraseña
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp-mail.outlook.com'; // Servidor Smtp de outlook
            $mail->SMTPAuth   = true;
            $mail->Username   = 'cu.uaemexvc@hotmail.com'; // Correo desde el que se mandara el mensaje
            $mail->Password   = 'uaemexvch2023'; // Contraseña del correo
            $mail->Port       = 587; // Puerto proveniente del smtp de outlook

            // Configuración del mensaje
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('cu.uaemexvc@hotmail.com', 'Extension y Vinculacion UAEMEX VCH');
            $mail->addAddress($correo);
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';
            $mail->Body    = 'Hola<br><br>Hemos recibido una solicitud para reestablecer la contraseña de tu cuenta. Si no has solicitado este cambio, por favor ignora este correo
            y no realices ninguna acción. <br><br>Si has solicitado el cambio de contraseña, haz clic en el siguiente enlace para continuar con el proceso:
            <br><br><a href="localhost/Dash/cambiarContrasena.php?id='.$row['idUsuarios'].'">Reestablecer contraseña</a>';

            $mail->send();
            echo 'El mensaje se envió correctamente';
        } catch (Exception $e) {
            echo 'Error al enviar el mensaje: ' . $mail->ErrorInfo;
        }
    } else {
        echo 'No se encontró ningún usuario con los datos proporcionados';
    }
    } else {
    // Redirigir al formulario de recuperación de contraseña (Pendiente)
 
    }
?>

<link id="pagestyle" href="../../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
<section>
  <div class="page-header min-vh-75">
    <div class="container">
      <div class="row justify-content-center align-items-center vh-100">
        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
          <div class="card card-plain mt-8">
            <div class="card-header pb-0 text-left bg-transparent">
              <h3 class="font-weight-bolder text-info text-gradient">
                ¡Lamentamos los inconvenientes!
              </h3>
              <p class="mb-0">¡Porfavor! Ingresa tu correo de usuario y sigue las instrucciones que te enviaremos para reestablecer tu contraseña.</p>
            </div>
            <div class="card-body">
              <form role="form" method="POST">
                <label for="correoUsu">Correo</label>
                <div class="mb-3">
                  <input
                    type="email"
                    name="correoUsu"
                    id="correoUsu"
                    class="form-control"
                    placeholder="correo@uaem.com"
                    aria-label="Email"
                    aria-describedby="email-addon"
                    autofocus
                  />
                </div>
                <div class="text-center">
                  <button
                    type="submit"
                    class="btn bg-gradient-info w-100 mt-4 mb-0">
                    Enviar
                  </button>
                </div>
            <?php include 'footer.php' ?>
          </div>
        </div>
        <div class="col-md-6">
          <div
            class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8"
          >
            <div
              class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
              style="
                background-image: url('./assets/img/curved-images/fondoLog.jpg');
              "
            ></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
