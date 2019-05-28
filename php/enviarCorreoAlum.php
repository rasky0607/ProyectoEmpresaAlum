<?php
/*falta por comprobar restricciones o fallos como campos
 que no pueden estar vacios o elevacion de exceiones o errores al insertar*/


 //Mostrar REGISTRO de correos enviados que se puede OCULTAR Si es un Alumno
if(strcmp($tipoUsuario,'alumno')==0)
{
    echo"
    <hr/>
    
     <h3 class=\"text-center\">Registo de correos enviados.</h3>
    <hr/>";

    $result = $app->getCorresEnviados($emailUsuario);
    //Convertimos la coleccion resultante es una lista $list
    $list =$result->fetchAll();

    if(count($list)>0)
    {
    //Cabecera
    $app->mostrarCabecerasDeTabla($result);
        mostrarDetalles($list,$app);
    }
    else
    {
        echo"<br><h6 class=\"text-center\">Aun no enviaste ningun mensaje.</h6>";
    }
}

 function mostrarDetalles($list,$app){
    echo "<tbody class=\"tablalistado\">";

    foreach($list as $fila)
    {    //Rellena la columna tipo de correo con el color del correo correspondiente
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

?>

