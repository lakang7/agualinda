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
<title>Clientes</title>
<style type="text/css">
.tabla-detalle{
	float:left;
	width:100%;
	height:210px;
	border:1px solid #CCC;	
	border-top:0px;
	z-index:999;
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
        <div class="barra2_pantalla">Clientes</div>
    </div>
    <div class="menu" id="menu">
    	<?php menu_interno(); ?>
    </div>
	<div class="cuerpo" id="cuerpo">
    	<div class="tabla">
        
	    	<div class="tabla-titulo">Clientes
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
		            <option value="cliente.idcliente">Codigo</option>
		            <option value="ubicacion.ciudad">Ciudad</option>
		            <option value="cliente.documento">Documento</option>
		            <option value="cliente.nombre">Nombre del Cliente</option>                    
		        </select>        
		        <div class="tabla-pie-elemento-etiqueta" style="margin-left:5px; float:right">Filtrar</div>
		    </div>
            
        <div id="muestra">
        <div class="tabla-cabecera">        
       	  	<div class="tabla-cabecera-elemento" style="width:15%;">Código 
            	<div class="tabla-cabecera-elemento-flechas"><img src="../recursos/imagenes/0.png" style="position:absolute;" width="16" height="18" />
            	<div class="tabla-cabecera-elemento-flechas_arriba" title="Ordenar Ascendentemente" onclick=actualizar_filtros("cliente.idcliente","asc")></div>
            	<div class="tabla-cabecera-elemento-flechas_abajo" title="Ordenar Descendentemente" onclick=actualizar_filtros("cliente.idcliente","desc")></div>
            	</div>
          	</div> 
       	  	<div class="tabla-cabecera-elemento" style="width:19%;">Ubicacion 
            	<div class="tabla-cabecera-elemento-flechas"><img src="../recursos/imagenes/0.png" style="position:absolute;" width="16" height="18" />
            	<div class="tabla-cabecera-elemento-flechas_arriba" title="Ordenar Ascendentemente" onclick=actualizar_filtros("ubicacion.ciudad","asc")></div>
            	<div class="tabla-cabecera-elemento-flechas_abajo" title="Ordenar Descendentemente" onclick=actualizar_filtros("ubicacion.ciudad","desc")></div>
            	</div>
          	</div>               
       	  	<div class="tabla-cabecera-elemento" style="width:15%;">Documento 
            	<div class="tabla-cabecera-elemento-flechas"><img src="../recursos/imagenes/0.png" style="position:absolute;" width="16" height="18" />
            	<div class="tabla-cabecera-elemento-flechas_arriba" title="Ordenar Ascendentemente" onclick=actualizar_filtros("cliente.documento","asc")></div>
            	<div class="tabla-cabecera-elemento-flechas_abajo" title="Ordenar Descendentemente" onclick=actualizar_filtros("cliente.documento","desc")></div>
            	</div>
          	</div>                      
       	  	<div class="tabla-cabecera-elemento" style="width:48%; border-right:0px;">Nombre del Cliente
            	<div class="tabla-cabecera-elemento-flechas"><img src="../recursos/imagenes/0.png" style="position:absolute;" width="16" height="18" />
            	<div class="tabla-cabecera-elemento-flechas_arriba" title="Ordenar Ascendentemente" onclick=actualizar_filtros("cliente.nombre","asc")></div>
            	<div class="tabla-cabecera-elemento-flechas_abajo" title="Ordenar Descendentemente" onclick=actualizar_filtros("cliente.nombre","desc")></div>
            	</div>
          	</div>                                                             
        </div>
        
        <input type="hidden" name="filtro" id="filtro" value="" />
        <input type="hidden" name="orden" id="orden" value="" />
        <input type="hidden" name="filtro2" id="filtro2" value="" />
        <input type="hidden" name="clave_bus" id="clave_bus" value="" />        
        
        <?php
		    $sql_clientes="select cliente.idcliente, ubicacion.ciudad, cliente.documento, cliente.nombre from cliente, ubicacion where cliente.idubicacion=ubicacion.idubicacion order by cliente.idcliente;";
			$result_clientes=pg_exec($con,$sql_clientes);
			if(pg_num_rows($result_clientes)>0){
				for($i=0;$i<pg_num_rows($result_clientes) && $i<10;$i++){
					$cliente=pg_fetch_array($result_clientes,$i);																																							
			    	echo "<div class='tabla-linea'>";
		        	echo "<div class='tabla-linea-elemento' style='width:15%;'>".Codigo("CLI",$cliente[0])."</div>";
		            echo "<div class='tabla-linea-elemento' style='width:19%;'>".$cliente[1]."</div>";
		            echo "<div class='tabla-linea-elemento' style='width:15%;'>".$cliente[2]."</div>";
		            echo "<div class='tabla-linea-elemento' style='width:37%;'>".$cliente[3]."</div>";										
		            echo "<div class='tabla-linea-elemento' id='linea".$cliente[0]."' onclick='detalle(".$cliente[0].")' style='width:20px;background:url(../recursos/imagenes/list_metro.png) no-repeat center center; cursor:pointer;' title='Ver Detalle'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='editar(".$cliente[0].")' style='width:20px;background:url(../recursos/imagenes/edit.png) no-repeat center center; cursor:pointer;' title='Editar Registro'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='eliminarbanco(".$cliente[0].")' style='width:20px;background:url(../recursos/imagenes/delete.png) no-repeat center center; cursor:pointer; border-right:0px;' title='Eliminar Registro'></div>";
			        echo "</div>";
			        echo "<div class='tabla-detalle' id='detalle".$cliente[0]."' style='display: none'>";
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
            
            <div class="tabla-pie-actual">Página <label id="pagina_actual">1</label>/<label id="total_paginas"><?php echo ceil(pg_num_rows($result_clientes)/10); ?></label></div>
			
            <div class="tabla-pie-tabulador" title="Ir una página adelante" onclick=cambiar_pagina(3)>></div>
            <div class="tabla-pie-tabulador" title="Ir a la última página" onclick=cambiar_pagina(4)>>></div>            
        	
            
            <div class="tabla-pie-elemento">
            	<div class="tabla-pie-elemento-etiqueta">Ir a la Página</div>
                <div class="tabla-pie-elemento-select">
                	<select name="selector_pagina" id="selector_pagina" onchange="paginar()">
                        <?php
						    $indice= ceil(pg_num_rows($result_clientes)/10);
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
            <div class="tabla-pie-actual" style="float:right; margin-right:5px;">Mostrando 01- <?php $limite; (pg_num_rows($result_clientes)<10)?$limite=pg_num_rows($result_clientes):$limite=10; echo $limite; ?> de <?php echo pg_num_rows($result_clientes); ?></div>           
        </div>    
    </div>        
                                            
        </div>             
                   	                 
        </div>    
    </div>
    <input type="hidden" name="elimina" id="elimina" value=""  />                    
	<div class="pie"></div>
</body>
<script type="text/javascript" language="javascript">
    
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
		$("#muestra").load("../recursos/funciones/ajaxClientes.php", {action:6, pagina: pagina, muestra: numero_registros , filtro_orden: filtro, orden: orden, filtro_busqueda: filtro2, clave: clave});
	}

	function detalle(id){
		if ($("#detalle"+id).is(':hidden')){
			$(".tabla-detalle").slideUp("slow");
			$('.tabla-detalle-contenedor').empty();	
			$("#detalle"+id).load("../recursos/funciones/ajaxClientes.php", {action: 2, identificador: id},function(){
				$( "#estatus2" ).buttonset();
			 	$( "input[type=button]" )
			      .button()
			      .click(function( event ) {
		          event.preventDefault();
		        });
				$("#tipopersona2").chosen();
				$("#ubicacion2").chosen({no_results_text: "No se han encontrado resultados para: "});	
				document.getElementById("tipopersona2_chzn").style.width=document.getElementById("tipopersona2").style.width+"px";
				document.getElementById("ubicacion2_chzn").style.width=document.getElementById("ubicacion2").style.width+"px";					
								
			});	
			$("#detalle"+id).slideDown("slow",function(){
				ajustar();
			});	
				
						
		}else
		if ($("#detalle"+id).is(':visible')){
			$('.tabla-detalle-contenedor').empty();	
			$("#detalle"+id).load("../recursos/funciones/ajaxClientes.php", {action: 2, identificador: id},function(){
				$( "#estatus2" ).buttonset();
			 	$( "input[type=button]" )
			      .button()
			      .click(function( event ) {
		          event.preventDefault();
		        });
				$("#tipopersona2").chosen();
				$("#ubicacion2").chosen({no_results_text: "No se han encontrado resultados para: "});	
				document.getElementById("tipopersona2_chzn").style.width=document.getElementById("tipopersona2").style.width+"px";
				document.getElementById("ubicacion2_chzn").style.width=document.getElementById("ubicacion2").style.width+"px";				
								
			});	
				
					
		}
		
				
	}
	

	
	function editar(id){						
		if ($("#detalle"+id).is(':hidden')){
			$(".tabla-detalle").slideUp("slow");
			$('.tabla-detalle-contenedor').empty();
			$("#detalle"+id).load("../recursos/funciones/ajaxClientes.php", {action: 4, identificador: id},function(){
				$( "#estatus3" ).buttonset();
			 	$( "input[type=button]" )
			      .button()
			      .click(function( event ) {
		          event.preventDefault();
		        });	
				$("#tipopersona3").chosen();
				$("#ubicacion3").chosen({no_results_text: "No se han encontrado resultados para: "});	
				document.getElementById("tipopersona3_chzn").style.width=document.getElementById("tipopersona3").style.width+"px";
				document.getElementById("ubicacion3_chzn").style.width=document.getElementById("ubicacion3").style.width+"px";									
			});
	        $("#detalle"+id).slideDown("slow",function(){
				ajustar();
			});			
			
		}else
		if ($("#detalle"+id).is(':visible')){
			$('.tabla-detalle-contenedor').empty();
			$("#detalle"+id).load("../recursos/funciones/ajaxClientes.php", {action: 4, identificador: id},function(){
				$( "#estatus3" ).buttonset();				
			 	$( "input[type=button]" )
			      .button()
			      .click(function( event ) {
		          event.preventDefault();
		        });	
				$("#tipopersona3").chosen();
				$("#ubicacion3").chosen({no_results_text: "No se han encontrado resultados para: "});	
				document.getElementById("tipopersona3_chzn").style.width=document.getElementById("tipopersona3").style.width+"px";
				document.getElementById("ubicacion3_chzn").style.width=document.getElementById("ubicacion3").style.width+"px";									
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
			$("#agregar").load("../recursos/funciones/ajaxClientes.php", {action: 3},function(){
				$( "#estatus1" ).buttonset();	
				$( "input[type=button]" )
				  .button()
				  .click(function( event ) {
			      event.preventDefault();
			    });	
							        
				$("#agregar").slideDown("slow",function(){
					ajustar();
				});
				$("#tipopersona1").chosen();
				$("#ubicacion1").chosen({no_results_text: "No se han encontrado resultados para: "});	
				document.getElementById("tipopersona1_chzn").style.width=document.getElementById("tipopersona1").style.width+"px";
				document.getElementById("ubicacion1_chzn").style.width=document.getElementById("ubicacion1").style.width+"px";						
			});			
		}else		
		if ($("#agregar").is(':visible')){
	        $("#agregar").slideUp("slow");
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
  
  function agregarregistro(){
	    var band=0;
							
	    if(document.getElementById("nombre1").value=="" && band==0){			 
			 alert("El nombre del cliente no puede quedar vacio.");
			 band=1;    	 	
		}
	    if(document.getElementById("facturacion1").value=="" && band==0){				 
			 alert("El nombre de facturación del cliente no puede quedar vacio.");
			 band=1;    	 	
		}
		
	    if(document.getElementById("rif1").value=="" && band==0){				 
			 alert("El documento de identificacion del cliente no puede quedar vacio.");
			 band=1;    	 	
		}					
				
	    if(document.getElementById("telefono1_1").value=="" && band==0){		
			 alert("El telefono 1 no puede quedar vacio.");		 
			 band=1;    	 	
		}
		   
		if (!/^[0-9]{4,4}-{1}[0-9]{7,7}$/.test(document.getElementById("telefono1_1").value) && band==0){
			 alert("El formato del telefono 1 no es correcto.");	 
			 band=1; 		   	        
		}		
		
	    if(document.getElementById("telefono2_1").value!="" && band==0){
		   if (!/^[0-9]{4,4}-{1}[0-9]{7,7}$/.test(document.getElementById("telefono2_1").value)){
			 alert("El formato del telefono 2 no es correcto.");			 
			 band=1; 		   	        
		   }		   	   	 	
		}
		
	    if(document.getElementById("correo1").value!="" && band==0){
		   if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("correo1").value)){
			 alert("El formato del correo electronico suministrado no es correcto.");			 
			 band=1; 		   	        
		   }		   	   	 	
		}
		
	    if(document.getElementById("ubicacion1").value=="0" && band==0){		
			 alert("Dede indicar la ubicación que le sera asignada al cliente.");		 
			 band=1;    	 	
		}		
			
	    if(document.getElementById("direccion1").value=="" && band==0){		
			 alert("La Dirección del cliente no puede quedar vacia..");		 
			 band=1;    	 	
		}											
		
																			
		if(band==0){
			 document.formagregacliente.submit();
		}
  }
  
  
  function editarregistro(){

	    var band=0;
							
	    if(document.getElementById("nombre3").value=="" && band==0){			 
			 alert("El nombre del cliente no puede quedar vacio.");
			 band=1;    	 	
		}
	    if(document.getElementById("facturacion3").value=="" && band==0){				 
			 alert("El nombre de facturación del cliente no puede quedar vacio.");
			 band=1;    	 	
		}
		
	    if(document.getElementById("rif3").value=="" && band==0){				 
			 alert("El documento de identificacion del cliente no puede quedar vacio.");
			 band=1;    	 	
		}					
				
	    if(document.getElementById("telefono3_1").value=="" && band==0){		
			 alert("El telefono 1 no puede quedar vacio.");		 
			 band=1;    	 	
		}
		   
		if (!/^[0-9]{4,4}-{1}[0-9]{7,7}$/.test(document.getElementById("telefono3_1").value) && band==0){
			 alert("El formato del telefono 1 no es correcto.");	 
			 band=1; 		   	        
		}		
		
	    if(document.getElementById("telefono3_2").value!="" && band==0){
		   if (!/^[0-9]{4,4}-{1}[0-9]{7,7}$/.test(document.getElementById("telefono3_2").value)){
			 alert("El formato del telefono 2 no es correcto.");			 
			 band=1; 		   	        
		   }		   	   	 	
		}
		
	    if(document.getElementById("correo3").value!="" && band==0){
		   if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("correo3").value)){
			 alert("El formato del correo electronico suministrado no es correcto.");			 
			 band=1; 		   	        
		   }		   	   	 	
		}
		
	    if(document.getElementById("ubicacion3").value=="0" && band==0){		
			 alert("Dede indicar la ubicación que le sera asignada al cliente.");		 
			 band=1;    	 	
		}		
			
	    if(document.getElementById("direccion3").value=="" && band==0){		
			 alert("La Dirección del cliente no puede quedar vacia..");		 
			 band=1;    	 	
		}											
		
																			
		if(band==0){
			 document.formeditarcliente.submit();
		}
  }

  
  function ajustar(){	  
	  $("#menu").css("height", $("#cuerpo").css("height"));  
  }

  
  function eliminarbanco(codigo){
	    document.getElementById("elimina").value=codigo;
		var answer = confirm ("¿Esta seguro que desea eliminar este banco?")
		if (answer)
		location.href="../recursos/funciones/ajaxClientes.php?action=7&id="+document.getElementById("elimina").value;	    
  }

</script>
</html>