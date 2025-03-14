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
if(isset($_GET['id_factura'])){
    $id_factura=$_GET['id_factura'];
}
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script language="JavaScript">
            function editarUsuario(id_usuario){                        
                document.getElementById('editarUsuario').style.display='block';
            }

            function cerrarEdicion(){
                document.getElementById('editarUsuario').style.display='none';
            }

            function validarEdicion(){
                var error='';            
                if(document.getElementById("tipo_documento").value==''){
                    error=error+"Tipo de documento \n";
                }
                if(document.getElementById("numdocumento").value==''){
                    error=error+"Número de documento \n";
                }
                if(document.getElementById("tipousuario").value==''){
                    error=error+"Tipo de usuario \n";
                }
                if(document.getElementById("fechanacimiento").value==''){
                    error=error+"Fecha de nacimiento \n";
                }
                if(document.getElementById("codsexo").value==''){
                    error=error+"Sexo \n";
                }
                if(document.getElementById("codpaisresidencia").value==''){
                    error=error+"País de residencia \n";
                }
                if(document.getElementById("codpaisresidencia").value=='170' && document.getElementById("codmunicipioresidencia").value==''){
                    error=error+"Municipio de residencia \n";
                }
                if(document.getElementById("codpaisresidencia").value!='170' && document.getElementById("codmunicipioresidencia").value!=''){
                    document.getElementById("codmunicipioresidencia").value='';
                }
                if(document.getElementById("codzonaresidencia").value==''){
                    error=error+"Zona de residencia \n";
                }
                if(document.getElementById("incapacidad").value==''){
                    error=error+"Incapacidad \n";
                }
                if(document.getElementById("codpaisorigen").value==''){
                    error=error+"País de origen \n";
                }

                if(error!=''){
                    alert("Para guardar debe complementar la siguiente información:\n\n"+error);
                }
                else{
                    guardarEdicionUsuario()
                }
            }

            function guardarEdicionUsuario(){
                $.ajax({
                    url: "mn_factura2611.php", // Ruta al archivo PHP
                    type: "POST",       // Método HTTP (puede ser "GET" o "POST")
                    data: {             // Datos que se envían al script PHP
                        id_usuario: document.getElementById("id_usuario").value,
                        tipo_documento: document.getElementById("tipo_documento").value,
                        numdocumento: document.getElementById("numdocumento").value,
                        tipousuario: document.getElementById("tipousuario").value,
                        fechanacimiento: document.getElementById("fechanacimiento").value,
                        codsexo: document.getElementById("codsexo").value,
                        codpaisresidencia: document.getElementById("codpaisresidencia").value,
                        codmunicipioresidencia: document.getElementById("codmunicipioresidencia").value,
                        codzonaresidencia: document.getElementById("codzonaresidencia").value,
                        incapacidad: document.getElementById("incapacidad").value,
                        codpaisorigen: document.getElementById("codpaisorigen").value
                    },
                    success: function(respuesta) {
                        document.getElementById('editarUsuario').style.display='none';
                        if(respuesta==1){
                            alert("Registro guardado con éxito");
                            document.form1.submit();
                        }
                        else{
                            alert("Ocurrió un error al guardar el registro");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Ocurrió un error: " + error);
                    }
                });
            }

        </script>
    </head>    
<?php
require("mn_funciones.php");
require("mn_menu.php");
$link=conectarbd();

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
<form name='form1' method="post" action="mn_factura261.php">
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

    echo "<span class='h5'>Usuario</span>";    
    ?>

    <table class="Tbl0" border='1'>
    <th class="Th0"colspan='2'><b>Sel</th>
    <th class="Th0"><b>Tp Ident.</th>
    <th class="Th0"><b>Número</th>
    <th class="Th0"><b>Tipo de Usuaario</th>
    <th class="Th0"><b>Fecha de Nacimiento</th>
    <th class="Th0"><b>Sexo</th>
    <th class="Th0"><b>Cód. Pais Residencia</th>
    <th class="Th0"><b>Municipio de Residencia</th>
    <th class="Th0"><b>Zona de Residencia</th>  
    <th class="Th0"><b>Incapacidad</th>  
    <th class="Th0"><b>Código Paid Origen</th>        
    <?php
    
    $consultausu="SELECT usu.id_usuario,usu.tipo_documento ,usu.numdocumento,usu.tipousuario,usu.fechanacimiento,usu.codsexo,usu.codpaisresidencia,usu.codmunicipioresidencia,usu.codzonaresidencia,usu.incapacidad,usu.codpaisorigen,usu.id_factura,
    mun.nombre_mun
    FROM nrusuario AS usu 
    LEFT JOIN municipio mun ON mun.codigo_mun=usu.codmunicipioresidencia
    WHERE usu.id_factura='$_SESSION[gid_factura]'";
    //echo $consultausu;
    $consultausu=$link->query($consultausu);    
    
    while($row=$consultausu->fetch_array()){
        echo "<input type='hidden' name='id_usuario' id='id_usuario' value='$row[id_usuario]'>";
        echo "<tr>";            
        echo "<td class='Td2' align='left'><a href='#' onclick='editarUsuario($row[id_usuario])' title='Editar Registro'><span class='icon-open-book'></span></a></td>";
        echo "<td class='Td2' align='left'></td>";
        
        echo "<td class='Td2' align='center'>$row[tipo_documento]</td>";            
        echo "<td class='Td2' align='center'>$row[numdocumento]</td>";
        
        $nombreConcepto = traeConcepto($row['tipousuario'],5);
        echo "<td class='Td2' align='left'>$nombreConcepto</td>";
        echo "<td class='Td2' align='center'>$row[fechanacimiento]</td>";        
        echo "<td class='Td2' align='center'>$row[codsexo]</td>";
        echo "<td class='Td2' align='center'>$row[codpaisresidencia]</td>";
        echo "<td class='Td2' align='left'>$row[nombre_mun]</td>";
        echo "<td class='Td2' align='center'>$row[codzonaresidencia]</td>";
        echo "<td class='Td2' align='center'>$row[incapacidad]</td>";
        echo "<td class='Td2' align='center'>$row[codpaisorigen]</td>";        
        echo "</tr>";
    }
    echo "</table>";
    
    ?>
    <div class="cajaInput" id="editarUsuario">
        <div class="cajaTitulo">
            <cemter><h5>Editar Usuario</h5></cemter>
        </div>          
        
        <div class="cajaContenido">
            <input type="hidden" name="id_usuario" id="id_usuario">            
            <br><span>Tipo de documento de identificación:</span>
                <select name="tipo_documento" id="tipo_documento">
                    <option value="">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='14'");
                        while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
            
            <br><span>Número</span>
            <input type="text" name="numdocumento" id="numdocumento" size="20" maxlength="20" value="0">
            <br><span>Tipo de usuario</span>            
            <select name="tipousuario" id="tipousuario">
                    <option value="">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='5'");
                        while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
            <br><span>Fecha de nacimiento</span>
            <input type="date" name="fechanacimiento" id="fechanacimiento" size="16" maxlength="16">
            <br><span>Sexo:</span>
                <select name="codsexo" id="codsexo">
                    <option value="">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='15'");
                        while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>                    
                </select>            
            <br><span>Código país de residencia:</span>
            <input type="text" name="codpaisresidencia" id="codpaisresidencia" size="3" maxlength="3">
            <br><span>Municipio de residencia:</span>            
                <select name="codmunicipioresidencia" id="codmunicipioresidencia">
                    <option value="">Seleccione</option>
                    <?php
                    $consultades=$link->query("select m.codigo_mun, CONCAT(m.nombre_mun,' (',m.departamento,')') AS nombre_mun from municipio m
                    ORDER BY m.nombre_mun");
                        while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[codigo_mun]'>".substr($rowdes['nombre_mun'],0,40)."</option>";
                    }
                    ?>
                </select>
            <br><span>Zona de residencia:</span>
                <select name="codzonaresidencia" id="codzonaresidencia">
                    <option value="">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                    from detalle_grupo dg 
                    where dg.id_grupo ='16'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
            <br><span>Incapacidad:</span>            
                <select name="incapacidad" id="incapacidad">
                    <option value="">Seleccione</option>
                    <option value="SI">Si</option>
                    <option value="NO">No</option>
                </select>
            <br><span>Código país de origen:</span>
            <input type="text" name="codpaisorigen" id="codpaisorigen" size="3" maxlength="3">
            
            <br><center>
                <a href='#' onclick='validarEdicion()'><span class='icon-save'></span>Guardar</a>
                <a href='#' onclick='cerrarEdicion()'><span class='icon-back'></span>Cancelar</a>
            </center>
        </div>         
    </div>
</form>
</body>
</html>

<?php

$consultausu->data_seek(0);
$row = $consultausu->fetch_array();
?>
<script>
    document.getElementById('tipo_documento').value="<?php echo $row['tipo_documento'];?>";
    document.getElementById('numdocumento').value="<?php echo $row['numdocumento'];?>";
    document.getElementById('tipousuario').value="<?php echo $row['tipousuario'];?>";
    document.getElementById('fechanacimiento').value="<?php echo $row['fechanacimiento'];?>";
    document.getElementById('codsexo').value="<?php echo $row['codsexo'];?>";
    document.getElementById('codpaisresidencia').value="<?php echo $row['codpaisresidencia'];?>";
    document.getElementById('codmunicipioresidencia').value="<?php echo $row['codmunicipioresidencia'];?>";
    document.getElementById('codzonaresidencia').value="<?php echo $row['codzonaresidencia'];?>";
    document.getElementById('incapacidad').value="<?php echo $row['incapacidad'];?>";
    document.getElementById('codpaisorigen').value="<?php echo $row['codpaisorigen'];?>";
    
</script>

<?php
function traeConcepto($val_,$id_grupo){
    $descripcion="";
    $link=conectarbd();
    $consultadet=$link->query("select dg.valor_det ,dg.descripcion_det 
        from detalle_grupo dg 
        where dg.id_grupo ='$id_grupo' and dg.valor_det='$val_'");
    if($consultadet->num_rows > 0){
        $rowdet=$consultadet->fetch_array();
        $descripcion=$rowdet['descripcion_det'];
    }    
    return $descripcion;
}


?>