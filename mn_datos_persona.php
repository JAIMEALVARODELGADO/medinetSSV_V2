    <fieldset><legend>Información Personal</legend>
    <div class="fila">
    <span class="etiqueta"><label for="tipo_iden">Tipo de Identificación:</label></span>
    <span class="form-el"><select name='tipo_iden' >
    <option value=''></option>
    <option value='CC'>CC</option>
    <option value='CE'>CE</option>
    <option value='PA'>PA</option>        
    </select>
    </span>        
    </div>
    <div class="fila">
    <span class="etiqueta"><label for="identificacion">Número de Identificación:</label></span>
    <span class="form-el"><input type='text' id='identificacion' name='identificacion' maxlength='20' size='20' onblur='recargar()' required=''/></span>
    </div>
    <div class="fila">
    <span class="etiqueta"><label for="pnombre">Primer Nombre:</label></span>
    <span class="form-el"><input type='text' id='pnombre' name='pnombre' maxlength='20' size='20' required=''/></span>        
    </div>
    <div class="fila">
    <span class="etiqueta"><label for="snombre">Segundo Nombre:</label></span>
    <span class="form-el"><input type='text' id='snombre' name='snombre' maxlength='20' size='20' required=''/></span>    
    </div>
    <div class="fila">
    <span class="etiqueta"><label for="papellido">Primer Apellido:</label></span>
    <span class="form-el"><input type='text' id='papellido' name='papellido' maxlength='30' size='30' required=''/></span>        
    </div>
    <div class="fila">
    <span class="etiqueta"><label for="sapellido">Segundo Apellido:</label></span>
    <span class="form-el"><input type='text' id='sapellido' name='sapellido' maxlength='30' size='30' required=''/></span>        
    </div>
    <div class="fila">
    <span class="etiqueta"><label for="fecha_nacim">Fecha de Nacimiento:</label></span>
    <span class="form-el"><input type='date' id='fecha_nacim' name='fecha_nacim' required=''/></span>        
    </div>
    <div class="fila">
    <span class="etiqueta"><label for="sexo">Sexo:</label></span>
    <span class="form-el"><select name='sexo' >
    <option value=''></option>
    <option value='M'>Masculino</option>
    <option value='F'>Femenino</option>
    </select>
    </span>        
    </div>
    <div class="fila">
    <span class="etiqueta"><label for="direccion">Dirección:</label></span>
    <span class="form-el"><input type='text' id='direccion' name='direccion' maxlength='80' size='80' required=''/></span>        
    </div>
    <div class="fila">
    <span class="etiqueta"><label for="telefono">Teléfono:</label></span>
    <span class="form-el"><input type='text' id='telefono' name='telefono' maxlength='30' size='30' required=''/></span>        
    </div>
    </fieldset>

    