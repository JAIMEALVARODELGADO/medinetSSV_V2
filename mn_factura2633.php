<?php
require("mn_funciones.php");
$link=conectarbd();

$id_otoservicio = $_POST['id_otroservicio'];

$sql="DELETE FROM nrotroservicios WHERE id_otroservicio='$id_otoservicio'";
//echo $sql;

$link->query($sql);

if($link->affected_rows > 0){
    echo 1;
}
else{
    echo 0;
}
   
?>
