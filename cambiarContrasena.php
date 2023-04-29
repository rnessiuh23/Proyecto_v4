<?php 

// Validar la URL por un ID válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

$resultado = $_GET['resultado'] ?? null;

// Base de Datos
require './includes/config/database.php'; 
$db = conectarDB();

// Obtener los datos de la tabla
$consulta = "SELECT * FROM Usuarios WHERE idUsuarios = $id";
$resultadoConsulta = mysqli_query($db, $consulta);
$usuario = mysqli_fetch_assoc($resultadoConsulta);

$contrasenaUsu = $usuario['contrasenaUsu'];

// Ejecutar el codigo despues de que el usuario envia el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $contrasenaUsu = $_POST['contrasenaUsu'];
  
    if(!$contrasenaUsu) {
      $errores['contrasenaUsu'][] = "Debe establecer una contraseña";
    } else if(!preg_match('/^[a-zA-Z 0-9._-]+$/', $contrasenaUsu)) {
      $errores['contrasenaUsu'][] = "La contraseña solo puede contener letras, numeros, guiones y puntos";
    }  else if(strlen($contrasenaUsu) < 8) {
      $errores['contrasenaUsu'][] = "La contraseña debe tener un minimo de 8 caracteres";
    }else if(strlen($contrasenaUsu) > 15) {
      $errores['contrasenaUsu'][] = "La contraseña solo puede tener un maximo de 15 caracteres";
    }
  
    // Revisar que el array de errores este vacio
    if(empty($errores)) {
      // INSERTAR EN LA BD
    $query = "UPDATE Usuarios SET contrasenaUsu = '$contrasenaUsu' WHERE idUsuarios = $id";
  
    $resultado = mysqli_query($db, $query);
  
  }
}

?>

<link id="pagestyle" href="./assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
<section>
  <div class="page-header min-vh-75">
    <div class="container">
      <div class="row justify-content-center align-items-center vh-100">
        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
          <div class="card card-plain mt-8">
            <div class="card-header pb-0 text-left bg-transparent">
              <h3 class="font-weight-bolder text-info text-gradient">
                Recupere su contraseña.
              </h3>
              <p class="mb-0">Ingrese y confirme su nueva contraseña para continuar.</p>
            </div>
            <div class="card-body">
              <form role="form" method="POST">
                <div class="col-md-6">
                <div class="form-group">
                <label for="contrasenaUsu">Nueva contraseña</label>
                    <input type="password" class="form-control" name="contrasenaUsu" id="contrasenaUsu" autofocus placeholder="Nueva contraseña">
                    <?php if(isset($errores['contrasenaUsu'])): ?>
                    <div class="message-error" id="contrasenaUsu-error" id="contrasenaUsu-error">
                        <?php foreach($errores['contrasenaUsu'] as $error): ?>
                        <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                <label for="contrasenaUsu">Confirme su contraseña</label>
                    <input type="password" class="form-control" name="contrasenaUsu" id="contrasenaUsu" placeholder="Confirme su contraseña">
                    <?php if(isset($errores['contrasenaUsu'])): ?>
                 <div class="message-error" id="contrasenaUsu-error" id="contrasenaUsu-error">
                        <?php foreach($errores['contrasenaUsu'] as $error): ?>
                        <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                </div>
                </div>
                <div class="text-center">
                  <button
                    type="submit"
                    class="btn bg-gradient-info w-100 mt-4 mb-0">
                    Confirmar
                  </button>
                </div>
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
