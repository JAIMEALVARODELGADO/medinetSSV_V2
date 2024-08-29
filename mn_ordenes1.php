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
        <script type='text/javascript' src='js/jquery.autocomplete.js'></script>
        <script type="text/javascript">
            $().ready(function() {  
                $("#course").autocomplete("mn_autocomp_cups.php", {
                    width: 460,
                    matchContains: false,
                    mustMatch: false,
                    selectFirst: false
                });
                
                $("#course").result(function(event, data, formatted) {
                    $("#course_val").val(data[1]);
                });
            });
        </script>
        <title>Medinet</title>
    </head>
    <script language="JavaScript">
        function validar(){
            var error='';
            if(document.form1.tipo_ord.value==''){error+="Tipo de Orden\n";}
            if(document.form1.id_cups.value==''){error+="Descripción\n";}
            if(error!=""){
                alert("Para continuar, debe digitar los sigientes campos:\n"+error);
            }
            else{
                document.form1.submit();
            }
        }
        function eliminar(id_,desc_){
            if(confirm("Desea eliminar la actividad:\n"+desc_)){                
                window.open("mn_ordenes12.php?id_ord_detalle="+id_,"_self");
            }
            //alert("Opcion NO disponible");
        }
        /*function editar(id_){
            window.open("mn_persona21.php?id_persona="+id_,"_self");
        }*/
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_consulta.php");
//echo "<br>".$_SESSION['gid_ingreso'];
//echo "<br>".$_SESSION['gid_consulta'];
?>
<form name='form1' method="post" action="mn_ordenes11.php">
    
<?php
//Aqui consulto la informacion del ingreso
$consultaper="SELECT CONCAT(tipo_iden,' ',identificacion,' ',pnombre,' ',snombre,' ',papellido,' ',sapellido) AS paciente FROM vw_ingreso WHERE id_ingreso='$_SESSION[gid_ingreso]'";
//echo "<br>".$consultaper;
$consultaper=$link->query($consultaper);
if($consultaper->num_rows<>0){
    $row=$consultaper->fetch_array();
    $paciente=$row['paciente'];
}
?>
<div class="fila">    
    <label><span class="icon-documents"><b>ORDENES</b></span></label>
</div>

<div class="fila">
    <span class="etiqueta"><label for="identificacion">Paciente:</label></span>
    <span class="form-el">
        <input type='text' class='texto' name='nombre_pac' size='60' readonly="true" />
        <input type='hidden' id='id_ingreso' name='id_ingreso'/>
    </span>            
</div>



<?php

echo "<br><br><table width='100%'>";
echo "<th>Tipo de Orden</th>".
"<th>Código</th>".
"<th>Descripción</th>".
"<th>Observación</th>".
"<th colspan='2'>Opciones</th>";
$estado_con='A';
$consultaord="SELECT id_ord_detalle,desc_tipo_orden,codigo_cups,descripcion_cups,observacion_det,estado_con FROM vw_consulta_orden_detalle WHERE id_consulta='$_SESSION[gid_consulta]' ORDER BY desc_tipo_orden";
//echo "<br>".$consultaord;
$consultaord=$link->query($consultaord);
if($consultaord->num_rows<>0){
    while($row=$consultaord->fetch_array()){
        echo "<tr>";
        echo "<td>$row[desc_tipo_orden]</td>";
        echo "<td>$row[codigo_cups]</td>";
        echo "<td>$row[descripcion_cups]</td>";
        echo "<td>$row[observacion_det]</td>";        
        //echo "<td width='5%'><a href='#' onclick=editar($row[id_form_det]) title='Editar' class='btnhref'><span class='icon-edit'></span></a></td>";
        $estado_con=$row['estado_con'];
        if($estado_con=='A'){
            echo "<td width='5%' colspan='2' align='center'><a href='#' onclick=eliminar($row[id_ord_detalle],$row[codigo_cups]) title='Eliminar' class='btnhref'><span class='icon-trash Eliminar'></span></a></td>";
            echo "</tr>";
        }
    }        
}
if($estado_con=='A'){
?>
<tr>
    <td>            
        <select name='tipo_ord' >
        <option value=''></option>
        <?php
        $consultatipo="SELECT codi_det,descripcion_det FROM vw_tipo_orden";
        //echo "<br>".$consultafin;
        $consultatipo=$link->query($consultatipo);
        if($consultatipo->num_rows<>0){
            while($row=$consultatipo->fetch_array()){
                echo "<option value='$row[codi_det]'>".$row['descripcion_det']."</option>";
            }                
        }
        ?>
        </select>
    </td>

    <td colspan='2'>
        <input type='text' id='course' class='texto' name='codigo_orden' size='60' />            
        <input type='hidden' id='course_val' name='id_cups'/>
    </td>
    <td>
        <input type='text' id='observacion_det' name='observacion_det' size='100' maxlength='250' />
    </td>
    <td colspan="2" align="center">
        <a href='#' onclick=validar() title='Guardar' class='btnhref'><span class='icon-save'>
    </td>
    <td></td>
</tr>
<?php
}
echo "</table>";

?>

<script type="text/javascript" language='JavaScript'>
    document.form1.nombre_pac.value='<?php echo $paciente;?>';
</script>

</form>
</body>
</html>
