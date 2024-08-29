<?php
require("mn_funciones.php");
$link=conectarbd();
$q = strtoupper($_GET["q"]);
if (!$q) RETURN;
$sql = "SELECT DISTINCT vw_producto.id_producto, vw_producto.nombre_prod FROM vw_producto WHERE vw_producto.nombre_prod LIKE '%$q%'";
$rsd=$link->query($sql);
if($rsd){
    while($rs=$rsd->fetch_array()){
        $cid = $rs['id_producto'];		
        $cname = $rs['nombre_prod'];
        echo "$cname|$cid\n";
    }
}
?>
<p><font color="#000000">no encontrado</font></p>