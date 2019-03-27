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
define("CALUMNO_EMAIL","email");
define("CALUMNO_ESTADOLABORAL","estadoLaboral");
define("CALUMNO_TRABAJAEN","trabajaEn");
define("CALUMNO_FECHACONTRATO","fechaContrato");

//Tabla Empresa
define ("TEMPRESA", "empresa");
define ("CEMPRESA_USUARIOEMP", "usuarioEmp");
define ("CEMPRESA_NOMBRE","nombre");
define ("CEMPRESA_DIRECCION","direccion");
define ("CEMPRESA_TELEFONO","telefono");
define ("CEMPRESA_email","email");
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
    function isConnected()
    {
        return isset($this->conecxion);
    }

    //Funcion que compruebasi existe el usuario en la tabla User
    function validarUsuario($user,$password){
        $sql="SELECT * FROM ".TUSUARIO." WHERE ".CUSUARIO_NOMBRE."='".$user."' AND ".CUSUARIO_PASSWORD." =password('".$password."')";
        //echo $sql;  
        $statement=$this->conecxion->query($sql);
        if($statement->rowCount()==1)      
            return true;
        else
        return false;

    }

    function tipoUsuario($user,$password)
    {
        try{
        $sql="SELECT ".CUSUARIO_TIPO." from ".TUSUARIO." WHERE ".CUSUARIO_NOMBRE."='".$user."' AND ".CUSUARIO_PASSWORD." =password('".$password."')";
        //echo $sql;
        $resultado = $this->conecxion->query($sql);
        return $resultado;
        }
        catch(PDOException $e)
        {
            $this->$error=$e->getMessage();
        }
    }

    //En base al usuario pasado buscamos su correo y filtramos en la tabla correo
    //select * from correo where remitente in(select email  from usuario where usuario='Maria') or destinatario in (select email  from usuario where usuario='Maria')order by fecha desc;
    function getcorreoAlum($user){
        try
        {
            //Pendiente de terminar la subconsulta de SQL donde preguntamos por el email del usuario en la tabla usuario
            $sql="SELECT".CCORREO_ID.",".CCORREO_REMITENTE.",".CCORREO_FECHA.",".CCORREO_ASUNTO."FROM ".TCORREO;
            $resultset=$this->conecxion->query($sql);
            //echo $sql; 
            
            return $resultset;
        }
        catch (PDOException $e)
        {
            $this->$error=$e->getMessage();
        }
    }

    function getAbsences(){
        try{
            $sql = "SELECT * FROM ".TABLE_ABSENCE;
            //echo $sql;
            $resultset = $this->conecxion->query($sql);
            return $resultset;
        }catch(PDOException $e){
            $this->error=$e->getMessage();
        }
    }

    function getAbsencesFrom($idStudent){
        try{
            $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_ID_STUDENT. " = ".$idStudent;
            //echo $sql;
            $resultset = $this->conecxion->query($sql);
            return $resultset;
        }catch(PDOException $e){
            $this->error=$e->getMessage();
        }
    }

//Recibe todos los datos
//Devuelve las faltas de un determinado alumno en un rango de fechas en  un determinado modulo
//select  * from (select * from falta where date>="2019-02-15" and date<="2019-02-20")as d where id_alumno=1 and id_modulo=1;
    function getAbsencesFromDateRanged($idStudent,$fechadesde,$fechahasta,$modulo){      
        try{
            $sql = "SELECT * FROM (SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_DATE.">='".$fechadesde."' AND ".COLUMN_DATE."<='".$fechahasta."')AS d WHERE ".COLUMN_ID_STUDENT."=".$idStudent." AND ".COLUMN_ID_MODULO."=".$modulo;
            //echo $sql;
            $resultset = $this->conecxion->query($sql);
            return $resultset;
        }catch(PDOException $e){
            $this->error=$e->getMessage();
        }
    }


