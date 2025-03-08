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

        function nuevoServicio(){            
            document.getElementById('nuevoServicio').style.display='block';
        }

        function cerrar(){
            document.getElementById('nuevoServicio').style.display='none';
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
            /*if(error!=''){
                alert("Para guardar debe complementar la siguiente información:\n\n"+error);
            }
            else{                */
                guardarServicio();                
            //}
        }

        function guardarServicio(){
            /*alert(document.form1.numautorizacion.value);
            alert(document.form1.idmipres.value);
            alert(document.form1.fechasuministrotecnologia.value);
            alert(document.form1.tipoos.value);
            alert(document.form1.codtecnologia.value);
            alert(document.form1.nomtecnologia.value);
            alert(document.form1.cantidados.value);                        
            alert(document.form1.vrunitos.value);                
            alert(document.form1.conceptorecaudo.value);
            alert(document.form1.conceptorecaudo.value);
            alert(document.form1.numfevpagomoderador.value);*/
            
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
                    valorpagomoderador: document.form1.conceptorecaudo.value,
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

        /*function eliminar_(tipo_,reg_){
            var url_='';
            if(confirm("Desea eliminar este servicio?")){
                //url_="fac_3borrarips.php?reg="+reg_+"&tipo="+tipo_;
                url_="mn_factura2632.php?reg="+reg_+"&tipo="+tipo_;
                //window.open(url_);
                window.location.href = url_;                
            }
        }*/


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
            //echo "<input type='hidden' name='id_otroservicio' value='$rowcon[id_otroservicio]'>";
            echo "<tr>";
            
            echo "<td class='Td2' align='left'></td>";
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
            <br><span>MIPRES</span>
            <input type="text" name="idmipres" size="11" maxlength="11" value="0">
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

</form>
</body>
</html>


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