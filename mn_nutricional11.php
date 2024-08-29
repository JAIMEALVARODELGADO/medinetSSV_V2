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
                if(document.form1.enfermedad_actual_nut.value==''){error+='Enfermedad Actual\n'}
                if(document.form1.medicamentos_nut.value==''){error+='Medicamentos que Consume\n'}
                if(document.form1.dxnutricional_nut.value==''){error+='Diagnóstico Nutricional\n'}
                if(error!=""){
                    alert("Es necesario complementar la siguiente información:\n"+error);
                }
                else{
                    if(confirm("Recuerde que al guardar esta consulta, no podrá modificarla ni eliminarla\nDesea guardar?")){
                        document.form1.submit();
                    }
                }
            }

            function calcular(){
                talla=((document.form1.altura_rodilla_nut.value*1.91)+(document.form1.edad.value*0.17))+75;
                document.form1.talla_muj.value=talla;
                talla=(document.form1.altura_rodilla_nut.value*2.08)+59.01;
                document.form1.talla_hom.value=talla;
                peso=((document.form1.altura_rodilla_nut.value*1.09)+(document.form1.circ_brazo_nut.value*2.68))-65.51;
                document.form1.peso_muj.value=peso;
                peso=((document.form1.altura_rodilla_nut.value*1.1)+(document.form1.circ_brazo_nut.value*3.07))-75.81;
                document.form1.peso_hom.value=peso;
                riesgo=document.form1.circ_cadera_nut.value/document.form1.circ_cintura_nut.value
                document.form1.riesgo.value=riesgo;
                pideal=(document.form1.talla_nut.value-100)*0.9;
                document.form1.peso_ideal.value=pideal;
                imc=document.form1.peso_nut.value/Math.pow(document.form1.talla_nut.value,2);
                document.form1.imc.value=imc;
                //alert();
                
            }
        </script>
        <title>Medinet</title>
    </head>
<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_nutricional2.php");
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

<form method="post" name='form1' action="mn_nutricional111.php">
    <?php
    require("mn_datos_nutricional.php");
    ?>
    <input type="hidden" id="id_ingreso" name='id_ingreso' value="<?php echo $_GET['id_ingreso']?>">
    <br><br><br><br><button type="button" id='btnguardar' onclick='validar()'><span class="icon-save"></span> Guardar</button>
    <script type="text/javascript" language='JavaScript'>
        document.form1.nombre_pac.value='<?php echo $paciente;?>';
        document.form1.id_ingreso.value='<?php echo $_GET['id_ingreso'];?>';
        document.form1.fecha_nacim.value='<?php echo $fecha_nacim;?>';
        document.form1.edad.value='<?php echo $edad;?>';        
    </script>
    
</form>
</body>
</html>