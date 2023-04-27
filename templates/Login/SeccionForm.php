<?php
// Base de Datos
require './includes/config/database.php'; 
$db = conectarDB();

// Validar si se recibieron los datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener los datos del formulario
    $correo = mysqli_real_escape_string($db, $_POST['correoUsu']);
    $contrasena = mysqli_real_escape_string($db, $_POST['contrasenaUsu']);

    // Preparar la consulta SQL utilizando sentencias preparadas
    $query = "SELECT * FROM Usuarios WHERE correoUsu = ? AND contrasenaUsu = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ss", $correo, $contrasena);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Validar si se encontró un usuario con los datos proporcionados
    if ($resultado->num_rows === 1) {
        $usuario = mysqli_fetch_assoc($resultado);
        // Iniciar sesión y redirigir al dashboard correspondiente según el rol del usuario
        if ($usuario['rol'] === 'Usuario') {
            // Usuario normal
            session_start();
            $_SESSION['usuario'] = $usuario;
            header('Location: ./panelAdministrativo/dashboard.php');
        } elseif ($usuario['rol'] === 'Administrador') {
            // Administrador
            session_start();
            $_SESSION['usuario'] = $usuario;
            header('Location: ./panelAdministrativo/dashboard.php');
        }
    } else {
        // Mostrar mensaje de error si los datos son incorrectos
        $errores[] = 'El correo o la contraseña son incorrectos.';
    }
}
?>

<section>
  <div class="page-header min-vh-75">
    <div class="container">
      <div class="row justify-content-center align-items-center vh-100">
        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
          <div class="card card-plain mt-8">
            <div class="card-header pb-0 text-left bg-transparent">
              <h3 class="font-weight-bolder text-info text-gradient">
                Bienvenido!
              </h3>
              <p class="mb-0">Ingresa tu correo y contraseña para acceder</p>
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
                  />
                </div>
                <label for="contrasenaUsu">Contraseña</label>
                <div class="mb-3">
                  <input
                    type="password"
                    name="contrasenaUsu"
                    id="contrasenaUsu"
                    class="form-control"
                    placeholder="***********"
                    aria-label="Password"
                    aria-describedby="password-addon"
                  />
                </div>
                <div class="text-center">
                  <button
                    type="submit"
                    class="btn bg-gradient-info w-100 mt-4 mb-0"
                  >
                    Iniciar sesión
                  </button>
                </div>
              </form>
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
                background-image: url('../assets/img/curved-images/fondoLog.jpg');
              "
            ></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
