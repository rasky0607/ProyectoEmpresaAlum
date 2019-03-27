<?php
include ("dao.php");
class App{
private $dao;

function __construct()
{
  $this->dao=new Dao();
}

    //$title ="Página SEGEMP" es el valor por defecto indicado a este parametro si n o sele pasa nada
function print_head($title="Página SEGEMP"){
  //Cambiamos el enlace de <link href=\"../css/bootstrap.css\" rel=\"stylesheet\"/>    
    echo "<!DOCTYPE html>
    <html lang=\"es\">  
      <head>    
        <title>$title</title>    
        <meta charset=\"UTF-8\">
        <meta name=\"title\" content=\"$title\">
        <meta name=\"description\" content=\"Descripción de la WEB\">    
        <link href=\"../css/bootstrap.css\" rel=\"stylesheet\"/>  
        <link href=\"../css/aula.css\" rel=\"stylesheet\"/>
        <script src=\"../js/jquery-3.3.1.js\"></script>
        <script type=\"text/javascript\" src=\"../js/bootstrap.js\"></script>
        <script type=\"text/javascript\" src=\"../js/bootstrap.min.js\"></script>
        <script type=\"text/javascript\" src=\"../js/bootstrap.bundle.js\"></script>
        
      </head>  
      <body style=\"background-color:#66ffa6\">    
        <header>
       
       
        </header> ";
        /*  <header>       
            <h1 class=\"text-center\">$title</h1>
            </header>  */ 
    }

    function print_head_login($title="Página SEGEMP"){
      //Cambiamos el enlace de <link href=\"../css/bootstrap.css\" rel=\"stylesheet\"/>    
        echo "<!DOCTYPE html>
        <html lang=\"es\">  
          <head>    
            <title>$title</title>    
            <meta charset=\"UTF-8\">
            <meta name=\"title\" content=\"$title\">
            <meta name=\"description\" content=\"Descripción de la WEB\">    
            <link href=\"../css/bootstrap.css\" rel=\"stylesheet\"/>  
            <link href=\"../css/aula.css\" rel=\"stylesheet\"/>
            <script src=\"../js/jquery-3.3.1.js\"></script>
            <script type=\"text/javascript\" src=\"../js/bootstrap.js\"></script>
            <script type=\"text/javascript\" src=\"../js/bootstrap.min.js\"></script>
            <script type=\"text/javascript\" src=\"../js/bootstrap.bundle.js\"></script>
            
          </head>  
          <body style=\"background-color:#bbdefb\">       
            <header>         
            </header>
            <br/> ";

  
        }

        //Funcion que imprime el menú del sitio web
      function print_nav_ausencias(){
        echo"      
        <div class=\"p-1 mb-2 bg-success text-white\"/>
        <nav class=\"navbar navbar-expand-lg navbar-dark\">              
        <span class=\"navbar-brand mb-0 h1\"><u>Ausencias:</u></span>
        <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
            <ul class=\"navbar-nav mr-auto\">
        
            <li class=\"nav-item active\">
                <a class=\"nav-link\" href=\"listabsenceAll.php\">Listado de ausencias <span class=\"sr-only\">(current)</span></a>
            </li>
            <li class=\"nav-item dropdown\">
            <span class=\"nav-item active\"> <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownMenuLink\" role=\"button\"
                 data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                Gestión de ausencias
                </a></sapn>
                <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdownMenuLink\">
                    <a class=\"dropdown-item disabled\" data-toggle=\"modal\" href=\"#\">Alta ausencia</a>
                    <a class=\"dropdown-item disabled\" href=\"#\">Editar ausencia</a>
                    <a class=\"dropdown-item\" href=\"formSearchAbsenDate.php\">Filtrar ausencias</a>
                </div> 
                </li>                                 
              </li>
              <li class=\"nav-item active\">
              <a class=\"nav-link\" href=\"liststudent.php\">Listado de alumnos <span class=\"sr-only\">(current)</span></a>
          </li>            
            </ul>
           <span class=\"navbar-brand mb-0 h1\"><a class=\"nav-link\" href=\"logout.php\">Cerrar sesión</a></span>
          </nav> 
          </div>";
        }

   
    
