<?php
session_start();
include_once '../config/sivisae_class.php';
$_SESSION['usuarioid'] = '999';
$_SESSION['perfilid'] = '19';
header("Location: " . RUTA_PPAL . "pages/sivisae_agendamiento_induccion.php?op=39#no-back-button");