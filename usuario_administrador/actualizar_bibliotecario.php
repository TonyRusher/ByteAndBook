<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['Actualizar'])) {
    require_once('../usuario_global/Conexion.php');
    $base = new Conexion();
    $conn = $base->getConn();

    // Datos del formulario
    $idUsuario = intval($_POST["id_usuario"]); // Aquí deberías recibir el ID del usuario de alguna manera
    $nombre = $_POST["nombre"];
    $apellido1 = $_POST["apellido1"];
    $apellido2 = $_POST["apellido2"];
    $telefono = $_POST["telefono"];
    $calle = $_POST["calle"];
    $numeroExt = $_POST["numeroExt"];
    $numeroInt = $_POST["numeroInt"] ?? null;
    $colonia = $_POST["colonia"];
    $alcaldia = $_POST["alcaldia"];
    $codigo_postal = $_POST["codigo_postal"];
    $fechaNacimiento = $_POST["fechaNacimiento"];
    $correo = $_POST["correo"];
    $pass1 = $_POST["pass1"];
    $pass2 = $_POST["pass2"];
    $tipoUsuario = isset($_POST['tipoUsuario']) ? $_POST['tipoUsuario'] : 2;

    // Asegúrate de validar las contraseñas antes de continuar
    if ($pass1 !== $pass2) {
        echo "<script>Swal.fire('Las contraseñas no coinciden.');</script>";
        exit;
    }

    // Llamada al procedimiento almacenado para actualizar los datos
    $sql = "CALL ActualizarDatosUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Asigna los parámetros
    $stmt->bind_param(
        "isssssisssssssi", // 15 parámetros, ajustados a los tipos correctos
        $idUsuario,
        $nombre,
        $apellido1,
        $apellido2,
        $telefono,
        $calle,
        $numeroExt,
        $numeroInt,
        $colonia,
        $alcaldia,
        $codigo_postal,
        $fechaNacimiento,
        $correo,
        $pass1,
        $tipoUsuario
    );

    // Ejecuta y verifica el resultado
    if ($stmt->execute()) {
        echo "<script>Swal.fire('Datos actualizados exitosamente');</script>";
    } else {
        echo "<script>Swal.fire('Error: " . $stmt->error . "');</script>";
    }

    $conn->close();
}
?>
<?php
header("Location: buscar_bibliotecario.php");
exit();
?>
