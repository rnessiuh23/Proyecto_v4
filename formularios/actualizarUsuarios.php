
<?php 

session_start();
  if (!isset($_SESSION['usuario'])) {
      header('Location: ../index.php');
      exit();
  }

// Validar la URL por un ID válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id) {
    header('Location: ../listas/listaUsuarios.php');
}


$resultado = $_GET['resultado'] ?? null;

// Base de Datos
require '../includes/config/database.php'; 
$db = conectarDB();

// Obtener los datos de la tabla
$consulta = "SELECT * FROM Usuarios WHERE idUsuarios = $id";
$resultadoConsulta = mysqli_query($db, $consulta);
$usuario = mysqli_fetch_assoc($resultadoConsulta);

// Array con mensajes de errores
$errores = [];

$idUsuarios = $usuario['idUsuarios'];
$nombreUsu = $usuario['nombreUsu'];
$paternoUsu = $usuario['paternoUsu'];
$maternoUsu = $usuario['maternoUsu'];
$correoUsu = $usuario['correoUsu'];
$contrasenaUsu = $usuario['contrasenaUsu'];
$rol = $usuario['rol'];


// Ejecutar el codigo despues de que el usuario envia el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {

  $nombreUsu = $_POST['nombreUsu'];
  $paternoUsu = $_POST['paternoUsu'];
  $maternoUsu = $_POST['maternoUsu'];
  $correoUsu = $_POST['correoUsu'];
  $contrasenaUsu = $_POST['contrasenaUsu'];
  $rol = $_POST['rol'];


  if(!$nombreUsu) {
    $errores['nombreUsu'][] = "Este campo es obligatorio";
  } else if(!preg_match('/^[a-zA-Z 0-9 ._-]+$/', $nombreUsu)) {
    $errores['nombreUsu'][] = "El nombre solo puede contener letras, numeros, guiones, puntos y espacios";
  }


if(!$paternoUsu) {
    $errores['paternoUsu'][] = "Este campo es obligatorio";
  } else if(!preg_match('/^[a-zA-Z ]+$/', $paternoUsu)) {
    $errores['paternoUsu'][] = "El apellido paterno solo puede contener letras y espacios";
  }


  if(!$maternoUsu) {
    $errores['maternoUsu'][] = "Este campo es obligatorio";
  } else if(!preg_match('/^[a-zA-Z ]+$/', $maternoUsu)) {
    $errores['maternoUsu'][] = "El apellido materno solo puede contener letras y espacios";
  }


  if(!$correoUsu) {
    $errores['correoUsu'][] = "Correo obligatorio";
  } else if(!filter_var($correoUsu, FILTER_VALIDATE_EMAIL)) {
    $errores['correoUsu'][] = "Correo inválido";
  } else if(!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $correoUsu)) {
    $errores['correoUsu'][] = "Correo inválido";
  } else if(!preg_match('/^[a-zA-Z0-9._%+-]+@(gmail|outlook|alumno.uaemex|hotmail)\.(com|mx)$/', $correoUsu)) {
    $errores['correoUsu'][] = "Por favor! Ingrese un correo de gmail, outlook o institucional";
  }


  if(!$contrasenaUsu) {
    $errores['contrasenaUsu'][] = "Debe establecer una contraseña";
  } else if(!preg_match('/^[a-zA-Z 0-9._-]+$/', $nombreUsu)) {
    $errores['contrasenaUsu'][] = "La contraseña solo puede contener letras, numeros, guiones y puntos";
  }  else if(strlen($contrasenaUsu) < 8) {
    $errores['contrasenaUsu'][] = "La contraseña debe tener un minimo de 8 caracteres";
  }else if(strlen($contrasenaUsu) > 15) {
    $errores['contrasenaUsu'][] = "La contraseña solo puede tener un maximo de 15 caracteres";
  }


  if(!$rol) {
    $errores['rol'][] = "Establezca un rol";
  }


  // Revisar que el array de errores este vacio
  if(empty($errores)) {
    // INSERTAR EN LA BD
  $query = "UPDATE Usuarios SET nombreUsu = '$nombreUsu', paternoUsu = '$paternoUsu', maternoUsu = '$maternoUsu', correoUsu = '$correoUsu', contrasenaUsu = '$contrasenaUsu', rol = '$rol' WHERE idUsuarios = $id";


  $resultado = mysqli_query($db, $query);

  if($resultado) {
    header('Location: ../listas/listaUsuarios.php?resultado=2');
  } 
}
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Logo_de_la_UAEMex.svg/1200px-Logo_de_la_UAEMex.svg.png">
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Logo_de_la_UAEMex.svg/1200px-Logo_de_la_UAEMex.svg.png">
  <title>
    Usuarios
  </title>
  <?php include '../recursos/recursos.php' ?>
</head>

