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
<title>Viaje de Ruta de Recolección de Leche</title>

<style type="text/css">
.calendario{
	float:left;
	width:55.5%;
	margin-left:2%;
	margin-bottom:5px;	
}

.ruta{
	float:left;
	width:30%;
	height:25px;
	/*border:1px solid #CCC;*/
	margin-left:5px;
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
.detalleviaje{
	float:right;
	width:34.5%;
	height:75px;
	border:1px solid #CCC;
	margin-right:6.5%;
	margin-bottom:5px;	
	margin-top:-80px;
}

.conte_detalle{
	float:left;
	width:19.7%;
	height:75px;
	border-right:1px solid #CCC;	
}

.conte_detalle_numero{
	float:left;
	width:100%;
	height:50px;
	line-height:50px;
	font-family: 'Oswald', sans-serif;
	text-align:center;
	font-size:18px;
	color:#666;
	margin-left:0px;

}

.conte_detalle_describe{
	float:left;
	width:100%;
	height:25px;
	line-height:12px;
	font-family: 'Oswald', sans-serif;
	text-align:center;
	font-size:11px;
	color:#666;
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
}

.subcomponente{
    float:left;
	margin:5px;
	width:96%;
	height:auto;
	margin-left:2%;
	margin-top:0px;	
	border:1px solid #CCC;	
	padding-left:5px;
	padding-bottom:5px;
}

.subconte{
	float:left;	
	width:16%;
	height:35px;
	/*border:1px solid #CCC;*/	
	margin-top:5px;
	margin-right:5px;
}

.subcontearriba{
    float:left;
	width:100%;
	height:15px;
	line-height:15px;
	font-family: 'Oswald', sans-serif;	
	font-size:12px;
	color:#333;
}

.subconteabajo{
    float:left;
	width:100%;
	height:20px;
}

.subentrada{
	position:absolute;
	margin:0px;
	width:12.3%;
	font-size:12px;	
}

.tablaproductores{
	float:left;
	margin:0px;	
	border-collapse: collapse;
	margin-bottom:5px;
	border:1px solid #999;
	margin-left:20px;
	width:96%;
}

.celda_cabecera{
	padding-left:5px;
	padding-right:5px;
	text-align:center;	
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

</style>

</head>

<body onload="ajustar()">
	<div class="barra1">
    	<div class="barra1_icon"><img src="../recursos/imagenes/CowLogo.PNG" width="45" height="40" /></div>
   	  	<div class="barra1_sistema">Sistema Para La Gestíón De La Industria Lactea</div>
	</div>
    <div class="barra2">
    	<div class="barra2_flecha"></div>                
        <div class="barra2_pantalla">Viaje de Ruta de Recolección de Leche</div>
    </div>
    <div class="menu" id="menu">
    	<?php menu_interno(); ?>
    </div>
	<div class="cuerpo" id="cuerpo">
    	 
        <form name="formularioviaje" id="formularioviaje" method="post" action="../recursos/funciones/ajaxviajesruta.php?action=3">
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
    	<div class="titulo-flotante">Viajes Ruta de Recolección</div>  
		<div id="dsel2" class="calendario" ></div>
        <div class="ruta">
           <select data-placeholder="Seleccione la ruta.." name="rutas" id="rutas" style="width:100%;" class="chzn-select" >
               <option value="0"></option>
               <?php								     
	           $sql_select_rutas="select * from ruta order by nombreruta ASC";
	           $result_select_rutas = pg_exec($con,$sql_select_rutas);
			   for($i=0;$i<pg_num_rows($result_select_rutas);$i++){
			       $ruta=pg_fetch_array($result_select_rutas,$i);
				   echo "<option value=".$ruta[0].">".$ruta[1]."</option>"; 										 										 
			   }
			   ?>
           </select>        
        </div>
        <div class="boton_cargar"><input type="button" value="Cargar" onclick="cargar()" style="font-size:12px;font-family: 'Oswald', sans-serif; line-height:14px; margin:0px; height:25px; width:70px;" /></div>                        
    	
        	<div id="actualiza" style="height:auto; float:left; margin-left:0px;"> 

        
        
        	       
	      	</div>
	    </form>         
         
         
         
    </div>                   
	<div class="pie"></div>
</body>
<script type="text/javascript" language="javascript">  
  function ajustar(){	  
	  $("#menu").css("height", $("#cuerpo").css("height"));  
  }  

   function cargar(){
	   if(document.getElementById("rutas").value==0){
		   alert("Debe seleccionar primero una ruta.");	   
	   }else{
		  $("#actualiza").load("../recursos/funciones/ajaxviajesruta.php", {action: 1, fecha:document.getElementById("fecha").value, ruta:document.getElementById("rutas").value},function(){
			  ajustar();
			  $("#productores").chosen({no_results_text: "No se han encontrado resultados para: "});
 			  $("input[type=button]").button()
              .click(function( event ) {
                event.preventDefault();
              });			  
		  });	   
	   }
	   
   }
   
   function agregar(){	   	  

       if(document.getElementById("productores").value==0){
		   alert("Debe seleccionar primero un productor para agregar a la ruta.");			   
	   }else{
	   	var tds = '<tr style="font-family: Oswald, sans-serif; font-size:12px;">';
		tds += '<td style="padding-left:5px;">'+$("#productores option[value='"+document.getElementById("productores").value+"']").text()+'</td>';
		tds += '<td><input type="text" class="entrada_tabla" id="litros-'+document.getElementById("productores").value+'" name="litros-'+document.getElementById("productores").value+'"  /></td>';
		
		var examenes = document.getElementById("examenes").value;		
		tipos_examenes = examenes.split("-");	
		for(var i=0;i<tipos_examenes.length;i++){
		tds += '<td><input type="text" class="entrada_tabla" id="'+tipos_examenes[i]+'-'+document.getElementById("productores").value+'" name="'+tipos_examenes[i]+'-'+document.getElementById("productores").value+'" /></td>'; 
		}						   
  	   tds += '</tr>';
		   $("#tabla_productores").append(tds);	
		   document.getElementById("listaproduc").value = document.getElementById("listaproduc").value+document.getElementById("productores").value+'-';
		   $("#conte_agregar").load("../recursos/funciones/ajaxviajesruta.php", {action: 2, usados:document.getElementById("listaproduc").value, ruta:document.getElementById("rutas").value,fecha:document.getElementById("fecha").value},function(){
			   $("#productores").chosen({no_results_text: "No se han encontrado resultados para: "});
		   });  
       }
	   ajustar();
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
    }});
