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
    //Devuelve especificamente el tipo de usuario
    function tipoUsuario2($user){
        try{
        $sql="SELECT ".CUSUARIO_TIPO." from ".TUSUARIO." WHERE ".CUSUARIO_NOMBRE."='".$user."'";
        //echo $sql;
        $resultado = $this->conecxion->query($sql);
        $list = $resultado->fetchAll();    
        //var_dump($list);
        $tipoUsuario = $list[0][0];//Obtenemos el tipo de usuario del array resultante de list  se puede apreciar en el var_dump($list);
       
            if(strcmp($tipoUsuario,"alumno")==0)
            {
                return "alumno";
            }
            else
            {
                return "empresa";
            
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
                //echo "alumno!";
                $sql2="INSERT INTO ".TALUMNO."(".CALUMNO_USUARIOALUM.")VALUES('".$usuario."')";
                //echo $sql2;
                $resultado2=$this->conecxion->query($sql2);

            }
            else{
                //echo "empresa";
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
//select email from usuario where email rlike '.*t.*' and tipoUsuario='alumno';

    function buscarEmail($emailAbuscar)
    {
        try{
            
        $sql="SELECT ".CUSUARIO_NOMBRE.",".CUSUARIO_EMAIL." FROM ".TUSUARIO." WHERE ".CUSUARIO_EMAIL." RLIKE '^".$emailAbuscar."' AND ".CUSUARIO_TIPO."='alumno'";
        //echo $sql;
        $resultado = $this->conecxion->query($sql);
        return $resultado;
        }
        catch(PDOException $e){
            $this->$error=$e->getMessage();
        }

    }
   /* insert into correo (remitente,destinatario,fecha,asunto,contenido)values
   ('mariagarciamiralles@gmail.com','estebangomezruiz@gmail.com','2019-03-22','esto es una prueba','contenido de correo paca');
*/ 
    function insercionMensaje($emailRemitente,$emailDestino,$asunto,$contenido)
    {
        try
        {
            $sql="INSERT INTO ".TCORREO."(".CCORREO_REMITENTE.",".CCORREO_DESTINATARIO.",".CCORREO_FECHA.",".CCORREO_ASUNTO.",".CCORREO_CONTENIDO.") VALUES "."('".$emailRemitente."','".$emailDestino."',curdate(),'".$asunto."','".$contenido."')";
            //echo $sql;
            $resultado=$this->conecxion->query($sql);
            return $resultado;

        }
        catch (PDOException $e)
        {
            $this->$error=$e->getMessage();
        }
        
    }

    function listarEmpresas()
    {
        try
        {
            $sql="SELECT ".CEMPRESA_NOMBRE.",".CEMPRESA_DIRECCION." FROM ".TEMPRESA;
            //echo $sql;
            $resultado=$this->conecxion->query($sql);
            return $resultado;

        }
        catch (PDOException $e)
        {
            $this->$error=$e->getMessage();
        }
        
    }

    function listarAlumnos($usuario)
    {
        try
        {
            //$sql="SELECT ".CALUMNO_USUARIOALUM.",".CALUMNO_NOMBRE.",".CALUMNO_APELLIDOS.",".CALUMNO_ANIOPROMOCION." FROM ".TALUMNO." WHERE ".CALUMNO_USUARIOALUM."!='".$usuario."'";
            $sql="select u.email,a.usuarioAlum,a.nombre,a.apellidos,a.anioPromocion from alumno a join usuario u on a.usuarioAlum=u.usuario HAVING a.usuarioAlum!='".$usuario."'";
            //echo $sql;
            $resultado=$this->conecxion->query($sql);
            return $resultado;

        }
        catch (PDOException $e)
        {
            $this->$error=$e->getMessage();
        }
        
    }
   //select a.usuarioAlum,a.nombre,a.apellidos,u.email from alumno a join usuario u on a.usuarioAlum=u.usuario having a.apellidos rlike '^.*Max Turbado.*';
//select a.usuarioAlum,a.nombre,a.apellidos,a.anioPromocion,u.email from alumno a join usuario u on a.usuarioAlum=u.usuario having a.apellidos rlike'^.*Max turbado.*' and a.anioPromocion=2017;

   function listarAlumnosParaEmp($apellidos,$anioPromocion)
   {
       try
       {
           if(empty($anioPromocion))
           {
            $sql="select a.usuarioAlum,a.nombre,a.apellidos,a.anioPromocion,u.email from alumno a join usuario u on a.usuarioAlum=u.usuario having a.apellidos rlike'^.*".$apellidos.".*'";
           }else if(empty($apellidos))
           {
            $sql="select a.usuarioAlum,a.nombre,a.apellidos,a.anioPromocion,u.email from alumno a join usuario u on a.usuarioAlum=u.usuario having a.anioPromocion=".$anioPromocion;
           }
           else
           {
            $sql="select a.usuarioAlum,a.nombre,a.apellidos,a.anioPromocion,u.email from alumno a join usuario u on a.usuarioAlum=u.usuario having a.apellidos rlike'^.*".$apellidos.".*' and a.anioPromocion=".$anioPromocion;
           }
           //echo $sql;
           $resultado=$this->conecxion->query($sql);
           return $resultado;

       }
       catch (PDOException $e)
       {
           $this->$error=$e->getMessage();
       }
       
   }
   function updatePerfilUsuario($usuario,$nombre,$apellidos,$anioPromocion,$trabajaEn,$fechaContrato)
   {
    try
    {
        //update alumno SET nombre='test1',anioPromocion='2009' where usuarioAlum='test1';
        if(!empty($trabajaEn)&& !empty($fechaContrato))
        {
            $sql="UPDATE ".TALUMNO." SET nombre='".$nombre."',apellidos='".$apellidos."',anioPromocion=".$anioPromocion.",trabajaEn='".$trabajaEn."',fechaContrato='".$fechaContrato."' WHERE ".CALUMNO_USUARIOALUM."='".$usuario."'";
        }else{
            $sql="UPDATE ".TALUMNO." SET nombre='".$nombre."',apellidos='".$apellidos."',anioPromocion=".$anioPromocion.",trabajaEn=NULL,fechaContrato=NULL WHERE ".CALUMNO_USUARIOALUM."='".$usuario."'";
        }
  
        //echo $sql;
        $resultado=$this->conecxion->query($sql);
        return $resultado;

    }
    catch (PDOException $e)
    {
        $this->$error=$e->getMessage();
    }
   }

   //PENDIENTE
   function updatePerfilEmpresa($usuario,$nombre,$direccion,$telefono,$nombreContacto)
   {
    try
    {
        //update alumno SET nombre='test1',anioPromocion='2009' where usuarioAlum='test1';
   
        $sql="UPDATE ".TEMPRESA." SET nombre='".$nombre."',direccion='".$direccion."',telefono='".$telefono."',nombreContacto='".$nombreContacto."' WHERE ".CEMPRESA_USUARIOEMP."='".$usuario."'";
         
        //echo $sql;
        $resultado=$this->conecxion->query($sql);
        return $resultado;

    }
    catch (PDOException $e)
    {
        $this->$error=$e->getMessage();
    }
   }
   
  
    
}
?>