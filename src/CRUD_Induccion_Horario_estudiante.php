<?php
session_start();
include_once '../config/sivisae_class.php';
$consulta = new sivisae_consultas();

switch ($_POST['crud']) {
    case 1:
        ejecutar($consulta->agregarHorarioInduccionEstudiante($_POST['id_estudiante'], $_POST['horario']), 'Selección', 'Agregada', 'alert success');
        break;
    case 2:
        ejecutar($consulta->eliminarHorarioInduccionEstudiante($_POST['induccion_horario_estudiante_id']), 'Eliminación', 'Eliminada', 'alert');
        break;
}


function ejecutar($ejecutaOperacion, $titulo, $texto, $tipo) {

    if($ejecutaOperacion || is_resource($ejecutaOperacion)) {
        echo json_encode(array(
            'tipo' => $tipo,
            'titulo' => "$titulo de cita de inducción",
            'mensaje' => "$texto existosamente"
        ));
    } else {
        echo json_encode(array(
            'tipo' => 'alert',
            'titulo' => "$titulo de cita de inducción",
            'mensaje' => "Ha fallado la operación"
        ));
    }
}