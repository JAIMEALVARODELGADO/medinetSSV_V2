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
            if(document.form1.mun_reside.value==''){error+="Municipio de Residencia\n";}
            if(document.form1.zona_reside.value==''){error+="Zona de Residencia\n";}
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
require("mn_menu_persona.php");
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
<form name='form1' method="post" action="mn_persona231.php">
    <?php
    echo "<fieldset><legend>Información Personal</legend>";
    echo "<div class='fila'>";
    echo "<span class='etiqueta'><label for='tipo_iden'>Tipo de Identificación:</label></span>";
    echo "<span class='form-el'>$tipo_iden</span>";      
    echo "</div>";
    echo "<div class='fila'>";
    echo "<span class='etiqueta'><label for='nombre'>Nombre:</label></span>";
    echo "<span class='form-el'>$nombre</span>";     
    echo "</div>";
    echo "</fieldset>";

    require("mn_datos_paciente.php");
    echo "<input type='hidden' name='id_persona' value='$_GET[id_persona]'/>";

    $consultapac="SELECT mun_reside,zona_reside,tipo_sangre FROM paciente WHERE id_persona='$_GET[id_persona]'";
    //echo "<br>".$consultapac;
    $consultapac=$link->query($consultapac);
    if($consultapac->num_rows > 0){
        $rowpac=$consultapac->fetch_array();
        $mun_reside=$rowpac['mun_reside'];
        $zona_reside=$rowpac['zona_reside'];
        $tipo_sangre=$rowpac['tipo_sangre'];
    }
    ?>
    <button type="button" onclick='validar()'><span class="icon-save"></span> Guardar</button>
    
    <script language="JavaScript">
        document.form1.mun_reside.value='<?php echo $mun_reside;?>';
        document.form1.zona_reside.value='<?php echo $zona_reside;?>';
        document.form1.tipo_sangre.value='<?php echo $tipo_sangre;?>';
    </script>
</form>
</body>
</html>
