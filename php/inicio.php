<?php
/*
Esto muestra la pantalla de inicio de un alumno que se ha logeado
 y el registro de mensajes enviados y recibidos
 */ 
include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Inicio");
//Preguntamos por el email de usuario para filtrar los correos que figura como remitente
$emailUsuario = $app-> getEmailUsuario(App::nombreUsuario());
//Preguntamos que tipo de usuario es para mostrar un nav u otro
$app->getDao()->tipoUsuario(App::nombreUsuario());

//Obtenemos todos los correos ENviado/recibidos del usuario
$result = $app->getcorreosEnviadosRecibidos(App::nombreUsuario());
//Convertimos la coleccion $result en una coleccin de tipo lista
$list = $result->fetchAll();

//Cabecera
$app->mostrarCabecerasDeTabla($result);

//Filas
listarFilasDeLaTabla($list,$emailUsuario,$app);

//Si la lista $list esta vacia
$app->coleccionVacia($list,"Bandeja de Entrada vacia.");

App::print_footer();

//---FUNCIONES--//

/*Funcion que pinta las filas de una tabla en funcion de:
 $list de datos pasada,el objeto $app en esta sesion y el correo del usuario de esta sesion $emailUsuario*/
function listarFilasDeLaTabla($list,$emailUsuario,$app){
    echo "<tbody class=\"tablalistado\">";
    //Datos
    foreach($list as $fila)
    {
      //Rellena la columna tipo de correo con el color del correo correspondiente
        $remitente=$fila['remitente'];  
        $tipoCorreo = $app->getCorreoEmailRemitente($emailUsuario,$remitente);     
        echo "<tr>";
        echo "<td scope=\"row\"> <a href='detalleCorreo.php?id_correo=".$fila['idCorreo']."'/>".$fila['idCorreo']."</td>".
        "<td scope=\"row\">"."<span id=\"marcacorreo\">".$tipoCorreo."</span>"."</td>".
        "<td scope=\"row\">".$fila['remitente']."</td>".
        "<td scope=\"row\">".$fila['destinatario']."</td>".
        "<td scope=\"row\">".$fila['fecha']."</td>".
        "<td scope=\"row\">".$fila['asunto']."</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}

//-----------------//

?>