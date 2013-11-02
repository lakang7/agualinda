<?php session_start(); 
	   require("recursos/funciones/funciones.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema Gestion Industria Lactia - Agua Linda </title>
<link href="recursos/css/estiloestructura.css" rel="stylesheet" type="text/css"  />
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700&amp;subset=latin,latin-ext" rel="stylesheet" type="text/css">
<script src="recursos/js/jquery-1.9.1.js" ></script>
<script src="recursos/js/jquery-1.9.1.min.js" ></script>
</head>

<body onload="inicializa()">
    <div class="banner"></div>
    <div class="cuerpo">
      <div class="menu">
  		<? menu(); ?>
  	  </div>
    
    	<div class="resumen_leche" id="actualizaleche">
            <input type="hidden" name="fecha_leche" id="fecha_leche" value="<?php echo PedirFecha(); ?>" />
        	<div class="resumen_titulo">Resumen Diario de Ingreso de Leche</div>
            <div class="resumen_fecha"><label id="fecha_observada"><?php echo FormatoFecha1(PedirFecha()); ?></label>
            	
       <div class="flecha_izquierda" onclick='atras_resumen_leche()' ><img src="recursos/imagenes/prev.png" width="6" height="10" style="margin-top:7px; margin-left:2px;" /></div>
       <div class="flecha_derecha"  onclick="adelante_resumen_leche()"><img src="recursos/imagenes/next.png" width="6" height="10" style="margin-top:7px; margin-left:2px;" /></div>
          
            </div>
             
        </div>
                                                                           
    </div>
	<div class="pie"></div>    
</body>
<script type="text/javascript" language="javascript">
	
	function inicializa_resumen_leche(){		
		$("#actualizaleche").load("recursos/funciones/ajaxindex.php", {action: 1, fecha:document.getElementById("fecha_leche").value, ira: 0});				
	}

	function adelante_resumen_leche(){		
		$("#actualizaleche").load("recursos/funciones/ajaxindex.php", {action: 1, fecha:document.getElementById("fecha_leche").value, ira: 2});				
	}
	
	function atras_resumen_leche(){		
		$("#actualizaleche").load("recursos/funciones/ajaxindex.php", {action: 1, fecha:document.getElementById("fecha_leche").value, ira: 1});				
	}	
	
	function inicializa(){
		inicializa_resumen_leche();
	}
	
</script>

</html>