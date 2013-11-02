<?php session_start();
    require("funciones.php");
	$con = Conectarse();
	if($_POST["action"]==1){
		if($_POST["ira"]==2){
			$semanaBuscada=$_POST["semana"]+1;
		}else if($_POST["ira"]==1){						
			$semanaBuscada=$_POST["semana"]-1;	
		}else if($_POST["ira"]==0){
			$semanaBuscada=$_POST["semana"];	
		}
		
        echo "<input type='hidden' name='semana_leche' id='semana_leche' value='".$semanaBuscada."' />";
        echo "<div class='Reporte-titulo'>Resumen Semanal Rutas de Transporte</div>";
		
        echo "<div class='Reporte-fecha'><label>".FormatoSemana($semanaBuscada)."</label>";		
        echo "<div class='Reporte-flecha_izq' onclick='atras_resumen_ruta()'><img src='../recursos/imagenes/prev.png' style='margin-left:2px; margin-top:7px;' width='6' height='10' /></div>";
        echo "<div class='Reporte-flecha_der' onclick='adelante_resumen_ruta()'><img src='../recursos/imagenes/next.png' style='margin-right:2px; margin-top:7px;' width='6' height='10' /></div>";
        echo "</div>";
		
		echo "<div id='reporte' style='float:left; width:100%;'>";
		$sql_select_rutas=" select * from ruta order by idruta ";
		$result_select_ruta = pg_exec($con,$sql_select_rutas);
	    
		$sql_semana= "select * from semanas where idsemana='".$semanaBuscada."'";
		$result_semana= pg_exec($con,$sql_semana);
		$semana = pg_fetch_array($result_semana,0);	
		
		$dias=array();
		$solodia=array();
		$cuenta_dias=0;
		$fecha=strtotime($semana[5]);	
		
		for($d=0;$d<7;$d++){
			$dias[$d]=date("Y-m-d",$fecha);
			$solodia[$d]=date("d",$fecha);
			$fecha=$fecha+86400;
		}
		
		$litros_completos=0;
		$bolivares_leche_completos=0;
		$bolivares_transporte_completos=0;
		
		for($i=0;$i<pg_num_rows($result_select_ruta);$i++){
			$ruta = pg_fetch_array($result_select_ruta,$i);
			
			$vec_transportados = array();
			$vec_asignados = array();
			$vec_todos = array();
			$cuenta_todos=0;
			
			/*Consulto los diferentes productores que la ruta transporto durante la semana*/
			$sql_productores_transportados = " select distinct productoresviaje.idproductor from viajeruta, productoresviaje where viajeruta.idviajeruta = productoresviaje.idviajeruta and viajeruta.fecha >= '".$semana[5]."' and viajeruta.fecha <= '".$semana[6]."' and viajeruta.idruta = '".$ruta[0]."' order by productoresviaje.idproductor ;";
			$result_productores_transportados = pg_exec($con,$sql_productores_transportados);
			for($j=0;$j<pg_num_rows($result_productores_transportados);$j++){
				$productor_transportado = pg_fetch_array($result_productores_transportados,$j);
				$vec_transportados[$j]=$productor_transportado[0];				
			}
			
			/*Consulto los productores asignados a la ruta de transporte*/
			$sql_productores_asigandos =" select idproductor from productor where idruta='".$ruta[0]."' order by idproductor;";
			$result_productores_asigandos = pg_exec($con,$sql_productores_asigandos);
			
			for($j=0;$j<pg_num_rows($result_productores_asigandos);$j++){
				$productor_asignado = pg_fetch_array($result_productores_asigandos,$j);
				$vec_asignados[$j]=$productor_asignado[0];				
			}	
			
			for($j=0;$j<sizeof($vec_asignados);$j++){
				$band=0;
				for($k=0;$k<sizeof($vec_todos);$k++){
					if($vec_asignados[$j]==$vec_todos[$k]){
						$band=1;
						break;	
					}
				}
				if($band==0){
					$vec_todos[$cuenta_todos]=$vec_asignados[$j];
					$cuenta_todos++;
				}
			}
			
			for($j=0;$j<sizeof($vec_transportados);$j++){
				$band=0;
				for($k=0;$k<sizeof($vec_transportados);$k++){
					if($vec_transportados[$j]==$vec_todos[$k]){
						$band=1;
						break;	
					}
				}
				if($band==0){
					$vec_todos[$cuenta_todos]=$vec_transportados[$j];
					$cuenta_todos++;
				}
			}			
												
	        	echo "<div class='rl_linea' style='border-top:1px solid #CCC;  background:#84cff7'>";
	        	echo "<div class='rl_columna' style='width:21%;'>Productor</div>";
	            echo "<div class='rl_columna' style='width:8%;text-align:center'>Domingo ".$solodia[0]."</div>";
	            echo "<div class='rl_columna' style='width:6%;text-align:center'>Lunes ".$solodia[1]."</div>";
	            echo "<div class='rl_columna' style='width:7%;text-align:center'>Martes ".$solodia[2]."</div>";
	            echo "<div class='rl_columna' style='width:8.5%;text-align:center'>Miercoles ".$solodia[3]."</div>";
	            echo "<div class='rl_columna' style='width:6.8%;text-align:center'>Jueves ".$solodia[4]."</div>";
	            echo "<div class='rl_columna' style='width:6%;text-align:center'>Viernes ".$solodia[5]."</div>";
	            echo "<div class='rl_columna' style='width:6%;text-align:center'>Sabado ".$solodia[6]."</div>";
	            echo "<div class='rl_columna' style='width:8%;text-align:center'>Total Litros</div>";
	            echo "<div class='rl_columna' style='width:8%;text-align:center'>Total Bs.</div>";
	        	echo "</div>";			
			
			$global_litros=0;
			$global_dinero=0;
			$global_transporte=0;
			
			$lunes=0;
			$martes=0;
			$miercoles=0;
			$jueves=0;
			$viernes=0;
			$sabado=0;
			$domingo=0;
			
			for($j=0;$j<sizeof($vec_todos);$j++){
				$sql_nombre_productor =" select nombreproductor from productor where idproductor ='".$vec_todos[$j]."'";
				$result_nombre_productor=pg_exec($con,$sql_nombre_productor);
				$productor = pg_fetch_array($result_nombre_productor,0);

				echo "<div class='rl_linea' style='border-top:1px solid #CCC;'>";							        
	        	echo "<div class='rl_columna' style='width:21%;'>".$productor[0]."</div>";
				
                $total_litros=0;
				$total_dinero=0;				
												
				$sql_litros_dia = " select viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor, productoresviaje.cantidadlitros, productoresviaje.pagounidad, viajeruta.pagounidad from viajeruta, productoresviaje where viajeruta.idviajeruta = productoresviaje.idviajeruta and productoresviaje.idproductor='".$vec_todos[$j]."' and viajeruta.idruta ='".$ruta[0]."' and viajeruta.fecha='".$dias[0]."'  order by viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor; ";
				$result_litros_dia = pg_exec($con,$sql_litros_dia);
				if(pg_num_rows($result_litros_dia)>0){
					$litros_dia = pg_fetch_array($result_litros_dia,0);
					echo "<div class='rl_columna' style='width:8%;text-align:right;'>".$litros_dia[3]."</div>";
					$total_litros+=$litros_dia[3];
					$total_dinero+=($litros_dia[3]*$litros_dia[4]);
					$global_transporte+=($litros_dia[3]*$litros_dia[5]);
					$domingo+=$litros_dia[3];
				}else{
					echo "<div class='rl_columna' style='width:8%;'></div>";
				}
				
				$sql_litros_dia = " select viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor, productoresviaje.cantidadlitros, productoresviaje.pagounidad, viajeruta.pagounidad from viajeruta, productoresviaje where viajeruta.idviajeruta = productoresviaje.idviajeruta and productoresviaje.idproductor='".$vec_todos[$j]."' and viajeruta.idruta ='".$ruta[0]."' and viajeruta.fecha='".$dias[1]."'  order by viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor; ";
				$result_litros_dia = pg_exec($con,$sql_litros_dia);
				if(pg_num_rows($result_litros_dia)>0){
					$litros_dia = pg_fetch_array($result_litros_dia,0);
					echo "<div class='rl_columna' style='width:6%;text-align:right;'>".$litros_dia[3]."</div>";
					$total_litros+=$litros_dia[3];
					$total_dinero+=($litros_dia[3]*$litros_dia[4]);
					$global_transporte+=($litros_dia[3]*$litros_dia[5]);
					$lunes+=$litros_dia[3];
				}else{
					echo "<div class='rl_columna' style='width:6%;'></div>";
				}				
	            
				$sql_litros_dia = " select viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor, productoresviaje.cantidadlitros, productoresviaje.pagounidad, viajeruta.pagounidad from viajeruta, productoresviaje where viajeruta.idviajeruta = productoresviaje.idviajeruta and productoresviaje.idproductor='".$vec_todos[$j]."' and viajeruta.idruta ='".$ruta[0]."' and viajeruta.fecha='".$dias[2]."'  order by viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor; ";
				$result_litros_dia = pg_exec($con,$sql_litros_dia);
				if(pg_num_rows($result_litros_dia)>0){
					$litros_dia = pg_fetch_array($result_litros_dia,0);
					echo "<div class='rl_columna' style='width:7%;text-align:right;'>".$litros_dia[3]."</div>";
					$total_litros+=$litros_dia[3];
					$total_dinero+=($litros_dia[3]*$litros_dia[4]);
					$global_transporte+=($litros_dia[3]*$litros_dia[5]);
					$martes+=$litros_dia[3];
				}else{
					echo "<div class='rl_columna' style='width:7%;'></div>";
				}	
				
				$sql_litros_dia = " select viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor, productoresviaje.cantidadlitros, productoresviaje.pagounidad, viajeruta.pagounidad from viajeruta, productoresviaje where viajeruta.idviajeruta = productoresviaje.idviajeruta and productoresviaje.idproductor='".$vec_todos[$j]."' and viajeruta.idruta ='".$ruta[0]."' and viajeruta.fecha='".$dias[3]."'  order by viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor; ";
				$result_litros_dia = pg_exec($con,$sql_litros_dia);
				if(pg_num_rows($result_litros_dia)>0){
					$litros_dia = pg_fetch_array($result_litros_dia,0);
					echo "<div class='rl_columna' style='width:8.5%;text-align:right;'>".$litros_dia[3]."</div>";
					$total_litros+=$litros_dia[3];
					$total_dinero+=($litros_dia[3]*$litros_dia[4]);
					$global_transporte+=($litros_dia[3]*$litros_dia[5]);
					$miercoles+=$litros_dia[3];
				}else{
					echo "<div class='rl_columna' style='width:8.5%;'></div>";
				}		
				
				$sql_litros_dia = " select viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor, productoresviaje.cantidadlitros, productoresviaje.pagounidad, viajeruta.pagounidad from viajeruta, productoresviaje where viajeruta.idviajeruta = productoresviaje.idviajeruta and productoresviaje.idproductor='".$vec_todos[$j]."' and viajeruta.idruta ='".$ruta[0]."' and viajeruta.fecha='".$dias[4]."'  order by viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor; ";
				$result_litros_dia = pg_exec($con,$sql_litros_dia);
				if(pg_num_rows($result_litros_dia)>0){
					$litros_dia = pg_fetch_array($result_litros_dia,0);
					echo "<div class='rl_columna' style='width:6.8%;text-align:right;'>".$litros_dia[3]."</div>";
					$total_litros+=$litros_dia[3];
					$total_dinero+=($litros_dia[3]*$litros_dia[4]);
					$global_transporte+=($litros_dia[3]*$litros_dia[5]);
					$jueves+=$litros_dia[3];
				}else{
					echo "<div class='rl_columna' style='width:6.8%;'></div>";
				}											
	           
				$sql_litros_dia = " select viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor, productoresviaje.cantidadlitros, productoresviaje.pagounidad, viajeruta.pagounidad from viajeruta, productoresviaje where viajeruta.idviajeruta = productoresviaje.idviajeruta and productoresviaje.idproductor='".$vec_todos[$j]."' and viajeruta.idruta ='".$ruta[0]."' and viajeruta.fecha='".$dias[5]."'  order by viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor; ";
				$result_litros_dia = pg_exec($con,$sql_litros_dia);
				if(pg_num_rows($result_litros_dia)>0){
					$litros_dia = pg_fetch_array($result_litros_dia,0);
					echo "<div class='rl_columna' style='width:6%;text-align:right;'>".$litros_dia[3]."</div>";
					$total_litros+=$litros_dia[3];
					$total_dinero+=($litros_dia[3]*$litros_dia[4]);
					$global_transporte+=($litros_dia[3]*$litros_dia[5]);
					$viernes+=$litros_dia[3];
				}else{
					echo "<div class='rl_columna' style='width:6%;'></div>";
				}	
				
				$sql_litros_dia = " select viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor, productoresviaje.cantidadlitros, productoresviaje.pagounidad, viajeruta.pagounidad from viajeruta, productoresviaje where viajeruta.idviajeruta = productoresviaje.idviajeruta and productoresviaje.idproductor='".$vec_todos[$j]."' and viajeruta.idruta ='".$ruta[0]."' and viajeruta.fecha='".$dias[6]."'  order by viajeruta.fecha, viajeruta.idruta, productoresviaje.idproductor; ";
				$result_litros_dia = pg_exec($con,$sql_litros_dia);
				if(pg_num_rows($result_litros_dia)>0){
					$litros_dia = pg_fetch_array($result_litros_dia,0);
					echo "<div class='rl_columna' style='width:6%;text-align:right;'>".$litros_dia[3]."</div>";
					$total_litros+=$litros_dia[3];
					$total_dinero+=($litros_dia[3]*$litros_dia[4]);
					$global_transporte+=($litros_dia[3]*$litros_dia[5]);
					$sabado+=$litros_dia[3];
				}else{
					echo "<div class='rl_columna' style='width:6%;'></div>";
				}						   
	            	            
	            echo "<div class='rl_columna' style='width:8%;text-align:right;'>".$total_litros."</div>";
	            echo "<div class='rl_columna' style='width:8%;text-align:right;'>".number_format(round($total_dinero,2),2,'.','')."</div>";
				$global_litros+=$total_litros;
				$global_dinero+=$total_dinero;
				
		        echo "</div>";
			}/*Finaliza for de productores*/
			
        	echo "<div class='rl_linea' style='border-top:1px solid #CCC; border-bottom:1px solid #CCC;'>";
        	echo "<div class='rl_columna' style='width:21%;'>Total Productores</div>";
			
			if($domingo!=0){
				echo "<div class='rl_columna' style='width:8%;text-align:right;'>".$domingo."</div>";
			}else{
				echo "<div class='rl_columna' style='width:8%;'></div>";
			}
            
			if($lunes!=0){
				echo "<div class='rl_columna' style='width:6%;text-align:right;'>".$lunes."</div>";
			}else{
				echo "<div class='rl_columna' style='width:6%;'></div>";
			}
			
			if($martes!=0){
				echo "<div class='rl_columna' style='width:7%;text-align:right;'>".$martes."</div>";
			}else{
				echo "<div class='rl_columna' style='width:7%;'></div>";
			}
			
			if($miercoles!=0){
				echo "<div class='rl_columna' style='width:8.5%;text-align:right;'>".$miercoles."</div>";
			}else{
				echo "<div class='rl_columna' style='width:8.5%;'></div>";
			}
			
            if($jueves!=0){
				echo "<div class='rl_columna' style='width:6.8%;text-align:right;'>".$jueves."</div>";
			}else{
				echo "<div class='rl_columna' style='width:6.8%;'></div>";
			}
			
			if($viernes!=0){
				echo "<div class='rl_columna' style='width:6%;text-align:right;'>".$viernes."</div>";
			}else{
				echo "<div class='rl_columna' style='width:6%;text-align:right;'></div>";
			}
            
			if($sabado!=0){
				echo "<div class='rl_columna' style='width:6%;text-align:right;'>".$sabado."</div>";
			}else{
				echo "<div class='rl_columna' style='width:6%;'></div>";
			}
                                                
            echo "<div class='rl_columna' style='width:8%;text-align:right;'>".$global_litros."</div>";
            echo "<div class='rl_columna' style='width:8%;text-align:right;'>".number_format(round($global_dinero,2),2,'.','')."</div>";
	        echo "</div>";			
						
			
	        	echo "<div class='rl_linea' style='border-left:1px solid #f7f7f7;border-bottom:1px solid #CCC; background:#F8F8F8'>";	        	
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:7%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8.5%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6.8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;width:6%;'></div>";
				echo "<div class='rl_columna' style='width:21%;text-align:right;'>".$ruta[1]."</div>";
	            echo "<div class='rl_columna' style='width:8%;text-align:right;'>".$global_litros."</div>";
	            echo "<div class='rl_columna' style='width:8%;text-align:right;'>".number_format(round($global_transporte,2),2,'.','')."</div>";
	        	echo "</div>";				
			
			
			$sql_tipopersona="select * from tipopersona where idtipopersona='".$ruta[12]."';";
			$result_tipopersona=pg_exec($con,$sql_tipopersona);
			$tipopersona=pg_fetch_array($result_tipopersona,0);
			
	        	echo "<div class='rl_linea' style='border-left:1px solid #f7f7f7;border-bottom:1px solid #CCC; background:#F8F8F8'>";	        	
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:7%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8.5%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6.8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;width:6%;'></div>";
				echo "<div class='rl_columna' style='width:21%;text-align:right;'>Retención I.S.L.R</div>";
	            echo "<div class='rl_columna' style='width:8%;text-align:right;'>".$tipopersona[2]."%</div>";
	            echo "<div class='rl_columna' style='width:8%;text-align:right;'>".number_format(round($global_transporte*($tipopersona[2]/100),2),2,'.','')."</div>";
	        	echo "</div>";						
			
	        	echo "<div class='rl_linea' style='border-left:1px solid #f7f7f7;border-bottom:1px solid #CCC; background:#F8F8F8'>";	        	
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:7%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8.5%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6.8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
				echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;width:8%;text-align:right;'></div>";
				echo "<div class='rl_columna' style='width:21%;text-align:right;'>Total pago a transportista</div>";
	            
	            echo "<div class='rl_columna' style='width:8%;text-align:right;'>".number_format(round(($global_transporte-($global_transporte*($tipopersona[2]/100))),2),2,'.','')."</div>";
	        	echo "</div>";											
			
	        	echo "<div class='rl_linea' style='border-left:1px solid #f7f7f7;border-bottom:1px solid #CCC; background:#F8F8F8; margin-bottom:15px;'>";	        	
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:7%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8.5%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6.8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
				echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;width:8%;text-align:right;'></div>";
				echo "<div class='rl_columna' style='width:21%;text-align:right;'>Total</div>";
	            
	            echo "<div class='rl_columna' style='width:8%;text-align:right;'>".number_format(round(($global_dinero+($global_transporte-($global_transporte*($tipopersona[2]/100)))),2),2,'.','')."</div>";
	        	echo "</div>";				
			
			
			$litros_completos+=$global_litros;
			$bolivares_leche_completos+=$global_dinero;
			$bolivares_transporte_completos+=($global_transporte-($global_transporte*($tipopersona[2]/100)));
									
		}/*Finaliza for de Rutas*/
				
				
	        	echo "<div class='rl_linea' style='border-left:1px solid #f7f7f7;border-bottom:1px solid #CCC;;border-top:1px solid #CCC; background:#F8F8F8;'>";	        	
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:7%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8.5%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6.8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
				echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;width:8%;text-align:right;'></div>";
				echo "<div class='rl_columna' style='width:21%;text-align:right;'>Total Litros de Leche</div>";	            
	            echo "<div class='rl_columna' style='width:8%;text-align:right;'>".number_format(round($litros_completos,2),2,'.','')."</div>";
	        	echo "</div>";	
				
	        	echo "<div class='rl_linea' style='border-left:1px solid #f7f7f7;border-bottom:1px solid #CCC; background:#F8F8F8;'>";	        	
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:7%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8.5%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6.8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
				echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;width:8%;text-align:right;'></div>";
				echo "<div class='rl_columna' style='width:21%;text-align:right;'>Pago Total Litros de Leche</div>";	            
	            echo "<div class='rl_columna' style='width:8%;text-align:right;'>".number_format(round($bolivares_leche_completos,2),2,'.','')."</div>";
	        	echo "</div>";
				
	        	echo "<div class='rl_linea' style='border-left:1px solid #f7f7f7;border-bottom:1px solid #CCC; background:#F8F8F8;'>";	        	
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:7%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8.5%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6.8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
				echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;width:8%;text-align:right;'></div>";
				echo "<div class='rl_columna' style='width:21%;text-align:right;'>Pago Total Por Transporte</div>";	            
	            echo "<div class='rl_columna' style='width:8%;text-align:right;'>".number_format(round($bolivares_transporte_completos,2),2,'.','')."</div>";
	        	echo "</div>";
				
	        	echo "<div class='rl_linea' style='border-left:1px solid #f7f7f7;border-bottom:1px solid #CCC; background:#F8F8F8;'>";	        	
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:7%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:8.5%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6.8%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
	            echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;border-right:1px solid #f7f7f7;width:6%;'></div>";
				echo "<div class='rl_columna' style='border-bottom:1px solid #f7f7f7;width:8%;text-align:right;'></div>";
				echo "<div class='rl_columna' style='width:21%;text-align:right;background:#84cff7;'>Total</div>";	            
	            echo "<div class='rl_columna' style='width:8%;text-align:right;background:#84cff7;'>".number_format(round(($bolivares_leche_completos+$bolivares_transporte_completos),2),2,'.','')."</div>";
	        	echo "</div>";														
													
		echo "</div>";
		
	}

?>