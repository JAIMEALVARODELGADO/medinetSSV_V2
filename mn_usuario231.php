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
$conpac="SELECT id_persona FROM usuario_sist WHERE id_persona='$_POST[id_persona]'";
//echo "<br>".$conpac;
$conpac=$link->query($conpac);
$password=SHA1($_POST['password']);
//echo $_POST['estado'];
if($_POST['estado']=='on'){$estado='AC';}
else{$estado='SU';}

if($conpac->num_rows > 0){
    $sql_="UPDATE usuario_sist SET login='$_POST[login]',profesion='$_POST[profesion]',registro='$_POST[registro]',observacion='$_POST[observacion]',id_formato='$_POST[id_formato]',observacion='$_POST[observacion]',estado='$estado' WHERE id_persona='$_POST[id_persona]'";
    $link->query($sql_);
    if(!empty($_POST['password'])){
        $sql_="UPDATE usuario_sist SET password='$password' WHERE id_persona='$_POST[id_persona]'";
        $link->query($sql_);
    }
}
else{
    if(!empty($_POST['password'])){
        $sql_="INSERT INTO usuario_sist(id_persona,login,password,profesion,registro,observacion,id_formato,estado) VALUES('$_POST[id_persona]','$_POST[login]','$password','$_POST[profesion]','$_POST[registro]','$_POST[observacion]','$_POST[id_formato]','$estado')";
        //echo $sql_;
        $link->query($sql_);
    }
    else{
        $msg="El password NO debe estar vacio";
    }
}

if($link->affected_rows > 0){
    $msg="";
}
else{$msg="Registro no guardado";}
?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_usuario2.php">
    <?php echo "<br>".$msg;?>
    <input type='hidden' name='id_persona' value="<?php echo $_POST['id_persona'];?>"/>
</form>
</body>
</html>
