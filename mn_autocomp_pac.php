<?php
require("mn_funciones.php");
$link=conectarbd();
$q = strtoupper($_GET["q"]);
if (!$q) RETURN;
$sql = "SELECT DISTINCT vw_paciente2.id_persona,vw_paciente2.nombre AS nombre FROM vw_paciente2
		WHERE vw_paciente2.nombre LIKE '%$q%'";
$rsd=$link->query($sql);
if($rsd){
    while($rs=$rsd->fetch_array()){
        $cid = $rs['id_persona'];		
        $cname = $rs['nombre'];
        echo "$cname|$cid\n";
    }
}
?>
<p><font color="#000000">no encontrado</font></p>