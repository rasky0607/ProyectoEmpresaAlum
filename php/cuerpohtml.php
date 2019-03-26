<?php
function print_head($title="Página SEGEMP"){
  echo "<!DOCTYPE html>
  <html lang=\"es\">  
    <head>    
      <title>$title</title>    
      <meta charset=\"UTF-8\">
      <meta name=\"title\" content=\"$title\">
      <meta name=\"description\" content=\"Descripción de la WEB\">    
      <link href=\"../css/bootstrap.css\" rel=\"stylesheet\"/>     
    </head>  
    <body>    
      <header>
        <h1>$title</h1>      
      </header> 
      ";
      
  }


      //Funcion que imprime el menú del sitio web
      function print_nav(){
        echo"<nav> </nav>";
        }
    
        //Funcion que imprime el pié de página del sitio Web
        function print_footer(){
       echo "<footer>
          <h4>Pablo López</h4>
          <a href='http://dominio.com/aviso-legal'>Política de cookies</a>
          <h4>Redes sociales</h4>
          <a href='http://facebook.com/mi-pagina-de-facebook'>Mi Facebook</a>
        </footer>";
        }

?>
<!--6 filas un calendario  x 7 columnas-->