        //Funcion que imprime el pié de página del sitio Web
      function print_footer(){
       echo "<footer>
          <h5 class=\"text-center\">Pablo López</h5>
          <a href='http://dominio.com/aviso-legal'>Política de cookies</a>         
        </footer>";
        }

        function print_nav_Alum($user){
          echo"      
          <div class=\"p-1 mb-2 bg-success text-white\"/>
          <nav class=\"navbar navbar-expand-lg navbar-dark\">              
          <span class=\"navbar-brand mb-0 h1\"><u>Usuario: $user</u></span>
          <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
              <ul class=\"navbar-nav mr-auto\">
          
              <li class=\"nav-item active\">
                  <a class=\"nav-link\" href=\"listabsenceAll.php\">Contactar con un exalumno <span class=\"sr-only\">(current)</span></a>
              </li>
              <li class=\"nav-item active\">
                <a class=\"nav-link\" href=\"listabsenceAll.php\">Correos enviados <span class=\"sr-only\">(current)</span></a>
              </li>

              <li class=\"nav-item active\">
                <a class=\"nav-link\" href=\"plataformaAlum.php\">Registro de todos los correos <span class=\"sr-only\">(current)</span></a>
              </li>
          
                    
              </ul>
             <span class=\"navbar-brand mb-0 h1\"><a class=\"nav-link\" href=\"logout.php\">Cerrar sesión</a></span>
            </nav> 
            </div>";
          }
  

        function print_nav_Empe($user){
          echo"      
          <div class=\"p-1 mb-2 bg-success text-white\"/>
          <nav class=\"navbar navbar-expand-lg navbar-dark\">              
          <span class=\"navbar-brand mb-0 h1\"><u>Usuario: $user</u></span>
          <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
              <ul class=\"navbar-nav mr-auto\">
          
              <li class=\"nav-item active\">
                  <a class=\"nav-link\" href=\"#\">Buscar un alumno <span class=\"sr-only\">(current)</span></a>
              </li>
              <li class=\"nav-item active\">
                <a class=\"nav-link\" href=\"#\">Correos enviados <span class=\"sr-only\">(current)</span></a>
              </li>

              <li class=\"nav-item active\">
                <a class=\"nav-link\" href=\"plataformaEmp.php\">Registro de todos los correos <span class=\"sr-only\">(current)</span></a>
              </li>
          
                    
              </ul>
             <span class=\"navbar-brand mb-0 h1\"><a class=\"nav-link\" href=\"logout.php\">Cerrar sesión</a></span>
            </nav> 
            </div>";
          }
       



        //Funcion que devuelve la unica conexion a la BD
      function getDao(){
        //var_dump($this->dao);
          return $this->dao;
        }

      function validateSession(){
          session_start();//Para iniciar una sesion o reanuda una existente (funcion propia de php)
          if (!$this->isLogged())
              $this->showLogin();
      }
      //Función que comprueba si existe el usuario
      function isLogged(){
          return isset ($_SESSION['user']);
      }

      function nombreUsuario(){
        return $_SESSION['user'];
      }
      //Función que redirige a a Login
      function showLogin(){
          //Petición a una cabecera.
          header ('Location: login.php'); //Solo se puede utilizar cuando no se ha escrito nada ni se ha mandado una petición al cliente.
      }
      

        //Funcion que guarda el nombre de usuario en la variable
        //$_SESSION cuando el usuario ha iniciado sesion en login.php
        function saveSession($user){
          $_SESSION['user']=$user;
        }

        function invalidateSession(){
          session_start();//Para iniciar una sesion o reanuda una existente (funcion propia de php)
          if ($this->isLogged())
              unset($_SESSION['user']);
          session_destroy();
          $this->showLogin();
      }

      //Función que devuelve todos los estudiantes dados de alta
      function getStudents(){
          return $this->dao->getStudents();
      }

    
}
?>