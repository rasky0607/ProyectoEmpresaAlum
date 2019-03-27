<?php
/*
Esto muestra la pantalla de inicio de un alumno que se ha logeado
 y el registro de mensajes enviados y recibidos
 */
include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Inicio Alumno");

App::print_nav(App::nombreUsuario());
echo "Soy un alumno!";
App::print_footer();

?>