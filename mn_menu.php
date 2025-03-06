<?php
//session_start();
//echo "<br>".$_SESSION['gid_usuario'];
//echo "<br>".$_SESSION['gnombre'];
if(!isset($_SESSION['gid_usuario'])){
    ?>
        <script type="text/javascript">
            alert("La sesion ha finalizado. \nIngrese nuevamente");
            window.open('blanco.html','_self',''); 
            window.close(); 
        </script>
    <?php
}
$link=conectarbd();
?>
<nav>
    <ul class="nav">
        <?php
            $consmenu="SELECT id_menu,descripcion,dependencia,nivel,url FROM menu WHERE nivel='1'";
            //echo $consmenu;
            $consmenu=$link->query($consmenu);
            if($consmenu->num_rows<>0){
                while($row=$consmenu->fetch_array()){
                    echo "<li><a href='$row[url]'>$row[descripcion]</a>";
                    $link2=conectarbd();
                    $consm2="select id_menu_usu,id_menu,descripcion,dependencia,nivel,url,id_persona
                    FROM vw_menu_usuario WHERE nivel='2' AND dependencia='$row[id_menu]' AND id_persona='$_SESSION[gid_usuario]'";
                    //echo "<br>".$consm2;
                    $consm2=$link2->query($consm2);
                    if($consm2->num_rows<>0){
                        echo "<ul>";
                        while($row2=$consm2->fetch_array()){
                            echo "<li><a href='$row2[url]'>$row2[descripcion]</a></li>";
                        }
                        echo "</ul>";
                    }
                    echo "</li>";
                }
            }
        ?>
    </ul>
    <ul align="right">
        <?php 
        echo "Usuario:".$_SESSION['gnombre'];
        echo "<br><a href='mn_cerrar.php' class='a'>Cerrar Sesion</a>";
        ?>
    </ul>
</nav>
