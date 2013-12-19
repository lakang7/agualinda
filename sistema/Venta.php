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
<title>Realizar Venta</title>
<style type="text/css">

	.contiene_titulo{
		float:left;
		width:96%;
		margin-left:2%;
		height:25px;
		line-height:25px;
		border-top:1px solid #999;
		font-family: 'Oswald', sans-serif;
		font-size:12px;	
	}
	
	.contiene_subtitulos{
		float:left;
		width:96%;
		margin-left:2%;
		height:25px;
		line-height:25px;
		border-bottom:1px solid #999;
		font-family: 'Oswald', sans-serif;
		font-size:12px;	
	}	

	.contiene_campos{
		float:left;
		width:96%;
		margin-left:2%;
		height:42px;
		border-top:1px solid #999;
		padding-top:10px;
		padding-bottom:10px;
		border-bottom:1px solid #999;
	}
	
	.titulo_tabla{
		float:left;
		width:96%;
		margin-left:2%;
		height:25px;
		line-height:25px;
		border-top:1px solid #999;
		border-bottom:1px solid #999;
		font-family: 'Oswald', sans-serif;
		font-size:11px;	
		margin-top:15px;
		background:#CCC;		
	}	
	
	.fila_tabla{
		float:left;
		width:96%;
		margin-left:2%;
		height:25px;
		line-height:25px;
		border-bottom:1px solid #999;
		font-family: 'Oswald', sans-serif;
		font-size:11px;	
		color:#333;

	}
	
	.fila_columna{
		float:left;
		width:10%;
		border-right:1px solid #999;
		height:25px;
		line-height:25px;
		text-align:left;
		padding-left:1%;
		padding-right:1%;		
	}		
	
	.titulo_columna{
		float:left;
		width:10%;
		border-right:1px solid #999;
		height:25px;
		line-height:25px;
		text-align:center;		
	}
	
	.campo{
		float:left;
		height:40px;
		margin-right:2%;			
	}
	.campo_up{
		position:absolute;
		height:15px;
		line-height:15px;
		font-family: 'Oswald', sans-serif;	
		font-size:11px;	
		margin:0px;	
	}
	.campo_down{
		height:22px;	
		position:absolute;
		margin:0px;
		margin-top:15px;		
	}	
	.entrada{
		position:absolute;
		margin:0px;
		height:25px;
		width:100%;	
	}
	
	.entrada_columna{
		position:absolute;
		margin:0px;	
		border:0px;
		height:25px;
		background:#f7f7f7;
		font-family: 'Oswald', sans-serif;
		color:#333;
		text-align:right;
		padding-right:0.5%;
		font-size:12px;
	}
	
	.numero_unidades{
		position:absolute;
		margin:0px;
		width:100px;
		height:25px;
		font-family: 'Oswald', sans-serif;
		color:#333;
		text-align:right;
		padding-right:3%;			
	}
	
	.borrar{
		float:left;
		margin-top:4px;		
        cursor:pointer;	
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
        <div class="barra2_pantalla">Realizar Venta</div>
    </div>
    <div class="menu" id="menu">
    	<?php menu_interno(); ?>
    </div>
    <form name="formularioVenta" id="formularioVenta" method="post" action="../recursos/funciones/ajaxVenta.php?action=3" >
	<div class="cuerpo" id="cuerpo">
    
    	<div class="contiene_titulo"> 
        	Parametros de Configuración
        </div>
    	<div class="contiene_campos">                

        	<div class="campo" style="width:25%;">
            	<div class="campo_up" style="width:19.2%"><label style="margin-left:0.5%">Nombre del Cliente</label></div>
                <div class="campo_down" style="width:19.2%">
                     <select data-placeholder="Seleccione el Nombre del Cliente..." name="nombreCliente" id="nombreCliente" style="width:100%;" class="chzn-select" >
                          <option value=""></option>
                                <?php
								     $sql_select_cliente="select * from cliente order by nombre ASC";
									 $result_select_clientes = pg_exec($con,$sql_select_cliente);
									 for($i=0;$i<pg_num_rows($result_select_clientes);$i++){
										 $cliente=pg_fetch_array($result_select_clientes,$i);		
										 echo "<option value=".$cliente[0].">".$cliente[1]."</option>"; 			
								     }
								?>
                      </select>                                    
                </div>
            </div>
        	<div class="campo" style="width:20%;" >
            	<div class="campo_up" style="width:15.4%"><label style="margin-left:0.5%">Tipo de Precio</label></div>
                <div class="campo_down" style="width:15.4%">
                     <select data-placeholder="Seleccione el tipo de precio..." name="tipoPrecio" id="tipoPrecio" style="width:100%;" class="chzn-select" >
                          <option value=""></option>
                                <?php
								     $sql_select_precios="select * from tipoprecio order by idtipoprecio ASC";
									 $result_select_precios = pg_exec($con,$sql_select_precios);
									 for($i=0;$i<pg_num_rows($result_select_precios);$i++){
										 $precio=pg_fetch_array($result_select_precios,$i);		
										 echo "<option value=".$precio[0].">".$precio[2]."</option>"; 			
								     }
								?>
                      </select>                  
                </div>
            </div>   
            
        	<div class="campo" style="width:27%;margin-right:1%;">
            	<div class="campo_up" style="width:21%"><label style="margin-left:0.5%">Tipo de Venta</label></div>
                <div class="campo_down" style="width:20.7%">
                     <select data-placeholder="Seleccione el tipo de venta..." name="tipoVenta" id="tipoVenta" style="width:100%;" class="chzn-select" >
                          <option value=""></option>
                          <option value="1" title="En esta opción solo se genera una Nota de entrega para el cliente.">Sin Factura</option>
                          <option value="2">Factura + Nota de Entrega</option>
                          <option value="3">Factura Con Ajuste Por Diferencia</option>
                      </select>                  
                </div>
            </div>
            
        	<div class="campo" style="width:15%;margin-right:1%;">
            	<div class="campo_up" style="width:11.5%"><label style="margin-left:0.5%">Tipo de Pago</label></div>
                <div class="campo_down" style="width:11.5%">
                     <select data-placeholder="Seleccione el tipo de pago..." name="tipoPago" id="tipoPago" style="width:100%;" class="chzn-select" >
                          <option value=""></option>
                          <option value="1">Contado</option>
                          <option value="2">Credito</option>
                      </select>                  
                </div>
            </div>            
            <div class="campo" style="width:7%;margin-right:0px;">
            	<div class="campo_up" style="width:7%"></div>
                <div class="campo_down" style="width:7%">
                	<button style="font-size:11px;font-family: 'Oswald', sans-serif; margin-top:-2px;" name="aceptar" id="aceptar">Aceptar</button>
                </div>                        
            </div>   
                                                      
        </div>
        
        <div id="refresca" style="float:left; height:auto; width:100%;" >
        
        
        </div>  
                                       
	</div>
    </form>                   
	<div class="pie"></div>
</body>
<script type="text/javascript" language="javascript"> 

	function actualizarTipo1(indice){
		
		document.getElementById("unidades"+indice).value=parseFloat(document.getElementById("unidades"+indice).value).toFixed(2);
		document.getElementById("kilogramos"+indice).value=parseFloat(document.getElementById("kilogramos"+indice).value).toFixed(2);
		document.getElementById("precio"+indice).value=parseFloat(document.getElementById("precio"+indice).value).toFixed(2);
		
		document.getElementById("subtotal"+indice).value=parseFloat(parseFloat(document.getElementById("precio"+indice).value)*parseFloat(document.getElementById("kilogramos"+indice).value)).toFixed(2);
		
		if(document.getElementById("iva"+indice).value=="0.00"){
			document.getElementById("total"+indice).value=document.getElementById("subtotal"+indice).value;
		}else{
			document.getElementById("total"+indice).value=parseFloat((parseFloat(document.getElementById("subtotal"+indice).value)*parseFloat(1.12))).toFixed(2);
		}
		
		var lista = document.getElementById("productosSeleccionados").value;	 	 
		arrayLista = lista.split("-"); 
		var acumulaExcento=0;
		var acumulaGravable=0;
		for(var i=0;i<(arrayLista.length-1);i++){			
			if(document.getElementById("iva"+arrayLista[i]).value=="0.00"){
			acumulaExcento=parseFloat(parseFloat(acumulaExcento)+parseFloat(document.getElementById("subtotal"+arrayLista[i]).value)).toFixed(2);
			}else{
			acumulaGravable=parseFloat(parseFloat(acumulaGravable)+parseFloat(document.getElementById("subtotal"+arrayLista[i]).value)).toFixed(2);
			}
		}
		
		document.getElementById("excento").value=acumulaExcento;
		document.getElementById("gravables").value=acumulaGravable;
		document.getElementById("subtotal").value=parseFloat(parseFloat(acumulaExcento)+parseFloat(acumulaGravable)).toFixed(2);
		
		document.getElementById("etiExcento").innerHTML=document.getElementById("excento").value;					
		document.getElementById("etiGravables").innerHTML=document.getElementById("gravables").value;	
		document.getElementById("etiSubtotal").innerHTML=document.getElementById("subtotal").value;	
		document.getElementById("etiIva").innerHTML=parseFloat(parseFloat(document.getElementById("gravables").value)*parseFloat(0.12)).toFixed(2);		
		document.getElementById("etiTotal").innerHTML= parseFloat(parseFloat(document.getElementById("subtotal").value)+parseFloat(document.getElementById("etiIva").innerHTML)).toFixed(2);
	}

    $(function() {
      $("button")
        .button()
        .click(function( event ) {
          event.preventDefault();
        });
    });

	$(function(){
	    $("#aceptar").click(function(){
			var band=0;			
			if(document.getElementById("nombreCliente").value==0 && band==0){
				band=1;
				alert("Debe seleccionar el cliente a quien va facturar la venta.");
			}
			if(document.getElementById("tipoPrecio").value==0 && band==0){
				band=1;
				alert("Debe seleccionar el tipo de precio con que se va a facturar la venta.");
			}
			if(document.getElementById("tipoVenta").value==0 && band==0){
				band=1;
				alert("Debe seleccionar el tipo de venta que llevara a cabo.");
			}
			if(document.getElementById("tipoPago").value==0 && band==0){
				band=1;
				alert("Debe indicar el tipo de pago.");
			}			
			
			if(band==0){				
				$("#refresca").load("../recursos/funciones/ajaxVenta.php", {indice: 2, cliente: document.getElementById("nombreCliente").value,precio:document.getElementById("tipoPrecio").value, tipodeventa:document.getElementById("tipoVenta").value, tipodepago:document.getElementById("tipoPago").value},function(){
					$("#listaProductos").chosen({no_results_text: "No se han encontrado resultados para: "});
				        
      				$("button")
			        .button()
			        .click(function( event ) {
			          event.preventDefault();
			        });
   
						
				});				
			}
									
		});
	});
	
	function elimina(indice){

		var lista = document.getElementById("productosSeleccionados").value;	 	 
		arrayLista = lista.split("-"); 
		var nuevaLista="";
		for(var i=0;i<(arrayLista.length-1);i++){	
			if(arrayLista[i]!=indice){
				nuevaLista=nuevaLista+arrayLista[i]+"-";
			}
		}
		document.getElementById("productosSeleccionados").value=nuevaLista;
		
		var lista = document.getElementById("productosSeleccionados").value;	 	 
		arrayLista = lista.split("-"); 
		var acumulaExcento=0;
		var acumulaGravable=0;
		for(var i=0;i<(arrayLista.length-1);i++){			
			if(document.getElementById("iva"+arrayLista[i]).value=="0.00"){
			acumulaExcento=parseFloat(parseFloat(acumulaExcento)+parseFloat(document.getElementById("subtotal"+arrayLista[i]).value)).toFixed(2);
			}else{
			acumulaGravable=parseFloat(parseFloat(acumulaGravable)+parseFloat(document.getElementById("subtotal"+arrayLista[i]).value)).toFixed(2);
			}
		}
		
		document.getElementById("excento").value=acumulaExcento;
		document.getElementById("gravables").value=acumulaGravable;
		document.getElementById("subtotal").value=parseFloat(parseFloat(acumulaExcento)+parseFloat(acumulaGravable)).toFixed(2);
		
		document.getElementById("etiExcento").innerHTML=document.getElementById("excento").value;					
		document.getElementById("etiGravables").innerHTML=document.getElementById("gravables").value;	
		document.getElementById("etiSubtotal").innerHTML=document.getElementById("subtotal").value;	
		document.getElementById("etiIva").innerHTML=parseFloat(parseFloat(document.getElementById("gravables").value)*parseFloat(0.12)).toFixed(2);		
		document.getElementById("etiTotal").innerHTML= parseFloat(parseFloat(document.getElementById("subtotal").value)+parseFloat(document.getElementById("etiIva").innerHTML)).toFixed(2);		
		
		$("#linea"+indice).remove();
		$("#contieneLista").load("../recursos/funciones/ajaxVenta.php", {indice: 1, seleccionados: document.getElementById("productosSeleccionados").value},function(){
		$("#listaProductos").chosen({no_results_text: "No se han encontrado resultados para: "});		
		});
		
		
	}					

	$("#ubicacionCliente").chosen({no_results_text: "No se han encontrado resultados para: "});
	$("#nombreCliente").chosen({no_results_text: "No se han encontrado resultados para: "});
	$("#tipoPrecio").chosen({no_results_text: "No se han encontrado resultados para: "});	
	$("#tipoVenta").chosen({no_results_text: "No se han encontrado resultados para: "});
	$("#tipoPago").chosen({no_results_text: "No se han encontrado resultados para: "});
	$("#listaProductos").chosen({no_results_text: "No se han encontrado resultados para: "});     
	 
  function ajustar(){	  
	  $("#menu").css("height", $("#cuerpo").css("height"));  
  }  
</script>
</html>