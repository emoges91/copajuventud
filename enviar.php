<?php

if (((isset($_POST['nombre'])and $_POST['nombre'] != '')) and ((isset($_POST['mail'])and $_POST['mail'] != '')) and ((isset($_POST['DC'])and $_POST['DC'] != '')))
{
	$nombre = $_POST['nombre'];
	$mail = $_POST['mail'];
	$empresa = $_POST['empresa'];
	$para = $_POST['correodes'];

	$header = 'From: ' . $mail . " \r\n";
	$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
	$header .= "Mime-Version: 1.0 \r\n";
	$header .= "Content-Type: text/plain";

	$mensaje = "Este mensaje fue enviado por " . $nombre . ", de la empresa " . $empresa . " \r\n";
	$mensaje .= "Su e-mail es: " . $mail . " \r\n";
	$mensaje .= "Mensaje: " . $_POST['DC'] . " \r\n";
	$mensaje .= "Enviado el dia " . date('d/m/Y', time());
	$mensaje .= " a las ". date ( "H:i:s");

	$asunto = 'Contacto desde Coparotativapz.org';

	mail($para, $asunto, utf8_decode($mensaje), $header);

	echo "<script type=\"text/javascript\">alert('Correo enviado correctamente');document.location.href='http://www.coparotativapz.org';</script>";
}
else
{
	echo "<script type=\"text/javascript\">alert('Los campos con asterisco (*) son requeridos');history.go(-1);</script>";	
}
?>