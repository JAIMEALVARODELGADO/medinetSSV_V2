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
        <link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type='text/javascript' src='js/jquery.autocomplete.js'></script>
        <script type="text/javascript">
            $().ready(function() {  
                $("#course").autocomplete("mn_autocomp_cie.php", {
                    width: 460,
                    matchContains: false,
                    mustMatch: false,
                    selectFirst: false
                });
                $("#course2").autocomplete("mn_autocomp_cie.php", {
                    width: 460,
                    matchContains: false,
                    mustMatch: false,
                    selectFirst: false
                });
                
                $("#course").result(function(event, data, formatted) {
                    $("#course_val").val(data[1]);
                });
                $("#course2").result(function(event, data, formatted) {
                    $("#course_val2").val(data[1]);
                });
            });
        </script>
        <script language='JavaScript'>
            function validar(){
                error="";
                if(document.form1.fecha_con.value==''){error+="Fecha\n";}
                if(document.form1.reingreso_con.value==''){error+="Reingreso\n";}
                if(document.form1.motivo_con.value==''){error+="Motivo de Consulta\n";}
                if(document.form1.diag_prin.value==''){error+="Diagnóstivo Principal\n";}
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
require("mn_menu_consulta.php");
$link=conectarbd();

$consulta="SELECT CONCAT(tipo_iden,' ',identificacion,' ',pnombre,' ',snombre,' ',papellido,' ',sapellido) AS paciente FROM vw_ingreso WHERE id_ingreso='$_GET[id_ingreso]'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows<>0){
    $row=$consulta->fetch_array();
    $paciente=$row['paciente'];
}
?>

<form method="post" name='form1' action="mn_consulta11.php">
    <?php
    require("mn_datos_consulta.php");
    ?>
    <input type="hidden" id="id_formato" name='id_formato' value="<?php echo $_GET['id_formato']?>">
    <br><button type="button" id='btnguardar' onclick='validar()'><span class="icon-save"></span> Guardar</button>
    <script type="text/javascript" language='JavaScript'>
        document.form1.nombre_pac.value='<?php echo $paciente;?>';
        document.form1.id_ingreso.value='<?php echo $_GET['id_ingreso'];?>';
    </script>
    
</form>
</body>
</html>
