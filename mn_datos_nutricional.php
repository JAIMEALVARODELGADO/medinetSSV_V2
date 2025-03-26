        <?php
                $hoy=date("Y-m-d");
                $hora=date("H:m");
        ?>
        <div class="fila">
        <span class="etiqueta"><label for="identificacion">Paciente:</label></span>
        <span class="form-el">
            <input type='text' class='texto' name='nombre_pac' size='60' readonly="true" />
            <input type='hidden' id='id_ingreso' name='id_ingreso'/>
        </span>
        <span class="etiqueta"><label for="fecha_nacim">Fecha de Nacimiento:</label></span>
        <span class="form-el">
            <input type='text' class='texto' name='fecha_nacim' size='10' readonly="true" />
            <label for="edad">Edad:</label>
            <input type='text' class='texto' name='edad' size='3' readonly="true" />
        </span>  
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="fecha_nut">Fecha y Hora:</label></span>
        <span class="form-el"><input type='date' id='fecha_nut' name='fecha_nut' value='<?php echo $hoy;?>' required='required'/>
        <input type='time' id='hora' name='hora' value='<?php echo $hora;?>' required='required'/>
        </span>
        </div>
        <div class="fila">
        <h4>Indicadores Clínicos</h4>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="diarrea_nut">Diarrea:</label></span>
        <span class="form-el">
            <input type="radio" name="diarrea_nut" value="Si">Si
            <input type="radio" name="diarrea_nut" value="No">No
        </span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="diarrea_nut">Estreñimiento:</label></span>
        <span class="form-el">
            <input type="radio" name="estrenim_nut" value="Si">Si
            <input type="radio" name="estrenim_nut" value="No">No
        </span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="gastritis_nut">Gastritis:</label></span>
        <span class="form-el">
            <input type="radio" name="gastritis_nut" value="Si">Si
            <input type="radio" name="gastritis_nut" value="No">No
        </span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="ulceras_nut">Ulceras:</label></span>
        <span class="form-el">
            <input type="radio" name="ulceras_nut" value="Si">Si
            <input type="radio" name="ulceras_nut" value="No">No
        </span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="nauceas_nut">Nauceas:</label></span>
        <span class="form-el">
            <input type="radio" name="nauceas_nut" value="Si">Si
            <input type="radio" name="nauceas_nut" value="No">No
        </span>
        </div>

        </div>
        <div class="fila">
        <span class="etiqueta"><label for="pirosis_nut">Pirosis:</label></span>
        <span class="form-el">
            <input type="radio" name="pirosis_nut" value="Si">Si
            <input type="radio" name="pirosis_nut" value="No">No
        </span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="vomito_nut">Vomito:</label></span>
        <span class="form-el">
            <input type="radio" name="vomito_nut" value="Si">Si
            <input type="radio" name="vomito_nut" value="No">No
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="colitis_nut">Colitis:</label></span>
        <span class="form-el">
            <input type="radio" name="colitis_nut" value="Si">Si
            <input type="radio" name="colitis_nut" value="No">No
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="dentadura_nut">Dentadura:</label></span>
        <span class="form-el">
            <input type="radio" name="dentadura_nut" value="Si">Si
            <input type="radio" name="dentadura_nut" value="No">No
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="otros_nut">Otros:</label></span>
        <span class="form-el"><input type='text' id='otros_nut' name='otros_nut' size='50' maxlength='50' /></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="observacion_nut">Observación:</label></span>
        <span class="form-el"><input type='text' id='observacion_nut' name='observacion_nut' size='120' maxlength='150' /></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="enfermedad_actual_nut">Enfermedad(es) Actual(es):</label></span>
        <span class="form-el"><input type='text' id='enfermedad_actual_nut' name='enfermedad_actual_nut' size='120' maxlength='150' /></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="medicamentos_nut">Medicamentos que Consume:</label></span>
        <span class="form-el"><input type='text' id='medicamentos_nut' name='medicamentos_nut' size='120' maxlength='150' /></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="cirugia_nut">Procedimientos Qx:</label></span>
        <span class="form-el"><input type='text' id='cirugia_nut' name='cirugia_nut' size='50' maxlength='50' /></span>
        </div>

        <div class="fila">
        <h4>Indicadores Antropométricos</h4>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="altura_rodilla_nut">Altura de Rodilla:</label></span>
        <span class="form-el"><input type='text' id='altura_rodilla_nut' name='altura_rodilla_nut' size='4' maxlength='4' onblur="calcular()" />Cm
        Talla Estimada Mujer <input type='text' class='texto' name='talla_muj' size='6' readonly="true" />
        Talla Estimada Hombre <input type='text' class='texto' name='talla_hom' size='6' readonly="true" /></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="circ_brazo_nut">Circunferencia de Brazo:</label></span>
        <span class="form-el"><input type='text' id='circ_brazo_nut' name='circ_brazo_nut' size='4' maxlength='4' onblur="calcular()" />Cm
        Peso Estimado Mujer <input type='text' class='texto' name='peso_muj' size='6' readonly="true" />
        Peso Estimado Hombre <input type='text' class='texto' name='peso_hom' size='6' readonly="true" /></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="circ_cadera_nut">Circunferencia de Cadera:</label></span>
        <span class="form-el"><input type='text' id='circ_cadera_nut' name='circ_cadera_nut' size='4' maxlength='4' onblur="calcular()" />Cm
        Circunferencia de Cintura: <input type='text' class='texto' name='circ_cintura_nut' size='4' maxlength='4' onblur="calcular()" />Cm
        Riesgo Cardiovascular <input type='text' class='texto' name='riesgo' size='6' readonly="true" /></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="circ_pantorrilla_nut">Circunferencia de Pantorrilla:</label></span>
        <span class="form-el"><input type='text' id='circ_pantorrilla_nut' name='circ_pantorrilla_nut' size='4' maxlength='4' />Cm
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="peso_nut">Peso:</label></span>
        <span class="form-el"><input type='text' id='peso_nut' name='peso_nut' size='6' maxlength='6' onblur="calcular()" />Kg</span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="talla_nut">Talla:</label></span>
        <span class="form-el"><input type='text' id='talla_nut' name='talla_nut' size='3' maxlength='3' onblur="calcular()" />Cm</span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="peso_ideal">Peso Ideal:</label></span>
        <span class="form-el">
            <input type='text' id='peso_ideal' name='peso_ideal' size='4' maxlength='4' readonly="true" />Kg 
            Indice de Masa Corporal<input type='text' id='imc' name='imc' size='6' maxlength='6' readonly="true" /></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="dxnutricional_nut">Diagnóstico Nutricional:</label></span>
        <span class="form-el">
            <textarea id='dxnutricional_nut' name='dxnutricional_nut' rows="4" cols="100"></textarea>
        </span>
        </div>

