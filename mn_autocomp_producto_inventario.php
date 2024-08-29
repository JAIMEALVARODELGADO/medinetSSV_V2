<?php
session_start();
require("mn_funciones.php");
$link=conectarbd();
$q = strtoupper($_GET["q"]);
if (!$q) RETURN;
//$sql = "SELECT DISTINCT vw_producto.id_producto, vw_producto.nombre_prod FROM vw_producto WHERE vw_producto.nombre_prod LIKE '%$q%'";
$sql = "SELECT DISTINCT id_producto, CONCAT(descripcion,' ',concentracion,' ',presentacion,' Saldo: ',saldo) AS descripcion,saldo FROM vw_inventario_paciente WHERE id_ingreso='$_SESSION[gid_ingreso]' AND descripcion LIKE '%$q%'";
//echo $sql;
$rsd=$link->query($sql);
if($rsd){
    while($rs=$rsd->fetch_array()){
        $cid = $rs['id_producto'];		
        $cname = $rs['descripcion'];
        $saldo = $rs['saldo'];
        echo "$cname|$cid|$saldo\n";
    }
}
?>
<p><font color="#000000">no encontrado</font></p>