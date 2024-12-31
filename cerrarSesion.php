<?php
// cierra la sesion del usuario
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit();
?>