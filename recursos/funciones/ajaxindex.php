<?php
    require("funciones.php");
	if($_POST["action"]==1){
		if($_POST["ira"]==2){
			$fechaBuscada=strtotime($_POST["fecha"])+86400;
		}else if($_POST["ira"]==1){
			$fechaBuscada=strtotime($_POST["fecha"])-86400;	
		}else if($_POST["ira"]==0){
			$fechaBuscada=strtotime($_POST["fecha"]);	
		}
				
		echo "<input type='hidden' name='fecha_leche' id='fecha_leche' value='".date("Y-m-d", $fechaBuscada)."' />";
        echo "<div class='resumen_titulo'>Resumen Diario de Ingreso de Leche</div>";
        echo "<div class='resumen_fecha'><label id='fecha_observada'>".FormatoFecha1(date("Y-m-d", $fechaBuscada))."</label>";
		
        echo "<div class='flecha_izquierda' onclick='atras_resumen_leche()'><img src='recursos/imagenes/prev.png' width='6' height='10' style='margin-top:7px; margin-left:2px;' /></div>";
        echo "<div class='flecha_derecha' onclick='adelante_resumen_leche()'><img src='recursos/imagenes/next.png' width='6' height='10' style='margin-top:7px; margin-left:2px;' /></div>";
        echo "</div>";
		$con=Conectarse();
		$sql_litros=" select sum(listrosviaje) as dicentraer, sum(litrosreal) as traen, sum(litrosreal-listrosviaje), sum(CASE WHEN ((litrosreal-listrosviaje)>0) THEN (litrosreal-listrosviaje) END),  sum(CASE WHEN ((litrosreal-listrosviaje)<0) THEN (litrosreal-listrosviaje) END)  from viajeruta where fecha ='".date("Y-m-d", $fechaBuscada)."' group by fecha ";
		$result_litros = pg_exec($con,$sql_litros);
		
		if(pg_num_rows($result_litros)>0){		
		$litros = pg_fetch_array($result_litros,0);		
        	echo "<div class='resumen_numeros'>";
	        echo "<div class='resumen_numero'>";
	        echo "<div class='resumen_numero_arriba'>".$litros[0]."</div>";
	        echo "<div class='resumen_numero_abajo'>Litros Viaje</div>";
	        echo "</div>";
	        echo "<div class='resumen_numero'>";
	        echo "<div class='resumen_numero_arriba'>".$litros[4]."</div>";
	        echo "<div class='resumen_numero_abajo'>Litros Faltantes</div>";
	        echo "</div>";
	        echo "<div class='resumen_numero'>";
	        echo "<div class='resumen_numero_arriba'>".$litros[3]."</div>";
	        echo "<div class='resumen_numero_abajo'>Litros Sobrantes</div>";
	        echo "</div>";
	        echo "<div class='resumen_numero'>";
	        echo "<div class='resumen_numero_arriba'>".$litros[1]."</div>";
	        echo "<div class='resumen_numero_abajo'>Litros Reales</div>";
	        echo "</div>";
	        echo "<div class='resumen_numero' style='border-right:0px;'>";
	        echo "<div class='resumen_numero_arriba'>".$litros[2]."</div>";
	        echo "<div class='resumen_numero_abajo'>Diferencia</div>";
	        echo "</div>";
	        echo "</div>";			
			echo "<div class='resumen_titulo2'>Listado de Rutas</div>";
	        echo "<div class='resumen_titulo2'>";
	        echo "<div class='resumen_columna' style='width:250px; padding-left:0px;'>Nombre de la Ruta</div>";
	        echo "<div class='resumen_columna' style='width:75px;'>Productores</div>";
	        echo "<div class='resumen_columna' style='width:65px;'>Litros Viaje</div>";
	        echo "<div class='resumen_columna' style='width:75px;'>Litros Reales</div>";
	        echo "<div class='resumen_columna' style='width:95px; border-right:0px;'>Litros Diferencia</div>";
	        echo "</div>";
			
			$sql_rutas=" select ruta.nombreruta, viajeruta.listrosviaje, viajeruta.litrosreal, viajeruta.idviajeruta from viajeruta, ruta where ruta.idruta=viajeruta.idruta and fecha ='".date("Y-m-d", $fechaBuscada)."'";
			$result_rutas = pg_exec($con,$sql_rutas);
			for($i=0;$i<pg_num_rows($result_rutas);$i++){
				$ruta = pg_fetch_array($result_rutas,$i);
				$sql_num_productores = "select * from productoresviaje where idviajeruta='".$ruta[3]."'";
				$result_num_productores = pg_exec($con,$sql_num_productores);
            	echo "<div class='resumen_columna_detalle'>";
	            echo "<div class='resumen_columna' style='width:250px; padding-left:0px;'>".$ruta[0]."</div>";
	            echo "<div class='resumen_columna2' style='width:75px;'>".pg_num_rows($result_num_productores)."</div>";
	            echo "<div class='resumen_columna2' style='width:65px;'>".$ruta[1]."</div>";
	            echo "<div class='resumen_columna2' style='width:75px;'>".$ruta[2]."</div>";
	            echo "<div class='resumen_columna2' style='width:95px; border-right:0px;'>".($ruta[2]-$ruta[1])."</div>";
	            echo "</div>";											
			}
			
			echo "<div class='resumen_titulo2'>Observaciones Sobre los Productores</div>"; 
	        echo "<div class='resumen_titulo2'>";
            echo "<div class='resumen_columna' style='width:250px; padding-left:0px;'>Nombre del Productor</div>";
            echo "<div class='resumen_columna' style='width:325px; border-right:0px;'>Detalle observado</div>";
	        echo "</div>";
			
			for($i=0;$i<pg_num_rows($result_rutas);$i++){
				$viajeruta = pg_fetch_array($result_rutas,$i);
				$sql_select_productores_viaje=" select  productoresviaje.idproductoresviaje, productoresviaje.idproductor, productor.nombreproductor from productoresviaje, productor where productoresviaje.idviajeruta='".$viajeruta[3]."' and productoresviaje.idproductor = productor.idproductor";
				$result_productores_viaje = pg_exec($con,$sql_select_productores_viaje);			
				for($j=0;$j<pg_num_rows($result_productores_viaje);$j++){
					$productor_en_viaje= pg_fetch_array($result_productores_viaje,$j);
					
					$sql_analisisquimico =" select * from analisisquimico where idproductoresviaje='".$productor_en_viaje[0]."'";
					$result_analisisquimico = pg_exec($con,$sql_analisisquimico);
					$analisisquimico = pg_fetch_array($result_analisisquimico,0);
					
					$sql_elementos_analisis=" select elementoanalisis.nombre, elementoanalisis.minimo, elementoanalisis.maximo, analisiselementos.valor  from analisiselementos, elementoanalisis where analisiselementos.idanalisisquimico='".$analisisquimico[0]."' and analisiselementos.idelementoanalisis = elementoanalisis.idelementoanalisis ";
					$result_elementos_analisis = pg_exec($con,$sql_elementos_analisis);
					for($k=0;$k<pg_num_rows($result_elementos_analisis);$k++){
						$elemento_analisis= pg_fetch_array($result_elementos_analisis,$k);
						if($elemento_analisis[3]<$elemento_analisis[1]){
    			        	echo "<div class='resumen_columna_detalle'>";
			            	echo "<div class='resumen_columna' style='width:250px; padding-left:0px;'>".$productor_en_viaje[2]."</div>";
			                echo "<div class='resumen_columna' style='width:325px; border-right:0px;'>".$elemento_analisis[0]." ".$elemento_analisis[3]." por debajo del rango [".$elemento_analisis[1]." - ".$elemento_analisis[2]."]</div>";
				            echo "</div>";							
						}else if($elemento_analisis[3]>$elemento_analisis[2]){
    			        	echo "<div class='resumen_columna_detalle'>";
			            	echo "<div class='resumen_columna' style='width:250px; padding-left:0px;'>".$productor_en_viaje[2]."</div>";
			                echo "<div class='resumen_columna' style='width:325px; border-right:0px;'>".$elemento_analisis[0]." ".$elemento_analisis[3]." por encima del rango [".$elemento_analisis[1]." - ".$elemento_analisis[2]."]</div>";
				            echo "</div>";							
						}
						
					}
																							
				}																		
			}
			echo "<div class='resumen_titulo2' style='border-bottom:0px;'></div>";			
						
		}else{
			echo "<div class='resumen_numeros2'>";
			echo "No hay registros para este día";
			echo "</div>";	
			echo "<div class='resumen_titulo2' style='border-bottom:0px;'></div>";	
		}
		

		
			
	}

?>