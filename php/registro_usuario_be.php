<?php

    include 'conexion_be.php';

    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    //Encriptacion de las contraseñas 
    //$contrasena = hash('sha512', $contrasena);

    $query = "INSERT INTO usuarios(nombre_completo, correo, usuario, contrasena) 
                VALUES('$nombre_completo', '$correo', '$usuario', '$contrasena')";
    
    //verificar que el correo no se repita
    $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo'");

    if(mysqli_num_rows($verificar_correo) > 0){
        echo '
            <script>
                alert("Este correo ya esta registrado, intenta con otro diferente");
                window.location = "../menu_principal.php";
            </script>
        ';
        exit();
    }

    //verificar que el nombre de usuario no se repita 
    $verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario'");

    if(mysqli_num_rows($verificar_usuario) > 0){
        echo '
            <script>
                alert("Este usuario ya esta registrado, intenta con otro diferente");
                window.location = "../menu_principal.php";
            </script>
        ';
        exit();
    }
    //notificacion del registro en la BD
    $ejecutar = mysqli_query($conexion, $query);

    if($ejecutar){
        echo '
            <script>
                alert("Usuario alamcenado exitosamente");
                window.location = "../menu.php";
            </script>
        ';
    }else{
        echo '
            <script>
                alert("Intentalo de Nuevo Usuario no almacenado");
                window.location = "../menu_principal.php";
            </script>
        ';
    }

    mysqli_close($conexion);
?>