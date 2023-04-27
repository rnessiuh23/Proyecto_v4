
<?php 

session_start();
  if (!isset($_SESSION['usuario'])) {
      header('Location: ../index.php');
      exit();
  }

$resultadoURL = $_GET['resultadoURL'] ?? null;

// Base de Datos
require '../includes/config/database.php'; 
$db = conectarDB();

// Array con mensajes de errores
$errores = [];

$idTutor = '';
$nombreTutor = '';
$denominacion = '';

// Ejecutar el codigo despues de que el usuario envia el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {

  // $idTutor = $_POST['idTutor'];
  $nombreTutor = strtoupper($_POST['nombreTutor']);
  $denominacion = $_POST['denominacion'];

  
  if(!$nombreTutor) {
    $errores['nombreTutor'][] = "Este campo es obligatorio";
  } else if(!preg_match('/^[a-zA-Z ]+$/', $nombreTutor)) {
    $errores['nombreTutor'][] = "El nombre solo puede contener letras y espacios";
  }

  if(!$denominacion) {
    $errores['denominacion'][] = "Establezca una denominacion";
  }


  // Revisar que el array de errores este vacio
  if(empty($errores)) {
    // INSERTAR EN LA BD
  $query = "INSERT INTO Tutor (nombreTutor, denominacion) VALUES ('$nombreTutor', '$denominacion')";

  // echo $query;

  $resultado = mysqli_query($db, $query);

  if($resultado) {
    // echo "Insertado correctamente";

    header('Location: ../formularios/registrarTutores.php?resultadoURL=1');
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
    Tutores
  </title>
  <?php include '../recursos/recursos.php' ?>
</head>

<body class="g-sidenav-show bg-gray-100">
  <?php include '../templates/Menu/menu.php' ?>
  <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    <?php if(intval($resultadoURL) === 1): ?>
      <script>

Swal.fire({
    title: 'Registro agregado correctamente!',
    html: '<p>¿Desea agregar otro tutor?</p>',
    icon: 'success',
    confirmButtonText: 'Seguir agregando',
    confirmButtonColor: '#65a30d',
    cancelButtonText: 'No',
    iconColor: '#65a30d',
    allowOutsideClick: false,
    showCancelButton: true
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "../formularios/registrarTutores.php";
    } else {
      window.location.href = "../listas/listaTutores.php";
      const url = window.location.href.replace("?resultadoURL=1", "");
      window.history.replaceState({path: url}, "", url);
    }
  });

  document.addEventListener('keydown', function(event) {
    const key = event.key;
    if (key === "Enter") {
      Swal.close();
    }
  });
</script>
    <?php endif ?>
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg bg-transparent shadow-none position-absolute px-4 w-100 z-index-2">
      <div class="container-fluid py-1">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 ps-2 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="text-white opacity-5" href="javascript:;">Formularios</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Tutores</li>
          </ol>
          <h6 class="text-white font-weight-bolder ms-2">Tutores</h6>
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
                Agregar tutores
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
  <form method="POST" action="../formularios/registrarTutores.php">

  
    <div class="col-md-6">
      <div class="form-group">
        <input type="text" class="form-controlNone text-uppercase" name="idTutor" id="idTutor" placeholder="" value="<?php echo $idTutor; ?>" disabled>
        <?php if(isset($errores['idTutor'])): ?>
          <div class="message-error" id="idTutor-error" id="idTutor-error">
            <?php foreach($errores['idTutor'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
      <label for="denominacion">Denominacion</label>
      <select name="denominacion" id="denominacion" class="form-select text-uppercase" aria-label="Default select example">
        <option value="" selected>-- Selecciona --</option>
        <option <?php echo $denominacion === "Dr." ? 'selected' : '' ?> value="Dr.">Dr.</option>
        <option <?php echo $denominacion === "Mstr." ? 'selected' : '' ?> value="Mstr.">Mstr.</option>
        <option <?php echo $denominacion === "Lic." ? 'selected' : '' ?> value="Lic.">Lic.</option>
        <option <?php echo $denominacion === "Ing." ? 'selected' : '' ?> value="Ing.">Ing.</option>
      </select>
      <?php if(isset($errores['denominacion'])): ?>
          <div class="message-error" id="denominacion-error">
            <?php foreach($errores['denominacion'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
      <label for="nombreTutor">Nombre completo</label>
      <input type="text" name="nombreTutor" id="nombreTutor" class="form-control text-uppercase" placeholder="Ej. Juan Carlos Benitez Estrada" value="<?php echo $nombreTutor; ?>" autofocus>
        <?php if(isset($errores['nombreTutor'])): ?>
          <div class="message-error" id="nombre-error">
            <?php foreach($errores['nombreTutor'] as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>


  <button class="btn btn-icon btn-3 btn-primary" type="submit">
	<span class="btn-inner--icon"><i class="fas fa-user-plus"></i></span>
  <span class="btn-inner--text"> Agregar</span>
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
  const telefonoDepInput = document.getElementById('telefonoDep');

  telefonoDepInput.addEventListener('keyup', (e) => {
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