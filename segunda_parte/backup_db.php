<?php
    // Incluir el archivo de conexión a la base de datos
    include '../db_connection.php';

    // Nombre del archivo de respaldo
    $backup_file = "../respaldo_dab" . $database . "_backup_" . date("Y-m-d_H-i-s") . ".sql";

    // Comando mysqldump
    $command = "mysqldump --opt -h $servername -u $username -p$password $database > $backup_file";

    // Ejecutar el comando
    system($command, $output);

    // Verificar si se ejecutó correctamente
    if ($output === 0) {
        echo "Respaldo realizado exitosamente en: " . $backup_file . "\n";
    } else {
        echo "Error al realizar el respaldo.\n";
    }
?>
