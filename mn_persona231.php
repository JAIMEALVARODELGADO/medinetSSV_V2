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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <title>Medinet</title>
    </head>
    <script language="JavaScript">
        function continuar(msg_){
            if(msg_!=''){alert(msg_);}
            document.form1.submit();
        }
    </script>
<?php
require("mn_funciones.php");
//require("pp_menu.php");
$link=conectarbd();
$conpac="SELECT id_persona FROM paciente WHERE id_persona='$_POST[id_persona]'";
//echo "<br>".$conpac;
$conpac=$link->query($conpac);
if($conpac->num_rows > 0){
    $sql_="UPDATE paciente SET mun_reside='$_POST[mun_reside]',zona_reside='$_POST[zona_reside]',tipo_sangre='$_POST[tipo_sangre]',tipo_usuario='$_POST[tipo_usuario]' WHERE id_persona='$_POST[id_persona]'";
}
else{
    $sql_="INSERT INTO paciente(id_persona,mun_reside,zona_reside,tipo_sangre,tipo_usuario) VALUES('$_POST[id_persona]','$_POST[mun_reside]','$_POST[zona_reside]','$_POST[tipo_sangre]','$_POST[tipo_usuario]')";
}
//echo "<br>".$sql_;
$link->query($sql_);
if($link->affected_rows > 0){
    $msg="";
}
else{$msg="Registro no guardado";}
?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_persona2.php">
    <?php echo "<br>".$msg;?>
    <input type='hidden' name='id_persona' value="<?php echo $_POST['id_persona'];?>"/>
</form>
</body>
</html>
