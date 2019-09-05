<?php
/**
* FICHERO: core/libraries/DB.php
* CLASE: DB
* 
* DESCRIPCION
* Clase que simplifica la conexión con la BDD mediante PDO.
* Conecta a partir de la configuración del fichero Config.php.
* 
*  DEPENDENCIAS
* - app/config/Config.php
* 
* @author Robert Sallent
* @version 2019_11_07
* 
*/

class DB{ 
    //PROPIEDADES
    protected static $conexion=null; //contendrá la conexión con la BDD  
       
    //METODOS
    //Método que conecta/recupera la conexión
    public static function get():PDO{
        if(!self::$conexion){ //si no estábamos conectados...
            
            $config=Config::get(); //recupera la configuración
            //conecta con la BDD, si no puede lanzará una PDOException
            $dsn="$config->sgdb:host=$config->db_host;dbname=$config->db_name;charset=$config->db_charset";
            self::$conexion = new PDO($dsn, $config->db_user, $config->db_pass);
                
        }
        return self::$conexion; //retorna la conexión
    } 
    
    
    //Método para realizar consultas SELECT que retornan un registro
    //retorna un objeto del tipo indicado por parámetro
    public static function select(string $consulta, string $class='stdClass'){
        $resultado=self::get()->query($consulta);                
        return $resultado->rowCount()? $resultado->fetchObject($class): null;
    }
    
    //Método para realizar consultas SELECT que retornan múltiples registros
    //retorna un array de objetos del tipo indicado por parámetro
    public static function selectAll(string $consulta, string $class='stdClass'):array{
        $resultado=self::get()->query($consulta);
        
        $objetos=[];
        while($r=$resultado->fetchObject($class))
            $objetos[]=$r;
        
        return $objetos;
    } 
    
    //Método para realizar consultas INSERT
    //retorna el id del último objeto insertado o false si falla
    public static function insert(string $consulta){            
        if(!self::get()->query($consulta)) return false;
        return self::get()->lastInsertId();
    }     
    //Método para realizar consultas UPDATE
    //retorna el número de filas afectadas, o false si falla
    public static function update(string $consulta){
        $resultado=self::get()->query($consulta);
        return $resultado? $resultado->rowCount(): false;
    }
    //Método para realizar consultas DELETE
    //retorna el número de filas afectadas, o false si falla
    public static function delete(string $consulta){
        $resultado=self::get()->query($consulta);
        return $resultado? $resultado->rowCount(): false;
    } 
    
    // Método que ejecuta una consulta de totales sobre la tabla deseada
    public static function total(string $tabla, string $campo='*', string $operacion='COUNT'):int{
        $consulta = "SELECT $operacion($campo) AS total FROM $tabla";
        return self::select($consulta)->total;
    }
    
    //Método para escapar caracteres especiales
    //evitará inyección de scripts (versión para PDO)
    public static function escape(string $texto){
        return htmlspecialchars($texto);
    }
}

    
    