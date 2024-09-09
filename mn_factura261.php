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
$id_factura=$_GET['id_factura'];
if(!empty($id_factura)){
    $_SESSION['gid_factura']=$id_factura;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <meta description="Registro y cotrol de actividades asistenciales"/>
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

        function activasel(var_,val_){
            var comando="form1."+var_+".value='"+val_+"'";
            //alert(comando);
            eval(comando);
        }
    </script>
<?php
require("mn_funciones.php");
require("mn_menu.php");
$link=conectarbd();


//Aqui consulto el numero consecutivo de la factura
/*$consultanum="SELECT numero_fac FROM entidad";
$consultanum=$link->query($consultanum);
if($consultanum->num_rows<>0){
    $rownum=$consultanum->fetch_array();
    $numero_fac=$rownum['numero_fac'];
    //Aqui actualizo el nuevo numero de la factura
    $sql_="UPDATE entidad SET numero_fac=$numero_fac+1";
    //echo "<br>".$sql_;
    //$link->query($sql_);

    //Aqui actualizo el estado de la factura y le coloco el numero 
    $sql_="UPDATE encabezado_factura SET estado_fac='C',numero_fac='$numero_fac' WHERE id_factura='$id_factura'";
    //echo "<br>".$sql_;
    //$link->query($sql_);
    //generarRips($id_factura);
    if($link->affected_rows > 0){
        $msg="Registro guardado con exito";
        generarRips($id_factura);
    }
    else{$msg="Registro no guardado";}
}*/

//Aqui consulto la factura
$consultafac = "select ef.id_factura , ef.numero_fac ,ef.numero_fac,ef.fecha_fac ,
p.identificacion , concat(p.pnombre,' ',p.snombre,' ',p.papellido,' ',p.sapellido) as nombre,
e.nombre_eps 
from encabezado_factura ef 
inner join persona p on p.id_persona = ef.id_persona 
inner join eps e on e.id_eps = ef.id_eps 
where id_factura ='$_SESSION[gid_factura]'";
//echo $consultafac;
$consultafac=$link->query($consultafac);
if($consultafac->num_rows<>0){    
    $rowfac=$consultafac->fetch_array();
    $identificacion=$rowfac['identificacion'];
    $nombre=$rowfac['nombre'];
    $fecha_fac=$rowfac['fecha_fac'];
    $numero_fac=$rowfac['numero_fac'];
    $nombre_eps=$rowfac['nombre_eps'];
}
   

?>
<body>
<form name='form1' method="post" action="">
    <div>
        <h4>Gestión de Rips</h4>
    </div>
    <span class="form-el"><b>Identificación: </b> <?php echo $identificacion;?></span>
    <br><span class="form-el"><b>Nombre: </b><?php echo $nombre;?></span>
    <br><span class="form-el"><b>Fecha de la factura: </b> <?php echo $fecha_fac;?></span>
    <br><span class="form-el"><b>Número de la factura: </b> <?php echo $numero_fac;?></span>
    <br><span class="form-el"><b>Eps:</b> <?php echo $nombre_eps;?></span>

    <?php
    require("mn_menu_rips.php");
    
    $consultausu="SELECT usu.id_usuario,usu.tipo_documento ,usu.numdocumento,usu.tipousuario,usu.fechanacimiento,usu.codsexo,usu.codpaisresidencia,usu.codmunicipioresidencia,usu.codzonaresidencia,usu.incapacidad,usu.codpaisorigen,usu.id_factura
    FROM nrusuario AS usu 
    WHERE usu.id_factura='$_SESSION[gid_factura]'";
    //echo $consultausu;
    $consultausu=$link->query($consultausu);
    if($consultausu->num_rows<>0){
        $rowusu=$consultausu->fetch_array();
        echo "<input type='text' name='id_usuario' value='$rowusu[id_usuario]'>";
        ?>
        <br><br>
        <center>
        <table class="Tbl1" border="0">
            <tr>
                <td class="Td1" align='right' width='50%'>
                
                </td>
                <td class="Td" align='left' width='50%'>
                
                </td>
            </tr>
            <tr>
                <td class="Td2" align='right' width='50%'><b>Tipo de documento de identificación:</td>
                <td class="Td2" align='left' width='50%'>
                    <select name='tipodocumento' disabled>
                    <option value=''></option>
                    <option value='CC'>CC</option>
                    <option value='CE'>CE</option>
                    <option value='PA'>PA</option> 
                    </select>                
                    
                    <script language='javascript'>activasel('tipodocumento','<?php echo $rowusu['tipo_documento'];?>');</script>
                </td>        
            </tr>
            <tr>
                <td class="Td2" align='right' width='50%'><b>Número:</td>
                <td class="Td2" align='left' width='50%'>
                    <input type='text' name='numdocumento' size='20' maxlength='20' value='<?php echo $rowusu['numdocumento'];?>' disabled>
                </td>
            </tr>
            <tr>
                <td class="Td2" align='right' width='50%'><b>Tipo de usuario:</td>
                <td class="Td2" align='left' width='50%'>
                    <?php
                        $consultapar="select valor_det ,descripcion_det  from detalle_grupo
                        where id_grupo ='5' ORDER BY descripcion_det";
                        $consultapar=$link->query($consultapar);
                        echo "<select name='tipousuario' disabled>";
                        while($rowpar=$consultapar->fetch_array()){
                            echo "<option value='$rowpar[valor_det]'>$rowpar[descripcion_det]</option>";                        }
                        echo "</select>";                        
                    ?>
                    <script language='javascript'>activasel('tipousuario','<?php echo $rowusu['tipousuario'];?>');</script>
                </td>        
            </tr>
            <tr>
                <td class="Td2" align='right' width='50%'><b>Fecha de nacimiento:</td>
                <td class="Td2" align='left' width='50%'>
                    <input type='text' name='fechanacimiento' size='10' maxlength='10' value='<?php echo $rowusu['fechanacimiento'];?>' disabled>
                </td>
            </tr>
            <tr>
                <td class="Td2" align='right' width='50%'><b>Sexo:</td>
                <td class="Td2" align='left' width='50%'>
                    <select name="codsexo" id="codsexo" disabled>
                        <option value=''></option>
                        <option value='H'>Hombre</option>
                        <option value='M'>Mujer</option>
                        <option value='I'>Indeterminado</option>
                    </select>                    
                    <script language='javascript'>activasel('codsexo','<?php echo $rowusu['codsexo'];?>');</script>
                </td>        
            </tr>
            <tr>
                <td class="Td2" align='right' width='50%'><b>Código del país de residencia:</td>
                <td class="Td2" align='left' width='50%'>
                    <input type='text' name='codpaisresidencia' size='3' maxlength='3' value='<?php echo $rowusu['codpaisresidencia'];?>' disabled>
                </td>        
            </tr>        
            <tr>
                <td class="Td2" align='right' width='50%'><b>Municipio de residencia:</td>
                <td class="Td2" align='left' width='50%'>
                    <?php
                        $consultamun="select m.codigo_mun ,m.nombre_mun  
                        from municipio m ORDER BY m.nombre_mun";
                        $consultamun=$link->query($consultamun);
                        echo "<select name='codmunicipioresidencia' disabled>";
                        echo "<option value=''>";
                        while($rowmun=$consultamun->fetch_array()){
                            echo "<option value='$rowmun[codigo_mun]'>$rowmun[nombre_mun]</option>";
                        }
                        echo "</select>";
                    ?>
                    <script language='javascript'>activasel('codmunicipioresidencia','<?php echo $rowusu['codmunicipioresidencia'];?>');</script>
                </td>        
            </tr>
            <tr>
                <td class="Td2" align='right' width='50%'><b>Zona de residencia:</td>
                <td class="Td2" align='left' width='50%'>
                    <select name='codzonaresidencia' disabled>
                        <option value=''></option>
                        <option value='U'>Urbana</option>
                        <option value='R'>Rural</option>    
                    </select>
                    <script language='javascript'>activasel('codzonaresidencia','<?php echo $rowusu['codzonaresidencia'];?>');</script>
                </td>        
            </tr>
            <tr>
                <td class="Td2" align='right' width='50%'><b>Incapacidad:</td>
                <td class="Td2" align='left' width='50%'>
                    <select name='incapacidad' disabled>
                        <option value='NO'>NO
                        <option value='SI'>SI
                    </select>
                    <script language='javascript'>activasel('incapacidad','<?php echo $rowusu['incapacidad'];?>');</script>
                </td>        
            </tr>
            <!--<tr>
                <td class="Td2" align='right' width='50%'><b>Pais de origen:</td>
                <td class="Td2" align='left' width='50%'>
                    <?php
                        /*$consultades=mysql_query("SELECT codigo,nombre FROM pais ORDER BY nombre");
                        echo "<select name='codpaisorigen' disabled>";
                        while($rowdes=mysql_fetch_array($consultades)){
                            echo "<option value='$rowdes[codigo]'>$rowdes[nombre] ";
                        }
                        echo "</select>";	*/
                    ?>
                    <script language='javascript'>activasel('codpaisorigen','<?php //echo $rowcon[codpaisresidencia];?>');</script>
                </td>        
            </tr>
            <tr>
                <td class="Td6" align='right' width='50%'>
                    <center><a href='#' onclick='activar()' title="Editar"><img src='icons/feed_edit.png' width='20' height='20'>Editar</a></center>
                </td>
                <td class="Td6" align='left' width='50%'>
                    <center><a href='#' onclick='validar()' title="Guardar"><img src='icons/feed_disk.png' width='20' height='20'>Guardar</a></center>
                </td>
            </tr>-->
        </table>
        </center>
        <?php
    }





    


    /*mysql_free_result($consulta);
    mysql_free_result($consultacon);
    mysql_close();*/
    ?>    

    <br><br>


    



</form>
</body>
</html>

