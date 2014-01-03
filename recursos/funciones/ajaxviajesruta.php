<?php session_start();
    require("funciones.php");
    $con=Conectarse();		
	if($_POST["action"]==1){
		$sql_existe="select * from viajeruta where date(fecha) = '".$_POST["fecha"]."' and idruta='".$_POST["ruta"]."'";
		$result_existe=pg_exec($con,$sql_existe);
		$band=pg_num_rows($result_existe);	
		if($band>0){ //Ya Existe El Registro
		
		    $sql_consulta_viaje_ruta="select * from viajeruta where fecha='".$_POST["fecha"]."' and idruta='".$_POST["ruta"]."'";
			$result_viaje_ruta = pg_exec($con,$sql_consulta_viaje_ruta);
			$viaje_ruta=pg_fetch_array($result_viaje_ruta,0);
			
			$sql_productores_ruta =" select * from productoresviaje where idviajeruta='".$viaje_ruta[0]."'";
			$result_productores_ruta = pg_exec($con,$sql_productores_ruta);
			$numero_productores = pg_num_rows($result_productores_ruta);
			$numero = "";
			$en_el_camion = array();
			$banderas_en_el_camion = array();
			$cuenta_productores=0;
			
			for($i=0;$i<$numero_productores;$i++){
				$aux = pg_fetch_array($result_productores_ruta,$i);
			 	$en_el_camion[$cuenta_productores]= $aux[2];
				$banderas_en_el_camion[$cuenta_productores]=0;
				$cuenta_productores++;
				//echo "<--".$en_el_camion[sizeof($filtros)]."_".$banderas_en_el_camion[sizeof($filtros)]."-->";
			}
			
								
			$sql_select_idanalisis_general="select * from analisisquimico where idviajeruta='".$viaje_ruta[0]."'";
			$result_idanalisis_general = pg_exec($con,$sql_select_idanalisis_general);
			$idgeneralanalisis= pg_fetch_array($result_idanalisis_general,0);
									
			if($numero_productores<10){
				$numero="0".$numero_productores;	
			}else{
				$numero=$numero_productores;	
			}
			
		?>
		<div class="detalleviaje">
        	<div class="conte_detalle">
            	<div class="conte_detalle_numero"><?php echo $numero; ?></div>
                <div class="conte_detalle_describe">Productores</div>
            </div>
            <div class="conte_detalle">
            	<div class="conte_detalle_numero"><?php echo $viaje_ruta[3]; ?></div>
                <div class="conte_detalle_describe">Litros Viaje</div>            
            </div>
            <div class="conte_detalle">
            	<div class="conte_detalle_numero"><?php echo $viaje_ruta[6]; ?></div>
                <div class="conte_detalle_describe">Litros reales</div>            
            </div>
            <div class="conte_detalle">
                <?php 
				    
					if(($viaje_ruta[6]-$viaje_ruta[3])>=0){
						$color="#0C3";					
					}else{
						$color="#F00";
					}
				
				?>
            	<div class="conte_detalle_numero" style="color:<?php echo $color; ?>"><?php echo $viaje_ruta[6]-$viaje_ruta[3]; ?></div>
                <div class="conte_detalle_describe">Diferencia</div>             
            </div>
            <div class="conte_detalle" style="border-right:0px;">
            	<div class="conte_detalle_numero"><?php echo $viaje_ruta[7]; ?></div>
                <div class="conte_detalle_describe">Bs. Litro</div>             
            </div>            
        </div>	
        <div class="subtitulo">Detalle General</div>
        <div class="subcomponente">
        	<div class="subconte">
            	<div class="subcontearriba">Litros Viaje (l)</div>
                <div class="subconteabajo"><input type="text" name="litrosviaje" id="litrosviaje" value="<?php echo $viaje_ruta[3]; ?>" class="subentrada"  /></div>
            </div>
        	<div class="subconte">
            	<div class="subcontearriba">Peso Camión LLeno (kg)</div>
                <div class="subconteabajo"><input type="text" name="lleno" id="lleno" value="<?php echo $viaje_ruta[4]; ?>" class="subentrada" onblur="calcular_litros()"  /></div>
            </div>
        	<div class="subconte">
            	<div class="subcontearriba">Peso Camión Vacio (kg)</div>
                <div class="subconteabajo"><input type="text" name="vacio" id="vacio" value="<?php echo $viaje_ruta[5]; ?>" class="subentrada" onblur="calcular_litros()" /></div>
            </div>
        	<div class="subconte">
            	<div class="subcontearriba">Litros Reales (l)</div>
                <div class="subconteabajo"><input type="text" readonly="readonly" name="litrosreales" id="litrosreales" value="<?php echo $viaje_ruta[6]; ?>" class="subentrada"  /></div>
            </div>      
        	<div class="subconte">
            	<div class="subcontearriba">Diferencia (l)</div>
                <div class="subconteabajo"><input type="text" readonly="readonly" name="diferencia" id="diferencia" value="<?php echo $viaje_ruta[6]-$viaje_ruta[3]; ?>" class="subentrada"  /></div>
            </div>      
        	<div class="subconte">
            	<div class="subcontearriba">Temperatura (ºC)</div>
                <div class="subconteabajo"><input type="text" name="temperatura" id="temperatura" value="<?php echo $viaje_ruta[8]  ?>" class="subentrada"  /></div>
            </div>                                                    
        </div>        
        <div class="subtitulo">Analisis Quimico General</div>        
        <div class="subcomponente">
        <?php
				$sql_elementos="select * from elementoanalisis order by idelementoanalisis";
				$result_elementos = pg_exec($con,$sql_elementos);
				for($i=0;$i<pg_num_rows($result_elementos);$i++){
					$elemento = pg_fetch_array($result_elementos,$i);
		        	echo "<div class='subconte'>";
	            	echo "<div class='subcontearriba'>".$elemento[1]."</div>";
					$sql_elemento_observado="select * from analisiselementos where idanalisisquimico='".$idgeneralanalisis[0]."' and idelementoanalisis='".$elemento[0]."'";
					$result_elemento_observado=pg_exec($con,$sql_elemento_observado);
					if(pg_num_rows($result_elemento_observado)>0){
						$elemento_observado=pg_fetch_array($result_elemento_observado,0);
						echo "<div class='subconteabajo'><input type='text' name='".str_replace(" ","_",$elemento[1])."' id='".str_replace(" ","_",$elemento[1])."' value='".$elemento_observado[3]."' class='subentrada' /></div>";
					}else{
						echo "<div class='subconteabajo'><input type='text' name='".str_replace(" ","_",$elemento[1])."' id='".str_replace(" ","_",$elemento[1])."' value='' class='subentrada' /></div>";
					}

		            echo "</div>";					
				}		
		
		?>                                                            
        </div>        
        
        <div class="subtitulo">Productores</div>
    	
        	<table border="1" class="tablaproductores" id="tabla_productores" style="margin-left:2%">
            	<thead>
                	<tr style="font-family: 'Oswald', sans-serif; font-size:12px; background:#F9F9F9">
                		<td style="width:34%;padding-left:5px;padding-right:5px;">Productor</td>
                        <td style="width:7%;padding-left:5px;padding-right:5px; text-align:center;">Litros</td>
                        <?php
							for($i=0;$i<pg_num_rows($result_elementos);$i++){
								$elemento = pg_fetch_array($result_elementos,$i);
								echo "<td style='width:7%;padding-left:5px;padding-right:5px; text-align:center;'>".$elemento[1]."</td>";
							}
						?>                        
                    </tr>
                </thead>
                <tbody>
                    <?php
					    $valor="";
	           			$sql_select_productores="select * from productor where idruta='".$_POST["ruta"]."' order by nombreproductor DESC";
		  	            $result_select_productores = pg_exec($con,$sql_select_productores);
					    for($i=0;$i<pg_num_rows($result_select_productores);$i++){
					       $productor=pg_fetch_array($result_select_productores,$i);
						   $valor=$valor.$productor[0]."-";
						   for($b=0;$b<$cuenta_productores;$b++){
							   if($en_el_camion[$b]==$productor[0]){
								   $banderas_en_el_camion[$b]=1;
								   break;
							   }
						   }
						   
						   ?>
						   <tr style="font-family: 'Oswald', sans-serif; font-size:12px;">
                    	   <td style="padding-left:5px;"><?php echo $productor[3]; ?></td>
                           <?php 
						   	$sql_select_pro="select * from productoresviaje where idviajeruta='".$viaje_ruta[0]."' and idproductor='".$productor[0]."'";
							$result_select_pro=pg_exec($con,$sql_select_pro);
							if(pg_num_rows($result_select_pro)>0){
								$litros = pg_fetch_array($result_select_pro,0);
								echo "<td><input type='text' class='entrada_tabla' id='litros-".$productor[0]."' name='litros-".$productor[0]."' value='".$litros[3]."' /></td>";
								
								
							$sql_select_idanalisis_productor="select * from analisisquimico where idproductoresviaje='".$litros[0]."'";
							$result_idanalisis_productor = pg_exec($con,$sql_select_idanalisis_productor);
							$idproductoranalisis= pg_fetch_array($result_idanalisis_productor,0);
							
							//echo "<-".$litros[0]."-".$idproductoranalisis[0]."->";	

                            for($j=0;$j<pg_num_rows($result_elementos);$j++){
								$elemento = pg_fetch_array($result_elementos,$j); 
					
					            $sql_elemento_observado2="select * from analisiselementos where idanalisisquimico='".$idproductoranalisis[0]."' and idelementoanalisis='".$elemento[0]."'";
								$result_elemento_observado2=pg_exec($con,$sql_elemento_observado2);
								if(pg_num_rows($result_elemento_observado2)>0){
									 $elemento_observado2=pg_fetch_array($result_elemento_observado2,0);
	 								 echo "<td><input type='text' class='entrada_tabla' name='".str_replace(" ","_",$elemento[1])."-".$productor[0]."' id='".str_replace(" ","_",$elemento[1])."-".$productor[0]."' value='".$elemento_observado2[3]."' /></td>"; 									 		
								}else{
									 echo "<td><input type='text' class='entrada_tabla' name='".str_replace(" ","_",$elemento[1])."-".$productor[0]."' id='".str_replace(" ","_",$elemento[1])."-".$productor[0]."' value='' /></td>"; 									
								}																                       	
							}								
																																																																																											
							}else{
                                echo "<td><input type='text' class='entrada_tabla' id='litros-".$productor[0]."' name='litros-".$productor[0]."' value='' /></td>";																			
                            	for($j=0;$j<pg_num_rows($result_elementos);$j++){
									$elemento = pg_fetch_array($result_elementos,$j); 					
									echo "<td><input type='text' class='entrada_tabla' name='".str_replace(" ","_",$elemento[1])."-".$productor[0]."' id='".str_replace(" ","_",$elemento[1])."-".$productor[0]."' value='' /></td>"; 																																	                       	
								}																													
							}
							
							?>
                           </tr>                                                                                 
                           <?

						   
					    }
						
		for($b=0;$b<$cuenta_productores;$b++){  
			if($banderas_en_el_camion[$b]==0){
				$sql_datos_extra="select * from productor where idproductor='".$en_el_camion[$b]."'";
				$result_datos_extra = pg_exec($con,$sql_datos_extra);
				$productor_extra=pg_fetch_array($result_datos_extra,0);
				$valor=$valor.$productor_extra[0]."-";
				
				$sql_select_pro="select * from productoresviaje where idviajeruta='".$viaje_ruta[0]."' and idproductor='".$en_el_camion[$b]."'";
				$result_select_pro=pg_exec($con,$sql_select_pro);								
				echo "<tr style='font-family: Oswald, sans-serif; font-size:12px;'>";																								
				echo "<td style='padding-left:5px;'>".$productor_extra[3]."</td>";
				
				if(pg_num_rows($result_select_pro)>0){
					$litros = pg_fetch_array($result_select_pro,0);
					echo "<td><input type='text' class='entrada_tabla' id='litros-".$en_el_camion[$b]."' name='litros-".$en_el_camion[$b]."' value='".$litros[3]."' /></td>";			
				}else{
                    echo "<td><input type='text' class='entrada_tabla' id='litros-".$en_el_camion[$b]."' name='litros-".$en_el_camion[$b]."' value='' /></td>";								
				}			
				
				
				$sql_select_idanalisis_productor="select * from analisisquimico where idproductoresviaje='".$litros[0]."'";
				$result_idanalisis_productor = pg_exec($con,$sql_select_idanalisis_productor);
				$idproductoranalisis= pg_fetch_array($result_idanalisis_productor,0);	

                for($j=0;$j<pg_num_rows($result_elementos);$j++){
					$elemento = pg_fetch_array($result_elementos,$j); 
					$sql_elemento_observado2="select * from analisiselementos where idanalisisquimico='".$idproductoranalisis[0]."' and idelementoanalisis='".$elemento[0]."'";
					$result_elemento_observado2=pg_exec($con,$sql_elemento_observado2);
					if(pg_num_rows($result_elemento_observado2)>0){
						$elemento_observado2=pg_fetch_array($result_elemento_observado2,0);
	 					echo "<td><input type='text' class='entrada_tabla' name='".str_replace(" ","_",$elemento[1])."-".$productor_extra[0]."' id='".str_replace(" ","_",$elemento[1])."-".$productor_extra[0]."' value='".$elemento_observado2[3]."' /></td>"; 									 		
					}else{
						echo "<td><input type='text' class='entrada_tabla' name='".str_replace(" ","_",$elemento[1])."-".$productor_extra[0]."' id='".str_replace(" ","_",$elemento[1])."-".$productor_extra[0]."' value='' /></td>"; 									
					}																                       	
				}												
				echo "</tr>";
			}
		}																							
					?>

                </tbody>
            </table>
           <div class="conte_agregar" id="conte_agregar" >
           <select data-placeholder="Seleccione el productor.." name="productores" id="productores" style="width:365px;" class="chzn-select" >
               <option value="0"></option>
               <?php								     
	           $sql_select_productores="select * from productor where idruta!='".$_POST["ruta"]."' order by nombreproductor  DESC";
	           $result_select_productores = pg_exec($con,$sql_select_productores);
			   for($i=0;$i<pg_num_rows($result_select_productores);$i++){
			       $productor=pg_fetch_array($result_select_productores,$i);
					  $sql_revisar_productor =" select viajeruta.fecha, productoresviaje.idproductor from productoresviaje, viajeruta where viajeruta.idviajeruta = productoresviaje.idviajeruta and productoresviaje.idproductor='".$productor[0]."' and viajeruta.fecha='".$_POST["fecha"]."';";
					  echo $sql_revisar_productor;
					  $result_revisar_productor = pg_exec($con,$sql_revisar_productor);
					  if(pg_num_rows($result_revisar_productor)==0){
						  echo "<option value=".$productor[0].">".$productor[3]."</option>";
					  }				   				   				    										 										 
			   }
			   ?>
           </select>          
           </div>
                <div class="boton_cargar"><input type="button" value="Agregar" onclick="agregar()" style="font-size:12px;font-family: 'Oswald', sans-serif; line-height:14px; margin:0px; height:25px; width:70px;"/></div> <input type="hidden" name="listaproduc" id="listaproduc" value="<? echo $valor; ?>" />         
                <div class="boton_cargar"><input type="button" value="Editar" onclick="editar()" style="font-size:12px;font-family: 'Oswald', sans-serif; line-height:14px; margin:0px; height:25px; width:70px;"/></div>             
                                                             
        <?		
		
		
		}else		
		if($band==0){ //No existe Registro
		  ?>                                   
        <div class="subtitulo">Detalle General</div>
        <div class="subcomponente">
        	<div class="subconte">
            	<div class="subcontearriba">Litros Viaje (l)</div>
                <div class="subconteabajo"><input type="text" name="litrosviaje" id="litrosviaje" value="" class="subentrada"  /></div>
            </div>
        	<div class="subconte">
            	<div class="subcontearriba">Peso Camión LLeno (kg)</div>
                <div class="subconteabajo"><input type="text" name="lleno" id="lleno" value="" class="subentrada" onblur="calcular_litros()"  /></div>
            </div>
        	<div class="subconte">
            	<div class="subcontearriba">Peso Camión Vacio (kg)</div>
                <div class="subconteabajo"><input type="text" name="vacio" id="vacio" value="" class="subentrada" onblur="calcular_litros()" /></div>
            </div>
        	<div class="subconte">
            	<div class="subcontearriba">Litros Reales (l)</div>
                <div class="subconteabajo"><input type="text" readonly="readonly" name="litrosreales" id="litrosreales" value="" class="subentrada"  /></div>
            </div>      
        	<div class="subconte">
            	<div class="subcontearriba">Diferencia (l)</div>
                <div class="subconteabajo"><input type="text" readonly="readonly" name="diferencia" id="diferencia" value="" class="subentrada"  /></div>
            </div>      
        	<div class="subconte">
            	<div class="subcontearriba">Temperatura (ºC)</div>
                <div class="subconteabajo"><input type="text" name="temperatura" id="temperatura" value="" class="subentrada"  /></div>
            </div>                                                    
        </div>
        <div class="subtitulo">Analisis Quimico General</div>
        <div class="subcomponente">
       		<?php
				$con=Conectarse();
				$sql_elementos="select * from elementoanalisis order by idelementoanalisis";
				$result_elementos = pg_exec($con,$sql_elementos);
				for($i=0;$i<pg_num_rows($result_elementos);$i++){
					$elemento = pg_fetch_array($result_elementos,$i);
		        	echo "<div class='subconte'>";
	            	echo "<div class='subcontearriba'>".$elemento[1]."</div>";
	                echo "<div class='subconteabajo'><input type='text' name='".str_replace(" ","_",$elemento[1])."' id='".str_replace(" ","_",$elemento[1])."' value='' class='subentrada'  /></div>";
		            echo "</div>";					
				}
			?>                                                                     
        </div>
            
        <div class="subtitulo">Productores</div>
    	
        	<table border="1" class="tablaproductores" id="tabla_productores" style="margin-left:2%">
            	<thead>
                	<tr style="font-family: 'Oswald', sans-serif; font-size:12px; background:#F9F9F9">
                		<td style="width:34%;padding-left:5px;padding-right:5px;">Productor</td>
                        <td style="width:7%;padding-left:5px;padding-right:5px; text-align:center;">Litros</td>
                        <?php
							for($i=0;$i<pg_num_rows($result_elementos);$i++){
								$elemento = pg_fetch_array($result_elementos,$i);
								echo "<td style='width:7%;padding-left:5px;padding-right:5px; text-align:center;'>".$elemento[1]."</td>";
							}
						?>                        
                    </tr>
                </thead>
                <tbody>
                    <?php
					    $valor="";
	           			$sql_select_productores="select * from productor where idruta='".$_POST["ruta"]."' order by nombreproductor DESC";
		  	            $result_select_productores = pg_exec($con,$sql_select_productores);
					    for($i=0;$i<pg_num_rows($result_select_productores);$i++){
					       $productor=pg_fetch_array($result_select_productores,$i);
						   $valor=$valor.$productor[0]."-";
						   ?>
						   <tr style="font-family: 'Oswald', sans-serif; font-size:12px;">
                    	   <td style="padding-left:5px;"><?php echo $productor[3]; ?></td>
                           <td><input type="text" class="entrada_tabla" id="litros-<?php echo $productor[0]; ?>" name="litros-<?php echo $productor[0]; ?>"  /></td>
							<?php
                            for($j=0;$j<pg_num_rows($result_elementos);$j++){
								$elemento = pg_fetch_array($result_elementos,$j); 
								echo "<td><input type='text' class='entrada_tabla' name='".str_replace(" ","_",$elemento[1])."-".$productor[0]."' id='".str_replace(" ","_",$elemento[1])."-".$productor[0]."' /></td>";                        	
							}
							?>
                           </tr>
                           <?
					    }					
					?>

                </tbody>
            </table>
           <div class="conte_agregar" id="conte_agregar">
           <select data-placeholder="Seleccione el productor.." name="productores" id="productores" style="width:365px;" class="chzn-select" >
               <option value="0"></option>
               <?php								     
	           $sql_select_productores="select * from productor where idruta!='".$_POST["ruta"]."' order by nombreproductor  DESC";
	           $result_select_productores = pg_exec($con,$sql_select_productores);
			   for($i=0;$i<pg_num_rows($result_select_productores);$i++){
			       $productor=pg_fetch_array($result_select_productores,$i);
					  $sql_revisar_productor =" select viajeruta.fecha, productoresviaje.idproductor from productoresviaje, viajeruta where viajeruta.idviajeruta = productoresviaje.idviajeruta and productoresviaje.idproductor='".$productor[0]."' and viajeruta.fecha='".$_POST["fecha"]."';";
					  echo $sql_revisar_productor;
					  $result_revisar_productor = pg_exec($con,$sql_revisar_productor);
					  if(pg_num_rows($result_revisar_productor)==0){				   				   
						   echo "<option value=".$productor[0].">".$productor[3]."</option>";
					  }
			   }
			   ?>
           </select>          
           </div>
                <div class="boton_cargar"><input type="button" value="Agregar" onclick="agregar()" style="font-size:12px;font-family: 'Oswald', sans-serif; line-height:14px; margin:0px; height:25px; width:70px;"/></div> <input type="hidden" name="listaproduc" id="listaproduc" value="<? echo $valor; ?>" />         
                <div class="boton_cargar"><input type="button" value="Guardar" onclick="guardar()" style="font-size:12px;font-family: 'Oswald', sans-serif; line-height:14px; margin:0px; height:25px; width:70px;"/></div>  
		  <?	
		}
		
		
									
	}
	
	
	
	
	
	
	
	
	if($_POST["action"]==2){/*refresca el selec de productores verificando que ya no este agregado*/
		$usados=explode("-",$_POST["usados"]);
		   ?>
           <select data-placeholder="Seleccione el productor.." name="productores" id="productores" style="width:365px;" class="chzn-select" >
               <option value="0"></option>
               <?php
			   			
			   //$productores								     
	           $sql_select_productores="select * from productor where idruta!='".$_POST["ruta"]."' order by nombreproductor  DESC";
	           $result_select_productores = pg_exec($con,$sql_select_productores);
			   for($i=0;$i<pg_num_rows($result_select_productores);$i++){
			       $productor=pg_fetch_array($result_select_productores,$i);
				   $bandpro=0;
				   for($j=0;$j<(sizeof($usados)-1);$j++){			
				        if($productor[0]==$usados[$j]){
						    $bandpro=1;	
						}
		           }
				   if($bandpro==0){
					  $sql_revisar_productor =" select viajeruta.fecha, productoresviaje.idproductor from productoresviaje, viajeruta where viajeruta.idviajeruta = productoresviaje.idviajeruta and productoresviaje.idproductor='".$productor[0]."' and viajeruta.fecha='".$_POST["fecha"]."';";
					  echo $sql_revisar_productor;
					  $result_revisar_productor = pg_exec($con,$sql_revisar_productor);
					  if(pg_num_rows($result_revisar_productor)==0){
						  echo "<option value=".$productor[0].">".$productor[3]."</option>"; 
					  }					  
				   }				    										 										 
			   }
			 ?>
           </select>
           <?		
	}
	
	if($_GET["action"]==3){ //registro nuevo viaje de ruta
	  if($_POST["accion"]==1){
	 // echo "entro en registro de nuevo viaje";
	  $sql_select_pago="select pagounidad from ruta where idruta='".$_POST["rutas"]."'";
	  $result_pago=pg_exec($con,$sql_select_pago);
	  $pago=pg_fetch_array($result_pago,0);
	  
	  $temperatura="NULL";
	  
	  if($_POST["temperatura"]!=""){
	       $temperatura=$_POST["$temperatura"];
	  }
	  
	  $auxTemperatura="";
	  if($_POST["temperatura"]!=NULL){
		  $auxTemperatura=$_POST["temperatura"];
	  }else{
		  $auxTemperatura="null";  
	  }
	  
	  $sql_insert_viaje="insert into viajeruta values(nextval('viajeruta_idviajeruta_seq'),'".$_POST["rutas"]."','".$_POST["fecha"]."','".$_POST["litrosviaje"]."','".$_POST["lleno"]."','".$_POST["vacio"]."','".$_POST["litrosreales"]."','".$pago[0]."',".$auxTemperatura.",now())";

	  
	  $result_insert_viaje = pg_exec($con,$sql_insert_viaje);   	  
	  $productores=explode("-",$_POST["listaproduc"]);
	  
	  /*Busco el id del ultimo viaje que se inserto en la base datos*/
	  $sql_ultimo_viaje = " select last_value from viajeruta_idviajeruta_seq; ";
	  $result_ultimo=pg_exec($con,$sql_ultimo_viaje);
	  $ultimo = pg_fetch_array($result_ultimo,0);
	  
	  /*Inserto el analisis fisicoquimico del viaje en general LA RUTA*/
	  $sql_fisico_general=" insert into analisisquimico values (nextval('analisisquimico_idanalisisquimico_seq'),'".$ultimo[0]."',null)";
	  $result_fisico_general = pg_exec($con,$sql_fisico_general);	  
	  
	  /*Busco el id del ultimo analisis quimico que se inserto*/
	  $sql_ultimo_analisis = " select last_value from analisisquimico_idanalisisquimico_seq; ";
	  $result_ultimo_analisis=pg_exec($con,$sql_ultimo_analisis);
	  $ultimo_analisis = pg_fetch_array($result_ultimo_analisis,0);	
	  
	  /*Recorro los elementos de un analisis fisico quimico e inserto los observados en el general de LA RUTA*/
	  $con=Conectarse();
	  $sql_elementos="select * from elementoanalisis order by idelementoanalisis";
	  $result_elementos = pg_exec($con,$sql_elementos);
	  for($i=0;$i<pg_num_rows($result_elementos);$i++){
	  	   $elemento = pg_fetch_array($result_elementos,$i);
		   /*Verifico que el elemento del analisis tenga un valor en el formulario*/
		   if($_POST[str_replace(" ","_",$elemento[1])]!="" && $_POST[str_replace(" ","_",$elemento[1])]!=NULL ){
			   $sql_insert_analisiselementos="insert into analisiselementos values(nextval('analisiselementos_idanalisiselementos_seq'),'".$ultimo_analisis[0]."','".$elemento[0]."',".$_POST[str_replace(" ","_",$elemento[1])]."); ";
			   $result_insert_analisiselementos=pg_exec($con,$sql_insert_analisiselementos);
		   }		   		   
	  }
	  
	    
	  
	  /*Recorro la lista de productores y consulto en la base datos sus datos*/
	  for($i=0;$i<(sizeof($productores)-1);$i++){
		  
		   if($_POST["litros-".$productores[$i]]!="" && $_POST["litros-".$productores[$i]]!=" " && $_POST["litros-".$productores[$i]]!=0){
		   	   $sql_productor="select * from productor where idproductor='".$productores[$i]."'";
			   $result_productor=pg_exec($con,$sql_productor);
			   $productor=pg_fetch_array($result_productor,0);
			   
			   $sql_insert_productor_viaje = "insert into productoresviaje values(nextval('productoresviaje_idproductoresviaje_seq'),'".$ultimo[0]."','".$productor[0]."','".$_POST["litros-".$productor[0]]."','".$productor[9]."')";
			   $result_insert_productor_viaje = pg_exec($con,$sql_insert_productor_viaje);
		   
		       /*Busco el id del ultimo productorviaje que se inserto en la base datos*/
			   $sql_ultimo_productor_viaje = " select last_value from productoresviaje_idproductoresviaje_seq; ";
			   $result_ultimo_productor_viaje=pg_exec($con,$sql_ultimo_productor_viaje);
			   $ultimo_productor = pg_fetch_array($result_ultimo_productor_viaje,0);	
		   
	 		   /*Inserto el analisis fisicoquimico de cada productor en el vieje PRODUCTOR*/
	 		   $sql_fisico_pro=" insert into analisisquimico values(nextval('analisisquimico_idanalisisquimico_seq'),null,'".$ultimo_productor[0]."')";
			   $result_fisico_pro = pg_exec($con,$sql_fisico_pro);
	
			   /*Busco el id del ultimo analisis quimico que se inserto*/
			   $sql_ultimo_analisis = " select last_value from analisisquimico_idanalisisquimico_seq; ";
			   $result_ultimo_analisis=pg_exec($con,$sql_ultimo_analisis);
			   $ultimo_analisis = pg_fetch_array($result_ultimo_analisis,0);
		   
		   
	  			/*Recorro los elementos de un analisis fisico quimico e inserto los observados en el detallado de cada productor*/
				  for($j=0;$j<pg_num_rows($result_elementos);$j++){
				  	   $elemento = pg_fetch_array($result_elementos,$j);
					   /*Verifico que el elemento del analisis tenga un valor en el formulario*/
					   if($_POST[str_replace(" ","_",$elemento[1])."-".$productor[0]]!="" && $_POST[str_replace(" ","_",$elemento[1])."-".$productor[0]]!=NULL ){	
					   	  $sql_insert_analisiselementos="insert into analisiselementos values(nextval('analisiselementos_idanalisiselementos_seq'),'".$ultimo_analisis[0]."','".$elemento[0]."',".$_POST[str_replace(" ","_",$elemento[1])."-".$productor[0]]."); ";
				          $result_insert_analisiselementos=pg_exec($con,$sql_insert_analisiselementos);
				       }		   		   
				  }				   
			   
		   }/*Final del if*/
		  	   			  		   	   		   		   		   
	  }/*Final del for*/
	  
		$sql_diaRegistrado="select * from inventarioleche where fecha='".$_POST["fecha"]."';";
		$result_diaRegistrado=pg_exec($con,$sql_diaRegistrado);		
		
		if(pg_num_rows($result_diaRegistrado)==0){/*El dia no esta registrado en la tabla*/
			$sql_ultimo_dia="select fecha from inventarioleche order by fecha DESC;";
			$result_ultimo_dia=pg_exec($con,$sql_ultimo_dia);
			$ultimodia=pg_fetch_array($result_ultimo_dia,0);			
			$fechaInicio=strtotime($ultimodia[0]);
		    $fechaFin=strtotime($_POST["fecha"]);
			/*Recorro los dias desde el ultimo registrado al que estoy registrando*/			
			for($i=($fechaInicio+86400);($i<=$fechaFin);$i+=86400){
				$diaAtras=($i-86400);
				$sql_diaAnterior="select * from inventarioleche where fecha='".date("Y-m-d",$diaAtras)."';";
				$result_diaAnterior=pg_exec($con,$sql_diaAnterior);
				$diaAnterior=pg_fetch_array($result_diaAnterior,0);
								
				$sql_insertDiaNuevo=" insert into inventarioleche values(nextval('inventarioleche_idinventarioleche_seq'),'".date("Y-m-d",$i)."',".$diaAnterior[7].",0,0,0,0,".$diaAnterior[7].")";
				$result_insertDiaNuevo=pg_exec($con,$sql_insertDiaNuevo);				
			}
		}
		
		/*En este punto el dia ya se encuentra registrado en la base datos*/
		/*consulto los viajes de ruta para determinar la leche recibida*/
		
		$totalLitros=0;
		$sql_viajesRutas="select * from viajeruta where fecha='".$_POST["fecha"]."';";
		$result_viajesRutas=pg_exec($con,$sql_viajesRutas);
		for($i=0;$i<pg_num_rows($result_viajesRutas);$i++){
			$viajeRuta=pg_fetch_array($result_viajesRutas,$i);
			$totalLitros+=$viajeRuta[3];
		}
		
		$sql_diaseditados="select * from inventarioleche where fecha >='".$_POST["fecha"]."' order by fecha;";
		$result_diaseditados=pg_exec($con,$sql_diaseditados);
		for($j=0;$j<pg_num_rows($result_diaseditados);$j++){
			$diaEditado=pg_fetch_array($result_diaseditados,$j);
			if($j==0){
				
				$sql_updateDia="update inventarioleche set recibida=".$totalLitros.", final=".(($diaEditado[2]+$totalLitros)-($diaEditado[4]+$diaEditado[5]+$diaEditado[6]))." where idinventarioleche=".$diaEditado[0]."";
				$result_updateDia=pg_exec($con,$sql_updateDia);
				
			}else if($j>0){
				
				$indiceAnterior=pg_fetch_array($result_diaseditados,($j-1));
				$sql_diaAnterior="select * from inventarioleche where idinventarioleche='".$indiceAnterior[0]."';";
				$result_diaAnterior=pg_exec($con,$sql_diaAnterior);
				$diaAnterior=pg_fetch_array($result_diaAnterior,0);
				$sql_updateDia="update inventarioleche set inicial=".$diaAnterior[7].", final=".(($diaAnterior[7]+$diaEditado[3])-($diaEditado[4]+$diaEditado[5]+$diaEditado[6]))." where idinventarioleche=".$diaEditado[0].";";					
				$result_updateDia=pg_exec($con,$sql_updateDia);				
			}
		}
	  
	  ?>
      	<script type="text/javascript" language="javascript">
		    alert("Viaje de Ruta registrado Satisfactoriamente.");		    
			location.href="../../sistema/ViajeDeRuta.php";
        </script>
      <?
	  
	  }else if($_POST["accion"]==2){
	      
		  $sql_select_pago="select pagounidad from ruta where idruta='".$_POST["rutas"]."'";
   	  	  $result_pago=pg_exec($con,$sql_select_pago);
	      $pago=pg_fetch_array($result_pago,0);
		  
	      $temperatura="null";
	  
	      if($_POST["temperatura"]!=""){
	       	  $temperatura=$_POST["$temperatura"];
	      }
	  
	  	  $auxTemperatura="";
	      if($_POST["temperatura"]!=NULL){
		      $auxTemperatura=$_POST["temperatura"];
	      }else{
		      $auxTemperatura="null";  
	      }	
		  				  		  
		  $sql_update_viaje=" update viajeruta set listrosviaje='".$_POST["litrosviaje"]."', pesolleno='".$_POST["lleno"]."', pesovacio='".$_POST["vacio"]."', litrosreal='".$_POST["litrosreales"]."', temperatura=".$auxTemperatura." where idruta='".$_POST["rutas"]."' and fecha='".$_POST["fecha"]."'";
		  $result_update_viaje = pg_exec($con,$sql_update_viaje); 
		  $productores=explode("-",$_POST["listaproduc"]);
		  
		  $sql_select_idviaje_general=" select * from viajeruta where fecha='".$_POST["fecha"]."' and idruta='".$_POST["rutas"]."' ";
		  $result_idviaje_general = pg_exec($con,$sql_select_idviaje_general);
		  $idviajegeneral = pg_fetch_array($result_idviaje_general,0);
		  
		  $sql_select_idanalisis_general =" select * from analisisquimico where idviajeruta ='".$idviajegeneral[0]."' ";
		  $result_idanalisis_general = pg_exec($con,$sql_select_idanalisis_general);
		  $idanalisisgeneral = pg_fetch_array($result_idanalisis_general,0);
		  
		  $sql_elementos="select * from elementoanalisis order by idelementoanalisis";
		  $result_elementos = pg_exec($con,$sql_elementos);
		  for($i=0;$i<pg_num_rows($result_elementos);$i++){
		  	   $elemento = pg_fetch_array($result_elementos,$i);
			   /*Verifico que el elemento del analisis tenga un valor en el formulario*/
			   if($_POST[str_replace(" ","_",$elemento[1])]!="" && $_POST[str_replace(" ","_",$elemento[1])]!=NULL ){
				   
				   $sql_existencia_general=" select * from analisiselementos where idanalisisquimico='".$idanalisisgeneral[0]."' and idelementoanalisis ='".$elemento[0]."' ";
				   $result_existencia_general = pg_exec($con,$sql_existencia_general);
				   $bandera_existencia = pg_num_rows($result_existencia_general);
				   
				   if($bandera_existencia==0){
					   $sql_insert_analisiselementos="insert into analisiselementos values(nextval('analisiselementos_idanalisiselementos_seq'),'".$idanalisisgeneral[0]."','".$elemento[0]."',".$_POST[str_replace(" ","_",$elemento[1])]."); ";
					   $result_insert_analisiselementos=pg_exec($con,$sql_insert_analisiselementos);					   
				   }else if($bandera_existencia>0){
					   $ultimo_analisis_ruta=pg_fetch_array($result_existencia_general,0);
					   $sql_update_analisiselementos=" update analisiselementos set valor = '".$_POST[str_replace(" ","_",$elemento[1])]."' where idanalisiselementos='".$ultimo_analisis_ruta[0]."' ";
					   $result_update_analisiselementos = pg_exec($con,$sql_update_analisiselementos);
				   }							   			   
			   }else{
					$sql_delete_elementoanalisis=" delete from analisiselementos where idanalisisquimico='".$idanalisisgeneral[0]."' and idelementoanalisis ='".$elemento[0]."'";
					$result_delete_elementoanalisis= pg_exec($con,$sql_delete_elementoanalisis);   				   
			   }
		  }		  
		  
		  $sql_productores_viaje=" select * from productoresviaje where idviajeruta='".$idviajegeneral[0]."' ";
		  $result_productores_viaje = pg_exec($con,$sql_productores_viaje);
		  for($j=0;$j<pg_num_rows($result_productores_viaje);$j++){
			  $productor_en_viaje = pg_fetch_array($result_productores_viaje,$j);
			  
			  if($_POST["litros-".$productor_en_viaje[2]]!="" && $_POST["litros-".$productor_en_viaje[2]]!=" " && $_POST["litros-".$productor_en_viaje[2]]!=0){

		   	   $sql_productor="select * from productor where idproductor='".$productor_en_viaje[2]."'";
			   $result_productor=pg_exec($con,$sql_productor);
			   $productor=pg_fetch_array($result_productor,0);
			   			   
			   $sql_update_productor_viaje = " update productoresviaje set cantidadlitros ='".$_POST["litros-".$productor_en_viaje[2]]."' where idproductoresviaje ='".$productor_en_viaje[0]."' ";			   
			   $result_update_productor_viaje = pg_exec($con,$sql_update_productor_viaje);
			   
			   $sql_select_idanalisis_productor =" select * from analisisquimico where idproductoresviaje ='".$productor_en_viaje[0]."' ";
			   $result_idanalisis_productor = pg_exec($con,$sql_select_idanalisis_productor);
			   $idanalisisproductor = pg_fetch_array($result_idanalisis_productor,0);			   
			   
			   
		  for($i=0;$i<pg_num_rows($result_elementos);$i++){
		  	   $elemento = pg_fetch_array($result_elementos,$i);
			   /*Verifico que el elemento del analisis tenga un valor en el formulario*/
			   if($_POST[str_replace(" ","_",$elemento[1])."-".$productor[0]]!="" && $_POST[str_replace(" ","_",$elemento[1])."-".$productor[0]]!=NULL ){
				   
				   $sql_existencia_particular=" select * from analisiselementos where idanalisisquimico='".$idanalisisproductor[0]."' and idelementoanalisis ='".$elemento[0]."' ";
				   $result_existencia_particular = pg_exec($con,$sql_existencia_particular);
				   $bandera_particular = pg_num_rows($result_existencia_particular);
				   
				   if($bandera_particular==0){
					   $sql_insert_analisiselementos="insert into analisiselementos values(nextval('analisiselementos_idanalisiselementos_seq'),'".$idanalisisproductor[0]."','".$elemento[0]."',".$_POST[str_replace(" ","_",$elemento[1])."-".$productor[0]]."); ";
					   $result_insert_analisiselementos=pg_exec($con,$sql_insert_analisiselementos);					   
				   }else if($bandera_particular>0){
					   $ultimo_analisis_ruta=pg_fetch_array($result_existencia_particular,0);
					   $sql_update_analisiselementos=" update analisiselementos set valor = '".$_POST[str_replace(" ","_",$elemento[1])."-".$productor[0]]."' where idanalisiselementos='".$ultimo_analisis_ruta[0]."' ";
					   $result_update_analisiselementos = pg_exec($con,$sql_update_analisiselementos);
				   }							   			   
			   }else{
					$sql_delete_elementoanalisis=" delete from analisiselementos where idanalisisquimico='".$idanalisisproductor[0]."' and idelementoanalisis ='".$elemento[0]."'";
					$result_delete_elementoanalisis= pg_exec($con,$sql_delete_elementoanalisis);   				   
			   }
		  }					   
			   			   			   	   			   
			   }else{
				   $sql_select_idanalisis_productor =" select * from analisisquimico where idproductoresviaje ='".$productor_en_viaje[0]."' ";
				   $result_idanalisis_productor = pg_exec($con,$sql_select_idanalisis_productor);
				   $idanalisisproductor = pg_fetch_array($result_idanalisis_productor,0);
				   
				   $delete_elementos_analisis=" delete from analisiselementos where idanalisisquimico='".$idanalisisproductor[0]."'";	
				   $result_delete_elementos_analisis = pg_exec($con,$delete_elementos_analisis);
				   	
				   $delete_analisis_quimico = "delete from analisisquimico where idproductoresviaje ='".$productor_en_viaje[0]."'";
				   $result_delete_analisis_quimico = pg_exec($con,$delete_analisis_quimico);	
				   
				   $delete_productor_viaje = " delete from productoresviaje where idproductoresviaje ='".$productor_en_viaje[0]."'";
				   $result_delete_productor_viaje = pg_exec($con,$delete_productor_viaje);
				   						
			   }			   			   			   
		  }
		  
		$sql_diaRegistrado="select * from inventarioleche where fecha='".$_POST["fecha"]."';";
		$result_diaRegistrado=pg_exec($con,$sql_diaRegistrado);		
		
		if(pg_num_rows($result_diaRegistrado)==0){/*El dia no esta registrado en la tabla*/
			$sql_ultimo_dia="select fecha from inventarioleche order by fecha DESC;";
			$result_ultimo_dia=pg_exec($con,$sql_ultimo_dia);
			$ultimodia=pg_fetch_array($result_ultimo_dia,0);			
			$fechaInicio=strtotime($ultimodia[0]);
		    $fechaFin=strtotime($_POST["fecha"]);
			/*Recorro los dias desde el ultimo registrado al que estoy registrando*/			
			for($i=($fechaInicio+86400);($i<=$fechaFin);$i+=86400){
				$diaAtras=($i-86400);
				$sql_diaAnterior="select * from inventarioleche where fecha='".date("Y-m-d",$diaAtras)."';";
				$result_diaAnterior=pg_exec($con,$sql_diaAnterior);
				$diaAnterior=pg_fetch_array($result_diaAnterior,0);
								
				$sql_insertDiaNuevo=" insert into inventarioleche values(nextval('inventarioleche_idinventarioleche_seq'),'".date("Y-m-d",$i)."',".$diaAnterior[7].",0,0,0,0,".$diaAnterior[7].")";
				$result_insertDiaNuevo=pg_exec($con,$sql_insertDiaNuevo);				
			}
		}
		
		/*En este punto el dia ya se encuentra registrado en la base datos*/
		/*consulto los viajes de ruta para determinar la leche recibida*/
		
		$totalLitros=0;
		$sql_viajesRutas="select * from viajeruta where fecha='".$_POST["fecha"]."';";
		$result_viajesRutas=pg_exec($con,$sql_viajesRutas);
		for($i=0;$i<pg_num_rows($result_viajesRutas);$i++){			
			$viajeRuta=pg_fetch_array($result_viajesRutas,$i);
			$totalLitros+=$viajeRuta[3];
		}
		
		$sql_diaseditados="select * from inventarioleche where fecha >='".$_POST["fecha"]."' order by fecha;";
		$result_diaseditados=pg_exec($con,$sql_diaseditados);
		for($j=0;$j<pg_num_rows($result_diaseditados);$j++){
			$diaEditado=pg_fetch_array($result_diaseditados,$j);
			if($j==0){
				
				$sql_updateDia="update inventarioleche set recibida=".$totalLitros.", final=".(($diaEditado[2]+$totalLitros)-($diaEditado[4]+$diaEditado[5]+$diaEditado[6]))." where idinventarioleche=".$diaEditado[0].";";
				$result_updateDia=pg_exec($con,$sql_updateDia);
				
			}else if($j>0){
				
				$indiceAnterior=pg_fetch_array($result_diaseditados,($j-1));
				$sql_diaAnterior="select * from inventarioleche where idinventarioleche='".$indiceAnterior[0]."';";
				$result_diaAnterior=pg_exec($con,$sql_diaAnterior);
				$diaAnterior=pg_fetch_array($result_diaAnterior,0);
				$sql_updateDia="update inventarioleche set inicial=".$diaAnterior[7].", final=".(($diaAnterior[7]+$diaEditado[3])-($diaEditado[4]+$diaEditado[5]+$diaEditado[6]))." where idinventarioleche=".$diaEditado[0].";";					
				$result_updateDia=pg_exec($con,$sql_updateDia);				
			}
		}		  
		  		   		  											
	  ?>
      	<script type="text/javascript" language="javascript">		 
		    alert("Viaje de Ruta Editado Satisfactoriamente");    
			location.href="../../sistema/ViajeDeRuta.php";
        </script>
      <?			
			
	  }
	  
	}
		
?>