<?php
require("pp_funciones.php");
$link=conectarbd();
$q = strtoupper($_GET["q"]);
if (!$q) RETURN;
$sql = "SELECT DISTINCT vw_institucion.id_institucion,CONCAT(vw_institucion.nombre,' (',vw_institucion.nombre_mun,')') AS nombre FROM vw_institucion
		WHERE vw_institucion.nombre LIKE '%$q%'";
$rsd=$link->query($sql);
if($rsd){
    while($rs=$rsd->fetch_array()){
        $cid = $rs['id_institucion'];		
        $cname = $rs['nombre'];
        echo "$cname|$cid\n";
    }
}
?>
<p><font color="#000000">no encontrado</font></p>
