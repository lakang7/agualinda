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

?>
