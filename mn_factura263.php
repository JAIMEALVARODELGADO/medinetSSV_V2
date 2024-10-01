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

        function activar(){
            var comando='';            
            if(form1.tipodocumento.disabled == true){
                form1.tipodocumento.disabled=false;}
            else{
                form1.tipodocumento.disabled=true;}
            if(form1.numdocumento.disabled == true){
                form1.numdocumento.disabled=false;}
            else{
                form1.numdocumento.disabled=true;}
            if(form1.tipousuario.disabled == true){
                form1.tipousuario.disabled=false;}
            else{
                form1.tipousuario.disabled=true;}
            if(form1.fechanacimiento.disabled == true){
                form1.fechanacimiento.disabled=false;}
            else{
                form1.fechanacimiento.disabled=true;}
            if(form1.codsexo.disabled == true){
                form1.codsexo.disabled=false;}
            else{
                form1.codsexo.disabled=true;}    
            if(form1.codpaisresidencia.disabled == true){
                form1.codpaisresidencia.disabled=false;}
            else{
                form1.codpaisresidencia.disabled=true;}
            if(form1.codmunicipioresidencia.disabled == true){
                form1.codmunicipioresidencia.disabled=false;}
            else{
                form1.codmunicipioresidencia.disabled=true;}
            if(form1.codzonaresidencia.disabled == true){
                form1.codzonaresidencia.disabled=false;}
            else{
                form1.codzonaresidencia.disabled=true;}
            if(form1.incapacidad.disabled == true){
                form1.incapacidad.disabled=false;}
            else{
                form1.incapacidad.disabled=true;}
            if(form1.codpaisorigen.disabled == true){
                form1.codpaisorigen.disabled=false;}
            else{
                form1.codpaisorigen.disabled=true;}
        }

        function validar(cont_){      
            var comando='',error='';            
            if(form1.tipodocumento.disabled == false){
                if(form1.tipodocumento.value==''){
                    error=error+"Tipo de documento \n";
                }    
                if(form1.numdocumento.value==''){        
                    error=error+"Número de documento \n";
                }
                if(form1.tipousuario.value==''){        
                    error=error+"Tipo de usuario \n";
                }
                if(form1.fechanacimiento.value==''){        
                    error=error+"Fecha de nacimiento \n";
                }
                if(form1.codsexo.value==''){        
                    error=error+"Sexo \n";
                }
                if(form1.codpaisresidencia.value==''){
                    error=error+"País de residencia \n";
                }
                if(form1.codpaisresidencia.value=='170' && form1.codmunicipioresidencia.value==''){
                    error=error+"Municipio de residencia \n";        
                }
                if(form1.codpaisresidencia.value!='170' && form1.codmunicipioresidencia.value!=''){
                    form1.codmunicipioresidencia.value='';
                }
                if(form1.codzonaresidencia.value==''){
                    error=error+"Zona de residencia \n";
                }
                if(form1.incapacidad.value==''){
                    error=error+"Incapacidad \n";
                }
                if(form1.codpaisorigen.value==''){
                    error=error+"País de origen \n";
                }
            }
            else{
                error=error+"No hay cambios para guardar... \n";
            }


            if(error!=''){
                alert("Para guardar debe complementar la siguiente información:\n\n"+error);
            }
            else{
                form1.submit();
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
<form name='form1' method="post" action="mn_factura2611.php">
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
//********************************* */
    ?>
    <table class="Tbl0" border='1'>
        <th class="Th0"colspan='2'><b>Sel</td>
        <th class="Th0"><b>Autorización</td>
        <th class="Th0"><b>MIPRES</td>
        <th class="Th0"><b>Fecha Suministro</td>
        <th class="Th0"><b>Tipo</td>
        <th class="Th0"><b>Código</td>
        <th class="Th0"><b>Nombre</td>
        <th class="Th0"><b>Cantidad</td>
        <th class="Th0"><b>Valor Unitario</td>  
        <th class="Th0"><b>Valor Total</td>  
        <th class="Th0"><b>Concepto Recaudo</td>
        <th class="Th0"><b>Vr. Moderador</td>
        <th class="Th0"><b>FEV Moderador</td>
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

            $consultades=sql_query("SELECT valo_des,nomb_des FROM destipos WHERE codt_des='H8'");
            $nomvar="tipoos".$cont;
            echo "<td class='Td2' align='center'><select name='$nomvar' disabled>";
            while($rowdes=mysql_fetch_array($consultades)){
                echo "<option value='$rowdes[valo_des]'>$rowdes[valo_des] ".substr($rowdes[nomb_des],0,40);
            }
            echo "</select>";
            echo "</td>";



        }
        //********************************* */
        ?>
        
        






    



</form>
</body>
</html>
