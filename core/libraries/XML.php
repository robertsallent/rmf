<?php		
/*
 FICHERO: core/libraries/XML.php
 CLASE: XML
 
 Clase con métodos útiles para exportar, importar y validar XML
 
 Dependencias: ---
 Autor: Robert Sallent
 Última revisión: 20/03/2018
 */

class XML{	
	//método que valida con DTD
    public static function validateWithDTD($fichero){
    	$dom = new DOMDocument();
    	$dom->load($fichero, LIBXML_DTDLOAD);
    	return $dom->validate();
    }

    //método que valida con XMLSchema
    public static function validateWithSchema($fichero, $esquema){
    	$dom = new DOMDocument();
    	$dom->load($fichero);
    	return $dom->schemaValidate($esquema);
    }
    
    //método que convierte un array de objetos en un XML
    //RECIBE:
    // - $lista: lista de objetos
    // - $root: nombre para la etiqueta del elemento raíz (opcional)
    // - $name: nombre para la etiqueta de cada elemento de la lista (opcional),
    // 	 si no se indica usa el nombre de la clase del elemento.
    // - $ns: namespace (opcional)
    
    //DEVUELVE: un String con el XML resultante.
    
    //convierte listas de cualquier tipo de objeto en XML.
    public static function toXML($lista, $root='root', $name='', $ns='http://ejemplo'){
        $xml = new DOMDocument("1.0", "utf-8");
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = true;
        
        $raiz = $xml->createElement($root); //crea el elemento raíz
        $raiz->setAttribute('xmlns', $ns); //pone el namespace
        
        foreach($lista as $objeto){ //para cada objeto de la lista
            $elemento = $xml->createElement($name?$name:get_class($objeto));
            
            foreach($objeto as $campo=>$valor) //para cada propiedad del objeto...
                $elemento->appendChild($xml->createElement($campo, $valor));
                
                $raiz->appendChild($elemento);
        }
        $xml->appendChild($raiz);
        return $xml->saveXML();
    }
    
    //Recupera objetos desde un XML
    public static function fromXML($origen, $clase='stdClass', $fichero=true){
        $xml=$fichero?simplexml_load_file($origen):simplexml_load_string($origen);
        
        $lista=[]; //lista de libros recuperados
        
        //para cada objeto que encontremos en el fichero...
        foreach($xml as $objetoXML){
            $objeto=new $clase(); //crea un nuevo objeto
            
            //mapea los datos del XML al objeto
            foreach($objetoXML as $campo=>$valor)
                $objeto->$campo=$valor;
                
                $lista[]=$objeto; //añade el objeto recuperado a la lista
        }
        return $lista;
    }
}
