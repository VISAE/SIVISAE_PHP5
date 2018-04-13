<?php
session_start();
include_once '../config/sivisae_class.php';
$consulta = new sivisae_consultas();
$periodo = $_POST['periodo'];
$zona = $_POST['zona'];
$cead = $_POST['cead'];
$escuela = $_POST['escuela'];
$programa = $_POST['programa'];
//echo $periodo, $zona, $cead[0], $programa;
$filtros = array('Periodo'=>$periodo, 'Zona'=>$zona, 'Centro'=>$cead, 'Escuela'=>$programa, 'Programa'=>$programa);
$filtrosValidos = '';
foreach ($filtros as $k => $v) {
    if(empty($v)) {
        $filtrosValidos .= ($filtrosValidos == '') ? $k : ', ' . $k;
        break;
    } else {
        eval("\$filtroConsulta = \$consulta->consulta$k(\$v".(is_array($v)?'[0]':'').");");
        if($row = mysql_fetch_assoc($filtroConsulta)) {
            $filtros[$k] = $row[$k];
        }
    }
}
//var_dump($filtros);
if(isset($periodo) && empty($filtrosValidos)) {
    date_default_timezone_get('America/Bogota');
    $fecha = date('Y/m/d', time());
    $validaFecha = $consulta->verificarFechasInduccion($fecha, $periodo);
    if ($row = mysql_fetch_array($validaFecha)) {
        ?>

        <div align="right">
            <button title="Crear Horario" id="boton_crear" onclick="activarpopupcrear()" <?php echo $_SESSION['opc_cr'] ?>"></button>
        </div>

        <!--creacion de usuarios inicio-->
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
                          action="src/creacion_usuarioCB.php">
                        <div style="background-color: #E8E8E8">
                            <table style="width: 400px">
                                <tr>
                                    <td colspan="2"><label>
                                            Periodo: <?php echo $filtros['Periodo'] ?><br>
                                            Zona: <?php echo $filtros['Zona'] ?><br>
                                            Centro: <?php echo $filtros['Centro'] ?><br>
                                            Escuela: <?php echo $filtros['Escuela'] ?><br>
                                            Programa: <?php echo $filtros['Programa'] ?><br>
                                        </label></td>
                                </tr>
                                <tr>
                                    <td><label for="nombre">Hora de inicio (*):</label></td>
                                    <td><input style="width: 180px;" id="nombre" name="nombre" type="text"
                                               maxlength="30"
                                               required="Falta el nombre"/></td>
                                </tr>
                                <tr>
                                    <td>Hora de finalización (*):</td>
                                    <td><input style="width: 180px;" id="correo" name="correo" type="text"
                                               maxlength="30"
                                               required="Falta el Correo electronico"/></td>
                                </tr>
                                <tr>
                                    <td>Salón (*):</td>
                                    <td><input style="width: 180px;" id="usuario" contenteditable="false" name="usuario"
                                               type="text" maxlength="30" readonly="readonly"/></td>
                                </tr>
                                <tr>
                                    <td>Cupos (*):</td>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <td>Inscritos (*):</td>
                                    <td><input style="width: 180px;" id="telefono" name="telefono" type="text"
                                               maxlength="10"/></td>
                                </tr>
                                <tr>
                                    <td>Tipo de inducción (*):</td>
                                    <td><input style="width: 180px;" id="celular" name="celular" type="text"
                                               maxlength="11"
                                               required="Falta el Numero celular"/></td>
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
        <!--creacion de usuarios fin-->
        <?php
    }
}
?>