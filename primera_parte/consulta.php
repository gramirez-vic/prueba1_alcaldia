<?php
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $nombre = obtenerNombrePorEmail($email);

    if ($nombre != "Usuario no encontrado") {
        header("Location: index.php?nombre=" . urlencode($nombre));
    } else {
        header("Location: index.php?error=" . urlencode("Usuario no encontrado"));
    }
    exit();
}
?>
