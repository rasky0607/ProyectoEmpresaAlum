<?php
include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Inicio Alumno");

App::print_nav_alumno(App::nombreUsuario());
echo "Soy un alumno!";
App::print_footer();

?>