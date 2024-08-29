<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <title>Medinet</title>
    </head>
    <script language="JavaScript">
        function validar(cont_){            
            var error='';
            var_="nombre_acud"+cont_;
            cmd_="document.form1."+var_+".disabled";
            if(eval(cmd_)==false){
                var_="id_acudiente"+cont_;
                cmd_="document.form1."+var_+".value";
                document.form1.id_acudiente.value=eval(cmd_);

                var_="tipo_identificacion"+cont_;
                cmd_="document.form1."+var_+".value";
                document.form1.tipo_identificacion.value=eval(cmd_);
                
                var_="identificacion"+cont_;
                cmd_="document.form1."+var_+".value";
                document.form1.identificacion.value=eval(cmd_);

                var_="nombre_acud"+cont_;
                cmd_="document.form1."+var_+".value";
                document.form1.nombre_acud.value=eval(cmd_);
                if(eval(cmd_)==''){error+="Nombre\n";}
                var_="telefono_acud"+cont_;
                cmd_="document.form1."+var_+".value";
                document.form1.telefono_acud.value=eval(cmd_);
                if(eval(cmd_)==''){error+="Tel�fono\n";}
                var_="direccion_acud"+cont_;
                cmd_="document.form1."+var_+".value";
                document.form1.direccion_acud.value=eval(cmd_);
                if(eval(cmd_)==''){error+="Direccion\n";}

                var_="correo"+cont_;
                cmd_="document.form1."+var_+".value";
                document.form1.correo.value=eval(cmd_);

                var_="fecha_nacimiento"+cont_;
                cmd_="document.form1."+var_+".value";
                document.form1.fecha_nacimiento.value=eval(cmd_);

                var_="parentesco"+cont_;
                cmd_="document.form1."+var_+".value";
                document.form1.parentesco.value=eval(cmd_);
                if(eval(cmd_)==''){error+="Parentesco\n";}        
                if(error!=""){
                    alert("Para continuar, debe completar la siguiente informacion:\n"+error);
                }
                else{
                    document.form1.submit();
                }
            }
        }
        function editar(cont_){
            var_="tipo_identificacion"+cont_;
            cmd_='document.form1.'+var_+'.disabled=false';
            eval(cmd_);
            
            var_="identificacion"+cont_;
            cmd_='document.form1.'+var_+'.disabled=false';
            eval(cmd_);

            var_="nombre_acud"+cont_;
            cmd_='document.form1.'+var_+'.disabled=false';
            eval(cmd_);
            var_="telefono_acud"+cont_;
            cmd_='document.form1.'+var_+'.disabled=false';
            eval(cmd_);
            var_="direccion_acud"+cont_;
            cmd_='document.form1.'+var_+'.disabled=false';
            eval(cmd_);
            var_="correo"+cont_;
            cmd_='document.form1.'+var_+'.disabled=false';
            eval(cmd_)
            var_="fecha_nacimiento"+cont_;
            cmd_='document.form1.'+var_+'.disabled=false';
            eval(cmd_)
            var_="parentesco"+cont_;
            cmd_='document.form1.'+var_+'.disabled=false';
            eval(cmd_);
        }
        function eliminar(id_){
            if(confirm("Desea eliminar al acudiente?\n")){
                document.form1.id_acudiente.value=id_;
                document.form1.action="mn_ingresopaciente232.php";
                document.form1.submit();
            }
        }
        function guardarnuevo(){
            var error='';
            if(document.form1.nombre_acud.value==''){error+="Nombre\n";}
            if(document.form1.telefono_acud.value==''){error+="Telefono\n";}
            if(document.form1.direccion_acud.value==''){error+="Direcci�n\n";}
            if(document.form1.parentesco.value==''){error+="Parentesco\n";}
            if(error!=""){
                alert("Para continuar, debe completar la siguiente informacion:\n"+error);
            }
            else{
                document.form1.action="mn_ingresopaciente233.php";
                document.form1.submit();
            }
        }

        function editaract(cont_){
            var_="descripcion"+cont_;
            cmd_='document.form1.'+var_+'.disabled=false';
            eval(cmd_);
        }
        function validaract(cont_){
            var error='';
            var_="descripcion"+cont_;
            cmd_="document.form1."+var_+".disabled";
            if(eval(cmd_)==false){
                var_="id_actividad"+cont_;
                cmd_="document.form1."+var_+".value";
                document.form1.id_actividad.value=eval(cmd_);
                var_="descripcion"+cont_;
                cmd_="document.form1."+var_+".value";
                document.form1.descripcion.value=eval(cmd_);
                if(eval(cmd_)==''){error+="Actividad\n";}     
                if(error!=""){
                    alert("Para continuar, debe completar la siguiente informacion:\n"+error);
                }
                else{
                    document.form1.action='mn_ingresopaciente234.php';
                    document.form1.submit();
                }
            }
        }
        function eliminaract(id_){
            if(confirm("Desea eliminar la actividad?\n")){
                document.form1.id_actividad.value=id_;
                document.form1.action="mn_ingresopaciente235.php";
                document.form1.submit();
            }
        }
        function guardarnuevoact(){
            var error='';
            if(document.form1.descripcion.value==''){error+="Actividad\n";}
            if(error!=""){
                alert("Para continuar, debe completar la siguiente informacion:\n"+error);
            }
            else{
                document.form1.action="mn_ingresopaciente236.php";
                document.form1.submit();
            }
        }
    </script>
