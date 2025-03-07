<?php

require("mn_funciones.php");

$link=conectarbd();

$id_consulta = $_POST['id_consulta'];

//Aqui elimino la consulta
$sql = "DELETE FROM nrconsulta WHERE id_consulta = '$id_consulta'";
mysqli_query($link, $sql);
if(mysqli_affected_rows($link)>0){
    echo "1";}
else{
    echo "0";
}

?>