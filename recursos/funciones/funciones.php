<?php  
    function fontStyles(){
		echo "<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>";
		echo "<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css' />";
	}
	
	function cssStyles(){
		echo "<link href='../recursos/css/plantilla.css' rel='stylesheet' type='text/css' />";
		echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css' />";		
		echo "<link rel='stylesheet' href='../recursos/js/chosen/chosen.css' />";
		echo "<link rel='stylesheet' href='../recursos/js/jquery.treeview.css' />";	
		echo "<link rel='stylesheet' href='../recursos/css/jquery.calendarPicker.css' type='text/css' media='screen'>";
	}
	
	function jquerys(){
		echo "<script src='../recursos/js/jquery-1.9.1.js'></script>";
		echo "<script src='../recursos/js/jquery-ui.js'></script>";
		echo "<script src='../recursos/js/jquery.treeview.js' type='text/javascript'></script>";
		echo "<script src='../recursos/js/chosen/chosen.jquery.js' type='text/javascript'></script>";
		echo "<script src='../recursos/js/jquery.calendarPicker.js' type='text/javascript' ></script>";
		echo "<script src='../recursos/js/jquery.mousewheel.js' type='text/javascript' ></script>";
		
		echo "<script type='text/javascript'>";
		echo "$(function() {";
		echo "$('#browser').treeview({";
		echo "collapsed: true,";
		echo "animated: 'fast'";
		echo "});";
		echo "});";
		echo "</script>";		
	}

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
	
	function InversaCodigo($codigo){
		$aux="";
		for($i=0;$i<strlen($codigo);$i++){
		    if($i>2){
			   $aux=$aux.$codigo[$i];	
			}
		}
		return $aux;
	}
	
	function PedirFecha(){
		$con=Conectarse();
		$sql_fecha=" select current_date; ";	
		$result_fecha = pg_exec($con,$sql_fecha);
		$fecha = pg_fetch_array($result_fecha,0);		
		return $fecha[0];
	}
	
	function PedirSemana(){
		$con=Conectarse();
		$fecha = PedirFecha();
		$sql_semana= "select * from semanas where '".$fecha."' >= desde and '".$fecha."' <= hasta ";
		$result_semana= pg_exec($con,$sql_semana);
		$semana = pg_fetch_array($result_semana,0);
		return $semana[0];	
	}
	
	function FormatoSemana($identificador){
		$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$orden = array('Primera','Segunda','Tercera','Cuarta','Quita','Sexta');
		$con=Conectarse();
		$sql_semana=" select * from semanas where idsemana='".$identificador."' ";
		$result_semana = pg_exec($con,$sql_semana);
		$semana=pg_fetch_array($result_semana,0);
		$retorna="Semana ".$semana[4]." del año / ".$orden[$semana[3]-1]." de ".$meses[$semana[2]-1]." / Desde ".$semana[5]." Hasta ".$semana[6]."";
		return $retorna;
	}
	
	function FormatoDia($dia){
		$con=Conectarse();
		$sql_selectFecha=" select  extract(dow from date('".$dia."')), extract(day from date('".$dia."')), extract(month from date('".$dia."')), extract(year from date('".$dia."'));";
		$result_SelectFecha=pg_exec($con,$sql_selectFecha);
		$fecha=pg_fetch_array($result_SelectFecha,0);
		$dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
		$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$variable = $dias[$fecha[0]]." ".$fecha[1]." de ".$meses[($fecha[2]-1)]." de ".$fecha[3];
		return $variable;
	}
	
	function FormatoFecha1($fecha_aux){
		$dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
		$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
		$con=Conectarse();
		$sql_formato="select extract(dow from date'".$fecha_aux."'), extract(day from date'".$fecha_aux."'), extract(month from date'".$fecha_aux."'), extract(year from date'".$fecha_aux."') ;";
		$result_formato = pg_exec($con,$sql_formato);
		$formato = pg_fetch_array($result_formato,0);
		$retorna=$dias[$formato[0]]." ".$formato[1]." de ".$meses[$formato[2]-1]." de ".$formato[3];
		return $retorna;		
	}
	
	
?>
     	<script type="text/javascript" language="javascript">
		    function redireccion(ruta){
				location.href=ruta;				
			}			
		</script>   
<?
	
	
	function menu_interno(){
		?>
        <div id="contienemenu" style="height:auto; position:absolute; width:19%; margin-left:1%;">
	<ul id="browser" class="filetree">
		<li><img src="../recursos/imagenes/folder.gif" /> Leche</span>
			<ul>
                <li><a href="../sistema/RutasDeRecoleccionDeLeche.php" ><img src="../recursos/imagenes/file.gif" /> Rutas de Recolección de Leche</a></li>
                <li><a href="../sistema/ProductoresDeLeche.php" ><img src="../recursos/imagenes/file.gif" /> Productores de Leche</a></li>
				<li><a href="../sistema/ViajeDeRuta.php" ><img src="../recursos/imagenes/file.gif" /> Viaje de Rutas</a></li>
			</ul>
		</li>
		<li><img src="../recursos/imagenes/folder.gif" /> Producción</span>
			<ul>
                <li><a href="../sistema/Productos.php" ><img src="../recursos/imagenes/file.gif" /> Productos</a></li>
                <li><a href="../sistema/RegistroDeProduccionDiaria.php" ><img src="../recursos/imagenes/file.gif" /> Produccion Diaria</a></li>
			</ul>
		</li>  
		<li><img src="../recursos/imagenes/folder.gif" /> Clientes</span>
			<ul>
                <li><a href="../sistema/Clientes.php" ><img src="../recursos/imagenes/file.gif" /> Clientes</a></li>
                <li><a href="../sistema/EntidadesBancarias.php" ><img src="../recursos/imagenes/file.gif" /> Entidades Bancarias</a></li>
			</ul>
		</li> 
		<li><img src="../recursos/imagenes/folder.gif" /> Ventas</span>
			<ul>
                <li><a href="../sistema/Venta.php" ><img src="../recursos/imagenes/file.gif" /> Realizar Venta</a></li> 
                <li><a href="../sistema/FacturarVenta.php" ><img src="../recursos/imagenes/file.gif" /> Facturar Venta</a></li>               
			</ul>
		</li>                 
		<li><img src="../recursos/imagenes/folder.gif" /> Reportes</span>
			<ul>
                <li><a href="../reportes/ReporteResumenRutasDeleche.php" ><img src="../recursos/imagenes/file.gif" /> Resumen Semanal Rutas y Productores</a></li>
                <li><a href="../reportes/ReporteResumenProduccionDiaria.php" ><img src="../recursos/imagenes/file.gif" /> Resumen Producción Diaria</a></li>                
                
			</ul>
		</li>               
	</ul>
    </div>	
    <?	
	}

?>
