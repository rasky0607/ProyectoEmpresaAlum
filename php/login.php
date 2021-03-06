<?php
include_once("app.php");

//Para iniciar una sesion o reanuda una existente (funcion propia de php)
session_start();
//llamada a metodos para pintar la cabecera plantilla de la pagina
App::print_head_login("Inicio de sesión");
//echo" <h1 class=\"text-center\">Inicio de sesión</h1>";
?>
<!--Crear el formulario LOGIN con Bootstrap-->
<div class="container">
    <div class="row">
    <!--col-md- lo que ocupa los componentes de la pagina -->
    <!--offset-md- numero de columnas que debe dejar en los marjenes -->
        <div class="col-12 col-md-4 offset-md-4">            
            <form method="POST" action="login.php">
            <div class="col-4 col-md-0 offset-md-4">
                <br/> 
                <img src="../img/logo2.svg" width="100" height="100"/>
            </div>    

                <div class="from-group">
                    <label for="user">Usuario:</label>
                    <input id="user" name="user" type="text" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>
                <div class="from-group">
                    <label for="password">Password:</label>
                    <input id="password" name="password" type="password" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>
                <br/>
               
                <div class="text-center">
                    <input type="submit" value="Iniciar de sesión" class="btn btn-primary">
                    <hr/>
                    <a href="registro.php" class="btn btn-primary">Registrarse</a>
                </div>
                
            </form>
        </div>
    </div>
</div>

<?php

//Comprobacion de que no este vacio 
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $user=$_POST["user"];
    $password=$_POST["password"];
    if(empty($user))
    {
        echo "<p class=\"text-center\">Debes introducir el nombre de usuario</p>";
    }
    else if(empty($password))
    {
        echo "<p class=\"text-center\">Debes introducir una contraseña</p>";
    }
    else{

        //Se realiza conecxion a la Base de datos y comprobar si el usuario existe
            $app = new App();
            if(!$app->getDao()-> conecxionAbierta()) //Iniciar sesion
            {
                //Mostrar el error
                echo "NO CONECTAS CHATO";
                echo "<p>".$app-> getDao()->error."</p>";

            }elseif($app->getDao()-> validarUsuario($user,$password)){
               
                //echo "<p> Usuario correcto.La conexion es correcta. </p>";
                //Se guarda la sesion
                //echo "Conectado!";
               $app->saveSession($user);//Se guarda la sesion de ese usuario         
                 //Se redirecciona
                 echo "<script languaje=\"javascript\">window.location.href=\"inicio.php\"</script>"; //Nuevo añadido
         
            }else
                echo "<p class=\"text-center\"> Usuario incorrecto. </p>";

               
               
        

        //Redireccion a la pagina principal del proyecto de esta forma:
        //echo "<script language='javascript'>window.location.href='aula.php'</script>";
    }
}

//llamada a metodos para pintar la pie de pajina plantilla de la pagina
App::print_footer();
?>