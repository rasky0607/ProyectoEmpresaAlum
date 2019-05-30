<?php
/*---------------------------
Limpiar errores inecesario
(solucion cutre a ciertas excepciones poco o nada relevantes para el funcionamiento)*/
//error_reporting(E_ALL);
//ini_set('display_errors', '0');
/**----------------------------------- */
//Un alumno contacta con uno o varios exalumnos
     include_once("app.php");
     
     $app = new App();
     $app -> validateSession();
     App::print_head("Contactar con alumnos");
     //Preguntamos por el email de usuario para filtrar los correos que figura como remitente
     $emailUsuario = $app-> getEmailUsuario(App::nombreUsuario());
     //Preguntamos que tipo de usuario es para mostrar un nav u otro
     $app->getDao()->tipoUsuario(App::nombreUsuario());//Coloca un nav u otro segun el tipo de usuario

     $result=$app->listarAlumnos(App::nombreUsuario());
     $list=$result->fetchAll();
    //Preparamos la lista de alumnos
     mostrarCabecerasDeTablaAlum($result);
     
     listarFilasDeLaTablaAlum($list);
     $arrayemails=array();
  
     /*IMPORTANTE:
     Evitamos la lectura de datos al cargar la pagina por culpa del summit
      que se ejecuta en la primera carga de la pagina*/
     if(isset($_POST['email'])) //recogemos correos marcados
     {
        $arrayemails=$_POST['email'];
     }
     //print_r($arrayemails);
 

     /*IMPORTANTE:
     Evitamos la lectura de datos al cargar la pagina por culpa del summit
      que se ejecuta en la primera carga de la pagina*/
  if(isset($_POST['asunto'])){   
    $asunto=$_POST['asunto'];
    $contenido=$_POST['contenido'];
  }
//Realizamos inserciones
if(isset($_POST['envio'])&& count($arrayemails)==0)
{
    echo"<h6 class=\"text-center\">Debes seleccionar uno o mas correos de destino.</h6>";
}
else
{
    if(!empty($contenido) && !empty($asunto))
    {
        $contadorCorrecto=0;
        for($i=0;$i<count($arrayemails);$i++)
        {
            
            if($app->insercionMensaje($emailUsuario,$arrayemails[$i],$asunto,$contenido))
            {
                var_dump($contadorCorrecto++);
            }           
        }
        if($contadorCorrecto == count($arrayemails))
        {
            echo"";
            echo "<script type=\"text/javascript\"> alert('¡Su correo ha sido enviado con exito!.');
            </script>";
                //redireccion a Inicio.php
            echo "<script languaje=\"javascript\">window.location.href=\"inicio.php\"</script>";
        }
        else{
            echo"";
            echo "<script type=\"text/javascript\"> alert('¡Ops!,Lo sentimos =( pero ocurrio un error al enviar su correo, pruebe de nuevo mas tarde.');
            </script>";
                //redireccion a Inicio.php
            echo "<script languaje=\"javascript\">window.location.href=\"ContactoAlumnos.php\"</script>";
        }
    
    }else if(empty($contenido) && empty($asunto) && count($arrayemails)>0){       
        echo"<h6 class=\"text-center\">*Recuerda el contenido y el asunto no pueden estar vacios.</h6>";
        
    }
}

//FUNCIONES
//En esta funcion pintamos absolutamente todo el el entorno excepto la  barra del nav
//Todo en un solo form para no perder los emailss
function listarFilasDeLaTablaAlum($list){
    echo "<tbody class=\"tablalistado\">";
    echo" <form method=\"POST\" action=\"ContactoAlumnos.php\">";
    //Datos
    foreach($list as $fila)
    {   
       
        echo "<tr>";
    
        echo "<td scope=\"row\">"."<input name='email[]' value=".$fila['email']." type=\"checkbox\"><img src=\"../img/enviarMensaje.png\"  width=\"27\" height=\"27\"/>".$fila['email']."</td>".
            "<td scope=\"row\">".$fila['usuarioAlum']."</td>".
            "<td scope=\"row\">".$fila['nombre']."</td>".
            "<td scope=\"row\">".$fila['apellidos']."</td>".
            "<td scope=\"row\">".$fila['anioPromocion']."</td>";
            
        
        echo "</tr>";
      
    }
   echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo"<div class=\"text-center\">
    
    </div>";
    echo "
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-12 col-md-4 offset-md-4\">            
               
                <div class=\"col-4 col-md-0 offset-md-4\">
                    <br/> 
                    <img src=\"../img/escribirCorreo.png\" width=\"50\" height=\"50\"/>
                </div>               
                    <div class=\"from-group\">
                        <label for=\"asunto\">Asunto:</label>
                        <input id=\"asunto\" name=\"asunto\" type=\"text\" autofocus=\"autofocus\" requiered=\"requiered\" class=\"form-control\">
                    </div>
                    <div class=\"from-group\">
                        <label for=\"texto\">Contenido:</label>
                        <textarea rows=\"4\" cols=\"50\" id=\"contenido\" name=\"contenido\" type=\"text\" autofocus=\"autofocus\" requiered=\"requiered\" class=\"form-control\"></textarea>
                    </div>
                    <br/>          
                    <hr/>               
                    <div class=\"text-center\">
                        <a href=\"inicio.php\" class=\"btn btn-primary\">Volver</a>
                        <input type=\"submit\" value=\"Enviar\" name=\"envio\" class=\"btn btn-primary\"> 
                                                       
                    </div>
                    
       
            </div>
        </div>
    </div>
    <br> 
    ";
   

    echo"</form> ";


    
}
  
function mostrarCabecerasDeTablaAlum($result){
  
    echo "<br><hr/>";
    echo "<h3 class=\"text-center\">Listado de alumnos y Exalumnos</h3>";
    echo "<hr/>";
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
?>