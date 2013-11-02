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
<title>Productos</title>
<style type="text/css">
.tabla-detalle{
	float:left;
	width:100%;
	height:595px;
	border:1px solid #CCC;	
	border-top:0px;
	z-index:999;
}

.detalle-linea{
	float:left;
	width:909px;
	margin:5px;
	margin-top:10px;
	height:37px;
}

.listaprecios{
	float:left;
	width:97%;
	margin:5px;
	margin-top:0px;
	margin-left:15px;
	height:auto;
}

.linea_precios{
	width:100%;
	height:20px;
	border-bottom:1px solid #CCC;	
}

.columna_precios{
	float:left;
	width:auto;
	height:20px;
	border-right:1px solid #CCC;
	font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
	padding-left:5px;
	line-height:20px;
	
}

.entrada_precio{
	position:absolute;
	margin:0px;	
	margin-left:-5px;
	height:20px;
	border:0px;
	font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
	padding-right:5px;	
}

.detalle-indica{
	float:left;
	width:97%;	
	margin:5px;
	margin-top:0px;
	height:20px;
	line-height:20px;
	margin-left:15px;
	font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	color:#333;		
}

.tablainsumos{
	float:left;
	margin:0px;	
	border-collapse: collapse;
	margin-left:0px;
	margin-bottom:5px;
	border:1px solid #999;
}

.conte_agregar{
	float:left;
	margin-left:0px;
	width:36%;
	height:25px;
	margin-bottom:5px;
	margin-left:15px;
}

