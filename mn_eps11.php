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
        <title>Práctica Pedag&oacute;gica Integral Investigativa</title>
    </head>
    <script language="JavaScript">
        function continuar(msg_){
            alert(msg_);
            document.form1.submit();
        }
    </script>
<?php
require("mn_funciones.php");
$link=conectarbd();
$sql_="INSERT INTO eps(id_eps,codigo_admin,nit,nombre_eps,direccion_eps,telefono_eps,nombre_cont) values('0','$_POST[codigo_admin]','$_POST[nit]','$_POST[nombre_eps]','$_POST[direccion_eps]','$_POST[telefono_eps]','$_POST[nombre_cont]')";
//echo "<br>".$sql_;
$link->query($sql_);
if($link->affected_rows > 0){
    $msg="Registro guardado con exito";
}
else{$msg="Registro no guardado";}
?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_eps2.php">
    <?php
    echo "<br>".$msg;
    ?>
</form>
</body>
</html>
