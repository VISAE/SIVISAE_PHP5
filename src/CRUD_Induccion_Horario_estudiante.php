<?php
session_start();
include_once '../config/sivisae_class.php';
$consulta = new sivisae_consultas();

switch ($_POST['crud']) {
    case 1:
        ejecutar($consulta->agregarHorarioInduccionEstudiante($_POST['id_estudiante'], $_POST['horario']), 'Selección', 'Agregado');
    break;
    case 2:
        ejecutar($consulta->actualizarHorarioInduccionEstudiante($_POST['induccion_horario_estudiante_id'], $_POST['horario']), 'Cambio', 'Actualizado');
        break;
    case 3:
        ejecutar($consulta->eliminarHorarioInduccionEstudiante($_POST['induccion_horario_estudiante_id']), 'Eliminación', 'Eliminado');
        break;
}


function ejecutar($ejecutaOperacion, $titulo, $texto) {

    //if(mysql_fetch_array($ejecutaOperacion)) {
        echo json_encode(array(
            'title' => "$titulo de horario",
            'text' => "$texto existosamente",
            'type' => 'success'
        ));
    //}
}