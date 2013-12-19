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
<title>Abono Cuentas Por Cobrar</title>

<style>
	.linea_titulo{
		float:left;
		width:97.5%;
		margin-left:1%;
		height:30px;
		border-top:1px solid #999;
		border-bottom:1px solid #999;
		font-size:12px;
		line-height:30px;
		font-family: 'Oswald', sans-serif;	
		font-weight:300;
		padding-left:0.5%;						
	}
		
	
	.linea_contiene{
		margin-top:0px;
		float:left;
		width:98%;
		margin-left:1%;
		height:50px;
		border-bottom:1px solid #999;
		font-size:12px;
		line-height:25px;
		font-family: 'Oswald', sans-serif;						
	}	
	
	.elemento_contiene{
		float:left;
		width:33%;
		height:50px;
		margin-right:0.5%;	
	}
	
	.elemento_arriba{
		float:left;
		width:100%;
		height:20px;
		line-height:20px;
		padding-left:1%;
		width:99%;
		font-size:11px;
	}	
	.elemento_abajo{
		float:left;
		width:100%;
		height:30px;		
	}
	.ui-widget { font-family: Verdana,Arial,sans-serif; font-size: .7em; }
	
	
	.linea_titulod{
		margin-top:15px;
		float:left;
		width:98%;
		margin-left:1%;
		height:25px;
		border:1px solid #999;
		background:#CCC;
		font-family: 'Oswald', sans-serif;
		font-size: 11px;												
	}
	
	.columnad{
		float:left;
		height:25px;
		border-right:1px solid #999;
		padding-left:0.5%;
		line-height:25px;	
		text-align:center;				
	}
	
	.columnafila{
		float:left;
		height:25px;
		border-right:1px solid #999;
		padding-left:0.5%;
		line-height:25px;	
		text-align:left;
		font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;					
	}	
		
		
	.linea_filad{		
		float:left;
		width:98%;
		margin-left:1%;
		height:25px;
		border:1px solid #999;
		border-top:0px;		
		font-family: 'Oswald', sans-serif;
		font-size: 12px;
														
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
        <div class="barra2_pantalla">Abono Cuentas Por Cobrar</div>
    </div>
    <div class="menu" id="menu">
    	<?php menu_interno(); ?>
    </div>
	<div class="cuerpo" id="cuerpo">
    
    	<form name="formabono" id="formabono" method="post" action="../recursos/funciones/ajaxAbono.php?action=5" >
		<div class="linea_titulo">Detalle Pago</div>
        <div class="linea_contiene">
        	<div class="elemento_contiene" style="width:18%">
            	<div class="elemento_arriba">Cliente</div>
                <div class="elemento_abajo">
                     <select data-placeholder="Cliente..." name="nombreCliente" id="nombreCliente" style="width:100%;" class="chzn-select" >
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
            
        	<div class="elemento_contiene" style="width:11%">
            	<div class="elemento_arriba">Tipo de Pago</div>
                <div class="elemento_abajo">
                     <select data-placeholder="Tipo de Pago..." onchange="cambia()" name="tipoPago" id="tipoPago" style="width:100%;" class="chzn-select" >
                          <option value=""></option>
						  <option value="1">Efectivo</option>
                          <option value="2">Deposito</option>
                          <option value="3">Transferencia</option>
                          <option value="4">Cheque</option>
                      </select>                  
                </div>
            </div>   
            
           
            <div id="actualiza">
        	<div class="elemento_contiene" style="width:16%">
            	<div class="elemento_arriba">Banco de Origen</div>
                <div class="elemento_abajo">
                     <select data-placeholder="Seleccione el Banco..."  name="banco" id="banco" style="width:100%;" class="chzn-select" >
                          <option value=""></option>
                          <?
								$con=Conectarse();
								$sql_banco="select * from banco order by nombre;";
								$result_banco=pg_exec($con,$sql_banco);
								for($i=0;$i<pg_num_rows($result_banco);$i++){
									$banco=pg_fetch_array($result_banco,$i);
									echo "<option value='".$banco[0]."'>".$banco[1]."</option>";																			
								}
						 ?>	
                      </select>                  
                </div>
            </div>    
            
        	<div class="elemento_contiene" style="width:22%">
            	<div class="elemento_arriba">Cuenta Destino</div>
                <div class="elemento_abajo">
                     <select data-placeholder="Seleccione la cuenta destino..." name="cuenta" id="cuenta" style="width:100%;" class="chzn-select" >
                          <option value=""></option>
                          <?
								$con=Conectarse();
								$sql_cuenta="select * from cuenta where tipopropietario='Empresa' order by numerocuenta;";
								$result_cuenta=pg_exec($con,$sql_cuenta);
								for($i=0;$i<pg_num_rows($result_cuenta);$i++){
									$cuenta=pg_fetch_array($result_cuenta,$i);
									$sql_banco="select * from banco where idbanco=".$cuenta[1]."";
									$result_banco=pg_exec($con,$sql_banco);
									$banco=pg_fetch_array($result_banco);
									echo "<option value='".$cuenta[0]."'> ".$banco[1]." ".$cuenta[4]."</option>";																			
								}
						 ?>	
                      </select>                  
                </div>
            </div>                                             
            
        	<div class="elemento_contiene" style="width:8%">
            	<div class="elemento_arriba">Monto</div>
                <div class="elemento_abajo">
					<input type="text" name="monto" id="monto" value="" style="width:100%; text-align:right; padding-right:3%; font-family: 'Oswald', sans-serif; height:25px; font-size:12px;"  />               
                </div>
            </div>
            
        	<div class="elemento_contiene" style="width:8%">
            	<div class="elemento_arriba">Identificador</div>
                <div class="elemento_abajo">
					<input type="text" name="identificador" id="identificador" value="" style="width:100%; text-align:right; padding-right:3%; font-family: 'Oswald', sans-serif; height:25px;"  />               
                </div>
            </div>             
            </div>
            
        	<div class="elemento_contiene" style="width:8%">
            	<div class="elemento_arriba">Fecha de pago</div>
                <div class="elemento_abajo">
                <input type="text" name="fecha" id="fecha" value="" style="width:100%; height:25px; padding-left:5%; font-family: 'Oswald', sans-serif;" />
                </div>
            </div>                
        	<div class="elemento_contiene" style="width:5%; margin-right:0px;">
            	<div class="elemento_arriba"></div>
                <div class="elemento_abajo">
					<input type="submit" value="Cargar" name="Cargar" id="Cargar" style="width:97%; font-size:11px; font-family: 'Oswald', sans-serif; height:25px; text-align:center"  />               
                </div>
            </div>                          
            
        </div>
        
        
        <div id="actualizadeudas">
        
        </div>                      	                             
        </form>
    </div>                 
	<div class="pie"></div>
</body>
<script type="text/javascript" language="javascript">

	function cambia(){
		
		if(document.getElementById("tipoPago").value==1){/*Efectivo*/		
			$("#actualiza").load("../recursos/funciones/ajaxAbono.php", {action: 1},function(){
				$("#banco").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#cuenta").chosen({no_results_text: "No se han encontrado resultados para: "});				
			});
		}													
		if(document.getElementById("tipoPago").value==2){/*Deposito*/
			$("#actualiza").load("../recursos/funciones/ajaxAbono.php", {action: 2},function(){
				$("#banco").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#cuenta").chosen({no_results_text: "No se han encontrado resultados para: "});	
			});			
		}
		if(document.getElementById("tipoPago").value==3 || document.getElementById("tipoPago").value==4){/*Transferencia o Cheque*/
			$("#actualiza").load("../recursos/funciones/ajaxAbono.php", {action: 3},function(){
				$("#banco").chosen({no_results_text: "No se han encontrado resultados para: "});
				$("#cuenta").chosen({no_results_text: "No se han encontrado resultados para: "});	
			});			 
		}
						
	}

	$(function(){
	    $("#Cargar").click(function(){
			var band=0;
			if(document.getElementById("nombreCliente").value==0 && band==0){
				alert("Debe indicar el nombre del cliente que esta realizando el abono.");
				band=1;
			}
			if(document.getElementById("tipoPago").value==0 && band==0){
				alert("Debe indicar el tipo de pago que se esta registrando.");
				band=1;
			}
		
			
			if(document.getElementById("tipoPago").value==1 && band==0){
				if(document.getElementById("monto").value==0 && band==0){
					alert("Debe indicar el monto del pago.");
					band=1;
				}				
			}
			
			if(document.getElementById("tipoPago").value==2 && band==0){
				
				if(document.getElementById("cuenta").value==0 && band==0){
					alert("Debe indicar la cuenta en la que se realizo el deposito.");
					band=1;
				}	
												
				if(document.getElementById("monto").value==0 && band==0){
					alert("Debe indicar el monto del pago.");
					band=1;
				}
				
				if(document.getElementById("identificador").value==0 && band==0){
					alert("Debe indicar el identificador del deposito que se realizo.");
					band=1;
				}																	
			}
			
			if((document.getElementById("tipoPago").value==3 || document.getElementById("tipoPago").value==4) && band==0){
				
				if(document.getElementById("banco").value==0 && band==0){
					alert("Debe indicar el banco desde el cual se origino la operación.");
					band=1;
				}					
				
				if(document.getElementById("cuenta").value==0 && band==0){
					alert("Debe indicar la cuenta en la que se realizo el deposito.");
					band=1;
				}	
												
				if(document.getElementById("monto").value==0 && band==0){
					alert("Debe indicar el monto del pago.");
					band=1;
				}
				
				if(document.getElementById("identificador").value==0 && band==0){
					alert("Debe indicar el identificador del deposito que se realizo.");
					band=1;
				}																	
			}	
			
			if(document.getElementById("fecha").value==0 && band==0){
				alert("Debe indicar la fecha en que el cliente realizo el pago.");
				band=1;
			}	
			
			if(band==0){
				$("#actualizadeudas").load("../recursos/funciones/ajaxAbono.php", {action: 4,cliente:document.getElementById("nombreCliente").value},function(){
					ajustar();
					
				  	$(function() {
				    $( "input[type=submit], button" )
				      .button()
				      .click(function( event ) {
				        event.preventDefault();
			    	  });
					});																
				});					
			}
												
		});		
	});
	
	
	
	
											
  	$(function() {
    $( "input[type=submit]" )
      .button()
      .click(function( event ) {
        event.preventDefault();
      });
	});
    	        
    $(function() {
		$("#nombreCliente").chosen({no_results_text: "No se han encontrado resultados para: "});
		$("#tipoPago").chosen({no_results_text: "No se han encontrado resultados para: "});
		$("#banco").chosen({no_results_text: "No se han encontrado resultados para: "});
		$("#cuenta").chosen({no_results_text: "No se han encontrado resultados para: "});
    });  
  		  
    function ajustar(){	  
	  	$("#menu").css("height", $("#cuerpo").css("height"));  
    }
	
    $(function() {
    	$( "#fecha" ).datepicker({
			showWeek: true,
			dateFormat: 'yy-mm-dd',
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
	
	
	$(document).ready(function(){ 
		$("#monto").keydown(function(event) {
		   if(event.shiftKey)
		   {
		        event.preventDefault();
		   }
		 
		   if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190)    {
		   }
		   else {
		        if (event.keyCode < 95) {
		          if (event.keyCode < 48 || event.keyCode > 57) {
		                event.preventDefault();
		          }
	        } 
	        else {
	              if (event.keyCode < 96 || event.keyCode > 105) {
	                  event.preventDefault();
	              }
	        }
	      }
	   });
	});	
  
</script>
</html>