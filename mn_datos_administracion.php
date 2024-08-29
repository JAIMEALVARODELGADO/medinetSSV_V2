        <div class="fila">
        <span class="etiqueta"><label for="identificacion">Paciente:</label></span>
        <span class="form-el">
            <input type='text' id='paciente' class='texto' name='nombre_pac' size='60' readonly="true" />
            <input type='hidden' id='id_ingreso' name='id_ingreso'/>
        </span>            
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="fecha_mov">Fecha y Hora:</label></span>
        <span class="form-el"><input type='datetime-local' id='fecha_mov' name='fecha_mov' required='true' />
        </span>
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="producto">Producto:</label></span>
        <span class="form-el">
            <input type='text' id='course2' class='texto' name='nombre_prod' size='60' required='' />
            <input type='hidden' id='course_val2' name='id_producto'/>
            <input type='hidden' id='course_val3' name='saldo'/>
        </span>            
        </div>
        <div class="fila">
        <span class="etiqueta"><label for="cantidad">Cantidad:</label></span>
        <span class="form-el"><input type='number' id='cantidad' name='cantidad' size='2' min='1' max=100 required='required'/></span>
        </div>

        <div class="fila">
        <span class="etiqueta"><label for="remite">Dosis:</label></span>
        <span class="form-el"><input type='text' id='dosis' name='dosis' size='10' maxlength='10' required='required'/></span>
        </div>
        
        <div class="fila">
        <span class="etiqueta"><label for="via">Via de Administración:</label></span>
        <span class="form-el"><input type='text' id='via' name='via' size='15' maxlength='15' required=''/></span>
        </div>
       
        <div class="fila">
        <span class="etiqueta"><label for="observacion">Observación:</label></span>
        <span class="form-el"><input type='text' id='observacion' name='observacion' size='30' maxlength='30' required=''/></span>
        </div>
