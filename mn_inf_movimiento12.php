<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>        
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <meta description="Registro y cotrol de actividades asistenciales"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <link rel="stylesheet" type="text/css" href="fonts/style.css">
        <title>Medinet</title>
    </head>
<body class="body2">
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
require("mn_funciones.php");
$link=conectarbd();
//echo $_POST['sql_'];
$consulta=$link->query($_POST['sql_']);
$id_ingreso=-1;
$producto=-1;
encabezado();
while($row=$consulta->fetch_array(MYSQLI_ASSOC)){
    if($id_ingreso!=$row['id_ingreso']){
      ?>
      </table>
      <br><br>
      <table class="Tbl3">
        <tr>
          <td>Nro. Ingreso: <?php echo $row['id_ingreso'];?></td>
        </tr>
        <tr>
          <td>Fecha de Ingreso: <?php echo $row['fecha_ing'];?></td>
        </tr>
        <tr>
          <td colspan="2">Identificación: <?php echo $row['tipo_iden'].' '.$row['identificacion'];?></td>
          <td colspan="3">Nombre: <?php echo $row['nombres'].' '.$row['apellidos'];?></td>
        </tr>        
      </table>
      <?php      
      $id_ingreso=$row['id_ingreso'];      
      ?>      
      <?php
    }
    if($producto!=$row['id_producto']){
      ?>
      <table class="Tbl2">
      <th class="Th1">Medicamento/Dispositivo Médico</th>
      <th class="Th1">Fecha Mov</th>
      <th class="Th1">Ingresos</th>
      <th class="Th1">Egresos</th>
      <th class="Th1">Saldo</th>      
      <?php
      $producto=$row['id_producto'];
      ?>
      <tr>
        <td><?php echo $row['producto'];?></td>
      </tr>
      <?php
      $saldo=0;      
    }
    ?>
    <tr>
      <td></td>
      <td><?php echo $row['fecha_mov'];?></td>
    <?php
    if($row['tipo_mov']=='I'){
      ?>        
        <td align="right"><?php echo $row['cantidad'];?></td>
        <td></td>
      <?php
      $saldo=$saldo+$row['cantidad'];
    }
    else{
      ?>
        <td></td>
        <td align="right"><?php echo $row['cantidad'];?></td>
      <?php
      $saldo=$saldo-$row['cantidad'];
    }
    ?>
    <td align="right"><?php echo $saldo;?></td>
    </tr>
    <?php
}

mysqli_free_result($consulta);
mysqli_close($link);
//$pdf->Output();


function encabezado(){
  ?>
  <img src="icons/encabezado_movimedicamento.png" width="100%" height="80">
  <br>
  <?php
}
?>

<script type="text/javascript">
//function imprimir() {
    window.print();
    //window.close();
//}
</script>
