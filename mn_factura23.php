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
    </script>
<?php
require("mn_funciones.php");
//require("pp_menu.php");
$link=conectarbd();
$id_factura=$_GET['id_factura'];

//Aqui consulto el numero consecutivo de la factura
$consultanum="SELECT numero_fac FROM entidad";
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
    $link->query($sql_);
    //generarRips($id_factura);
    if($link->affected_rows > 0){
        $msg="Registro guardado con exito";
        generarRips($id_factura);
    }
    else{$msg="Registro no guardado";}
}
?>
<body onload="continuar('<?php echo $msg;?>')">
<form name='form1' method="post" action="mn_factura2.php">
    <?php 
    echo "<br>".$msg;
    echo "<input type='hidden' name='id_factura' value='$id_factura'>";
    ?>
</form>
</body>
</html>


<?php
function generarRips($idfac_){
    $link_=conectarbd();

    //Aqui se trae la información del usuario
    $consultausu="select p.tipo_iden ,p.identificacion,dg.valor_det as tipo_usuario,p.fecha_nacim,p.sexo,170 as codpaisresidencia,
    pac.mun_reside,pac.zona_reside 
    from encabezado_factura ef
    inner join persona p ON p.id_persona = ef.id_persona 
    inner join paciente pac on pac.id_persona = p.id_persona 
    inner join detalle_grupo dg on dg.codi_det = pac.tipo_usuario 
    where ef.id_factura ='$idfac_'";
    //echo "<br>".$consultausu;
    
    $consultausu=$link_->query($consultausu);
    if($consultausu->num_rows<>0){
        $row=$consultausu->fetch_array();
        $consultanrusu="SELECT COUNT(*) as total FROM nrusuario WHERE id_factura='$idfac_'";
        //echo "<br>".$consultanrusu;
        $consultanrusu=$link_->query($consultanrusu);
        $rowusu=$consultanrusu->fetch_array();        

        if($rowusu['total'] == 0){
            
            if($row['sexo']=='F'){
                $sexo='M';
            }
            else{
                $sexo='M';
            }
            
            $sql="INSERT INTO nrusuario(tipo_documento,numdocumento,tipousuario,fechanacimiento,codsexo,codpaisresidencia,codmunicipioresidencia,codzonaresidencia,incapacidad,codpaisorigen,id_factura)
            VALUES('$row[tipo_iden]','$row[identificacion]','$row[tipo_usuario]','$row[fecha_nacim]','$sexo','$row[codpaisresidencia]','$row[mun_reside]','$row[zona_reside]','NO','$row[codpaisresidencia]','$idfac_')";
            //echo $sql;
            $link_->query($sql);            
        }

    }
    
    //Aqui se consulta el detalle de la factura
    $consultadet="select df.id_detalle,df.id_factura, ef.fecha_ini,ef.autoriza_fac ,df.cantidad_det ,df.valor_unitario,
    ef.fecha_ini,ef.autoriza_fac,
    p.tipo_iden ,p.identificacion 
    from detalle_factura df 
    inner join encabezado_factura ef on ef.id_factura =df.id_factura 
    inner join persona p on p.id_persona = ef.id_persona
    where df.id_factura ='$idfac_'";
    //echo "<br>".$consultadet;
    $consultadet=$link_->query($consultadet);
    if($consultadet->num_rows<>0){
        while($rowdet=$consultadet->fetch_array()){
            //echo "<br>".$rowdet['id_detalle'];
            $objDetalle = new Detalle();
            $objDetalle->fechainicioatencion=$rowdet['fecha_ini'];
            $objDetalle->numautorizacion=$rowdet['autoriza_fac'];
            /*$objDetalle->iden_tco=$rowdet[iden_tco];
            $objDetalle->servi_dfa=$rowdet[servi_dfa];
            $objDetalle->coddiagnosticoprincipal=$rowdet[cod_cie10];*/
            $objDetalle->tipodocumentoidentificacion=$rowdet['tipo_iden'];
            $objDetalle->numdocumentoidentificacion=$rowdet['identificacion'];
            $objDetalle->vrservicio=$rowdet['valor_unitario'];
            $objDetalle->id_factura=$idfac_;
            $objDetalle->id_detalle=$rowdet['id_detalle'];
            $objDetalle->cantidad=$rowdet['cantidad_det'];
            /*$objDetalle->id_ing=$rowdet[id_ing];*/
            //echo "<br>".$objDetalle->fechainicioatencion;
              
            $objDetalle->crearOtrosServicios($link_);
            /*$objDetalle->crearEstancia();
            $objDetalle->crearEstancia2();*/

        }
    }
    
    

}

class Detalle{
    public $fechainicioatencion;
    public $numautorizacion;
    public $iden_tco;
    public $servi_dfa;
    public $coddiagnosticoprincipal;
    public $tipodocumentoidentificacion;
    public $numdocumentoidentificacion;
    public $vrservicio;
    public $conceptorecaudo;
    public $valorpagomoderador;
    public $numfevpagomoderador;
    public $consecutivo;
    public $id_factura;
    public $id_detalle;
    public $cantidad;
    public $id_ing;
  
    function crearOtrosServicios($link_){
        //Aqui consulto el codigo del OS
        $consultaos="select c.codigo_cups ,c.descripcion_cups 
        from detalle_factura df 
        inner join cups c on c.id_cups = df.id_cups 
        where id_detalle ='$this->id_detalle'";
        //echo "<br><br>".$consultaos;
            
        $consultaos=$link_->query($consultaos);
        if($consultaos->num_rows<>0){            
            $rowos=$consultaos->fetch_array();
            $codigo=$rowos['codigo_cups'];
            $descripcion=substr(trim($rowos['descripcion_cups']),0,60);
        }        
    
        //Aqui consulto el ultimo consecutivo
        $consultaconsecutivo="SELECT MAX(n.consecutivo) as consecutivo 
        FROM nrotroservicios n WHERE n.id_factura ='$this->id_factura'";
        //echo "<br><br>".$consultaconsecutivo;

        $consultaconsecutivo=$link_->query($consultaconsecutivo);

        $rowconsecutivo=$consultaconsecutivo->fetch_array();
        $consecutivo=$rowconsecutivo['consecutivo'];
        $consecutivo++;
        //echo "<br>Consecutivo ".$consecutivo;      
    
        $vrUnitario=$this->vrservicio;
        $vrTotal=$this->cantidad*$this->vrservicio;
    
        $sql="INSERT INTO nrotroservicios(numautorizacion,idmipres,fechasuministrotecnologia,tipoos,codtecnologia,nomtecnologia,cantidados,tipodocumentoidentificacion,numdocumentoidentificacion,vrunitos,vrservicio,conceptorecaudo,valorpagomoderador,numfevpagomoderador,consecutivo,id_factura,id_detalle)
        VALUES('$this->numautorizacion'
        ,'0'
        ,'$this->fechainicioatencion'
        ,''
        ,'$codigo'
        ,'$descripcion'
        ,'$this->cantidad'
        ,'$this->tipodocumentoidentificacion'
        ,'$this->numdocumentoidentificacion'
        ,'$vrUnitario'
        ,'$vrTotal'
        ,''
        ,'0'
        ,''
        ,'$consecutivo'
        ,'$this->id_factura'
        ,'$this->id_detalle'
        )";
        //echo "<br><br>".$sql;
        $link_->query($sql);        
        
      }  
}

?>