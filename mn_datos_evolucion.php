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
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="fecha_evol">Fecha y Hora:</label></span>
        <span class="form-el"><input type='text' id='fecha_evol' name='fecha_evol' value='<?php echo $hoy;?>' required='required' disabled=true/>

        <input type='time' id='hora_evol' name='hora_evol' value='<?php echo $hora;?>' required='required'/>
        </span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="observacion">Observación:</label></span>
        <span class="form-el"><textarea id='observacion' name='observacion' maxlength='5000' minlength='150' rows='3' cols='100'></textarea>
        </span>
        </div>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="salida">Dar Salida al Paciente:</label></span>
        <span class="form-el"><input type='checkbox' id='salida' name='salida' onclick='advertencia()' value='S'/></span>
        </div>
