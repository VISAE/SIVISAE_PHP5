<form method="post" id="formEstudiante" name="formEstudiante" target="src/guardar_estudiante_eventoCB.php">
    <div align='center' style='background-color: #004669'>
        <h2 id='p_fieldset_autenticacion_2'>
            Datos personales del Estudiante
        </h2>
    </div>
    <input type="hidden" id="cedula_id" name="cedula_id">
    <input type="hidden" id="periodo_id" name="periodo_id">
    <div align='center'>
            <table>
                <tr>
                    <td class="sel_zona item-required">
                        Zona:
                        <select id="zona" name="zona[]" data-placeholder="Seleccione una Zona" class="chosen-select"
                                style="width:180px;" tabindex="4">
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
                    <td class="f sel_zona item-required">
                        <div id="div-zona">
                            CEAD:
                            <select id="cead" name="cead[]" data-placeholder="Seleccione un CEAD" class="chosen-select"
                                    style="width:180px;" tabindex="4" required>
                                <option value=""></option>
                                <?php
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
                                class="chosen-select" style="width:180px;" tabindex="4">
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
                    <td class="e item-required">
                        Programa:
                        <select id="programa" name="programa[]" data-placeholder="Seleccione un Programa"
                                class="chosen-select" style="width:180px;" tabindex="4" required>
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
                    <td colspan="4" align="center">
                        <table style="border: 1px solid grey; box-shadow: 10px 10px 5px grey;">
                            <tr>
                                <td>
                                    <label for="nombre">* Nombre(s):</label>
                                </td>
                                <td colspan="2" class="item-required">
                                    <input style="width: 300px;" id="nombre" name="nombre" class="form-control"
                                           type="text"
                                           maxlength="30" tabindex="5" placeholder="Nombre aqui" required/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="apellido">* Apellido(s):</label>
                                </td>
                                <td colspan="2" class="item-required">
                                    <input style="width: 300px;" id="apellido" name="apellido" class="form-control"
                                           type="text"
                                           maxlength="30" tabindex="6" placeholder="Apellido aqui" required/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="email">* Email personal:</label>
                                </td>
                                <td colspan="2" class="item-required">
                                    <input style="width: 300px;" id="email" name="email" class="form-control"
                                           type="email"
                                           maxlength="30" tabindex="7" placeholder="nombre@correo.com" required/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="telefono">* Teléfono:</label>
                                </td>
                                <td colspan="2" class="item-required">
                                    <input style="width: 300px;" id="telefono" name="telefono" class="form-control"
                                           type="tel"
                                           maxlength="30" tabindex="8" placeholder="Teléfono aqui" required/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="generoDiv">Género</label>
                                </td>
                                <td>
                                    <div id="generoDiv">
                                        <input type="radio" id="genero" name="genero" value="M" checked>Masculino
                                        <input type="radio" id="genero" name="genero" value="F">Femenino
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="tipoDiv">Tipo de estudiante</label>
                                </td>
                                <td>
                                    <div id="tipoDiv">
                                        <input type="radio" id="tipo" name="tipo_estudiante" value="G" checked>Nuevo
                                        <input type="radio" id="tipo" name="tipo_estudiante" value="H">Antiguo
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        <br>
        <input class="botones" type="submit" onclick="return crearEstudiante();" value="Guardar">
    </div>
</form>