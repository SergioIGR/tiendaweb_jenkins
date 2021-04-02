<?php
require './ClassCliente.php';

// Variables 
$servername = "localhost";
$username = "jenkins";
$password = "Powerfuljenkinsdb1-";
$dbname = "pruebas";
$dni = $_POST["dni"];
$fnom = $_POST["nombre"];
$fape = $_POST["apellidos"];
$fmail = $_POST["email"];
$fdate = $_POST["fecha"];

// Establecer conexión con la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

//Creamos un objeto cliente y le pedimos el alta.
$clienteNuevo = new Cliente($fnom,$fape,$dni,$fmail,$fdate);

$clienteNuevo->darAlta($conn);

// Cerrar la conexion a la base de datos
$conn->close();
?>
