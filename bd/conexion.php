<?php
include("variables.php");
// $servidor = "localhost";
// $usuario = "root";
// $contrasenha = "";
// $bd = "TiendaInformatica";

$conexion = mysqli_connect($servidor, $usuario, $contrasenha, $bd);

if(!$conexion){
    die("Error de conexión: " . mysqli_connect_error());
}
?>



