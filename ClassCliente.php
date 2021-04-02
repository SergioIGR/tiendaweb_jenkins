<?php
require 'ClassEnvioMail.php';
require 'vendor/autoload.php';

class Cliente {
    //Estado
    private $dni;
    private $nombre;
    private $apellidos;
    private $fnac;
    private $email;

    //Comportamiento
     function __construct($nombre,$apellidos,$dni,$email,$fnac) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fnac = $fnac;
        $this->email = $email;
    }

    //darse de alta
    function darAlta($conn) {

      // Consulta para realizar inserción a la base de datos
        $sql = "INSERT INTO clientes (nombre,apellidos,dni,email,fecha_de_nacimiento) VALUES ('".$this->nombre."','".$this->apellidos."','".$this->dni."','".$this->email."','".$this->fnac."');";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            //hago la construccion del email y lo mando
            $miEmail = new envioEmail($this->email);
            $miEmail->sendMail();
        
    
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
    }

    function asignarEmail($nuevoEmail) {
      $this->email = $nuevoEmail;
    }
    
    //Buscar un/unos cliente/s dentro de la BBDD y mostrarlo por pantalla
    public static function buscar($busqueda,$tipoBusqueda,$conn) {

        // Consulta para realizar la búsqueda en la base de datos
        $sql = "SELECT * FROM clientes WHERE ";
        switch ($tipoBusqueda){
        case "nombre":
          $sql = $sql."nombre like '%$busqueda%';";
        break;
        case "apellidos":
          $sql = $sql."apellidos like '%$busqueda%';";
        break;
        case "email":
          $sql = $sql."email like '%$busqueda%';";
        break;
        case "dni":
          $sql = $sql."dni like '%$busqueda%';";
        break;
        case "fecha_nacimiento":
            $sql = $sql."fecha_de_nacimiento like '%$busqueda%';";
        break;
        default:
          echo "Se ha producido un error durante la búsqueda.";
      }

      $resultado = $conn->query($sql);
        $usuarios = array();
        $contador = 0;

      // Consulta para realizar la busqueda en la base de datos
      if ($resultado->num_rows > 0) {
        // Salida de datos por cada fila
        while($row = $resultado->fetch_assoc()) {
          $usuarios[$contador] = "- Nombre: ".$row["nombre"].", Apellidos: ".$row["apellidos"].", Email: ".$row["email"].", DNI: ".$row["dni"].", Fecha de nacimiento ".$row["fecha_de_nacimiento"]." <br>";
          $contador++;
        }

        return $usuarios;

      }else{
        echo "No se han encontrado resultados.";
        return $usuarios;
      }
    }
   }
?>