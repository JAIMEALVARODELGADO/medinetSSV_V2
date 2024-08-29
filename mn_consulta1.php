<?php
session_start();
//$_SESSION['datos'];
//$datos[0]='nombre';
//$datos[1]='codigo';
//$_SESSION['gid_ingreso']='';
if(isset($_GET['id_ingreso'])){
    $_SESSION['gid_ingreso']=$_GET['id_ingreso'];
    $_SESSION['gid_consulta']="";
    $_SESSION['gid_formato']=$_GET['id_formato'];
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>        
        <meta charset="UTF-8"/>
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type='text/javascript' src='js/jquery.autocomplete.js'></script>
        <script type="text/javascript">
            $().ready(function() {  
                $("#course").autocomplete("mn_autocomp_cie.php", {
                    width: 460,
                    matchContains: false,
                    mustMatch: false,
                    selectFirst: false
                });
                $("#course2").autocomplete("mn_autocomp_cie.php", {
                    width: 460,
                    matchContains: false,
                    mustMatch: false,
                    selectFirst: false
                });
                $("#course3").autocomplete("mn_autocomp_cups.php", {
                    width: 460,
                    matchContains: false,
                    mustMatch: false,
                    selectFirst: false
                });
                
                $("#course").result(function(event, data, formatted) {
                    $("#course_val").val(data[1]);
                });
                $("#course2").result(function(event, data, formatted) {
                    $("#course_val2").val(data[1]);
                });
                $("#course3").result(function(event, data, formatted) {
                    $("#course_val3").val(data[1]);
                });
            });
        </script>
        <script language='JavaScript'>
            function validar(){
                error="";
                if(document.form1.fecha_con.value==''){error+="Fecha\n";}
                if(document.form1.reingreso_con.value==''){error+="Reingreso\n";}
                if(document.form1.motivo_con.value==''){error+="Motivo de Consulta\n";}
                if(document.form1.diag_prin.value==''){error+="Diagnóstivo Principal\n";}
                if(document.form1.id_cups.value==''){error+="Cups de la Consulta\n";}
                if(document.form1.finalidad_con.value==''){error+="Finalidad\n";}
                if(document.form1.causaexte_con.value==''){error+="Causa Externa\n";}
                if(error!=""){
                    alert("Es necesario complementar la siguiente información:\n"+error);
                }
                else{
                    //if(confirm("Recuerde que al guardar esta consulta, no podrá modificarla ni eliminarla\nDesea guardar?")){
                        document.form1.submit();
                    //}
                }
            }
        </script>
        <title>Medinet</title>
    </head>
<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_consulta.php");
$link=conectarbd();

$consultaing="SELECT diag_prin,vw_cie.nombre_cie,diag_rel1,vw_cierel.nombre_cie AS nombre_cierel FROM ingreso 
INNER JOIN vw_cie ON vw_cie.id_cie=ingreso.diag_prin
LEFT JOIN vw_cie AS vw_cierel ON vw_cierel.id_cie=ingreso.diag_rel1
WHERE id_ingreso='$_SESSION[gid_ingreso]'";
//echo $consultaing;
$consultaing=$link->query($consultaing);
if($consultaing->num_rows<>0){
    $rowing=$consultaing->fetch_array();
    //$paciente=$row['paciente'];
    $diag_prin=$rowing['diag_prin'];
    $diag_rel1=$rowing['diag_rel1'];
    $nombre_cie=$rowing['nombre_cie'];
    $nombre_cierel=$rowing['nombre_cierel'];
}

//Aqui consulto la informacion del ingreso
$consulta="SELECT CONCAT(tipo_iden,' ',identificacion,' ',pnombre,' ',snombre,' ',papellido,' ',sapellido) AS paciente FROM vw_ingreso WHERE id_ingreso='$_SESSION[gid_ingreso]'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows<>0){
    $row=$consulta->fetch_array();
    $paciente=$row['paciente'];
}

