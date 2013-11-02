<?php session_start();
	  require_once '../recursos/clases/PHPExcel.php';

	$objPHPExcel = new PHPExcel();
	
	$objPHPExcel->getProperties()->setCreator("Sistema Gestión de Quesera");
	$objPHPExcel->getProperties()->setTitle("Resumen de Leche Semana 12");
	$objPHPExcel->getProperties()->setDescription("Reporte contentivo del detalle de ingreso de leche en la semana 8 del año.");
	
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Hello');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Mundo');
	
	$objPHPExcel->getActiveSheet()->setTitle('Resumen Semana 8');
	
	/*Cambiar color de la letra en una celda
	$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);*/	

	/*Aliniar texto en celda a la izquierda o a la derecha
	$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
	
	/*Dibujar borde en las celdas
	$objPHPExcel->getActiveSheet()->getStyle('B2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$objPHPExcel->getActiveSheet()->getStyle('B1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$objPHPExcel->getActiveSheet()->getStyle('B2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$objPHPExcel->getActiveSheet()->getStyle('B2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);*/
	
	/*Pintar el fondo de una celda
	$objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setARGB('FFFF0000');*/
	
	/*Cambiar estilo y tamaño de las letras 
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(8);*/
	
	/*Definir Ancho de una columna
	$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn("1")->setWidth(22); */
	
	/*Combinar Celdas
	$objPHPExcel->getActiveSheet()->mergeCells('C1:H1');*/
	
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save("ejemplo.xlsx");

 ?>
