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
            window.open("mn_ccobro1.php?id_ccob="+id_,"_self");
        }
        function adicionar(id_){
            window.open("mn_ccobro22.php?id_ccob="+id_,"_self");
        }
        function erroreditar(){
            alert("La cuenta de cobro se encuentra cerrada");
        }
        function erroreditar(){
            alert("La cuenta de cobro debe estar cerrada");
        }
        function editar_facturas(id_){
            window.open("mn_ccobro23.php?id_ccob="+id_,"_self");
        }
        function cerrar(id_){
            mensaje="";
            mensaje+="Recuerde que al cerrar la cuenta de cobro, no podrá adicionar mas facturas.\nDesea cerrarla?";
            if(confirm(mensaje)){
                window.open("mn_ccobro24.php?id_ccob="+id_,"_self");
            }
        }
        function planos(id_){
            window.open("mn_ccobro26.php?id_ccob="+id_,"_self");
        }
        
        /*function anular(id_){
            if(confirm("Desea anular la factura?\n")){
                window.open("mn_factura24.php?id_factura="+id_,"_self");
            }
        }*/
        function imprimir(id_){
            window.open("mn_ccobro25.php?id_ccob="+id_,"_new");
        }
    </script>

<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_ccobro.php");
$numero_ccob='';
$fecha_ccob='';
$estado_ccob='';
$id_eps='';
$orden='';
$id_ccob='';

if(isset($_POST['numero_ccob'])){$numero_ccob=$_POST['numero_ccob'];}
if(isset($_POST['fecha_ccob'])){$fecha_ccob=$_POST['fecha_ccob'];}
if(isset($_POST['estado_ccob'])){$estado_ccob=$_POST['estado_ccob'];}
if(isset($_POST['id_eps'])){$id_eps=$_POST['id_eps'];}
if(isset($_POST['orden'])){$orden=$_POST['orden'];}
if(isset($_POST['id_ccob'])){$id_ccob=$_POST['id_ccob'];}
?>
<form name='form1' method="post" action="mn_ccobro2.php">
    <span class="form-el"><input type='text' id='numero_ccob' name='numero_ccob' maxlength='8' size='8' placeholder='Numero' value="<?php echo $numero_ccob;?>"/></span>
    <span class="form-el">Fecha:<input type='date' id='fecha_ccob' name='fecha_ccob' placeholder='Fecha' value="<?php echo $fecha_ccob;?>"/></span>
    <span class="form-el">Estado:
        <select id='estado_ccob' name='estado_ccob' value="<?php echo $estado_ccob;?>">
            <option value=''>Todos</option>
            <option value='A'>Abierta</option>
            <option value='C'>Cerrada</option>
            <option value='N'>Anulada</option>
        </select>
    </span>
    <span class="form-el">Eps:
        <select id='id_eps' name='id_eps' value="<?php echo $id_eps;?>">
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
    <span class="form-el">Orden:
        <select id='orden' name='orden' value="<?php echo $orden;?>">
            <option value='numero_ccob'>Num. Cuenta</option>
            <option value='fecha_ccob'>Fecha</option>
            <option value='nombre_eps'>Eps</option>
        </select>
    </span>
    <a href="#" onclick='validar();' title='Buscar'><span class="icon-magnifying-glass"></span> </a>
