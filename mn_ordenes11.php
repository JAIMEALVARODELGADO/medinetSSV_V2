<?php
session_start();
if(!isset($_SESSION['gid_usuario'])){
    ?>
        <script type="text/javascript">
            alert("La sesion ha finalizado. \nIngrese nuevamente");
            window.open('blanco.html','_self',''); 
            window.close(); 
        </script>
    <?php
}
if($_SESSION['gid_consulta']==""){
    ?>
        <script type="text/javascript">
            alert("No hay una consulta guardada");            
        </script>
    <?php
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
        <meta description="Registro y cotrol de medicamentos"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <title>Medinet</title>
    </head>
    <script language="JavaScript">
        function continuar(msg_){
            //alert(msg_);
            document.form1.submit();
        }
    </script>
<?php
require("mn_funciones.php");
//require("pp_menu.php");
$link=conectarbd();

if($_SESSION['gid_consulta']<>""){
    //echo $_SESSION['gid_consulta'];
    $consultaord="SELECT id_orden FROM consulta_orden WHERE id_consulta='$_SESSION[gid_consulta]' AND tipo_ord='$_POST[tipo_ord]'";
    //echo $consultaord;
    $consultaord=$link->query($consultaord);
    if($consultaord->num_rows<>0){
        $roword=$consultaord->fetch_array();
        $id_orden=$roword['id_orden'];
    }
    else{
        $sql_="INSERT INTO consulta_orden(id_orden,id_consulta,tipo_ord) VALUES(0,'$_SESSION[gid_consulta]','$_POST[tipo_ord]')";        
        $link->query($sql_);
        $id_orden=$link->insert_id;
    }
    $sql_="INSERT INTO consulta_orden_detalle(id_ord_detalle,id_orden,id_cups,observacion_det) VALUES(0,'$id_orden','$_POST[id_cups]','$_POST[observacion_det]')";
    //echo "<br>".$sql_;
    $link->query($sql_);
}

if($link->affected_rows > 0){
    $msg="Registro guardado con exito";
}
else{$msg="Registro no guardado";}

?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_ordenes1.php">
    <?php 
    echo "<br>".$msg;
    ?>
</form>
</body>
</html>