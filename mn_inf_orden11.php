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
<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>        
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <title>Medinet</title>
    </head>
<body class="body3">
<?php

require("mn_funciones.php");
$link=conectarbd();
$consulta="SELECT fecha_con,CONCAT(nombres,' ',apellidos) AS nombre,fecha_nacim,TRUNCATE((DATEDIFF(fecha_con,fecha_nacim))/365.25,0) AS edad, direccion, telefono,ident_oper FROM vw_consulta WHERE id_consulta='$_POST[id_consulta]'";
//echo $consulta;
$consulta=$link->query($consulta);
$row=$consulta->fetch_array(MYSQLI_ASSOC);
encabezado("ORDENES");
?>
<br>
<br>
<table class="Tbl3">
    <tr>
        <td>Fecha: <?php echo cambiafechadmy($row['fecha_con']);?></td>        
        <td>No de Consulta:  <?php echo $_POST['id_consulta'];?></td>
    </tr>
</table>
<br><h5>IDENTIFICACION</h5>
<table class="Tbl3">
    <tr>
        <td>Nombre:</td>
        <td><?php echo $row['nombre'];?></td>
        <td>Fecha de Nacimiento:</td>
        <td><?php echo cambiafechadmy($row['fecha_nacim']);?></td>
    </tr>
    <tr>
        <td>Domicilio/Telefono:</td>
        <td><?php echo $row['direccion'].' - '.$row['telefono'];?></td>
        <td>Edad:</td>
        <td><?php echo $row['edad'];?></td>
    </tr>
</table>

<?php
$consultaord="SELECT id_orden,desc_tipo_orden FROM vw_consulta_orden WHERE id_consulta='$_POST[id_consulta]'";
//echo $consultaord;
$consultaord=$link->query($consultaord);
if($consultaord->num_rows<>0){
    while($roword=$consultaord->fetch_array()){
        echo "<br><h5>".$roword['desc_tipo_orden']."</h5>";

        $consultadet="SELECT codigo_cups,descripcion_cups,observacion_det FROM vw_consulta_orden_detalle WHERE id_orden='$roword[id_orden]'";
        //echo $consultadet;
        $consultadet=$link->query($consultadet);
        if($consultadet->num_rows<>0){
            ?>            
            <table class="Tbl3">
                <th>CODIGO</th>
                <th>DESCRIPCION</th>
                <th>OBSERVACION</th>                
            <?php
            while($rowdet=$consultadet->fetch_array()){
                echo "<tr>";
                echo "<td>$rowdet[codigo_cups]</td>";
                echo "<td>$rowdet[descripcion_cups]</td>";
                echo "<td>$rowdet[observacion_det]</td>";                
                echo "</tr>";
            }
            ?>
            </table>
            <?php
        }
    }
}

$firma='firmas/'.$row['ident_oper'].'.jpg';
echo "<br><table class='Tbl3'>";
echo "<tr>";
if(file_exists($firma)){
    echo "<td width='30%' align='center'><img src='$firma' width='150' height='80'></td>";
}
else{          
    echo "<td width='30%' align='center'>$row[ident_oper]</td>";
}
echo "</tr>";
echo "<tr>";
echo "<td width='30%' align='center'>FIRMA</td>";
echo "<td width='30%' align='center'>SELLO</td>";
echo "</tr>";
echo "</table>"
?>

<?php
mysqli_free_result($consulta);
mysqli_close($link);

function encabezado($formato){
  ?>
  <table class="Tbl3">
      <tr>
          <td width="30%"><img src="icons/logosursalud.png" width="200" height="80"></td>
          <td width="70%" align="center"><h4><?php echo $formato;?></h4></td>
      </tr>
  </table>  
  <br>
  Nit. 900.751.760-6
  <?php
}
?>

<script type="text/javascript">
//function imprimir() {
    window.print();
    //window.close();
//}
</script>
