<?php
session_start();
//$_SESSION['datos'];
//$datos[0]='nombre';
//$datos[1]='codigo';
$_SESSION['gid_ingreso']='';
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
                $("#course").autocomplete("mn_autocomp_pac_ingre.php", {
                    width: 460,
                    matchContains: false,
                    mustMatch: false,
                    selectFirst: false
                });
                $("#course2").autocomplete("mn_autocomp_producto_inventario.php", {
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
                    $("#course_val3").val(data[2]);
                });
            });
        </script>
        <script language='JavaScript'>
            function recargar(){
                document.form1.action='mn_administracion1.php';
                document.form1.submit();
            }
            function validar(){
                error="";
                cant_=0;
                saldo_=0;
                //if(document.form1.id_ingreso.value==''){error+="Seleccionar al paciente\n";}
                if(document.form1.fecha_mov.value==''){error+="Fecha y hora\n";}
                if(document.form1.id_producto.value==''){error+="Seleccionar el producto\n";}
                if(document.form1.cantidad.value==''){error+="Cantidad\n";}
                cant_=parseInt(document.form1.cantidad.value);
                saldo_=parseInt(document.form1.saldo.value);
                if(cant_>saldo_){error+="La Cantidad supera el saldo\n";}
                if(error!=""){
                    alert("Es necesario complementar la siguiente información:\n"+error);
                }
                else{
                    if(confirm("Recuerde que al guardar, se afecta el inventario.\nDesea Guardar?")){
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
require("mn_menu_administracion2.php");
$link=conectarbd();
$id_ingreso='';
$fecha_mov='';
//if(isset($_POST['id_ingreso'])){
    //$id_ingreso=$_POST['id_ingreso'];
    //$_SESSION['gid_ingreso']=$id_ingreso;
    //echo $_SESSION['gid_ingreso'];
//}
if(isset($_GET['id_ingreso'])){
    $id_ingreso=$_GET['id_ingreso'];
    $_SESSION['gid_ingreso']=$id_ingreso;
}
if(isset($_POST['id_ingreso'])){
    $id_ingreso=$_POST['id_ingreso'];
    $_SESSION['gid_ingreso']=$id_ingreso;
}
if(isset($_POST['fecha_mov'])){$fecha_mov=$_POST['fecha_mov'];}
$consulta="SELECT id_ingreso, CONCAT(tipo_iden,' ',identificacion,' ',pnombre,' ',snombre,' ',papellido,' ',sapellido) AS nombre FROM vw_ingreso WHERE id_ingreso='$id_ingreso'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows<>0){
    $row=$consulta->fetch_array();
    $nombre=$row['nombre'];
}

/*if(isset($_POST['id_movimiento'])){
    //echo $_POST['id_movimiento'];
    $consultamov="SELECT vw_movimientos.descripcion, vw_movimientos.cantidad FROM vw_movimientos WHERE vw_movimientos.id_movimiento='$_POST[id_movimiento]' ";
    echo "<br>".$consultamov;
}*/
?>

<form method="post" name='form1' action="mn_administracion11.php">

    <?php
    require("mn_datos_administracion.php");
    ?>
    <input type="hidden" name="id_ingreso" value='<?php echo $id_ingreso;?>'/>
    <br><button type="button" id='btnguardar' onclick='validar()'><span class="icon-save"></span> Guardar</button>
    <script type="text/javascript" languaje='JavaScript'>
        document.form1.nombre_pac.value='<?php echo $nombre;?>';
        //document.form1.id_ingreso.value='<?php echo $id_ingreso;?>';
        //document.form1.fecha_mov.value='<?php echo $fecha_mov;?>';
    </script>
</form>
</body>
</html>