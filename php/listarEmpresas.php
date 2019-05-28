<?php
include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Inicio");
//Preguntamos por el email de usuario para filtrar los correos que figura como remitente
$emailUsuario = $app-> getEmailUsuario(App::nombreUsuario());
//Preguntamos que tipo de usuario es para mostrar un nav u otro
$app->getDao()->tipoUsuario(App::nombreUsuario());
$result=$app->listarEmpresas();
$list=$result->fetchAll();
mostrarCabecerasDeTabla($result);
listarFilasDeLaTabla($list);

function mostrarCabecerasDeTabla($result){
    echo "<table class=\"table table-striped table-dark table-bordered\>";
    echo"<thead>";
    echo "<tr <div class=\"p-3 mb-2 bg-success text-white\">";
    for($i=0;$i<$result->columnCount();$i++)
    {       
       $nombreColumn = $result->getcolumnMeta($i);
     
        echo "<th class=\"cabecolum\">".strtoupper($nombreColumn['name'])."</th>";       
       
    }
    echo "</tr>";
    echo "</thead>";
  }

  function listarFilasDeLaTabla($list){
    echo "<tbody class=\"tablalistado\">";
    //Datos
    foreach($list as $fila)
    {
      //Rellena la columna tipo de correo con el color del correo correspondiente
        echo "<tr>";
        echo 
        "<td scope=\"row\">".$fila['nombre']."</td>".
        "<td scope=\"row\">".$fila['direccion']."</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}

?>