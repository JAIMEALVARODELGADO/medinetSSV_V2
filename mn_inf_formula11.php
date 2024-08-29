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
$consulta="SELECT fecha_con,CONCAT(nombres,' ',apellidos) AS nombre,fecha_nacim,TRUNCATE((DATEDIFF(fecha_con,fecha_nacim))/365.25,0) AS edad, direccion, telefono,ident_oper,tipo_iden,identificacion
    FROM vw_consulta WHERE id_consulta='$_POST[id_consulta]'";
//echo $consulta;
$consulta=$link->query($consulta);
$row=$consulta->fetch_array(MYSQLI_ASSOC);
encabezado("FORMULA MEDICA");
?>
<br>
<br>
<table class="Tbl3">
    <tr>
        <td>Fecha: <?php echo cambiafechadmy($row['fecha_con']);?></td>        
        <td>No de Consulta:  <?php echo $_POST['id_consulta'];?></td>
    </tr>
</table>
<br><h4>IDENTIFICACION</h4>
<table class="Tbl3">
    <tr>
        <td>Identificación:</td>
        <td><?php echo $row['tipo_iden'].' '.$row['identificacion'];?></td>
    </tr>
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
$consultafor="SELECT codigo_producto, descripcion, concentracion, presentacion, dosis_det, frecuencia_det, via, tiempo_trat_det, cantidad_det, observacion_det FROM vw_consulta_formula_detalle WHERE id_consulta='$_POST[id_consulta]'";
//echo $consultafor;
$consultafor=$link->query($consultafor);
if($consultafor->num_rows<>0){
    //$rowfor=$consultafor->fetch_array(MYSQLI_ASSOC);
    ?>
    <br><br>
    <table class="Tbl3">
        <th>CODIGO</th>
        <th>DESCRIPCION</th>
        <th>CONCENTRACION</th>
        <th>PRESENTACION</th>
        <th>DOSIS</th>
        <th>FRECUENCIA</th>
        <th>VIA</th>        
        <th>TIEMPO</th>
        <th>CANTIDAD</th>
        <?php
        while($rowfor=$consultafor->fetch_array()){            
            echo "<tr>";
            echo "<td>$rowfor[codigo_producto]</td>";
            echo "<td>$rowfor[descripcion]</td>";
            echo "<td>$rowfor[concentracion]</td>";
            echo "<td>$rowfor[presentacion]</td>";
            echo "<td>$rowfor[dosis_det]</td>";
            echo "<td>$rowfor[frecuencia_det]</td>";
            echo "<td>$rowfor[via]</td>";
            echo "<td>$rowfor[tiempo_trat_det]</td>";
            echo "<td align='right'>$rowfor[cantidad_det]</td>";
            echo "</tr>";
            echo "<tr>";            
            echo "<td colspan='9'>Observacion: $rowfor[observacion_det]</td>";            
            echo "</tr>";
        }
        ?>
    </table>
    <?php
}

$firma='firmas/'.$row['ident_oper'].'.jpg';
echo "<table class='Tbl3'>";
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
