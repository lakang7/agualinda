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

.columa{
	float:left;
	height:20px;
	border-right:1px solid #CCC;
	font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
	line-height:20px;
	padding-left:1%;
	padding-right:1%;
	border-top:1px solid #CCC;		
}

.conParametros{
	float:left;
	width:96%;
	margin-left:2%;
	/*border:1px solid #CCC;*/
	height:55px;
}	

.Parametro{
	float:left;
	width:11%;
	height:50px;
	/*border-right:1px solid #CCC;*/
	margin-right:0.5%;	
}

.nombreParametro{
	float:left;
	width:100%;
	/*border-bottom:1px solid #CCC;*/
	height:20px;
	font-size:12px;
	line-height:20px;
	font-family: 'Oswald', sans-serif;	
}

.conteParametro{
	float:left;
	width:100%;
	height:30px;	
}

.entrada{
	position:absolute;
	margin:0px;
	width:7.2%;
	height:25px;
	padding-left:0.3%;	
}

.conReporte{
	float:left;
	width:96%;
	margin-left:2%;
	/*border:1px solid #CCC;*/
	height:auto;
	margin-top:10px;	
}	

.ui-widget { font-family: Verdana,Arial,sans-serif; font-size: .7em; }

</style>
<script type="text/javascript" language="javascript">

    $(function() {
    	$( "#desde" ).datepicker({
			showWeek: true,
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
		 	closeText: 'Cerrar',
            prevText: '<Ant',
      		nextText: 'Sig>',
	        currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm'	 						
		});
		$( "#hasta" ).datepicker({
			showWeek: true,
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
		 	closeText: 'Cerrar',
            prevText: '<Ant',
      		nextText: 'Sig>',
	        currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm'						
		});
    });
  </script>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Resumen Semanal de Productor</title>
</head>

<body onload="inicializa_resumen_ruta()">
	<div class="barra1">
    	<div class="barra1_icon"><img src="../recursos/imagenes/CowLogo.PNG" width="45" height="40" /></div>
   	  	<div class="barra1_sistema">Sistema Para La Gestíón De La Industria Lactea</div>
	</div>
    <div class="barra2">
    	<div class="barra2_flecha"></div>                
        <div class="barra2_pantalla">Resumen Semanal de Productor</div>
    </div>
    <div class="menu" id="menu">
    	<?php menu_interno(); ?>
    </div>
	<div class="cuerpo" id="cuerpo">
  		<div class="conParametros" style="border-bottom:1px solid #CCC">
        	<div class="Parametro" >
            	<div class="nombreParametro">
                	Desde
                </div>
                <div class="conteParametro">
                	<input type="text" name="desde" id="desde" class="entrada"  />
                </div>
            </div>
            <div class="Parametro">
            	<div class="nombreParametro">
                	Hasta
                </div> 
                <div class="conteParametro">
                	<input type="text" name="hasta" id="hasta" class="entrada"  />
                </div>                           
            </div>
            <div class="Parametro" style="width:40%">
            	<div class="nombreParametro">
                	Productor
                </div>
                <div class="conteParametro">
		           <select data-placeholder="Seleccione el productor.." name="productores" id="productores" style="width:100%;" class="chzn-select" >
		               <option value="0"></option>
                       <option value="-1">Todos Los Productores</option>
		               <?php								     
			           $sql_select_productores="select * from productor order by nombreproductor ASC";
			           $result_select_productores = pg_exec($con,$sql_select_productores);
					   for($i=0;$i<pg_num_rows($result_select_productores);$i++){
					       $productor=pg_fetch_array($result_select_productores,$i);
						   echo "<option value=".$productor[0].">".$productor[3]."</option>"; 										 										
					   }
			   		   ?>
		           </select>                  
                </div>            
            </div>
            
            <div class="Parametro" style="width:8%; margin-left:1%">
            	<div class="nombreParametro">
                </div> 
                <div class="conteParametro">
                	<input type="submit" style="font-size:10px;font-family: 'Oswald', sans-serif;" name="reportar" id="reportar" value="Generar Reporte" />
                </div>                           
            </div>                                                                    
        </div>
        
        <div class="conReporte" id="conReporte">                      
        </div>
        
    </div>                  
	<div class="pie"></div>
</body>

<script type="text/javascript" language="javascript">

  $(function() {
    $( "input[type=submit]" )
      .button()
      .click(function( event ) {
        event.preventDefault();
      });
  });
  
	$("#productores").chosen({no_results_text: "No se han encontrado resultados para: "});
	function ajustar(){	  
		$("#menu").css("height", $("#cuerpo").css("height"));  
	} 
	
	$(function(){
	    $("#reportar").click(function(){
			var band=0;
			if(document.getElementById("desde").value=="" && band==0){
				alert("Debe indicar la fecha desde la que desea consultar.");
				band=1;
			}
			
			if(document.getElementById("hasta").value=="" && band==0){
				alert("Debe indicar la fecha hasta la que desea consultar.");
				band=1;
			}
			
			if(document.getElementById("productores").value==0 && band==0){
				alert("Debe indicar el productor que desea consultar.");
				band=1;
			}	
			
			if(band==0){
				$("#conReporte").load("../recursos/funciones/ajaxreportesemanalProductor.php", {action: 1, desde:document.getElementById("desde").value, hasta: document.getElementById("hasta").value, productor: document.getElementById("productores").value},function(){
					ajustar();														
				});					
			}
								
		});		
	});	
	
  function ajustar(){	  
	  $("#menu").css("height", $("#cuerpo").css("height"));  
  }  	
		
</script>

</html>