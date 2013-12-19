<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?

    require("funciones.php");
    $con=Conectarse();			
	
	if($_GET["action"]==1){ //Agregar Nueva Cuenta	   	  
		$con=Conectarse();
		$sql_consulta_cuentas = "select numerocuenta from cuenta;";
		$result_cuentas = pg_exec($con,$sql_consulta_cuentas);
		$bandera=0;
		for($i=0;$i<pg_num_rows($result_cuentas);$i++){
			$cuenta = pg_fetch_array($result_cuentas,$i);			
			if(strtolower($cuenta[0])==strtolower($_POST["numero1"])){
				$bandera=1;
				break;
			}
		}
		
		
		if($bandera==0){
			$sql_insert_cuenta="";
			
			if($_POST["propietario1"]=="Empresa"){				
				$sql_insert_cuenta="insert into cuenta values(nextval('cuenta_idcuenta_seq'),'".$_POST["banco1"]."','".$_POST["propietario1"]."','".$_POST["cuenta1"]."','".$_POST["numero1"]."','".$_POST["titular1"]."','".$_POST["asociado1"]."',now(),'".$_POST["estatus1"]."',null,null,null)";				
			}
			if($_POST["propietario1"]=="Ruta"){
				$sql_ruta="select * from ruta where idruta='".$_POST["asociado1"]."'";
				$result_ruta=pg_exec($con,$sql_ruta);
				$ruta=pg_fetch_array($result_ruta,0);
				$sql_insert_cuenta="insert into cuenta values(nextval('cuenta_idcuenta_seq'),'".$_POST["banco1"]."','".$_POST["propietario1"]."','".$_POST["cuenta1"]."','".$_POST["numero1"]."','".$_POST["titular1"]."','".$ruta[1]."',now(),'".$_POST["estatus1"]."','".$_POST["asociado1"]."',null,null)";				
			}
			if($_POST["propietario1"]=="Productor"){
				$sql_productor="select * from productor where idproductor='".$_POST["asociado1"]."'";
				$result_productor=pg_exec($con,$sql_productor);
				$productor=pg_fetch_array($result_productor,0);				
				$sql_insert_cuenta="insert into cuenta values(nextval('cuenta_idcuenta_seq'),'".$_POST["banco1"]."','".$_POST["propietario1"]."','".$_POST["cuenta1"]."','".$_POST["numero1"]."','".$_POST["titular1"]."','".$productor[3]."',now(),'".$_POST["estatus1"]."',null,null,'".$_POST["asociado1"]."')";				
			}
			if($_POST["propietario1"]=="Cliente"){
				$sql_cliente="select * from cliente where idcliente='".$_POST["asociado1"]."'";
				$result_cliente=pg_exec($con,$sql_cliente);
				$cliente=pg_fetch_array($result_cliente,0);									
				$sql_insert_cuenta="insert into cuenta values(nextval('cuenta_idcuenta_seq'),'".$_POST["banco1"]."','".$_POST["propietario1"]."','".$_POST["cuenta1"]."','".$_POST["numero1"]."','".$_POST["titular1"]."','".$cliente[1]."',now(),'".$_POST["estatus1"]."',null,'".$_POST["asociado1"]."',null)";				
			}						
			
			
			$result_insert_cuenta=pg_exec($con,$sql_insert_cuenta);						
			if($result_insert_cuenta!=NULL){
				?>                    
		        	<script type="text/javascript" language="javascript"> 
						alert("Cuenta Agregada Satisfactoriamente.");
						location.href="../../sistema/CuentasBancarias.php"; 
                    </script>
		        <?			
			}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("Ocurrio un problema agragando la cuenta.");
						location.href="../../sistema/CuentasBancarias.php";                     
                    </script>
		        <?		
			}						
		}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo "La cuenta numero ".$_POST["numero1"]." ya se encuentra registrado en la base datos." ?>");
						location.href="../../sistema/CuentasBancarias.php"; 						
                    </script>
		        <?									
		}	  
	}
	
	if($_POST["action"]==2){  //ver detalle de Cuenta
	     $sql_select_cuenta="select * from cuenta where idcuenta='".$_POST["identificador"]."'";
		 $result_select_cuenta=pg_exec($con,$sql_select_cuenta);
		 $cuenta=pg_fetch_array($result_select_cuenta,0);
	?>
		<div class='tabla-detalle-contenedor'>  
    		<div class="detalle-titulo">Detalle de Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
               <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:15%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="codigo2" name="codigo2" value="<?php echo Codigo("CUE",$cuenta[0]); ?>" class="entrada" readonly='readonly' style="width:97%; background:#EFEFEF" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Banco (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el banco..." name="banco2" id="banco2"  class="chzn-select" style="width:100%;">
                                <option value=""></option>
                                <?php
								    $con=Conectarse();
									$sql_banco="select * from banco order by nombre;";
									$result_banco=pg_exec($con,$sql_banco);
									for($i=0;$i<pg_num_rows($result_banco);$i++){
										$banco=pg_fetch_array($result_banco,$i);
										if($cuenta[1]==$banco[0]){
											echo "<option selected='selected' value='".$banco[0]."'>".$banco[1]."</option>";
										}else{
											echo "<option value='".$banco[0]."'>".$banco[1]."</option>";
										}																				
									}									   									 								
								?>
                            </select>                           
                        </div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Propietario</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el tipo de propietario..." name="propietario2" id="propietario2"  class="chzn-select" style="width:100%;">
                                <option value=""></option>
                                <?php
								    if($cuenta[2]=="Empresa"){
										echo "<option value='Empresa' selected='selected'>Empresa</option>"; 
										echo "<option value='Ruta'>Ruta</option>";
										echo "<option value='Productor'>Productor</option>"; 
										echo "<option value='Cliente'>Cliente</option>";
									}
								    if($cuenta[2]=="Ruta"){
										echo "<option value='Empresa'>Empresa</option>"; 
										echo "<option value='Ruta' selected='selected'>Ruta</option>";
										echo "<option value='Productor'>Productor</option>"; 
										echo "<option value='Cliente'>Cliente</option>";
									}
								    if($cuenta[2]=="Productor"){
										echo "<option value='Empresa'>Empresa</option>"; 
										echo "<option value='Ruta'>Ruta</option>";
										echo "<option value='Productor' selected='selected'>Productor</option>"; 
										echo "<option value='Cliente'>Cliente</option>";
									}
								    if($cuenta[2]=="Cliente"){
										echo "<option value='Empresa' >Empresa</option>"; 
										echo "<option value='Ruta'>Ruta</option>";
										echo "<option value='Productor'>Productor</option>"; 
										echo "<option value='Cliente' selected='selected'>Cliente</option>";
									}																											
								?>
                            </select>                        
                        </div>
                    </div>  
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:98%;">Cuenta (*)</div>
  						<div style="font-size:8px; width:98%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el tipo de persona..." name="cuenta2" id="cuenta2"  class="chzn-select" style="width:100%;">
                                <option value=""></option>
                                <?php
								    if($cuenta[3]=="Corriente"){
										echo "<option value='Corriente' selected='selected'>Corriente</option>"; 
										echo "<option value='Ahorro'>Ahorro</option>"; 										
									}else{
										echo "<option value='Corriente'>Corriente</option>"; 
										echo "<option value='Ahorro' selected='selected'>Ahorro</option>"; 										
									}
 									 								
								?>
                            </select> 
					    </div>
                    </div> 
                                                                                                
                </div>
                
                
                
                
                
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:15%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="fecha2" name="fecha2" class="entrada" readonly='readonly' style="width:97%; background:#EFEFEF" value="<?php echo $cuenta[7]; ?>" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Titular de la Cuenta (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        <input type="text" id="titular2" name="titular2" value="<?php echo $cuenta[5]; ?>" class="entrada" style="width:100%;" />
                        </div>
                    </div> 

                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:98%;">Asociado a (*)</div>
  						<div style="font-size:8px; width:98%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el tipo de persona..." name="asociado2" id="asociado2"  class="chzn-select" style="width:100%;">
                                <option value=""></option>
                                <?php
									echo "<option value='Productos Agua Linda' selected='selected'>Productos Agua Linda</option>";  									 								
								?>
                            </select> 
					    </div>
                    </div> 
                                                                                               
                </div>                
                <div class="detalle-linea">
					<div class="detalle-linea-elemento" style="width:15%;">
                    
                    </div>
                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Numero de Cuenta (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        <input type="text" id="numero2" value="<?php echo $cuenta[4]; ?>" name="numero2" class="entrada" style="width:100%;" />
                        </div>
                    </div>   
                    
                	<div class="detalle-linea-elemento" style="width:22%; ">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Estatus (*)</div>
  						<div id="estatus2" style="font-size:8px; width:98%; margin-top:1px;" class="detalle-linea-elemento-abajo">
						    <input type="radio" id="radio1" name="estatus2" value="1" checked="checked" /><label for="radio1">Habilitado</label>
						    <input type="radio" id="radio2" name="estatus2" value="2"  /><label for="radio2">Deshabilitado</label>
					    </div>
                    </div>                    
                                                       
                </div>
                <div class="detalle-indica">Los campos indicados con (*) son Obligatotios</div>               
                                              
	    </div>
	<?	    	
	}
	
	if($_POST["action"]==3){  //Generar Formulario Para Registro
		?>                                
			<div class='tabla-detalle-contenedor'>  
                <form name="formagregacuenta" id="formagregacuenta" method="post" action="../recursos/funciones/ajaxCuentasBancarias.php?action=1" >
    			<div class="detalle-titulo">Agregar Nuevo Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:15%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="codigo1" name="codigo1" class="entrada" disabled="disabled" style="width:97%;" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Banco (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el banco..." name="banco1" id="banco1"  class="chzn-select" style="width:100%;">
                                <option value=""></option>
                                <?php
								    $con=Conectarse();
									$sql_banco="select * from banco order by nombre;";
									$result_banco=pg_exec($con,$sql_banco);
									for($i=0;$i<pg_num_rows($result_banco);$i++){
										$banco=pg_fetch_array($result_banco,$i);
										echo "<option value='".$banco[0]."'>".$banco[1]."</option>";
									}
									 
  									 								
								?>
                            </select>                           
                        </div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Propietario</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el tipo de propietario..." name="propietario1" id="propietario1"  class="chzn-select" style="width:100%;" onchange="asociadoa(1)">
                                <option value=""></option>
                                <?php
									echo "<option value='Empresa' selected='selected'>Empresa</option>"; 
									echo "<option value='Ruta'>Ruta</option>";
									echo "<option value='Productor'>Productor</option>"; 
									echo "<option value='Cliente'>Cliente</option>";  									 								
								?>
                            </select>                        
                        </div>
                    </div>  
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:98%;">Cuenta (*)</div>
  						<div style="font-size:8px; width:98%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el tipo de persona..." name="cuenta1" id="cuenta1"  class="chzn-select" style="width:100%;">
                                <option value=""></option>
                                <?php
									echo "<option value='Corriente' selected='selected'>Corriente</option>"; 
									echo "<option value='Ahorro'>Ahorro</option>";  									 								
								?>
                            </select> 
					    </div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:8%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;"></div>
                        <div class="detalle-linea-elemento-abajo" style="font-size:8px; width:100%;"><input type="button" value="Guardar" onclick="agregarcuenta()" /></div>
                    </div>                                                                                                
                </div>
                
                
                
                
                
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:15%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="fecha1" name="fecha1" class="entrada" disabled="disabled" style="width:97%;" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Titular de la Cuenta (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        <input type="text" id="titular1" name="titular1" class="entrada" style="width:100%;" />
                        </div>
                    </div> 

                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:98%;">Asociado a (*)</div>
  						<div style="font-size:8px; width:98%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                        		<div id="panelasocia1">
                        	<select data-placeholder="Seleccione el tipo de persona..." name="asociado1" id="asociado1"  class="chzn-select" style="width:100%;">
                                <option value=""></option>
                                <?php
									echo "<option value='Productos Agua Linda' selected='selected'>Productos Agua Linda</option>";  									 								
								?>
                            </select> 
                            	</div>
					    </div>
                    </div> 
                                                                                               
                </div>                
                <div class="detalle-linea">
					<div class="detalle-linea-elemento" style="width:15%;">
                    
                    </div>
                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Numero de Cuenta (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        <input type="text" id="numero1" name="numero1" class="entrada" style="width:100%;" />
                        </div>
                    </div>   
                    
                	<div class="detalle-linea-elemento" style="width:22%; ">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Estatus (*)</div>
  						<div id="estatus1" style="font-size:8px; width:98%; margin-top:1px;" class="detalle-linea-elemento-abajo">
						    <input type="radio" id="radio1" name="estatus1" value="1" checked="checked" /><label for="radio1">Habilitado</label>
						    <input type="radio" id="radio2" name="estatus1" value="2"  /><label for="radio2">Deshabilitado</label>
					    </div>
                    </div>                    
                                                       
                </div>
                                                                                
                <div class="detalle-indica">Los campos indicados con (*) son Obligatotios</div>                                  
	        	</form>
				 
            </div>                        
               
        <?
	}
	
	
	if($_POST["action"]==4){  //formulario para editar registro
	     $sql_select_cuenta="select * from cuenta where idcuenta='".$_POST["identificador"]."'";
		 $result_select_cuenta=pg_exec($con,$sql_select_cuenta);
		 $cuenta=pg_fetch_array($result_select_cuenta,0);
	?>
         
		<div class='tabla-detalle-contenedor'>  
        	<form name="formeditarcuenta" id="formeditarcuenta" method="post" action="../recursos/funciones/ajaxCuentasBancarias.php?action=5"  >
    			<div class="detalle-titulo">Editar Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:15%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="codigo3" name="codigo3" value="<?php echo Codigo("CUE",$cuenta[0]); ?>" class="entrada" readonly='readonly' style="width:97%; background:#EFEFEF" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Banco (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el banco..." name="banco3" id="banco3"  class="chzn-select" style="width:100%;">
                                <option value=""></option>
                                <?php
								    $con=Conectarse();
									$sql_banco="select * from banco order by nombre;";
									$result_banco=pg_exec($con,$sql_banco);
									for($i=0;$i<pg_num_rows($result_banco);$i++){
										$banco=pg_fetch_array($result_banco,$i);
										if($cuenta[1]==$banco[0]){
											echo "<option selected='selected' value='".$banco[0]."'>".$banco[1]."</option>";
										}else{
											echo "<option value='".$banco[0]."'>".$banco[1]."</option>";
										}																				
									}									   									 								
								?>
                            </select>                           
                        </div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Propietario</div>
                        <div class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el tipo de propietario..." name="propietario3" id="propietario3"  class="chzn-select" style="width:100%;" onchange="asociadoa(3)">
                                <option value=""></option>
                                <?php
								    if($cuenta[2]=="Empresa"){
										echo "<option value='Empresa' selected='selected'>Empresa</option>"; 
										echo "<option value='Ruta'>Ruta</option>";
										echo "<option value='Productor'>Productor</option>"; 
										echo "<option value='Cliente'>Cliente</option>";
									}
								    if($cuenta[2]=="Ruta"){
										echo "<option value='Empresa'>Empresa</option>"; 
										echo "<option value='Ruta' selected='selected'>Ruta</option>";
										echo "<option value='Productor'>Productor</option>"; 
										echo "<option value='Cliente'>Cliente</option>";
									}
								    if($cuenta[2]=="Productor"){
										echo "<option value='Empresa'>Empresa</option>"; 
										echo "<option value='Ruta'>Ruta</option>";
										echo "<option value='Productor' selected='selected'>Productor</option>"; 
										echo "<option value='Cliente'>Cliente</option>";
									}
								    if($cuenta[2]=="Cliente"){
										echo "<option value='Empresa' >Empresa</option>"; 
										echo "<option value='Ruta'>Ruta</option>";
										echo "<option value='Productor'>Productor</option>"; 
										echo "<option value='Cliente' selected='selected'>Cliente</option>";
									}																											
								?>
                            </select>                        
                        </div>
                    </div>  
                	<div class="detalle-linea-elemento" style="width:17%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:98%;">Cuenta (*)</div>
  						<div style="font-size:8px; width:98%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                        	<select data-placeholder="Seleccione el tipo de persona..." name="cuenta3" id="cuenta3"  class="chzn-select" style="width:100%;">
                                <option value=""></option>
                                <?php
								    if($cuenta[3]=="Corriente"){
										echo "<option value='Corriente' selected='selected'>Corriente</option>"; 
										echo "<option value='Ahorro'>Ahorro</option>"; 										
									}else{
										echo "<option value='Corriente'>Corriente</option>"; 
										echo "<option value='Ahorro' selected='selected'>Ahorro</option>"; 										
									}
 									 								
								?>
                            </select> 
					    </div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:8%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;"></div>
                        <div class="detalle-linea-elemento-abajo" style="font-size:8px; width:100%;"><input type="button" value="Guardar" onclick="editarcuenta()" /></div>
                    </div>                                                                                                
                </div>
                
                
                
                
                
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:15%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="fecha3" name="fecha3" class="entrada" readonly='readonly' style="width:97%; background:#EFEFEF" value="<?php echo $cuenta[7]; ?>" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Titular de la Cuenta (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        <input type="text" id="titular3" name="titular3" value="<?php echo $cuenta[5]; ?>" class="entrada" style="width:100%;" />
                        </div>
                    </div> 

                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:98%;">Asociado a (*)</div>                        
  						<div style="font-size:8px; width:98%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                        <div id="panelasocia3">
                        	<select data-placeholder="Seleccione el tipo de persona..." name="asociado3" id="asociado3"  class="chzn-select" style="width:100%;">
                                <option value=""></option>
                                <?php
								 	if($cuenta[2]=="Empresa"){
										echo "<option value='Productos Agua Linda' selected='selected'>Productos Agua Linda</option>";
									}else
								 	if($cuenta[2]=="Ruta"){
										$sql_rutas="select * from ruta order by nombreruta;";
										$result_rutas=pg_exec($con,$sql_rutas);
										for($i=0;$i<pg_num_rows($result_rutas);$i++){
											$ruta=pg_fetch_array($result_rutas);
											if($ruta[0]==$cuenta[9]){
												echo "<option value='".$ruta[0]."' selected='selected'>".$ruta[1]."</option>";		
											}else{
												echo "<option value='".$ruta[0]."' >".$ruta[1]."</option>";
											}
										}
									}else									
								 	if($cuenta[2]=="Productor"){
										$sql_productores="select * from productor order by nombreproductor;";
										$result_productores=pg_exec($con,$sql_productores);
										for($i=0;$i<pg_num_rows($result_productores);$i++){
											$productor=pg_fetch_array($result_productores);
											if($productor[0]==$cuenta[11]){
												echo "<option value='".$productor[0]."' selected='selected'>".$productor[3]."</option>";		
											}else{
												echo "<option value='".$productor[0]."' >".$productor[3]."</option>";
											}
										}
									}else									
								 	if($cuenta[2]=="Cliente"){
										$sql_clientes="select * from cliente order by nombre;";
										$result_clientes=pg_exec($con,$sql_clientes);
										for($i=0;$i<pg_num_rows($result_clientes);$i++){
											$cliente=pg_fetch_array($result_clientes);
											if($cliente[0]==$cuenta[10]){
												echo "<option value='".$cliente[0]."' selected='selected'>".$cliente[1]."</option>";		
											}else{
												echo "<option value='".$cliente[0]."' >".$cliente[1]."</option>";
											}
										}
									}									  									 								
								?>
                            </select>
                        </div> 
					    </div>
                    </div> 
                                                                                               
                </div>                
                <div class="detalle-linea">
					<div class="detalle-linea-elemento" style="width:15%;">
                    
                    </div>
                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Numero de Cuenta (*)</div>
                        <div class="detalle-linea-elemento-abajo">
                        <input type="text" id="numero3" value="<?php echo $cuenta[4]; ?>" name="numero3" class="entrada" style="width:100%;" />
                        </div>
                    </div>   
                    
                	<div class="detalle-linea-elemento" style="width:22%; ">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Estatus (*)</div>
  						<div id="estatus3" style="font-size:8px; width:98%; margin-top:1px;" class="detalle-linea-elemento-abajo">
						    <input type="radio" id="radio1" name="estatus3" value="1" checked="checked" /><label for="radio1">Habilitado</label>
						    <input type="radio" id="radio2" name="estatus3" value="2"  /><label for="radio2">Deshabilitado</label>
					    </div>
                    </div>                    
                                                       
                </div>
                <div class="detalle-indica">Los campos indicados con (*) son Obligatotios</div>                                  
	        </form>
            </div>
            
	<?	    	
	}	
	
	if($_GET["action"]==5){ /*Editar Registro*/	
		$con=Conectarse();
		$sql_consulta_numeros = "select numerocuenta from cuenta where idcuenta!= '".InversaCodigo($_POST["codigo3"])."';";
		$result_numeros = pg_exec($con,$sql_consulta_numeros);
		$bandera=0;
		for($i=0;$i<pg_num_rows($result_numeros);$i++){
			$numero = pg_fetch_array($result_numeros,$i);			
			if(strtolower($numero[0])==strtolower($_POST["numero3"])){
				$bandera=1;
				break;
			}
		}
				
		
		if($bandera==0){
			
			$sql_update_cuenta="";
			
		    if($_POST["propietario3"]=="Empresa"){
				$sql_update_cuenta="update cuenta set idbanco='".$_POST["banco3"]."', tipopropietario='".$_POST["propietario3"]."', asociado='".$_POST["asociado3"]."', anombrede='".$_POST["titular3"]."', numerocuenta='".$_POST["numero3"]."', tipocuenta='".$_POST["cuenta3"]."', estatus='".$_POST["estatus3"]."' where idcuenta ='".InversaCodigo($_POST["codigo3"])."' ";				
			}
		    if($_POST["propietario3"]=="Ruta"){
				$sql_ruta="select * from ruta where idruta='".$_POST["asociado3"]."'";
				$result_ruta=pg_exec($con,$sql_ruta);
				$ruta=pg_fetch_array($result_ruta,0);
				
				$sql_update_cuenta="update cuenta set idbanco='".$_POST["banco3"]."', tipopropietario='".$_POST["propietario3"]."', asociado='".$ruta[1]."', anombrede='".$_POST["titular3"]."', numerocuenta='".$_POST["numero3"]."', tipocuenta='".$_POST["cuenta3"]."', estatus='".$_POST["estatus3"]."', idruta='".$_POST["asociado3"]."', idproductor=null, idcliente=null where idcuenta ='".InversaCodigo($_POST["codigo3"])."' ";								
			}
		    if($_POST["propietario3"]=="Productor"){
				$sql_prodcutor="select * from productor where idproductor='".$_POST["asociado3"]."'";
				$result_productor=pg_exec($con,$sql_prodcutor);
				$productor=pg_fetch_array($result_productor,0);
				
				$sql_update_cuenta="update cuenta set idbanco='".$_POST["banco3"]."', tipopropietario='".$_POST["propietario3"]."', asociado='".$productor[3]."', anombrede='".$_POST["titular3"]."', numerocuenta='".$_POST["numero3"]."', tipocuenta='".$_POST["cuenta3"]."', estatus='".$_POST["estatus3"]."', idruta=null, idproductor='".$_POST["asociado3"]."', idcliente=null where idcuenta ='".InversaCodigo($_POST["codigo3"])."' ";				
			}
		    if($_POST["propietario3"]=="Cliente"){
				$sql_cliente="select * from cliente where idcliente='".$_POST["asociado3"]."'";
				$result_cliente=pg_exec($con,$sql_cliente);
				$cliente=pg_fetch_array($result_cliente,0);
				
				$sql_update_cuenta="update cuenta set idbanco='".$_POST["banco3"]."', tipopropietario='".$_POST["propietario3"]."', asociado='".$cliente[1]."', anombrede='".$_POST["titular3"]."', numerocuenta='".$_POST["numero3"]."', tipocuenta='".$_POST["cuenta3"]."', estatus='".$_POST["estatus3"]."', idruta=null, idproductor=null, idcliente='".$_POST["asociado3"]."' where idcuenta ='".InversaCodigo($_POST["codigo3"])."' ";				
			}									
			

			
					
			$result_update_cuenta=pg_exec($con,$sql_update_cuenta);			
			if($result_update_cuenta!=NULL){
				?>                	
		        	<script type="text/javascript" language="javascript">
						alert("Cuenta Editada Satisfactoriamente.");
						location.href="../../sistema/CuentasBancarias.php"; 
                    </script>
		        <?			
			}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("Ocurrio un problema Editando La Cuenta");
						location.href="../../sistema/CuentasBancarias.php"; 
                    </script>
		        <?		
			}						
		}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo "La cuenta ".$_POST["numero1"]." ya se encuentra registrada en la base datos." ?>");
						location.href="../../sistema/CuentasBancarias.php"; 
                    </script>
		        <?									
		}		 
		 

	}
	
	if($_POST["action"]==6){
		
        echo "<div class='tabla-cabecera'>";
       	  	echo "<div class='tabla-cabecera-elemento' style='width:10%;'>Código";
            if($_POST["filtro_orden"]=="cuenta.idcuenta" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="cuenta.idcuenta" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}			
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('cuenta.idcuenta','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('cuenta.idcuenta','desc')></div>";
            echo "</div>";
          	echo "</div>";
			
       	  	echo "<div class='tabla-cabecera-elemento' style='width:9%;'>Tipo";
            if($_POST["filtro_orden"]=="cuenta.tipopropietario" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="cuenta.tipopropietario" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}			
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('cuenta.tipopropietario','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('cuenta.tipopropietario','desc')></div>";
            echo "</div>";
          	echo "</div>"; 	
			
       	  	echo "<div class='tabla-cabecera-elemento' style='width:19%;'>Asociado";
            if($_POST["filtro_orden"]=="cuenta.asociado" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="cuenta.asociado" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}			
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('cuenta.asociado','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('cuenta.asociado','desc')></div>";
            echo "</div>";
          	echo "</div>"; 		
			
       	  	echo "<div class='tabla-cabecera-elemento' style='width:18%;'>Banco";
            if($_POST["filtro_orden"]=="banco.nombre" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="banco.nombre" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}			
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('banco.nombre','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('banco.nombre','desc')></div>";
            echo "</div>";
          	echo "</div>"; 	
			
       	  	echo "<div class='tabla-cabecera-elemento' style='width:9%;'>Cuenta";
            if($_POST["filtro_orden"]=="cuenta.tipocuenta" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="cuenta.tipocuenta" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}			
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('cuenta.tipocuenta','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('cuenta.tipocuenta','desc')></div>";
            echo "</div>";
          	echo "</div>";	
			
       	  	echo "<div class='tabla-cabecera-elemento' style='width:20%;'>Numero de Cuenta";
            if($_POST["filtro_orden"]=="cuenta.numerocuenta" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="cuenta.numerocuenta" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}			
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('cuenta.numerocuenta','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('cuenta.numerocuenta','desc')></div>";
            echo "</div>";
          	echo "</div>";													   
			
						                                                                
       echo " </div>";	
	   
	    echo "<input type='hidden' name='filtro' id='filtro' value='".$_POST["filtro_orden"]."' />";
        echo "<input type='hidden' name='orden' id='orden' value='".$_POST["orden"]."' />";
        echo "<input type='hidden' name='filtro2' id='filtro2' value='".$_POST["filtro_busqueda"]."' />";
        echo "<input type='hidden' name='clave_bus' id='clave_bus' value='".$_POST["clave"]."' />";
        
		$sql_cuentas="select cuenta.idcuenta, cuenta.tipopropietario, cuenta.asociado, banco.nombre, cuenta.tipocuenta, cuenta.numerocuenta from cuenta,banco where cuenta.idbanco = banco.idbanco ";
		if($_POST["filtro_busqueda"]!="0" && $_POST["clave"]!="" ){
			if($_POST["filtro_busqueda"]=="cuenta.idcuenta"){
				$sql_cuentas = $sql_cuentas." and cuenta.idcuenta = ".$_POST["clave"]." ";
			}else
			if($_POST["filtro_busqueda"]=="cuenta.tipopropietario"){
				$sql_cuentas = $sql_cuentas." and cuenta.tipopropietario ilike '%".$_POST["clave"]."%' ";
			}else
			if($_POST["filtro_busqueda"]=="cuenta.asociado"){
				$sql_cuentas = $sql_cuentas." and cuenta.asociado ilike '%".$_POST["clave"]."%' ";
			}else
			if($_POST["filtro_busqueda"]=="banco.nombre"){
				$sql_cuentas = $sql_cuentas." and banco.nombre ilike '%".$_POST["clave"]."%' ";
			}else
			if($_POST["filtro_busqueda"]=="cuenta.tipocuenta"){
				$sql_cuentas = $sql_cuentas." and cuenta.tipocuenta ilike '%".$_POST["clave"]."%' ";
			}else
			if($_POST["filtro_busqueda"]=="cuenta.numerocuenta"){
				$sql_cuentas = $sql_cuentas." and cuenta.numerocuenta ilike '%".$_POST["clave"]."%' ";
			}			
		}
		
		if($_POST["filtro_orden"]!=""){
			$sql_cuentas = $sql_cuentas." order by ".$_POST["filtro_orden"]." ".$_POST["orden"];
		}else{
			$sql_cuentas = $sql_cuentas." order by cuenta.idcuenta";
		}
	
			$result_cuenta=pg_exec($con,$sql_cuentas);
			if(pg_num_rows($result_cuenta)>0){
				for($i=(($_POST["pagina"]*$_POST["muestra"])-$_POST["muestra"]);$i<pg_num_rows($result_cuenta) && $i<($_POST["pagina"] * $_POST["muestra"]);$i++){
					$cuenta=pg_fetch_array($result_cuenta,$i);																																							
			    	echo "<div class='tabla-linea'>";
		        	echo "<div class='tabla-linea-elemento' style='width:10%;'>".Codigo("CUE",$cuenta[0])."</div>";
		            echo "<div class='tabla-linea-elemento' style='width:9%;'>".$cuenta[1]."</div>";
					echo "<div class='tabla-linea-elemento' style='width:19%;'>".$cuenta[2]."</div>";
					echo "<div class='tabla-linea-elemento' style='width:18%;'>".$cuenta[3]."</div>";
					echo "<div class='tabla-linea-elemento' style='width:9%;'>".$cuenta[4]."</div>";
					echo "<div class='tabla-linea-elemento' style='width:20%;'>".$cuenta[5]."</div>";
		            echo "<div class='tabla-linea-elemento' id='linea".$cuenta[0]."' onclick='detalle(".$cuenta[0].")' style='width:20px;background:url(../recursos/imagenes/list_metro.png) no-repeat center center; cursor:pointer;' title='Ver Detalle'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='editar(".$cuenta[0].")' style='width:20px;background:url(../recursos/imagenes/edit.png) no-repeat center center; cursor:pointer;' title='Editar Registro'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='eliminarcuenta(".$cuenta[0].")' style='width:20px;background:url(../recursos/imagenes/delete.png) no-repeat center center; cursor:pointer; border-right:0px;' title='Eliminar Registro'></div>";
			        echo "</div>";
			        echo "<div class='tabla-detalle' id='detalle".$cuenta[0]."' style='display: none'>";
		        	echo "<div class='tabla-detalle-contenedor'>										
					</div>";
			        echo "</div>";											
				}				
			}else{
				
			}	
			
            echo "<div class='tabla-pie'>";      	
            echo "<div class='tabla-pie-tabulador' title='Ir a la primera página' onclick=cambiar_pagina(1)><<</div>";
            echo "<div class='tabla-pie-tabulador' title='Ir una página atras' onclick=cambiar_pagina(2)><</div>";      
            echo "<div class='tabla-pie-actual'>Página <label id='pagina_actual'>".$_POST["pagina"]."</label>/<label id='total_paginas'>".ceil(pg_num_rows($result_cuenta)/$_POST["muestra"])."</label></div>";
            echo "<div class='tabla-pie-tabulador' title='Ir una página adelante' onclick=cambiar_pagina(3)>></div>";
            echo "<div class='tabla-pie-tabulador' title='Ir a la última página' onclick=cambiar_pagina(4)>>></div>";          
        	
            
            echo "<div class='tabla-pie-elemento'>";
            echo "<div class='tabla-pie-elemento-etiqueta'>Ir a la Página</div>";
            echo "<div class='tabla-pie-elemento-select'>";
            echo "<select name='selector_pagina' id='selector_pagina' onchange='paginar()'>";
						    $indice= ceil(pg_num_rows($result_cuenta)/$_POST["muestra"]);
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
			if(pg_num_rows($result_cuenta)>=($_POST["pagina"]*$_POST["muestra"])){
				$limite=$_POST["pagina"]*$_POST["muestra"];
			}else{
				$limite=(($_POST["pagina"]-1)*$_POST["muestra"])+ ( pg_num_rows($result_cuenta) - (($_POST["pagina"]-1)*$_POST["muestra"])) ;	
			}
			
            echo "<div class='tabla-pie-actual' style='float:right; margin-right:5px;'>Mostrando ".((($_POST["pagina"]*$_POST["muestra"])-$_POST["muestra"])+1)." - ".$limite." de ".pg_num_rows($result_cuenta)."</div>";
        echo "</div>";    
    echo "</div>";								
	}
	
	if($_GET["action"]==7){ //Eliminar registro
		?>
		     <script type="text/javascript" language="javascript">location.href="../../sistema/CuentasBancarias.php"; </script>
		<?			
	}
	
	if($_POST["action"]==8){
			if($_POST["tipo"]=="Empresa"){
				?>
                 <select data-placeholder="Seleccione el tipo de persona..." name="asociado<?php echo $_POST["indice"]; ?>" id="asociado<?php echo $_POST["indice"]; ?>"  class="chzn-select" style="width:100%;">
                    <option value=""></option>
                        <?php
							echo "<option value='Productos Agua Linda' selected='selected'>Productos Agua Linda</option>";  									 						?>
                 </select> 				
               <?
			}
			if($_POST["tipo"]=="Ruta"){
				?>
                 <select data-placeholder="Seleccione el nombre de la ruta..." name="asociado<?php echo $_POST["indice"]; ?>" id="asociado<?php echo $_POST["indice"]; ?>"  class="chzn-select" style="width:100%;">
                    <option value=""></option>
                        <?php
							$sql_listaRutas="select * from ruta order by nombreruta;";
							$result_listaRutas=pg_exec($con,$sql_listaRutas);
							for($i=0;$i<pg_num_rows($result_listaRutas);$i++){
								$ruta=pg_fetch_array($result_listaRutas,$i);
								echo "<option value='".$ruta[0]."'>".$ruta[1]."</option>";
							}
						?>
                 </select> 				
               <?				
			}
			if($_POST["tipo"]=="Productor"){
				?>
                 <select data-placeholder="Seleccione el nombre del productor..." name="asociado<?php echo $_POST["indice"]; ?>" id="asociado<?php echo $_POST["indice"]; ?>"  class="chzn-select" style="width:100%;">
                    <option value=""></option>
                        <?php
							$sql_listaProductores="select * from productor order by nombreproductor;";
							$result_listaProductores=pg_exec($con,$sql_listaProductores);
							for($i=0;$i<pg_num_rows($result_listaProductores);$i++){
								$productor=pg_fetch_array($result_listaProductores,$i);
								echo "<option value='".$productor[0]."'>".$productor[3]."</option>";
							}
						?>
                 </select> 				
               <?				
			}
			if($_POST["tipo"]=="Cliente"){
				?>
                 <select data-placeholder="Seleccione el nombre del cliente..." name="asociado<?php echo $_POST["indice"]; ?>" id="asociado<?php echo $_POST["indice"]; ?>"  class="chzn-select" style="width:100%;">
                    <option value=""></option>
                        <?php
							$sql_listaClientes="select * from cliente order by nombre;";
							$result_listaClientes=pg_exec($con,$sql_listaClientes);
							for($i=0;$i<pg_num_rows($result_listaClientes);$i++){
								$cliente=pg_fetch_array($result_listaClientes,$i);
								echo "<option value='".$cliente[0]."'>".$cliente[1]."</option>";
							}
						?>
                 </select> 				
               <?				
			}									
	}

  
?>