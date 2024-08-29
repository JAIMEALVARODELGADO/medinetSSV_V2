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
                if(document.form1.fecha_evol.value==''){error+="Fecha y hora\n";}
                if(document.form1.observacion.value==''){error+="Observaci�n\n";}
                if(error!=""){
                    alert("Es necesario complementar la siguiente informaci�n:\n"+error);
                }
                else{
                    if(confirm("Recuerde que al guardar esta evolucion, no podr� modificarla ni eliminarla\nDesea guardar?")){
                        document.form1.fecha_evol.disabled=false;
                        document.form1.submit();
                    }
                }
            }
            function advertencia(){
                if(document.form1.salida.checked){
                    alert("Recuerde: Al elegir esta opci�n, el paciente saldr� del listado.\n Para que el paciente salga debe estar en cero (0) su inventario de medicamentos y dispositivos");
                }
            }
        </script>
        <title>Medinet</title>
    </head>
<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_evolucion.php");
$link=conectarbd();

$consulta="SELECT CONCAT(tipo_iden,' ',identificacion,' ',pnombre,' ',snombre,' ',papellido,' ',sapellido) AS paciente FROM vw_ingreso WHERE id_ingreso='$_GET[id_ingreso]'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows<>0){
    $row=$consulta->fetch_array();
    $paciente=$row['paciente'];
}
?>

<form method="post" name='form1' action="mn_evolucion11.php">
    <?php
    require("mn_datos_evolucion.php");
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
