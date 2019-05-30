<?php

include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Perfil ");
$nombreUsuario=App::nombreUsuario();
//Preguntamos que tipo de usuario es para mostrar un nav u otro
$app->getDao()->tipoUsuario(App::nombreUsuario());//Coloca un nav u otro segun el tipo de usuario
echo"<h3 class=\"text-center\">Actualizar datos:</h3>";

$list = $app->perfilUsuario(App::nombreUsuario());
//--Preparacion--//
$email=$app-> getEmailUsuario(App::nombreUsuario());
$anio = date('Y');
$fecha= date('d/m/Y');
  echo "
  <div class=\"container\">
      <div class=\"row\">
      <!--col-md- lo que ocupa los componentes de la pagina -->
      <!--offset-md- numero de columnas que debe dejar en los marjenes -->
          <div class=\"col-12 col-md-4 offset-md-4\">            
              <form method=\"POST\" action=\"insertDatosPerfilAlum.php\">
              <div class=\"col-4 col-md-0 offset-md-4\">
                  <br/> 
                  <img src=\"../img/perfil.png\" width=\"100\" height=\"100\"/>
              </div>               
                  <div class=\"from-group\">
                      <label for=\"user\">Usuario:</label>
                      <input id=\"user\" name=\"user\" type=\"text\" \" requiered=\"requiered\" class=\"form-control\" value=\"$nombreUsuario\" readonly >
                  </div>
                  <div class=\"from-group\">
                      <label for=\"NombreAlum\">Nombre alumno:</label>
                      <input id=\"NombreAlum\" name=\"NombreAlum\"  type=\"text\" requiered=\"requiered\" class=\"form-control\" >
                  </div>
                  <div class=\"from-group\">
                      <label for=\"apellidos\">Apellidos:</label>
                      <input id=\"apellidos\" name=\"apellidos\"  type=\"text\" requiered=\"requiered\" class=\"form-control\" >
                  </div>
                  <div class=\"from-group\">
                      <label for=\"anioPromocion\">Promocion del:</label>
                      <input id=\"anioPromocion\" name=\"anioPromocion\" type=\"number\" requiered=\"requiered\" class=\"form-control\">
                  
      
                  <div class=\"from-group\">
                      <label for=\"trabajaEn\">Trabajas en:</label>
                      <input id=\"trabajaEn\" name=\"trabajaEn\" type=\"text\"  class=\"form-control\">
                  </div>
                  <div class=\"from-group\">
                      <label for=\"fechaContrato\">Fecha de contratación:</label>
                      <input id=\"fechaContrato\" name=\"fechaContrato\" type=\"date\" requiered=\"requiered\" class=\"form-control\">
                  </div>
                  <br/>
  
                  <hr/>               
                  <div class=\"text-center\">
                      <a href=\"perfil.php\" class=\"btn btn-primary\">Volver</a>
                      <input type=\"submit\" value=\"Guardar\" class=\"btn btn-primary\">            
                  </div>
                  
              </form>
          </div>
      </div>
  </div>";

if(isset($_POST['NombreAlum'])){
  $usuarioAlum=$_POST['user'];
  $nombre=$_POST['NombreAlum'];
  $apellidos=$_POST['apellidos'];
  $anioPromocion=$_POST['anioPromocion'];
  $trabajaEn=$_POST['trabajaEn'];
  $fechaContrato=$_POST['fechaContrato'];
}

if(!empty($usuarioAlum) &&!empty($nombre) &&!empty($apellidos) &&!empty($anioPromocion) &&!empty($trabajaEn) &&!empty($fechaContrato))
{
    if($anioPromocion < 1900 || $anioPromocion>$anio)
    {
        echo "<script type=\"text/javascript\"> alert('¡El  año de promocion no puede ser inferior a 1900,ni superior al actual!.');
        </script>";
    }else 
    {
        if($app->updatePerfilUsuario($usuarioAlum,$nombre,$apellidos,$anioPromocion,$trabajaEn,$fechaContrato));
        {
            echo "<script type=\"text/javascript\"> alert('¡Datos guardados con exito!.');
            </script>";
            echo "<script languaje=\"javascript\">window.location.href=\"perfil.php\"</script>";
        }
    }

}
else if(!empty($usuarioAlum) &&!empty($nombre) &&!empty($apellidos) &&!empty($anioPromocion) && empty($trabajaEn) && empty($fechaContrato))
{
    if($anioPromocion < 1900 || $anioPromocion>$anio)
    {
        echo "<script type=\"text/javascript\"> alert('¡El  año de promocion no puede ser inferior a 1900 ni superior al actual!.');
        </script>";
    }
    else
    {
        if($app->updatePerfilUsuario($usuarioAlum,$nombre,$apellidos,$anioPromocion,$trabajaEn,$fechaContrato));
        {
            echo "<script type=\"text/javascript\"> alert('¡Datos guardados con exito!.');
            </script>";
            echo "<script languaje=\"javascript\">window.location.href=\"perfil.php\"</script>";
        }
    }

}
else
{
    echo "<script type=\"text/javascript\"> alert('¡Los campos Nombre de alumno, Apellidos, Email y Año de promocion son obligatorios!.');
    </script>";
}
?>