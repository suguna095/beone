<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_export extends CI_Controller {


 function __construct() {
  parent::__construct(); 
}




	function shelveBulkFormate()
	{
	  $this->load->library("excel");
	  $object = new PHPExcel();
	
	  $object->setActiveSheetIndex(0);
	
	  $table_columns = array(
		"City",
		"Shelv Location",
		"Shelve No ",
	  );
	
	  $column = 0;
	
	  foreach($table_columns as $field)
	  {
	   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
	   $column++;
	 }
	
	 $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
	 header('Content-Type: application/vnd.ms-excel');
	 header('Content-Disposition: attachment;filename="shelve No Bulk.xls"');
	 $object_writer->save('php://output');
	}


	function shelveLocationBulkFormat()
	{
	  $this->load->library("excel");
	  $object = new PHPExcel();
	
	  $object->setActiveSheetIndex(0);
	
	  $table_columns = array(
		"Country",
		"City",
		"Shelv Location", 
	);  
	
	  $column = 0;
	
	  foreach($table_columns as $field)
	  {
	   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
	   $column++;
	 }
	
	 $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
	 header('Content-Type: application/vnd.ms-excel');
	 header('Content-Disposition: attachment;filename="shelve Location Bulk.xls"');
	 $object_writer->save('php://output');
	}


function BulkRouteExcel()
	{
	  $this->load->library("excel");
	  $object = new PHPExcel();
	
	  $object->setActiveSheetIndex(0);
	
	  $table_columns = array(
		"Country",
		"City",
		"Route Code", 
		"Route",
		"Arabic Keyword",
	);  
	
	  $column = 0;
	
	  foreach($table_columns as $field)
	  {
	   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
	   $column++;
	 }
	
	 $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
	 header('Content-Type: application/vnd.ms-excel');
	 header('Content-Disposition: attachment;filename="Route Bulk.xls"');
	 $object_writer->save('php://output');
	}



	function ImportratesFile()
	{
	  $this->load->library("excel");
	  $object = new PHPExcel();
	
	  $object->setActiveSheetIndex(0);
	
	  $table_columns = array(
		"AWB No(Existing)",
		"Service Charge",
		"Cod Fees ",
		"Return Fees",
		"POD Fees",
	  );
	
	  $column = 0;
	
	  foreach($table_columns as $field)
	  {
	   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
	   $column++;
	 }
	
	 $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
	 header('Content-Type: application/vnd.ms-excel');
	 header('Content-Disposition: attachment;filename="Import Rate Bulk.xls"');
	 $object_writer->save('php://output');
	}
	
	function shelvefileImport()
   {
	 
		
 if(isset($base64string))
 {
	 $_POST = json_decode(file_get_contents('php://input'), true);
   $path = $_FILES["file"]["tmp_name"];
   $this->load->library("excel");
   $object = PHPExcel_IOFactory::load($path);
   foreach($object->getWorksheetIterator() as $worksheet)
   {
    $highestRow = $worksheet->getHighestRow();
    $highestColumn = $worksheet->getHighestColumn();
	$Skucheck=array();
	$skuData=array();
	$alertArray=array();
	    for($row=2; $row<=$highestRow; $row++)
    {	
	
	echo "ddddddd".$storageName = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
		//$storageArray=$this->Item_model->getcheckstorageid($storageName);
	
	
		 $sku = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
		//$skuArray=$this->Item_model->GetchekskuDuplicate($sku);
		 // echo $sku."//".$skuArray['sku']."//".$storageArray['id']."<br>";
		
		  if(empty($storageArray))
		  {
			 
			  $alertArray['invalidstorage'][]=$storageName;	
		  }
		   if(!empty($skuArray))
		  {
			  $alertArray['alreadyexits'][]=$skuArray['sku'];	
		  }
		if(!empty($storageArray) && empty($skuArray))
	  {
		 
		  $name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
		
		$capacity = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
		$description = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
		$type = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
		$less_qty = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
		$alert_day = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
		if(in_array($sku,$Skucheck))
		{
		   $alertArray['duplicate'][]=$row;	
		}
		else
		{
			$alertArray['validrow'][]=$row;	
			array_push($Skucheck,$sku);
	      $data[] = array(
        'storage_id' => $storageArray['id'],
		'name'=>$name,
		'type'=>$type,
        'sku'  => $sku,
        'description'   => $description,
		'sku_size'   => $capacity,
		'less_qty'   => $less_qty,
		'alert_day'   => $alert_day
         );
			}
		
				// print_r($skuArray);
		
	  }
	  else
	  {
		   $alertArray['invalid']=$row;	
	  }
	}
	

  }
  echo json_encode($_FILES);
}
else{
  //$this->session->set_flashdata('error','file error Bulk add failed'); 
 // redirect('Item');
}

}
    


function ImportCountryFile()
	{
	  $this->load->library("excel");
	  $object = new PHPExcel();
	
	  $object->setActiveSheetIndex(0);
	
	  $table_columns = array(
		"City",
		"Hub",
		"Latitude ",
		"Longitude",
	  );
	
	  $column = 0;
	
	  foreach($table_columns as $field)
	  {
	   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
	   $column++;
	 }
	
	 $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
	 header('Content-Type: application/vnd.ms-excel');
	 header('Content-Disposition: attachment;filename="Import Country.xls"');
	 $object_writer->save('php://output');
	}
	
	function ImportCourierFile()
	{
	  $this->load->library("excel");
	  $object = new PHPExcel();
	
	  $object->setActiveSheetIndex(0);
	
	  $table_columns = array(
		"Name",
		"code",
		"branch ",
		"city",
		"mobile",
		"email",
		"iqama",
		"iqama_id",
		"type_vehicle",
		"supplier",
		"join_date",
		"password",
		"vehicle_number"
	  );
	
	  $column = 0;
	
	  foreach($table_columns as $field)
	  {
	   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
	   $column++;
	 }
	
	 $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
	 header('Content-Type: application/vnd.ms-excel');
	 header('Content-Disposition: attachment;filename="Import Courier.xls"');
	 $object_writer->save('php://output');
	}
	
	function ImportWrongAreaFile()
	{
	  $this->load->library("excel");
	  $object = new PHPExcel();
	
	  $object->setActiveSheetIndex(0);
	
	  $table_columns = array(
		"AWB No(Existing)",
		"Area",
		"Channel ",
		
	  );
	
	  $column = 0;
	
	  foreach($table_columns as $field)
	  {
	   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
	   $column++;
	 }
	
	 $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
	 header('Content-Type: application/vnd.ms-excel');
	 header('Content-Disposition: attachment;filename="Import Courier.xls"');
	 $object_writer->save('php://output');
	}
}