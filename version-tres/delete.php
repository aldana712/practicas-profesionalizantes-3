<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cuenta";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id']) || empty($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    exit;
}

$id = $conn->real_escape_string($data['id']);


$sql = "DELETE FROM user WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar usuario: ' . $conn->error]);
}

$conn->close();
?>