//PRUEBA ------
//Todo menos modulo
// SELECT * FROM (SELECT * FROM falta WHERE date>='2019-02-15' AND date<='2019-02-22')AS d WHERE id_alumno=1;
function getAbsencesFromDateRangedNoModulo($idStudent,$fechadesde,$fechahasta){      
    try{
        $sql = "SELECT * FROM (SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_DATE.">='".$fechadesde."' AND ".COLUMN_DATE."<='".$fechahasta."')AS d WHERE ".COLUMN_ID_STUDENT."=".$idStudent;
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}
//Todo menos fecha hasta
// select  * from falta where date>="20190215" and id_alumno=1 and id_modulo=1;
function getAbsencesFromDateRangedNoFechaHasta($idStudent,$fechadesde,$modulo){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_DATE.">='".$fechadesde."' AND ".COLUMN_ID_STUDENT."=".$idStudent." AND ".COLUMN_ID_MODULO."=".$modulo;
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}
//Todo menos fecha desde
//select  * from falta where date<="20190215" and id_alumno=1 and id_modulo=1;
function getAbsencesFromDateRangedNoFechaDesde($idStudent,$fechahasta,$modulo){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_DATE."<='".$fechahasta."' AND ".COLUMN_ID_STUDENT."=".$idStudent." AND ".COLUMN_ID_MODULO."=".$modulo;
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}

//Todo menos ID
//select  * from falta where date>="20190215" and date<="20190221" and id_modulo=1;
function getAbsencesFromDateRangedNoId($fechadesde,$fechahasta,$modulo){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_DATE.">='".$fechadesde."' AND ".COLUMN_DATE."<='".$fechahasta."' AND ".COLUMN_ID_MODULO."=".$modulo;
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}
//Solo Fecha hasta
function getAbsencesFromDateRangedOnlyFechaHasta($fechahasta){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_DATE."<='".$fechahasta."'";
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}
//Solo Fecha hasta e ID
function getAbsencesFromDateRangedFechaHastaId($idStudent,$fechahasta){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_DATE."<='".$fechahasta."' AND ".COLUMN_ID_STUDENT."=".$idStudent;
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}

//Solo Fecha hasta, Modulo
function getAbsencesFromDateRangedFechaHastaModulo($fechahasta,$modulo){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_DATE."<='".$fechahasta."' AND ".COLUMN_ID_MODULO."=".$modulo;
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}
//Solo Fecha desde
function getAbsencesFromDateRangedOnlyFechaDesde($fechadesde){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_DATE.">='".$fechadesde."'";
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}
//Solo Fecha desde y Modulo
function getAbsencesFromDateRangedFechaDesdeModulo($fechadesde,$modulo){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_DATE.">='".$fechadesde."' AND ".COLUMN_ID_MODULO."=".$modulo;
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}
//Solo damos Fecha desde y Fecha hasta
//select  * from falta where  date>="20190215" and date<="20190221";
function getAbsencesFromDateRangedFechaDesdeHasta($fechadesde,$fechahasta){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_DATE.">='".$fechadesde."' AND ".COLUMN_DATE."<='".$fechahasta."'";
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}

//Solo ID y Fecha desde
function getAbsencesFromDateRangedIdFechaDesde($idStudent,$fechadesde){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_DATE.">='".$fechadesde."' AND ".COLUMN_ID_STUDENT."=".$idStudent;
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}


//Solo ID
//SELECT * FROM falta WHERE id_alumno=1;
//Realizado mas arriva en getAbsencesFrom($idStudent)

//SOlo ID  y Modulo
function getAbsencesFromIdModulo($idStudent,$modulo){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_ID_STUDENT."=".$idStudent." AND ".COLUMN_ID_MODULO."=".$modulo;
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}

//Solo ID  y Fecha hasta
function getAbsencesFromIdFechaHasta($idStudent,$fechahasta){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_ID_STUDENT."=".$idStudent." AND ".COLUMN_DATE."<='".$fechahasta."'";
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}

//Solo ID  y Fecha Desde
function getAbsencesFromIdFechaDesde($idStudent,$fechadesde){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_ID_STUDENT."=".$idStudent." AND ".COLUMN_DATE.">='".$fechadesde."'";
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}

//Solo Modulo 
function getAbsencesFromModulo($modulo){      
    try{
        $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_ID_MODULO."=".$modulo;
        //echo $sql;
        $resultset = $this->conecxion->query($sql);
        return $resultset;
    }catch(PDOException $e){
        $this->error=$e->getMessage();
    }
}

//---

}
?>