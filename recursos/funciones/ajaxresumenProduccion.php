<?php session_start();
    require("funciones.php");
	$con = Conectarse();
	if($_POST["action"]==1){
		
		$fecha=strtotime($_POST["dia"]);
		
		if($_POST["ira"]==2){
			$fechaBuscada=$fecha+86400;
		}else if($_POST["ira"]==1){						
			$fechaBuscada=$fecha-86400;	
		}else if($_POST["ira"]==0){
			$fechaBuscada=$fecha;	
		}
		
		$fecha=FormatoDia(date("Y-m-d",$fechaBuscada));
        echo "<input type='hidden' name='dia_produccion' id='dia_produccion' value='".date("Y-m-d",$fechaBuscada)."' />";
        echo "<div class='Reporte-titulo'>Resumen Producción Diaria</div>";
        echo "<div class='Reporte-fecha'><label>".$fecha."</label>";		
        echo "<div class='Reporte-flecha_izq' onclick='atras_resumen_ruta()'><img src='../recursos/imagenes/prev.png' style='margin-left:2px; margin-top:7px;' width='6' height='10' /></div>";
        echo "<div class='Reporte-flecha_der' onclick='adelante_resumen_ruta()'><img src='../recursos/imagenes/next.png' style='margin-right:2px; margin-top:7px;' width='6' height='10' /></div>";
        echo "</div>";
		
		echo "<div id='reporte' style='float:left; width:100%;'>";
		
		$sql_leche="select * from inventarioleche where fecha='".date("Y-m-d",$fechaBuscada)."';";
		$result_leche=pg_exec($con,$sql_leche);
		$leche=pg_fetch_array($result_leche,0);
		
		?>
            <div class="linea">
            	<div class="columa" style="width:16%">Litros Iniciales</div>
                <div class="columa" style="width:8%; text-align:right"><?php echo $leche[2]; ?></div>
            </div>
       		<div class="linea">
            	<div class="columa" style="width:16%">Litros Recibidos</div>
                <div class="columa" style="width:8%; text-align:right"><?php echo $leche[3]; ?></div>
            </div> 
       		<div class="linea">
            	<div class="columa" style="width:16%">Litros Trabajados</div>
                <div class="columa" style="width:8%; text-align:right"><?php echo $leche[4]; ?></div>
            </div>            
       		<div class="linea" style="margin-bottom:15px;">
            	<div class="columa" style="width:16%; border-bottom:1px solid #CCC">Litros Finales</div>
                <div class="columa" style="width:8%; border-bottom:1px solid #CCC;; text-align:right"><?php echo $leche[7]; ?></div>
            </div>         
        <?		
		
		$sql_produccionesDia="select * from produccion where fecha ='".date("Y-m-d",$fechaBuscada)."';";
		$result_produccionesDia=pg_exec($con,$sql_produccionesDia);
		for($i=0;$i<pg_num_rows($result_produccionesDia);$i++){
			 $produccionDia=pg_fetch_array($result_produccionesDia,$i);
			 $sql_tipoProduccion="select * from tipoproducto where idtipoproducto='".$produccionDia[1]."'";
			 $result_tipoProduccion=pg_exec($con,$sql_tipoProduccion);
			 $tipoProduccion=pg_fetch_array($result_tipoProduccion,0);
		?>	
            <div class="linea"><label style="margin-left:1%"><?php echo $tipoProduccion[1]; ?></label></div>
            <div class="linea">
            	<div class="columa" style="width:20%;background:#84cff7">Nombre del Producto</div>
                <div class="columa" style="width:6%;background:#84cff7">Unidades</div>
                <div class="columa" style="width:6%;background:#84cff7">Kilogramos</div>
                <div class="columa" style="width:6%;background:#84cff7">KgxUnidad</div>                
            </div>                         						
		<?php
			$sql_productosEnProduccion=" select * from productosenproduccion where idproduccion='".$produccionDia[0]."'";
			$result_productosEnProduccion=pg_exec($con,$sql_productosEnProduccion);
			for($j=0;$j<pg_num_rows($result_productosEnProduccion);$j++){
				$productoEnProduccion=pg_fetch_array($result_productosEnProduccion,$j);
				$sql_producto="select * from producto where idproducto='".$productoEnProduccion[2]."';";
				$result_producto=pg_exec($con,$sql_producto);
				$producto=pg_fetch_array($result_producto,0);
				if($j<(pg_num_rows($result_productosEnProduccion)-1)){
				?>
            	<div class="linea">
	            	<div class="columa" style="width:20%;"><?php echo $producto[2]; ?></div>
	                <div class="columa" style="width:6%;"><?php echo $productoEnProduccion[3]; ?></div>
	                <div class="columa" style="width:6%;"><?php echo $productoEnProduccion[4]; ?></div>
	                <div class="columa" style="width:6%;"><?php echo $productoEnProduccion[5]; ?></div>                
	            </div>               
    	        <?php
				}else{
				?>
            	<div class="linea">
	            	<div class="columa" style="width:20%; border-bottom:1px solid #CCC"><?php echo $producto[2]; ?></div>
	                <div class="columa" style="width:6%; border-bottom:1px solid #CCC"><?php echo $productoEnProduccion[3]; ?></div>
	                <div class="columa" style="width:6%; border-bottom:1px solid #CCC"><?php echo $productoEnProduccion[4]; ?></div>
	                <div class="columa" style="width:6%; border-bottom:1px solid #CCC"><?php echo $productoEnProduccion[5]; ?></div>                
	            </div>               
    	        <?php										
				}
			}
			?>
			<div class="linea" style="margin-bottom:15px;"><label style="margin-left:1%;"><?php echo $produccionDia[3]; ?> litros que generaron <?php echo $produccionDia[4]; ?> kg a un promedio de <?php echo $produccionDia[5]; ?> Litros x Kg</label></div>			
		<?
		
		}
													
		echo "</div>";
		
	}

?>