        <fieldset><legend>Información del Usuario del Sistema</legend>
        <div class="fila">
        <span class="etiqueta"><label for="login">Login:</label></span>
        <span class="form-el"><input type='text' id='login' name='login' maxlength='45' size='45' required=''/></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="password">Password:</label></span>
        <span class="form-el"><input type='password' id='password' name='password' maxlength='10' size='10' required=''/></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="password2">Confirme Password:</label></span>
        <span class="form-el"><input type='password' id='password2' name='password2' maxlength='10' size='10' required=''/></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="profesion">Profesion:</label></span>
        <span class="form-el"><input type='text' id='profesion' name='profesion' maxlength='30' size='30' required=''/></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="registro">Registro:</label></span>
        <span class="form-el"><input type='text' id='registro' name='registro' maxlength='10' size='10' required=''/></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="id_formato">Formato que va a diligenciar:</label></span>
        <span class="form-el"><select name='id_formato' >
                <option value=''></option>
                <?php
                $consultafor="SELECT id_formato,descripcion_for FROM formatos";
                //echo $consultafor;
                $consultafor=$link->query($consultafor);
                if($consultafor->num_rows<>0){
                        //$rowfor=$consultafor->fetch_array();
                        //$formato=$rowfor['formato'];
                        while($rowfor=$consultafor->fetch_array()){
                                echo "<option value='$rowfor[id_formato]'>$rowfor[descripcion_for]</option>";
                        }
                }
                ?>
                </select>
        </span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="observacio">Observación:</label></span>
        <span class="form-el"><input type='text' id='observacion' name='observacion' maxlength='80' size='80' required=''/>
        </span>
        </div>
        <div class="fila">
        <span class="etiqueta"><input type='checkbox' id='estado' name='estado'/><label for="estado">Activo:</label></span>
        </div>

        </fieldset>