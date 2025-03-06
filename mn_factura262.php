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
        /*function continuar(msg_){            
            document.form1.submit();
        }

        function activasel(var_,val_){
            var comando="form1."+var_+".value='"+val_+"'";            
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
        }*/

        /*function activartodos(){            
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
           /* }
        }*/

        /*function eliminar(tipo_,reg_){
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

    echo "<span class='h5'>Consultas</span>";

    ?>
    <table class="Tbl0" border='1'>
        <th class="Th0"colspan='2'><b>Sel</th>
        <th class="Th0"><b>Fecha Aten.</th>
        <th class="Th0"><b>Autorización</th>
        <th class="Th0"><b>Código Cons.</th>
        <th class="Th0"><b>Modalidad</th>
        <th class="Th0"><b>Grupo</th>
        <th class="Th0"><b>Cod. Servicio</th>
        <th class="Th0"><b>Finalidad</th>
        <th class="Th0"><b>Motivo de Atención</th>  
        <th class="Th0"><b>Dx. Principal</th>  
        <th class="Th0"><b>Tipo Dx.</th>
        <th class="Th0"><b>Dx.Relacionado</th>
        <th class="Th0"><b>Valor</th>
        <th class="Th0"><b>Concepto Recaudo</th>
        <th class="Th0"><b>Vr. Moderador</th>
        <th class="Th0"><b>FEV Moderador</th>
        <?php
        $cont=0;
        $total=0;
        $consultacon="SELECT con.id_consulta,con.fechainicioatencion,con.numautorizacion,con.codconsulta,con.modalidadgruposervicio,con.gruposervicio,con.codservicio,con.finalidadtecnologiasalud,con.causamotivoatencion,con.coddiagnosticoprincipal,con.coddiagnosticorelacionado1,con.coddiagnosticorelacionado2,con.coddiagnosticorelacionado3,con.tipodiagnosticoprincipal,con.vrservicio,con.conceptorecaudo,con.valorpagomoderador,con.numfevpagomoderador,con.consecutivo,con.id_factura,con.id_detalle
        FROM nrconsulta AS con
        WHERE con.id_factura='$_SESSION[gid_factura]'";
        //echo $consultacon;
        $consultacon=$link->query($consultacon);

        while($rowcon=$consultacon->fetch_array()){
            $nomvar="id_consulta".$cont;
            echo "<input type='hidden' name='$nomvar' value='$rowcon[id_consulta]'>";
            echo "<tr>";
            $nomvar="chk".$cont;
            echo "<td class='Td2' align='left'><input type='checkbox' name='$nomvar' onclick='activar($cont)'></td>";
            echo "<td class='Td2' align='left'><a href='#' onclick=eliminar('O','$rowcon[id_otroservicio]') title='Eliminar Registro'><span class='icon-trash'></span></a></td>";

            $nomvar="fechainicioatencion".$cont;
            echo "<td class='Td2' align='center'><input type='text' name='$nomvar' size='30' maxlength='30' value='$rowcon[numautorizacion]' disabled></td>";

            $nomvar="numautorizacion".$cont;
            echo "<td class='Td2' align='center'><input type='text' name='$nomvar' size='15' maxlength='15' value='$rowcon[codconsulta]' disabled></td>";
            
            $nomvar="codconsulta".$cont;
            echo "<td class='Td2' align='center'><input type='text' name='$nomvar' size='16' maxlength='16' value='$rowcon[fechasuministrotecnologia]' disabled></td>";

            $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                from detalle_grupo dg 
                where dg.id_grupo ='6'");
            $nomvar="modalidadgruposervicio".$cont;
            echo "<td class='Td2' align='center'>
            <select name='$nomvar' disabled='true'>";
            while($rowdes=$consultades->fetch_array()){                
                echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
            }
            echo "</select>";

            $modalidadgruposervicio=$rowcon['modalidadgruposervicio'];
            ?>
            <script language='javascript'>activasel('<?php echo $nomvar;?>','<?php echo $modalidadgruposervicio;?>');</script>
            <?php
            echo "</td>";            
                        
            $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                from detalle_grupo dg 
                where dg.id_grupo ='6'");

            $nomvar="gruposervicio".$cont;
            echo "<td class='Td2' align='center'>
            <select name='$nomvar' disabled='true'>";
            while($rowdes=$consultades->fetch_array()){                
                echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
            }
            echo "</select>";

            $gruposervicio=$rowcon['gruposervicio'];
            ?>
            <script language='javascript'>activasel('<?php echo $nomvar;?>','<?php echo $modalidadgruposervicio;?>');</script>
            <?php
            echo "</td>";                        

            $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                from detalle_grupo dg 
                where dg.id_grupo ='6'");
            $nomvar="codservicio".$cont;
            echo "<td class='Td2' align='center'>
            <select name='$nomvar' disabled='true'>";
            while($rowdes=$consultades->fetch_array()){                
                echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
            }
            echo "</select>";

            $codservicio=$rowcon['codservicio'];
            ?>
            <script language='javascript'>activasel('<?php echo $nomvar;?>','<?php echo $codservicio;?>');</script>
            <?php
            echo "</td>";


            $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                from detalle_grupo dg 
                where dg.id_grupo ='6'");
            $nomvar="finalidadtecnologiasalud".$cont;
            echo "<td class='Td2' align='center'>
            <select name='$nomvar' disabled='true'>";
            while($rowdes=$consultades->fetch_array()){                
                echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
            }
            echo "</select>";

            $finalidadtecnologiasalud=$rowcon['finalidadtecnologiasalud'];
            ?>
            <script language='javascript'>activasel('<?php echo $nomvar;?>','<?php echo $finalidadtecnologiasalud;?>');</script>
            <?php
            echo "</td>";

            $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                from detalle_grupo dg 
                where dg.id_grupo ='6'");
            $nomvar="causamotivoatencion".$cont;
            echo "<td class='Td2' align='center'>
            <select name='$nomvar' disabled='true'>";
            while($rowdes=$consultades->fetch_array()){                
                echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
            }
            echo "</select>";

            $causamotivoatencion=$rowcon['causamotivoatencion'];
            ?>
            <script language='javascript'>activasel('<?php echo $nomvar;?>','<?php echo $causamotivoatencion;?>');</script>
            <?php
            echo "</td>";            
            $nomvar="coddiagnosticoprincipal".$cont;
            echo "<td class='Td2' align='center'>
            <input type='text' name='$nomvar' size='4' maxlength='4' value='$rowcon[coddiagnosticoprincipal]' disabled>";
            $nomvar="coddiagnosticorelacionado1".$cont;
            echo "<br><input type='text' name='$nomvar' size='4' maxlength='4' value='$rowcon[coddiagnosticorelacionado1]' disabled>";
            $nomvar="coddiagnosticorelacionado2".$cont;
            echo "<br><input type='text' name='$nomvar' size='4' maxlength='4' value='$rowcon[coddiagnosticorelacionado2]' disabled>";
            $nomvar="coddiagnosticorelacionado3".$cont;
            echo "<br><input type='text' name='$nomvar' size='4' maxlength='4' value='$rowcon[coddiagnosticorelacionado3]' disabled>
            </td>";            

            $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                from detalle_grupo dg 
                where dg.id_grupo ='6'");
            $nomvar="tipodiagnosticoprincipal".$cont;
            echo "<td class='Td2' align='center'>
            <select name='$nomvar' disabled='true'>";
            while($rowdes=$consultades->fetch_array()){                
                echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
            }
            echo "</select>";

            $tipodiagnosticoprincipal=$rowcon['tipodiagnosticoprincipal'];
            ?>
            <script language='javascript'>activasel('<?php echo $nomvar;?>','<?php echo $tipodiagnosticoprincipal;?>');</script>
            <?php
            echo "</td>";
            
            $nomvar="vrservicio".$cont;
            echo "<td class='Td2' align='right'><input type='text' name='$nomvar' size='10' maxlength='10' value='".number_format($rowcon['vrservicio'])."' disabled></td>";

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

        <div class="cajaInput">
            <div class="cajaTitulo">
                <cemter><h5>Nueva Consulta</h5></cemter>
            </div>
            
            <div class="cajaContenido">
                <br><span>Fecha de Atención:</span>
                <input type="text" name="fechainicioatencion" size="10" maxlength="10">
                <br><span>Número de Autrización:</span>
                <input type="text" name="numautorizacion" size="30" maxlength="30">
                <br><span>Código de la Consulta:</span>
                <input type="text" name="codconsulta" size="6" maxlength="6">
                <br><span>Modalidad:</span>
                <select name="modalidadgruposervicio">
                    <option value="0">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='8'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
                <br><span>Grupo de Servicio:</span>
                <select name="gruposervicio">
                    <option value="0">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='9'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>



            </div>                
        </div>

</form>
</body>
</html>

<script>
    var cont_ = <?php echo $cont; ?>;    
</script>