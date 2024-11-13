<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo '
        <script>
            alert("Por favor debes iniciar sesión");
            window.location = "index.php";
        </script>
    ';
    session_destroy();
    die();
}
// No destruyas la sesión aquí; permite que el usuario navegue mientras está logueado.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESTOCAR - Vista Principal</title>
    <link rel="stylesheet" href="CSS/principal.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>ReservApp</h1>
            <div class="buttons">
                <a href="reserva_mesa.html"><button>Reservar</button></a>
                <a href="index.php"><button>Iniciar sesión/Registro</button></a>
            </div>
        </header>
        <main>
            <div class="menu">
                <!-- Ejemplo de items de menú -->
                <div class="menu-item">
                    <img src="IMG/image.png" alt="Dish 1">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>S/. **.**</span>
                    <button class="info-button">Más información</button>
                    <div class="popup" style="display: none;">
                        <img src="IMG/image.png" alt="Dish 1">
                        <h3>Detalle del Platillo</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                        <span>S/. **.**</span>
                        <button class="close-button">Cerrar</button>
                    </div>
                </div>              
                <div class="menu-item">
                    <img src="IMG/image (1).png" alt="Dish 2">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>S/. **.**</span>
                    <button class="info-button">Más información</button>
                    <div class="popup" style="display: none;">
                        <img src="IMG/image (1).png" alt="Dish 2">
                        <h3>Detalle del Platillo</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                        <span>S/. **.**</span>
                        <button class="close-button">Cerrar</button>
                    </div>
                </div>
                <!-- Añade más elementos de menú si es necesario -->
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona todos los botones de "Más información" y de "Cerrar"
            const infoButtons = document.querySelectorAll('.info-button');

            infoButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Cierra todos los popups abiertos antes de abrir el nuevo
                    document.querySelectorAll('.popup').forEach(popup => {
                        popup.style.display = 'none';
                    });

                    // Muestra el popup correspondiente al botón clicado
                    const popup = this.nextElementSibling;
                    popup.style.display = 'block';
                });
            });

            // Agrega el evento de cierre a cada botón "Cerrar" dentro del popup
            document.querySelectorAll('.close-button').forEach(button => {
                button.addEventListener('click', function() {
                    const popup = this.parentElement;
                    popup.style.display = 'none';
                });
            });
        });
    </script>    
</body>
</html>
