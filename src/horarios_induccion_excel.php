<?php

session_start();
include_once '../config/sivisae_class.php';
include './paginador.php';
include_once './crear_reporteCB.php';
$consulta = new sivisae_consultas();


$periodo = $_POST['periodo'];
$zona = isset($_POST['zona']) && $_POST['zona'] != '' ? implode(", ", $_POST['zona']) : "T";
$cead = isset($_POST['cead']) && $_POST['cead'] != '' ? implode(", ", $_POST['cead']) : "T";
$escuela = isset($_POST['escuela']) && $_POST['escuela'] != '' ? implode("', '", $_POST['escuela']) : "T";
$programa = isset($_POST['programa']) && $_POST['programa'] != '' ? implode(", ", $_POST['programa']) : "T";



$asignar = array();

$temp = $consulta->HorariosInduccionesExcel($periodo, $zona, $cead, $escuela, $programa);

while ($fila = mysql_fetch_array($temp)) {
    $asignar[] = $fila;
}


$titulo = "Reporte de horarios de inducción";

$columnas = array("ZONA", "CEAD", "PROGRAMA", "ESCUELA", "PERIODO ACADEMICO", "FECHA Y HORA INICIAL", "FECHA Y HORA FINAL", "SALÓN", "CUPOS", "INSCRITOS", "TIPO INDUCCION");
$nombre_arch = "Reporte Horarios Induccion";
$desc = "Reporte que contiene un listado de horarios de inducciones.";
$ruta = generarReporte($titulo, $columnas, $asignar, $nombre_arch, $desc);

echo $ruta;
