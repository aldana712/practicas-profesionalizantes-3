
<?php
// Leer el archivo JSON
$jsonData = file_get_contents('C:/xampp/htdocs/webcomponent/practicas-profesionalizantes-3/webcomponents/cuentas.json');

// Decodificar el JSON
$data = json_decode($jsonData, true);

// Verificar si se ha decodificado correctamente
if ($data === null) {
    die("Error al decodificar el archivo JSON");
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
echo "Conexión exitosa<br>";


$stmt = $conn->prepare("INSERT INTO user (id, username, balance) VALUES (?, ?, ?)");


if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}


$stmt->bind_param("isd", $id, $username, $balance);


foreach ($data['cuentas'] as $cuenta) {
    
    $id = $cuenta['id'];
    $username = $cuenta['username'];
    $balance = floatval(str_replace('$', '', $cuenta['saldo']));

    if (!$stmt->execute()) {
        echo "Error al insertar los datos: " . $stmt->error . "<br>";
    }
}

$stmt->close();

$conn->close();

echo "Datos insertados exitosamente";
?>

