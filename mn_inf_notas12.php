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
$consulta=$link->query($_POST['sql_']);
$id_ingreso='';
encabezado();
?>
<h2 style="color:black;text-align: center"><?php echo $_POST['descripcion_for'];?></h2>
<?php
while($row=$consulta->fetch_array(MYSQLI_ASSOC)){
    if($id_ingreso<>$row['id_ingreso']){
      ?>
      </table>
      <br><br>
      <table class="Tbl3">
        <tr>
          <td colspan="3">Nombre: <?php echo $row['nombres'].' '.$row['apellidos'];?></td>
          <td align="right">Nro. Ingreso: <?php echo $row['id_ingreso'];?></td>
        </tr>
        <tr>
          <td colspan="3">Identificación: <?php echo $row['tipo_iden'].' '.$row['identificacion'];?></td>
          <td align="right">Fecha de Ingreso: <?php echo $row['fecha_ing'];?></td>
        </tr>
        <tr>
          <td colspan="4">Diagnóstico de Ingreso: <?php echo $row['codigo_cie'].' '.$row['descripcion_cie'];?></td>
        </tr>        
      </table>
      <?php      
      $id_ingreso=$row['id_ingreso'];      
      ?>
      <table class="Tbl2">
      <th class="Th1" width="10%">Fecha y Hora</th>
      <th class="Th1" width="80%">Observación</th>
      <th class="Th1" width="10%">Firma</th>      
      <?php
      $id_ingreso=$row['id_ingreso'];
    }
    ?>
    <tr>
      <td><?php echo $row['fecha_evol'];?></td>
      <td><?php echo $row['observacion'];?></td>      
      <td>
        <?php
        $firma='firmas/'.$row['ident_oper'].'.jpg';
        if(file_exists($firma)){
          echo "<img src='$firma' width='80' height='50'>";
        }
        else{
          echo $row['ident_oper'];
        }
        ?>
      </td>
    </tr>
    <?php
}
mysqli_free_result($consulta);
mysqli_close($link);

function encabezado(){
  ?>
  <img src="icons/encabezado_notasenferme.png" width="100%" height="80">
  <br>
  <?php
}
?>

<script type="text/javascript">
//function imprimir() {
    //window.print();
    //window.close();
//}
</script>