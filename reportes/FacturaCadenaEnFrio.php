<?php session_start();   
	  include("../recursos/clases/FPDF/fpdf.php");
	  header("Content-Type: text/html; charset=iso-8859-1");
      require("../recursos/funciones/conexion.php");
	  $con=Conectarse();	
	  
	  $sql_venta="select * from venta where idventa='".$_GET["idventa"]."'";
	  $result_venta=pg_exec($con,$sql_venta);
	  $venta=pg_fetch_array($result_venta,0);	  
	  
	  $sql_facturaCadena="select * from facturacadena where idventa='".$_GET["idventa"]."'";
	  $result_facturaCadena=pg_exec($con,$sql_facturaCadena);
	  $facturaCadena=pg_fetch_array($result_facturaCadena,0);
	  
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
	$pdf->Cell(190,5,utf8_decode("   Codigo         Descripcion                                UMS    C.Stock  UMV    C.Venta     Precio        Sub Total    %D1    %D2    %D3   %IVA   Total Item"),0);
	$posicionY+=5;
	$pdf->SetY($posicionY);		
	$pdf->Cell(190,5,utf8_decode("-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------"),0);	
	

		$posicionY+=5;
		$pdf->SetY($posicionY);	
		$pdf->Cell(18,4,utf8_decode("SER00001"),0);	
		$pdf->Cell(42,4,utf8_decode("Mantenimiento Cadena en Frio"),0);
		$pdf->Cell(8,4,utf8_decode("Und"),0);
		$pdf->Cell(14,4,utf8_decode("1.00"),0,'L','R');	
		$pdf->Cell(8,4,utf8_decode("Und"),0);
		$pdf->Cell(12,4,utf8_decode("1.00"),0,'L','R');
		$pdf->Cell(16,4,utf8_decode($facturaCadena[4]),0,'L','R');		
		$pdf->Cell(18,4,utf8_decode($facturaCadena[4]),0,'L','R');
		$pdf->Cell(10,4,utf8_decode("0.00"),0,'L','R');
		$pdf->Cell(9,4,utf8_decode("0.00"),0,'L','R');	
		$pdf->Cell(9,4,utf8_decode("0.00"),0,'L','R');	
		$pdf->Cell(11,4,utf8_decode("12.00"),0,'L','R');
		$pdf->Cell(16,4,utf8_decode($facturaCadena[7]),0,'L','R');			
	
	
	
	for($i;$i<11;$i++){
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
	$pdf->Cell(20,4,utf8_decode($facturaCadena[3]),0,'L','R');	
	$pdf->Cell(18,4,utf8_decode("Gravables:"),0,'L','L');
	$pdf->Cell(20,4,utf8_decode($facturaCadena[4]),0,'L','R');
	$pdf->Cell(28,4,utf8_decode("Sub Total              "),0,'L','L');
	$pdf->Cell(2,4,utf8_decode(":"),0,'L','L');	
	$pdf->Cell(24,4,utf8_decode($facturaCadena[5]),0,'L','R');	
	
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
	$pdf->Cell(24,4,utf8_decode($facturaCadena[6]),0,'L','R');
	
	$posicionY+=4;
	$pdf->SetY($posicionY);
	$pdf->Cell(80,4,utf8_decode(""),0,'L','R');			
	$pdf->Cell(20,4,utf8_decode(""),0,'L','R');	
	$pdf->Cell(18,4,utf8_decode(""),0,'L','L');
	$pdf->Cell(20,4,utf8_decode(""),0,'L','R');
	$pdf->Cell(28,4,utf8_decode("Monto Total BSF  "),0,'L','L');
	$pdf->Cell(2,4,utf8_decode(":"),0,'L','L');		
	$pdf->Cell(24,4,utf8_decode($facturaCadena[7]),0,'L','R');
	
	$numerofactura="";
	
	if($facturaCadena[1]<10){
		$numerofactura="0000000000000000".$facturaCadena[1];	
	}else if($facturaCadena[1]<100){
		$numerofactura="000000000000000".$facturaCadena[1];			
	}else if($facturaCadena[1]<1000){
		$numerofactura="00000000000000".$facturaCadena[1];			
	}else if($facturaCadena[1]<10000){
		$numerofactura="0000000000000".$facturaCadena[1];			
	}else if($facturaCadena[1]<100000){
		$numerofactura="000000000000".$facturaCadena[1];			
	}else if($facturaCadena[1]<1000000){
		$numerofactura="00000000000".$facturaCadena[1];			
	}else if($facturaCadena[1]<10000000){
		$numerofactura="0000000000".$facturaCadena[1];			
	}else if($facturaCadena[1]<100000000){
		$numerofactura="000000000".$facturaCadena[1];			
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
