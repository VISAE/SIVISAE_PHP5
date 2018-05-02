<?php
/**
 * Created by PhpStorm.
 * User: omar.bautista
 * Date: 20/03/2018
 * Time: 12:37 PM
 */
session_start();
include_once '../config/sivisae_class.php';
//include_once '../pages/sivisae_filtro_induccion_agrega_estudiante.php';
$consulta = new sivisae_consultas();

if (isset($_POST['documento']) && isset($_POST['periodo'])) {
    $documento = $_POST['documento'];
    $periodo = $_POST['periodo'];

    $datosEstudiante = $consulta->consultarMatriculado($documento, $periodo);
    if ($row = mysql_fetch_array($datosEstudiante)) {

        $dataText = "
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
                <h2 id='p_fieldset_autenticacion_2'>Inscripciones Actuales</h2>
            </div>
        </td>    
    </tr>
    ";
        // el valor de parámetro inducción es nulo para validar todos los eventos de inducción registrados
        $horariosInduccionEstudiante = $consulta->verificarHorariosInducciónEstudiante($row['estudiante_id'], $row['periodo_academico_id']);
        $encontrado = false;
        while ($vRow = mysql_fetch_array($horariosInduccionEstudiante)) {
            $fecha = date('j/n/Y', strtotime($vRow['fecha_hora_inicio']));
            $horaInicio = date('h:i A', strtotime($vRow['fecha_hora_inicio']));
            $horaFin = date('h:i A', strtotime($vRow['fecha_hora_fin']));
            $dataText .= "
                <tr>
                    <td colspan='2' align='center'>
                        <table border='1'>
                            <thead><tr><th title='Dia/Mes/Año'>Fecha</th><th>Hora Inicial</th><th>Hora Final</th><th>Salón</th></tr></thead>
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
                                </tr>
                            </tbody>        
                        </table>    
                    </td>            
                </tr>
            ";
            $encontrado = true;
        }

        if($encontrado) {
            $asisteInduccionEstudiante = $consulta->consultaInduccionEstudiante($row['estudiante_id'], $row['periodo_academico_id']);
            if ($rowIE = mysql_fetch_array($asisteInduccionEstudiante))
                $salida = Array('typeSwal' => 'info',
                    'titleSwal' => 'El estudiante ' . $row['nombre'] . ' ya registró su asistencia',
                    'response' => $dataText);
            else {
                $registrarAsistencia = $consulta->registrarAsistenciaEventoInduccion($row['estudiante_id'], 1, $row['periodo_academico_id']);
                if($registrarAsistencia)
                    $salida = Array('typeSwal' => 'success',
                        'titleSwal' => 'El estudiante ' . $row['nombre'] . ' ha ingresado exitosamente',
                        'response' => $dataText,
                        'alert' => Array(
                            'type' => 'alert success',
                            'title' => 'Ingreso: ',
                            'text' => 'Satisfactorio'));
                else
                    $salida = Array('typeSwal' => 'error',
                        'titleSwal' => 'No se ha podido completar el registro',
                        'response' => $dataText);
            }
        } else {
            $dataText .= "
                <tr><td colspan='2' align='center'>No se encontraron registros</td></tr>
            ";
            $salida = Array('typeSwal' => 'warning',
                'titleSwal' => 'El estudiante ' . $row['nombre'] . ' No registra citas de inducción',
                'response' => $dataText);
        }
        $dataText .= "
                </tbody>
            </table>
        </div>
        ";
    } else {
        $salida = Array('typeSwal' => 'error',
            'titleSwal' => 'Verifique el periodo académico',
            'response' => "");
        date_default_timezone_get('America/Bogota');
        $fecha = date('Y/m/d', time());
        $consultaFecha = $consulta->verificarFechasInduccion($fecha, $periodo);
        if ($rowF = mysql_fetch_array($consultaFecha)) {
            $salida = Array('typeSwal' => 'warning',
                'titleSwal' => 'Registro Inexistente',
                'textSwal' => '¿desea proceder a crearlo?',
                'response' => "",
                'cancelBtn' => true);
        }
    }
    echo json_encode($salida);
} else {
    echo json_encode(Array('typeSwal'=>'warning',
        'titleSwal'=>'Error',
        'response'=>'Error: Verifique los campos'));
}
?>