.boton_cargar{
	float:left;
	width:68px;
	height:23px;
	margin-left:0px;
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
        <div class="barra2_pantalla">Productos</div>
    </div>
    <div class="menu" id="menu">
    	<?php menu_interno(); ?>
    </div>
	<div class="cuerpo" id="cuerpo">
    
  	<?php
		$con=Conectarse();
		$precios="";
		$ubicaciones="";
		$sql_precios="select * from tipoprecio order by idtipoprecio";
		$result_precios=pg_exec($con,$sql_precios);						
		for($i=0;$i<pg_num_rows($result_precios);$i++){
			$precio=pg_fetch_array($result_precios,$i);
			$precios=$precios.$precio[0]."-";
		}
	
		$sql_ciudades="select * from ubicacion order by idubicacion";
		$result_ciudades=pg_exec($con,$sql_ciudades);
		for($i=0;$i<pg_num_rows($result_ciudades);$i++){
			$ciudad=pg_fetch_array($result_ciudades);
			$ubicaciones=$ubicaciones.$ciudad[0]."-";
		}
						  	  
	  ?>
	  <input type="hidden" name="ubicaciones" id="ubicaciones" value="<?php echo $ubicaciones; ?>" />
	  <input type="hidden" name="precios" id="precios" value="<?php echo $precios; ?>" />    
    
    	<div class="tabla">
        
	    	<div class="tabla-titulo">Productos
	        	<div class="tabla-titulo-add" onclick="agregar()">
	            	<div class="tabla-titulo-add-icon" style="background:url(../recursos/imagenes/add.png) no-repeat center center;"></div>
	                <div class="tabla-titulo-add-text"> Agregar Nuevo Registro </div>
	            </div>
	        </div>
            <div class='tabla-detalle' id='agregar' style='display: none'></div>
	        <div class="tabla-cabecera" style="border-bottom:0px;">                
	        	<div class="filter" title="Filtrar registros" onclick="actualizar_filtros2()"><img src="../recursos/imagenes/filter_data.png" width="19" height="19" /></div>
		        <input type="text" id="clave" name="clave" class="campo_filtro" placeholder="Indique su referencia" />
      			<select name="select_filtros" id="select_filtros" class="select_filtro" placeholder="Seleccione el campo para filtrar">
		        	<option value="0">Sin Filtrar</option>
		            <option value="idproducto">Codigo</option>
		            <option value="descripcion">Nombre / Descripción del Producto</option>
		        </select>       
		        <div class="tabla-pie-elemento-etiqueta" style="margin-left:5px; float:right">Filtrar</div>
		    </div>
            
        <div id="muestra">
        <div class="tabla-cabecera">        
       	  	<div class="tabla-cabecera-elemento" style="width:19%;">Código 
            	<div class="tabla-cabecera-elemento-flechas"><img src="../recursos/imagenes/0.png" style="position:absolute;" width="16" height="18" />
            	<div class="tabla-cabecera-elemento-flechas_arriba" title="Ordenar Ascendentemente" onclick=actualizar_filtros("idproducto","asc")></div>
            	<div class="tabla-cabecera-elemento-flechas_abajo" title="Ordenar Descendentemente" onclick=actualizar_filtros("idproducto","desc")></div>
            	</div>
          	</div>
                      
       	  	<div class="tabla-cabecera-elemento" style="width:79%; border-right:0px;">Nombre / Descripción del Producto
            	<div class="tabla-cabecera-elemento-flechas"><img src="../recursos/imagenes/0.png" style="position:absolute;" width="16" height="18" />
            	<div class="tabla-cabecera-elemento-flechas_arriba" title="Ordenar Ascendentemente" onclick=actualizar_filtros("descripcion","asc")></div>
            	<div class="tabla-cabecera-elemento-flechas_abajo" title="Ordenar Descendentemente" onclick=actualizar_filtros("descripcion","desc")></div>
            	</div>
          	</div>                                                               
        </div>
        
        <input type="hidden" name="filtro" id="filtro" value="" />
        <input type="hidden" name="orden" id="orden" value="" />
        <input type="hidden" name="filtro2" id="filtro2" value="" />
        <input type="hidden" name="clave_bus" id="clave_bus" value="" />        
        
        <?php
		    $sql_productos="select * from producto order by idproducto";
			$result_productos=pg_exec($con,$sql_productos);
			if(pg_num_rows($result_productos)>0){
				for($i=0;$i<pg_num_rows($result_productos) && $i<10;$i++){
					$producto=pg_fetch_array($result_productos,$i);																																							
			    	echo "<div class='tabla-linea'>";
		        	echo "<div class='tabla-linea-elemento' style='width:19%'>".Codigo("PRO",$producto[0])."</div>";
		            echo "<div class='tabla-linea-elemento' style='width:69%;'>".$producto[2]."</div>";
		            echo "<div class='tabla-linea-elemento' id='linea".$producto[0]."' onclick='detalle(".$producto[0].")' style='width:20px;background:url(../recursos/imagenes/list_metro.png) no-repeat center center; cursor:pointer;' title='Ver Detalle'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='editar(".$producto[0].")' style='width:20px;background:url(../recursos/imagenes/edit.png) no-repeat center center; cursor:pointer;' title='Editar Registro'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='eliminarproducto(".$producto[0].")' style='width:20px;background:url(../recursos/imagenes/delete.png) no-repeat center center; cursor:pointer; border-right:0px;' title='Eliminar Registro'></div>";
			        echo "</div>";
			        echo "<div class='tabla-detalle' id='detalle".$producto[0]."' style='display: none'>";
		        	echo "<div class='tabla-detalle-contenedor'>										
					</div>";
			        echo "</div>";										
				}				
			}else{
				
			}

		?>        
        
        <div class="tabla-pie">
        	
            <div class="tabla-pie-tabulador" title="Ir a la primera página" onclick=cambiar_pagina(1)><<</div>
            <div class="tabla-pie-tabulador" title="Ir una página atras" onclick=cambiar_pagina(2)><</div>
            
            <div class="tabla-pie-actual">Página <label id="pagina_actual">1</label>/<label id="total_paginas"><?php echo ceil(pg_num_rows($result_productos)/10); ?></label></div>
			
            <div class="tabla-pie-tabulador" title="Ir una página adelante" onclick=cambiar_pagina(3)>></div>
            <div class="tabla-pie-tabulador" title="Ir a la última página" onclick=cambiar_pagina(4)>>></div>            
        	
            
            <div class="tabla-pie-elemento">
            	<div class="tabla-pie-elemento-etiqueta">Ir a la Página</div>
                <div class="tabla-pie-elemento-select">
                	<select name="selector_pagina" id="selector_pagina" onchange="paginar()">
                        <?php
						    $indice= ceil(pg_num_rows($result_productos)/10);
							for($i=0;$i<$indice;$i++){
								echo "<option value=".($i+1).">".($i+1)."</option>";
							}						
						?>                    	
                    </select>
                </div>                
            </div>
        	<div class="tabla-pie-elemento">
            	<div class="tabla-pie-elemento-etiqueta">Numero de Registros</div>
                <div class="tabla-pie-elemento-select">
                	<select name="selector_registros" id="selector_registros" onchange="paginar2()">
                    	<option value="10" selected="selected" >10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>                
            </div> 
            <div class="tabla-pie-actual" style="float:right; margin-right:5px;">Mostrando 01- <?php $limite; (pg_num_rows($result_productos)<10)?$limite=pg_num_rows($result_productos):$limite=10; echo $limite; ?> de <?php echo pg_num_rows($result_productos); ?></div>    
    </div>        
                                            
        </div>             
                   	                 
        </div>    
    </div>
    <input type="hidden" name="elimina" id="elimina" value=""  />                    
	<div class="pie"></div>
</body>
<script type="text/javascript" language="javascript">

    function cambia_regulado(numero){
		
		if(document.getElementById("tipoventa"+numero).value==1){ /*Con precio regulado*/
			document.getElementById("regulado"+numero).style.background="#FFFFFF";
			document.getElementById("regulado"+numero).readOnly=false;
		}else if(document.getElementById("tipoventa"+numero).value==2){ /*Con precio full*/
			document.getElementById("regulado"+numero).value="";
			document.getElementById("regulado"+numero).readOnly=true;
			document.getElementById("regulado"+numero).style.background="#EFEFEF";
		}
	}
    
	function cambiar_pagina(posicion){
		
		var actual = parseInt(document.getElementById("pagina_actual").innerHTML);
		var total = parseInt(document.getElementById("total_paginas").innerHTML);


		if(posicion==1){
		    actualizar(1,document.getElementById("selector_registros").value,document.getElementById("filtro").value,document.getElementById("orden").value,document.getElementById("filtro2").value,document.getElementById("clave_bus").value);
		}
		if(posicion==4){
		    actualizar(total,document.getElementById("selector_registros").value,document.getElementById("filtro").value,document.getElementById("orden").value,document.getElementById("filtro2").value,document.getElementById("clave_bus").value);
		}		
		if(posicion==2 && actual > 1 ){
			actualizar(actual-1,document.getElementById("selector_registros").value,document.getElementById("filtro").value,document.getElementById("orden").value,document.getElementById("filtro2").value,document.getElementById("clave_bus").value);
		}
		if(posicion==3 && (actual + 1) <= total ){			
			actualizar(actual+1,document.getElementById("selector_registros").value,document.getElementById("filtro").value,document.getElementById("orden").value,document.getElementById("filtro2").value,document.getElementById("clave_bus").value);
		}						
	}

	function actualizar_filtros(nombre,orden){
		document.getElementById("filtro").value=nombre;
		document.getElementById("orden").value=orden;
		paginar();
	}
	
	function actualizar_filtros2(){
		document.getElementById("filtro2").value=document.getElementById("select_filtros").value;
		document.getElementById("clave_bus").value=document.getElementById("clave").value;		
		paginar2();
	}	

    function paginar(){	
	    actualizar(document.getElementById("selector_pagina").value,document.getElementById("selector_registros").value,document.getElementById("filtro").value,document.getElementById("orden").value,document.getElementById("filtro2").value,document.getElementById("clave_bus").value);
	}
    
	function paginar2(){	
	    actualizar(1,document.getElementById("selector_registros").value,document.getElementById("filtro").value,document.getElementById("orden").value,document.getElementById("filtro2").value,document.getElementById("clave_bus").value);
	}	
	
	function actualizar(pagina,numero_registros,filtro,orden,filtro2,clave){
		//alert(pagina+" -- "+numero_registros+" -- "+filtro+" -- "+orden+" -- "+filtro2+" -- "+clave);
		$("#muestra").load("../recursos/funciones/ajaxProductos.php", {action:6, pagina: pagina, muestra: numero_registros , filtro_orden: filtro, orden: orden, filtro_busqueda: filtro2, clave: clave},function(){
			ajustar();	
		});
	}

	function detalle(id){
		if ($("#detalle"+id).is(':hidden')){
			$(".tabla-detalle").slideUp("slow");
			$('.tabla-detalle-contenedor').empty();	
			$("#detalle"+id).load("../recursos/funciones/ajaxProductos.php", {action: 2, identificador: id},function(){
				$( "#estatus1" ).buttonset();
			 	$( "input[type=button]" )
			      .button()
			      .click(function( event ) {
		          event.preventDefault();
		        });	
				$("#tipoproducto1").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#impuesto1").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#tipoventa1").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#insumos1").chosen({no_results_text: "No se han encontrado resultados para: "});	
				$("#ventapor1").chosen({no_results_text: "No se han encontrado resultados para: "});
				
				document.getElementById("tipoproducto1_chzn").style.width=document.getElementById("tipoproducto1").style.width+"px";		
				document.getElementById("impuesto1_chzn").style.width=document.getElementById("impuesto1").style.width+"px";	
				document.getElementById("tipoventa1_chzn").style.width=document.getElementById("tipoventa1").style.width+"px";	
				document.getElementById("insumos1_chzn").style.width=document.getElementById("insumos1").style.width+"px";	
				document.getElementById("ventapor1_chzn").style.width=document.getElementById("ventapor1").style.width+"px";											
			});	
			$("#detalle"+id).slideDown("slow",function(){
				ajustar();	
			});				
		}else
		if ($("#detalle"+id).is(':visible')){
			$('.tabla-detalle-contenedor').empty();	
			$("#detalle"+id).load("../recursos/funciones/ajaxProductos.php", {action: 2, identificador: id},function(){
				$( "#estatus1" ).buttonset();
			 	$( "input[type=button]" )
			      .button()
			      .click(function( event ) {
		          event.preventDefault();
		        });	
				$("#tipoproducto1").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#impuesto1").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#tipoventa1").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#insumos1").chosen({no_results_text: "No se han encontrado resultados para: "});	
				$("#ventapor1").chosen({no_results_text: "No se han encontrado resultados para: "});
				
				document.getElementById("tipoproducto1_chzn").style.width=document.getElementById("tipoproducto1").style.width+"px";		
				document.getElementById("impuesto1_chzn").style.width=document.getElementById("impuesto1").style.width+"px";	
				document.getElementById("tipoventa1_chzn").style.width=document.getElementById("tipoventa1").style.width+"px";	
				document.getElementById("insumos1_chzn").style.width=document.getElementById("insumos1").style.width+"px";	
				document.getElementById("ventapor1_chzn").style.width=document.getElementById("ventapor1").style.width+"px";												
			});			
		}		
	}
	

	
	function editar(id){						
		if ($("#detalle"+id).is(':hidden')){
			$(".tabla-detalle").slideUp("slow");
			$('.tabla-detalle-contenedor').empty();
			$("#detalle"+id).load("../recursos/funciones/ajaxProductos.php", {action: 4, identificador: id},function(){
				$( "#estatus3" ).buttonset();
			 	$( "input[type=button]" )
			      .button()
			      .click(function( event ) {
		          event.preventDefault();
		        });
				$("#tipoproducto3").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#impuesto3").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#tipoventa3").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#insumos3").chosen({no_results_text: "No se han encontrado resultados para: "});	
				$("#ventapor3").chosen({no_results_text: "No se han encontrado resultados para: "});
				
				document.getElementById("tipoproducto3_chzn").style.width=document.getElementById("tipoproducto3").style.width+"px";		
				document.getElementById("impuesto3_chzn").style.width=document.getElementById("impuesto3").style.width+"px";	
				document.getElementById("tipoventa3_chzn").style.width=document.getElementById("tipoventa3").style.width+"px";	
				document.getElementById("insumos3_chzn").style.width=document.getElementById("insumos3").style.width+"px";	
				document.getElementById("ventapor3_chzn").style.width=document.getElementById("ventapor3").style.width+"px";																					
			});
	        $("#detalle"+id).slideDown("slow",function(){
				ajustar();	
			});														
		}else
		if ($("#detalle"+id).is(':visible')){
			$('.tabla-detalle-contenedor').empty();
			$("#detalle"+id).load("../recursos/funciones/ajaxProductos.php", {action: 4, identificador: id},function(){
				$( "#estatus3" ).buttonset();				
			 	$( "input[type=button]" )
			      .button()
			      .click(function( event ) {
		          event.preventDefault();
		        });
				$("#tipoproducto3").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#impuesto3").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#tipoventa3").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#insumos3").chosen({no_results_text: "No se han encontrado resultados para: "});	
				$("#ventapor3").chosen({no_results_text: "No se han encontrado resultados para: "});
				
				document.getElementById("tipoproducto3_chzn").style.width=document.getElementById("tipoproducto3").style.width+"px";		
				document.getElementById("impuesto3_chzn").style.width=document.getElementById("impuesto3").style.width+"px";	
				document.getElementById("tipoventa3_chzn").style.width=document.getElementById("tipoventa3").style.width+"px";	
				document.getElementById("insumos3_chzn").style.width=document.getElementById("insumos3").style.width+"px";	
				document.getElementById("ventapor3_chzn").style.width=document.getElementById("ventapor3").style.width+"px";								
									
			});	     
		}	    	
	}
	
	function cerrar(){
		$(".tabla-detalle").slideUp("slow",function(){
			ajustar();	
		});
	}
	
	function agregar(){		
		$(".tabla-detalle").slideUp("slow");			
		if ($("#agregar").is(':hidden')){
			$('.tabla-detalle-contenedor').empty();	
			$("#agregar").load("../recursos/funciones/ajaxProductos.php", {action: 3},function(){
				$( "#estatus1" ).buttonset();	
				$( "input[type=button]" )
				  .button()
				  .click(function( event ) {
			      event.preventDefault();
			    });	
							        
				$("#agregar").slideDown("slow",function(){
					ajustar();	
				});	
				$("#tipoproducto1").chosen({no_results_text: "No se han encontrado resultados para: "});		
				$("#impuesto1").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#tipoventa1").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#insumos1").chosen({no_results_text: "No se han encontrado resultados para: "});	
				$("#ventapor1").chosen({no_results_text: "No se han encontrado resultados para: "});
				
				document.getElementById("tipoproducto1_chzn").style.width=document.getElementById("tipoproducto1").style.width+"px";		
				document.getElementById("impuesto1_chzn").style.width=document.getElementById("impuesto1").style.width+"px";	
				document.getElementById("tipoventa1_chzn").style.width=document.getElementById("tipoventa1").style.width+"px";	
				document.getElementById("insumos1_chzn").style.width=document.getElementById("insumos1").style.width+"px";	
				document.getElementById("ventapor1_chzn").style.width=document.getElementById("ventapor1").style.width+"px";				
				
			});			
		}else		
		if ($("#agregar").is(':visible')){
	        $("#agregar").slideUp("slow",function(){
				ajustar();	
			});
		}			
	}
	
	
   function agregar_insumo(numero){	   	  

       if(document.getElementById("insumos"+numero).value==0){
		   alert("Debe seleccionar un insumo / empaque para agregar a la producción, de una unidad del producto que se esta registrando.");			   
	   }else{					
			var tds= '<tr style="font-size:12px; height:20px; border-left:hidden; border-bottom: 1px solid color:#CCC">';
			tds += '<td style="width:330px;padding-left:5px;padding-right:5px;">'+$("#insumos"+numero+" option[value='"+document.getElementById("insumos"+numero).value+"']").text()+'</td>';
	        tds += '<td style="width:60px;padding-left:5px;padding-right:5px;"><input type="text" id="insumo-'+document.getElementById("insumos"+numero).value+'" name="insumo-'+document.getElementById("insumos"+numero).value+'" class="entrada_precio" style="width:70px; margin-top:-9px; height:19px; text-align:right" /></td>';
			tds += '</tr>';
			$("#tablainsumos").append(tds);					
			document.getElementById("listainsumo").value = document.getElementById("listainsumo").value+document.getElementById("insumos"+numero).value+'-';		
		   $("#conte_agregar").load("../recursos/funciones/ajaxProductos.php", {action: 8, usados:document.getElementById("listainsumo").value, ind:numero},function(){
			   $("#insumos"+numero).chosen({no_results_text: "No se han encontrado resultados para: "});
		   }); 			
				
	   }
		   
   }	
 
  $(function() {
    $( "#estatus1" ).buttonset();
	
 	$( "input[type=button]" )
      .button()
      .click(function( event ) {
        event.preventDefault();
      });	
  });
  
  function precio_base(numero){
	 
   	 var precios = document.getElementById("precios").value;
	 arreglo_precios = precios.split("-");
	 
   	 var ubicaciones = document.getElementById("ubicaciones").value;
	 arreglo_ubicaciones = ubicaciones.split("-");	 	 
	 for(var i=0;i<arreglo_ubicaciones.length-1;i++){		 
		 for(var j=0;j<arreglo_precios.length-1;j++){
			  if(document.getElementById("por_"+arreglo_ubicaciones[i]+"_"+arreglo_precios[j]).value=="" || document.getElementById("por_"+arreglo_ubicaciones[i]+"_"+arreglo_precios[j]).value==0){
				  document.getElementById("por_"+arreglo_ubicaciones[i]+"_"+arreglo_precios[j]).value=0;
				  document.getElementById("pre_"+arreglo_ubicaciones[i]+"_"+arreglo_precios[j]).value=document.getElementById("venta"+numero).value;
			  }else{
				  var pre= (document.getElementById("venta"+numero).value*(document.getElementById("por_"+arreglo_ubicaciones[i]+"_"+arreglo_precios[j]).value/100));
				  var aux = document.getElementById("venta"+numero).value;
				  pre = Number(pre) + Number(aux);
				  pre = parseFloat(pre).toFixed(2);
				  document.getElementById("pre_"+arreglo_ubicaciones[i]+"_"+arreglo_precios[j]).value = pre;
			  }
		 }	
	 }
	 
  }
  
  function agregarproducto(){
	    var band=0;
	    if(document.getElementById("tipoproducto1").value==0  && band==0){	
		     alert("Debe indicar el tipo de producto que esta registrando.");
			 band=1;    	 	
		}
		
	    if(document.getElementById("descripcion1").value==""  && band==0){	
		     alert("Debe indicar la descripción / nombre del producto que esta registrando.");	 		 
			 band=1;    	 	
		}		
					
		
		if(document.getElementById("peso_min1").value!="" && band==0){
			if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("peso_min1").value)){
				alert("El peso minimo aceptable para una unidad del producto no cumple con el formato requerido, deber ser un numero por ejemplo 7.5");			 
				band=1;				
			}
		}	
		
		if(document.getElementById("peso_max1").value!="" && band==0){
			if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("peso_max1").value)){
				alert("El peso maximo aceptable para una unidad del producto no cumple con el formato requerido, deber ser un numero por ejemplo 7.5");			 
				band=1;				
			}
		}	
		
	    if(document.getElementById("impuesto1").value==0  && band==0){	
		     alert("Debe indicar si el producto que esta registrando es o no excento de Impuesto.");
			 band=1;    	 	
		}	
		
	    if(document.getElementById("ventapor1").value==0  && band==0){	
		     alert("Debe seleccionar si el producto se vendera por su peso o por unidades.");
			 band=1;    	 	
		}			
		
	    if(document.getElementById("tipoventa1").value==0  && band==0){	
		     alert("Debe indicar si el producto que esta registrando se vendera bajo precio regulado o no.");
			 band=1;    	 	
		}	
		
		if(document.getElementById("tipoventa1").value==1  && band==0){
			if(document.getElementById("regulado1").value=="" || document.getElementById("regulado1").value==0 && band==0){
				alert("Debe indicar el precio de venta regulado del producto que esta registrando");			 
				band=1;		
			}
			
			if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("regulado1").value) && band==0){
				alert("El precio de venta regulado del producto no cumple con el formato requerido debe ser un numero por ejemplo 34.45");
				band=1;				
			}						
		}
		
	    if(document.getElementById("venta1").value==0  && band==0){	
		     alert("Debe indicar el precio base de venta del producto que esta registrando ya que en base al mismo se calcularan los precios por categoria y ubicación.");
			 band=1;    	 	
		}	
		
		if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("venta1").value)  && band==0){
			alert("El precio base de venta del producto que se esta registrando no cumple con el formato requerido debe ser un numero.");
			band=1;				
		}	
		
		if(document.getElementById("listainsumo").value=="" && band==0){
			alert("Debe seleccionar por lo menos un insumo / empaque para el producto que esta registrando.");
			band=1;
		}else{
	        
			var bandaux=0;
			var insumos = document.getElementById("listainsumo").value;		
			arrayinsumos = insumos.split("-");					
			for(var i=0;i<arrayinsumos.length-1;i++){
				if(document.getElementById("insumo-"+arrayinsumos[i]).value!="-" && document.getElementById("insumo-"+arrayinsumos[i]).value!=""){
					if(document.getElementById("insumo-"+arrayinsumos[i]).value!=""){
						 bandaux=1;
						 break
					}	
				}
			}
			
			if(bandaux==0 && band==0){
				alert("Debe indicar la unidad necesario en por lo menos uno de los insumos que selecciono.");
				band=1;
			}
			
	
		}						
		
		if(band==0){
			 document.formagregaproducto.submit();
		}
  }
  
  function editarproducto(){
	    var band=0;
	    if(document.getElementById("tipoproducto3").value==0  && band==0){	
		     alert("Debe indicar el tipo de producto que esta editando.");
			 band=1;    	 	
		}
		
	    if(document.getElementById("descripcion3").value==""  && band==0){	
		     alert("Debe indicar la descripción / nombre del producto que esta editando.");	 		 
			 band=1;    	 	
		}		
							
		if(document.getElementById("peso_min3").value!="" && band==0){
			if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("peso_min3").value)){
				alert("El peso minimo aceptable para una unidad del producto no cumple con el formato requerido, deber ser un numero por ejemplo 7.5");			 
				band=1;				
			}
		}	
		
		if(document.getElementById("peso_max3").value!="" && band==0){
			if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("peso_max3").value)){
				alert("El peso maximo aceptable para una unidad del producto no cumple con el formato requerido, deber ser un numero por ejemplo 7.5");			 
				band=1;				
			}
		}	
		
	    if(document.getElementById("impuesto3").value==0  && band==0){	
		     alert("Debe indicar si el producto que esta editando es o no excento de Impuesto.");
			 band=1;    	 	
		}	
		
	    if(document.getElementById("ventapor3").value==0  && band==0){	
		     alert("Debe seleccionar si el producto se vendera por su peso o por unidades.");
			 band=1;    	 	
		}		
		
	    if(document.getElementById("tipoventa3").value==0  && band==0){	
		     alert("Debe indicar si el producto que esta editando se vendera bajo precio regulado o no.");
			 band=1;    	 	
		}	
		
		if(document.getElementById("tipoventa3").value==1  && band==0){
			if(document.getElementById("regulado3").value=="" || document.getElementById("regulado3").value==0 && band==0){
				alert("Debe indicar el precio de venta regulado del producto que esta editando");			 
				band=1;		
			}
			
			if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("regulado3").value) && band==0){
				alert("El precio de venta regulado del producto no cumple con el formato requerido debe ser un numero por ejemplo 34.45");
				band=1;				
			}						
		}
		
	    if(document.getElementById("venta3").value==0  && band==0){	
		     alert("Debe indicar el precio base de venta del producto que esta editando ya que en base al mismo se calcularan los precios por categoria y ubicación.");
			 band=1;    	 	
		}	
		
		if(!/^([0-9])*[.]?[0-9]*$/.test(document.getElementById("venta3").value)  && band==0){
			alert("El precio base de venta del producto que se esta editando no cumple con el formato requerido debe ser un numero.");
			band=1;				
		}	
		
		if(document.getElementById("listainsumo").value=="" && band==0){
			alert("Debe seleccionar por lo menos un insumo / empaque para el producto que esta registrando.");
			band=1;
		}else{
	        
			var bandaux=0;
			var insumos = document.getElementById("listainsumo").value;		
			arrayinsumos = insumos.split("-");					
			for(var i=0;i<arrayinsumos.length-1;i++){
				if(document.getElementById("insumo-"+arrayinsumos[i]).value!="-" && document.getElementById("insumo-"+arrayinsumos[i]).value!=""){
					if(document.getElementById("insumo-"+arrayinsumos[i]).value!=""){
						 bandaux=1;
						 break
					}	
				}
			}			
			if(bandaux==0 && band==0){
				alert("Debe indicar la unidad necesario en por lo menos uno de los insumos que selecciono.");
				band=1;
			}				
		}								
		if(band==0){
			 document.formeditarproducto.submit();
		}
  }
  
  function ajustar(){	  
	  $("#menu").css("height", $("#cuerpo").css("height"));  
  }  
  
  function eliminarproducto(codigo){
	    document.getElementById("elimina").value=codigo;
		var answer = confirm ("¿Esta seguro que desea eliminar este producto?")
		if (answer)
		location.href="../recursos/funciones/ajaxProductos.php?action=7&id="+document.getElementById("elimina").value;		    
  }

</script>
</html>