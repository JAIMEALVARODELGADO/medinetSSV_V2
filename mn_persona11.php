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
            alert(msg_);
            document.form1.submit();
        }
    </script>
<?php
require("mn_funciones.php");
//require("pp_menu.php");
$link=conectarbd();
$hoy=cambiafecha(hoy());
$hora=date("H:i:s");
$hoy=$hoy.' '.$hora;
$consulta="SELECT tipo_iden,identificacion FROM persona WHERE tipo_iden='$_POST[tipo_iden]' AND identificacion='$_POST[identificacion]'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows > 0){
    $msg="Existe una persona registrada con la misma identificación";
}
else{
    $sql_="INSERT INTO persona(id_persona,tipo_iden,identificacion,papellido,sapellido,pnombre,snombre,fecha_nacim,direccion,telefono,sexo,id_operador,fecha_reg) VALUES(0,'$_POST[tipo_iden]','$_POST[identificacion]','$_POST[papellido]','$_POST[sapellido]','$_POST[pnombre]','$_POST[snombre]','$_POST[fecha_nacim]','$_POST[direccion]','$_POST[telefono]','$_POST[sexo]','$_SESSION[gid_usuario]','$hoy')";   
    //echo "<br>".$sql_;
    $link->query($sql_);
    $id_persona=$link->insert_id;
    if($link->affected_rows > 0){
        $msg="Registro guardado con exito";
    }
    else{$msg="Registro no guardado";}
    if(!empty($_POST['mun_reside']) or !empty($_POST['zona_reside'])  or !empty($_POST['tipo_sangre'])){
        $sql_="INSERT INTO paciente(id_persona,mun_reside,zona_reside,tipo_sangre) VALUES($id_persona,'$_POST[mun_reside]','$_POST[zona_reside]','$_POST[tipo_sangre]')";
        //echo "<br>".$sql_;
        $link->query($sql_);
    }
}
?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_persona2.php">
    <?php echo "<br>".$msg;?>
</form>
</body>
</html>
