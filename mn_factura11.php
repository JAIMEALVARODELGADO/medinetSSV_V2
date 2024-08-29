<?php
session_start();
if(!isset($_SESSION['gid_usuario'])){
    ?>
        <script type="text/javascript">
            alert("La sesion ha finalizado. \nIngrese nuevamente");
            window.open('blanco.html','_self',''); 
            window.close(); 
        </script>
    <?php
}
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
        function continuar(msg_){
            //alert(msg_);
            document.form1.submit();
        }
    </script>
<?php
require("mn_funciones.php");
//require("pp_menu.php");
$link=conectarbd();
/*$hoy=cambiafecha(hoy());
$hora=date("H:i:s");
$hoy=$hoy.' '.$hora;*/
if(empty($_POST['id_factura'])){
    $sql_="INSERT INTO encabezado_factura(id_factura,id_persona,id_eps,numero_fac,fecha_ini,fecha_fin,fecha_fac,autoriza_fac,id_cie,id_operador) VALUES(0,'$_POST[id_persona]','$_POST[id_eps]','0','$_POST[fecha_ini]','$_POST[fecha_fin]','$_POST[fecha_fac]','$_POST[autoriza_fac]','$_POST[id_cie]','$_SESSION[gid_usuario]')";
    //echo "<br>".$sql_;
    $link->query($sql_);
    $id_factura=$link->insert_id;
}
else{
    $sql_="UPDATE encabezado_factura SET id_eps='$_POST[id_eps]',fecha_ini='$_POST[fecha_ini]',fecha_fin='$_POST[fecha_fin]' ,fecha_fac='$_POST[fecha_fac]',autoriza_fac='$_POST[autoriza_fac]',id_cie='$_POST[id_cie]' WHERE id_factura='$_POST[id_factura]'";
    echo "<br>".$sql_;
    $link->query($sql_);
    $id_factura=$_POST['id_factura'];
}
if($link->affected_rows > 0){
    $msg="Registro guardado con exito";
}
else{$msg="Registro no guardado";}

?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_factura1.php">
    <?php 
    echo "<br>".$msg;
    echo "<input type='hidden' name='id_factura' value='$id_factura'>";
    ?>
</form>
</body>
</html>