<body>
<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_ingreso.php");
$link=conectarbd();
$consulta="SELECT tipo_iden,identificacion,CONCAT(pnombre,' ',snombre,' ',papellido,' ',sapellido) AS nombre,fecha_ing,nombre_eps FROM vw_ingreso WHERE id_ingreso='$_GET[id_ingreso]'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows > 0){
    $row=$consulta->fetch_array();
    $tipo_iden=$row['tipo_iden'];
    $identificacion=$row['identificacion'];
    $nombre=$row['nombre'];
    $fecha_ing=$row['fecha_ing'];
    $nombre_eps=$row['nombre_eps'];
}
?>
<form name='form1' method="post" action="mn_ingresopaciente231.php">
<fieldset><legend>Información del Paciente</legend>
    <div class="fila">
    <span class="etiqueta"><label>Tipo de Identificación:</label></span>
    <span class="form-el"><?php echo $tipo_iden;?></span>        
    </div>
    <div class="fila">
    <span class="etiqueta"><label>Número de Identificación:</label></span>
    <span class="form-el"><?php echo $identificacion;?></span>
    </div>
    <div class="fila">
    <span class="etiqueta"><label>Nombre:</label></span>
    <span class="form-el"><?php echo $nombre;?></span>        
    </div>
    <div class="fila">
    <span class="etiqueta"><label>Fecha de Ingreso:</label></span>
    <span class="form-el"><?php echo $fecha_ing;?></span>    
    </div>
    <div class="fila">
    <span class="etiqueta"><label>EPS:</label></span>
    <span class="form-el"><?php echo $nombre_eps;?></span>        
    </div>
    </fieldset>

    <?php
    //require("pp_datos_evaluacion.php");

    echo "<input type='hidden' name='id_ingreso' value='$_GET[id_ingreso]'/>";
    ?>
    <br><br>
    <fieldset><legend>Acudientes</legend>
    <table>
            <th colspan='2'>Opciones</th>
            <th>Tp.Ident</th>
            <th>Nro.Identificación</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            
            <th><span class='icon-save '></span></th>
            <?php
            $consulta_acudiente="SELECT id_acudiente,nombre_acud,telefono_acud,direccion_acud,parentesco,tipo_identificacion,identificacion,correo,fecha_nacimiento FROM acudiente WHERE id_ingreso='$_GET[id_ingreso]'";
            //echo "<br>".$consulta_acudiente;
            $consulta_acudiente=$link->query($consulta_acudiente);
            if($consulta_acudiente->num_rows<>0){
                $cont=0;
                while($rowacu=$consulta_acudiente->fetch_array()){
                    echo "<tr>";
                    echo "<td><a href='#' onclick=editar($cont) title='Editar' class='btnhref'><span class='icon-edit'></span></a></td>";
                    echo "<td><a href='#' onclick=eliminar($rowacu[id_acudiente]) title='Eliminar' class='btnhref'><span class='icon-trash Eliminar'></span></a></td>";
                    echo "<td>";
                    $var='id_acudiente'.$cont;                    
                    echo "<input type='hidden' name='$var' value='$rowacu[id_acudiente]'/>";
                    
                    $var='tipo_identificacion'.$cont;
                    echo "<input type='text' name='$var' size='2' maxlength='2' value='$rowacu[tipo_identificacion]' disabled='true'>";
                    echo "</td>";

                    echo "<td>";
                    $var='identificacion'.$cont;
                    echo "<input type='text' name='$var' size='10' maxlength='10' value='$rowacu[identificacion]' disabled='true'>";
                    echo "</td>";

                    echo "<td>";
                    $var='nombre_acud'.$cont;
                    echo "<input type='text' name='$var' size='30' maxlength='50' value='$rowacu[nombre_acud]' disabled='true'>";
                    echo "</td>";
                    $var='telefono_acud'.$cont;
                    echo "<td><input type='text' name='$var' size='10' maxlength='30' value='$rowacu[telefono_acud]' disabled='true'></td>";
                    $var='direccion_acud'.$cont;
                    echo "<td><input type='text' name='$var' size='35' maxlength='80' value='$rowacu[direccion_acud]' disabled='true'></td>";

                    echo "</tr>";
                    echo "<tr>";
                    //echo "<td></td><td></td>";

                    echo "<td colspan='4'>";
                    echo "<b>Correo</b><br>";
                    $var='correo'.$cont;
                    echo "<input type='text' name='$var' size='50' maxlength='100' value='$rowacu[correo]' disabled='true'>";
                    echo "</td>";
                    
                    echo "<td>";
                    echo "<b>Fecha de Nacimiento</b><br>";
                    $var='fecha_nacimiento'.$cont;
                    echo "<input type='date' name='$var' value='$rowacu[fecha_nacimiento]' disabled='true'>";
                    echo "</td>";


                    $var='parentesco'.$cont;
                    echo "<td>";
                    echo "<b>Parentesco</b><br>";
                    echo "<input type='text' name='$var' size='10' maxlength='30' value='$rowacu[parentesco]' disabled='true'>";
                    echo "</td>";

                    echo"<td></td>";
                    echo "<td align='center'><a href='#' onclick=validar($cont) title='Guardar' class='btnhref'><span class='icon-save'></span></a> </td>";
                    echo "</tr>";
                    $cont++;
                }
            }
            ?>
            <tr>
                <td colspan="2" align="rigth"><span class='icon-add-user '></span>Nuevo</td>

                <td>
                    <select id='tipo_identificacion' name='tipo_identificacion'>
                    <option value=""></option>
                    <option value="CC">CC</option>
                    <option value="PA">PA</option>
                    <option value="CE">CE</option>
                    </select>
                </td>

                <td><input type='text' name='identificacion' size='10' maxlength='10' placeholder='Identificación'></td>

                <td><input type="text" name="nombre_acud" size="30" maxlength="50" placeholder='Nombre'></td>
                <td><input type="text" name="telefono_acud" size="10" maxlength="30" placeholder='Telefono'></td>

                <td><input type="text" name="direccion_acud" size="35" maxlength="80" placeholder='Dirección'></td>
                
            </tr>
            <tr>
                <td colspan='4'>
                    <b>Correo</b><br>
                    <input type='text' name='correo' size='50' maxlength='100' placeholder='Correo'>
                </td>
                <td>
                    <b>Fecha de Nacimiento</b><br>
                    <input type='date' name='fecha_nacimiento'>
                </td>
                <td>
                    <b>Parentesco</b><br>
                    <input type="text" name="parentesco" size="10" maxlength="30" placeholder='Parentesco'>
                </td>
                <td align='center'><a href='#' onclick="guardarnuevo()" title='Guardar' class='btnhref'><span class='icon-save'></span></a></td>-->
            </tr>
        </table>
        </fieldset>
    <input type='hidden' name='id_acudiente'>
    
    <fieldset><legend>Actividades Favoritas</legend>
    <table width="50%">
            <th colspan='2'>Opciones</th>
            <th>Actividad</th>
            <th><span class='icon-save'></span></th>
            <?php
            $consulta_acti="SELECT id_actividad,descripcion FROM actividades_fav WHERE id_ingreso='$_GET[id_ingreso]'";
            //echo "<br>".$consulta_acti;
            $consulta_acti=$link->query($consulta_acti);
            if($consulta_acti->num_rows<>0){
                $cont=0;
                while($rowacti=$consulta_acti->fetch_array()){
                    echo "<tr>";
                    echo "<td width='5%'><a href='#' onclick=editaract($cont) title='Editar' class='btnhref'><span class='icon-edit'></span></a></td>";
                    echo "<td width='5%'><a href='#' onclick=eliminaract($rowacti[id_actividad]) title='Eliminar' class='btnhref'><span class='icon-trash Eliminar'></span></a></td>";
                    echo "<td>";
                    $var='id_actividad'.$cont;
                    echo "<input type='hidden' name='$var' value='$rowacti[id_actividad]'/>";
                    $var='descripcion'.$cont;
                    echo "<input type='text' name='$var' size='40' maxlength='40' value='$rowacti[descripcion]' disabled='true'>";
                    echo "</td>";
                     echo "<td align='center'><a href='#' onclick=validaract($cont) title='Guardar' class='btnhref'><span class='icon-save'></span></a></td>";
                    echo "</tr>";
                    $cont++;
                }
            }
            ?>
            <tr>
                <td colspan="2" align="rigth"><span class='icon-colours'></span>Nuevo</td>
                <td><input type="text" name="descripcion" size="40" maxlength="40"></td>
                <td align='center'><a href='#' onclick="guardarnuevoact()" title='Guardar' class='btnhref'><span class='icon-save'></span></a></td>
            </tr>
        </table>
        </fieldset>
        <input type='hidden' name='id_actividad'>
</form>
</body>
</html>