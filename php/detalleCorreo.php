<?php
include_once("app.php");
$app = new App();
$app -> validateSession();
App::print_head("Detalle de correo: ");
//Preguntamos que tipo de usuario es para mostrar un nav u otro
 $app->getDao()->tipoUsuario(App::nombreUsuario());

//Recogemos el id del correo selecionado:
$idCorreo = $_GET['id_correo'];
//Optenemos los campos del correo en funcion de su ID
$resul = $app ->getDetalleDeUnCorreoRecibido($idCorreo);
//Convertimos la colecion $result en una lista $list
$list = $resul->fetchAll();
//Datos
mostrarDetalles($list);
//App::print_footer();

//---FUNCIONES--//

//Funcion que lista los detalles en el centro de la pantalla
function mostrarDetalles($list){
    foreach($list as $fila)
    { 
       /* echo "<br/><div class=\"text-center\">";
        echo"<h3>Remitente:</br></h3>".$fila['remitente'].
        "<h3>Destinatario:</br></h3>".$fila['destinatario'].
        "<h3>Fecha:</br></h3>".$fila['fecha'].
        "<h3>Asunto:</br></h3>".$fila['asunto'].
        "<h3>Contenido:</br></h3>".$fila['contenido'];
        echo"</div>"; */

        echo "
        <div class=\"container\">
            <div class=\"row\">
            <!--col-md- lo que ocupa los componentes de la pagina -->
            <!--offset-md- numero de columnas que debe dejar en los marjenes -->
                <div class=\"col-12 col-md-4 offset-md-4\">            
                    <form method=\"POST\" action=\"perfil.php\">
                    <div class=\"col-4 col-md-0 offset-md-4\">
                        <br/> 
                        <img src=\"../img/leerCorreo.png\" width=\"100\" height=\"100\"/>
                    </div>               
                        <div class=\"from-group\">
                            <label for=\"remitente\">Remitente:</label>
                            <input id=\"remitente\" name=\"remitente\" type=\"text\" requiered=\"requiered\" class=\"form-control\" value=".$fila['remitente']." readonly >
                        </div>
                        <div class=\"from-group\">
                            <label for=\"Destinatario\">Destinatario:</label>
                            <input id=\"Destinatario\" name=\"Destinatario\" type=\"text\" requiered=\"requiered\" class=\"form-control\" value=".$fila['destinatario']." readonly>
                        </div>
                        <div class=\"from-group\">
                            <label for=\"Fecha\">Fecha:</label>
                            <input id=\"Fecha\" name=\"Fecha\" type=\"text\" requiered=\"requiered\" class=\"form-control\" value=".$fila['fecha']." readonly>
                        </div>
                        <div class=\"from-group\">
                            <label for=\"Asunto\">Asunto:</label>
                            <input id=\"Asunto\" name=\"Asunto\" type=\"text\"  value=".$fila['asunto']." requiered=\"requiered\" class=\"form-control\" readonly>
                        </div>
                        <div class=\"from-group\">
                            <label for=\"Contenido\">Contenido:</label>
                            <textarea rows=\"4\" cols=\"50\" id=\"contenido\" name=\"contenido\" type=\"text\" autofocus=\"autofocus\" requiered=\"requiered\" class=\"form-control\" readonly>".$fila['contenido']."</textarea>
                        </div>
                        <br/>
                    
                    </form>
                </div>
            </div>
        </div>";
    
    }
}

//-----------------//

?>