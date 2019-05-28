//VIEJO FICHERO BUSCAR ALUMNO
<?php

include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Buscar alumno");
//Preguntamos por el email de usuario para filtrar los correos que figura como remitente
$emailUsuario = $app-> getEmailUsuario(App::nombreUsuario());
//Preguntamos que tipo de usuario es para mostrar un nav u otro
$app->getDao()->tipoUsuario(App::nombreUsuario());


?>

<?php
$emailAbuscar=$_POST['email'];//Siempre se rocoge el post por el name y no por el id
$todos=$_POST['todos'];//Si esta variable se llena pasara al else if el cual mostrara todos los correos existentes.

$app2 = new App();
if(!empty($emailAbuscar))//Mostrara solo los correos filtrados
{
    $result = $app2->buscarEmail($emailAbuscar);

    $list= $result->fetchAll();
    if(count($list)==0)
    {
        echo"<br><h6 class=\"text-center\">No se encontro ningun usuario con ese correo.</h6>";
    }
    else{
        mostrarCabecerasDeTabla($result);
        listarFilasDeLaTabla($list,$emailUsuario);
    }
}
else if(strcmp($todos,'Mostrar todos')==0)//Mostrara todos los correos
{
    $result = $app2->buscarEmail($emailAbuscar);

    $list= $result->fetchAll();
    if(count($list)==0)
    {
        echo"<br><h6 class=\"text-center\">No se encontro ningun usuario con ese correo.</h6>";
    }
    else{
        mostrarCabecerasDeTabla($result);
        listarFilasDeLaTabla($list,$emailUsuario);
    }
}
//Funciones
function mostrarCabecerasDeTabla($result){
    echo "<div class=\"container\">";
    echo "<div class=\"col-12 col-md-6 offset-md-3\">";
    echo "<hr/> <br>";
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



function listarFilasDeLaTabla($list,$emailUsuario){
    echo "<tbody class=\"tablalistado\">";
    //Datos
    foreach($list as $fila)
    {
      //Rellena la columna tipo de correo con el color del correo correspondiente     
        echo "<tr>";
        if($emailUsuario!=$fila['email'])//Nos aseguramos de que el usuario actual no pueda enviarse un correo a si mismo
        {
            echo "<td scope=\"row\">".$fila['usuario']."</td>".
            "<td scope=\"row\"><a href='enviarCorreo.php?email=".$fila['email']."'>".$fila['email']."<img src=\"../img/enviarMensaje.png\"  width=\"27\" height=\"27\"/></a>"."</td>";
        }
        echo "</tr>";
    }
}
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
?>