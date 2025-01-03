<?php
// cierra la sesion del usuario
session_start();
session_unset();
session_destroy();
header("Location: ../usuario_global/index.php");
exit();
?>