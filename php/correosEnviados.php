<?php
include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Correos enviados: ");
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
//----------//
//Preguntamos por el email de usuario para filtrar los correos que figura como remitente
$emailUsuario = $app-> getEmailUsuario(App::nombreUsuario());
$result = $app ->getCorresEnviados($emailUsuario);
$list =$result->fetchAll();

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

App::print_footer();

?>