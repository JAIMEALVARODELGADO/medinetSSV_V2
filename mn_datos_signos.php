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
        <span class="etiqueta"><label for="tasistol_sign">Tension Arterial mm Hg:</label></span>
        <span class="form-el">
            <input type='number' id='tasistol_sign' name='tasistol_sign' size='3' maxlength='3' min='50' max='140' required/>/
            <input type='number' id='tadiasto_sign' name='tadiasto_sign' size='3' maxlength='3' min='50' max='220'/>
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="satoxig_sign">Saturación de Oxígeno:</label></span>
        <span class="form-el">
            <input type='number' id='satoxig_sign' name='satoxig_sign' size='3' maxlength='3' min='70' max='100'/>%
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="frecard_sign">Frecuencia Cardiaca:</label></span>
        <span class="form-el">
            <input type='number' id='frecard_sign' name='frecard_sign' size='3' maxlength='3' min='50' max='100'/> Por Min
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="frecresp_sign">Frecuencia Respiratoria:</label></span>
        <span class="form-el">
            <input type='number' id='frecresp_sign' name='frecresp_sign' size='3' maxlength='3' min='13' max='40'/> Por Min
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="temperatura_sign">Temperatura:</label></span>
        <span class="form-el">
            <input type='number' id='temperatura_sign' name='temperatura_sign' size='2' maxlength='2' min='35' max='40'/> °C
        </span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="observacion_sign">Observación:</label></span>
        <span class="form-el"><input type='text' id='observacion_sign' name='observacion_sign' size='120' maxlength='150' /></span>
        </div>


