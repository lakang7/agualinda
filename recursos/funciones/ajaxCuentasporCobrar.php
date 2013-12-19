<?php session_start();

    require("funciones.php");
    $con=Conectarse();

	if($_POST["action"]==1){
		
		$con=Conectarse();
		$sql_listaCuentas="select cuentaporcobrar.idcuentaporcobrar, venta.idventa, cliente.idcliente, cliente.nombre, ubicacion.idubicacion, ubicacion.ciudad, venta.tipoventa, venta.tipopago, tipoprecio.idtipoprecio, tipoprecio.descripcion, cuentaporcobrar.montototal, cuentaporcobrar.cancelado, cuentaporcobrar.restante, cuentaporcobrar.estatus, venta.fecha, ((cuentaporcobrar.cancelado*100)/cuentaporcobrar.montototal) as porcentaje from tipoprecio, ubicacion, cuentaporcobrar, cliente, venta where cuentaporcobrar.idventa = venta.idventa and venta.idcliente = cliente.idcliente and venta.idubicacion = ubicacion.idubicacion and tipoprecio.idtipoprecio = venta.tipoprecio and (cuentaporcobrar.estatus = 1 or cuentaporcobrar.estatus = 2) ";		
		
		$filtros_ubicacion =  explode("-",$_POST["ubicacion"]);
		$filtros_precio =  explode("-",$_POST["precio"]);
		$filtros_tipodeventa =  explode("-",$_POST["tipodeventa"]);
		$filtros_cliente =  explode("-",$_POST["cliente"]);
		
		
		$bandUbicacion=0;
		for($i=0;$i<(sizeof($filtros_ubicacion)-1);$i++){
			if($i==0){
				$sql_listaCuentas=$sql_listaCuentas." and ( ubicacion.idubicacion = ".$filtros_ubicacion[$i]." ";
			}
			if($i>0){
				$sql_listaCuentas=$sql_listaCuentas." or ubicacion.idubicacion = ".$filtros_ubicacion[$i]." ";
			}						
			if($i==(sizeof($filtros_ubicacion)-2)){
				$sql_listaCuentas=$sql_listaCuentas." ) ";
			}			
		}
		
		for($i=0;$i<(sizeof($filtros_precio)-1);$i++){
			if($i==0){
				$sql_listaCuentas=$sql_listaCuentas." and ( tipoprecio.idtipoprecio = ".$filtros_precio[$i]." ";
			}
			if($i>0){
				$sql_listaCuentas=$sql_listaCuentas." or tipoprecio.idtipoprecio = ".$filtros_precio[$i]." ";
			}						
			if($i==(sizeof($filtros_precio)-2)){
				$sql_listaCuentas=$sql_listaCuentas." ) ";
			}						
		}	
		
		for($i=0;$i<(sizeof($filtros_tipodeventa)-1);$i++){
			if($filtros_tipodeventa[$i]==1){
				if($i==0){
					$sql_listaCuentas=$sql_listaCuentas." and ( venta.tipoventa = ".$filtros_tipodeventa[$i]." ";
				}
				if($i>0){
					$sql_listaCuentas=$sql_listaCuentas." or venta.tipoventa = ".$filtros_tipodeventa[$i]." ";
				}						
				if($i==(sizeof($filtros_tipodeventa)-2)){
					$sql_listaCuentas=$sql_listaCuentas." ) ";
				}													
			}else if($filtros_tipodeventa[$i]==2){
				if($i==0){
					$sql_listaCuentas=$sql_listaCuentas." and ( venta.tipoventa = 2 or venta.tipoventa = 3 or venta.tipoventa = 4 ";
				}
				if($i>0){
					$sql_listaCuentas=$sql_listaCuentas." or venta.tipoventa = 2 or venta.tipoventa = 3 or venta.tipoventa = 4 ";
				}						
				if($i==(sizeof($filtros_tipodeventa)-2)){
					$sql_listaCuentas=$sql_listaCuentas." ) ";
				}											
			}
			
		}				
		
		for($i=0;$i<(sizeof($filtros_cliente)-1);$i++){			
			if($i==0){
				$sql_listaCuentas=$sql_listaCuentas." and ( cliente.idcliente = ".$filtros_cliente[$i]." ";
			}
			if($i>0){
				$sql_listaCuentas=$sql_listaCuentas." or cliente.idcliente = ".$filtros_cliente[$i]." ";
			}						
			if($i==(sizeof($filtros_cliente)-2)){
				$sql_listaCuentas=$sql_listaCuentas." ) ";
			}			
		}			
		
		if($_POST["desde"]!="" && $_POST["hasta"]==""){
			$sql_listaCuentas=$sql_listaCuentas." and date(venta.fecha)>= '".$_POST["desde"]."' ";
		}else
		if($_POST["desde"]=="" && $_POST["hasta"]!=""){
			$sql_listaCuentas=$sql_listaCuentas." and date(venta.fecha)<= '".$_POST["hasta"]."' ";
		}else
		if($_POST["desde"]!="" && $_POST["hasta"]!=""){
			$sql_listaCuentas=$sql_listaCuentas." and date(venta.fecha)>= '".$_POST["desde"]."' and date(venta.fecha)<= '".$_POST["hasta"]."' ";
		}				
		
				//echo $sql_listaCuentas;
				$result_listaCuentas=pg_exec($con,$sql_listaCuentas);				
			?>
        	<div class="panel_resume" style="width:99%"  >Resumen Cuentas por Cobrar</div>
            <div class="panel_detalle_resume" >
            	<div class="panel_detalle_columna" style="border-left:1px solid #666" >
                	<div class="panel_detalle_columna_titulo" >Ubicación</div>
                    <?php
					    $con=Conectarse();
						$sql_listaUbicaciones="select * from ubicacion;";
						$result_listaUbicaciones=pg_exec($con,$sql_listaUbicaciones);
						$cuentaGeneral=0;
						$acumulaGeneral=0;						
						for($i=0;$i<pg_num_rows($result_listaUbicaciones);$i++){
							$ubicacion=pg_fetch_array($result_listaUbicaciones,$i);
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
		
		<?
	
	}

?>