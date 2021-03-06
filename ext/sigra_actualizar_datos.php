<?php
/*
 * 
 *   @author Andres C Mendez A
 * 
 */

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
        include "../template/sivisae_link_home.php";
        $respuesta = $consulta->perfiles();
        $sedes = $consulta->traerSedes();
        $sintilde = explode(',', SIN_TILDES);
        $tildes = explode(',', TILDES);
        ?>

        <!--contenedor-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="template/css/estilo_index.css">
        <script src="js/popup/bpopup.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="template/popup/estilo_popup.css">
        <link rel="stylesheet" type="text/css" href="js/Chosen1.4/chosen.css">
        <link rel="stylesheet" type="text/css" href="js/Chosen1.4/chosen.min.css">
        <script src="js/sweetalert2-master/dist/sweetalert2.min.js" type="text/javascript" languaje="javascript"></script>
        <link rel="stylesheet" href="js/sweetalert2-master/dist/sweetalert2.css">
        <script src="js/Chosen1.4/chosen.jquery.js" type="text/javascript" language="javascript"></script>
        <script src="js/Chosen1.4/chosen.jquery.min.js" type="text/javascript" language="javascript"></script>
        <link rel="stylesheet" href="js/Steps/css/normalize.css">
        <link rel="stylesheet" href="js/Steps/css/main.css">
        <link rel="stylesheet" href="js/Steps/css/jquery.steps.css">
        <script src="js/Steps/jquery.steps.js"></script>
        <link href="js/iCheck/polaris/polaris.css" rel="stylesheet">
        <script src="js/iCheck/icheck.js"></script>
        <script src="js/sigra/region_calendario.js"></script>
        <script src="js/sigra/enviar-actualizacion.js"></script>

       

        <!--scripts de funcionalidad - inicio-->
        <script >

            ///Seguridad - Inicio
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
            ///Seguridad - Fin

            ///validaciones - inicio

            $(document).ready(function () {
                $("#hora").keydown(function (event) {
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
            (function ($) {
                $(function () {
                    // Crear
                    $('#boton_crear').bind('click', function (e) {
                        e.preventDefault();
                        var form = document.form_crear;
                        limpiaForm(form);
                        $('#result').html('');
                        $('#popup_crear').bPopup();
                        $("#perfil, #sede").chosen();
                    });
                });

            })(jQuery);

            function submitFormEditar() {
                $('#btn_submit_e').attr("disabled", true);
                $("#spinner_e").show();
                var form = document.form_editar;
                var dataString = $(form).serialize();
                $.ajax({
                    type: 'POST',
                    url: 'src/actualiza_eventoCB.php',
                    data: dataString,
                    success: function (data) {
                        limpiaForm(form);
                        $('#btn_submit_e').attr("disabled", false);
                        $('#result_e').html(data);
                        $("#spinner_e").hide();
                        //Se recarga la grilla
                        listaGrilla();
                        setTimeout("CerrarPopup(2)", 1000);
                    }
                });
                return false;
            }

            ///Eliminar


            function limpiaForm(miForm) {
                // recorremos todos los campos que tiene el formulario
                $(':input', miForm).each(function () {
                    var type = this.type;
                    var tag = this.tagName.toLowerCase();
                    //limpiamos los valores de los campos…
                    if (type === 'text' || type === 'password' || tag === 'textarea' || tag === 'number')
                        this.value = "";
                    // excepto de los checkboxes y radios, le quitamos el checked
                    // pero su valor no debe ser cambiado
                    else if (type === 'checkbox' || type === 'radio')
                        this.checked = false;
                    // los selects le ponesmos el indice a -
                    else if (tag === 'select')
                        this.selectedIndex = 0;
                });
            }
            ///logica - fin

            $(function () {
                function log(message) {
                    //                      $( "<div>" ).text( message ).prependTo( "#log" );
                    //                      $( "#log" ).scrollTop( 0 );
                }

            });

        </script>
        <!--scripts de funcionalidad - fin-->
        <!--inicio calendario firefox-->



        <style>

            .tc  {border-spacing:0; }
            .tc td{font-family:Tahoma;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
            .tc th{font-family:Tahoma;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
            .tc .tcar-qa4j{font-family:Tahoma ;background-color:#004669;color:#ffffff;text-align:center}
            .tc .tcar-xitf{font-family:Tahoma ;color:#000000;text-align:center}
            .tc .tcar-qa4j2{font-family:Tahoma ;background-color:#E26C0E;color:#FFFFFF;text-align:center; font-weight: bold; font-size: 21px;}
            .tc .tcar-xitf2{font-family:Tahoma ;color:#004669;text-align:center; font-weight: bold;}
            .bo {border-style:solid; border-width:2px;border-top-width:2px;border-bottom-width:2px;border-left-width: 2px;border-right-width: 2px; border-color: #004669}
            .falta {border-color: #FF0000;}                 
        </style>


        <!--fin calendario firefox-->

    </head>

    <body onload="nobackbutton();">
        <!--Encabezado - Inicio-->
        <?php include "../template/sivisae_head_home.php"; ?>
        <!--Encabezado - Fin-->
        <!--Menu - Inicio-->
        <div id="cssmenu" class="align-center">
            <ul>
                <li class='has-sub' ><a target="_blank" href='https://estudios.unad.edu.co/'><span>Matrículas</span></a></li>
                <li class='has-sub' ><a target="_blank" href='https://academia.unad.edu.co/estudiantes-servicios'><span>Estudiantes</span></a></li>
                <li class='has-sub' ><a target="_blank" href='https://egresados.unad.edu.co'><span>Egresados</span></a></li>
                <li class='has-sub' ><a target="_blank" href='https://informacion.unad.edu.co/cuerpo-academico'><span>Cuerpo académico</span></a></li>
                <li class='has-sub' ><a target="_blank" href='https://informacion.unad.edu.co/servidores-publicos'><span>Servidores Públicos</span></a></li>

            </ul>
        </div>
        <!--Menu - Fin-->
        <main>

            <div>

                <!--Barra de estado inicio-->

                <!--Barra de estado fin-->

                <div align="center" style="background-color: #004669">
                    <h2 id='p_fieldset_autenticacion_2'>
                        ACTUALIZACIÓN DE DATOS
                    </h2>
                </div>
                <br/>
                <div align="center">
                    <table style="width: 60%;">
                        <colgroup>
                            <col style="width: 50%"/>
                            <col style="width: 50%"/>
                        </colgroup>
                        <tr>                                
                            <td colspan="2" align="center"><label>No. Documento *</label><br/><input size="44" type="text" name="documento_b" maxlength="20" id="documento_b"/></td>
                        </tr>
                        <tr>                                
                            <td colspan="2" align="center"><label>Codigo Verificación *</label><br/>
                                <input size="40" title="Diligenciae" type="text" name="cverficacion_b" maxlength="50" id="cverficacion_b"/>
                                <img src="template/imagenes/generales/informacion.png" width="20" height="20" title="Ingrese en este campo el codigo de verificación que recibio via correo. Sí NO ha recibido un codigo de verificación por favor escribanos al correo: graduados@unad.edu.co junto con su numero de documento y datos personales." />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><input type="button" class="botones" name="buscar" id="buscar" value="Buscar" onclick="frm();"/></td>
                        <input type="hidden" id="graduado_id" value="" name="graduado_id"/>
                        <input type="hidden" id="interno" value="no" name="interno"/>
                        </tr>

                    </table>
                </div>
                <br/>
                <div align="center" id="frm_actualizacion">
                </div> 
                <br/>
                <div align="center" style="background-color: #004669">
                    <h2 id='p_fieldset_autenticacion_2'>
                        &nbsp;
                    </h2>
                </div>
            </div>

        </main>

        <?php
        //Pie de pagina
        include "../template/sivisae_footer_home.php";
        ?>
    </body>
    <?php
}
$consulta->destruir();
?>
