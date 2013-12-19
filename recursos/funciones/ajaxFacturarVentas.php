<?php session_start();
    require("funciones.php");
	$con = Conectarse();
	
	if($_POST["action"]==1){
		
		$fecha=strtotime($_POST["dia"]);
		
		if($_POST["ira"]==2){
			$fechaBuscada=$fecha+86400;
		}else if($_POST["ira"]==1){						
			$fechaBuscada=$fecha-86400;	
		}else if($_POST["ira"]==0){
			$fechaBuscada=$fecha;	
		}
		
		$fecha=FormatoDia(date("Y-m-d",$fechaBuscada));
        echo "<input type='hidden' name='dia_produccion' id='dia_produccion' value='".date("Y-m-d",$fechaBuscada)."' />";
        echo "<div class='Reporte-titulo'>Lista de Ventas</div>";
        echo "<div class='Reporte-fecha'><label>".$fecha."</label>";		
        echo "<div class='Reporte-flecha_izq' onclick='atras_resumen_ventas()'><img src='../recursos/imagenes/prev.png' style='margin-left:2px; margin-top:7px;' width='6' height='10' /></div>";
        echo "<div class='Reporte-flecha_der' onclick='adelante_resumen_ventas()'><img src='../recursos/imagenes/next.png' style='margin-right:2px; margin-top:7px;' width='6' height='10' /></div>";
        echo "</div>";		
		
        echo "<div id='reporte' class='contenedor_ventas' style='float:left; width:100%;'>";
       		
			    $con=Conectarse();
				$sql_listarVentas="select * from venta where date(fecha)='".date("Y-m-d",$fechaBuscada)."' order by fecha DESC;";
				$result_listarVentas=pg_exec($con,$sql_listarVentas);
				
			    for($i=0;$i<pg_num_rows($result_listarVentas);$i++){
					$venta=pg_fetch_array($result_listarVentas,$i);
					$sql_cliente="select * from cliente where idcliente='".$venta[2]."'";
					$result_cliente=pg_exec($con,$sql_cliente);
					$cliente=pg_fetch_array($result_cliente,0);
					
					$sql_ubicacion="select * from ubicacion where idubicacion='".$venta[1]."'";
					$result_ubicacion=pg_exec($con,$sql_ubicacion);
					$ubicacion=pg_fetch_array($result_ubicacion,0);					
					
					$sql_precio="select * from tipoprecio where idtipoprecio='".$venta[5]."'";
					$result_precio=pg_exec($con,$sql_precio);
					$precio=pg_fetch_array($result_precio,0);						
					
        			echo"<div class='venta'>";
		        	echo"<div class='venta_fecha' >";
	            	echo"<div class='linea_fecha_dia'>".$ubicacion[1].$precio[1]."</div>";
		            echo"</div>";
		            echo"<div class='venta_describe'>";
	            	echo"<div class='linea_describe'>".strtoupper($cliente[1])."</div>";
		            echo"</div>";
		            echo"<div class='venta_detalle'>";
					echo"<div class='detalle'>";
                	echo"<div class='detalle_arriba'>".$venta[7]."</div>";
                    echo"<div class='detalle_abajo'>EXCENTO</div>";
    	            echo"</div>";
					echo"<div class='detalle'>";
                	echo"<div class='detalle_arriba'>".$venta[8]."</div>";
                    echo"<div class='detalle_abajo'>GRAVABLE</div>";
	                echo"</div>";
					echo"<div class='detalle'>";
                	echo"<div class='detalle_arriba'>".$venta[9]."</div>";
                    echo"<div class='detalle_abajo'>SUB TOTAL</div>";
    	            echo"</div>";
					echo"<div class='detalle'>";
                	echo"<div class='detalle_arriba'>".$venta[10]."</div>";
                    echo"<div class='detalle_abajo'>TOTAL IVA</div>";
	                echo"</div>";
					echo"<div class='detalle' style='border-right:0px;'>";
                	echo"<div class='detalle_arriba' >".$venta[11]."</div>";
                    echo"<div class='detalle_abajo'>MONTO TOTAL</div>";
    	            echo"</div>";                        
        		    echo"</div>";
					if($venta[3]==1){
						echo"<a href='../reportes/notaDeEntrega.php?idventa=".$venta[0]."'><div class='venta_generar' title='Nota de Entrega'>NE</div></a>";
					}if($venta[3]==2||$venta[3]==3){
		            	echo"<a href='../reportes/notaDeEntrega.php?idventa=".$venta[0]."'><div class='venta_generar' title='Nota de Entrega'>NE</div></a>";
			            echo"<a href='../reportes/FacturaVenta.php?idventa=".$venta[0]."'><div class='venta_generar' title='Factura'>FA</div></a>";						
					}if($venta[3]==4){
			            echo"<a href='../reportes/notaDeEntrega.php?idventa=".$venta[0]."'><div class='venta_generar' title='Nota de Entrega'>NE</div></a>";
			            echo"<a href='../reportes/FacturaVenta.php?idventa=".$venta[0]."'><div class='venta_generar' title='Factura'>FA</div></a>";
			            echo"<a href='../reportes/FacturaCadenaEnFrio.php?idventa=".$venta[0]."'><div class='venta_generar' title='Cadena en Frio' style='border-right:0px;'>CF</div></a>";						
					}
			        echo"</div>";
				}                   
            
        echo "</div>";
		
		
	}

	

?>