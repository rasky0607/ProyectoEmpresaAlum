<?php
include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Detalle de correo: ");
//Preguntamos que tipo de usuario es para mostrar un nav u otro
$tipoUsuario = $app->getDao()->tipoUsuario(App::nombreUsuario());
if(strcmp($tipoUsuario,"alumno")==0)
{
    App::print_nav_Alum(App::nombreUsuario());
}
else
{
    App::print_nav_Empe(App::nombreUsuario());
}
//------------//
//Recogemos el id del correo selecionado:
$idCorreo = $_GET['id_correo'];
$resul = $app ->getDetalleDeUnCorreoRecibido($idCorreo);
$list = $resul->fetchAll();

//Datos
foreach($list as $fila)
{ 
    echo "<br/><div class=\"text-center\">";
    echo"<h3>Remitente:</br></h3>".$fila['remitente'].
    "<h3>Destinatario:</br></h3>".$fila['destinatario'].
    "<h3>Fecha:</br></h3>".$fila['fecha'].
    "<h3>Asunto:</br></h3>".$fila['asunto'].
    "<h3>Contenido:</br></h3>".$fila['contenido'];
    echo"</div>"; 
    
}

?>