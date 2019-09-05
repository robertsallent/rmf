<?php 
/*
 FICHERO: core/libraries/Upload.php
 CLASE: Upload
 
 Clase para subir ficheros de forma fácil.
 Primero construiremos un nuevo objeto Upload con los parámetros deseados y luego
 llamaremos al método save().
 
 Existen algunos métodos estáticos para subir ficheros de algunos tipos de forma
 aún más simple.
 
 Dependencias: ---
 Autor: Robert Sallent
 Última revisión: 25/03/2019
 */

class Upload{

	//PROPIEDADES
	private $fichero;
	private $carpetaDestino;
	private $maxSize;     // tamaño máximo para el fichero (0 = sin límite)
	private $renombrar;   // indica si hay que generar un nombre aleatorio
	private $validar;     // indica si hay que validar el tipo del fichero con finfo
	private $mime;        // tipo MIME a validar por finfo
	
	private $nombreFinal=''; //nombre final que tendrá el fichero en el servidor
	private $rutaFinal=''; //ruta donde debe quedar ubicado finalmente el fichero
				
	
    //CONSTRUCTOR
    //RECIBE: fichero y carpeta de destino
    //RECIBE OPCIONALMENTE: tamaño máximo, si hay que renombrar, si hay que validar, tipo MIME
	public function __construct(array $fichero, string $carpetaDestino, int $maxSize=0, 
	                            bool $renombrar=true, bool $validar=false, string $mime='*'){
	    
		$this->fichero = $fichero;
		$this->carpetaDestino = $carpetaDestino; 
		$this->maxSize = $maxSize;
		$this->renombrar = $renombrar;
		$this->validar = $validar;
		$this->mime=$mime;
		
		//comprueba que no se produjeron errores en la subida
		$this->check(); 
				
		//comprobar que el fichero tiene el tipo MIME esperado
		if($this->validar) 
		    $this->valida();
		
		//recupera la extensión del fichero
		$extension = pathinfo($this->fichero['name'], PATHINFO_EXTENSION);
		
		//calcula el nuevo nombre
		if($this->renombrar)
			$this->nombreFinal = $this->generar_nombre($extension);
		else
			$this->nombreFinal = $this->fichero['name'];
		
		//calcula la ruta final a la que irá el fichero
		$this->rutaFinal = $this->carpetaDestino.''.$this->nombreFinal;
	}
	

	//método privado para comprobación de errores en la subida
	private function check(){
	    //control de errores en la subida de fichero
	    switch($this->fichero['error']){
	        case 0: break; //OK
	        case 1:
	        case 2: throw new Exception('El fichero es demasiado grande');
	        case 3: throw new Exception('El fichero se subió de forma parcial');
	        case 4: throw new Exception('No se indicó ningún fichero');
	        default: throw new Exception('Error en la subida del fichero');
	    }
	    
	    //comprobar que no supera el tamaño máximo
	    if($this->maxSize && $this->fichero['size']>$this->maxSize)
	        throw new Exception('El fichero supera el tamaño máximo'); 
	}
	
	
	//método privado que valida el tipo MIME del fichero
	private function valida(){
	    //recupera el tipo del fichero
	    $tipoReal = (new finfo(FILEINFO_MIME_TYPE))->file($this->fichero['tmp_name']);
	    
	    //ajustes para que no falle la expresión regular en la comprobación
	    $mimetmp=str_replace('*','',$this->mime); //quito el * (si lo tiene)
	    $mimetmp=preg_quote($mimetmp,'/');  //escapo los caracteres especiales
	    	    
	    //la comprobación se realiza mediante expresiones regulares
	    if(!preg_match("/^$mimetmp/i",$tipoReal)) 
	        throw new Exception("El fichero no es de tipo $this->mime");
	}
	
	//método para generar un nombre de fichero
	private static function generar_nombre(string $extension, string $prefijo='file_'):string{
	    //genera un nombre mediante un identificador único
	    $nombre=uniqid($prefijo);
	    
	    //retorna el nuevo nombre con la extensión (si se indicó)
	    return $extension? "$nombre.$extension" : $nombre;
	}
	
	
	//método para la subida de ficheros de cualquier tipo
	public function save():string{
        //mover de la ruta temporal a la ruta final
	    if(!move_uploaded_file($this->fichero['tmp_name'], $this->rutaFinal))
	        throw new Exception('Error al mover el fichero.');
	        	        
	    //retorna la ruta final donde se guardó el fichero
	    return $this->rutaFinal;
	}
	
	
    //MÉTODOS ESTATICOS QUE PERMITEN SUBIR FICHEROS DE ALGUNOS TIPOS DE FORMA SIMPLE
	//Método para subir cualquier tipo de imagen.
	public static function saveImage(array $fichero, string $carpetaDestino, int $maxSize=0, 
	                                 string $extension='*', bool $renombrar=true):string{
	    
	    //crea un nuevo Upload con los parámetros adecuados
	    $fichero=new self($fichero, $carpetaDestino, $maxSize, $renombrar, true, "image/$extension");
	    
	    //guarda el fichero en la carpeta de destino y retorna la ruta completa
	    return $fichero->save();
	}
	
	
	
	//Método para subir PDF
	public static function savePDF(array $fichero, string $carpetaDestino, int $maxSize=0, bool $renombrar=true):string{
	        
	        //crea un nuevo Upload con los parámetros adecuados
	        $fichero=new self($fichero, $carpetaDestino, $maxSize, $renombrar, true, "application/pdf");
	        
	        //guarda el fichero en la carpeta de destino y retorna la ruta completa
	        return $fichero->save();
	}
}
?>