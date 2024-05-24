<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta y Actualización de Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Consulta y Actualización de Usuario</h1>

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

        // Función para actualizar la contraseña de un usuario por su nombre
        function actualizarContrasenaPorNombre($nombre, $nueva_contrasena) {
            global $conn;
            $sql = "UPDATE usuarios SET contrasena = ? WHERE nombre = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $nueva_contrasena, $nombre);
            if ($stmt->execute()) {
                return "Contraseña actualizada exitosamente";
            } else {
                return "Error al actualizar contraseña: " . $conn->error;
            }
        }

        // Variables para los resultados
        $nombre = $error = $actualizacion = "";
        // Manejar la solicitud del formulario de actualización de contraseña
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar'])) {
            $nombre_usuario = $_POST['nombre'];
            $nueva_contrasena = $_POST['nueva_contrasena'];
            $actualizacion = actualizarContrasenaPorNombre($nombre_usuario, $nueva_contrasena);
        }
        ?>

        <!-- Formulario de actualización de contraseña -->
        <div class="mt-5">
            <h2>Actualizar Contraseña</h2>
            <form id="actualizarForm" method="POST" action="">
                <div class="form-group">
                    <label for="nombre">Nombre del Usuario:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="nueva_contrasena">Nueva Contraseña:</label>
                    <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena" required>
                </div>
                <button type="submit" class="btn btn-primary" name="actualizar">Actualizar</button>
            </form>
            <div class="mt-4">
                <?php
                if (!empty($actualizacion)) {
                    echo '<div class="alert alert-info">' . htmlspecialchars($actualizacion) . '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
