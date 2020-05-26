<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class ShipmentManagement extends CI_Controller {

    function __construct() {
        parent::__construct();
        //  error_reporting(0);
        $this->load->model("ShipmentManagement_model");
    }

    public function allshiplist() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        //echo json_encode($_POST);
        $dataAray = $this->ShipmentManagement_model->alllistData($_POST);
        $tolalShip = $dataAray['count'];
        $downlaoadData = 5000;
        $j = 0;
        for ($i = 0; $i < $tolalShip;) {
            $i = $i + $downlaoadData;
            if ($i > 0) {
                $expoertdropArr[] = array('j' => $j, 'i' => $i);
            }
            $j = $i;
        }

        $newdataAray = $dataAray['result'];
        foreach ($newdataAray as $key => $val) {
            $newdataAray[$key]['origin'] = Get_name_country_by_id('city', $val['origin']);
            $newdataAray[$key]['reciever_city'] = Get_name_country_by_id('state', $val['reciever_city']);
            $newdataAray[$key]['d_attempt'] = get_total_attempted($val['slip_no']);
            $newdataAray[$key]['messenger_name'] = get_messanger_tablefield($val['messanger_id'], 'messenger_name');
            $newdataAray[$key]['messenger_code'] = get_messanger_tablefield($val['messanger_id'], 'messenger_code');
            $statusData = driver_detail($val['slip_no']);
            $newdataAray[$key]['comment'] = $newdataAray['comment'];
            $newdataAray[$key]['Details'] = $newdataAray['Details'];
            $newdataAray[$key]['shelv_no_1'] = getshelv_location($val['shelv_no']);
            $newdataAray[$key]['delivered_show'] = status_main_cat($val['delivered']);
            $newdataAray[$key]['show_code'] = getActivity($val['code']);

            if ($val['mode'] == 'COD')
                $styletr = 'style="background-color:#AEFFAE;"';
            if ($val['booking_mode'] == 'Pay at pickup' && $val['total_cod_amt'] != 0)
                $styletr = 'style="background-color:#AEFFAE;"';
            if ($val['total_cod_amt'] != '' && $val['total_cod_amt'] != '0') {
                if ($val['client_type'] == 'B2C')
                    $total_cod_amt = $val['total_cod_amt'];
                else
                    $total_cod_amt = $val['total_cod_amt'] + $val['cod_fees'] + $val['service_charge'];
            } else
                $total_cod_amt = 0;

            $newdataAray[$key]['total_cod_amt'] = $styletr;
            $newdataAray[$key]['total_cod_amt'] = $total_cod_amt;





            // $newstatusArray[$key]['new_location']=Get_name_country_by_id('city',$val2['new_location']);
            // $newstatusArray[$key]['citycode']=Get_name_country_by_id('city_code',$val2['new_location']);
            // $newstatusArray[$key]['username']=Get_user_name($val2['user_id'],$val2['type']);
        }
        $shiparray = $newdataAray;
        $dataArray['result'] = $shiparray;
        $dataArray['dropexport'] = $expoertdropArr;
        $dataArray['count'] = $dataAray['count'];

        echo json_encode($dataArray);
    }

    public function allshiplist1() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $search_type = $_POST['search_type'];
        $main_status = $_POST['main_status'];
        $shipmentStatus = $_POST['shipmentStatus'];
        $statusBy = $_POST['statusBy'];
        $newdataAray = $this->ShipmentManagement_model->alllistData1($_POST);

        foreach ($newdataAray as $key => $val) {
            $newdataAray[$key]['origin'] = Get_name_country_by_id('city', $val['origin']);
            $newdataAray[$key]['reciever_city'] = Get_name_country_by_id('state', $val['reciever_city']);
            $newdataAray[$key]['d_attempt'] = get_total_attempted($val['slip_no']);
            $newdataAray[$key]['messenger_name'] = get_messanger_tablefield($val['messanger_id'], 'messenger_name');
            $newdataAray[$key]['messenger_code'] = get_messanger_tablefield($val['messanger_id'], 'messenger_code');
            $statusData = driver_detail($val['slip_no']);
            $newdataAray[$key]['comment'] = $newdataAray['comment'];
            $newdataAray[$key]['Details'] = $newdataAray['Details'];
            $newdataAray[$key]['shelv_no_1'] = getshelv_location($val['shelv_no']);
            $newdataAray[$key]['delivered_show'] = status_main_cat($val['delivered']);
            $newdataAray[$key]['show_code'] = getActivity($val['code']);

            if ($val['mode'] == 'COD')
                $styletr = 'style="background-color:#AEFFAE;"';
            if ($val['booking_mode'] == 'Pay at pickup' && $val['total_cod_amt'] != 0)
                $styletr = 'style="background-color:#AEFFAE;"';
            if ($val['total_cod_amt'] != '' && $val['total_cod_amt'] != '0') {
                if ($val['client_type'] == 'B2C')
                    $total_cod_amt = $val['total_cod_amt'];
                else
                    $total_cod_amt = $val['total_cod_amt'] + $val['cod_fees'] + $val['service_charge'];
            } else
                $total_cod_amt = 0;

            $newdataAray[$key]['total_cod_amt'] = $styletr;
            $newdataAray[$key]['total_cod_amt'] = $total_cod_amt;





            // $newstatusArray[$key]['new_location']=Get_name_country_by_id('city',$val2['new_location']);
            // $newstatusArray[$key]['citycode']=Get_name_country_by_id('city_code',$val2['new_location']);
            // $newstatusArray[$key]['username']=Get_user_name($val2['user_id'],$val2['type']);
        }
        $shiparray = $newdataAray;
        $dataArray['result'] = $shiparray;


        echo json_encode($dataArray);
    }

    public function allCustomerlist() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataAray = $this->ShipmentManagement_model->allCustomerData($_POST);
        $shiparray = $dataAray['result'];
        $dataArray['result'] = $shiparray;
        $dataArray['count'] = $dataAray['count'];

        echo json_encode($dataArray);
    }

    public function allArchiveshiplist() {


        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataAray = $this->ShipmentManagement_model->allArchievelistData($_POST);

        $tolalShip = $dataAray['count'];
        $downlaoadData = 5000;
        $j = 0;
        for ($i = 0; $i < $tolalShip;) {
            $i = $i + $downlaoadData;
            if ($i > 0) {
                $expoertdropArr[] = array('j' => $j, 'i' => $i);
            }
            $j = $i;
        }
        $newdataAray = $dataAray['result'];
        foreach ($newdataAray as $key => $val) {
            $newdataAray[$key]['origin'] = Get_name_country_by_id('city', $val['origin']);
            $newdataAray[$key]['reciever_city'] = Get_name_country_by_id('state', $val['destination']);
        }
        $shiparray = $newdataAray;
        $dataArray['result'] = $shiparray;
        $dataArray['dropexport'] = $expoertdropArr;
        $dataArray['count'] = $dataAray['count'];

        echo json_encode($dataArray);
    }

    public function allDeletedshiplist() {



        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataAray = $this->ShipmentManagement_model->allDeletedlistData($_POST);
        $tolalShip = $dataAray['count'];
        $downlaoadData = 5000;
        $j = 0;
        for ($i = 0; $i < $tolalShip;) {
            $i = $i + $downlaoadData;
            if ($i > 0) {
                $expoertdropArr[] = array('j' => $j, 'i' => $i);
            }
            $j = $i;
        }

        $newdataAray = $dataAray['result'];
        foreach ($newdataAray as $key => $val) {
            $newdataAray[$key]['origin'] = Get_name_country_by_id('city', $val['origin']);
            $newdataAray[$key]['reciever_city'] = Get_name_country_by_id('state', $val['reciever_city']);
            $newdataAray[$key]['d_attempt'] = get_total_attempted($val['slip_no']);
            $newdataAray[$key]['messenger_name'] = get_messanger_tablefield($val['messanger_id'], 'messenger_name');
            $newdataAray[$key]['messenger_code'] = get_messanger_tablefield($val['messanger_id'], 'messenger_code');
            $statusData = driver_detail($val['slip_no']);
            $newdataAray[$key]['comment'] = $newdataAray['comment'];
            $newdataAray[$key]['Details'] = $newdataAray['Details'];
            $newdataAray[$key]['shelv_no_1'] = getshelv_location($val['shelv_no']);
            $newdataAray[$key]['delivered_show'] = status_main_cat($val['delivered']);
            $newdataAray[$key]['show_code'] = getActivity($val['code']);

            if ($val['mode'] == 'COD')
                $styletr = 'style="background-color:#AEFFAE;"';
            if ($val['booking_mode'] == 'Pay at pickup' && $val['total_cod_amt'] != 0)
                $styletr = 'style="background-color:#AEFFAE;"';
            if ($val['total_cod_amt'] != '' && $val['total_cod_amt'] != '0') {
                if ($val['client_type'] == 'B2C')
                    $total_cod_amt = $val['total_cod_amt'];
                else
                    $total_cod_amt = $val['total_cod_amt'] + $val['cod_fees'] + $val['service_charge'];
            } else
                $total_cod_amt = 0;

            $newdataAray[$key]['total_cod_amt'] = $styletr;
            $newdataAray[$key]['total_cod_amt'] = $total_cod_amt;





            // $newstatusArray[$key]['new_location']=Get_name_country_by_id('city',$val2['new_location']);
            // $newstatusArray[$key]['citycode']=Get_name_country_by_id('city_code',$val2['new_location']);
            // $newstatusArray[$key]['username']=Get_user_name($val2['user_id'],$val2['type']);
        }
        $shiparray = $newdataAray;
        $dataArray['result'] = $shiparray;
        $dataArray['dropexport'] = $expoertdropArr;
        $dataArray['count'] = $dataAray['count'];

        echo json_encode($dataArray);
    }

    public function allreadydeliverlist() {


        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataAray = $this->ShipmentManagement_model->allreadydeliverlistData($_POST);
        $shiparray = $dataAray['result'];
        $newshiparray = $dataAray['result'];
        foreach ($newshiparray as $key => $value) {
            $base64 = 'data:image/' . $type . ';base64,' . barcodeRuntime($value['drs_unique_id']);
            $newshiparray[$key]['barcodeImage'] = $base64;
            $newshiparray[$key]['city_id'] = Get_name_country_by_id('city', $value['city_id']);
            $newshiparray[$key]['routecode'] = getRoutCode($value['routecode']);
            $newshiparray[$key]['messenger_name'] = get_messanger_tablefield($value['messanger_id'], 'messenger_name');
            $newshiparray[$key]['supplier_name'] = get_supplier_name($value['messanger_id']);
        }
        $dataArray['result'] = $newshiparray;
        $dataArray['count'] = $dataAray['count'];

        echo json_encode($dataArray);
    }

    public function allreadydeliverlist_details() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        //$date=date('Y-m-d');
        $drs_unique_id = $_POST['drs_unique_id'];
        $shipment_detail = $this->ShipmentManagement_model->allreadydeliverlistData_details($drs_unique_id);

        $newshipment_detail = $shipment_detail;
        $ammountdue = 0;



        foreach ($newshipment_detail as $key => $val) {
            if ($shipment_detail[$key]['client_type'] == 'B2C')
                $ammountdue = $ammountdue + $shipment_detail[$key]['total_cod_amt'];
            else
                $ammountdue = $ammountdue + ($shipment_detail[$key]['total_cod_amt'] + $shipment_detail[$key]['cod_fees'] + $shipment_detail[$key]['service_charge'] );

            $newshipment_detail[$key]['messenger_name'] = get_messanger_tablefield($val['messanger_id'], 'messenger_name');
            $newshipment_detail[$key]['messenger_code'] = get_messanger_tablefield($val['messanger_id'], 'messenger_code');
            $newshipment_detail[$key]['mobile'] = get_messanger_tablefield($val['messanger_id'], 'mobile');
            $newshipment_detail[$key]['supplier_name'] = get_supplier_name($val['messanger_id']);
        }
        $meessanger_id = $shipment_detail[0]['messanger_id'];



        $return = array('ammountdue' => $ammountdue, 'shipment_detail' => $newshipment_detail);
        echo json_encode($return);
    }

    public function allExceldeliverlist_details() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $date = date('Y-m-d');
        $drs_unique_id = $_POST['drs_unique_id'];
        $shipment_detail = $this->ShipmentManagement_model->allreadydeliverlistExcelData_details($drs_unique_id, $date);

        $newshipment_detail = $shipment_detail;
        $ammountdue = 0;



        foreach ($newshipment_detail as $key => $val) {
            if ($shipment_detail[$key]['client_type'] == 'B2C')
                $ammountdue = $ammountdue + $shipment_detail[$key]['total_cod_amt'];
            else
                $ammountdue = $ammountdue + ($shipment_detail[$key]['total_cod_amt'] + $shipment_detail[$key]['cod_fees'] + $shipment_detail[$key]['service_charge'] );

            $newshipment_detail[$key]['messenger_name'] = get_messanger_tablefield($val['messanger_id'], 'messenger_name');
            $newshipment_detail[$key]['messenger_code'] = get_messanger_tablefield($val['messanger_id'], 'messenger_code');
            $newshipment_detail[$key]['mobile'] = get_messanger_tablefield($val['messanger_id'], 'mobile');
            $newshipment_detail[$key]['supplier_name'] = get_supplier_name($val['messanger_id']);
        }
        $meessanger_id = $shipment_detail[0]['messanger_id'];



        $return = array('ammountdue' => $ammountdue, 'shipment_detail' => $newshipment_detail);
        echo json_encode($return);
    }

    public function print_readyfordel($drs_unique_id) {

        $citydata = $this->ShipmentManagement_model->GetallreadydrsPritqry($drs_unique_id);
        $total = count($citydata);
        if (!empty($citydata)) {
            $ammountdue = 0;
            foreach ($citydata as $key => $val) {
                if ($citydata[$key]['client_type'] == 'B2C')
                    $ammountdue = $ammountdue + $citydata[$key]['total_cod_amt'];
                else
                    $ammountdue = $ammountdue + ($citydata[$key]['total_cod_amt'] + $citydata[$key]['cod_fees'] + $citydata[$key]['service_charge'] );
            }
        }
        $view['ammountdue'] = $ammountdue;
        $view['data1'] = $citydata;
        $view['total'] = $total;

        $this->load->view('printReadyshow', $view);
    }

    public function RouteCityDrop() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnArray = $this->ShipmentManagement_model->GetCityRouteDrop($_POST);
        echo json_encode($returnArray);
    }

    public function SupplistDrop() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnArray = $this->ShipmentManagement_model->GetSupplistDrop($_POST);
        echo json_encode($returnArray);
    }

    public function CustlistDrop() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnArray = $this->ShipmentManagement_model->GetCustlistDrop($_POST);
        echo json_encode($returnArray);
    }

    public function allGetCsaStaffLis() {
        $return = all_csa_staffs_list();

        echo json_encode($return);
    }

    public function GetmonthlyGraphData() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataAray = $this->ShipmentManagement_model->getDataFromShipmetMonthWise($_POST);
        echo json_encode($dataAray, JSON_NUMERIC_CHECK);
    }

    public function GetshowmonthlyinsideData() {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnarray['title1'] = $this->ShipmentManagement_model->gettotalValueFromShipment('booked', 1, '');
        $returnarray['title2'] = $this->ShipmentManagement_model->gettotalValueFromShipment('not-delivered', 0, '');
        $returnarray['title3'] = $this->ShipmentManagement_model->gettotalValueFromShipment('pick-up-collected', 0, '');
        $returnarray['title4'] = $this->ShipmentManagement_model->gettotalValueFromShipment('out-for-delivery', 0, '');
        $returnarray['title5'] = $this->ShipmentManagement_model->gettotalValueFromShipment('return', 0, '');
        $returnarray['title6'] = $this->ShipmentManagement_model->gettotalValueFromShipment('shelve', 0, '');
        $returnarray['title7'] = $this->ShipmentManagement_model->gettotalValueFromShipment('shipment-forward-arrival', 0, '');
        $returnarray['title8'] = $this->ShipmentManagement_model->gettotalValueFromShipment('hold-for-pickup', 0, '');
        $returnarray['title9'] = $this->ShipmentManagement_model->gettotalValueFromShipment('pod', 0, '');
        $returnarray['title10'] = $this->ShipmentManagement_model->gettotalValueFromShipment('received-inbound', 0, '');
        $returnarray['title11'] = $this->ShipmentManagement_model->gettotalValueFromShipment('ready-for-delivery', 0, '');

        echo json_encode($returnarray);
    }

    public function GetshipmentExportDataaHome() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataAray = $this->ShipmentManagement_model->GetshipmentExportDataaHomeQry();
        echo json_encode($dataAray);
    }

    public function allAssignShipmentlist() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataAray = $this->ShipmentManagement_model->allAssignShipmentlistData($_POST);
        $shiparray = $dataAray['result'];
        $newshiparray = $dataAray['result'];
        foreach ($newshiparray as $key => $val) {
            $newshiparray[$key]['csa_id'] = get_agentname($val['csa_id'], 'name');
        }
        $dataArray['result'] = $newshiparray;
        echo json_encode($dataArray);
    }

    public function ShowEditShipment() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $table_id = $_POST['cusid'];

        $returnArray = $this->ShipmentManagement_model->GetShipment_edit($table_id);

        echo json_encode($returnArray);
    }

    public function ShowEditShipmentStatus() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $table_id = $_POST['cusid'];

        $returnArray = $this->ShipmentManagement_model->GetShipment_editStatus($table_id);

        echo json_encode($returnArray);
    }

    public function get_delete_shipment() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $array = array('deleted' => 'Y');
        $ReturnData = $this->ShipmentManagement_model->getshipmentdelete($array, $_POST['id']);
        echo json_encode($ReturnData);
    }

    public function get_retrieve_shipment() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $array = array('deleted' => 'N');
        $ReturnData = $this->ShipmentManagement_model->getshipmentdelete($array, $_POST['id']);
        echo json_encode($ReturnData);
    }

    public function AddShipmentStatus() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataArray = $_POST['edit_status'];
        $user_id = $dataArray['userid'];
        $cusid = $dataArray['cusid'];
        $pickup_date = date('Y-m-d H:i:s');
        if (!empty($dataArray)) {

            if ($user_id == "1" || $user_id == "10" || $user_id == "8" || $user_id == "4" || $user_id == "15" || $user_id == "20" || $user_id == "21" || $user_id == "24" || $user_id == "25" || $user_id == "26" || $user_id == "27") {
                $shipmentArray = array('code' => $dataArray['sub_category'], 'status_comment' => $dataArray['comment']);
            } else if ($user_id == "3" || $user_id == "5") {
                $shipmentArray = array('status_comment' => $dataArray['comment'], 'messanger_id' => '1');
            } else if ($user_id == "7") {
                $shipmentArray = array('status_comment' => $dataArray['comment'], 'shelv_no' => $dataArray['shelv_no']);
            } else if ($user_id == "11" || $user_id == "13") {
                $shipmentArray = array('status_comment' => $dataArray['comment'], 'delevered_to' => $dataArray['reciever_name'], 'delevered_no' => $dataArray['reciever_number'], 'delever_date' => $pickup_date, 'messanger_id' => '1');
            } else if ($user_id == "14") {
                $shipmentArray = array('status_comment' => $dataArray['comment'], 'shelv_no' => $dataArray['shelv_no'], 'messanger_id' => '1');
            }
            $shipmentstatusArray = array('user_id' => '1', 'user_type' => 'user', 'slip_no' => $dataArray['booking_id'], 'new_status' => $user_id, 'code' => $dataArray['sub_category'], 'pickup_date' => $pickup_date, 'comment' => $dataArray['comment'], 'entry_date' => $pickup_date);


            $res_data = $this->ShipmentManagement_model->insertStatus($shipmentstatusArray);
            $res_data1 = $this->ShipmentManagement_model->getshipmentdelete($shipmentArray, $cusid);

            $return = true;
        } else {

            $return = false;
        }
        echo json_encode($res_data);
    }

    public function addtransferShipment1() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataArray = $_POST['ManifestScanArr'];
        $id = $dataArray['id'];
        $pickup_date = date('Y-m-d H:i:s');

        $pickup_date = date('Y-m-d H:i:s');
        $pickup_time = date('Y-m-d');
        if (!empty($dataArray)) {

            $UpdateshipmentArray = array('destination' => $dataArray['origin'], 'reciever_city' => $dataArray['origin'], 'reciever_address' => $dataArray['address']);


            $insertstatusArray = array('user_id' => '1', 'user_type' => 'user', 'slip_no' => $dataArray['slip_no'], 'new_status' => 'Transferred', 'pickup_time' => $pickup_time, 'pickup_date' => $pickup_date, 'entry_date' => $pickup_date, 'Activites' => 'Shipment Transferred', 'Details' => 'Shimpment Transferred to requested Destination', 'code' => 'TR');


            $res_data = $this->ShipmentManagement_model->insertStatus($insertstatusArray);
            $res_data1 = $this->ShipmentManagement_model->getshipmentdelete($UpdateshipmentArray, $id);

            $return = true;
        } else {

            $return = false;
        }


        echo json_encode($res_data);
    }

    public function AddShipmentFile() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataArray = $_POST['edit_status'];
        $user_id = $dataArray['userid'];
        $cusid = $dataArray['cusid'];
        $pickup_date = date('Y-m-d H:i:s');
        if (!empty($dataArray)) {

            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/images/";

            $d1 = 'file_add' . mktime(date(h), date(i), date(s), date(m), date(d), date(y));
            $path = 'assets/images/' . $d1 . '.pdf';

            move_uploaded_file($_FILES['file_add']['tmp_name'], "$path");
            $file_add = $d1 . '.pdf';
            unlink('assets/images/' . $_REQUEST['file_add']);

            $shipmentAddArray = array('file_add' => $file_add);


            $res_data = $this->ShipmentManagement_model->UpdateAddFile($shipmentAddArray, $cusid);

            $return = true;
        } else {

            $return = false;
        }
        echo json_encode($res_data);
    }

    public function AddShipment() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataArray = $_POST['add_new_shipment'];
        if (!empty($dataArray)) {

            $customerArray = array('booking_id' => $dataArray['booking_id'], 'code' => $dataArray['code'],
                'booking_mode' => $dataArray['booking_mode'], 'shippers_ac_no' => $dataArray['shippers_ac_no'], 'sender_name' => $dataArray['sender_name'],
                'sender_city' => $dataArray['sender_city'], 'sender_address' => $dataArray['sender_address'], 'sender_phone' => $dataArray['sender_phone'], 'sender_email' => $dataArray['sender_email'], 'reciever_name' => $dataArray['reciever_name'],
                'reciever_city' => $dataArray['reciever_city'], 'reciever_zip' => $dataArray['reciever_zip'], 'reciever_address' => $dataArray['reciever_address'], 'reciever_phone' => $dataArray['reciever_phone'],
                'reciever_email' => $dataArray['reciever_email'], 'nrd' => $dataArray['nrd'], 'pieces' => $dataArray['pieces'], 'service_id' => $dataArray['service_id'],
                'declared_charge' => $dataArray['declared_charge'], 'status_describtion' => $dataArray['status_describtion'], 'sku' => $dataArray['sku'],
                'weight' => $dataArray['weight'], 'service_charge' => $dataArray['service_charge'], 'service_tax' => $dataArray['service_tax'], 'other_charges' => $dataArray['other_charges'], 'total_amt' => $dataArray['total_amt']);

            $res_data = $this->ShipmentManagement_model->insertShipment($customerArray);

            $return = true;
        } else {

            $return = false;
        }
        echo json_encode($res_data);
    }

    public function AddAssignShipment() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataArray = $_POST['assign_shipment'];
        $statusshow = false;
        if (!empty($dataArray)) {
            if ($dataArray['awb_no'] != '') {
                if ($dataArray['csa_id'] != '') {
                    $a = trim(' ', $dataArray['awb_no']);
                    if ($a != '') {
                        if (strpos($a, PHP_EOL) !== '') {
                            $slipData = explode(PHP_EOL, $dataArray['awb_no']);
                        } else if (strpos($a, ',') !== '') {
                            $slipData = explode(",", $dataArray['awb_no']);
                        }
                    }
                    $CURRENT_DATE = date("Y-m-d H:i:s");
                    $CURRENT_TIME = date("H:i");

                    if ($slipData != '') {
                        $wrong_awb = array();
                        $success_update = array();
                        $updatesAwb = array();

                        $shipmentLoopArray = array_unique($slipData);
                        $error = array();
                        foreach ($shipmentLoopArray as $key1 => $val1) {
                            $drsData = $this->ShipmentManagement_model->GetstatusShipmentDataQry(trim($slipData[$key1]));


                            if (!empty($drsData)) {

                                $assigningdata = $this->ShipmentManagement_model->GetassignmentQryData(trim($slipData[$key1]));
                                if (trim($slipData[$key1]) == $assigningdata[$key1]['slip_no']) {
                                    $statusshow = true;
                                    $this->ShipmentManagement_model->UpdateAssigntableData(trim($slipData[$key1]));
                                    array_push($updatesAwb, trim($slipData[$key1]));
                                    // print_r($updatesAwb);
                                    $returnarry['updatesAwb'] = $updatesAwb;
                                    if (!empty($assigningdata)) {
                                        $this->ShipmentManagement_model->AddedAssigntableData(trim($slipData[$key1]), $dataArray['csa_id']);
                                    } else {

                                        array_push($wrong_awb, trim($slipData[$key1]));
                                        $returnarry['wrong_awb'] = $wrong_awb;
                                    }
                                } else {
                                    $statusshow = true;
                                    $this->ShipmentManagement_model->AddedAssigntableData(trim($slipData[$key1]), $dataArray['csa_id']);
                                    $details = 'Shipment Assign  By CSA to ' . $this->session->userdata('user_name');
                                    $shipmentstatusArray = array('Activites' => 'shipment assign to CSA',
                                        'Details' => $details,
                                        'user_id' => $this->session->userdata('useridadmin'),
                                        'user_type' => 'user',
                                        'slip_no' => $dataArray['awb_no'],
                                        'code' => 'ACSA',
                                        'pickup_date' => $CURRENT_DATE,
                                        'pickup_time' => $CURRENT_TIME,
                                        'entry_date' => $CURRENT_DATE,
                                        'new_location' => $this->session->userdata('adminbranchlocation'),
                                        'Activites' => 'shipment assign to CSA',
                                        'new_status' => 0);

                                    $res_data = $this->ShipmentManagement_model->insertStatus($shipmentstatusArray);
                                    array_push($updatesAwb, trim($slipData[$key1]));
                                    $returnarry['updatesAwb'] = $updatesAwb;
                                }
                            } else {
                                array_push($wrong_awb, trim($slipData[$key1]));
                                $returnarry['wrong_awb'] = $wrong_awb;
                            }
                        }
                    }
                } else
                    $returnarry['errmess'] = 'CSA is required.';
            } else {
                $returnarry['errmess'] = 'awb no required';
            }
        } else
            $returnarry['errmess'] = 'all filed are required';

        $return = array('status' => $statusshow, 'returnR' => $returnarry);
        echo json_encode($return);
    }

    public function AddEditShipment() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataArray = $_POST['edit_shipment'];
        $cusid = $dataArray['cusid'];

        if (!empty($dataArray)) {


            $customerArray = array('booking_id' => $dataArray['booking_id'], 'code' => $dataArray['code'],
                'booking_mode' => $dataArray['booking_mode'], 'shippers_ac_no' => $dataArray['shippers_ac_no'], 'sender_name' => $dataArray['sender_name'],
                'sender_city' => $dataArray['sender_city'], 'sender_address' => $dataArray['sender_address'], 'sender_phone' => $dataArray['sender_phone'], 'sender_email' => $dataArray['sender_email'], 'reciever_name' => $dataArray['reciever_name'],
                'reciever_city' => $dataArray['reciever_city'], 'reciever_zip' => $dataArray['reciever_zip'], 'reciever_address' => $dataArray['reciever_address'], 'reciever_phone' => $dataArray['reciever_phone'],
                'reciever_email' => $dataArray['reciever_email'], 'nrd' => $dataArray['nrd'], 'pieces' => $dataArray['pieces'], 'service_id' => $dataArray['service_id'],
                'declared_charge' => $dataArray['declared_charge'], 'status_describtion' => $dataArray['status_describtion'], 'sku' => $dataArray['sku'], 'volumetric_weight' => $dataArray['volumetric_weight'],
                'weight' => $dataArray['weight'], 'service_charge' => $dataArray['service_charge'], 'service_tax' => $dataArray['service_tax'], 'other_charges' => $dataArray['other_charges'], 'total_amt' => $dataArray['total_amt']);

            $res_data = $this->ShipmentManagement_model->updateEditShipment($customerArray, $cusid);
            $return = true;
        } else {

            $return = false;
        }
        echo json_encode($res_data);
    }

    public function Getalltemplatename() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $table_id = $_POST['template_id'];

        $returnArray = $this->ShipmentManagement_model->GetalltemplatesQuery($table_id);

        echo json_encode($returnArray);
    }

    public function GetallCountryList() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnArray = $this->ShipmentManagement_model->Getallcountry();

        echo json_encode($returnArray);
    }

    public function AddTransferShipment() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataArray = $_POST['transferdata'];
        $slip_no = $dataArray['slip_no'];
        $cusid = $dataArray['cusid'];
        $pickup_date = date('Y-m-d H:i:s');
        $pickup_time = date('Y-m-d');
        if (!empty($dataArray)) {

            $UpdateshipmentArray = array('destination' => $dataArray['city_dest'], 'reciever_city' => $dataArray['city_dest'], 'reciever_address' => $dataArray['address']);


            $insertstatusArray = array('user_id' => '1', 'user_type' => 'user', 'slip_no' => $dataArray['slip_no'], 'new_status' => 'Transferred', 'pickup_time' => $pickup_time, 'pickup_date' => $pickup_date, 'entry_date' => $pickup_date, 'Activites' => 'Shipment Transferred', 'Details' => 'Shimpment Transferred to requested Destination', 'code' => 'TR');


            $res_data = $this->ShipmentManagement_model->insertStatus($insertstatusArray);
            $res_data1 = $this->ShipmentManagement_model->getshipmentdelete($UpdateshipmentArray, $cusid);

            $return = true;
        } else {

            $return = false;
        }
        echo json_encode($res_data);
    }

    public function SendSMS() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $dataArray = $_POST;
        $slip_no = $dataArray['slip_no'];
        $cusid = $dataArray['cusid'];
        $pickup_date = date('Y-m-d H:i:s');
        $pickup_time = date('Y-m-d');
        // echo json_encode($_POST); die;
        if (!empty($dataArray)) {
            $mobile_no = $dataArray['mobile_no'];
            $details = "SMS Sent To Customer sucessfully. Mobile No: " . $mobile_no;

            SEND_SMS($mobile_no, $dataArray['templates']);
            $insertstatusArray = array('user_id' => $this->session->userdata('useridadmin'),
                'user_type' => 'user',
                'slip_no' => $dataArray['slip_no'],
                'new_status' => 'SMS Sent To Customer',
                'pickup_time' => $pickup_time,
                'pickup_date' => $pickup_date,
                'entry_date' => $pickup_date,
                'Activites' => 'SMS Sent To Customer',
                'Details' => $details,
                'code' => $dataArray['code'],
                'comment' => $dataArray['templates'],
                'new_location' => $this->session->userdata('adminbranchlocation'));
            $res_data = $this->ShipmentManagement_model->insertStatus($insertstatusArray);
            $return = true;
        } else {
            $return = false;
        }
        echo json_encode($return);
    }

    public function AddBulkUpdate() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        //echo json_encode($_POST);die;
        // $_POST['slip_no']="BEO5713437260111";
        //$_POST['userid']='1';
        //	$_POST['comment']='dsad';
        //$_POST['sub_category']='MW';
        $_POST['main_status'] = $_POST['userid'];
        $CURRENT_TIME = date('H:i:s');
        $CURRENT_DATE = date('Y-m-d H:i:s');
        //echo $_POST['slip_no']; die;
        $statusCheck = false;
        if ($_POST['slip_no'] != '') {

            //echo $_POST['main_status']; die;
            if (!empty($_POST['main_status'])) {
                if ($_POST['main_status'] == 3 || $_POST['main_status'] == 5 || $_POST['main_status'] == 14) {
                    $driverData = explode('/', $_POST['messanger_id']);
                    //print_r($driverData[2]); die();
                    if (count($driverData) < 3) {
                        $returnArray['courier_error'] = "please select courier";
                        $return = array('status' => $statusCheck, 'resultarr' => $driverData[2]);
                        //echo json_encode($return); die;
                    }
                    $driver_rout = $driverData[0];
                    $driver_name = $driverData[1];
                    $driver_id = $driverData[2];
                    //print_r($driver_id); die();
                    if ($_POST['main_status'] == 5)
                        $drs_unique_code = checkDrsToday($driver_id);
                    if ($_POST['main_status'] == 14)
                        $drs_unique_code = checkTempDrsToday($driver_id);
                    //===============================================create bar code====================================================//
                    $auto_bar_id = $drs_unique_code;
                    $show_updatedetails = ", Driver Name : $driver_name";
                }

                $mainStatus = $_POST['main_status'];
                $Activites = getStatus($mainStatus);

                if (!empty($_POST['sub_category'])) {

                    $code = $_POST['sub_category'];
                    $details = getActivity($code) . $show_updatedetails;
                } else {

                    $code = getStatusCode($mainStatus);
                    $details = getStatus($mainStatus) . $show_updatedetails;
                }

                $a = trim(' ', $_POST['slip_no']);

                if ($a != '') {
                    if (strpos($a, PHP_EOL) !== '') {
                        $slipData = explode(PHP_EOL, $_POST['slip_no']);
                    } else if (strpos($a, ',') !== '') {
                        $slipData = explode(",", $_POST['slip_no']);
                    }
                }

                //print_r($slipData); die;

                if ($slipData != '') {
                    $wrong_awb = array();
                    $deliverd_awb = array();
                    $success_update = array();
                    $schedule_issue = array();
                    $menifest_awbs = array();
                    $rtc_awb = array();
                    $refused_awb = array();
                    $status_issue = array();
                    $not_ready_for_deliver = array();
                    $not_in_selve = array();
                    $notForwareded = array();
                    $inbound_issue = array();

                    $shipmentLoopArray = array_unique($slipData);
                    $error = array();
                    /// echo $mainStatus; die;
                    // print_r($shipmentLoopArray); die;
                    //$logcount=count($shipmentLoopArray);
                    $counter = 0;
                    foreach ($shipmentLoopArray as $key1 => $val1) {
                        $logcount = $counter + 1;

                        $citydata = $this->ShipmentManagement_model->GetstatusShipmentDataQry(trim($slipData[$key1]));
                        //print_r($citydata); die; 
                        if (!empty($citydata)) {


                            if ($citydata[0]['refused'] != 'YES' || $code == 'SH' || $code == 'UI') {
                                if ($citydata[0]['code'] != 'POD') {
                                    if ($citydata[0]['code'] != 'RTC') {


                                        if ($code == 'SH') {


                                            $location = $_POST['shelv_location'];
                                            $shelv_no = $_POST['shelve_number'];

                                            $Location = getlocation($_POST['shelve_number']);

                                            $shelv_location = getshelv_location($Location);
                                            $details = "shipment Shelved at  " . $shelv_location . " and shelv no. is " . $shelv_no . " ";
                                            $param['location'] = $location;
                                            $param['shelv_no'] = $shelv_no;
                                            $param['Location'] = $Location;
                                        }


                                        $slipno = preg_replace('/\s+/', '', $citydata[0]['slip_no']);
                                        $receiver_no = $citydata[0]['reciever_phone'];
                                        $receiver_name = $citydata[0]['reciever_name'];
                                        $sender_name = $citydata[0]['sender_name'];
                                        $status = getStatus($citydata[0]['delivered']);
                                        $booking_mode = $citydata[0]['mode'];
                                        $cod_amount = $citydata[0]['total_cod_amt'];
                                        $collect_fees = $citydata[0]['total_cod_amt'];
                                        $total_amt = $citydata[0]['total_amt'];
                                        $cust_id = $citydata[0]['cust_id'];
                                        $sms_on_off = getSMS_yes_no($cust_id);
                                        $scheduled = $citydata[0]['schedule_status'];
                                        $schedule_date = $citydata[0]['schedule_date'];
                                        $origin = $citydata[0]['sender_city'];
                                        $destination = $citydata[0]['reciever_city'];

                                        //==================param=================

                                        $param['code'] = $code;
                                        $param['driver_id'] = $driver_id;
                                        $param['slip_no'] = $slipno;
                                        $param['number'] = $receiver_no;
                                        $param['main_status'] = $_POST['main_status'];
                                        $param['driver_rout'] = $driver_rout;
                                        $param['drs_unique_code'] = $drs_unique_code;

                                        $param['Activites'] = $Activites;
                                        $param['destination'] = $citydata[0]['reciever_city'];
                                        $param['details'] = $details;
                                        $param['comment'] = $_POST['comment'];
                                        $param['reciever_name'] = $_POST['reciever_name'];
                                        $param['reciever_number'] = $_POST['reciever_number'];
                                        if ($_POST['main_status'] == 13) {
                                            if ($citydata[0]['code'] == 'FTH' || $citydata[0]['code'] == 'PUC' || $citydata[0]['code'] == 'DP' || $citydata[0]['code'] == 'DTH') {
                                                if ($citydata[0]['code'] == 'FTH' || $citydata[0]['code'] == 'DTH') {
                                                    $unique_id = $_REQUEST['unique_input'];
                                                    bulkRecieveInboundUpdate($param, $unique_id);
                                                    array_push($menifest_awbs, trim($slipData[$key1]));
                                                    $returnArray = array('menifest_awbs' => $menifest_awbs);
                                                    $statusCheck = true;

                                                    $destinationHub = getdestinationfieldshow($destination, 'state');
                                                    $adminHub = getdestinationfieldshows($this->session->userdata('adminbranchlocation'), 'state');
                                                    if ($destinationHub == $adminHub) {

                                                        $r_phone = $receiver_no;
                                                        $message = $slipData[$key1]; //pickupMessage($slipData[$key1]);
                                                        // SEND_SMS($r_phone,$message);
                                                    }
                                                } else {
                                                    $destinationHub = getdestinationfieldshow($destination, 'state');
                                                    //$_SESSION['adminbranchlocation'];
                                                    $adminHub = getdestinationfieldshow($this->session->userdata('adminbranchlocation'), 'state');
                                                    if ($destinationHub == $adminHub) {

                                                        $r_phone = $receiver_no;
                                                        $message = $slipData[$key1];
                                                        //SEND_SMS($r_phone,$message);
                                                    }
                                                    bulkStatusUpdate($param);
                                                    array_push($menifest_awbs, trim($slipData[$key1]));
                                                    //$_SESSION['menifest_awbs']=$menifest_awbs;	
                                                    $returnArray = array('menifest_awbs' => $menifest_awbs);
                                                    $statusCheck = true;
                                                }
                                            } else {
                                                array_push($status_issue, trim($slipData[$key1]));

                                                $returnArray = array('status_issue' => $status_issue);
                                            }
                                        }

                                        if ($code == 'OD') {



                                            //	echo 'xxxxx'.strtotime($schedule_date).'yy'.$schedule_date.'yyy'.	strtotime(date('Y-m-d')).'--'.date('Y-m-d').'--'	.$scheduled; exit;				
                                            if (strtotime($schedule_date) == strtotime(date('Y-m-d')) && $scheduled == 'Y') {
                                                if ($citydata[0]['code'] == 'RFDE') {
                                                    outOfDelivery($param);
                                                    array_push($success_update, trim($slipData[$key1]));
                                                    $returnArray = array('success_update' => $success_update);
                                                    $statusCheck = true;
                                                } else {
                                                    array_push($not_ready_for_deliver, trim($slipData[$key1]));

                                                    $returnArray = array('not_ready_for_deliver' => $not_ready_for_deliver);
                                                }
                                            } else {
                                                array_push($schedule_issue, trim($slipData[$key1]));
                                                $returnArray = array('schedule_issue' => $schedule_issue);
                                            }
                                        } else if ($code == 'OP') {

                                            if ($citydata[0]['code'] == 'B') {
                                                createPickup($param);
                                                array_push($success_update, trim($slipData[$key1]));
                                                $returnArray = array('success_update' => $success_update);
                                                $statusCheck = true;
                                            } else {

                                                array_push($status_issue, trim($slipData[$key1]));
                                                $returnArray = array('status_issue' => $status_issue);
                                            }
                                        } elseif ($code == 'POD') {

                                            if ($citydata[0]['code'] == 'OD') {
                                                deliverShipment($param);
                                                array_push($success_update, trim($slipData[$key1]));
                                                $returnArray = array('success_update' => $success_update);
                                                $statusCheck = true;
                                            } else {
                                                array_push($status_issue, trim($slipData[$key1]));
                                                $returnArray = array('status_issue' => $status_issue);
                                            }
                                        } elseif ($code == 'PUC') {
                                            if ($citydata[0]['code'] == 'OP' || $citydata[0]['code'] == 'B' || $citydata[0]['code'] == 'RP') {

                                                $number = $citydata[0]['reciever_phone'];
                                                $driver_mobile = '920011657';

                                                $message = "Ù„Ù‚Ø¯ ØªÙ… Ø¥Ø³ØªÙ„Ø§Ù… Ø·Ù„Ø¨Ùƒ " . $citydata[0]['sender_name'] . " Ù…Ù† Ù‚Ø¨Ù„ Ø´Ø±ÙƒØ© ØªÙ… Ø§ÙƒØ³Ø¨Ø±ÙŠØ³ 920011657 , AWB # " . $citydata[0]['slip_no'];
                                                $message_eng = "We have receive your order from " . $citydata[0]['sender_name'] . " by TAMCO 920011657";

                                                //SEND_SMS($number,$message);
                                                bulkStatusUpdate($param);
                                                array_push($success_update, trim($slipData[$key1]));
                                                $returnArray = array('success_update' => $success_update);
                                                $statusCheck = true;
                                            } else {
                                                array_push($status_issue, trim($slipData[$key1]));

                                                $returnArray = array('status_issue' => $status_issue);
                                            }
                                        } else {

                                            if ($mainStatus == 1) {

                                                if ($citydata[0]['code'] == 'OD') {

                                                    if ($code == 'DD') {
                                                        $number = $citydata[0]['reciever_phone'];
                                                        $message = $citydata[0]['slip_no'];
                                                        SEND_SMS($number, $message);
                                                    }
                                                    bulkStatusUpdate($param);
                                                    array_push($success_update, trim($slipData[$key1]));
                                                    $returnArray = array('success_update' => $success_update);
                                                    $statusCheck = true;
                                                } else {
                                                    array_push($status_issue, trim($slipData[$key1]));
                                                    $returnArray = array('status_issue' => $status_issue);
                                                }
                                            }
                                            if ($code == 'RFDE') {

                                                if (strtotime($schedule_date) == strtotime(date('Y-m-d')) && $scheduled == 'Y') {
                                                    //	echo $citydata[0]['code']; die;
                                                    if ($citydata[0]['code'] == 'SH' || $citydata[0]['code'] == 'RFDE') {
                                                        //echo "ssssss"; die;	
                                                        readyForDelivery($param);
                                                        array_push($success_update, trim($slipData[$key1]));
                                                        $returnArray = array('success_update' => $success_update);
                                                        $statusCheck = true;
                                                    } else {
                                                        array_push($not_in_selve, trim($slipData[$key1]));
                                                        $returnArray = array('not_in_selve' => $not_in_selve);
                                                    }
                                                } else {
                                                    array_push($schedule_issue, trim($slipData[$key1]));
                                                    $returnArray = array('schedule_issue' => $schedule_issue);
                                                }
                                            } elseif ($code == 'SH') {
                                                if ($citydata[0]['code'] == 'RI' || $citydata[0]['code'] == 'RDS') {
                                                    if ($_REQUEST['main_status'] != 13 || $citydata[0]['code'] == 'RDS') {
                                                        shelveShipment($param);
                                                        array_push($success_update, trim($slipData[$key1]));
                                                        $returnArray = array('success_update' => $success_update);
                                                        $statusCheck = true;
                                                    }
                                                } else {
                                                    array_push($inbound_issue, trim($slipData[$key1]));
                                                    $returnArray = array('inbound_issue' => $inbound_issue);
                                                }
                                            } elseif ($code == 'RDS') {
                                                if ($citydata[0]['frwd_throw'] != '') {
                                                    if ($_POST['main_status'] == 24) {
                                                        bulkStatusUpdatereturndelivery($param);
                                                        array_push($success_update, trim($slipData[$key1]));
                                                        $returnArray = array('success_update' => $success_update);
                                                        $statusCheck = true;
                                                    }
                                                } else {
                                                    array_push($notForwareded, trim($slipData[$key1]));
                                                    $returnArray = array('notForwareded' => $notForwareded);
                                                }
                                            } elseif ($code == 'UI') {
                                                bulkStatusUpdateUi($param);
                                                array_push($success_update, trim($slipData[$key1]));
                                                $returnArray = array('success_update' => $success_update);
                                                $statusCheck = true;
                                            } else {

                                                if ($citydata[0]['code'] != 'OD' || $citydata[0]['code'] != 'OP') {

                                                    //echo 'xxxx'.$citydata[0]['code'];exit;
                                                    if ($_POST["main_status"] != 13) {
                                                        bulkStatusUpdate($param);
                                                        array_push($success_update, trim($slipData[$key1]));
                                                        $returnArray = array('success_update' => $success_update);
                                                        $statusCheck = true;
                                                    }
                                                } else {
                                                    array_push($not_in_selve, trim($slipData[$key1]));
                                                    $returnArray = array('not_in_selve' => $not_in_selve);
                                                }
                                            }
                                        }
                                        // echo $citydata[0]['cust_id']; exit;
                                        if ($citydata[0]['cust_id'] == '43' || $citydata[0]['cust_id'] == '40') {

                                            $data['slip_no'] = $citydata[0]['booking_id'];
                                            $data['new_location'] = $new_location;
                                            $data['new_status'] = $_POST['main_status'];
                                            $data['Activites'] = $Activites;
                                            $data['Details'] = $details;
                                            $data['comment'] = $comment;
                                            //$functions->trackPush(trim($slipData[$key1]));
                                        }
                                    } else {

                                        array_push($rtc_awb, trim($slipData[$key1]));
                                        $returnArray = array('rtc_awb' => $rtc_awb);


                                        //$error2=1;
                                    }
                                } else {
                                    array_push($deliverd_awb, trim($slipData[$key1]));
                                    $returnArray = array('deliverd_awb' => $deliverd_awb);


                                    // $error['derror']=1;
                                }
                            } else {
                                array_push($refused_awb, trim($slipData[$key1]));
                                $returnArray = array('refused_awb' => $refused_awb);
                            }
                        } else {
                            array_push($wrong_awb, trim($slipData[$key1]));
                            $returnarry['wrong_awb'] = $wrong_awb;
                        }
                        //echo $citydata[0]['cust_id'];
                        //echo $logcount;
                        if ($mainStatus == '1')
                            GetAllclientLogUpdates(1, 'not_delivered', $citydata[0]['cust_id']);
                        elseif ($mainStatus == 3)
                            GetAllclientLogUpdates(1, 'on_process', $citydata[0]['cust_id']);
                        elseif ($mainStatus == 4)
                            GetAllclientLogUpdates(1, 'pick_up_collected', $citydata[0]['cust_id']);
                        elseif ($mainStatus == 5)
                            GetAllclientLogUpdates(1, 'out_for_delivery', $citydata[0]['cust_id']);
                        elseif ($mainStatus == 7)
                            GetAllclientLogUpdates(1, 'shelve', $citydata[0]['cust_id']);
                        elseif ($mainStatus == 8)
                            GetAllclientLogUpdates(1, 'in_transit', $citydata[0]['cust_id']);
                        elseif ($mainStatus == 10)
                            GetAllclientLogUpdates(1, 'hold_for_pickup', $citydata[0]['cust_id']);
                        elseif ($mainStatus == 11)
                            GetAllclientLogUpdates(1, 'delivered', $citydata[0]['cust_id']);
                        elseif ($mainStatus == 13)
                            GetAllclientLogUpdates(1, 'received_inbound', $citydata[0]['cust_id']);
                        elseif ($mainStatus == 14)
                            GetAllclientLogUpdates(1, 'ready_for_delivery', $citydata[0]['cust_id']);
                        elseif ($mainStatus == 15)
                            GetAllclientLogUpdates(1, 'general_update', $citydata[0]['cust_id']);
                        elseif ($mainStatus == 20)
                            GetAllclientLogUpdates(1, 'booked_reverse_pick', $citydata[0]['cust_id']);
                        elseif ($mainStatus == 21)
                            GetAllclientLogUpdates(1, 'cancelled_per_client', $citydata[0]['cust_id']);
                        elseif ($mainStatus == 24)
                            GetAllclientLogUpdates(1, 'Refrom_delivery_station', $citydata[0]['cust_id']);
                        else
                            GetAllclientLogUpdates(1, 'under_investigation', $citydata[0]['cust_id']);
                        //$counter++;
                    }
                }

                $return = array('status' => $statusCheck, 'resultarr' => $returnArray);
            } else {
                $returnArray['mainstatusEmpty'] = "please select main status";
                $return = array('status' => $statusCheck, 'resultarr' => $returnArray);
            }
        } else {
            $return = array('status' => $statusCheck, 'resultarr' => $returnArray);
        }


        echo json_encode($return);
    }

    public function getDashboardData() {
        $totalBookingarray = get_totel_booking_today();
        $totalCustomerarray = get_totel_customer_today();
        $totalPaymentarray = get_totel_payment_today();
        $totalInquroesarray = get_totel_inquries_today();
        $totalnotDelarray = gettotalValueFromShipment_admin("not-delivered", 0, "not_delivered");
        $totalpickupColarray = gettotalValueFromShipment_admin1("pick-up-collected", 0, "pick_upcollected");
        $totaloutforDelarray = gettotalValueFromShipment_admin2("out-for-delivery", 0, "outfordelivery");
        $totalreturnarray = gettotalValueFromShipment_admin3("return", 0, "returnval");
        $totalshelvearray = gettotalValueFromShipment_admin4("shelve", 0, "shelve");
        $totalShipmentForwardarray = gettotalValueFromShipment_admin5("shipment-forward-arrival", 0, "shipment_forward_arrival");
        $totalHoldPickuparray = gettotalValueFromShipment_admin6("hold-for-pickup", 0, "holdfor_pickup");
        $totalPODarray = gettotalValueFromShipment_admin7("pod", 0, "pod");
        $totalreceivedarray = gettotalValueFromShipment_admin8("received-inbound", 0, "received_inbound");
        $totalreadyDeliverarray = gettotalValueFromShipment_admin9("ready-for-delivery", 0, "readyfor_delivery");

        $dataArray['total_shipment'] = $totalBookingarray;
        $dataArray['total_coustomer'] = $totalCustomerarray;
        $dataArray['total_payment'] = $totalPaymentarray;
        $dataArray['total_customer'] = $totalInquroesarray;
        $dataArray['not_delivered'] = $totalnotDelarray;
        $dataArray['pick_upcollected'] = $totalpickupColarray;
        $dataArray['outfordelivery'] = $totaloutforDelarray;
        $dataArray['returnval'] = $totalreturnarray;
        $dataArray['shelve'] = $totalshelvearray;
        $dataArray['shipment_forward_arrival'] = $totalShipmentForwardarray;
        $dataArray['holdfor_pickup'] = $totalHoldPickuparray;
        $dataArray['pod'] = $totalPODarray;
        $dataArray['received_inbound'] = $totalreceivedarray;
        $dataArray['readyfor_delivery'] = $totalreadyDeliverarray;
        echo json_encode($dataArray);
    }

    public function getCustomerDrop() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnArray = $this->ShipmentManagement_model->getCustomerDropData();
        echo json_encode($returnArray);
    }

    public function getStaffDrop() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnArray = $this->ShipmentManagement_model->getStaffDropData();
        echo json_encode($returnArray);
    }

    public function getStatusDrop() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnArray = $this->ShipmentManagement_model->getStatusDropData();
        echo json_encode($returnArray);
    }

    public function getOriginDrop() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $returnArray = $this->ShipmentManagement_model->getOriginDropData();
        echo json_encode($returnArray);
    }

    public function DeleteShipment() {
        $_POST = json_decode(file_get_contents('php://input'), true);

        $array = $_POST['itemList'];
        for ($count = 0; $count < count($array); $count++) {
            $dataarray = array('deleted' => 'Y');

            $ReturnData = $this->ShipmentManagement_model->delete($array[$count], $dataarray);
        }

        echo json_encode($ReturnData);
    }

    public function ShowShipDetails() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $table_id = $_POST['shid'];
        $ShipArray = $this->ShipmentManagement_model->GetShipmentData($table_id);
        $ShipArray['origin'] = Get_name_country_by_id('city', $ShipArray['origin']);
        $ShipArray['destination'] = Get_name_country_by_id('city', $ShipArray['destination']);
        $ShipArray['showstatus'] = status_main_cat($ShipArray['delivered']);
        $ShipArray['store_link'] = GetcustomerTable($ShipArray['cust_id'], 'store_link');
        $ShipArray['VIP_user'] = GetcustomerTable($ShipArray['cust_id'], 'VIP_user');
        $ShipArray['uniqueid'] = GetcustomerTable($ShipArray['cust_id'], 'uniqueid');

        $statusArray = $this->ShipmentManagement_model->GetShipmentstatus($ShipArray['slip_no']);
        $newstatusArray = $statusArray;
        foreach ($newstatusArray as $key => $val2) {

            $newstatusArray[$key]['new_location'] = Get_name_country_by_id('city', $val2['new_location']);
            $newstatusArray[$key]['citycode'] = Get_name_country_by_id('city_code', $val2['new_location']);
            $newstatusArray[$key]['username'] = Get_user_name($val2['user_id'], $val2['user_type']);
            $newstatusArray[$key]['delivered_show'] = status_main_cat($val['delivered']);
        }
        $messengerArray = $this->ShipmentManagement_model->GetCourierStaff($ShipArray['messanger_id']);
        $SchedulingHistory = $this->ShipmentManagement_model->GetshipemtSchedulingHistory($ShipArray['slip_no']);
        $newSchedulingHistory = $SchedulingHistory;
        foreach ($newSchedulingHistory as $key => $val) {
            $newSchedulingHistory[$key]['username'] = Get_user_name($val['user_id'], $val['type']);
        }


        //$receiverArray=$this->ShipmentManagement_model->GetReceiver($ShipArray['messanger_id']);
        $return['diamentionArr'] = get_diamention_shipment_datail($ShipArray['slip_no']);
        $return['shipInfo'] = $ShipArray;
        $return['statusArray'] = $newstatusArray;
        $return['messengerArray'] = $messengerArray;
        $return['SchedulingHistory'] = $newSchedulingHistory;
        echo json_encode($return);
    }

    public function ShowArchieveDetails() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $table_id = $_POST['shid'];
        $ShipArray = $this->ShipmentManagement_model->GetArchieveData($table_id);
        $ShipArray['origin'] = Get_name_country_by_id('city', $ShipArray['origin']);
        $ShipArray['destination'] = Get_name_country_by_id('city', $ShipArray['destination']);
        $ShipArray['showstatus'] = status_main_cat($ShipArray['delivered']);
        $ShipArray['store_link'] = GetcustomerTable($ShipArray['cust_id'], 'store_link');
        $ShipArray['VIP_user'] = GetcustomerTable($ShipArray['cust_id'], 'VIP_user');
        $ShipArray['uniqueid'] = GetcustomerTable($ShipArray['cust_id'], 'uniqueid');

        $statusArray = $this->ShipmentManagement_model->GetArchievestatus($ShipArray['slip_no']);
        $newstatusArray = $statusArray;
        foreach ($newstatusArray as $key => $val2) {

            $newstatusArray[$key]['new_location'] = Get_name_country_by_id('city', $val2['new_location']);
            $newstatusArray[$key]['citycode'] = Get_name_country_by_id('city_code', $val2['new_location']);
            $newstatusArray[$key]['username'] = Get_user_name($val2['user_id'], $val2['user_type']);
        }
        $messengerArray = $this->ShipmentManagement_model->GetCourierStaff($ShipArray['messanger_id']);
        $SchedulingHistory = $this->ShipmentManagement_model->GetshipemtSchedulingHistory($ShipArray['slip_no']);
        $newSchedulingHistory = $SchedulingHistory;
        foreach ($newSchedulingHistory as $key => $val) {
            $newSchedulingHistory[$key]['username'] = Get_user_name($val['user_id'], $val['type']);
        }


        //$receiverArray=$this->ShipmentManagement_model->GetReceiver($ShipArray['messanger_id']);
        $return['diamentionArr'] = get_diamention_shipment_datail($ShipArray['slip_no']);
        $return['shipInfo'] = $ShipArray;
        $return['statusArray'] = $newstatusArray;
        $return['messengerArray'] = $messengerArray;
        $return['SchedulingHistory'] = $newSchedulingHistory;
        echo json_encode($return);
    }

    public function ShowShipmentStatus() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $table_id = $_POST['slip_no'];
        $returnArray = $this->ShipmentManagement_model->GetShipmentstatus($table_id);
        echo json_encode($_POST);
    }

    public function ShowCourierStaff() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $table_id = $_POST['messanger_id'];
        $returnArray = $this->ShipmentManagement_model->GetCourierStaff($table_id);
        echo json_encode($_POST);
    }

    public function ShowaminstatusDropData() {

        $return = all_main_status_bulk();
        echo json_encode($return);
    }

    public function Getallsubcatdata() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $return = all_main_status_subCat($_POST['statusid']);
        echo json_encode($return);
    }

    public function getData() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        //$searchText=$_POST['searchText'];
        $returnArray = $this->ShipmentManagement_model->getmessangername();
        echo json_encode($returnArray);
    }

    public function getShelveData() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        //$searchText=$_POST['searchText'];
        $returnArray = $this->ShipmentManagement_model->getshelvename();
        echo json_encode($returnArray);
    }

    public function inter_originData() {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $return = inter_origin();
        echo json_encode($return);
    }

    public function messangerDataShow() {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $return = messangerData();
        echo json_encode($return);
    }

    public function GetlabelPrint4_6($pickUpId = null, $page = null) {


        $this->load->helper('pdf_helper');
        $this->load->library('pagination');
        $this->load->library('M_pdf');



        //	die;
        $data['pickupId'] = $pickUpId;
        $status_update_data = $this->ShipmentManagement_model->PrintawbFilterShip($pickUpId);

        if (!empty($status_update_data)) {
            $html .= '
			<!doctype html>
				<html>
					<head>
						<meta charset="utf-8">';
            $html .= '<title>AWB print of ' . $awb . ' </title> ';

            $html .= '	<style>


				img {
    -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
    filter: grayscale(100%);
}
						.invoice-box {
							max-width: 800px;
							margin: auto;
							padding: 10px;
							border: 1px solid #eee;
							box-shadow: 0 0 10px rgba(0, 0, 0, .15);
							font-size: 12px;
							line-height: 24px;
							font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
							color: #555;
							height:850px
						}
						
						.invoice-box table {
							width: 100%;
							line-height: inherit;
							text-align: left;
						}
						
						.invoice-box table td {
							padding: 5px;
							vertical-align: top;
						}
						
						.invoice-box table tr td:nth-child(2) {
							text-align: left;
						}
						
						.invoice-box table tr.top table td {
							padding-bottom: 10px;
						}
						
						.invoice-box table tr.top table td.title {
							font-size: 45px;
							line-height: 45px;
							color: #333;
						}
						table {
							font-family: arial, sans-serif;
							border-collapse: collapse;
							width: 100%;
						}

						td, th {
							
							text-align: left;
							padding: 0px;
						} 
						</style>
					</head> 
					<body>';
            foreach ($status_update_data as $key => $val) {


                $destination = getdestinationfieldshow($status_update_data[$key]['destination'], 'city');
                $origin = getdestinationfieldshow($status_update_data[$key]['origin'], 'city');
                $dcode = getCityCode($status_update_data[$key]['destination']);
                $oringincode = getCityCode($status_update_data[$key]['origin']);
                $account_no = Get_cust_uid($status_update_data[$key]['cust_id']);
                $limit = $status_update_data[$key]['pieces'];
                for ($i = 1; $i <= $limit; $i++) {



                    if ($status_update_data[$key]['weight'] > $status_update_data[$key]['volumetric_weight'])
                        $weight = $status_update_data[$key]['weight'];
                    else
                        $weight = $status_update_data[$key]['volumetric_weight'];

                    /* 	$listingQry1="select * from status where deleted='N' and slip_no='".$status_update_data[$key]['slip_no']."'";
                      $this->dbh_read->Query($listingQry1);
                      if($this->dbh_read->num_rows)
                      {
                      $status_update_data1=$this->dbh_read->FetchAllResults($listingQry1);
                      //$objSmarty->assign("status_update_data1", $status_update_data1);
                      } */


                    //$destination_city=$functions->Get_city_idd($status_update_data[$key]['country_city']);
                    //echo 'application/third_party/qrcodegen.php?data='.$status_update_data[$key]['slip_no']; die;
                    $html .= '<div class="invoice-box">
							<table cellpadding="0" cellspacing="0"  border="1">
								<tr >
									
											<tr>
												<td class="" style="width:34%; ">
													<img src="' . base_url . site_configTable('logo') . '"  style="height:17% !important; width:100px !important">
												</td>
												
												
												<td style=" text-align:center" class="center" > 
												<img src="' . base_url() . 'application/third_party/qrcodegen.php?data=' . $status_update_data[$key]['slip_no'] . '"  style="height:17% !important; width:17% !important;" /> 
												</td>
												<td align="center" style="width:33%"> 
											<span style="font-size:28px;">' . $dcode . '</span>
												</td>
											</tr>
											<tr> 
										
									
								</tr>
								</table>
								<table border="1">
								
											<tr  align="center">
									<td style="font-size:12px; width:50%">
										 <strong> From</strong>  :  <br />
										<strong>' . $status_update_data[$key]['sender_name'] . '  </strong><br />
										' . $status_update_data[$key]['sender_address'] . '
										 <br /><strong>Mobile</strong>: ' . $status_update_data[$key]['sender_phone'] . '
										 <br /><strong>City</strong>: ' . $origin . '
									</td>
									
										
									<td class="center "  style="font-size:10px;">
										 <strong> To</strong>  :  <br />
										<strong>' . $status_update_data[$key]['reciever_name'] . ' </strong> <br />
										' . $status_update_data[$key]['reciever_address'] . '
										 <br /><strong>Mobile</strong>: ' . $status_update_data[$key]['reciever_phone'] . '
										 <br /><strong>City</strong>: ' . $destination . '
									</td>
									
								</tr> 
										
									
								</tr> 
							</table>
							<table cellpadding="0" cellspacing="0" border="1">	   
							<tr> <td colspan="2"  style="font-size:12px; align:center" align="center" >
										  
										' . barcodeRuntime_new($status_update_data[$key]['slip_no']) . '</td>
											</tr> <tr> 
										<td colspan="2" style="font-size:14px; align:center" align="center" ><strong>' . $status_update_data[$key]['slip_no'] . '  ' . $i . '/' . $status_update_data[$key]['pieces'] . '</strong>
									</td>
									
								</tr>
								<tr>
									<td class=" " style="font-size:8px;">
										<strong> Account number </strong>: ' . $account_no . '
									</td>
							 
									<td class=" " style="font-size:8px;">
										<strong> Date </strong> : ' . date("d-m-Y H:i:s", strtotime($status_update_data[$key]['entrydate'])) . '
									</td>  
								</tr>
								<tr>
									<td class=" " style="font-size:12px;">
										<strong> Weight</strong> : ' . $weight . 'Kg' . '
									</td>  
							 
									<td class=" "style="font-size:12px;">
										<strong> Pieces </strong>: ' . $status_update_data[$key]['pieces'] . '
									</td>  
									
								</tr>
								<!--<tr>
									<td class=" " style="font-size:12px;">
										<strong> Reference number </strong>: ' . $status_update_data[$key]['booking_id'] . '
									</td> 
								</tr>-->  ';


                    if ($status_update_data[$key]['pod'] == 'Y') {
                        $html .= '<tr>
										<td class=" " style="font-size:12px;">
											<strong> POD fees </strong>: ' . $status_update_data[$key]['pod_fees'] . '
										</td> 
									</tr>';
                    }
                    if ($status_update_data[$key]['pod'] == 'Y') {
                        $pod_services = 'Yes';
                    } else {
                        $pod_services = 'No';
                    }


                    $Total_amount = $status_update_data[$key]['cod_fees'] + $status_update_data[$key]['service_charge'] + $status_update_data[$key]['total_cod_amt'];

                    if ($status_update_data[$key]['total_cod_amt'] != '' && $status_update_data[$key]['total_cod_amt'] != '0') {
                        if ($status_update_data[$key]['client_type'] == 'B2C') {
                            $html .= '<tr> 
											<td class=" " colspan="2" align="center">
												<strong> COD </strong>: ' . $status_update_data[$key]['total_cod_amt'] . '
											</td>  
										</tr>';
                        } else {
                            $html .= '<tr>
											<td class=" "colspan="2" align="center">
												<strong> COD </strong>: ' . $Total_amount . ' SAR
											</td>  
										</tr>';
                        }
                    }

                    if (!empty($status_update_data[$key]['booking_id'])) {
                        $html .= '  
							
								<tr align="center">
									<td colspan="2"  style="font-size:12px; align:center" align="center">
										
										' . barcodeRuntime_new($status_update_data[$key]['booking_id']) . '
										</td>
										</tr> <tr> 
										<td colspan="2" style="font-size:12px; align:center" align="center" ><strong>' . $status_update_data[$key]['booking_id'] . '</strong>
									</td></tr> ';
                    }

                    $html .= '   <tr><td colspan="2" style="font-size:8px;" >
										<strong> Description </strong>:' . $status_update_data[$key]['status_describtion'] . '
									</td></tr></table>
						</div> ';
                }
            }
            $html .= '
							
					</body>
				</html> ';

            //echo $html; die;
            $mpdf = new mPDF('utf-8', array(101, 152), 0, '', 0, 0, 0, 0, 0, 0);
            $mpdf->WriteHTML($html);
            //$mpdf->SetDisplayMode('fullpage'); 
            //$mpdf->Output();
            $mpdf->Output('AWB_print.pdf', 'I');
        }
    }

    public function GetlabelPrintA4($pickUpId = null, $page = null) {


        $this->load->helper('pdf_helper');
        $this->load->library('pagination');

        $data['pickupId'] = $pickUpId;
        $shipment = $this->ShipmentManagement_model->PrintawbFilterShip($pickUpId);
        //  print_r($shipment); die;
        // print_r($shipment); exit;
        $shipment = json_decode(json_encode($shipment));
        for ($i = 0; $i < count($shipment); $i++) {
            $sku_per_shipment[$i] = $this->ShipmentManagement_model->find_by_slip_no_for_sku($shipment[$i]->slip_no);
        }

        tcpdf();
        //$custom_layout = array('101.6', '152.4');
        $obj_pdf = new TCPDF('P', PDF_UNIT, A4, true, 'UTF-8', false);
        ob_start();

        if (!empty($shipment)) {
            for ($i = 0; $i < count($shipment); $i++) {


                $obj_pdf->SetCreator(PDF_CREATOR);
                //$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                //$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                $obj_pdf->SetDefaultMonospacedFont('helvetica');
                //$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                //$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                $obj_pdf->setPrintHeader(false);
                $obj_pdf->setPrintFooter(false);
                $obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                $obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                $obj_pdf->SetFont('helvetica', '', 9);

                $obj_pdf->setFontSubsetting(false);

                $obj_pdf->AddPage();
                $obj_pdf->Rect('1', '1', '207', '295');
                $obj_pdf->Rect('1.5', '1.5', '207', '295');
                ///////Column 1///////////////////////
                $obj_pdf->Rect('1.5', '1.5', '207', '295');
                $obj_pdf->Rect('1.5', '1.5', '80', '55');
                ////////Column 2////////////////////
                $obj_pdf->Rect('81.5', '1.5', '70', '55');


                ////////Column 3////////////////////
                $obj_pdf->Rect('151.3', '1.5', '57', '55');
                $obj_pdf->Rect('1', '56.5', '100', '40');

                /////////AWB Bar Code//////////
                $obj_pdf->Rect('100.6', '56.5', '107.5', '40');
                ///////////AWB No//////////////////////
                $obj_pdf->Rect('1', '96.5', '207', '10');
                /////////Acount No AND DATE//////////////////////
                $obj_pdf->Rect('1', '106.5', '207', '23');
                $obj_pdf->Rect('1', '129.5', '207', '10');
                /////////Weight AND Pieces/////////////////////
                $obj_pdf->Rect('1', '139.5', '95', '10');
                $obj_pdf->Rect('95.6', '139.5', '113', '10');

                //////////REFRENCE BAR CODE///////////////
                $obj_pdf->Rect('1', '149.3', '95', '10');
                //////////Reference Number//////////////
                $obj_pdf->Rect('95.7', '149.3', '113', '10');
                ///////////////Code Value/////////////////
                $obj_pdf->Rect('1', '159.5', '207', '30');
                $obj_pdf->Rect('1', '189.5', '207', '15');
                // /////////Description ////////////////
                $obj_pdf->Rect('1', '205.1', '207', '25');

                // ob_start();	
                ///**********Working For Image*******///


                $image_file = file_get_contents(site_configTable('logo'));
                $obj_pdf->Image('@' . $image_file, 3, 2, 70, 50);



                // $content = ob_get_contents();
                // ob_end_clean();

                $style['position'] = 'C';
/////////////////////////here QR Code No 2d ////////////////
                $obj_pdf->write2DBarcode($shipment[$i]->slip_no, 'QRCODE,H', 70, 8, 120, 40, $style, 'N');
//////////////////////here Pass AWB NO too////////////////////////////////////////
                $obj_pdf->write1DBarcode($shipment[$i]->slip_no, 'C128', 90, 110, 62, 16, 0.7, $style, 'N');
///////////////////////here Pass Reference No ////////////////////////////////
                $obj_pdf->write1DBarcode($shipment[$i]->booking_id, 'C128', 150, 168, 62, 12, 0.7, $style, 'N');
//$obj_pdf->SetFont('aealarabiya','',9);
//////////////////////here////////////////////////////////////////
                $obj_pdf->SetTitle($shipment[$i]->slip_no);
                $obj_pdf->SetFont('helvetica', '', 12);
                $obj_pdf->Text(2, 60, 'From: ');
                $obj_pdf->Text(2, 70, 'Mobile: ');
                $obj_pdf->Text(2, 80, 'Address: ');
                $obj_pdf->Text(2, 140, 'Account No: ');
                $obj_pdf->Text(2, 150, 'Weight: ');

                $obj_pdf->Text(100, 140, 'Booking Date: ');
                $obj_pdf->Text(80, 100, 'COD: ');
                $obj_pdf->Text(100, 150, 'Pieces: ');
                $obj_pdf->Text(110, 60, 'To: ');
                $obj_pdf->Text(110, 70, 'Mobile: ');
                $obj_pdf->Text(110, 80, 'Address: ');
                $obj_pdf->Text(2, 210, 'Description: ');
                $number++;
                $obj_pdf->Text(90, 130, $shipment[$i]->slip_no);
                //$obj_pdf->Text(64,73.5,$number.'/'.$shipment[$i]->pieces);

                $obj_pdf->Text(90, 195, $shipment[$i]->booking_id);






//////////////////////here////////////////////////////////////////
                $obj_pdf->SetFont('helvetica', '', 30);

                $obj_pdf->SetFont('aealarabiya', 'B', 30);
                $obj_pdf->Text(75, 100, $data['city_code']);
                $obj_pdf->SetFont('aealarabiya', '', 10);
                $obj_pdf->Text(20, 60, $shipment[$i]->sender_name);


                $obj_pdf->Text(20, 70, $shipment[$i]->sender_phone);
                $obj_pdf->MultiCell(42, 100, $shipment[$i]->sender_address . ', ' . $data['city_code1'], 0, 'L', false, 2, 3, 85, '', true);


                $obj_pdf->Text(20, 150, $shipment[$i]->weight . ' (KG)');

                $obj_pdf->Text(95, 100, $shipment[$i]->total_cod_amt . ' (SR)');
                $obj_pdf->Text(130, 140, $shipment[$i]->entrydate);
                $obj_pdf->Text(20, 140, $data['account_no']);
                $obj_pdf->Text(120, 60, $shipment[$i]->reciever_name);

                $obj_pdf->Text(125, 70, $shipment[$i]->reciever_phone);
                $obj_pdf->MultiCell(80, 70, $shipment[$i]->reciever_address . ', ' . $data['city_code2'], 0, 'L', false, 2, 110, 85, '', true);

                $obj_pdf->Text(120, 150, $shipment[$i]->pieces . ' (PCS)');
                $obj_pdf->Text(30, 210, $shipment[$i]->status_describtion);
            }
            $content = ob_get_contents();
            ob_end_clean();
            $obj_pdf->writeHTML($content, true, false, true, false, '');
            $obj_pdf->Output(Date('d-M') . '_Shipments-Report.pdf', 'I');
        } else {
            if ($page == 'bulkpage')
                return 'bulkpage';
        }


        $content = ob_get_contents();
        ob_end_clean();
        $obj_pdf->writeHTML($content, true, false, true, false, '');
        $obj_pdf->Output(Date('d-M') . '_Shipments-Report.pdf', 'I');
    }

    public function GetshipmentExportDatahk(){
        $request = json_decode(file_get_contents('php://input'), true);
        $limit = $request['limit'];
        $start = 0;
        $this->db->select('`id`, `refused`, `schedule_status`, `schedule_type`, `code`, `schedule_date`, `time_slot`, `area_street`, `area`, `sub_category`, `booking_id`, `user_id`, `sku`, `uniqueid`, `cust_id`, `service_id`, `shippers_ac_no`, `shippers_ref_no`, `nrd`, `slip_no`, `origin`, `next_station`, `destination`, `pieces`, `weight`, `volumetric_weight`, `sender_name`, `recieved_from`, `sender_address`, `sender_zip`, `sender_phone`, `sender_fax`, `sender_email`, `sender_city`, `reciever_name`, `hand_to`, `reciever_address`, `reciever_zip`, `reciever_phone`, `reciever_fax`, `reciever_email`, `reciever_city`, `receiver_image`, `contents`, `declared_charge`, `service_charge`, `packing_charge`, `service_tax`, `valuation_charges`, `other_charges`, `total_amt`, `booking_mode`, `signature_img`, `mode`, `pickup_time`, `pickup_date`, `expected_date`, `entrydate`, `status_describtion`, `delivered`, `status_comment`, `delevered_to`, `delevered_no`, `delever_date`, `delever_time`, `req_delevery_time`, `status`, `deleted`, `in_meni`, `bar_code_img`, `zip_code_image`, `zip_code_number`, `bar_code_number`, `messanger_id`, `total_cod_amt`, `amount_collected`, `cod_paid`, `year_month_group`, `frwd_throw`, `frwd_awb_no`, `missing`, `menifest_location`, `missing_location`, `product_type`, `user_type`, `topay_amount`, `cod_fees`, `pod_fees`, `pod`, `file_add`, `dest_lng`, `dest_lat`, `shipment_all_city`, `shelv_no`, `client_type`, `d_attempt`, `route_code`, `shipping_zone`, `call_attempt`, `fulfillment`, `onHold_Confirm`, `onHold_Date`, `onHold_Days`, `onHold_Reason`, `rated`');
        $this->db->from('shipment');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->order_by('id', 'desc');
        $this->db->limit(100);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        $resultArr =  $query->result_array();
        $file_name = 'all shipment ' . date('Ymdhis') . '.xls';

        echo json_encode($this->exportitemshipmentexport($resultArr, $file_name));
        //print_r($res);die;
        
    }
    public function GetshipmentExportData() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        /*  $dataAray=$this->ShipmentManagement_model->alllistData($_POST);
          $tolalShip=$dataAray['count'];
          $shiplimit=$_POST['shiplimit']; */
        $downlaoadData = $_POST['limit'];
        $conditions = $_POST['cond'];
        $j = 0;
        for ($i = 0; $i < $tolalShip;) {
            $i = $i + $downlaoadData;
            if ($i > 0)
                $expoertdropArr[] = array('j' => $j, 'i' => $i);
            $j = $i;
        }
        $end1 = $shiplimit;
        if ($end1 <= $downlaoadData)
            $start1 = 0;
        else
            $start1 = $end1 - $downlaoadData;

        $resultArr = $this->ShipmentManagement_model->alllistData_export($start1, $downlaoadData, $conditions);

        foreach ($resultArr as $key => $val) {
            $resultArr[$key]['origin'] = Get_name_country_by_id('city', $val['origin']);
            $resultArr[$key]['destination'] = Get_name_country_by_id('city', $val['destination']);
        }
        $data = array();
        $data['results'] = $resultArr;
        //print_r($resultArr);die;
         $this->load->view('printshipmentExportData', $data);
        //$file_name = 'all shipment ' . date('Ymdhis') . '.xls';

        //echo json_encode($this->exportitemshipmentexport($resultArr, $file_name));
        //echo json_encode($resultArr);
    }

    function    exportitemshipmentexport($dataEx, $file_name) {
        $dataArray = array();
        $i = 0;
        foreach ($dataEx as $data) {

            $dataArray[$i]['entrydate'] = $data['entrydate'];
            $dataArray[$i]['pickup_date'] = $data['pickup_date'];
            $dataArray[$i]['booking_id'] = $data['booking_id'];
            $dataArray[$i]['shippers_ref_no'] = $data['shippers_ref_no'];
            $dataArray[$i]['slip_no'] = $data['slip_no'];
            $dataArray[$i]['d_attempt'] = $data['d_attempt'];
            $dataArray[$i]['call_attempt'] = $data['call_attempt'];
            $dataArray[$i]['origin'] = $data['origin'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['destination'] = $data['destination'];
            $dataArray[$i]['sender_name'] = $data['sender_name'];
            $dataArray[$i]['sender_address'] = $data['sender_address'];
            $dataArray[$i]['sender_zip'] = $data['sender_zip'];
            $dataArray[$i]['sender_phone'] = $data['sender_phone'];
            $dataArray[$i]['reciever_name'] = $data['reciever_name'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['reciever_zip'] = $data['reciever_zip'];
            $dataArray[$i]['reciever_phone'] = $data['reciever_phone'];
            $dataArray[$i]['mode'] = $data['mode'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['total_cod_amt'] = $data['total_cod_amt'];
            $dataArray[$i]['pay_Invoice_status'] = $data['pay_Invoice_status'];
            $dataArray[$i]['sub_category'] = $data['sub_category'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['onHold_Date'] = $data['onHold_Date'];
            $dataArray[$i]['onHold_Days'] = $data['onHold_Days'];
            $dataArray[$i]['onHold_Reason'] = $data['onHold_Reason'];
            $dataArray[$i]['onHold_Confirm'] = $data['onHold_Confirm'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['shelv_no'] = $data['shelv_no'];
            $dataArray[$i]['uniqueid'] = $data['uniqueid'];
            $dataArray[$i]['schedule_date'] = $data['schedule_date'];
            $dataArray[$i]['time_slot'] = $data['time_slot'];
            $dataArray[$i]['area_street'] = $data['area_street'];
            $dataArray[$i]['area'] = $data['area'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['update_date'] = $data['update_date'];
            $dataArray[$i]['delever_date'] = $data['delever_date'];
            $dataArray[$i]['pieces'] = $data['pieces'];
            $dataArray[$i]['weight'] = $data['weight'];
            $dataArray[$i]['status_describtion'] = $data['status_describtion'];
            $dataArray[$i]['frwd_throw'] = $data['frwd_throw'];
            $dataArray[$i]['frwd_awb_no'] = $data['frwd_awb_no'];
            $dataArray[$i][''] = $data[''];

            $i++;
        }
        array_unshift($dataArray, '');
        $this->load->library("excel");
        $doc = new PHPExcel();

        $doc->getActiveSheet()->fromArray($dataArray);
        $from = "A1"; // or any value
        $to = "BE1"; // or any value
        $doc->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
        $doc->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Date')
                ->setCellValue('B1', 'Picked up Date')
                ->setCellValue('C1', 'Reference#')
                ->setCellValue('D1', 'Shipper Reference#')
                ->setCellValue('E1', ' AWB')
                ->setCellValue('F1', 'Delivery Attempts')
                ->setCellValue('G1', 'Call Attempts')
                ->setCellValue('H1', 'Origin')
                ->setCellValue('I1', 'HUB')
                ->setCellValue('J1', 'Destination')
                ->setCellValue('K1', 'Sender')
                ->setCellValue('L1', 'Sender Address')
                ->setCellValue('M1', 'Sender Zip')
                ->setCellValue('N1', 'Sender Phone')
                ->setCellValue('O1', 'Reciever')
                ->setCellValue('P1', 'Forward Through')
                ->setCellValue('Q1', 'Airway Bill No.')
                ->setCellValue('R1', 'Reciever Address')
                ->setCellValue('S1', 'Reciever Zip')
                ->setCellValue('T1', 'Reciever Phone')
                ->setCellValue('U1', 'Mode')
                ->setCellValue('V1', 'Status')
                ->setCellValue('W1', 'COD Amount')
                ->setCellValue('X1', 'Pay Status')
                ->setCellValue('Y1', 'Sub Category 1')
                ->setCellValue('Z1', 'driver comment 1')
                ->setCellValue('AA1', 'Sub Category 2')
                ->setCellValue('AB1', 'Driver Comment 2')
                ->setCellValue('AC1', 'Sub Category 3')
                ->setCellValue('AD1', 'Driver Comment 3')
                ->setCellValue('AE1', 'Shelv location')
                ->setCellValue('AF1', 'Schedule')
                ->setCellValue('AG1', 'Schedule Channel')
                ->setCellValue('AH1', 'On Hold Date')
                ->setCellValue('AI1', 'On Hold')
                ->setCellValue('AJ1', 'On Hold Reason')
                ->setCellValue('AJ1', 'On Hold Confirm')
                ->setCellValue('AL1', 'Driver Name')
                ->setCellValue('AM1', 'Driver Code')
                ->setCellValue('AN1', 'Driver Mobile')
                ->setCellValue('AO1', 'Driver Supplier')
                ->setCellValue('AP1', 'Warehouse')
                ->setCellValue('AQ1', 'Shelve')
                ->setCellValue('AR1', 'UID Account')
                ->setCellValue('AS1', 'Schedule Date')
                ->setCellValue('AT1', 'Time Slot')
                ->setCellValue('AU1', 'Area Street')
                ->setCellValue('AV1', 'Area')
                ->setCellValue('AW1', 'latitude , longitude')
                ->setCellValue('AX1', 'Update Date')
                ->setCellValue('AY1', 'Deliver Date')
                ->setCellValue('AZ1', 'Pieces')
                ->setCellValue('BA1', 'Weight')
                ->setCellValue('BB1', 'Description')
                ->setCellValue('BC1', 'Forward Through')
                ->setCellValue('BD1', 'Forward Awb')
                ->setCellValue('BE1', 'Forward Date');

        $objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');
        ob_start();
        $objWriter->save("php://output");
        //$objWriter->save('packexcel/'.$file_name);    
        $xlsData = ob_get_contents();
        ob_end_clean();

        return $response = array(
            'op' => 'ok',
            'file_name' => $file_name,
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );
    }

    public function GetArchshipmentExportData() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        /*  $dataAray=$this->ShipmentManagement_model->alllistData($_POST);
          $tolalShip=$dataAray['count'];
          $shiplimit=$_POST['shiplimit']; */
        $downlaoadData = $_POST['limit'];
        $conditions = $_POST['cond'];
        $j = 0;
        for ($i = 0; $i < $tolalShip;) {
            $i = $i + $downlaoadData;
            if ($i > 0)
                $expoertdropArr[] = array('j' => $j, 'i' => $i);
            $j = $i;
        }
        $end1 = $shiplimit;
        if ($end1 <= $downlaoadData)
            $start1 = 0;
        else
            $start1 = $end1 - $downlaoadData;

        $resultArr = $this->ShipmentManagement_model->alllArchistData_export($start1, $downlaoadData, $conditions);
        foreach ($resultArr as $key => $val) {
            $resultArr[$key]['origin'] = Get_name_country_by_id('city', $val['origin']);
            $resultArr[$key]['destination'] = Get_name_country_by_id('city', $val['destination']);
        }
        $file_name = 'archieve shipment ' . date('Ymdhis') . '.xls';

        echo json_encode($this->exportitemshipmentArchexport($resultArr, $file_name));
        //echo json_encode($resultArr);
    }

    function exportitemshipmentArchexport($dataEx, $file_name) {
        $dataArray = array();
        $i = 0;
        foreach ($dataEx as $data) {
            $dataArray[$i]['entrydate'] = $data['entrydate'];
            $dataArray[$i]['pickup_date'] = $data['pickup_date'];
            $dataArray[$i]['booking_id'] = $data['booking_id'];
            $dataArray[$i]['shippers_ref_no'] = $data['shippers_ref_no'];
            $dataArray[$i]['slip_no'] = $data['slip_no'];
            $dataArray[$i]['d_attempt'] = $data['d_attempt'];
            $dataArray[$i]['call_attempt'] = $data['call_attempt'];
            $dataArray[$i]['origin'] = $data['origin'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['destination'] = $data['destination'];
            $dataArray[$i]['sender_name'] = $data['sender_name'];
            $dataArray[$i]['sender_address'] = $data['sender_address'];
            $dataArray[$i]['sender_zip'] = $data['sender_zip'];
            $dataArray[$i]['sender_phone'] = $data['sender_phone'];
            $dataArray[$i]['reciever_name'] = $data['reciever_name'];
            //$dataArray[$i]['']=$data[''];
            //$dataArray[$i]['']=$data[''];
            $dataArray[$i]['reciever_zip'] = $data['reciever_zip'];
            $dataArray[$i]['reciever_phone'] = $data['reciever_phone'];
            $dataArray[$i]['mode'] = $data['mode'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['total_cod_amt'] = $data['total_cod_amt'];
            $dataArray[$i]['pay_Invoice_status'] = $data['pay_Invoice_status'];
            $dataArray[$i]['sub_category'] = $data['sub_category'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['onHold_Date'] = $data['onHold_Date'];
            $dataArray[$i]['onHold_Days'] = $data['onHold_Days'];
            $dataArray[$i]['onHold_Reason'] = $data['onHold_Reason'];
            $dataArray[$i]['onHold_Confirm'] = $data['onHold_Confirm'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['shelv_no'] = $data['shelv_no'];
            $dataArray[$i]['uniqueid'] = $data['uniqueid'];
            $dataArray[$i]['schedule_date'] = $data['schedule_date'];
            $dataArray[$i]['time_slot'] = $data['time_slot'];
            $dataArray[$i]['area_street'] = $data['area_street'];
            $dataArray[$i]['area'] = $data['area'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['update_date'] = $data['update_date'];
            $dataArray[$i]['delever_date'] = $data['delever_date'];
            $dataArray[$i]['pieces'] = $data['pieces'];
            $dataArray[$i]['weight'] = $data['weight'];
            $dataArray[$i]['status_describtion'] = $data['status_describtion'];
            //$dataArray[$i]['frwd_throw']=$data['frwd_throw'];
            //$dataArray[$i]['frwd_awb_no']=$data['frwd_awb_no'];  
            //$dataArray[$i]['']=$data[''];

            $i++;
        }
        array_unshift($dataArray, '');
        $this->load->library("excel");
        $doc = new PHPExcel();

        $doc->getActiveSheet()->fromArray($dataArray);
        $from = "A1"; // or any value
        $to = "AZ1"; // or any value
        $doc->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
        $doc->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Date')
                ->setCellValue('B1', 'Picked up Date')
                ->setCellValue('C1', 'Reference#')
                ->setCellValue('D1', 'Shipper Reference#')
                ->setCellValue('E1', ' AWB')
                ->setCellValue('F1', 'Delivery Attempts')
                ->setCellValue('G1', 'Call Attempts')
                ->setCellValue('H1', 'Origin')
                ->setCellValue('I1', 'HUB')
                ->setCellValue('J1', 'Destination')
                ->setCellValue('K1', 'Sender')
                ->setCellValue('L1', 'Sender Address')
                ->setCellValue('M1', 'Sender Zip')
                ->setCellValue('N1', 'Sender Phone')
                ->setCellValue('O1', 'Reciever')
                ->setCellValue('P1', 'Reciever Address')
                ->setCellValue('Q1', 'Reciever Zip')
                ->setCellValue('R1', 'Reciever Phone')
                ->setCellValue('S1', 'Mode')
                ->setCellValue('T1', 'Status')
                ->setCellValue('U1', 'COD Amount')
                ->setCellValue('V1', 'Pay Status')
                ->setCellValue('W1', 'Sub Category 1')
                ->setCellValue('X1', 'driver comment 1')
                ->setCellValue('Y1', 'Sub Category 2')
                ->setCellValue('Z1', 'Driver Comment 2')
                ->setCellValue('AA1', 'Sub Category 3')
                ->setCellValue('AB1', 'Driver Comment 3')
                ->setCellValue('AC1', 'Shelv location')
                ->setCellValue('AD1', 'Schedule')
                ->setCellValue('AE1', 'Schedule Channel')
                ->setCellValue('AF1', 'On Hold Date')
                ->setCellValue('AG1', 'On Hold')
                ->setCellValue('AH1', 'On Hold Reason')
                ->setCellValue('AI1', 'On Hold Confirm')
                ->setCellValue('AJ1', 'Driver Name')
                ->setCellValue('AK1', 'Driver Code')
                ->setCellValue('AL1', 'Driver Mobile')
                ->setCellValue('AM1', 'Driver Supplier')
                ->setCellValue('AN1', 'Warehouse')
                ->setCellValue('AO1', 'Shelve')
                ->setCellValue('AP1', 'UID Account')
                ->setCellValue('AQ1', 'Schedule Date')
                ->setCellValue('AR1', 'Time Slot')
                ->setCellValue('AS1', 'Area Street')
                ->setCellValue('AT1', 'Area')
                ->setCellValue('AU1', 'latitude , longitude')
                ->setCellValue('AV1', 'Update Date')
                ->setCellValue('AW1', 'Deliver Date')
                ->setCellValue('AX1', 'Pieces')
                ->setCellValue('AY1', 'Weight')
                ->setCellValue('AZ1', 'Description');
        //->setCellValue('BC1', 'Forward Through')
        //->setCellValue('BD1', 'Forward Awb')
        //->setCellValue('BE1', 'Forward Date');
        $objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');
        ob_start();
        $objWriter->save("php://output");
        //$objWriter->save('packexcel/'.$file_name);    
        $xlsData = ob_get_contents();
        ob_end_clean();

        return $response = array(
            'op' => 'ok',
            'file_name' => $file_name,
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );
    }

    public function GetDelshipmentExportData() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        /*  $dataAray=$this->ShipmentManagement_model->alllistData($_POST);
          $tolalShip=$dataAray['count'];
          $shiplimit=$_POST['shiplimit']; */
        $downlaoadData1 = $_POST['limit'];
        $conditions = $_POST['cond'];
        $j = 0;
        for ($i = 0; $i < $tolalShip;) {
            $i = $i + $downlaoadData1;
            if ($i > 0)
                $expoertdropArr[] = array('j' => $j, 'i' => $i);
            $j = $i;
        }
        $end1 = $shiplimit;
        if ($end1 <= $downlaoadData1)
            $start1 = 0;
        else
            $start1 = $end1 - $downlaoadData1;

        $resultArr = $this->ShipmentManagement_model->alllDelistData_export($start1, $downlaoadData1, $conditions);

        foreach ($resultArr as $key => $val) {
            $resultArr[$key]['origin'] = Get_name_country_by_id('city', $val['origin']);
            $resultArr[$key]['destination'] = Get_name_country_by_id('city', $val['destination']);
        }

        $file_name = 'deleted shipment ' . date('Ymdhis') . '.xls';

        echo json_encode($this->exportitemshipmentDelexport($resultArr, $file_name));
        //echo json_encode($resultArr);
    }

    function exportitemshipmentDelexport($dataEx, $file_name) {
        $dataArray = array();
        $i = 0;
        foreach ($dataEx as $data) {
            $dataArray[$i]['entrydate'] = $data['entrydate'];
            $dataArray[$i]['pickup_date'] = $data['pickup_date'];
            $dataArray[$i]['booking_id'] = $data['booking_id'];
            $dataArray[$i]['shippers_ref_no'] = $data['shippers_ref_no'];
            $dataArray[$i]['slip_no'] = $data['slip_no'];
            $dataArray[$i]['d_attempt'] = $data['d_attempt'];
            $dataArray[$i]['call_attempt'] = $data['call_attempt'];
            $dataArray[$i]['origin'] = $data['origin'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['destination'] = $data['destination'];
            $dataArray[$i]['sender_name'] = $data['sender_name'];
            $dataArray[$i]['sender_address'] = $data['sender_address'];
            $dataArray[$i]['sender_zip'] = $data['sender_zip'];
            $dataArray[$i]['sender_phone'] = $data['sender_phone'];
            $dataArray[$i]['reciever_name'] = $data['reciever_name'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['reciever_zip'] = $data['reciever_zip'];
            $dataArray[$i]['reciever_phone'] = $data['reciever_phone'];
            $dataArray[$i]['mode'] = $data['mode'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['total_cod_amt'] = $data['total_cod_amt'];
            $dataArray[$i]['pay_Invoice_status'] = $data['pay_Invoice_status'];
            $dataArray[$i]['sub_category'] = $data['sub_category'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['onHold_Date'] = $data['onHold_Date'];
            $dataArray[$i]['onHold_Days'] = $data['onHold_Days'];
            $dataArray[$i]['onHold_Reason'] = $data['onHold_Reason'];
            $dataArray[$i]['onHold_Confirm'] = $data['onHold_Confirm'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['shelv_no'] = $data['shelv_no'];
            $dataArray[$i]['uniqueid'] = $data['uniqueid'];
            $dataArray[$i]['schedule_date'] = $data['schedule_date'];
            $dataArray[$i]['time_slot'] = $data['time_slot'];
            $dataArray[$i]['area_street'] = $data['area_street'];
            $dataArray[$i]['area'] = $data['area'];
            $dataArray[$i][''] = $data[''];
            $dataArray[$i]['update_date'] = $data['update_date'];
            $dataArray[$i]['delever_date'] = $data['delever_date'];
            $dataArray[$i]['pieces'] = $data['pieces'];
            $dataArray[$i]['weight'] = $data['weight'];
            $dataArray[$i]['status_describtion'] = $data['status_describtion'];
            $dataArray[$i]['frwd_throw'] = $data['frwd_throw'];
            $dataArray[$i]['frwd_awb_no'] = $data['frwd_awb_no'];
            $dataArray[$i][''] = $data[''];

            $i++;
        }
        array_unshift($dataArray, '');
        $this->load->library("excel");
        $doc = new PHPExcel();

        $doc->getActiveSheet()->fromArray($dataArray);
        $from = "A1"; // or any value
        $to = "BE1"; // or any value
        $doc->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold(true);
        $doc->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Date')
                ->setCellValue('B1', 'Picked up Date')
                ->setCellValue('C1', 'Reference#')
                ->setCellValue('D1', 'Shipper Reference#')
                ->setCellValue('E1', ' AWB')
                ->setCellValue('F1', 'Delivery Attempts')
                ->setCellValue('G1', 'Call Attempts')
                ->setCellValue('H1', 'Origin')
                ->setCellValue('I1', 'HUB')
                ->setCellValue('J1', 'Destination')
                ->setCellValue('K1', 'Sender')
                ->setCellValue('L1', 'Sender Address')
                ->setCellValue('M1', 'Sender Zip')
                ->setCellValue('N1', 'Sender Phone')
                ->setCellValue('O1', 'Reciever')
                ->setCellValue('P1', 'Forward Through')
                ->setCellValue('Q1', 'Airway Bill No.')
                ->setCellValue('R1', 'Reciever Address')
                ->setCellValue('S1', 'Reciever Zip')
                ->setCellValue('T1', 'Reciever Phone')
                ->setCellValue('U1', 'Mode')
                ->setCellValue('V1', 'Status')
                ->setCellValue('W1', 'COD Amount')
                ->setCellValue('X1', 'Pay Status')
                ->setCellValue('Y1', 'Sub Category 1')
                ->setCellValue('Z1', 'driver comment 1')
                ->setCellValue('AA1', 'Sub Category 2')
                ->setCellValue('AB1', 'Driver Comment 2')
                ->setCellValue('AC1', 'Sub Category 3')
                ->setCellValue('AD1', 'Driver Comment 3')
                ->setCellValue('AE1', 'Shelv location')
                ->setCellValue('AF1', 'Schedule')
                ->setCellValue('AG1', 'Schedule Channel')
                ->setCellValue('AH1', 'On Hold Date')
                ->setCellValue('AI1', 'On Hold')
                ->setCellValue('AJ1', 'On Hold Reason')
                ->setCellValue('AJ1', 'On Hold Confirm')
                ->setCellValue('AL1', 'Driver Name')
                ->setCellValue('AM1', 'Driver Code')
                ->setCellValue('AN1', 'Driver Mobile')
                ->setCellValue('AO1', 'Driver Supplier')
                ->setCellValue('AP1', 'Warehouse')
                ->setCellValue('AQ1', 'Shelve')
                ->setCellValue('AR1', 'UID Account')
                ->setCellValue('AS1', 'Schedule Date')
                ->setCellValue('AT1', 'Time Slot')
                ->setCellValue('AU1', 'Area Street')
                ->setCellValue('AV1', 'Area')
                ->setCellValue('AW1', 'latitude , longitude')
                ->setCellValue('AX1', 'Update Date')
                ->setCellValue('AY1', 'Deliver Date')
                ->setCellValue('AZ1', 'Pieces')
                ->setCellValue('BA1', 'Weight')
                ->setCellValue('BB1', 'Description')
                ->setCellValue('BC1', 'Forward Through')
                ->setCellValue('BD1', 'Forward Awb')
                ->setCellValue('BE1', 'Forward Date');
        $objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');
        ob_start();
        $objWriter->save("php://output");
        //$objWriter->save('packexcel/'.$file_name);    
        $xlsData = ob_get_contents();
        ob_end_clean();

        return $response = array(
            'op' => 'ok',
            'file_name' => $file_name,
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );
    }

    public function bulkPrintAbw() {

        $CheckshidIds = $this->input->post('CheckshidIds');
        $bulklable_print = $this->input->post('bulklable_print');
        if (!empty($CheckshidIds))
            $this->GetlabelPrint4_6($CheckshidIds);
        else
            redirect(base_url() . 'dashboard', 'refresh');
    }

    public function getTrackDetails() {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $awbNos = $_POST['shid'];

        $SlipNos = preg_replace('/\s+/', ',', $awbNos);
        $slipData = explode(",", $SlipNos);
        $SlipNosArr = array_unique($slipData);
        $shipment = $this->ShipmentManagement_model->showTrackDetails($SlipNosArr);
        foreach ($shipment as $key => $val) {
            $shipment[$key]['origin'] = Get_name_country_by_id('city', $val['origin']);
            $shipment[$key]['destination'] = Get_name_country_by_id('state', $val['reciever_city']);
            $shipment[$key]['showstatus'] = status_main_cat($val['delivered']);



            // $newstatusArray[$key]['new_location']=Get_name_country_by_id('city',$val2['new_location']);
            // $newstatusArray[$key]['citycode']=Get_name_country_by_id('city_code',$val2['new_location']);
            // $newstatusArray[$key]['username']=Get_user_name($val2['user_id'],$val2['type']);
        }
        echo json_encode($shipment);
    }

    public function BulkPrintAwbNo() {

        $CheckshidIds = $this->input->post('CheckshidIds');
        $awbNos = $this->input->post('awbNos');
        if (!empty($awbNos)) {
            $SlipNos = preg_replace('/\s+/', ',', $awbNos);
            $slipData = explode(",", $SlipNos);
            $SlipNosArr = array_unique($slipData);
            $req = $this->GetlabelPrint4_6($SlipNosArr, 'bulkpage');
            if ($req == 'bulkpage')
                redirect(base_url() . 'bulk_print');
        } else
            redirect('bulk_print');
    }

    public function GetArchievelabelPrint4_6($pickUpId = null, $page = null) {


        $this->load->helper('pdf_helper');
        $this->load->library('pagination');

        $data['pickupId'] = $pickUpId;
        $shipment = $this->ShipmentManagement_model->PrintArcrchieveawbFilterShip($pickUpId);
        //  print_r($shipment); die;
        // print_r($shipment); exit;
        $shipment = json_decode(json_encode($shipment));
        for ($i = 0; $i < count($shipment); $i++) {
            $sku_per_shipment[$i] = $this->ShipmentManagement_model->find_by_slip_no_for_sku($shipment[$i]->slip_no);
        }

        tcpdf();
        $custom_layout = array('101.6', '152.4');
        $obj_pdf = new TCPDF('P', PDF_UNIT, $custom_layout, true, 'UTF-8', false);
        ob_start();

        if (!empty($shipment)) {
            for ($i = 0; $i < count($shipment); $i++) {


                $obj_pdf->SetCreator(PDF_CREATOR);
                //$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                //$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                $obj_pdf->SetDefaultMonospacedFont('helvetica');
                //$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                //$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                $obj_pdf->setPrintHeader(false);
                $obj_pdf->setPrintFooter(false);
                $obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                $obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                $obj_pdf->SetFont('helvetica', '', 9);

                $obj_pdf->setFontSubsetting(false);

                $obj_pdf->AddPage();
                $obj_pdf->Rect('1', '1', '100', '130');
                $obj_pdf->Rect('1.5', '1.5', '99', '43');
                ///////Column 1///////////////////////
                $obj_pdf->Rect('1.5', '1.5', '33', '20');
                $obj_pdf->Rect('1.5', '21.5', '49.5', '23');
                ////////Column 2////////////////////
                $obj_pdf->Rect('34.5', '1.5', '33', '20');


                ////////Column 3////////////////////
                $obj_pdf->Rect('67.5', '1.5', '33', '20');
                $obj_pdf->Rect('51', '21.5', '49.5', '23');

                /////////AWB Bar Code//////////
                $obj_pdf->Rect('1.5', '52.5', '99', '20');
                ///////////AWB No//////////////////////
                $obj_pdf->Rect('1.5', '72.5', '99', '6');
                /////////Acount No AND DATE//////////////////////
                $obj_pdf->Rect('1.5', '78.5', '49.5', '8');
                $obj_pdf->Rect('51', '78.5', '49.5', '8');
                /////////Weight AND Pieces/////////////////////
                $obj_pdf->Rect('1.5', '86.5', '49.5', '8');
                $obj_pdf->Rect('51', '86.5', '49.5', '8');

                //////////REFRENCE BAR CODE///////////////
                $obj_pdf->Rect('1.5', '94.5', '99', '14');
                //////////Reference Number//////////////
                $obj_pdf->Rect('1.5', '108.5', '99', '8');
                ///////////////Code Value/////////////////
                $obj_pdf->Rect('1.5', '44.5', '99', '8');
                // /////////Description ////////////////
                // $obj_pdf->Rect('1.5','134.5','99','6');
                // ob_start();	
                ///**********Working For Image*******///


                $image_file = file_get_contents(site_configTable('logo'));
                $obj_pdf->Image('@' . $image_file, 3, 2, 30, 18);



                // $content = ob_get_contents();
                // ob_end_clean();

                $style['position'] = 'C';
/////////////////////////here QR Code No 2d ////////////////
                $obj_pdf->write2DBarcode($shipment[$i]->slip_no, 'QRCODE,H', 70.5, 4, 33, 20, $style, 'N');
//////////////////////here Pass AWB NO too////////////////////////////////////////
                $obj_pdf->write1DBarcode($shipment[$i]->slip_no, 'C128', 3.5, 54.5, 62, 16, 0.7, $style, 'N');
///////////////////////here Pass Reference No ////////////////////////////////
                $obj_pdf->write1DBarcode($shipment[$i]->booking_id, 'C128', 3.5, 95.5, 62, 12, 0.7, $style, 'N');
//$obj_pdf->SetFont('aealarabiya','',9);
//////////////////////here////////////////////////////////////////
                $obj_pdf->SetTitle($shipment[$i]->slip_no);

                $obj_pdf->Text(2, 22, 'From: ');
                $obj_pdf->Text(2, 28, 'Mobile: ');
                $obj_pdf->Text(2, 31, 'Address: ');
                $obj_pdf->Text(2, 80, 'Account No: ');
                $obj_pdf->Text(2, 89, 'Weight: ');

                $obj_pdf->Text(52, 80, 'Booking Date: ');
                $obj_pdf->Text(37, 47, 'COD: ');
                $obj_pdf->Text(52, 89, 'Pieces: ');
                $obj_pdf->Text(52, 22, 'To: ');
                $obj_pdf->Text(52, 28, 'Mobile: ');
                $obj_pdf->Text(52, 31, 'Address: ');
                $obj_pdf->Text(2, 120, 'Description: ');
                $number++;
                $obj_pdf->Text(37, 73.5, $shipment[$i]->slip_no);
                //$obj_pdf->Text(64,73.5,$number.'/'.$shipment[$i]->pieces);

                $obj_pdf->Text(37, 110.5, $shipment[$i]->booking_id);






//////////////////////here////////////////////////////////////////
                $obj_pdf->SetFont('helvetica', '', 7);

                $obj_pdf->SetFont('aealarabiya', 'B', 20);
                $obj_pdf->Text(75, 10, $data['city_code']);
                $obj_pdf->SetFont('aealarabiya', '', 7);
                $obj_pdf->Text(12, 22.6, $shipment[$i]->sender_name);


                $obj_pdf->Text(14, 28.5, $shipment[$i]->sender_phone);
                $obj_pdf->MultiCell(42, 10, $shipment[$i]->sender_address . ', ' . $data['city_code1'], 0, 'L', false, 2, 3, 35, '', true);


                $obj_pdf->Text(15, 89.5, $shipment[$i]->weight . ' (KG)');

                $obj_pdf->Text(46, 47.5, $shipment[$i]->total_cod_amt . ' (SR)');
                $obj_pdf->Text(73, 80.7, $shipment[$i]->entrydate);
                $obj_pdf->Text(20, 80.7, $data['account_no']);
                $obj_pdf->Text(58, 22.6, $shipment[$i]->reciever_name);

                $obj_pdf->Text(64, 28.5, $shipment[$i]->reciever_phone);
                $obj_pdf->MultiCell(42, 10, $shipment[$i]->reciever_address . ', ' . $data['city_code2'], 0, 'L', false, 2, 53, 35, '', true);

                $obj_pdf->Text(65, 89.5, $shipment[$i]->pieces . ' (PCS)');
                $obj_pdf->Text(20, 120.7, $shipment[$i]->status_describtion);
            }
            $content = ob_get_contents();
            ob_end_clean();
            $obj_pdf->writeHTML($content, true, false, true, false, '');
            $obj_pdf->Output(Date('d-M') . '_Shipments-Report.pdf', 'I');
        } else {
            if ($page == 'bulkpage')
                return 'bulkpage';
        }


        $content = ob_get_contents();
        ob_end_clean();
        $obj_pdf->writeHTML($content, true, false, true, false, '');
        $obj_pdf->Output(Date('d-M') . '_Shipments-Report.pdf', 'I');
    }

}
