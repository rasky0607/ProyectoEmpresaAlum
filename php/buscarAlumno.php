<?php

include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Buscar alumno");
//Preguntamos por el email de usuario para filtrar los correos que figura como remitente
$emailUsuario = $app-> getEmailUsuario(App::nombreUsuario());
//Preguntamos que tipo de usuario es para mostrar un nav u otro
$app->getDao()->tipoUsuario(App::nombreUsuario());//Coloca un nav u otro segun el tipo de usuario
$tipoUsuario= $app->tipoUsuario2(App::nombreUsuario());//devuelve el tipo exacto de usuario

    echo"
    <div class=\"container\">
    <div class=\"row\">
    <!--col-md- lo que ocupa los componentes de la pagina -->
    <!--offset-md- numero de columnas que debe dejar en los marjenes -->
        <div class=\"col-12 col-md-4 offset-md-4\">            
            <form method=\"POST\" action=\"buscarAlumno.php\">
            <div class=\"col-4 col-md-0 offset-md-4\">
                <br/> 
                <img src=\"../img/buscarEmail.png\" width=\"100\" height=\"100\"/>
            </div>                             
                <div class=\"from-group\">
                    <label for=\"apellidos\">Apellidos:</label>
                    <input id=\"apellidos\" name=\"apellidos\" type=\"text\" autofocus=\"autofocus\" requiered=\"requiered\" class=\"form-control\">
                </div>    
                <div class=\"from-group\">
                <label for=\"anioPromocion\">Año de promocion:</label>
                <input id=\"anioPromocion\" name=\"anioPromocion\" type=\"number\" autofocus=\"autofocus\" requiered=\"requiered\" class=\"form-control\">
            </div>         
                <hr/>               
                <div class=\"text-center\">
                    <a href=\"buscarAlumno.php\" class=\"btn btn-primary\">Volver</a>
                    <input type=\"submit\" name=\"buscar\" value=\"Buscar\" class=\"btn btn-primary\">
                    <input type=\"submit\" value=\"Mostrar todos\" name=\"todos\" class=\"btn btn-primary\">                                   
                </div>
                
            </form>
        </div>
    </div>
</div>";

    if(!isset($_POST['buscar'])&& isset($_POST['todos']))//Muestra todos
    {
        $apellidos=$_POST['apellidos'];
        $anioPromocion=$_POST['anioPromocion'];
       //Consulta de el dao
       $result=$app->listarAlumnosParaEmp($apellidos,$anioPromocion);
       $list=$result->fetchAll(); 
       mostrarCabecerasDeTablaEmp($result);
       listarFilasDeLaTablaEmp($list);    
    }
    else if(isset($_POST['buscar'])&& !isset($_POST['todos']))//Muestra solo el filtrado
    {
        $apellidos=$_POST['apellidos'];
        $anioPromocion=$_POST['anioPromocion'];
       //Consulta de el dao
       $result=$app->listarAlumnosParaEmp($apellidos,$anioPromocion);
       $list=$result->fetchAll(); 
       if(count($list)>0)
       {     
        mostrarCabecerasDeTablaEmp($result);
        listarFilasDeLaTablaEmp($list);
       }else
       {
           echo"<br><h5 class=\"text-center\">Nadie coincide con esos parametros.</h5>";
       }

    }
    
    


  //Funciones


function mostrarCabecerasDeTablaEmp($result){
    echo"<br><hr/>";
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

function listarFilasDeLaTablaEmp($list){
    echo "<tbody class=\"tablalistado\">";
    //Datos
    foreach($list as $fila)
    {   
        echo "<tr>";
    
        echo "<td scope=\"row\">".$fila['usuarioAlum']."</td>".
            "<td scope=\"row\">".$fila['nombre']."</td>".
            "<td scope=\"row\">".$fila['apellidos']."</td>".
            "<td scope=\"row\">".$fila['anioPromocion']."</td>".
            "<td scope=\"row\"><a href='empresaEnviaCorreo.php?email=".$fila['email']."'>".$fila['email']."<img src=\"../img/enviarMensaje.png\"  width=\"27\" height=\"27\"/></a>"."</td>";
            
        
        echo "</tr>";

    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    
}

  


?>