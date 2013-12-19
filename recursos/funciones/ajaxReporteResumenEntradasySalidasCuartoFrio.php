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
        echo "<div class='Reporte-titulo'>Resumen Entradas y Salidas Cuarto Frio </div>";
        echo "<div class='Reporte-fecha'><label>".$fecha."</label>";		
        echo "<div class='Reporte-flecha_izq' onclick='atras_resumen_ruta()'><img src='../recursos/imagenes/prev.png' style='margin-left:2px; margin-top:7px;' width='6' height='10' /></div>";
        echo "<div class='Reporte-flecha_der' onclick='adelante_resumen_ruta()'><img src='../recursos/imagenes/next.png' style='margin-right:2px; margin-top:7px;' width='6' height='10' /></div>";
        echo "</div>";
		
		echo "<div id='reporte' style='float:left; width:100%;'>";				
		?>	
            <div class="linea" style="border-bottom:0px;">
            	<div class="columa" style="width:24.5%;background:#84cff7">Nombre del Producto</div>
                <div class="columa" style="width:6%;background:#84cff7; text-align:center">Inicial</div>
                <div class="columa" style="width:6%;background:#84cff7; text-align:center">Devolucion</div>
                <div class="columa" style="width:6%;background:#84cff7; text-align:center">Ini. Total</div>   
                <div class="columa" style="width:6%;background:#84cff7; text-align:center">Producción</div> 
                <div class="columa" style="width:6%;background:#84cff7; text-align:center">Venta</div> 
                <div class="columa" style="width:6%;background:#84cff7; text-align:center">Donación</div>  
                <div class="columa" style="width:6%;background:#84cff7; text-align:center">Reciclado</div> 
                <div class="columa" style="width:6%;background:#84cff7; text-align:center">Votado</div> 
                <div class="columa" style="width:6%;background:#84cff7; text-align:center">Final</div>
            </div>                                     								
		<?
			$sql_productos="select * from producto order by idproducto;";
			$result_productos=pg_exec($con,$sql_productos);
			for($i=0;$i<pg_num_rows($result_productos);$i++){
				$producto=pg_fetch_array($result_productos,$i);
				
				if($producto[0]!=30){
				
				$sql_inventario="select * from inventarioproductos where idproducto='".$producto[0]."' and fecha='".date("Y-m-d",$fechaBuscada)."';";
				$result_inventario=pg_exec($con,$sql_inventario);
				$inventario=pg_fetch_array($result_inventario,0);
					
				if($i==0){
					echo "<div class='linea' style='border-top:0px;'>";
				}else if($i>0 && $i<(pg_num_rows($result_productos)-1)){
					echo "<div class='linea' >";
				}else if($i==(pg_num_rows($result_productos)-1)){
					echo "<div class='linea' style='border-bottom:1px solid #CCC'>";
				}
				            	
	            echo "<div class='columa' style='width:24.5%'>".$producto[2]."</div>";
	            echo "<div class='columa' style='width:6%; text-align:center'>".round($inventario[3],0)."</div>";
	            echo "<div class='columa' style='width:6%; text-align:center'>".round($inventario[4],0)."</div>";
	            echo "<div class='columa' style='width:6%; text-align:center'>".round($inventario[5],0)."</div>"; 
	            echo "<div class='columa' style='width:6%; text-align:center'>".round($inventario[6],0)."</div>";
	            echo "<div class='columa' style='width:6%; text-align:center'>".round($inventario[7],0)."</div>";
	            echo "<div class='columa' style='width:6%; text-align:center'>".round($inventario[8],0)."</div>"; 
	            echo "<div class='columa' style='width:6%; text-align:center'>".round($inventario[9],0)."</div>";
	            echo "<div class='columa' style='width:6%; text-align:center'>".round($inventario[10],0)."</div>";
	            echo "<div class='columa' style='width:6%; text-align:center'>".round($inventario[11],0)."</div>"; 								             	              
				echo "</div>";
				}
			}
																			
		echo "</div>";
		
	}

?>