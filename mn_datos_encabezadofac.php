        
        <fieldset><legend>Encabezado</legend>
        <div class="fila">
        <span class="etiqueta"><label for="course">Paciente:</label></span>
        <span class="form-el">
            <input type='text' id='course' class='texto' name='nombre_pac' size='60' required='' />
            <input type='hidden' id='course_val' name='id_persona'/>
        </span>            
        </div>


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
        <span class="etiqueta"><label for="fecha_ini">Fecha Inicial:</label></span>
        <span class="form-el"><input type='date' id='fecha_ini' name='fecha_ini' maxlength='10' size='10' required=''/></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="fecha_fin">Fecha Final:</label></span>
        <span class="form-el"><input type='date' id='fecha_fin' name='fecha_fin' maxlength='10' size='10' required=''/></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="fecha_fac">Fecha  de la Factura:</label></span>
        <span class="form-el"><input type='date' id='fecha_fac' name='fecha_fac' maxlength='10' size='10' required=''/></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="autoriza_fac">Autorización Nro:</label></span>
        <span class="form-el"><input type='text' id='autoriza_fac' name='autoriza_fac' maxlength='15' size='15' required=''/></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="course2">Dx Principal:</label></span>
        <span class="form-el">
            <input type='text' id='course2' class='texto' name='nombre_dxp' size='80' required='' />
            <input type='hidden' id='course_val2' name='id_cie'/>
        </span>            
        </div>
        <!--<div class="fila">
        <span class="etiqueta"><label for="cuenta_cobro">Num. Cuenta de Cobro:</label></span>
        <span class="form-el"><input type='text' id='cuenta_cobro' name='cuenta_cobro' size='8' maxlength='8'/></span>
        </div>-->
        <div class="fila">
        <button type="button" id='btnguardar' onclick='validar()'><span class="icon-save"></span> Guardar</button>
        </div>
        <br>
        </fieldset>
