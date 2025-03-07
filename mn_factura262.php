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

        consultas=[];

        function nuevaConsulta(){            
            document.getElementById('nuevaConsulta').style.display='block';
        }

        function cerrar(){
            document.getElementById('nuevaConsulta').style.display='none';
        }

        function validar(){
            error='';
            if(document.form1.fechainicioatencion.value==''){
                error+='Fecha de Atención\n';
            }
            if(document.form1.codconsulta.value==''){
                error+='Código de la Consulta\n';
            }
            if(document.form1.modalidadgruposervicio.value=='0'){
                error+='Modalidad\n';
            }
            if(document.form1.gruposervicio.value=='0'){
                error+='Grupo de Servicio\n';
            }
            if(document.form1.codservicio.value=='0'){
                error+='Código del Servicio\n';
            }
            if(document.form1.finalidadtecnologiasalud.value=='0'){
                error+='Finalidad\n';
            }
            if(document.form1.causamotivoatencion.value=='0'){
                error+='Motivo de Atención\n';
            }
            if(document.form1.coddiagnosticoprincipal.value==''){
                error+='Código Dx. Principal\n';
            }
            if(document.form1.tipodiagnosticoprincipal.value=='0'){
                error+='Tipo Dx. Principal\n';
            }
            if(document.form1.vrservicio.value==''){
                error+='Valor del Servicio\n';
            }
            if(document.form1.conceptorecaudo.value=='0'){
                error+='Concepto de Recaudo\n';
            }
            if(document.form1.valorpagomoderador.value==''){
                error+='Valor Moderador\n';
            }
            
            if(error!=''){
                alert("Para guardar debe complementar la siguiente información:\n\n"+error);
            }
            else{                
                guardarConsulta();                
            }
        }

        function validarEdicion(){
            error='';
            if(document.form1.fechainicioatencionEd.value==''){
                error+='Fecha de Atención\n';
            }
            if(document.form1.codconsultaEd.value==''){
                error+='Código de la Consulta\n';
            }
            if(document.form1.modalidadgruposervicioEd.value=='0'){
                error+='Modalidad\n';
            }
            if(document.form1.gruposervicioEd.value=='0'){
                error+='Grupo de Servicio\n';
            }
            if(document.form1.codservicioEd.value=='0'){
                error+='Código del Servicio\n';
            }
            if(document.form1.finalidadtecnologiasaludEd.value=='0'){
                error+='Finalidad\n';
            }
            if(document.form1.causamotivoatencionEd.value=='0'){
                error+='Motivo de Atención\n';
            }
            if(document.form1.coddiagnosticoprincipalEd.value==''){
                error+='Código Dx. Principal\n';
            }
            if(document.form1.tipodiagnosticoprincipalEd.value=='0'){
                error+='Tipo Dx. Principal\n';
            }
            if(document.form1.vrservicioEd.value==''){
                error+='Valor del Servicio\n';
            }
            if(document.form1.conceptorecaudoEd.value=='0'){
                error+='Concepto de Recaudo\n';
            }
            if(document.form1.valorpagomoderadorEd.value==''){
                error+='Valor Moderador\n';
            }
            
            if(error!=''){
                alert("Para guardar debe complementar la siguiente información:\n\n"+error);
            }
            else{                
                guardarEdicionConsulta();       
            }
        }

        function guardarConsulta(){
            
            $.ajax({
                url: "mn_factura2621.php", // Ruta al archivo PHP
                type: "POST",       // Método HTTP (puede ser "GET" o "POST")
                data: {             // Datos que se envían al script PHP
                    fechainicioatencion: document.form1.fechainicioatencion.value,
                    numautorizacion: document.form1.numautorizacion.value,
                    codconsulta: document.form1.codconsulta.value,
                    modalidadgruposervicio: document.form1.modalidadgruposervicio.value,
                    gruposervicio: document.form1.gruposervicio.value,
                    codservicio: document.form1.codservicio.value,
                    finalidadtecnologiasalud: document.form1.finalidadtecnologiasalud.value,
                    causamotivoatencion: document.form1.causamotivoatencion.value,
                    coddiagnosticoprincipal: document.form1.coddiagnosticoprincipal.value,
                    coddiagnosticorelacionado1: document.form1.coddiagnosticorelacionado1.value,
                    coddiagnosticorelacionado2: document.form1.coddiagnosticorelacionado2.value,
                    coddiagnosticorelacionado3: document.form1.coddiagnosticorelacionado3.value,
                    tipodiagnosticoprincipal: document.form1.tipodiagnosticoprincipal.value,
                    vrservicio: document.form1.vrservicio.value,
                    conceptorecaudo: document.form1.conceptorecaudo.value,
                    valorpagomoderador: document.form1.valorpagomoderador.value,
                    numfevpagomoderador: document.form1.numfevpagomoderador.value,
                    id_factura: <?php echo $_SESSION['gid_factura']; ?>
                },
                success: function(respuesta) {
                    document.getElementById('nuevaConsulta').style.display='none';                                  
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
                url: "mn_factura2622.php", // Ruta al archivo PHP
                type: "POST",       // Método HTTP (puede ser "GET" o "POST")
                data: {             // Datos que se envían al script PHP
                    id_consulta: reg_
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

        function editarConsulta(id_consulta){            
            document.getElementById('editarConsulta').style.display='block';
            for (let consulta of consultas) {                
                if(consulta.id_consulta == id_consulta){  
                    document.getElementById("id_consulta").value = consulta.id_consulta;
                    document.getElementById("fechainicioatencionEd").value = consulta.fechainicioatencion;
                    document.getElementById("numautorizacionEd").value = consulta.numautorizacion;
                    document.getElementById("codconsultaEd").value = consulta.codconsulta;
                    document.getElementById("modalidadgruposervicioEd").value = consulta.modalidadgruposervicio;
                    document.getElementById("gruposervicioEd").value = consulta.gruposervicio;
                    document.getElementById("codservicioEd").value = consulta.codservicio;
                    document.getElementById("finalidadtecnologiasaludEd").value = consulta.finalidadtecnologiasalud;
                    document.getElementById("causamotivoatencionEd").value = consulta.causamotivoatencion;
                    document.getElementById("coddiagnosticoprincipalEd").value = consulta.coddiagnosticoprincipal;
                    document.getElementById("coddiagnosticorelacionado1Ed").value = consulta.coddiagnosticorelacionado1;
                    document.getElementById("coddiagnosticorelacionado2Ed").value = consulta.coddiagnosticorelacionado2;
                    document.getElementById("coddiagnosticorelacionado3Ed").value = consulta.coddiagnosticorelacionado3;
                    document.getElementById("tipodiagnosticoprincipalEd").value = consulta.tipodiagnosticoprincipal;
                    document.getElementById("vrservicioEd").value = consulta.vrservicio;
                    document.getElementById("conceptorecaudoEd").value = consulta.conceptorecaudo;
                    document.getElementById("valorpagomoderadorEd").value = consulta.valorpagomoderador;
                    document.getElementById("numfevpagomoderadorEd").value = consulta.numfevpagomoderador;
                }
            }

        }

        function cerrarEdicion(){
            document.getElementById('editarConsulta').style.display='none';            
        }

        function guardarEdicionConsulta(){
            $.ajax({
                url: "mn_factura2623.php", // Ruta al archivo PHP
                type: "POST",       // Método HTTP (puede ser "GET" o "POST")
                data: {             // Datos que se envían al script PHP
                    id_consulta: document.getElementById("id_consulta").value,                    
                    fechainicioatencion: document.getElementById("fechainicioatencionEd").value,
                    numautorizacion: document.getElementById("numautorizacionEd").value,
                    codconsulta: document.getElementById("codconsultaEd").value,
                    modalidadgruposervicio: document.getElementById("modalidadgruposervicioEd").value,
                    gruposervicio: document.getElementById("gruposervicioEd").value,
                    codservicio: document.getElementById("codservicioEd").value,
                    finalidadtecnologiasalud: document.getElementById("finalidadtecnologiasaludEd").value,
                    causamotivoatencion: document.getElementById("causamotivoatencionEd").value,
                    coddiagnosticoprincipal: document.getElementById("coddiagnosticoprincipalEd").value,
                    coddiagnosticorelacionado1: document.getElementById("coddiagnosticorelacionado1Ed").value,
                    coddiagnosticorelacionado2: document.getElementById("coddiagnosticorelacionado2Ed").value,
                    coddiagnosticorelacionado3: document.getElementById("coddiagnosticorelacionado3Ed").value,
                    tipodiagnosticoprincipal: document.getElementById("tipodiagnosticoprincipalEd").value,
                    vrservicio: document.getElementById("vrservicioEd").value,
                    conceptorecaudo: document.getElementById("conceptorecaudoEd").value,
                    valorpagomoderador: document.getElementById("valorpagomoderadorEd").value,
                    numfevpagomoderador: document.getElementById("numfevpagomoderadorEd").value                    
                },
                success: function(respuesta) {
                    document.getElementById('editarConsulta').style.display='none';
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
<form name='form1' method="post" action="mn_factura262.php">
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
    <br>    
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
        <th class="Th0"><b>Dx. Rel. 1</th>
        <th class="Th0"><b>Dx. Rel. 2</th>
        <th class="Th0"><b>Dx. Rel. 3</th>
        <th class="Th0"><b>Tipo Dx. Principal</th>
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
            
            echo "<tr>";            
            echo "<td class='Td2' align='left'><a href='#' onclick='editarConsulta($rowcon[id_consulta])' title='Editar Registro'><span class='icon-open-book'></span></a></td>";
            echo "<td class='Td2' align='left'><a href='#' onclick=eliminar('$rowcon[id_consulta]') title='Eliminar Registro'><span class='icon-trash'></span></a></td>";
            

            echo "<td class='Td2' align='center'>$rowcon[fechainicioatencion]</td>";
            echo "<td class='Td2' align='center'>$rowcon[numautorizacion]</td>";
            echo "<td class='Td2' align='center'>$rowcon[codconsulta]</td>";
            echo "<td class='Td2' align='center'>";
            $nombreConcepto = traeConcepto($rowcon['modalidadgruposervicio'],8);            
            echo "$nombreConcepto</td>";

            echo "<td class='Td2' align='center'>";
            $nombreConcepto = traeConcepto($rowcon['gruposervicio'],9);            
            echo "$nombreConcepto</td>";

            echo "<td class='Td2' align='center'>";
            $nombreConcepto = traeConcepto($rowcon['codservicio'],10);            
            echo "$nombreConcepto</td>";

            echo "<td class='Td2' align='center'>";
            $nombreConcepto = traeConcepto($rowcon['finalidadtecnologiasalud'],11);
            echo "$nombreConcepto</td>";

            echo "<td class='Td2' align='center'>";
            $nombreConcepto = traeConcepto($rowcon['causamotivoatencion'],12);
            echo "$nombreConcepto</td>";            
            
            echo "<td class='Td2' align='center'>$rowcon[coddiagnosticoprincipal]</td>";
            echo "<td class='Td2' align='center'>$rowcon[coddiagnosticorelacionado1]</td>";
            echo "<td class='Td2' align='center'>$rowcon[coddiagnosticorelacionado2]</td>";
            echo "<td class='Td2' align='center'>$rowcon[coddiagnosticorelacionado3]</td>";

            echo "<td class='Td2' align='center'>";
            $nombreConcepto = traeConcepto($rowcon['tipodiagnosticoprincipal'],13);
            echo "$nombreConcepto</td>";            
            
            echo "<td class='Td2' align='right'>".number_format($rowcon['vrservicio'])."</td>";

            echo "<td class='Td2' align='center'>";
            $nombreConcepto = traeConcepto($rowcon['conceptorecaudo'],7);
            echo "$nombreConcepto</td>"; 

            echo "<td class='Td2' align='right'>".number_format($rowcon['valorpagomoderador'])."</td>";
            echo "<td class='Td2' align='center'>$rowcon[numfevpagomoderador]</td>";

            echo "</tr>";
            $total=$total+$rowcon['vrservicio'];
            $cont++;
        }
        echo "<tr>";
        echo "<td class='Td2' align='right' colspan=15><b>Total </td>";
        echo "<td class='Td2' align='right'><b>".number_format($total)."</td>";
        echo "</tr>";
        echo "</table>";

        ?>
        <br>        
        <div>
            <a href='#' onclick='nuevaConsulta()'><span class='icon-save'></span>Nuevo</a>
        </div>    

        <div class="cajaInput" id="nuevaConsulta">
            <div class="cajaTitulo">
                <cemter><h5>Nueva Consulta</h5></cemter>
            </div>
            
            <div class="cajaContenido">
                <br><span>Fecha de Atención:</span>
                <input type="datetime-local" name="fechainicioatencion" size="16" maxlength="16">
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
                </select>
                <br><span>Código del Servicio:</span>
                <select name="codservicio">
                    <option value="0">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='10'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
                <br><span>Finalidad:</span>
                <select name="finalidadtecnologiasalud">
                    <option value="0">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='11'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
                <br><span>Motivo de Atención:</span>
                <select name="causamotivoatencion">
                    <option value="0">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='12'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
                <br><span>Código Dx. Principal:</span>
                <input type="text" name="coddiagnosticoprincipal" size="4" maxlength="4">
                <br><span>Código Dx. Relacionado 1:</span>
                <input type="text" name="coddiagnosticorelacionado1" size="4" maxlength="4">
                <br><span>Código Dx. Relacionado 2:</span>
                <input type="text" name="coddiagnosticorelacionado2" size="4" maxlength="4">
                <br><span>Código Dx. Relacionado 3:</span>
                <input type="text" name="coddiagnosticorelacionado3" size="4" maxlength="4">
                <br><span>Tipo Dx. Principal:</span>
                <select name="tipodiagnosticoprincipal">
                    <option value="0">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='13'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
                <br><span>Valor del Servicio:</span>
                <input type="text" name="vrservicio" size="10" maxlength="10" value="0">
                <br><span>Concepto de Recaudo:</span>
                <select name="conceptorecaudo">
                    <option value="0">Seleccione</option>
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

        <div class="cajaInput" id="editarConsulta">
            <div class="cajaTitulo">
                <cemter><h5>Editar Consulta</h5></cemter>
            </div>
            
            <div class="cajaContenido">
                <input type="hidden" name="id_consulta" id="id_consulta">
                <br><span>Fecha de Atención:</span>
                <input type="datetime-local" name="fechainicioatencionEd" id="fechainicioatencionEd" size="16" maxlength="16">
                <br><span>Número de Autrización:</span>
                <input type="text" name="numautorizacionEd" id="numautorizacionEd" size="30" maxlength="30">
                <br><span>Código de la Consulta:</span>
                <input type="text" name="codconsultaEd" id="codconsultaEd" size="6" maxlength="6">
                <br><span>Modalidad:</span>
                <select name="modalidadgruposervicioEd" id="modalidadgruposervicioEd">
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
                <select name="gruposervicioEd" id="gruposervicioEd">
                    <option value="0">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='9'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
                <br><span>Código del Servicio:</span>
                <select name="codservicioEd" id="codservicioEd">
                    <option value="0">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='10'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
                <br><span>Finalidad:</span>
                <select name="finalidadtecnologiasaludEd" id="finalidadtecnologiasaludEd">
                    <option value="0">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='11'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
                <br><span>Motivo de Atención:</span>
                <select name="causamotivoatencionEd" id="causamotivoatencionEd">
                    <option value="0">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='12'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
                <br><span>Código Dx. Principal:</span>
                <input type="text" name="coddiagnosticoprincipalEd" id="coddiagnosticoprincipalEd" size="4" maxlength="4">
                <br><span>Código Dx. Relacionado 1:</span>
                <input type="text" name="coddiagnosticorelacionado1Ed" id="coddiagnosticorelacionado1Ed" size="4" maxlength="4">
                <br><span>Código Dx. Relacionado 2:</span>
                <input type="text" name="coddiagnosticorelacionado2Ed" id="coddiagnosticorelacionado2Ed" size="4" maxlength="4">
                <br><span>Código Dx. Relacionado 3:</span>
                <input type="text" name="coddiagnosticorelacionado3Ed" id="coddiagnosticorelacionado3Ed" size="4" maxlength="4">
                <br><span>Tipo Dx. Principal:</span>
                <select name="tipodiagnosticoprincipalEd" id="tipodiagnosticoprincipalEd">
                    <option value="0">Seleccione</option>
                    <?php
                    $consultades=$link->query("select dg.valor_det ,dg.descripcion_det 
                        from detalle_grupo dg 
                        where dg.id_grupo ='13'");
                    while($rowdes=$consultades->fetch_array()){                
                        echo "<option value='$rowdes[valor_det]'>".substr($rowdes['descripcion_det'],0,40)."</option>";
                    }
                    ?>
                </select>
                <br><span>Valor del Servicio:</span>
                <input type="text" name="vrservicioEd" id="vrservicioEd" size="10" maxlength="10" value="0">
                <br><span>Concepto de Recaudo:</span>
                <select name="conceptorecaudoEd" id="conceptorecaudoEd">
                    <option value="0">Seleccione</option>
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
        consulta={
            id_consulta: <?php echo $row['id_consulta']; ?>,
            fechainicioatencion: '<?php echo $row['fechainicioatencion']; ?>',
            numautorizacion: '<?php echo $row['numautorizacion']; ?>',
            codconsulta: '<?php echo $row['codconsulta']; ?>',
            modalidadgruposervicio: '<?php echo $row['modalidadgruposervicio']; ?>',
            gruposervicio: '<?php echo $row['gruposervicio']; ?>',
            codservicio: '<?php echo $row['codservicio']; ?>',
            finalidadtecnologiasalud: '<?php echo $row['finalidadtecnologiasalud']; ?>',
            causamotivoatencion: '<?php echo $row['causamotivoatencion']; ?>',
            coddiagnosticoprincipal: '<?php echo $row['coddiagnosticoprincipal']; ?>',
            coddiagnosticorelacionado1: '<?php echo $row['coddiagnosticorelacionado1']; ?>',
            coddiagnosticorelacionado2: '<?php echo $row['coddiagnosticorelacionado2']; ?>',
            coddiagnosticorelacionado3: '<?php echo $row['coddiagnosticorelacionado3']; ?>',
            tipodiagnosticoprincipal: '<?php echo $row['tipodiagnosticoprincipal']; ?>',
            vrservicio: '<?php echo $row['vrservicio']; ?>',
            conceptorecaudo: '<?php echo $row['conceptorecaudo']; ?>',
            valorpagomoderador: '<?php echo $row['valorpagomoderador']; ?>',
            numfevpagomoderador: '<?php echo $row['numfevpagomoderador']; ?>'
        };
        consultas.push(consulta);        
    </script>
    <?php
}


function traeConcepto($val_,$id_grupo){
    $link=conectarbd();
    $consultadet=$link->query("select dg.valor_det ,dg.descripcion_det 
        from detalle_grupo dg 
        where dg.id_grupo ='$id_grupo' and dg.valor_det='$val_'");
    $rowdet=$consultadet->fetch_array();
    return $rowdet['descripcion_det'];
}


?>