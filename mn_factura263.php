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
    </head>
    <script language="JavaScript">

        otrosServicios=[];

        function nuevoServicio(){            
            document.getElementById('nuevoServicio').style.display='block';
        }

        function cerrar(){
            document.getElementById('nuevoServicio').style.display='none';
        }

        function cerrarEdicion(){
            document.getElementById('editarServicio').style.display='none';
        }
        
        function validar(){
            error='';
            if(document.form1.fechasuministrotecnologia.value==''){
                error+='Fecha de Suministro\n';
            }
            if(document.form1.tipoos.value==''){
                error+='Tipo\n';
            }
            if(document.form1.codtecnologia.value==''){
                error+='Código del servicio\n';
            }
            if(document.form1.nomtecnologia.value==''){
                error+='Nombre del servicio\n';
            }
            if(document.form1.conceptorecaudo.value==''){
                error+='Concepto del recaudo\n';
            }
            if(error!=''){
                alert("Para guardar debe complementar la siguiente información:\n\n"+error);
            }
            else{
                guardarServicio();                
            }
        }

        function guardarServicio(){            
            $.ajax({
                url: "mn_factura2631.php", // Ruta al archivo PHP
                type: "POST",       // Método HTTP (puede ser "GET" o "POST")
                data: {             // Datos que se envían al script PHP                    
                    numautorizacion: document.form1.numautorizacion.value,
                    idmipres: document.form1.idmipres.value,
                    fechasuministrotecnologia: document.form1.fechasuministrotecnologia.value,
                    tipoos: document.form1.tipoos.value,
                    codtecnologia: document.form1.codtecnologia.value,
                    nomtecnologia: document.form1.nomtecnologia.value,
                    cantidados: document.form1.cantidados.value,
                    vrunitos: document.form1.vrunitos.value,                    
                    conceptorecaudo: document.form1.conceptorecaudo.value,
                    valorpagomoderador: document.form1.valorpagomoderador.value,
                    numfevpagomoderador: document.form1.numfevpagomoderador.value,                    
                    id_factura: <?php echo $_SESSION['gid_factura']; ?>            
                },
                success: function(respuesta) {
                    document.getElementById('nuevoServicio').style.display='none';
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

        function editarServicio(id_servicio){            
            
            document.getElementById('editarServicio').style.display='block';
            for (let servicio of otrosServicios) {
                if(servicio.id_otroservicio == id_servicio){                    
                    document.getElementById("id_otroservicio").value = servicio.id_otroservicio;
                    document.getElementById("numautorizacionEd").value = servicio.numautorizacion;
                    document.getElementById("idmipresEd").value = servicio.idmipres
                    document.getElementById("fechasuministrotecnologiaEd").value = servicio.fechasuministrotecnologia;
                    document.getElementById("tipoosEd").value = servicio.tipoos;
                    document.getElementById("codtecnologiaEd").value = servicio.codtecnologia;
                    document.getElementById("nomtecnologiaEd").value = servicio.nomtecnologia;
                    document.getElementById("cantidadosEd").value = servicio.cantidados;
                    document.getElementById("vrunitosEd").value = servicio.vrunitos;
                    document.getElementById("conceptorecaudoEd").value = servicio.conceptorecaudo;
                    document.getElementById("valorpagomoderadorEd").value = servicio.valorpagomoderador;
                    document.getElementById("numfevpagomoderadorEd").value = servicio.numfevpagomoderador;
                }
            }

        }

        function validarEdicion(){
            error='';
            if(document.getElementById("fechasuministrotecnologiaEd").value == ''){
                error+='Fecha de Suministro\n';
            }
            if(document.getElementById("tipoosEd").value==''){
                error+='Tipo\n';
            }
            if(document.getElementById("codtecnologiaEd").value==''){
                error+='Código del servicio\n';
            }
            if(document.getElementById("nomtecnologiaEd").value==''){
                error+='Nombre del servicio\n';
            }
            if(document.getElementById("conceptorecaudoEd").value==''){
                error+='Concepto del recaudo\n';
            }
            if(error!=''){
                alert("Para guardar debe complementar la siguiente información:\n\n"+error);
            }
            else{
                guardarEdicionServicio();
            }
        }

        function guardarEdicionServicio(){            
            $.ajax({
                url: "mn_factura2632.php", // Ruta al archivo PHP
                type: "POST",       // Método HTTP (puede ser "GET" o "POST")
                data: {             // Datos que se envían al script PHP
                    id_otroservicio: document.getElementById("id_otroservicio").value,
                    numautorizacion: document.getElementById("numautorizacionEd").value,
                    idmipres: document.getElementById("idmipresEd").value,
                    fechasuministrotecnologia: document.getElementById("fechasuministrotecnologiaEd").value,
                    tipoos: document.getElementById("tipoosEd").value,
                    codtecnologia: document.getElementById("codtecnologiaEd").value,
                    nomtecnologia: document.getElementById("nomtecnologiaEd").value,
                    cantidados: document.getElementById("cantidadosEd").value,
                    vrunitos: document.getElementById("vrunitosEd").value,
                    conceptorecaudo: document.getElementById("conceptorecaudoEd").value,
                    valorpagomoderador: document.getElementById("valorpagomoderadorEd").value,
                    numfevpagomoderador: document.getElementById("numfevpagomoderadorEd").value
                },
                success: function(respuesta) {
                    document.getElementById('editarServicio').style.display='none';
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

        function eliminar(reg_){
            if(confirm("Desea eliminar este servicio?")){
                $.ajax({
                    url: "mn_factura2633.php", // Ruta al archivo PHP
                    type: "POST",       // Método HTTP (puede ser "GET" o "POST")
                    data: {             // Datos que se envían al script PHP
                        id_otroservicio: reg_,                        
                    },
                    success: function(respuesta) {                        
                        if(respuesta==1){
                            alert("Registro eliminado con éxito");
                            document.form1.submit();
                        }
                        else{
                            alert("Ocurrió un error al eliminar el registro");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Ocurrió un error: " + error);
                    }
                });
            }
        }


    </script>
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
<form name='form1' method="post" action="mn_factura263.php">
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

    echo "<span class='h5'>Otros Servicios</span>";

    ?>
    <table class="Tbl0" border='1'>
        <th class="Th0"colspan='2'><b>Sel</th>
        <th class="Th0"><b>Autorización</th>
        <th class="Th0"><b>MIPRES</th>
        <th class="Th0"><b>Fecha Suministro</th>
        <th class="Th0"><b>Tipo</th>
        <th class="Th0"><b>Código</th>
        <th class="Th0"><b>Nombre</th>
        <th class="Th0"><b>Cantidad</th>
        <th class="Th0"><b>Valor Unitario</th>  
        <th class="Th0"><b>Valor Total</th>  
        <th class="Th0"><b>Concepto Recaudo</th>
        <th class="Th0"><b>Vr. Moderador</th>
        <th class="Th0"><b>FEV Moderador</th>
        <?php
        $total=0;
        $consultacon="SELECT otr.id_otroservicio,otr.numautorizacion,otr.idmipres,otr.fechasuministrotecnologia,otr.tipoos,otr.codtecnologia,otr.nomtecnologia,otr.cantidados,otr.tipodocumentoidentificacion,otr.numdocumentoidentificacion,otr.vrunitos,otr.vrservicio,otr.conceptorecaudo,otr.valorpagomoderador,otr.numfevpagomoderador,otr.consecutivo,otr.id_factura,otr.id_detalle 
        FROM nrotroservicios AS otr
        WHERE otr.id_factura='$_SESSION[gid_factura]'";
        //echo $consultacon;
        $consultacon=$link->query($consultacon);

        while($rowcon=$consultacon->fetch_array()){            
            echo "<tr>";
            
            echo "<td class='Td2' align='left'><a href='#' onclick='editarServicio($rowcon[id_otroservicio])' title='Editar Registro'><span class='icon-open-book'></span></a></td>";
            echo "<td class='Td2' align='left'><a href='#' onclick=eliminar('$rowcon[id_otroservicio]') title='Eliminar Registro'><span class='icon-trash'></span></a></td>";
            
            echo "<td class='Td2' align='center'>$rowcon[numautorizacion]</td>";            
            echo "<td class='Td2' align='center'>$rowcon[idmipres]</td>";
            echo "<td class='Td2' align='center'>$rowcon[fechasuministrotecnologia]</td>";
            
            echo "<td class='Td2' align='center'>";
            $nombreConcepto = traeConcepto($rowcon['tipoos'],6);
            echo "$nombreConcepto</td>";

            echo "<td class='Td2' align='center'>$rowcon[codtecnologia]</td>";            
            echo "<td class='Td2' align='center'>$rowcon[nomtecnologia]</td>";
            echo "<td class='Td2' align='center'>$rowcon[cantidados]</td>";
            echo "<td class='Td2' align='right'>".number_format($rowcon['vrunitos'])."</td>";
            echo "<td class='Td2' align='right'>".number_format($rowcon['vrservicio'])."</td>";

            echo "<td class='Td2' align='center'>";
            $nombreConcepto = traeConcepto($rowcon['conceptorecaudo'],7);
            echo "$nombreConcepto</td>";

            echo "<td class='Td2' align='right'>".number_format($rowcon['valorpagomoderador'])."</td>";
            
            echo "<td class='Td2' align='center'>$rowcon[numfevpagomoderador]</td>";
            echo "</tr>";
            $total=$total+$rowcon['vrservicio'];
            
        }
        echo "<tr>";
        echo "<td class='Td2' align='right' colspan=10><b>Total </td>";
        echo "<td class='Td2' align='right'><b>".number_format($total)."</td>";
        echo "</tr>";
        echo "</table>";
        ?>

        <div>
            <a href='#' onclick='nuevoServicio()'><span class='icon-save'></span>Nuevo</a>
        </div> 


    <div class="cajaInput" id="nuevoServicio">
        <div class="cajaTitulo">
            <cemter><h5>Nuevo Servicio</h5></cemter>
        </div>          
        
        <div class="cajaContenido">
            <br><span>Número de Autrización:</span>
            <input type="text" name="numautorizacion" size="30" maxlength="30">
            <br><span>ID MIPRES</span>
            <input type="text" name="idmipres" size="15" maxlength="15" value="0">
            <br><span>Fecha de suministro</span>
            <input type="datetime-local" name="fechasuministrotecnologia" size="16" maxlength="16">
            <br><span>Tipo de servicio:</span>            
                <select name="tipoos">
                    <option value="">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='6'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
            
            <br><span>Código:</span>
            <input type="text" name="codtecnologia" size="20" maxlength="20">
            <br><span>Nombre:</span>
            <input type="text" name="nomtecnologia" size="60" maxlength="60">
            <br><span>Cantidad:</span>
            <input type="text" name="cantidados" size="5" maxlength="5" value="0">
            <br><span>Valor unitario:</span>
            <input type="text" name="vrunitos" size="15" maxlength="15" value="0">

            <br><span>Concepto de recaudo:</span>
            <select name="conceptorecaudo">
                <option value="">Seleccione</option>
                <?php
                $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                    from detalle_grupo dg 
                    where dg.id_grupo ='7'");
                while($rowdes=$consultades->fetch_array()){                
                    echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                }
                ?>
            </select>
            
            <br><span>Valor Moderador:</span>
            <input type="text" name="valorpagomoderador" size="10" maxlength="10" value="0">
            <br><span>FEV Moderador:</span>
            <input type="text" name="numfevpagomoderador" size="20" maxlength="20">

            <br><center>
                <a href='#' onclick='validar()'><span class='icon-save'></span>Guardar</a>
                <a href='#' onclick='cerrar()'><span class='icon-back'></span>Cancelar</a>
            </center>


        </div>                
    </div>

    <div class="cajaInput" id="editarServicio">
        <div class="cajaTitulo">
            <cemter><h5>Editar Servicio</h5></cemter>
        </div>          
        
        <div class="cajaContenido">
            <input type="hidden" name="id_otroservicio" id="id_otroservicio">
            <br><span>Número de Autrización:</span>
            <input type="text" name="numautorizacionEd" id="numautorizacionEd" size="30" maxlength="30">
            <br><span>ID MIPRES</span>
            <input type="text" name="idmipresEd" id="idmipresEd" size="15" maxlength="15" value="0">
            <br><span>Fecha de suministro</span>
            <input type="datetime-local" name="fechasuministrotecnologiaEd" id="fechasuministrotecnologiaEd" size="16" maxlength="16">
            <br><span>Tipo de servicio:</span>
                <select name="tipoosEd" id="tipoosEd">
                    <option value="">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='6'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
            
            <br><span>Código:</span>
            <input type="text" name="codtecnologiaEd" id="codtecnologiaEd" size="20" maxlength="20">
            <br><span>Nombre:</span>
            <input type="text" name="nomtecnologiaEd" id="nomtecnologiaEd" size="60" maxlength="60">
            <br><span>Cantidad:</span>
            <input type="text" name="cantidadosEd" id="cantidadosEd" size="5" maxlength="5" value="0">
            <br><span>Valor unitario:</span>
            <input type="text" name="vrunitosEd" id="vrunitosEd" size="15" maxlength="15" value="0">

            <br><span>Concepto de recaudo:</span>
            <select name="conceptorecaudoEd" id="conceptorecaudoEd">
                <option value="">Seleccione</option>
                <?php
                $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                    from detalle_grupo dg 
                    where dg.id_grupo ='7'");
                while($rowdes=$consultades->fetch_array()){                
                    echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                }
                ?>
            </select>
            
            <br><span>Valor Moderador:</span>
            <input type="text" name="valorpagomoderadorEd" id="valorpagomoderadorEd" size="10" maxlength="10" value="0">
            <br><span>FEV Moderador:</span>
            <input type="text" name="numfevpagomoderadorEd" id="numfevpagomoderadorEd" size="20" maxlength="20">

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

$consultacon->data_seek(0);
while($row = $consultacon->fetch_array()){    
    ?>
    <script>
        servicio={
            id_otroservicio: '<?php echo $row['id_otroservicio'];?>',
            numautorizacion: '<?php echo $row['numautorizacion'];?>',
            idmipres: '<?php echo $row['idmipres'];?>',
            fechasuministrotecnologia: '<?php echo $row['fechasuministrotecnologia'];?>',
            tipoos: '<?php echo $row['tipoos'];?>',
            codtecnologia: '<?php echo $row['codtecnologia'];?>',
            nomtecnologia: '<?php echo $row['nomtecnologia'];?>',
            cantidados: '<?php echo $row['cantidados'];?>',
            vrunitos: '<?php echo $row['vrunitos'];?>',
            conceptorecaudo: '<?php echo $row['conceptorecaudo'];?>',
            vrservicio: '<?php echo $row['vrservicio'];?>',
            valorpagomoderador: '<?php echo $row['valorpagomoderador'];?>',
            numfevpagomoderador: '<?php echo $row['numfevpagomoderador'];?>'
        };
        otrosServicios.push(servicio);
    </script>
    <?php
}

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