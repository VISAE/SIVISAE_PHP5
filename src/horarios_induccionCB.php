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
					</tr>
				</thead>
                        <tbody>
                    ";
    while ($row = mysql_fetch_array($inducciones)) {

        echo "<tr>"
        . "<td>$row[0]</td>"
        . "<td>$row[1]</td>"
        . "<td>$row[2]</td>"
        . "<td>$row[3]</td>"
        . "<td>$row[4]</td>"
        . "<td>$row[5]</td>"
        . "<td>$row[6]</td>"
        . "<td>$row[7]</td>"
        . "<td>$row[8]</td>"
        . "<td>$row[9]</td>"
        . "<td>$row[11]</td>"
        . "<td>$row[11]</td>";
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
$consulta->destruir();
