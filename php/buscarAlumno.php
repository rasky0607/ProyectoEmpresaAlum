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
                </div>
                
            </form>
        </div>
    </div>
</div>