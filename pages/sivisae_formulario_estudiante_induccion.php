<form>
    <div align='center' style='background-color: #004669'>
        <h2 id='p_fieldset_autenticacion_2'>
            Datos personales del Estudiante
        </h2>
    </div>
    <div align='center'>
        <table>
            <tr>
                <td class="sel_zona">
                    Zona:
                    <select id="zona" name="zona[]" data-placeholder="Seleccione una Zona" class="chosen-select"
                            multiple style="width:180px;" tabindex="4">
                        <option value=""></option>
                        <?php
                        while ($row = mysql_fetch_array($zonas)) {
                            echo "<option value='$row[0]'>" .
                                ucwords($row[1]) .
                                "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td class="f sel_zona">
                    <div id="div-zona">
                        CEAD:
                        <select id="cead" name="cead[]" data-placeholder="Seleccione un CEAD" class="chosen-select"
                                multiple style="width:180px;" tabindex="4">
                            <?php
                            if ($filtro_zonas === '3') {
                                ?>
                                <option value="T">Todos</option>
                                <?php
                            }
                            while ($row = mysql_fetch_array($centros)) {
                                echo "<option value='$row[0]'>" .
                                    $row[1] . " - " . ucwords($row[2]) .
                                    "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </td>
                <td>
                    Escuela:
                    <select id="escuela" name="escuela[]" data-placeholder="Seleccione una Escuela"
                            class="chosen-select" multiple style="width:180px;" tabindex="4">
                        <option value=""></option>
                        <?php
                        while ($row = mysql_fetch_array($escuelas)) {
                            echo "<option value='$row[0]'>" .
                                ucwords($row[0]) .
                                "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td class="e">
                    Programa:
                    <select id="programa" name="programa[]" data-placeholder="Seleccione un Programa"
                            class="chosen-select" multiple style="width:180px;" tabindex="4">
                        <option value=""></option>
                        <?php
                        while ($row = mysql_fetch_array($programas)) {
                            echo "<option value='$row[0]'>" .
                                $row[1] . " - " . ucwords($row[2]) .
                                "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="4"><br>
                    <hr>
                    <br></td>
            </tr>
            <tr>
                <td>
                    <label for="nombre">* Nombre(s):</label>
                </td>
                <td colspan="2">
                    <input style="width: 300px;" id="nombre" name="nombre" class="form-control" type="text"
                           maxlength="30" tabindex="5" placeholder="Nombre aqui" required/>
                </td>
                <td class="aud">Fecha Evento
                    <input style="width: 180px;" id="fecha_evento" name="fecha_evento" type="date"
                           required="Por favor ingrese la fecha de evento."/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="apellido">* Apellido(s):</label>
                </td>
                <td colspan="2">
                    <input style="width: 300px;" id="apellido" name="apellido" class="form-control" type="text"
                           maxlength="30" tabindex="6" placeholder="Apellido aqui" required/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="email">* Email personal:</label>
                </td>
                <td colspan="2">
                    <input style="width: 300px;" id="email" name="email" class="form-control" type="email"
                           maxlength="30" tabindex="7" placeholder="nombre@correo.com" required/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="telefono">* Teléfono:</label>
                </td>
                <td colspan="2">
                    <input style="width: 300px;" id="telefono" name="telefono" class="form-control" type="tel"
                           maxlength="30" tabindex="8" placeholder="Teléfono aqui" required/>
                </td>
            </tr>
            <tr>
                <td>
                    <input class="submit_fieldset_autenticacion" type="submit" value="Guardar">
                </td>
            </tr>
        </table>
    </div>
</form>