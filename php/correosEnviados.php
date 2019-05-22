<?php
include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Correos enviados: ");
//Preguntamos que tipo de usuario es para mostrar un nav u otro
$app->getDao()->tipoUsuario(App::nombreUsuario());

//----------//
//Preguntamos por el email de usuario para filtrar los correos que figura como remitente
$emailUsuario = $app-> getEmailUsuario(App::nombreUsuario());
//Obtenemos todos los correos donde el remetimente es el email del usuario
$result = $app ->getCorresEnviados($emailUsuario);
//Convertimos la coleccion resultante es una lista $list
$list =$result->fetchAll();

//Cabecera
$app->mostrarCabecerasDeTabla($result);
//Listar filas
mostrarDetalles($list);
//Si la coleccion $List esta vacia
$app->coleccionVacia($list,"Bandeja de Envio vacia.");

App::print_footer();


//---FUNCIONES--//

/*Funcion que pinta las filas de una tabla en funcion de:
 $list de datos pasada*/
function mostrarDetalles($list){
    echo "<tbody class=\"tablalistado\">";
    foreach($list as $fila)
    {
        echo "<tr>";
        echo "<td scope=\"row\"> <a href='detalleCorreo.php?id_correo=".$fila['idCorreo']."'/>".$fila['idCorreo']."</td>".
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