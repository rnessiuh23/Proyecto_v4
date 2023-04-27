
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
    header('Location: ../listas/listaAlumnos.php');
}


$resultado = $_GET['resultado'] ?? null;

// Base de Datos
require '../includes/config/database.php'; 
$db = conectarDB();

// Obtener los datos de la tabla Alumnos
$consulta = "SELECT * FROM Alumnos WHERE cuenta = $id";
$resultadoConsulta = mysqli_query($db, $consulta);
$alumno = mysqli_fetch_assoc($resultadoConsulta);


// echo "<pre>";
// var_dump($alumno);
// echo "</pre>";

// Array con mensajes de errores
$errores = [];

$cuenta = $alumno['cuenta'];
$nombre = $alumno['nombre'];
$sexo = $alumno['sexo'];
$correo = $alumno['correo'];
$telefono = $alumno['telefono'];
$carrera = $alumno['idCarrera'];
$tutor = $alumno['idTutor'];
$dependencia = $alumno['idDependencias'];

// Ejecutar el codigo despues de que el usuario envia el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  // echo '<pre>';
  // var_dump($_POST);
  // echo '</pre>';

//   $cuenta = $_POST['cuenta'];
//   $nombre = strtoupper($_POST['nombre']);
//   $sexo = strtoupper($_POST['sexo']);
  $correo = $_POST['correo'];
  $telefono = $_POST['telefono'];
//   $carrera = $_POST['carrera'];
  $tutor = $_POST['tutor'];
  $dependencia = $_POST['dependencia'];

//   if(strlen($cuenta) < 7) {
//     $errores['cuenta'][] = "Debes añadir una cuenta valida";
//   } else if (strlen($cuenta) > 7) {
//     $errores['cuenta'][] = "No te puedes pasar de los 7 digitos";
//   }else if (!is_numeric($cuenta)) {
//     $errores['cuenta'][] = "El valor de la cuenta debe ser numérico";
//   }else {
//     // Verificar si el número de cuenta ya existe en la base de datos
//     $query = "SELECT cuenta FROM Alumnos WHERE cuenta = '$cuenta'";
//     $resultado = mysqli_query($db, $query);
//     if(mysqli_num_rows($resultado) > 0) {
//       $errores['cuenta'][] = "Este número de cuenta ya existe";
//     }
//   }

//   if(!$nombre) {
//     $errores['nombre'][] = "Nombre obligatorio";
//   } else if(!preg_match('/^[a-zA-Z ]+$/', $nombre)) {
//     $errores['nombre'][] = "El nombre solo puede contener letras y espacios";
//   }

//   if(!$sexo) {
//     $errores['sexo'][] = "Seleccione sexo";
//   }

if (!$correo) {
    $errores['correo'][] = "Correo obligatorio";
  } else if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores['correo'][] = "Correo inválido";
  } else if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $correo)) {
    $errores['correo'][] = "Correo inválido";
  } else if (!preg_match('/^[a-zA-Z0-9._%+-]+@(gmail|outlook|alumno.uaemex|hotmail)\.(com|mx)$/', $correo)) {
    $errores['correo'][] = "Favor de ingresar un correo de gmail, outlook o institucional";
  }

  if (!preg_match('/^(\([0-9]{2}\) ?|[0-9]{4}-)[0-9]{4}-[0-9]{4}$/', $telefono)) {
    $errores['telefono'][] = "El número de teléfono debe tener un formato válido";
} else if(strlen($telefono) > 14) {
  $errores['telefono'][] = "No puedes meter mas de 14 digitos";
}

//   if(!$carrera) {
//     $errores['carrera'][] = "Carrera obligatorio";
//   }

  if(!$tutor) {
    $errores['tutor'][] = "Tutor obligatorio";
  }

  if(!$dependencia) {
    $errores['dependencia'][] = "Dependencia obligatorio";
  }

  // echo '<pre>';
  // var_dump($errores);
  // echo '</pre>';

  // exit;

  // Revisar que el array de errores este vacio
  if(empty($errores)) {
    // INSERTAR EN LA BD
  $query = "UPDATE Alumnos SET correo = '$correo', telefono = '$telefono', idTutor = '$tutor', idDependencias = '$dependencia' WHERE cuenta = $id";

//   echo $query;


  $resultado = mysqli_query($db, $query);

  if($resultado) {
    // echo "Insertado correctamente";

    header('Location: ../listas/listaAlumnos.php?resultado=2');
  } 
}
  }

  

// CONSULTA DE TABLA Tutor
$query_Tutor = "SELECT idTutor, nombreTutor, denominacion FROM Tutor";

$resultado_Tutor = mysqli_query($db, $query_Tutor);

$tutores = array();
while ($fila = mysqli_fetch_array($resultado_Tutor)) {
    $tutores[] = $fila;
}

// CONSULTA DE TABLA Dependencias
$query_Dependencia = "SELECT idDependencias, nombreDep FROM Dependencias";

$resultado_Dependencias = mysqli_query($db,$query_Dependencia);

$dependencias = array();
while ($fila = mysqli_fetch_array($resultado_Dependencias)) {
  $dependencias[] = $fila;
}

