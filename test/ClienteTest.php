<?php

//Descomentar dependendiendo de donde este el archivo PHP
//Windows
//require 'vendor/autoload.php';
//require 'ClassCliente.php';

//Linux
require '/var/www/html/vendor/autoload.php';
require '/var/www/html/ClassCliente.php';

class ClienteTest extends \PHPUnit\Framework\TestCase
{


    public function testDarAlta()
    {

        $servername = "localhost";
        $username = "jenkins";
        $password = "Powerfuljenkinsdb1-";
        $dbname = "pruebas";

        // Establecer conexión con la base de datos
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        //Primera tanda

        //Primero calculo cuantas lineas hay en la tabla

        $sqlPrueba = "select * from clientes;";
        $resultado = $conn->query($sqlPrueba);

        // Consulta para realizar la busqueda en la base de datos
        $clientesAntes = $resultado->num_rows;


        $clienteNuevo = new Cliente("prueba", "prueba", "prueba", "prueba", "1998-04-04");

        $clienteNuevo->darAlta($conn);

        $resultado = $conn->query($sqlPrueba);

        // Consulta para realizar la busqueda en la base de datos

        $clientesDespues = $resultado->num_rows;


        $this->assertEquals($clientesAntes + 1, $clientesDespues, "<br>El cliente se da de alta correctamente<br>");

        //Segunda tanda

        $sqlPrueba = "select * from clientes where dni like 'prueba';";
        $resultado = $conn->query($sqlPrueba);

        // Consulta para realizar la busqueda en la base de datos
        $numeroFilas = $resultado->num_rows;

        $this->assertEquals(1, $numeroFilas, "El cliente se da de alta correctamente, 2a prueba, y no se repiten filas");

        $conn->close();


    }

    public function testBuscar()
    {

        $servername = "localhost";
        $username = "jenkins";
        $password = "Powerfuljenkinsdb1-";
        $dbname = "pruebas";

        // Establecer conexión con la base de datos
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        //Aqui vamos a crear el cliente y a darlo de alta.
        $clienteNuevo = new Cliente("buscar", "buscar", "buscar", "buscar", "1998-04-04");

        $clienteNuevo->darAlta($conn);

        //Primer test

        $buscarcliente = Cliente::buscar("buscar", "dni",$conn);


        $this->assertEquals(1, count($buscarcliente), "Se ha encontrado el cliente correctamente");

        //Segundo test

        $buscarcliente = Cliente::buscar("ajfkkabfkf", "nombre",$conn);

        $this->assertEquals(0, count($buscarcliente), "Se ha comprobado que al buscar algo random efectivamente no encuentra nada");

        $conn->close();


    }

}
