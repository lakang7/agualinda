<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?

    require("funciones.php");
    $con=Conectarse();			
	
	if($_GET["action"]==1){ //Agregar Nuevo Producto		   	  
	    
		$con=Conectarse();
		$sql_consulta_nombres = "select descripcion from producto;";
		$result_nombres = pg_exec($con,$sql_consulta_nombres);
		$bandera=0;
		for($i=0;$i<pg_num_rows($result_nombres);$i++){
			$nombre = pg_fetch_array($result_nombres,$i);			
			if(strtolower($nombre[0])==strtolower($_POST["descripcion1"])){
				$bandera=1;
				break;
			}
		}		
		
		if($bandera==0){
									
		  	$pesoMinimo="";
		  	if($_POST["peso_min1"]!=NULL){
			  	$pesoMinimo=$_POST["peso_min1"];
		  	}else{
			  	$pesoMinimo="null";  
		  	}	
			
		  	$pesoMaximo="";
		  	if($_POST["peso_max1"]!=NULL){
			  	$pesoMaximo=$_POST["peso_max1"];
		  	}else{
			  	$pesoMaximo="null";  
		  	}									
			
			$sql_insert_producto="insert into producto values(nextval('producto_idproducto_seq'),'".$_POST["tipoproducto1"]."','".$_POST["descripcion1"]."',now(),'".$_POST["impuesto1"]."','".$_POST["ventapor1"]."','".$_POST["tipoventa1"]."',".$pesoMinimo.",".$pesoMaximo.",".$_POST["estatus1"].")";
			$result_insert_producto=pg_exec($con,$sql_insert_producto);						
			if($result_insert_producto!=NULL){
				
			  /*Consulto el id del producto que acabo de registrar*/	
			  $sql_ultimo_producto = " select last_value from producto_idproducto_seq; ";
			  $result_ultimo=pg_exec($con,$sql_ultimo_producto);
			  $ultimo = pg_fetch_array($result_ultimo,0);
			  
			  /*Inserto en la tabla precio real de venta*/
			  $sql_preciorealventa = " insert into preciorealventa values (nextval('preciorealventa_idpreciorealventa_seq'),'".$ultimo[0]."',now(),null,'".$_POST["venta1"]."')";
			  $result_preciorealventa = pg_exec($con,$sql_preciorealventa);
			  
			  /*Consulto si para el producto aplica el precio regulado y de ser asi lo registro*/
			  if($_POST["tipoventa1"]==1){
				  $sql_precioregulado = " insert into precioregulado values (nextval('precioregulado_idprecioregulado_seq'),'".$ultimo[0]."',now(),null,'".$_POST["regulado1"]."')";
				  $result_precioregulado = pg_exec($con,$sql_precioregulado);				  
			  }
			  									
			$sql_ciudades="select * from ubicacion order by idubicacion";
			$result_ciudades=pg_exec($con,$sql_ciudades);
			$sql_precios="select * from tipoprecio order by idtipoprecio";
			$result_precios=pg_exec($con,$sql_precios);
			
			for($i=0;$i<pg_num_rows($result_ciudades);$i++){								
				$ciudad=pg_fetch_array($result_ciudades);
				for($j=0;$j<pg_num_rows($result_precios);$j++){
					$precio=pg_fetch_array($result_precios,$j);	
					$sql_precioxubicacion=" insert into precioxubicacion values (nextval('precioxubicacion_idprecioxubicacion_seq'),'".$ultimo[0]."','".$precio[0]."','".$ciudad[0]."','".$_POST["venta1"]."','".$_POST["por_".$ciudad[0]."_".$precio[0]]."','".$_POST["pre_".$ciudad[0]."_".$precio[0]]."',now(),null,true) ";
					$result_precioxubicacion=pg_exec($con,$sql_precioxubicacion);									
				}								
			}		
			
			$listainsumos = explode("-",$_POST["listainsumo"]);
			for($i=0;$i<(sizeof($listainsumos)-1);$i++){
				if($_POST["insumo-".$listainsumos[$i]]!=""){
					$sql_productoempaques=" insert into productosempaques values (nextval('productosempaques_idproductosempaques_seq'),'".$ultimo[0]."','".$listainsumos[$i]."',now(),null,'".$_POST["insumo-".$listainsumos[$i]]."')";
					$result_productoempaques=pg_exec($con,$sql_productoempaques);					
				}
			}
			  
								
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("Producto <?php echo $_POST["descripcion1"] ?> Registrado Satisfactoriamente");
						location.href="../../sistema/Productos.php"; 
                    </script>
		        <?			
			}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("Ocurrio un problema registrando el producto <?php echo $_POST["descripcion1"] ?>");
						location.href="../../sistema/Productos.php"; 
                    </script>
		        <?		
			}						
		}else{
				?>                   
		        	<script type="text/javascript" language="javascript"> 
						alert("Ya existe un producto registrado con el nombre / descripcion <?php echo $_POST["descripcion1"] ?>");
						location.href="../../sistema/Productos.php"; 
                    </script>
		        <?									
		}	  
	}
	
	if($_POST["action"]==2){  //ver detalle de producto
	     $sql_select_producto="select * from producto where idproducto='".$_POST["identificador"]."'";
		 $result_select_producto=pg_exec($con,$sql_select_producto);
		 $producto=pg_fetch_array($result_select_producto,0);
	?>
        
		<div class='tabla-detalle-contenedor'>
        <form name="formeditarproducto" id="formeditarproducto" method="post" action="../recursos/funciones/ajaxProductos.php?action=5">   
    		<div class="detalle-titulo">Editar Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
    
<div class="detalle-linea" style="width:97%">
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="codigo1" name="codigo1" class="entrada" readonly="readonly" style="width:97%; background:#EFEFEF" value="<?php echo Codigo("PRO",$producto[0]); ?>" /></div>
                    </div>
                    
                    
                	<div class="detalle-linea-elemento" style="width:40%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Tipo de Producto (*)</div>
                        <div class="detalle-linea-elemento-abajo">                        	
                        	<select data-placeholder="Seleccione el tipo de producto..." name="tipoproducto1" id="tipoproducto1" style="width:97%;" class="chzn-select" disabled="disabled" >
                                <option value="0"></option>
                                <?php
								     $con=Conectarse();
								     $sql_select_tipoproducto="select * from tipoproducto order by idtipoproducto ASC";
									 $result_select_tipoproducto= pg_exec($con,$sql_select_tipoproducto);
									 for($i=0;$i<pg_num_rows($result_select_tipoproducto);$i++){
										 $tipoproducto=pg_fetch_array($result_select_tipoproducto,$i);
										 if($producto[1]==$tipoproducto[0]){
											 echo "<option selected='selected' value=".$tipoproducto[0].">".$tipoproducto[1]."</option>";
										 }else{
										 	  echo "<option value=".$tipoproducto[0].">".$tipoproducto[1]."</option>"; 
										 }
																					 										 
									 }
								?>
                            </select>
                        </div>
                    </div>
                    
                    
                     
                	<div class="detalle-linea-elemento" style="width:40%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Descripcion (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="descripcion1" name="descripcion1" class="entrada" style="width:97%;" maxlength="60" value="<?php echo $producto[2]; ?>" disabled="disabled" /></div>
                    </div>  
                </div>                                                                                                                    
               
                
                <div class="detalle-linea" style="width:97%">
                
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="fecha1" name="fecha1" class="entrada" readonly="readonly" style="width:97%; background:#EFEFEF" value="<?php echo substr($producto[3],0,10); ?>" /></div>
                    </div>
                                                       
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Peso Minimo Producto</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="peso_min1" name="peso_min1" class="entrada"  style="width:97%;" maxlength="12" value="<?php echo $producto[7]; ?>" disabled="disabled" /></div>
                    </div>                     
                
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Peso Maximo producto</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="peso_max1" name="peso_max1" class="entrada"  style="width:97%;" maxlength="12" value="<?php echo $producto[8]; ?>" disabled="disabled" /></div>
                    </div> 
                    
                	<div class="detalle-linea-elemento" style="width:19%;margin-left:2%">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Impuesto (*)</div>
                            <div class="detalle-linea-elemento-abajo">                        	
                        	<select data-placeholder="Seleccione..." name="impuesto1" id="impuesto1" style="width:97%;" class="chzn-select" disabled="disabled" >
                                <option value="0"></option>
                                <?php
									if($producto[4]=="t"){
										echo "<option selected='selected' value='true'>Aplica</option>";
		                                echo "<option value='false'>Excento</option>";
									}else{
										echo "<option value='true'>Aplica</option>";
		                                echo "<option selected='selected' value='false'>Excento</option>";									
									}
									
								?>

                            </select>
                        </div>
                    </div> 
                    
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Venta Por (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione..." name="ventapor1" id="ventapor1" style="width:97%;" class="chzn-select" disabled="disabled" >
                                <option value="0"></option>
                                <?php  
									if($producto[5]==1){
										echo "<option selected='selected' value='1'>Kilogramos</option>";
		                                echo "<option value='2'>Unidades</option>";
									}else{
										echo "<option value='1'>Kilogramos</option>";
		                                echo "<option selected='selected' value='2'>Unidades</option>";										
									}
								?>

                            </select>                        
                        </div>
                    </div>                        
                                       
                                    
                </div>
                
                <div class="detalle-linea" style="width:97%">
                  
                    
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Tipo de Venta (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione..." name="tipoventa1" id="tipoventa1" onchange="cambia_regulado(3)" style="width:97%;" class="chzn-select" disabled="disabled" >
                                <option value="0"></option>
                                <?php
									
									if($producto[6]==1){
										echo "<option value='1' selected='selected'>Con Precio Regulado</option>";
		                                echo "<option value='2' >Con Precio Full</option>";																
									}else{										
										echo "<option value='1' >Con Precio Regulado</option>";
		                                echo "<option value='2' selected='selected'>Con Precio Full</option>";												
									}																	
								?>
                            </select>                        
                        </div>
                    </div>       
                    
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Precio Regulado</div>
                        
                        <?php
							if($producto[6]==1){
								$con= Conectarse();
								$sql_precioregulado="select * from precioregulado where idproducto='".$producto[0]."' and hasta is null";
								$result_precioregulado=pg_exec($con,$sql_precioregulado);
								$regulado=pg_fetch_array($result_precioregulado,0);
								
							?>
                        		<div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $regulado[4]; ?>" id="regulado1" name="regulado1" class="entrada"  style="width:97%;" maxlength="12" disabled="disabled" /></div>	                            
                            <?	
							}else{
							?>
                        		<div class="detalle-linea-elemento-abajo"><input type="text" value="" id="regulado1" name="regulado1" class="entrada" disabled="disabled" style="width:97%;  background:#EFEFEF" maxlength="12" /></div>							
							<?
							}
						
						?>                                                                                                
                    </div>             
                    
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Precio Base de Venta (*)</div>
                        <?php
								    $con=Conectarse();
									$sql_venta="select * from preciorealventa where idproducto='".$producto[0]."' ";
									$result_venta=pg_exec($con,$sql_venta);
									$precio_venta="";
									for($i=0;$i<pg_num_rows($result_venta);$i++){
										$venta=pg_fetch_array($result_venta,$i);
										if($venta[3]==""){
											$precio_venta=$venta[4];		
										}
									}						
						
						?>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $precio_venta; ?>" onblur="precio_base(1)" id="venta1" name="venta1" class="entrada"  style="width:97%;" maxlength="12" disabled="disabled" /></div>
                    </div>
                    
					<div class="detalle-linea-elemento" style="width:17%; margin-left:2%">
                    	<div class="detalle-linea-elemento-arriba" style="width:97%;">Estatus (*)</div>
  						<div id="estatus1" style="font-size:8px; width:160px; margin-top:1px;" class="detalle-linea-elemento-abajo">
						    <input type="radio" id="radio1" name="estatus1" value="1" checked="checked" /><label for="radio1">Habilitado</label>
						    <input type="radio" id="radio2" name="estatus1" value="2"  /><label for="radio2">Deshabilitado</label>
					    </div>
                    </div>                     
               </div>    
                              
                                                                                                           
                <div class="detalle-indica" style="margin-top:5px; background:#F9F9F9">Listado de Precios </div>  
                <div class="listaprecios">
                	<div class="linea_precios" style="text-align:center;">
                    	<div class="columna_precios" style="width:230px;"></div>
                	<?php
						$con=Conectarse();
						$sql_precios="select * from tipoprecio order by idtipoprecio";
						$result_precios=pg_exec($con,$sql_precios);
						
						for($i=0;$i<pg_num_rows($result_precios);$i++){
							$precio=pg_fetch_array($result_precios,$i);
							echo "<div class='columna_precios' style='width:100px;'>".$precio[2]."</div>";
						}
					
					?>                    
                    </div>
                    <div class="linea_precios" style="text-align:center;">
                    	<div class="columna_precios" style="width:230px;"></div>
                        <?php
                        for($i=0;$i<pg_num_rows($result_precios);$i++){
							echo "<div class='columna_precios' style='width:29px;'>%</div>";
                        	echo "<div class='columna_precios' style='width:65px;'>Precio</div>";
                        }
						?>                                              
                    </div>
                    
                    
                        <?php
							$sql_ciudades="select * from ubicacion order by idubicacion";
							$result_ciudades=pg_exec($con,$sql_ciudades);
							for($i=0;$i<pg_num_rows($result_ciudades);$i++){								
								echo "<div class='linea_precios'>";
								$ciudad=pg_fetch_array($result_ciudades);
								echo "<div class='columna_precios' style='width:230px;'>".$ciudad[2]."</div>";
								for($j=0;$j<pg_num_rows($result_precios);$j++){
								    $precio=pg_fetch_array($result_precios,$j);	
									
									$sql_prexubi="select * from precioxubicacion where idproducto='".$producto[0]."' and idtipoprecio='".$precio[0]."' and idubicacion='".$ciudad[0]."' and actual='TRUE';";
									$result_prexubi=pg_exec($con,$sql_prexubi);
									$precioxubicacion=pg_fetch_array($result_prexubi,0);									
									
									echo "<div class='columna_precios' style='width:29px;'><input type='text' class='entrada_precio' style='width:34px;text-align:right' value='".$precioxubicacion[5]."' id='por_".$ciudad[0]."_".$precio[0]."' name='por_".$ciudad[0]."_".$precio[0]."' onblur=precio_base(3) disabled='disabled' /></div>";
                        			echo "<div class='columna_precios' style='width:65px;'><input type='text' class='entrada_precio' style='width:69px;text-align:right' value='".number_format(round(($precioxubicacion[4]+($precioxubicacion[4]*($precioxubicacion[5]/100))),2),2,'.','')."' id='pre_".$ciudad[0]."_".$precio[0]."' name='pre_".$ciudad[0]."_".$precio[0]."' readonly='readonly' disabled='disabled' /></div>";
								}
								echo "</div>";
							}
							
						?>                    	                                       
                </div>            
            
            
               <div class="detalle-indica" style="margin-top:5px; background:#F9F9F9;">Insumo y Empaques necesarios para producir una unidad del producto </div>  
                <div class="listaprecios" style="">
                <table border="1px" style="border:#CCC; font-size:11px;font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;" class="tablainsumos" id="tablainsumos">
                	
                    
                    
	                	<tr style="font-size:12px; height:20px; border-top:hidden; border-left:hidden; border-bottom:1px solid #CCC;">
	                    	<td style="width:330px;padding-left:5px;padding-right:5px;">Insumo / Empaque</td>
	                        <td style="width:60px;padding-left:5px;padding-right:5px;">Unidades</td>
	                    </tr>                    
                        <?php 
							$sql_insumos="select * from productosempaques where idproducto='".$producto[0]."'";
							$result_insumos=pg_exec($con,$sql_insumos);
							$usados=array();
							$cuenta_usados=0;
							$concatena="";							
							for($i=0;$i<pg_num_rows($result_insumos);$i++){
								$insumo=pg_fetch_array($result_insumos,$i);
								$sql_nombre="select nombre from insumo where idinsumo='".$insumo[2]."'";
								$result_nombre = pg_exec($con,$sql_nombre);
								$nombre = pg_fetch_array($result_nombre,0);								
								if($insumo[4]==""){
									$usados[$cuenta_usados]=$insumo[2];
									$cuenta_usados++;
									$concatena=$concatena.$insumo[2]."-";
									?>
				                	<tr style="font-size:12px; height:20px; border-left:hidden; border-bottom: 1px solid color:#CCC; border-top:1px solid color:#CCC;">
				                    	<td style="width:330px;padding-left:5px;padding-right:5px;"><?php echo $nombre[0]; ?></td>
				                        <td style="width:60px;padding-left:5px;padding-right:5px;"><input type="text" id="insumo-<?php echo $insumo[2]; ?>" name="insumo-<?php echo $insumo[2]; ?>" value="<?php echo $insumo[5]; ?>" class="entrada_precio" style="width:70px; margin-top:-9px; height:19px; text-align:right" disabled='disabled' /></td>
				                    </tr>                                                                         
                                    <?	
								}
							}
						
						?>                                        	                  
                </table>                                                                                                
                </div>            
                                                            
            <div class="detalle-indica">Los campos indicados con (*) son Obligatotios</div>                                  
	    </form>
        </div>
	<?	    	
	}
	
	if($_POST["action"]==3){  //Generar Formulario Para Registro
		?>
                                
			<div class='tabla-detalle-contenedor'> 
             <form name="formagregaproducto" id="formagregaproducto" method="post" action="../recursos/funciones/ajaxProductos.php?action=1" >
    			<div class="detalle-titulo">Agregar Nuevo Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
                <div class="detalle-linea" style="width:98%;">
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="codigo1" name="codigo1" class="entrada" readonly="readonly" style="width:97%; background:#EFEFEF"  /></div>
                    </div>
                    
                    
                	<div class="detalle-linea-elemento" style="width:40%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Tipo de Producto (*)</div>
                        <div class="detalle-linea-elemento-abajo">                        	
                        	<select data-placeholder="Seleccione el tipo de producto..." name="tipoproducto1" id="tipoproducto1" style="width:97%;" class="chzn-select" >
                                <option value="0"></option>
                                <?php
								     $con=Conectarse();
								     $sql_select_tipoproducto="select * from tipoproducto order by idtipoproducto ASC";
									 $result_select_tipoproducto= pg_exec($con,$sql_select_tipoproducto);
									 for($i=0;$i<pg_num_rows($result_select_tipoproducto);$i++){
										 $tipoproducto=pg_fetch_array($result_select_tipoproducto,$i);
											echo "<option value=".$tipoproducto[0].">".$tipoproducto[1]."</option>"; 										 										 
									 }
								?>
                            </select>
                        </div>
                    </div>
                    
                    
                     
                	<div class="detalle-linea-elemento" style="width:40%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Descripcion (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="descripcion1" name="descripcion1" class="entrada" style="width:97%;" maxlength="60" /></div>
                    </div>  
                </div>                                                                                                                    
               
                
                <div class="detalle-linea" style="width:98%;">
                
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="fecha1" name="fecha1" class="entrada" readonly="readonly" style="width:97%; background:#EFEFEF" /></div>
                    </div>
                    
                                                        
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Peso Minimo Producto</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="peso_min1" name="peso_min1" class="entrada"  style="width:97%;" maxlength="12" /></div>
                    </div>                     
                
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Peso Maximo producto</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="peso_max1" name="peso_max1" class="entrada"  style="width:97%;" maxlength="12" /></div>
                    </div> 
                    
                	<div class="detalle-linea-elemento" style="width:19%; margin-left:2%">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Impuesto (*)</div>
                            <div class="detalle-linea-elemento-abajo">                        	
                        	<select data-placeholder="Seleccione..." name="impuesto1" id="impuesto1" style="width:97%;" class="chzn-select" >
                                <option value="0"></option>
								<option value="true">Aplica</option>
                                <option value="false">Excento</option>
                            </select>
                        </div>
                    </div> 
                    
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Venta Por (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione..." name="ventapor1" id="ventapor1" style="width:97%;" class="chzn-select" >
                                <option value="0"></option>
								<option value="1">Kilogramos</option>
                                <option value="2">Unidades</option>
                            </select>                        
                        </div>
                    </div>                        
                                       
                                    
                </div>
                
                <div class="detalle-linea" style="width:98%;">
                
                      
                    
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Tipo de Venta (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione..." name="tipoventa1" id="tipoventa1" onchange="cambia_regulado(1)" style="width:97%;" class="chzn-select" >
                                <option value="0"></option>
								<option value="1">Con Precio Regulado</option>
                                <option value="2">Con Precio Full</option>
                            </select>                        
                        </div>
                    </div>       
                    
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%">Precio Regulado</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="regulado1" name="regulado1" class="entrada" readonly="readonly" style="width:97%;  background:#EFEFEF" maxlength="12" /></div>
                    </div>             
                    
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Precio Base de Venta (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" onblur="precio_base(1)" id="venta1" name="venta1" class="entrada"  style="width:97%;" maxlength="12" /></div>
                    </div> 
                    
					<div class="detalle-linea-elemento" style="width:17%;margin-left:2%">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Estatus (*)</div>
  						<div id="estatus1" style="font-size:8px; width:97%; margin-top:1px;" class="detalle-linea-elemento-abajo">
						    <input type="radio" id="radio1" name="estatus1" value="1" checked="checked" /><label for="radio1">Habilitado</label>
						    <input type="radio" id="radio2" name="estatus1" value="2"  /><label for="radio2">Deshabilitado</label>
					    </div>
                    </div>                                          
                    
                                                                                              
                </div>
                                
                <div class="detalle-indica" style="margin-top:5px;">Listado de Precios </div>  
                <div class="listaprecios">
                	<div class="linea_precios" style="text-align:center;">
                    	<div class="columna_precios" style="width:23%;"></div>
                	<?php
						$con=Conectarse();
						$sql_precios="select * from tipoprecio order by idtipoprecio";
						$result_precios=pg_exec($con,$sql_precios);
						
						for($i=0;$i<pg_num_rows($result_precios);$i++){
							$precio=pg_fetch_array($result_precios,$i);
							echo "<div class='columna_precios' style='width:11.1%; padding-left:0px;'>".$precio[2]."</div>";
						}
					
					?>                    
                    </div>
                    <div class="linea_precios" style="text-align:center;">
                    	<div class="columna_precios" style="width:23%;"></div>
                        <?php
                        for($i=0;$i<pg_num_rows($result_precios);$i++){
							echo "<div class='columna_precios' style='width:4%; padding-left:0px;'>%</div>";
                        	echo "<div class='columna_precios' style='width:7%; padding-left:0px;'>Precio</div>";
                        }
						?>                                              
                    </div>
                    
                    
                        <?php
							$sql_ciudades="select * from ubicacion order by idubicacion";
							$result_ciudades=pg_exec($con,$sql_ciudades);
							for($i=0;$i<pg_num_rows($result_ciudades);$i++){								
								echo "<div class='linea_precios'>";
								$ciudad=pg_fetch_array($result_ciudades);
								echo "<div class='columna_precios' style='width:23%;'>".$ciudad[2]."</div>";
								for($j=0;$j<pg_num_rows($result_precios);$j++){
								    $precio=pg_fetch_array($result_precios,$j);	
									echo "<div class='columna_precios' style='width:4%;padding-left:0px;'><input type='text' class='entrada_precio' style='width:2.9%;text-align:right;margin-left:0px;' id='por_".$ciudad[0]."_".$precio[0]."' name='por_".$ciudad[0]."_".$precio[0]."' onblur=precio_base(1) /></div>";
                        			echo "<div class='columna_precios' style='width:7%;padding-left:0px;'><input type='text' class='entrada_precio' style='width:5.2%;text-align:right;margin-left:0px;' id='pre_".$ciudad[0]."_".$precio[0]."' name='pre_".$ciudad[0]."_".$precio[0]."' readonly='readonly' /></div>";
								}
								echo "</div>";
							}
							
						?>                    	                                       
                </div>
                <div class="detalle-indica" style="margin-top:5px; background:#F9F9F9;">Insumo y Empaques necesarios para producir una unidad del producto </div>  
                <div class="listaprecios" style="">
                <table border="1px" style="border:#CCC; font-size:11px;font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;" class="tablainsumos" id="tablainsumos">
                	
	                	<tr style="font-size:12px; height:20px; border-top:hidden; border-left:hidden; border-bottom:1px solid #CCC;">
	                    	<td style="width:330px;padding-left:5px;padding-right:5px;">Insumo / Empaque</td>
	                        <td style="width:60px;padding-left:5px;padding-right:5px;">Unidades</td>
	                    </tr>                                                                               	                  
                </table>                                                                                                
                </div>
                
           <div class="conte_agregar" id="conte_agregar" style="width:36%;" >
           <select data-placeholder="Seleccione el insumo.." name="insumos1" id="insumos1" style="width:97%;" class="chzn-select" >
               <option value="0"></option>
               <?php								     
	           $sql_select_insumos="select * from insumo where tipoinsumo=2 order by idinsumo";
	           $result_select_insumos = pg_exec($con,$sql_select_insumos);
			   for($i=0;$i<pg_num_rows($result_select_insumos);$i++){
			       $insumo=pg_fetch_array($result_select_insumos,$i);
				   echo "<option value=".$insumo[0].">".$insumo[4]."</option>";
				}
			   ?>
           </select>
           </div>
           <div class="boton_cargar"><input type="button" value="Agregar" onclick="agregar_insumo(1)" style="font-size:12px;font-family: 'Oswald', sans-serif; line-height:14px; margin:0px; height:25px; width:70px;"/></div> <input type="hidden" name="listainsumo" id="listainsumo" value="" />   
            <div class="boton_cargar" style="margin-left:8px;"><input type="button" value="Guardar" onclick="agregarproducto()" style="font-size:12px;font-family: 'Oswald', sans-serif; line-height:14px; margin:0px; height:25px; width:70px;"/></div>                               
               
                
                <div class="detalle-indica">Los campos indicados con (*) son Obligatotios</div>                                  
	        </form>
            </div>                        
                
        <?
	}
	
	
	if($_POST["action"]==4){  //formulario para editar registro
	     $sql_select_producto="select * from producto where idproducto='".$_POST["identificador"]."'";
		 $result_select_producto=pg_exec($con,$sql_select_producto);
		 $producto=pg_fetch_array($result_select_producto,0);
	?>
        
		<div class='tabla-detalle-contenedor'>
        <form name="formeditarproducto" id="formeditarproducto" method="post" action="../recursos/funciones/ajaxProductos.php?action=5">   
    		<div class="detalle-titulo">Editar Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
    
<div class="detalle-linea" style="width:97%">
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="codigo3" name="codigo3" class="entrada" readonly="readonly" style="width:97%; background:#EFEFEF" value="<?php echo Codigo("PRO",$producto[0]); ?>" /></div>
                    </div>
                    
                    
                	<div class="detalle-linea-elemento" style="width:40%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Tipo de Producto (*)</div>
                        <div class="detalle-linea-elemento-abajo">                        	
                        	<select data-placeholder="Seleccione el tipo de producto..." name="tipoproducto3" id="tipoproducto3" style="width:97%;" class="chzn-select" >
                                <option value="0"></option>
                                <?php
								     $con=Conectarse();
								     $sql_select_tipoproducto="select * from tipoproducto order by idtipoproducto ASC";
									 $result_select_tipoproducto= pg_exec($con,$sql_select_tipoproducto);
									 for($i=0;$i<pg_num_rows($result_select_tipoproducto);$i++){
										 $tipoproducto=pg_fetch_array($result_select_tipoproducto,$i);
										 if($producto[1]==$tipoproducto[0]){
											 echo "<option selected='selected' value=".$tipoproducto[0].">".$tipoproducto[1]."</option>";
										 }else{
										 	  echo "<option value=".$tipoproducto[0].">".$tipoproducto[1]."</option>"; 
										 }
																					 										 
									 }
								?>
                            </select>
                        </div>
                    </div>
                    
                    
                     
                	<div class="detalle-linea-elemento" style="width:40%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Descripcion (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="descripcion3" name="descripcion3" class="entrada" style="width:97%;" maxlength="60" value="<?php echo $producto[2]; ?>" /></div>
                    </div>  
                </div>                                                                                                                    
               
                
                <div class="detalle-linea" style="width:97%">
                
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="fecha3" name="fecha3" class="entrada" readonly="readonly" style="width:97%; background:#EFEFEF" value="<?php echo substr($producto[3],0,10); ?>" /></div>
                    </div>
                                                       
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Peso Minimo Producto</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="peso_min3" name="peso_min3" class="entrada"  style="width:97%;" maxlength="12" value="<?php echo $producto[7]; ?>" /></div>
                    </div>                     
                
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Peso Maximo producto</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="peso_max3" name="peso_max3" class="entrada"  style="width:97%;" maxlength="12" value="<?php echo $producto[8]; ?>" /></div>
                    </div>
                    
					<div class="detalle-linea-elemento" style="width:19%;margin-left:2%">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Impuesto (*)</div>
                            <div class="detalle-linea-elemento-abajo">                        	
                        	<select data-placeholder="Seleccione..." name="impuesto3" id="impuesto3" style="width:97%;" class="chzn-select" >
                                <option value="0"></option>
                                <?php
									if($producto[4]=="t"){
										echo "<option selected='selected' value='true'>Aplica</option>";
		                                echo "<option value='false'>Excento</option>";
									}else{
										echo "<option value='true'>Aplica</option>";
		                                echo "<option selected='selected' value='false'>Excento</option>";									
									}
									
								?>

                            </select>
                        </div>
                    </div> 
                    
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Venta Por (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione..." name="ventapor3" id="ventapor3" style="width:97%;" class="chzn-select" >
                                <option value="0"></option>
                                <?php  
									if($producto[5]==1){
										echo "<option selected='selected' value='1'>Kilogramos</option>";
		                                echo "<option value='2'>Unidades</option>";
									}else{
										echo "<option value='1'>Kilogramos</option>";
		                                echo "<option selected='selected' value='2'>Unidades</option>";										
									}
								?>

                            </select>                        
                        </div>
                    </div>                                        
                                    
                </div>
                
                <div class="detalle-linea" style="width:97%">
                	                      
                    
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Tipo de Venta (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione..." name="tipoventa3" id="tipoventa3" onchange="cambia_regulado(3)" style="width:97%;" class="chzn-select" >
                                <option value="0"></option>
                                <?php
									
									if($producto[6]==1){
										echo "<option value='1' selected='selected'>Con Precio Regulado</option>";
		                                echo "<option value='2' >Con Precio Full</option>";																
									}else{										
										echo "<option value='1' >Con Precio Regulado</option>";
		                                echo "<option value='2' selected='selected'>Con Precio Full</option>";												
									}																	
								?>
                            </select>                        
                        </div>
                    </div>       
                    
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Precio Regulado</div>
                        
                        <?php
							if($producto[6]==1){
								$con= Conectarse();
								$sql_precioregulado="select * from precioregulado where idproducto='".$producto[0]."' and hasta is null";
								$result_precioregulado=pg_exec($con,$sql_precioregulado);
								$regulado=pg_fetch_array($result_precioregulado,0);
								
							?>
                        		<div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $regulado[4]; ?>" id="regulado3" name="regulado3" class="entrada"  style="width:97%;" maxlength="12" /></div>	                            
                            <?	
							}else{
							?>
                        		<div class="detalle-linea-elemento-abajo"><input type="text" value="" id="regulado3" name="regulado3" class="entrada" readonly="readonly" style="width:97%;  background:#EFEFEF" maxlength="12" /></div>							
							<?
							}
						
						?>                                                                                                
                    </div>             
                    
                	<div class="detalle-linea-elemento" style="width:19%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Precio Base de Venta (*)</div>
                        <?php
								    $con=Conectarse();
									$sql_venta="select * from preciorealventa where idproducto='".$producto[0]."' ";
									$result_venta=pg_exec($con,$sql_venta);
									$precio_venta="";
									for($i=0;$i<pg_num_rows($result_venta);$i++){
										$venta=pg_fetch_array($result_venta,$i);
										if($venta[3]==""){
											$precio_venta=$venta[4];		
										}
									}						
						
						?>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $precio_venta; ?>" onblur="precio_base(3)" id="venta3" name="venta3" class="entrada"  style="width:97%;" maxlength="12" /></div>
                    </div>
                    
					<div class="detalle-linea-elemento" style="width:19%; margin-left:2%">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;margin-left:2%">Estatus (*)</div>
  						<div id="estatus3" style="font-size:8px; width:100%; margin-top:1px;" class="detalle-linea-elemento-abajo">
						    <input type="radio" id="radio1" name="estatus3" value="1" checked="checked" /><label for="radio1">Habilitado</label>
						    <input type="radio" id="radio2" name="estatus3" value="2"  /><label for="radio2">Deshabilitado</label>
					    </div>
                    </div>                     
               </div>                  
                                                                                                           
                <div class="detalle-indica" style="margin-top:5px; background:#F9F9F9">Listado de Precios </div>  
                <div class="listaprecios">
                	<div class="linea_precios" style="text-align:center;">
                    	<div class="columna_precios" style="width:230px;"></div>
                	<?php
						$con=Conectarse();
						$sql_precios="select * from tipoprecio order by idtipoprecio";
						$result_precios=pg_exec($con,$sql_precios);
						
						for($i=0;$i<pg_num_rows($result_precios);$i++){
							$precio=pg_fetch_array($result_precios,$i);
							echo "<div class='columna_precios' style='width:100px;'>".$precio[2]."</div>";
						}
					
					?>                    
                    </div>
                    <div class="linea_precios" style="text-align:center;">
                    	<div class="columna_precios" style="width:230px;"></div>
                        <?php
                        for($i=0;$i<pg_num_rows($result_precios);$i++){
							echo "<div class='columna_precios' style='width:29px;'>%</div>";
                        	echo "<div class='columna_precios' style='width:65px;'>Precio</div>";
                        }
						?>                                              
                    </div>
                    
                    
                        <?php
							$sql_ciudades="select * from ubicacion order by idubicacion";
							$result_ciudades=pg_exec($con,$sql_ciudades);
							for($i=0;$i<pg_num_rows($result_ciudades);$i++){								
								echo "<div class='linea_precios'>";
								$ciudad=pg_fetch_array($result_ciudades);
								echo "<div class='columna_precios' style='width:230px;'>".$ciudad[2]."</div>";
								for($j=0;$j<pg_num_rows($result_precios);$j++){
								    $precio=pg_fetch_array($result_precios,$j);	
									
									$sql_prexubi="select * from precioxubicacion where idproducto='".$producto[0]."' and idtipoprecio='".$precio[0]."' and idubicacion='".$ciudad[0]."' and actual='TRUE';";
									$result_prexubi=pg_exec($con,$sql_prexubi);
									$precioxubicacion=pg_fetch_array($result_prexubi,0);									
									
									echo "<div class='columna_precios' style='width:29px;'><input type='text' class='entrada_precio' style='width:34px;text-align:right' value='".$precioxubicacion[5]."' id='por_".$ciudad[0]."_".$precio[0]."' name='por_".$ciudad[0]."_".$precio[0]."' onblur=precio_base(3) /></div>";
                        			echo "<div class='columna_precios' style='width:65px;'><input type='text' class='entrada_precio' style='width:69px;text-align:right' value='".number_format(round(($precioxubicacion[4]+($precioxubicacion[4]*($precioxubicacion[5]/100))),2),2,'.','')."' id='pre_".$ciudad[0]."_".$precio[0]."' name='pre_".$ciudad[0]."_".$precio[0]."' readonly='readonly' /></div>";
								}
								echo "</div>";
							}
							
						?>                    	                                       
                </div>            
            
            
               <div class="detalle-indica" style="margin-top:5px; background:#F9F9F9;">Insumo y Empaques necesarios para producir una unidad del producto </div>  
                <div class="listaprecios" style="">
                <table border="1px" style="border:#CCC; font-size:11px;font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;" class="tablainsumos" id="tablainsumos">
                	
                    
                    
	                	<tr style="font-size:12px; height:20px; border-top:hidden; border-left:hidden; border-bottom:1px solid #CCC;">
	                    	<td style="width:330px;padding-left:5px;padding-right:5px;">Insumo / Empaque</td>
	                        <td style="width:60px;padding-left:5px;padding-right:5px;">Unidades</td>
	                    </tr>                    
                        <?php 
							$sql_insumos="select * from productosempaques where idproducto='".$producto[0]."'";
							$result_insumos=pg_exec($con,$sql_insumos);
							$usados=array();
							$cuenta_usados=0;
							$concatena="";							
							for($i=0;$i<pg_num_rows($result_insumos);$i++){
								$insumo=pg_fetch_array($result_insumos,$i);
								$sql_nombre="select nombre from insumo where idinsumo='".$insumo[2]."'";
								$result_nombre = pg_exec($con,$sql_nombre);
								$nombre = pg_fetch_array($result_nombre,0);								
								if($insumo[4]==""){
									$usados[$cuenta_usados]=$insumo[2];
									$cuenta_usados++;
									$concatena=$concatena.$insumo[2]."-";
									?>
				                	<tr style="font-size:12px; height:20px; border-left:hidden; border-bottom: 1px solid color:#CCC; border-top:1px solid color:#CCC;">
				                    	<td style="width:330px;padding-left:5px;padding-right:5px;"><?php echo $nombre[0]; ?></td>
				                        <td style="width:60px;padding-left:5px;padding-right:5px;"><input type="text" id="insumo-<?php echo $insumo[2]; ?>" name="insumo-<?php echo $insumo[2]; ?>" value="<?php echo $insumo[5]; ?>" class="entrada_precio" style="width:70px; margin-top:-9px; height:19px; text-align:right" /></td>
				                    </tr>                                                                         
                                    <?	
								}
							}
						
						?>                                        	                  
                </table>                                                                                                
                </div>            
            
           <div class="conte_agregar" id="conte_agregar" >
           <select data-placeholder="Seleccione el insumo.." name="insumos3" id="insumos3" style="width:365px;" class="chzn-select" >
               <option value="0"></option>
               <?php								     
	           $sql_select_insumos="select * from insumo where tipoinsumo=2 order by idinsumo";
	           $result_select_insumos = pg_exec($con,$sql_select_insumos);			   
			   for($i=0;$i<pg_num_rows($result_select_insumos);$i++){
			       $insumo=pg_fetch_array($result_select_insumos,$i);
				   $band=0;
				   for($j=0;$j<$cuenta_usados;$j++){
					    if($insumo[0]==$usados[$j]){
							$band=1;	
						}
				   }
				   
				   if($band==0){
					   echo "<option value=".$insumo[0].">".$insumo[4]."</option>";
				   }				   
				}
			   ?>
           </select>
           </div>
           <div class="boton_cargar"><input type="button" value="Agregar" onclick="agregar_insumo(3)" style="font-size:12px;font-family: 'Oswald', sans-serif; line-height:14px; margin:0px; height:25px; width:70px;"/></div> <input type="hidden" name="listainsumo" id="listainsumo" value="<?php echo $concatena; ?>" />   
            <div class="boton_cargar" style="margin-left:8px;"><input type="button" value="Editar" onclick="editarproducto()" style="font-size:12px;font-family: 'Oswald', sans-serif; line-height:14px; margin:0px; height:25px; width:70px;"/></div>             
            
            
            
            <div class="detalle-indica">Los campos indicados con (*) son Obligatotios</div>                                  
	    </form>
        </div>
        
	<?	    	
	}	
	
	if($_GET["action"]==5){ /*Editar Registro*/
		
		  	$litrosMinimos="";
			
		  	$pesoMinimo="";
		  	if($_POST["peso_min3"]!=NULL){
			  	$pesoMinimo=$_POST["peso_min3"];
		  	}else{
			  	$pesoMinimo="null";  
		  	}	
			
		  	$pesoMaximo="";
		  	if($_POST["peso_max3"]!=NULL){
			  	$pesoMaximo=$_POST["peso_max3"];
		  	}else{
			  	$pesoMaximo="null";  
		  	}			
		
		 $sql_update_producto="update producto set idtipoproducto='".$_POST["tipoproducto3"]."', descripcion='".$_POST["descripcion3"]."', impuesto='".$_POST["impuesto3"]."', venta_por='".$_POST["ventapor3"]."', tipo_venta='".$_POST["tipoventa3"]."', peso_minimo=".$pesoMinimo.", peso_maximo=".$pesoMaximo.", estatus='".$_POST["estatus3"]."' where idproducto='".InversaCodigo($_POST["codigo3"])."'";		 
		 $result_update_producto=pg_exec($con,$sql_update_producto);
		 
		 $sql_consulto_precioreal="select * from preciorealventa where idproducto='".InversaCodigo($_POST["codigo3"])."' and hasta is null;";
		 $result_consulta_precioreal = pg_exec($con,$sql_consulto_precioreal);
		 $precioreal=pg_fetch_array($result_consulta_precioreal,0);
		 
		 /*Consulto si para el producto aplica el precio regulado y de ser asi lo registro*/
		 if($_POST["tipoventa3"]==1){			
			$sql_existe_regualdo="select * from precioregulado where idproducto='".InversaCodigo($_POST["codigo3"])."' and hasta is null;";
			$result_existe_regulado=pg_exec($con,$sql_existe_regualdo);
			/*Si para el producto actualmente hay un precio regulado*/
			if(pg_num_rows($result_existe_regulado)>0){
				$precioregulado=pg_fetch_array($result_existe_regulado,0);

				/*Cierro el precio regulado de actual*/
				$sql_cierre_precioregulado="update precioregulado set hasta = now() where idprecioregulado='".$precioregulado[0]."'";
				$result_cierre_precioregulado=pg_exec($con,$sql_cierre_precioregulado);
							
			 	$sql_precioregulado = " insert into precioregulado values (nextval('precioregulado_idprecioregulado_seq'),'".InversaCodigo($_POST["codigo3"])."',now(),null,'".$_POST["regulado3"]."')";
			    $result_precioregulado = pg_exec($con,$sql_precioregulado);					
			}else{/*Si para el producto no existia actualmente un precio registrado*/
			 	$sql_precioregulado = " insert into precioregulado values (nextval('precioregulado_idprecioregulado_seq'),'".InversaCodigo($_POST["codigo3"])."',now(),null,'".$_POST["regulado3"]."')";
			    $result_precioregulado = pg_exec($con,$sql_precioregulado);									
			}															  
		 }else{/*No aplica precio regulado para el producto*/
			$sql_existe_regulado="select * from precioregulado where idproducto='".InversaCodigo($_POST["codigo3"])."' and hasta is null;";
			$result_existe_regulado=pg_exec($con,$sql_existe_regulado);
			/*Si para el producto actualmente hay un precio regulado*/
			if(pg_num_rows($result_existe_regulado)>0){				
				$precioregulado=pg_fetch_array($result_existe_regulado,0);
				/*Cierro el precio regulado de actual*/
				$sql_cierre_precioregulado="update precioregulado set hasta = now() where idprecioregulado='".$precioregulado[0]."'";
				$result_cierre_precioregulado=pg_exec($con,$sql_cierre_precioregulado);															
			}						 
		 }
		 
		 
		 if($precioreal[4]==$_POST["venta3"]){
			 
			$sql_ciudades="select * from ubicacion order by idubicacion";
			$result_ciudades=pg_exec($con,$sql_ciudades);
			$sql_precios="select * from tipoprecio order by idtipoprecio";
			$result_precios=pg_exec($con,$sql_precios);			
			echo "llego aqui";
			for($i=0;$i<pg_num_rows($result_ciudades);$i++){								
				$ciudad=pg_fetch_array($result_ciudades);
				for($j=0;$j<pg_num_rows($result_precios);$j++){
					$precio=pg_fetch_array($result_precios,$j);	
					$sql_ConsultaPrecioxubicacion=" select * from precioxubicacion where idtipoprecio='".$precio[0]."' and idubicacion='".$ciudad[0]."' and idproducto='".InversaCodigo($_POST["codigo3"])."' and hasta is null and actual='true';";
					$result_ConsultaPrecioxubicacion=pg_exec($con,$sql_ConsultaPrecioxubicacion);
					if(pg_num_rows($result_ConsultaPrecioxubicacion)>0){
						$precioUbicado=pg_fetch_array($result_ConsultaPrecioxubicacion,0);
						if($_POST["por_".$ciudad[0]."_".$precio[0]]!=$precioUbicado[5]){
							$sql_updateprecioxubicacion="update precioxubicacion set hasta = now(), actual='false' where idproducto='".InversaCodigo($_POST["codigo3"])."' and idtipoprecio='".$precio[0]."' and idubicacion='".$ciudad[0]."' and hasta is null and actual='true';";
							$result_updateprecioxubicacion = pg_exec($con,$sql_updateprecioxubicacion);
							
							$sql_precioxubicacion=" insert into precioxubicacion values (nextval('precioxubicacion_idprecioxubicacion_seq'),'".InversaCodigo($_POST["codigo3"])."','".$precio[0]."','".$ciudad[0]."','".$_POST["venta3"]."','".$_POST["por_".$ciudad[0]."_".$precio[0]]."','".$_POST["pre_".$ciudad[0]."_".$precio[0]]."',now(),null,true) ";
							$result_precioxubicacion=pg_exec($con,$sql_precioxubicacion);																																			
						}
					}
				
				}
				
			}
			
			
			
		 }else{
			 
			/*Cierro el precio real de venta actual*/
			$sql_cierre_precioreal="update preciorealventa set hasta = now() where idpreciorealventa='".$precioreal[0]."'";
			$result_cierre_precioreal=pg_exec($con,$sql_cierre_precioreal);
			
			/*Inserto el nuevo precio real de venta*/
			$sql_preciorealventa = " insert into preciorealventa values (nextval('preciorealventa_idpreciorealventa_seq'),'".InversaCodigo($_POST["codigo3"])."',now(),null,'".$_POST["venta3"]."')";
			$result_preciorealventa = pg_exec($con,$sql_preciorealventa);	
			
			/*Cierro todos los precios reales por ubicaciones y tipos de precio*/
			$sql_updateprecioxubicacion="update precioxubicacion set hasta = now(), actual='false' where idproducto='".InversaCodigo($_POST["codigo3"])."' and hasta is null and actual='true';";
			$result_updateprecioxubicacion = pg_exec($con,$sql_updateprecioxubicacion);
						
			/*Inserto los nuevos precios por ubicación producto del cambio del precio real de venta*/
			$sql_ciudades="select * from ubicacion order by idubicacion";
			$result_ciudades=pg_exec($con,$sql_ciudades);
			$sql_precios="select * from tipoprecio order by idtipoprecio";
			$result_precios=pg_exec($con,$sql_precios);
			
			for($i=0;$i<pg_num_rows($result_ciudades);$i++){								
				$ciudad=pg_fetch_array($result_ciudades);
				for($j=0;$j<pg_num_rows($result_precios);$j++){
					$precio=pg_fetch_array($result_precios,$j);	
					$sql_precioxubicacion=" insert into precioxubicacion values (nextval('precioxubicacion_idprecioxubicacion_seq'),'".InversaCodigo($_POST["codigo3"])."','".$precio[0]."','".$ciudad[0]."','".$_POST["venta3"]."','".$_POST["por_".$ciudad[0]."_".$precio[0]]."','".$_POST["pre_".$ciudad[0]."_".$precio[0]]."',now(),null,true) ";
					$result_precioxubicacion=pg_exec($con,$sql_precioxubicacion);									
				}								
			}												
		 }
		 
		 
		 
		 
		 
		 
			$listainsumos = explode("-",$_POST["listainsumo"]);
			for($i=0;$i<(sizeof($listainsumos)-1);$i++){
				if($_POST["insumo-".$listainsumos[$i]]!="" && $_POST["insumo-".$listainsumos[$i]]!=0){
					
					$sql_existe_empaque="select * from productosempaques where idproducto='".InversaCodigo($_POST["codigo3"])."' and hasta is null and idinsumo='".$listainsumos[$i]."';";
					$result_existe_empaque = pg_exec($con,$sql_existe_empaque);
	
					if(pg_num_rows($result_existe_empaque)>0){
						$empaque_existente=pg_fetch_array($result_existe_empaque,0);
						
						if($_POST["insumo-".$listainsumos[$i]]!=$empaque_existente[5]){
							$sql_update_empaque="update productosempaques set hasta=now() where idproductosempaques='".$empaque_existente[0]."';";
							$result_update_empaque= pg_exec($con,$sql_update_empaque);
	
							$sql_productoempaques=" insert into productosempaques values (nextval('productosempaques_idproductosempaques_seq'),'".InversaCodigo($_POST["codigo3"])."','".$listainsumos[$i]."',now(),null,'".$_POST["insumo-".$listainsumos[$i]]."')";
							$result_productoempaques=pg_exec($con,$sql_productoempaques);								
							
						}
											
					}else{
				
						$sql_productoempaques=" insert into productosempaques values (nextval('productosempaques_idproductosempaques_seq'),'".InversaCodigo($_POST["codigo3"])."','".$listainsumos[$i]."',now(),null,'".$_POST["insumo-".$listainsumos[$i]]."')";
						$result_productoempaques=pg_exec($con,$sql_productoempaques);										
					}													
				}else{
					
					$sql_existe_empaque="select * from productosempaques where idproducto='".InversaCodigo($_POST["codigo3"])."' and hasta is null and idinsumo='".$listainsumos[$i]."';";
					$result_existe_empaque = pg_exec($con,$sql_existe_empaque);	
					if(pg_num_rows($result_existe_empaque)>0){
						$empaque_existente=pg_fetch_array($result_existe_empaque,0);
						$sql_update_empaque="update productosempaques set hasta=now() where idproductosempaques='".$empaque_existente[0]."';";
						$result_update_empaque= pg_exec($con,$sql_update_empaque);					
					}					
				}
			}
			
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("Producto Editado Satisfactoriamente");
						location.href="../../sistema/Productos.php"; 
                    </script>
		        <?						 
		 		 		 
		 		 
	}
	
	if($_POST["action"]==6){
		
        echo "<div class='tabla-cabecera'>";
       	  	echo "<div class='tabla-cabecera-elemento' style='width:19%;'>Código";
            if($_POST["filtro_orden"]=="idproducto" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="idproducto" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}			
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('idproducto','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('idproducto','desc')></div>";
            echo "</div>";
          	echo "</div>";   
			     
       	  	echo "<div class='tabla-cabecera-elemento' style='width:79%; border-right:0px;'>Nombre / Descripción del Producto";
            if($_POST["filtro_orden"]=="descripcion" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="descripcion" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}							
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('descripcion','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('descripcion','desc')></div>";
            echo "</div>";
          	echo "</div>";                                                           
       echo " </div>";	
	   
	    echo "<input type='hidden' name='filtro' id='filtro' value='".$_POST["filtro_orden"]."' />";
        echo "<input type='hidden' name='orden' id='orden' value='".$_POST["orden"]."' />";
        echo "<input type='hidden' name='filtro2' id='filtro2' value='".$_POST["filtro_busqueda"]."' />";
        echo "<input type='hidden' name='clave_bus' id='clave_bus' value='".$_POST["clave"]."' />";
        
		$sql_productos="select * from producto ";
		if($_POST["filtro_busqueda"]!="0" && $_POST["clave"]!="" ){
			if($_POST["filtro_busqueda"]=="idproducto"){
				$sql_productos = $sql_productos." where idproducto = ".$_POST["clave"]." ";
			}else
			if($_POST["filtro_busqueda"]=="descripcion"){
				$sql_productos = $sql_productos." where descripcion ilike '%".$_POST["clave"]."%' ";
			}			
		}
		
		if($_POST["filtro_orden"]!=""){
			$sql_productos = $sql_productos." order by ".$_POST["filtro_orden"]." ".$_POST["orden"];
		}else{
			$sql_productos = $sql_productos." order by idproducto";
		}
				
			$result_productos=pg_exec($con,$sql_productos);
			if(pg_num_rows($result_productos)>0){
				for($i=(($_POST["pagina"]*$_POST["muestra"])-$_POST["muestra"]);$i<pg_num_rows($result_productos) && $i<($_POST["pagina"] * $_POST["muestra"]);$i++){
					$producto=pg_fetch_array($result_productos,$i);																																							
			    	echo "<div class='tabla-linea'>";
		        	echo "<div class='tabla-linea-elemento' style='width:19%;'>".Codigo("PRO",$producto[0])."</div>";
		            echo "<div class='tabla-linea-elemento' style='width:69%;'>".$producto[2]."</div>";
		            echo "<div class='tabla-linea-elemento' id='linea".$producto[0]."' onclick='detalle(".$producto[0].")' style='width:20px;background:url(../recursos/imagenes/list_metro.png) no-repeat center center; cursor:pointer;' title='Ver Detalle'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='editar(".$producto[0].")' style='width:20px;background:url(../recursos/imagenes/edit.png) no-repeat center center; cursor:pointer;' title='Editar Registro'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='eliminarbanco(".$producto[0].")' style='width:20px;background:url(../recursos/imagenes/delete.png) no-repeat center center; cursor:pointer; border-right:0px;' title='Eliminar Registro'></div>";
			        echo "</div>";
			        echo "<div class='tabla-detalle' id='detalle".$producto[0]."' style='display: none'>";
		        	echo "<div class='tabla-detalle-contenedor'>										
					</div>";
			        echo "</div>";										
				}				
			}else{
				
			}	
			
            echo "<div class='tabla-pie'>";      	
            echo "<div class='tabla-pie-tabulador' title='Ir a la primera página' onclick=cambiar_pagina(1)><<</div>";
            echo "<div class='tabla-pie-tabulador' title='Ir una página atras' onclick=cambiar_pagina(2)><</div>";      
            echo "<div class='tabla-pie-actual'>Página <label id='pagina_actual'>".$_POST["pagina"]."</label>/<label id='total_paginas'>".ceil(pg_num_rows($result_productos)/$_POST["muestra"])."</label></div>";
            echo "<div class='tabla-pie-tabulador' title='Ir una página adelante' onclick=cambiar_pagina(3)>></div>";
            echo "<div class='tabla-pie-tabulador' title='Ir a la última página' onclick=cambiar_pagina(4)>>></div>";          
        	
            
            echo "<div class='tabla-pie-elemento'>";
            echo "<div class='tabla-pie-elemento-etiqueta'>Ir a la Página</div>";
            echo "<div class='tabla-pie-elemento-select'>";
            echo "<select name='selector_pagina' id='selector_pagina' onchange='paginar()'>";
						    $indice= ceil(pg_num_rows($result_productos)/$_POST["muestra"]);
							for($i=0;$i<$indice;$i++){
								if(($i+1)==$_POST["pagina"]){
									echo "<option value=".($i+1)." selected='selected'>".($i+1)."</option>";
								}else{
									echo "<option value=".($i+1).">".($i+1)."</option>";
								}
								
							}												                    	
            echo "</select>";
            echo "</div>";                
            echo "</div>";
            
        	echo "<div class='tabla-pie-elemento'>";
            echo "<div class='tabla-pie-elemento-etiqueta'>Numero de Registros</div>";
            echo "<div class='tabla-pie-elemento-select'>";
            echo "<select name='selector_registros' id='selector_registros' onchange='paginar2()'>";
            if($_POST["muestra"]==10){
				echo "<option value='10' selected='selected' >10</option>";
			}else{
				echo "<option value='10'>10</option>";
			}
            if($_POST["muestra"]==20){
				echo "<option value='20' selected='selected' >20</option>";
			}else{
				echo "<option value='20'>20</option>";
			}
            if($_POST["muestra"]==50){
				echo "<option value='50' selected='selected' >50</option>";
			}else{
				echo "<option value='50'>50</option>";
			}
		    
            
            
            echo "</select>";
            echo "</div>";                
            echo "</div>";
			$limite;
			if(pg_num_rows($result_productos)>=($_POST["pagina"]*$_POST["muestra"])){
				$limite=$_POST["pagina"]*$_POST["muestra"];
			}else{
				$limite=(($_POST["pagina"]-1)*$_POST["muestra"])+ ( pg_num_rows($result_productos) - (($_POST["pagina"]-1)*$_POST["muestra"])) ;	
			}
			
            echo "<div class='tabla-pie-actual' style='float:right; margin-right:5px;'>Mostrando ".((($_POST["pagina"]*$_POST["muestra"])-$_POST["muestra"])+1)." - ".$limite." de ".pg_num_rows($result_productos)."</div>";
        echo "</div>";    
    echo "</div>";								
	}
	
	if($_GET["action"]==7){ //Eliminar registro
		
	}
	
	if($_POST["action"]==8){ /*Actualizo la lista de insumos para remover de la misma los que ya fueron usados*/
	$usados=explode("-",$_POST["usados"]);
		   ?>
           <select data-placeholder="Seleccione el insumo.." name="insumos<?php echo $_POST["ind"]; ?>" id="insumos<?php echo $_POST["ind"]; ?>"  class="chzn-select" style="width:97%;" >
               <option value="0"></option>
               <?php						     
	           $sql_select_insumos="select * from insumo where tipoinsumo=2 order by idinsumo";
	           $result_select_insumos = pg_exec($con,$sql_select_insumos);
			   for($i=0;$i<pg_num_rows($result_select_insumos);$i++){
			       $insumo=pg_fetch_array($result_select_insumos,$i);
				   $bandpro=0;
				   for($j=0;$j<(sizeof($usados)-1);$j++){			
				        if($insumo[0]==$usados[$j]){
						    $bandpro=1;	
						}
		           }
				   if($bandpro==0){
						  echo "<option value=".$insumo[0].">".$insumo[4]."</option>"; 					 				  
				   }				    										 										 
			   }
			 ?>
           </select>
           <?				
	}

  
?>