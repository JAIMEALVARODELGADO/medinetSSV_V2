<?php
session_start();
set_time_limit(0);
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
        
    </script>
<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_ccobro.php");
$id_ccob='';
if(isset($_GET['id_ccob'])){$id_ccob=$_GET['id_ccob'];}
?>
<form name='form1' method="post" action="mn_ccobro2.php">
<?php

$consultaccob="SELECT id_eps,nombre_eps,numero_ccob,codigo_admin FROM vw_cuenta_cobro WHERE id_ccob='$id_ccob'";
//echo $consultaccob;
$consultaccob=$link->query($consultaccob);
if($consultaccob->num_rows<>0){
    $rowccob=$consultaccob->fetch_array();
    $id_eps=$rowccob['id_eps'];
    $nombre_eps=$rowccob['nombre_eps'];
    $numero_ccob=$rowccob['numero_ccob'];
    $codigo_admin=$rowccob['codigo_admin'];
}
?>
    <h7>Generando RIPS para la Cuenta de Cobro Nro: <?php echo $id_ccob.' de '.$nombre_eps;?></h7>
    <br>
    <br>
<?php

$condicion="id_ccob='$id_ccob' AND estado_fac='C'";
$consultaeps="SELECT codigo_habil,nombre_ent,nit_ent FROM entidad";
//echo "<br>".$consultaeps;
$consultaeps=$link->query($consultaeps);
$roweps=$consultaeps->fetch_array();
//echo "<br>".$roweps['nombre_ent'];

$codigo_habil=$roweps['codigo_habil'];
$nombre_ent=$roweps['nombre_ent'];
$nit_ent=$roweps['nit_ent'];
$archivous='';
$archivoaf='';
$archivoat='';
$regus=0;
$regaf=0;
$regat=0;

//Aqui genero AF
$consulta="SELECT numero_fac,fecha_fac,fecha_ini,fecha_fin,valor_total
FROM vw_factura
WHERE $condicion";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows<>0){
    $regaf=$consulta->num_rows;
    $shtml="";
    while($row=$consulta->fetch_array()){
        $shtml=$shtml.$codigo_habil.",";
        $shtml=$shtml.$nombre_ent.",";
        $shtml=$shtml."NI,";
        $shtml=$shtml.$nit_ent.",";
        $shtml=$shtml.$row['numero_fac'].",";
        $shtml=$shtml.cambiafechadmy($row['fecha_fac']).",";
        $shtml=$shtml.cambiafechadmy($row['fecha_ini']).",";
        $shtml=$shtml.cambiafechadmy($row['fecha_fin']).",";
        $shtml=$shtml.$codigo_admin.",";
        $shtml=$shtml.$nombre_eps.",";
        $shtml=$shtml.",";
        $shtml=$shtml.",";
        $shtml=$shtml.",";
        $shtml=$shtml."0,";
        $shtml=$shtml."0,";
        $shtml=$shtml."0,";
        $shtml=$shtml.$row['valor_total']."\r\n";
    }
}
$archivoaf='AF'.$numero_ccob;
$scarpeta=""; //carpeta donde guardar el archivo. 
//debe tener permisos 775 por lo menos 
$sfile="planos/AF".$numero_ccob.".csv"; //ruta del archivo a generar 
$fp=fopen($sfile,"w"); 
fwrite($fp,$shtml); 
fclose($fp);
echo "<br><span class='form-el'><a href='".$sfile."'>$archivoaf<span class='icon-download'></span></a></span>";


