<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <head>        
        <meta charset="UTF-8"/>
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <title>Medinet</title>
    </head>
<body>
<header>
    <h3>Medinet</h3>
    <h5>Sistema de Información Asistencial</h5>
    <figure></figure>    
</header>
<script language='JavaScript'>
    function continuar(msg_){
        if(msg_!=''){
            alert(msg_);
            document.form1.action='index.html';
            document.form1.submit();
        }
        else{
            //document.form1.action='frm_inicio.html';
            document.form1.submit();
        }
    }
</script>
<?PHP
require('mn_funciones.php');
$password=SHA1($_POST['password']);
$link=conectarbd();
$consulta="SELECT id_persona,CONCAT(pnombre,' ',snombre,' ',papellido,' ',sapellido) AS nombre FROM vw_usuario_sist 
WHERE password='$password' AND login='$_POST[login]' AND estado='AC'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
$msg='';

if($consulta->num_rows == 0){
    $msg="Usuario no registrado";
}
else{
    $row=$consulta->fetch_array();
    /*$consulta="SELECT id_usuario,nombre FROM usuario WHERE password='$password' AND login='$_POST[login]' AND activo='S'";
    $result = mysqli_query($link, $consulta);
    $row=mysqli_fetch($result)
    echo "<br>".$row[0];*/
    $_SESSION['gid_usuario']=$row['id_persona'];
    $_SESSION['gnombre']=$row['nombre'];
}
mysqli_close($link);
?>
<form name='form1' method="post" action="frm_inicio.html">
<script language="JavaScript">
    continuar('<?php echo $msg;?>');
</script>

</form>
</body>
</html>
