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
        <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
        <meta description="Registro y cotrol de medicamentos"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <title>Medinet</title>
    </head>
    <script language="JavaScript">
        function continuar(msg_){
            alert(msg_);
            document.form1.submit();
        }
    </script>
<?php
require("mn_funciones.php");
//require("pp_menu.php");
$link=conectarbd();

$ruta = 'firmas/'; //Decalaramos una variable con la ruta en donde almacenaremos los archivos
opendir($ruta);
$destino = $ruta.$_FILES['firma']['name'];
copy($_FILES['firma']['tmp_name'],$destino);
$nombre=$_FILES['firma']['name'];
echo "<img src='firmas/$nombre' width='200 px'>";

$error = $_FILES['firma']['error'];
if ($error!=''){//Si existio algún error retornamos un el error por cada archivo.
    $mensaje = "No se pudo subir el archivo ".$nombre." debido al siguiente Error: ".$error; 
}
else{
    $mensaje = "Archivo subido con éxito"; 
}

/*foreach ($_FILES as $archivo){ //Iteramos el arreglo de archivos
    echo "ARCHIVO:... ".$archivo['name'];
    if($archivo['error'] == UPLOAD_ERR_OK ){//Si el archivo se paso correctamente continuamos 
        $NombreOriginal = $archivo['name'];//Obtenemos el nombre original del archivo
        $temporal = $archivo['tmp_name']; //Obtenemos la ruta Original del archivo
        $extension=explode(".", $NombreOriginal);//Obtengo la extension del archivo
        $extension=end($extension);
        $nuevonombre=$id_adjunto.".".$extension;
        $destino = $ruta.$nuevonombre;	//Creamos una ruta de destino con la variable ruta y el nombre original del archivo
        move_uploaded_file($temporal, $destino); //Movemos el archivo temporal a la ruta especificada
        echo "<br>Destino:... ".$destino;
    }
    if ($archivo['error']==''){ //Si no existio ningun error, retornamos un mensaje por cada archivo subido
        $mensaje .= 'Archivo '.$NombreOriginal.' Subido correctamente.';
        $sql="UPDATE consulta_adjunto SET archivo_adj='$nuevonombre' WHERE id_adjunto='$id_adjunto'";
        //echo $sql;
        $res=mysqli_query($conexion,$sql);
    }
    if ($archivo['error']!=''){//Si existio algún error retornamos un el error por cada archivo.
        $mensaje .= 'No se pudo subir el archivo '.$NombreOriginal.' debido al siguiente Error: n'.$archivo['error']; 
    }
}*/

?>
<body onload="continuar('<?php echo $mensaje;?>')">
<form name='form1' method="post" action="mn_firma1.php">
    <?php 
    echo "<br>".$mensaje;    
    ?>
</form>
</body>
</html>