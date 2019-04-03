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
$tipoUsuario = $app->getDao()->tipoUsuario(App::nombreUsuario());

if(strcmp($tipoUsuario,"alumno")==0)
{
    App::print_nav_Alum(App::nombreUsuario());
}
else
{
    App::print_nav_Empe(App::nombreUsuario());//Pinta el nombre del usuario del que se guardo la sesion
    
}
//---------//

$result = $app->getcorreosEnviadosRecibidos(App::nombreUsuario());

$list = $result->fetchAll();

//print_r($list);
echo "<table border=\"1\" class=\"table table-striped table-dark table-bordered\>";
echo"<thead>";
echo "<tr <div class=\"p-3 mb-2 bg-success text-white\">";
//Cabecera
for($i=0;$i<$result->columnCount();$i++)
{
    $nombreColumn = $result->getcolumnMeta($i);
    echo "<th>".strtoupper($nombreColumn['name'])."</th>";
}
echo "</tr>";
echo "</thead>";
echo "<tbody>";
//Datos
foreach($list as $fila)
{
     $remitente=$fila['remitente'];  
     $tipoCorreo = $app->getCorreoEmailRemitente($emailUsuario,$remitente);
    echo "<tr>";
    echo "<td scope=\"row\"> <a href='detalleCorreo.php?id_correo=".$fila['idCorreo']."'/>".$fila['idCorreo']."</td>".
    "<td scope=\"row\">".$tipoCorreo.$fila['remitente']."</td>".
    "<td scope=\"row\">".$fila['destinatario']."</td>".
    "<td scope=\"row\">".$fila['fecha']."</td>".
    "<td scope=\"row\">".$fila['asunto']."</td>";
    echo "</tr>";
    

}

echo "</tbody>";
echo "</table>";
if(empty($list)){
    echo "<h3 class=\"text-center\"> Bandeja de Entrada vacia.</h3>";
    }
App::print_footer();

?>