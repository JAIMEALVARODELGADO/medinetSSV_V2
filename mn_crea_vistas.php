<?php
session_start();
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
        function validar(){
            document.form1.submit();
        }        
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
$link=conectarbd();

$sql="CREATE OR REPLACE VIEW vw_usuario_sist AS 
SELECT persona.id_persona,persona.tipo_iden,persona.identificacion,persona.pnombre,persona.snombre,persona.papellido,persona.sapellido,persona.telefono,persona.direccion,usuario_sist.login,usuario_sist.password,usuario_sist.estado FROM persona INNER JOIN usuario_sist ON usuario_sist.id_persona=persona.id_persona";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_usuario_sist NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_paciente AS 
SELECT persona.id_persona,persona.tipo_iden,persona.identificacion,persona.papellido,persona.sapellido,persona.pnombre,persona.snombre,persona.fecha_nacim,persona.direccion,persona.telefono,persona.sexo,paciente.mun_reside,paciente.zona_reside,paciente.tipo_sangre FROM persona INNER JOIN paciente ON paciente.id_persona=persona.id_persona";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_paciente NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_paciente2 AS 
SELECT persona.id_persona,CONCAT(persona.tipo_iden,' ',persona.identificacion,' ',persona.pnombre,' ',persona.snombre,' ',persona.papellido,' ',persona.sapellido) AS nombre FROM persona INNER JOIN paciente ON paciente.id_persona=persona.id_persona ORDER BY pnombre";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_paciente2 NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_ingreso AS
SELECT ingreso.id_ingreso,ingreso.jornada,ingreso.fecha_ing,ingreso.peso,ingreso.id_eps,eps.nombre_eps,ingreso.control_esfin,ingreso.desplazam,ingreso.alimentacion_indep,ingreso.comunicacion_verbal,ingreso.alergia_medicame,ingreso.alergia_alimento,ingreso.fecha_egreso,ingreso.estado,ingreso.observacion_ing,persona.tipo_iden,persona.identificacion,persona.papellido,persona.sapellido,persona.pnombre,persona.snombre,persona.fecha_nacim,persona.direccion,persona.telefono,persona.sexo, 
ingreso.diag_prin,cie.codigo_cie,cie.descripcion_cie,ingreso.diag_rel1,cie_2.codigo_cie AS cie_rel1,cie_2.descripcion_cie AS desc_cie_rel1
FROM ingreso INNER JOIN persona ON persona.id_persona=ingreso.id_persona INNER JOIN eps on ingreso.id_eps=eps.id_eps
LEFT JOIN cie ON cie.id_cie=ingreso.diag_prin LEFT JOIN cie AS cie_2 ON cie_2.id_cie=ingreso.diag_rel1";
//echo "<br>".$sql;
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_ingreso NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_paciente_act AS
SELECT DISTINCT vw_ingreso.id_ingreso, CONCAT(vw_ingreso.tipo_iden,' ',vw_ingreso.identificacion,' ',vw_ingreso.pnombre,' ',vw_ingreso.snombre,' ',vw_ingreso.papellido,' ',vw_ingreso.sapellido) AS nombre FROM `vw_ingreso` WHERE vw_ingreso.estado='AC'";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_paciente_act NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_producto AS
SELECT producto.id_producto,producto.tipo_producto,CONCAT(producto.codigo_producto,' ',producto.descripcion,' ',producto.concentracion,' ',producto.presentacion) AS nombre_prod FROM producto ORDER BY producto.descripcion";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_producto NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_movimientos AS
SELECT movimiento_inventario.id_movimiento, movimiento_inventario.tipo_mov, movimiento_inventario.id_ingreso, movimiento_inventario.fecha_mov, movimiento_inventario.id_producto, movimiento_inventario.remite,movimiento_inventario.lote,movimiento_inventario.cantidad, movimiento_inventario.dosis, movimiento_inventario.via, movimiento_inventario.observacion_mov,
ingreso.estado,ingreso.fecha_ing,
persona.id_persona, persona.tipo_iden, persona.identificacion, persona.papellido, persona.sapellido, persona.pnombre, persona.snombre,
producto.tipo_producto, producto.codigo_producto, producto.descripcion, producto.concentracion, producto.presentacion,
movimiento_inventario.id_operador,CONCAT(usuario.pnombre,' ',usuario.snombre,' ',usuario.papellido,' ',usuario.sapellido) AS operador,usuario.identificacion AS ident_oper
FROM movimiento_inventario
INNER JOIN ingreso ON ingreso.id_ingreso=movimiento_inventario.id_ingreso
INNER JOIN persona ON persona.id_persona=ingreso.id_persona
INNER JOIN producto ON producto.id_producto=movimiento_inventario.id_producto
INNER JOIN persona As usuario ON usuario.id_persona=movimiento_inventario.id_operador";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_movimientos NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_inventario_paciente AS
SELECT inventario_paciente.id_inventario, inventario_paciente.id_ingreso, inventario_paciente.id_producto, inventario_paciente.cantidad_ingresa, inventario_paciente.cantidad_aplicada,(inventario_paciente.cantidad_ingresa-inventario_paciente.cantidad_aplicada) AS saldo,
producto.tipo_producto, producto.descripcion, producto.concentracion, producto.presentacion,
ingreso.fecha_ing,ingreso.estado,
persona.id_persona,persona.tipo_iden, persona.identificacion, persona.papellido, persona.sapellido, persona.pnombre, persona.snombre
FROM inventario_paciente
INNER JOIN producto ON producto.id_producto=inventario_paciente.id_producto
INNER JOIN ingreso ON ingreso.id_ingreso=inventario_paciente.id_ingreso
INNER JOIN persona ON persona.id_persona=ingreso.id_persona";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_inventario_paciente NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_evolucion_notas AS
SELECT ingreso.id_ingreso, ingreso.jornada,ingreso.fecha_ing,persona.tipo_iden,persona.identificacion,CONCAT(persona.papellido,' ',persona.sapellido) AS apellidos,CONCAT(persona.pnombre,' ',persona.snombre) AS nombres ,persona.fecha_nacim, evolucion_nota.fecha_evol, evolucion_nota.observacion, evolucion_nota.id_operador,evolucion_nota.id_formato,CONCAT(usuario.pnombre,' ',usuario.snombre,' ',usuario.papellido,' ',usuario.sapellido) AS operador,usuario.identificacion AS ident_oper,formatos.descripcion_for,formatos.grupo_for,
cie.codigo_cie,cie.descripcion_cie
FROM evolucion_nota
INNER JOIN ingreso ON ingreso.id_ingreso=evolucion_nota.id_ingreso
INNER JOIN persona ON persona.id_persona=ingreso.id_persona
INNER JOIN persona As usuario ON usuario.id_persona=evolucion_nota.id_operador
INNER JOIN formatos ON formatos.id_formato=evolucion_nota.id_formato
LEFT JOIN cie ON cie.id_cie=ingreso.diag_prin";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_evolucion_notas NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_hcnutricional AS
SELECT ingreso.id_ingreso, ingreso.jornada,ingreso.fecha_ing,nutricional.id_nut,nutricional.fecha_nut,persona.tipo_iden,persona.identificacion,CONCAT(persona.papellido,' ',persona.sapellido) AS apellidos,CONCAT(persona.pnombre,' ',persona.snombre) AS nombres,persona.direccion,persona.telefono ,persona.fecha_nacim,nutricional.edad_actual_nut,nutricional.diarrea_nut,nutricional.estrenim_nut,nutricional.gastritis_nut,nutricional.ulceras_nut,nutricional.nauceas_nut,nutricional.pirosis_nut,nutricional.vomito_nut,nutricional.colitis_nut,nutricional.dentadura_nut,nutricional.otros_nut,nutricional.observacion_nut,nutricional.enfermedad_actual_nut,nutricional.medicamentos_nut,nutricional.cirugia_nut,nutricional.altura_rodilla_nut,nutricional.circ_brazo_nut,nutricional.circ_cadera_nut,nutricional.circ_cintura_nut,nutricional.circ_pantorrilla_nut,nutricional.peso_nut,nutricional.talla_nut,nutricional.dxnutricional_nut,nutricional.id_operador,CONCAT(usuario.pnombre,' ',usuario.snombre,' ',usuario.papellido,' ',usuario.sapellido) AS operador,usuario.identificacion AS ident_oper FROM nutricional
INNER JOIN ingreso ON ingreso.id_ingreso=nutricional.id_ingreso
INNER JOIN persona ON persona.id_persona=ingreso.id_persona
INNER JOIN persona AS usuario ON usuario.id_persona=nutricional.id_operador";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_hcnutricional NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_signos AS
SELECT ingreso.id_ingreso, ingreso.jornada,ingreso.fecha_ing,persona.tipo_iden,persona.identificacion,CONCAT(persona.papellido,' ',persona.sapellido) AS apellidos,CONCAT(persona.pnombre,' ',persona.snombre) AS nombres ,persona.fecha_nacim, signos_vitales.fecha_sign, signos_vitales.tasistol_sign, signos_vitales.tadiasto_sign, signos_vitales.satoxig_sign, signos_vitales.frecard_sign, signos_vitales.frecresp_sign, signos_vitales.temperatura_sign,signos_vitales.observacion_sign, signos_vitales.id_operador, CONCAT(usuario.pnombre,' ',usuario.snombre,' ',usuario.papellido,' ',usuario.sapellido) AS operador,usuario.identificacion AS ident_oper
FROM signos_vitales
INNER JOIN ingreso ON ingreso.id_ingreso=signos_vitales.id_ingreso
INNER JOIN persona ON persona.id_persona=ingreso.id_persona
INNER JOIN persona As usuario ON usuario.id_persona=signos_vitales.id_operador";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_signos NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_consulta AS
SELECT ingreso.id_ingreso, ingreso.jornada,ingreso.fecha_ing,consulta.id_consulta,consulta.fecha_con,persona.tipo_iden,persona.identificacion,CONCAT(persona.papellido,' ',persona.sapellido) AS apellidos,CONCAT(persona.pnombre,' ',persona.snombre) AS nombres,persona.direccion,persona.telefono ,persona.fecha_nacim,consulta.reingreso_con,consulta.quien_con,consulta.motivo_con,consulta.enfermedad_con,consulta.revsistemas_con,consulta.anteced_per_con,consulta.anteced_fam_con,consulta.id_cups,cups.descripcion_cups,consulta.finalidad_con,consulta.causaexte_con,consulta.analisis_con,consulta.plan_con,consulta.diag_prin,cie.codigo_cie,cie.descripcion_cie,consulta.diag_rel1,cierel.codigo_cie AS codigo_cierel1,cierel.descripcion_cie AS descripcion_cierel1,consulta.fecha_reg,consulta.observacion_con,consulta.id_formato,formatos.descripcion_for,formatos.grupo_for,consulta.id_operador,consulta.estado_con,CONCAT(usuario.pnombre,' ',usuario.snombre,' ',usuario.papellido,' ',usuario.sapellido) AS operador,usuario.identificacion AS ident_oper
FROM consulta
INNER JOIN ingreso ON ingreso.id_ingreso=consulta.id_ingreso
INNER JOIN persona ON persona.id_persona=ingreso.id_persona
INNER JOIN cie ON cie.id_cie=consulta.diag_prin
LEFT JOIN cups ON cups.id_cups=consulta.id_cups
LEFT JOIN cie AS cierel ON cierel.id_cie=consulta.diag_rel1
INNER JOIN persona AS usuario ON usuario.id_persona=consulta.id_operador
INNER JOIN formatos ON formatos.id_formato=consulta.id_formato";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_consulta NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_consulta_signos AS
SELECT consulta_signos.id_signo,consulta_signos.id_consulta,consulta_signos.tension_sig,consulta_signos.frec_respi_sig,consulta_signos.frec_card_sig,consulta_signos.temperat_sig,consulta_signos.peso_sig,consulta_signos.talla_sig,consulta_signos.observacion_sig,consulta.fecha_con,ingreso.id_ingreso,persona.id_persona,CONCAT(persona.pnombre,' ',persona.snombre,' ',persona.papellido,' ',persona.sapellido) AS nombre_per
FROM consulta_signos
INNER JOIN consulta ON consulta.id_consulta=consulta_signos.id_consulta
INNER JOIN ingreso ON ingreso.id_ingreso=consulta.id_ingreso
INNER JOIN persona ON persona.id_persona=ingreso.id_persona";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_consulta_signos NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_consulta_examenfisico AS
SELECT consulta_examen_fisico.id_efis,consulta_examen_fisico.id_consulta,consulta_examen_fisico.cabeza_estado_efis,consulta_examen_fisico.cabeza_hallazgo_efis,consulta_examen_fisico.cuello_estado_efis,consulta_examen_fisico.cuello_hallazdo_efis,consulta_examen_fisico.torax_estado_efis,consulta_examen_fisico.torax_hallazgo_efis,consulta_examen_fisico.abdomen_estado_efis,consulta_examen_fisico.abdomen_hallazgo_efis,consulta_examen_fisico.columna_estado_efis,consulta_examen_fisico.columna_hallazgo_efis,consulta_examen_fisico.extremi_estado_efis,consulta_examen_fisico.extremi_hallazgo_efis,consulta.fecha_con,ingreso.id_ingreso,persona.id_persona,CONCAT(persona.pnombre,' ',persona.snombre,' ',persona.papellido,' ',persona.sapellido) AS nombre_per
FROM consulta_examen_fisico
INNER JOIN consulta ON consulta.id_consulta=consulta_examen_fisico.id_consulta
INNER JOIN ingreso ON ingreso.id_ingreso=consulta.id_ingreso
INNER JOIN persona ON persona.id_persona=ingreso.id_persona";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_consulta_examenfisico NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_factura AS
SELECT encabezado_factura.id_factura,encabezado_factura.id_persona,persona.tipo_iden,persona.identificacion,CONCAT(persona.papellido,' ',persona.sapellido) AS apellidos, CONCAT(persona.pnombre,' ',persona.snombre) AS nombres,persona.direccion,persona.telefono,encabezado_factura.id_eps,eps.nombre_eps,encabezado_factura.numero_fac,encabezado_factura.fecha_ini,encabezado_factura.fecha_fin,encabezado_factura.fecha_fac,encabezado_factura.id_ccob,encabezado_factura.autoriza_fac,encabezado_factura.valor_total,encabezado_factura.estado_fac,encabezado_factura.id_cie,cie.codigo_cie,cie.descripcion_cie,encabezado_factura.id_operador,usuario.identificacion AS ident_oper,CONCAT(usuario.pnombre,' ',usuario.snombre,' ',usuario.papellido,' ',usuario.sapellido) AS operador FROM encabezado_factura
INNER JOIN persona ON persona.id_persona=encabezado_factura.id_persona
INNER JOIN persona AS usuario ON usuario.id_persona=encabezado_factura.id_operador
INNER JOIN eps ON eps.id_eps=encabezado_factura.id_eps
INNER JOIN cie ON cie.id_cie=encabezado_factura.id_cie";
//echo $sql;
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_factura NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_usuarios_factura_rips AS
SELECT encabezado_factura.id_factura,encabezado_factura.id_persona,persona.tipo_iden,persona.identificacion,persona.papellido,persona.sapellido,persona.pnombre,persona.snombre,TRUNCATE(DATEDIFF(CURRENT_DATE(),persona.fecha_nacim)/365.25,0) as edad,persona.sexo,
	paciente.mun_reside,paciente.zona_reside,
	encabezado_factura.id_eps,eps.nombre_eps,encabezado_factura.numero_fac,encabezado_factura.id_ccob,encabezado_factura.estado_fac
