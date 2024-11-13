<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Mesa</title>
    <link rel="stylesheet" href="CSS/reserva.css">
</head>
<body>
    <header>
        <div class="logo">ReservApp</div>
        <nav>
            <ul>
                <li><a href="menu.php">Inicio</a></li>
                <li><a href="menu_principal.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="reservation-form">
            <h1>Reservar Mesa</h1>
            <form>
                <label for="date">Selecciona la fecha:</label>
                <input type="date" id="date" name="date" required>

                <label for="chairs">Número de sillas:</label>
                <select id="chairs" name="chairs">
                    <option value="2">2 Sillas</option>
                    <option value="4">4 Sillas</option>
                    <option value="6">6 Sillas</option>
                    <option value="8">8 Sillas</option>
                    <option value="10">10 Sillas</option>
                </select>

                <label for="table">Selecciona tu mesa:</label>
                <div class="tables">
                    <div class="table available" data-table="1">Mesa 1</div>
                    <div class="table reserved" data-table="2">Mesa 2</div>
                    <div class="table available" data-table="3">Mesa 3</div>
                    <div class="table available" data-table="4">Mesa 4</div>
                </div>

                <button type="submit">Confirmar Reserva</button>
            </form>
        </section>
    </main>

    <footer>
        <p>Contacto: info@reservapp.com</p>
        <p><a href="#">Política de Privacidad</a> | <a href="#">Términos de Servicio</a></p>
    </footer>
</body>
</html>
