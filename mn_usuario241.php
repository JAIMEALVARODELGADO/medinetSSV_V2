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
            //if(msg_!=''){alert(msg_);}
            document.form1.submit();
        }
    </script>
<?php
require("mn_funciones.php");
//require("pp_menu.php");
/*echo "<br>".$_POST['id_persona'];
echo "<br>".$_POST['checkbox'];
echo "<br>".$_POST['id_menu'];
echo "<br>".$_POST['id_menu_usu'];
*/

$link=conectarbd();
if($_POST['checkbox']=='true'){
    $sql_="INSERT INTO menu_usuario(id_menu_usu,id_menu,id_persona,nuevo,editar,eliminar) values (0,$_POST[id_menu],$_POST[id_persona],'S','S','S')";
}
else{
    $sql_="DELETE FROM menu_usuario WHERE id_menu_usu='$_POST[id_menu_usu]'";
}
//echo "<br>".$sql_;
$link->query($sql_);
//$id_movimiento=$link->insert_id;
if($link->affected_rows > 0){
    $msg="Registro guardado con exito";
}
else{$msg="Registro no guardado";}

?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_usuario24.php">
    <?php echo "<br>".$msg;?>
    <input type='hidden' name='id_persona' value="<?php echo $_POST['id_persona'];?>"/>
</form>
</body>
</html>
