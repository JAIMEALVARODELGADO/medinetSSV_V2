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
            if(document.form1.tipo_iden.value==''){error+="Tipo de Identificación\n";}
            if(document.form1.identificacion.value==''){error+="Número de Identificación\n";}
            if(document.form1.papellido.value==''){error+="Primer Apellidos\n";}
            if(document.form1.pnombre.value==''){error+="Primer Nombres\n";}
            if(document.form1.fecha_nacim.value==''){error+="Fecha de Nacimiento\n";}
            if(document.form1.sexo.value==''){error+="Sexo\n";}
            if(error!=''){
                alert("Es necesario complementar la siguiente información:\n"+error);
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
$consulta="SELECT tipo_iden,identificacion,papellido,sapellido,pnombre,snombre,fecha_nacim,direccion,telefono,sexo FROM persona WHERE id_persona='$_GET[id_persona]'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows > 0){
    while($row=$consulta->fetch_array()){
        $tipo_iden=$row['tipo_iden'];
        $identificacion=$row['identificacion'];
        $papellido=$row['papellido'];
        $sapellido=$row['sapellido'];
        $pnombre=$row['pnombre'];
        $snombre=$row['snombre'];
        $fecha_nacim=$row['fecha_nacim'];
        $sexo=$row['sexo'];
        $direccion=$row['direccion'];
        $telefono=$row['telefono'];
    }
}
?>
<form name='form1' method="post" action="mn_usuario211.php">
    <?php
    require("mn_datos_persona.php");
    echo "<input type='hidden' name='id_persona' value='$_GET[id_persona]'/>";
    ?>
    <button type="button" onclick='validar()'><span class="icon-save"></span> Guardar</button>
    
    <script language="JavaScript">
        document.form1.tipo_iden.value='<?php echo $tipo_iden;?>';
        document.form1.identificacion.value='<?php echo $identificacion;?>';
        document.form1.papellido.value='<?php echo $papellido;?>';
        document.form1.sapellido.value='<?php echo $sapellido;?>';
        document.form1.pnombre.value='<?php echo $pnombre;?>';
        document.form1.snombre.value='<?php echo $snombre;?>';
        document.form1.fecha_nacim.value='<?php echo $fecha_nacim;?>';
        document.form1.sexo.value='<?php echo $sexo;?>';
        document.form1.direccion.value='<?php echo $direccion;?>';
        document.form1.telefono.value='<?php echo $telefono;?>';
    </script>
</form>
</body>
</html>
