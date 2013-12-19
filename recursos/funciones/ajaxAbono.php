<?php

	require("funciones.php");
    $con=Conectarse();		

	if($_POST["action"]==1){
		?>
        	<div class="elemento_contiene" style="width:16%">
            	<div class="elemento_arriba">Banco de Origen</div>
                <div class="elemento_abajo">
                     <select data-placeholder="Seleccione el Banco..." disabled="disabled"  name="banco" id="banco" style="width:100%;" class="chzn-select" >
                          <option value=""></option>
                          <?
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
            
        	<div class="elemento_contiene" style="width:22%">
            	<div class="elemento_arriba">Cuenta Destino</div>
                <div class="elemento_abajo">
                     <select data-placeholder="Seleccione la cuenta destino..." disabled="disabled"  name="cuenta" id="cuenta" style="width:100%;" class="chzn-select" >
                          <option value=""></option>
                          <?
								$con=Conectarse();
								$sql_cuenta="select * from cuenta where tipopropietario='Empresa' order by numerocuenta;";
								$result_cuenta=pg_exec($con,$sql_cuenta);
								for($i=0;$i<pg_num_rows($result_cuenta);$i++){
									$cuenta=pg_fetch_array($result_cuenta,$i);
									$sql_banco="select * from banco where idbanco=".$cuenta[1]."";
									$result_banco=pg_exec($con,$sql_banco);
									$banco=pg_fetch_array($result_banco);
									echo "<option value='".$cuenta[0]."'> ".$banco[1]." ".$cuenta[4]."</option>";																			
								}
						 ?>	
                      </select>                  
                </div>
            </div>                                             
            
        	<div class="elemento_contiene" style="width:8%">
            	<div class="elemento_arriba">Monto</div>
                <div class="elemento_abajo">
					<input type="text" name="monto" id="monto" value="" style="width:100%; text-align:right; padding-right:3%; font-family: 'Oswald', sans-serif; height:25px; font-size:12px;"  />               
                </div>
            </div>
            
        	<div class="elemento_contiene" style="width:8%">
            	<div class="elemento_arriba">Identificador</div>
                <div class="elemento_abajo">
					<input type="text" name="identificador" disabled="disabled" id="identificador" value="" style="width:100%; text-align:right; padding-right:3%; font-family: 'Oswald', sans-serif; height:25px;"  />               
                </div>
            </div>	
	<?
	
	
	}
	
	
	
	if($_POST["action"]==2){
		?>
        	<div class="elemento_contiene" style="width:16%">
            	<div class="elemento_arriba">Banco de Origen</div>
                <div class="elemento_abajo">
                     <select data-placeholder="Seleccione el Banco..." disabled="disabled"  name="banco" id="banco" style="width:100%;" class="chzn-select" >
                          <option value=""></option>
                          <?
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
            
        	<div class="elemento_contiene" style="width:22%">
            	<div class="elemento_arriba">Cuenta Destino</div>
                <div class="elemento_abajo">
                     <select data-placeholder="Seleccione la cuenta destino..."   name="cuenta" id="cuenta" style="width:100%;" class="chzn-select" >
                          <option value=""></option>
                          <?
								$con=Conectarse();
								$sql_cuenta="select * from cuenta where tipopropietario='Empresa' order by numerocuenta;";
								$result_cuenta=pg_exec($con,$sql_cuenta);
								for($i=0;$i<pg_num_rows($result_cuenta);$i++){
									$cuenta=pg_fetch_array($result_cuenta,$i);
									$sql_banco="select * from banco where idbanco=".$cuenta[1]."";
									$result_banco=pg_exec($con,$sql_banco);
									$banco=pg_fetch_array($result_banco);
									echo "<option value='".$cuenta[0]."'> ".$banco[1]." ".$cuenta[4]."</option>";																			
								}
						 ?>	
                      </select>                  
                </div>
            </div>                                             
            
        	<div class="elemento_contiene" style="width:8%">
            	<div class="elemento_arriba">Monto</div>
                <div class="elemento_abajo">
					<input type="text" name="monto" id="monto" value="" style="width:100%; text-align:right; padding-right:3%; font-family: 'Oswald', sans-serif; height:25px; font-size:12px;"  />               
                </div>
            </div>
            
        	<div class="elemento_contiene" style="width:8%">
            	<div class="elemento_arriba">Identificador</div>
                <div class="elemento_abajo">
					<input type="text" name="identificador" id="identificador" value="" style="width:100%; text-align:right; padding-right:3%; font-family: 'Oswald', sans-serif; height:25px;"  />               
                </div>
            </div>	
	<?
	
	
	}	
	
	
	
	if($_POST["action"]==3){
		?>
        	<div class="elemento_contiene" style="width:16%">
            	<div class="elemento_arriba">Banco de Origen</div>
                <div class="elemento_abajo">
                     <select data-placeholder="Seleccione el Banco..."  name="banco" id="banco" style="width:100%;" class="chzn-select" >
                          <option value=""></option>
                          <?
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
            
        	<div class="elemento_contiene" style="width:22%">
            	<div class="elemento_arriba">Cuenta Destino</div>
                <div class="elemento_abajo">
                     <select data-placeholder="Seleccione la cuenta destino..."   name="cuenta" id="cuenta" style="width:100%;" class="chzn-select" >
                          <option value=""></option>
                          <?
								$con=Conectarse();
								$sql_cuenta="select * from cuenta where tipopropietario='Empresa' order by numerocuenta;";
								$result_cuenta=pg_exec($con,$sql_cuenta);
								for($i=0;$i<pg_num_rows($result_cuenta);$i++){
									$cuenta=pg_fetch_array($result_cuenta,$i);
									$sql_banco="select * from banco where idbanco=".$cuenta[1]."";
									$result_banco=pg_exec($con,$sql_banco);
									$banco=pg_fetch_array($result_banco);
									echo "<option value='".$cuenta[0]."'> ".$banco[1]." ".$cuenta[4]."</option>";																			
								}
						 ?>	
                      </select>                  
                </div>
            </div>                                             
            
        	<div class="elemento_contiene" style="width:8%">
            	<div class="elemento_arriba">Monto</div>
                <div class="elemento_abajo">
					<input type="text" name="monto" id="monto" value="" style="width:100%; text-align:right; padding-right:3%; font-family: 'Oswald', sans-serif; height:25px; font-size:12px;"  />               
                </div>
            </div>
            
        	<div class="elemento_contiene" style="width:8%">
            	<div class="elemento_arriba">Identificador</div>
                <div class="elemento_abajo">
					<input type="text" name="identificador" id="identificador" value="" style="width:100%; text-align:right; padding-right:3%; font-family: 'Oswald', sans-serif; height:25px;"  />               
                </div>
            </div>	
	<?
	
	
	}		
	
	
	if($_POST["action"]==4){
	 
	?>        
    	<div class="linea_titulo" style="margin-top:15px; ">Cuentas Pendientes Del Cliente</div>
        <div class="linea_titulod" >
        	<div class="columnad" style="width:9%; ">Fecha</div>
            <div class="columnad" style="width:30%; text-align:left">Cliente</div>
            <div class="columnad" style="width:10%">Tipo Precio</div>
            <div class="columnad" style="width:10%">Total</div>
            <div class="columnad" style="width:10%">Cancelado</div>
            <div class="columnad" style="width:10%">Pendiente</div>
            <div class="columnad" style="width:8%">% Cancelado</div>
            <div class="columnad" style="width:8%; border-right:0px; ">Abono</div>
        </div> 
        
        	<?php
				$con=Conectarse();
				$sql_listaCuentas="select cuentaporcobrar.idcuentaporcobrar, venta.idventa, cliente.idcliente, cliente.nombre, ubicacion.idubicacion, ubicacion.ciudad, venta.tipoventa, venta.tipopago, tipoprecio.idtipoprecio, tipoprecio.descripcion, cuentaporcobrar.montototal, cuentaporcobrar.cancelado, cuentaporcobrar.restante, cuentaporcobrar.estatus, venta.fecha, ((cuentaporcobrar.cancelado*100)/cuentaporcobrar.montototal) as porcentaje from tipoprecio, ubicacion, cuentaporcobrar, cliente, venta where cuentaporcobrar.idventa = venta.idventa and venta.idcliente = cliente.idcliente and venta.idubicacion = ubicacion.idubicacion and tipoprecio.idtipoprecio = venta.tipoprecio and cliente.idcliente='".$_POST["cliente"]."' and (cuentaporcobrar.estatus = 1 or cuentaporcobrar.estatus = 2)";
				$result_listaCuentas=pg_exec($con,$sql_listaCuentas);
				$listaCuentas="";
				for($i=0;$i<pg_num_rows($result_listaCuentas);$i++){
					$cuenta=pg_fetch_array($result_listaCuentas,$i);
					$listaCuentas=$listaCuentas.$cuenta[0]."-";
		        	echo "<div class='linea_filad'>";
					echo "<div class='columnafila' style='width:9%;text-align:center'>".substr($cuenta[14],0,10)."</div>";
		            echo "<div class='columnafila' style='width:30%; text-align:left'>".$cuenta[3]."</div>";
					echo "<div class='columnafila' style='width:10%; text-align:Center'>".$cuenta[9]."</div>";
		            echo "<div class='columnafila' style='width:10%;text-align:right; padding-left:0px;padding-right:0.5%'>".$cuenta[10]."</div>";
		            echo "<div class='columnafila' style='width:10%;text-align:right; padding-left:0px;padding-right:0.5%'>".$cuenta[11]."</div>";
		            echo "<div class='columnafila' style='width:10%;text-align:right; padding-left:0px;padding-right:0.5%'>".$cuenta[12]."</div>";
					echo "<div class='columnafila' style='width:8%;text-align:center; padding-left:0px;padding-right:0.5%'>".number_format(round($cuenta[15],2),2,'.','')."</div>";
					echo "<div class='columnafila' style='background:#FFF;width:8.6%; border-right:0px; padding-left:0%'><input style='width:95%; padding-left:0%; padding-right:5%;height:25px; border:0px;font-family: Oswald, sans-serif; text-align:right'  type='text' name='abono".$cuenta[0]."' id='abono".$cuenta[0]."' /></div>";
					echo "</div>"; 				
				}	
				echo "<input type='hidden' id='listacuentas' name='listacuentas' value='".$listaCuentas."' />";
				
				echo "<div class='linea_filad' style='margin-top:10px; border:0px;' >";
				echo "<input type='submit' value='Guardar' name='Guardar' id='Guardar' style='width:8%; font-size:11px; font-family: Oswald, sans-serif; height:25px; text-align:center; margin-left:42%; float:left'  />";
				echo "</div>";
	}
	
	if($_GET["action"]==5){
		$con=Conectarse();
		$sql_insertAbonoCuenta="";
		
		if($_POST["tipoPago"]==1){/*Efectivo*/
			$sql_insertAbonoCuenta="insert into abonocuentaporcobrar values(nextval('abonocuentaporcobrar_idabonocuentaporcobrar_seq'),now(),null,null,1,'".$_POST["fecha"]."','".$_POST["monto"]."',null)";
		}
		if($_POST["tipoPago"]==2){/*Deposito*/
			$sql_insertAbonoCuenta="insert into abonocuentaporcobrar values(nextval('abonocuentaporcobrar_idabonocuentaporcobrar_seq'),now(),null,'".$_POST["cuenta"]."',2,'".$_POST["fecha"]."','".$_POST["monto"]."','".$_POST["identificador"]."')";
		}	
		if($_POST["tipoPago"]==3 || $_POST["tipoPago"]==4){/*Deposito*/
			$sql_insertAbonoCuenta="insert into abonocuentaporcobrar values(nextval('abonocuentaporcobrar_idabonocuentaporcobrar_seq'),now(),'".$_POST["banco"]."','".$_POST["cuenta"]."','".$_POST["tipoPago"]."','".$_POST["fecha"]."','".$_POST["monto"]."','".$_POST["identificador"]."')";
		}
		
		$result_insertAbonoCuenta=pg_exec($con,$sql_insertAbonoCuenta);
		
		$sql_last_record="select last_value from abonocuentaporcobrar_idabonocuentaporcobrar_seq;";
		$result_last_record=pg_exec($con,$sql_last_record);
		$last_record=pg_fetch_array($result_last_record,0);			
		
		$listaCuentas=explode("-",$_POST["listacuentas"]);		
		for($i=0;$i<(sizeof($listaCuentas)-1);$i++){
			
			if($_POST["abono".$listaCuentas[$i]]!=""){
			$sql_detalleCuenta="select * from cuentaporcobrar where idcuentaporcobrar='".$listaCuentas[$i]."' ";
			$result_detalleCuenta=pg_exec($con,$sql_detalleCuenta);
			$detalleCuenta=pg_fetch_array($result_detalleCuenta,0);
			$sql_updateCuenta="";
			if(($detalleCuenta[2]-($detalleCuenta[3]+$_POST["abono".$listaCuentas[$i]]))==0){ /*pago completo de la deuda*/
				$sql_updateCuenta="update cuentaporcobrar set cancelado='".($detalleCuenta[3]+$_POST["abono".$listaCuentas[$i]])."', restante='".($detalleCuenta[2]-($detalleCuenta[3]+$_POST["abono".$listaCuentas[$i]]))."', estatus=3 where idcuentaporcobrar='".$detalleCuenta[0]."'";
			}else{/*Pago parcial*/
				$sql_updateCuenta="update cuentaporcobrar set cancelado='".($detalleCuenta[3]+$_POST["abono".$listaCuentas[$i]])."', restante='".($detalleCuenta[2]-($detalleCuenta[3]+$_POST["abono".$listaCuentas[$i]]))."', estatus=2 where idcuentaporcobrar='".$detalleCuenta[0]."'";
			}			
			$result_updateCuenta=pg_exec($con,$sql_updateCuenta);
			
			$sql_insertAbono="insert into abono values(nextval('abono_idabono_seq'),'".$detalleCuenta[0]."','".$last_record[0]."','".number_format(round($_POST["abono".$listaCuentas[$i]],2),2,'.','')."')";
			$result_insertAbono=pg_exec($con,$sql_insertAbono);	
			}
											
		}
		
		?>
        <script language="javascript" type="text/javascript">
			alert("Abono Registrado Satisfactoriamente.");
			location.href="../../sistema/CuentasporCobrar.php";
		</script>
         <?																					
	}
	

?>

<script type="text/javascript" language="javascript">
	$(function(){
	    $("#Guardar").click(function(){
			var montoTotal=parseFloat(document.getElementById("monto").value);			
			var auxCuentas=document.getElementById("listacuentas").value;		
			listaCuentas = auxCuentas.split("-");
			var distribuido=0; 
			for(var i=0;i<(listaCuentas.length-1);i++){	
			    if(document.getElementById("abono"+listaCuentas[i]).value!=""){
					distribuido+=parseFloat(document.getElementById("abono"+listaCuentas[i]).value);
				}					
			}	
			
			if(montoTotal!=distribuido){
			   alert("Solo ha distribuido en las cuentas por cobrar para este cliente "+distribuido+" y el monto del pago es por "+montoTotal+". Debe completar el monto del pago distribuyendolo entre las cuentas por cobrar.");
			}else if(montoTotal==distribuido) {
				document.formabono.submit();
			}
			
		});		
	});	

</script>