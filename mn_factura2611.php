<?php
require("mn_funciones.php");

$link=conectarbd();
$sql_="UPDATE nrusuario SET  
tipo_documento='$_POST[tipo_documento]',
numdocumento='$_POST[numdocumento]',
tipousuario='$_POST[tipousuario]',
fechanacimiento='$_POST[fechanacimiento]',
codsexo='$_POST[codsexo]',
codpaisresidencia='$_POST[codpaisresidencia]',
codmunicipioresidencia='$_POST[codmunicipioresidencia]',
codzonaresidencia='$_POST[codzonaresidencia]',
incapacidad='$_POST[incapacidad]',
codpaisorigen='$_POST[codpaisorigen]'
WHERE id_usuario='$_POST[id_usuario]'";
//echo "<br>".$sql_;
$link->query($sql_);

if($link->affected_rows > 0){
    echo "1";
}
else{
    echo "0";
}

?>