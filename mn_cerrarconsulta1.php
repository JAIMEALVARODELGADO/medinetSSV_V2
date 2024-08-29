<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
        <meta description="Registro y cotrol de formulacion"/>                
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        
        <title>Medinet</title>
    </head>
    <script language="JavaScript">
        function cerrar(){
            if(confirm("Recuerde que al cerrar esta consulta, no podrá modificarla ni eliminarla\nDesea cerrar?")){
                document.form1.submit();
            }        
        }
        function imprimir_consulta(id_con_){            
            document.form1.id_consulta.value=id_con_;
            document.form1.action='mn_inf_consulta13.php';
            document.form1.target='_new';
            document.form1.submit();
        }
        function imprimir_formula(id_con_){            
            document.form1.id_consulta.value=id_con_;
            document.form1.action='mn_inf_formula11.php';
            document.form1.target='_new';
            document.form1.submit();
        }
        function imprimir_orden(id_con_){            
            document.form1.id_consulta.value=id_con_;
            document.form1.action='mn_inf_orden11.php';
            document.form1.target='_new';
            document.form1.submit();
        }
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_consulta.php");
//echo "<br>".$_SESSION['gid_ingreso'];
//echo "<br>".$_SESSION['gid_consulta'];
?>
<form name='form1' method="post" action="mn_cerrarconsulta11.php">
    
<?php
//Aqui consulto la informacion del ingreso
$consultaper="SELECT CONCAT(tipo_iden,' ',identificacion,' ',pnombre,' ',snombre,' ',papellido,' ',sapellido) AS paciente FROM vw_ingreso WHERE id_ingreso='$_SESSION[gid_ingreso]'";
//echo "<br>".$consultaper;
$consultaper=$link->query($consultaper);
if($consultaper->num_rows<>0){
    $row=$consultaper->fetch_array();
    $paciente=$row['paciente'];
}
$estado_con="";
$consulta="SELECT id_consulta,estado_con FROM vw_consulta WHERE id_consulta='$_SESSION[gid_consulta]'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows<>0){
    $rowcon=$consulta->fetch_array();
    $id_consulta=$rowcon['id_consulta'];    
    $estado_con=$rowcon['estado_con'];
}

?>
<div class="fila">    
    <label><span class="icon-shield"><b>CERRAR CONSULTA</b></span></label>
</div>

<div class="fila">
    <span class="etiqueta"><label for="identificacion">Paciente:</label></span>
    <span class="form-el">
        <input type='text' class='texto' name='nombre_pac' size='60' readonly="true" />
        <input type='hidden' id='id_ingreso' name='id_ingreso'/>
    </span>            
</div>
<?php
if($estado_con<>"C"){
    ?>
    <div class="fila">
        <label>Recuerde que al cerrar la consulta no puede realizar modificaciones.</label>
        <a href='#' onclick=cerrar() title='Cerrar Consulta' class='btnhref'><span class='icon-shield'>Cerrar Consulta</span></a>
    </div>
    <?php
}
else{
    ?>
    <div class="caja1">
        <h4>Impresión</h4>
        <a href="#" onclick='imprimir_consulta(<?php echo $id_consulta;?>);' title='Imprimir Consulta'><span class="icon-print"></span> Consulta</a>
        <a href="#" onclick='imprimir_formula(<?php echo $id_consulta;?>);' title='Imprimir Formula'><span class="icon-print"></span> Formula</a>
        <a href="#" onclick='imprimir_orden(<?php echo $id_consulta;?>);' title='Imprimir Ordenes'><span class="icon-print"></span> Ordenes</a>
    </div>
    <?php
}
?>
<input type="hidden" name="id_consulta" value="">

<script type="text/javascript" language='JavaScript'>
    document.form1.nombre_pac.value='<?php echo $paciente;?>';
</script>

</form>
</body>
</html>
