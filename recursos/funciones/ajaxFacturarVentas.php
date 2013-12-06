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
        echo "<div class='Reporte-titulo'>Lista de Ventas</div>";
        echo "<div class='Reporte-fecha'><label>".$fecha."</label>";		
        echo "<div class='Reporte-flecha_izq' onclick='atras_resumen_ventas()'><img src='../recursos/imagenes/prev.png' style='margin-left:2px; margin-top:7px;' width='6' height='10' /></div>";
        echo "<div class='Reporte-flecha_der' onclick='adelante_resumen_ventas()'><img src='../recursos/imagenes/next.png' style='margin-right:2px; margin-top:7px;' width='6' height='10' /></div>";
        echo "</div>";		
		
        echo "<div id='reporte' class='contenedor_ventas' style='float:left; width:100%;'>";
       		
                   
            
        echo "</div>";
		
		
	}

	

?>