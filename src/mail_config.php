<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/phpmailer/src/SMTP.php';

class mail_config extends PHPMailer {

    private $mail;

    function __construct() {
        $this->mail = new PHPMailer();
        $this->mail->IsSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $this->mail->SMTPDebug = 2;
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->Port = 587;//465;
        $this->mail->SMTPSecure = "tls";//"ssl";
        $this->mail->SMTPAuth = true;
        $this->mail->Username = "auditores.servicios@unad.edu.co";
        $this->mail->Password = "SONIA122";
        $this->mail->CharSet = "UTF-8";
        //Set who the message is to be sent from
        $this->mail->setFrom('no-reply@unad.edu.co',  utf8_decode('Sistema de Información del Estudiante - SIVISAE - VISAE'));
    }

    function enviarPass($asunto, $usuario, $password, $correo, $nombre) {
        $this->mail->Subject = $asunto;
        //$mail->AltBody = "Hola, esto es un correo de prueba de la VISAE.";
        $this->mail->MsgHTML(""
                . "<table>"
                . "<tr>"
                . "     <td colspan='2' ><b>Usuario y contraseña para ingresar al SIVISAE.<br></b>"
                . "         Escribir contraseña con los simbolos y puntos<br><br><br></td>"
                . "</tr>"
                . "<tr>"
                . "     <td style='alignment-adjust: middle'> Usuario:</td>"
                . "     <td><b>" . $usuario . "</b></td>"
                . "</tr>"
                . "<tr>"
                . "     <td style='alignment-adjust: middle'> Contraseña:</td>"
                . "     <td><b>" . $password . "</b></td>"
                . "</tr>"
                . "</table>"
                . "<br><br><br>"
                . "Puede ingresar a la aplicación desde <a href='" . RUTA_PPAL . "'>aquí</a><br>");
        //$mail->AddAttachment("files/img03.jpg");
        $this->mail->AddAddress($correo, $nombre);
        $this->mail->IsHTML(true);

        if (!$this->mail->send()) {
            echo $this->mail->ErrorInfo;
            return "0";
        } else {
            return "1";
        }
    }

}
?>