$id_consulta="";
$fecha_con="";
$reingreso_con="";
$quien_con="";
$motivo_con="";
$enfermedad_con="";
$revsistemas_con="";
$anteced_per_con="";
$anteced_fam_con="";
$diag_principal="";
$diag_relacionado="";
$dxrelac1="";
$observacion_con="";
$id_cups="";
$finalidad_con="";
$causaexte_con="";
$analisis_con="";
$plan_con="";
$dxprinc="";
$descripcion_cups="";

$tension_sig="";
$frec_respi_sig="";
$frec_card_sig="";
$temperat_sig="";
$peso_sig="";
$talla_sig="";
$observacion_sig="";
$tasistol_sign="";
$tadiasto_sign="";

$cabeza_estado_efis="";
$cabeza_hallazgo_efis="";
$cuello_estado_efis="";
$cuello_hallazdo_efis="";
$torax_estado_efis="";
$torax_hallazgo_efis="";
$abdomen_estado_efis="";
$abdomen_hallazgo_efis="";
$columna_estado_efis="";
$columna_hallazgo_efis="";
$extremi_estado_efis="";
$extremi_hallazgo_efis="";

//Aqui consulto la informacion de consultas abiertas
$consultacon="SELECT vw_consulta.id_consulta,vw_consulta.fecha_con,vw_consulta.reingreso_con,vw_consulta.quien_con,vw_consulta.motivo_con,vw_consulta.enfermedad_con,vw_consulta.revsistemas_con,vw_consulta.anteced_per_con,vw_consulta.anteced_fam_con,vw_consulta.diag_prin,CONCAT(vw_consulta.codigo_cie,' ',vw_consulta.descripcion_cie) AS dxprinc,vw_consulta.diag_rel1,
CONCAT(vw_consulta.codigo_cierel1,' ',vw_consulta.descripcion_cierel1) AS dxrelac1,vw_consulta.observacion_con,vw_consulta.id_cups,vw_consulta.descripcion_cups,vw_consulta.finalidad_con,vw_consulta.causaexte_con,vw_consulta.analisis_con,vw_consulta.plan_con,vw_consulta.estado_con
FROM vw_consulta WHERE id_ingreso='$_SESSION[gid_ingreso]' AND id_operador='$_SESSION[gid_usuario]' and estado_con='A'";
//echo $consultacon;
$consultacon=$link->query($consultacon);
if($consultacon->num_rows<>0){
    $rowcon=$consultacon->fetch_array();
    $id_consulta=$rowcon['id_consulta'];
    $fecha_con=$rowcon['fecha_con'];
    $reingreso_con=$rowcon['reingreso_con'];
    $quien_con=$rowcon['quien_con'];
    $motivo_con=$rowcon['motivo_con'];
    $enfermedad_con=$rowcon['enfermedad_con'];
    $revsistemas_con=$rowcon['revsistemas_con'];
    $anteced_per_con=$rowcon['anteced_per_con'];
    $anteced_fam_con=$rowcon['anteced_fam_con'];
    $diag_principal=$rowcon['diag_prin'];
    $dxprinc=$rowcon['dxprinc'];
    $diag_rel1=$rowcon['diag_rel1'];
    $dxrelac1=$rowcon['dxrelac1'];;
    $observacion_con=$rowcon['observacion_con'];
    $id_cups=$rowcon['id_cups'];
    $descripcion_cups=$rowcon['descripcion_cups'];
    $finalidad_con=$rowcon['finalidad_con'];
    $causaexte_con=$rowcon['causaexte_con'];
    $analisis_con=$rowcon['analisis_con'];
    $plan_con=$rowcon['plan_con'];
    $_SESSION['gid_consulta']=$id_consulta;
}

