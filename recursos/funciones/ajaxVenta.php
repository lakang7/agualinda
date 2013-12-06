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
		
       	echo "<input type='hidden' name='excento' id='excento' value='0' />";
        echo "<input type='hidden' name='gravables' id='gravables' value='0' />";
        echo "<input type='hidden' name='subtotal' id='subtotal' value='0' />";
		echo "<input type='hidden' name='precioAplica' id='precioAplica' value='".$_POST["precio"]."' />";
		echo "<input type='hidden' name='tipoVentaAplica' id='tipoVentaAplica' value='".$_POST["tipodeventa"]."' />";
		echo "<input type='hidden' name='tipoPagoAplica' id='tipoPagoAplica' value='".$_POST["tipodepago"]."' />";				
        echo "<div class='contiene_subtitulos'>";
			
		$idCliente=$_POST["cliente"];
		$idCosto=$_POST["precio"];		
		$con=Conectarse();
		$sql_ubicacion="select * from cliente_ubicacion where idcliente='".$idCliente."' and hasta is null;";
		$result_ubicacion=pg_exec($con,$sql_ubicacion);
		$ubicacion=pg_fetch_array($result_ubicacion,0);				
		$listaProductos="";
		$impuestoProductos="";
		$preciosProductos="";
		$presentacionProductos="";
		$preciosFulesProductos="";
		$sql_listaProductos="select * from producto order by idproducto;";
		$result_listaProductos=pg_exec($con,$sql_listaProductos);
		for($i=0;$i<pg_num_rows($result_listaProductos);$i++){
			$producto=pg_fetch_array($result_listaProductos,$i);
			$listaProductos=$listaProductos.$producto[0]."-";	
			$impuestoProductos=$impuestoProductos.$producto[4]."-";
			$presentacionProductos=$presentacionProductos.$producto[5]."-";
			if($producto[6]==1){ //precio regulado														
				$sql_precioRegulado="select * from precioregulado where idproducto='".$producto[0]."' and hasta is null";
				$result_precioRegulado=pg_exec($con,$sql_precioRegulado);
				$precioRegulado=pg_fetch_array($result_precioRegulado,0);
				$preciosProductos=$preciosProductos.$precioRegulado[4]."-";					
			}else if($producto[6]==2){ //precio full													
				$sql_precioxubicacion="select * from precioxubicacion where idproducto='".$producto[0]."' and idubicacion='".$ubicacion[2]."' and idtipoprecio='".$idCosto."' and hasta is null;";
				$result_precioxubicacion=pg_exec($con,$sql_precioxubicacion);
				$precioxUbicacion=pg_fetch_array($result_precioxubicacion,0);				
				$preciosProductos=$preciosProductos.$precioxUbicacion[6]."-";						
			}
			$sql_precioxubicacion="select * from precioxubicacion where idproducto='".$producto[0]."' and idubicacion='".$ubicacion[2]."' and idtipoprecio='".$idCosto."' and hasta is null;";
			$result_precioxubicacion=pg_exec($con,$sql_precioxubicacion);
			$precioxUbicacion=pg_fetch_array($result_precioxubicacion,0);
			//if($_POST["tipodeventa"]==1 && $producto[4]=="t"){
			if($producto[4]=="t"){
				$aux=round(($precioxUbicacion[6]*1.12),2);
				$preciosFulesProductos=$preciosFulesProductos.$aux."-";
			}else{
				$preciosFulesProductos=$preciosFulesProductos.$precioxUbicacion[6]."-";
			}
							
							
		}
		
        echo "Agregar Productos a La Venta";
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
        echo "<div class='campo_up' style='width:8.7%'><label style='margin-left:0.5%'>Kilogramos en la Venta</label></div>";
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
        echo "<div class='titulo_columna' style='width:10%;'>Precio</div>";
        echo "<div class='titulo_columna' style='width:10%;'>Sub Total</div>";
        echo "<div class='titulo_columna' style='width:4%;'>%IVA</div>";
        echo "<div class='titulo_columna' style='width:9%;'>Total Item</div>";
        echo "<div class='titulo_columna' style='width:2.5%; border-right:0px;'></div>";
        echo "</div>";
        echo "<div id='productosVenta'>";
        echo "</div>";
        echo "<div class='contiene_subtitulos' style='text-align:right; color:#666'>Excento:<label id='etiExcento' style='margin-right:30px; margin-left:5px;' >0.00</label>Gravables:<label id='etiGravables' style='margin-right:30px; margin-left:5px;'>0.00</label>  Sub Total:<label id='etiSubtotal' style='margin-right:3%; margin-left:5px;'>0.00</label></div>";
        echo "<div class='contiene_subtitulos' style='text-align:right; color:#666'>Total IVA:<label style='margin-right:3%; margin-left:5px;' id='etiIva'>0.00</label></div>";
        echo "<div class='contiene_subtitulos' style='text-align:right; color:#666'>Monto Total BSF:<label id='etiTotal' style='margin-right:3%; margin-left:5px;'>0.00</label></div>";		
		?>
        <button style="font-size:11px;font-family: 'Oswald', sans-serif; margin-top:-2px; width:120px; margin-left:2%; margin-top:10px;" name="finalizarVenta" id="finalizarVenta">Finalizar Venta</button>
        <?				
		?>
		<script type="text/javascript" language="javascript">
	$(function(){
		
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
			if(document.getElementById("kilogramosVenta").value=="" && bandAgrega==0){
				alert("Debe indicar el peso de las unidades de producto que esta agregando a la venta.");
				bandAgrega=1;
			}	
			
			if(parseInt(document.getElementById("numeroItems").value)>11){
				bandAgrega=1;
				alert("La venta ya cuenta con el número maximo de items.");						
			}else{
				document.getElementById("numeroItems").value=parseInt(document.getElementById("numeroItems").value)+1;		
			}
				     
			if(bandAgrega==0 ){
				var posicion="";
				var lista = document.getElementById("idPro").value;	 	 
				arrayLista = lista.split("-");   
				var impuesto = document.getElementById("impPro").value;	 	 
				arrayImpuesto = impuesto.split("-");  
				var precioFactura = document.getElementById("preciosFull").value;	 	 
				arrayprecioFactura = precioFactura.split("-"); 			 			
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
				//if(arrayImpuesto[posicion]=='t' && document.getElementById("tipoVenta").value!=1){
					//etiquetaImpuesto="(G)";
					etiquetaImpuesto="(E)";
					impuesto="0.00";
					//impuesto="12.00";
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
				
				var subTotal=parseFloat(arrayprecioFactura[posicion]*document.getElementById("kilogramosVenta").value).toFixed(2);
				var totalItem = "";
				//if(arrayImpuesto[posicion]=='t'  && document.getElementById("tipoVenta").value!=1){
				/*if(arrayImpuesto[posicion]=='t'  ){
					totalItem=parseFloat(subTotal)*parseFloat(1.12);
				}else{*/
					totalItem=subTotal;
				/*}	*/
				
				totalItem=parseFloat(totalItem).toFixed(2);								
				
				$("#productosVenta").append("<div class='fila_tabla' id='linea"+document.getElementById("listaProductos").value+"'><div class='fila_columna' style='width:8%;'>"+codigo+"</div><div class='fila_columna' style='width:20%;'>"+$("#listaProductos option:selected").text()+"</div><div class='fila_columna' style='width:1%;'>"+etiquetaImpuesto+"</div><div class='fila_columna' style='width:2%;'>Und</div><div class='fila_columna' style='width:10%; padding-left:0px; padding-right:0px; '><input type='text' class='entrada_columna' onblur='actualizarTipo1("+document.getElementById("listaProductos").value+")' id='unidades"+document.getElementById("listaProductos").value+"' name='unidades"+document.getElementById("listaProductos").value+"' style='width:7.6%' value='"+parseFloat(document.getElementById("numeroUnidades").value).toFixed(2)+"' /></div><div class='fila_columna' style='width:2%;'>"+presenta+"</div><div class='fila_columna' style='width:10%; padding-left:0px; padding-right:0px;'><input type='text' class='entrada_columna' onblur='actualizarTipo1("+document.getElementById("listaProductos").value+")' id='kilogramos"+document.getElementById("listaProductos").value+"' name='kilogramos"+document.getElementById("listaProductos").value+"' style='width:7.6%' id='kilogramos' value='"+parseFloat(document.getElementById("kilogramosVenta").value).toFixed(2)+"' /></div><div class='fila_columna' style='width:10%; padding-left:0px; padding-right:0px;'><input type='text' class='entrada_columna' style='width:7.6%' onblur='actualizarTipo1("+document.getElementById("listaProductos").value+")' id='precio"+document.getElementById("listaProductos").value+"' name='precio"+document.getElementById("listaProductos").value+"' value='"+parseFloat(arrayprecioFactura[posicion]).toFixed(2)+"' /></div><div class='fila_columna' style='width:10%; padding-left:0px; padding-right:0px;'><input type='text' class='entrada_columna' style='width:7.6%' id='subtotal"+document.getElementById("listaProductos").value+"' name='subtotal"+document.getElementById("listaProductos").value+"' value='"+subTotal+"' /></div><div class='fila_columna' style='width:4%; padding-left:0px; padding-right:0px;'><input type='text' class='entrada_columna' style='width:3%' id='iva"+document.getElementById("listaProductos").value+"' name='iva"+document.getElementById("listaProductos").value+"' value='"+impuesto+"' /></div><div class='fila_columna' style='width:9%; padding-left:0px; padding-right:0px;'><input type='text' class='entrada_columna' style='width:6.9%' id='total"+document.getElementById("listaProductos").value+"' name='total"+document.getElementById("listaProductos").value+"' value='"+totalItem+"' /></div><div class='fila_columna' style='width:2.3%; border-right:0px; padding-left:0px; padding-right:0px;'><img class='borrar' style='margin-left:25%'  src='../recursos/imagenes/deleteIcon2.png' onclick=elimina("+document.getElementById("listaProductos").value+") width='16' height='16' /></div></div>");	
			
				$("#contieneLista").load("../recursos/funciones/ajaxVenta.php", {indice: 1, seleccionados: document.getElementById("productosSeleccionados").value},function(){
					$("#listaProductos").chosen({no_results_text: "No se han encontrado resultados para: "});
					
				document.getElementById("numeroUnidades").value="";
				document.getElementById("kilogramosVenta").value="";
				
				if(etiquetaImpuesto=="(E)"){
					document.getElementById("excento").value=parseFloat(document.getElementById("excento").value)+parseFloat(subTotal);
					document.getElementById("excento").value=parseFloat(document.getElementById("excento").value).toFixed(2);	
				}else if(etiquetaImpuesto=="(G)"){
					document.getElementById("gravables").value=parseFloat(document.getElementById("gravables").value)+parseFloat(subTotal);
					document.getElementById("gravables").value=parseFloat(document.getElementById("gravables").value).toFixed(2);	
				}
				
				document.getElementById("subtotal").value=parseFloat(document.getElementById("excento").value)+parseFloat(document.getElementById("gravables").value);
				document.getElementById("subtotal").value=parseFloat(document.getElementById("subtotal").value).toFixed(2);
				
				document.getElementById("etiExcento").innerHTML=document.getElementById("excento").value;					
				document.getElementById("etiGravables").innerHTML=document.getElementById("gravables").value;	
				document.getElementById("etiSubtotal").innerHTML=document.getElementById("subtotal").value;	
				document.getElementById("etiIva").innerHTML=parseFloat(parseFloat(document.getElementById("gravables").value)*parseFloat(0.12)).toFixed(2);
				document.getElementById("etiTotal").innerHTML= parseFloat(parseFloat(document.getElementById("subtotal").value)+parseFloat(document.getElementById("etiIva").innerHTML)).toFixed(2);
				
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
		
		echo $listaProductos."</br>";
		echo $preciosProductos."</br>";
		echo $impuestoProductos."</br>";

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
		
		
		
		if($_POST["tipoVenta"]==2){ /*Registro de factura con precio legal*/							
			$sql_insertFactura="insert into factura values(nextval('factura_idfactura_seq'),".$control[1].",".$last_record[0].",".$excento.",".$gravables.",".$subtotal.",".$totalIva.",".$montoTotal.")";
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
		}
		
		if($_POST["tipoVenta"]==3){ /*Registro de factura con precio legal y diferencia por queso telita*/
			
			$sql_insertFactura="insert into factura values(nextval('factura_idfactura_seq'),".$control[1].",".$last_record[0].",".$excento.",".$gravables.",".$subtotal.",".$totalIva.",".$montoTotal.")";
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
			
			
			$sql_updateFactura="update factura set excento=".$auxExcento.", gravable=".$auxGravable.", subtotal=".$auxSubTotal.", totaliva=".$auxTotalIva.", montototal=".$auxMontoTotal." where idfactura='".$last_record[0]."';";
			$result_updateFactura=pg_exec($con,$sql_updateFactura);
			
			$sql_updateControl="update control set factura='".($control[1]+1)."' where idcontrol=1;";
			$result_updateControl=pg_exec($con,$sql_updateControl);	
			
			$sql_proDiferencia="select * from producto where idproducto='".$control[2]."';";
			$result_proDiferencia=pg_exec($con,$sql_proDiferencia);
			$proDiferencia=pg_fetch_array($result_proDiferencia,0);
			
			$sql_precioDiferencia="select * from preciorealventa where idproducto='".$control[2]."' and hasta is null;";
			$result_precioDiferencia=pg_exec($con,$sql_precioDiferencia);
			$precioDiferencia=pg_fetch_array($result_precioDiferencia,0);
			
			
			echo "la diferencia entre la venta y la factura es de: ".$montoTotal." - ".$auxMontoTotal.": ".($montoTotal-$auxMontoTotal);
			echo "</br>Son ".round((($montoTotal-$auxMontoTotal)/$precioDiferencia[4]),2)." Kgs y ".round(((($montoTotal-$auxMontoTotal)/$precioDiferencia[4])/$proDiferencia[7]),0)." unidades ";
			
			
			if(($montoTotal-$auxMontoTotal)>0){			
				$sql_inserProductoFactura="insert into productosxfactura values(nextval('productosxfactura_idproductosxfactura_seq'),".$control[2].",".$last_record[0].",".number_format(round(((($montoTotal-$auxMontoTotal)/$precioDiferencia[4])/$proDiferencia[7]),0),2,'.','').",".round((($montoTotal-$auxMontoTotal)/$precioDiferencia[4]),2).",".number_format(round($precioDiferencia[4],2),2,'.','').",".round((($montoTotal-$auxMontoTotal)/$precioDiferencia[4])*($precioDiferencia[4]),2).",'0.00',".round((($montoTotal-$auxMontoTotal)/$precioDiferencia[4])*($precioDiferencia[4]),2).")";
				$result_inserProductoFactura=pg_exec($con,$sql_inserProductoFactura);
			
				$auxExcento=$auxExcento+round((($montoTotal-$auxMontoTotal)/$precioDiferencia[4])*($precioDiferencia[4]),2);
				$auxExcento=round($auxExcento,2);
				$auxSubTotal=round(($auxGravable+$auxExcento),2);
				$auxTotalIva=round(($auxGravable*0.12),2);	
				$auxMontoTotal=round(($auxSubTotal+$auxTotalIva),2);
			
				$sql_updateFactura="update factura set excento=".number_format(round($auxExcento,2),2,'.','').", gravable=".number_format(round($auxGravable,2),2,'.','').", subtotal=".number_format(round($auxSubTotal,2),2,'.','').", totaliva=".number_format(round($auxTotalIva,2),2,'.','').", montototal=".number_format(round($auxMontoTotal,2),2,'.','')." where idfactura='".$last_record[0]."';";
				$result_updateFactura=pg_exec($con,$sql_updateFactura);				
			}
			
																		
		}
		
		if($_POST["tipoVenta"]==4){ /*Registro de factura con precio legal y diferencia en mantenimiento de cadena en frio*/
			
			$sql_insertFactura="insert into factura values(nextval('factura_idfactura_seq'),".$control[1].",".$last_record[0].",".$excento.",".$gravables.",".$subtotal.",".$totalIva.",".$montoTotal.")";
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
			echo "la diferencia entre la venta y la factura es de: ".$montoTotal." - ".$auxMontoTotal.": ".($montoTotal-$auxMontoTotal);
			
			if(($montoTotal-$auxMontoTotal)>0){
			
				$sql_insertCadena="insert into facturacadena values(nextval('facturacadena_idfacturacadena_seq'),'".($control[1]+1)."','".$last_record[0]."','0.00','".number_format(round((($montoTotal-$auxMontoTotal)/1.12),2),2,'.','')."','".number_format(round((($montoTotal-$auxMontoTotal)/1.12),2),2,'.','')."','".number_format(round(((($montoTotal-$auxMontoTotal)/1.12)*0.12)),2,'.','')."','".number_format(round(($montoTotal-$auxMontoTotal),2),2,'.','')."')";
				$result_insertCadena=pg_exec($con,$sql_insertCadena);
			
			}
																	
		}
		
		
	}

?>