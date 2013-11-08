<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?

    require("funciones.php");
    $con=Conectarse();			
	
	if($_GET["action"]==1){ //Agregar Nuevo Cliente		   	  
		$con=Conectarse();
		$sql_consulta_nombres = "select documento from cliente;";
		$result_nombres = pg_exec($con,$sql_consulta_nombres);
		$bandera=0;
		for($i=0;$i<pg_num_rows($result_nombres);$i++){
			$nombre = pg_fetch_array($result_nombres,$i);			
			if(strtolower($nombre[0])==strtolower($_POST["documento1"])){
				$bandera=1;
				break;
			}
		}
		
		
		if($bandera==0){
			$sql_insertCliente=" insert into cliente values(nextval('cliente_idcliente_seq'),'".$_POST["nombre1"]."','".$_POST["rif1"]."',".$_POST["tipopersona1"].",'".$_POST["facturacion1"]."',".$_POST["ubicacion1"].",now(),'".$_POST["direccion1"]."','".$_POST["telefono1_1"]."','".$_POST["telefono1_2"]."','".$_POST["correo1"]."',".$_POST["estatus1"].")";
			$result_insertCliente=pg_exec($con,$sql_insertCliente);
			
			$sql_last_record="select last_value from cliente_idcliente_seq;";
			$result_last_record=pg_exec($con,$sql_last_record);
			$last_record=pg_fetch_array($result_last_record,0);	
			
			$sql_insert_record="insert into cliente_ubicacion values(nextval('cliente_idcliente_seq'),'".$last_record[0]."','".$_POST["ubicacion1"]."',now(),null)";
			$result_insert_record = pg_exec($con,$sql_insert_record);								
												
			if($result_insertCliente!=NULL){
				?>                    
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo $_POST["nombre1"]." Agregado Satisfactoriamente." ?>");
						location.href="../../sistema/Clientes.php"; 
                    </script>
		        <?			
			}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo "Ocurrio un problema agragando '".$_POST["nombre1"] ?>");
						location.href="../../sistema/Clientes.php";                     
                    </script>
		        <?		
			}						
		}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo $_POST["nombre1"]." ya se encuentra registrado en la base datos." ?>");
						location.href="../../sistema/Clientes.php"; 						
                    </script>
		        <?									
		}	  
	}
	
	
	if($_POST["action"]==2){  //ver detalle de Cliente
	     $sql_select_cliente="select * from cliente where idcliente='".$_POST["identificador"]."'";
		 $result_select_cliente=pg_exec($con,$sql_select_cliente);
		 $cliente=pg_fetch_array($result_select_cliente,0);
	?>
		<div class='tabla-detalle-contenedor'>  
    			<div class="detalle-titulo">Detalle de Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
				 <div class="detalle-linea" style="width:98%;">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo Codigo("CLI",$cliente[0]); ?>" id="codigo2" name="codigo2" class="entrada" readonly='readonly' style="width:97%; background:#EFEFEF" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:36%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Nombre del Cliente (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[1]; ?>" id="nombre2" name="nombre2" class="entrada"  style="width:97%; background:#EFEFEF" maxlength="60" disabled="disabled" /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:36%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Nombre de Facturación (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[4]; ?>" id="facturacion2" name="facturacion2" class="entrada" style="width:97%; background:#EFEFEF" disabled="disabled" maxlength="120" /></div>
                    </div>
                </div>
                
                
                <div class="detalle-linea" style="width:98%;">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Documento (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[2]; ?>" id="rif2" name="rif2" class="entrada"  style="width:97%;background:#EFEFEF" maxlength="30" disabled="disabled" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Teléfono 1 (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[8]; ?>" id="telefono2_1" name="telefono2_1" class="entrada"  style="width:97%;background:#EFEFEF" disabled="disabled" maxlength="12" /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Teléfono 2 </div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[9]; ?>" id="telefono2_2" name="telefono2_2" class="entrada"  style="width:97%;background:#EFEFEF" disabled="disabled" maxlength="12" /></div>
                    </div>
                 	<div class="detalle-linea-elemento" style="width:17%; margin-left:2%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Correo Electrónico</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[10]; ?>" id="correo2" name="correo1" class="entrada"  style="width:97%;background:#EFEFEF" disabled="disabled" maxlength="60" /></div>
                    </div>                    
                    <div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:97%;">Tipo de Persona</div>
                        <div class="detalle-linea-elemento-abajo" style="width:97%;">
                        	<select data-placeholder="Seleccione el tipo de persona..." name="tipopersona2" id="tipopersona2"  class="chzn-select" style="width:97%;" disabled="disabled">
                                <option value=""></option>
                                <?php
								     if($cliente[3]==1){
										echo "<option value='1' selected='selected'>Persona Natural</option>"; 
										echo "<option value='2'>Persona Juridica</option>"; 												
									 }else{
										echo "<option value='1'>Persona Natural</option>"; 
										echo "<option value='2' selected='selected'>Persona Juridica</option>"; 										
									 }
									 								
								?>
                            </select>                         
                        </div>
                    </div>                                                            
                </div>
                
                
				 <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Ubicación (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        
                        <select data-placeholder="Seleccione la ubicación..." name="ubicacion2" id="ubicacion2" style="width:97%;" class="chzn-select" disabled="disabled" >
                            <option value="0"></option>
                                <?php
								     $con=Conectarse();
								     $sql_select_ubicaciones="select * from ubicacion order by ciudad ASC";
									 $result_select_ubicaciones = pg_exec($con,$sql_select_ubicaciones);
									 for($i=0;$i<pg_num_rows($result_select_ubicaciones);$i++){
										 $ubicacion=pg_fetch_array($result_select_ubicaciones,$i);
										    if($cliente[5]==$ubicacion[0]){
												echo "<option value=".$ubicacion[0]." selected='selected'>".$ubicacion[2]."</option>";
											}else{
												echo "<option value=".$ubicacion[0].">".$ubicacion[2]."</option>";
											}
											 										 										 
									 }
								?>
                            </select>                        
                        
                        </div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Direccion (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[7]; ?>" id="direccion2" name="direccion2" class="entrada" disabled="disabled"  style="width:97%;background:#EFEFEF" maxlength="400" /></div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[6]; ?>" id="fecha2" name="fecha2" class="entrada" disabled="disabled"  style="width:97%; background:#EFEFEF" maxlength="12" readonly='readonly' /></div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:17%; ">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Estatus (*)</div>
  						<div id="estatus2" style="font-size:8px; width:100%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                            <?php							   
						   			echo "<input type='radio' id='radio1' name='estatus2' value='1' checked='checked' /><label for='radio1'>Habilitado</label>";
						    		echo "<input type='radio' id='radio2' name='estatus2' value='2' /><label for='radio2'>Deshabilitado</label>";																	
							?>

					    </div>
                    </div>                                                          
                    
                </div>                                
                                                 
	    
        </div>
	<?	    	
	}
	
	if($_POST["action"]==3){  //Generar Formulario Para Registro
		?>
                                
			<div class='tabla-detalle-contenedor'>  
            	<form name="formagregacliente" id="formagregacliente" method="post" action="../recursos/funciones/ajaxClientes.php?action=1" >
    			<div class="detalle-titulo">Agregar Nuevo Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
				 <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="codigo1" name="codigo1" class="entrada" readonly='readonly' style="width:97%;" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:36%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Nombre del Cliente (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="nombre1" name="nombre1" class="entrada"  style="width:97%" maxlength="30" /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:36%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Nombre de Facturación (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="facturacion1" name="facturacion1" class="entrada" style="width:97%;" maxlength="30" /></div>
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
                    <div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Tipo de Persona</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el tipo de persona..." name="tipopersona1" id="tipopersona1"  class="chzn-select" style="width:100%;">
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
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Ubicación (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        
                        <select data-placeholder="Seleccione la ubicación..." name="ubicacion1" id="ubicacion1" style="width:97%;" class="chzn-select" >
                            <option value="0"></option>
                                <?php
								     $con=Conectarse();
								     $sql_select_ubicaciones="select * from ubicacion order by ciudad ASC";
									 $result_select_ubicaciones = pg_exec($con,$sql_select_ubicaciones);
									 for($i=0;$i<pg_num_rows($result_select_ubicaciones);$i++){
										 $ubicacion=pg_fetch_array($result_select_ubicaciones,$i);
											echo "<option value=".$ubicacion[0].">".$ubicacion[2]."</option>"; 										 										 
									 }
								?>
                            </select>                        
                        
                        </div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:36%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Direccion (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="direccion1" name="direccion1" class="entrada"  style="width:97%" maxlength="30" /></div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="" id="fecha1" name="fecha1" class="entrada"  style="width:97%;" maxlength="12" readonly='readonly' /></div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:17%; ">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Estatus (*)</div>
  						<div id="estatus1" style="font-size:8px; width:100%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                            <?php							   
						   			echo "<input type='radio' id='radio1' name='estatus1' value='1' checked='checked' /><label for='radio1'>Habilitado</label>";
						    		echo "<input type='radio' id='radio2' name='estatus1' value='2' /><label for='radio2'>Deshabilitado</label>";																	
							?>

					    </div>
                    </div> 
                    
                	<div class="detalle-linea-elemento" style="width:8%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;"></div>
                        <div class="detalle-linea-elemento-abajo" style="font-size:8px; width:100%;"><input type="button" value="Guardar" onclick="agregarregistro()" /></div>
                    </div>                     
                    
                    
                </div>                                  
                <div class="detalle-indica">Los campos indicados con (*) son Obligatotios</div>              
	        	</form> 
            </div>                        
               
        <?
	}
	
	
	if($_POST["action"]==4){  //formulario para editar registro
	     $sql_select_cliente="select * from cliente where idcliente='".$_POST["identificador"]."'";
		 $result_select_cliente=pg_exec($con,$sql_select_cliente);
		 $cliente=pg_fetch_array($result_select_cliente,0);
	?>
         
		<div class='tabla-detalle-contenedor'>  
        	<form name="formeditarcliente" id="formeditarcliente" method="post" action="../recursos/funciones/ajaxClientes.php?action=5"  >
    			<div class="detalle-titulo">Editar Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
				 <div class="detalle-linea" style="width:98%;">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo Codigo("CLI",$cliente[0]); ?>" id="codigo3" name="codigo3" class="entrada" readonly='readonly' style="width:97%; background:#EFEFEF" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:36%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Nombre del Cliente (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[1]; ?>" id="nombre3" name="nombre3" class="entrada"  style="width:97%;" maxlength="60"  /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:36%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Nombre de Facturación (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[4]; ?>" id="facturacion3" name="facturacion3" class="entrada" style="width:97%;"  maxlength="120" /></div>
                    </div>
                </div>
                
                
                <div class="detalle-linea" style="width:98%;">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Documento (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[2]; ?>" id="rif3" name="rif3" class="entrada"  style="width:97%;" maxlength="30"  /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Teléfono 1 (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[8]; ?>" id="telefono3_1" name="telefono3_1" class="entrada"  style="width:97%;"  maxlength="12" /></div>
                    </div> 
                 	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Teléfono 2 </div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[9]; ?>" id="telefono3_2" name="telefono3_2" class="entrada"  style="width:97%;"  maxlength="12" /></div>
                    </div>
                 	<div class="detalle-linea-elemento" style="width:17%; margin-left:2%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Correo Electrónico</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[10]; ?>" id="correo3" name="correo3" class="entrada"  style="width:97%;"  maxlength="60" /></div>
                    </div>                    
                    <div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:97%;">Tipo de Persona</div>
                        <div class="detalle-linea-elemento-abajo" style="width:97%;">
                        	<select data-placeholder="Seleccione el tipo de persona..." name="tipopersona3" id="tipopersona3"  class="chzn-select" style="width:97%;" >
                                <option value=""></option>
                                <?php
								     if($cliente[3]==1){
										echo "<option value='1' selected='selected'>Persona Natural</option>"; 
										echo "<option value='2'>Persona Juridica</option>"; 												
									 }else{
										echo "<option value='1'>Persona Natural</option>"; 
										echo "<option value='2' selected='selected'>Persona Juridica</option>"; 										
									 }
									 								
								?>
                            </select>                         
                        </div>
                    </div>                                                            
                </div>
                
                
				 <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:14%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Ubicación (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        
                        <select data-placeholder="Seleccione la ubicación..." name="ubicacion3" id="ubicacion3" style="width:97%;" class="chzn-select" >
                            <option value="0"></option>
                                <?php
								     $con=Conectarse();
								     $sql_select_ubicaciones="select * from ubicacion order by ciudad ASC";
									 $result_select_ubicaciones = pg_exec($con,$sql_select_ubicaciones);
									 for($i=0;$i<pg_num_rows($result_select_ubicaciones);$i++){
										 $ubicacion=pg_fetch_array($result_select_ubicaciones,$i);
										    if($cliente[5]==$ubicacion[0]){
												echo "<option value=".$ubicacion[0]." selected='selected'>".$ubicacion[2]."</option>";
											}else{
												echo "<option value=".$ubicacion[0].">".$ubicacion[2]."</option>";
											}
											 										 										 
									 }
								?>
                            </select>                        
                        
                        </div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:34.6%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Direccion (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[7]; ?>" id="direccion3" name="direccion3" class="entrada"   style="width:97%;" maxlength="400" /></div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $cliente[6]; ?>" id="fecha3" name="fecha3" class="entrada" style="width:97%;" maxlength="12" readonly='readonly' /></div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:17%; ">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Estatus (*)</div>
  						<div id="estatus3" style="font-size:8px; width:100%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                            <?php							   
						   			echo "<input type='radio' id='radio1' name='estatus3' value='1' checked='checked' /><label for='radio1'>Habilitado</label>";
						    		echo "<input type='radio' id='radio2' name='estatus3' value='2' /><label for='radio2'>Deshabilitado</label>";																	
							?>

					    </div>
                    </div>
                    
                	<div class="detalle-linea-elemento" style="width:8%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;"></div>
                        <div class="detalle-linea-elemento-abajo" style="font-size:8px; width:100%;"><input type="button" value="Guardar" onclick="editarregistro()" /></div>
                    </div>                                                                               
                    
                </div>                
               
               
               
               
                <div class="detalle-indica">Los campos indicados con (*) son Obligatotios</div>                                  
	        </form>
            </div>
            
	<?	    	
	}	
	
	if($_GET["action"]==5){ /*Editar Registro*/	
		$con=Conectarse();
		$sql_consulta_documentos = "select documento from cliente where idcliente!= '".InversaCodigo($_POST["codigo3"])."';";
		$result_documentos = pg_exec($con,$sql_consulta_documentos);
		$bandera=0;
		for($i=0;$i<pg_num_rows($result_documentos);$i++){
			$documento = pg_fetch_array($result_documentos,$i);			
			if(strtolower($documento[0])==strtolower($_POST["rif3"])){
				$bandera=1;
				break;
			}
		}
				
		
		if($bandera==0){
		    $sql_update_cliente="update cliente set nombre='".$_POST["nombre3"]."', nombrefactura='".$_POST["facturacion3"]."', documento='".$_POST["rif3"]."', telefono1='".$_POST["telefono3_1"]."', telefono2='".$_POST["telefono3_2"]."', correo='".$_POST["correo3"]."', tipopersona=".$_POST["tipopersona3"].", direccion='".$_POST["direccion3"]."' where idcliente='".InversaCodigo($_POST["codigo3"])."';";					
			$result_update_cliente=pg_exec($con,$sql_update_cliente);
			
			$sql_select_record2="select idubicacion from cliente where idcliente='".InversaCodigo($_POST["codigo3"])."'";
			$result_select_record2=pg_exec($con,$sql_select_record2);
			$antigua_ubicacion=pg_fetch_array($result_select_record2,0);
			
			if($antigua_ubicacion[0]!=$_POST["ubicacion3"]){
				
				$sql_select_vieja_ubicacion="select idcliente_ubicacion from cliente_ubicacion where idcliente='".InversaCodigo($_POST["codigo3"])."' order by idcliente_ubicacion DESC";
				$result_select_vieja_ubicacion=pg_exec($con,$sql_select_vieja_ubicacion);
				$ultima_ubicacion=pg_fetch_array($result_select_vieja_ubicacion,0);
												
				$sql_update_vieja_ubicacion="update cliente_ubicacion set hasta = now() where idcliente_ubicacion='".$ultima_ubicacion[0]."'";
				$result_update_vieja_ubicacion=pg_exec($con,$sql_update_vieja_ubicacion);
				
				$sql_insert_record="insert into cliente_ubicacion values(nextval('cliente_ubicacion_idcliente_ubicacion_seq'),'".InversaCodigo($_POST["codigo3"])."','".$_POST["ubicacion3"]."',now(),null)";
				$result_insert_record = pg_exec($con,$sql_insert_record);
				
		        $sql_update_registro="update cliente set idubicacion='".$_POST["ubicacion3"]."' where idcliente ='".InversaCodigo($_POST["codigo3"])."' ";		
			    $result_update_registro=pg_exec($con,$sql_update_registro);								
			}
						
						
						
			if($result_update_cliente!=NULL){
				?>                	
		        	<script type="text/javascript" language="javascript">
						alert("<?php echo "Cliente Editado Satisfactoriamente."; ?>");
						location.href="../../sistema/Clientes.php"; 
                    </script>
		        <?			
			}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo "Ocurrio un problema Editando el Cliente." ?>");
						location.href="../../sistema/Clientes.php"; 
                    </script>
		        <?		
			}						
		}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo "Un cliente con el documento ".$_POST["rif3"]." ya se encuentra registrado en la base datos." ?>");
						location.href="../../sistema/Clientes.php"; 
                    </script>
		        <?									
		}		 
		 

	}
	
	if($_POST["action"]==6){
		
        echo "<div class='tabla-cabecera'>";
       	  	echo "<div class='tabla-cabecera-elemento' style='width:15%;'>Código";
            if($_POST["filtro_orden"]=="cliente.idcliente" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="cliente.idcliente" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}			
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('cliente.idcliente','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('cliente.idcliente','desc')></div>";
            echo "</div>";
          	echo "</div>"; 
			
       	  	echo "<div class='tabla-cabecera-elemento' style='width:19%;'>Ubicacion";
            if($_POST["filtro_orden"]=="ubicacion.ciudad" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="ubicacion.ciudad" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}			
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('ubicacion.ciudad','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('ubicacion.ciudad','desc')></div>";
            echo "</div>";
          	echo "</div>";  	
			
       	  	echo "<div class='tabla-cabecera-elemento' style='width:15%;'>Documento";
            if($_POST["filtro_orden"]=="cliente.documento" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="cliente.documento" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}			
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('cliente.documento','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('cliente.documento','desc')></div>";
            echo "</div>";
          	echo "</div>";					  
			     
       	  	echo "<div class='tabla-cabecera-elemento' style='width:48%; border-right:0px;'>Nombre del Cliente";
            if($_POST["filtro_orden"]=="cliente.nombre" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="cliente.nombre" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}							
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('cliente.nombre','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('cliente.nombre','desc')></div>";
            echo "</div>";
          	echo "</div>";                                                           
       echo " </div>";	
	   
	    echo "<input type='hidden' name='filtro' id='filtro' value='".$_POST["filtro_orden"]."' />";
        echo "<input type='hidden' name='orden' id='orden' value='".$_POST["orden"]."' />";
        echo "<input type='hidden' name='filtro2' id='filtro2' value='".$_POST["filtro_busqueda"]."' />";
        echo "<input type='hidden' name='clave_bus' id='clave_bus' value='".$_POST["clave"]."' />";
        
		    $sql_clientes="select cliente.idcliente, ubicacion.ciudad, cliente.documento, cliente.nombre from cliente, ubicacion where cliente.idubicacion=ubicacion.idubicacion ";
			
		if($_POST["filtro_busqueda"]!="0" && $_POST["clave"]!="" ){
			if($_POST["filtro_busqueda"]=="cliente.idcliente"){
				$sql_clientes = $sql_clientes." and cliente.idcliente = ".$_POST["clave"]." ";
			}else
			if($_POST["filtro_busqueda"]=="ubicacion.ciudad"){
				$sql_clientes = $sql_clientes." and ubicacion.ciudad ilike '%".$_POST["clave"]."%' ";
			}else
			if($_POST["filtro_busqueda"]=="cliente.documento"){
				$sql_clientes = $sql_clientes." and cliente.documento ilike '%".$_POST["clave"]."%' ";
			}else
			if($_POST["filtro_busqueda"]=="cliente.nombre"){
				$sql_clientes = $sql_clientes." and cliente.nombre ilike '%".$_POST["clave"]."%' ";
			}			
		}
		
		if($_POST["filtro_orden"]!=""){
			$sql_clientes = $sql_clientes." order by ".$_POST["filtro_orden"]." ".$_POST["orden"];
		}else{
			$sql_clientes = $sql_clientes." order by cliente.idcliente";
		}
				
			$result_clientes=pg_exec($con,$sql_clientes);
			if(pg_num_rows($result_clientes)>0){
				for($i=(($_POST["pagina"]*$_POST["muestra"])-$_POST["muestra"]);$i<pg_num_rows($result_clientes) && $i<($_POST["pagina"] * $_POST["muestra"]);$i++){
					$cliente=pg_fetch_array($result_clientes,$i);																																							
			    	echo "<div class='tabla-linea'>";
		        	echo "<div class='tabla-linea-elemento' style='width:15%;'>".Codigo("CLI",$cliente[0])."</div>";
					echo "<div class='tabla-linea-elemento' style='width:19%;'>".$cliente[1]."</div>";
					echo "<div class='tabla-linea-elemento' style='width:15%;'>".$cliente[2]."</div>";
		            echo "<div class='tabla-linea-elemento' style='width:37%;'>".$cliente[3]."</div>";
		            echo "<div class='tabla-linea-elemento' id='linea".$cliente[0]."' onclick='detalle(".$cliente[0].")' style='width:20px;background:url(../recursos/imagenes/list_metro.png) no-repeat center center; cursor:pointer;' title='Ver Detalle'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='editar(".$cliente[0].")' style='width:20px;background:url(../recursos/imagenes/edit.png) no-repeat center center; cursor:pointer;' title='Editar Registro'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='eliminarbanco(".$cliente[0].")' style='width:20px;background:url(../recursos/imagenes/delete.png) no-repeat center center; cursor:pointer; border-right:0px;' title='Eliminar Registro'></div>";
			        echo "</div>";
			        echo "<div class='tabla-detalle' id='detalle".$cliente[0]."' style='display: none'>";
		        	echo "<div class='tabla-detalle-contenedor'>										
					</div>";
			        echo "</div>";										
				}				
			}else{
				
			}	
			
            echo "<div class='tabla-pie'>";      	
            echo "<div class='tabla-pie-tabulador' title='Ir a la primera página' onclick=cambiar_pagina(1)><<</div>";
            echo "<div class='tabla-pie-tabulador' title='Ir una página atras' onclick=cambiar_pagina(2)><</div>";      
            echo "<div class='tabla-pie-actual'>Página <label id='pagina_actual'>".$_POST["pagina"]."</label>/<label id='total_paginas'>".ceil(pg_num_rows($result_clientes)/$_POST["muestra"])."</label></div>";
            echo "<div class='tabla-pie-tabulador' title='Ir una página adelante' onclick=cambiar_pagina(3)>></div>";
            echo "<div class='tabla-pie-tabulador' title='Ir a la última página' onclick=cambiar_pagina(4)>>></div>";          
        	
            
            echo "<div class='tabla-pie-elemento'>";
            echo "<div class='tabla-pie-elemento-etiqueta'>Ir a la Página</div>";
            echo "<div class='tabla-pie-elemento-select'>";
            echo "<select name='selector_pagina' id='selector_pagina' onchange='paginar()'>";
						    $indice= ceil(pg_num_rows($result_clientes)/$_POST["muestra"]);
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
			if(pg_num_rows($result_clientes)>=($_POST["pagina"]*$_POST["muestra"])){
				$limite=$_POST["pagina"]*$_POST["muestra"];
			}else{
				$limite=(($_POST["pagina"]-1)*$_POST["muestra"])+ ( pg_num_rows($result_clientes) - (($_POST["pagina"]-1)*$_POST["muestra"])) ;	
			}
			
            echo "<div class='tabla-pie-actual' style='float:right; margin-right:5px;'>Mostrando ".((($_POST["pagina"]*$_POST["muestra"])-$_POST["muestra"])+1)." - ".$limite." de ".pg_num_rows($result_clientes)."</div>";
        echo "</div>";    
    echo "</div>";								
	}
	
	if($_GET["action"]==7){ //Eliminar registro
		?>
		     <script type="text/javascript" language="javascript">location.href="../../sistema/Clientes.php"; </script>
		<?			
	}

  
?>