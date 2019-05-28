<?php
include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Redactar correo");
//Preguntamos por el email de usuario para filtrar los correos que figura como remitente
$emailUsuario = $app-> getEmailUsuario(App::nombreUsuario());
//Preguntamos que tipo de usuario es para mostrar un nav u otro
$app->getDao()->tipoUsuario(App::nombreUsuario());
$tipoUsuario=$app->tipoUsuario2(App::nombreUsuario());

$emailDestino=$_GET['email'];

//Formulario

echo "
<div class=\"container\">
    <div class=\"row\">
        <div class=\"col-12 col-md-4 offset-md-4\">            
            <form method=\"POST\" action=\"empresaEnviaCorreo.php\">
            <div class=\"col-4 col-md-0 offset-md-4\">
                <br/> 
                <img src=\"../img/escribirCorreo.png\" width=\"50\" height=\"50\"/>
            </div>               
                <div class=\"from-group\">
                    <label for=\"emailDestino\">Dirigido a:</label>
                    <input id=\"emailDestino\" name=\"emailDestino\" type=\"email\" value=\"$emailDestino\" autofocus=\"autofocus\" requiered=\"requiered\" class=\"form-control\" readonly=\"readonly\">
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
                    <a href=\"buscarAlumno.php\" class=\"btn btn-primary\">Volver</a>
                    <input type=\"submit\" value=\"Enviar\" name=\"envio\" class=\"btn btn-primary\"> 
                                                   
                </div>
                
            </form>
        </div>
    </div>
</div>
<br> 
";

if(!empty($_POST['asunto'])&&!empty($_POST['contenido']))
{
    $asunto=$_POST['asunto'];
    $contenido=$_POST['contenido'];
    $emaildestino2=$_POST['emailDestino'];

    //Insercion
    if($app->insercionMensaje($emailUsuario,$emaildestino2,$asunto,$contenido))
    {
        echo"";
        echo "<script type=\"text/javascript\"> alert('¡Su correo ha sido enviado con exito!.');
        </script>";
            //redireccion a Inicio.php
        echo "<script languaje=\"javascript\">window.location.href=\"inicio.php\"</script>";
    }
    else{
        echo "<script type=\"text/javascript\"> alert('Ops!Lo sentimos pero a ocurrido un error  al enviar el correo =(,Pruebe de nuevo');
        </script>";
            //redireccion a Inicio.php
        echo "<script languaje=\"javascript\">window.location.href=\"buscarAlumno.php\"</script>";
        
      

    }


   
}
else
{
    echo"<p class=\"text-center\">Todos los campos son obligatorios.</p>";
}
?>