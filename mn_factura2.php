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
        function eliminar(id_){
            if(confirm("Desea eliminar la factura?\n")){
                window.open("mn_factura22.php?id_factura="+id_,"_self");
            }
        }
        function editar(id_){
            window.open("mn_factura1.php?id_factura="+id_,"_self");
        }
        function erroreditar(){
            alert("La factura se encuentra cerrada");
        }
        function cerrar_fac(id_,total_){
            mensaje="";
            if(total_==0){
                alert("No se pueden cerrar facturas en cero(0)");
            }
            else{
                mensaje+="Recuerde que al cerrar la factura no podrá editarla.\nDesea cerrarla?";
                if(confirm(mensaje)){
                    window.open("mn_factura23.php?id_factura="+id_,"_self");
                }
            }
        }
        function anular(id_){
            if(confirm("Desea anular la factura?\n")){
                window.open("mn_factura24.php?id_factura="+id_,"_self");
            }
        }
        function imprimir(id_){
            window.open("mn_factura25.php?id_factura="+id_,"_new");
        }

        function editarRips_fac(id_){
            window.open("mn_factura261.php?id_factura="+id_,"_self");
        }
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_factura.php");
$id_factura='';
$identificacion='';
$apellidos='';
$nombres='';
$orden='';
$numero='';
$fecha='';
$cuenta='';
$eps='';
$estado='';
if(isset($_POST['id_factura'])){$id_factura=$_POST['id_factura'];}
if(isset($_POST['identificacion'])){$identificacion=$_POST['identificacion'];}
if(isset($_POST['apellidos'])){$apellidos=$_POST['apellidos'];}
if(isset($_POST['nombres'])){$nombres=$_POST['nombres'];}
if(isset($_POST['orden'])){$orden=$_POST['orden'];}
if(isset($_POST['numero'])){$numero=$_POST['numero'];}
if(isset($_POST['fecha'])){$fecha=$_POST['fecha'];}
if(isset($_POST['cuenta'])){$cuenta=$_POST['cuenta'];}
if(isset($_POST['eps'])){$eps=$_POST['eps'];}
if(isset($_POST['estado'])){$estado=$_POST['estado'];}
?>
<form name='form1' method="post" action="mn_factura2.php">
    <span class="form-el"><input type='text' id='identificacion' name='identificacion' maxlength='20' size='20' placeholder='Identificación' value="<?php echo $identificacion;?>"/></span>
    <span class="form-el"><input type='text' id='nombres' name='nombres' maxlength='30' size='30' placeholder='Nombres' value="<?php echo $nombres;?>"/></span>
    <span class="form-el"><input type='text' id='apellidos' name='apellidos' maxlength='30' size='30' placeholder='Apellidos' value="<?php echo $apellidos;?>"/></span>
    <span class="form-el">Eps:
        <select id='eps' name='eps' value="<?php echo $eps;?>">
            <option value=''>Todas</option>
            <?php
            $consultaeps="SELECT id_eps,nombre_eps FROM eps ORDER BY nombre_eps";
            //echo "<br>".$consultaeps;
            $consultaeps=$link->query($consultaeps);
            if($consultaeps->num_rows<>0){
                while($roweps=$consultaeps->fetch_array()){
                    echo "<option value='$roweps[id_eps]'>$roweps[nombre_eps]</option>";
                }
            }
            ?>
        </select>
    </span>
    <br>
    <span class="form-el">Fecha:<input type='date' id='fecha' name='fecha' placeholder='Fecha' value="<?php echo $fecha;?>"/></span>
    <span class="form-el"><input type='text' id='numero' name='numero' maxlength='7' size='6' placeholder='Numero' value="<?php echo $numero;?>"/></span>
    <span class="form-el"><input type='text' id='cuenta' name='cuenta' maxlength='8' size='6' placeholder='Cuenta' value="<?php echo $cuenta;?>"/></span>
    <span class="form-el">Estado:
        <select id='estado' name='estado' value="<?php echo $estado;?>">
            <option value=''>Todos</option>
            <option value='A'>Abierta</option>
            <option value='C'>Cerrada</option>
            <option value='N'>Anulada</option>
        </select>
    </span>


    <span class="form-el">Orden:
        <select id='orden' name='orden' value="<?php echo $orden;?>">
            <option value='numero_fac'>Num.Factura</option>
            <option value='identificacion'>Identificación</option>
            <option value='apellidos'>Apellidos</option>
            <option value='nombres'>Nombres</option>
            <option value='fecha_fac'>Fecha de Facturación</option>
        </select>
    </span>
    <a href="#" onclick='validar();' title='Buscar'><span class="icon-magnifying-glass"></span> </a>
