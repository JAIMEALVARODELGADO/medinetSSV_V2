<?php
require("mn_funciones.php");
$link=conectarbd();
$q = strtoupper($_GET["q"]);
if (!$q) RETURN;
$sql = "SELECT DISTINCT vw_cie.id_cie, vw_cie.nombre_cie FROM vw_cie WHERE vw_cie.estado_cie='AC' and vw_cie.nombre_cie LIKE '%$q%'";
$rsd=$link->query($sql);
if($rsd){
    while($rs=$rsd->fetch_array()){
        $cid = $rs['id_cie'];		
        $cname = $rs['nombre_cie'];
        echo "$cname|$cid\n";
    }
}
?>
<p><font color="#000000">no encontrado</font></p>