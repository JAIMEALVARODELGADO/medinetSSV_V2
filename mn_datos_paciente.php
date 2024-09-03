    <fieldset><legend>Información del Paciente</legend>
    <div class="fila">
    <span class="etiqueta"><label for="mun_reside">Municipio de Residencia:</label></span>
    <span class="form-el"><select name='mun_reside'>
    <option value=''></option>
    <?php
        $consultamun="SELECT codigo_mun,nombre_mun FROM municipio WHERE departamento LIKE '%NARI%' ORDER BY nombre_mun";
        //echo "<br>".$consultamun;
        $consultamun=$link->query($consultamun);
        if($consultamun->num_rows<>0){
            while($rowmun=$consultamun->fetch_array()){
                echo "<option value='$rowmun[codigo_mun]'>$rowmun[nombre_mun]</option>";
            }
        }
    ?>
    </select></span>
    </div>
    <div class="fila">
    <span class="etiqueta"><label for="zona_reside">Zona de Residencia:</label></span>
    <span class="form-el"><select name='zona_reside' >
    <option value=''></option>
    <option value='U'>Urbana</option>
    <option value='R'>Rural</option>    
    </select>
    </span>        
    </div>
    
    <div class="fila">
    <span class="etiqueta"><label for="tipo_sangre">Tipo de Sangre:</label></span>
    <span class="form-el"><select name='tipo_sangre' >
    <option value=''></option>
    <option value='A+'>A+</option>
    <option value='A-'>A-</option>
    <option value='B+'>B+</option>
    <option value='B-'>B-</option>
    <option value='AB+'>AB+</option>
    <option value='AB-'>AB-</option>
    <option value='O+'>O+</option>
    <option value='O-'>O-</option> 
    </select>
    </span>        
    </div>

    <div class="fila">
    <span class="etiqueta"><label for="zona_reside">Tipo de Usuario:</label></span>
    <span class="form-el"><select name='tipo_usuario'>
    <option value=''></option>
    <?php
        $consultatpusu="select codi_det,descripcion_det  from detalle_grupo
        where id_grupo ='5' ORDER BY descripcion_det";
        //echo "<br>".$consultatpusu
        $consultatpusu=$link->query($consultatpusu);
        if($consultatpusu->num_rows<>0){
            while($rowtp=$consultatpusu->fetch_array()){
                echo "<option value='$rowtp[codi_det]'>$rowtp[descripcion_det]</option>";
            }
        }
    ?>   
    </select>
    </span>        
    </div>

    </fieldset>
