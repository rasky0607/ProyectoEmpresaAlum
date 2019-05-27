<?php

include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Inicio");
//Preguntamos por el email de usuario para filtrar los correos que figura como remitente
$emailUsuario = $app-> getEmailUsuario(App::nombreUsuario());
//Preguntamos que tipo de usuario es para mostrar un nav u otro
$app->getDao()->tipoUsuario(App::nombreUsuario());


?>
<div class="container">
    <div class="row">
    <!--col-md- lo que ocupa los componentes de la pagina -->
    <!--offset-md- numero de columnas que debe dejar en los marjenes -->
        <div class="col-12 col-md-4 offset-md-4">            
            <form method="POST" action="buscarAlumno.php">
            <div class="col-4 col-md-0 offset-md-4">
                <br/> 
                <img src="../img/buscarEmail.png" width="100" height="100"/>
            </div>                             
                <div class="from-group">
                    <label for="email">Email:</label>
                    <input id="email" name="email" type="email" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>            
                <hr/>               
                <div class="text-center">
                    <a href="buscarAlumno.php" class="btn btn-primary">Volver</a>
                    <input type="submit" value="Buscar" class="btn btn-primary">
                    <input type="submit" value="Mostrar todos" name="todos" class="btn btn-primary">                                   
                </div>
                
            </form>
        </div>
    </div>
</div>
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
        listarFilasDeLaTabla($list);
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
        listarFilasDeLaTabla($list);
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



function listarFilasDeLaTabla($list){
    echo "<tbody class=\"tablalistado\">";
    //Datos
    foreach($list as $fila)
    {
      //Rellena la columna tipo de correo con el color del correo correspondiente     
        echo "<tr>";
        
        echo "<td scope=\"row\">".$fila['usuario']."</td>".
        "<td scope=\"row\"><a href='enviarCorreo.php?email=".$fila['email']."'>".$fila['email']."<img src=\"../img/enviarMensaje.png\"  width=\"27\" height=\"27\"/></a>"."</td>";
        echo "</tr>";
    }
}
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
?>