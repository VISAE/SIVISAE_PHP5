<?php
session_start();
include_once '../config/sivisae_class.php';
$consulta = new sivisae_consultas();
if(isset($_POST['cedula_id'])) {
    $texto = '';
    $datosEstudiante = $consulta->consultaEstudiante($_POST['cedula_id']);
    if(!$row = mysql_fetch_array($datosEstudiante)) {
        $datos = array(
            'cedula' => $_POST['cedula_id'],
            'nombre' => $_POST['nombre'],
            'correo' => $_POST['email'],
            'cead_cead_id' => $_POST['cead'][0],
            'skype' => $_POST['skype'],
            'fecha_nacimiento' => $_POST['1970-01-01'],
            'genero' => $_POST['genero'],
            'estado_civil' => $_POST['Soltero(a)'],
            'telefono' => $_POST['telefono'],
            'usuario' => $_POST['']
        );
        $idEstudiante = $consulta->agregaEstudiante($datos);
        $tipoEstudiante = 'G';
        $texto .= 'datos del estudiante agregados correctamente, ';
    } else {
        $idEstudiante = $row[0];
        $tipoEstudiante = 'H';
        $texto .= 'el estudiante ya existe, ';
    }
    $datosMatricula = $consulta->consultaMatricula($idEstudiante, $_POST['periodo_id'], $_POST['programa'][0]);
    if (!$idMatricula = mysql_fetch_array($datosMatricula)) {
        $datosMatricula = array(
            'estudiante_estudiante_id' => $idEstudiante,
            'periodo_academico_periodo_academico_id' => $_POST['periodo_id'],
            'programa_programa_id' => $_POST['programa'][0],
            'tipo_estudiante' => $tipoEstudiante,
            'numero_matriculas' => 1
        );
        $idMatricula = $consulta->agregaMatricula($datosMatricula);
        $texto .= 'datos de matrícula agregados correctamente.';
    } else {
        $texto .= 'ya se encuentra matriculado';
    }
    echo json_encode(array(
        'title' => 'Resultado del registro',
        'text' => $texto,
        'type' => 'success'
    ));
} else {
    echo json_encode(array(
        'title' => 'Error',
        'text' => 'Verifique que todos los campos esten diligenciados',
        'type' => 'error'
    ));
}