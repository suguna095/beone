<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class InventoryManagement extends CI_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(0);
        $this->load->model("InventoryManagement_model");
        $this->load->helpers('utility_helper');
    }

    public function showShelve_Data() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnArray = $this->InventoryManagement_model->getviewshelve($_POST);
        $maniarray = $returnArray['result'];

        foreach ($maniarray as $key => $val) {
            $maniarray[$key]['city_id'] = getcityidbyid($maniarray[$key]['city_id']);
            $maniarray[$key]['shelv_location'] = getshelv_location($maniarray[$key]['shelv_location']);
        }


        $dataArray['result'] = $maniarray;
        $dataArray['count'] = $returnArray['count'];
        echo json_encode($dataArray);
    }

    public function showExcelShelve_Data() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnArray = $this->InventoryManagement_model->ShowExcellist();
        //	$maniarray=$returnArray['result'];

        foreach ($returnArray as $key => $val) {
            $returnArray[$key]['city_id'] = getcityidbyid($returnArray[$key]['city_id']);
            $returnArray[$key]['shelv_location'] = getshelv_location($returnArray[$key]['shelv_location']);
        }


        // $dataArray['result']=$returnArray;   
        //  $dataArray['count']=$returnArray['count'];
        echo json_encode($returnArray);
    }

    public function AddShelve() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataArray = $_POST['add_shelve'];
        $shelv_location = $dataArray['shelv_location'];
        $shelv_no = $dataArray['shelv_no'];
        $city = $dataArray['city_id'];
        
        $city_id = getIdByCityName($city);


        $returnArray = $this->InventoryManagement_model->GetShelveDetails($shelv_location, $shelv_no, $city_id);
       
        if ($returnArray == 0) {
            $shelveArray = array('country_id' => $dataArray['country_id'], 'city_id' => $city_id, 'shelv_location' => $dataArray['shelv_location'], 'shelv_no' => $dataArray['shelv_no']);
          
            $res_data = $this->InventoryManagement_model->insertShelve($shelveArray);
            $return = true;
        } else {
            $res_data = false;
            $return = false;
        }

        echo json_encode($return);
    }

    public function get_delete_shelve() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $array = array('deleted' => 'Y');
        $ReturnData = $this->InventoryManagement_model->getshelvedelete($array, $_POST['id']);
        echo json_encode($ReturnData);
    }

    public function ShowEditShelve() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $table_id = $_POST['sheid'];

        $returnArray = $this->InventoryManagement_model->Getshelve_edit($table_id);
        $returnArray['cityname'] = getdestinationfieldshow($returnArray['city_id'], 'city');
        echo json_encode($returnArray);
    }

    public function AddEditShelve() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataArray = $_POST['edit_shelve'];
        $sheid = $dataArray['sheid'];
        $editshelveArray = array('country_id' => $dataArray['country_id'], 'city_id' => $dataArray['city_id'], 'shelv_location' => $dataArray['shelv_location'], 'shelv_no' => $dataArray['shelv_no']);
        $res_data = $this->InventoryManagement_model->shelveUpdate($editshelveArray, $sheid);
        $return = true;
        echo json_encode($res_data);
    }

    public function showWarehouse_Data() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnArray = $this->InventoryManagement_model->getviewwarehouse();
        $maniarray = $returnArray['result'];
        foreach ($maniarray as $key => $value) {
            $maniarray[$key]['city_id'] = Get_name_country_by_id('city', $value['city_id']);
        }
        $dataArray['result'] = $maniarray;
        $dataArray['count'] = $returnArray['count'];
        echo json_encode($dataArray);
    }

    public function get_delete_warehouse() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $array = array('deleted' => 'Y');
        $ReturnData = $this->InventoryManagement_model->getwarehousedelete($array, $_POST['id']);
        echo json_encode($ReturnData);
    }

    public function AddLocation() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataArray = $_POST['add_location'];

        $country_id = $dataArray['country_id'];
        $shelv_location = $dataArray['shelv_location'];
        $city = $dataArray['city_id'];
        $city_id = getidsByNameshow($city);

        $returnArray = $this->InventoryManagement_model->GetLocationDetails($country_id, $shelv_location, $city_id);
        if ($returnArray == 0) {


            $locationArray = array('country_id' => $dataArray['country_id'], 'city_id' => $city_id, 'shelv_location' => $dataArray['shelv_location']);
            $res_data = $this->InventoryManagement_model->insertLocation($locationArray);
            $return = true;
        } else {
            $res_data = false;
            $return = false;
        }

        echo json_encode($return);
    }

    public function ShowEditLocation() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $table_id = $_POST['loid'];

        $returnArray = $this->InventoryManagement_model->Getlocation_edit($table_id);
        $returnArray['cityname'] = getdestinationfieldshow($returnArray['city_id'], 'city');
        /* foreach($returnArray as $key=>$val)
          {
          $returnArray[$key]['city_id']=Get_name_country_by_id('state',$val['city_id']);
          } */
        echo json_encode($returnArray);
    }

    public function AddEditLocation() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataArray = $_POST['edit_location'];
        $loid = $dataArray['loid'];
        $city_id = Get_name_country_by_id('id', $dataArray['city_id']);
        $editlocationArray = array('country_id' => $dataArray['country_id'], 'city_id' => $city_id, 'shelv_location' => $dataArray['shelv_location']);
        $res_data = $this->InventoryManagement_model->locationUpdate($editlocationArray, $loid);
        $return = true;
        echo json_encode($res_data);
    }

    public function ShelveCityDrop() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnArray = $this->InventoryManagement_model->GetCityShelveDrop();
        echo json_encode($returnArray);
    }

    public function GetCountryDropshowShow() {
        $returnArray = GetcountryDropData();
        echo json_encode($returnArray);
    }

    public function GetCityDropshowShow() {
        $returnArray = GetCityDropData();
        echo json_encode($returnArray);
    }

    public function Getcitydropdatashow() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnArray = getAllDestination($_POST['country_id']);
        echo json_encode($returnArray);
    }

    public function shelve_warehouse_boxDrop() {
        $_POST = json_decode(file_get_contents('php://input'), true);

        $return = shelve_warehouse_select_box($_POST['city_id']);
        echo json_encode($return);
    }

    public function GetsearchShelveNoPage() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $rdataArr = $this->InventoryManagement_model->GetsearchShelveNoPageQry($_POST);
        $fetchData = $rdataArr[0];
        //$fetchData1=$rdataArr[1];
        //print_r($fetchData); die;

        $currentSelected = '';
        $checkShelve = array();
        $checkSh = array();
        $mainData = array();
        $i = 0;
        foreach ($fetchData as $key => $value) {
            $countShelve = 0;
            $currentSelected = $fetchData[$key]['shelv_no'];
            if (in_array($currentSelected, $checkSh)) {
                $currentSelected;
                $countShelve = $checkShelve[$currentSelected] + 1;
                $checkShelve[$currentSelected] = $countShelve;
            } else {
                $checkShelve[$currentSelected] = 1;
                array_push($checkSh, $currentSelected);
                $mainData[$i]['shelv_no'] = $currentSelected;
                $mainData[$i]['destination'] = $fetchData[$key]['destination'];
                $i++;
            }
        }
        //print_r($checkShelve); die;  
        foreach ($mainData as $key1 => $value1) {
            $mainData[$key1]['count'] = $checkShelve[$mainData[$key1]['shelv_no']];
            $mainData[$key1]['destination'] = getdestinationfieldshow($mainData[$key1]['destination'], 'city');
        }

        $return['tcount'] = count($mainData);
        $return['result'] = $mainData;
        echo json_encode($return);
    }

    public function ShowtotalshelveDetails() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $totalofdAray = $this->InventoryManagement_model->gettotalShipmentData($_POST);
        $returnArray = $totalofdAray['result'];
        foreach ($returnArray as $key => $value) {

            $returnArray[$key]['destination'] = getdestinationfieldshow($returnArray[$key]['origin'], 'city');
            $returnArray[$key]['origin'] = getdestinationfieldshow($returnArray[$key]['destination'], 'destination');
            $returnArray[$key]['citydata'] = status_main_cat($returnArray[$key]['delivered']);
            $returnArray[$key]['totaldata'] = $returnArray[$key]['total_cod_amt'] + $returnArray[$key]['cod_fees'] + $returnArray[$key]['service_charge'];
        }


        $returnArrayR['result'] = $returnArray;
        echo json_encode($returnArrayR);
    }

    public function shelvePrint() {

        $Checklocations = $this->input->post('Checklocations');
        if (!empty($Checklocations)) {
            $awbData = $Checklocations;
            $this->load->library('M_pdf');
            $html .= '<!doctype html><html><head><meta charset="utf-8">';
            $html .= '<title>Total Shelve of ' . count($awbData) . ' </title> ';
            $html .= '<style>
			img {
			   -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
				filter: grayscale(100%);
				height:100px;
			}
			.invoice-box {
						max-width: 922px;
						margin: auto;
						padding: 5px;
						border: 1px solid #eee;
						box-shadow: 0 0 10px rgba(0, 0, 0, .15);
						font-size: 12px;
						line-height: 29px;
						font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
						color: #555;
						height:850px
					}
					.invoice-box table {
						
						line-height: inherit;
						text-align: center;
					}
					
					.invoice-box table td {
						padding: 20px;
						vertical-align: top;
					}
					
					.invoice-box table tr td:nth-child(2) {
						text-align: right;
					}
					
					.invoice-box table tr.top table td {
						padding-bottom: 5px;
					}
					
					.invoice-box table tr.top table td.title {
						font-size: 45px;
						line-height: 45px;
						color: #333;
					}
					table {
						font-family: arial, sans-serif;
						border-collapse: collapse;
						
					}

					td, th {
						
						text-align: left;
						padding: 10px;
					} 
					</style>
				</head> 
				<body>';
            $html .= '<h2 style="align:center" align="center">Print Shelve Barcode4*6 </h2>';
            $html .= '<div class="invoice-box" >';
            $i = 0;
            $html .= '<table cellpadding="10" cellspacing="10" border="1"><tr>';
            foreach ($awbData as $data1) {
                if ($i % 2 == 0) {
                    $html .= '<tr>';
                }
                $base64 = 'data:image/' . $type . ';base64,' . barcodeRuntime($data1);
                $html .= '<td style="" align="center" colspan="2">
                <span style="font-size:20px;"><img src="' . $base64 . '"></span><br/>
				<span>' . $data1 . '</span>
           	</td>';
                if ($i % 3 == 2) {
                    $html .= '</tr>';
                }
                $i++;
            }
            if ($i % 3 != 0) {
                $html .= '</tr>';
            }
            $html .= '</table>';
            $pdfFilePath = " Shelve Barcode4*6 " . date('Y-m-d H:i:s') . ".pdf";
            $this->m_pdf->pdf->WriteHTML($html);
            $this->m_pdf->pdf->Output($pdfFilePath, "I");
        } else {
            redirect(base_url() . 'print_barcode');
        }
    }

    public function shelvefileImport() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $path = $_FILES["file"]["tmp_name"];
        if (!empty($path)) {
            $this->load->library("excel");
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();

                $returnArr = array();
                for ($row = 2; $row <= $highestRow; $row++) {

                    $cityname = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    
                    //$shelv_location = getShelvId($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                    $shelv_location = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $shelv_no = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    
                    $city_id = Get_name_country_by_id('id', $cityname);
                    
                    $countryName = Get_name_country_by_id('country', $cityname);

                    $country_id = GetCountryNameByid($countryName);
                   
                    $checkSelve = getlocation($shelv_location);
                   
                    if ($city_id > 0) {
                        if ($checkSelve == '' && $shelv_location != '') {
                           // echo $shelv_location;die;
                          //  if ($shelv_location == '') {

                                $insertdata = array(
                                    'country_id' => $country_id,
                                    'city_id' => $city_id,
                                    'shelv_location' => $shelv_location);
                                $shelv_location = $this->InventoryManagement_model->warehous_shelveInsert($insertdata);
                           // }
                            //echo $shelv_location; 
                            $data = array(
                                'country_id' => $country_id,
                                'city_id' => $city_id,
                                'shelv_location' => $shelv_location,
                                'shelv_no' => $shelv_no
                            );
                            $this->InventoryManagement_model->warehous_shelve_noInsert($data);

                            $returnArr['valid'][] = $row;
                        } else
                            $returnArr['shelv_locationErr'][] = $row;
                    } else
                        $returnArr['cityiderr'][] = $row;
                }
            }
        } else
            $returnArr['fileemtpy'];

        echo json_encode($returnArr);
    }

    public function shelveLocationfileImport() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $path = $_FILES["file"]["tmp_name"];
        if (!empty($path)) {
            $this->load->library("excel");
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();

                $returnArr = array();
                for ($row = 2; $row <= $highestRow; $row++) {

                    $countryName = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $cityname = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $shelv_location = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $city_id = Get_name_country_by_id('id', $cityname);
                    $countryName = Get_name_country_by_id('country', $city_id);

                    $country_id = GetCountryNameByid($countryName);
                    if ($city_id > 0) {

                        $data = array(
                            'country_id' => $country_id,
                            'city_id' => $city_id,
                            'shelv_location' => $shelv_location
                        );

                        $this->InventoryManagement_model->insertLocation($data);


                        $returnArr['valid'][] = $row;
                    } else {
                        $returnArr['cityiderr'][] = $row;
                    }
                }
            }
        } else
            $returnArr['fileemtpy'];

        echo json_encode($returnArr);
    }

}
