<?php
session_start(); // Iniciar la sesión

// Verificar que el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado. Por favor, inicia sesión."]);
    exit();
}

// Obtener el ID del usuario autenticado desde la sesión
$usuario_id = $_SESSION['usuario_id'];

// Verificar si el formulario fue enviado (si hay datos en $_POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validar si los datos necesarios están presentes
    if (isset($_POST['selectedTable'], $_POST['date'], $_POST['time'])) {
        // Conectar a la base de datos
        $conexion = new mysqli("localhost", "root", "", "login_register_bd");
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Obtener los datos del formulario
        $mesa_id = $_POST['selectedTable'];
        $fecha = $_POST['date'];
        $hora = $_POST['time'];

        // Verificar si la mesa seleccionada existe en la tabla mesas
        $sql_check_mesa = "SELECT * FROM mesas WHERE id = ?";
        $stmt_check_mesa = $conexion->prepare($sql_check_mesa);
        $stmt_check_mesa->bind_param("i", $mesa_id);
        $stmt_check_mesa->execute();
        $result_check_mesa = $stmt_check_mesa->get_result();

        if ($result_check_mesa->num_rows == 0) {
            echo json_encode(["status" => "error", "message" => "La mesa seleccionada no existe."]);
        } else {
            // Verificar disponibilidad de la mesa en la tabla reservas
            $sql_check = "SELECT * FROM reservas WHERE mesa_id = ? AND fecha = ? AND hora = ?";
            $stmt_check = $conexion->prepare($sql_check);
            $stmt_check->bind_param("iss", $mesa_id, $fecha, $hora);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                echo json_encode(["status" => "error", "message" => "La mesa ya está reservada para esta fecha y hora."]);
            } else {
                // Insertar la reserva en la base de datos
                $sql_insert = "INSERT INTO reservas (usuario_id, mesa_id, fecha, hora) VALUES (?, ?, ?, ?)";
                $stmt_insert = $conexion->prepare($sql_insert);
                $stmt_insert->bind_param("iiss", $usuario_id, $mesa_id, $fecha, $hora);
                if ($stmt_insert->execute()) {
                    echo json_encode(["status" => "success", "message" => "Reserva confirmada."]);
                } else {
                    // Mostrar error de SQL si ocurre un fallo en la inserción
                    echo json_encode([
                        "status" => "error",
                        "message" => "Error al realizar la reserva.",
                        "sql_error" => $stmt_insert->error
                    ]);
                }
            }
        }

        // Cerrar conexiones
        $stmt_check_mesa->close();
        $stmt_check->close();
        $stmt_insert->close();
        $conexion->close();
    } else {
        // Si faltan datos, enviar mensaje de error
        echo json_encode(["status" => "error", "message" => "Faltan datos para realizar la reserva."]);
    }
    exit(); // Terminar script después de procesar la solicitud AJAX
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Mesa</title>
    <link rel="stylesheet" href="CSS/reserva.css">
    <style>
        /* Estilos adicionales para mesas seleccionadas */
        .table.selected {
            background-color: #4CAF50; /* Cambia el color a verde */
            color: white;
            font-weight: bold;
        }
        .table {
            cursor: pointer; /* Cambia el cursor a pointer para mesas seleccionables */
            display: inline-block; /* Asegura que las mesas se muestren como bloques en línea */
            padding: 10px;
            margin: 5px;
            border: 1px solid #333;
            text-align: center;
        }
        .table.reserved {
            background-color: #e0e0e0; /* Color gris para mesas reservadas */
            color: #888;
            cursor: not-allowed; /* Cursor de no permitido para mesas reservadas */
        }
    </style>
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
            <form id="reservationForm" method="POST">
                <!-- Campo para seleccionar la hora -->
                <label for="time">Selecciona la hora:</label>
                <input type="time" id="time" name="time" required>

                <!-- Campo para seleccionar la fecha -->
                <label for="date">Selecciona la fecha:</label>
                <input type="date" id="date" name="date" required>

                <!-- Visualización de cantidad de sillas (se actualiza según la mesa seleccionada) -->
                <label for="chairs">Cantidad de sillas:</label>
                <p id="sillasInfo">Selecciona una mesa para ver la cantidad de sillas</p>

                <!-- Selección de la mesa -->
                <label for="table">Selecciona tu mesa:</label>
                <div class="tables">
                <div class="table available" data-table="1" data-sillas="4">Mesa 1</div>
                <div class="table available" data-table="2" data-sillas="6">Mesa 2</div>
                <div class="table available" data-table="3" data-sillas="4">Mesa 3</div>
                <div class="table available" data-table="4" data-sillas="8">Mesa 4</div>
                <!-- Continúa con las demás mesas -->

                </div>
                <div class="tables">
                <div class="table available" data-table="5" data-sillas="10">Mesa 5</div>
                <div class="table available" data-table="6" data-sillas="4">Mesa 6</div>
                <div class="table available" data-table="7" data-sillas="8">Mesa 7</div>
                <div class="table available" data-table="8" data-sillas="2">Mesa 8</div>
                </div>

                <!-- Campo oculto para enviar la mesa seleccionada -->
                <input type="hidden" id="selectedTable" name="selectedTable" required>

                <button type="submit">Confirmar Reserva</button>
            </form>
        </section>
    </main>

    <footer>
        <p>Contacto: info@reservapp.com</p>
        <p><a href="#">Política de Privacidad</a> | <a href="#">Términos de Servicio</a></p>
    </footer>

    <script>
        window.onload = function() {
            // Seleccionar todas las mesas y el campo de información de sillas
            const tables = document.querySelectorAll('.table');
            const selectedTableInput = document.getElementById('selectedTable');
            const sillasInfo = document.getElementById('sillasInfo'); // Asegúrate de que este elemento exista en tu HTML

            // Agregar un evento de clic a cada mesa
            tables.forEach(table => {
                table.addEventListener('click', function() {
                    console.log("Mesa seleccionada:", this.dataset.table); // Debug para confirmar el click
                    // Evitar selección si la mesa está reservada
                    if (this.classList.contains('reserved')) {
                        alert("Esta mesa ya está reservada.");
                        return;
                    }
                    
                    // Desmarcar todas las mesas seleccionadas
                    tables.forEach(t => t.classList.remove('selected'));
                    
                    // Marcar la mesa seleccionada
                    this.classList.add('selected');
                    
                    // Guardar el número de mesa seleccionada en el campo oculto
                    const mesaId = this.dataset.table;
                    selectedTableInput.value = mesaId;
                    
                    // Mostrar la cantidad de sillas de la mesa seleccionada
                    const numSillas = this.dataset.sillas || "N/A";
                    sillasInfo.textContent = `La mesa seleccionada tiene ${numSillas} sillas.`;
                });
            });
        };
    </script>

</body>
</html>