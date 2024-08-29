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
                $("#course").autocomplete("mn_autocomp_producto.php", {
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
            if(document.form1.id_producto.value==''){error+="Producto\n";}
            /*if(document.form1.dosis_det.value==''){error+="Dosis\n";}
            if(document.form1.frecuencia_det.value==''){error+="Frecuencia\n";}
            if(document.form1.via_det.value==''){error+="Vía\n";}
            if(document.form1.tiempo_trat_det.value==''){error+="Tiempo de tratamiento\n";}*/
            if(document.form1.cantidad_det.value==''){error+="Cantidad\n";}
            if(error!=""){
                alert("Para continuar, debe digitar los sigientes campos:\n"+error);
            }
            else{
                document.form1.submit();
            }
        }
        function eliminar(id_,desc_){
            if(confirm("Desea eliminar el producto:\n"+desc_)){
                window.open("mn_formula12.php?id_form_det="+id_,"_self");
            }
            //alert("Opcion NO disponible");
        }
        /*function editar(id_){
            window.open("mn_persona21.php?id_persona="+id_,"_self");
        }
        */
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_consulta.php");
//echo "<br>".$_SESSION['gid_ingreso'];
//echo "<br>".$_SESSION['gid_consulta'];
?>
<form name='form1' method="post" action="mn_formula11.php">
    
<?php
//Aqui consulto la informacion del ingreso
$consultaper="SELECT CONCAT(tipo_iden,' ',identificacion,' ',pnombre,' ',snombre,' ',papellido,' ',sapellido) AS paciente FROM vw_ingreso WHERE id_ingreso='$_SESSION[gid_ingreso]'";
//echo "<br>".$consultaper;
$consultaper=$link->query($consultaper);
if($consultaper->num_rows<>0){
    $row=$consultaper->fetch_array();
    $paciente=$row['paciente'];
}
$estado_con='A';
?>
<div class="fila">    
    <label><span class="icon-bowl"><b>FORMULA MEDICA</b></span></label>
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
echo "<th>Código</th>".
"<th>Descripción</th>".
"<th>Concentración</th>".
"<th>Presentación</th>".
"<th>Dosis</th>".
"<th>Frecuencia</th>".
"<th>Vía</th>".
"<th>Tiempo</th>".
"<th>Cantidad</th>".
"<th>Observación</th>".
"<th colspan='2'>Opciones</th>";
$consultafor="SELECT id_form_det,codigo_producto,descripcion,concentracion,presentacion,dosis_det,frecuencia_det,via,tiempo_trat_det,cantidad_det,observacion_det,estado_con FROM vw_consulta_formula_detalle WHERE id_consulta='$_SESSION[gid_consulta]'";
//echo "<br>".$consultafor;
$consultafor=$link->query($consultafor);
if($consultafor->num_rows<>0){        
    while($row=$consultafor->fetch_array()){
        echo "<tr>";
        echo "<td>$row[codigo_producto]</td>";
        echo "<td>$row[descripcion]</td>";
        echo "<td>$row[concentracion]</td>";
        echo "<td>$row[presentacion]</td>";
        echo "<td>$row[dosis_det]</td>";
        echo "<td>$row[frecuencia_det]</td>";
        echo "<td>$row[via]</td>";
        echo "<td>$row[tiempo_trat_det]</td>";
        echo "<td>$row[cantidad_det]</td>";
        echo "<td>$row[observacion_det]</td>";            
        //echo "<td width='5%'><a href='#' onclick=editar($row[id_form_det]) title='Editar' class='btnhref'><span class='icon-edit'></span></a></td>";
        $estado_con=$row['estado_con'];
        if($estado_con=='A'){
            echo "<td width='5%' colspan='2' align='center'><a href='#' onclick=eliminar($row[id_form_det],$row[codigo_producto]) title='Eliminar' class='btnhref'><span class='icon-trash Eliminar'></span></a></td>";
            echo "</tr>";
        }

    }        
}

    
    if($estado_con=='A'){
    ?>
    <tr>    
    <td colspan='4'>
        <input type='text' id='course' class='texto' name='codigo_producto' size='60' />            
        <input type='hidden' id='course_val' name='id_producto'/>

    </td>
    <td><input type='text' id='dosis_det' name='dosis_det' size='10' maxlength='10' /></td>
    <td><input type='text' id='frecuencia_det' name='frecuencia_det' size='10' maxlength='10' /></td>
    <td>            
        <select name='via_det' >
        <option value=''></option>
        <?php
        $consultavia="SELECT codi_det,descripcion_det FROM vw_via";
        //echo "<br>".$consultafin;
        $consultavia=$link->query($consultavia);
        if($consultavia->num_rows<>0){
            while($row=$consultavia->fetch_array()){
                echo "<option value='$row[codi_det]'>".$row['descripcion_det']."</option>";
            }                
        }
        ?>
        </select>
    </td>
    <td><input type='text' id='tiempo_trat_det' name='tiempo_trat_det' size='10' maxlength='10' /></td>
    <td><input type='text' id='cantidad_det' name='cantidad_det' size='3' maxlength='3' /></td>
    <td>
        <input type='text' id='observacion_det' name='observacion_det' size='50' maxlength='50' />
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
