<?php
include 'conexion_be.php'; // Incluye la conexión

$nombre_completo = $_POST['nombre_completo'];
$correo = $_POST['correo'];
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

// Encriptación de la contraseña (opcional)
// $contrasena = hash('sha512', $contrasena);

$query = "INSERT INTO usuarios(nombre_completo, correo, usuario, contraseña) 
          VALUES('$nombre_completo', '$correo', '$usuario', '$contraseña')";

// Verificar que el correo no se repita
$verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo'");
if (mysqli_num_rows($verificar_correo) > 0) {
    echo '
        <script>
            alert("Este correo ya está registrado, intenta con otro diferente");
            window.location = "../menu_principal.php";
        </script>
    ';
    exit();
}

// Verificar que el nombre de usuario no se repita
$verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario'");
if (mysqli_num_rows($verificar_usuario) > 0) {
    echo '
        <script>
            alert("Este usuario ya está registrado, intenta con otro diferente");
            window.location = "../menu_principal.php";
        </script>
    ';
    exit();
}

// Ejecutar la inserción
$ejecutar = mysqli_query($conexion, $query);
if ($ejecutar) {
    echo '
        <script>
            alert("Usuario almacenado exitosamente");
            window.location = "../menu.php";
        </script>
    ';
} else {
    echo '
        <script>
            alert("Error al almacenar el usuario: ' . mysqli_error($conexion) . '");
            window.location = "../menu_principal.php";
        </script>
    ';
}

mysqli_close($conexion); // Cierra la conexión
?>
