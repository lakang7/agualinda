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


<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registro de Producción Diaria</title>
<style type="text/css">
.calendario{
	float:left;
	width:55.5%;
	margin-left:2%;
	margin-bottom:5px;	
}



.boton_cargar{
	float:left;
	width:7%;
	height:23px;
	/*border:1px solid #CCC;*/
	margin-left:1%;
	margin-bottom:5px;	
}

.subtitulo{
    float:left;
	margin:5px;
	width:96%;
	height:20px;
	margin-left:2%;
	margin-top:0px;	
	background:#0b67cd;
	border:1px solid #0b67cd;
	line-height:20px;
	color:#FFF;
	font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif; 
	font-size:12px;
	padding-left:5px;
	color:#F00;
}


.conte_agregar{
	float:left;
	margin-left:270px;
	/*border:1px solid #CCC;*/
	width:365px;
	height:25px;
	margin-bottom:5px;
}

.entrada_tabla{
	width:99%;
	margin:0px;
	float:left;
	border:0px;	
}

.columna{
	float:left;
	width:100px;
	height:20px;
	padding-left:5px;
	border:1px solid #CCC;	
	font-size:12px;
	line-height:20px;
	font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;	
	color:#666;	
}

.entrada_columna{
	position:absolute;
	height:20px;
	margin-left:-5px;
	border:0px;	
	text-align:right;
	padding-right:5px;
	font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;	
	color:#666;	
}


.resumenproduccion{
	position:absolute;
	width:26.3%;
	height:104px;
	border:1px solid #CCC;
	margin-bottom:5px;
	margin-top:-112px;
	margin-left:45.1%;	
}

.opcionresumenproduccion{
	float:left;
	width:33%;
	height:104px;
	border-right:1px solid #CCC;
	
}

.arribaresumen{
	float:left;
	width:100%;
	height:52px;
	border-bottom:1px solid #CCC;
}

.abajoresumen{
	float:left;
	width:100%;
	height:52px;	
}

.numero_resumen{
	float:left;
	width:100%;
	height:32px;
	line-height:32px;
	font-size:16px;
	text-align:center;
	font-family: 'Oswald', sans-serif; 		
	color:#666;
}

.titulo_resumen{
	float:left;	
	width:100%;
	height:20px;
	font-family: 'Oswald', sans-serif; 		
	color:#666;
	text-align:center;
	font-size:11px;	
	line-height:20px;
}


.numero_resumengran{
	float:left;
	width:100%;
	height:60px;
	line-height:60px;
	font-size:26px;
	text-align:center;
	font-family: 'Oswald', sans-serif;		
	color:#666;
}

.titulo_resumengran{
	float:left;	
	width:100%;
	height:39px;
	font-family: 'Oswald', sans-serif;	
	color:#666;
	text-align:center;
	font-size:11px;	
	
}

.boton_cargar{
	float:left;
	width:68px;
	height:23px;
	/*border:1px solid #CCC;*/
	margin-left:34%;
	margin-bottom:5px;	
}

.boton_guardar{
	position:absolute;
	width:68px;
	height:23px;
	/*border:1px solid #CCC;*/
	margin-left:73.5%;
	margin-top:68px;
	margin-bottom:5px;	
}


</style>

</head>

<body onload="ajustar()">
	<div class="barra1">
    	<div class="barra1_icon"><img src="../recursos/imagenes/CowLogo.PNG" width="45" height="40" /></div>
   	  	<div class="barra1_sistema">Sistema Para La Gestíón De La Industria Lactea</div>
	</div>
    <div class="barra2">
    	<div class="barra2_flecha"></div>                
        <div class="barra2_pantalla">Registro de Producción Diaria</div>
    </div>
    <div class="menu" id="menu">
    	<?php menu_interno(); ?>
    </div>
	<div class="cuerpo" id="cuerpo">

        <form name="formularioproduccion" id="formularioproduccion" method="post" action="../recursos/funciones/ajaxregistroproduccion.php?action=2">
        <input type="hidden" name="accion" id="accion" value="1" />
		<?php
			$con=Conectarse();
			$sql_elementos="select * from elementoanalisis order by idelementoanalisis";
			$acumula_examenes="";
			$acumula_requeridos="";
			$result_elementos = pg_exec($con,$sql_elementos);
			for($i=0;$i<pg_num_rows($result_elementos);$i++){
				$elemento = pg_fetch_array($result_elementos,$i);
				if($i==(pg_num_rows($result_elementos)-1)){
					$acumula_examenes=$acumula_examenes.str_replace(" ","_",$elemento[1]);
					$acumula_requeridos=$acumula_requeridos.$elemento[5];
				}else{
					$acumula_examenes=$acumula_examenes.str_replace(" ","_",$elemento[1])."-";
					$acumula_requeridos=$acumula_requeridos.$elemento[5]."-";
				}
				
			}
		?>
        <input type="hidden" name="examenes" id="examenes" value="<?php echo $acumula_examenes; ?>" />
        <input type="hidden" name="requeridos" id="requeridos" value="<?php echo $acumula_requeridos; ?>" />
        <input type="hidden" name="fecha" id="fecha" value="" />
    	
        <div id="arriba" style="float:left; width:100%">
        
        <div class="titulo-flotante">Producción Diaria</div>  
		<div id="dsel2" class="calendario" ></div>

        <div class="boton_cargar"><input type="button" value="Guardar" onclick="guardar()" style="font-size:12px;font-family: 'Oswald', sans-serif; line-height:14px; margin:0px; height:25px; width:70px;" /></div>                        
    	</div>
        
            <div class="boton_guardar">
            	
            </div>                        
   
        

        
        <div id="abajo" style="float:left">
        	<div id="actualiza" style="height:auto; float:right; margin-left:2%;"> 				
                
                                         	       
	      	</div>
        </div>
        
 	    </form>                   
                   
                   
                   
                                	                   
    </div>                
	<div class="pie"></div>
