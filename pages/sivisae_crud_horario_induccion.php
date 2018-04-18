<?php
        ?>

        <div align="right">
            <button title="Crear Horario" id="boton_crear" onclick="activarpopupcrear()" <?php echo $_SESSION['opc_cr'] ?>"></button>
        </div>

        <!--creacion de horarios inicio-->
        <div id="popup_crear">
            <span class="button_cerrar b-close"></span>
            <div align="center" style="background-color: #004669">
                <h2 id='p_fieldset_autenticacion_2'>
                    Crear Horario
                </h2>
            </div>
            <div class="art-postcontent">
                <div align="center">
                    <form id="crear_horario" name="crear_horario" method="post" onsubmit="return submitFormCrear()"
                          action="src/creacion_horarioCB.php">
                        <div style="background-color: #E8E8E8">
                            <table style="width: 400px">
                                <tr>
                                    <td colspan="2">
                                        <label id="datosGenerales">
                                            Periodo:
                                            Zona:
                                            Cead:
                                            Escuela:
                                            Programa:
                                        </label>
                                        <input type="hidden" name="periodo" id="hiddenPeriodo" />
                                        <input type="hidden" name="zona" id="hiddenZona" />
                                        <input type="hidden" name="cead" id="hiddenCead" />
                                        <input type="hidden" name="programa" id="hiddenPrograma" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 30%">Fecha y Hora de inicio (*):</td>
                                    <td><input style="width: 230px;" id="fecha_hora_inicio" name="fecha_hora_inicio" type="datetime-local"
                                               maxlength="30" required="Falta la fecha y hora"/></td>
                                </tr>
                                <tr>
                                    <td>Fecha y Hora de cierre (*):</td>
                                    <td><input style="width: 230px;" id="fecha_hora_fin" name="fecha_hora_fin" type="datetime-local"
                                               maxlength="30" required="Falta la fecha y hora"/></td>
                                </tr>
                                <tr>
                                    <td>Salón (*):</td>
                                    <td><input style="width: 230px;" id="salon" name="salon" type="text"
                                               maxlength="30" /></td>
                                </tr>
                                <tr>
                                    <td>Cupos (*):</td>
                                    <td><input style="width: 230px;" id="cupos" name="cupos" type="number"
                                               maxlength="3" min="0" step="1"
                                               required="Falta la cantidad de cupos"/></td>
                                </tr>
                                <tr>
                                    <td>Tipo de inducción (*):</td>
                                    <td><select style="width: 230px;" id="tipo_induccion" name="tipo_induccion" data-placeholder='Seleccione tipo de inducción' required="Falta tipo de inducción">
                                            <option value="1">Inducción General</option>
                                            <option value="2">Inmersión a Campus</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p><input class="submit_fieldset_autenticacion" type="submit" value="Crear"/>
                                        </p>
                                        <div align="center" id="result"></div>
                                        <div id="spinner" align="center" style="display:none;">
                                            <img id="img-spinner" width="50" height="50"
                                                 src="template/imagenes/generales/loading.gif" alt="Loading"/>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!--creacion de horarios fin-->
    <!--edicion de usuarios inicio-->
    <div id="popup_editar">
        <span class="button_cerrar b-close"></span>
        <div align="center" style="background-color: #004669" >
            <h2 id='p_fieldset_autenticacion_2'>
                Editar Horario
            </h2>
        </div>
        <div  class="art-postcontent">
            <div align="center">
                <form id="editar_horario" name="editar_horario" method="post" onsubmit="return submitFormEditar()" action="src/actualiza_horarioCB.php">
                    <div style="background-color: #E8E8E8">
                        <table style="width: 400px">
                            <tr>
                                <td colspan="2">
                                    <label id="datosGenerales_e">
                                        Periodo:
                                        Zona:
                                        Cead:
                                        Escuela:
                                        Programa:
                                    </label>
                                    <input type="hidden" name="horario" id="hiddenhorario_e" />
                                    <input type="hidden" name="periodo" id="hiddenPeriodo_e" />
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 30%">Fecha y Hora de inicio (*):</td>
                                <td><input style="width: 230px;" id="fecha_hora_inicio_e" name="fecha_hora_inicio" type="datetime-local"
                                           maxlength="30" required="Falta la fecha y hora"/></td>
                            </tr>
                            <tr>
                                <td>Fecha y Hora de cierre (*):</td>
                                <td><input style="width: 230px;" id="fecha_hora_fin_e" name="fecha_hora_fin" type="datetime-local"
                                           maxlength="30" required="Falta la fecha y hora"/></td>
                            </tr>
                            <tr>
                                <td>Salón :</td>
                                <td><input style="width: 230px;" id="salon_e" name="salon" type="text"
                                           maxlength="30" /></td>
                            </tr>
                            <tr>
                                <td>Cupos (*):</td>
                                <td><input style="width: 230px;" id="cupos_e" name="cupos" type="number"
                                           maxlength="3" min="0" step="1"
                                           required="Falta la cantidad de cupos"/></td>
                            </tr>
                            <tr>
                                <td>Tipo de inducción (*):</td>
                                <td><select style="width: 230px;" id="tipo_induccion_e" name="tipo_induccion" data-placeholder='Seleccione tipo de inducción' required="Falta tipo de inducción">
                                        <option value="1">Inducción General</option>
                                        <option value="2">Inmersión a Campus</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input style="width: 180px;" id="id_e" name="id_e" type="hidden" maxlength="30" />
                                    <input style="width: 180px;" id="id_e_p" name="id_e_p" type="hidden" maxlength="30" />
                                    <p><input id="btn_submit_e" name="btn_submit_e" class="submit_fieldset_autenticacion" type="submit" value="Actualizar"/></p>
                                    <div align="center" id="result_e"></div>
                                    <div id="spinner_e" align="center" style="display:none;">
                                        <img id="img-spinner" width="50" height="50" src="template/imagenes/generales/loading.gif" alt="Loading"/>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!--edicion de usuarios fin-->

    <!--eliminar usuarios inicio-->
    <div id="popup_eliminar">
        <span class="button_cerrar b-close"></span>
        <div align="center" style="background-color: #004669" >
            <h2 id='p_fieldset_autenticacion_2'>
                Eliminar Horario
            </h2>
        </div>
        <div  class="art-postcontent">
            <div align="center">
                <form id="eliminar_horario" name="eliminar_horario" method="post" onsubmit="return submitFormEliminar()" action="src/eliminar_horarioCB.php">
                    <div style="background-color: #E8E8E8">
                        <table style="width: 400px">
                            <tr>
                                <td><label>¿Realmente desea eliminar el horario?.</label></td>
                            </tr>
                            <tr>
                                <td><label id="datosGenerales_el"></label></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input style="width: 180px;" id="id_el" name="id_el" type="hidden" maxlength="30" />
                                    <p><input id="btn_submit_el" class="submit_fieldset_autenticacion" type="submit" value="Eliminar"/></p>
                                    <div align="center" id="result_el"></div>
                                    <div id="spinner_el" align="center" style="display:none;">
                                        <img id="img-spinner" width="50" height="50" src="template/imagenes/generales/loading.gif" alt="Loading"/>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!--eliminar usuarios fin-->
        <?php

?>