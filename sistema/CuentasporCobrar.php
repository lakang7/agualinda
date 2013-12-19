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
<title>Cuentas Por Cobrar</title>
    <link href="../recursos/js/scrollbar/perfect-scrollbar.css" rel="stylesheet">
   <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
    <script src="../recursos/js/scrollbar/jquery.mousewheel.js"></script>
    <script src="../recursos/js/scrollbar/perfect-scrollbar.js"></script>
<style type="text/css">
	.panel_izquierda{
		float:left;
		/*background:#999;*/
		width:25%;
		height:530px;
		margin-left:10px;
		font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;	
	}
	
	.panel_derecha{
		float:left;
		width:70%;
		height:auto;
		margin-left:2%;		
		font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;			
	}
	
	.panel_contiene{
		float:left;
		width:100%;
		height:100px;
		/*border-bottom:1px solid #666;*/
		border:1px solid #666;
		margin-bottom:8px;	
	}
	.panel_titulo{
		float:left;
		width:98%;
		height:20px;
		line-height:20px;
		padding-left:2%;
		font-size:12px;	
		border-bottom:1px solid #666;
		background:#84cff7;
	}
	.panel_lista{
		/*background:#F00;*/
		float:left;
		width:98%;
		height:79px;
		line-height:20px;
		font-size:12px;			
	}	
	
	.opcion_lista{
		float:left;
		width:99%;
		height:19px;
		font-size:11px;
		line-height:19px;
		/*border-top:1px solid #666;*/

	}
	
	.opcion_lista:hover{
		float:left;
		width:99%;
		height:19px;
		font-size:11px;
		line-height:19px;
	   /* border-top:1px solid #666;*/
		background:#F0F0F0;
	}	
	
	.panel_resume{
		float:left;
		width:99.5%;
		padding-left:0.5%;
		height:20px;
		border:1px solid #666;
		font-size:12px;
		line-height:20px;	
		background:#84cff7;
	}
	
	.panel_detalle_resume{
		float:left;		
		width:100%;
		height:auto;
		/*border-bottom:1px solid #666;	*/
	}
	
	.panel_detalle_columna{
		float:left;
		width:33%;
		height:auto;
		border-right:1px solid #666;
	}	
	.panel_detalle_columna_titulo{
		float:left;	
		line-height:20px;
		font-size:12px;
		padding-left:2%;
		width:98%;
		border-bottom:1px solid #666;		
	}	
	.panel_detalle_columna_opcion{
		float:left;		
		padding-left:2%;
		width:98%;
		height:60px;
		border-bottom:1px solid #666;
	}
	
	.panel_detalle_columna_opcion_titulo{
		float:left;
		width:100%;
		height:20px;
		line-height:20px;
		font-size:12px;	
		/*text-decoration:underline;*/
		background:#E4E4E4;
		margin-left:-2%;
		padding-left:2%;
		border-bottom:1px solid #666;		
	}
	
	.panel_detalle_columna_opcion_cuentas{
		float:left;
		width:30%;
		height:40px;
		line-height:30px;
		font-size:22px;			
	}
	.panel_detalle_columna_opcion_monto{
		float:left;
		width:68%;
		height:40px;
		padding-left:1%;
		line-height:30px;
		font-size:22px;			
	}
	
	.panel_detalle_columna_subtitulo{
		float:left;
		width:100%;
		height:15px;
		font-size:10px;
		line-height:15px;	
	}
	.panel_detalle_columna_texto{
		float:left;
		width:100%;
		height:20px;
		font-size:14px;
		line-height:15px;	
	}	

	.panel_detalle_lista{
		float:left;		
		width:100%;
		height:auto;
		margin-top:10px;
		
	}
	
	.panel_detalle_cabecera{
		float:left;
		width:100%;
		height:20px;
		border-bottom:1px solid #666;	
		border-top:1px solid #666;
		background:#84cff7;
	}
	
	.cabecera_columna{
		float:left;
		width:10%;
		border-right:1px solid #666;
		height:20px;
		line-height:20px;
		font-size:12px;	
		padding-left:0.5%;
	}
	
	.panel_detalle_linea{
		float:left;
		width:100%;
		height:20px;
		border-bottom:1px solid #666;
		cursor:pointer;	
	}
	
	.panel_detalle_linea:hover{
		float:left;
		width:100%;
		height:20px;
		border-bottom:1px solid #666;	
		background:#F0F0F0;
	}	
	
	.linea_columna{
		float:left;
		width:10%;
		border-right:1px solid #666;
		height:20px;
		line-height:20px;
		font-size:11px;	
		padding-left:0.5%;
	}
      
	  #lista1 {
        height:81px;
        width: 20%;
        overflow: hidden;
        position: absolute;
		margin-top:21px;

      }	
	  	
	  #lista2 {
        height:81px;
        width: 20%;
        overflow: hidden;
        position: absolute;
		margin-top:21px;
      }	
	  
	  #lista3 {
        height:81px;
        width: 20%;
        overflow: hidden;
        position: absolute;
		margin-top:21px;
      }	
	  
	  #lista4 {
        height:98px;
        width: 20%;
        overflow: hidden;
        position: absolute;
		margin-top:21px;
      }	 
	  
	  .tipo_fecha{
			float:left;
			width:99%;
			padding-left:1%;
			/*border-bottom:1px solid #666;*/
			height:45px; 
			font-size:11px; 
	  }
	  
	  .contiene_desde{
			float:left;
			width:37%;
			height:45px;
			border-right:1px solid #666;  
	  }
	  
	  .contiene_desde_arriba{
			float:left;
			padding-left:2%;
			width:98%;
			height:15px;
			font-size:10px;
			line-height:15px;  
	  }	
	  
	  .contiene_desde_abajo{
			float:left;
			width:100%;
			height:20px;
			font-size:10px;
			line-height:15px;  
	  }		  
	  

	  .ui-widget { font-family: Verdana,Arial,sans-serif; font-size: .7em; }
  
	  

