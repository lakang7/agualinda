<?php  

	function Conectarse()
	{
	   if (!($conexion = pg_connect("dbname=gestionquesera port=5432 user=postgres password=jcglobal")))
	   {
	       echo "No pudo conectarse al servidor";
	       exit();
	   }
	    return $conexion;
	}	

	function Codigo($prefijo,$numero){
		$codigo=$prefijo;																
		if($numero>9999){
			$codigo=$codigo.$numero;	
		}else
		if($numero>999){
			$codigo=$codigo."0".$numero;	
		}else
		if($numero>99){
			$codigo=$codigo."00".$numero;	
		}else
		if($numero>9){
			$codigo=$codigo."000".$numero;	
		}else															
		if($numero>0){
			$codigo=$codigo."0000".$numero;	
		}
		return $codigo;			
	}

?>
