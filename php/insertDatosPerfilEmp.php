<?php
echo"<h3 class=\"text-center\">Tus datos:</h3>";
include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Perfil ");
$nombreUsuario=App::nombreUsuario();
//Preguntamos que tipo de usuario es para mostrar un nav u otro
$list = $app->perfilUsuario(App::nombreUsuario());

//--Preparacion--//
$email=$app-> getEmailUsuario(App::nombreUsuario());

echo "
<div class=\"container\">
    <div class=\"row\">
    <!--col-md- lo que ocupa los componentes de la pagina -->
    <!--offset-md- numero de columnas que debe dejar en los marjenes -->
        <div class=\"col-12 col-md-4 offset-md-4\">            
            <form method=\"POST\" action=\"insertDatosPerfilEmp.php\">
            <div class=\"col-4 col-md-0 offset-md-4\">
                <br/> 
                <img src=\"../img/perfil.png\" width=\"100\" height=\"100\"/>
            </div>               
                <div class=\"from-group\">
                    <label for=\"user\">Usuario:</label>
                    <input id=\"user\" name=\"user\" type=\"text\" requiered=\"requiered\" class=\"form-control\" value=\"$nombreUsuario\" readonly >
                </div>
                <div class=\"from-group\">
                    <label for=\"NombreEmp\">Nombre de empresa:</label>
                    <input id=\"NombreEmp\" name=\"NombreEmp\" type=\"text\" requiered=\"requiered\" class=\"form-control\">
                </div>
                <div class=\"from-group\">
                    <label for=\"direccion\">Direccion:</label>
                    <input id=\"direccion\" name=\"direccion\" type=\"text\" requiered=\"requiered\" class=\"form-control\">
                </div>
                <div class=\"from-group\">
                    <label for=\"telefono\">Telefono:</label>
                    <input id=\"telefono\" name=\"telefono\" type=\"number\"   requiered=\"requiered\" class=\"form-control\">
                </div>
                <div class=\"from-group\">
                    <label for=\"nombreContacto\">Nombre de contacto:</label>
                    <input id=\"nombreContacto\" name=\"nombreContacto\" type=\"text\"   requiered=\"requiered\" class=\"form-control\">
                </div>
                <br/>

                <hr/>               
                <div class=\"text-center\">
                    <a href=\"perfil.php\" class=\"btn btn-primary\">Volver</a>
                    <input type=\"submit\" name=\"guardar\" value=\"Guardar\" class=\"btn btn-primary\">     
                </div>
            
            </form>
        </div>
    </div>
</div>";

  $usuarioEmp=$_POST['user'];
  $nombre=$_POST['NombreEmp'];
  $direccion=$_POST['direccion'];
  $telefono=$_POST['telefono'];
  $nombreContacto=$_POST['nombreContacto'];
if($_POST['guardar'])
{
    if(!empty($usuarioEmp) &&!empty($nombre) &&!empty($direccion) &&!empty($telefono) &&!empty($nombreContacto))
    {

        if($app->updatePerfilEmpresa($usuarioEmp,$nombre,$direccion,$telefono,$nombreContacto));
        {
            echo "<script type=\"text/javascript\"> alert('¡Datos guardados con exito!.');
            </script>";
            echo "<script languaje=\"javascript\">window.location.href=\"perfil.php\"</script>";
        }

    }else
    {
        echo "<script type=\"text/javascript\"> alert('¡Debe rellenarse todos los campos!.');
        </script>";
    }
}
?>