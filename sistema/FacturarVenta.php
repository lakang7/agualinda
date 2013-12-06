<?php session_start(); 
      require("../recursos/funciones/funciones.php");
	  $con=Conectarse();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	fontStyles();
	cssStyles();
	jquerys();
?>

<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Facturación Venta</title>
<style type="text/css">

.reporte_ventas{
	float:left;
	margin-left:2%;
	width:auto;
	height:auto;	
	width:96%;
}

.Reporte-titulo{	
	padding-left:1%;
    float:left;
	width:99%;
	height:30px;
	background:#61380a;
	border:1px solid #21A010;
	font-family:'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	color:#FFF;
	line-height:30px;
	font-size:14px;	
	border-color: #0b67cd;		
	background:#0b67cd;
	margin-left:0px;
	margin-top:5px;
}

.Reporte-fecha{
    float:left;
	width:100%;
	height:25px;
	border:1px solid #CCC;
	line-height:25px;
	font-size:12px;	
	border-bottom:1px solid #CCC;			
	margin-left:0px;
	text-align:center;
	font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
	font-weight:900;
	margin-bottom:15px;	
}

.Reporte-flecha_izq{
	position:absolute;
    margin:0px;
	width:10px;
	height:25px;
	cursor:pointer;	
	margin-top:-25px;
}

.Reporte-flecha_der{
	position:absolute;
    margin:0px;
	width:10px;
	height:25px;
	cursor:pointer;	
	margin-top:-25px;
	margin-left:76%;
}


.contenedor_ventas{
	float:left;
	width:96%;
	border:1px solid #CCC;
	height:auto;
	margin-left:0%;
	margin-top:10px;
	border-bottom:0px;	
}

.venta{
	float:left;
	width:100%;
	height:35px;
	border-bottom:1px solid #CCC;
}

.venta:hover{
	float:left;
	width:100%;
	height:35px;
	border-bottom:1px solid #CCC;
	background:#EEE;
}

.venta_fecha{
	float:left;
	width:15%;
	height:35px;
	border-right:1px solid #CCC;
}

.venta_describe{
	float:left;
	width:30%;
	height:35px;
	border-right:1px solid #CCC;
}

.linea_describe{
	float:left;
	width:98%;
	height:35px;
	line-height:35px;
	font-size:12px;
	padding-left:2%;
	font-family: 'Oswald', sans-serif;
	/*border-bottom:1px solid #CCC;*/
	color:#666;
}

.linea_fecha_dia{
	float:left;
	width:100%;
	height:35px;
	/*border-bottom:1px solid #CCC;*/
	line-height:35px;
	text-align:center;
	font-size:12px;
	color:#666;
	font-family: 'Oswald', sans-serif;
}	

.venta_detalle{
	float:left;
	width:44%;
	height:35px;
	border-right:1px solid #CCC;
}	

.detalle{
	float:left;
	width:19.75%;
	height:35px;
	border-right:1px solid #CCC;
	color:#666;	
}

.detalle_arriba{
	float:left;
	width:100%;
	height:18px;
	line-height:20px;
	font-size:14px;
	font-family: 'Oswald', sans-serif;
	text-align:center;		
}

.detalle_abajo{
	float:left;
	width:100%;
	height:15px;
	line-height:15px;
	font-size:10px;
	font-family: 'Oswald', sans-serif;
	text-align:center;	
	color:#333;	
}

.venta_generar{
	float:left;
	width:3.4%;
	height:35px;
	border-right:1px solid #CCC;
	text-align:center;
	line-height:35px;
	font-family: 'Oswald', sans-serif;
	color:#666;			
}

.venta_generar:hover{
	float:left;
	width:3.4%;
	height:35px;
	border-right:1px solid #CCC;
	text-align:center;
	line-height:35px;
	font-family: 'Oswald', sans-serif;
	color:#666;	
	cursor:pointer;
	text-decoration:underline;		
}		

</style>
</head>

<body onload="ajustar()">
	<div class="barra1">
    	<div class="barra1_icon"><img src="../recursos/imagenes/CowLogo.PNG" width="45" height="40" /></div>
   	  	<div class="barra1_sistema">Sistema Para La Gestíón De La Industria Lactea</div>
	</div>
    <div class="barra2">
    	<div class="barra2_flecha"></div>                
        <div class="barra2_pantalla">Facturación Venta</div>
    </div>
    <div class="menu" id="menu">
    	<?php menu_interno(); ?>
    </div>
	<div class="cuerpo" id="cuerpo">

<div class="reporte_ventas" id="reporte_ventas"  >
		<?php
			$sql_selectHoy=" select current_date, extract(dow from current_date), extract(day from current_date), extract(month from current_date), extract(year from current_date);";
			$result_selectHoy=pg_exec($con,$sql_selectHoy);
			$hoy=pg_fetch_array($result_selectHoy,0);		
		?>
        <input type="hidden" name="dia_produccion" id="dia_produccion" value="<?php echo $hoy[0];?>" />
        <div class="Reporte-titulo">Lista de Ventas</div>
