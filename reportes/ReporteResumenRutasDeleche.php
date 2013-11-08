<?php session_start(); 
      require("../recursos/funciones/funciones.php");
	  $con=Conectarse();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	fontStyles();
	cssStyles();
	jquerys();
?>

<style type="text/css">
.reporte_leche{
	float:left;
	margin-left:2%;
	width:auto;
	height:auto;	
	width:96%;
}

.Reporte-titulo{	
	padding-left:1%;
    float:left;
	width:99%;
	height:30px;
	background:#61380a;
	border:1px solid #21A010;
	font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	color:#FFF;
	line-height:30px;
	font-size:14px;	
	border-color: #0b67cd;		
	background:#0b67cd;
	margin-left:0px;
	margin-top:5px;
}

.Reporte-fecha{
    float:left;
	width:100%;
	height:25px;
	border:1px solid #CCC;
	line-height:25px;
	font-size:12px;	
	border-bottom:1px solid #CCC;			
	margin-left:0px;
	text-align:center;
	font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	font-weight:900;
	margin-bottom:15px;	
}

.Reporte-flecha_izq{
	position:absolute;
    margin:0px;
	width:10px;
	height:25px;
	cursor:pointer;	
	margin-top:-25px;
}

.Reporte-flecha_der{
	position:absolute;
    margin:0px;
	width:10px;
	height:25px;
	cursor:pointer;	
	margin-top:-25px;
	margin-left:76%;
}

.resumen_numeros{
	float:left;
	width:590px;
	height:70px;
	border-bottom:1px solid #CCC;	
	
}

.resumen_numeros2{
	float:left;
	width:590px;
	height:70px;
	border-bottom:1px solid #CCC;
	font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	font-size:24px;	
	line-height:70px;
	text-align:center;	
	color:#333;		
}

.resumen_numero{
	float:left;
	width:117px;
	height:70px;
	border-right:1px solid #CCC;	
}

.resumen_numero_arriba{
	float:left;
	width:117px;
	height:50px;
	font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	font-size:24px;	
	line-height:50px;
	text-align:center;	
	color:#333;	
}

.resumen_numero_abajo{
	float:left;
	width:117px;
	height:20px;
	font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;	
	line-height:20px;
	text-align:center;	
	color:#333;	
}

.resumen_titulo2{
	float:left;
	width:585px;
	height:22px;
	line-height:20px;
	font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;	
	padding-left:5px;
	border-bottom:1px solid #CCC;
	background:#F9F9F9;
}

.resumen_columna{
	float:left;
	height:22px;
	border-right:1px solid #CCC;	
	padding-left:5px;	
}

.resumen_columna2{
	float:left;
	height:22px;
	border-right:1px solid #CCC;	
	padding-right:5px;
	text-align:right;	
}

.resumen_columna_detalle{
	float:left;
	width:585px;
	height:22px;
	line-height:20px;
	font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;	
	padding-left:5px;
	border-bottom:1px solid #CCC;
}

.rl_linea{
	float:left;
	width:100%;
	height:20px;
	margin-left:0px;
	/*border-bottom:1px solid #CCC;*/
	border-left:1px solid #CCC;	
}

.rl_linea_transporte{
	float:left;
	width:51%;
	height:20px;
	margin-left:49%;
	border-bottom:1px solid #CCC;
	border-left:1px solid #CCC;	
}

.rl_linea_total{
	float:left;
	width:22.2%;
	height:20px;
	margin-left:77.8%;
	border-bottom:1px solid #CCC;
	border-left:1px solid #CCC;	
}

.rl_total{
	background:#CCC;
	float:left;
	width:262px;
	height:20px;
	margin-left:663px;
	border-bottom:1px solid #CCC;
	border-left:1px solid #CCC;	
	border-top:1px solid #CCC;	
}

.rl_columna{
	float:left;
	height:20px;
	border-right:1px solid #CCC;
	padding-left:5px;
	padding-right:5px;
	line-height:20px;
	font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	font-size:70%;	
		
}



</style>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Resume Semanal Rutas y Productores</title>
</head>

<body onload="inicializa_resumen_ruta()">
	<div class="barra1">
    	<div class="barra1_icon"><img src="../recursos/imagenes/CowLogo.PNG" width="45" height="40" /></div>
   	  	<div class="barra1_sistema">Sistema Para La Gestíón De La Industria Lactea</div>
	</div>
    <div class="barra2">
    	<div class="barra2_flecha"></div>                
        <div class="barra2_pantalla">Resume Semanal Rutas y Productores</div>
    </div>
    <div class="menu" id="menu">
    	<?php menu_interno(); ?>
    </div>
	<div class="cuerpo" id="cuerpo">

	<div class="reporte_leche" id="reporte_leche"  >
		
        <input type="hidden" name="semana_leche" id="semana_leche" value="<?php echo PedirSemana(); ?>" />
        <div class="Reporte-titulo">Resumen Semanal Rutas y Productores</div>
<div class="Reporte-fecha"><label><?php echo FormatoSemana(PedirSemana()); ?></label>
        	<div class="Reporte-flecha_izq" onclick="atras_resumen_ruta()"><img src="../recursos/imagenes/prev.png" style="margin-left:2px; margin-top:7px;" width="6" height="10" /></div>
            <div class="Reporte-flecha_der" onclick="adelante_resumen_ruta()"><img src="../recursos/imagenes/next.png" style="margin-right:2px; margin-top:7px;" width="6" height="10" /></div>
        </div>
        
        <div id="reporte" style="float:left; width:100%;">                                                                             
        </div><!--finaliza reporte -->        
        
                
	</div>

  
    </div>                  
	<div class="pie"></div>
</body>

<script type="text/javascript" language="javascript">

	function ajustar(){	  
		$("#menu").css("height", $("#cuerpo").css("height"));  
	} 
	
	function inicializa_resumen_ruta(){		
		$("#reporte_leche").load("../recursos/funciones/ajaxresumenRutaLeche.php", {action: 1, semana:document.getElementById("semana_leche").value, ira: 0},function(){
			ajustar();	
		});				
	}

	function adelante_resumen_ruta(){	
		$("#reporte_leche").load("../recursos/funciones/ajaxresumenRutaLeche.php", {action: 1, semana:document.getElementById("semana_leche").value, ira: 2},function(){
			ajustar();	
		});				
	}
	
	function atras_resumen_ruta(){	
		$("#reporte_leche").load("../recursos/funciones/ajaxresumenRutaLeche.php", {action: 1, semana:document.getElementById("semana_leche").value, ira: 1},function(){
			ajustar();	
		});				
	}	
	
</script>

</html>