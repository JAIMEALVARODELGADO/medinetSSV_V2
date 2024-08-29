<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html lang="es-ES" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
        function actualizar(var_,idmenu_,idmenuusu_){
            cmd_="document.form1."+var_+".checked";
            document.form1.checkbox.value=eval(cmd_);
            document.form1.id_menu.value=idmenu_;
            document.form1.id_menu_usu.value=idmenuusu_;
            //window.open("mn_usuario241.php?id_persona="+id_,"_self");
            document.form1.submit();
        }
    </script>
<body>

<?php
require("mn_funciones.php");
require("mn_menu.php");
require("mn_menu_usuario.php");
$id_persona="";
if(ISSET($_GET['id_persona'])){$id_persona=$_GET['id_persona'];}
else{$id_persona=$_POST['id_persona'];}
//echo $id_persona;
$link=conectarbd();
$consulta="SELECT tipo_iden,identificacion,papellido,sapellido,pnombre,snombre FROM persona WHERE id_persona='$id_persona'";
//echo "<br>".$consulta;
$consulta=$link->query($consulta);
if($consulta->num_rows > 0){
    $row=$consulta->fetch_array();
    $tipo_iden=$row['tipo_iden'];
    $identificacion=$row['identificacion'];
    $nombre=$row['pnombre'].' '.$row['snombre'].' '.$row['papellido'].' '.$row['sapellido'];
}
?>
<form name='form1' method="post" action="mn_usuario241.php">
    <?php
    echo "<div class='fila'>";
    echo "<span class='etiqueta'><label for='tipo_iden'>Identificación:</label></span>";
    echo "<span class='form-el'>$tipo_iden $identificacion</span>";      
    echo "</div>";
    echo "<div class='fila'>";
    echo "<span class='etiqueta'><label for='nombre'>Nombre:</label></span>";
    echo "<span class='form-el'>$nombre</span>";     
    echo "</div>";

    //require("mn_datos_usuariosist.php");
    ?>
    <fieldset><legend>Menú</legend>
        <?php
            $consultamenu="SELECT menu.id_menu,menu.descripcion,menu.dependencia,menu.nivel FROM menu WHERE menu.nivel='1'";
            //echo $consultamenu;
            $consultamenu=$link->query($consultamenu);
            if($consultamenu->num_rows<>0){
                while($rowmenu=$consultamenu->fetch_array()){
                    //echo "<br>$rowmenu[descripcion]";
                    ?>
                    <div class="fila">
                    <span class="form-el"><label for=""><b><?php echo $rowmenu['descripcion'];?></b></label></span>
                    </div>                 
                    <?php
                    $consultamenu2="SELECT menu.id_menu,menu.descripcion,menu.dependencia,menu.nivel FROM menu WHERE nivel='2' AND dependencia='$rowmenu[id_menu]'";
                    /*$consultamenu2="SELECT id_menu_usu,id_menu,descripcion,dependencia,nivel FROM vw_menu_usuario WHERE nivel='2' AND dependencia='$rowmenu[id_menu]' AND (ISNULL(id_menu_usu) OR id_persona='$id_persona')";*/
                    //echo "<br>".$consultamenu2;
                    $consultamenu2=$link->query($consultamenu2);
                    if($consultamenu2->num_rows<>0){
                        while($rowmenu2=$consultamenu2->fetch_array()){
                            $var="chk".$rowmenu2['id_menu'];
                            //echo $var;
                            ?>
                            <div class="fila">
                            <span class="form-el">
                                <?php
                                $check_='checked';

                                $consultamenu3="SELECT id_menu_usu,id_menu FROM vw_menu_usuario WHERE id_menu='$rowmenu2[id_menu]' AND id_persona='$id_persona'";
                                $consultamenu3=$link->query($consultamenu3);
                                //echo "<br>".$consultamenu3;
                                $id_menu_usu='0';
                                if($consultamenu3->num_rows<>0){
                                    $rowmenu3=$consultamenu3->fetch_array();
                                    $id_menu_usu=$rowmenu3['id_menu_usu'];
                                }
                                else{
                                    $check_='';
                                }

                                ?>
                                <input type="checkbox" name="<?php echo $var;?>" onclick="actualizar('<?php echo $var;?>',<?php echo $rowmenu2['id_menu'];?>,<?php echo $id_menu_usu;?>)" <?php echo $check_;?>
                                <label for=""><?php echo $rowmenu2['descripcion'];?></label>
                            </span>
                            </div>  
                            <?php
                        }
                    }
                }
            }
        ?>
    </fieldset>

    <?php
    echo "<input type='hidden' name='id_persona' value='$id_persona'/>";
    echo "<input type='hidden' name='checkbox'/>";
    echo "<input type='hidden' name='id_menu'/>";
    echo "<input type='hidden' name='id_menu_usu'/>";

    ?>
    
    <!--<button type="button" onclick='validar()'><span class="icon-save"></span> Guardar</button>-->
    
    
</form>
</body>
</html>