//Aqui consulto los signos vitales
$consultasig="SELECT vw_consulta_signos.id_consulta,vw_consulta_signos.tension_sig,vw_consulta_signos.frec_respi_sig,vw_consulta_signos.frec_card_sig,vw_consulta_signos.temperat_sig,vw_consulta_signos.peso_sig,vw_consulta_signos.talla_sig,vw_consulta_signos.observacion_sig
    FROM vw_consulta_signos WHERE id_consulta='$id_consulta'";
//echo $consultasig;
$consultasig=$link->query($consultasig);
if($consultasig->num_rows<>0){
    $rowsig=$consultasig->fetch_array();
    $tension_sig=$rowsig['tension_sig'];
    $frec_respi_sig=$rowsig['frec_respi_sig'];
    $frec_card_sig=$rowsig['frec_card_sig'];
    $temperat_sig=$rowsig['temperat_sig'];
    $peso_sig=$rowsig['peso_sig'];
    $talla_sig=$rowsig['talla_sig'];
    $observacion_sig=$rowsig['observacion_sig'];    
    $tasistol_sign=substr($tension_sig,0,strpos($tension_sig,'/'));
    $tadiasto_sign=substr($tension_sig,strpos($tension_sig,'/')+1);    
}

//Aqui consulto el examen fisico
$consultaefis="SELECT vw_consulta_examenfisico.id_consulta,vw_consulta_examenfisico.cabeza_estado_efis,vw_consulta_examenfisico.cabeza_hallazgo_efis,vw_consulta_examenfisico.cuello_estado_efis,vw_consulta_examenfisico.cuello_hallazdo_efis,vw_consulta_examenfisico.torax_estado_efis,vw_consulta_examenfisico.torax_hallazgo_efis,vw_consulta_examenfisico.abdomen_estado_efis,vw_consulta_examenfisico.abdomen_hallazgo_efis,vw_consulta_examenfisico.columna_estado_efis,vw_consulta_examenfisico.columna_hallazgo_efis,vw_consulta_examenfisico.extremi_estado_efis,vw_consulta_examenfisico.extremi_hallazgo_efis
    FROM vw_consulta_examenfisico WHERE id_consulta='$id_consulta'";
//echo $consultaefis;
$consultaefis=$link->query($consultaefis);
if($consultaefis->num_rows<>0){
    $rowefis=$consultaefis->fetch_array();
    $cabeza_estado_efis=$rowefis['cabeza_estado_efis'];
    $cabeza_hallazgo_efis=$rowefis['cabeza_hallazgo_efis'];
    $cuello_estado_efis=$rowefis['cuello_estado_efis'];
    $cuello_hallazdo_efis=$rowefis['cuello_hallazdo_efis'];
    $torax_estado_efis=$rowefis['torax_estado_efis'];
    $torax_hallazgo_efis=$rowefis['torax_hallazgo_efis'];
    $abdomen_estado_efis=$rowefis['abdomen_estado_efis'];
    $abdomen_hallazgo_efis=$rowefis['abdomen_hallazgo_efis'];
    $columna_estado_efis=$rowefis['columna_estado_efis'];
    $columna_hallazgo_efis=$rowefis['columna_hallazgo_efis'];
    $extremi_estado_efis=$rowefis['extremi_estado_efis'];
    $extremi_hallazgo_efis=$rowefis['extremi_hallazgo_efis'];
}
?>

