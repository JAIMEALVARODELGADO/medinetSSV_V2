    <div class="fila">
        <span class="etiqueta"><label for="identificacion">Paciente:</label></span>
        <span class="form-el">
            <input type='text' class='texto' name='nombre_pac' size='60' readonly="true" />
            <input type='hidden' id='id_ingreso' name='id_ingreso'/>
        </span>            
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="fecha_con">Fecha:</label></span>
        <span class="form-el"><input type='date' id='fecha_con' name='fecha_con' required='required'/>
        </span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="reingreso_con">Reingreso:</label></span>
        <span class="reingreso_con">
            <select name='reingreso_con' >
            <option value=''></option>
            <option value='N'>No</option>
            <option value='S'>Si</option>
            </select>
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="quien_con">Quién Consulta:</label></span>
        <span class="form-el"><input type='text' id='quien_con' name='quien_con' size='50' maxlength='50' /></span>
        </div>
        <div class="fila">
            <span class="etiqueta"><label for="motivo_con"><b>ANAMNESIS</b></label></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="motivo_con">Motivo de Consulta:</label></span>
        <span class="form-el"><input type='text' id='motivo_con' name='motivo_con' size='120' maxlength='2000' /></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="enfermedad_con">Enfermedad Actual:</label></span>
        <span class="form-el"><input type='text' id='enfermedad_con' name='enfermedad_con' size='120' maxlength='2000' /></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="revsistemas_con">Revision por Sistemas:</label></span>
        <span class="form-el"><input type='text' id='revsistemas_con' name='revsistemas_con' size='120' maxlength='2000' /></span>
        </div>
        
        <div class="fila">
            <span class="etiqueta"><label><b>ANTECEDENTES</b></label></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="anteced_per_con">Antecedentes Personales:</label></span>
        <span class="form-el"><input type='text' id='anteced_per_con' name='anteced_per_con' size='120' maxlength='2000' /></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="anteced_fam_con">Antecedentes Familiares:</label></span>
        <span class="form-el"><input type='text' id='anteced_fam_con' name='anteced_fam_con' size='120' maxlength='2000' /></span>
        </div>

        <div class="fila">
            <span class="etiqueta"><label><b>SIGNOS VITALES</b></label></span>
        </div>

<!------------------------------->        
        <div class="fila">
            <span class="etiqueta"><label for="tasistol_sign">Tension Arterial mm Hg:</label></span>
            <span class="form-el">
                <input type='number' id='tasistol_sign' name='tasistol_sign' size='3' maxlength='3' min='50' max='140' required/>/
                <input type='number' id='tadiasto_sign' name='tadiasto_sign' size='3' maxlength='3' min='50' max='220'/>

                <label for="frec_respi_sig">Frecuencia Respiratoria:</label>
                <input type='number' id='frec_respi_sig' name='frec_respi_sig' size='3' maxlength='3' min='13' max='40'/> Por Min
                <label for="frec_card_sig">Frecuencia Cardiaca:</label>
                <input type='number' id='frec_card_sig' name='frec_card_sig' size='3' maxlength='3' min='50' max='100'/> Por Min
            </span>
        </div>

        <div class="fila">
            <span class="etiqueta"><label for="temperat_sig">Temperatura:</label></span>
            <span class="form-el">
                <input type='number' id='temperat_sig' name='temperat_sig' size='2' maxlength='2' min='35' max='40'/> °C
                <label for="peso_sig">Peso:</label>
                <input type='number' id='peso_sig' name='peso_sig' size='3' maxlength='3' min='40' max='100'/>Kg
                <label for="talla_sig">Talla:</label>
                <input type='number' id='talla_sig' name='talla_sig' size='3' maxlength='3' min='70' max='200'/>Cm
            </span>
        </div>
        <div class="fila">
            <span class="etiqueta"><label for="observacion_sig">Observación:</label></span>
            <span class="form-el"><input type='text' id='observacion_sig' name='observacion_sig' size='120' maxlength='150' /></span>
        </div>
