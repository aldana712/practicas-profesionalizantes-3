<?php
header('Content-Type: application/json');

$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "cuenta";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if ($data === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON received']);
    exit();
}

$id = $data['id'];
$username = $data['username'];
$balance = $data['balance'];

if (empty($id) || empty($username) || empty($balance)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    $conn->close();
    exit();
}

if (!is_numeric($balance)) {
    echo json_encode(['success' => false, 'message' => 'El saldo debe ser un número']);
    $conn->close();
    exit();
}

$sql = "UPDATE user SET username = ?, balance = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error]);
    $conn->close();
    exit();
}

$stmt->bind_param("ssi", $username, $balance, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Datos actualizados correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
