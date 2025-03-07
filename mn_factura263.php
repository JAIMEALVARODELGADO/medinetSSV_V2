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

        function activar(reg_){
            var comando='';
            comando="form1.chk"+reg_+".checked";            
            if(eval(comando)==true){                
                comando="form1.numautorizacion"+reg_+".disabled=false";
                eval(comando);
                comando="form1.idmipres"+reg_+".disabled=false";
                eval(comando);
                comando="form1.fechasuministrotecnologia"+reg_+".disabled=false";
                eval(comando);
                comando="form1.tipoos"+reg_+".disabled=false";
                eval(comando);
                comando="form1.codtecnologia"+reg_+".disabled=false";
                eval(comando);
                comando="form1.nomtecnologia"+reg_+".disabled=false";
                eval(comando);
                comando="form1.conceptorecaudo"+reg_+".disabled=false";
                eval(comando);
                comando="form1.valorpagomoderador"+reg_+".disabled=false";
                eval(comando);
                comando="form1.numfevpagomoderador"+reg_+".disabled=false";
                eval(comando);
            }
            else{
                comando="form1.numautorizacion"+reg_+".disabled=true";
                eval(comando);
                comando="form1.idmipres"+reg_+".disabled=true";
                eval(comando);
                comando="form1.fechasuministrotecnologia"+reg_+".disabled=true";
                eval(comando);
                comando="form1.tipoos"+reg_+".disabled=true";
                eval(comando);
                comando="form1.codtecnologia"+reg_+".disabled=true";
                eval(comando);
                comando="form1.nomtecnologia"+reg_+".disabled=true";
                eval(comando);
                comando="form1.conceptorecaudo"+reg_+".disabled=true";
                eval(comando);
                comando="form1.valorpagomoderador"+reg_+".disabled=true";
                eval(comando);
                comando="form1.numfevpagomoderador"+reg_+".disabled=true";
                eval(comando);
            }
        }

        function validar(cont_){
            var i=0,comando='',error='';
            for(i=0;i<cont_;i++){    
                comando="form1.fechasuministrotecnologia"+i+".value"
                if(eval(comando)==''){error=error+"Fecha de suministro "+i+"\n";}
                comando="form1.tipoos"+i+".value"
                if(eval(comando)==''){error=error+"Tipo "+i+"\n";}
                comando="form1.codtecnologia"+i+".value"
                if(eval(comando)==''){error=error+"Código del servicio "+i+"\n";}
                comando="form1.nomtecnologia"+i+".value"
                if(eval(comando)==''){error=error+"Nombre del servicio "+i+"\n";}
                comando="form1.conceptorecaudo"+i+".value"
                if(eval(comando)==''){error=error+"Concepto del recaudo "+i+"\n";}
            }
            if(error!=''){
                alert("Para guardar debe complementar la siguiente información:\n\n"+error);
            }
            else{
                activartodos();
                form1.submit();
            }
        }

        function activartodos(){            
            var i=0,comando='';
            for(i=0;i<cont_;i++){    
                comando="form1.numautorizacion"+i+".disabled=false";                
                eval(comando);                
                comando="form1.idmipres"+i+".disabled=false";
                eval(comando);
                comando="form1.fechasuministrotecnologia"+i+".disabled=false";
                eval(comando);
                comando="form1.tipoos"+i+".disabled=false";
                eval(comando);
                comando="form1.codtecnologia"+i+".disabled=false";
                eval(comando);
                comando="form1.nomtecnologia"+i+".disabled=false";
                eval(comando);
                comando="form1.conceptorecaudo"+i+".disabled=false";
                eval(comando);
                comando="form1.valorpagomoderador"+i+".disabled=false";
                eval(comando);
                comando="form1.numfevpagomoderador"+i+".disabled=false";
                eval(comando);
                /*comando="form1.cantidados"+i+".disabled=false";
                eval(comando);
                comando="form1.vrunitos"+i+".disabled=false";
                eval(comando);
                comando="form1.vrservicio"+i+".disabled=false";
                eval(comando);*/
            }
        }

        function eliminar_(tipo_,reg_){
            var url_='';
            if(confirm("Desea eliminar este servicio?")){
                //url_="fac_3borrarips.php?reg="+reg_+"&tipo="+tipo_;
                url_="mn_factura2632.php?reg="+reg_+"&tipo="+tipo_;
                //window.open(url_);
                window.location.href = url_;                
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
<form name='form1' method="post" action="mn_factura2631.php">
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
        $cont=0;
        $total=0;
        $consultacon="SELECT otr.id_otroservicio,otr.numautorizacion,otr.idmipres,otr.fechasuministrotecnologia,otr.tipoos,otr.codtecnologia,otr.nomtecnologia,otr.cantidados,otr.tipodocumentoidentificacion,otr.numdocumentoidentificacion,otr.vrunitos,otr.vrservicio,otr.conceptorecaudo,otr.valorpagomoderador,otr.numfevpagomoderador,otr.consecutivo,otr.id_factura,otr.id_detalle 
        FROM nrotroservicios AS otr
        WHERE otr.id_factura='$_SESSION[gid_factura]'";
        //echo $consultacon;
        $consultacon=$link->query($consultacon);

        while($rowcon=$consultacon->fetch_array()){
            $nomvar="id_otroservicio".$cont;
            echo "<input type='hidden' name='$nomvar' value='$rowcon[id_otroservicio]'>";
            echo "<tr>";
            $nomvar="chk".$cont;
            echo "<td class='Td2' align='left'><input type='checkbox' name='$nomvar' onclick='activar($cont)'></td>";
            echo "<td class='Td2' align='left'><a href='#' onclick=eliminar('O','$rowcon[id_otroservicio]') title='Eliminar Registro'><span class='icon-trash'></span></a></td>";

            $nomvar="numautorizacion".$cont;
            echo "<td class='Td2' align='center'><input type='text' name='$nomvar' size='30' maxlength='30' value='$rowcon[numautorizacion]' disabled></td>";

            $nomvar="idmipres".$cont;
            echo "<td class='Td2' align='center'><input type='text' name='$nomvar' size='15' maxlength='15' value='$rowcon[idmipres]' disabled></td>";
            
            $nomvar="fechasuministrotecnologia".$cont;
            echo "<td class='Td2' align='center'><input type='text' name='$nomvar' size='16' maxlength='16' value='$rowcon[fechasuministrotecnologia]' disabled></td>";

            $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                from detalle_grupo dg 
                where dg.id_grupo ='6'");
            $nomvar="tipoos".$cont;
            echo "<td class='Td2' align='center'>
            <select name='$nomvar' disabled='true'>";
            while($rowdes=$consultades->fetch_array()){                
                echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
            }
            echo "</select>";
            $tipops=$rowcon['tipoos'];
            ?>
            <script language='javascript'>activasel('<?php echo $nomvar;?>','<?php echo $tipops;?>');</script>
            <?php
            echo "</td>";

            $nomvar="codtecnologia".$cont;
            echo "<td class='Td2' align='center'><input type='text' name='$nomvar' size='20' maxlength='20' value='$rowcon[codtecnologia]' disabled></td>";

            $nomvar="nomtecnologia".$cont;
            echo "<td class='Td2' align='center'><input type='text' name='$nomvar' size='60' maxlength='60' value='$rowcon[nomtecnologia]' disabled></td>";

            $nomvar="cantidados".$cont;
            echo "<td class='Td2' align='center'><input type='text' name='$nomvar' size='5' maxlength='5' value='$rowcon[cantidados]' disabled></td>";

            $nomvar="vrunitos".$cont;
            echo "<td class='Td2' align='right'><input type='text' name='$nomvar' size='15' maxlength='15' value='".number_format($rowcon['vrunitos'])."' disabled></td>";

            $nomvar="vrservicio".$cont;
            echo "<td class='Td2' align='right'><input type='text' name='$nomvar' size='15' maxlength='15' value='".number_format($rowcon['vrservicio'])."' disabled></td>";

            $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                from detalle_grupo dg 
                where dg.id_grupo ='7'");
            $nomvar="conceptorecaudo".$cont;
            echo "<td class='Td2' align='center'><select name='$nomvar' disabled>";
            while($rowdes=$consultades->fetch_array()){                
                echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
            }
            echo "</select>";
            echo "</td>";

            $conceptorecaudo=$rowcon['conceptorecaudo'];
            ?>
            <script language='javascript'>activasel('<?php echo $nomvar;?>','<?php echo $conceptorecaudo;?>');</script>
            <?php

            $nomvar="valorpagomoderador".$cont;
            echo "<td class='Td2' align='right'><input type='text' name='$nomvar' size='10' maxlength='10' value='".number_format($rowcon['valorpagomoderador'])."' disabled></td>";

            $nomvar="numfevpagomoderador".$cont;
            echo "<td class='Td2' align='center'><input type='text' name='$nomvar' size='15' maxlength='20' value='$rowcon[numfevpagomoderador]' disabled></td>";

            echo "</tr>";
            $total=$total+$rowcon['vrservicio'];
            $cont++;
        }
        echo "<tr>";
        echo "<td class='Td2' align='right' colspan=10><b>Total </td>";
        echo "<td class='Td2' align='right'><b>".number_format($total)."</td>";
        echo "</tr>";
        echo "</table>";

        ?>
        <br><br>
        <div class='Td6'>
        <center><a href='#' onclick='validar(<?php echo $cont;?>)'><span class='icon-save'></span>Guardar</a></center>
        </div>
        <input type='hidden' name='cont' value='<?php echo $cont-1;?>'>

</form>
</body>
</html>

<script>
    var cont_ = <?php echo $cont; ?>;    
</script>