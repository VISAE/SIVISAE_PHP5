<?php
session_start();
include '../config/sivisae_class.php';

$periodo = $_POST['periodo'];
$horario = $_POST['horario'];
$salon = $_POST['salon'];
$fecha_hora_inicio = explode('T', $_POST['fecha_hora_inicio']);
$fecha_hora_fin = explode('T', $_POST['fecha_hora_fin']);
$cupos = $_POST['cupos'];
$tipo_induccion = $_POST['tipo_induccion'] + (isset($_POST['tipo_induccion_general'])?$_POST['tipo_induccion_general']:1);


$update = new sivisae_consultas();

$validaFechaInicial = $update->verificarFechasInduccion($fecha_hora_inicio[0], $periodo);
$validaFechaFinal = $update->verificarFechasInduccion($fecha_hora_fin[0], $periodo);
$fecha_hora_inicio = implode(' ',$fecha_hora_inicio);
$fecha_hora_fin = implode(' ',$fecha_hora_fin);
$comparaFechas = strtotime($fecha_hora_inicio) < strtotime($fecha_hora_fin);

if($fi = mysql_fetch_array($validaFechaInicial) && $ff = mysql_fetch_array($validaFechaFinal) && $comparaFechas) {
    //se actualiza el horario
    $resUpd = $update->actualizarHorario($horario, $salon, $fecha_hora_inicio, $fecha_hora_fin, $cupos, $tipo_induccion);
} else {
    $resUpd = "<span style='color: red; font-weight: bold;'>Error: Las fechas se no se encuentran en el rango del periodo académico</span>";
}
//Se retona el resultado
echo $resUpd;

$update->destruir();