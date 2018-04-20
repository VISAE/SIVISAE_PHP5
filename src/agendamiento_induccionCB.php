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
    $dataText = "
        <div align='center' style='background-color: #004669'>
            <h2 id='p_fieldset_autenticacion_2'>Datos Básicos</h2>
        </div>
        <div align='center' id='datos_basicos'>
            <table>
                <thead>
                    <tr>
                        <th colspan='2' style='font-size: x-large;'>$row[nombre]</th>
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
        $counter = 0;
        while($vRow = mysql_fetch_array($horariosInduccionEstudiante)) {
            $dataText .= "
                <tr>
                    <td>
                        <table>
                            <thead><th>Fecha</th><th>Hora de Inicio</th><th>Hora de Finalización</th><th>Salón</th></thead>
                            <tbody>
                                <tr><td>$vRow[fecha_hora_inicio]</td><td>$vRow[fecha_hora_inicio]</td><td>$vRow[fecha_hora_fin]</td><td>$vRow[salon]</td></tr>
                            </tbody>        
                        </table>    
                    </td>            
                </tr>
            ";
            $counter++;
        }
        if(!$counter) {
            $dataText .= "
            <tr><td colspan='2' align='center'>No se encontraron registros</td></tr>
            ";
        }
    $dataText .= "
                </tbody>
            </table>
        </div>
    ";

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