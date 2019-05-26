<?php

//Clase que va gestionar la conexion a la base dedatos

define("DATABASE","empresalum");
define("DSN","mysql:host=localhost;dbname=".DATABASE);
define("USER","usuario");
define("PASSWORD","123");
//Definimos las tablas con sus columnas
//----------------------//
//Tabla usuarios
define("TUSUARIO","usuario");
define("CUSUARIO_NOMBRE","usuario");
define("CUSUARIO_PASSWORD","password");
define("CUSUARIO_EMAIL","email");
define("CUSUARIO_TIPO","tipoUsuario");

//Tabla alumno
define ("TALUMNO", "alumno");
define("CALUMNO_USUARIOALUM","usuarioAlum");
define("CALUMNO_NOMBRE","nombre");
define("CALUMNO_APELLIDOS","apellidos");
define("CALUMNO_ANIOPROMOCION","anioPromocion");
define("CALUMNO_ESTADOLABORAL","estadoLaboral");
define("CALUMNO_TRABAJAEN","trabajaEn");
define("CALUMNO_FECHACONTRATO","fechaContrato");

//Tabla Empresa
define ("TEMPRESA", "empresa");
define ("CEMPRESA_USUARIOEMP", "usuarioEmp");
define ("CEMPRESA_NOMBRE","nombre");
define ("CEMPRESA_DIRECCION","direccion");
define ("CEMPRESA_TELEFONO","telefono");
define ("CEMPRESA_NOMBRECONTACTO","nombreContacto");

//Tabla Correos
define("TCORREO","correo");
define("CCORREO_ID","idCorreo");
define("CCORREO_REMITENTE","remitente");
define("CCORREO_DESTINATARIO","destinatario");
define("CCORREO_FECHA","fecha");
define("CCORREO_ASUNTO","asunto");
define("CCORREO_CONTENIDO","contenido");
//----------------------//

class Dao{
    private $conecxion;
    public $error;
    function __construct()
    {
        try
        {
           $this->conecxion=new PDO(DSN,USER,PASSWORD);//devuelve un objet conexcion     
           
        }
        catch(PDOEXception $e)
        {
            $this->error="Error en la conecxion: ".$e->getMessage();//deveulve el error
        }
    }

    //Metodo que comprueba si hay una conexion con la BD
    function conecxionAbierta(){       
        return isset($this->conecxion);// si conexion es null
    }

    //Funcion que compruebasi existe el usuario en la tabla User
    function validarUsuario($user,$password){
        $sql="SELECT * FROM ".TUSUARIO." WHERE ".CUSUARIO_NOMBRE."='".$user."' AND ".CUSUARIO_PASSWORD." =password('".$password."')";
        //echo $sql;  
        $resultado=$this->conecxion->query($sql);
        if($resultado->rowCount()==1)      
            return true;
        else
        return false;

    }

    /*Funcion que determina el tipo de usuario que tiene la sesion iniciada
     En funcion de el nombre de usuario guardado en la sesion para pintar uno u otro NAV*/
    function tipoUsuario($user){
        try{
        $sql="SELECT ".CUSUARIO_TIPO." from ".TUSUARIO." WHERE ".CUSUARIO_NOMBRE."='".$user."'";
        //echo $sql;
        $resultado = $this->conecxion->query($sql);
        $list = $resultado->fetchAll();    
        //var_dump($list);
        $tipoUsuario = $list[0][0];//Obtenemos el tipo de usuario del array resultante de list  se puede apreciar en el var_dump($list);
       
            if(strcmp($tipoUsuario,"alumno")==0)
            {
                return App::print_nav_Alum(App::nombreUsuario());
            }
            else
            {
                return App::print_nav_Empe(App::nombreUsuario());//Pinta el nombre del usuario del que se guardo la sesion
            
            }      
        }
        catch(PDOException $e)
        {
            $this->$error=$e->getMessage();
        }
    }
    function perfilUsuario($user){
        try{
           $tipoUsuario =$this->ObtenertipoUsuario($user);      
            if(strcmp($tipoUsuario,"alumno")==0)
            {
                $sql2="SELECT * from ".TALUMNO." WHERE ".CALUMNO_USUARIOALUM."='".$user."'";
                //echo $sql2;
                $result=$this->conecxion->query($sql2);
                $listdatos =$result->fetchAll();
                return $listdatos;
            }
            else
            {
                $sql2="SELECT * from ".TEMPRESA." WHERE ".CEMPRESA_USUARIOEMP."='".$user."'";
                $result=$this->conecxion->query($sql2);
                $listdatos =$result->fetchAll();
                return $listdatos;
            
            }      
        }
        catch(PDOException $e)
        {
            $this->$error=$e->getMessage();
        }
    }

