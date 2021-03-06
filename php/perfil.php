<?php

include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Perfil ");
//Preguntamos que tipo de usuario es para mostrar un nav u otro
//Preguntamos que tipo de usuario es para mostrar un nav u otro
$app->getDao()->tipoUsuario(App::nombreUsuario());//Coloca un nav u otro segun el tipo de usuario
//echo"<h3 class=\"text-center\">Tus datos:</h3>";
$list = $app->perfilUsuario(App::nombreUsuario());

//--Preparacion--//
$email=$app-> getEmailUsuario(App::nombreUsuario());
/*Optenemos el tipo de usuario para mostrar una interfaz u otra,
 ya que los datos de empresa y alumnos son distintos*/
$tipoUsuario = $app->getDao()->ObtenertipoUsuario($app->nombreUsuario());


//--Ejecucion--//

//Perfil Alumno

if(strcmp($tipoUsuario,'alumno')==0)
{
    
    $usuarioAlum=$list[0][0];
    $nombre=$list[0][1];
    $apellidos=$list[0][2];
    $anioPromocion=$list[0][3];
    $estadoLaboral=$list[0][4];
    $trabajaEn=$list[0][5];
    $fechaContrato=$list[0][6];
    //echo $list[0][5];


    //echo "hola";

    echo "
    <div class=\"container\">
    </script>
        <div class=\"row\">
        <!--col-md- lo que ocupa los componentes de la pagina -->
        <!--offset-md- numero de columnas que debe dejar en los marjenes -->
            <div class=\"col-12 col-md-4 offset-md-4\">            
                <form method=\"POST\" action=\"perfil.php\">
                <div class=\"col-4 col-md-0 offset-md-4\">
                    <br/> 
                    <img src=\"../img/perfil.png\" width=\"100\" height=\"100\"/>
                </div>               
                    <div class=\"from-group\">
                        <label for=\"user\">Usuario:</label>
                        <input id=\"user\" name=\"user1\" type=\"text\" \" requiered=\"requiered\" class=\"form-control\" value=\"$usuarioAlum\" readonly >
                    </div>
                    <div class=\"from-group\">
                        <label for=\"NombreAlum\">Nombre alumno:</label>
                        <input id=\"NombreAlum\" name=\"NombreAlum\"  type=\"text\" requiered=\"requiered\" class=\"form-control\" value=\"$nombre\" readonly>
                    </div>
                    <div class=\"from-group\">
                        <label for=\"apellidos\">Apellidos:</label>
                        <input id=\"apellidos\" name=\"apellidos\"  type=\"text\" requiered=\"requiered\" class=\"form-control\" value=\"$apellidos\" readonly>
                    </div>
                    <div class=\"from-group\">
                        <label for=\"email\">Email:</label>
                        <input id=\"email\" name=\"email\"  type=\"email\"  value=\"$email\" requiered=\"requiered\" class=\"form-control\" readonly>
                    </div>
                    <div class=\"from-group\">
                        <label for=\"anioPromocion\">Promocion del:</label>
                        <input id=\"anioPromocion\" name=\"anioPromocion\"  type=\"number\"  value=\"$anioPromocion\" requiered=\"requiered\" class=\"form-control\" readonly>
                    </div>
                    <div class=\"text-center\">
                    <hr/>
                    </br>
                    <label for=\"estadoLaboral\">Estado laboral:</label><br/>
                    <input id=\"estadoLaboral\" name=\"estadoLaboral\" type=\"text\"  value=\"$estadoLaboral\" requiered=\"requiered\" class=\"form-control\" readonly>
                    </div>   
        
                    <div class=\"from-group\">
                        <label for=\"trabajaEn\">Trabajas en:</label>
                        <input id=\"trabajaEn\" name=\"trabajaEn\"  type=\"text\"  value=\"$trabajaEn\" requiered=\"requiered\" class=\"form-control\" readonly>
                    </div>
                    <div class=\"from-group\">
                        <label for=\"fechaContrato\">Fecha de contratación:</label>
                        <input id=\"fechaContrato\" name=\"fechaContrato\"  type=\"date\"  value=\"$fechaContrato\" requiered=\"requiered\" class=\"form-control\" readonly>
                    </div>
                    <br/>
    
                    <hr/>               
                    <div class=\"text-center\">
                        <a href=\"inicio.php\" class=\"btn btn-primary\">Volver</a>
                        <a class=\"btn btn-primary\" href=\"insertDatosPerfilAlum.php\" class=\"btn btn-primary\">Rellenar tus datos</a>                                   
                    </div>
                    
                </form>
            </div>
        </div>
    </div>";
    
      
       // echo $usuarioAlum." ".$nombre." ".$apellidos." ".$anioPromocion." ".$estadoLaboral." ".$trabajaEn." ".$fechaContrato;
       // $app->updatePerfilUsuario($usuarioAlum,$nombre,$apellidos,$anioPromocion,$estadoLaboral,$trabajaEn,$fechaContrato);

}

// Perfil Empresa
if(strcmp($tipoUsuario,'empresa')==0)
{
    $usuarioEmp=$list[0][0];
    $nombre=$list[0][1];
    $direccion=$list[0][2];
    $telefono=$list[0][3];
    $nombreContacto=$list[0][4];
    //echo $list[0][5];
    echo "
    <div class=\"container\">
        <div class=\"row\">
        <!--col-md- lo que ocupa los componentes de la pagina -->
        <!--offset-md- numero de columnas que debe dejar en los marjenes -->
            <div class=\"col-12 col-md-4 offset-md-4\">            
                <form method=\"POST\" action=\"perfil.php\">
                <div class=\"col-4 col-md-0 offset-md-4\">
                    <br/> 
                    <img src=\"../img/perfil.png\" width=\"100\" height=\"100\"/>
                </div>               
                    <div class=\"from-group\">
                        <label for=\"user\">Usuario:</label>
                        <input id=\"user\" name=\"user\" type=\"text\" requiered=\"requiered\" class=\"form-control\" value=\"$usuarioEmp\" readonly >
                    </div>
                    <div class=\"from-group\">
                        <label for=\"NombreEmp\">Nombre de empresa:</label>
                        <input id=\"NombreEmp\" name=\"NombreEmp\" type=\"text\" requiered=\"requiered\" class=\"form-control\" value=\"$nombre\" readonly>
                    </div>
                    <div class=\"from-group\">
                        <label for=\"direccion\">Direccion:</label>
                        <input id=\"direccion\" name=\"direccion\" type=\"text\" requiered=\"requiered\" class=\"form-control\" value=\"$direccion\" readonly>
                    </div>
                    <div class=\"from-group\">
                        <label for=\"telefono\">Telefono:</label>
                        <input id=\"telefono\" name=\"telefono\" type=\"number\"  value=\"$telefono\" requiered=\"requiered\" class=\"form-control\" readonly>
                    </div>
                    <div class=\"from-group\">
                        <label for=\"nombreContacto\">Nombre de contacto:</label>
                        <input id=\"nombreContacto\" name=\"nombreContacto\" type=\"text\"  value=\"$nombreContacto\" requiered=\"requiered\" class=\"form-control\" readonly>
                    </div>
                    <br/>
   
                    <hr/>               
                    <div class=\"text-center\">
                        <a href=\"inicio.php\" class=\"btn btn-primary\">Volver</a>
                        <a class=\"btn btn-primary\" href=\"insertDatosPerfilEmp.php\" class=\"btn btn-primary\">Rellenar tus datos</a>                                       
                    </div>
                
                </form>
            </div>
        </div>
    </div>";
}



?>