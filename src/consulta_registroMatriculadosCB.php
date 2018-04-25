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
    $salida = Array('typeSwal'=>'warning',
        'titleSwal'=>'Registro Inexistente proceda a crearlo',
        'response'=>"
                    <script>
                        $('#datosEstudiante').show();
                    </script>                    
                    "
        /*<form>
            <div align='center' style='background-color: #004669'>
                <h2 id='p_fieldset_autenticacion_2'>
                    Datos personales del Estudiante
                </h2>
            </div>
            <div align='center'>
                <table>"
                    .filtroInduccion().
                "</table>
            </div>
        </form>"*/
    );
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
        $horariosInduccionEstudiante = $consulta->verificarHorariosInducciónEstudiante($row['estudiante_id'], $row['periodo_academico_id'], 1);
        if ($vRow = mysql_fetch_array($horariosInduccionEstudiante)) {
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
        } else {
            $dataText .= "
            <tr><td colspan='2' align='center'>No se encontraron registros</td></tr>
            ";
            $encontrado = false;
        }
        $dataText .= "
                </tbody>
            </table>
        </div>
    ";

        if($encontrado) {
            $salida = Array('typeSwal' => 'info',
                'titleSwal' => 'El estudiante ' . $row[1] . ' ha ingresado exitosamente',
                'response' => $dataText);
        } else {
            $salida = Array('typeSwal' => 'warning',
                'titleSwal' => 'El estudiante ' . $row[1] . ' No registra citas de inducción',
                'response' => $dataText);
        }
    }
    echo json_encode($salida);
} else {
    echo json_encode(Array('typeSwal'=>'warning',
        'titleSwal'=>'El documento no aparece registrado en el periodo académico',
        'response'=>'Error'));
}
?>