</body>
<script type="text/javascript">

  function actualiza_suero(id){
	  if(document.getElementById("cat_lit_"+id).value!=""){
		  var categorias = document.getElementById("generansuero").value.split("-");
		  var acumula=0;
		  for(var i=0;i<(categorias.length-1);i++){
			  if(document.getElementById("cat_lit_"+categorias[i]).value!=""){
				  acumula += parseFloat(document.getElementById("cat_lit_"+categorias[i]).value);
			  }			   
		  }
		  
		 document.getElementById("cat_lit_"+document.getElementById("usasuero").value).value = parseFloat(((acumula)*0.7)).toFixed(0);	  
		  		  
	  }
	   
  }

  function litrosxkg(id){
	  if(document.getElementById("cat_lit_"+id).value!="" && document.getElementById("cat_kg_"+id).value!=""){		  
		  document.getElementById("cat_litxkg_"+id).value=parseFloat((document.getElementById("cat_lit_"+id).value/document.getElementById("cat_kg_"+id).value)).toFixed(2);
	  }
  }
  
  function kgxuni(cat,pro){
	  
	  //alert(document.getElementById("lista"+cat).value);
	  if(document.getElementById("pro_uni_"+cat+"_"+pro).value!="" && document.getElementById("pro_kg_"+cat+"_"+pro).value!=""){		 	  	  document.getElementById("pro_kgxuni_"+cat+"_"+pro).value=parseFloat((document.getElementById("pro_kg_"+cat+"_"+pro).value/document.getElementById("pro_uni_"+cat+"_"+pro).value)).toFixed(2);		  
	  }
	  
	  if(document.getElementById("pro_kg_"+cat+"_"+pro).value){
		  var productos = document.getElementById("lista"+cat).value.split("-");
		  var acumula=0;
		  for(var i=0;i<(productos.length-1);i++){
			  //alert(productos[i]);
			  if(document.getElementById("pro_kg_"+cat+"_"+productos[i]).value!=""){
				  acumula += parseFloat(document.getElementById("pro_kg_"+cat+"_"+productos[i]).value);
			  }
			   
		  }
		  document.getElementById("cat_kg_"+cat).value = acumula;
		  
		  if(document.getElementById("cat_lit_"+cat).value!="" && document.getElementById("cat_kg_"+cat).value!=""){
			  document.getElementById("cat_litxkg_"+cat).value=parseFloat((document.getElementById("cat_lit_"+cat).value/document.getElementById("cat_kg_"+cat).value)).toFixed(2);			  
		  }
	  }
	  
	  
	  
  }  

  function ajustar(){	  
	  $("#menu").css("height", $("#cuerpo").css("height"));  
  }  

	
  var calendarPicker2 = $("#dsel2").calendarPicker({
    monthNames:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
    years:2,
    months:4,
    days:5,
    showDayArrows:true,
    callback:function(cal) {      
	  miFecha = new Date();
	  miFecha = cal.currentDate;
	 document.getElementById("fecha").value=miFecha.getFullYear()+"-"+(miFecha.getMonth()+1)+"-"+miFecha.getDate();
	 cargar();
    }});	
	
	function cargar(){
		if(document.getElementById("fecha").value==""){

			  miFecha = new Date();			  		
	  	      var fecha_aux=miFecha.getFullYear()+"-"+(miFecha.getMonth()+1)+"-"+miFecha.getDate();
			$("#actualiza").load("../recursos/funciones/ajaxregistroproduccion.php", {action: 1, fecha:fecha_aux, ruta:1},function(){
				$("input[type=button]").button()
					.click(function( event ) {
					event.preventDefault();
				});
				ajustar();			  
			});	
						
			
		}else{
	
			
			$("#actualiza").load("../recursos/funciones/ajaxregistroproduccion.php", {action: 1, fecha:document.getElementById("fecha").value, ruta:1},function(){
				$("input[type=button]").button()
					.click(function( event ) {
					event.preventDefault();
				});	
				ajustar();		  
			});										
		}		   
	}
	
	function guardar(){
		document.formularioproduccion.submit();
	}
   

</script>  

  <script type="text/javascript"> 
 	$("input[type=button]").button()
      .click(function( event ) {
        event.preventDefault();
      });	  	   		  
  </script>
</html>