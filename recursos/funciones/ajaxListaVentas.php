<?php session_start();

    require("funciones.php");
    $con=Conectarse();

	if($_POST["action"]==1){
		
		$con=Conectarse();
		$sql_listaVentas="select venta.idventa, venta.idubicacion, ubicacion.ciudad, venta.idcliente, cliente.nombre, venta.tipoventa, venta.tipopago, venta.tipoprecio, tipoprecio.descripcion, venta.fecha, venta.excento, venta.gravable, venta.subtotal, venta.totaliva, venta.montototal from venta, ubicacion, cliente, tipoprecio where venta.idubicacion=ubicacion.idubicacion and venta.idcliente = cliente.idcliente and venta.tipoprecio = tipoprecio.idtipoprecio ";		
		
		
		
		$sin=0;
		$par=0;
		$com=0;
		
		$filtros_estatus=explode("-",$_POST["estatus"]);
		
		for($i=0;$i<sizeof($filtros_estatus);$i++){
			if($filtros_estatus[$i]==1){
				$sin=1;	
			}else if($filtros_estatus[$i]==2){
				$par=1;	
			}else if($filtros_estatus[$i]==3){
				$com=1;	
			}
		}
		
		//echo $sin." -- ".$par." -- ".$com;			
		
		$filtros_ubicacion =  explode("-",$_POST["ubicacion"]);
		$filtros_precio =  explode("-",$_POST["precio"]);
		$filtros_tipodeventa =  explode("-",$_POST["tipodeventa"]);
		$filtros_cliente =  explode("-",$_POST["cliente"]);
		
		
		$bandUbicacion=0;
		for($i=0;$i<(sizeof($filtros_ubicacion)-1);$i++){
			if($i==0){
				$sql_listaVentas=$sql_listaVentas." and ( venta.idubicacion = ".$filtros_ubicacion[$i]." ";
			}
			if($i>0){
				$sql_listaVentas=$sql_listaVentas." or venta.idubicacion = ".$filtros_ubicacion[$i]." ";
			}						
			if($i==(sizeof($filtros_ubicacion)-2)){
				$sql_listaVentas=$sql_listaVentas." ) ";
			}			
		}
		
		for($i=0;$i<(sizeof($filtros_precio)-1);$i++){
			if($i==0){
				$sql_listaVentas=$sql_listaVentas." and ( venta.tipoprecio = ".$filtros_precio[$i]." ";
			}
			if($i>0){
				$sql_listaVentas=$sql_listaVentas." or venta.tipoprecio = ".$filtros_precio[$i]." ";
			}						
			if($i==(sizeof($filtros_precio)-2)){
				$sql_listaVentas=$sql_listaVentas." ) ";
			}						
		}	
		
		for($i=0;$i<(sizeof($filtros_tipodeventa)-1);$i++){
			if($filtros_tipodeventa[$i]==1){
				if($i==0){
					$sql_listaVentas=$sql_listaVentas." and ( venta.tipoventa = ".$filtros_tipodeventa[$i]." ";
				}
				if($i>0){
					$sql_listaCuentas=$sql_listaVentas." or venta.tipoventa = ".$filtros_tipodeventa[$i]." ";
				}						
				if($i==(sizeof($filtros_tipodeventa)-2)){
					$sql_listaVentas=$sql_listaVentas." ) ";
				}													
			}else if($filtros_tipodeventa[$i]==2){
				if($i==0){
					$sql_listaVentas=$sql_listaVentas." and ( venta.tipoventa = 2 or venta.tipoventa = 3 or venta.tipoventa = 4 ";
				}
				if($i>0){
					$sql_listaVentas=$sql_listaVentas." or venta.tipoventa = 2 or venta.tipoventa = 3 or venta.tipoventa = 4 ";
				}						
				if($i==(sizeof($filtros_tipodeventa)-2)){
					$sql_listaVentas=$sql_listaVentas." ) ";
				}											
			}
			
		}				
		
		for($i=0;$i<(sizeof($filtros_cliente)-1);$i++){			
			if($i==0){
				$sql_listaVentas=$sql_listaVentas." and ( venta.idcliente = ".$filtros_cliente[$i]." ";
			}
			if($i>0){
				$sql_listaVentas=$sql_listaVentas." or venta.idcliente = ".$filtros_cliente[$i]." ";
			}						
			if($i==(sizeof($filtros_cliente)-2)){
				$sql_listaVentas=$sql_listaVentas." ) ";
			}			
		}			
		
		if($_POST["desde"]!="" && $_POST["hasta"]==""){
			$sql_listaVentas=$sql_listaVentas." and date(venta.fecha)>= '".$_POST["desde"]."' ";
		}else
		if($_POST["desde"]=="" && $_POST["hasta"]!=""){
			$sql_listaVentas=$sql_listaVentas." and date(venta.fecha)<= '".$_POST["hasta"]."' ";
		}else
		if($_POST["desde"]!="" && $_POST["hasta"]!=""){
			$sql_listaVentas=$sql_listaVentas." and date(venta.fecha)>= '".$_POST["desde"]."' and date(venta.fecha)<= '".$_POST["hasta"]."' ";
		}				
		
				//echo $sql_listaCuentas;
				$result_listaVentas=pg_exec($con,$sql_listaVentas);				
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
						
						//echo $filtros_estatus[0];
					
										
						for($i=0;$i<pg_num_rows($result_listaUbicaciones);$i++){
							$ubicacion=pg_fetch_array($result_listaUbicaciones,$i);
							$acumulaCuentas=0;
							$acumulaDeuda=0;							
							for($j=0;$j<pg_num_rows($result_listaVentas);$j++){								
								$venta=pg_fetch_array($result_listaVentas,$j);
																		
								if($venta[6]==1){ /*Contado*/
									$cancelado=number_format(round($venta[14],2),2,'.','');							
								}else if($venta[6]==2){ /*Credito*/
									$sql_selectCuenta="select * from cuentaporcobrar where idventa='".$venta[0]."';";
									$result_selectCuenta=pg_exec($con,$sql_selectCuenta);
									$cuentaporCobrar=pg_fetch_array($result_selectCuenta,0);
									$cancelado=$cuentaporCobrar[3];
								}
								$porcentaje=($cancelado*100)/$venta[14];										
								$band=0;
								if($sin==1 && $porcentaje==0){
									$band=1;	
								}
								if($par==1 && $porcentaje > 0 && $porcentaje < 100){
									$band=1;	
								}
								if($com==1 && $porcentaje==100){
									$band=1;	
								}
								
								if($sin==0 && $par==0 && $com==0){
									if($ubicacion[0]==$venta[1]){
										$acumulaCuentas++;
										$acumulaDeuda+=$venta[14];	
										$cuentaGeneral++;
										$acumulaGeneral+=$venta[14];
									}									
								}
								
								if($band==1){
									if($ubicacion[0]==$venta[1]){
										$acumulaCuentas++;
										$acumulaDeuda+=$venta[14];	
										$cuentaGeneral++;
										$acumulaGeneral+=$venta[14];
									}																		
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
							for($j=0;$j<pg_num_rows($result_listaVentas);$j++){
								$venta=pg_fetch_array($result_listaVentas,$j);
								
								if($venta[6]==1){ /*Contado*/
									$cancelado=number_format(round($venta[14],2),2,'.','');							
								}else if($venta[6]==2){ /*Credito*/
									$sql_selectCuenta="select * from cuentaporcobrar where idventa='".$venta[0]."';";
									$result_selectCuenta=pg_exec($con,$sql_selectCuenta);
									$cuentaporCobrar=pg_fetch_array($result_selectCuenta,0);
									$cancelado=$cuentaporCobrar[3];
								}
								$porcentaje=($cancelado*100)/$venta[14];										
								$band=0;
								if($sin==1 && $porcentaje==0){
									$band=1;	
								}
								if($par==1 && $porcentaje > 0 && $porcentaje < 100){
									$band=1;	
								}
								if($com==1 && $porcentaje==100){
									$band=1;	
								}								
								
								if($sin==0 && $par==0 && $com==0){
									if($precio[0]==$venta[7]){
										$acumulaCuentas++;
										$acumulaDeuda+=$venta[14];	
									}									
								}
								
								if($band==1){
									if($precio[0]==$venta[7]){
										$acumulaCuentas++;
										$acumulaDeuda+=$venta[14];	
									}									
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
							for($j=0;$j<pg_num_rows($result_listaVentas);$j++){
								$venta=pg_fetch_array($result_listaVentas,$j);
								if($venta[6]==1){ /*Contado*/
									$cancelado=number_format(round($venta[14],2),2,'.','');							
								}else if($venta[6]==2){ /*Credito*/
									$sql_selectCuenta="select * from cuentaporcobrar where idventa='".$venta[0]."';";
									$result_selectCuenta=pg_exec($con,$sql_selectCuenta);
									$cuentaporCobrar=pg_fetch_array($result_selectCuenta,0);
									$cancelado=$cuentaporCobrar[3];
								}
								$porcentaje=($cancelado*100)/$venta[14];										
								$band=0;
								if($sin==1 && $porcentaje==0){
									$band=1;	
								}
								if($par==1 && $porcentaje > 0 && $porcentaje < 100){
									$band=1;	
								}
								if($com==1 && $porcentaje==100){
									$band=1;	
								}								
								
								
								if($sin==0 && $par==0 && $com==0){								
									if($venta[5]==1){
										$cuentasSin++;
										$acumulaSin+=$venta[14];									
									}else if($venta[5]==2 || $venta[5]==3 || $venta[5]==4){
										$cuentasCon++;
										$acumulaCon+=$venta[14];
									}
								}
								if($band==1){
									if($venta[5]==1){
										$cuentasSin++;
										$acumulaSin+=$venta[14];									
									}else if($venta[5]==2 || $venta[5]==3 || $venta[5]==4){
										$cuentasCon++;
										$acumulaCon+=$venta[14];
									}									
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
                    <div class="cabecera_columna" style="width:12%; text-align:center">Total</div>
                    <div class="cabecera_columna" style="width:12%; text-align:center">Cancelado</div>
                    <div class="cabecera_columna" style="width:12%; text-align:center">Pendiente</div>
                    <div class="cabecera_columna" style="width:6%; text-align:center; border-right:0px;">%</div>
                </div>
                <?php 
					$porcobrarSeleccionadas="";
					

					
					
					for($i=0;$i<pg_num_rows($result_listaVentas);$i++){
						$venta=pg_fetch_array($result_listaVentas,$i);
						//$porcobrarSeleccionadas=$porcobrarSeleccionadas.$venta[0]."-";
						$tipodeventa="";
						$cancelado=0;
						
						
						if($venta[5]==1){
							$tipodeventa="Sin Factura";								
						}else if($venta[5]==2 || $venta[5]==3 || $venta[5]==4){
							$tipodeventa="Con Factura";
						}			
						
						if($venta[6]==1){ /*Contado*/
							$cancelado=number_format(round($venta[14],2),2,'.','');
							
						}else if($venta[6]==2){ /*Credito*/
							$sql_selectCuenta="select * from cuentaporcobrar where idventa='".$venta[0]."';";
							$result_selectCuenta=pg_exec($con,$sql_selectCuenta);
							$cuentaporCobrar=pg_fetch_array($result_selectCuenta,0);
							$cancelado=$cuentaporCobrar[3];
						}
												
						$porcentaje=($cancelado*100)/$venta[14];				
																						
						$band=0;
						if($sin==1 && $porcentaje==0){
							$band=1;	
						}
						if($par==1 && $porcentaje > 0 && $porcentaje < 100){
							$band=1;	
						}
						if($com==1 && $porcentaje==100){
							$band=1;	
						}						
						
						if($sin==0 && $par==0 && $com==0){	
						$porcobrarSeleccionadas=$porcobrarSeleccionadas.$venta[0]."-";
		                echo "<div class='panel_detalle_linea' onclick='verdetalle(".$venta[0].")' style='border-left:1px solid #666;  border-right:1px solid #666' title='Ubicacion: ".$venta[2]." --- Precio de Venta: ".$venta[8]." --- Tipo de Venta: ".$tipodeventa."'>";
        	        	echo "<div class='linea_columna' style='width:12%; text-align:center'>".substr($venta[9],0,10)."</div>";
	                    echo "<div class='linea_columna' style='width:41.5%'>".$venta[4]."</div>";
	                    echo "<div class='linea_columna' style='width:12%;text-align:right; padding-right:0.5%;padding-left:0px;'>".number_format(round($venta[14],2),2,'.','')."</div>";
	                    echo "<div class='linea_columna' style='width:12%;text-align:right; padding-right:0.5%;padding-left:0px;'>".number_format(round($cancelado,2),2,'.','')."</div>";
	                    echo "<div class='linea_columna' style='width:12%;text-align:right; padding-right:0.5%;padding-left:0px;'>".number_format(round(($venta[14]-$cancelado),2),2,'.','')."</div>";
	                    echo "<div class='linea_columna' style='width:6%; border-right:0px; text-align:right; padding-right:0.5%;padding-left:0px;'>".number_format(round($porcentaje,2),2,'.','')."</div>";
		                echo "</div>";
						}
						
						if($band==1){
						$porcobrarSeleccionadas=$porcobrarSeleccionadas.$venta[0]."-";	
		                echo "<div class='panel_detalle_linea' onclick='verdetalle(".$venta[0].")' style='border-left:1px solid #666;  border-right:1px solid #666' title='Ubicacion: ".$venta[2]." --- Precio de Venta: ".$venta[8]." --- Tipo de Venta: ".$tipodeventa."'>";
        	        	echo "<div class='linea_columna' style='width:12%; text-align:center'>".substr($venta[9],0,10)."</div>";
	                    echo "<div class='linea_columna' style='width:41.5%'>".$venta[4]."</div>";
	                    echo "<div class='linea_columna' style='width:12%;text-align:right; padding-right:0.5%;padding-left:0px;'>".number_format(round($venta[14],2),2,'.','')."</div>";
	                    echo "<div class='linea_columna' style='width:12%;text-align:right; padding-right:0.5%;padding-left:0px;'>".number_format(round($cancelado,2),2,'.','')."</div>";
	                    echo "<div class='linea_columna' style='width:12%;text-align:right; padding-right:0.5%;padding-left:0px;'>".number_format(round(($venta[14]-$cancelado),2),2,'.','')."</div>";
	                    echo "<div class='linea_columna' style='width:6%; border-right:0px; text-align:right; padding-right:0.5%;padding-left:0px;'>".number_format(round($porcentaje,2),2,'.','')."</div>";
		                echo "</div>";
						}						
						
						
					}
					$_SESSION["porCobrar"]=$porcobrarSeleccionadas;
				?>
                

            </div> 		
		
		<?
	
	}

?>