<?php
$condicion="";
if(!empty($numero_ccob)){$condicion=$condicion."numero_ccob='$numero_ccob' AND ";}
if(!empty($fecha_ccob)){$condicion=$condicion."fecha_ccob='$fecha_ccob' AND ";}
if(!empty($estado_ccob)){$condicion=$condicion."estado_ccob='$estado_ccob' AND ";}
if(!empty($id_eps)){$condicion=$condicion."id_eps='$id_eps' AND ";}
if(!empty($id_ccob)){$condicion=$condicion."id_ccob='$id_ccob' AND ";}
if(!empty($condicion)){
    $condicion=substr($condicion,0,-5);
    //echo "<br>".$condicion;
    if(empty($orden)){$orden='numero_ccob';}
    $consulta="SELECT id_ccob,numero_ccob,nombre_eps,fecha_ccob,estado_ccob FROM vw_cuenta_cobro WHERE ".$condicion." ORDER BY ".$orden;
    //echo "<br>".$consulta;
    $consulta=$link->query($consulta);
    if($consulta->num_rows<>0){
        echo "<br><br><table width='100%'>";
        echo "<th colspan='6'>Opciones</th>".
            "<th>Eps</th>".
            "<th>Número</th>".
            "<th>Fecha</th>".
            "<th>Estado</th>";
        while($row=$consulta->fetch_array()){
            switch ($row['estado_ccob']){
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
            if($row['estado_ccob']=='A'){
                echo "<td width='5%'><a href='#' onclick=editar($row[id_ccob]) title='Editar Cuenta' class='btnhref'><span class='icon-edit'></span></a></td>";
            }
            else{
                echo "<td width='5%'><a href='#' onclick=erroreditar() class='btnhref'><span class='icon-edit'></span></a></td>";
            }
            if($row['estado_ccob']=='A'){
                echo "<td width='5%'><a href='#' onclick=adicionar($row[id_ccob]) title='Adicionar Facturas a la Cuenta' class='btnhref'><span class='icon-add-to-list'></span></a></td>";
            }
            else{
                echo "<td width='5%'><a href='#' onclick=erroreditar() class='btnhref'><span class='icon-add-to-list'></span></a></td>";
            }
            if($row['estado_ccob']=='A'){
                echo "<td width='5%'><a href='#' onclick=editar_facturas($row[id_ccob]) title='Facturas de la Cuenta' class='btnhref'><span class='icon-grid '></span></a></td>";
            }
            else{
                echo "<td width='5%'><a href='#' onclick=erroreditar() class='btnhref'><span class='icon-grid '></span></a></td>";
            }
            if($row['estado_ccob']=='A'){
                echo "<td width='5%'><a href='#' onclick=cerrar($row[id_ccob]) title='Cerrar Cuenta' class='btnhref'><span class='icon-lock'></span></a></td>";
            } 
            else{
                echo "<td width='5%'><a href='#' onclick=erroreditar() title='' class='btnhref'><span class='icon-lock'></span></a></td>";
            }
            /*if($row['estado_ccob']=='A'){
                echo "<td width='5%'><a href='#' onclick=eliminar($row[id_factura],$row[identificacion]) title='Eliminar Factura' class='btnhref'><span class='icon-trash'></span></a></td>";
            }
            else{
                if($row['estado_fac']=='C'){
                    echo "<td width='5%'><a href='#' onclick=anular($row[id_factura]) title='Anular Factura' class='btnhref'><span class='icon-circle-with-cross '></span></a></td>";
                }
                else{
                    echo "<td width='5%'><a href='#' class='btnhref'><span class='icon-circle-with-cross '></span></a></td>";
                }                    
            }
            */
            echo "<td width='5%'><a href='#' onclick=imprimir($row[id_ccob]) title='Imprimir Cuenta' class='btnhref'><span class='icon-print'></span></a></td>";
            if($row['estado_ccob']!='A'){
                echo "<td width='5%'><a href='#' onclick=planos($row[id_ccob]) title='Generar Rips' class='btnhref'><span class='icon-download'></span></a></td>";
            } 
            else{
                echo "<td width='5%'><a href='#' onclick=errorplanos() title='' class='btnhref'><span class='icon-download'></span></a></td>";
            }
            echo "<td>$row[nombre_eps]</td>";
            echo "<td>$row[numero_ccob]</td>";
            echo "<td>$row[fecha_ccob]</td>";
            echo "<td>$estado</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
}
?>
</form>
</body>
</html>