<?php
$condicion="";
if(!empty($id_factura)){$condicion=$condicion."id_factura='$id_factura' AND ";}
if(!empty($id_ingreso)){$condicion=$condicion."id_ingreso='$id_ingreso' AND ";}
if(!empty($identificacion)){$condicion=$condicion."identificacion='$identificacion' AND ";}
if(!empty($apellidos)){$condicion=$condicion."apellidos LIKE '%$apellidos%' AND ";}
if(!empty($nombres)){$condicion=$condicion."nombres LIKE '%$nombres%' AND ";}
if(!empty($numero)){$condicion=$condicion."numero_fac LIKE '%$numero%' AND ";}
if(!empty($fecha)){$condicion=$condicion."fecha_fac LIKE '%$fecha%' AND ";}
if(!empty($cuenta)){$condicion=$condicion."id_ccob LIKE '%$cuenta%' AND ";}
if(!empty($eps)){$condicion=$condicion."id_eps LIKE '%$eps%' AND ";}
if(!empty($estado)){$condicion=$condicion."estado_fac LIKE '%$estado%' AND ";}
if(!empty($condicion)){
    $condicion=substr($condicion,0,-5);
    //echo "<br>".$condicion;
    if(empty($orden)){$orden='identificacion';}
    $consulta="SELECT id_factura,tipo_iden,identificacion,nombres,apellidos,fecha_fac,numero_fac,id_ccob,estado_fac,valor_total,nombre_eps FROM vw_factura WHERE ".$condicion." ORDER BY ".$orden;
    //echo "<br>".$consulta;
    $consulta=$link->query($consulta);
    if($consulta->num_rows<>0){
        echo "<br><br><table width='100%'>";
        echo "<th colspan='5'>Opciones</th>".
            "<th>Tp.Iden.</th>".
            "<th>Identificación.</th>".
            "<th>Nombres</th>".
            "<th>Apellidos</th>".
            "<th>Fecha Fac.</th>",
            "<th>Número</th>",
            "<th>Cuenta</th>",
            "<th>EPS</th>",
            "<th>Estado</th>";
        while($row=$consulta->fetch_array()){
            switch ($row['estado_fac']){
                case 'A':
                    $estado='Abierta';
                    break;
                case 'C':
                    $estado='Cerrada';
                    break;
                case 'N':
                    $estado='Anulada';
                    break;
            }
            echo "<tr>";
            if($row['estado_fac']=='A'){
                echo "<td width='5%'><a href='#' onclick=editar($row[id_factura]) title='Editar Factura' class='btnhref'><span class='icon-edit'></span></a></td>";
            }
            else{
                echo "<td width='5%'><a href='#' onclick=erroreditar() class='btnhref' title='Editar Factura'><span class='icon-edit'></span></a></td>";
            }
            if($row['estado_fac']=='A'){
                echo "<td width='5%'><a href='#' onclick=eliminar($row[id_factura],$row[identificacion]) title='Eliminar Factura' class='btnhref'><span class='icon-trash'></span></a></td>";
            }
            else{
                if($row['estado_fac']=='C'){
                    echo "<td width='5%'><a href='#' onclick=anular($row[id_factura]) title='Anular Factura' class='btnhref'><span class='icon-circle-with-cross '></span></a></td>";
                }
                else{
                    echo "<td width='5%'><a href='#' class='btnhref' title='Anular Factura'><span class='icon-circle-with-cross '></span></a></td>";
                }                    
            }
            if($row['estado_fac']=='A'){
                echo "<td width='5%'><a href='#' onclick=cerrar_fac($row[id_factura],$row[valor_total]) title='Cerrar Factura' class='btnhref'><span class='icon-lock'></span></a></td>";
            } 
            else{
                echo "<td width='5%'><a href='#' onclick=erroreditar() title='Cerrar Factura' class='btnhref'><span class='icon-lock'></span></a></td>";
            }
            echo "<td width='5%'><a href='#' onclick=imprimir($row[id_factura]) title='Imprimir Factura' class='btnhref'><span class='icon-print'></span></a></td>";
            if($row['estado_fac']=='C'){                
                echo "<td width='5%'><a href='#' onclick=editarRips_fac($row[id_factura],$row[valor_total]) title='RIPS' class='btnhref'><span class='icon-open-book'></span></a></td>";
            } 
            else{
                echo "<td width='5%'><a href='#' onclick=erroreditar() title='RIPS' class='btnhref'><span class='icon-open-book'></span></a></td>";
            }            

            echo "<td>$row[tipo_iden]</td>";
            echo "<td>$row[identificacion]</td>";
            echo "<td>$row[nombres]</td>";
            echo "<td>$row[apellidos]</td>";
            echo "<td>$row[fecha_fac]</td>";
            echo "<td>$row[numero_fac]</td>";
            echo "<td>$row[id_ccob]</td>";
            echo "<td>$row[nombre_eps]</td>";
            echo "<td>$estado</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
}

?>
<script language="JavaScript">
    document.form1.orden.value='<?php echo $orden;?>';
    document.form1.eps.value='<?php echo $eps;?>';
    document.form1.estado.value='<?php echo $estado;?>';
</script>
</form>
</body>
</html>
