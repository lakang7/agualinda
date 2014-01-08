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
		
		$sql_insertDespacho="insert into despacho values(nextval('despacho_iddespacho_seq'),'".$_POST["nombreCliente"]."',now(),1,'Esperando Despacho')";
		$result_insertDespacho=pg_exec($con,$sql_insertDespacho);
		
		$sql_last_record="select last_value from despacho_iddespacho_seq;";
		$result_last_record=pg_exec($con,$sql_last_record);
		$last_record=pg_fetch_array($result_last_record,0);			
		
		$productos = explode("-",$_POST["productosSeleccionados"]);
		
		for($i=0;$i<sizeof($productos);$i++){
			if($productos[$i]!=""){				
				$sql_insertProductosDespacho="insert into productosendespacho values (nextval('productosendespacho_idproductosendespacho_seq'),'".$last_record[0]."','".$productos[$i]."',".$_POST["unidades".$productos[$i]].",".$_POST["kilogramos".$productos[$i]].")";
				$result_insertProductosDespacho=pg_exec($con,$sql_insertProductosDespacho);																
			}			
		}

			
		?>            	
            <script type="text/javascript" language="javascript">
				alert("Despacho Registrado Satisfactoriamente.");
				location.href="../../sistema/ListaDespachos.php";
			</script>            
        <?			
																		
		
				
	}

?>