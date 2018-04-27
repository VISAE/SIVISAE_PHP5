<?php

session_start();
include_once './excel/PHPExcel.php';
include_once '../config/sivisae_class.php';
//include_once './crear_reporteCB.php';
set_time_limit(300);
if (!isset($_FILES['archivo'])) {
    echo 'Ha habido un error, tiene que elegir un archivo';
} else {
    $nombre = $_FILES['archivo']['name'];
    $nombre_tmp = $_FILES['archivo']['tmp_name'];
    $tipo = $_FILES['archivo']['type'];
    $tamano = $_FILES['archivo']['size'];

    $ext_permitidas = array('xls', 'xlsx', 'csv');
    $partes_nombre = explode('.', $nombre);
    $extension = end($partes_nombre);
    $ext_correcta = in_array($extension, $ext_permitidas);

    $tipo_correcto = preg_match('/^excel\/(xls|xlsx|csv)$/', $tipo);

    $limite = 500 * 1024;
    $consulta = new sivisae_consultas();
    $estudiantes = array();

    if ($ext_correcta) {
        if ($_FILES['archivo']['error'] > 0) {
            echo 'Error: ' . $_FILES['archivo']['error'] . '<br/>';
        } else {
            move_uploaded_file($nombre_tmp, "../tmp/" . $nombre);

            if($extension=='csv') {
                $objReader = PHPExcel_IOFactory::createReader('CSV')
                    ->setDelimiter(";");
                $objReader->setInputEncoding('');
                $phpExcel = $objReader->load("../tmp/" . $nombre);
            }else {
                $phpExcel = PHPExcel_IOFactory::load("../tmp/" . $nombre);
            }
            $hoja = $phpExcel->getActiveSheet()->toArray(true, true, true);
//            var_dump($hoja);
            $encabezados = '';
            $counter = 0;
            foreach ($hoja as $indice => $fila) {
                if($indice == 5) { // captura periodo
                    $periodo = $consulta->consultaPeriodo($fila[0]);
                    if ($row = mysql_fetch_array($periodo))
                        $periodo = $row[0];
                    else
                        die("Error: Periodo académico inválido. <br>");
//                    echo $periodo;
                }
                if($indice == 6) //captura encabezados
                    $encabezados = $fila;
                if($indice > 6) { // Inicio informacion estudiantes
                    $estudiante = array_combine($encabezados, $fila);
                    if(is_numeric($estudiante["Código"])) {
                        $centro = trim(preg_replace("/\(.*?\)/", "", $estudiante["Centro"]));
                        $idCentro = $consulta->consultaCentro(ucwords($centro));
                        $idCentro = mysql_fetch_array($idCentro)[0];
                        $idPrograma = $consulta->consultaPrograma($estudiante["Programa"]);
                        $idPrograma = mysql_fetch_array($idPrograma)[0];
                        $tipo = ($estudiante["Tipo"] == "NUEVO") ? "H" : "G";
                        $genero = ($estudiante["Genero"] == "MASCULINO") ? "M" : "F";
                        $usuario = explode("@", $estudiante["Email Institucional"])[0];

                        $datosEstudiante = $consulta->consultaEstudiante($estudiante["Código"]);
                        if (!$row = mysql_fetch_array($datosEstudiante)) { // si NO encuentra datos del estudiante
                            $datosEstudiante = Array(
                                'cedula' => $estudiante["Código"],
                                'nombre' => $estudiante["Nombres"] . ' ' . $estudiante["Apellidos"],
                                'correo' => $estudiante["Email Personal"],
                                'cead_cead_id' => $idCentro,
                                'skype' => 'skype',
                                'fecha_nacimiento' => '1970-01-01',
                                'genero' => $genero,
                                'estado_civil' => 'Soltero(a)',
                                'telefono' => $estudiante["Telefono"],
                                'usuario' => $usuario);

                            $idEstudiante = $consulta->agregaEstudiante($datosEstudiante);
                            $tipoEstudiante = 'G';
                        } else {
                            $idEstudiante = $row[0];
                            $tipoEstudiante = 'H';
                        }

                        $datosMatricula = $consulta->consultaMatricula($idEstudiante, $periodo, $idPrograma);
                        if (!$idMatricula = mysql_fetch_array($datosMatricula)) {
                            $datosMatricula = Array('estudiante_estudiante_id' => $idEstudiante,
                                'periodo_academico_periodo_academico_id' => $periodo,
                                'programa_programa_id' => $idPrograma,
                                'tipo_estudiante' => $tipoEstudiante,
                                'numero_matriculas' => 1);
                            $idMatricula = $consulta->agregaMatricula($datosMatricula);
                            $counter += 1;
                        }
//                    $estudiantes[]=Array($row[0], $periodo, $idPrograma, $estado);
                    }
                }
            }

//            echo json_encode($estudiantes, JSON_UNESCAPED_UNICODE);
            echo $counter." Registros insertados exitosamente";
        }
    } else {
        echo 'Archivo inválido <br>';
    }
}