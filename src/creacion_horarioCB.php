<?php

session_start();
include '../config/sivisae_class.php';

$periodo = $_POST['periodo'];
$zona = $_POST['zona'];
$cead = $_POST['cead'];
$programa = $_POST['programa'];
$salon = $_POST['salon'];
$fecha_hora_inicio = explode('T', $_POST['fecha_hora_inicio']);
$fecha_hora_fin = explode('T', $_POST['fecha_hora_fin']);
$cupos = $_POST['cupos'];
$tipo_induccion = $_POST['tipo_induccion'];

$insert = new sivisae_consultas();

$validaFechaInicial = $insert->verificarFechasInduccion($fecha_hora_inicio[0], $periodo);
$validaFechaFinal = $insert->verificarFechasInduccion($fecha_hora_fin[0], $periodo);
$fecha_hora_inicio = implode(' ',$fecha_hora_inicio);
$fecha_hora_fin = implode(' ',$fecha_hora_fin);
$comparaFechas = strtotime($fecha_hora_inicio) < strtotime($fecha_hora_fin);

if($fi = mysql_fetch_array($validaFechaInicial) && $ff = mysql_fetch_array($validaFechaFinal) && $comparaFechas) {
    $row = $insert->agregaHorarioInduccion($zona, $cead, $programa, $periodo, $salon, $fecha_hora_inicio, $fecha_hora_fin, $cupos, $tipo_induccion);
    if($row > 0)
        echo "Horario agregado existosamente";
    else
        echo "Error al agregar horario",$zona, $cead, $programa, $periodo, $salon, $fecha_hora_inicio, $fecha_hora_fin, $cupos, $tipo_induccion;
} else {
    echo "Error: Las fechas se no se encuentran en el rango del periodo académico";
}
