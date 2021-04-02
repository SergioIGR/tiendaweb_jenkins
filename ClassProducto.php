<?php
require 'vendor/autoload.php';

class Producto {

    //Estado
    Private $Codigo;
    Private $Descripcion;
    Private $Precio;
    Private $Stock;

    //Comportamiento
    function __construct($Codigo,$Descripcion,$Precio,$Stock)
    {
        $this->Codigo = $Codigo;
        $this->Descripcion = $Descripcion;
        $this->Precio = $Precio;
        $this->Stock = $Stock;

    }

    //Insertar un producto

    function insertarproducto($conn){

        $sql = "INSERT INTO productos (CodProducto,Descripcion,Precio,Stock) VALUES ('".$this->Codigo."','".$this->Descripcion."','".$this->Precio."','".$this->Stock."');";

        if ($conn->query($sql) === TRUE) {
            echo "Todo ha salido bien";

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    //Buscar un producto en función de un parámetro

    public static function buscarproductos($busqueda,$tipoBusqueda,$conn) {

        // Consulta para realizar la búsqueda en la base de datos
        $sql = "SELECT * FROM productos WHERE ";
        switch ($tipoBusqueda){
            case "CodProducto":
                $sql = $sql."CodProducto like '%$busqueda%';";
                break;
            case "Descripcion":
                $sql = $sql."Descripcion like '%$busqueda%';";
                break;
            case "Precio":
                $sql = $sql."Precio like '%$busqueda%';";
                break;
            case "Stock":
                $sql = $sql."Stock like '%$busqueda%';";
                break;
            default:
                echo "Se ha producido un error durante la búsqueda.";
        }

        $resultado = $conn->query($sql);
        $productos = array();
        $contador = 0;

        // Consulta para realizar la busqueda en la base de datos
        if ($resultado->num_rows > 0) {
            // Salida de datos por cada fila
            while($row = $resultado->fetch_assoc()) {

                $productos[$contador] = "- Codigo: ".$row["CodProducto"].", Descripcion: ".$row["Descripcion"].", Precio: ".$row["Precio"].", Stock: ".$row["Stock"]."<br>";
                $contador++;

            }
            return $productos;

        }else{
            echo "No se han encontrado resultados.";
            return $productos;
        }
    }
}