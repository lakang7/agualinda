<?php session_start();
    require("funciones.php");
    $con=Conectarse();		
	if($_POST["action"]==1){				
		$categorias="select * from tipoproducto order by idtipoproducto;";
		$result_categorias= pg_exec($con,$categorias);
		
		        $sql_inventarioLeche=" select * from inventarioleche where fecha='".$_POST["fecha"]."'; ";
				$result_inventarioLeche=pg_exec($con,$sql_inventarioLeche);
				if(pg_num_rows($result_inventarioLeche)==0){
		       
			    echo "<div class='resumenproduccion'>";
		       	echo "<div class='opcionresumenproduccion'>";
		        echo "<div class='numero_resumengran'>------</div>";
		        echo "<div class='titulo_resumengran'>Leche Inicial En Los Silos </div>";
		        echo "</div>";
		        echo "<div class='opcionresumenproduccion'>";
			    echo "<div class='arribaresumen'>";
		        echo "<div class='numero_resumen'>------</div>";
		        echo "<div class='titulo_resumen'>Litros Recibidos</div>";
		        echo "</div>";
		        echo "<div class='abajoresumen'>";
		        echo "<div class='numero_resumen'>------</div>";
		        echo "<div class='titulo_resumen'>Litros Trabajados</div>";
		        echo "</div>";
		        echo "</div>";
		        echo "<div class='opcionresumenproduccion' style='border-right:0px;'>";
		        echo "<div class='numero_resumengran'>------</div>";
		        echo "<div class='titulo_resumengran'>Leche Final En Los Silos</div>";
		        echo "</div>";
		        echo "</div>";						
				
				}else{
		        $inventarioLeche=pg_fetch_array($result_inventarioLeche,0);								
				echo "<div class='resumenproduccion'>";
		       	echo "<div class='opcionresumenproduccion'>";
		        echo "<div class='numero_resumengran'>".$inventarioLeche[2]."</div>";
		        echo "<div class='titulo_resumengran'>Leche Inicial En Los Silos </div>";
		        echo "</div>";
		        echo "<div class='opcionresumenproduccion'>";
			    echo "<div class='arribaresumen'>";
		        echo "<div class='numero_resumen'>".$inventarioLeche[3]."</div>";
		        echo "<div class='titulo_resumen'>Litros Recibidos</div>";
		        echo "</div>";
		        echo "<div class='abajoresumen'>";
		        echo "<div class='numero_resumen'>".$inventarioLeche[4]."</div>";
		        echo "<div class='titulo_resumen'>Litros Trabajados</div>";
		        echo "</div>";
		        echo "</div>";
		        echo "<div class='opcionresumenproduccion' style='border-right:0px;'>";
		        echo "<div class='numero_resumengran'>".$inventarioLeche[7]."</div>";
		        echo "<div class='titulo_resumengran'>Leche Final En Los Silos</div>";
		        echo "</div>";
		        echo "</div>";						
					
				}
				
	
		
		
		$listacategoriasgeneransuero="";
		$categoria_usa_suero="";
		for($i=0;$i<pg_num_rows($result_categorias);$i++){
			
			$categoria=pg_fetch_array($result_categorias,$i);

						
			$consulta_existencia_produccion="select * from produccion where fecha='".$_POST["fecha"]."' and idtipoproducto='".$categoria[0]."';";
			$result_existencia_produccion=pg_exec($con,$consulta_existencia_produccion);
			
			if($categoria[5]=="1"){
				$listacategoriasgeneransuero=$listacategoriasgeneransuero.$categoria[0]."-";	
			}
			if($categoria[5]=="2"){
				$categoria_usa_suero=$categoria[0];
			}	
					    				
                echo "<div class='columna' style='width:22%;background:#0b67cd; color:#FFF; margin-top:5px;'>Tipo de Producto</div>";
				echo "<div class='columna' style='width:8%; border-left:0px;background:#0b67cd; color:#FFF;margin-top:5px;'>Litros </div>";
				echo "<div class='columna' style='width:8%; border-left:0px;background:#0b67cd; color:#FFF;margin-top:5px;'>Kilogramos </div>";
				echo "<div class='columna' style='width:9%; border-left:0px;background:#0b67cd; color:#FFF;margin-top:5px;'>Litros x Kg </div>";   
				echo "<div class='columna' style='width:22%; border-left:0px;background:#0b67cd; color:#FFF;margin-top:5px;'>Producto </div>";
				echo "<div class='columna' style='width:8%; border-left:0px;background:#0b67cd; color:#FFF;margin-top:5px;'>Unidades </div>";
				echo "<div class='columna' style='width:8%; border-left:0px;background:#0b67cd; color:#FFF;margin-top:5px;'>Kilogramos </div>";
				echo "<div class='columna' style='width:8%; border-left:0px;background:#0b67cd; color:#FFF;margin-top:5px;'>Kg x Unidad </div>";
				
				$sql_proxcat="select * from producto where idtipoproducto='".$categoria[0]."';";
				$result_proxcat=pg_exec($con,$sql_proxcat);
				$lista_productos="";
				for($j=0;$j<pg_num_rows($result_proxcat);$j++){
					$producto=pg_fetch_array($result_proxcat,$j);
					$lista_productos=$lista_productos.$producto[0]."-";
					/*Primer producto en la categoria imprimo toda la cabecera de la tabla*/
					if($j==0){
					
                echo "<div class='columna' style='width:22%; border-top:0px;'>".$categoria[1]."</div>";
				
				if(pg_num_rows($result_existencia_produccion)==0){
					echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='cat_lit_".$categoria[0]."' name='cat_lit_".$categoria[0]."' onblur=litrosxkg(".$categoria[0]."),actualiza_suero(".$categoria[0].") /></div>";
								
					echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='cat_kg_".$categoria[0]."' name='cat_kg_".$categoria[0]."' onblur=litrosxkg(".$categoria[0].") /></div>";
				
					echo "<div class='columna' style='width:9%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:7.45%;' id='cat_litxkg_".$categoria[0]."' name='cat_litxkg_".$categoria[0]."' /></div>";					
				}else{
                    
					$categoriaEditando=pg_fetch_array($result_existencia_produccion,0);
					
					echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='cat_lit_".$categoria[0]."' name='cat_lit_".$categoria[0]."' onblur=litrosxkg(".$categoria[0]."),actualiza_suero(".$categoria[0].") value=".number_format(round($categoriaEditando[3],2),2,'.','')." /></div>";
								
					echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='cat_kg_".$categoria[0]."' name='cat_kg_".$categoria[0]."' onblur=litrosxkg(".$categoria[0].") value=".number_format(round($categoriaEditando[4],2),2,'.','')." /></div>";
				
					echo "<div class='columna' style='width:9%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:7.45%;' id='cat_litxkg_".$categoria[0]."' name='cat_litxkg_".$categoria[0]."' value=".number_format(round($categoriaEditando[5],2),2,'.','')." /></div>";															
				}
					
				if(pg_num_rows($result_existencia_produccion)==0){
					echo "<div class='columna' style='width:22%; border-left:0px;border-top:0px;'>".$producto[2]."</div>";				
					echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_uni_".$categoria[0]."_".$producto[0]."' name='pro_uni_".$categoria[0]."_".$producto[0]."' onblur=kgxuni(".$categoria[0].",".$producto[0].") /> </div>";
					echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_kg_".$categoria[0]."_".$producto[0]."' name='pro_kg_".$categoria[0]."_".$producto[0]."' onblur=kgxuni(".$categoria[0].",".$producto[0].")  /> </div>";
					echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_kgxuni_".$categoria[0]."_".$producto[0]."' name='pro_kgxuni_".$categoria[0]."_".$producto[0]."'  /> </div>";										
				}else{
					$categoriaEditando=pg_fetch_array($result_existencia_produccion,0);
					$sql_existencia_productoEnProduccion="select * from productosenproduccion where idproduccion='".$categoriaEditando[0]."' and idproducto='".$producto[0]."' ";
					$result_existencia_productoEnProduccion=pg_exec($con,$sql_existencia_productoEnProduccion);
					if(pg_num_rows($result_existencia_productoEnProduccion)==0){
						
					echo "<div class='columna' style='width:22%; border-left:0px;border-top:0px;'>".$producto[2]."</div>";				
					echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_uni_".$categoria[0]."_".$producto[0]."' name='pro_uni_".$categoria[0]."_".$producto[0]."' onblur=kgxuni(".$categoria[0].",".$producto[0].")  /> </div>";
					echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_kg_".$categoria[0]."_".$producto[0]."' name='pro_kg_".$categoria[0]."_".$producto[0]."' onblur=kgxuni(".$categoria[0].",".$producto[0].")  /> </div>";
					echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_kgxuni_".$categoria[0]."_".$producto[0]."' name='pro_kgxuni_".$categoria[0]."_".$producto[0]."'  /> </div>";							
						
					}else{
						
					$productoEditando = pg_fetch_array($result_existencia_productoEnProduccion,0);					
					echo "<div class='columna' style='width:22%; border-left:0px;border-top:0px;'>".$producto[2]."</div>";				
					echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_uni_".$categoria[0]."_".$producto[0]."' name='pro_uni_".$categoria[0]."_".$producto[0]."' onblur=kgxuni(".$categoria[0].",".$producto[0].") value=".number_format(round($productoEditando[3],2),2,'.','')." /> </div>";
					echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_kg_".$categoria[0]."_".$producto[0]."' name='pro_kg_".$categoria[0]."_".$producto[0]."' onblur=kgxuni(".$categoria[0].",".$producto[0].") value=".number_format(round($productoEditando[4],2),2,'.','')."  /> </div>";
					echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_kgxuni_".$categoria[0]."_".$producto[0]."' name='pro_kgxuni_".$categoria[0]."_".$producto[0]."' value=".number_format(round($productoEditando[5],2),2,'.','')."  /> </div>";	
					
					}
					
				}
													

						
					}else{/*Imprimo solo lo correspondiente a el producto no a la categoria*/
					
                echo "<div class='columna' style='width:22%; border-top:0px;border-color:#f7f7f7;'></div>";
				echo "<div class='columna' style='width:8%; border-left:0px;border-top:0px;border-color:#f7f7f7;'></div>";
				echo "<div class='columna' style='width:8%; border-left:0px;border-top:0px;border-color:#f7f7f7;'></div>";
				echo "<div class='columna' style='width:9%; border-left:0px;border-top:0px;border-color:#f7f7f7;border-right:1px solid #CCC;'></div>";					
				
				if(pg_num_rows($result_existencia_produccion)==0){
					
				echo "<div class='columna' style='width:22%;border-left:0px; border-top:0px; '>".$producto[2]."</div>";
				echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_uni_".$categoria[0]."_".$producto[0]."' name='pro_uni_".$categoria[0]."_".$producto[0]."' onblur=kgxuni(".$categoria[0].",".$producto[0].") /></div>";
				echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_kg_".$categoria[0]."_".$producto[0]."' name='pro_kg_".$categoria[0]."_".$producto[0]."' onblur=kgxuni(".$categoria[0].",".$producto[0].") /> </div>";
				echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_kgxuni_".$categoria[0]."_".$producto[0]."' name='pro_kgxuni_".$categoria[0]."_".$producto[0]."' /></div>";					
					
				}else{
					
				$categoriaEditando=pg_fetch_array($result_existencia_produccion,0);
				$sql_existencia_productoEnProduccion="select * from productosenproduccion where idproduccion='".$categoriaEditando[0]."' and idproducto='".$producto[0]."' ";
				$result_existencia_productoEnProduccion=pg_exec($con,$sql_existencia_productoEnProduccion);
				
				if(pg_num_rows($result_existencia_productoEnProduccion)==0){				
					
				echo "<div class='columna' style='width:22%;border-left:0px; border-top:0px; '>".$producto[2]."</div>";
				echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_uni_".$categoria[0]."_".$producto[0]."' name='pro_uni_".$categoria[0]."_".$producto[0]."' onblur=kgxuni(".$categoria[0].",".$producto[0].")  /></div>";
				echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_kg_".$categoria[0]."_".$producto[0]."' name='pro_kg_".$categoria[0]."_".$producto[0]."' onblur=kgxuni(".$categoria[0].",".$producto[0].")  /> </div>";
				echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_kgxuni_".$categoria[0]."_".$producto[0]."' name='pro_kgxuni_".$categoria[0]."_".$producto[0]."'  /></div>";					
					
				}else{
				$productoEditando = pg_fetch_array($result_existencia_productoEnProduccion,0);					
					
				echo "<div class='columna' style='width:22%;border-left:0px; border-top:0px; '>".$producto[2]."</div>";
				echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_uni_".$categoria[0]."_".$producto[0]."' name='pro_uni_".$categoria[0]."_".$producto[0]."' onblur=kgxuni(".$categoria[0].",".$producto[0].") value=".number_format(round($productoEditando[3],2),2,'.','')." /></div>";
				echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_kg_".$categoria[0]."_".$producto[0]."' name='pro_kg_".$categoria[0]."_".$producto[0]."' onblur=kgxuni(".$categoria[0].",".$producto[0].") value=".number_format(round($productoEditando[4],2),2,'.','')." /> </div>";
				echo "<div class='columna' style='width:8%; border-left:0px; border-top:0px;'><input type='text' class='entrada_columna' style='width:6.6%;' id='pro_kgxuni_".$categoria[0]."_".$producto[0]."' name='pro_kgxuni_".$categoria[0]."_".$producto[0]."' value=".number_format(round($productoEditando[5],2),2,'.','')." /></div>";					
					
				}															
				}																												
					}													
				
																							
			}
			echo "<input type='hidden' name='lista".$categoria[0]."' id='lista".$categoria[0]."' value='".$lista_productos."' />";																			
		}	
		echo "<input type='hidden' name='generansuero' id='generansuero' value='".$listacategoriasgeneransuero."' />";
		echo "<input type='hidden' name='usasuero' id='usasuero' value='".$categoria_usa_suero."' />";
		//echo $listacategoriasgeneransuero;					        
	}
	
	if($_GET["action"]==2){		
		$categorias="select * from tipoproducto order by idtipoproducto;";
		$result_categorias= pg_exec($con,$categorias);
		for($i=0;$i<pg_num_rows($result_categorias);$i++){			
			$bandera_categoria=0;
			$idproduccion="";						
			$categoria=pg_fetch_array($result_categorias,$i);
			if($_POST["cat_lit_".$categoria[0]]!="" || $_POST["cat_kg_".$categoria[0]]!=""){

			  	$litros="";
			  	if($_POST["cat_lit_".$categoria[0]]!=NULL){
				  	$litros=$_POST["cat_lit_".$categoria[0]];
			  	}else{
				  	$litros="null";  
			  	}	
				
			  	$kilogramos="";
			  	if($_POST["cat_kg_".$categoria[0]]!=NULL){
				  	$kilogramos=$_POST["cat_kg_".$categoria[0]];
			  	}else{
				  	$kilogramos="null";  
			  	}
				
			  	$litxkg="";
			  	if($_POST["cat_litxkg_".$categoria[0]]!=NULL){
				  	$litxkg=$_POST["cat_litxkg_".$categoria[0]];
			  	}else{
				  	$litxkg="null";  
			  	}													
				
				$sql_existencia_produccion="select * from produccion where fecha='".$_POST["fecha"]."' and idtipoproducto='".$categoria[0]."'";
				$result_existencia_produccion= pg_exec($con,$sql_existencia_produccion);
	
				if(pg_num_rows($result_existencia_produccion)==0){/*Consulto y no existe la produccion registrada*/
					
					$sql_categoria="insert into produccion values(nextval('produccion_idproduccion_seq'),'".$categoria[0]."','".$_POST["fecha"]."',".$litros.",".$kilogramos.",".$litxkg.")";
					$result_categoria=pg_exec($con,$sql_categoria);
				
					$sql_ultima_produccion="select last_value from produccion_idproduccion_seq;";
					$result_ultima_produccion=pg_exec($con,$sql_ultima_produccion);
				    $ultimaproduccion = pg_fetch_array($result_ultima_produccion,0);
					$idproduccion = $ultimaproduccion[0];								
					$bandera_categoria=1;					
					
				}else{/*La producción ya esta registrada y procedo a editarla*/

				    $produccioneditando = pg_fetch_array($result_existencia_produccion,0);
					$idproduccion = $produccioneditando[0];								
					$bandera_categoria=1;	
														
					$sql_update_produccion="update produccion set total_litros=".$litros.", total_kilogramos=".$kilogramos.", litrosxkilogramo=".$litxkg." where idproduccion='".$idproduccion."'";
					$result_update_produccion=pg_exec($con,$sql_update_produccion);
																				
				}
												
			}
			
			
			$sql_proxcat="select * from producto where idtipoproducto='".$categoria[0]."';";
			$result_proxcat=pg_exec($con,$sql_proxcat);							
			for($j=0;$j<pg_num_rows($result_proxcat);$j++){
				$producto=pg_fetch_array($result_proxcat,$j);
				
				if($_POST["pro_uni_".$categoria[0]."_".$producto[0]]!="" || $_POST["pro_kg_".$categoria[0]."_".$producto[0]]!=""){
					if($bandera_categoria==0){ /*Voy a registrar un producto en una produccion que aun no fue inceratda en la base datos*/
						
			  			$litros="";
					  	if($_POST["cat_lit_".$categoria[0]]!=NULL){
						  	$litros=$_POST["cat_lit_".$categoria[0]];
					  	}else{
						  	$litros="null";  
					  	}	
				
					  	$kilogramos="";
					  	if($_POST["cat_kg_".$categoria[0]]!=NULL){
						  	$kilogramos=$_POST["cat_kg_".$categoria[0]];
					  	}else{
						  	$kilogramos="null";  
					  	}
				
					  	$litxkg="";
					  	if($_POST["cat_litxkg_".$categoria[0]]!=NULL){
						  	$litxkg=$_POST["cat_litxkg_".$categoria[0]];
			  			}else{
						  	$litxkg="null";  
					  	}													
															
			  			$unidades="";
					  	if($_POST["pro_uni_".$categoria[0]."_".$producto[0]]!=NULL){
						  	$unidades=$_POST["pro_uni_".$categoria[0]."_".$producto[0]];
					  	}else{
						  	$unidades="null";  
					  	}	
				
					  	$kilos="";
					  	if($_POST["pro_kg_".$categoria[0]."_".$producto[0]]!=NULL){
						  	$kilos=$_POST["pro_kg_".$categoria[0]."_".$producto[0]];
					  	}else{
						  	$kilos="null";  
					  	}
				
					  	$kgxunidad="";
					  	if($_POST["pro_kgxuni_".$categoria[0]."_".$producto[0]]!=NULL){
						  	$kgxunidad=$_POST["pro_kgxuni_".$categoria[0]."_".$producto[0]];
					  	}else{
						  	$kgxunidad="null";  
					  	}	
						
						$sql_categoria="insert into produccion values(nextval('produccion_idproduccion_seq'),'".$categoria[0]."','".$_POST["fecha"]."',".$litros.",".$kilogramos.",".$litxkg.")";
						$result_categoria=pg_exec($con,$sql_categoria);
				
						$sql_ultima_produccion="select last_value from produccion_idproduccion_seq;";
						$result_ultima_produccion=pg_exec($con,$sql_ultima_produccion);
			    		$ultimaproduccion = pg_fetch_array($result_ultima_produccion,0);
						$idproduccion = $ultimaproduccion[0];								
						$bandera_categoria=1;												
						
						
						$sql_existencia_productoenproduccion="select * from productosenproduccion where idproduccion='".$idproduccion."' and idproducto='".$producto[0]."'";
						$result_existencia_productoenproduccion=pg_exec($con,$sql_existencia_productoenproduccion);
						if(pg_num_rows($result_existencia_productoenproduccion)==0){ /*Producto en produccion no estaba registrado*/
							
							$sql_productoenproduccion="insert into productosenproduccion values(nextval('productosenproduccion_idproductosenproduccion_seq'),".$idproduccion.",".$producto[0].",".$unidades.",".$kilos.",".$kgxunidad.")";
							$result_productoenproduccion=pg_exec($con,$sql_productoenproduccion);	
							
						}else{/*Producto en produccion ya se encontraba registrado voy a editarlo*/
							$productoeditando = pg_fetch_array($result_existencia_productoenproduccion,0);
							$sql_update_productoenproduccion="update productosenproduccion set unidades=".$unidades.", kilogramos=".$kilos.", Kilogramosxunidad=".$kgxunidad." where idproductosenproduccion='".$productoeditando[0]."'";
							$result_update_productoenproduccion=pg_exec($con,$sql_update_productoenproduccion);
							
						}
						
																							
					}else{ /*Registro producto en producción ya incertada en la base datos*/
						
			  			$unidades="";
					  	if($_POST["pro_uni_".$categoria[0]."_".$producto[0]]!=NULL){
						  	$unidades=$_POST["pro_uni_".$categoria[0]."_".$producto[0]];
					  	}else{
						  	$unidades="null";  
					  	}	
				
					  	$kilos="";
					  	if($_POST["pro_kg_".$categoria[0]."_".$producto[0]]!=NULL){
						  	$kilos=$_POST["pro_kg_".$categoria[0]."_".$producto[0]];
					  	}else{
						  	$kilos="null";  
					  	}
				
					  	$kgxunidad="";
					  	if($_POST["pro_kgxuni_".$categoria[0]."_".$producto[0]]!=NULL){
						  	$kgxunidad=$_POST["pro_kgxuni_".$categoria[0]."_".$producto[0]];
					  	}else{
						  	$kgxunidad="null";  
					  	}
						
						
						$sql_existencia_productoenproduccion="select * from productosenproduccion where idproduccion='".$idproduccion."' and idproducto='".$producto[0]."'";
						$result_existencia_productoenproduccion=pg_exec($con,$sql_existencia_productoenproduccion);
						if(pg_num_rows($result_existencia_productoenproduccion)==0){ /*Producto en produccion no estaba registrado*/
							
							$sql_productoenproduccion="insert into productosenproduccion values(nextval('productosenproduccion_idproductosenproduccion_seq'),".$idproduccion.",".$producto[0].",".$unidades.",".$kilos.",".$kgxunidad.")";
							$result_productoenproduccion=pg_exec($con,$sql_productoenproduccion);	
							
						}else{/*Producto en produccion ya se encontraba registrado voy a editarlo*/
							$productoeditando = pg_fetch_array($result_existencia_productoenproduccion,0);
							$sql_update_productoenproduccion="update productosenproduccion set unidades=".$unidades.", kilogramos=".$kilos.", Kilogramosxunidad=".$kgxunidad." where idproductosenproduccion='".$productoeditando[0]."'";
							$result_update_productoenproduccion=pg_exec($con,$sql_update_productoenproduccion);
							
						}																														
					}
				}
				
			}/*Final for j*/
						
		}/*Final for i*/
		
		/*Consulto si el dia para el que estoy registrando la producción ya se encuentra en la tabla de inventario de productos*/
		
		$sql_diaregistrado="select count(*) from inventarioproductos where fecha='".$_POST["fecha"]."';";
		$result_diaregistrado=pg_exec($con,$sql_diaregistrado);
		$registros = pg_fetch_array($result_diaregistrado,0);
		
		if($registros[0]==0){

			$sql_ultimo_dia="select fecha from inventarioproductos order by fecha DESC;";
			$result_ultimo_dia=pg_exec($con,$sql_ultimo_dia);
			$ultimodia=pg_fetch_array($result_ultimo_dia,0);
			
			$fechaInicio=strtotime($ultimodia[0]);
		    $fechaFin=strtotime($_POST["fecha"]);
			
			//echo "desde: ".$ultimodia[0]." hasta: ".$_POST["fecha"];
			
			$sql_control="select * from control";
			$result_control=pg_exec($con,$sql_control);
			$control=pg_fetch_array($result_control,0);			
			
			
			for($i=($fechaInicio+86400);($i<=$fechaFin);$i+=86400){
				$sql_productos =" select * from producto order by idproducto";
				$result_productos = pg_exec($con,$sql_productos);
				$diaAtras=($i-86400);
				
				for($j=0;$j<pg_num_rows($result_productos);$j++){
					
					$producto=pg_fetch_array($result_productos,$j);
					if($producto[0]!=$control[2]){					
						$sql_inventario_atras=" select * from inventarioproductos where fecha='".date("Y-m-d",$diaAtras)."' and idproducto='".$producto[0]."'; ";										
						$result_inventario_atras=pg_exec($con,$sql_inventario_atras);
						$inventarioAtras=pg_fetch_array($result_inventario_atras,0);										
						$sql_insertInvetario=" insert into inventarioproductos values(nextval('inventarioproductos_idinventarioproducto_seq'),'".$producto[0]."','".date("Y-m-d",$i)."','".$inventarioAtras[11]."',0,'".$inventarioAtras[11]."',0,0,0,0,0,'".$inventarioAtras[11]."'); ";
						$result_insertInventario=pg_exec($con,$sql_insertInvetario);
					}
																									
				}				
			}
			
		}
		
		/*En este punto ya el dia esta registrado en la tabla de inventarios cualquiera que fuese el caso*/
				
		$sql_productosElaborados=" select produccion.fecha, productosenproduccion.idproducto, productosenproduccion.unidades, productosenproduccion.kilogramos, productosenproduccion.kilogramosxunidad from productosenproduccion, produccion where productosenproduccion.idproduccion = produccion.idproduccion and produccion.fecha='".$_POST["fecha"]."';";
		$result_productosElaborados=pg_exec($con,$sql_productosElaborados);
		for($i=0;$i<pg_num_rows($result_productosElaborados);$i++){
			$productoElaborado=pg_fetch_array($result_productosElaborados,$i);
			//echo "i-->".$i."</br>";
			$sql_diaseditados="select * from inventarioproductos where fecha >='".$_POST["fecha"]."' and idproducto='".$productoElaborado[1]."' order by fecha;";
			$result_diaseditados=pg_exec($con,$sql_diaseditados);
			for($j=0;$j<pg_num_rows($result_diaseditados);$j++){
				//echo "j---->".$j."</br>";
				$diaEditado = pg_fetch_array($result_diaseditados,$j);
				if($j==0){/*Primera fecha en la secuencia de dias*/
					$sql_updateDia=" update inventarioproductos set produccion='".$productoElaborado[2]."', final='".(($diaEditado[5]+$productoElaborado[2])-($diaEditado[7]+$diaEditado[8]+$diaEditado[9]+$diaEditado[10]))."' where idinventarioproducto='".$diaEditado[0]."'";
					$result_updateDia=pg_exec($con,$sql_updateDia);																
				}else if($j>0){/*Resto de dias*/
					$indiceAnterior=pg_fetch_array($result_diaseditados,($j-1));
					$sql_diaAnterior="select * from inventarioproductos where idinventarioproducto='".$indiceAnterior[0]."';";
					$result_diaAnterior=pg_exec($con,$sql_diaAnterior);
					$diaAnterior=pg_fetch_array($result_diaAnterior,0);					
					$sql_updateDia=" update inventarioproductos set inicial='".$diaAnterior[11]."', inicialtotal=(".$diaAnterior[11]."+".$diaEditado[4]."), final=((".$diaAnterior[11]."+".$diaEditado[4].")+".$diaEditado[6].")-(".$diaEditado[7]."+".$diaEditado[8]."+".$diaEditado[9]."+".$diaEditado[10].") where idinventarioproducto='".$diaEditado[0]."' ";					
					$result_updateDia = pg_exec($con,$sql_updateDia);										
				}
					
			}			
						
		}
		
		
	/*Cuento toda la leche procesada durante este dia*/
	$LitrosTrabajados=0;
	$sql_produccionFecha="select * from produccion where fecha='".$_POST["fecha"]."';";		
	$result_produccionFecha=pg_exec($con,$sql_produccionFecha);
	for($i=0;$i<pg_num_rows($result_produccionFecha);$i++){
		$produccion=pg_fetch_array($result_produccionFecha,$i);
		$sql_tipoProduccion="select * from tipoproducto where idtipoproducto=".$produccion[1]."";
		$result_tipoProduccion=pg_exec($con,$sql_tipoProduccion);
		$tipoProduccion=pg_fetch_array($result_tipoProduccion,0);
		if($tipoProduccion[5]==1 || $tipoProduccion[5]==3){
			$LitrosTrabajados+=$produccion[3];	
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
	$sql_diaseditados="select * from inventarioleche where fecha >='".$_POST["fecha"]."' order by fecha;";
	$result_diaseditados=pg_exec($con,$sql_diaseditados);
	for($j=0;$j<pg_num_rows($result_diaseditados);$j++){
		$diaEditado=pg_fetch_array($result_diaseditados,$j);
		if($j==0){
							
			$sql_updateDia="update inventarioleche set trabajada=".$LitrosTrabajados.", final=".(($diaEditado[2]+$diaEditado[3])-($LitrosTrabajados+$diaEditado[5]+$diaEditado[6]))." where idinventarioleche=".$diaEditado[0].";";
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
		    alert("Produccion Registrada satisfactoriamente.");    
			location.href="../../sistema/RegistroDeProduccionDiaria.php";
        </script>
      <?					
		
		
		
	}					
?>