<?php
if (isset($_GET['id'])) {
    $idUsuario = intval($_GET['id']);

    // Conexión a la base de datos
    require_once('../usuario_global/Conexion.php');
    $base = new Conexion();
    $conn = $base->getConn();

    // Consulta para obtener los datos actuales del usuario
    $sql = "SELECT dp.NOMBRE, dp.APELLIDO_1, dp.APELLIDO_2, dp.TELEFONO, 
                   d.CALLE, d.NUMERO_EXT, d.NUMERO_INT, d.COLONIA, d.ALCALDIA, d.CODIGO_POSTAL, 
                   u.FECHA_NACIMIENTO, u.CORREO, u.CONTRASENA
            FROM USUARIOS u
            INNER JOIN DATOS_PERSONALES dp ON u.ID_DATOS_PERSONALES = dp.ID_DATOS_PERSONALES
            INNER JOIN DIRECCIONES d ON u.ID_DIRECCION = d.ID_DIRECCION
            WHERE u.ID_USUARIO = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontraron datos
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();?>
        
        <form method="POST" action="actualizar_usuario.php">
        <input type="hidden" name="id_usuario" value="<?php echo $idUsuario; ?>" />
        <div class="row gtr-uniform">
            <div class="col-4 col-12-small">
                <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario['NOMBRE']); ?>" placeholder="Nombre" />
            </div>
            <div class="col-4 col-12-small">
                <input type="text" name="apellido1" id="apellido1" value="<?php echo $usuario['APELLIDO_1']; ?>" placeholder="Primer apellido" />
            </div>
            <div class="col-4 col-12-small">
                <input type="text" name="apellido2" id="apellido2" value="<?php echo $usuario['APELLIDO_2']; ?>" placeholder="Segundo apellido" />
            </div>
            <div class="col-4 col-12-small">
                <input type="email" name="correo" id="correo" value="<?php echo $usuario['CORREO']; ?>" placeholder="Correo electrónico" />
            </div>
            <div class="col-4 col-12-small">
                <input type="password" name="pass1" id="pass1" placeholder="Nueva Contraseña" value="<?php echo $usuario['CONTRASENA']; ?>"/>
            </div>
            <div class="col-4 col-12-small">
                <input type="password" name="pass2" id="pass2" placeholder="Confirmar Contraseña" value="<?php echo $usuario['CONTRASENA']; ?>"/>
            </div>
            <div class="col-4 col-12-small">
                <input type="tel" name="telefono" id="telefono" value="<?php echo $usuario['TELEFONO']; ?>" placeholder="Teléfono" />
            </div>
            <div class="col-4 col-12-small">
                <input type="date" name="fechaNacimiento" id="fechaNacimiento" value="<?php echo $usuario['FECHA_NACIMIENTO']; ?>" placeholder="Fecha de nacimiento" />
            </div>
            <div class="col-12">
                <h4>Ingresa tu dirección</h4>
            </div>
            <div class="col-6 col-12-small">
                <input type="text" name="calle" id="calle" value="<?php echo $usuario['CALLE']; ?>" placeholder="Calle" />
            </div>
            <div class="col-2 col-6-small">
                <input type="text" name="numeroExt" id="numeroExt" value="<?php echo $usuario['NUMERO_EXT']; ?>" placeholder="Número exterior" />
            </div>
            <div class="col-2 col-6-small">
                <input type="text" name="numeroInt" id="numeroInt" value="<?php echo $usuario['NUMERO_INT']; ?>" placeholder="Número interior" />
            </div>
            <div class="col-2 col-6-small">
                <input type="text" name="codigo_postal" id="codigo_postal" value="<?php echo $usuario['CODIGO_POSTAL']; ?>" placeholder="Código postal" />
            </div>
            <div class="col-6">
                <input type="text" name="colonia" id="colonia" value="<?php echo $usuario['COLONIA']; ?>" placeholder="Colonia" />
            </div>
            <div class="col-6">
                <input type="text" name="alcaldia" id="alcaldia" value="<?php echo $usuario['ALCALDIA']; ?>" placeholder="Alcaldía" />
            </div>
            <input type="hidden" name="tipoUsuario" value="1" />
            <div class="col-12">
                <input type="submit" value="Actualizar" name="Actualizar" />
            </div>
        </div>
        </form>
        
    <?php
    } else {
        echo "<p>Error: Usuario no encontrado.</p>";
    }
    $conn->close();
} else {
    echo "<p>Error: No se especificó el usuario.</p>";
}
?>