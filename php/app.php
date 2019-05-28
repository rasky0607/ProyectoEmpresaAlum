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
        <link href=\"../css/estilosGeneral.css\" rel=\"stylesheet\"/>
        <script src=\"../js/jquery-3.3.1.js\"></script>
        <script type=\"text/javascript\" src=\"../js/bootstrap.js\"></script>
        <script type=\"text/javascript\" src=\"../js/bootstrap.min.js\"></script>
        <script type=\"text/javascript\" src=\"../js/bootstrap.bundle.js\"></script>
        
      </head>  
      <body>    
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
            <link href=\"../css/estilosLogin.css\" rel=\"stylesheet\"/>
            <script src=\"../js/jquery-3.3.1.js\"></script>
            <script type=\"text/javascript\" src=\"../js/bootstrap.js\"></script>
            <script type=\"text/javascript\" src=\"../js/bootstrap.min.js\"></script>
            <script type=\"text/javascript\" src=\"../js/bootstrap.bundle.js\"></script>
            
          </head>  
          <body>       
            <header>         
            </header>
            <br/> ";
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
          <div class=\"p-1 mb-2 bg-info text-white\"/>
          <nav class=\"navbar navbar-expand-lg navbar-dark\">              
          <span class=\"navbar-brand mb-0 h1\"><u>Usuario:<a href=\"perfil.php\" title=\"perfil\"> $user</a></u></span>
          <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
              <ul class=\"navbar-nav mr-auto\">
          
              <li class=\"nav-item active\">
                  <a class=\"nav-link\" href=\"buscarAlumno.php\"><img src=\"../img/contactar.png\" title=\"Contactar con exalumno\" width=\"50\" height=\"50\"/><span class=\"sr-only\">(current)</span></a>
              </li>
              <li class=\"nav-item active\">
                <a class=\"nav-link\" href=\"correosEnviados.php\"><img src=\"../img/correoenviado.png\" title=\"Correos Enviados\" width=\"50\" height=\"50\"/><span class=\"sr-only\">(current)</span></a>
              </li>

              <li class=\"nav-item active\">
                <a class=\"nav-link\" href=\"inicio.php\"><img src=\"../img/buzon.png\" title=\"Registro de todos los correos\" width=\"50\" height=\"50\"/><span class=\"sr-only\">(current)</span></a>            
              </li>

              <li class=\"nav-item active\">
              <a class=\"nav-link\" href=\"listarEmpresas.php\"><img src=\"../img/empresa.png\" title=\"Listado de empresas\" width=\"50\" height=\"50\"/><span class=\"sr-only\">(current)</span></a>            
            </li>
                             
              </ul>
             <span class=\"navbar-brand mb-0 h1\"><a class=\"nav-link\" href=\"logout.php\">Cerrar sesión</a></span>
            </nav> 
            </div>";
          }


        function print_nav_Empe($user){
          echo"      
          <div class=\"p-1 mb-2 bg-info text-white\"/>
          <nav class=\"navbar navbar-expand-lg navbar-dark\">              
          <span class=\"navbar-brand mb-0 h1\"><u>Usuario:<a href=\"perfil.php\" title=\"perfil\"> $user</a></u></span>
          <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
              <ul class=\"navbar-nav mr-auto\">
          
              <li class=\"nav-item active\">
                  <a class=\"nav-link\" href=\"buscarAlumno.php\"><img src=\"../img/buscar.png\" title=\"Buscar alumno\" width=\"50\" height=\"50\"/> <span class=\"sr-only\">(current)</span></a>
              </li>           

              <li class=\"nav-item active\">
                <a class=\"nav-link\" href=\"inicio.php\"><img src=\"../img/correoenviado.png\" title=\"Correos Enviados\" width=\"50\" height=\"50\"/> <span class=\"sr-only\">(current)</span></a>
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
        return strtoupper($_SESSION['user']);
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

      //Función que devuelve todos los correos de un usuario concreto como remitente y detinatario
      function getcorreosEnviadosRecibidos($user){
          return $this->dao->getcorreosEnviadosRecibidos($user);
      }

      function getDetalleDeUnCorreoRecibido($idCorreo){
        return $this->dao->getDetalleDeUnCorreoRecibido($idCorreo);
    }

    function getCorresEnviados($correoUsuario)
    {
      return $this->dao->getCorresEnviados($correoUsuario);
    }
    
    function getEmailUsuario($usuario)
    {
      return $this->dao->getEmailUsuario($usuario);
    }

    function getCorreoEmailRemitente($emailUsuario,$remitente)
    {
      return $this->dao->getCorreoEmailRemitente($emailUsuario,$remitente);
    }

    /*Funcion que pinta la cabecera de una tabla con estilos de boostrap
     Para LISTADO de CORREOS*/
    function mostrarCabecerasDeTabla($result){
      echo "<table class=\"table table-striped table-dark table-bordered\>";
      echo"<thead>";
      echo "<tr <div class=\"p-3 mb-2 bg-success text-white\">";
      for($i=0;$i<$result->columnCount();$i++)
      {       
         $nombreColumn = $result->getcolumnMeta($i);
       
          echo "<th class=\"cabecolum\">".strtoupper($nombreColumn['name'])."</th>";
          if($i==0)
            echo "<th class=\"cabecolum\">TIPO DE CORREO</th>";
         
      }
      echo "</tr>";
      echo "</thead>";
    }

    function coleccionVacia($list,$mensaje)
    {
      if(empty($list)){//Si no ha enviado ningun correo
        echo "<h3 class=\"text-center\"> $mensaje</h3>";
        }
    }
    function insertNuevoUsuario($usuario,$password,$email,$tipoUsuario)
    {
      return $this->dao->insertNuevoUsuario($usuario,$password,$email,$tipoUsuario);
    }
    
    function perfilUsuario($user)
    {
      return $this->dao->perfilUsuario($user);
    }
    
    function buscarEmail($emailAbuscar)
    {
      return $this->dao->buscarEmail($emailAbuscar);
    }
    function insercionMensaje($emailRemitente,$emailDestino,$asunto,$contenido)
    {
      return $this->dao->insercionMensaje($emailRemitente,$emailDestino,$asunto,$contenido);
    }
    function listarEmpresas()
    {
      return $this->dao->listarEmpresas();
    }
    function tipoUsuario2($usuario)
    {
      return $this->dao->tipoUsuario2($usuario);
    }
    function listarAlumnos($usuario)
    {
      return $this->dao->listarAlumnos($usuario);
    }
    function listarAlumnosParaEmp($apellidos,$anioPromocion)
    {
      return $this->dao->listarAlumnosParaEmp($apellidos,$anioPromocion);
    }

    function updatePerfilUsuario($usuario,$nombre,$apellidos,$anioPromocion,$trabajaEn,$fechaContrato)
    {
      return $this->dao->updatePerfilUsuario($usuario,$nombre,$apellidos,$anioPromocion,$trabajaEn,$fechaContrato);
    }
    function updatePerfilEmpresa($usuario,$nombre,$direccion,$telefono,$nombreContacto)
    {
      return $this->dao->updatePerfilEmpresa($usuario,$nombre,$direccion,$telefono,$nombreContacto);
    }
}
?>