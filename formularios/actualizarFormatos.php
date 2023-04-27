
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
    header('Location: ../listas/listaFormatos.php');
}


$resultado = $_GET['resultado'] ?? null;

// Base de Datos
require '../includes/config/database.php'; 
$db = conectarDB();

// Obtener los datos de la tabla
$consulta = "SELECT * FROM Formatos WHERE idFormatos = $id";
$resultadoConsulta = mysqli_query($db, $consulta);
$formato = mysqli_fetch_assoc($resultadoConsulta);

// Array con mensajes de errores
$errores = [];

$idFormatos = $formato['idFormatos'];
$fecRegistro = $formato['fecRegistro'];
$hora = $formato['hora'];
$ss = $formato['ss'];
$fecInicio  = $formato['fecInicio'];
$fecTermino = $formato['fecTermino'];
$carta = $formato['carta'];
$primerInf = $formato['primerInf'];
$segundoInf = $formato['segundoInf'];
$tercerInf = $formato['tercerInf'];
$finalInf = $formato['finalInf'];
$terminacion = $formato['terminacion'];
$evaluacion = $formato['evaluacion'];
$solicitud = $formato['solicitud'];
$observaciones = $formato['observaciones'];

// Ejecutar el codigo despues de que el usuario envia el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {

  $ss = $_POST['ss'];
  $fecInicio  = $_POST['fecInicio'];
  $fecTermino = $_POST['fecTermino'];
  $carta = $_POST['carta'];
  $primerInf = $_POST['primerInf'];
  $segundoInf = $_POST['segundoInf'];
  $tercerInf = $_POST['tercerInf'];
  $finalInf = $_POST['finalInf'];
  $terminacion = $_POST['terminacion'];
  $evaluacion = $_POST['evaluacion'];
  $solicitud = $_POST['solicitud'];
  $observaciones = $_POST['observaciones'];


  if(!$ss) {
    $errores['ss'][] = "Este campo es obligatorio!";
  }

  if(!$fecInicio ) {
    $errores['fecInicio'][] = "Seleccione una fecha";
  }

  if(!$fecTermino ) {
    $errores['fecTermino'][] = "Seleccione una fecha";
  }
  
  if(!$carta) {
    $errores['carta'][] = "Este campo es obligatorio!";
  }

  if(!$primerInf) {
    $errores['primerInf'][] = "Este campo es obligatorio!";
  }

  if(!$segundoInf) {
    $errores['segundoInf'][] = "Este campo es obligatorio!";
  }

  if(!$tercerInf) {
    $errores['tercerInf'][] = "Este campo es obligatorio!";
  }

  if(!$finalInf) {
    $errores['finalInf'][] = "Este campo es obligatorio!";
  }

  if(!$terminacion) {
    $errores['terminacion'][] = "Este campo es obligatorio!";
  }

  if(!$evaluacion) {
    $errores['evaluacion'][] = "Este campo es obligatorio!";
  }

  if(!$solicitud) {
    $errores['solicitud'][] = "Este campo es obligatorio!";
  }

  if(!$observaciones) {
    $errores['observaciones'][] = "Este campo es obligatorio!";
  }


  // Revisar que el array de errores este vacio
  if(empty($errores)) {
    // INSERTAR EN LA BD
  $query = "UPDATE Formatos SET ss = '$ss', fecInicio = '$fecInicio', fecTermino = '$fecTermino', carta = '$carta', primerInf = '$primerInf', segundoInf = '$segundoInf', tercerInf = '$tercerInf', finalInf = '$finalInf', terminacion = '$terminacion',
   evaluacion = '$evaluacion', solicitud = '$solicitud', observaciones = '$observaciones' WHERE idFormatos = $id";

  $resultado = mysqli_query($db, $query);

  if($resultado) {
    // echo "Insertado correctamente";

    header('Location: ../listas/listaFormatos.php?resultado=2');
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
    Formatos
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
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Formatos</li>
          </ol>
          <h6 class="text-white font-weight-bolder ms-2">Formatos</h6>
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
                Actualizar formatos
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
        <input type="text" class="form-controlNone text-uppercase" name="idFormatos" id="idFormatos" placeholder="" value="<?php echo $idFormatos; ?>" disabled>
        <?php if(isset($errores['idFormatos'])): ?>
          <div class="message-error" id="idFormatos-error" id="idFormatos-error">
            <?php foreach($errores['idFormatos'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

<div class="row"> 
<div class="col-md-6">
      <div class="form-group">
      <label for="fecRegistro">Fecha de registro</label>
        <input type="date" class="form-control text-uppercase" name="fecRegistro" id="fecRegistro" placeholder="" value="<?php echo $fecRegistro; ?>" disabled>
        <?php if(isset($errores['fecRegistro'])): ?>
          <div class="message-error" id="fecRegistro-error" id="fecRegistro-error">
            <?php foreach($errores['fecRegistro'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>


    <div class="col-md-6">
      <div class="form-group">
      <label for="hora">Hora</label>
        <input type="time" class="form-control" name="hora" id="hora" placeholder="" value="<?php echo $hora; ?>" disabled>
        <?php if(isset($errores['hora'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['hora'] as $error): ?>
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
      <label for="fecInicio">Fecha de Inicio</label>
        <input type="date" class="form-control text-uppercase" name="fecInicio" id="fecInicio" placeholder="" value="<?php echo $fecInicio; ?>">
        <?php if(isset($errores['fecInicio'])): ?>
          <div class="message-error" id="fecInicio-error" id="fecInicio-error">
            <?php foreach($errores['fecInicio'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>


    <div class="col-md-6">
      <div class="form-group">
      <label for="fecTermino">Fecha de Termino</label>
        <input type="date" class="form-control text-uppercase" name="fecTermino" id="fecTermino" placeholder="" value="<?php echo $fecTermino; ?>">
        <?php if(isset($errores['fecTermino'])): ?>
          <div class="message-error" id="fecTermino-error" id="fecTermino-error">
            <?php foreach($errores['fecTermino'] as $error): ?>
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
      <label for="ss">Servicio social</label>
      <select name="ss" id="ss" class="form-select text-uppercase" aria-label="Default select example">
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $ss === "Incompleto" ? 'selected' : '' ?> value="Incompleto">Incompleto</option>
        <option <?php echo $ss === "En curso" ? 'selected' : '' ?> value="En curso">En curso</option>
        <option <?php echo $ss === "Terminado" ? 'selected' : '' ?> value="Terminado">Terminado</option>
      </select>
      <?php if(isset($errores['ss'])): ?>
          <div class="message-error" id="ss-error">
            <?php foreach($errores['ss'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>


    <div class="col-md-6">
      <div class="form-group">
      <label for="carta">Carta de presentacion</label>
      <select name="carta" id="carta" class="form-select text-uppercase" aria-label="Default select example">
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $carta === "Entregada" ? 'selected' : '' ?> value="Entregada">Entregada</option>
        <option <?php echo $carta === "Pendiente" ? 'selected' : '' ?> value="Pendiente">Pendiente</option>
        <option <?php echo $carta === "No Entregada" ? 'selected' : '' ?> value="No Entregada">No Entregada</option>
      </select>
      <?php if(isset($errores['carta'])): ?>
          <div class="message-error" id="carta-error">
            <?php foreach($errores['carta'] as $error): ?>
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
      <label for="primerInf">Primer informe trimestral</label>
      <select name="primerInf" id="primerInf" class="form-select text-uppercase" aria-label="Default select example">
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $primerInf === "Entregado" ? 'selected' : '' ?> value="Entregado">Entregado</option>
        <option <?php echo $primerInf === "Pendiente" ? 'selected' : '' ?> value="Pendiente">Pendiente</option>
        <option <?php echo $primerInf === "No Entregado" ? 'selected' : '' ?> value="No Entregado">No Entregado</option>
      </select>
      <?php if(isset($errores['primerInf'])): ?>
          <div class="message-error" id="primerInf-error">
            <?php foreach($errores['primerInf'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>


    <div class="col-md-6">
      <div class="form-group">
      <label for="segundoInf">Segundo informe trimestral</label>
      <select name="segundoInf" id="segundoInf" class="form-select text-uppercase" aria-label="Default select example">
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $segundoInf === "Entregado" ? 'selected' : '' ?> value="Entregado">Entregado</option>
        <option <?php echo $segundoInf === "Pendiente" ? 'selected' : '' ?> value="Pendiente">Pendiente</option>
        <option <?php echo $segundoInf === "No Entregado" ? 'selected' : '' ?> value="No Entregado">No Entregado</option>
      </select>
      <?php if(isset($errores['segundoInf'])): ?>
          <div class="message-error" id="segundoInf-error">
            <?php foreach($errores['segundoInf'] as $error): ?>
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
      <label for="tercerInf">Tercer informe trimestral</label>
      <select name="tercerInf" id="tercerInf" class="form-select text-uppercase" aria-label="Default select example">
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $tercerInf === "Entregado" ? 'selected' : '' ?> value="Entregado">Entregado</option>
        <option <?php echo $tercerInf === "Pendiente" ? 'selected' : '' ?> value="Pendiente">Pendiente</option>
        <option <?php echo $tercerInf === "No Entregado" ? 'selected' : '' ?> value="No Entregado">No Entregado</option>
      </select>
      <?php if(isset($errores['tercerInf'])): ?>
          <div class="message-error" id="tercerInf-error">
            <?php foreach($errores['tercerInf'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>


    <div class="col-md-6">
      <div class="form-group">
      <label for="finalInf">Informe final</label>
      <select name="finalInf" id="finalInf" class="form-select text-uppercase" aria-label="Default select example">
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $finalInf === "Entregado" ? 'selected' : '' ?> value="Entregado">Entregado</option>
        <option <?php echo $finalInf === "Pendiente" ? 'selected' : '' ?> value="Pendiente">Pendiente</option>
        <option <?php echo $finalInf === "No Entregado" ? 'selected' : '' ?> value="No Entregado">No Entregado</option>
      </select>
      <?php if(isset($errores['finalInf'])): ?>
          <div class="message-error" id="finalInf-error">
            <?php foreach($errores['finalInf'] as $error): ?>
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
      <label for="terminacion">Terminacion</label>
      <select name="terminacion" id="terminacion" class="form-select text-uppercase" aria-label="Default select example">
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $terminacion === "Realizada" ? 'selected' : '' ?> value="Realizada">Realizada</option>
        <option <?php echo $terminacion === "No Realizada" ? 'selected' : '' ?> value="No Realizada">No Realizada</option>
      </select>
      <?php if(isset($errores['terminacion'])): ?>
          <div class="message-error" id="terminacion-error">
            <?php foreach($errores['terminacion'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>


    <div class="col-md-6">
      <div class="form-group">
      <label for="evaluacion">Evaluacion</label>
      <select name="evaluacion" id="evaluacion" class="form-select text-uppercase" aria-label="Default select example">
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $terminacion === "Realizada" ? 'selected' : '' ?> value="Realizada">Realizada</option>
        <option <?php echo $terminacion === "No Realizada" ? 'selected' : '' ?> value="No Realizada">No Realizada</option>
      </select>
      <?php if(isset($errores['evaluacion'])): ?>
          <div class="message-error" id="evaluacion-error">
            <?php foreach($errores['evaluacion'] as $error): ?>
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
      <label for="solicitud">Solicitud</label>
      <select name="solicitud" id="solicitud" class="form-select text-uppercase" aria-label="Default select example">
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $solicitud === "Realizada" ? 'selected' : '' ?> value="Realizada">Realizada</option>
        <option <?php echo $solicitud === "No Realizada" ? 'selected' : '' ?> value="No Realizada">No Realizada</option>
      </select>
      <?php if(isset($errores['solicitud'])): ?>
          <div class="message-error" id="solicitud-error">
            <?php foreach($errores['solicitud'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>


    <div class="col-md-6">
      <div class="form-group">
      <label for="observaciones">Status</label>
      <select name="observaciones" id="observaciones" class="form-select text-uppercase" aria-label="Default select example">
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $observaciones === "En curso" ? 'selected' : '' ?> value="En curso">En curso</option>
        <option <?php echo $observaciones === "Baja" ? 'selected' : '' ?> value="Baja">Baja</option>
        <option <?php echo $observaciones === "Terminado" ? 'selected' : '' ?> value="Terminado">Terminado</option>
      </select>
      <?php if(isset($errores['observaciones'])): ?>
          <div class="message-error" id="observaciones-error">
            <?php foreach($errores['observaciones'] as $error): ?>
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

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
  <!-- Incluye SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.all.min.js"></script>
</body>

</html>