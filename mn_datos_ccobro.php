        
        <fieldset><legend>Encabezado Cuenta de Cobro</legend>

        <div class="fila">
        <span class="etiqueta"><label for="id_eps">EPS:</label></span>
        <span class="form-el"><select name='id_eps'>
        <option value=''></option>
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
        </select></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="numero_ccob">Número Cuenta de Cobro:</label></span>
        <span class="form-el"><input type='text' id='numero_ccob' name='numero_ccob' size='8' maxlength='8'/></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="fecha_ccob">Fecha de la Cuenta de Cobro:</label></span>
        <span class="form-el"><input type='date' id='fecha_ccob' name='fecha_ccob' maxlength='10' size='10' required=''/></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="fecha_inicio">Fecha Inicial:</label></span>
        <span class="form-el"><input type='date' id='fecha_inicio' name='fecha_inicio' maxlength='10' size='10' required=''/></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="fecha_fin">Fecha Final:</label></span>
        <span class="form-el"><input type='date' id='fecha_fin' name='fecha_fin' maxlength='10' size='10' required=''/></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="concepto_ccob">Concepto:</label></span>
        <span class="form-el"><textarea rows="4" cols="100" maxlength="400" id="concepto_ccob" name="concepto_ccob" required></textarea></span>
        </div>
        
        <div class="fila">
        <button type="button" id='btnguardar' onclick='validar()'><span class="icon-save"></span> Guardar</button>
        </div>
        <br>
        </fieldset>
