<?php 

session_start();
  if (!isset($_SESSION['usuario'])) {
      header('Location: ../index.php');
      exit();
  }

// Base de Datos
require '../includes/config/database.php'; 
$db = conectarDB();


$resultado = $_GET['resultado'] ?? null;

// ELIMINAR
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $id = filter_var($id, FILTER_VALIDATE_INT);

  if($id) {
    $query = "DELETE FROM Formatos WHERE idFormatos = $id";

    $resultadoEliminar = mysqli_query($db, $query);

    if($resultadoEliminar) {
      header('location: ../listas/listaFormatos.php');
    }
  }
  
}


// CONSULTA DE TABLA
$query_Formatos = "SELECT Formatos.idFormatos, Formatos.fecRegistro, Formatos.hora, Formatos.ss, Formatos.fecInicio, Formatos.fecTermino, Formatos.carta, 
Formatos.primerInf, Formatos.segundoInf, Formatos.tercerInf, Formatos.finalInf, Formatos.terminacion, Formatos.evaluacion, Formatos.solicitud, Formatos.observaciones FROM Formatos";

$resultado_Formato = mysqli_query($db, $query_Formatos);

$formatos = array();
while ($fila = mysqli_fetch_array($resultado_Formato)) {
    $formatos[] = $fila;
}

mysqli_close($db);
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

  <?php if(intval($resultado) === 2 ): ?>
    <script>
  Swal.fire({
    title: 'Registro actualizado correctamente!',
    // text: 'You clicked the button!',
    icon: 'success',
    confirmButtonText: 'Aceptar',
    confirmButtonColor: '#65a30d',
    iconColor: '#65a30d',
    allowOutsideClick: false,
  }).then((result) => {
  window.location.href = "../listas/listaFormatos.php";
      const url = window.location.href.replace("?resultado=2", "");
      window.history.replaceState({path: url}, "", url);
})

document.addEventListener('keydown', function(event) {
  const key = event.key;
  if (key === "Enter") {
    Swal.close();
  }
});
</script>
  <?php endif ?>
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
                Lista de formatos
              </h5>
            </div>
            <a href="../formularios/registrarFormatos.php" class="btn btn-icon btn-3 btn-primary" type="button">
              <span class="btn-inner--icon"><i class="fas fa-user-plus"></i></span>
              <span class="btn-inner--text"> Agregar formato</span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <div class="row">

        <div class="col-12 mt-4">
          <div class="card mb-4">
             <div class="card-header pb-0 p-3">
            </div>
            
<div class="card">
  <div class="table-responsive">
    <table class="table align-items-center mb-0" id="tabla-lista">
      <thead class="">
        <tr>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Acción</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha y hora de Registro</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fecha de Inicio</th>
          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fecha de Termino</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Servicio social</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Carta presentacion</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Primer informe</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Segundo informe</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tercer informe</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Informe final</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Terminacion</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Evaluacion</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Solicitud</th>
          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
          

          <!-- <th class="text-secondary opacity-7"></th> -->
        </tr>
      </thead>
      <tbody>
      <?php if (empty($formatos)): ?>
        <tr>
          <td colspan="10" class="text-center">No se encontraron registros.</td>
        </tr>
      <?php else: ?>
      <?php foreach ($formatos as $formato): ?>
        <tr>
          <td>
            <div class="d-flex px-2 py-1 justify-content-center">
              <div class="d-flex">
                <a href="../formularios/actualizarFormatos.php?id=<?php echo $formato['idFormatos']; ?>" class="btn btn-icon btn-2 avatar avatar-sm me-3 btn-edit" type="button">
                  <span class="btn-inner--icon"><i class="las la-edit icon-edit"></i></span>
                </a>
                <form method="POST">
                  <input type="hidden" name="id" value="<?php echo $formato['idFormatos']; ?>">
                <button type="submit" class="btn btn-icon btn-2 btn-delete avatar avatar-sm me-3">
                  <span class="btn-inner--icon"><i class="las la-trash-alt icon-delete"></i></span>
                </button>
                </form>
              </div>
            </div>
          </td>
          <td>
          <div class="d-flex flex-column justify-content-center">
          <p class="text-xs text-secondary mb-0"><?= $formato['fecRegistro'] ?></p>
                <p class="text-xs text-secondary mb-0"><?= $formato['hora'] ?></p>
              </div>
          </td>
         
          <td>
          <p class="text-xs text-secondary mb-0"><?= $formato['fecInicio'] ?></p>
          </td>

          <td>
          <p class="text-xs text-secondary mb-0"><?= $formato['fecTermino'] ?></p>
          </td>

          <td class="align-middle text-center text-sm status">
          <?php if ($formato['ss'] == "Terminado") { ?>
            <span class="badge badge-sm badge-Terminado">Terminado</span>
          <?php } else if ($formato['ss'] == "Incompleto") { ?>
            <span class="badge badge-sm badge-red">Incompleto</span>
          <?php } else if ($formato['ss'] == "En curso") { ?>
            <span class="badge badge-sm badge-orange">En Curso</span>
          <?php } ?>
          <!-- <p class="text-xs text-secondary mb-0"><?= $formato['ss'] ?></p> -->
          </td>

          <td>
          <p class="text-xs text-secondary mb-0"><?= $formato['carta'] ?></p>
          </td>

          <td>
          <p class="text-xs text-secondary mb-0"><?= $formato['primerInf'] ?></p>
          </td>

          <td>
          <p class="text-xs text-secondary mb-0"><?= $formato['segundoInf'] ?></p>
          </td>

          <td>
          <p class="text-xs text-secondary mb-0"><?= $formato['tercerInf'] ?></p>
          </td>

          <td>
          <p class="text-xs text-secondary mb-0"><?= $formato['finalInf'] ?></p>
          </td>

          <td>
          <p class="text-xs text-secondary mb-0"><?= $formato['terminacion'] ?></p>
          </td>

          <td>
          <p class="text-xs text-secondary mb-0"><?= $formato['evaluacion'] ?></p>
          </td>

          <td>
          <p class="text-xs text-secondary mb-0"><?= $formato['solicitud'] ?></p>
          </td>

          <td>
          <p class="text-xs text-secondary mb-0"><?= $formato['observaciones'] ?></p>
          </td>

          
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>

      </tbody>
      </table>

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
  <script src="../assets/js/datatable.js"></script>
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