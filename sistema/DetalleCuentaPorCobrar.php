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


<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalle Cuentas Por Cobrar</title>
<style>
	.linea_titulo{
		float:left;
		width:95.5%;
		margin-left:2%;
		height:20px;
		border:1px solid #666;
		font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
		padding-left:0.5%;	
		font-size:12px;
		line-height:20px;
		background:#84cff7;
	}
	.linea{
		float:left;
		width:96%;
		margin-left:2%;
		height:20px;
		border:1px solid #666;
		border-top:0px;
		font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;			
		font-size:12px;
		line-height:20px;
	}	
	
	.atras{
		position:absolute;
		width:6%;
		height:20px;
		border:1px solid #666;
		margin-left:1.6%;	
		text-align:center;
		font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
		line-height:20px;
		cursor:pointer;
		/*background:#84cff7;*/	
	}
	
	.adelante{
		position:absolute;
		width:6%;
		height:20px;
		border:1px solid #666;
		margin-left:8.3%;	
		text-align:center;
		font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
		line-height:20px;
		cursor:pointer;
		/*background:#84cff7;*/		
	}	
	
	.linea_columna{
		float:left;
		height:20px;
		line-height:20px;
		font-size:11px;
		font-family: 'Segoe UI Semilight', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;
		border-right:1px solid #666;
		padding-left:0.5%;	
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
        <div class="barra2_pantalla">Detalle Cuentas Por Cobrar</div>
    </div>
    <div class="menu" id="menu">
    	<?php menu_interno(); ?>
    </div>
	<div class="cuerpo" id="cuerpo">
    	<?php
			$con=Conectarse();			
			$sql_detalle="select cuentaporcobrar.idcuentaporcobrar, venta.idventa, cliente.idcliente, cliente.nombre, ubicacion.idubicacion, ubicacion.ciudad, venta.tipoventa, venta.tipopago, tipoprecio.idtipoprecio, tipoprecio.descripcion, cuentaporcobrar.montototal, cuentaporcobrar.cancelado, cuentaporcobrar.restante, cuentaporcobrar.estatus, venta.fecha, ((cuentaporcobrar.cancelado*100)/cuentaporcobrar.montototal) as porcentaje from tipoprecio, ubicacion, cuentaporcobrar, cliente, venta where cuentaporcobrar.idventa = venta.idventa and venta.idcliente = cliente.idcliente and venta.idubicacion = ubicacion.idubicacion and tipoprecio.idtipoprecio = venta.tipoprecio and cuentaporcobrar.idcuentaporcobrar='".$_GET["id"]."';";	
			$result_detalle=pg_exec($con,$sql_detalle);
			$detalle=pg_fetch_array($result_detalle,0);		
		
		
			$secuencia=explode("-",$_SESSION["porCobrar"]);
			$atras="";
			$adelante="";
			for($i=0;$i<(sizeof($secuencia)-1);$i++){
				if($secuencia[$i]==$_GET["id"]){
					if(($i-1)>=0){
						$atras=$secuencia[($i-1)];	
					}
					if(($i+1)<=(sizeof($secuencia)-1)){
						$adelante=$secuencia[($i+1)];	
					}
				}				
			}
					
		?>
        
		<?php 
			if($atras!=""){
				echo "<div class='atras'><a href='DetalleCuentaPorCobrar.php?id=".$atras."' style='text-decoration:none; color:#333'>Anterior</a></div>";			
			}else{
				echo "<div class='atras'>Anterior</div>";	
			}
			
			if($adelante!=""){
				echo "<div class='adelante'><a href='DetalleCuentaPorCobrar.php?id=".$adelante."' style='text-decoration:none; color:#333'>Siguiente</a></div>";
			}else{
				echo "<div class='adelante'>Siguiente</div>";
			}
		
		?>
                
 		<div class="linea_titulo" style="margin-top:30px;">Detalle de La Venta</div>
        <div class="linea" >
        	<div class="linea_columna" style="width:13%">Fecha: <?php echo substr($detalle[14],0,10) ?></div>
            <div class="linea_columna" style="width:33%">Cliente: <?php echo $detalle[3]; ?></div>
            <div class="linea_columna" style="width:32%">Ubicación: <?php echo $detalle[5]; ?></div>
            <div class="linea_columna" style="width:19%; border-right:0px;">Tipo Precio: <?php echo $detalle[9]; ?></div>
        </div>
        <div class="linea_titulo" style="padding-left:0px; width:96%; margin-top:20px;">
        	<div class="linea_columna" style="width:8%; text-align:center">Codigo</div>
            <div class="linea_columna" style="width:19.5%; text-align:center">Descripcion</div>
            <div class="linea_columna" style="width:4%; text-align:center">UMS</div>
        	<div class="linea_columna" style="width:8%; text-align:center">C.Stock</div>
            <div class="linea_columna" style="width:4%; text-align:center">UMV</div>
            <div class="linea_columna" style="width:8%; text-align:center">C.Venta</div>
        	<div class="linea_columna" style="width:8%; text-align:center">Precio</div>
            <div class="linea_columna" style="width:8%; text-align:center">Sub Total</div>
            <div class="linea_columna" style="width:4%; text-align:center">%D1</div> 
            <div class="linea_columna" style="width:4%; text-align:center">%D2</div>
            <div class="linea_columna" style="width:4%; text-align:center">%D3</div>                                               
            <div class="linea_columna" style="width:4%; text-align:center">%IVA</div>
            <div class="linea_columna" style="width:8%; border-right:0px; text-align:center">Total Item</div>           
        </div>
        
        <?
	$sql_productosxVenta="select * from productosxventa where idventa='".$detalle[1]."'";
	$result_productosxventa=pg_exec($con,$sql_productosxVenta);
	for($i=0;$i<pg_num_rows($result_productosxventa);$i++){
		$producto_venta=pg_fetch_array($result_productosxventa,$i);
		$sql_producto="select * from producto where idproducto='".$producto_venta[1]."'";
		$result_producto=pg_exec($con,$sql_producto);
		$producto=pg_fetch_array($result_producto,0);

        echo "<div class='linea' style='border-top:0px; padding-left:0px; width:96%'>";
        echo "<div class='linea_columna' style='width:8%'>".Codigo("PRO",$producto[0])."</div>";
        echo "<div class='linea_columna' style='width:19.5%'>".$producto[2]."</div>";
        echo "<div class='linea_columna' style='width:4%; text-align:center'>Und</div>";
        echo "<div class='linea_columna' style='width:8%;text-align:right;padding-left:0px;padding-right:0.5%'>".$producto_venta[3]."</div>";
		if($producto[5]==1){
			echo "<div class='linea_columna' style='width:4%; text-align:center'>Kgr</div>";
		}else{
			echo "<div class='linea_columna' style='width:4%; text-align:center'>Und</div>";
		}
		        
        echo "<div class='linea_columna' style='width:8%;text-align:right;padding-left:0px;padding-right:0.5%'>".$producto_venta[4]."</div>";
        echo "<div class='linea_columna' style='width:8%;text-align:right;padding-left:0px;padding-right:0.5%'>".$producto_venta[5]."</div>";
        echo "<div class='linea_columna' style='width:8%;text-align:right;padding-left:0px;padding-right:0.5%'>".$producto_venta[6]."</div>";
        echo "<div class='linea_columna' style='width:4%; text-align:center'>0.00</div>";
        echo "<div class='linea_columna' style='width:4%; text-align:center'>0.00</div>";
        echo "<div class='linea_columna' style='width:4%; text-align:center'>0.00</div>";                                              
        echo "<div class='linea_columna' style='width:4%; text-align:center'>".$producto_venta[7]."</div>";
        echo "<div class='linea_columna' style='width:8%; border-right:0px; text-align:right '>".$producto_venta[8]."</div>";
        echo "</div>";	
	}  		
	
	?> 
    <div class="linea">
    	<?php
			$sql_detalleVenta="select * from venta where idventa='".$detalle[1]."'";
			$result_detalleVenta=pg_exec($con,$sql_detalleVenta);
			$detalleVenta=pg_fetch_array($result_detalleVenta,0);								
		?>
        <div class="linea_columna" style="width:42.5%; border-right:0px;"></div>
        <div class="linea_columna" style="width:8%; border-right:0px;">Excento:</div>
        <div class="linea_columna" style="width:8%; border-right:0px;"><?php echo $detalleVenta[7] ?></div>
        <div class="linea_columna" style="width:8%; border-right:0px;">Gravable:</div>
        <div class="linea_columna" style="width:8%; border-right:0px;"><?php echo $detalleVenta[8] ?></div>     
        <div class="linea_columna" style="width:12%; border-right:0px;">Sub Total</div>
        <div class="linea_columna" style="width:1%; border-right:0px;">:</div>
        <div class="linea_columna" style="width:8%; text-align:right;border-right:0px;"><?php echo $detalleVenta[9] ?></div>              
    </div>    
    <div class="linea">
        <div class="linea_columna" style="width:42.5%; border-right:0px;"></div>
        <div class="linea_columna" style="width:8%; border-right:0px;"></div>
        <div class="linea_columna" style="width:8%; border-right:0px;"></div>
        <div class="linea_columna" style="width:8%; border-right:0px;"></div>
        <div class="linea_columna" style="width:8%; border-right:0px;"></div>     
        <div class="linea_columna" style="width:12%; border-right:0px;">Total Desc</div>
        <div class="linea_columna" style="width:1%; border-right:0px;">:</div>
        <div class="linea_columna" style="width:8%; text-align:right;border-right:0px;">0.00</div>              
    </div> 
    <div class="linea">
        <div class="linea_columna" style="width:42.5%; border-right:0px;"></div>
        <div class="linea_columna" style="width:8%; border-right:0px;"></div>
        <div class="linea_columna" style="width:8%; border-right:0px;"></div>
        <div class="linea_columna" style="width:8%; border-right:0px;"></div>
        <div class="linea_columna" style="width:8%; border-right:0px;"></div>     
        <div class="linea_columna" style="width:12%; border-right:0px;">Total IVA 12.00%</div>
        <div class="linea_columna" style="width:1%; border-right:0px;">:</div>
        <div class="linea_columna" style="width:8%; text-align:right;border-right:0px;"><?php echo $detalleVenta[10] ?></div>              
    </div>           
    <div class="linea">
        <div class="linea_columna" style="width:42.5%; border-right:0px;"></div>
        <div class="linea_columna" style="width:8%; border-right:0px;"></div>
        <div class="linea_columna" style="width:8%; border-right:0px;"></div>
        <div class="linea_columna" style="width:8%; border-right:0px;"></div>
        <div class="linea_columna" style="width:8%; border-right:0px;"></div>     
        <div class="linea_columna" style="width:12%; border-right:0px;">Monto Total BSF</div>
        <div class="linea_columna" style="width:1%; border-right:0px;">:</div>
        <div class="linea_columna" style="width:8%; text-align:right;border-right:0px;"><?php echo $detalleVenta[11] ?></div>              
    </div>           
    
    <div class="linea_titulo" style="margin-top:20px;">Detalle de La Cuenta por Cobrar</div>   
    <div class="linea" >
        <div class="linea_columna" style="width:20%">Monto Total: <?php echo $detalle[10] ?></div>
        <div class="linea_columna" style="width:20%">Monto Cancelado: <?php echo $detalle[11]; ?></div>
        <div class="linea_columna" style="width:20%">Monto Restante: <?php echo $detalle[12]; ?></div>
        <div class="linea_columna" style="width:19%; border-right:0px;">Porcentaje Cancelado: <?php echo round($detalle[15],2)." %"; ?></div>
    </div>

        <div class="linea_titulo" style="padding-left:0px; width:96%; margin-top:20px;">
        	<div class="linea_columna" style="width:10%; text-align:center">Fecha</div>
            <div class="linea_columna" style="width:12.5%; text-align:center">Tipo Pago</div>
            <div class="linea_columna" style="width:22%; text-align:center">Banco de Origen</div>
        	<div class="linea_columna" style="width:23%; text-align:center">Cuenta Destino</div>
            <div class="linea_columna" style="width:10%; text-align:center">Identificador</div>
            <div class="linea_columna" style="width:9%; text-align:center">Monto</div>
        	<div class="linea_columna" style="width:9%; text-align:center; border-right:0px">Abonado</div>          
        </div>  
        
        <?php
			$con=Conectarse();
			$sql_selectAbono="select * from abono where idcuentaporcobrar='".$_GET["id"]."'";
			$result_selectAbono=pg_exec($con,$sql_selectAbono);
			for($i=0;$i<pg_num_rows($result_selectAbono);$i++){
				$abono=pg_fetch_array($result_selectAbono,$i);
				$sql_detallePago="select * from abonocuentaporcobrar where idabonocuentaporcobrar='".$abono[2]."'";
				$result_detallePago=pg_exec($con,$sql_detallePago);
				$detallePago=pg_fetch_array($result_detallePago,0);
				
				if($detallePago[4]==3 || $detallePago[4]==4){
					$sql_banco="select * from banco where idbanco='".$detallePago[2]."'";
					$result_banco=pg_exec($con,$sql_banco);
					$banco=pg_fetch_array($result_banco,0);
				}
				
				if($detallePago[4]==2 || $detallePago[4]==3 || $detallePago[4]==4){
					$sql_cuenta="select * from cuenta where idcuenta='".$detallePago[3]."'";
					$result_cuenta=pg_exec($con,$sql_cuenta);
					$cuenta=pg_fetch_array($result_cuenta);
					$sql_bancoCuenta="select * from banco where idbanco='".$cuenta[1]."'";
					$result_bancoCuenta=pg_exec($con,$sql_bancoCuenta);
					$bancoCuenta=pg_fetch_array($result_bancoCuenta,0);
				}
				
				echo "<div class='linea'>";
				echo "<div class='linea_columna' style='width:10%; text-align:center'>".substr($detallePago[5],0,10)."</div>";
				if($detallePago[4]==1){
					echo "<div class='linea_columna' style='width:12.5%; text-align:center'>Efectivo</div>";
					echo "<div class='linea_columna' style='width:22%; text-align:center'></div>";
					echo "<div class='linea_columna' style='width:23%; text-align:center'></div>";
				}
				if($detallePago[4]==2){
					echo "<div class='linea_columna' style='width:12.5%; text-align:center'>Deposito</div>";
					echo "<div class='linea_columna' style='width:22%; text-align:center'></div>";
					echo "<div class='linea_columna' style='width:23%; text-align:center' title='".$bancoCuenta[1]."'>".$cuenta[4]."</div>";
				}
				if($detallePago[4]==3){
					echo "<div class='linea_columna' style='width:12.5%; text-align:center'>Transferencia</div>";
					echo "<div class='linea_columna' style='width:22%; text-align:center'>".$banco[1]."</div>";
					echo "<div class='linea_columna' style='width:23%; text-align:center' title='".$bancoCuenta[1]."'>".$cuenta[4]."</div>";
				}
				if($detallePago[4]==4){
					echo "<div class='linea_columna' style='width:12.5%; text-align:center'>Cheque</div>";
					echo "<div class='linea_columna' style='width:22%; text-align:center'>".$banco[1]."</div>";
					echo "<div class='linea_columna' style='width:23%; text-align:center' title='".$bancoCuenta[1]."'>".$cuenta[4]."</div>";
				}												
            	
	            
	        	
	            echo "<div class='linea_columna' style='width:10%; text-align:center'>".$detallePago[7]."</div>";
	            echo "<div class='linea_columna' style='width:9%; text-align:right; padding-left:0%; padding-right:0.5%'>".number_format(round($detallePago[6],2),2,'.','')."</div>";
	        	echo "<div class='linea_columna' style='width:9%; text-align:right; padding-left:0%; padding-right:0.5%; border-right:0px'>".number_format(round($abono[3],2),2,'.','')."</div>";
				echo "</div>";
			}
		?>
        	        
              
               
    </div>               
	<div class="pie" style=""></div>
</body>
<script type="text/javascript" language="javascript">
     
  function ajustar(){	  
	  $("#menu").css("height", $("#cuerpo").css("height"));  
  }
  
</script>
</html>