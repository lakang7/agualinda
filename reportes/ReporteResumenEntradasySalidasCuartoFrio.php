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

.linea{
	float:left;
	width:100%;
	height:20px;
	border:0px solid #CCC;
	border-left:1px solid #CCC;
	font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	line-height:20px;
	font-size:11px;	
	line-height:20px;
}

.linea:hover{
	float:left;
	width:100%;
	height:20px;
	border:0px solid #CCC;
	border-left:1px solid #CCC;
	font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	line-height:20px;
	font-size:11px;	
	line-height:20px;
	background:#E9E9E9;
}

.columa{
	float:left;
	height:20px;
	border-right:1px solid #CCC;
	font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
	line-height:20px;
	padding-left:1%;
	padding-right:1%;
	border-bottom:1px solid #CCC;		
}



</style>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Resumen Producción Diaria</title>
</head>

<body onload="inicializa_resumen_ruta()">
	<div class="barra1">
    	<div class="barra1_icon"><img src="../recursos/imagenes/CowLogo.PNG" width="45" height="40" /></div>
   	  	<div class="barra1_sistema">Sistema Para La Gestíón De La Industria Lactea</div>
	</div>
    <div class="barra2">
    	<div class="barra2_flecha"></div>                
        <div class="barra2_pantalla">Resumen Entradas y Salidas Cuarto Frio </div>
    </div>
    <div class="menu" id="menu">
    	<?php menu_interno(); ?>
    </div>
	<div class="cuerpo" id="cuerpo">

	<div class="reporte_leche" id="reporte_produccion"  >
		<?php
			$sql_selectHoy=" select current_date, extract(dow from current_date), extract(day from current_date), extract(month from current_date), extract(year from current_date);";
			$result_selectHoy=pg_exec($con,$sql_selectHoy);
			$hoy=pg_fetch_array($result_selectHoy,0);		
		?>
        <input type="hidden" name="dia_produccion" id="dia_produccion" value="<?php echo $hoy[0];?>" />
        <div class="Reporte-titulo">Resumen Entradas y Salidas Cuarto Frio </div>
<div class="Reporte-fecha"><label><?php echo FormatoDia($hoy[0]); ?></label>
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
		$("#reporte_produccion").load("../recursos/funciones/ajaxReporteResumenEntradasySalidasCuartoFrio.php", {action: 1, dia:document.getElementById("dia_produccion").value, ira: 0},function(){
			ajustar();	
		});				
	}

	function adelante_resumen_ruta(){	
		$("#reporte_produccion").load("../recursos/funciones/ajaxReporteResumenEntradasySalidasCuartoFrio.php", {action: 1, dia:document.getElementById("dia_produccion").value, ira: 2},function(){
			ajustar();	
		});				
	}
	
	function atras_resumen_ruta(){	
		$("#reporte_produccion").load("../recursos/funciones/ajaxReporteResumenEntradasySalidasCuartoFrio.php", {action: 1, dia:document.getElementById("dia_produccion").value, ira: 1},function(){
			ajustar();	
		});				
	}	
	
</script>

</html>