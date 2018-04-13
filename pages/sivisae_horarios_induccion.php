<?php
session_start();
include_once '../config/sivisae_class.php';
$consulta = new sivisae_consultas();
?>
<head>
    <?php
    $browser = getenv("HTTP_USER_AGENT");
    if (preg_match("/MSIE/i", "$browser")) {
        //Navegadores no compatibles
        ?>
        <script language="JavaScript" type="text/JavaScript">
            window.location = "sivisae_notifica.php?e=X01";
        </script>

        <?php
    } else {
        //Navegadores compatibles
        // Se valida inicio de sesion

        if (!isset($_SESSION['usuarioid'])) {
            //Debe iniciar sesion
            header("Location: " . RUTA_PPAL . "pages/sivisae_notifica.php?e=X02");
        } else {

            //Se configuran los permisos (crear, editar, eliminar)
            $modulo = $_GET["op"];

            if ($modulo != "") {
                $copy = 0;
                $edit = 0;
                $delete = 0;
                $permisos = $consulta->permisos($modulo, $_SESSION["perfilid"]);
                while ($row = mysql_fetch_array($permisos)) {
                    $copy = $row[0];
                    $edit = $row[1];
                    $delete = $row[2];
                }
            } else {
                $copy = 0;
                $edit = 0;
                $delete = 0;
            }

            //Se configuran imagenes y acceso de los iconos
            if ($copy == 0) {
                $class_copy = "boton_c_bloq";
                $disabled_copy = "disabled";
            } else {
                $class_copy = "boton_c";
                $disabled_copy = "";
            }

            if ($edit == 0) {
                $class_edit = "boton_e_bloq";
                $disabled_edit = "disabled";
            } else {
                $class_edit = "boton_e";
                $disabled_edit = "";
            }
            if ($delete == 0) {
                $class_delete = "boton_el_bloq";
                $disabled_delete = "disabled";
            } else {
                $class_delete = "boton_el";
                $disabled_delete = "";
            }

            $_SESSION['opc_cr'] = "class='$class_copy' $disabled_copy";
            $_SESSION['opc_ed'] = "class='$class_edit' $disabled_edit";
            $_SESSION['opc_el'] = "class='$class_delete' $disabled_delete";
            $_SESSION['opc_ve'] = "class='boton_ver_encuesta'";


            include "../template/sivisae_link_home.php";
            $respuesta = $consulta->perfiles();
            $sedes = $consulta->traerSedes();
            ?>

            <!--contenedor-->
            <link rel="stylesheet" type="text/css" href="template/css/estilo_index.css">
            <link rel="stylesheet" type="text/css" href="js/Chosen1.4/chosen.css">
            <link rel="stylesheet" type="text/css" href="js/Chosen1.4/chosen.min.css">
            <link type="text/css" rel="stylesheet" href="js/qtip/jquery.qtip.css" />
            <script src="js/sweetalert-master/dist/sweetalert-dev.js" type="text/javascript" languaje="javascript"></script>
            <link rel="stylesheet" href="js/sweetalert-master/dist/sweetalert.css">
            <link rel="stylesheet" href="template/popup/style.min.css">
            <script src="js/popup/bpopup.js" type="text/javascript"></script>
            <link rel="stylesheet" type="text/css" href="template/popup/estilo_popup.css">
            <link rel="stylesheet" type="text/css" href="template/grilla/estilo_grilla.css">
            <script src="js/Chosen1.4/chosen.jquery.js" type="text/javascript" language="javascript"></script>
            <script src="js/Chosen1.4/chosen.jquery.min.js" type="text/javascript" language="javascript"></script>
            <script type="text/javascript" src="js/qtip/jquery.qtip.js"></script>
            <script src="js/introLoader/jquery.introLoader.js" type="text/javascript" language="javascript"></script>
            <script src="js/introLoader/spin.min.js" type="text/javascript" language="javascript"></script>




            <script type="text/javascript" language="javascript">

        $(document).ready(function () {
            $(document).on('contextmenu', function (e) {
                swal({
                    title: '¡Cuidado!',
                    text: 'El clic derecho esta deshabilitado en esta página',
                    type: 'error',
                    confirmButtonColor: '#004669',
                    confirmButtonText: 'Aceptar'
                });
                return false;
            });
        });

        function nobackbutton() {
            window.location.hash = "no-back-button";
            window.location.hash = "Again-No-back-button" //chrome
            window.onhashchange = function () {
                window.location.hash = "no-back-button";
            }
        }

        ///validaciones - inicio

        $(document).ready(function () {
            $("#telefono, #celular, #cedula, #telefono_e, #celular_e, #cedula_e").keydown(function (event) {
                if (event.shiftKey)
                {
                    event.preventDefault();
                }

                if (event.keyCode === 46 || event.keyCode === 8) {
                }
                else {
                    if (event.keyCode < 95) {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                    else {
                        if (event.keyCode < 96 || event.keyCode > 105) {
                            event.preventDefault();
                        }
                    }
                }
            });
        });

        ///validaciones - fin

        ///Popup - inicio

        function activarpopupcrear() {
            // Crear
            $('#boton_crear').bind('click', function (e) {
                e.preventDefault();
                var form = document.crear_horario;
                limpiaForm(form);
                $('#result').html('');
                $('#popup_crear').bPopup();
                // $("#perfil, #sede").chosen();
            });
        }

        ///Popup - fin


        ///logica - inicio

        ///Crear
        function submitFormCrear() {
            $('#btn_submit').attr("disabled", true);
            $("#spinner").show();
            var form = document.crear_usuario;
            var dataString = $(form).serialize();
            $.ajax({
                type: 'POST',
                url: 'src/creacion_usuarioCB.php',
                data: dataString,
                success: function (data) {
                    limpiaForm(form);
                    $('#btn_submit').attr("disabled", false);
                    $('#result').html(data);
                    $("#spinner").hide();
                    //Se recarga la grilla
                    listaEstudiantes();
                    setTimeout("CerrarPopup(1)", 1000);
                }
            });
            return false;
        }

        function listaHorarios() {
            if ($('#periodo').val() !== '') {
                var form = document.gestion_auditores;
                var dataString = $(form).serialize();
                $.ajax({
                    type: 'POST',
                    url: 'src/horarios_induccionCB.php',
                    data: dataString,
                    beforeSend: function () {
                        startLoad();
                    },
                    success: function (data) {
                        stopLoad();
                        $('#list_horarios').html(data);
                        var aud = $("#auditor").val();
                        var reg = $("#registros").val();
                        var search = $("#buscar").val();
                        var periodo = $("#periodo").val();
                        var escuela = $("#escuela").val();
                        var programa = $("#programa").val();
                        var zona = $("#zona").val();
                        var cead = $("#cead").val();

                        $("#list_horarios").on("click", ".pagination a", function (e) {
                            e.preventDefault();
                            startLoad();
                            var page = $(this).attr("data-page"); //get page number from link
                            $("#list_horarios").load("src/horarios_induccionCB.php", {
                                "page": page,
                                "auditor": aud,
                                "registros": reg,
                                "buscar": search,
                                "periodo": periodo,
                                "escuela": escuela,
                                "programa": programa
                            },
                            function () { //get content from PHP page 
                                stopLoad();
                            });
                        });
                        $('#popup_crear').remove();
                        $('#add_button').load('pages/sivisae_crud_horario_induccion.php',
                            {periodo:periodo, zona:zona, cead:cead, escuela:escuela, programa:programa});
                    }
                });
                return false;
            } else {
                swal({
                    title: 'Seleccione el Periodo primero',
                    text: '',
                    type: 'error',
                    confirmButtonColor: '#004669',
                    confirmButtonText: 'Aceptar'
                });
                $('#periodo').focus();
                return false;
            }
        }

        function crearReporte() {
            var form = document.gestion_auditores;
            var dataS = $(form).serialize();
            $.ajax({
                type: 'POST',
                url: 'src/horarios_induccion_excel.php',
                data: dataS,
                beforeSend: function () {
                    startLoad();
                },
                success: function (data) {
                    stopLoad();
                    swal({
                        title: '¡Descargue su documento!',
                        text: "<a href='" + data + "' id='pdf' class='botones'>AQUÍ</a>",
                        type: 'success',
                        html: true,
                        confirmButtonColor: '#004669',
                        confirmButtonText: 'Aceptar'
                    });

                }
            });
            return false;
        }

        function startLoad() {
            $('#list_horarios').hide();
            $("#dynElement").introLoader({
                animation: {
                    name: 'simpleLoader',
                    options: {
                        stop: false,
                        fixed: false,
                        exitFx: 'fadeOut',
                        ease: "linear",
                        style: 'light'
                    }
                },
                spinJs: {
                    lines: 13, // The number of lines to draw 
                    length: 20, // The length of each line 
                    width: 10, // The line thickness 
                    radius: 30, // The radius of the inner circle 
                    corners: 1, // Corner roundness (0..1) 
                    color: '#004669', // #rgb or #rrggbb or array of colors 
                }
            });
        }
        function stopLoad() {
            $('#list_horarios').show();
            var loader = $('#dynElement').data('introLoader');
            loader.stop();
        }

        function CerrarPopup(popup) {
            if (popup == 1)
            {
                $('#popup_crear').bPopup().close();
            }
            if (popup == 2)
            {
                $('#popup_editar').bPopup().close();
            }
            if (popup == 3)
            {
                $('#popup_eliminar').bPopup().close();
            }
        }

        function limpiaForm(miForm) {
            // recorremos todos los campos que tiene el formulario
            $(':input', miForm).each(function () {
                var type = this.type;
                var tag = this.tagName.toLowerCase();
                //limpiamos los valores de los campos…
                if (type === 'text' || type === 'password' || tag === 'textarea')
                    this.value = "";
                // excepto de los checkboxes y radios, le quitamos el checked
                // pero su valor no debe ser cambiado
                else if (type === 'checkbox' || type === 'radio')
                    this.checked = false;
                // los selects le ponesmos el indice a -
                else if (tag === 'select')
                {
                    this.selectedIndex = 0;
                    $(this).chosen('destroy');
                    $(this).prop('selectedIndex', 0);
                }
            });
        }

        ///logica - fin

            </script>
            <!--scripts de funcionalidad - fin-->

        </head>

        <body onload="nobackbutton();
              ">
            <!--Encabezado - Inicio-->
            <?php include "../template/sivisae_head_home.php"; ?>
            <!--Encabezado - Fin-->
            <!--Menu - Inicio-->
            <?php include "sivisae_menu.php"; ?>
            <!--Menu - Fin-->
            <main>

                <div >

                    <!--Barra de estado inicio-->
                    <?php include "sivisae_barra_estado.php"; ?>
                    <!--Barra de estado fin-->
                    <!--opciones inicio-->
                    <!--opciones fin-->


                    <!--listado de usuarios inicio-->

                    <div align="center" style="background-color: #004669">
                        <h2 id='p_fieldset_autenticacion_2'>
                            HORARIOS DE INDUCCIÓN
                        </h2>
                    </div>
                    <div class="art-postcontent">
                        <div id="dynElement" >
                        </div>
                        <div align="center">
                            <form id="gestion_auditores" name="gestion_auditores">
                                <br>
                                <?php
                                include "sivisae_filtro.php";
                                ?>
                                <div id="list_horarios">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="add_button"></div>
                </div>

            </main>

            <?php
            //Pie de pagina
            include "../template/sivisae_footer_home.php";
            ?>
        </body>
        <?php
    }
}
$consulta->destruir();
?>
