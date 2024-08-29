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
//require("mn_menu_cups.php");
$ruta='';
if(isset($_POST['ruta'])){$ruta=$_POST['ruta'];}
?>
<form name='form1' method="post" action="mn_backup1.php">
    <br><h3>Copia de seguridad de base de datos</h3>
    <br>Ruta: <input type='text' name='ruta' size='80' maxleng='200' value='<?php echo $ruta;?>'>
    
    <button type="button" onclick='validar()'><span class="icon-save"></span> Iniciar</button>
    <?php
    if(!empty($ruta)){
        $dbhost = 'localhost';
        $dbname = 'medinet_bd';
        $dbuser = 'root';
        $dbpass = '654321';
        //$backup_file = 'C:\\Users\\USUARIO\\Downloads\\'.$dbname. "-" .date("Y-m-d-H-i-s"). ".sql";
        $backup_file = $ruta.$dbname. "-" .date("Y-m-d-H-i-s"). ".sql";
        //echo "<br>".$backup_file;
        $comando="C:/xampp/mysql/bin/mysqldump --opt -u $dbuser -p$dbpass -h $dbhost -v $dbname > $backup_file";
        exec($comando,$output,$retorna);
        if($retorna==0){
            echo "<br><h3>Copia realizada con exito</h3>";
        }
        else{
             echo "<br><h3>La copia no se pudo realizar, pofavor verifique la ruta</h3>";
        }
    }
    ?>
    
</form>
</body>
</html>