<form method="post" name='form1' action="mn_consulta11.php">
    <div class="fila">
        <label><span class="icon-clipboard"><b>HISTORIA DE CONSULTA</b></span></label>
    </div>
    <?php
    require("mn_datos_consulta.php");
    ?>
    <input type="hidden" id="id_formato" name='id_formato' value="<?php echo $_SESSION['gid_formato'];?>">  
    <input type="hidden" id="id_consulta" name='id_consulta' value="<?php echo $id_consulta;?>">
    <br><button type="button" id='btnguardar' onclick='validar()'><span class="icon-save"></span> Guardar</button>
    <script type="text/javascript" language='JavaScript'>
        document.form1.nombre_pac.value='<?php echo $paciente;?>';
        document.form1.id_ingreso.value='<?php echo $_SESSION['gid_ingreso'];?>';
        document.form1.fecha_con.value="<?php echo $fecha_con;?>";
        document.form1.reingreso_con.value="<?php echo $reingreso_con;?>";
        document.form1.quien_con.value="<?php echo $quien_con;?>";
        document.form1.motivo_con.value="<?php echo $motivo_con;?>";
        document.form1.enfermedad_con.value="<?php echo $enfermedad_con;?>";
        document.form1.revsistemas_con.value="<?php echo $revsistemas_con;?>";
        document.form1.anteced_per_con.value="<?php echo $anteced_per_con;?>";
        document.form1.anteced_fam_con.value="<?php echo $anteced_fam_con;?>";        
        document.form1.diag_principal.value="<?php echo $dxprinc;?>";
        document.form1.diag_prin.value="<?php echo $diag_principal;?>";
        document.form1.diag_rel1.value="<?php echo $diag_rel1;?>";
        document.form1.diag_relacionado.value="<?php echo $dxrelac1;?>";
        document.form1.observacion_con.value="<?php echo $observacion_con;?>";
        document.form1.id_cups.value="<?php echo $id_cups;?>";
        document.form1.cups.value="<?php echo $descripcion_cups;?>";        
        document.form1.finalidad_con.value="<?php echo $finalidad_con;?>";
        document.form1.causaexte_con.value="<?php echo $causaexte_con;?>";
        document.form1.analisis_con.value="<?php echo $analisis_con;?>";
        document.form1.plan_con.value="<?php echo $plan_con;?>";

        document.form1.tasistol_sign.value="<?php echo $tasistol_sign;?>";
        document.form1.tadiasto_sign.value="<?php echo $tadiasto_sign;?>";
        document.form1.frec_respi_sig.value="<?php echo $frec_respi_sig;?>";
        document.form1.frec_card_sig.value="<?php echo $frec_card_sig;?>";
        document.form1.temperat_sig.value="<?php echo $temperat_sig;?>";
        document.form1.peso_sig.value="<?php echo $peso_sig;?>";
        document.form1.talla_sig.value="<?php echo $talla_sig;?>";
        document.form1.observacion_sig.value="<?php echo $observacion_sig;?>";

        document.form1.cabeza_estado_efis.value="<?php echo $cabeza_estado_efis;?>";
        document.form1.cabeza_hallazgo_efis.value="<?php echo $cabeza_hallazgo_efis;?>";
        document.form1.cuello_estado_efis.value="<?php echo $cuello_estado_efis;?>";
        document.form1.cuello_hallazdo_efis.value="<?php echo $cuello_hallazdo_efis;?>";
        document.form1.torax_estado_efis.value="<?php echo $torax_estado_efis;?>";
        document.form1.torax_hallazgo_efis.value="<?php echo $torax_hallazgo_efis;?>";
        document.form1.abdomen_estado_efis.value="<?php echo $abdomen_estado_efis;?>";
        document.form1.abdomen_hallazgo_efis.value="<?php echo $abdomen_hallazgo_efis;?>";
        document.form1.columna_estado_efis.value="<?php echo $columna_estado_efis;?>";
        document.form1.columna_hallazgo_efis.value="<?php echo $columna_hallazgo_efis;?>";
        document.form1.extremi_estado_efis.value="<?php echo $extremi_estado_efis;?>";
        document.form1.extremi_hallazgo_efis.value="<?php echo $extremi_hallazgo_efis;?>";
    </script>
    
</form>
</body>
</html>

<script type="text/javascript">
    

    document.form1.diag_prin.value="<?php echo $diag_prin;?>";
    document.form1.diag_rel1.value="<?php echo $diag_rel1;?>";
    document.form1.diag_principal.value="<?php echo $nombre_cie;?>";    
    document.form1.diag_relacionado.value="<?php echo $nombre_cierel;?>";    
</script>