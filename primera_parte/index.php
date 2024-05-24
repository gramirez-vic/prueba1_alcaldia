<?php
// Incluir el archivo de conexión a la base de datos
include '../db_connection.php';

$messages = [];

// 1. Crear la tabla usuarios
$sql_create_table = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(250) NOT NULL,
    email VARCHAR(250) NOT NULL,
    contrasena VARCHAR(255) NOT NULL
)";

if ($conn->query($sql_create_table) === TRUE) {
    $messages[] = ["type" => "success", "text" => "Tabla 'usuarios' creada exitosamente"];
} else {
    $messages[] = ["type" => "danger", "text" => "Error al crear la tabla: " . $conn->error];
}

// Función para verificar si un registro existe
function usuarioExiste($email) {
    global $conn;
    $sql = "SELECT id FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Datos de los usuarios a insertar
$usuarios = [
    ['nombre' => 'gabriel ramirez', 'email' => 'gabiel.ramirez@gmail.com', 'contrasena' => '12345'],
    ['nombre' => 'victoria ramirez', 'email' => 'victoria@gmail.com', 'contrasena' => '12345'],
    ['nombre' => 'catalina gamboa', 'email' => 'catalina@gmail.com', 'contrasena' => '12345']
];

// 2. Insertar registros en la tabla usuarios si no existen
foreach ($usuarios as $usuario) {
    if (!usuarioExiste($usuario['email'])) {
        $sql_insert = "INSERT INTO usuarios (nombre, email, contrasena) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("sss", $usuario['nombre'], $usuario['email'], $usuario['contrasena']);
        if ($stmt->execute() === TRUE) {
            $messages[] = ["type" => "success", "text" => "Registro de " . $usuario['nombre'] . " insertado exitosamente"];
        } else {
            $messages[] = ["type" => "danger", "text" => "Error al insertar registro de " . $usuario['nombre'] . ": " . $conn->error];
        }
    } else {
        $messages[] = ["type" => "info", "text" => "El usuario con email " . $usuario['email'] . " ya existe"];
    }
}

// Recuperar todos los registros de la tabla usuarios
$sql_select = "SELECT id, nombre, email, contrasena FROM usuarios";
$result = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Usuarios Registrados</h1>
        
        <?php foreach ($messages as $message): ?>
            <div class="alert alert-<?php echo $message['type']; ?>" role="alert">
                <?php echo $message['text']; ?>
            </div>
        <?php endforeach; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Contraseña</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nombre']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['contrasena']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay usuarios registrados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
