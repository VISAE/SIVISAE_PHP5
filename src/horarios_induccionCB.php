<?php

session_start();
include_once '../config/sivisae_class.php';
include './paginador.php';
$consulta = new sivisae_consultas();
$sintilde = explode(',', SIN_TILDES);
$tildes = explode(',', TILDES);


$periodo = $_POST['periodo'];
$zona = isset($_POST['zona']) && $_POST['zona'] != '' ? implode(", ", $_POST['zona']) : "T";
$cead = isset($_POST['cead']) && $_POST['cead'] != '' ? implode(", ", $_POST['cead']) : "T";
$escuela = isset($_POST['escuela']) && $_POST['escuela'] != '' ? implode("', '", $_POST['escuela']) : "T";
$programa = isset($_POST['programa']) && $_POST['programa'] != '' ? implode(", ", $_POST['programa']) : "T";
//$pagina = $_POST["page"];
$auditor = isset($_POST['auditor']) && $_POST['auditor'] != '' ? $_POST['auditor'] : 'T';

$registros;
$buscar;
$seleccionados = array();
if (isset($_POST["registros"])) {
    $registros = $_POST["registros"];
} else {
    $registros = 10;
}

//$auditor = 'T';
//echo $pagina;
if (isset($_POST["page"])) {
    $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
    if (!is_numeric($page_number)) {
        die('N' . chr(250) . 'mero de p' . chr(225) . 'gina incorrecto!');
    } //incase of invalid page number
} else {
    $page_number = 1; //Si no hay numero de pagina coloca 1 por defecto
}
//Cantidad de items a mostrar
$item_per_page = $registros;
//Obtiene la cantidad total de registros desde BD para crear la paginacion
$cantAud;
$cantAud = $consulta->cantHorariosInducciones($periodo, $zona, $cead, $escuela, $programa);

$get_total_rows = $cantAud;

//Divide la cantidad de registros totales entre la cantidad de registros a mostrar para saber cuantas paginas se crearan
$total_pages = ceil($get_total_rows / $item_per_page);

//Obtengo la posicion en que debe arrancar la siguiente consulta.
$page_position = (($page_number - 1) * $item_per_page);

$inducciones = $consulta->HorariosInducciones($periodo, $zona, $cead, $escuela, $programa, $page_position, $item_per_page);

if (count($inducciones) <= 0) {
    echo 'No existen resultados para esta consulta';
} else {

    echo "<br>
        
        <a href='#' onclick='return crearReporte()'  id='excel-asignados' class='botones'>Descargue este listado</a>";
    

    echo "
    <br><br>
        <div style='overflow-y: hidden; overflow-x:scroll;'>
        <table id='tb_estudiantes' class='tg' style='table-layout: fixed; width=300px'>
				<thead>
                                        <tr>
                                                <th>ZONA</th>
                                                <th>CEAD</th>
                                                <th>PROGRAMA</th>
                                                <th>ESCUELA</th>
                                                <th>PERIODO ACADEMICO</th>
                                                <th>FECHA Y HORA INICIAL</th>
                                                <th>FECHA Y HORA FINAL</th>
                                                <th>SALÓN</th>
                                                <th>CUPOS</th>
                                                <th>INSCRITOS</th>
                                                <th>TIPO INDUCCION</th>
                                                <th colspan='2'>ACCIONES (Doble click)</th>
					</tr>
				</thead>
                        <tbody>
                    ";
    while ($row = mysql_fetch_array($inducciones)) {
        $horario_id = $row[0];
        $zona_des = $row[1];
        $cead_des = $row[2];
        $programa_des = $row[3];
        $escuela_des = $row[4];
        $periodo_academico = $row[5];
        $fecha_y_hora_inicial = $row[6];
        $fecha_y_hora_final = $row[7];
        $salon = $row[8];
        $cupos = $row[9];
        $inscritos = $row[10];
        $tipo_induccion_id = $row[11];
        $tipo_induccion = $row[12];

        echo "<tr>"
        . "<td>$zona_des</td>"
        . "<td>$cead_des</td>"
        . "<td>$programa_des</td>"
        . "<td>$escuela_des</td>"
        . "<td>$periodo_academico</td>"
        . "<td>$fecha_y_hora_inicial</td>"
        . "<td>$fecha_y_hora_final</td>"
        . "<td>$salon</td>"
        . "<td>$cupos</td>"
        . "<td>$inscritos</td>"
        . "<td>$tipo_induccion</td>"
        . "<td> <button title='Editar Horario' ".$_SESSION['opc_ed']." id='boton_editar" . $horario_id . "' onclick='activarpopupeditar(" . $horario_id . ")'></button> </td>"
        . "<td> <button title='Eliminar Horario' ".$_SESSION['opc_el']."  id='boton_eliminar" . $horario_id . "' onclick='activarpopupeliminar(" . $horario_id . ")'></button> </td>"
        . "<input type='hidden' id='input_" . $horario_id . "' value='" . $horario_id . "|" . $zona_des . "|" . $cead_des . "|" . $programa_des . "|" . $escuela_des . "|" . $periodo_academico . "|" . $fecha_y_hora_inicial . "|" . $fecha_y_hora_final . "|" . $salon . "|" . $cupos . "|" . $inscritos . "|" . $tipo_induccion_id . "'></input>"
        . "</tr>";
    }

    echo "     </tbody>
                    </table></div>";

    echo '<div align="center"><br><br>'
    . '<table><tr><td>Mostrando ' . $registros . ' registros de ' . $get_total_rows . ' encontrados.</td>'
    . '<td>';
    echo paginate_function($item_per_page, $page_number, $get_total_rows, $total_pages);
    echo '</td>'
    . '<td> de ' . $total_pages . ' p&aacute;ginas.</td></tr></table></div>'
    . '<div id="oculto">'
    . '<input type="hidden" id="est_hid" name="est_hid[]"/>'
    . '</div>';
}

// validación para mostrar popup agregar horario
if($zona !== "T" && $cead !== "T" && $escuela !== "T") {
    date_default_timezone_get('America/Bogota');
    $fecha = date('Y/m/d', time());
    $validaFecha = $consulta->verificarFechasInduccion($fecha, $periodo);
    if($row = mysql_fetch_array($validaFecha)) {
        echo '<script>
                $("#boton_crear").show();
                $("#hiddenPeriodo").val("'.$periodo.'");
                $("#hiddenZona").val("'.$zona.'");
                $("#hiddenCead").val("'.$cead.'");
                $("#hiddenEscuela").val("'.$escuela.'");
                $("#fecha_hora_inicio").val("'.$row[2].'T12:00");
                $("#fecha_hora_fin").val("'.$row[2].'T12:00");
              </script>';
    } else {
        echo '<script>
                $("#boton_crear").hide();
              </script>';
    }
} else {
    echo '<script>
            $("#boton_crear").hide();
          </script>';
}

$consulta->destruir();
