        
        <fieldset><legend>Detalle</legend>
        <table width='100%'>
            <th>Opciones</th>
            <th>Detalle</th>
            <th>Cantidad</th>
            <th>Valor Unitario</th>
            <th>Valor Total</th>
            <?php
            $consultadet="SELECT id_detalle,CONCAT(codigo_cups,' ',descripcion_cups) AS detalle,cantidad_det,valor_unitario,valor_total FROM vw_detalle_fac WHERE id_factura='$id_factura'";
            //echo "<br>".$consultadet;
            $consultadet=$link->query($consultadet);
            if($consultadet->num_rows<>0){
                while($rowdet=$consultadet->fetch_array()){
                    echo "<tr>";
                    echo "<td><a href='#' onclick=eliminar_reg($rowdet[id_detalle],$id_factura) title='Eliminar Registro' class='btnhref'><span class='icon-trash Eliminar'></span></a></td>";
                    echo "<td>$rowdet[detalle]</td>";
                    echo "<td align='right'>$rowdet[cantidad_det]</td>";
                    echo "<td align='right'>$rowdet[valor_unitario]</td>";
                    echo "<td align='right'>$rowdet[valor_total]</td>";
                    echo"</tr>";
                }
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td colspan="2" align="right"><b>Total Facturado</td>
                <td align="right"><b><?php echo $valor_total;?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                <input type='text' id='course3' class='texto' name='detalle' size='80' required='' />
                <input type='hidden' id='course_val3' name='id_cups'/>
                </td>
                <td><input type="number" id="cantidad_det" name="cantidad_det" size="3" min='1' max="999" onblur="calculatotal()"></td>
                <td><input type="number" id="valor_unitario" name="valor_unitario" size="6" min='1' max="9999999" onblur="calculatotal()"></td>
                <td><input type="number" id="valor_total" name="valor_total" size="6" min='1' max="9999999" disabled>
                <a href='#' onclick="validardet()" title='Guardar' class='btnhref'><span class='icon-save'></span></a>
                </td>
            </tr>
        </table>
        </fieldset>
