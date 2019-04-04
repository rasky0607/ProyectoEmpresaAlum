<?php
include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Detalle de correo: ");
//Preguntamos que tipo de usuario es para mostrar un nav u otro
 $app->getDao()->tipoUsuario(App::nombreUsuario());

//Recogemos el id del correo selecionado:
$idCorreo = $_GET['id_correo'];
//Optenemos los campos del correo en funcion de su ID
$resul = $app ->getDetalleDeUnCorreoRecibido($idCorreo);
//Convertimos la colecion $result en una lista $list
$list = $resul->fetchAll();
//Datos
mostrarDetalles($list);
App::print_footer();

//---FUNCIONES--//

//Funcion que lista los detalles en el centro de la pantalla
function mostrarDetalles($list){
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
}

//-----------------//

?>