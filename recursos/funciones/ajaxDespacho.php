<?php
	require("funciones.php");
    $con=Conectarse();
	if($_POST["indice"]==1){/*Actualiza select*/			
		$seleccionados = explode("-",$_POST["seleccionados"]);
		echo "<select data-placeholder='Seleccione el Producto a Agregar...' name='listaProductos' id='listaProductos' style='width:100%;' class='chzn-select' >";
        echo "<option value=''></option>";
                                
		$sql_select_productos="select * from producto order by idproducto ASC";
		$result_select_productos = pg_exec($con,$sql_select_productos);
		for($i=0;$i<pg_num_rows($result_select_productos);$i++){
			$producto=pg_fetch_array($result_select_productos,$i);
			$band=0;
			for($j=0;$j<(sizeof($seleccionados)-1);$j++){
				 if($producto[0]==$seleccionados[$j]){
					$band=1;
					break; 
				 }
			}
			if($band==0){
				echo "<option value=".$producto[0].">".$producto[2]."</option>";
			}			 			
		}							
        echo "</select>";															
	}
	
	if($_POST["indice"]==2){ /*Establece la factura*/
					
        echo "<div class='contiene_subtitulos'>";
			
		$idCliente=$_POST["cliente"];	
		$con=Conectarse();
				
		$listaProductos="";
		$presentacionProductos="";
		$sql_listaProductos="select * from producto order by idproducto;";
		$result_listaProductos=pg_exec($con,$sql_listaProductos);
		for($i=0;$i<pg_num_rows($result_listaProductos);$i++){
			$producto=pg_fetch_array($result_listaProductos,$i);
			$listaProductos=$listaProductos.$producto[0]."-";	
			$presentacionProductos=$presentacionProductos.$producto[5]."-";
																	
		}
		
        echo "Agregar Productos al Despacho";
        echo "<input type='hidden' name='productosSeleccionados' id='productosSeleccionados' value='' />";
        echo "<input type='hidden' name='idPro' id='idPro' value='".$listaProductos."' />";
        echo "<input type='hidden' name='impPro' id='impPro' value='".$impuestoProductos."' />";
        echo "<input type='hidden' name='prePro' id='prePro' value='".$preciosProductos."' />";
        echo "<input type='hidden' name='presentacionPro' id='presentacionPro' value='".$presentacionProductos."' />";
        echo "<input type='hidden' name='preciosFull' id='preciosFull' value='".$preciosFulesProductos."' />";
        echo "<input type='hidden' name='numeroItems' id='numeroItems' value='1' />";
        echo "</div>";
		
		
		echo "<div class='contiene_campos' style='border-top:0px;'>";
        echo "<div class='campo' style='width:31%;'>";
        echo "<div class='campo_up' style='width:23.9%'><label style='margin-left:0.5%'>Nombre del Producto</label></div>";
        echo "<div class='campo_down' style='width:23.9%' id='contieneLista'>";
        echo "<select data-placeholder='Seleccione el Producto a Agregar...' name='listaProductos' id='listaProductos' style='width:100%;' class='chzn-select' >";
        echo "<option value=''></option>";                                
		$sql_select_productos="select * from producto order by idproducto ASC";
        $result_select_productos = pg_exec($con,$sql_select_productos);
	    for($i=0;$i<pg_num_rows($result_select_productos);$i++){
			$producto=pg_fetch_array($result_select_productos,$i);		
			echo "<option value=".$producto[0].">".$producto[2]."</option>"; 			
		}								
        echo "</select>";
        echo "</div>";
        echo "</div>";
        echo "<div class='campo' style='width:11.4%;'>";
        echo "<div class='campo_up' style='width:8.7%'><label style='margin-left:0.5%'>Número Unidades</label></div>";
        echo "<div class='campo_down' style='width:8.7%'>";
        echo "<input type='text' name='numeroUnidades' id='numeroUnidades' value='' class='numero_unidades'  style='width:100%;'/>";
        echo "</div>";
        echo "</div>";
        echo "<div class='campo' style='width:11.4%;'>";
        echo "<div class='campo_up' style='width:8.7%'><label style='margin-left:0.5%'>Kilogramos</label></div>";
        echo "<div class='campo_down' style='width:8.7%'>";
        echo "<input type='text' name='kilogramosVenta' id='kilogramosVenta' value='' class='numero_unidades' style='width:100%;' />";
        echo "</div>";
        echo "</div>";
        echo "<div class='campo' style='width:7%;margin-right:0px;'>";
        echo "<div class='campo_up' style='width:7%'></div>";
        echo "<div class='campo_down' style='width:7%'>";
		?>
        <button style="font-size:11px;font-family: 'Oswald', sans-serif; margin-top:-2px; width:120px;" name="agregarTipo1" id="agregarTipo1">Agregar Producto</button>
        <?
        echo "</div>";
        echo "</div>";
        echo "</div>";
        
        echo "<div class='titulo_tabla'>";
        echo "<div class='titulo_columna' style='width:10%;'>Código</div>";
        echo "<div class='titulo_columna' style='width:22%;'>Descripción</div>";
        echo "<div class='titulo_columna' style='width:3%;'>Imp</div>";
        echo "<div class='titulo_columna' style='width:4%;'>UMS</div>";
        echo "<div class='titulo_columna' style='width:10%;'>C.Stock</div>";
        echo "<div class='titulo_columna' style='width:4%;'>UMV</div>";
        echo "<div class='titulo_columna' style='width:10%;'>C.Venta</div>";
        echo "<div class='titulo_columna' style='width:2.5%; border-right:0px;'></div>";
        echo "</div>";
        echo "<div id='productosVenta'>";
        echo "</div>";
        		
		?>
        <button style="font-size:11px;font-family: 'Oswald', sans-serif; margin-top:-2px; width:120px; margin-left:2%; margin-top:10px;" name="finalizarVenta" id="finalizarVenta">Finalizar Despacho</button>
        <?				
		?>
		<script type="text/javascript" language="javascript">
	$(function(){
		
	$(document).ready(function(){ 
		$("#numeroUnidades, #kilogramosVenta").keydown(function(event) {
		   if(event.shiftKey)
		   {
		        event.preventDefault();
		   }
		 
		   if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 190 || event.keyCode == 9)    {
		   }
		   else {
		        if (event.keyCode < 95) {
		          if (event.keyCode < 48 || event.keyCode > 57) {
		                event.preventDefault();
		          }
	        } 
	        else {
	              if (event.keyCode < 96 || event.keyCode > 105) {
	                  event.preventDefault();
	              }
	        }
	      }
	   });
	});		
		
		$("#finalizarVenta").click(function(){
			if(document.getElementById("numeroItems").value==1){
				alert("Debe agragar por lo menos un producto a la venta.");
			}else{
				document.formularioVenta.submit();
			}	
		});
		
	    $("#agregarTipo1").click(function(){ /*Factura regulada + nota de entrega*/	
		       
			var bandAgrega=0;			
			if(document.getElementById("listaProductos").value==0){
				alert("Debe indicar el producto que desea agregar.");
				bandAgrega=1;
			}	
			if(document.getElementById("numeroUnidades").value=="" && bandAgrega==0){
				alert("Debe indicar el numero de unidades de producto que se esta agregando a la venta.");
				bandAgrega=1;
			}	
			
			numcheck = /^(?:\d*\.\d{1,2}|\d+)$/;			
			if(numcheck.test(document.getElementById("numeroUnidades").value)==false && bandAgrega==0){
				alert("El número de unidades no cumple con el formato requerido debe ser un número y los decimales indicados con punto.");
				bandAgrega=1;				
			}
									
			if(document.getElementById("kilogramosVenta").value=="" && bandAgrega==0){
				alert("Debe indicar el peso de las unidades de producto que esta agregando a la venta.");
				bandAgrega=1;
			}	
			
			if(numcheck.test(document.getElementById("kilogramosVenta").value)==false && bandAgrega==0){
				alert("El peso de las unidades no cumple con el formato requerido debe ser un número y los decimales indicados con punto.");
				bandAgrega=1;				
			}			
			
			if(parseInt(document.getElementById("numeroItems").value)>11 && bandAgrega==0){
				bandAgrega=1;
				alert("La venta ya cuenta con el número maximo de items.");						
			}else{
				if(bandAgrega==0){
					document.getElementById("numeroItems").value=parseInt(document.getElementById("numeroItems").value)+1;	
				}
					
			}
				     
			if(bandAgrega==0 ){
				var posicion="";
				var lista = document.getElementById("idPro").value;	 	 
				arrayLista = lista.split("-");   
				var impuesto = document.getElementById("impPro").value;	 	 
				arrayImpuesto = impuesto.split("-");  		 			
				var presentacion = document.getElementById("presentacionPro").value;	 	 
				arrayPresentacion = presentacion.split("-"); 				
	
				for(var i=0;i<(arrayLista.length-1);i++){
					if(arrayLista[i]==document.getElementById("listaProductos").value){
						posicion=i;	
					}
				}	
				
				var indice= parseInt(document.getElementById("listaProductos").value);
				var codigo="";
				if(indice>100){
					codigo="PRO00"+indice;
				}else if(indice>10){
					codigo="PRO000"+indice;
				}else{
					codigo="PRO0000"+indice;
				}				
				
				document.getElementById("productosSeleccionados").value=document.getElementById("productosSeleccionados").value+document.getElementById("listaProductos").value+"-";
				
				var etiquetaImpuesto="";
				var impuesto="";
				if(arrayImpuesto[posicion]=='t'){
					etiquetaImpuesto="(E)";
					impuesto="0.00";
				}else{
					etiquetaImpuesto="(E)";
					impuesto="0.00";
				}
				
				var presenta="";
				if(arrayPresentacion[posicion]==1){
					presenta="Kgr";
				}else if(arrayPresentacion[posicion]==2){
					presenta="Und";
				}
				
							
				
				$("#productosVenta").append("<div class='fila_tabla' id='linea"+document.getElementById("listaProductos").value+"'><div class='fila_columna' style='width:8%;'>"+codigo+"</div><div class='fila_columna' style='width:20%;'>"+$("#listaProductos option:selected").text()+"</div><div class='fila_columna' style='width:1%;'>"+etiquetaImpuesto+"</div><div class='fila_columna' style='width:2%;'>Und</div><div class='fila_columna' style='width:10%; padding-left:0px; padding-right:0px; '><input type='text' class='entrada_columna' onblur='actualizarTipo1("+document.getElementById("listaProductos").value+")' id='unidades"+document.getElementById("listaProductos").value+"' name='unidades"+document.getElementById("listaProductos").value+"' style='width:7.6%' value='"+parseFloat(document.getElementById("numeroUnidades").value).toFixed(2)+"' /></div><div class='fila_columna' style='width:2%;'>"+presenta+"</div><div class='fila_columna' style='width:10%; padding-left:0px; padding-right:0px;'><input type='text' class='entrada_columna' onblur='actualizarTipo1("+document.getElementById("listaProductos").value+")' id='kilogramos"+document.getElementById("listaProductos").value+"' name='kilogramos"+document.getElementById("listaProductos").value+"' style='width:7.6%' id='kilogramos' value='"+parseFloat(document.getElementById("kilogramosVenta").value).toFixed(2)+"' /></div><div class='fila_columna' style='width:2.3%; border-right:0px; padding-left:0px; padding-right:0px;'><img class='borrar' style='margin-left:25%'  src='../recursos/imagenes/deleteIcon2.png' onclick=elimina("+document.getElementById("listaProductos").value+") width='16' height='16' /></div></div>");	
			
				$("#contieneLista").load("../recursos/funciones/ajaxVenta.php", {indice: 1, seleccionados: document.getElementById("productosSeleccionados").value},function(){
					$("#listaProductos").chosen({no_results_text: "No se han encontrado resultados para: "});
					
				document.getElementById("numeroUnidades").value="";
				document.getElementById("kilogramosVenta").value="";																			
				ajustar();
						
				});																				
			}								
		});		
	});		
		</script>                
        <?		
	}
	
	if($_GET["action"]==3){

		$sql_consultarCliente="select * from cliente where idcliente='".$_POST["nombreCliente"]."'";
		$result_consultarCliente=pg_exec($con,$sql_consultarCliente);
		$cliente=pg_fetch_array($result_consultarCliente,0);
		
		$listaProductos="";
		$preciosProductos="";
		$impuestoProductos="";
		$sql_listaProductos="select * from producto order by idproducto;";
		$result_listaProductos=pg_exec($con,$sql_listaProductos);
		for($i=0;$i<pg_num_rows($result_listaProductos);$i++){
			$producto=pg_fetch_array($result_listaProductos,$i);
			$listaProductos=$listaProductos.$producto[0]."-";	
			$impuestoProductos=$impuestoProductos.$producto[4]."-";
			if($producto[6]==1){ //precio regulado														
				$sql_precioRegulado="select * from precioregulado where idproducto='".$producto[0]."' and hasta is null";
				$result_precioRegulado=pg_exec($con,$sql_precioRegulado);
				$precioRegulado=pg_fetch_array($result_precioRegulado,0);
				$preciosProductos=$preciosProductos.$precioRegulado[4]."-";					
			}else if($producto[6]==2){ //precio full													
				$sql_precioxubicacion="select * from precioxubicacion where idproducto='".$producto[0]."' and idubicacion='".$cliente[5]."' and idtipoprecio='".$_POST["precioAplica"]."' and hasta is null;";
				$result_precioxubicacion=pg_exec($con,$sql_precioxubicacion);
				$precioxUbicacion=pg_fetch_array($result_precioxubicacion,0);				
				$preciosProductos=$preciosProductos.$precioxUbicacion[6]."-";						
			}		
		}
		
		//echo $listaProductos."</br>";
		//echo $preciosProductos."</br>";
		//echo $impuestoProductos."</br>";

		$sql_control="select * from control";
		$result_control=pg_exec($con,$sql_control);
		$control=pg_fetch_array($result_control,0);
		
		$excento=$_POST["excento"];
		$gravables=$_POST["gravables"];
		$subtotal=$_POST["subtotal"];
		$totalIva=round(($_POST["gravables"]*0.12),2);
		$montoTotal=round(($subtotal+$totalIva),2);
		
		$sql_insertVenta="insert into venta values(nextval('venta_idventa_seq'),".$cliente[5].",".$cliente[0].",".$_POST["tipoVentaAplica"].",".$_POST["tipoPagoAplica"].",".$_POST["precioAplica"].",now(),".number_format(round($excento,2),2,'.','').",".number_format(round($gravables,2),2,'.','').",".number_format(round($subtotal,2),2,'.','').",".number_format(round($totalIva,2),2,'.','').",".number_format(round($montoTotal,2),2,'.','').")";				
		$result_insertVenta=pg_exec($con,$sql_insertVenta);
		
		$sql_last_record="select last_value from venta_idventa_seq;";
		$result_last_record=pg_exec($con,$sql_last_record);
		$last_record=pg_fetch_array($result_last_record,0);		
				
		$productos = explode("-",$_POST["productosSeleccionados"]);
		
		for($i=0;$i<(sizeof($productos)-1);$i++){
			$sql_inserProductoVenta="insert into productosxventa values(nextval('productosxventa_idproductosxventa_seq'),".$productos[$i].",".$last_record[0].",".$_POST["unidades".$productos[$i]].",".$_POST["kilogramos".$productos[$i]].",".$_POST["precio".$productos[$i]].",".$_POST["subtotal".$productos[$i]].",".$_POST["iva".$productos[$i]].",".$_POST["total".$productos[$i]].")";
			$result_inserProductoVenta=pg_exec($con,$sql_inserProductoVenta);
		}
		
		/*Inserto la cuenta por cobrar ya que el tipo de pago que aplica es 2 osea a credito*/
		if($_POST["tipoPagoAplica"]==2){
			$sql_insertCuentaporCobrar="insert into cuentaporcobrar values(nextval('cuentaporcobrar_idcuentaporcobrar_seq'),".$last_record[0].",'".number_format(round($montoTotal,2),2,'.','')."','0.00','".number_format(round($montoTotal,2),2,'.','')."',1)";
			$result_insertCuentaporCobrar=pg_exec($con,$sql_insertCuentaporCobrar);			
		}
		
		/*-------------------------------------------------------------------------------------------------------*/
		$sql_diaregistrado="select count(*) from inventarioproductos where fecha=current_date;";
		$result_diaregistrado=pg_exec($con,$sql_diaregistrado);
		$registros = pg_fetch_array($result_diaregistrado,0);
		
		if($registros[0]==0){

			$sql_ultimo_dia="select fecha from inventarioproductos order by fecha DESC;";
			$result_ultimo_dia=pg_exec($con,$sql_ultimo_dia);
			$ultimodia=pg_fetch_array($result_ultimo_dia,0);
			
			$fechaInicio=strtotime($ultimodia[0]);
		    $fechaFin=strtotime($_POST["fecha"]);			
			
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
						
		$productos = explode("-",$_POST["productosSeleccionados"]);		
		for($i=0;$i<(sizeof($productos)-1);$i++){					
			$sql_diaseditados="select * from inventarioproductos where fecha >=current_date and idproducto='".$productos[$i]."' order by fecha;";
			$result_diaseditados=pg_exec($con,$sql_diaseditados);
			for($j=0;$j<pg_num_rows($result_diaseditados);$j++){
				$diaEditado = pg_fetch_array($result_diaseditados,$j);
				if($j==0){/*Primera fecha en la secuencia de dias*/
					$sql_updateDia=" update inventarioproductos set venta='".$_POST["unidades".$productos[$i]]."', final='".(($diaEditado[5]+$diaEditado[6])-($_POST["unidades".$productos[$i]]+$diaEditado[8]+$diaEditado[9]+$diaEditado[10]))."' where idinventarioproducto='".$diaEditado[0]."'";
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
				
		/*-------------------------------------------------------------------------------------------------------*/			
		
		
		
		if($_POST["tipoVenta"]==1){
			?>            	
            	<script type="text/javascript" language="javascript">
					alert("Venta Registrada Satisfactoriamente.");
					location.href="../../sistema/FacturarVenta.php";
				</script>            
            <?						
		}
		
		
		
		if($_POST["tipoVenta"]==2){ /*Registro de factura con precio legal*/							
			$sql_insertFactura="insert into factura values(nextval('factura_idfactura_seq'),".$control[1].",".$last_record[0].",".number_format(round($excento,2),2,'.','').",".number_format(round($gravables,2),2,'.','').",".number_format(round($subtotal,2),2,'.','').",".number_format(round($totalIva,2),2,'.','').",".number_format(round($montoTotal,2),2,'.','').")";
			$result_insertFactura=pg_exec($con,$sql_insertFactura);
			
			$sql_last_record="select last_value from factura_idfactura_seq;";
			$result_last_record=pg_exec($con,$sql_last_record);
			$last_record=pg_fetch_array($result_last_record,0);			
			
			$lisPro = explode("-",$listaProductos);
			$prePro = explode("-",$preciosProductos);
			$impuestos = explode("-",$impuestoProductos);
			
			$auxPro= 0;
			$auxExcento=0;
			$auxGravable=0;
			$auxSubTotal=0;
			$auxTotalIva=0;
			$auxMontoTotal=0;
			
			for($i=0;$i<(sizeof($productos)-1);$i++){
								
				for($j=0;$j<(sizeof($lisPro)-1);$j++){
					if($lisPro[$j]==$productos[$i]){
						$auxPro=$j;
						break;
					}
				}
				
				$montoIva=0;
				if($impuestos[$auxPro]=="t"){
					$montoIva=12.00;
				}else{
					$montoIva=0.00;
				}
								
				$auxSubTotalItem=round($prePro[$auxPro]*$_POST["kilogramos".$productos[$i]],2);
				$auxtotalItem=$auxSubTotalItem+($auxSubTotalItem*($montoIva/100));
				if($montoIva==12.00){
					$auxGravable+=$auxSubTotalItem;
				}else{
					$auxExcento+=$auxSubTotalItem;
				}	

				
				$sql_inserProductoFactura="insert into productosxfactura values(nextval('productosxfactura_idproductosxfactura_seq'),".$productos[$i].",".$last_record[0].",".number_format(round($_POST["unidades".$productos[$i]],2),2,'.','').",".number_format(round($_POST["kilogramos".$productos[$i]],2),2,'.','').",".number_format(round($prePro[$auxPro],2),2,'.','').",".number_format(round($auxSubTotalItem,2),2,'.','').",".number_format(round($montoIva,2),2,'.','').",".number_format(round($auxtotalItem,2),2,'.','').")";
				$result_inserProductoFactura=pg_exec($con,$sql_inserProductoFactura);
			}
			
				$auxSubTotal=round(($auxGravable+$auxExcento),2);
				$auxTotalIva=round(($auxGravable*0.12),2);	
				$auxMontoTotal=round(($auxSubTotal+$auxTotalIva),2);			
			
				$auxExcento=round($auxExcento,2);
				$auxGravable=round($auxGravable,2);
			
			
			$sql_updateFactura="update factura set excento=".number_format(round($auxExcento,2),2,'.','').", gravable=".number_format(round($auxGravable,2),2,'.','').", subtotal=".number_format(round($auxSubTotal,2),2,'.','').", totaliva=".number_format(round($auxTotalIva,2),2,'.','').", montototal=".number_format(round($auxMontoTotal,2),2,'.','')." where idfactura='".$last_record[0]."';";
			$result_updateFactura=pg_exec($con,$sql_updateFactura);
			
			$sql_updateControl="update control set factura='".($control[1]+1)."' where idcontrol=1;";
			$result_updateControl=pg_exec($con,$sql_updateControl);
			?>            	
            	<script type="text/javascript" language="javascript">
					alert("Venta Registrada Satisfactoriamente.");
					location.href="../../sistema/FacturarVenta.php";
				</script>            
            <?
																								
		}
		
		if($_POST["tipoVenta"]==3){ /*Registro de factura con precio legal y diferencia por queso telita*/
			
			$sql_insertFactura="insert into factura values(nextval('factura_idfactura_seq'),".$control[1].",".$last_record[0].",".number_format(round($excento,2),2,'.','').",".number_format(round($gravables,2),2,'.','').",".number_format(round($subtotal,2),2,'.','').",".number_format(round($totalIva,2),2,'.','').",".number_format(round($montoTotal,2),2,'.','').")";
			$result_insertFactura=pg_exec($con,$sql_insertFactura);
			
			$sql_last_record="select last_value from factura_idfactura_seq;";
			$result_last_record=pg_exec($con,$sql_last_record);
			$last_record=pg_fetch_array($result_last_record,0);			
			
			$lisPro = explode("-",$listaProductos);
			$prePro = explode("-",$preciosProductos);
			$impuestos = explode("-",$impuestoProductos);
			$auxPro= 0;
			$auxExcento=0;
			$auxGravable=0;
			$auxSubTotal=0;
			$auxTotalIva=0;
			$auxMontoTotal=0;
			
			for($i=0;$i<(sizeof($productos)-1);$i++){
								
				for($j=0;$j<(sizeof($lisPro)-1);$j++){
					if($lisPro[$j]==$productos[$i]){
						$auxPro=$j;
						break;
					}
				}
				
				$montoIva=0;
				if($impuestos[$auxPro]=="t"){
					$montoIva=12.00;
				}else{
					$montoIva=0.00;
				}				
								
				$auxSubTotalItem=round($prePro[$auxPro]*$_POST["kilogramos".$productos[$i]],2);
				$auxtotalItem=$auxSubTotalItem+($auxSubTotalItem*($montoIva/100));
				if($montoIva==12.00){
					$auxGravable+=$auxSubTotalItem;
				}else{
					$auxExcento+=$auxSubTotalItem;
				}	

				
				$sql_inserProductoFactura="insert into productosxfactura values(nextval('productosxfactura_idproductosxfactura_seq'),".$productos[$i].",".$last_record[0].",".number_format(round($_POST["unidades".$productos[$i]],2),2,'.','').",".number_format(round($_POST["kilogramos".$productos[$i]],2),2,'.','').",".number_format(round($prePro[$auxPro],2),2,'.','').",".number_format(round($auxSubTotalItem,2),2,'.','').",".number_format(round($montoIva,2),2,'.','').",".number_format(round($auxtotalItem,2),2,'.','').")";
				$result_inserProductoFactura=pg_exec($con,$sql_inserProductoFactura);
			}
			
				$auxSubTotal=round(($auxGravable+$auxExcento),2);
				$auxTotalIva=round(($auxGravable*0.12),2);	
				$auxMontoTotal=round(($auxSubTotal+$auxTotalIva),2);			
			
				$auxExcento=round($auxExcento,2);
				$auxGravable=round($auxGravable,2);
			
			
			$sql_updateFactura="update factura set excento=".number_format(round($auxExcento,2),2,'.','').", gravable=".number_format(round($auxGravable,2),2,'.','').", subtotal=".number_format(round($auxSubTotal,2),2,'.','').", totaliva=".number_format(round($auxTotalIva,2),2,'.','').", montototal=".number_format(round($auxMontoTotal,2),2,'.','')." where idfactura='".$last_record[0]."';";
			$result_updateFactura=pg_exec($con,$sql_updateFactura);
			
			$sql_updateControl="update control set factura='".($control[1]+1)."' where idcontrol=1;";
			$result_updateControl=pg_exec($con,$sql_updateControl);	
			
			$sql_proDiferencia="select * from producto where idproducto='".$control[2]."';";
			$result_proDiferencia=pg_exec($con,$sql_proDiferencia);
			$proDiferencia=pg_fetch_array($result_proDiferencia,0);
			
			$sql_precioDiferencia="select * from preciorealventa where idproducto='".$control[2]."' and hasta is null;";
			$result_precioDiferencia=pg_exec($con,$sql_precioDiferencia);
			$precioDiferencia=pg_fetch_array($result_precioDiferencia,0);
			
			
			//echo "la diferencia entre la venta y la factura es de: ".$montoTotal." - ".$auxMontoTotal.": ".($montoTotal-$auxMontoTotal);
			//echo "</br>Son ".round((($montoTotal-$auxMontoTotal)/$precioDiferencia[4]),2)." Kgs y ".round(((($montoTotal-$auxMontoTotal)/$precioDiferencia[4])/$proDiferencia[7]),0)." unidades ";
			
			
			if(($montoTotal-$auxMontoTotal)>0){		
				
				if(($montoTotal-$auxMontoTotal)>$control[3]){ /*Diferencia mayor que el limite sale por queso telita*/		
					$sql_inserProductoFactura="insert into productosxfactura values(nextval('productosxfactura_idproductosxfactura_seq'),".$control[2].",".$last_record[0].",".number_format(round(((($montoTotal-$auxMontoTotal)/$precioDiferencia[4])/$proDiferencia[7]),0),2,'.','').",".round((($montoTotal-$auxMontoTotal)/$precioDiferencia[4]),2).",".number_format(round($precioDiferencia[4],2),2,'.','').",".round((($montoTotal-$auxMontoTotal)/$precioDiferencia[4])*($precioDiferencia[4]),2).",'0.00',".round((($montoTotal-$auxMontoTotal)/$precioDiferencia[4])*($precioDiferencia[4]),2).")";
					$result_inserProductoFactura=pg_exec($con,$sql_inserProductoFactura);
			
					$auxExcento=$auxExcento+round((($montoTotal-$auxMontoTotal)/$precioDiferencia[4])*($precioDiferencia[4]),2);
					$auxExcento=round($auxExcento,2);
					$auxSubTotal=round(($auxGravable+$auxExcento),2);
					$auxTotalIva=round(($auxGravable*0.12),2);	
					$auxMontoTotal=round(($auxSubTotal+$auxTotalIva),2);
			
					$sql_updateFactura="update factura set excento=".number_format(round($auxExcento,2),2,'.','').", gravable=".number_format(round($auxGravable,2),2,'.','').", subtotal=".number_format(round($auxSubTotal,2),2,'.','').", totaliva=".number_format(round($auxTotalIva,2),2,'.','').", montototal=".number_format(round($auxMontoTotal,2),2,'.','')." where idfactura='".$last_record[0]."';";
					$result_updateFactura=pg_exec($con,$sql_updateFactura);
						
				}else{ /*Diferencia menor que el limite sale por cadena en frio*/
					
					$sql_control="select * from control";
					$result_control=pg_exec($con,$sql_control);
					$control=pg_fetch_array($result_control,0);	
				
					$sql_last_record="select last_value from venta_idventa_seq;";
					$result_last_record=pg_exec($con,$sql_last_record);
					$last_record=pg_fetch_array($result_last_record,0);								
			
					$sql_insertCadena="insert into facturacadena values(nextval('facturacadena_idfacturacadena_seq'),'".($control[1])."','".$last_record[0]."','0.00','".number_format(round((($montoTotal-$auxMontoTotal)/1.12),2),2,'.','')."','".number_format(round((($montoTotal-$auxMontoTotal)/1.12),2),2,'.','')."','".number_format(round(((($montoTotal-$auxMontoTotal)/1.12)*0.12)),2,'.','')."','".number_format(round(($montoTotal-$auxMontoTotal),2),2,'.','')."')";
					$result_insertCadena=pg_exec($con,$sql_insertCadena);
				
					$sql_updateControl="update control set factura='".($control[1]+1)."' where idcontrol=1;";
					$result_updateControl=pg_exec($con,$sql_updateControl);	
					
					$sql_last_record="select last_value from venta_idventa_seq;";
					$result_last_record=pg_exec($con,$sql_last_record);
					$last_record=pg_fetch_array($result_last_record,0);	
										
					$sql_updateVenta="update venta set tipoventa=4 where idventa=".$last_record[0].";";
					$result_updateVenta=pg_exec($con,$sql_updateVenta);
																			
				}								
			}
			
			?>            	
            	<script type="text/javascript" language="javascript">
					alert("Venta Registrada Satisfactoriamente.");
					location.href="../../sistema/FacturarVenta.php";
				</script>            
            <?			
																		
		}
				
	}

?>