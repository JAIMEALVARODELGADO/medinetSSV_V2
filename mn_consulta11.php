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
//$hoy=cambiafecha(hoy());
//$hora=date("H:i:s");
//$hoy=$hoy.' '.$hora;

//Aqui se eliminan los caracteres("') de las variables de texto
$quien_con=quitarComillas($_POST['quien_con']);
$motivo_con=quitarComillas($_POST['motivo_con']);
$enfermedad_con=quitarComillas($_POST['enfermedad_con']);
$revsistemas_con=quitarComillas($_POST['revsistemas_con']);
$anteced_per_con=quitarComillas($_POST['anteced_per_con']);
$anteced_fam_con=quitarComillas($_POST['anteced_fam_con']);
$observacion_sig=quitarComillas($_POST['observacion_sig']);
$cabeza_estado_efis=quitarComillas($_POST['cabeza_estado_efis']);
$cabeza_hallazgo_efis=quitarComillas($_POST['cabeza_hallazgo_efis']);
$cuello_estado_efis=quitarComillas($_POST['cuello_estado_efis']);
$cuello_hallazdo_efis=quitarComillas($_POST['cuello_hallazdo_efis']);
$torax_estado_efis=quitarComillas($_POST['torax_estado_efis']);
$torax_hallazgo_efis=quitarComillas($_POST['torax_hallazgo_efis']);
$abdomen_estado_efis=quitarComillas($_POST['abdomen_estado_efis']);
$abdomen_hallazgo_efis=quitarComillas($_POST['abdomen_hallazgo_efis']);
$columna_estado_efis=quitarComillas($_POST['columna_estado_efis']);
$columna_hallazgo_efis=quitarComillas($_POST['columna_hallazgo_efis']);
$extremi_estado_efis=quitarComillas($_POST['extremi_estado_efis']);
$extremi_hallazgo_efis=quitarComillas($_POST['extremi_hallazgo_efis']);
$observacion_con=quitarComillas($_POST['observacion_con']);
$analisis_con=quitarComillas($_POST['analisis_con']);
$plan_con=quitarComillas($_POST['plan_con']);

if($_POST['id_consulta']>0){
    $sql_="UPDATE consulta SET fecha_con='$_POST[fecha_con]',reingreso_con='$_POST[reingreso_con]',quien_con='$quien_con',motivo_con='$motivo_con',enfermedad_con='$enfermedad_con',revsistemas_con='$revsistemas_con',anteced_per_con='$anteced_per_con',anteced_fam_con='$anteced_fam_con',diag_prin='$_POST[diag_prin]',diag_rel1='$_POST[diag_rel1]',observacion_con='$observacion_con',id_cups='$_POST[id_cups]',finalidad_con='$_POST[finalidad_con]',causaexte_con='$_POST[causaexte_con]',analisis_con='$analisis_con',plan_con='$plan_con' WHERE id_consulta='$_POST[id_consulta]'";
    //echo "<br>".$sql_;
    $link->query($sql_);
    $id_consulta=$_POST['id_consulta'];
}
else{
    $sql_="INSERT INTO consulta(id_consulta,id_ingreso,fecha_con,reingreso_con,quien_con,motivo_con,enfermedad_con,revsistemas_con,anteced_per_con,anteced_fam_con,diag_prin,diag_rel1,observacion_con,id_cups,finalidad_con,causaexte_con,analisis_con,plan_con,id_formato,id_operador) VALUES(0,'$_POST[id_ingreso]','$_POST[fecha_con]','$_POST[reingreso_con]','$quien_con','$motivo_con','$enfermedad_con','revsistemas_con','$anteced_per_con','$anteced_fam_con','$_POST[diag_prin]','$_POST[diag_rel1]','$observacion_con','$_POST[id_cups]','$_POST[finalidad_con]','$_POST[causaexte_con]','$analisis_con','$plan_con','$_POST[id_formato]','$_SESSION[gid_usuario]')";
    //echo "<br>".$sql_;
    $link->query($sql_);
    $id_consulta=$link->insert_id;
    //echo $id_consulta
}

