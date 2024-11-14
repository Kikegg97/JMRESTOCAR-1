<?php
// Obtener los detalles de la reserva de la URL
$mesa_id = $_GET['mesa_id'];
$fecha = $_GET['fecha'];
$hora = $_GET['hora'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva</title>
    <link rel="stylesheet" href="CSS/confirmacion_reserva.css">
</head>
<body>
    <header>
        <div class="logo">ReservApp</div>
        <button onclick="window.location.href='menu.php'" class="menu-button">Menu</button>
    </header>

    <main>
        <section class="confirmation-box">
            <div class="icon">
                <img src="icono_exito.png" alt="Ícono de éxito" style="width:50px;height:50px;">
            </div>
            <h2>Reserva</h2>
            <p>Su reserva en la mesa <?php echo htmlspecialchars($mesa_id); ?> se realizó con éxito y fue notificado a su correo</p>
            <hr>
            <div class="details">
                <p><strong>Fecha:</strong> <?php echo htmlspecialchars($fecha); ?></p>
                <p><strong>Ubicación:</strong> Mesa <?php echo htmlspecialchars($mesa_id); ?></p>
            </div>
            <button onclick="window.location.href='mis_reservas.php'" class="reservas-button">Mis Reservas</button>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <p><strong>Contacto</strong> 999999999</p>
            <div class="social-links">
                <p><strong>Redes Sociales</strong></p>
                <a href="https://instagram.com" target="_blank">Instagram</a> |
                <a href="https://facebook.com" target="_blank">Facebook</a>
            </div>
        </div>
    </footer>
</body>
</html>
