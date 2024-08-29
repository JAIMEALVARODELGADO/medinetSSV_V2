<?php
session_start();
//$_SESSION['datos'];
//$datos[0]='nombre';
//$datos[1]='codigo';
//$_SESSION['gid_ingreso']='';
?>
<!DOCTYPE html>
<html lang="es">
    <head>        
        <meta charset="UTF-8"/>
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">

        <script language='JavaScript'>
            function validar(){
                error="";
                if(document.form1.tasistol_sign.value=='' || document.form1.tadiasto_sign.value==''){error+='Tensión Arterial\n'}
                if(document.form1.satoxig_sign.value==''){error+='Saturación de Oxígeno\n'}
                if(document.form1.frecard_sign.value==''){error+='Frecuencia Cardiaca\n'}
                if(document.form1.frecresp_sign.value==''){error+='Frecuencia Respiratoria\n'}
                if(document.form1.temperatura_sign.value==''){error+='Temperatura\n'}
                if(error!=""){
                    alert("Es necesario complementar la siguiente información:\n"+error);
                }
                else{
                    if(confirm("Recuerde que al guardar esta consulta, no podrá modificarla ni eliminarla\nDesea guardar?")){
                        document.form1.submit();
                    }
                }
            }
        </script>
        <title>Medinet</title>
    </head>
<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_signos2.php");
$link=conectarbd();

$consulta="SELECT CONCAT(tipo_iden,' ',identificacion,' ',pnombre,' ',snombre,' ',papellido,' ',sapellido) AS paciente,fecha_nacim,TRUNCATE((datediff(now(),fecha_nacim))/365.25,0) AS edad FROM vw_ingreso WHERE id_ingreso='$_GET[id_ingreso]'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows<>0){
    $row=$consulta->fetch_array();
    $paciente=$row['paciente'];
    $fecha_nacim=$row['fecha_nacim'];
    $edad=$row['edad'];
}
?>

<form method="post" name='form1' action="mn_signos111.php">
    <?php
    require("mn_datos_signos.php");
    ?>
    <input type="hidden" id="id_ingreso" name='id_ingreso' value="<?php echo $_GET['id_ingreso']?>">
    <br><button type="button" id='btnguardar' onclick='validar()'><span class="icon-save"></span> Guardar</button>
    <script type="text/javascript" language='JavaScript'>
        document.form1.nombre_pac.value='<?php echo $paciente;?>';
        document.form1.id_ingreso.value='<?php echo $_GET['id_ingreso'];?>';
        document.form1.fecha_nacim.value='<?php echo $fecha_nacim;?>';
        document.form1.edad.value='<?php echo $edad;?>';        
    </script>
    
</form>
</body>
</html>