    function ObtenertipoUsuario($user){
        try{        
        $sql="SELECT ".CUSUARIO_TIPO." from ".TUSUARIO." WHERE ".CUSUARIO_NOMBRE."='".$user."'";
        //echo $sql;
        $resultado = $this->conecxion->query($sql);
        $list = $resultado->fetchAll();    
        //var_dump($list);
        $tipoUsuario = $list[0][0];//Obtenemos el tipo de usuario del array resultante de list  se puede apreciar en el var_dump($list);
       
            if(strcmp($tipoUsuario,"alumno")==0)
                return'alumno';
            else    
                return'empresa';     
       
                 
        }
        catch(PDOException $e)
        {
            $this->$error=$e->getMessage();
        }
    }



    //En base al usuario pasado buscamos su correo y filtramos en la tabla correo
    //select * from correo where remitente in(select email  from usuario where usuario='Maria') or destinatario in (select email  from usuario where usuario='Maria')order by fecha desc;
    function getcorreosEnviadosRecibidos($user){
        try
        {
            $sql="SELECT ".CCORREO_ID.",".CCORREO_REMITENTE.",".CCORREO_DESTINATARIO.",".CCORREO_FECHA.",".CCORREO_ASUNTO." FROM ".TCORREO. " WHERE ".CCORREO_REMITENTE." IN(SELECT ".CUSUARIO_EMAIL." FROM ".TUSUARIO." WHERE ".CUSUARIO_NOMBRE."='".$user."') OR ".CCORREO_DESTINATARIO." IN(SELECT ".CUSUARIO_EMAIL." FROM ".TUSUARIO." WHERE ".CUSUARIO_NOMBRE."='".$user."') ORDER BY ".CCORREO_FECHA;
            $resultado=$this->conecxion->query($sql);
            //echo $sql;     
            return $resultado;
        }
        catch (PDOException $e)
        {
            $this->$error=$e->getMessage();
        }
    }

   // Esta funcion muesta los destalles de un correo  los recibidos por un alumno
    function getDetalleDeUnCorreoRecibido($idCorreo){
        try
        {         
            $sql="SELECT ".CCORREO_ID.",".CCORREO_REMITENTE.",".CCORREO_DESTINATARIO.",".CCORREO_FECHA.",".CCORREO_ASUNTO.",".CCORREO_CONTENIDO." FROM ".TCORREO. " WHERE ".CCORREO_ID."=".$idCorreo;
            //echo $sql;
            $resultado=$this->conecxion->query($sql);                               
            return $resultado;        
        }
        catch (PDOException $e)
        {
            $this->$error=$e->getMessage();
        }
    }

    //Esta funcion obtiene el email del usuario conectado
    function getEmailUsuario($user){
        $sql="SELECT ".CUSUARIO_EMAIL." FROM ".TUSUARIO." WHERE ".CUSUARIO_NOMBRE."='".$user."'";
        //echo $sql;  
        $resultado=$this->conecxion->query($sql);
        $list = $resultado->fetchAll();    
        //var_dump($list);
        $emailUser = $list[0]['email'];//Obtenemos el correo del array resultante de list  se puede apreciar en el var_dump($list);
       
        return $emailUser;           
    }

     // Esta funcion muesta los correos enviados de el usuario conectado
     function getCorresEnviados($emailUsuario){
        try
        {        
            $sql="SELECT ".CCORREO_ID.",".CCORREO_REMITENTE.",".CCORREO_DESTINATARIO.",".CCORREO_FECHA.",".CCORREO_ASUNTO." FROM ".TCORREO. " WHERE ".CCORREO_REMITENTE." LIKE '".$emailUsuario."'";
            //echo $sql;
            $resultado=$this->conecxion->query($sql);                               
            return $resultado;        
            
        }
        catch (PDOException $e)
        {
            $this->$error=$e->getMessage();
        }
    }

    function getDatosUsuario($nombreUsuario)
    {
        //obtener los datos de la tabla alumno o de la tabla empresa
    }


