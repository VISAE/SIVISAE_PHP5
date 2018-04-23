<?php
/**
 * Created by PhpStorm.
 * User: omar.bautista
 * Date: 20/04/2018
 * Time: 11:54 AM
 */
session_start();
include_once '../config/sivisae_class.php';
$consulta = new sivisae_consultas();

$documento = $_POST['documento_b'];
$tipoInduccion = $_POST['tipo_induccion'];

$verificaMatriculado = $consulta->consultarMatriculado($documento);
if ($row = mysql_fetch_array($verificaMatriculado)) {
    /*$periodoId = $row['periodo_academico_id'];
    $zonaId = $row['zona_id'];
    $ceadId = $row['cead_id'];
    $programaId = $row['programa_id'];*/
    $dataText = "
    <form method='post' id='formHorarios'>
        <div align='center' style='background-color: #004669'>
            <h2 id='p_fieldset_autenticacion_2'>Datos Básicos</h2>
        </div>
        <div align='center' id='datos_basicos'>
            <table>
                <thead>
                    <tr>
                        <th colspan='2' style='font-size: x-large;'>
                            $row[nombre]
                            <input type='hidden' name='id_estudiante' value='$row[estudiante_id]' />
                        </th>
                    </tr>
                </thead>            
                <tbody>
                    <tr>
                        <td><strong>Zona:</strong></td>
                        <td>$row[zona]</td>
                    </tr>
                    <tr>
                        <td><strong>Centro:</strong></td>
                        <td>$row[cead]</td>
                    </tr>
                    <tr>
                        <td><strong>Escuela:</strong></td>
                        <td>$row[escuela]</td>
                    </tr>
                    <tr>
                        <td><strong>Programa:</strong></td>
                        <td>$row[programa]</td>
                    </tr>
                    <tr>
                        <td><strong>Periodo Académico:</strong></td>
                        <td>$row[periodo_academico]</td>
                    </tr>";
    $dataText .= "
    <tr>
        <td colspan='2'>
            <div align='center' style='background-color: #004669'>
                <h2 id='p_fieldset_autenticacion_2'>Inscripciones Actuales - ".($tipoInduccion === 'Virtual'?'Inmersión a Campus':'Inducción General')."</h2>
            </div>
        </td>    
    </tr>
    ";
        $horariosInduccionEstudiante = $consulta->verificarHorariosInducciónEstudiante($row['estudiante_id'], $row['periodo_academico_id']);
        $muestraHorarios = false;
        if ($vRow = mysql_fetch_array($horariosInduccionEstudiante)) {
            $fecha = date('j/n/Y', strtotime($vRow['fecha_hora_inicio']));
            $horaInicio = date('h:i A', strtotime($vRow['fecha_hora_inicio']));
            $horaFin = date('h:i A', strtotime($vRow['fecha_hora_fin']));
            $dataText .= "
                <tr>
                    <td>
                        <table>
                            <thead><th>Fecha</th><th>Hora de Inicio</th><th>Hora de Finalización</th><th>Salón</th><th colspan='2'>ACCIONES (Doble click)</th></thead>
                            <tbody>
                                <tr>
                                    <td>
                                        $fecha
                                        <input type='hidden' name='induccion_horario_estudiante_id' value='$vRow[induccion_horario_estudiante_id]' />
                                    </td>
                                    <td>
                                        $horaInicio
                                    </td>
                                    <td>
                                        $horaFin
                                    </td>
                                    <td>
                                        $vRow[salon]
                                    </td>
                                    <td> 
                                        <button title='Editar Horario' $_SESSION[opc_ed] name='boton_editar' id='boton_editar' onclick='HorarioCRUD(2);'></button>
                                    </td>
                                    <td>
                                        <button title='Eliminar Horario' $_SESSION[opc_el] name='boton_eliminar' id='boton_eliminar' onclick='HorarioCRUD(3);'></button>
                                    </td>
                                </tr>
                            </tbody>        
                        </table>    
                    </td>            
                </tr>
            ";
        } else {
            $dataText .= "
            <tr><td colspan='2' align='center'>No se encontraron registros</td></tr>
            ";
            $muestraHorarios = true;
        }
    $dataText .= "
                </tbody>
            </table>
        </div>
    ";
    date_default_timezone_get('America/Bogota');
    $fecha = date('Y/m/d', time());
    $consultaFecha = $consulta->verificarFechasInduccion($fecha, $row['periodo_academico_id']);
        if($muestraHorarios && $consultaFecha = mysql_fetch_array($consultaFecha)) {
            $dataText .= "
                <div id='HorariosInduccion'>
                    <div align='center' style='background-color: #004669'>
                        <h2 id='p_fieldset_autenticacion_2'>Horarios de Inducción - ".($tipoInduccion === 'Virtual'?'Inmersión a Campus':'Inducción General')."</h2>
                    </div>
                    <table border='1'>
                        <thead>
                            <tr>
                                <th>SALÓN</th>               
                                <th>FECHA</th>                 
                                <th>HORA INICIAL</th>
                                <th>HORA FINAL</th>
                                <th>INSCRITOS</th>
                                <th>CUPOS</th>
                                <th>SELECCIONAR</th>
                            </tr>
                        </thead>
                        <tbody> 
                        ";
            $consultaHorarios = $consulta->HorariosInduccionesAgendamiento($row['periodo_academico_id'], $row['zona_id'], $row['cead_id'], $row['programa_id'], ($tipoInduccion === 'Virtual'?2:1));
            if(mysql_num_rows($consultaHorarios)) {
                while ($horarios = mysql_fetch_array($consultaHorarios)) {
                    $fecha = date('j/n/Y', strtotime($horarios['fecha_hora_inicio']));
                    $horaInicio = date('h:i A', strtotime($horarios['fecha_hora_inicio']));
                    $horaFin = date('h:i A', strtotime($horarios['fecha_hora_fin']));
                    $dataText .= "
                            <tr align='center'>
                                <td>$horarios[salon]</td>
                                <td>$fecha</td>
                                <td>$horaInicio</td>
                                <td>$horaFin</td>
                                <td>$horarios[inscritos]</td>                                
                                <td>$horarios[cupos]</td>
                                <td><input type='radio' id='horario' name='horario' value='$horarios[induccion_horario_id]' required></td>
                            </tr>
                        ";
                }
                $dataText .= "
                <tr><td colspan='12' align='center'><input type='button' class='botones' name='selecciona_horario' id='selecciona_horario' value='Registrar' onclick='HorarioCRUD(1);' /></td></tr>
                ";
            } else {
                $dataText .= "<tr><td colspan='12' align='center'>No hay horarios de inducción disponibles</td></tr>";
            }
            $dataText .= "
                        </tbody>      
                    </table>
                    <input type='hidden' name='crud' id='crud' />
                </div>
            </form>
                ";
        }

    echo json_encode(array(
        'title' => 'Resultado de la consulta',
        'text' => "Información de: $row[0]\n$row[1]",
        'type' => 'success',
        'value' => $dataText
    ));
} else {
    echo json_encode(array(
        'title' => 'Falla la consulta',
        'text' => 'No se encontró información de inducción del estudiante',
        'type' => 'error',
        'value' => ''
    ));
}