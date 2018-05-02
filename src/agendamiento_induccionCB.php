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
$tipoInduccion = null;
$induccion = array('titulo' => '', 'valor' => 1);
$actionTitle = '';
$action = '';
$modulo = $_POST["op"];

function validaTipoInduccion($tipoInduccion) {
    if($tipoInduccion === 'Virtual') {
        return array(
            'titulo' => ' - Inmersión a Campus',
            'valor' => 2
        );
    }

    return array(
        'titulo' => ' - Inducción General',
        'valor' => 1
    );
}


if ($modulo != "") {
    $copy = 0;
    $edit = 0;
    $delete = 0;
    $permisos = $consulta->permisos($modulo, $_SESSION["perfilid"]);
    while ($row = mysql_fetch_array($permisos)) {
        $copy = $row[0];
        $edit = $row[1];
        $delete = $row[2];
    }
} else {
    $copy = 0;
    $edit = 0;
    $delete = 0;
}

if($copy && $edit && $delete) {
    $tipoInduccion = $_POST['tipo_induccion'];
    $actionTitle = "<th title='Doble click'>Eliminar</th>";
    $action = "<td><button title='Eliminar Horario' $_SESSION[opc_el] name='boton_eliminar' id='boton_eliminar' type='button' onclick='HorarioCRUD(2);'></button></td>";
    $induccion = validaTipoInduccion($tipoInduccion);
}

$verificaMatriculado = $consulta->consultarMatriculado($documento);
if ($row = mysql_fetch_array($verificaMatriculado)) {
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
                <h2 id='p_fieldset_autenticacion_2'>Inscripciones Actuales".$induccion['titulo']."</h2>
            </div>
        </td>    
    </tr>
    ";
        if ($_SESSION['perfilid'] === '19')
            $induccionVr = null;
        else
            $induccionVr = $induccion['valor'];
        $horariosInduccionEstudiante = $consulta->verificarHorariosInducciónEstudiante($row['estudiante_id'], $row['periodo_academico_id'], $induccionVr);
        $muestraHorarios = false;
        while ($vRow = mysql_fetch_array($horariosInduccionEstudiante)) {
            $fecha = date('j/n/Y', strtotime($vRow['fecha_hora_inicio']));
            $horaInicio = date('h:i A', strtotime($vRow['fecha_hora_inicio']));
            $horaFin = date('h:i A', strtotime($vRow['fecha_hora_fin']));
            $dataText .= "
                <tr>
                    <td colspan='2' align='center'>
                        <table border='1' id='tablaHorariosEstudiantes'>
                            <thead><tr><th title='Dia/Mes/Año'>Fecha</th><th>Hora Inicial</th><th>Hora Final</th><th>Salón</th>$actionTitle</tr></thead>
                            <tbody>
                                <tr align='center'>
                                    <td title='Dia/Mes/Año'>
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
                                    $action
                                </tr>
                            </tbody>        
                        </table>    
                    </td>            
                </tr>
            ";
            // si el estudiante ha obtenido baja calificación en la evaluación de inducción
            $consultaAsistencia = $consulta->consultaInduccionEstudiante($row['estudiante_id'], $row['periodo_academico_id'], 2);
            if($rowCA = mysql_fetch_array($consultaAsistencia) && mysql_num_rows($horariosInduccionEstudiante) <= 1) {
                $muestraHorarios = true;
                $induccion = validaTipoInduccion('Virtual');
            }
        }
        if(!isset($consultaAsistencia)) {
            $dataText .= "
            <tr><td colspan='2' align='center'>No se encontraron registros</td></tr>
            ";
            $muestraHorarios = true;
        }
    $dataText .= "
                </tbody>
            </table>
            <div id='msg'></div>
        </div>
    ";
    date_default_timezone_get('America/Bogota');
    $fecha = date('Y/m/d', time());
    $consultaFecha = $consulta->verificarFechasInduccion($fecha, $row['periodo_academico_id']);
        if($muestraHorarios && $consultaFecha = mysql_fetch_array($consultaFecha)) {
            $dataText .= "
                <div id='HorariosInduccion'>
                    <div align='center' style='background-color: #004669'>
                        <h2 id='p_fieldset_autenticacion_2'>Horarios de Inducción".$induccion['titulo']."</h2>
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
            $consultaHorarios = $consulta->HorariosInduccionesAgendamiento($row['periodo_academico_id'], $row['zona_id'], $row['cead_id'], $row['programa_id'], $induccion['valor']);
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
                </div>
                ";
        }
    $dataText .= "
                    <input type='hidden' name='crud' id='crud' >
                </form>
                ";

        $consultaCentro = $consulta->consultaCentro($row['cead_id']);
        if($centro = mysql_fetch_array($consultaCentro))
            $additional = '<br><strong>Dirección: </strong>'.$centro['direccion'].'<br><strong>Teléfono: </strong>'.$centro['telefono'];

    echo json_encode(array(
        'title' => 'Resultado de la consulta',
        'text' => "Información de:\n$row[1]\nDocumento: $row[0]",
        'type' => 'success',
        'value' => $dataText,
        'additional' => $additional
    ));
} else {
    echo json_encode(array(
        'title' => 'Falla la consulta',
        'text' => 'No se encontró información de inducción del estudiante',
        'type' => 'error',
        'value' => '',
        'additional' => ''
    ));
}