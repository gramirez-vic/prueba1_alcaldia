<?php
include '../db_connection.php';

function obtenerNombrePorEmail($email) {
    global $conn;
    $sql = "SELECT nombre FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_sresult();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["nombre"];
    } else {
        return "Usuario no encontrado";
    }
}



?>
