<?php session_start();

    require("funciones.php");
    $con=Conectarse();		


	if($_POST["action"]==1){
		$con=Conectarse();
		$sql_lecheProductor="";
		
		$fechaInicio=strtotime($_POST["desde"]);
		$fechaFin=strtotime($_POST["hasta"]);
								

		$listaProductores = array();
		$cont=0;
		
		if($_POST["productor"]==-1){
			$sql_productores="select * from productor order by idproductor";
			$result_productores= pg_exec($con,$sql_productores);
			for($i=0;$i<pg_num_rows($result_productores);$i++){
				$pro=pg_fetch_array($result_productores,$i);
				$listaProductores[$cont]=$pro[0];
				$cont++;
			}
		}else{
			$listaProductores[$cont]=$_POST["productor"];
			$cont++;				
		}
				
		for($j=0;$j<sizeof($listaProductores);$j++){
						
		$sql_productor="select * from productor where idproductor='".$listaProductores[$j]."'";
		$result_productor=pg_exec($con,$sql_productor);
		$productor=pg_fetch_array($result_productor,0);
        echo "<div class='linea'>";
        echo "<div class='columa' style='width:44.4%; border:0px'>".$productor[3]." </div>";
        echo "</div>";     		
		
       	echo "<div class='linea'>";
        echo "<div class='columa' style='width:44.4%; border:0px'>Por Compra de Leche Fria</div>";
        echo "<div class='columa' style='width:44.4%; margin-left:5%; border:0px'>Por Concepto de Incentivo por Producción</div>";
        echo "</div>";
        echo "<div class='linea'>";
        echo "<div class='columa' style='width:10%;background:#84cff7; text-align:center'>Fecha</div>";
        echo "<div class='columa' style='width:6%;background:#84cff7; text-align:center'>Litros</div>";
        echo "<div class='columa' style='width:6%;background:#84cff7; text-align:center'>Total Lts</div>";
        echo "<div class='columa' style='width:6%;background:#84cff7; text-align:center'>Precio</div>";
        echo "<div class='columa' style='width:8%;background:#84cff7; text-align:center'>Monto Total</div>";
        echo "<div class='columa' style='width:10%;background:#84cff7; margin-left:5%; border-left:1px solid #CCC; text-align:center'>Fecha</div>";
        echo "<div class='columa' style='width:6%;background:#84cff7; text-align:center'>Litros</div>";
        echo "<div class='columa' style='width:6%;background:#84cff7; text-align:center'>Total Lts</div>";
        echo "<div class='columa' style='width:6%;background:#84cff7; text-align:center'>Precio</div>";
        echo "<div class='columa' style='width:8%;background:#84cff7; text-align:center'>Monto Total</div>";                                	
        echo "</div>";	
																																
		
		$acumulaLitros=0;
		$acumulaBolivares=0;
		$acumulaIncentivo=0;
		$ultimoPrecio="";		
		$sql_precio="select pagounidad, idinsumo from productor where idproductor='".$listaProductores[$j]."'";
		$result_precio=pg_exec($con,$sql_precio);
		$precio=pg_fetch_array($result_precio,0);
		$ultimoPrecio=$precio[0];
		

		
		for($i=$fechaInicio;$i<=$fechaFin;$i+=86400){
			
			$sql_regulado="select * from reguladoleche where date('".date("d-m-Y",$i)."') >= desde and date('".date("d-m-Y",$i)."') <= hasta and tipoleche='".$precio[1]."' order by desde DESC";						
			$result_regulado=pg_exec($con,$sql_regulado);
			
			if(pg_num_rows($result_regulado)>0){
				$regulado=pg_fetch_array($result_regulado,0);
			}else{
				$sql_regulado="select * from reguladoleche where hasta is null and tipoleche='".$precio[1]."';";
				$result_regulado=pg_exec($con,$sql_regulado);
				$regulado=pg_fetch_array($result_regulado,0);				
			}
															
			$sql_lecheProductor="select viajeruta.fecha, productoresviaje.idproductor, productoresviaje.cantidadlitros, productoresviaje.pagounidad from productoresviaje, viajeruta where productoresviaje.idviajeruta=viajeruta.idviajeruta and productoresviaje.idproductor='".$listaProductores[$j]."' and viajeruta.fecha='".date("d-m-Y",$i)."' ";			
			$result_lecheProductor=pg_exec($con,$sql_lecheProductor);
			if(pg_num_rows($result_lecheProductor)>0){
			$lecheProductor=pg_fetch_array($result_lecheProductor,0);			
			$acumulaLitros+=$lecheProductor[2];
			$acumulaBolivares+=($regulado[4]*$lecheProductor[2]);
			$acumulaIncentivo+=(($lecheProductor[3]-$regulado[4])*$lecheProductor[2]);
        	echo "<div class='linea'>";
            echo "<div class='columa' style='width:10%; text-align:center'>".date("d-m-Y",$i)."</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>".number_format($lecheProductor[2],2,".","")."</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>".number_format($lecheProductor[2],2,".","")."</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>".number_format($regulado[4],2,".","")."</div>";
            echo "<div class='columa' style='width:8%; text-align:right'>".number_format(($regulado[4]*$lecheProductor[2]),2,".","")."</div>";
            echo "<div class='columa' style='width:10%; margin-left:5%; border-left:1px solid #CCC; text-align:center'>".date("d-m-Y",$i)."</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>".number_format($lecheProductor[2],2,".","")."</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>".number_format($lecheProductor[2],2,".","")."</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>".number_format(($lecheProductor[3]-$regulado[4]),2,".","")."</div>";
            echo "<div class='columa' style='width:8%; text-align:right'>".number_format(($lecheProductor[3]-$regulado[4])*$lecheProductor[2],2,".","")."</div>";      	
            echo "</div>";					
			}else{
				
				$sql_leche="select * from historico_productor_pago where date('".date("d-m-Y",$i)."') >= desde and date('".date("d-m-Y",$i)."') <= hasta and idproductor='".$listaProductores[$j]."' order by desde DESC";						
				$result_leche=pg_exec($con,$sql_leche);
			
				if(pg_num_rows($result_leche)>0){
					$precioLeche=pg_fetch_array($result_leche,0);
				}else{
					$sql_leche="select * from historico_productor_pago where hasta is null and idproductor='".$listaProductores[$j]."';";
					$result_leche=pg_exec($con,$sql_leche);
					$precioLeche=pg_fetch_array($result_leche,0);				
				}				
				
        	echo "<div class='linea'>";
            echo "<div class='columa' style='width:10%; text-align:center'>".date("d-m-Y",$i)."</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>0.00</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>0.00</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>".number_format($regulado[4],2,".","")."</div>";
            echo "<div class='columa' style='width:8%; text-align:right'>0.00</div>";
            echo "<div class='columa' style='width:10%; margin-left:5%; border-left:1px solid #CCC; text-align:center'>".date("d-m-Y",$i)."</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>0.00</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>0.00</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>".number_format(($precioLeche[2]-$regulado[4]),2,".","")."</div>";
            echo "<div class='columa' style='width:8%; text-align:right'>0.00</div>";                                	
            echo "</div>";				
			}						
		}
		
        	echo "<div class='linea'>";
            echo "<div class='columa' style='width:10%; text-align:center'>Total General</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>".number_format($acumulaLitros,2,".","")."</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>".number_format($acumulaLitros,2,".","")."</div>";
            echo "<div class='columa' style='width:6%; text-align:right'></div>";
            echo "<div class='columa' style='width:8%; text-align:right'>".number_format($acumulaBolivares,2,".","")."</div>";
            echo "<div class='columa' style='width:10%; margin-left:5%; border-left:1px solid #CCC; text-align:center'>Total General</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>".number_format($acumulaLitros,2,".","")."</div>";
            echo "<div class='columa' style='width:6%; text-align:right'>".number_format($acumulaLitros,2,".","")."</div>";
            echo "<div class='columa' style='width:6%; text-align:right'></div>";
            echo "<div class='columa' style='width:8%; text-align:right'>".number_format($acumulaIncentivo,2,".","")."</div>";
			echo "</div>";
			
        	echo "<div class='linea' style='margin-bottom:20px;'>";
            echo "<div class='columa' style='width:10%; text-align:center;border-bottom:1px solid #CCC'></div>";
            echo "<div class='columa' style='width:6%; text-align:right;border-bottom:1px solid #CCC'></div>";
            echo "<div class='columa' style='width:6%; text-align:right;border-bottom:1px solid #CCC'></div>";
            echo "<div class='columa' style='width:6%; text-align:right;border-bottom:1px solid #CCC'></div>";
            echo "<div class='columa' style='width:8%; text-align:right;border-bottom:1px solid #CCC'></div>";
            echo "<div class='columa' style='width:10%; margin-left:5%; border-left:1px solid #CCC; text-align:center;border-bottom:1px solid #CCC'></div>";
            echo "<div class='columa' style='width:6%; text-align:right;border-bottom:1px solid #CCC'></div>";
            echo "<div class='columa' style='width:6%; text-align:right;border-bottom:1px solid #CCC'></div>";
            echo "<div class='columa' style='width:6%; text-align:right;border-bottom:1px solid #CCC'>Total Bs.</div>";
            echo "<div class='columa' style='width:8%; text-align:right;border-bottom:1px solid #CCC'>".number_format(($acumulaBolivares+$acumulaIncentivo),2,".","")."</div>";
			echo "</div>";			
			
			
			
			
			
			}
			
			
			
		}


?>