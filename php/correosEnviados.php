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
mostrarCabecerasDeTabla($result);
//Listar filas
mostrarDetalles($list,$app,$emailUsuario);//Necesita la instancia de app para poder acceder a la funcion de getCorreoEmailRemitente con la sesion y conexion del usuario actual
//Si la coleccion $List esta vacia
$app->coleccionVacia($list,"Bandeja de Envio vacia.");

App::print_footer();


//---FUNCIONES--//

//$tipoCorreo = $app->getCorreoEmailRemitente($emailUsuario,$remitente);  

/*Funcion que pinta las filas de una tabla en funcion de:
 $list de datos pasada*/
function mostrarDetalles($list,$app,$emailUsuario){
    echo "<tbody class=\"tablalistado\">";

    foreach($list as $fila)
    {    //Rellena la columna tipo de correo con el color del correo correspondiente
        $remitente= $fila['remitente'];
        $tipoCorreo = $app->getCorreoEmailRemitente($emailUsuario,$remitente); 
      
        echo "<tr>";
        echo "<td scope=\"row\"> <a href='detalleCorreo.php?id_correo=".$fila['idCorreo']."'/>".$fila['idCorreo']."</td>".
        "<td scope=\"row\">"."<span id=\"marcacorreo\">".$tipoCorreo."</span>"."</td>".
        "<td scope=\"row\">".$fila['destinatario']."</td>".
        "<td scope=\"row\">".$fila['fecha']."</td>".
        "<td scope=\"row\">".$fila['asunto']."</td>";
        echo "</tr>";    
    }
    echo "</tbody>";
    echo "</table>";
}

function mostrarCabecerasDeTabla($result){
    echo "<table class=\"table table-striped table-dark table-bordered\>";
    echo"<thead>";
    echo "<tr <div class=\"p-3 mb-2 bg-success text-white\">";
    for($i=0;$i<$result->columnCount();$i++)
    {       
       $nombreColumn = $result->getcolumnMeta($i);
       
        if(strcmp($nombreColumn['name'],"remitente")!=0){//Para que no pinte la cabecera para el remitente q, la cual no necesitamos ahora
            echo "<th class=\"cabecolum\">".strtoupper($nombreColumn['name'])."</th>";
        }
        if($i==0)
          echo "<th class=\"cabecolum\">TIPO DE CORREO</th>";
       
    }
}
//-----------------//


?>