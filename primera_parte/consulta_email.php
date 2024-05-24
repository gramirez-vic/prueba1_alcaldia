<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Consulta de Usuario</h1>

        <?php
        // Incluir la conexión a la base de datos
        include '../db_connection.php';

        // Función para obtener el nombre de un usuario por su email
        function obtenerNombrePorEmail($email) {
            global $conn;
            $sql = "SELECT nombre FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row["nombre"];
            } else {
                return "Usuario no encontrado";
            }
        }

        // Manejar la solicitud del formulario
        $nombre = $error = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $nombre = obtenerNombrePorEmail($email);

            if ($nombre == "Usuario no encontrado") {
                $error = $nombre;
                $nombre = "";
            }
        }
        ?>

        <form id="consultaForm" method="POST" action="">
            <div class="form-group col-md-6">
                <label for="email">Email del Usuario:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary ml-4">Consultar</button>
        </form>
        <div class="mt-4 col-md-4">
            <?php
            if (!empty($nombre)) {
                echo '<div class="alert alert-info">Nombre del usuario: ' . htmlspecialchars($nombre) . '</div>';
            } elseif (!empty($error)) {
                echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($error) . '</div>';
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

