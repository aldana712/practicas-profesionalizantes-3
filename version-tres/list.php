<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cuenta";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id, username, balance FROM user";
$result = $conn->query($sql);

$users = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = [
            'id' => $row['id'],
            'username' => $row['username'],
            'saldo' => '$' . number_format($row['balance'], 2)
        ];
    }
} else {
    echo "No se encontraron usuarios";
}

$conn->close();


header('Content-Type: application/json');
echo json_encode($users);
?>
