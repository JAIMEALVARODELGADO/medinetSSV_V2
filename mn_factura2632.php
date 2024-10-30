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
        function regresar(ret_){
            //alert(ret_);
            window.open(ret_) 
        }

    /*    function continuar(msg_){
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
                form1.submit();
            }
        }

        function eliminar(tipo_,reg_){
            var url_='';
            if(confirm("Desea eliminar este servicio?")){
                //url_="fac_3borrarips.php?reg="+reg_+"&tipo="+tipo_;
                url_="mn_factura2632.php?reg="+reg_+"&tipo="+tipo_;
                window.open(url_);
            }
        }*/


    </script>
<?php
require("mn_funciones.php");
//require("mn_menu.php");
$link=conectarbd();

//Aqui consulto la factura
/*$consultafac = "select ef.id_factura , ef.numero_fac ,ef.numero_fac,ef.fecha_fac ,
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
}*/
   

$tipo=$_GET['tipo'];
$reg=$_GET['reg'];


switch ($tipo){
    case "C":
        $actualiza="DELETE FROM nrconsulta WHERE id_consulta='$reg'";
        $retorna="fac_3muestraripscons.php";
        break;
    case "P":
        $actualiza="DELETE FROM nrprocedimiento WHERE id_procedimiento='$reg'";
        $retorna="fac_3muestraripsproc.php";
        break;
    case "M":
        $actualiza="DELETE FROM nrmedicamento WHERE id_medicamento='$reg'";
        $retorna="fac_3muestraripsmedi.php";
        break;
    case "O":
        $actualiza="DELETE FROM nrotroservicios WHERE id_otroservicio='$reg'";
        $retorna="mn_factura263.php";
        break;
    case "U":
        $actualiza="DELETE FROM nrurgencias WHERE id_urgencias='$reg'";
        $retorna="fac_3muestraripsurge.php";
        break;
    case "H":
        $actualiza="DELETE FROM nrhospital WHERE id_hospital='$reg'";
        $retorna="fac_3muestraripshosp.php";
        break;
    case "N":
        $actualiza="DELETE FROM nrnacidos WHERE id_nacidos='$reg'";
        $retorna="fac_3muestraripsrnac.php";
        break;
}
//echo $actualiza;
$consulta=$link->query($actualiza);


?>
<body onload="regresar('<?php echo $retorna;?>')">
</body>
</html>
