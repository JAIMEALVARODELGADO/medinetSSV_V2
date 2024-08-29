<?php
session_start();
//$_SESSION['datos'];
//$datos[0]='nombre';
//$datos[1]='codigo';
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
                $("#course").autocomplete("mn_autocomp_pac.php", {
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

                $("#course3").autocomplete("mn_autocomp_cups.php", {
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

                $("#course3").result(function(event, data, formatted) {
                    $("#course_val3").val(data[1]);
                });
                
            });
        </script>
        <script language='JavaScript'>
            function validar(){
                error="";
                if(document.form1.id_persona.value==''){error+="Seleccionar al paciente\n";}
                if(document.form1.fecha_fac.value==''){error+="Seleccionar la fecha de la factura\n";}
                if(error!=""){
                    alert("Es necesario complementar la siguiente información:\n"+error);
                }
                else{
                    document.form1.submit();
                }
            }

            function calculatotal(){
                total=document.form1.cantidad_det.value*document.form1.valor_unitario.value;
                document.form1.valor_total.value=total;
            }

            function validardet(){
                error="";
                if(document.form1.id_cups.value==''){error+="Seleccionar al detalle a facturar\n";}
                if(document.form1.cantidad_det.value==''){error+="Cantidad\n";}
                if(document.form1.valor_unitario.value==''){error+="Valor unitario\n";}
                if(error!=""){
                    alert("Es necesario complementar la siguiente información:\n"+error);
                }
                else{
                    document.form1.action="mn_factura12.php";
                    document.form1.submit();
                }
            }

            function eliminar_reg(id_,id_fac){
            if(confirm("Desea eliminar el registro\n")){
                url_="mn_factura13.php?id_detalle="+id_+"&id_factura="+id_fac;
                //alert(url_);
                window.open(url_,"_self");
            }
        }
        </script>
        <title>Medinet</title>
    </head>
<body>

<?php
require("mn_funciones.php");
$link=conectarbd();
$id_factura='';
if(isset($_GET['id_factura'])){
    $id_factura=$_GET['id_factura'];
}
if(isset($_POST['id_factura'])){
    $id_factura=$_POST['id_factura'];
}
if(!empty($id_factura)){
    $consulta="SELECT id_factura,id_persona,id_eps,CONCAT(tipo_iden,' ',identificacion,' ',nombres,' ',apellidos) AS nombre,fecha_ini,fecha_fin,fecha_fac,autoriza_fac,valor_total,id_cie,descripcion_cie FROM vw_factura WHERE id_factura='$id_factura'";
    //echo "<br>".$consulta;
    $consulta=$link->query($consulta);
    if($consulta->num_rows<>0){
        $row=$consulta->fetch_array();
        $id_persona=$row['id_persona'];
        $id_eps=$row['id_eps'];
        $nombre=$row['nombre'];
        $fecha_ini=$row['fecha_ini'];
        $fecha_fin=$row['fecha_fin'];
        $fecha_fac=$row['fecha_fac'];
        $autoriza_fac=$row['autoriza_fac'];
        //$cuenta_cobro=$row['cuenta_cobro'];
        $valor_total=$row['valor_total'];
        $id_cie=$row['id_cie'];
        $descripcion_cie=$row['descripcion_cie'];
    }
}

require("mn_menu.php");
require("mn_menu_factura.php");
//$link=conectarbd();
?>

<form method="post" name='form1' action="mn_factura11.php">
    <?php
    $observacion_ing='';
    require("mn_datos_encabezadofac.php");
    if(!empty($id_factura)){
        ?>
          <script languaje='JavaScript'>
            document.form1.nombre_pac.value="<?php echo $nombre;?>";
            document.form1.id_persona.value="<?php echo $id_persona;?>";
            document.form1.id_eps.value="<?php echo $id_eps;?>";
            document.form1.fecha_ini.value="<?php echo $fecha_ini;?>";
            document.form1.fecha_fin.value="<?php echo $fecha_fin;?>";
            document.form1.fecha_fac.value="<?php echo $fecha_fac;?>";
            document.form1.autoriza_fac.value="<?php echo $autoriza_fac;?>";
            document.form1.id_cie.value="<?php echo $id_cie;?>";
            document.form1.nombre_dxp.value="<?php echo $descripcion_cie;?>";
          </script>
          <input type="hidden" name="id_factura" value="<?php echo $id_factura;?>"/>
        <?php
        require("mn_datos_detallefac.php");
    }
    //echo $id_factura;
    
    //require("mn_datos_actividad.php");
    ?>
</form>
</body>
</html>