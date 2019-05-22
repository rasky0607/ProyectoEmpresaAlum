<?php
include_once("app.php");
$app = new App();
App::print_head("Registro");
?>
<div class="container">
    <div class="row">
    <!--col-md- lo que ocupa los componentes de la pagina -->
    <!--offset-md- numero de columnas que debe dejar en los marjenes -->
        <div class="col-12 col-md-4 offset-md-4">            
            <form method="POST" action="registro.php">
            <div class="col-4 col-md-0 offset-md-4">
                <br/> 
                <img src="../img/login.png" width="100" height="100"/>
            </div>               
                <div class="from-group">
                    <label for="user">Usuario:</label>
                    <input id="user" name="user" type="text" autofocus="autofocus" requiered="requiered" class="form-control" >
                </div>
                <div class="from-group">
                    <label for="password">Password:</label>
                    <input id="password" name="password" type="password" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>
                <div class="from-group">
                    <label for="password">Confirmar Password:</label>
                    <input id="confirpassword" name="confirpassword" type="password" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>
                <div class="from-group">
                    <label for="email">Email:</label>
                    <input id="email" name="email" type="email" autofocus="autofocus" requiered="requiered" class="form-control">
                </div>
                <br/>
                <div class="text-center">
                    <label for="user">Soy un/una:</label><br/>
                    <select name="tipoUsuario">
                        <option value="alumno">Alumno</option>
                        <option value="empresa">Empresa</option>
                    </select>
                </div>    
                <hr/>               
                <div class="text-center">
                    <a href="login.php" class="btn btn-primary">Volver</a>
                    <input type="submit" value="Registrar" class="btn btn-primary">                                   
                </div>
                
            </form>
        </div>
    </div>
</div>
<?php
$usuario=$_POST["user"];
$password=$_POST["password"];
$confirPassword=$_POST["confirpassword"]; // Confirmaccion de password
$email = $_POST["email"];
$tipoUsuario =$_POST["tipoUsuario"];
if(!empty($usuario)&&!empty($email))
{
    if($password==$confirPassword)
    {
        if($app->insertNuevoUsuario($usuario,$password,$email,$tipoUsuario))
        {
            echo"<p class=\"text-center\"><a id=\"marcacorrecto\">Usuario creado con exito!.</a></p>";
        }else{
            echo"<p class=\"text-center\"><a id=\"marcaerror\">*</a>Fallo al crear el usuario.</p>";
        }
    }
    else
    {
        echo"<p class=\"text-center\"><a id=\"marcaerror\">*</a>Los password no coinciden.</p>";
    }
}else if(!preg_match('^.+',$usuario)&&!empty($email)){
    echo"<p class=\"text-center\"><a id=\"marcaerror\">*</a>Error: Los campos Usuario y el Email deben rellenarse.</p>";
}
else{
    echo"<p class=\"text-center\">Todos los campos son obligatorios.</p>";
}

//echo " DATOS-> ".$usuario.", ".$password.", ".$confirPassword.", ".$email.", ".$tipoUsuario; 

?>