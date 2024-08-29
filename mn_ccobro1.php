<?php
session_start();
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
        
        <script language='JavaScript'>
            function validar(){
                error="";
                if(document.form1.id_eps.value==''){error+="Seleccionar la Eps\n";}
                if(document.form1.numero_ccob.value==''){error+="Número de Cuenta de Cobro\n";}
                if(document.form1.fecha_ccob.value==''){error+="Seleccionar la fecha de la Cuenta de Cobro\n";}
                if(error!=""){
                    alert("Es necesario complementar la siguiente información:\n"+error);
                }
                else{
                    document.form1.submit();
                }
            }
        </script>
        <title>Medinet</title>
    </head>
<body>

<?php
require("mn_funciones.php");
$link=conectarbd();
if(isset($_GET['id_ccob'])){
    $id_ccob=$_GET['id_ccob'];
}
if(isset($_POST['id_ccob'])){
    $id_ccob=$_POST['id_ccob'];
}
//echo $id_ccob;
if(!empty($id_ccob)){
    $consulta="SELECT id_eps,numero_ccob,fecha_ccob,fecha_inicio,fecha_fin,concepto_ccob FROM vw_cuenta_cobro WHERE id_ccob='$id_ccob'";
    //echo "<br>".$consulta;
    $consulta=$link->query($consulta);
    if($consulta->num_rows<>0){
        $row=$consulta->fetch_array();
        $id_eps=$row['id_eps'];
        $numero_ccob=$row['numero_ccob'];
        $fecha_ccob=$row['fecha_ccob'];
        $fecha_inicio=$row['fecha_inicio'];
        $fecha_fin=$row['fecha_fin'];
        $concepto_ccob=$row['concepto_ccob'];
    }
}

require("mn_menu.php");
require("mn_menu_ccobro.php");
$link=conectarbd();
?>

<form method="post" name='form1' action="mn_ccobro11.php">
    <?php
    require("mn_datos_ccobro.php");
    if(!empty($id_ccob)){
        ?>
          <script language='JavaScript'>
            document.form1.id_eps.value='<?php echo $id_eps;?>';
            document.form1.numero_ccob.value="<?php echo $numero_ccob;?>";
            document.form1.fecha_ccob.value="<?php echo $fecha_ccob;?>";
            document.form1.fecha_inicio.value="<?php echo $fecha_inicio;?>";
            document.form1.fecha_fin.value="<?php echo $fecha_fin;?>";
            document.form1.concepto_ccob.value="<?php echo $concepto_ccob;?>";
          </script>
          <input type="hidden" name="id_ccob" value="<?php echo $id_ccob;?>"/>
        <?php
        //require("mn_datos_detallefac.php");
    }
    //echo $id_factura;
    
    //require("mn_datos_actividad.php");
    ?>
</form>
</body>
</html>