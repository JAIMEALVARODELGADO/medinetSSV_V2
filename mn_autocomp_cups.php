<?php
require("mn_funciones.php");
$link=conectarbd();
$q = strtoupper($_GET["q"]);
if (!$q) RETURN;
$sql = "SELECT DISTINCT vw_cups.id_cups,vw_cups.nombre_cups AS nombre FROM vw_cups
		WHERE vw_cups.estado_cups='AC' AND vw_cups.nombre_cups LIKE '%$q%'";
$rsd=$link->query($sql);
if($rsd){
    while($rs=$rsd->fetch_array()){
        $cid = $rs['id_cups'];		
        $cname = $rs['nombre'];
        echo "$cname|$cid\n";
    }
}
?>
<p><font color="#000000">no encontrado</font></p>