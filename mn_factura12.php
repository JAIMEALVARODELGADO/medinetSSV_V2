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

$sql_="INSERT INTO detalle_factura(id_detalle,id_factura,id_cups,cantidad_det,valor_unitario) VALUES(0,'$_POST[id_factura]','$_POST[id_cups]','$_POST[cantidad_det]','$_POST[valor_unitario]')";
//echo "<br>".$sql_;
$link->query($sql_);
$id_factura=$_POST['id_factura'];
if($link->affected_rows > 0){
    $msg="Registro guardado con exito";
}
else{$msg="Registro no guardado";}

$sql_="UPDATE encabezado_factura SET valor_total=(SELECT SUM(cantidad_det*valor_unitario) FROM detalle_factura WHERE id_factura='$_POST[id_factura]') WHERE id_factura='$_POST[id_factura]'";
//echo $sql_;

$link->query($sql_);

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
