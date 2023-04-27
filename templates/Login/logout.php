<?php
// Iniciar sesión
session_start();

// Destruir la sesión actual
session_destroy();

// Redirigir al usuario a la página de inicio de sesión
header('Location: ../../index.php');
exit;
?>
