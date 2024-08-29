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
    $consultafor="SELECT id_form FROM consulta_formula WHERE id_consulta='$_SESSION[gid_consulta]'";
    //echo $consultafor;
    $consultafor=$link->query($consultafor);
    if($consultafor->num_rows<>0){
        $rowfor=$consultafor->fetch_array();        
        $id_form=$rowfor['id_form'];
    }
    else{
        $sql_="INSERT INTO consulta_formula(id_form,id_consulta) VALUES(0,'$_SESSION[gid_consulta]')";        
        $link->query($sql_);
        $id_form=$link->insert_id;
    }
    $sql_="INSERT INTO consulta_formula_detalle(id_form_det,id_form,id_producto,dosis_det,frecuencia_det,via_det,tiempo_trat_det,cantidad_det,observacion_det) VALUES(0,'$id_form','$_POST[id_producto]','$_POST[dosis_det]','$_POST[frecuencia_det]','$_POST[via_det]','$_POST[tiempo_trat_det]','$_POST[cantidad_det]','$_POST[observacion_det]')";
    //echo "<br>".$sql_;
    $link->query($sql_);    
}

if($link->affected_rows > 0){
    $msg="Registro guardado con exito";
}
else{$msg="Registro no guardado";}

?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_formula1.php">
    <?php 
    echo "<br>".$msg;    
    ?>
</form>
</body>
</html>