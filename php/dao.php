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
    function conecxionAbierta()
    {
       
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

    function tipoUsuario($user)
    {
        try{
        $sql="SELECT ".CUSUARIO_TIPO." from ".TUSUARIO." WHERE ".CUSUARIO_NOMBRE."='".$user."'";
        //echo $sql;
        $resultado = $this->conecxion->query($sql);
        $list = $resultado->fetchAll();    
        //var_dump($list);
        $tipoUsuario = $list[0][0];//Obtenemos el correo del array resultante de list  se puede apreciar en el var_dump($list);
       
        return $tipoUsuario;
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