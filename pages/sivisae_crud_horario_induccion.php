<?php
include_once '../config/sivisae_class.php';
$consulta = new sivisae_consultas();
?>

<div align="right">
    <button title="Crear Horario" id="boton_crear" onclick="activarpopupcrear()" <?php echo $disabled_copy; ?> class="<?php echo $class_copy; ?>"></button>
</div>

<!--creacion de usuarios inicio-->
<div id="popup_crear">
    <span class="button_cerrar b-close"></span>
    <div align="center" style="background-color: #004669" >
        <h2 id='p_fieldset_autenticacion_2'>
            Crear Horario
        </h2>
    </div>
    <div  class="art-postcontent">
        <div align="center">
            <form id="crear_horario" name="crear_horario" method="post" onsubmit="return submitFormCrear()" action="src/creacion_usuarioCB.php">
                <div style="background-color: #E8E8E8">
                    <table style="width: 400px">
                        <tr>
                            <td><label for="cedula">Cédula (*):</label></td>
                            <td><input style="width: 180px;" id="cedula" name="cedula" type="text" maxlength="15" required="Falta el número de cedula"/></td>
                        </tr>
                        <tr>
                            <td ><label for="nombre">Nombre (*):</label></td>
                            <td><input style="width: 180px;" id="nombre" name="nombre" type="text" maxlength="30" required="Falta el nombre"/></td>
                        </tr>
                        <tr>
                            <td >Correo electrónico (*):</td>
                            <td><input style="width: 180px;" id="correo" name="correo"  type="text" maxlength="30" required="Falta el Correo electronico"/></td>
                        </tr>
                        <tr>
                            <td >Usuario:</td>
                            <td><input style="width: 180px;" id="usuario" contenteditable="false" name="usuario" type="text" maxlength="30" readonly="readonly"/></td>
                        </tr>
                        <tr>
                            <td>Perfil (*):</td>
                            <td>
                                <?php
                                $sbHtML2 = "<select required='required' style='width: 180px;' name='perfil' id='perfil' data-placeholder='Seleccione un perfil...' style='width: 150px' tabindex='2'>";
                                $sbHtML2.= "<option value=''></option>";
                                while ($row = mysql_fetch_array($respuesta)) {
                                    $sbHtML2.="<option value=$row[0]>";
                                    $sbHtML2.= $row[1];
                                    $sbHtML2.="</option>";
                                }
                                $sbHtML2.= "</select>";
                                echo $sbHtML2;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td >Teléfono fijo:</td>
                            <td><input style="width: 180px;" id="telefono" name="telefono" type="text" maxlength="10" /></td>
                        </tr>
                        <tr>
                            <td >Celular (*):</td>
                            <td><input style="width: 180px;" id="celular" name="celular" type="text" maxlength="11" required="Falta el Numero celular"/></td>
                        </tr>
                        <tr>
                            <td >Skype:</td>
                            <td><input style="width: 180px;" id="skype" name="skype" type="text" maxlength="30" /></td>
                        </tr>
                        <tr>
                            <td>Sede (*):</td>
                            <td>    <?php
                                $sbHtML2 = "";
                                $sbHtML2 = "<select required='required' style='width: 180px;' name='sede' id='sede' data-placeholder='Seleccione sede.' style='width: 150px' tabindex='2'>";
                                $sbHtML2.= "<option value=''></option>";
                                while ($row = mysql_fetch_array($sedes)) {
                                    $sbHtML2.="<option value=$row[0]>";
                                    $sbHtML2.= $row[1];
                                    $sbHtML2.="</option>";
                                }
                                $sbHtML2.= "</select>";
                                echo $sbHtML2;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p><input class="submit_fieldset_autenticacion" type="submit" value="Crear"/></p>
                                <div align="center" id="result"></div>
                                <div id="spinner" align="center" style="display:none;">
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
<!--creacion de usuarios fin-->