//Aqui genero US
$consulta="SELECT tipo_iden,identificacion,papellido,sapellido,pnombre,snombre,edad,sexo,mun_reside,zona_reside
FROM vw_usuarios_factura_rips
WHERE $condicion GROUP BY id_persona";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows<>0){
    $regus=$consulta->num_rows;
    $shtml="";
    while($row=$consulta->fetch_array()){
      $tpusu='2';
      $shtml=$shtml.TRIM(str_replace("\r","",$row['tipo_iden'])).",";
      $shtml=$shtml.TRIM(str_replace("\r","",$row['identificacion'])).",";
      $shtml=$shtml.TRIM(str_replace("\r","",$codigo_admin)).",";
      $shtml=$shtml.TRIM(str_replace("\r","",$tpusu)).",";
      $shtml=$shtml.TRIM(str_replace("\r","",$row['papellido'])).",";
      $shtml=$shtml.TRIM(str_replace("\r","",$row['sapellido'])).",";
      $shtml=$shtml.TRIM(str_replace("\r","",$row['pnombre'])).",";
      $shtml=$shtml.TRIM(str_replace("\r","",$row['snombre'])).",";
      $shtml=$shtml.TRIM(str_replace("\r","",$row['edad'])).",";
      $shtml=$shtml.TRIM(str_replace("\r","",'1')).",";
      $shtml=$shtml.TRIM(str_replace("\r","",$row['sexo'])).",";
      $dep=SUBSTR($row['mun_reside'],0,2);
      $mun=SUBSTR($row['mun_reside'],2,3);
      $shtml=$shtml.TRIM(str_replace("\r","",$dep)).",";
      $shtml=$shtml.TRIM(str_replace("\r","",$mun)).",";
      $shtml=$shtml.TRIM(str_replace("\r","",$row['zona_reside']))."\r\n";
    }
}
$archivous='US'.$numero_ccob;
$scarpeta=""; //carpeta donde guardar el archivo. 
//debe tener permisos 775 por lo menos 
$sfile="planos/US".$numero_ccob.".csv"; //ruta del archivo a generar 
$fp=fopen($sfile,"w"); 
fwrite($fp,$shtml); 
fclose($fp);
echo "<br><br><span class='form-el'><a href='".$sfile."'>$archivous<span class='icon-download'></span></a></span>";



//Aqui genero AT
$consulta="SELECT numero_fac,tipo_iden,identificacion,autoriza_fac,codigo_cups,descripcion_cups,cantidad_det,valor_unitario,valor_total
FROM vw_detalle_fac_rips
WHERE $condicion";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows<>0){
    $regat=$consulta->num_rows;
    $shtml="";
    while($row=$consulta->fetch_array()){
      $shtml=$shtml.TRIM(str_replace("\r", "",$row['numero_fac'])).",";
      $shtml=$shtml.TRIM(str_replace("\r","",$codigo_habil)).",";
      $shtml=$shtml.TRIM(str_replace("\r", "",$row['tipo_iden'])).",";
      $shtml=$shtml.TRIM(str_replace("\r", "",$row['identificacion'])).",";
      $shtml=$shtml.TRIM(str_replace("\r", "",$row['autoriza_fac'])).",";
      $shtml=$shtml.TRIM(str_replace("\r", "",'1')).",";
      $shtml=$shtml.TRIM(str_replace("\r", "",$row['codigo_cups'])).",";
      $shtml=$shtml.TRIM(str_replace("\r", "",SUBSTR($row['descripcion_cups'],0,60))).",";
      $shtml=$shtml.TRIM(str_replace("\r", "",$row['cantidad_det'])).",";
      $shtml=$shtml.TRIM(str_replace("\r", "",$row['valor_unitario'])).",";
      $shtml=$shtml.TRIM(str_replace("\r", "",$row['valor_total']))."\r\n";
    }
}
$archivoat='AT'.$numero_ccob;
$scarpeta=""; //carpeta donde guardar el archivo. 
//debe tener permisos 775 por lo menos 
$sfile="planos/AT".$numero_ccob.".csv"; //ruta del archivo a generar 
$fp=fopen($sfile,"w"); 
fwrite($fp,$shtml); 
fclose($fp);
echo "<br><br><span class='form-el'><a href='".$sfile."'>$archivoat<span class='icon-download'></span></a></span>";

//Aqui genero CT
$shtml="";
if(!empty($archivous)){
  $shtml=$shtml.$codigo_habil.",";
  $hoy=hoy();
  $shtml=$shtml.$hoy.",";
  $shtml=$shtml.$archivous.",";
  $shtml=$shtml.$regus."\r\n";
}
if(!empty($archivoaf)){
  $shtml=$shtml.$codigo_habil.",";
  $hoy=hoy();
  $shtml=$shtml.$hoy.",";
  $shtml=$shtml.$archivoaf.",";
  $shtml=$shtml.$regaf."\r\n";
}
if(!empty($archivoat)){
  $shtml=$shtml.$codigo_habil.",";
  $hoy=hoy();
  $shtml=$shtml.$hoy.",";
  $shtml=$shtml.$archivoat.",";
  $shtml=$shtml.$regat."\r\n";
}
$archivoct='CT'.$numero_ccob;
$scarpeta=""; //carpeta donde guardar el archivo. 
//debe tener permisos 775 por lo menos 
$sfile="planos/CT".$numero_ccob.".csv"; //ruta del archivo a generar 
$fp=fopen($sfile,"w"); 
fwrite($fp,$shtml); 
fclose($fp);
echo "<br><br><span class='form-el'><a href='".$sfile."'>$archivoct<span class='icon-download'></span></a></span>";

?>

</form>
</body>
</html>