</script>  

  <script type="text/javascript"> 
	$("#rutas").chosen({no_results_text: "No se han encontrado resultados para: "});
	$("#productores").chosen({no_results_text: "No se han encontrado resultados para: "});
 	$("input[type=button]").button()
      .click(function( event ) {
        event.preventDefault();
      });
	  
	function editar(){
		document.getElementById("accion").value="2";
		 var band=0;

	    if(document.getElementById("litrosviaje").value==0 && band==0){	
		     alert("Debe indicar los litros de leche que trae el camión.");			 
			 band=1;    	 	
		}	
		
		if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("litrosviaje").value)){
			 alert("Los litros que trae el camion no cumple con el formato requerido, debe ser un numero.");			 
			 band=1; 		   	        
		}				
							
	    if(document.getElementById("lleno").value=="" && band==0){	
			 alert("Debe indicar el peso del camion lleno.");		 
			 band=1;    	 	
		}

		if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("lleno").value)){
			 alert("El peso del camion lleno no cumple con el formato requerido, debe ser un numero.");			 
			 band=1; 		   	        
		}			
		
	    if(document.getElementById("vacio").value=="" && band==0){
			 alert("Debe indicar el peso del camion vacio.");				 
			 band=1;    	 	
		}
		
		if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("vacio").value)){
			 alert("El peso del camion vacio no cumple con el formato requerido, debe ser un numero.");			 
			 band=1; 		   	        
		}					
		
	    if(document.getElementById("temperatura").value!="" && band==0){	
			if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("temperatura").value)){
				 alert("La Temperatura no cumple con el formato requerido, debe ser un numero.");			 
				 band=1; 		   	        
			}		        	 	
		}		
		
		var examenes = document.getElementById("examenes").value;		
		tipos_examenes = examenes.split("-");	
		
		var requeridos = document.getElementById("requeridos").value;		
		tipos_requeridos = requeridos.split("-");			
		
		for(var i=0;i<tipos_examenes.length;i++){
						
		    if(document.getElementById(tipos_examenes[i]).value=="" && band==0 && tipos_requeridos[i]==1){
				 alert("Debe indicar "+tipos_examenes[i]+" observada en el analisis fisico quimico general.");				 
				 band=1;    	 	
			}				
						
			if(document.getElementById(tipos_examenes[i]).value!="" && band==0){							    
				if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById(tipos_examenes[i]).value)){
					 alert("La "+tipos_examenes[i]+" no cumple con el formato requerido, debe ser un numero.");		 
					 band=1; 		   	        
				}		        	 	
			}
			
		}
		
		/*Pongo obligatorios los analisis reuqeridos por configuración de la base datos*/
		var productores=document.getElementById("listaproduc").value.split("-");
		for(var i=0;i<(productores.length-1);i++){
			if(document.getElementById("litros-"+productores[i]).value!=""){
				for(var j=0;j<tipos_examenes.length;j++){
		    		if(document.getElementById(tipos_examenes[j]+"-"+productores[i]).value=="" && band==0 && tipos_requeridos[j]==1){	
					alert("Debe indicar "+tipos_examenes[j]+" observada en la muestra de todos los productores que enviaron leche en la rura.");		
					band=1;    	 	
					}
					
					if(document.getElementById(tipos_examenes[j]+"-"+productores[i]).value!="" && band==0){							    
						if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById(tipos_examenes[j]+"-"+productores[i]).value)){
							 alert("La "+tipos_examenes[j]+" en la muestra de alguno de los productores no cumple con el formato requerido, debe ser un numero.");		 
							 band=1; 		   	        
						}		        	 	
					}										
					
				}
			}		   
		}	
		
		
										
		var acumula=0;
		var productores=document.getElementById("listaproduc").value.split("-");
		for(var i=0;i<(productores.length-1);i++){
			if(document.getElementById("litros-"+productores[i]).value!=""){
				acumula+= parseFloat(document.getElementById("litros-"+productores[i]).value);
			}		   
		}
		
		if(acumula!=document.getElementById("litrosviaje").value){
		   alert("Los litros indicados en el viaje no coinciden con la sumatoria de los litros traidos por cada uno de los productores.");
		   band=1;	
		}
										
		if(band==0){
			document.formularioviaje.submit();
		}			
	}
	  
	function guardar(){
		document.getElementById("accion").value="1";
		 var band=0;

	    if(document.getElementById("litrosviaje").value==0 && band==0){	
		     alert("Debe indicar los litros de leche que trae el camión.");			 
			 band=1;    	 	
		}	
		
		if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("litrosviaje").value)){
			 alert("Los litros que trae el camion no cumple con el formato requerido, debe ser un numero.");		 
			 band=1; 		   	        
		}				
							
	    if(document.getElementById("lleno").value=="" && band==0){	
		     alert("Debe indicar el peso del camion lleno.");		 
			 band=1;    	 	
		}

		if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("lleno").value)){
			 alert("El peso del camion lleno no cumple con el formato requerido, debe ser un numero.");			 
			 band=1; 		   	        
		}			
		
	    if(document.getElementById("vacio").value=="" && band==0){	
			 alert("Debe indicar el peso del camion vacio.");			 
			 band=1;    	 	
		}
		
		if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("vacio").value)){
			 alert("El peso del camion vacio no cumple con el formato requerido, debe ser un numero.");			 
			 band=1; 		   	        
		}					
		
	    if(document.getElementById("temperatura").value!="" && band==0){	
			if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("temperatura").value)){
				 alert("La Temperatura no cumple con el formato requerido, debe ser un numero.");			 
				 band=1; 		   	        
			}		        	 	
		}		
		
		var examenes = document.getElementById("examenes").value;		
		tipos_examenes = examenes.split("-");	
		
		var requeridos = document.getElementById("requeridos").value;		
		tipos_requeridos = requeridos.split("-");			
		
		for(var i=0;i<tipos_examenes.length;i++){
						
		    if(document.getElementById(tipos_examenes[i]).value=="" && band==0 && tipos_requeridos[i]==1){
				 alert("Debe indicar "+tipos_examenes[i]+" observada en el analisis fisico quimico general.");	 
				 band=1;    	 	
			}				
						
			if(document.getElementById(tipos_examenes[i]).value!="" && band==0){							    
				if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById(tipos_examenes[i]).value)){
					 alert("La "+tipos_examenes[i]+" no cumple con el formato requerido, debe ser un numero.");			 
					 band=1; 		   	        
				}		        	 	
			}
			
		}
		
		/*Pongo obligatorios los analisis reuqeridos por configuración de la base datos*/
		var productores=document.getElementById("listaproduc").value.split("-");
		for(var i=0;i<(productores.length-1);i++){
			if(document.getElementById("litros-"+productores[i]).value!=""){
				for(var j=0;j<tipos_examenes.length;j++){
		    		if(document.getElementById(tipos_examenes[j]+"-"+productores[i]).value=="" && band==0 && tipos_requeridos[j]==1){	
					alert("Debe indicar "+tipos_examenes[j]+" observada en la muestra de todos los productores que enviaron leche en la rura.");
					band=1;    	 	
					}
					
					if(document.getElementById(tipos_examenes[j]+"-"+productores[i]).value!="" && band==0){							    
						if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById(tipos_examenes[j]+"-"+productores[i]).value)){
							 alert("La "+tipos_examenes[j]+" en la muestra de alguno de los productores no cumple con el formato requerido, debe ser un numero.");			 
							 band=1; 		   	        
						}		        	 	
					}										
					
				}
			}		   
		}	
		
		
										
		var acumula=0;
		var productores=document.getElementById("listaproduc").value.split("-");
		
		for(var i=0;i<(productores.length);i++){
			if(productores[i]!="" && productores[i]!=" " && productores[i]!=null){
				if(document.getElementById("litros-"+productores[i]).value!=""){
					acumula+= parseFloat(document.getElementById("litros-"+productores[i]).value);
				}	
			}
			
		}
		
		if(acumula!=document.getElementById("litrosviaje").value){
		   alert("Los litros indicados en el viaje no coinciden con la sumatoria de los litros traidos por cada uno de los productores.");
		   band=1;	
		}
										
		if(band==0){
			document.formularioviaje.submit();
		}
										
	}
	
	function calcular_litros(){
	   if(document.getElementById("lleno").value!="" && document.getElementById("vacio").value!=""){
	       document.getElementById("litrosreales").value=((document.getElementById("lleno").value-document.getElementById("vacio").value)/1.032).toFixed(2);
           document.getElementById("diferencia").value=((document.getElementById("litrosreales").value-document.getElementById("litrosviaje").value)).toFixed(2);
	   }else{
			document.getElementById("litrosreales").value="";   
	   }
	   
	   
	}
	  
  </script>

</html>