<body class="g-sidenav-show bg-gray-100">
  <?php include '../templates/Menu/menu.php' ?>
  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

  
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg bg-transparent shadow-none position-absolute px-4 w-100 z-index-2">
      <div class="container-fluid py-1">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 ps-2 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="text-white opacity-5" href="javascript:;">Formularios</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Usuarios</li>
          </ol>
          <h6 class="text-white font-weight-bolder ms-2">Usuarios</h6>
        </nav>
        <div class="collapse navbar-collapse me-md-0 me-sm-4 mt-sm-0 mt-2" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            
          </div>
          <ul class="navbar-nav justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="../templates/Login/logout.php" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Cerrar sesión</span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 pe-0 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                  <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                  </div>
                </a>
              </a>
            </li>
              </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid">
      <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/fondoAlumnos.jpg'); background-position-y: 95%;">
        <span class="mask bg-gradient-primary opacity-7"></span>
      </div>
      <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="https://img.icons8.com/color/512/add-user-male-skin-type-7.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                Actualizar usuarios
              </h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <div class="row">

        <div class="col-12 mt-4">
          <div class="card mb-4">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-1">Favor de llenar todos los campos</h6>
            </div>
            <div class="card-body p-3">
              <div class="row">
                <div class="col-xl-12 col-md-6 mb-xl-0 mb-4">
                  <div class="card card-blog card-plain">


  <form method="POST">
    <div class="col-md-6">
      <div class="form-group">
        <input type="number" class="form-controlNone" name="idUsuarios" id="idUsuarios" placeholder="" value="<?php echo $idUsuarios; ?>" disabled>
        <?php if(isset($errores['idUsuarios'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['idUsuarios'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
      <label for="nombre">Nombre de usuario</label>
        <input type="text" class="form-control text-uppercase" name="nombreUsu" id="nombreUsu" placeholder="Brian David Peralta Arriaga" value="<?php echo $nombreUsu; ?>">
        <?php if(isset($errores['nombreUsu'])): ?>
          <div class="message-error" id="nombreUsu-error" id="nombreUsu-error">
            <?php foreach($errores['nombreUsu'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  
    <div class="col-md-6">
      <div class="form-group">
      <label for="correoUsu">Correo</label>
        <input type="text" class="form-control text-uppercase" name="correoUsu" id="correoUsu" placeholder="usuario@correo.com" value="<?php echo $correoUsu; ?>">
        <?php if(isset($errores['correoUsu'])): ?>
          <div class="message-error" id="correoUsu-error" id="correoUsu-error">
            <?php foreach($errores['correoUsu'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>


  <div class="row">
  <div class="col-md-6">
      <div class="form-group">
      <label for="paternoUsu">Apellido paterno</label>
        <input type="text" class="form-control text-uppercase" name="paternoUsu" id="paternoUsu" placeholder="Ej: Garcia" value="<?php echo $paternoUsu; ?>">
        <?php if(isset($errores['paternoUsu'])): ?>
          <div class="message-error" id="paternoUsu-error" id="paternoUsu-error">
            <?php foreach($errores['paternoUsu'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
      <label for="maternoUsu">Apellido Materno</label>
        <input type="text" class="form-control text-uppercase" name="maternoUsu" id="maternoUsu" placeholder="Ej: Estrada" value="<?php echo $maternoUsu; ?>">
        <?php if(isset($errores['maternoUsu'])): ?>
          <div class="message-error" id="maternoUsu-error" id="maternoUsu-error">
            <?php foreach($errores['maternoUsu'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>


<div class="row">
  <div class="col-md-6">
      <div class="form-group">
      <label for="contrasenaUsu">Contraseña</label>
        <input type="text" class="form-control text-uppercase" name="contrasenaUsu" id="contrasenaUsu" placeholder="**********" value="<?php echo $contrasenaUsu; ?>">
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
      <label for="rol">Rol</label>
      <select name="rol" id="rol" class="form-select text-uppercase" aria-label="Default select example">
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $rol === "Usuario" ? 'selected' : '' ?> value="Usuario">Usuario</option>
        <option <?php echo $rol === "Administrador" ? 'selected' : '' ?> value="Administrador">Administrador</option>
      </select>
      <?php if(isset($errores['rol'])): ?>
          <div class="message-error" id="rol-error">
            <?php foreach($errores['rol'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <button class="btn btn-icon btn-3 btn-primary" type="submit">
	<span class="btn-inner--icon"><i class="fas fa-user-plus"></i></span>
  <span class="btn-inner--text"> Actualizar</span>
</button>
</form>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer pt-3">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-beetwen">
            <div class="col-lg-12 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                <script>
                  document.write(new Date().getFullYear())
                </script>,
                Software creado por
                <a href="#" class="font-weight-bold">ICO y LIA</a>
                
              </div>
        </div>
      
    </div>
  </div>
</footer>
  
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script>
  const telefonoInput = document.getElementById('telefonoDep');

  telefonoInput.addEventListener('keyup', (e) => {
    let telefonoDep = e.target.value;
    telefonoDep = telefonoDep.replace(/\D/g, '');
    telefonoDep = telefonoDep.substring(0, 10);
    telefonoDep = telefonoDep.replace(/^(\d{2})(\d{4})(\d{4})$/, "($1) $2-$3");
    e.target.value = telefonoDep;
  });
</script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
  <!-- Incluye SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>
</body>

</html>