    /*Funcion que evalua cuales son los correos de la tabla"correo",
    en los que el email de usuario aparece como remitente.
    En este caso el correo sera de envio devolvera "envio" en ROJO.
    En caso de que el remitente sea un correo de un usuario de tipo "Empresa"azul devolvera "Empresa" en AZUL.
    En caso de que no sea de empresa ni el email del usuario, devolvera "Recibido" en VERDE*/
    /*
select if(remitente='mariagarciamiralles@gmail.com','v','f') from correo where remitente='mariagarciamiralles@gmail.com';
Devuelve V si es verdad y f si es falso.
*/
    function getCorreoEmailRemitente($emailUsuario,$remitente){
        try
        {                 
            $resultadoFinal;
            $valor;         
            $sql="SELECT if('".$emailUsuario."'"."="."'".$remitente."','v','f')";
            //echo $sql;
            $resultado=$this->conecxion->query($sql);
            $list=$resultado->fetchAll();           
            $valor=$list[0][0];  
           
            if($valor=='v')//Si esto se cumple es que el email del remitente es el mismo que el del usuario
            {   //Osea mensaje ENVIADO     
                             
               $resultadoFinal=" <div class=\"correoEnviado\">ENVIADO</div>"; 
            }
            else
            {              
                //Comrpueba si el email como remitente es de alguna empresa Si lo es Devuelve "AZUL"
                //select if(tipoUsuario='empresa','v','f') from usuario where email in(select remitente from correo where remitente='TheHugoBoss@gmail.com');
                $sql="select if(".CUSUARIO_TIPO."='empresa','v','f') FROM ".TUSUARIO." WHERE ".CUSUARIO_EMAIL." IN(SELECT ".CCORREO_REMITENTE." FROM ".TCORREO." WHERE ".CCORREO_REMITENTE."='".$remitente."')";
                //echo $sql;
                $resultado=$this->conecxion->query($sql);
                $list=$resultado->fetchAll();
                $valor=$list[0][0];
                if($valor=='v')
                {
                   
                    $resultadoFinal=" <div class=\"correoEmpresa\">EMPRESA</div>"; 
                }
                else{ //Si no lo es devuelve "VERDE"
                    //RECIBIDO de un compañero
                    $resultadoFinal=" <div class=\"correoRecibido\">RECIBIDO</div>"; 
                }
               
            }
            return $resultadoFinal;        
            
        }
        catch (PDOException $e)
        {
            $this->$error=$e->getMessage();
        }
    }

    //Registro
    function insertNuevoUsuario($usuario,$password,$email,$tipoUsuario)
    {
        try
        {
            $sql="INSERT INTO ".TUSUARIO."(".CUSUARIO_NOMBRE.",".CUSUARIO_PASSWORD.",".CUSUARIO_EMAIL.",".CUSUARIO_TIPO.") VALUES "."('".$usuario."',password('".$password."'),'".$email."','".$tipoUsuario."')";
            $resultado=$this->conecxion->query($sql);
            if(strcmp($tipoUsuario,'alumno')==0)
            {
                echo "alumno!";
                $sql2="INSERT INTO ".TALUMNO."(".CALUMNO_USUARIOALUM.")VALUES('".$usuario."')";
                echo $sql2;
                $resultado2=$this->conecxion->query($sql2);

            }
            else{
                echo "empresa";
                $sql2="INSERT INTO ".TEMPRESA."(".CEMPRESA_USUARIOEMP.")VALUES('".$usuario."')";
                $resultado2=$this->conecxion->query($sql2);
            }
            //echo $sql;     
            return $resultado;
        }
        catch (PDOException $e)
        {
            $this->$error=$e->getMessage();
        }
    }
   
   
   
   
   
    /*
    //Funcion comodin para convertir una coleccion con un unico valor o consulta con un unico resultado
    en unico dato guardado ya en una variable
    function ExtraerResultadoUnico($coleccionBD,$campo)
    {
        $list=$coleccionBD->fetchAll();
        $resultado = $list[0][$campo];
        echo $resultado;
        return $resultado;
    }*/
    //PENDIENTE
    //INTENTANDO QUE DEVUELVA UN  UNICO RESULTADO
    //Ejemplo cogido de http://notasweb.com/articulo/php/obtener-un-campo-de-una-base-de-datos-mysql-en-php.html

}
?>