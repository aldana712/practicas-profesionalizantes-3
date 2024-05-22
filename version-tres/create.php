<?php
// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos JSON enviados
    $data = json_decode(file_get_contents('php://input'), true);

    // Verificar si los datos se han decodificado correctamente
    if ($data === null) {
        die("Error al recibir los datos JSON");
    }

    // Configuración de la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cuenta";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Preparar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO user (id, username, balance) VALUES (?, ?, ?)");

    // Verificar si la preparación fue exitosa
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Remover el símbolo de dólar y convertir a float
    $id = $data['id'];
    $username = $data['username'];
    $balance = floatval(str_replace('$', '', $data['saldo']));

    // Vincular los parámetros
    $stmt->bind_param("isd", $id, $username, $balance);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Datos insertados exitosamente";
    } else {
        echo "Error al insertar los datos: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "Método no permitido";
}
?>