</style>
<script type="text/javascript" language="javascript">
	$(function() {
        $('#lista1').perfectScrollbar();				
    });

    $(function() {
    	$( "#desde" ).datepicker({
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
		$( "#hasta" ).datepicker({
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
  </script>
</head>

<body onload="ajustar()">
	<div class="barra1">
    	<div class="barra1_icon"><img src="../recursos/imagenes/CowLogo.PNG" width="45" height="40" /></div>
   	  	<div class="barra1_sistema">Sistema Para La Gestíón De La Industria Lactea</div>
	</div>
    <div class="barra2">
    	<div class="barra2_flecha"></div>                
        <div class="barra2_pantalla">Cuentas Por Cobrar</div>
    </div>
    <div class="menu" id="menu">
    	<?php menu_interno(); ?>
    </div>
	<div class="cuerpo" id="cuerpo" >
  		<div class="panel_izquierda">
        	<input type="hidden" name="ubicacion" id="ubicacion" value="" />
            <input type="hidden" name="precio" id="precio" value="" />
        	<input type="hidden" name="tipodeventa" id="tipodeventa" value="" />
            <input type="hidden" name="cliente" id="cliente" value="" />
                        
        	<div class="panel_contiene" style="height:70px; border-top:1px solid #666; border-bottom:1px solid #666; border-left:0px; border-right:0px;">
            	<div class="panel_titulo" >Fecha</div>
                <div class="tipo_fecha" style="padding-left:0px;">
                	<div class="contiene_desde" style="border-right:0px;">
                    	<div class="contiene_desde_arriba">Desde:</div>
                        <div class="contiene_desde_abajo"><input type="text" name="desde" id="desde" style="float:left; margin-left:2%; width:90%; padding-left:2%;font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif; font-size:11px;" /></div>
                    </div>
                    <div class="contiene_desde" style="border-right:0px;">
<div class="contiene_desde_arriba">Hasta:</div>
                        <div class="contiene_desde_abajo"><input type="text" name="hasta" id="hasta" style="float:left; margin-left:2%; width:90%; padding-left:2%;font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif; font-size:11px" /></div>                    
                    </div>
                    <div class="contiene_desde" style="border-right:0px; width:25%">
						<div class="contiene_desde_arriba"></div>
                        <div class="contiene_desde_abajo"><input type="submit" style="font-size:10px;" name="Filtrar" id="Filtrar" value="Filtrar" /></div>                    
                    </div>                    
                </div>
                
            </div>
        	<div class="panel_contiene" style="height:100px;">
            	<div class="panel_titulo">Ubicación</div> 
                <div id="lista1" class="panel_lista">
                    <?php
                    	$con=Conectarse();
						$sql_ubicacion="select * from ubicacion order by ciudad";
						$result_ubicacion=pg_exec($con,$sql_ubicacion);
						for($i=0;$i<pg_num_rows($result_ubicacion);$i++){
							$ubicacion=pg_fetch_array($result_ubicacion,$i);
							if($i<(pg_num_rows($result_ubicacion)-1)){
								echo "<div class='opcion_lista'>";
							}else{
								echo "<div class='opcion_lista' >";
							}							
		                    
		                    echo "<input type='checkbox' onchange=seleccionado('ubicacion',".$ubicacion[0].") name='ubicacion".$ubicacion[0]."' id='ubicacion".$ubicacion[0]."' value='".$ubicacion[0]."' style='float:left'>";
		                    echo "<label for='ubicacion".$ubicacion[0]."' style='cursor:pointer'>".$ubicacion[2]."</label>";
		                    echo "</div>";
						}
					?>                	
                </div>               
            </div>  
        	<div class="panel_contiene" style="height:100px;">
            	<div class="panel_titulo">Precio Venta</div>
                <div id="lista2" class="panel_lista">                	
                    <?php
                    	$con=Conectarse();
						$sql_precio="select * from tipoprecio order by descripcion";
						$result_precio=pg_exec($con,$sql_precio);
						for($i=0;$i<pg_num_rows($result_precio);$i++){
							$precio=pg_fetch_array($result_precio,$i);
							if($i<(pg_num_rows($result_precio)-1)){
								echo "<div class='opcion_lista'>";
							}else{
								echo "<div class='opcion_lista' >";
							}								
		                    echo "<input type='checkbox' onchange=seleccionado('precio',".$precio[0].") name='precio".$precio[0]."' id='precio".$precio[0]."' value='".$precio[0]."' style='float:left'>";
		                    echo "<label for='precio".$precio[0]."' style='cursor:pointer'>".$precio[2]."</label>";
		                    echo "</div>";
						}
					?> 
                </div>                
            </div>    
        	<div class="panel_contiene" style="height:100px;">
            	<div class="panel_titulo">Tipo de Venta</div>
                <div id="lista3" class="panel_lista">                	
					<?php
		            echo "<div class='opcion_lista'>";
		            echo "<input type='checkbox' name='tipventa1' onchange=seleccionado('tipodeventa',1) id='tipventa1' value='1' style='float:left'>";
		            echo "<label for='tipventa1' style='cursor:pointer' > Sin Factura</label>";
		            echo "</div>";			
		            echo "<div class='opcion_lista' >";
		            echo "<input type='checkbox' name='tipventa2' onchange=seleccionado('tipodeventa',2) id='tipventa2' value='2' style='float:left'>";
		            echo "<label for='tipventa2' style='cursor:pointer' >Con Factura</label>";
		            echo "</div>";													
					?>                                     
                </div>                
            </div>                                
        	<div class="panel_contiene" style="height:120px;">
            	<div class="panel_titulo">Cliente</div>
                <div id="lista4" class="panel_lista">                	
                    <?php
                    	$con=Conectarse();
						$sql_cliente="select * from cliente order by nombre";
						$result_cliente=pg_exec($con,$sql_cliente);
						for($i=0;$i<pg_num_rows($result_cliente);$i++){
							$cliente=pg_fetch_array($result_cliente,$i);
							if($i<(pg_num_rows($result_cliente)-1)){
								echo "<div class='opcion_lista'>";
							}else{
								echo "<div class='opcion_lista' >";
							}								
		                    echo "<input type='checkbox' onchange=seleccionado('cliente',".$cliente[0].") name='cliente".$cliente[0]."' id='cliente".$cliente[0]."' value='".$cliente[0]."' style='float:left'>";
		                    echo "<label for='cliente".$cliente[0]."' style='cursor:pointer'>".$cliente[1]."</label>";
		                    echo "</div>";
						}
					?>                    
                </div>                
            </div>            
        </div>
        <div class="panel_derecha" id="panel_derecha">
        	<?php
				$con=Conectarse();
				$sql_listaCuentas="select cuentaporcobrar.idcuentaporcobrar, venta.idventa, cliente.idcliente, cliente.nombre, ubicacion.idubicacion, ubicacion.ciudad, venta.tipoventa, venta.tipopago, tipoprecio.idtipoprecio, tipoprecio.descripcion, cuentaporcobrar.montototal, cuentaporcobrar.cancelado, cuentaporcobrar.restante, cuentaporcobrar.estatus, venta.fecha, ((cuentaporcobrar.cancelado*100)/cuentaporcobrar.montototal) as porcentaje from tipoprecio, ubicacion, cuentaporcobrar, cliente, venta where cuentaporcobrar.idventa = venta.idventa and venta.idcliente = cliente.idcliente and venta.idubicacion = ubicacion.idubicacion and tipoprecio.idtipoprecio = venta.tipoprecio and (cuentaporcobrar.estatus = 1 or cuentaporcobrar.estatus = 2) order by cuentaporcobrar.idcuentaporcobrar";
				$result_listaCuentas=pg_exec($con,$sql_listaCuentas);				
			?>
        	<div class="panel_resume" style="width:99%"  >Resumen Cuentas por Cobrar</div>
            <div class="panel_detalle_resume" >
            	<div class="panel_detalle_columna" style="border-left:1px solid #666" >
                	<div class="panel_detalle_columna_titulo" >Ubicación</div>
                    <?php 
						$sql_listaUbicaciones="select * from ubicacion;";
						$result_listaUbicaciones=pg_exec($con,$sql_listaUbicaciones);
						$cuentaGeneral=0;
						$acumulaGeneral=0;						
						for($i=0;$i<pg_num_rows($result_listaUbicaciones);$i++){
							$ubicacion=pg_fetch_array($result_ubicacion,$i);
							$acumulaCuentas=0;
							$acumulaDeuda=0;
							for($j=0;$j<pg_num_rows($result_listaCuentas);$j++){
								$cuenta=pg_fetch_array($result_listaCuentas,$j);
								if($ubicacion[0]==$cuenta[4]){
									$acumulaCuentas++;
									$acumulaDeuda+=$cuenta[12];	
									$cuentaGeneral++;
									$acumulaGeneral+=$cuenta[12];
								}
							}
							
	                    echo "<div class='panel_detalle_columna_opcion' >";
                    	echo "<div class='panel_detalle_columna_opcion_titulo'>".$ubicacion[2]."</div>";
                        echo "<div class='panel_detalle_columna_opcion_cuentas' style='border-right:1px solid #666'>";
                        echo "<div class='panel_detalle_columna_subtitulo'>Cuentas</div>";
						echo "<div class='panel_detalle_columna_texto'>".$acumulaCuentas."</div>";                        
                        echo "</div>";
                        echo "<div class='panel_detalle_columna_opcion_monto'>";
                        echo "<div class='panel_detalle_columna_subtitulo'>Monto</div>";
                        echo "<div class='panel_detalle_columna_texto'>".number_format(round($acumulaDeuda,2),2,'.','')."</div>";
                        echo "</div>";
                    	echo "</div>";																				
						}
						
	                    echo "<div class='panel_detalle_columna_opcion' >";
                    	echo "<div class='panel_detalle_columna_opcion_titulo' style='background:#84cff7'>Total</div>";
                        echo "<div class='panel_detalle_columna_opcion_cuentas' style='border-right:1px solid #666'>";
                        echo "<div class='panel_detalle_columna_subtitulo'>Cuentas</div>";
						echo "<div class='panel_detalle_columna_texto'>".$cuentaGeneral."</div>";                        
                        echo "</div>";
                        echo "<div class='panel_detalle_columna_opcion_monto'>";
                        echo "<div class='panel_detalle_columna_subtitulo'>Monto</div>";
                        echo "<div class='panel_detalle_columna_texto'>".number_format(round($acumulaGeneral,2),2,'.','')."</div>";
                        echo "</div>";
                    	echo "</div>";						
					?>                                                                           
                </div>
            	<div class="panel_detalle_columna">
                	<div class="panel_detalle_columna_titulo">Precio de Venta</div>
                    <?php 
						$sql_listaPrecios="select * from tipoprecio;";
						$result_listaPrecios=pg_exec($con,$sql_listaPrecios);
						for($i=0;$i<pg_num_rows($result_listaPrecios);$i++){
							$precio=pg_fetch_array($result_listaPrecios,$i);
							$acumulaCuentas=0;
							$acumulaDeuda=0;
							for($j=0;$j<pg_num_rows($result_listaCuentas);$j++){
								$cuenta=pg_fetch_array($result_listaCuentas,$j);
								if($precio[0]==$cuenta[8]){
									$acumulaCuentas++;
									$acumulaDeuda+=$cuenta[12];	
								}
							}
							
	                    echo "<div class='panel_detalle_columna_opcion' >";
                    	echo "<div class='panel_detalle_columna_opcion_titulo' >".$precio[2]."</div>";
                        echo "<div class='panel_detalle_columna_opcion_cuentas' style='border-right:1px solid #666'>";
                        echo "<div class='panel_detalle_columna_subtitulo'>Cuentas</div>";
						echo "<div class='panel_detalle_columna_texto'>".$acumulaCuentas."</div>";                        
                        echo "</div>";
                        echo "<div class='panel_detalle_columna_opcion_monto'>";
                        echo "<div class='panel_detalle_columna_subtitulo'>Monto</div>";						
                        echo "<div class='panel_detalle_columna_texto'>".number_format(round($acumulaDeuda,2),2,'.','')."</div>";
                        echo "</div>";
                    	echo "</div>";																				
						}
					?>                                           
                </div>
            	<div class="panel_detalle_columna" style="border-right:1px solid #666; width:33.2%">
                	<div class="panel_detalle_columna_titulo">Tipo de Venta</div>
                    <?php
					        $cuentasCon=0;
							$cuentasSin=0;
							$acumulaCon=0;
							$acumulaSin=0;
							for($j=0;$j<pg_num_rows($result_listaCuentas);$j++){
								$cuenta=pg_fetch_array($result_listaCuentas,$j);								
								if($cuenta[6]==1){
									$cuentasSin++;
									$acumulaSin+=$cuenta[12];									
								}else if($cuenta[6]==2 || $cuenta[6]==3 || $cuenta[6]==4){
									$cuentasCon++;
									$acumulaCon+=$cuenta[12];
								}
							}					
					
					?>
                                        
 					<div class="panel_detalle_columna_opcion">
                    	<div class="panel_detalle_columna_opcion_titulo">Con Factura</div>
                        <div class="panel_detalle_columna_opcion_cuentas" style="border-right:1px solid #666">
                        	<div class="panel_detalle_columna_subtitulo">Cuentas</div>
                            <div class="panel_detalle_columna_texto"><?php echo $cuentasCon; ?></div>
                        </div>
                        <div class="panel_detalle_columna_opcion_monto">
                        	<div class="panel_detalle_columna_subtitulo">Monto</div>
                            <div class="panel_detalle_columna_texto"><?php echo number_format(round($acumulaCon,2),2,'.',''); ?></div>
                        </div>
                    </div>
                    <div class="panel_detalle_columna_opcion">
                    	<div class="panel_detalle_columna_opcion_titulo">Sin Factura</div>
                        <div class="panel_detalle_columna_opcion_cuentas" style="border-right:1px solid #666">
                        	<div class="panel_detalle_columna_subtitulo">Cuentas</div>
                            <div class="panel_detalle_columna_texto"><?php echo $cuentasSin; ?></div>
                        </div>
                        <div class="panel_detalle_columna_opcion_monto">
                        	<div class="panel_detalle_columna_subtitulo">Monto</div>                            
                            <div class="panel_detalle_columna_texto"><?php echo number_format(round($acumulaSin,2),2,'.',''); ?></div>
                        </div>
                    </div>                     
                </div>                                
            </div><!-- Finaliza Panel Detalle Resumen -->
            <div class="panel_detalle_lista">
            	<div class="panel_detalle_cabecera" style='border-left:1px solid #666; border-right:1px solid #666'>
                    <div class="cabecera_columna" style="width:12%; text-align:center">Fecha</div>
                    <div class="cabecera_columna" style="width:41.5%">Cliente</div>
                    <div class="cabecera_columna" style="width:12%;">Total</div>
                    <div class="cabecera_columna" style="width:12%">Cancelado</div>
                    <div class="cabecera_columna" style="width:12%;">Pendiente</div>
                    <div class="cabecera_columna" style="width:6%; text-align:center; border-right:0px;">%</div>
                </div>
                <?php 
				    $porcobrarSeleccionadas="";
					for($i=0;$i<pg_num_rows($result_listaCuentas);$i++){
						$cuenta=pg_fetch_array($result_listaCuentas,$i);
						$porcobrarSeleccionadas=$porcobrarSeleccionadas.$cuenta[0]."-";
						$tipodeventa="";
						if($cuenta[6]==1){
							$tipodeventa="Sin Factura";								
						}else if($cuenta[6]==2 || $cuenta[6]==3){
							$tipodeventa="Con Factura";
						}						
						
		                echo "<div class='panel_detalle_linea' onclick='verdetalle(".$cuenta[0].")' style='border-left:1px solid #666;  border-right:1px solid #666' title='Ubicacion: ".$cuenta[5]." --- Precio de Venta: ".$cuenta[9]." --- Tipo de Venta: ".$tipodeventa."'>";
        	        	echo "<div class='linea_columna' style='width:12%; text-align:center'>".substr($cuenta[14],0,10)."</div>";
	                    echo "<div class='linea_columna' style='width:41.5%'>".$cuenta[3]."</div>";
	                    echo "<div class='linea_columna' style='width:12%;text-align:right; padding-right:0.5%;padding-left:0px;'>".number_format(round($cuenta[10],2),2,'.','')."</div>";
	                    echo "<div class='linea_columna' style='width:12%;text-align:right; padding-right:0.5%;padding-left:0px;'>".number_format(round($cuenta[11],2),2,'.','')."</div>";
	                    echo "<div class='linea_columna' style='width:12%;text-align:right; padding-right:0.5%;padding-left:0px;'>".number_format(round($cuenta[12],2),2,'.','')."</div>";
	                    echo "<div class='linea_columna' style='width:6%; border-right:0px; text-align:right; padding-right:0.5%;padding-left:0px;'>".number_format(round($cuenta[15],2),2,'.','')."</div>";
		                echo "</div>";
					}
					
					$_SESSION["porCobrar"]=$porcobrarSeleccionadas;
				?>
                

            </div>            
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
    
	function verdetalle(id){
		location.href="DetalleCuentaPorCobrar.php?id="+id;
	}
	
	function seleccionado(filtro,id){
		if(filtro=="ubicacion"){
			var auxUbicacion=document.getElementById("ubicacion").value;
			var band=0;
			listaUbicaciones = auxUbicacion.split("-"); 
			for(var i=0;i<(listaUbicaciones.length-1);i++){	
				if(listaUbicaciones[i]==id){
					band=1;
					break;
				}
			}			
			if(band==0){
				document.getElementById("ubicacion").value+=id+"-";	
			}else{
				var buffer="";
				for(var i=0;i<(listaUbicaciones.length-1);i++){	
					if(listaUbicaciones[i]!=id){
						buffer+=listaUbicaciones[i]+"-";
					}
				}
				document.getElementById("ubicacion").value=buffer;					
			}			
		}
		if(filtro=="precio"){
			var auxPrecio=document.getElementById("precio").value;
			var band=0;
			listaPrecios = auxPrecio.split("-"); 
			for(var i=0;i<(listaPrecios.length-1);i++){	
				if(listaPrecios[i]==id){
					band=1;
					break;
				}
			}			
			if(band==0){
				document.getElementById("precio").value+=id+"-";	
			}else{
				var buffer="";
				for(var i=0;i<(listaPrecios.length-1);i++){	
					if(listaPrecios[i]!=id){
						buffer+=listaPrecios[i]+"-";
					}
				}
				document.getElementById("precio").value=buffer;					
			}			
		}
		if(filtro=="tipodeventa"){
			var auxtipodeVenta=document.getElementById("tipodeventa").value;
			var band=0;
			listaTipos = auxtipodeVenta.split("-"); 
			for(var i=0;i<(listaTipos.length-1);i++){	
				if(listaTipos[i]==id){
					band=1;
					break;
				}
			}			
			if(band==0){
				document.getElementById("tipodeventa").value+=id+"-";	
			}else{
				var buffer="";
				for(var i=0;i<(listaTipos.length-1);i++){	
					if(listaTipos[i]!=id){
						buffer+=listaTipos[i]+"-";
					}
				}
				document.getElementById("tipodeventa").value=buffer;					
			}			
		}			
		if(filtro=="cliente"){
			var auxCliente=document.getElementById("cliente").value;
			var band=0;
			listaClientes = auxCliente.split("-"); 
			for(var i=0;i<(listaClientes.length-1);i++){	
				if(listaClientes[i]==id){
					band=1;
					break;
				}
			}			
			if(band==0){
				document.getElementById("cliente").value+=id+"-";	
			}else{
				var buffer="";
				for(var i=0;i<(listaClientes.length-1);i++){	
					if(listaClientes[i]!=id){
						buffer+=listaClientes[i]+"-";
					}
				}
				document.getElementById("cliente").value=buffer;					
			}				
		}
			
		$("#panel_derecha").load("../recursos/funciones/ajaxCuentasporCobrar.php", {action: 1, ubicacion:document.getElementById("ubicacion").value, precio: document.getElementById("precio").value, tipodeventa: document.getElementById("tipodeventa").value, cliente: document.getElementById("cliente").value, desde:document.getElementById("desde").value, hasta:document.getElementById("hasta").value},function(){
			ajustar();	
		});
		
	}
	
	$(function(){
	    $("#Filtrar").click(function(){
			$("#panel_derecha").load("../recursos/funciones/ajaxCuentasporCobrar.php", {action: 1, ubicacion:document.getElementById("ubicacion").value, precio: document.getElementById("precio").value, tipodeventa: document.getElementById("tipodeventa").value, cliente: document.getElementById("cliente").value, desde:document.getElementById("desde").value, hasta:document.getElementById("hasta").value},function(){
				ajustar();	
			});						
		});		
	});
  
    function ajustar(){	 
		$("#menu").css("height", $("#cuerpo").css("height"));  
    }

    $(function() {
		$("#filtrofecha").chosen({no_results_text: "No se han encontrado resultados para: "});	
        $('#lista1').perfectScrollbar();
		$('#lista2').perfectScrollbar();
		$('#lista3').perfectScrollbar();
		$('#lista4').perfectScrollbar();
    });
  
</script>
</html>