// CONSULTA DE TABLA Carrera
$query_Carrera = "SELECT idCarrera, carrera, abreviatura FROM Carrera";

$resultado_Carreras = mysqli_query($db,$query_Carrera);

$carreras = array();
while ($fila = mysqli_fetch_array($resultado_Carreras)) {
  $carreras[] = $fila;
}

// mysqli_close();




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Logo_de_la_UAEMex.svg/1200px-Logo_de_la_UAEMex.svg.png">
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Logo_de_la_UAEMex.svg/1200px-Logo_de_la_UAEMex.svg.png">
  <title>
    Alumnos
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
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Alumnos</li>
          </ol>
          <h6 class="text-white font-weight-bolder ms-2">Alumnos</h6>
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
                Actualizar alumnos
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
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="cuenta">Numero de cuenta</label>
        <!-- <i class="las la-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Solo puedes ingresar 7 digitos sin repetir" data-container="body" data-animation="true"></i> -->
        <input type="number" class="form-control" name="cuenta" id="cuenta" placeholder="1929132" value="<?php echo $cuenta; ?>" disabled>
        <?php if(isset($errores['cuenta'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['cuenta'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
      <label for="nombre">Nombre completo</label>
        <input type="text" class="form-control text-uppercase" name="nombre" id="nombre" placeholder="Brian David Peralta Arriaga" value="<?php echo $nombre; ?>" disabled>
        <?php if(isset($errores['nombre'])): ?>
          <div class="message-error" id="nombre-error" id="nombre-error">
            <?php foreach($errores['nombre'] as $error): ?>
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
      <label for="sexo">Sexo</label>
      <select name="sexo" id="sexo" class="form-select text-uppercase" aria-label="Default select example" disabled>
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $sexo === "1" ? 'selected' : '' ?> value="1">Masculino</option>
        <option <?php echo $sexo === "2" ? 'selected' : '' ?> value="2">Femenino</option>
      </select>
      <?php if(isset($errores['sexo'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['sexo'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
      <label for="correo">Correo</label>
        <input type="email" class="form-control" name="correo" id="correo" placeholder="correo@correo.com" value="<?php echo $correo; ?>">
        <?php if(isset($errores['correo'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['correo'] as $error): ?>
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
      <label for="telefono">Teléfono</label>
      <input type="tel" name="telefono" id="telefono" class="form-control" placeholder="Teléfono (XX) XXXX-XXXX" maxlength="14" value="<?php echo $telefono; ?>">
        <?php if(isset($errores['telefono'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['telefono'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
      <label for="carrera">Carrera</label>
      <select name="carrera" id="carrera" class="form-select text-uppercase" aria-label="Default select example" disabled>
    <option value="" <?php echo empty($carrera) ? 'selected' : ''; ?>>-- Selecciona --</option>
    <?php foreach ($carreras as $carrera_actual) { ?>
        <option value="<?php echo $carrera_actual['idCarrera']; ?>" <?php echo ($carrera_actual['idCarrera'] == $carrera) ? 'selected' : ''; ?>>
            <?php echo $carrera_actual['carrera'] . " - " . $carrera_actual['abreviatura']; ?>
        </option>
    <?php } ?>
</select>
      <?php if(isset($errores['carrera'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['carrera'] as $error): ?>
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
      <label for="tutor">Tutor</label>
<select name="tutor" id="tutor" class="form-select text-uppercase" aria-label="Default select example">
    <option value="" <?php echo empty($tutor) ? 'selected' : ''; ?>>-- Selecciona --</option>
    <?php foreach ($tutores as $tutor_actual) { ?>
        <option value="<?php echo $tutor_actual['idTutor']; ?>" <?php echo ($tutor_actual['idTutor'] == $tutor) ? 'selected' : ''; ?>>
            <?php echo $tutor_actual['denominacion'] . " " . $tutor_actual['nombreTutor']; ?>
        </option>
    <?php } ?>
</select>
      <?php if(isset($errores['tutor'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['tutor'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
      <label for="dependencia">Dependencia</label>
      <select name="dependencia" id="dependencia" class="form-select text-uppercase" aria-label="Default select example">
    <option value="" <?php echo empty($dependencia) ? 'selected' : ''; ?>>-- Selecciona --</option>
    <?php foreach ($dependencias as $dependencia_actual) { ?>
        <option value="<?php echo $dependencia_actual['idDependencias']; ?>" <?php echo ($dependencia_actual['idDependencias'] == $dependencia) ? 'selected' : ''; ?>>
            <?php echo $dependencia_actual['nombreDep']; ?>
        </option>
    <?php } ?>
</select>
      <?php if(isset($errores['dependencia'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['dependencia'] as $error): ?>
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
  const telefonoInput = document.getElementById('telefono');

  telefonoInput.addEventListener('keyup', (e) => {
    let telefono = e.target.value;
    telefono = telefono.replace(/\D/g, '');
    telefono = telefono.substring(0, 10);
    telefono = telefono.replace(/^(\d{2})(\d{4})(\d{4})$/, "($1) $2-$3");
    e.target.value = telefono;
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