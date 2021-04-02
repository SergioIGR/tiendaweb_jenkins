<?php
require './ClassCliente.php';

// Variables
$servername = "localhost";
$username = "jenkins";
$password = "Powerfuljenkinsdb1-";
$dbname = "pruebas";
$tipoBusqueda = $_POST["param"];
$busqueda = $_POST["busqueda"];

// Establecer conexión con la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
//Buscar el cliente

$resultado = Cliente::buscar($busqueda,$tipoBusqueda,$conn);
$arrlength = count($resultado);

for($x = 0; $x < $arrlength; $x++) {
    echo $resultado[$x];
    echo "<br>";
}


// Cerrar la conexion a la base de datos
$conn->close();
?>
