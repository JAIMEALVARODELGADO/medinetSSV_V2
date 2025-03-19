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
$giden_fac=$_SESSION['gid_factura'];
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

        <script>

        function saveTextAsFile(nombreArchivo_) {            
            var textarea = document.getElementById("json");
            var textToWrite = textarea.value;

            var textFileAsBlob = new Blob([textToWrite], {type:'text/plain'});
            var fileNameToSaveAs = nombreArchivo_;

            var downloadLink = document.createElement("a");
            downloadLink.download = fileNameToSaveAs;
            downloadLink.innerHTML = "Descargar archivo";
            if (window.webkitURL != null) {
                // Para navegadores webkit (como Chrome)
                downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
            } else {
                // Para otros navegadores
                downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
                downloadLink.onclick = destroyClickedElement;
                downloadLink.style.display = "none";
                document.body.appendChild(downloadLink);
            }
            downloadLink.click();
        }

        function destroyClickedElement(event) {
            document.body.removeChild(event.target);
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

    echo "<span class='h5'>Archivo Json</span>";

    $errores="";

    $consultaent = "select e.nit_ent,e.codigo_habil from entidad e";
    $consultaent=$link->query($consultaent);
    $row=$consultaent->fetch_array();
    
    $nit = $row['nit_ent'];
    $codigoPrestador=$row['codigo_habil'];

    $consultafac = "SELECT numero_fac AS numerofac,valor_total 
    FROM encabezado_factura ef 
    WHERE ef.id_factura ='$giden_fac'";
    //echo "<br>".$consultafac;
    $consultafac=$link->query($consultafac);
    $rowfac=$consultafac->fetch_array();

    $numFactura = $rowfac['numerofac'];
    $totalFacturado = $rowfac['valor_total'];

    $consultas=array();
    //aqui se generan las consultas
    $consultacon="SELECT con.id_consulta, con.fechainicioatencion , con.numautorizacion , con.codconsulta ,con.modalidadgruposervicio ,con.gruposervicio ,con.codservicio ,con.finalidadtecnologiasalud ,con.causamotivoatencion ,con.coddiagnosticoprincipal ,con.coddiagnosticorelacionado1 ,con.coddiagnosticorelacionado2 ,con.coddiagnosticorelacionado3 ,con.tipodiagnosticoprincipal ,con.vrservicio ,con.conceptorecaudo ,con.valorpagomoderador ,con.numfevpagomoderador ,con.consecutivo ,con.id_factura ,con.id_detalle ,
    usu.tipo_documento ,usu.numdocumento 
    FROM nrconsulta AS con 
    INNER JOIN nrusuario usu on usu.id_factura  = con.id_factura 
    WHERE con.id_factura='$giden_fac'";
    //echo $consultacon;
    $consecutivo=1;    
    $consultacon=$link->query($consultacon);
    
    if($consultacon->num_rows <> 0){
        while($rowcon = $consultacon->fetch_array()){
            //echo "<br>".$rowcon['fechainicioatencion'];
            $consulta = new Consulta();
            $consulta->codPrestador = $codigoPrestador;
            $consulta->fechaInicioAtencion = $rowcon['fechainicioatencion'];
            if(!empty($rowcon['numautorizacion'])){
                $consulta->numAutorizacion = $rowcon['numautorizacion'];
            }
            $consulta->codConsulta = $rowcon['codconsulta'];
            $consulta->modalidadGrupoServicioTecSal = $rowcon['modalidadgruposervicio'];
            $consulta->grupoServicios = $rowcon['gruposervicio'];
            $consulta->codServicio = intval($rowcon['codservicio']);
            $consulta->finalidadTecnologiaSalud = $rowcon['finalidadtecnologiasalud'];
            $consulta->causaMotivoAtencion = $rowcon['causamotivoatencion'];
            $consulta->codDiagnosticoPrincipal = $rowcon['coddiagnosticoprincipal'];
            if(!empty($rowcon['coddiagnosticorelacinado1'])){
                $consulta->codDiagnosticoRelacinado1 = $rowcon['coddiagnosticorelacinado1'];
            }
            if(!empty($rowcon['coddiagnosticorelacinado2'])){
                $consulta->codDiagnosticoRelacinado2 = $rowcon['coddiagnosticorelacinado2'];
            }
            if(!empty($rowcon['coddiagnosticorelacinado3'])){
                $consulta->codDiagnosticoRelacinado3 = $rowcon['coddiagnosticorelacinado3'];
            }
            $consulta->tipoDiagnosticoPrincipal = $rowcon['tipodiagnosticoprincipal'];
            $consulta->tipoDocumentoIdentificacion = $rowcon['tipo_documento'];
            $consulta->numDocumentoIdentificacion = $rowcon['numdocumento'];
            $consulta->vrServicio = intval($rowcon['vrservicio']);
            $consulta->conceptoRecaudo = $rowcon['conceptorecaudo'];
            $consulta->valorPagoModerador = intval($rowcon['valorpagomoderador']);
            if(!empty($rowcon['numfevpagomoderador'])){
                $consulta->numFEVPagoModerador = $rowcon['numfevpagomoderador'];
            }
            $consulta->consecutivo = $consecutivo;    
            $consecutivo++;
            $consultas[] = $consulta;

            $errores.=$consulta->validar();

        }
    }
    
    //echo"<br>".json_encode($consultas);    

    $otrosServicios=array();
    //aqui se generan los otros servicios
    $consultaotr="SELECT ot.id_otroservicio ,ot.numautorizacion ,ot.idmipres ,ot.fechasuministrotecnologia ,ot.tipoos ,ot.codtecnologia ,ot.nomtecnologia ,ot.cantidados ,ot.tipodocumentoidentificacion ,ot.numdocumentoidentificacion ,ot.vrunitos ,ot.vrservicio ,ot.conceptorecaudo ,ot.valorpagomoderador ,ot.numfevpagomoderador ,ot.consecutivo ,ot.id_factura ,ot.id_detalle 
    FROM nrotroservicios AS ot
    WHERE id_factura='$giden_fac'";
    //echo $consultaotr;
    
    $consecutivo=1;
    $consultaotr=$link->query($consultaotr);
    
    if($consultaotr->num_rows <> 0){
        while($rowotr = $consultaotr->fetch_array()){
            $otroServicio = new otrosServicios();
            $otroServicio->codPrestador = $codigoPrestador;
            if(!empty($rowotr['numautorizacion'])){
                $otroServicio->numAutorizacion = $rowotr['numautorizacion'];
            }
            if(!empty($rowotr['idmipres'])){
                $otroServicio->idMIPRES = $rowotr['idmipres'];
            }
            $otroServicio->fechaSuministroTecnologia = $rowotr['fechasuministrotecnologia'];
            $otroServicio->tipoOS = $rowotr['tipoos'];
            $otroServicio->codTecnologiaSalud = $rowotr['codtecnologia'];
            if(!empty($rowotr['nomtecnologia'])){
                $otroServicio->nomTecnologiaSalud = $rowotr['nomtecnologia'];
            }
            $otroServicio->cantidadOS = intval($rowotr['cantidados']);
            $otroServicio->tipoDocumentoIdentificacion = $rowotr['tipodocumentoidentificacion'];
            $otroServicio->numDocumentoIdentificacion = $rowotr['numdocumentoidentificacion'];
            $otroServicio->vrUnitOS = intval($rowotr['vrunitos']);
            $otroServicio->vrServicio = intval($rowotr['vrservicio']);
            $otroServicio->conceptoRecaudo = $rowotr['conceptorecaudo'];
            $otroServicio->valorPagoModerador = intval($rowotr['valorpagomoderador']);
            if(!empty($rowotr['nomtecnologia'])){
                $otroServicio->numFEVPagoModerador = $rowotr['numfevpagomoderador'];
            }
            $otroServicio->consecutivo = $consecutivo;
            $consecutivo++;
            $otrosServicios[] = $otroServicio;

            $errores.=$otroServicio->validar();
        }
        //echo"<br>".json_encode($otroServicio);
    }
    //echo"<br>".json_encode($otrosServicios);

    $servicios = new Servicio();
    $servicios->consultas = $consultas;
    //$servicios->procedimientos = $procedimientos;
    //$servicios->medicamentos = $medicamentos;
    $servicios->otrosServicios = $otrosServicios;
    //$servicios->urgencias = $urgencias;
    //$servicios->hospitalizacion = $hospitals;
    //$servicios->recienNacidos = $recienNacidos;
    //echo"<br>".json_encode($servicios);

    $consultausu="SELECT usu.id_usuario,usu.tipo_documento ,usu.numdocumento,usu.tipousuario,usu.fechanacimiento,usu.codsexo,usu.codpaisresidencia,usu.codmunicipioresidencia,usu.codzonaresidencia,usu.incapacidad,usu.codpaisorigen,usu.id_factura 
        FROM nrusuario AS usu
        WHERE id_factura='$giden_fac'";
    //echo "<br><br>".$consultausu;
    $consultausu=$link->query($consultausu);
    $rowusu=$consultausu->fetch_array();

    //aqui se genera el usuario
    $usuario = new Usuario();
    $usuario->tipoDocumento = $rowusu['tipo_documento'];
    $usuario->numDocumentoIdentificacion = $rowusu['numdocumento'];
    $usuario->tipoUsuario = $rowusu['tipousuario'];
    $usuario->fechaNacimiento = $rowusu['fechanacimiento'];
    $usuario->codSexo = $rowusu['codsexo'];
    $usuario->codPaisResidencia = $rowusu['codpaisresidencia'];
    $usuario->codMunicipioResidencia = $rowusu['codmunicipioresidencia'];
    $usuario->codZonaTerritorialResidencia = $rowusu['codzonaresidencia'];
    $usuario->incapacidad = $rowusu['incapacidad'];
    $usuario->consecutivo = 1;
    $usuario->codPaisOrigen = $rowusu['codpaisorigen'];
    $usuario->servicios = $servicios;

    $errores.=$usuario->validar();
    
    //echo"<br>".json_encode($usuario);

    $usuarios=array();
    $usuarios[] = $usuario;

    $rips = new Rips();

    $rips->numDocumentoIdObligado = $nit;
    $rips->numFactura = $numFactura;
    $rips->usuarios = $usuarios;

    //Aqui se genera el archivo json
    $ripsJson = json_encode($rips);
    //echo "<br><br>".$ripsJson;

    //Inicia bloque guardar archivo -- Este bloque permite guardar el json en una carpeta y luego descargarlo
    $scarpeta=""; //carpeta donde guardar el archivo. 
    //debe tener permisos 775 por lo menos 
    $sfile="planos/ripsJson".$numFactura.".json"; //ruta del archivo a generar 
    $fp=fopen($sfile,"w"); 
    fwrite($fp,$ripsJson); 
    fclose($fp);
    /*echo"
    <div>   
        <a href='".$sfile."'><img width=20 height=20 src='icons/feed_disk.png' alt='Generar Archivo' border=0></a>    
        <a href='".$sfile."'><font color=#3300FF><b>Guardar Json</font></a>
    </div>
    ";*/
    //Fin bloque guardar archivo
    $nombreArchivo="ripsJson".$numFactura.".json";
    
    if($errores<>""){
        echo"
            <table class='Tbl0'>
            <tr><td class='Td1'>Lista de errores</td></tr>
            $errores
            </table>";
    }

?>


<br>
<textarea name="json" id="json" hidden="true">
<?php echo $ripsJson;?>
</textarea>

<br><br>
<div class='Td6'>    
  <center><a href='#' onclick="saveTextAsFile('<?php echo $nombreArchivo;?>')">Descargar Rips</a></center>
</div>
    

</form>
</body>
</html>

<?php
class Consulta{
    public $codPrestador;
    public $fechaInicioAtencion;
    public $numAutorizacion;
    public $codConsulta;
    public $modalidadGrupoServicioTecSal;
    public $grupoServicios;
    public $codServicio;
    public $finalidadTecnologiaSalud;
    public $causaMotivoAtencion;
    public $codDiagnosticoPrincipal;
    public $codDiagnosticoRelacinado1;
    public $codDiagnosticoRelacinado2;
    public $codDiagnosticoRelacinado3;
    public $tipoDiagnosticoPrincipal;
    public $tipoDocumentoIdentificacion;
    public $numDocumentoIdentificacion;
    public $vrServicio;
    public $conceptoRecaudo;
    public $valorPagoModerador;
    public $numFEVPagoModerador;
    public $consecutivo;

    public function validar(){
        $errores="";        
        if(isset($this->fechaInicioAtencion) and strlen($this->fechaInicioAtencion) < 16){
            $errores.="<tr><td>Consultas - Fecha y hora de inicio de atención - Registro ".$this->consecutivo." </td><tr>";
        }
        if(isset($this->codConsulta) and strlen($this->codConsulta) < 6){
            $errores.="<tr><td>Consultas - El código no debe ser menor a 6 caracteres - Registro ".$this->consecutivo." </td><tr>";
        }        
        if(isset($this->modalidadGrupoServicioTecSal) and !existeTipo($this->modalidadGrupoServicioTecSal,'8')){
            $errores.="<tr><td>Consultas - Modalidad de atención - Registro ".$this->consecutivo."</td><tr>";
        }        
        if(isset($this->grupoServicios) and !existeTipo($this->grupoServicios,'9')){
            $errores.="<tr><td>Consultas - Grupo de servicios - Registro ".$this->consecutivo."</td><tr>";
        }
        if(isset($this->codServicio) and !existeTipo($this->codServicio,'10')){
            $errores.="<tr><td>Consultas - Servicio - Registro ".$this->consecutivo."</td><tr>";
        }
        if(isset($this->finalidadTecnologiaSalud) and !existeTipo($this->finalidadTecnologiaSalud,'11')){
            $errores.="<tr><td>Consultas - Finalidad - Registro ".$this->consecutivo."</td><tr>";
        }        
        if(isset($this->causaMotivoAtencion) and !existeTipo($this->causaMotivoAtencion,'12')){
            $errores.="<tr><td>Consultas - Causa motivo de atención - Registro ".$this->consecutivo."</td><tr>";
        }        
        if(isset($this->codDiagnosticoPrincipal) and strlen($this->codDiagnosticoPrincipal) < 4){
            $errores.="<tr><td>Consultas - El diagnóstico principal no puede ser menor a 4 caracteres - Registro ".$this->consecutivo." </td><tr>";
        }        
        if(isset($this->codDiagnosticoRelacinado1) and strlen($this->codDiagnosticoRelacinado1) < 4){
            $errores.="<tr><td>Consultas - El diagnóstico relacionado 1 no puede ser menor a 4 caracteres - Registro ".$this->consecutivo." </td><tr>";
        }
        if(isset($this->codDiagnosticoRelacinado2) and strlen($this->codDiagnosticoRelacinado2) < 4){
            $errores.="<tr><td>Consultas - El diagnóstico relacionado 2 no puede ser menor a 4 caracteres - Registro ".$this->consecutivo." </td><tr>";
        }
        if(isset($this->codDiagnosticoRelacinado3) and strlen($this->codDiagnosticoRelacinado3) < 4){
            $errores.="<tr><td>Consultas - El diagnóstico relacionado 3 no puede ser menor a 4 caracteres - Registro ".$this->consecutivo." </td><tr>";
        }
        if(isset($this->tipoDiagnosticoPrincipal) and !existeTipo($this->tipoDiagnosticoPrincipal,'13')){
            $errores.="<tr><td>Consultas - Tipo de diagnóstico - Registro ".$this->consecutivo." </td><tr>";
        }
        if(isset($this->conceptoRecaudo) and !existeTipo($this->conceptoRecaudo,'7')){
            $errores.="<tr><td>Consultas - Concepto del recaudo - Registro ".$this->consecutivo." </td><tr>";
        }        

        return($errores);
    }
}

class otrosServicios{
    public $codPrestador;
    public $numAutorizacion;
    public $idMIPRES;
    public $fechaSuministroTecnologia;
    public $tipoOS;
    public $codTecnologiaSalud;
    public $nomTecnologiaSalud;
    public $cantidadOS;
    public $tipoDocumentoIdentificacion;
    public $numDocumentoIdentificacion;
    public $vrUnitOS;
    public $vrServicio;
    public $conceptoRecaudo;
    public $valorPagoModerador;
    public $numFEVPagoModerador;
    public $consecutivo;

    public function validar(){
        $errores="";
        if(isset($this->fechaSuministroTecnologia) and strlen($this->fechaSuministroTecnologia) < 16){
            $errores.="<tr><td>Otros Servicios - Fecha y hora de suministro - Registro ".$this->consecutivo." </td><tr>";
        }
        if(isset($this->tipoOS) and !existeTipo($this->tipoOS,'6')){
            $errores.="<tr><td>Otros Servicios - Tipo de servicio - Registro ".$this->consecutivo." </td><tr>";
        }        
        if(isset($this->codTecnologiaSalud) and empty($this->codTecnologiaSalud)){
            $errores.="<tr><td>Otros Servicios - Código de la tecnología - Registro ".$this->consecutivo." </td><tr>";
        }        
        if(isset($this->conceptoRecaudo) and !existeTipo($this->conceptoRecaudo,'7')){
            $errores.="<tr><td>Otros Servicios - Concepto de recaudo - Registro ".$this->consecutivo." </td><tr>";
        }        

        return($errores);
    }
}

class Usuario{
    public $tipoDocumento;
    public $numDocumentoIdentificacion;
    public $tipoUsuario;
    public $fechaNacimiento;
    public $codSexo;
    public $codPaisResidencia;
    public $codMunicipioResidencia;
    public $codZonaTerritorialResidencia;
    public $incapacidad;
    public $consecutivo;
    public $codPaisOrigen;
    public $servicios;

    public function validar(){
        $errores="";                        
        if(isset($this->numDocumentoIdentificacion) and strlen($this->numDocumentoIdentificacion) < 4){
            $errores.="<tr><td>Usuario - El número de documento de identificación no debe ser inferior a 4 caracteres </td><tr>";
        }        
        if(isset($this->tipoUsuario) and !existeTipo($this->tipoUsuario,'5')){
            $errores.="<tr><td>Usuario - Tipo de usuario </td><tr>";
        }        
        if(isset($this->fechaNacimiento) and strlen($this->fechaNacimiento) < 10 ){
            $errores.="<tr><td>Usuario - Fecha de nacimiento </td><tr>";
        }        
        if(isset($this->codSexo) and !existeTipo($this->codSexo,'15')){
            $errores.="<tr><td>Usuario - Sexo </td><tr>";
        }                
        if(isset($this->codMunicipioResidencia) and !existeMunicipio($this->codMunicipioResidencia)){
            $errores.="<tr><td>Usuario - Municipio de residencia </td><tr>";
        }        
        if(isset($this->codZonaTerritorialResidencia) and !existeTipo($this->codZonaTerritorialResidencia,'16')){
            $errores.="<tr><td>Usuario - Zona de residencia </td><tr>";
        }
        if(isset($this->incapacidad) and empty($this->incapacidad)){
            $errores.="<tr><td>Usuario - Incapacidad </td><tr>";
        }        

        return($errores);
    }
}

class Rips{
    public $numDocumentoIdObligado;
    public $numFactura;
    public $tipoNota;
    public $numNota;
    public $usuarios;    
}

class Servicio{
    public $consultas;
    public $procedimientos;
    public $urgencias;
    public $hospitalizacion;
    public $recienNacidos;
    public $medicamentos;
    public $otrosServicios;
}

function existeTipo($valor_,$grupo_){
    global $link;
    $existe = false;
    $consultatipo = "SELECT dg.valor_det FROM detalle_grupo dg 
    WHERE dg.id_grupo ='$grupo_' and dg.valor_det ='$valor_'";
    $consultatipo=$link->query($consultatipo);
    
    if($consultatipo->num_rows<>0){        
        $existe = true;
    }    
    return ($existe);
}

function existeMunicipio($valor_){
    global $link;
    $existe = false;
    $consultamun = "SELECT m.codigo_mun FROM municipio m WHERE m.codigo_mun ='$valor_'";
    $consultamun = $link->query($consultamun);
    
    if($consultamun->num_rows <> 0){
        $existe = true;
    }
    return ($existe);
}
?>