<div class="Reporte-fecha"><label><?php echo FormatoDia($hoy[0]); ?></label>
        	<div class="Reporte-flecha_izq" onclick="atras_resumen_ventas()"><img src="../recursos/imagenes/prev.png" style="margin-left:2px; margin-top:7px;" width="6" height="10" /></div>
            <div class="Reporte-flecha_der" onclick="adelante_resumen_ventas()"><img src="../recursos/imagenes/next.png" style="margin-right:2px; margin-top:7px;" width="6" height="10" /></div>
        </div>
        
        <div id="reporte" class="contenedor_ventas" style="float:left; width:100%;">

        

        
      <!--<div class="venta">
        	<div class="venta_fecha" >
            	<div class="linea_fecha_dia">21NOV2013</div>
            </div>
            <div class="venta_describe">
            	<div class="linea_describe">GLORIA URREA</div>
        </div>
            <div class="venta_detalle">
				<div class="detalle">
                	<div class="detalle_arriba">22300.12</div>
                    <div class="detalle_abajo">EXCENTO</div>
                </div>
				<div class="detalle">
                	<div class="detalle_arriba">4100.00</div>
                    <div class="detalle_abajo">GRAVABLE</div>
                </div>
				<div class="detalle">
                	<div class="detalle_arriba">27300.12</div>
                    <div class="detalle_abajo">SUB TOTAL</div>
                </div>
				<div class="detalle">
                	<div class="detalle_arriba">492.00</div>
                    <div class="detalle_abajo">TOTAL IVA</div>
                </div>
				<div class="detalle" style="border-right:0px;">
                	<div class="detalle_arriba" >27792.12</div>
                    <div class="detalle_abajo">MONTO TOTAL</div>
                </div>                                                                
            </div>
        </div>-->        
        
       		<?php 
			    $con=Conectarse();
				$sql_listarVentas="select * from venta where date(fecha)='".$hoy[0]."' order by fecha DESC;";
				$result_listarVentas=pg_exec($con,$sql_listarVentas);
				
			    for($i=0;$i<pg_num_rows($result_listarVentas);$i++){
					$venta=pg_fetch_array($result_listarVentas,$i);
					$sql_cliente="select * from cliente where idcliente='".$venta[2]."'";
					$result_cliente=pg_exec($con,$sql_cliente);
					$cliente=pg_fetch_array($result_cliente,0);
					
					$sql_ubicacion="select * from ubicacion where idubicacion='".$venta[1]."'";
					$result_ubicacion=pg_exec($con,$sql_ubicacion);
					$ubicacion=pg_fetch_array($result_ubicacion,0);					
					
					$sql_precio="select * from tipoprecio where idtipoprecio='".$venta[5]."'";
					$result_precio=pg_exec($con,$sql_precio);
					$precio=pg_fetch_array($result_precio,0);						
					
        			echo"<div class='venta'>";
		        	echo"<div class='venta_fecha' >";
	            	echo"<div class='linea_fecha_dia'>".$ubicacion[1].$precio[1]."</div>";
		            echo"</div>";
		            echo"<div class='venta_describe'>";
	            	echo"<div class='linea_describe'>".strtoupper($cliente[1])."</div>";
		            echo"</div>";
		            echo"<div class='venta_detalle'>";
					echo"<div class='detalle'>";
                	echo"<div class='detalle_arriba'>".$venta[7]."</div>";
                    echo"<div class='detalle_abajo'>EXCENTO</div>";
    	            echo"</div>";
					echo"<div class='detalle'>";
                	echo"<div class='detalle_arriba'>".$venta[8]."</div>";
                    echo"<div class='detalle_abajo'>GRAVABLE</div>";
	                echo"</div>";
					echo"<div class='detalle'>";
                	echo"<div class='detalle_arriba'>".$venta[9]."</div>";
                    echo"<div class='detalle_abajo'>SUB TOTAL</div>";
    	            echo"</div>";
					echo"<div class='detalle'>";
                	echo"<div class='detalle_arriba'>".$venta[10]."</div>";
                    echo"<div class='detalle_abajo'>TOTAL IVA</div>";
	                echo"</div>";
					echo"<div class='detalle' style='border-right:0px;'>";
                	echo"<div class='detalle_arriba' >".$venta[11]."</div>";
                    echo"<div class='detalle_abajo'>MONTO TOTAL</div>";
    	            echo"</div>";                        
        		    echo"</div>";
					if($venta[3]==1){
						echo"<a href='../reportes/notaDeEntrega.php?idventa=".$venta[0]."'><div class='venta_generar' title='Nota de Entrega'>NE</div></a>";
					}if($venta[3]==2||$venta[3]==3){
		            	echo"<a href='../reportes/notaDeEntrega.php?idventa=".$venta[0]."'><div class='venta_generar' title='Nota de Entrega'>NE</div></a>";
			            echo"<a href='../reportes/FacturaVenta.php?idventa=".$venta[0]."'><div class='venta_generar' title='Factura'>FA</div></a>";						
					}if($venta[3]==4){
			            echo"<a href='../reportes/notaDeEntrega.php?idventa=".$venta[0]."'><div class='venta_generar' title='Nota de Entrega'>NE</div></a>";
			            echo"<a href='../reportes/FacturaVenta.php?idventa=".$venta[0]."'><div class='venta_generar' title='Factura'>FA</div></a>";
			            echo"<div class='venta_generar' title='Cadena en Frio' style='border-right:0px;'>CF</div>";						
					}
			        echo"</div>";
				}
			?>
                   
            
        </div><!--finaliza reporte -->          
	</div>

    </div>                   
	<div class="pie"></div>
</body>
<script type="text/javascript" language="javascript">
    	  
  function ajustar(){	  
	  $("#menu").css("height", $("#cuerpo").css("height"));  
  }
  
	function adelante_resumen_ventas(){	
		$("#reporte_ventas").load("../recursos/funciones/ajaxFacturarVentas.php", {action: 1, dia:document.getElementById("dia_produccion").value, ira: 2},function(){
			ajustar();	
		});				
	}
	
	function atras_resumen_ventas(){	
		$("#reporte_ventas").load("../recursos/funciones/ajaxFacturarVentas.php", {action: 1, dia:document.getElementById("dia_produccion").value, ira: 1},function(){
			ajustar();	
		});				
	}	  
  
</script>
</html>