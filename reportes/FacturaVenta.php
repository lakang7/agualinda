<?php session_start();   
	  include("../recursos/clases/FPDF/fpdf.php");
	  header("Content-Type: text/html; charset=iso-8859-1");
      require("../recursos/funciones/conexion.php");
	  $con=Conectarse();	
	  
	  $sql_venta="select * from venta where idventa='".$_GET["idventa"]."'";
	  $result_venta=pg_exec($con,$sql_venta);
	  $venta=pg_fetch_array($result_venta,0);	  
	  
	  $sql_factura="select * from factura where idventa='".$_GET["idventa"]."'";
	  $result_factura=pg_exec($con,$sql_factura);
	  $factura=pg_fetch_array($result_factura,0);
	  
	  $sql_cliente="select * from cliente where idcliente='".$venta[2]."'";
	  $result_cliente=pg_exec($con,$sql_cliente);
	  $cliente=pg_fetch_array($result_cliente);	  
	  
	$posicionY=20;
	$pdf=new FPDF();
	$pdf->AddPage();
	$pdf->SetFont('Times','',9);
	$pdf->SetX(30);
	$pdf->SetY($posicionY);	
	$pdf->Cell(130,5,utf8_decode("Razon Social     : ".strtoupper($cliente[4]).""),0);	
	$posicionY+=5;
	$pdf->SetY($posicionY);	
	$pdf->Cell(130,5,utf8_decode("Nro Rif o CI      : ".$cliente[2].""),0);
	$posicionY+=5;
	$pdf->SetY($posicionY);	
	$pdf->Cell(130,5,utf8_decode("Domicilio Fiscal: ".$cliente[7].""),0);	
	$posicionY+=10;
	$pdf->SetY($posicionY);		
	$pdf->Cell(190,5,utf8_decode("-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------"),0);
	$posicionY+=5;
	$pdf->SetY($posicionY);
	$pdf->Cell(190,5,utf8_decode("   Codigo         Descripcion                                UMS    C.Stock  UMV    C.Venta    Precio    Sub Total    %D1    %D2    %D3   %IVA      Total Item"),0);
	$posicionY+=5;
	$pdf->SetY($posicionY);		
	$pdf->Cell(190,5,utf8_decode("-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------"),0);	
	
	$sql_productosxFactura="select * from productosxfactura where idfactura='".$factura[0]."'";
	$result_productosxFactura=pg_exec($con,$sql_productosxFactura);
	for($i=0;$i<pg_num_rows($result_productosxFactura);$i++){
		$producto_factura=pg_fetch_array($result_productosxFactura,$i);
		$sql_producto="select * from producto where idproducto='".$producto_factura[1]."'";
		$result_producto=pg_exec($con,$sql_producto);
		$producto=pg_fetch_array($result_producto,0);
		$posicionY+=5;
		$pdf->SetY($posicionY);	
		$pdf->Cell(18,4,utf8_decode(Codigo("PRO",$producto[0])),0);	
		$pdf->Cell(42,4,utf8_decode($producto[2]),0);
		$pdf->Cell(8,4,utf8_decode("Und"),0);
		$pdf->Cell(14,4,utf8_decode($producto_factura[3]),0,'L','R');
		if($producto[5]==1){
			$pdf->Cell(8,4,utf8_decode("Kgr"),0);
		}else{
			$pdf->Cell(8,4,utf8_decode("Und"),0);
		}				
		$pdf->Cell(14,4,utf8_decode($producto_factura[4]),0,'L','R');
		$pdf->Cell(12,4,utf8_decode($producto_factura[5]),0,'L','R');		
		$pdf->Cell(17,4,utf8_decode($producto_factura[6]),0,'L','R');
		$pdf->Cell(9,4,utf8_decode("0,00"),0,'L','R');
		$pdf->Cell(9,4,utf8_decode("0,00"),0,'L','R');	
		$pdf->Cell(9,4,utf8_decode("0,00"),0,'L','R');	
		$pdf->Cell(10,4,utf8_decode($producto_factura[7]),0,'L','R');
		$pdf->Cell(20,4,utf8_decode($producto_factura[8]),0,'L','R');			
	}
	
	
	for($i;$i<12;$i++){
		$posicionY+=5;
		$pdf->SetY($posicionY);	
		$pdf->Cell(18,4,utf8_decode(""),0);	
		$pdf->Cell(42,4,utf8_decode(""),0);
		$pdf->Cell(8,4,utf8_decode(""),0);
		$pdf->Cell(14,4,utf8_decode(""),0,'L','R');	
		$pdf->Cell(8,4,utf8_decode(""),0);
		$pdf->Cell(14,4,utf8_decode(""),0,'L','R');
		$pdf->Cell(12,4,utf8_decode(""),0,'L','R');		
		$pdf->Cell(17,4,utf8_decode(""),0,'L','R');
		$pdf->Cell(9,4,utf8_decode(""),0,'L','R');
		$pdf->Cell(9,4,utf8_decode(""),0,'L','R');	
		$pdf->Cell(9,4,utf8_decode(""),0,'L','R');	
		$pdf->Cell(10,4,utf8_decode(""),0,'L','R');
		$pdf->Cell(20,4,utf8_decode(""),0,'L','R');			
	}
	$posicionY+=5;
	$pdf->SetY($posicionY);		
	$pdf->Cell(190,5,utf8_decode("-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------"),0);		
	$posicionY+=5;
	$pdf->SetY($posicionY);
	$pdf->Cell(80,4,utf8_decode("Excento:"),0,'L','R');			
	$pdf->Cell(20,4,utf8_decode($factura[3]),0,'L','R');	
	$pdf->Cell(18,4,utf8_decode("Gravables:"),0,'L','L');
	$pdf->Cell(20,4,utf8_decode($factura[4]),0,'L','R');
	$pdf->Cell(28,4,utf8_decode("Sub Total              "),0,'L','L');
	$pdf->Cell(2,4,utf8_decode(":"),0,'L','L');	
	$pdf->Cell(24,4,utf8_decode($factura[5]),0,'L','R');	
	
	$posicionY+=4;
	$pdf->SetY($posicionY);
	$pdf->Cell(80,4,utf8_decode(""),0,'L','R');			
	$pdf->Cell(20,4,utf8_decode(""),0,'L','R');	
	$pdf->Cell(18,4,utf8_decode(""),0,'L','L');
	$pdf->Cell(20,4,utf8_decode(""),0,'L','R');
	$pdf->Cell(28,4,utf8_decode("Total Desc            "),0,'L','L');
	$pdf->Cell(2,4,utf8_decode(":"),0,'L','L');		
	$pdf->Cell(24,4,utf8_decode("0.00"),0,'L','R');	

	$posicionY+=4;
	$pdf->SetY($posicionY);
	$pdf->Cell(80,4,utf8_decode(""),0,'L','R');			
	$pdf->Cell(20,4,utf8_decode(""),0,'L','R');	
	$pdf->Cell(18,4,utf8_decode(""),0,'L','L');
	$pdf->Cell(20,4,utf8_decode(""),0,'L','R');
	$pdf->Cell(28,4,utf8_decode("Total Iva 12,00%  "),0,'L','L');
	$pdf->Cell(2,4,utf8_decode(":"),0,'L','L');		
	$pdf->Cell(24,4,utf8_decode($factura[6]),0,'L','R');
	
	$posicionY+=4;
	$pdf->SetY($posicionY);
	$pdf->Cell(80,4,utf8_decode(""),0,'L','R');			
	$pdf->Cell(20,4,utf8_decode(""),0,'L','R');	
	$pdf->Cell(18,4,utf8_decode(""),0,'L','L');
	$pdf->Cell(20,4,utf8_decode(""),0,'L','R');
	$pdf->Cell(28,4,utf8_decode("Monto Total BSF  "),0,'L','L');
	$pdf->Cell(2,4,utf8_decode(":"),0,'L','L');		
	$pdf->Cell(24,4,utf8_decode($factura[7]),0,'L','R');
	
	$numerofactura="";
	
	if($factura[1]<10){
		$numerofactura="0000000000000000".$factura[1];	
	}else if($factura[1]<100){
		$numerofactura="000000000000000".$factura[1];			
	}else if($factura[1]<1000){
		$numerofactura="00000000000000".$factura[1];			
	}else if($factura[1]<10000){
		$numerofactura="0000000000000".$factura[1];			
	}else if($factura[1]<100000){
		$numerofactura="000000000000".$factura[1];			
	}else if($factura[1]<1000000){
		$numerofactura="00000000000".$factura[1];			
	}else if($factura[1]<10000000){
		$numerofactura="0000000000".$factura[1];			
	}else if($factura[1]<100000000){
		$numerofactura="000000000".$factura[1];			
	}
	
	
	$posicionY=15;
	$pdf->SetY($posicionY);
	$pdf->SetX(130);	
	$pdf->Cell(25,4,utf8_decode("Factura                  "),0,'L','L');	
	$pdf->Cell(2,4,utf8_decode(":"),0,'L','L');
	$pdf->Cell(43,4,utf8_decode("Nro:B-".$numerofactura),0,'L','R');	
	$posicionY+=5;
	$pdf->SetY($posicionY);
	$pdf->SetX(130);	
	$pdf->Cell(25,4,utf8_decode("Fecha de Emision  "),0,'L','L');
	$pdf->Cell(2,4,utf8_decode(":"),0,'L','L');	
	$pdf->Cell(43,4,utf8_decode($venta[6][8].$venta[6][9].$venta[6][4].$venta[6][5].$venta[6][6].$venta[6][4].$venta[6][0].$venta[6][1].$venta[6][2].$venta[6][3]),0,'L','R');
	$posicionY+=5;
	$pdf->SetY($posicionY);
	$pdf->SetX(130);	
	$pdf->Cell(25,4,utf8_decode("Vence                    "),0,'L','L');
	$pdf->Cell(2,4,utf8_decode(":"),0,'L','L');		
	if($venta[4]==1){
		$pdf->Cell(43,4,utf8_decode($venta[6][8].$venta[6][9].$venta[6][4].$venta[6][5].$venta[6][6].$venta[6][4].$venta[6][0].$venta[6][1].$venta[6][2].$venta[6][3]),0,'L','R');	
	}else{
		$fecha=strtotime($venta[6]);
		$fechaBuscada=$fecha+604800;
		$pdf->Cell(43,4,utf8_decode(date("d-m-Y",$fechaBuscada)),0,'L','R');	
	}			
	$posicionY+=5;
	$pdf->SetY($posicionY);
	$pdf->SetX(130);	
	$pdf->Cell(25,4,utf8_decode("Forma de Pago      "),0,'L','L');
	$pdf->Cell(2,4,utf8_decode(":"),0,'L','L');	
	if($venta[4]==1){
		$pdf->Cell(43,4,utf8_decode("CONTADO"),0,'L','R');	
	}else{
		$pdf->Cell(43,4,utf8_decode("CREDITO"),0,'L','R');	
	}
	
																
	$pdf->Output();





?>