<!------------------------------->        
        <div class="fila">
            <span class="etiqueta"><label><b>EXAMEN FÍSICO</b></label></span>
        </div>
        <div class="fila">
            <span class="etiqueta"><b>DESCRIPCIÓN</b></span>
            <span class="etiqueta"><b>ESTADO</b></span>
            <span class="etiqueta"><b>HALLAZGO</b></span>
        </div>
        <div class="fila">
            <span class="etiqueta"><label for="cabeza_estado_efis">Cabeza</label></span>
            <span class="etiqueta">
                <input type='text' id='cabeza_estado_efis' name='cabeza_estado_efis' size='30' maxlength='50' />
            </span>
            <span class="etiqueta">
                <textarea id='cabeza_hallazgo_efis' name='cabeza_hallazgo_efis'  maxlength='900' cols="70" rows="4"></textarea></span>
        </div>
        <div class="fila">
            <span class="etiqueta"><label for="cuello_estado_efis">Cuello</label></span>
            <span class="etiqueta">
                <input type='text' id='cuello_estado_efis' name='cuello_estado_efis' size='30' maxlength='50' />
            </span>
            <span class="etiqueta">
                <textarea id='cuello_hallazdo_efis' name='cuello_hallazdo_efis' maxlength='900' cols="70" rows="4"></textarea></span>
        </div>
        <div class="fila">
            <span class="etiqueta"><label for="torax_estado_efis">Torax</label></span>
            <span class="etiqueta">
                <input type='text' id='torax_estado_efis' name='torax_estado_efis' size='30' maxlength='50' />
            </span>
            <span class="etiqueta">
                <textarea id='torax_hallazgo_efis' name='torax_hallazgo_efis' maxlength='900' cols="70" rows="4"></textarea></span>
        </div>
        <div class="fila">
            <span class="etiqueta"><label for="abdomen_estado_efis">Abdomen</label></span>
            <span class="etiqueta">
                <input type='text' id='abdomen_estado_efis' name='abdomen_estado_efis' size='30' maxlength='50' />
            </span>
            <span class="etiqueta">
                <textarea id='abdomen_hallazgo_efis' name='abdomen_hallazgo_efis' maxlength='900' cols="70" rows="4"></textarea></span>
        </div>
        <div class="fila">
            <span class="etiqueta"><label for="columna_estado_efis">Columna</label></span>
            <span class="etiqueta">
                <input type='text' id='columna_estado_efis' name='columna_estado_efis' size='30' maxlength='50' />
            </span>
            <span class="etiqueta">
                <textarea id='columna_hallazgo_efis' name='columna_hallazgo_efis' maxlength='900' cols="70" rows="4"></textarea></span>
        </div>
        <div class="fila">
            <span class="etiqueta"><label for="extremi_estado_efis">Extremidades</label></span>
            <span class="etiqueta">
                <input type='text' id='extremi_estado_efis' name='extremi_estado_efis' size='30' maxlength='50' />
            </span>
            <span class="etiqueta">
                <textarea id='extremi_hallazgo_efis' name='extremi_hallazgo_efis' maxlength='900' cols="70" rows="4"></textarea></span>
        </div>
<!------------------------------->

        <div class="fila">
            <span class="etiqueta"><label><b>IMPRESION DIAGNÓSTICA</b></label></span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="diag_prin">Diagnóstico Principal:</label></span>
        <span class="form-el">
        <input type='text' id='course' class='texto' name='diag_principal' size='60' required='' />
        <input type='hidden' id='course_val' name='diag_prin'/>
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="diag_rel1">Diagnóstico Relacionado:</label></span>
        <span class="form-el">
        <input type='text' id='course2' class='texto' name='diag_relacionado' size='60' required='' />
        <input type='hidden' id='course_val2' name='diag_rel1'/>
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="observacion_con">Observación:</label></span>
        <span class="form-el">
            <textarea id='observacion_con' name='observacion_con' maxlength='2000' cols="100" rows="4"></textarea>
        </span>
        </div>

        <div class="fila">
            <span class="etiqueta"><label for="id_cups">CUPS de la Consulta:</label></span>
            <span class="form-el">
            <input type='text' id='course3' class='texto' name='cups' size='60' required='' />
            <input type='hidden' id='course_val3' name='id_cups'/>
            Finalidad:
            <select name='finalidad_con' >
            <option value=''></option>
            <?php
            $consultafin="SELECT codi_det,descripcion_det FROM vw_finalidad";
            //echo "<br>".$consultafin;
            $consultafin=$link->query($consultafin);
            if($consultafin->num_rows<>0){
                while($row=$consultafin->fetch_array()){
                    echo "<option value='$row[codi_det]'>".$row['descripcion_det']."</option>";
                }                
            }
            ?>
            </select>
            </span>
        </div>
        <div class="fila">
            <span class="etiqueta"><label for="causaexte_con">Causa Externa:</label></span>
            <span class="form-el">
            <select name='causaexte_con' >
            <option value=''></option>
            <?php
            $consultacext="SELECT codi_det,descripcion_det FROM vw_causaexterna";
            //echo "<br>".$consultafin;
            $consultacext=$link->query($consultacext);
            if($consultacext->num_rows<>0){
                while($row=$consultacext->fetch_array()){
                    echo "<option value='$row[codi_det]'>".$row['descripcion_det']."</option>";
                }                
            }
            ?>
            </select>
            </span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="analisis_con">Análisis:</label></span>
        <span class="form-el">
            <textarea id='analisis_con' name='analisis_con' maxlength='2000' cols="100" rows="10"></textarea>     
        </span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="plan_con">Plan de Manejo:</label></span>
        <span class="form-el">
            <textarea id='plan_con' name='plan_con' maxlength='2000' cols="100" rows="10"></textarea>     
        </span>
        </div>
