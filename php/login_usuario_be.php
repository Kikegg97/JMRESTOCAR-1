<?php
session_start();

include 'conexion_be.php';

$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

// Verificación de login sin encriptación de contraseña
$validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' AND contraseña='$contraseña'");

if (mysqli_num_rows($validar_login) > 0) {
    $_SESSION['usuario'] = $correo;
    header("location: ../menu.php");
    exit;
} else {
    echo '
        <script>
            alert("Usuario no existe, por favor verifique los datos ");
            window.location = "../menu_principal.php"
        </script>
    ';
    exit;
}
?>
