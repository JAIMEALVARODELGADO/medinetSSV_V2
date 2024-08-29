<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <title>Medinet</title>
    </head>
    <script language="JavaScript">
        function eliminar(idfac_){
            if(confirm("Desea quitar esta factura del la cuenta?")){
                document.form1.id_factura.value=idfac_;
                document.form1.action="mn_ccobro231.php";
                document.form1.submit();
            }
        }
        function regresar(){
            document.form1.action="mn_ccobro2.php";
            document.form1.submit();
        }
        function buscar(){
            document.form1.submit();
        }
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
$numero_fac='';
$fecha_fac='';
$id_ccob='';
if(isset($_GET['id_ccob'])){$id_ccob=$_GET['id_ccob'];}
if(isset($_POST['numero_fac'])){$numero_fac=$_POST['numero_fac'];}
if(isset($_POST['fecha_fac'])){$fecha_fac=$_POST['fecha_fac'];}
if(isset($_POST['id_ccob'])){$id_ccob=$_POST['id_ccob'];}
?>
<form name='form1' method="post" action="mn_ccobro22.php">
<?php

$consultaccob="SELECT id_eps,nombre_eps FROM vw_cuenta_cobro WHERE id_ccob='$id_ccob'";
//echo $consultaccob;
$consultaccob=$link->query($consultaccob);
if($consultaccob->num_rows<>0){
    $rowccob=$consultaccob->fetch_array();
    $id_eps=$rowccob['id_eps'];
    $nombre_eps=$rowccob['nombre_eps'];
}
?>
    <h3>Facturas Relacionadas en la Cuenta de Cobro Nro: <?php echo $id_ccob.' de '.$nombre_eps;?></h3>
    <span class="form-el"><input type='text' id='numero_fac' name='numero_fac' maxlength='11' size='11' placeholder='Factura Numero' value="<?php echo $numero_fac;?>"/></span>
    <span class="form-el">Fecha de la Factura:<input type='date' id='fecha_fac' name='fecha_fac' placeholder='Fecha' value="<?php echo $fecha_fac;?>"/></span>
    <a href="#" onclick='buscar();' title='Buscar'><span class="icon-magnifying-glass"></span> </a>
    <a href="#" onclick='regresar();' title='Regresar'><span class="icon-arrow-bold-left"></span> </a>
<?php
$condicion="numero_fac!='' AND estado_fac='C' AND id_ccob='$id_ccob' AND ";
if(!empty($numero_fac)){$condicion=$condicion."numero_fac='$numero_fac' AND ";}
if(!empty($fecha_fac)){$condicion=$condicion."fecha_fac='$fecha_fac' AND ";}


if(!empty($condicion)){
    $condicion=substr($condicion,0,-5);
    //echo "<br>".$condicion;
    if(empty($orden)){$orden='identificacion';}
    $consulta="SELECT id_factura,numero_fac,nombre_eps,fecha_fac,valor_total,identificacion,CONCAT(nombres,' ',apellidos) AS nombre FROM vw_factura WHERE ".$condicion;
    //echo "<br>".$consulta;
    $consulta=$link->query($consulta);
    if($consulta->num_rows<>0){
        echo "<br><br><table width='100%'>";
        echo "<th colspan='1'>Opción</th>".
            "<th>Número</th>".
            "<th>Fecha</th>".
            "<th>Identificación</th>".
            "<th>Nombre</th>".
            "<th>Eps</th>".
            "<th>Valor</th>";
        while($row=$consulta->fetch_array()){
            echo "<tr>";
            echo "<td width='5%'><a href='#' onclick=eliminar($row[id_factura]) title='Quitar de esta Cuenta' class='btnhref'><span class='icon-erase'></span></a></td>";
            echo "<td>$row[numero_fac]</td>";
            echo "<td>$row[fecha_fac]</td>";
            echo "<td>$row[identificacion]</td>";
            echo "<td>$row[nombre]</td>";
            echo "<td>$row[nombre_eps]</td>";
            echo "<td>$row[valor_total]</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
}
echo "<input type='hidden' name='id_ccob' value='$id_ccob'>";
echo "<input type='hidden' name='id_factura'>";
?>
</form>
</body>
</html>
