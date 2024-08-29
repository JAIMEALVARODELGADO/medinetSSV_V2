        
        <fieldset><legend>Información del Ingreso</legend>
        <div class="fila">
        <span class="etiqueta"><label for="identificacion">Paciente:</label></span>
        <span class="form-el">
            <input type='text' id='course' class='texto' name='nombre_pac' size='60' required='' />
            <input type='hidden' id='course_val' name='id_persona'/>
        </span>            
        </div>
        <div class="fila">
        <span class="etiqueta"><label>Jornada:</label></span>
        <span class="form-el"><select name='jornada' >
        <option value=''></option>
        <option value='Mañana'>Mañana</option>
        <option value='Tarde'>Tarde</option>
        <option value='Larga Estancia'>Larga Estancia</option>
        </select></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="fecha_ing">Fecha de Ingreso:</label></span>
        <span class="form-el"><input type='date' id='fecha_ing' name='fecha_ing' maxlength='10' size='10' required=''/></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="peso">Peso:</label></span>
        <span class="form-el"><input type='number' id='peso' name='peso' min='40' max='110' required=''/>Kg</span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="course">Diagnóstico Principal:</label></span>
        <span class="form-el">
        <input type='text' id='course2' class='texto' name='diag_principal' size='60' required='' />
        <input type='hidden' id='course_val2' name='diag_prin'/>
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="course3">Diagnóstico Relacionado:</label></span>
        <span class="form-el">
        <input type='text' id='course3' class='texto' name='diag_relacionado' size='60' required='' />
        <input type='hidden' id='course_val3' name='diag_rel1'/>
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label>EPS:</label></span>
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
        <span class="etiqueta"><label>Controla Esfínteres:</label></span>
        <span class="form-el"><select name='control_esfin' >
        <option value=''></option>
        <option value='S'>Si</option>
        <option value='N'>No</option>
        </select></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label>Desplazamiento:</label></span>
        <span class="form-el"><select name='desplazam'>
        <option value=''></option>
        <option value='Independiente'>Independiente</option>
        <option value='Muletas'>Muletas</option>
        <option value='Baston'>Baston</option>
        <option value='Caminador'>Caminador</option>
        <option value='Silla de ruedas'>Silla de ruedas</option>
        <option value='Otro'>Otro</option>
        </select>  Cual:<input type='text' id='cual_desp' name='cual_desp' size='20' maxlength='20' /></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label>Es independiente en su alimentación:</label></span>
        <span class="form-el"><select name='alimentacion_indep' >
        <option value=''></option>
        <option value='S'>Si</option>
        <option value='N'>No</option>
        </select></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label>Comunicación verbal sin dificultad:</label></span>
        <span class="form-el"><select name='comunicacion_verbal' >
        <option value=''></option>
        <option value='S'>Si</option>
        <option value='N'>No</option>
        </select></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label>Alergia a Medicamentos:</label></span>
        <span class="form-el"><select name='alergia_medicame'>
        <option value=''></option>
        <option value='No'>No</option>
        <option value='Si'>Si</option>
        </select>  Cual:<input type='text' id='cual_med' name='cual_med' size='50' maxlength='50' /></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label>Alergia a Alimentos:</label></span>
        <span class="form-el"><select name='alergia_alimento'>
        <option value=''></option>
        <option value='No'>No</option>
        <option value='Si'>Si</option>
        </select>  Cual:<input type='text' id='cual_ali' name='cual_ali' size='50' maxlength='50' /></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="observacion">Observación:</label></span>
        <span class="form-el"><textarea name='observacion_ing' cols='100' rows='3' maxlength='250'><?php echo $observacion_ing;?></textarea>
        </div>

        <div class="fila">
            <span class="etiqueta"><label>Estado: </label></span>
            <span class="form-el">
                <select name='estado'>
                    <option value='AC'>Activo</option>
                    <option value='IN'>Inactivo</option>
                </select>
        </div>
        </fieldset>
