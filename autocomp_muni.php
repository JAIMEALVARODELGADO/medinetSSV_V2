<?php
require("pp_funciones.php");
$link=conectarbd();
$q = strtoupper($_GET["q"]);
if (!$q) RETURN;
$sql = "SELECT DISTINCT vw_municipio.codigo_mun,vw_municipio.nombre AS nombre FROM vw_municipio
		WHERE vw_municipio.nombre LIKE '%$q%'";
$rsd=$link->query($sql);
if($rsd){
    while($rs=$rsd->fetch_array()){
        $cid = $rs['codigo_mun'];	
        $cname = $rs['nombre'];
        echo "$cname|$cid\n";
    }
}
?>
<p><font color="#000000">no encontrado</font></p>