if($link->affected_rows > 0){
    $msg="Registro guardado con exito";
}
else{$msg="Registro no guardado";}
if($id_consulta>1){
    //Aqui guardo los signos vitales
    $tension_sig=$_POST['tasistol_sign']."/".$_POST['tadiasto_sign'];
    $consultasig="SELECT id_signo FROM consulta_signos WHERE id_consulta='$id_consulta'";    
    $consultasig=$link->query($consultasig);
    if($consultasig->num_rows<>0){
        $sql_="UPDATE consulta_signos SET 
        tension_sig='$tension_sig',
        frec_respi_sig='$_POST[frec_respi_sig]',
        frec_card_sig='$_POST[frec_card_sig]',
        temperat_sig='$_POST[temperat_sig]',
        peso_sig='$_POST[peso_sig]',
        talla_sig='$_POST[talla_sig]',
        observacion_sig='$observacion_sig'
        WHERE id_consulta='$id_consulta'";      
        //ECHO $sql_;
        $link->query($sql_);

    }
    else{
        $sql_="INSERT INTO consulta_signos(id_consulta,tension_sig,frec_respi_sig,frec_card_sig,temperat_sig,peso_sig, talla_sig,observacion_sig) VALUES('$id_consulta','$tension_sig','$_POST[frec_respi_sig]','$_POST[frec_card_sig]','$_POST[temperat_sig]','$_POST[peso_sig]','$_POST[talla_sig]','$observacion_sig')";
        //ECHO $sql_;
        $link->query($sql_);    
    }

    //Aqui guardo el examen físico
    $consultaefis="SELECT id_efis FROM consulta_examen_fisico WHERE id_consulta='$id_consulta'";
    //echo $consultaefis;
    $consultaefis=$link->query($consultaefis);
    if($consultaefis->num_rows<>0){
        $sql_="UPDATE consulta_examen_fisico SET         
        cabeza_estado_efis='$cabeza_estado_efis',
        cabeza_hallazgo_efis='$cabeza_hallazgo_efis',
        cuello_estado_efis='$cuello_estado_efis',
        cuello_hallazdo_efis='$cuello_hallazdo_efis',
        torax_estado_efis='$torax_estado_efis',
        torax_hallazgo_efis='$torax_hallazgo_efis',
        abdomen_estado_efis='$abdomen_estado_efis',
        abdomen_hallazgo_efis='$abdomen_hallazgo_efis',
        columna_estado_efis='$columna_estado_efis',
        columna_hallazgo_efis='$columna_hallazgo_efis',
        extremi_estado_efis='$extremi_estado_efis',
        extremi_hallazgo_efis='$extremi_hallazgo_efis'
        WHERE id_consulta='$id_consulta'";
        //echo "<br>".$sql_;
        $link->query($sql_);
    }
    else{    
        $sql_="INSERT INTO consulta_examen_fisico(id_consulta,cabeza_estado_efis,cabeza_hallazgo_efis,cuello_estado_efis,cuello_hallazdo_efis,torax_estado_efis,torax_hallazgo_efis,abdomen_estado_efis,abdomen_hallazgo_efis,columna_estado_efis,columna_hallazgo_efis,extremi_estado_efis,extremi_hallazgo_efis) 
        VALUES('$id_consulta','$cabeza_estado_efis','$cabeza_hallazgo_efis','$cuello_estado_efis','$cuello_hallazdo_efis','$torax_estado_efis','$torax_hallazgo_efis','$abdomen_estado_efis','$abdomen_hallazgo_efis','$columna_estado_efis','$columna_hallazgo_efis','$extremi_estado_efis','$extremi_hallazgo_efis')";
        //ECHO $sql_;
        $link->query($sql_);
    }
}
$_SESSION['gid_consulta']=$id_consulta;

?>
<body onload="continuar('<?php echo $msg;?>')">
<!--<form name='form1' method="post" action="mn_lista_pacientes1.php">-->
<form name='form1' method="post" action="mn_consulta1.php">
    <?php 
    echo "<br>".$msg;
    //echo "<input type='hidden' name='id_evolucion' value='$id_evolucion'>";
    ?>

</form>
</body>
</html>

<?php
function quitarComillas($text_){
    $text_=str_replace("'","",$text_);
    $text_=str_replace('"',"",$text_);
    return($text_);
}
?>