FROM encabezado_factura
INNER JOIN persona ON persona.id_persona=encabezado_factura.id_persona
INNER JOIN paciente ON paciente.id_persona=persona.id_persona
INNER JOIN eps ON eps.id_eps=encabezado_factura.id_eps
INNER JOIN cie ON cie.id_cie=encabezado_factura.id_cie";
//echo $sql;
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_usuarios_factura_rips NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_detalle_fac AS
SELECT detalle_factura.id_detalle,detalle_factura.id_factura,
encabezado_factura.numero_fac,encabezado_factura.id_ccob,encabezado_factura.estado_fac
,detalle_factura.id_cups,cups.codigo_cups,cups.descripcion_cups,detalle_factura.cantidad_det,detalle_factura.valor_unitario,(detalle_factura.cantidad_det*detalle_factura.valor_unitario) AS valor_total 
FROM detalle_factura
INNER JOIN encabezado_factura ON encabezado_factura.id_factura=detalle_factura.id_factura
INNER JOIN cups ON cups.id_cups=detalle_factura.id_cups";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_detalle_fac NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_detalle_fac_rips AS
SELECT detalle_factura.id_detalle,detalle_factura.id_factura,
encabezado_factura.numero_fac,encabezado_factura.id_ccob,encabezado_factura.autoriza_fac,encabezado_factura.estado_fac,
persona.tipo_iden,persona.identificacion,
detalle_factura.id_cups,cups.codigo_cups,cups.descripcion_cups,detalle_factura.cantidad_det,detalle_factura.valor_unitario,(detalle_factura.cantidad_det*detalle_factura.valor_unitario) AS valor_total 
FROM detalle_factura
INNER JOIN encabezado_factura ON encabezado_factura.id_factura=detalle_factura.id_factura
INNER JOIN persona ON persona.id_persona=encabezado_factura.id_persona
INNER JOIN cups ON cups.id_cups=detalle_factura.id_cups";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_detalle_fac_rips NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_detalle_ccob AS
SELECT detalle_factura.id_detalle,detalle_factura.id_factura,
encabezado_factura.numero_fac,encabezado_factura.autoriza_fac,encabezado_factura.id_persona,
persona.tipo_iden,persona.identificacion,persona.papellido,persona.sapellido,persona.pnombre,persona.snombre,TRUNCATE(datediff(CURRENT_DATE,persona.fecha_nacim)/365.25,0) AS edad,persona.sexo,
encabezado_factura.id_cie,cie.codigo_cie,cie.descripcion_cie,encabezado_factura.id_eps,encabezado_factura.id_ccob,encabezado_factura.valor_total
,detalle_factura.id_cups,cups.codigo_cups,cups.descripcion_cups,detalle_factura.cantidad_det,detalle_factura.valor_unitario,(detalle_factura.cantidad_det*detalle_factura.valor_unitario) AS total,encabezado_factura.estado_fac
FROM detalle_factura
INNER JOIN encabezado_factura ON encabezado_factura.id_factura=detalle_factura.id_factura
INNER JOIN persona ON persona.id_persona=encabezado_factura.id_persona
INNER JOIN cups ON cups.id_cups=detalle_factura.id_cups
INNER JOIN cie ON cie.id_cie=encabezado_factura.id_cie
WHERE encabezado_factura.estado_fac='C'";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_detalle_ccob NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_usuario_formato AS
SELECT usuario_sist.id_persona,usuario_sist.registro,usuario_sist.id_formato,formatos.grupo_for,formatos.descripcion_for 
FROM usuario_sist 
INNER JOIN formatos ON formatos.id_formato=usuario_sist.id_formato";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_usuario_formato NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_cie AS
SELECT cie.id_cie,cie.codigo_cie,cie.descripcion_cie,cie.estado_cie,CONCAT(cie.codigo_cie,' ',cie.descripcion_cie) AS nombre_cie FROM cie";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_cie NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_cups AS
SELECT cups.id_cups,cups.codigo_cups,cups.descripcion_cups,cups.estado_cups,CONCAT(cups.codigo_cups,' ',cups.descripcion_cups) AS nombre_cups FROM cups";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_cups NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_menu_usuario AS
SELECT menu_usuario.id_menu_usu,menu.id_menu,menu.descripcion,menu.dependencia,menu.nivel,menu.url,menu_usuario.nuevo,menu_usuario.editar,menu_usuario.eliminar,persona.id_persona,persona.identificacion,CONCAT(persona.pnombre,persona.snombre,persona.papellido,persona.sapellido) AS nombre FROM menu_usuario 
LEFT JOIN menu ON menu.id_menu=menu_usuario.id_menu LEFT JOIN persona ON persona.id_persona=menu_usuario.id_persona";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_menu_usuario NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_cuenta_cobro AS
SELECT cuenta_cobro.id_ccob,cuenta_cobro.numero_ccob,cuenta_cobro.id_eps,eps.codigo_admin,eps.nit,eps.nombre_eps,cuenta_cobro.fecha_ccob,cuenta_cobro.fecha_inicio,cuenta_cobro.fecha_fin,cuenta_cobro.concepto_ccob,cuenta_cobro.estado_ccob
FROM cuenta_cobro
INNER JOIN eps ON eps.id_eps=cuenta_cobro.id_eps";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_cuenta_cobro NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_finalidad AS
SELECT detalle_grupo.codi_det,detalle_grupo.id_grupo,detalle_grupo.descripcion_det,detalle_grupo.valor_det
FROM detalle_grupo
WHERE detalle_grupo.id_grupo='1'";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_finalidad NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_causaexterna AS
SELECT detalle_grupo.codi_det,detalle_grupo.id_grupo,detalle_grupo.descripcion_det,detalle_grupo.valor_det
FROM detalle_grupo
WHERE detalle_grupo.id_grupo='2'";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_causaexterna NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_via AS
SELECT detalle_grupo.codi_det,detalle_grupo.id_grupo,detalle_grupo.descripcion_det,detalle_grupo.valor_det
FROM detalle_grupo
WHERE detalle_grupo.id_grupo='3'";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_via NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_tipo_orden AS
SELECT detalle_grupo.codi_det,detalle_grupo.id_grupo,detalle_grupo.descripcion_det,detalle_grupo.valor_det
FROM detalle_grupo
WHERE detalle_grupo.id_grupo='4'";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_tipo_orden NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_consulta_formula_detalle AS
SELECT consulta_formula_detalle.id_form_det,consulta_formula_detalle.id_form,consulta_formula_detalle.id_producto,
producto.codigo_producto,producto.descripcion,producto.concentracion,producto.presentacion,
consulta_formula_detalle.dosis_det,consulta_formula_detalle.frecuencia_det,consulta_formula_detalle.via_det,detalle_grupo.descripcion_det AS via,consulta_formula_detalle.tiempo_trat_det,consulta_formula_detalle.cantidad_det,consulta_formula_detalle.observacion_det,
consulta_formula.id_consulta,consulta.estado_con
FROM consulta_formula_detalle
INNER JOIN consulta_formula ON consulta_formula.id_form=consulta_formula_detalle.id_form
INNER JOIN consulta ON consulta.id_consulta=consulta_formula.id_consulta
INNER JOIN producto ON producto.id_producto=consulta_formula_detalle.id_producto
LEFT JOIN detalle_grupo ON detalle_grupo.codi_det=consulta_formula_detalle.via_det";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_consulta_formula_detalle NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_consulta_orden_detalle AS
SELECT consulta_orden_detalle.id_ord_detalle,consulta_orden_detalle.id_orden,consulta_orden_detalle.id_cups,cups.codigo_cups,cups.descripcion_cups,consulta_orden_detalle.observacion_det,
consulta_orden.id_consulta,consulta_orden.tipo_ord,detalle_grupo.descripcion_det AS desc_tipo_orden,consulta.estado_con
FROM consulta_orden_detalle
INNER JOIN consulta_orden ON consulta_orden.id_orden=consulta_orden_detalle.id_orden
INNER JOIN consulta ON consulta.id_consulta=consulta_orden.id_consulta
INNER JOIN detalle_grupo ON detalle_grupo.codi_det=consulta_orden.tipo_ord
INNER JOIN cups ON cups.id_cups=consulta_orden_detalle.id_cups";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_consulta_orden_detalle NO creada";
}

$sql="CREATE OR REPLACE VIEW vw_consulta_orden AS
SELECT 
consulta_orden.id_orden,consulta_orden.id_consulta,consulta_orden.tipo_ord,detalle_grupo.descripcion_det AS desc_tipo_orden,consulta.estado_con
FROM consulta_orden
INNER JOIN consulta ON consulta.id_consulta=consulta_orden.id_consulta
INNER JOIN detalle_grupo ON detalle_grupo.codi_det=consulta_orden.tipo_ord";
$vw=$link->query($sql);
if($vw==0){
    echo "<br>vw_consulta_orden NO creada";
}

echo "<br><br><h4>Creacion de Vistas Finalizada</h4>";
?>