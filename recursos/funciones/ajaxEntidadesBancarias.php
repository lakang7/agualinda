<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?

    require("funciones.php");
    $con=Conectarse();			
	
	if($_GET["action"]==1){ //Agregar Nuevo Banco		   	  
		$con=Conectarse();
		$sql_consulta_nombres = "select nombre from banco;";
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
			$sql_insert_banco="insert into banco values(nextval('banco_idbanco_seq'),'".$_POST["nombre1"]."',now(),".$_POST["estatus1"].")";
			$result_insert_banco=pg_exec($con,$sql_insert_banco);						
			if($result_insert_banco!=NULL){
				?>                    
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo $_POST["nombre1"]." Agregado Satisfactoriamente." ?>");
						location.href="../../sistema/EntidadesBancarias.php"; 
                    </script>
		        <?			
			}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo "Ocurrio un problema agragando '".$_POST["nombre1"] ?>");
						location.href="../../sistema/EntidadesBancarias.php";                     
                    </script>
		        <?		
			}						
		}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo $_POST["nombre1"]." ya se encuentra registrado en la base datos." ?>");
						location.href="../../sistema/EntidadesBancarias.php"; 						
                    </script>
		        <?									
		}	  
	}
	
	if($_POST["action"]==2){  //ver detalle de banco
	     $sql_select_banco="select * from banco where idbanco='".$_POST["identificador"]."'";
		 $result_select_banco=pg_exec($con,$sql_select_banco);
		 $banco=pg_fetch_array($result_select_banco,0);
	?>
		<div class='tabla-detalle-contenedor'>  
    			<div class="detalle-titulo">Detalle de Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:15%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo Codigo("BAN",$banco[0]); ?>" id="codigo2" name="codigo2" class="entrada" disabled="disabled" style="width:97%;" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Nombre del Banco (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $banco[1]; ?>" id="nombre2" name="nombre2" class="entrada" disabled="disabled" style="width:97%;" maxlength="60" /></div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:15%;">                    
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo date("d-m-Y",strtotime($banco[2])); ?>" id="fecha2" name="fecha2" class="entrada" disabled="disabled" style="width:97%;" /></div>
                    </div>  
                	<div class="detalle-linea-elemento" style="width:22%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:98%;">Estatus (*)</div>
  						<div id="estatus2" style="font-size:8px; width:98%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                            <?php
							    if($banco[3]==1){
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
                <div class="detalle-indica">Los campos indicados con (*) son Obligatotios</div>                                  
	        </div>
	<?	    	
	}
	
	if($_POST["action"]==3){  //Generar Formulario Para Registro
		?>
                                
			<div class='tabla-detalle-contenedor'>  
            	<form name="formagregabanco" id="formagregabanco" method="post" action="../recursos/funciones/ajaxEntidadesBancarias.php?action=1" >
    			<div class="detalle-titulo">Agregar Nuevo Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:15%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="codigo1" name="codigo1" class="entrada" disabled="disabled" style="width:97%;" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Nombre del Banco (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="nombre1" name="nombre1" class="entrada" style="width:97%;" maxlength="60" /></div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:15%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" id="fecha1" name="fecha1" class="entrada" disabled="disabled" style="width:97%;" /></div>
                    </div>  
                	<div class="detalle-linea-elemento" style="width:22%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:98%;">Estatus (*)</div>
  						<div id="estatus1" style="font-size:8px; width:98%; margin-top:1px;" class="detalle-linea-elemento-abajo">
						    <input type="radio" id="radio1" name="estatus1" value="1" checked="checked" /><label for="radio1">Habilitado</label>
						    <input type="radio" id="radio2" name="estatus1" value="2"  /><label for="radio2">Deshabilitado</label>
					    </div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:8%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;"></div>
                        <div class="detalle-linea-elemento-abajo" style="font-size:8px; width:100%;"><input type="button" value="Guardar" onclick="agregarbanco()" /></div>
                    </div>                                                                                                
                </div>
                <div class="detalle-indica">Los campos indicados con (*) son Obligatotios</div>                                  
	        	</form> 
            </div>                        
               
        <?
	}
	
	
	if($_POST["action"]==4){  //formulario para editar registro
	     $sql_select_banco="select * from banco where idbanco='".$_POST["identificador"]."'";
		 $result_select_banco=pg_exec($con,$sql_select_banco);
		 $banco=pg_fetch_array($result_select_banco,0);
	?>
         
		<div class='tabla-detalle-contenedor'>  
        	<form name="formeditarbanco" id="formeditarbanco" method="post" action="../recursos/funciones/ajaxEntidadesBancarias.php?action=5"  >
    			<div class="detalle-titulo">Editar Registro<div class="detalle-titulo-cerrar" title="Cerrar Formulario" onclick="cerrar()"></div></div>
                <div class="detalle-linea">
                	<div class="detalle-linea-elemento" style="width:15%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Código</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo Codigo("BAN",$banco[0]); ?>" id="codigo3" name="codigo3" class="entrada" readonly='readonly' style="width:97%;  background:#EFEFEF" /></div>
                    </div>
                	<div class="detalle-linea-elemento" style="width:35%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Nombre del Banco (*)</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo $banco[1]; ?>" id="nombre3" name="nombre3" class="entrada" style="width:97%;" maxlength="60" /></div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:15%;">                    
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;">Fecha de Registro</div>
                        <div class="detalle-linea-elemento-abajo"><input type="text" value="<?php echo date("d-m-Y",strtotime($banco[2])); ?>" id="fecha3" name="fecha3" readonly='readonly' class="entrada" style="width:97%;  background:#EFEFEF" /></div>
                    </div>  
                	<div class="detalle-linea-elemento" style="width:22%;">
                    	<div class="detalle-linea-elemento-arriba" style="width:98%;">Estatus (*)</div>
  						<div id="estatus3" style="font-size:8px; width:98%; margin-top:1px;" class="detalle-linea-elemento-abajo">
                            <?php
							    if($banco[3]==1){
						   			echo "<input type='radio' id='radio1' name='estatus3' value='1' checked='checked' /><label for='radio1'>Habilitado</label>";
						    		echo "<input type='radio' id='radio2' name='estatus3' value='2' /><label for='radio2'>Deshabilitado</label>";									
								}else{
						   			echo "<input type='radio' id='radio1' name='estatus3' value='1' /><label for='radio1'>Habilitado</label>";
						    		echo "<input type='radio' id='radio2' name='estatus3' value='2'  checked='checked' /><label for='radio2'>Deshabilitado</label>";									
								}
							?>

					    </div>
                    </div> 
                	<div class="detalle-linea-elemento" style="width:8%; margin-left:0%">
                    	<div class="detalle-linea-elemento-arriba" style="width:100%;"></div>
                        <div class="detalle-linea-elemento-abajo" style="font-size:8px; width:100%;"><input type="button" value="Guardar" onclick="editarbanco()" /></div>
                    </div>                                                                                           
                </div>
                <div class="detalle-indica">Los campos indicados con (*) son Obligatotios</div>                                  
	        </form>
            </div>
            
	<?	    	
	}	
	
	if($_GET["action"]==5){ /*Editar Registro*/	
		$con=Conectarse();
		$sql_consulta_nombres = "select nombre from banco where idbanco!= '".InversaCodigo($_POST["codigo3"])."';";
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
		    $sql_update_banco="update banco set nombre='".$_POST["nombre3"]."', estatus='".$_POST["estatus3"]."' where idbanco ='".InversaCodigo($_POST["codigo3"])."' ";		
			$result_update_banco=pg_exec($con,$sql_update_banco);			
			if($result_update_banco!=NULL){
				?>                	
		        	<script type="text/javascript" language="javascript">
						alert("<?php echo "Banco Editado Satisfactoriamente."; ?>");
						location.href="../../sistema/EntidadesBancarias.php"; 
                    </script>
		        <?			
			}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo "Ocurrio un problema Editando el banco." ?>");
						location.href="../../sistema/EntidadesBancarias.php"; 
                    </script>
		        <?		
			}						
		}else{
				?>
		        	<script type="text/javascript" language="javascript"> 
						alert("<?php echo $_POST["nombre3"]." ya se encuentra registrado en la base datos." ?>");
						location.href="../../sistema/EntidadesBancarias.php"; 
                    </script>
		        <?									
		}		 
		 

	}
	
	if($_POST["action"]==6){
		
        echo "<div class='tabla-cabecera'>";
       	  	echo "<div class='tabla-cabecera-elemento' style='width:19%;'>Código";
            if($_POST["filtro_orden"]=="idbanco" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="idbanco" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}			
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('idbanco','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('idbanco','desc')></div>";
            echo "</div>";
          	echo "</div>";   
			     
       	  	echo "<div class='tabla-cabecera-elemento' style='width:79%; border-right:0px;'>Nombre del Banco";
            if($_POST["filtro_orden"]=="nombre" && $_POST["orden"]=="asc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/1.png' style='position:absolute;' width='16' height='18' />";
			}else
            if($_POST["filtro_orden"]=="nombre" && $_POST["orden"]=="desc"){				
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/2.png' style='position:absolute;' width='16' height='18' />";
			}else{
				echo "<div class='tabla-cabecera-elemento-flechas'><img src='../recursos/imagenes/0.png' style='position:absolute;' width='16' height='18' />";
			}							
            echo "<div class='tabla-cabecera-elemento-flechas_arriba' title='Ordenar Ascendentemente' onclick=actualizar_filtros('nombre','asc')></div>";
            echo "<div class='tabla-cabecera-elemento-flechas_abajo' title='Ordenar Descendentemente' onclick=actualizar_filtros('nombre','desc')></div>";
            echo "</div>";
          	echo "</div>";                                                           
       echo " </div>";	
	   
	    echo "<input type='hidden' name='filtro' id='filtro' value='".$_POST["filtro_orden"]."' />";
        echo "<input type='hidden' name='orden' id='orden' value='".$_POST["orden"]."' />";
        echo "<input type='hidden' name='filtro2' id='filtro2' value='".$_POST["filtro_busqueda"]."' />";
        echo "<input type='hidden' name='clave_bus' id='clave_bus' value='".$_POST["clave"]."' />";
        
		$sql_bancos="select * from banco ";
		if($_POST["filtro_busqueda"]!="0" && $_POST["clave"]!="" ){
			if($_POST["filtro_busqueda"]=="idbanco"){
				$sql_bancos = $sql_bancos." where idbanco = ".$_POST["clave"]." ";
			}else
			if($_POST["filtro_busqueda"]=="nombre"){
				$sql_bancos = $sql_bancos." where nombre ilike '%".$_POST["clave"]."%' ";
			}			
		}
		
		if($_POST["filtro_orden"]!=""){
			$sql_bancos = $sql_bancos." order by ".$_POST["filtro_orden"]." ".$_POST["orden"];
		}else{
			$sql_bancos = $sql_bancos." order by idbanco";
		}
				
			$result_banco=pg_exec($con,$sql_bancos);
			if(pg_num_rows($result_banco)>0){
				for($i=(($_POST["pagina"]*$_POST["muestra"])-$_POST["muestra"]);$i<pg_num_rows($result_banco) && $i<($_POST["pagina"] * $_POST["muestra"]);$i++){
					$banco=pg_fetch_array($result_banco,$i);																																							
			    	echo "<div class='tabla-linea'>";
		        	echo "<div class='tabla-linea-elemento' style='width:19%;'>".Codigo("BAN",$banco[0])."</div>";
		            echo "<div class='tabla-linea-elemento' style='width:69%;'>".$banco[1]."</div>";
		            echo "<div class='tabla-linea-elemento' id='linea".$banco[0]."' onclick='detalle(".$banco[0].")' style='width:20px;background:url(../recursos/imagenes/list_metro.png) no-repeat center center; cursor:pointer;' title='Ver Detalle'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='editar(".$banco[0].")' style='width:20px;background:url(../recursos/imagenes/edit.png) no-repeat center center; cursor:pointer;' title='Editar Registro'></div>";
		            echo "<div class='tabla-linea-elemento' onclick='eliminarbanco(".$banco[0].")' style='width:20px;background:url(../recursos/imagenes/delete.png) no-repeat center center; cursor:pointer; border-right:0px;' title='Eliminar Registro'></div>";
			        echo "</div>";
			        echo "<div class='tabla-detalle' id='detalle".$banco[0]."' style='display: none'>";
		        	echo "<div class='tabla-detalle-contenedor'>										
					</div>";
			        echo "</div>";										
				}				
			}else{
				
			}	
			
            echo "<div class='tabla-pie'>";      	
            echo "<div class='tabla-pie-tabulador' title='Ir a la primera página' onclick=cambiar_pagina(1)><<</div>";
            echo "<div class='tabla-pie-tabulador' title='Ir una página atras' onclick=cambiar_pagina(2)><</div>";      
            echo "<div class='tabla-pie-actual'>Página <label id='pagina_actual'>".$_POST["pagina"]."</label>/<label id='total_paginas'>".ceil(pg_num_rows($result_banco)/$_POST["muestra"])."</label></div>";
            echo "<div class='tabla-pie-tabulador' title='Ir una página adelante' onclick=cambiar_pagina(3)>></div>";
            echo "<div class='tabla-pie-tabulador' title='Ir a la última página' onclick=cambiar_pagina(4)>>></div>";          
        	
            
            echo "<div class='tabla-pie-elemento'>";
            echo "<div class='tabla-pie-elemento-etiqueta'>Ir a la Página</div>";
            echo "<div class='tabla-pie-elemento-select'>";
            echo "<select name='selector_pagina' id='selector_pagina' onchange='paginar()'>";
						    $indice= ceil(pg_num_rows($result_banco)/$_POST["muestra"]);
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
			if(pg_num_rows($result_banco)>=($_POST["pagina"]*$_POST["muestra"])){
				$limite=$_POST["pagina"]*$_POST["muestra"];
			}else{
				$limite=(($_POST["pagina"]-1)*$_POST["muestra"])+ ( pg_num_rows($result_banco) - (($_POST["pagina"]-1)*$_POST["muestra"])) ;	
			}
			
            echo "<div class='tabla-pie-actual' style='float:right; margin-right:5px;'>Mostrando ".((($_POST["pagina"]*$_POST["muestra"])-$_POST["muestra"])+1)." - ".$limite." de ".pg_num_rows($result_banco)."</div>";
        echo "</div>";    
    echo "</div>";								
	}
	
	if($_GET["action"]==7){ //Eliminar registro
		?>
		     <script type="text/javascript" language="javascript">location.href="../../sistema/EntidadesBancarias.php"; </script>
		<?			
	}

  
?>