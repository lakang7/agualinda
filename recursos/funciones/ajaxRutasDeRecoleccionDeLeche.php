<?php session_start();


    require("funciones.php");
    $con=Conectarse();			
	
	if($_GET["action"]==1){ //Agregar Nuevo registro
	
		$con=Conectarse();
		$sql_consulta_nombres = "select nombreruta from ruta;";
		$result_nombres = pg_exec($con,$sql_consulta_nombres);
		$bandera=0;
		for($i=0;$i<pg_num_rows($result_nombres);$i++){
			$nombre = pg_fetch_array($result_nombres,$i);			
			if(strtolower($nombre[0])==strtolower($_POST["nombre1"])){
				$bandera=1;
				break;
			}
		}
					   	  
		if($bandera==0){
			
			$sql_insert_registro="insert into ruta values(nextval('ruta_idruta_seq'),'".$_POST["nombre1"]."','".$_POST["encargado1"]."','".$_POST["telefono1_1"]."','".$_POST["telefono2_1"]."','".$_POST["correo1"]."','".$_POST["capacidad1"]."','".$_POST["placa1"]."','".$_POST["rif1"]."','".$_POST["pago1"]."',now(),1,'".$_POST["tipopersona1"]."')";
			$result_insert_registro=pg_exec($con,$sql_insert_registro);
			
			$sql_last_record="select last_value from ruta_idruta_seq;";
			$result_last_record=pg_exec($con,$sql_last_record);
			$last_record=pg_fetch_array($result_last_record,0);
			
			$sql_insert_record="insert into historico_ruta_pago values(nextval('historico_ruta_pago_idhistorico_ruta_pago_seq'),'".$last_record[0]."','".$_POST["pago1"]."',now(),null)";
			$result_insert_record = pg_exec($con,$sql_insert_record);
			
			
			if($result_insert_registro!=NULL){
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo $_POST["nombre1"]." Agregado Satisfactoriamente."; ?>");
						location.href="../../sistema/RutasDeRecoleccionDeLeche.php"; 
                    </script>
		        <?			
			}else{			
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo "Ocurrio un problema agragando '".$_POST["nombre1"]; ?>");
						location.href="../../sistema/RutasDeRecoleccionDeLeche.php"; 
                    </script>
		        <?		
			}						
		}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo $_POST["nombre1"]."' ya se encuentra registrada en la base datos."; ?>");
						location.href="../../sistema/RutasDeRecoleccionDeLeche.php"; 
                    </script>
		        <?									
		}	  
	}
	
	if($_POST["action"]==2){  //ver detalle de banco
	     $sql_select_registro="select * from ruta where idruta='".$_POST["identificador"]."'";
		 $result_select_registro=pg_exec($con,$sql_select_registro);
		 $registro=pg_fetch_array($result_select_registro,0);
	?>
		<div class='tabla-detalle-contenedor'>  
    			<div class="detalle-titulo">Detalle de Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo Codigo("RUT",$registro[0]); ?>" id="codigo2" name="codigo2" class="entrada" disabled="disabled" style="width:97%;" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:36%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Nombre de la Ruta (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[1]; ?>" id="nombre2" name="nombre2" class="entrada" disabled="disabled" style="width:97%;" maxlength="30" /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:36%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Encargado de la Ruta (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[2]; ?>" id="encargado2" name="encargado2" class="entrada" disabled="disabled" style="width:97%;" maxlength="30" /></div>
                    </div>
                </div> 
                
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Documento (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[8]; ?>" id="rif2" name="rif2" class="entrada" disabled="disabled" style="width:97%;" maxlength="20" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Teléfono 1 (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[3]; ?>" id="telefono1_2" name="telefono1_2" class="entrada" disabled="disabled" style="width:97%;" maxlength="12" /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Teléfono 2 </div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[4]; ?>" id="telefono2_2" name="telefono2_2" class="entrada" disabled="disabled" style="width:97%;" maxlength="12" /></div>
                    </div>
                 	<div class="detalle-linea-elemento" style="width:17%;margin-left:2%">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Correo Electrónico</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[5]; ?>" id="correo2" name="correo2" class="entrada" disabled="disabled" style="width:97%;" maxlength="60" /></div>
                    </div> 
                 	
                    <div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Tipo de Persona</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el tipo de persona..." name="tipopersona2" id="tipopersona2" disabled="disabled" style="width:97%;" class="chzn-select" >
                                <option value=""></option>
                                <?php
										 if($registro[12]==1){
											echo "<option value='1' selected='selected'>Persona Natural</option>"; 
											echo "<option value='2'>Persona Juridica</option>"; 
										 }else{
											echo "<option value='1' >Persona Natural</option>"; 
											echo "<option value='2' selected='selected'>Persona Juridica</option>"; 											 
										 }										 								
								?>
                            </select>                        
                        </div>
                    </div>
                    
                                                            
                </div>    
                
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Placa (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[7]; ?>" id="placa2" name="placa2" class="entrada" disabled="disabled" style="width:97%;" maxlength="20" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Capacidad Maxima litros (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[6]; ?>" id="capacida2" name="capacida2" class="entrada" disabled="disabled" style="width:97%;" maxlength="12" /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Pago por Litro </div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[9]; ?>" id="pago2" name="pago2" class="entrada" disabled="disabled" style="width:97%;" maxlength="12" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%;margin-left:2%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo date("d-m-Y",strtotime($registro[10])); ?>" id="fecha2" name="fecha2" class="entrada" disabled="disabled" style="width:97%;" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Estatus (*)</div>
  						<div id="estatus2" style="font-size:8px; width:100%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                            <?php
							    if($registro[11]==1){
						   			echo "<input type='radio' id='radio1' name='estatus2' value='1' checked='checked' /><label for='radio1'>Habilitado</label>";
						    		echo "<input type='radio' id='radio2' name='estatus2' value='2' /><label for='radio2'>Deshabilitado</label>";									
								}else{
						   			echo "<input type='radio' id='radio1' name='estatus2' value='1' /><label for='radio1'>Habilitado</label>";
						    		echo "<input type='radio' id='radio2' name='estatus2' value='2'  checked='checked' /><label for='radio2'>Deshabilitado</label>";									
								}
							?>

					    </div>
                    </div>                                          
                </div>                                                                                                                                                                                                             
                <div class="detalle-indica">Los campos indicados con (*) son Obligatorios</div>                                  
	        </div>
	<?	    	
	}
	
	if($_POST["action"]==3){  //Generar Formulario Para Registro
		?>
                            
		<div class='tabla-detalle-contenedor'> 
         	<form name="formagregaregistro" id="formagregaregistro" method="post" action="../recursos/funciones/ajaxRutasDeRecoleccionDeLeche.php?action=1" >
    			<div class="detalle-titulo">Detalle de Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="codigo1" name="codigo1" class="entrada" readonly='readonly' style="width:97%;" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:36%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Nombre de la Ruta (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="nombre1" name="nombre1" class="entrada"  style="width:97%" maxlength="30" /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:36%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Encargado de la Ruta (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="encargado1" name="encargado1" class="entrada" style="width:97%;" maxlength="30" /></div>
                    </div>
                </div> 
                
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Documento (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="rif1" name="rif1" class="entrada"  style="width:97%;" maxlength="20" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Teléfono 1 (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="telefono1_1" name="telefono1_1" class="entrada"  style="width:97%;" maxlength="12" /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Teléfono 2 </div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="telefono2_1" name="telefono2_1" class="entrada"  style="width:97%;" maxlength="12" /></div>
                    </div>
                 	<div class="detalle-linea-elemento" style="width:17%; margin-left:2%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Correo Electrónico</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="correo1" name="correo1" class="entrada"  style="width:97%;" maxlength="60" /></div>
                    </div>                    
                    <div class="detalle-linea-elemento" style="width:20%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Tipo de Persona</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el tipo de persona..." name="tipopersona1" id="tipopersona1"  class="chzn-select" style="width:50%;">
                                <option value=""></option>
                                <?php
											echo "<option value='1' selected='selected'>Persona Natural</option>"; 
											echo "<option value='2'>Persona Juridica</option>"; 									 								
								?>
                            </select>                         
                        </div>
                    </div>                    
                    
                    
                </div>    
                
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Placa (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="placa1" name="placa1" class="entrada"  style="width:97%" maxlength="20" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Capacidad Maxima litros (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="capacidad1" name="capacidad1" class="entrada"  style="width:97%;" maxlength="12" /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Pago por Litro </div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="pago1" name="pago1" class="entrada"  style="width:97%;" maxlength="12" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%;margin-left:2%">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="fecha1" name="fecha1" class="entrada" readonly="readonly"  style="width:97%;" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Estatus (*)</div>
  						<div id="estatus1" style="font-size:8px; width:97%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                            <?php							   
						   			echo "<input type='radio' id='radio1' name='estatus1' value='1' checked='checked' /><label for='radio1'>Habilitado</label>";
						    		echo "<input type='radio' id='radio2' name='estatus1' value='2' /><label for='radio2'>Deshabilitado</label>";																	
							?>

					    </div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:60px;">
                    	<div class="detalle-linea-elemento-arriba" style="width:60px;"></div>
                        <div class="detalle-linea-elemento-abajo" style="font-size:8px; width:60px;"><input type="button" value="Guardar" onclick="agregarregistro()" /></div>
                    </div>                                                                
                </div>                                                                                                                                                                                                             
                <div class="detalle-indica">Los campos indicados con (*) son Obligatorios</div>                                  
	      	</form>    
            </div>                       
              
        <?
	}
	
	
	if($_POST["action"]==4){  //formulario para editar registro
	     $sql_select_registro="select * from ruta where idruta='".$_POST["identificador"]."'";
		 $result_select_registro=pg_exec($con,$sql_select_registro);
		 $registro=pg_fetch_array($result_select_registro,0);
	?>
         
		<div class='tabla-detalle-contenedor'> 
        	<form name="formeditarregistro" id="formeditarregistro" method="post" action="../recursos/funciones/ajaxRutasDeRecoleccionDeLeche.php?action=5" > 
    			<div class="detalle-titulo">Editar Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo Codigo("RUT",$registro[0]); ?>" id="codigo3" name="codigo3" class="entrada" readonly='readonly' style="width:97%; background:#EFEFEF" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:36%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Nombre de la Ruta (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[1]; ?>" id="nombre3" name="nombre3" class="entrada"  style="width:97%;" maxlength="30" /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:36%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Encargado de la Ruta (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[2]; ?>" id="encargado3" name="encargado3" class="entrada" style="width:97%;" maxlength="30" /></div>
                    </div>
                </div> 
                
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Documento (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[8]; ?>" id="rif3" name="rif3" class="entrada"  style="width:97%;" maxlength="20" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Teléfono 1 (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[3]; ?>" id="telefono1_3" name="telefono1_3" class="entrada"  style="width:97%;" maxlength="12" /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Teléfono 2 </div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[4]; ?>" id="telefono2_3" name="telefono2_3" class="entrada"  style="width:97%;" maxlength="12" /></div>
                    </div>
                 	<div class="detalle-linea-elemento" style="width:17%;margin-left:2%">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Correo Electrónico</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[5]; ?>" id="correo3" name="correo3" class="entrada"  style="width:97%;" maxlength="60" /></div>
                    </div> 
                    <div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Tipo de Persona</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el tipo de persona..." name="tipopersona3" id="tipopersona3" style="width:97%;" class="chzn-select" >
                                <option value=""></option>
                                <?php
										 if($registro[12]==1){
											echo "<option value='1' selected='selected'>Persona Natural</option>"; 
											echo "<option value='2'>Persona Juridica</option>"; 
										 }else{
											echo "<option value='1' >Persona Natural</option>"; 
											echo "<option value='2' selected='selected'>Persona Juridica</option>"; 											 
										 }										 								
								?>
                            </select>                        
                        </div>
                    </div>                    
                                       
                </div>    
                
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Placa (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[7]; ?>" id="placa3" name="placa3" class="entrada"  style="width:97%;" maxlength="20" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Capacidad Maxima litros (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[6]; ?>" id="capacidad3" name="capacidad3" class="entrada"  style="width:97%;" maxlength="12" /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Pago por Litro </div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $registro[9]; ?>" id="pago3" name="pago3" class="entrada"  style="width:97%;" maxlength="12" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%;margin-left:2% ">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo date("d-m-Y",strtotime($registro[10])); ?>" id="fecha3" name="fecha3" class="entrada" disabled="disabled"  style="width:97%;" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Estatus (*)</div>
  						<div id="estatus3" style="font-size:8px; width:97%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                            <?php
							    if($registro[11]==1){
						   			echo "<input type='radio' id='radio1' name='estatus3' value='1' checked='checked' /><label for='radio1'>Habilitado</label>";
						    		echo "<input type='radio' id='radio2' name='estatus3' value='2' /><label for='radio2'>Deshabilitado</label>";									
								}else{
						   			echo "<input type='radio' id='radio1' name='estatus3' value='1' /><label for='radio1'>Habilitado</label>";
						    		echo "<input type='radio' id='radio2' name='estatus3' value='2'  checked='checked' /><label for='radio2'>Deshabilitado</label>";									
								}
							?>

					    </div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:8%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;"></div>
                        <div class="detalle-linea-elemento-abajo" style="font-size:8px; width:100%;"><input type="button" value="Guardar" onclick="editarregistro()" /></div>
                    </div>                                                                
                </div>                                                          
                <div class="detalle-indica">Los campos indicados con (*) son Obligatorios</div>                                  
	        </form>
            </div>		               
	<?	    	
	}	
	
	if($_GET["action"]==5){ /*Editar Registro*/	
		$con=Conectarse();
		$sql_consulta_nombres = "select nombreruta from ruta where idruta!= '".InversaCodigo($_POST["codigo3"])."';";
		$result_nombres = pg_exec($con,$sql_consulta_nombres);
		$bandera=0;
		for($i=0;$i<pg_num_rows($result_nombres);$i++){
			$nombre = pg_fetch_array($result_nombres,$i);			
			if(strtolower($nombre[0])==strtolower($_POST["nombre3"])){
				$bandera=1;
				break;
			}
		}		 
		 						
		if($bandera==0){
		    $sql_update_registro="update ruta set nombreruta='".$_POST["nombre3"]."', estatus='".$_POST["estatus3"]."', encargado='".$_POST["encargado3"]."', telefono1='".$_POST["telefono1_3"]."', telefono2='".$_POST["telefono2_3"]."', correo='".$_POST["correo3"]."', capacidadmaxima='".$_POST["capacidad3"]."', placa='".$_POST["placa3"]."', rif='".$_POST["rif3"]."', tipopersona='".$_POST["tipopersona3"]."'   where idruta ='".InversaCodigo($_POST["codigo3"])."' ";	
			
				
			$result_update_registro=pg_exec($con,$sql_update_registro);
			$sql_select_record2="select pagounidad from ruta where idruta='".InversaCodigo($_POST["codigo3"])."'";
			$result_select_record2=pg_exec($con,$sql_select_record2);
			$antiguo_pago=pg_fetch_array($result_select_record2,0);
			if($antiguo_pago[0]!=$_POST["pago3"]){
				$sql_select_viejo_historico="select idhistorico_ruta_pago from historico_ruta_pago where idruta='".InversaCodigo($_POST["codigo3"])."' order by idhistorico_ruta_pago DESC";
				$result_select_viejo_historico=pg_exec($con,$sql_select_viejo_historico);
				$ultimo_historico=pg_fetch_array($result_select_viejo_historico,0);								
				$sql_update_viejo_historico="update historico_ruta_pago set hasta = now() where idhistorico_ruta_pago='".$ultimo_historico[0]."'";
				$result_update_viejo_historico=pg_exec($con,$sql_update_viejo_historico);
				$sql_insert_record="insert into historico_ruta_pago values(nextval('historico_ruta_pago_idhistorico_ruta_pago_seq'),'".InversaCodigo($_POST["codigo3"])."','".$_POST["pago3"]."',now(),null)";
				$result_insert_record = pg_exec($con,$sql_insert_record);	
		        $sql_update_registro="update ruta set pagounidad='".$_POST["pago3"]."' where idruta ='".InversaCodigo($_POST["codigo3"])."' ";		
			    $result_update_registro=pg_exec($con,$sql_update_registro);								
			}
				
			
			
			if($result_update_registro!=NULL){
				?>
                	
		        	<script type="text/javascript" language="javascript"> 
						alert("Ruta Editada Satisfactoriamente");
						location.href="../../sistema/RutasDeRecoleccionDeLeche.php"; 
                    </script>
		        <?			
			}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("Ocurrio un problema Editando la ruta de recolección.");
						location.href="../../sistema/RutasDeRecoleccionDeLeche.php"; 
                    </script>
		        <?		
			}						
		}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo $_POST["nombre3"]."' ya se encuentra registrado en la base datos.";  ?>");
						location.href="../../sistema/RutasDeRecoleccionDeLeche.php"; 
                    </script>
		        <?									
		}		 
		 

	}
	
	if($_POST["action"]==6){
		
        echo "<div class='tabla-cabecera'>";
       	  	echo "<div class='tabla-cabecera-elemento' style='width:9%;'>Código";
            if($_POST["filtro_orden"]=="idruta" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="idruta" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}			
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('idruta','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('idruta','desc')></div>";
            echo "</div>";
          	echo "</div>";   
			
						     
       	  	echo "<div class='tabla-cabecera-elemento' style='width:26%; border-right:0px;'>Nombre de la Ruta";
            if($_POST["filtro_orden"]=="nombreruta" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="nombreruta" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}							
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('nombreruta','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('nombreruta','desc')></div>";
            echo "</div>";
          	echo "</div>";
			 
			
       	  	echo "<div class='tabla-cabecera-elemento' style='width:26%; border-right:0px;'>Encargado";
            if($_POST["filtro_orden"]=="encargado" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="encargado" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}							
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('encargado','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('encargado','desc')></div>";
            echo "</div>";
          	echo "</div>"; 		

			
       	  	echo "<div class='tabla-cabecera-elemento' style='width:13%; border-right:0px;'>Documento";
            if($_POST["filtro_orden"]=="rif" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="rif" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}							
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('rif','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('rif','desc')></div>";
            echo "</div>";
          	echo "</div>";
			
			
       	  	echo "<div class='tabla-cabecera-elemento' style='width:22%; border-right:0px;'>Bs Litro";
            if($_POST["filtro_orden"]=="pagounidad" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="pagounidad" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}							
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('pagounidad','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('pagounidad','desc')></div>";
            echo "</div>";
          	echo "</div>"; 			 				
									                                                          
       echo " </div>";	
	   
	    echo "<input type='hidden' name='filtro' id='filtro' value='".$_POST["filtro_orden"]."' />";
        echo "<input type='hidden' name='orden' id='orden' value='".$_POST["orden"]."' />";
        echo "<input type='hidden' name='filtro2' id='filtro2' value='".$_POST["filtro_busqueda"]."' />";
        echo "<input type='hidden' name='clave_bus' id='clave_bus' value='".$_POST["clave"]."' />";
        
		$sql_records="select * from ruta ";
		if($_POST["filtro_busqueda"]!="0" && $_POST["clave"]!="" ){

			if($_POST["filtro_busqueda"]=="idruta"){
				$sql_records = $sql_records." where idruta = ".$_POST["clave"]." ";
			}else
			if($_POST["filtro_busqueda"]=="nombreruta"){
				$sql_records = $sql_records." where nombreruta ilike '%".$_POST["clave"]."%' ";
			}else
			if($_POST["filtro_busqueda"]=="encargado"){
				$sql_records = $sql_records." where encargado ilike '%".$_POST["clave"]."%' ";
			}else
			if($_POST["filtro_busqueda"]=="rif"){
				$sql_records = $sql_records." where rif ilike '%".$_POST["clave"]."%' ";
			}else		
			if($_POST["filtro_busqueda"]=="pagounidad"){
				$sql_records = $sql_records." where pagounidad = ".$_POST["clave"]." ";
			}	
					
		}
		
		if($_POST["filtro_orden"]!=""){
			$sql_records = $sql_records." order by ".$_POST["filtro_orden"]." ".$_POST["orden"];
		}else{
			$sql_records = $sql_records." order by idruta";
		}
				
			$result_records=pg_exec($con,$sql_records);
			if(pg_num_rows($result_records)>0){
				for($i=(($_POST["pagina"]*$_POST["muestra"])-$_POST["muestra"]);$i<pg_num_rows($result_records) && $i<($_POST["pagina"] * $_POST["muestra"]);$i++){
					$registro=pg_fetch_array($result_records,$i);																																							
			    	echo "<div class='tabla-linea'>";
		        	echo "<div class='tabla-linea-elemento' style='width:9%;'>".Codigo("RUT",$registro[0])."</div>";
		            echo "<div class='tabla-linea-elemento' style='width:26%;'>".$registro[1]."</div>";
		            echo "<div class='tabla-linea-elemento' style='width:26%;'>".$registro[2]."</div>";
		            echo "<div class='tabla-linea-elemento' style='width:13%;'>".$registro[8]."</div>";
		            echo "<div class='tabla-linea-elemento' style='width:12%;'>".$registro[9]."</div>";															
					
		            echo "<div class='tabla-linea-elemento' id='linea".$registro[0]."' onclick='detalle(".$registro[0].")' style='width:20px;background:url(../recursos/imagenes/list_metro.png) no-repeat center center; cursor:pointer;' title='Ver Detalle'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='editar(".$registro[0].")' style='width:20px;background:url(../recursos/imagenes/edit.png) no-repeat center center; cursor:pointer;' title='Editar Registro'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='eliminarregistro(".$registro[0].")' style='width:20px;background:url(../recursos/imagenes/delete.png) no-repeat center center; cursor:pointer; border-right:0px;' title='Eliminar Registro'></div>";
			        echo "</div>";
			        echo "<div class='tabla-detalle' id='detalle".$registro[0]."' style='display: none'>";
		        	echo "<div class='tabla-detalle-contenedor'>										
					</div>";
			        echo "</div>";										
				}				
			}else{
				
			}	
			
            echo "<div class='tabla-pie'>";      	
            echo "<div class='tabla-pie-tabulador' title='Ir a la primera página' onclick=cambiar_pagina(1)><<</div>";
            echo "<div class='tabla-pie-tabulador' title='Ir una página atras' onclick=cambiar_pagina(2)><</div>";      
            echo "<div class='tabla-pie-actual'>Página <label id='pagina_actual'>".$_POST["pagina"]."</label>/<label id='total_paginas'>".ceil(pg_num_rows($result_records)/$_POST["muestra"])."</label></div>";
            echo "<div class='tabla-pie-tabulador' title='Ir una página adelante' onclick=cambiar_pagina(3)>></div>";
            echo "<div class='tabla-pie-tabulador' title='Ir a la última página' onclick=cambiar_pagina(4)>>></div>";          
        	
            
            echo "<div class='tabla-pie-elemento'>";
            echo "<div class='tabla-pie-elemento-etiqueta'>Ir a la Página</div>";
            echo "<div class='tabla-pie-elemento-select'>";
            echo "<select name='selector_pagina' id='selector_pagina' onchange='paginar()'>";
						    $indice= ceil(pg_num_rows($result_records)/$_POST["muestra"]);
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
			if(pg_num_rows($result_records)>=($_POST["pagina"]*$_POST["muestra"])){
				$limite=$_POST["pagina"]*$_POST["muestra"];
			}else{
				$limite=(($_POST["pagina"]-1)*$_POST["muestra"])+ ( pg_num_rows($result_records) - (($_POST["pagina"]-1)*$_POST["muestra"])) ;	
			}
			
            echo "<div class='tabla-pie-actual' style='float:right; margin-right:5px;'>Mostrando ".((($_POST["pagina"]*$_POST["muestra"])-$_POST["muestra"])+1)." - ".$limite." de ".pg_num_rows($result_records)."</div>";
        echo "</div>";    
    echo "</div>";								
	}
	
	if($_GET["action"]==7){ //Eliminar registro
		?>
		    <script type="text/javascript" language="javascript"> location.href="../../sistema/RutasDeRecoleccionDeLeche.php"; </script>
		<?		
	}

  
?>