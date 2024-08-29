<?php
session_start();
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
        function validar(){
            var error='';
            if(document.form1.login.value==''){error+="Login\n";}
            if(document.form1.password.value!=document.form1.password2.value){error+="Verifique el Password\n";}
            if(error!=''){
                alert("Es necesario complementar la siguiente informaci�n:\n"+error);
            }
            else{
                document.form1.submit();
            }
        }
    </script>
<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_usuario.php");
$link=conectarbd();
$consulta="SELECT tipo_iden,identificacion,papellido,sapellido,pnombre,snombre FROM persona WHERE id_persona='$_GET[id_persona]'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows > 0){
    $row=$consulta->fetch_array();
    $tipo_iden=$row['tipo_iden'];
    $identificacion=$row['identificacion'];
    $nombre=$row['pnombre'].' '.$row['snombre'].' '.$row['papellido'].' '.$row['sapellido'];
}
?>
<form name='form1' method="post" action="mn_usuario231.php">
    <?php
    echo "<fieldset><legend>Informaci�n Personal</legend>";
    echo "<div class='fila'>";
    echo "<span class='etiqueta'><label for='tipo_iden'>Tipo de Identificaci�n:</label></span>";
    echo "<span class='form-el'>$tipo_iden</span>";      
    echo "</div>";
    echo "<div class='fila'>";
    echo "<span class='etiqueta'><label for='nombre'>Nombre:</label></span>";
    echo "<span class='form-el'>$nombre</span>";     
    echo "</div>";
    echo "</fieldset>";

    require("mn_datos_usuariosist.php");
    echo "<input type='hidden' name='id_persona' value='$_GET[id_persona]'/>";

    $consultausu="SELECT login,password,profesion,registro,observacion,id_formato,estado FROM usuario_sist WHERE id_persona='$_GET[id_persona]'";
    //echo "<br>".$consultausu;
    $consultausu=$link->query($consultausu);
    if($consultausu->num_rows > 0){
        $rowusu=$consultausu->fetch_array();
        $login=$rowusu['login'];
        $profesion=$rowusu['profesion'];
        $registro=$rowusu['registro'];
        $observacion=$rowusu['observacion'];
        $id_formato=$rowusu['id_formato'];
        $estado=$rowusu['estado'];
    }
    ?>
    <button type="button" onclick='validar()'><span class="icon-save"></span> Guardar</button>
    
    <script language="JavaScript">
        document.form1.login.value='<?php echo $login;?>';
        document.form1.profesion.value='<?php echo $profesion;?>';
        document.form1.registro.value='<?php echo $registro;?>';
        document.form1.id_formato.value='<?php echo $id_formato;?>';
        document.form1.observacion.value='<?php echo $observacion;?>';
        <?php
        if($estado=='AC'){
            ?>
            document.form1.estado.checked=true;
            <?php
        }
        ?>
    </script>
</form>
</body>
</html>
