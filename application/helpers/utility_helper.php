<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('asset_url()')) {

    function asset_url() {
        return base_url() . 'assets/';
    }

}
if (!function_exists('getStatusCode')) {

    function getStatusCode($status_id) {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "select code from status_main_cat where id='" . $status_id . "' and deleted='N'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result['code'];
    }

}

function getCityCode($city_id = null) {

    $ci = & get_instance();
    $ci->load->database();
    $sql = "select city_code from country where (id='" . $city_id . "' or city='" . $city_id . "') and deleted='N'";
    $query = $ci->db->query($sql);
    $statusData = $query->row_array();
    return $status = $statusData['city_code'];
}

if (!function_exists('total_collection')) {

    function total_collection($shipment) {
        $ci = & get_instance();
        $ci->load->database();
        $cust_id = $shipment['cust_id'];
        if ($shipment['mode'] == 'CASH') {
            return '-' . $shipment[0]['service_charge'];
        }
        if ($shipment['delivered'] == '6') {
            if (($shipment['origin'] == '29663') && ($shipment['destination'] == '29663')) {
                $price_query = "select return_fees from zone_riyadh_price_set where cust_id='" . $cust_id . "' limit 1";
                $query = $ci->db->query($price_query);
                $price = $query->result_array();

                if ($price) {
                    return '-' . $price[0]['return_fees'];
                } else {
                    $price_query = "select return_fees from zone_riyadh_price_set where cust_id='0' limit 1";
                    $query = $ci->db->query($price_query);
                    $price = $query->result_array();

                    return '-' . $price[0]['return_fees'];
                }
            } else {

                $from_zone_id = "select zone_id from country where id='" . $shipment['origin'] . "' limit 1";
                $query = $ci->db->query($from_zone_id);
                $from_zone_id = $query->result_array();


                $to_zone_id = "select zone_id from country where id='" . $shipment['destination'] . "' limit 1";
                $query = $ci->db->query($to_zone_id);
                $to_zone_id = $query->result_array();



                $price_query = "select return_fees from zone_price_set where cust_id='" . $cust_id . "' and zone_id_form ='" . $from_zone_id[0]['zone_id'] . "' and  zone_id_to ='" . $to_zone_id[0]['zone_id'] . "' limit 1";
                $query = $ci->db->query($price_query);
                $price = $query->result_array();


                if ($price) {
                    return '-' . $price[0]['return_fees'];
                } else {
                    $price_query = "select return_fees from zone_price_set where cust_id='0' and zone_id_form ='" . $from_zone_id[0]['zone_id'] . "' and  zone_id_to ='" . $to_zone_id[0]['zone_id'] . "' limit 1";
                    $query = $ci->db->query($price_query);
                    $price = $query->result_array();

                    return '-' . $price[0]['return_fees'];
                }
            }
        } else {
            return ($shipment['total_amt'] - $shipment['service_charge'] - $shipment['cod_fees']);
        }
    }

}

function getAwb_betweendateStatus($date1, $date2, $status) {
    $ci = & get_instance();
    $ci->load->database();
    if ($date1 != $date2)
        $status = "select slip_no from status where  new_status='" . $status . "' and DATE(entry_date) BETWEEN '" . $date1 . "' AND  '" . $date2 . "' order by id desc ";
    elseif ($date1)
        $status = "select slip_no from status where  new_status='" . $status . "' and DATE(entry_date) = '" . $date1 . "' order by id desc ";
    else
        $status = "select slip_no from status where  new_status='" . $status . "'  order by id desc ";


    $query = $ci->db->query($status);
    $fetchstatus = $query->result_array();

    $data = array();
    foreach ($fetchstatus as $key => $val) {
        array_push($data, $fetchstatus[$key]['slip_no']);
    }
    return $data;
}

if (!function_exists('getAwb_betweendateStatus_multy')) {

    function getAwb_betweendateStatus_multy($date1 = null, $date2 = null, $status = null) {

        $ci = & get_instance();
        $ci->load->database();
        if ($date1 != $date2)
            $status = "select slip_no from status where  new_status in (" . $status . ") and DATE(entry_date) BETWEEN '" . $date1 . "' AND  '" . $date2 . "' order by id desc ";
        elseif ($date1)
            $status = "select slip_no from status where new_status in (" . $status . ") and DATE(entry_date) = '" . $date1 . "' order by id desc ";
        else
            $status = "select slip_no from status where new_status in (" . $status . ") order by id desc ";
        $query = $ci->db->query($status);
        $fetchstatus = $query->result_array();

        $data = array();
        foreach ($fetchstatus as $key => $val) {
            array_push($data, "'" . $fetchstatus[$key]['slip_no'] . "'");
        }
        return implode(',', $data);
    }

}
if (!function_exists('getHubCity_multy')) {

    function getHubCity_multy($hub) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "select * from country where deleted='N'";
        $query = $ci->db->query($sql);
        $citydata = $query->result_array();
        $hub = explode(',', $hub);
        $cityArray = array();
        foreach ($hub as $hublist) {
            $i = 0;
            for ($i = 0; $i < sizeof($citydata); $i++) {
                if ($citydata[$i]['state'] == $hublist) {
                    array_push($cityArray, $citydata[$i]['id']);
                }
            }
        }


        return implode(',', $cityArray);
    }

}

function remove_decimal($weight_details) {
    $x = str_replace('.', '_', $weight_details);
    return $x;
}

if (!function_exists('get_comment')) {

    function get_comment($slip_no = null, $main_status = null) {

        $ci = & get_instance();
        $ci->load->database();
        if (!empty($main_status))
            $statusCond = " and new_status='" . $main_status . "' ";
        if ($main_status == 1)
            $statusCond .= " and Details not LIKE '%feedback%' ";

        $siteQry = "select  Details from status where  slip_no='" . $slip_no . "' " . $statusCond . " order by id DESC limit 3";
        $query = $ci->db->query($siteQry);
        //echo $ci->db->last_query();exit;
        $statusData = $query->row_array();
        return $statusData['Details'];
    }

}



if (!function_exists('get_detail')) {

    function get_detail($slip_no = null, $main_status = null) {

        $ci = & get_instance();
        $ci->load->database();
        if (!empty($main_status))
            $statusCond = " and new_status='" . $main_status . "' ";
        if ($main_status == 1)
            $statusCond .= " and Details not LIKE '%feedback%' ";

        $siteQry = "select  Details,entry_date,comment,user_id,user_type from status where  slip_no='" . $slip_no . "' " . $statusCond . " order by id DESC limit 3";
        $query = $ci->db->query($siteQry);
        //echo $ci->db->last_query();exit;
        $statusData = $query->row_array();
        return $statusData;
    }

}

if (!function_exists('GetallrtoshipmenttotalClass')) {

    function GetallrtoshipmenttotalClass($drs_unique_id, $type) {
        $ci = & get_instance();
        $ci->load->database();
        if ($type == 'Y') {
            $siteQry = "select count(shipment.id) as POD from drs left join shipment ON drs.shipment_id=shipment.slip_no where drs.drs_unique_id='" . $drs_unique_id . "' and drs.deleted='N' and drs.delivered='Y' and shipment.code='POD' ";
            $query = $ci->db->query($siteQry);
            //echo $ci->db->last_query();exit;
            $countrydata = $query->row_array();
            $name = $countrydata['POD'];
        } else if ($type == 'all') {
            $siteQry = "select count(id) as total_ship from drs where   drs_unique_id='$drs_unique_id'  and deleted='N'";
            $query = $ci->db->query($siteQry);
            $countrydata = $query->row_array();
            $name = $countrydata['total_ship'];
        } else if ($type == 'N') {
            $siteQry = "select count(shipment.id) as NP from drs left join shipment ON drs.shipment_id=shipment.slip_no where drs.drs_unique_id='" . $drs_unique_id . "' and drs.deleted='N' and drs.delivered='Y' and drs.rto_status='Y' and ( shipment.code='RI')";
            $query = $ci->db->query($siteQry);
            $countrydata = $query->row_array();
            $name = $countrydata['NP'];
        } else if ($type == 'NP') {
            $siteQry = "select count(id) as totalall from drs where drs_unique_id='$drs_unique_id' and (delivered='N') and deleted='N'";
            $query = $ci->db->query($siteQry);
            $countrydata = $query->row_array();
            $name = $countrydata['totalall'];
        }
        return $name;
    }

}


if (!function_exists('GetalltotalamountClass')) {

    function GetalltotalamountClass($drs_unique_id = null) {
        $ci = & get_instance();
        $ci->load->database();

        $query = "select SUM(shipment.total_cod_amt) as COD_AMOUNT from drs left join shipment ON drs.shipment_id=shipment.slip_no where drs.drs_unique_id='" . $drs_unique_id . "' and drs.deleted='N' and drs.delivered='Y' and  drs.delivery_status='Y' and shipment.mode='COD' ";

        $query = $ci->db->query($query);
        // echo $ci->db->last_query();exit;  
        $CODdata = $query->row_array();
        $COD_AMOUNT = $CODdata['COD_AMOUNT'];

        if ($COD_AMOUNT > 0)
            $COD_AMOUNT = $COD_AMOUNT;
        else
            $COD_AMOUNT = 0;

        return $COD_AMOUNT;
    }

}
if (!function_exists('procut_categoryUniqueID')) {

    function procut_categoryUniqueID() {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "SELECT unique_id FROM `procut_category` where deleted='N' limit 1";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result['unique_id'];
    }

}


if (!function_exists('getshelv_location')) {

    function getshelv_location($status_id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "select shelv_location from warehous_shelve where id='" . $status_id . "' and deleted='N'";
        $query = $ci->db->query($sql);
        $statusData = $query->row_array();
        return $status = $statusData['shelv_location'];
    }

}
if (!function_exists('getDriverNameByid')) {

    function getDriverNameByid($id) {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "select messenger_name from courier_staff where cor_id='" . $id . "' and deleted='N'";
        $query = $ci->db->query($sql);
        //echo $ci->db->last_query();exit;
        $result = $query->row_array();
        return $result['messenger_name'];
    }

}



if (!function_exists('Get_cust_name')) {

    function Get_cust_name($cust_id) {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "select company from customer where id='" . $cust_id . "'";
        $query = $ci->db->query($sql);
        //echo $ci->db->last_query();exit;
        $result = $query->row_array();
        return $result['company'];
    }

}


if (!function_exists('get_total_attempted')) {

    function get_total_attempted($awb_number = null) {
        $ci = & get_instance();
        $ci->load->database();
        $site_query = "select count(id) as total_attempted from status where slip_no='" . $awb_number . "' and new_status='5'  ";

        $query = $ci->db->query($site_query);
        //echo $ci->db->last_query();exit;
        $result = $query->result_array();
        $total_attempted = $result[0]['total_attempted'];

        return $total_attempted;
    }

}
if (!function_exists('get_supplier_name')) {

    function get_supplier_name($messanger_id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $site_query = "select name,id from supplier where   status='Y' and deleted='N' and id='$messanger_id' ";
        $query = $ci->db->query($site_query);
        $result = $query->row_array();
        $supplierName = $result['name'];
        return $supplierName;
    }

}
if (!function_exists('get_Route_code')) {

    function get_Route_code($shipment_id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $site_query = "select routecode from pickup where shipment_id='" . $shipment_id . "'  and deleted='N' ";
        $query = $ci->db->query($site_query);
        $result = $query->row_array();
        $routecode = $result['routecode'];

        return $routecode;
    }

}
if (!function_exists('getLinehoul')) {

    function getLinehoul($id = null) {
        $ci = & get_instance();
        $ci->load->database();

        $siteQry = "select name from line_hule where deleted='N'and id ='" . $id . "' ";

        $query = $ci->db->query($siteQry);
        $statusData = $query->row_array();
        if (!empty($statusData)) {
            return $statusData['name'];
        } else {
            return $id;
        }
    }

}
if (!function_exists('get_messanger_tablefield')) {

    function get_messanger_tablefield($messanger_id = null, $field = null) {

        $ci = & get_instance();
        $ci->load->database();
        $site_query = "select $field from courier_staff where status='Y' and deleted='N' and cor_id='$messanger_id'";
        $query = $ci->db->query($site_query);

        //echo $ci->db->last_query();exit;

        $result = $query->row_array();
        return $result[$field];
    }

}
if (!function_exists('get_supp_tablefield')) {

    function get_supp_tablefield($messanger_id = null, $field = null) {

        $ci = & get_instance();
        $ci->load->database();
        $site_query = "select $field from customer where status='Y' and deleted='N' and id='$messanger_id'";
        $query = $ci->db->query($site_query);

        //echo $ci->db->last_query();exit;

        $result = $query->row_array();
        return $result[$field];
    }

}

if (!function_exists('outOfDeliveryMessage')) {

    function outOfDeliveryMessage($awb = null, $driver_name = null, $driver_mobile = null) {
        $message = " شحنتك رقم " . $awb . " مع مندوب التوصيل " . $driver_name . "  " . $driver_mobile . " جاهزة للتسليم ";
        return $message;
    }

}
if (!function_exists('driver_detail')) {

    function driver_detail($slip_no = null) {
        $ci = & get_instance();
        $ci->load->database();
        if (!empty($slip_no))
            $statusCond = " and new_status='" . $main_status . "'";
        $status = "select Details,comment,Activites from status where  slip_no='" . $slip_no . "' order by id desc limit 1";
        $query = $ci->db->query($status);
        $result = $query->row_array();
        return $result;
    }

}
if (!function_exists('site_configTable')) {

    function site_configTable($field = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "select $field from site_config where id='1'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result[$field];
    }

}

if (!function_exists('getStatus')) {

    function getStatus($status_id) {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "select main_status from status_main_cat where id='" . $status_id . "' and deleted='N'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result['main_status'];
    }

}
if (!function_exists('Email_Info')) {

    function Email_Info($id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $selQry = "select * from mails where id='" . $id . "'";
        $query = $ci->db->query($selQry);
        $maildata = $query->result_array();
        return $maildata;
    }

}
if (!function_exists('Send_mail')) {

    function Send_mail($from = null, $sitetitle = null, $to = null, $subject = null, $message = null) {

        $ci = & get_instance();
        $ci->load->database();
        $selQry = "select * from smtp_configuration where id=1";
        $query = $ci->db->query($selQry);
        $smtp_data = $query->result_array();
        $Port = $smtp_data[0]['smtp_port']; //  Sets the default SMTP server port.
        $SMTPSecure = $smtp_data[0]['smtp_secure']; //  Options are "", "ssl" or "tls"
        $Host = $smtp_data[0]['smtp_host']; // SMTP server
        $Username = $smtp_data[0]['smtp_user_name'];  // Sets SMTP username.
        $Password = $smtp_data[0]['smtp_password'];  //Sets SMTP password.
        if ($smtp_data[0]['smtp_onoff'] == 'Y') {
            $config = array(
                'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
                'smtp_host' => $Host,
                'smtp_port' => $Port, // 465 or 587
                'smtp_user' => $Username,
                'smtp_pass' => $Password,
                'smtp_crypto' => $SMTPSecure, //can be 'ssl' or 'tls' for example
                'mailtype' => 'html', //plaintext 'text' mails or 'html'
                //'smtp_timeout' => '10', //in seconds
                'charset' => 'iso-8859-1',
                    // 'crlf' => "\r\n",
                    //'newline' => "\r\n"
            );
        } else {
            $config = array(
                'protocol' => 'sendmail', // 'mail', 'sendmail', or 'smtp'
                'smtp_host' => 'smtp.gmail.com',
                'smtp_port' => 465, // 465 or 587
                //'smtp_user' => 'support@digitalpack.sa',
                //'smtp_pass' => 'Am@2019@@',
                'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
                'mailtype' => 'html', //plaintext 'text' mails or 'html'
                //'smtp_timeout' => '10', //in seconds
                'charset' => 'iso-8859-1',
                    // 'crlf' => "\r\n",
                    //'newline' => "\r\n"
            );
        }

        $from = $form;
        $to = $to;
        $subject = $subject;
        $message = $message;
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($from, $sitetitle);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send())
            return true;
        else
            show_error($this->email->print_debugger());
    }

}

if (!function_exists('status_main_cat')) {

    function status_main_cat($status_id = null) {

        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT * FROM status_main_cat";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        $citydata = $result;

        $mainStatusArray = array();
        $mainStatusArray_css = array();
        $i = 0;
        for ($i = 0; $i < sizeof($citydata); $i++) {
            $mainStatusArray[$citydata[$i]['id']] = $citydata[$i]['main_status'];
            $mainStatusArray_css[$citydata[$i]['id']] = $citydata[$i]['css'];
        }
        if (empty($mainStatusArray[$status_id]))
            $STATUS_SUB_DATA = $result; {
            $j = 0;
            for ($j = 0; $j < sizeof($STATUS_SUB_DATA); $j++) {
                $mainStatusArray[$STATUS_SUB_DATA[$j]['id']] = $STATUS_SUB_DATA[$j]['sub_status'];
                $mainStatusArray_css[$STATUS_SUB_DATA[$j]['id']] = $STATUS_SUB_DATA[$j]['css'];
            }
        }

        //print_r($mainStatusArray);
        //return  $mainStatusArray[$status_id]; 
        return '<i class="' . $mainStatusArray_css[$status_id] . '" aria-hidden="true"></i> ' . $mainStatusArray[$status_id];
    }

}
if (!function_exists('GetcustomerTable')) {

    function GetcustomerTable($cust_id = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();
        $ratesQry = "select $field from customer where id='" . $cust_id . "' ";
        $query = $ci->db->query($ratesQry);
        $custdata = $query->row_array();
        $fieldval = $custdata[$field];
        return $fieldval;
    }

}
if (!function_exists('get_diamention_shipment_datail')) {

    function get_diamention_shipment_datail($slip_no = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT * FROM diamention WHERE slip_no='" . $slip_no . "'";
        $query = $ci->db->query($sql);
        return $diamention = $query->result_array();
    }

}
if (!function_exists('getProcessed_drs')) {

    function getProcessed_drs($unique_id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "select count(shipment.id) as total_shipment from drs left join shipment ON drs.shipment_id=shipment.slip_no where drs.drs_unique_id='" . $unique_id . "' and drs.deleted='N' and drs.delivered='Y'  and drs.rto_status='Y' and drs.delivery_status='N'";
        $query = $ci->db->query($sql);
        $total_shipment_data = $query->result_array();
        $total_shipment_post = $total_shipment_data[0]['total_shipment'];
        return $total_shipment_post;
    }

}
if (!function_exists('getTotal_return')) {

    function getTotal_return($id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "select count(shipment.id) as total_shipment from drs left join shipment ON drs.shipment_id=shipment.slip_no where drs.drs_unique_id='" . $id . "'  and drs.shipment_id!='' and drs.delivered='Y'  and drs.delivery_status='N' and drs.deleted='N'  ";
        $query = $ci->db->query($sql);
        $total_shipment_data = $query->result_array();
        $total_shipment_post = $total_shipment_data[0]['total_shipment'];
        return $total_shipment_post;
    }

}

if (!function_exists('Get_user_name')) {

    function Get_user_name($id = null, $type = null) {


        $ci = & get_instance();
        $ci->load->database();
        if ($type == 'user') {
            $siteQry = "SELECT name FROM user WHERE id='" . $id . "' ";
            $query = $ci->db->query($siteQry);
            $countrydata = $query->result_array();
            $name = $countrydata[0]['name'];
        }
        if ($type == 'customer') {
            $siteQry = "SELECT name FROM customer WHERE id='" . $id . "' ";
            $query = $ci->db->query($siteQry);
            $countrydata = $query->result_array();
            $name = $countrydata[0]['name'];
        }
        if ($type == 'driver') {
            $siteQry = "SELECT messenger_name FROM courier_staff WHERE cor_id='" . $id . "'  ";
            $query = $ci->db->query($siteQry);
            $countrydata = $query->result_array();
            $name = $countrydata[0]['messenger_name'];
        }
        return $name;
    }

}
if (!function_exists('getShelvId')) {

    function getShelvId($shelv_location = null) {

        $ci = & get_instance();
        $ci->load->database();
        $siteQry = "select id from warehous_shelve where shelv_location='" . $shelv_location . "' and deleted='N'";
        $query = $ci->db->query($siteQry);
        $statusData = $query->row_array();
        return $status = $statusData['id'];
    }

}
if (!function_exists('getlocation')) {

    function getlocation($status_id = null) {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "SELECT shelv_location FROM warehous_shelve_no WHERE shelv_no =  '" . $status_id . "' AND deleted =  'N'";
        $query = $ci->db->query($sql);
        $statusData = $query->row_array();
        return $status = $statusData['shelv_location'];
    }

}
if (!function_exists('getSMS_yes_no')) {

    function getSMS_yes_no($id = null) {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "select sms_noti from customer where id='" . $id . "' and deleted='N'";
        $query = $ci->db->query($sql);
        $statusData = $query->row_array();
        return $result['sms_noti'];
    }

}

if (!function_exists('GetcustomerDropdata')) {

    function GetcustomerDropdata() {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "SELECT id,uniqueid,company FROM customer WHERE  status='Y' and deleted='N'";
        $query = $ci->db->query($sql);
        $statusData = $query->result_array();
        return $statusData;
    }

}
if (!function_exists('return_charge')) {

    function return_charge($cust_id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $site_query = "SELECT  distinct(return_fees) as return_fees FROM zone_price_set where cust_id='" . $cust_id . "' and deleted='N' and return_fees>0 ";
        $query = $ci->db->query($site_query);
        $zonedata = $query->result_array();
        $total_attempted = $zonedata[0]['return_fees'];
        return $total_attempted;
    }

}
if (!function_exists('calculatePriceJolly')) {

    function calculatePriceJolly($service_id = null, $productType = null, $weight = null, $origin = null, $destination = null, $customer_id = 0) {

        $ci = & get_instance();
        $ci->load->database();
        $state = Get_name_country_by_id('state', $origin);

        $from_zone = Get_name_country_by_id('zone_id', $state);

        $state2 = Get_name_country_by_id('state', $destination);

        $to_zone = Get_name_country_by_id('zone_id', $state2);



        if (empty($from_zone) || $from_zone == 0)
            $from_zone = 1;
        if (empty($to_zone) || $to_zone == 0)
            $to_zone = 1;

        if ($service_id != 3) {
            $service_id = 3;
        }

        if ($productType == '' || $productType == 0)
            $productType = 'KVAIMI';


        if ($weight < 1 || $weight == '')
            $weight = 1;
        //==================to get additional weight======================
        $getlastWeight = "select start_weight_range from zone_price_set where service_id='" . $service_id . "' and unique_id='" . $productType . "' and zone_id_form='" . $from_zone . "' and zone_id_to='" . $to_zone . "' and  end_weight_range='FLAT' and cust_id='" . $customer_id . "'  and deleted='N'";
        $query = $ci->db->query($getlastWeight);
        $lastWeightData = $query->row_array();
        $lastWeight = $lastWeightData['start_weight_range'];
        if ($weight >= $lastWeight) {
            $additionWeight = $weight - $lastWeight;
            $weight = $lastWeight;
        } else {
            $additionWeight = 0;
        }



        $ratesQry = "select price,cod_fees from zone_price_set where service_id='" . $service_id . "' and cust_id='" . $customer_id . "' and unique_id='" . $productType . "' and zone_id_form='" . $from_zone . "' and zone_id_to='" . $to_zone . "'  and ('" . $weight . "' >= cast(start_weight_range AS SIGNED) && '" . $weight . "' <= cast(end_weight_range AS SIGNED)  &&  end_weight_range!='FLAT'  ) and deleted='N'";

        $query2 = $ci->db->query($ratesQry);
        $ratesdata = $query2->row_array();
        $price = $ratesdata['price'];

        $newData['cod_fees'] = $ratesdata['cod_fees'];
        ;
        $newData['price'] = $price;
        return $newData;
        //print_r($newData);
    }

}
if (!function_exists('bulkRecieveInboundUpdate')) {

    function bulkRecieveInboundUpdate($data = null, $unique_id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $code = $data['code'];
        $slip_no = $data['slip_no'];
        $number = $data['number'];
        $main_status = $data['main_status'];
        $menifest_unique_id = $unique_id;
        $CURRENT_TIME = date('H:i:s');
        $CURRENT_DATE = date('Y-m-d H:i:s');
        $Activites = $data['Activites'];
        $details = $data['details'];
        $comment = $data['comment'];

        $today_year_month = getTodayYearMonth($CURRENT_DATE);
        //$delever_date=", delever_date='".date('Y-m-d H:i:s')."',year_month_group='".$today_year_month."' ";
        $update_menifest = "update menifest set arrived='Y' where awbillno='" . trim($slip_no) . "' ";
        $ci->db->query($update_menifest);
        $update_status_r = "update shipment set  code='" . $code . "' , delivered='" . $main_status . "' " . $cond . " where  slip_no='" . trim($slip_no) . "' ";
        $ci->db->query($update_status_r);

        $update_status = "insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('" . $slip_no . "','" . $ci->session->userdata('adminbranchlocation') . "','" . $main_status . "','" . $CURRENT_TIME . "','" . $CURRENT_DATE . "','" . $Activites . "','" . $details . "','" . $CURRENT_DATE . "','" . $ci->session->userdata('useridadmin') . "','user','" . $comment . "','" . $code . "')";
        $ci->db->query($update_status);
    }

}
if (!function_exists('getTodayYearMonth')) {

    function getTodayYearMonth($today_date = null) {
//===========================get year month =======================//

        $exploade_date = explode("-", $today_date);
        $Year = $exploade_date[0];
        $month = $exploade_date[1];


        if ($month == "01")
            $month_name = 'January';
        if ($month == "02")
            $month_name = 'February';
        if ($month == "03")
            $month_name = 'March';
        if ($month == "04")
            $month_name = 'April';
        if ($month == "05")
            $month_name = 'May';
        if ($month == "06")
            $month_name = 'June';
        if ($month == "07")
            $month_name = 'July';
        if ($month == "08")
            $month_name = 'August';
        if ($month == "09")
            $month_name = 'September';
        if ($month == "10")
            $month_name = 'October';
        if ($month == "11")
            $month_name = 'November';
        if ($month == "12")
            $month_name = 'December';

        $month_year_name = $month_name . "-" . $Year;

        return $month_year_name;
    }

}


if (!function_exists('getActivity')) {

    function getActivity($code = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "select sub_status from status_category where code='" . $code . "' and deleted='N'";
        $query = $ci->db->query($sql);
        $activityData = $query->row_array();
        return $status = $activityData['sub_status'];
    }

}


if (!function_exists('getBookingId')) {

    function getBookingId($slip_no = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "select booking_id from shipment where slip_no='" . trim($slip_no) . "' ";
        $query = $ci->db->query($sql);
        $activityData = $query->row_array();
        return $status = $activityData['booking_id'];
    }

}


if (!function_exists('update_stock')) {

    function update_stock($data = array()) {
        $ci = & get_instance();
        $ci->load->database();
        foreach ($data as $rdata) {

            foreach ($rdata as $finaldata) {

                $updates = "update item_inventory set quantity='" . $finaldata['upqty'] . "' where id='" . $finaldata['tableid'] . "'";
                $query = $ci->db->query($updates);
            }
        }
    }

}
if (!function_exists('check_stock')) {

    function check_stock($seller_id, $sku, $pieces) {
        $ci = & get_instance();
        $ci->load->database();
        //echo $pieces."<br>";		 
        $inventory_dataqry = "select item_inventory.*,items_m.sku from item_inventory left join items_m on item_inventory.item_sku=items_m.id where item_inventory.seller_id='" . $seller_id . "' and items_m.sku like'" . trim($sku) . "'";
        $query = $ci->db->query($inventory_dataqry);


        if ($query->num_rows() > 0) {
            $inventory_data = $query->result_array();
            $returnarray = array();

            //print_r($inventory_data);
            //echo array_sum($inventory_data['quantity']);
            $totalqty = 0;
            $totalqty1 = 0;
            foreach ($inventory_data as $rdata) {
                $totalqty += $rdata['quantity'];
            }

            //print_r($returnarray);
            //echo '<br>xxx'. $pieces;
            if ($pieces <= $totalqty) {
                $newpcs = $pieces;
                $ii = 0;

                foreach ($inventory_data as $rdata) {


                    if ($newpcs >= $rdata['quantity']) {

                        $returnarray[$ii]['upqty'] = 0;
                        $newpcs = $newpcs - $rdata['quantity'];
                        $pieces = $pieces - $rdata['quantity'];
                    } else {
                        if ($pieces > 0) {


                            $newpcs = $rdata['quantity'] - $newpcs;
                            $pieces = $pieces - $rdata['quantity'];
                            $returnarray[$ii]['upqty'] = $newpcs;
                        } else {

                            $returnarray[$ii]['upqty'] = $rdata['quantity'];
                        }
                    }
                    //echo '<br>yy'. $pieces.'//'.$rdata['sku'];
                    $returnarray[$ii]['tableid'] = $rdata['id'];
                    $returnarray[$ii]['skuid'] = $rdata['item_sku'];
                    $returnarray[$ii]['quantity'] = $rdata['quantity'];
                    $returnarray[$ii]['sku'] = $rdata['sku'];
                    $ii++;
                }
                //print_r($returnarray);
                return array('succ' => 1, 'stArray' => $returnarray);
            } else {
                return 'Less Stock';
            }
        } else {
            return 'Invalid SKU';
        }
    }

}
if (!function_exists('skuDetails')) {

    function skuDetails($id) {
        $ci = & get_instance();
        $ci->load->database();
        $item_query = "select   items_m.description from items_m  where sku='" . $id . "' ";
        $query = $ci->db->query($item_query);
        $result = $query->row_array();
        return $result['description'];
    }

}
if (!function_exists('BookingIdCheck_cust')) {

    function BookingIdCheck_cust($booking_id, $cust_id) {
        $ci = & get_instance();
        $ci->load->database();
        $site_query = "select slip_no from shipment where booking_id='" . trim($booking_id) . "' and cust_id='" . $cust_id . "' and deleted='N'  ";
        $query = $ci->db->query($site_query);
        $result = $query->row_array();
        return $result['slip_no'];
    }

}

if (!function_exists('Generate_awb_number')) {

    function Generate_awb_number() {
        $ci = & get_instance();
        $ci->load->helper('utility');
        $random_chars2 = mt_rand(1000000000, 9999999999);
        $generate_awb_no = 'BOL' . strtoupper($random_chars2);

        $check = checkAwbNumberExits($generate_awb_no);
        if ($check == 1) {
            Generate_awb_number();
        } else {
            return $generate_awb_no;
        }
    }

}
//================check awb number exits====================//
if (!function_exists('checkAwbNumberExits')) {

    function checkAwbNumberExits($awb_number) {
        $ci = & get_instance();
        $ci->load->database();
        $site_query = "select slip_no from shipment where slip_no='" . $awb_number . "' and deleted='N'  ";
        $query = $ci->db->query($site_query);
        $result = $query->row_array();
        //$result['slip_no'];
        if (!empty($result['slip_no'])) {
            return 1;
        } else {
            return 0;
        }
    }

}
if (!function_exists('createOrderFulfillment')) {

    function createOrderFulfillment($dataArray) {
        $ci = & get_instance();
        $ci->load->database();
        $ci->load->helper('utility');
        $CURRENT_DATE = date("Y-m-d H:i:s");
        $entrydate = date("Y-m-d H:i:s");
        $dataArrayNew = array();
        foreach ($dataArray as $datanew) {//$key=-1;
            $key2 = array_search($datanew['booking_id'], array_column($dataArrayNew, 'booking_id'));
            // echo('zzzz<br>'.$key2) ;
            // echo('zzz<br>'.$dataArrayNew[$key2]['booking_id'].'//'.$datanew['booking_id']) ;

            if ($dataArrayNew[$key2]['booking_id'] == $datanew['booking_id']) {
                // echo('vv<br>'.$dataArrayNew[$key2]['booking_id'].'//'.$datanew['booking_id']) ;
                $dataArrayNew[$key2]['pieces'] = $dataArrayNew[$key2]['pieces'] + $datanew['pieces'];
                $dataArrayNew[$key2]['total_cod_amt'] = $dataArrayNew[$key2]['total_cod_amt'] + $datanew['total_cod_amt'];
                $dataArrayNew[$key2]['weight'] = $dataArrayNew[$key2]['weight'] + $datanew['weight'];
                $key3 = array_search($datanew['sku'], array_column($dataArrayNew[$key2]['sku_details'], 'sku'));
                if ($dataArrayNew[$key2]['sku_details'][$key3]['sku'] == $datanew['sku']) {
                    // echo('cc<br>'.$dataArrayNew[$key2]['sku_details'][$key3]['sku'].'//'.$datanew['sku']) ; 

                    $dataArrayNew[$key2]['sku_details'][$key3]['pieces'] = $dataArrayNew[$key2]['sku_details'][$key3]['pieces'] + $datanew['pieces'];
                    $dataArrayNew[$key2]['sku_details'][$key3]['weight'] = $dataArrayNew[$key2]['sku_details'][$key3]['weight'] + $datanew['weight'];
                    $dataArrayNew[$key2]['sku_details'][$key3]['total_cod_amt'] = $dataArrayNew[$key2]['sku_details'][$key3]['total_cod_amt'] + $datanew['total_cod_amt'];
                } else {
                    // echo '<br>dd'.$datanew['sku'];
                    $datanew['sku_details']['sku'] = $datanew['sku'];
                    $datanew['sku_details']['total_cod_amt'] = $datanew['total_cod_amt'];
                    $datanew['sku_details']['pieces'] = $datanew['pieces'];
                    $datanew['sku_details']['status_describtion'] = skuDetails($datanew['sku']);
                    $datanew['sku_details']['weight'] = $datanew['weight'];
                    array_push($dataArrayNew[$key2]['sku_details'], $datanew['sku_details']);
                }
            } else {
                // echo '<br>ll'.$datanew['sku'];
                array_push($dataArrayNew, $datanew);
                $lastkey = count($dataArrayNew) - 1;
                $datanew['sku_details']['sku'] = $datanew['sku'];
                $datanew['sku_details']['total_cod_amt'] = $datanew['total_cod_amt'];
                $datanew['sku_details']['pieces'] = $datanew['pieces'];
                $datanew['sku_details']['status_describtion'] = skuDetails($datanew['sku']);
                $datanew['sku_details']['weight'] = $datanew['weight'];
                $dataArrayNew[$lastkey]['sku_details'][] = $datanew['sku_details'];
            }
        }
        // print_r($dataArrayNew); exit;
        foreach ($dataArrayNew as $data) {
            $new_awb_number = $data['slip_no'];

            $new_pices = $data['pieces'];
            $new_weight = $data['weight'];
            $new_cod = $data['total_cod_amt'];
            //$booking_id=$this->ZajilCreateorderId($data);
            $booking_id = $data['booking_id'];
            $bookingExits = BookingIdCheck_cust($data['booking_id'], $data['cust_id']);

            if ($bookingExits == '') {
                $stockarray = array();
                foreach ($data['sku_details'] as $data4) {
                    $stock_check = check_stock($data['seller_id'], $data4['sku'], $data4['pieces']);
                    //$datacheck=count($stock_check);
                    if ($stock_check['succ'] == 1) {
                        //array_push($ReturnstockArray,$stock_check['stArray']);
                        $ReturnstockArray[] = $stock_check['stArray'];
                    } else {
                        array_push($stockarray, $data4['sku']);
                    }
                }
                //print_r($stockarray);exit;	 
                if (empty($stockarray)) {

                    $shipment_m_data .= "('" . $new_awb_number . "', '" . $data['sku'] . "','','" . $data['seller_id'] . "','" . $data['delivered'] . "','" . $new_pices . "','0','" . $CURRENT_DATE . "','shipment Booked'),";
                    // {
                    $shipmentInsetValue .= "( '" . ($data['booking_id']) . "','" . $data['user_id'] . "','" . $data['shippers_ac_no'] . "', '" . $data['shippers_ref_no'] . "', '" . $data['nrd'] . "', '" . $data['slip_no'] . "', '" . $data['origin'] . "','" . $data['destination'] . "','" . $data['pieces'] . "','" . $data['weight'] . "','" . $data['volumetric_weight'] . "','" . $data['sender_name'] . "','" . $data['sender_address'] . "','" . $data['sender_phone'] . "','" . $data['sender_email'] . "','" . ($data['reciever_name']) . "' ,'" . ($data['reciever_address']) . "' ,'" . $data['reciever_phone'] . "'  ,'" . $data['reciever_email'] . "' ,'" . $data['service_charge'] . "' ,'" . $data['status_describtion'] . "','" . $data['entrydate'] . "','" . $data['mode'] . "','" . $data['delivered'] . "','" . $data['cust_id'] . "','" . $data['total_cod_amt'] . "','" . $data['service_id'] . "','" . $data['sku'] . "','" . getStatusCode($data['delivered']) . "','Y'),";
                    if (!empty($data['sku_details'])) {
                        //print_r($ReturnstockArray);
                        update_stock($ReturnstockArray);
                        foreach ($data['sku_details'] as $data3) {

                            $add_diamention = "INSERT INTO diamention(slip_no,booking_id, length, width, height, wieght,piece,sku,description,cod) VALUES ('" . $new_awb_number . "','" . $booking_id . "','','','','" . $data3['weight'] . "','" . $data3['pieces'] . "','" . $data3['sku'] . "','" . $data3['status_describtion'] . "','" . $data3['total_cod_amt'] . "')";
                            $ci->db->query($add_diamention);
                        }
                    }
                    if (isset($data['user_type']) && !empty($data['user_type'])) {
                        $user_type = $data['user_type'];
                    } else {
                        $user_type = 'user';
                    }
                    if ($data['delever_time'] == '') {
                        $Activites = getStatus($data['delivered']);
                        $Details = getStatus($data['delivered']);
                    } else {
                        $Activites = "Reverse order as per customer request &rarr; Original AWB #" . $data['slip_no'];
                        $Details = "Reverse order as per customer request &rarr; Original AWB #" . $data['slip_no'];
                    }

                    $statusInsertData .= " ('" . $data['slip_no'] . "','" . $data['sender_city'] . "','" . $data['delivered'] . "','" . $data['CURRENT_TIME'] . "','" . $entrydate . "','" . $Activites . "','" . $Details . "','" . $entrydate . "','" . $data['user_id'] . "','" . $user_type . "','" . getStatusCode($data['delivered']) . "'),";


                    if ($data['mode'] == 'COD') {
                        $codInsertData .= "('" . $data['cust_id'] . "','" . $data['slip_no'] . "','" . $data['total_cod_amt'] . "','" . $data['year_month_group'] . "'),";
                    }
                    //==============================================invoice generate query========================================//	
                }
            }
        }
        if ($bookingExits == '') {
            $shipmentInsetValue = rtrim($shipmentInsetValue, ',');
            $statusInsertData = rtrim($statusInsertData, ',');
            $inserdata = rtrim($inserdata, ',');
            $codInsertData = rtrim($codInsertData, ',');
            if (!empty($shipmentInsetValue)) {


                $add_shipment = "insert into shipment (booking_id,user_id,shippers_ac_no, shippers_ref_no, nrd, slip_no, origin ,destination ,pieces ,weight  ,volumetric_weight ,sender_name ,sender_address  ,sender_phone  ,sender_email ,reciever_name ,reciever_address ,reciever_phone  ,reciever_email  ,service_charge ,status_describtion,entrydate,mode,delivered,cust_id, total_cod_amt,service_id,sku,code,fulfillment) values " . $shipmentInsetValue;

                $ci->db->query($add_shipment);



                $update_status = "insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,code) values" . $statusInsertData;
                $ci->db->query($update_status);
                //echo $ci->db->last_query();exit;
            }



            return true;
        }
    }

}
if (!function_exists('Getupdate_status')) {

    function Getupdate_status($data = array()) {
        $ci = & get_instance();
        $ci->load->database();
        $query = $ci->db->insert($data);
    }

}
if (!function_exists('getusertypedropdown')) {

    function getusertypedropdown($id = null) {

        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT id,designation_name FROM designation_tbl";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        $userdrop = '<select class="form-control" name="usertype" id="usertype"><option value="">Please Select</option>';
        foreach ($result as $row) {
            if ($row['id'] == $id)
                $userdrop .= '<option value="' . $row['id'] . '" selected="selected">' . $row['designation_name'] . '</option>';
            else
                $userdrop .= '<option value="' . $row['id'] . '">' . $row['designation_name'] . '</option>';
        }
        $userdrop .= '</select>';
        return $userdrop;
    }

}


if (!function_exists('Getallskudatadetails')) {

    function Getallskudatadetails($slip_no = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "select (select id from items_m where items_m.sku=diamention.sku)as itmSku,piece from diamention where deleted='N' and slip_no='" . $slip_no . "'";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

}
if (!function_exists('getusertypenameshow')) {

    function getusertypenameshow($id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT id,designation_name FROM designation_tbl where id='$id'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result['designation_name'];
    }

}
if (!function_exists('get_total_current')) {

    function get_total_current($status = null) {


        $date1 = date('Y-m-d');


        $current_date_new = '';
        //	if($current_date == 1){
        $current_date = date('Y-m-d');
        $current_date_new = "	 and DATE(entrydate)='" . $current_date . "' ";
        //}
        if ($status_slug == '11' || $status_slug == '6') {
            $current_date = date('Y-m-d');
            $current_date_new = "	 and DATE(delever_date)='" . $current_date . "' ";
        }
        $total = 0;
        $status_condition = "and delivered='" . $status . "'";
        $ci = & get_instance();
        $ci->load->database();
        $sql = "select id from shipment where  status='Y' and deleted='N' $status_condition $current_date_new ";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return count($result);
    }

}

if (!function_exists('getUserNameById')) {

    function getUserNameById($id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT username FROM users where user_id='$id'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result['username'];
    }

}
if (!function_exists('getstaff_multycreated')) {

    function getstaff_multycreated($id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $siteQry = "select name,id from user where status='Y' and deleted='N' and usertype='S'  order by name asc";

        $query = $ci->db->query($siteQry);
        $result = $query->result_array();
        return $result;
    }

}
if (!function_exists('invoiceCountnew')) {

    function invoiceCountnew($invoice_no = null) {
        $ci = & get_instance();
        $ci->load->database();
        $siteQry = "select count(id) as total_numCount from Payable_invoice where invoice_no='" . $invoice_no . "' ";
        $query = $ci->db->query($siteQry);
        $invoiceCountData = $query->row_array();

        return $invoiceCountData;
    }

}
if (!function_exists('invoiceDetailnew')) {

    function invoiceDetailnew($invoice_no = null) {
        $ci = & get_instance();
        $ci->load->database();
        $siteQry = "select SUM(cod_charge) as cod_charge_sum,SUM(return_charge) as return_charge_sum,SUM(service_charge) as service_charge_sum,SUM(cod_amount) as cod_amount_sum,SUM(vat) as vat_sum from Payable_invoice where invoice_no='" . $invoice_no . "'";
        $query = $ci->db->query($siteQry);
        $invoiceCountData = $query->row_array();
        return $invoiceCountData;
    }

}

if (!function_exists('getpickuplist_tblDatashow')) {

    function getpickuplist_tblDatashow($slip_no = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT sku FROM pickuplist_tbl where slip_no='$slip_no'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result['sku'];
    }

}

if (!function_exists('getUserNameByIdType')) {

    function getUserNameByIdType($id = null, $usertype = null) {

        $ci = & get_instance();
        $ci->load->database();

        if ($usertype == 'customer')
            $sql = "SELECT name as username FROM customer where id='$id'";
        else
            $sql = "SELECT username FROM users where user_id='$id'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result['username'];
    }

}


if (!function_exists('statusCount')) {

    function statusCount($id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT COUNT(ID) as total_cnt FROM shipment  where delivered='" . $id . "' and deleted='N'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result['total_cnt'];
    }

}
if (!function_exists('getallsratusshipmentid')) {

    function getallsratusshipmentid($shipid = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT $field FROM shipment  where id='$shipid'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result[$field];
    }

}

if (!function_exists('GetshpmentDataByawb')) {

    function GetshpmentDataByawb($awb = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT $field FROM shipment  where slip_no='$awb'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result[$field];
    }

}
if (!function_exists('shelve_warehouse_select_box')) {

    function shelve_warehouse_select_box($city_id = null) {
        $ci = & get_instance();
        $ci->load->database();
        if (!empty($city_id) && $city_id > 0)
            $condition = "and city_id='$city_id'";
        $sql = "select `id`,  `city_id`, `shelv_location` from warehous_shelve where deleted='N' and status='Y' $condition";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        foreach ($result as $key => $val) {
            $result[$key]['cityname'] = Get_name_country_by_id('city', $val['city_id']);
        }
        return $result;
    }

}
if (!function_exists('getAllDestination')) {

    function getAllDestination($id = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();
        if (!empty($id) && $id > 0) {
            $country = Get_name_country_by_id('country', $id);
            $condition = "and country='$country'";
        }
        $sql = "SELECT id,city FROM country where deleted='N' and city!='' $condition";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

}
if (!function_exists('GetcountryDropData')) {

    function GetcountryDropData($id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT id,country FROM country where deleted='N' and state='' and city=''";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

}


if (!function_exists('GetCityDropData')) {

    function GetCityDropData() {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT id,city FROM country where deleted='N' and city!=''";
        $query = $ci->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

}


if (!function_exists('getitembulduploadData')) {

    function getitembulduploadData($data, $stock_location) {
        $ci = & get_instance();
        $ci->load->database();
        $ci->db->select('*');
        $ci->db->from('item_inventory');
        $ci->db->where('item_sku', $data['item_sku']);
        $ci->db->where('seller_id', $data['seller_id']);
        $ci->db->where('expity_date', $data['expity_date']);
        $ci->db->where('stock_location', $stock_location);
        $query2 = $ci->db->get();

        return $query2->row();
    }

}
if (!function_exists('getallitemskubyid')) {

    function getallitemskubyid($sku = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT id FROM items_m where sku='$sku'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result['id'];
    }

}



if (!function_exists('getalldataitemtables')) {

    function getalldataitemtables($id = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT $field FROM items_m where id='$id'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result[$field];
    }

}


if (!function_exists('GetcheckalreadyLocations')) {

    function GetcheckalreadyLocations($stock_location = null, $seller_id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT id FROM stockLocation where stock_location='$stock_location' and seller_id='$seller_id'";
        $query = $ci->db->query($sql);
        $countdata = $query->num_rows();
        if ($countdata == 0)
            return true;
        else
            return false;
    }

}



if (!function_exists('GetallaccountidBysellerID')) {

    function GetallaccountidBysellerID($uid = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT seller_id FROM customer where uniqueid='$uid'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result['seller_id'];
    }

}

function barcodeRuntime_new($bar_code_id) {
    // Get pararameters that are passed in through $_GET or set to the default value
    $text = (isset($_GET["text"]) ? $_GET["text"] : $bar_code_id);
    $size = (isset($_GET["size"]) ? $_GET["size"] : "40");
    $orientation = (isset($_GET["orientation"]) ? $_GET["orientation"] : "horizontal");
    $code_type = (isset($_GET["codetype"]) ? $_GET["codetype"] : "code128");
    $code_string = "";

    // Translate the $text into barcode the correct $code_type
    if (strtolower($code_type) == "code128") {
        $chksum = 104;
        // Must not change order of array elements as the checksum depends on the array's key to validate final code
        $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ($X = 1; $X <= strlen($text); $X++) {
            $activeKey = substr($text, ($X - 1), 1);
            $code_string .= $code_array[$activeKey];
            $chksum = ($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

        $code_string = "211214" . $code_string . "2331112";
    } elseif (strtolower($code_type) == "codabar") {
        $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "-", "$", ":", "/", ".", "+", "A", "B", "C", "D");
        $code_array2 = array("1111221", "1112112", "2211111", "1121121", "2111121", "1211112", "1211211", "1221111", "2112111", "1111122", "1112211", "1122111", "2111212", "2121112", "2121211", "1121212", "1122121", "1212112", "1112122", "1112221");

        // Convert to uppercase
        $upper_text = strtoupper($text);

        for ($X = 1; $X <= strlen($upper_text); $X++) {
            for ($Y = 0; $Y < count($code_array1); $Y++) {
                if (substr($upper_text, ($X - 1), 1) == $code_array1[$Y])
                    $code_string .= $code_array2[$Y] . "1";
            }
        }
        $code_string = "11221211" . $code_string . "1122121";
    }

    // Pad the edges of the barcode
    $code_length = 20;
    for ($i = 1; $i <= strlen($code_string); $i++)
        $code_length = $code_length + (integer) (substr($code_string, ($i - 1), 1));

    if (strtolower($orientation) == "horizontal") {
        $img_width = $code_length;
        $img_height = $size;
    } else {
        $img_width = $size;
        $img_height = $code_length;
    }

    $image = imagecreate($img_width, $img_height);
    $black = imagecolorallocate($image, 0, 0, 0);
    $white = imagecolorallocate($image, 255, 255, 255);

    imagefill($image, 0, 0, $white);

    $location = 10;
    for ($position = 1; $position <= strlen($code_string); $position++) {
        $cur_size = $location + ( substr($code_string, ($position - 1), 1) );
        if (strtolower($orientation) == "horizontal")
            imagefilledrectangle($image, $location, 0, $cur_size, $img_height, ($position % 2 == 0 ? $white : $black));
        else
            imagefilledrectangle($image, 0, $location, $img_width, $cur_size, ($position % 2 == 0 ? $white : $black));
        $location = $cur_size;
    }

    ob_start();

    imagejpeg($image);
    imagedestroy($image);

    $data = ob_get_contents();

    ob_end_clean();

    $image = "<img src='data:image/jpeg;base64," . base64_encode($data) . "'>";
    return $image;
    // Draw barcode to the screen
    //imagejpeg($image,$path,100);	
    //header ('Content-type: image/png');
    //imagepng($image);
    //imagedestroy($image);
}

if (!function_exists('barcodeRuntime')) {

    function barcodeRuntime($bar_code_id) {
        // Get pararameters that are passed in through $_GET or set to the default value
        $text = (isset($_GET["text"]) ? $_GET["text"] : $bar_code_id);
        $size = (isset($_GET["size"]) ? $_GET["size"] : "80");
        $orientation = (isset($_GET["orientation"]) ? $_GET["orientation"] : "horizontal");
        $code_type = (isset($_GET["codetype"]) ? $_GET["codetype"] : "code128");
        $code_string = "";

        // Translate the $text into barcode the correct $code_type
        if (strtolower($code_type) == "code128") {
            $chksum = 104;
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

            $code_string = "211214" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "codabar") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "-", "$", ":", "/", ".", "+", "A", "B", "C", "D");
            $code_array2 = array("1111221", "1112112", "2211111", "1121121", "2111121", "1211112", "1211211", "1221111", "2112111", "1111122", "1112211", "1122111", "2111212", "2121112", "2121211", "1121212", "1122121", "1212112", "1112122", "1112221");

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ($X = 1; $X <= strlen($upper_text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($upper_text, ($X - 1), 1) == $code_array1[$Y])
                        $code_string .= $code_array2[$Y] . "1";
                }
            }
            $code_string = "11221211" . $code_string . "1122121";
        }

        // Pad the edges of the barcode
        $code_length = 40;
        for ($i = 1; $i <= strlen($code_string); $i++)
            $code_length = $code_length + (integer) (substr($code_string, ($i - 1), 1));

        if (strtolower($orientation) == "horizontal") {
            $img_width = $code_length;
            $img_height = $size;
        } else {
            $img_width = $size;
            $img_height = $code_length;
        }

        $image = imagecreate($img_width, $img_height);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);

        imagefill($image, 0, 0, $white);

        $location = 10;
        for ($position = 1; $position <= strlen($code_string); $position++) {
            $cur_size = $location + ( substr($code_string, ($position - 1), 1) );
            if (strtolower($orientation) == "horizontal")
                imagefilledrectangle($image, $location, 0, $cur_size, $img_height, ($position % 2 == 0 ? $white : $black));
            else
                imagefilledrectangle($image, 0, $location, $img_width, $cur_size, ($position % 2 == 0 ? $white : $black));
            $location = $cur_size;
        }

        ob_start();

        imagejpeg($image);
        imagedestroy($image);

        $data = ob_get_contents();

        ob_end_clean();

        $image = base64_encode($data);
        return $image;
        // Draw barcode to the screen
        //imagejpeg($image,$path,100);	
        //header ('Content-type: image/png');
        //imagepng($image);
        //imagedestroy($image);
    }

}
if (!function_exists('getdestinationfieldshow')) {

    function getdestinationfieldshow($id = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT $field FROM country where id='$id'";
        $query = $ci->db->query($sql);
        //echo $ci->db->last_query();exit;
        $result = $query->row_array();
        return $result[$field];
    }

}


if (!function_exists('Get_cust_uid')) {

    function Get_cust_uid($cust_id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "select uniqueid from customer where id='" . $cust_id . "'";
        $query = $ci->db->query($sql);
        //echo $ci->db->last_query();exit;
        $result = $query->row_array();
        return $result['uniqueid'];
    }

}



if (!function_exists('all_main_status_bulk')) {

    function all_main_status_bulk($status = null) {
        $ci = & get_instance();
        $ci->load->database();
        if ($ci->session->userdata('adminusertype') == 'S')
            $cond = " and id NOT IN (11,15,12,16,17,18,19,9,6,21,22,23)  order by main_status";
        else
            $cond = " and id NOT IN (12,16,17,18,19,6,9,22,23) order by main_status";

        $query = $ci->db->query("select id,main_status from status_main_cat where status='Y' and deleted='N' " . $cond);
        $statusData = $query->result_array();

        return $statusData;
    }

}


if (!function_exists('get_report_status')) {

    function get_report_status($slip_no = null, $status = null) {

        $ci = & get_instance();
        $ci->load->database();

        if (!empty($slip_no)) {

            if ($status = 'N') {
                $main_status = '1';
                $statusCond = " and new_status='" . $main_status . "' and Activites like '%not delivered%'";



                $status = "select Details,comment from status where  slip_no='" . $slip_no . "'  " . $statusCond . " order by id desc limit 1";

                $query = $ci->db->query($status);

                //echo $ci->db->last_query();exit;
                $result = $query->row_array();
                return $result;
            }
        }
    }

}

if (!function_exists('all_main_status_subCat')) {

    function all_main_status_subCat($main_status = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT id,sub_status,code FROM status_category where main_status='$main_status' ";
        $query = $ci->db->query($sql);
        //echo $ci->db->last_query();exit;
        $rows = $query->result_array();
        return $rows;
    }

}
if (!function_exists('inter_origin')) {

    function inter_origin() {
        $ci = & get_instance();
        $ci->load->database();
        $siteQry = "SELECT shelv_no FROM `warehous_shelve_no` WHERE status='Y'  and deleted='N'";
        $query = $ci->db->query($siteQry);
        $rows = $query->result_array();
        return $rows;
    }

}

if (!function_exists('getidsByNameshow')) {

    function getidsByNameshow($id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT id FROM country where state='$id'";
        $query = $ci->db->query($sql);
        //echo $ci->db->last_query();exit;
        $result = $query->row_array();
        return $result['id'];
    }

}


if (!function_exists('getIdByCityName')) {

    function getIdByCityName($id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT id FROM country where city='$id'";
        $query = $ci->db->query($sql);
        
        $result = $query->row_array();
        return $result['id'];
    }

}



if (!function_exists('outOfDelivery')) {

    function outOfDelivery($data = array()) {
        $ci = & get_instance();
        $ci->load->database();
        $code = $data['code'];
        $driver_id = $data['driver_id'];
        $slip_no = $data['slip_no'];
        $number = $data['number'];
        $main_status = $data['main_status'];
        $driver_rout = $data['driver_rout'];
        $drs_unique_code = $data['drs_unique_code'];
        $CURRENT_TIME = date('H:i:s');
        $CURRENT_DATE = date('Y-m-d H:i:s');
        $Activites = $data['Activites'];
        $details = $data['details'];
        $comment = $data['comment'];

        $sql = "select messanger_id, drs_unique_id from drs where   shipment_id='" . trim($slip_no) . "'  and deleted='N' and DATE(drs_date)='" . date('Y-m-d') . "'";
        $query = $ci->db->query($sql);
        $queryData = $query->row_array();

        if (!empty($queryData['messanger_id'])) {
            $active_drs = "update drs set deleted='Y' where shipment_id='" . trim($slip_no) . "' and drs_unique_id='" . $queryData['drs_unique_id'] . "' and deleted='N'";
            $ci->db->query($active_drs);
        }

        if ($drs_unique_code != $queryData['drs_unique_id']) {
            $edit_drs = "insert into drs (routecode, shipment_id, city_id,drs_date, messanger_id,drs_unique_id) values ('" . $driver_rout . "', '" . trim($slip_no) . "', '" . $_SESSION['adminbranchlocation'] . "','" . $CURRENT_DATE . "','" . $driver_id . "','" . $drs_unique_code . "')";
            $ci->db->query($edit_drs);


            GetAllAttemptUpdate(trim($slip_no));
            $update_status_r = "update shipment set delivered='" . $main_status . "', code='" . $code . "' ,messanger_id='" . $driver_id . "' where  slip_no='" . trim($slip_no) . "' ";
            $ci->db->query($update_status_r);
            $update_status = "insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('" . $slip_no . "','" . $_SESSION['adminbranchlocation'] . "','" . $main_status . "','" . $CURRENT_TIME . "','" . $CURRENT_DATE . "','" . $Activites . "','" . $details . "','" . $CURRENT_DATE . "','" . $_SESSION['useridadmin'] . "','user','" . $comment . "','" . $code . "')";
            $ci->db->query($update_status);
        }
    }

}
if (!function_exists('createPickup')) {

    function createPickup($data = array()) {
        $ci = & get_instance();
        $ci->load->database();
        $code = $data['code'];
        $driver_id = $data['driver_id'];
        $slip_no = $data['slip_no'];
        $number = $data['number'];
        $main_status = $data['main_status'];
        $driver_rout = $data['driver_rout'];
        $drs_unique_code = $data['drs_unique_code'];
        $CURRENT_TIME = date('H:i:s');
        $CURRENT_DATE = date('Y-m-d H:i:s');
        $Activites = $data['Activites'];
        $details = $data['details'];
        $comment = $data['comment'];


        $city_id = $citydata[0]['sender_city'];
        $edit_drs = "insert into pickup (routecode, shipment_id, city_id,drs_date, messanger_id,drs_unique_id,drs_bar_image,drs_bar_code) values ('" . $driver_rout . "', '" . trim($slip_no) . "', '" . $city_id . "','" . $CURRENT_DATE . "','" . $driver_id . "','" . $drs_unique_code . "','" . $uploaded_file . "','" . $auto_bar_id . "')";
        $ci->db->query($edit_drs);

        $update_status_r = "update shipment set messanger_id='" . $driver_id . "', code='" . $code . "', delivered='" . $main_status . "' where  slip_no='" . trim($slip_no) . "' ";
        $ci->db->query($update_status_r);

        $update_status = "insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('" . $slip_no . "','" . $ci->session->userdata('adminbranchlocation') . "','" . $main_status . "','" . $CURRENT_TIME . "','" . $CURRENT_DATE . "','" . $Activites . "','" . $details . "','" . $CURRENT_DATE . "','" . $ci->session->userdata('useridadmin') . "','user','" . $comment . "','" . $code . "')";
        $ci->db->query($update_status);
    }

}
if (!function_exists('GetAllAttemptUpdate')) {

    function deliverShipment($data = array()) {
        $ci = & get_instance();
        $ci->load->database();
        $code = $data['code'];
        $driver_id = $data['driver_id'];
        $slip_no = $data['slip_no'];
        $number = $data['number'];
        $main_status = $data['main_status'];
        $driver_rout = $data['driver_rout'];
        $drs_unique_code = $data['drs_unique_code'];
        $CURRENT_TIME = date('H:i:s');
        $CURRENT_DATE = date('Y-m-d H:i:s');
        $Activites = $data['Activites'];
        $details = $data['details'];
        $comment = $data['comment'];
        $today_year_month = getTodayYearMonth($CURRENT_DATE);
        $delever_date = ", delever_date='" . date('Y-m-d H:i:s') . "',year_month_group='" . $today_year_month . "' ";
        $drs_update_query = "update drs set delivered='Y' where shipment_id='" . trim($slip_no) . "' ORDER BY id DESC
LIMIT 1";
        $ci->db->query($drs_update_query);


        $update_status_r = "update shipment set delivered='" . $main_status . "', messanger_id='" . $driver_id . "', code='" . $code . "' " . $delever_date . " ,delevered_to='" . $data['reciever_name'] . "',delevered_no='" . $data['reciever_number'] . "' where  slip_no='" . trim($slip_no) . "' ";

        $ci->db->query($update_status_r);

        $update_status = "insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('" . $slip_no . "','" . $_SESSION['adminbranchlocation'] . "','" . $main_status . "','" . $CURRENT_TIME . "','" . $CURRENT_DATE . "','" . $Activites . "','" . $details . "','" . $CURRENT_DATE . "','" . $ci->session->userdata('useridadmin') . "','user','" . $comment . "','" . $code . "')";
        $ci->db->query($update_status);
    }

}
if (!function_exists('GetAllAttemptUpdate')) {

    function GetAllAttemptUpdate($slip_no = null) {
        $ci = & get_instance();
        $ci->load->database();
        if (!empty($slip_no))
            $ci->db->query("update shipment set d_attempt=d_attempt+1 where slip_no='$slip_no'");
    }

}
if (!function_exists('bulkStatusUpdate')) {

    function bulkStatusUpdate($data = array()) {

        $ci = & get_instance();
        $ci->load->database();
        $code = $data['code'];
        $driver_id = $data['driver_id'];
        $slip_no = $data['slip_no'];
        $number = $data['number'];
        $main_status = $data['main_status'];
        $driver_rout = $data['driver_rout'];
        $drs_unique_code = $data['drs_unique_code'];
        $CURRENT_TIME = date('H:i:s');
        $pickup_image = $data['pickup_image'];
        $CURRENT_DATE = date('Y-m-d H:i:s');
        $Activites = $data['Activites'];
        $details = $data['details'];
        $comment = $data['comment'];
        $today_year_month = getTodayYearMonth($CURRENT_DATE);
        $cond = '';
        $cond1 = '';
        if ($code == 'PUC') {
            $cond .= " , pickup_date='" . $CURRENT_DATE . "'";
        }
        if (!empty($pickup_image)) {
            $cond .= " , pickup_image='" . $pickup_image . "'";
        }

        $destZone = getdestinationfieldshow($data['destination'], 'zone_id');
        $staffZone = getdestinationfieldshow($ci->session->userdata('adminbranchlocation'), 'zone_id');
        if ($destZone == $staffZone) {
            $ThatTime = '16:00';
            if (strtotime($ThatTime) >= time())
                $expactedDate = date('Y-m-d');
            else
                $expactedDate = date('Y-m-d', strtotime('+1 days'));
            $cond .= " ,req_delevery_time='" . $expactedDate . "' ";
        } else {
            $cond .= "";
        }

        //$delever_date=", delever_date='".date('Y-m-d H:i:s')."',year_month_group='".$today_year_month."' ";
        //$drs_update_query="update drs set delivered='Y' where shipment_id='".trim($slip_no)."' ORDER BY id DESC LIMIT 1";  
        //$this->dbh->Query($drs_update_query);	
        //
        //print_r($ci->session->userdata);
        //echo $ci->session->userdata('adminbranchlocation'); die;
        $update_status_r = "update shipment set  code='" . $code . "' ,pickup_date='" . $CURRENT_DATE . "', delivered='" . $main_status . "' " . $cond . " " . $cond1 . " where  slip_no='" . trim($slip_no) . "' ";
        $ci->db->query($update_status_r);

        $update_status = "insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('" . $slip_no . "','" . $ci->session->userdata('adminbranchlocation') . "','" . $main_status . "','" . $CURRENT_TIME . "','" . $CURRENT_DATE . "','" . $Activites . "','" . $details . "','" . $CURRENT_DATE . "','" . $ci->session->userdata('useridadmin') . "','user','" . $comment . "','" . $code . "')";
        $ci->db->query($update_status);
    }

}


if (!function_exists('bulkStatusRemove')) {

    function bulkStatusRemove($data = array()) {

        $ci = & get_instance();
        $ci->load->database();
        $code = $data['code'];
        $slip_no = $data['slip_no'];
        $CURRENT_TIME = date('H:i:s');
        $pickup_image = $data['pickup_image'];
        $CURRENT_DATE = date('Y-m-d H:i:s');
        $Activites = $data['Activites'];
        $comment = $data['comment'];
        $today_year_month = getTodayYearMonth($CURRENT_DATE);


        $update_status_r = "update shipment set schedule_status='N',schedule_type='' where  slip_no='" . trim($slip_no) . "' ";
        $ci->db->query($update_status_r);

        $update_status = "insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('" . $slip_no . "','" . $ci->session->userdata('adminbranchlocation') . "',16,'" . $CURRENT_TIME . "','" . $CURRENT_DATE . "','" . $Activites . "','Shipment Not Scheduled by CSA','" . $CURRENT_DATE . "','" . $ci->session->userdata('useridadmin') . "','user','" . $comment . "','" . $code . "')";
        $ci->db->query($update_status);
    }

}


if (!function_exists('readyForDelivery')) {

    function readyForDelivery($data = array()) {
        $ci = & get_instance();
        $ci->load->database();
        $code = $data['code'];
        $driver_id = $data['driver_id'];
        $slip_no = $data['slip_no'];
        $number = $data['number'];
        $main_status = $data['main_status'];
        $driver_rout = $data['driver_rout'];
        $drs_unique_code = $data['drs_unique_code'];
        $CURRENT_TIME = date('H:i:s');
        $CURRENT_DATE = date('Y-m-d H:i:s');
        $Activites = $data['Activites'];
        $details = $data['details'];
        $comment = $data['comment'];
        $today_year_month = getTodayYearMonth($CURRENT_DATE);
        //$delever_date=", delever_date='".date('Y-m-d H:i:s')."',year_month_group='".$today_year_month."' ";
        $drs_update_query = "update drs set delivered='Y' where shipment_id='" . trim($slip_no) . "' ORDER BY id DESC
LIMIT 1";
        $ci->db->query($drs_update_query);




        $update_status_r = "update shipment set  code='" . $code . "',messanger_id='" . $driver_id . "' ,delivered='" . $main_status . "' where  slip_no='" . trim($slip_no) . "' ";
        $ci->db->query($update_status_r);

        $edit_drs_temp = "insert into temp_drs (routecode, shipment_id, city_id,drs_date, messanger_id,drs_unique_id,drs_bar_image,drs_bar_code) values ('" . $driver_rout . "', '" . trim($slip_no) . "', '" . $ci->session->userdata('adminbranchlocation') . "','" . $CURRENT_DATE . "','" . $driver_id . "','" . $drs_unique_code . "','" . $uploaded_file . "','" . $auto_bar_id . "')";
        $ci->db->query($edit_drs_temp);

        $update_status = "insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('" . $slip_no . "','" . $ci->session->userdata('adminbranchlocation') . "','" . $main_status . "','" . $CURRENT_TIME . "','" . $CURRENT_DATE . "','" . $Activites . "','" . $details . "','" . $CURRENT_DATE . "','" . $ci->session->userdata('useridadmin') . "','user','" . $comment . "','" . $code . "')";
        $ci->db->query($update_status);
    }

}

if (!function_exists('shelveShipment')) {

    function shelveShipment($data = array()) {
        $ci = & get_instance();
        $ci->load->database();
        $code = $data['code'];
        $driver_id = $data['driver_id'];
        $slip_no = $data['slip_no'];
        $number = $data['number'];
        $main_status = $data['main_status'];
        $driver_rout = $data['driver_rout'];
        $drs_unique_code = $data['drs_unique_code'];
        $CURRENT_TIME = date('H:i:s');
        $CURRENT_DATE = date('Y-m-d H:i:s');
        $Activites = $data['Activites'];
        $details = $data['details'];
        $comment = $data['comment'];
        $today_year_month = getTodayYearMonth($CURRENT_DATE);
        //$delever_date=", delever_date='".date('Y-m-d H:i:s')."',year_month_group='".$today_year_month."' ";
        $drs_update_query = "update drs set delivered='Y' where shipment_id='" . trim($slip_no) . "' ORDER BY id DESC
LIMIT 1";
        $ci->db->query($drs_update_query);

        $update_status_r = "update shipment set  code='" . $code . "' ,shelv_no='" . $data['shelv_no'] . "', delivered='" . $main_status . "' where  slip_no='" . trim($slip_no) . "' ";

        $ci->db->query($update_status_r);

        $update_status = "insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('" . $slip_no . "','" . $ci->session->userdata('adminbranchlocation') . "','" . $main_status . "','" . $CURRENT_TIME . "','" . $CURRENT_DATE . "','" . $Activites . "','" . $details . "','" . $CURRENT_DATE . "','" . $ci->session->userdata('useridadmin') . "','user','" . $comment . "','" . $code . "')";
        $ci->db->query($update_status);
    }

}
if (!function_exists('bulkStatusUpdatereturndelivery')) {

    function bulkStatusUpdatereturndelivery($data) {
        $ci = & get_instance();
        $ci->load->database();
        $code = $data['code'];
        $driver_id = $data['driver_id'];
        $slip_no = $data['slip_no'];
        $number = $data['number'];
        $main_status = $data['main_status'];
        $driver_rout = $data['driver_rout'];
        $drs_unique_code = $data['drs_unique_code'];
        $CURRENT_TIME = date('H:i:s');
        $CURRENT_DATE = date('Y-m-d H:i:s');
        $Activites = $data['Activites'];
        $details = $data['details'];
        $comment = $data['comment'];
        $today_year_month = getTodayYearMonth($CURRENT_DATE);
        $cond = '';
        if ($code == 'PUC') {
            $cond = " , pickup_date='" . $CURRENT_DATE . "'";
        }




        $update_status_r = "update shipment set  code='" . $code . "', refused='YES', delivered='" . $main_status . "' " . $cond . " where  slip_no='" . trim($slip_no) . "' ";
        $ci->db->query($update_status_r);

        $update_status1 = "insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('" . $slip_no . "','" . $ci->session->userdata('adminbranchlocation') . "','" . $main_status . "','" . $CURRENT_TIME . "','" . $CURRENT_DATE . "','On hold','On hold due to  return from delivery station.','" . $CURRENT_DATE . "','" . $ci->session->userdata('useridadmin') . "','user','" . $comment . "','OH')";
        $this->dbh->Query($update_status1);
        $update_status = "insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('" . $slip_no . "','" . $ci->session->userdata('adminbranchlocation') . "','" . $main_status . "','" . $CURRENT_TIME . "','" . $CURRENT_DATE . "','" . $Activites . "','" . $details . "','" . $CURRENT_DATE . "','" . $ci->session->userdata('useridadmin') . "','user','" . $comment . "','" . $code . "')";
        $this->dbh->Query($update_status);
    }

}
if (!function_exists('bulkStatusUpdateUi')) {

    function bulkStatusUpdateUi($data = array()) {
        $ci = & get_instance();
        $ci->load->database();
        $code = $data['code'];
        $driver_id = $data['driver_id'];
        $slip_no = $data['slip_no'];
        $number = $data['number'];
        $main_status = $data['main_status'];
        $driver_rout = $data['driver_rout'];
        $drs_unique_code = $data['drs_unique_code'];
        $CURRENT_TIME = date('H:i:s');
        $pickup_image = $data['pickup_image'];
        $CURRENT_DATE = date('Y-m-d H:i:s');
        $Activites = $data['Activites'];
        $details = $data['details'];
        $comment = $data['comment'];
        $today_year_month = getTodayYearMonth($CURRENT_DATE);
        $cond = '';
        $cond1 = '';





        $update_status_r = "update shipment set  code='" . $code . "',refused='YES', delivered='" . $main_status . "' " . $cond . " " . $cond1 . " where  slip_no='" . trim($slip_no) . "' ";
        $ci->db->query($update_status_r);

        $update_status = "insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('" . $slip_no . "','" . $ci->session->userdata('adminbranchlocation') . "','" . $main_status . "','" . $CURRENT_TIME . "','" . $CURRENT_DATE . "','" . $Activites . "','" . $details . "','" . $CURRENT_DATE . "','" . $ci->session->userdata('useridadmin') . "','user','" . $comment . "','" . $code . "')";
        $ci->db->query($update_status);
        $update_status1 = "insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('" . $slip_no . "','" . $ci->session->userdata('adminbranchlocation') . "','On Hold','" . $CURRENT_TIME . "','" . $CURRENT_DATE . "','On hold','On Hold due to Under Investigation','" . $CURRENT_DATE . "','" . $ci->session->userdata('useridadmin') . "','user','" . $comment . "','OH')";

        $ci->db->query($siteQry);
    }

}

if (!function_exists('getRoutCode')) {

    function getRoutCode($id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $siteQry = "select routecode from root where status='Y' and deleted='N'and id='" . $id . "' ";
        $query = $ci->db->query($siteQry);
        $routdata = $query->row_array();
        if (!empty($routdata['routecode']))
            return $routdata['routecode'];
        else
            return $id;
    }

}
if (!function_exists('getTotal_pickup')) {

    function getTotal_pickup($id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "select count(id) as total_shipment from pickup where  deleted='N' and drs_unique_id='" . $id . "' ";
        $query = $ci->db->query($sql);
        $total_shipment_data = $query->result_array();
        $total_shipment_post = $total_shipment_data[0]['total_shipment'];
        return $total_shipment_post;
    }

}

function Get_name_country_by_id($fild = null, $cityid = null) {
    $ci = & get_instance();
    $ci->load->database();
    $city_list = "select " . $fild . " from country where (id='" . $cityid . "'  || city='" . $cityid . "'  )";
    $query = $ci->db->query($city_list);
    $citydata = $query->result_array();
    $city_name = $citydata[0][$fild];
    return $city_name;
}

if (!function_exists('getInvoiceNumber')) {

    function getInvoiceNumber($cust_id = null, $field = null, $year_month = null) {
        $ci = & get_instance();
        $ci->load->database();
        $getCustName = "SELECT " . $field . " FROM shipment_invoice_details WHERE user_id='" . $cust_id . "' and  invoice_month_year='" . $year_month . "' and deleted='N'  ";
        $query = $ci->db->query($getCustName);
        $cusNameRun = $query->result_array();
        $customerName = $cusNameRun[0][$field];
        return $customerName;
    }

}
if (!function_exists('messangerData')) {

    function messangerData($id = null) {
        if (!empty($id))
            $condi = "and cor_id='" . $id . "'";
        $ci = & get_instance();
        $ci->load->database();
        $siteQry = "SELECT messenger_code,cor_id,messenger_name,mobile,supplier FROM  `courier_staff` WHERE status='Y'  and deleted='N' $condi";
        $query = $ci->db->query($siteQry);
        $servicedata = $query->result_array();
        return $servicedata;
    }

}

if (!function_exists('driverName')) {

    function driverName($id) {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "SELECT messenger_code,cor_id,messenger_name FROM  `courier_staff` WHERE status='Y'  and deleted='N'";
        $query = $ci->db->query($sql);
        //echo $ci->db->last_query();exit;
        $servicedata = $query->result_array();
        foreach ($servicedata as $key => $val) {


            $drop1 .= $servicedata[$key]['messenger_code'] . '/' . $servicedata[$key]['messenger_name'] . '/' . $servicedata[$key]['cor_id'] . ',';
        }
        return $drop1 = rtrim($drop1, ",");
    }

}
if (!function_exists('line_hule')) {

    function line_hule($id = null) {
        $ci = & get_instance();
        $ci->load->database();

        $siteQry = "select name,id from line_hule where deleted='N' ";
        $query = $ci->db->query($siteQry);
        $result = $query->result_array();
        return $result;
    }

}
if (!function_exists('transist_time')) {

    function transist_time($data = array()) {
        $ci = & get_instance();
        $ci->load->database();
        $qry = "select cutoff,day from transit_time where lid='" . $data['lid'] . "' and zone_to='" . $data['zone_to'] . "' and zone_from='" . $data['zone_from'] . "' ";
        $query = $ci->db->query($qry);
        return $result = $query->row_array();
    }

}
if (!function_exists('getTotal_menifest')) {

    function getTotal_menifest($id = null, $type = null) {
        $ci = & get_instance();
        $ci->load->database();

        $siteQry = "select count(id) as total_shipment from menifest where  deleted='N' and uniqueid='" . $id . "' and arrived='$type' ";
        $query = $ci->db->query($siteQry);
        $total_shipment_data = $query->result_array();

        $total_shipment_post = $total_shipment_data[0]['total_shipment'];
        return $total_shipment_post;
    }

}
if (!function_exists('checkTempDrsToday')) {

    function checkTempDrsToday($messenger_id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $siteQry = "select drs_unique_id from temp_drs where   messanger_id='" . $messenger_id . "'  and deleted='N' and DATE(drs_date)='" . date('Y-m-d') . "'";
        $query = $ci->db->query($siteQry);
        $queryData = $query->row_array();
        if (!empty($queryData['drs_unique_id'])) {
            $drs_unique_code = $queryData['drs_unique_id'];
        } else {
            $drs_unique_code = get_unique_code();
        }

        return $drs_unique_code;
    }

}

if (!function_exists('GetUseraccounTiD')) {

    function GetUseraccounTiD() {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT id FROM customer order by id desc limit 1";
        $query = $ci->db->query($sql);
        $result = $query->row();
        $last_id = $result->id + 1;
        return '100' . $last_id . date('s');
    }

}
if (!function_exists('checkDrsToday')) {

    function checkDrsToday($messenger_id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "select drs_unique_id from drs where   messanger_id='" . $messenger_id . "'  and deleted='N' and DATE(drs_date)='" . date('Y-m-d') . "'";
        $query = $ci->db->query($sql);
        $queryData = $query->row_array();
        if (!empty($queryData['drs_unique_id'])) {
            $drs_unique_code = $queryData['drs_unique_id'];
        } else {
            $drs_unique_code = get_unique_code();
        }

        return $drs_unique_code;
    }

}
if (!function_exists('get_unique_code')) {

    function get_unique_code() {
        $string = 'dfsicjkxcvXSNxmaOZpqxnQDlaciwalaciAghakckUIy1234567890';
        $shuffle = str_shuffle($string);
        $random_chars = substr($shuffle, 0, 6);
        $random_chars2 = substr(str_shuffle('dfsicjkxcvXSNxmaOZpqxnQDlaciwalaciAghakckUIy123456789'), 0, 6);
        return strtoupper($random_chars2);
    }

}

if (!function_exists('GetallitemcheckDuplicate')) {

    function GetallitemcheckDuplicate($sku) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT id FROM items_m where sku='$sku'";
        $query = $ci->db->query($sql);
        $countdata = $query->num_rows();
        $row = $query->row_array();
        if ($countdata > 0)
            return $row['id'];
        else
            return false;
    }

}


if (!function_exists('getallmaincatstatus')) {

    function getallmaincatstatus($id = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT $field FROM status_main_cat where id='$id'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result[$field];
    }

}
if (!function_exists('Getuser_id')) {

    function Getuser_id($status_id = null) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "select cust_id from shipment where slip_no='" . $status_id . "' and deleted='N'";
        $query = $ci->db->Query($sql);
        $statusData = $query->row_array();
        $user_id = $statusData['cust_id'];
        return $user_id;
    }

}

if (!function_exists('GetAllclientLogUpdates')) {

    function GetAllclientLogUpdates($logcount = 0, $updatefield = null, $cust_id = "") {
        $ci = & get_instance();
        $ci->load->database();

        if (!empty($cust_id))
            $cust_id = $cust_id;
        else
            $cust_id = $ci->session->userdata('user_id');
        $matchDate = date("Y-m-d");
        $sql = "select id,$updatefield from shipment_log where client_id='" . $cust_id . "' and DATE(entry_date)='$matchDate'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();

        $date = date("Y-m-d H:i:sa");
        if ($query->num_rows() == 0) {

            $ci->db->query("insert into shipment_log(client_id,$updatefield,entry_date)values('" . $cust_id . "','$logcount','" . $date . "')");
        } else {

            $oldcount2 = $result[$updatefield] + $logcount;
            $ci->db->query("update shipment_log set $updatefield='$oldcount2' where client_id='" . $cust_id . "' and '" . $result['id'] . "'");
        }
    }

}
if (!function_exists('GetAllclientLogUpdates_stutusCat')) {

    function GetAllclientLogUpdates_stutusCat($logcount = 0, $updatefield = null, $cust_id = "") {
        $ci = & get_instance();
        $ci->load->database();

        if (!empty($cust_id))
            $cust_id = $cust_id;
        else
            $cust_id = $ci->session->userdata('user_id');
        $matchDate = date("Y-m-d");
        $sql = "select id,$updatefield from ship_log_status where client_id='" . $cust_id . "' and DATE(entry_date)='$matchDate'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        // print_r($result); die;
        $date = date("Y-m-d H:i:sa");
        if ($query->num_rows() == 0) {

            $insertData = "insert into shipment_log(client_id,$updatefield,entry_date)values('" . $cust_id . "','$logcount','" . $date . "')";
            $ci->db->query($insertData);
        } else {

            $oldcount2 = $result[$updatefield] + $logcount;
            $updateQuery = "update shipment_log set $updatefield='$oldcount2' where client_id='" . $cust_id . "' and '" . $result['id'] . "'";
            $ci->db->query($updateQuery);
        }
    }

}
if (!function_exists('checkPrivilageExitsForCustomer')) {

    function checkPrivilageExitsForCustomer($customer_id = null, $privilage_id = null) {

        $ci = & get_instance();
        $ci->load->database();
        $sql = "select privilage_array from set_user_privilage where customer_id='" . $customer_id . "' ";
        $query = $ci->db->Query($sql);
        $data = $query->row_array();
        $privilage = $data['privilage_array'];

        $privilage_array = explode(',', $privilage);

        if (in_array($privilage_id, $privilage_array)) {
            return true;
        } else {
            return false;
        }
    }

}
/* if(!function_exists('menuIdExitsInPrivilageArray')){
  function menuIdExitsInPrivilageArray($user_id)
  {

  $ci=& get_instance();
  $ci->load->database();
  $sql="select privilage_array from set_user_privilage where customer_id='".$user_id."'";
  $query = $ci->db->query($sql);
  $result=$query->row_array();
  $privielage_array=explode(',',$result['privilage_array']);

  if (in_array($menu_id, $privielage_array))
  $return_value="Y";
  else
  $return_value="N";


  return $return_value;
  }
  } */

if (!function_exists('menuIdExitsInPrivilageArray')) {

    function menuIdExitsInPrivilageArray($menu_id) {

        $ci = & get_instance();
        $ci->load->database();
        $sql = "select privilage_array from set_user_privilage where customer_id='" . $ci->session->userdata('A_ID') . "'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        $privielage_array = explode(',', $result['privilage_array']);
        if ($ci->session->userdata('adminusertype') == 'A') {
            $return_value = "Y";
        } else {
            if (in_array($menu_id, $privielage_array))
                $return_value = "Y";
            else
                $return_value = "N";
        }

        return $return_value;
    }

}


if (!function_exists('getIdfromCityName')) {

    function getIdfromCityName($city) {
        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT id FROM country where deleted='N' and city Like '" . $city . "'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result['id'];
    }

}
if (!function_exists('get_customer_detail')) {

    function get_customer_detail($customer_uid_ac) {

        $ci = & get_instance();
        $ci->load->database();
        $sql = "SELECT id,seller_id,secret_key FROM customer where deleted='N' and uniqueid='" . $customer_uid_ac . "' limit 1";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result;
    }

}
if (!function_exists('generate_hash')) {

    function generate_hash($salt, $password, $algo = 'sha256') {
        return hash($algo, $salt . $password);
    }

    if (!function_exists('barcodeRuntime')) {

        function barcodeRuntime($bar_code_id) {
            // Get pararameters that are passed in through $_GET or set to the default value
            $text = (isset($_GET["text"]) ? $_GET["text"] : $bar_code_id);
            $size = (isset($_GET["size"]) ? $_GET["size"] : "100");
            $orientation = (isset($_GET["orientation"]) ? $_GET["orientation"] : "horizontal");
            $code_type = (isset($_GET["codetype"]) ? $_GET["codetype"] : "code128");
            $code_string = "";

            // Translate the $text into barcode the correct $code_type
            if (strtolower($code_type) == "code128") {
                $chksum = 104;
                // Must not change order of array elements as the checksum depends on the array's key to validate final code
                $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
                $code_keys = array_keys($code_array);
                $code_values = array_flip($code_keys);
                for ($X = 1; $X <= strlen($text); $X++) {
                    $activeKey = substr($text, ($X - 1), 1);
                    $code_string .= $code_array[$activeKey];
                    $chksum = ($chksum + ($code_values[$activeKey] * $X));
                }
                $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

                $code_string = "211214" . $code_string . "2331112";
            } elseif (strtolower($code_type) == "codabar") {
                $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "-", "$", ":", "/", ".", "+", "A", "B", "C", "D");
                $code_array2 = array("1111221", "1112112", "2211111", "1121121", "2111121", "1211112", "1211211", "1221111", "2112111", "1111122", "1112211", "1122111", "2111212", "2121112", "2121211", "1121212", "1122121", "1212112", "1112122", "1112221");

                // Convert to uppercase
                $upper_text = strtoupper($text);

                for ($X = 1; $X <= strlen($upper_text); $X++) {
                    for ($Y = 0; $Y < count($code_array1); $Y++) {
                        if (substr($upper_text, ($X - 1), 1) == $code_array1[$Y])
                            $code_string .= $code_array2[$Y] . "1";
                    }
                }
                $code_string = "11221211" . $code_string . "1122121";
            }

            // Pad the edges of the barcode
            $code_length = 40;
            for ($i = 1; $i <= strlen($code_string); $i++)
                $code_length = $code_length + (integer) (substr($code_string, ($i - 1), 1));

            if (strtolower($orientation) == "horizontal") {
                $img_width = $code_length;
                $img_height = $size;
            } else {
                $img_width = $size;
                $img_height = $code_length;
            }

            $image = imagecreate($img_width, $img_height);
            $black = imagecolorallocate($image, 0, 0, 0);
            $white = imagecolorallocate($image, 255, 255, 255);

            imagefill($image, 0, 0, $white);

            $location = 10;
            for ($position = 1; $position <= strlen($code_string); $position++) {
                $cur_size = $location + ( substr($code_string, ($position - 1), 1) );
                if (strtolower($orientation) == "horizontal")
                    imagefilledrectangle($image, $location, 0, $cur_size, $img_height, ($position % 2 == 0 ? $white : $black));
                else
                    imagefilledrectangle($image, 0, $location, $img_width, $cur_size, ($position % 2 == 0 ? $white : $black));
                $location = $cur_size;
            }

            ob_start();

            imagejpeg($image);
            imagedestroy($image);

            $data = ob_get_contents();

            ob_end_clean();

            $image = "data:image/jpeg;base64," . base64_encode($data);
            return $image;
            // Draw barcode to the screen
            //imagejpeg($image,$path,100);	
            //header ('Content-type: image/png');
            //imagepng($image);
            //imagedestroy($image);
        }

    }
}
if (!function_exists('getsupplierbyid')) {

    function getsupplierbyid($status_id) {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "select name from supplier where id='" . $status_id . "' and deleted='N'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();

        //echo $ci->db->last_query();exit;
        return $result['name'];
    }

}

if (!function_exists('getuserbyid')) {

    function getuserbyid($id) {
        $ci = & get_instance();
        $ci->load->database();

        $sql = "select name from user where id='" . $id . "' and deleted='N'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();

        //echo $ci->db->last_query();exit;  
        return $result['name'];
    }

}

if (!function_exists('checkRoutAssigned')) {

    function checkRoutAssigned($messanger_id, $id) {

        $ci = & get_instance();
        $ci->load->database();

        $sql = "select id as routeid from courier_routing where cor_id='" . $messanger_id . "' and rout='" . $id . "' and deleted='N' ";
        $query = $ci->db->query($sql);
        $result = $query->row_array();

        //echo $ci->db->last_query();exit;

        $routeid = $result['routeid'];

        if (!empty($routeid)) {
            return true;
        } else {
            return false;
        }
    }

}

if (!function_exists('SEND_SMS')) {

    function SEND_SMS($number = null, $message = null) {

        $number = ltrim($number, '966 ');
        $number = ltrim($number, '0');
        $number = '0' . $number;
        $number = str_replace(' ', '', $number);
        $params = array(
            'username' => 'beone', //username used in HQSMS
            'password' => 'beone.147',
            'numbers' => $number, //destination number
            'sender' => "BEONE", //sender name have to be activated
            'message' => ($message),
        );


        $data = '?' . http_build_query($params);
        if ($params['username'] && $params['password'] && $params['numbers'] && $params['message']) {
            $file = fopen('www.safa-sms.com/api/sendsms.php' . $data, 'r');
            $result = fread($file, 1024);
            fclose($file);
            //echo $result;
        }
        return true;
    }

}
if (!function_exists('getcitybyid')) {

    function getcitybyid($status_id = null) {
        $ci = & get_instance();

        $ci->load->database();
        $sql = "select city from country where id='" . $status_id . "' and deleted='N'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        //echo $ci->db->last_query();exit;
        return $result['city'];
    }

}
if (!function_exists('GetCountryNameByid')) {

    function GetCountryNameByid($name = null) {
        $ci = & get_instance();

        $ci->load->database();
        $sql = "select id from country where country='" . $name . "' and deleted='N' and state='' and city=''";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result['id'];
    }

}


if (!function_exists('all_csa_staffs_list')) {

    function all_csa_staffs_list($status) {
        $ci = & get_instance();
        $ci->load->database();
        $cond = " and privilege IN ('CSA')";
        $siteQry = "select id,privilege,name from user where status='Y' and deleted='N' " . $cond;
        $query = $ci->db->query($siteQry);
        return $result = $query->result_array();
    }

}
if (!function_exists('get_agentname')) {

    function get_agentname($id = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();

        $getCustName = "SELECT " . $field . " FROM user WHERE id='" . $id . "' and deleted='N'";
        $query = $ci->db->query($getCustName);
        $cusNameRun = $query->result_array();
        $customerName = $cusNameRun[0][$field];
        return $customerName;
    }

}


if (!function_exists('get_totel_booking_today')) {

    function get_totel_booking_today() {
        $ci = & get_instance();
        $ci->load->database();

        $date = date("Y-m-d 00:00:00");
        $date1 = date("Y-m-d 23:59:59");

        $getCustName = "select count(id) as total_shipment from shipment where entrydate >= '" . $date . "' and  entrydate <= '" . $date1 . "' and deleted='N'";
        $query = $ci->db->query($getCustName);
        $cusNameRun = $query->result_array();
        $customerName = $cusNameRun[0]['total_shipment'];
        return $customerName;
    }

}

if (!function_exists('get_totel_customer_today')) {

    function get_totel_customer_today() {
        $ci = & get_instance();
        $ci->load->database();

        $date = date("Y-m-d");
        $date1 = date("Y-m-d");

        $getCustName = "select count(id) as total_coustomer  from customer where entrydate= '" . $date . "' and deleted='N'";
        $query = $ci->db->query($getCustName);
        //echo $ci->db->last_query();exit;   
        $cusNameRun = $query->result_array();
        return $cusNameRun[0]['total_coustomer'];
        //$total_coustomer=$cusNameRun[$total_coustomer];
        //return $cusNameRun;
    }

}

if (!function_exists('get_totel_payment_today')) {

    function get_totel_payment_today() {
        $ci = & get_instance();
        $ci->load->database();

        $date = date("Y-m-d 00:00:00");
        $date1 = date("Y-m-d 23:59:59");

        $getCustName = "select SUM(amount) as total_payment  from account where entrydate >= '" . $date . "' and  entrydate <= '" . $date1 . "' and paystatus='TRUE'";
        $query = $ci->db->query($getCustName);
        $cusNameRun = $query->result_array();
        return $cusNameRun[0]['total_payment'];
    }

}

if (!function_exists('get_totel_inquries_today')) {

    function get_totel_inquries_today() {
        $ci = & get_instance();
        $ci->load->database();

        $date = date("Y-m-d 00:00:00");
        $date1 = date("Y-m-d 23:59:59");

        $getCustName = "select count(id) as total_customer from contactus where entry_date >='" . $date . "' and entry_date <='" . $date . "' and deleted='N'";
        $query = $ci->db->query($getCustName);
        $cusNameRun = $query->result_array();
        $total_customer = $cusNameRun[0]['total_customer'];
        return $total_customer;
    }

}


if (!function_exists('gettotalValueFromShipment_admin')) {

    function gettotalValueFromShipment_admin($status_slug = null, $current_date = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();

        $current_date_new = '';
        if ($current_date == 1 && ($status_slug != 'pod' && $status_slug != 'return' )) {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(entrydate)='" . $current_date . "' ";
        } else if ($status_slug == 'pod' || $status_slug == 'return') {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(delever_date)='" . $current_date . "' ";
        }
        $total = 0;
        if ($status_slug == 'not-delivered') {
            $main_status = '1';
        } else if ($status_slug == 'not-delivered-other') {
            $main_status = '2';
        } else if ($status_slug == 'on-process') {
            $main_status = '3';
        } else if ($status_slug == 'pick-up-collected') {
            $main_status = '4';
        } else if ($status_slug == 'out-for-delivery') {
            $main_status = '5';
        } else if ($status_slug == 'return') {
            $main_status = '6';
        } else if ($status_slug == 'shelve') {
            $main_status = '7';
        } else if ($status_slug == 'shipment-forward-arrival') {
            $main_status = '8';
        } else if ($status_slug == 'damage-shipment-arrival') {
            $main_status = '9';
        } else if ($status_slug == 'hold-for-pickup') {
            $main_status = '10';
        } else if ($status_slug == 'pod') {
            $main_status = '11';
        } else if ($status_slug == 'booked') {
            $main_status = '12';
        } else if ($status_slug == 'received-inbound') {
            $main_status = '13';
        } else if ($status_slug == 'ready-for-delivery') {
            $main_status = '14';
        } else if ($status_slug == 'general-update') {
            $main_status = '15';
        }
        if ($status_slug != '')
            $status_condition = "and delivered='" . $main_status . "'";

        $status = "select count(id) as $field from shipment where  status='Y' and deleted='N' and delivered='" . $main_status . "' and DATE(entrydate)='" . $current_date . "' ";
        $query = $ci->db->query($status);
        //echo $ci->db->last_query();exit;
        $fetchstatus = $query->row_array();
        return $fetchstatus[$field];
    }

}

if (!function_exists('gettotalValueFromShipment_admin1')) {

    function gettotalValueFromShipment_admin1($status_slug = null, $current_date = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();

        $current_date_new = '';
        if ($current_date == 1 && ($status_slug != 'pod' && $status_slug != 'return' )) {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(entrydate)='" . $current_date . "' ";
        } else if ($status_slug == 'pod' || $status_slug == 'return') {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(delever_date)='" . $current_date . "' ";
        }
        $total = 0;
        if ($status_slug == 'not-delivered') {
            $main_status = '1';
        } else if ($status_slug == 'not-delivered-other') {
            $main_status = '2';
        } else if ($status_slug == 'on-process') {
            $main_status = '3';
        } else if ($status_slug == 'pick-up-collected') {
            $main_status = '4';
        } else if ($status_slug == 'out-for-delivery') {
            $main_status = '5';
        } else if ($status_slug == 'return') {
            $main_status = '6';
        } else if ($status_slug == 'shelve') {
            $main_status = '7';
        } else if ($status_slug == 'shipment-forward-arrival') {
            $main_status = '8';
        } else if ($status_slug == 'damage-shipment-arrival') {
            $main_status = '9';
        } else if ($status_slug == 'hold-for-pickup') {
            $main_status = '10';
        } else if ($status_slug == 'pod') {
            $main_status = '11';
        } else if ($status_slug == 'booked') {
            $main_status = '12';
        } else if ($status_slug == 'received-inbound') {
            $main_status = '13';
        } else if ($status_slug == 'ready-for-delivery') {
            $main_status = '14';
        } else if ($status_slug == 'general-update') {
            $main_status = '15';
        }
        if ($status_slug != '')
            $status_condition = "and delivered='" . $main_status . "'";

        $status = "select count(id) as $field from shipment where  status='Y' and deleted='N' and delivered='" . $main_status . "' and DATE(entrydate)='" . $current_date . "' ";
        $query = $ci->db->query($status);
        //echo $ci->db->last_query();exit;
        $fetchstatus = $query->row_array();
        return $fetchstatus[$field];
    }

}

if (!function_exists('gettotalValueFromShipment_admin2')) {

    function gettotalValueFromShipment_admin2($status_slug = null, $current_date = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();
        $date = date('Y-m-d');
        $current_date_new = '';
        if ($current_date == 1 && ($status_slug != 'pod' && $status_slug != 'return' )) {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(entrydate)='" . $current_date . "' ";
        } else if ($status_slug == 'pod' || $status_slug == 'return') {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(delever_date)='" . $current_date . "' ";
        }
        $total = 0;
        if ($status_slug == 'not-delivered') {
            $main_status = '1';
        } else if ($status_slug == 'not-delivered-other') {
            $main_status = '2';
        } else if ($status_slug == 'on-process') {
            $main_status = '3';
        } else if ($status_slug == 'pick-up-collected') {
            $main_status = '4';
        } else if ($status_slug == 'out-for-delivery') {
            $main_status = '5';
        } else if ($status_slug == 'return') {
            $main_status = '6';
        } else if ($status_slug == 'shelve') {
            $main_status = '7';
        } else if ($status_slug == 'shipment-forward-arrival') {
            $main_status = '8';
        } else if ($status_slug == 'damage-shipment-arrival') {
            $main_status = '9';
        } else if ($status_slug == 'hold-for-pickup') {
            $main_status = '10';
        } else if ($status_slug == 'pod') {
            $main_status = '11';
        } else if ($status_slug == 'booked') {
            $main_status = '12';
        } else if ($status_slug == 'received-inbound') {
            $main_status = '13';
        } else if ($status_slug == 'ready-for-delivery') {
            $main_status = '14';
        } else if ($status_slug == 'general-update') {
            $main_status = '15';
        }
        if ($status_slug != '')
            $status_condition = "and delivered='" . $main_status . "'";

        $status = "select count(id) as $field from shipment where  status='Y' and deleted='N' and delivered='" . $main_status . "' and DATE(entrydate) like '$date%' ";
        $query = $ci->db->query($status);
        //	echo $ci->db->last_query();exit;
        $fetchstatus = $query->row_array();
        return $fetchstatus[$field];
    }

}

if (!function_exists('gettotalValueFromShipment_admin3')) {

    function gettotalValueFromShipment_admin3($status_slug = null, $current_date = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();

        $current_date_new = '';
        if ($current_date == 1 && ($status_slug != 'pod' && $status_slug != 'return' )) {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(entrydate)='" . $current_date . "' ";
        } else if ($status_slug == 'pod' || $status_slug == 'return') {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(delever_date)='" . $current_date . "' ";
        }
        $total = 0;
        if ($status_slug == 'not-delivered') {
            $main_status = '1';
        } else if ($status_slug == 'not-delivered-other') {
            $main_status = '2';
        } else if ($status_slug == 'on-process') {
            $main_status = '3';
        } else if ($status_slug == 'pick-up-collected') {
            $main_status = '4';
        } else if ($status_slug == 'out-for-delivery') {
            $main_status = '5';
        } else if ($status_slug == 'return') {
            $main_status = '6';
        } else if ($status_slug == 'shelve') {
            $main_status = '7';
        } else if ($status_slug == 'shipment-forward-arrival') {
            $main_status = '8';
        } else if ($status_slug == 'damage-shipment-arrival') {
            $main_status = '9';
        } else if ($status_slug == 'hold-for-pickup') {
            $main_status = '10';
        } else if ($status_slug == 'pod') {
            $main_status = '11';
        } else if ($status_slug == 'booked') {
            $main_status = '12';
        } else if ($status_slug == 'received-inbound') {
            $main_status = '13';
        } else if ($status_slug == 'ready-for-delivery') {
            $main_status = '14';
        } else if ($status_slug == 'general-update') {
            $main_status = '15';
        }
        if ($status_slug != '')
            $status_condition = "and delivered='" . $main_status . "'";

        $status = "select count(id) as $field from shipment where  status='Y' and deleted='N' and delivered='" . $main_status . "' and DATE(entrydate)='" . $current_date . "' ";
        $query = $ci->db->query($status);
        //echo $ci->db->last_query();exit;
        $fetchstatus = $query->row_array();
        return $fetchstatus[$field];
    }

}


if (!function_exists('gettotalValueFromShipment_admin4')) {

    function gettotalValueFromShipment_admin4($status_slug = null, $current_date = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();

        $current_date_new = '';
        if ($current_date == 1 && ($status_slug != 'pod' && $status_slug != 'return' )) {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(entrydate)='" . $current_date . "' ";
        } else if ($status_slug == 'pod' || $status_slug == 'return') {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(delever_date)='" . $current_date . "' ";
        }
        $total = 0;
        if ($status_slug == 'not-delivered') {
            $main_status = '1';
        } else if ($status_slug == 'not-delivered-other') {
            $main_status = '2';
        } else if ($status_slug == 'on-process') {
            $main_status = '3';
        } else if ($status_slug == 'pick-up-collected') {
            $main_status = '4';
        } else if ($status_slug == 'out-for-delivery') {
            $main_status = '5';
        } else if ($status_slug == 'return') {
            $main_status = '6';
        } else if ($status_slug == 'shelve') {
            $main_status = '7';
        } else if ($status_slug == 'shipment-forward-arrival') {
            $main_status = '8';
        } else if ($status_slug == 'damage-shipment-arrival') {
            $main_status = '9';
        } else if ($status_slug == 'hold-for-pickup') {
            $main_status = '10';
        } else if ($status_slug == 'pod') {
            $main_status = '11';
        } else if ($status_slug == 'booked') {
            $main_status = '12';
        } else if ($status_slug == 'received-inbound') {
            $main_status = '13';
        } else if ($status_slug == 'ready-for-delivery') {
            $main_status = '14';
        } else if ($status_slug == 'general-update') {
            $main_status = '15';
        }
        if ($status_slug != '')
            $status_condition = "and delivered='" . $main_status . "'";

        $status = "select count(id) as $field from shipment where  status='Y' and deleted='N' and delivered='" . $main_status . "' and DATE(entrydate)='" . $current_date . "' ";
        $query = $ci->db->query($status);
        //echo $ci->db->last_query();exit;
        $fetchstatus = $query->row_array();
        return $fetchstatus[$field];
    }

}


if (!function_exists('gettotalValueFromShipment_admin5')) {

    function gettotalValueFromShipment_admin5($status_slug = null, $current_date = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();

        $current_date_new = '';
        if ($current_date == 1 && ($status_slug != 'pod' && $status_slug != 'return' )) {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(entrydate)='" . $current_date . "' ";
        } else if ($status_slug == 'pod' || $status_slug == 'return') {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(delever_date)='" . $current_date . "' ";
        }
        $total = 0;
        if ($status_slug == 'not-delivered') {
            $main_status = '1';
        } else if ($status_slug == 'not-delivered-other') {
            $main_status = '2';
        } else if ($status_slug == 'on-process') {
            $main_status = '3';
        } else if ($status_slug == 'pick-up-collected') {
            $main_status = '4';
        } else if ($status_slug == 'out-for-delivery') {
            $main_status = '5';
        } else if ($status_slug == 'return') {
            $main_status = '6';
        } else if ($status_slug == 'shelve') {
            $main_status = '7';
        } else if ($status_slug == 'shipment-forward-arrival') {
            $main_status = '8';
        } else if ($status_slug == 'damage-shipment-arrival') {
            $main_status = '9';
        } else if ($status_slug == 'hold-for-pickup') {
            $main_status = '10';
        } else if ($status_slug == 'pod') {
            $main_status = '11';
        } else if ($status_slug == 'booked') {
            $main_status = '12';
        } else if ($status_slug == 'received-inbound') {
            $main_status = '13';
        } else if ($status_slug == 'ready-for-delivery') {
            $main_status = '14';
        } else if ($status_slug == 'general-update') {
            $main_status = '15';
        }
        if ($status_slug != '')
            $status_condition = "and delivered='" . $main_status . "'";

        $status = "select count(id) as $field from shipment where  status='Y' and deleted='N' and delivered='" . $main_status . "' and DATE(entrydate)='" . $current_date . "' ";
        $query = $ci->db->query($status);
        //echo $ci->db->last_query();exit;
        $fetchstatus = $query->row_array();
        return $fetchstatus[$field];
    }

}

if (!function_exists('gettotalValueFromShipment_admin6')) {

    function gettotalValueFromShipment_admin6($status_slug = null, $current_date = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();

        $current_date_new = '';
        if ($current_date == 1 && ($status_slug != 'pod' && $status_slug != 'return' )) {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(entrydate)='" . $current_date . "' ";
        } else if ($status_slug == 'pod' || $status_slug == 'return') {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(delever_date)='" . $current_date . "' ";
        }
        $total = 0;
        if ($status_slug == 'not-delivered') {
            $main_status = '1';
        } else if ($status_slug == 'not-delivered-other') {
            $main_status = '2';
        } else if ($status_slug == 'on-process') {
            $main_status = '3';
        } else if ($status_slug == 'pick-up-collected') {
            $main_status = '4';
        } else if ($status_slug == 'out-for-delivery') {
            $main_status = '5';
        } else if ($status_slug == 'return') {
            $main_status = '6';
        } else if ($status_slug == 'shelve') {
            $main_status = '7';
        } else if ($status_slug == 'shipment-forward-arrival') {
            $main_status = '8';
        } else if ($status_slug == 'damage-shipment-arrival') {
            $main_status = '9';
        } else if ($status_slug == 'hold-for-pickup') {
            $main_status = '10';
        } else if ($status_slug == 'pod') {
            $main_status = '11';
        } else if ($status_slug == 'booked') {
            $main_status = '12';
        } else if ($status_slug == 'received-inbound') {
            $main_status = '13';
        } else if ($status_slug == 'ready-for-delivery') {
            $main_status = '14';
        } else if ($status_slug == 'general-update') {
            $main_status = '15';
        }
        if ($status_slug != '')
            $status_condition = "and delivered='" . $main_status . "'";

        $status = "select count(id) as $field from shipment where  status='Y' and deleted='N' and delivered='" . $main_status . "' and DATE(entrydate)='" . $current_date . "' ";
        $query = $ci->db->query($status);
        //echo $ci->db->last_query();exit;
        $fetchstatus = $query->row_array();
        return $fetchstatus[$field];
    }

}

if (!function_exists('gettotalValueFromShipment_admin7')) {

    function gettotalValueFromShipment_admin7($status_slug = null, $current_date = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();

        $current_date_new = '';
        if ($current_date == 1 && ($status_slug != 'pod' && $status_slug != 'return' )) {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(entrydate)='" . $current_date . "' ";
        } else if ($status_slug == 'pod' || $status_slug == 'return') {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(delever_date)='" . $current_date . "' ";
        }
        $total = 0;
        if ($status_slug == 'not-delivered') {
            $main_status = '1';
        } else if ($status_slug == 'not-delivered-other') {
            $main_status = '2';
        } else if ($status_slug == 'on-process') {
            $main_status = '3';
        } else if ($status_slug == 'pick-up-collected') {
            $main_status = '4';
        } else if ($status_slug == 'out-for-delivery') {
            $main_status = '5';
        } else if ($status_slug == 'return') {
            $main_status = '6';
        } else if ($status_slug == 'shelve') {
            $main_status = '7';
        } else if ($status_slug == 'shipment-forward-arrival') {
            $main_status = '8';
        } else if ($status_slug == 'damage-shipment-arrival') {
            $main_status = '9';
        } else if ($status_slug == 'hold-for-pickup') {
            $main_status = '10';
        } else if ($status_slug == 'pod') {
            $main_status = '11';
        } else if ($status_slug == 'booked') {
            $main_status = '12';
        } else if ($status_slug == 'received-inbound') {
            $main_status = '13';
        } else if ($status_slug == 'ready-for-delivery') {
            $main_status = '14';
        } else if ($status_slug == 'general-update') {
            $main_status = '15';
        }
        if ($status_slug != '')
            $status_condition = "and delivered='" . $main_status . "'";

        $status = "select count(id) as $field from shipment where  status='Y' and deleted='N' and delivered='" . $main_status . "' and DATE(entrydate)='" . $current_date . "' ";
        $query = $ci->db->query($status);
        //echo $ci->db->last_query();exit;
        $fetchstatus = $query->row_array();
        return $fetchstatus[$field];
    }

}

if (!function_exists('gettotalValueFromShipment_admin8')) {

    function gettotalValueFromShipment_admin8($status_slug = null, $current_date = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();

        $current_date_new = '';
        if ($current_date == 1 && ($status_slug != 'pod' && $status_slug != 'return' )) {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(entrydate)='" . $current_date . "' ";
        } else if ($status_slug == 'pod' || $status_slug == 'return') {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(delever_date)='" . $current_date . "' ";
        }
        $total = 0;
        if ($status_slug == 'not-delivered') {
            $main_status = '1';
        } else if ($status_slug == 'not-delivered-other') {
            $main_status = '2';
        } else if ($status_slug == 'on-process') {
            $main_status = '3';
        } else if ($status_slug == 'pick-up-collected') {
            $main_status = '4';
        } else if ($status_slug == 'out-for-delivery') {
            $main_status = '5';
        } else if ($status_slug == 'return') {
            $main_status = '6';
        } else if ($status_slug == 'shelve') {
            $main_status = '7';
        } else if ($status_slug == 'shipment-forward-arrival') {
            $main_status = '8';
        } else if ($status_slug == 'damage-shipment-arrival') {
            $main_status = '9';
        } else if ($status_slug == 'hold-for-pickup') {
            $main_status = '10';
        } else if ($status_slug == 'pod') {
            $main_status = '11';
        } else if ($status_slug == 'booked') {
            $main_status = '12';
        } else if ($status_slug == 'received-inbound') {
            $main_status = '13';
        } else if ($status_slug == 'ready-for-delivery') {
            $main_status = '14';
        } else if ($status_slug == 'general-update') {
            $main_status = '15';
        }
        if ($status_slug != '')
            $status_condition = "and delivered='" . $main_status . "'";

        $status = "select count(id) as $field from shipment where  status='Y' and deleted='N' and delivered='" . $main_status . "' and DATE(entrydate)='" . $current_date . "' ";
        $query = $ci->db->query($status);
        //echo $ci->db->last_query();exit;
        $fetchstatus = $query->row_array();
        return $fetchstatus[$field];
    }

}

if (!function_exists('gettotalValueFromShipment_admin9')) {

    function gettotalValueFromShipment_admin9($status_slug = null, $current_date = null, $field = null) {
        $ci = & get_instance();
        $ci->load->database();

        $current_date_new = '';
        if ($current_date == 1 && ($status_slug != 'pod' && $status_slug != 'return' )) {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(entrydate)='" . $current_date . "' ";
        } else if ($status_slug == 'pod' || $status_slug == 'return') {
            $current_date = date("Y-m-d");
            $current_date_new = "	 and DATE(delever_date)='" . $current_date . "' ";
        }
        $total = 0;
        if ($status_slug == 'not-delivered') {
            $main_status = '1';
        } else if ($status_slug == 'not-delivered-other') {
            $main_status = '2';
        } else if ($status_slug == 'on-process') {
            $main_status = '3';
        } else if ($status_slug == 'pick-up-collected') {
            $main_status = '4';
        } else if ($status_slug == 'out-for-delivery') {
            $main_status = '5';
        } else if ($status_slug == 'return') {
            $main_status = '6';
        } else if ($status_slug == 'shelve') {
            $main_status = '7';
        } else if ($status_slug == 'shipment-forward-arrival') {
            $main_status = '8';
        } else if ($status_slug == 'damage-shipment-arrival') {
            $main_status = '9';
        } else if ($status_slug == 'hold-for-pickup') {
            $main_status = '10';
        } else if ($status_slug == 'pod') {
            $main_status = '11';
        } else if ($status_slug == 'booked') {
            $main_status = '12';
        } else if ($status_slug == 'received-inbound') {
            $main_status = '13';
        } else if ($status_slug == 'ready-for-delivery') {
            $main_status = '14';
        } else if ($status_slug == 'general-update') {
            $main_status = '15';
        }
        if ($status_slug != '')
            $status_condition = "and delivered='" . $main_status . "'";

        $status = "select count(id) as $field from shipment where  status='Y' and deleted='N' and delivered='" . $main_status . "' and DATE(entrydate)='" . $current_date . "' ";
        $query = $ci->db->query($status);
        //echo $ci->db->last_query();exit;
        $fetchstatus = $query->row_array();
        return $fetchstatus[$field];
    }

}

if (!function_exists('lastOfd')) {

    function lastOfd($slip_no = null) {
        $ci = & get_instance();
        $ci->load->database();
        $status = "select  entry_date from status where 	slip_no='" . $slip_no . "' and code='OD' ";
        $query = $ci->db->query($status);
        $fetchstatus = $query->row_array();
        return $fetchstatus['entry_date'];
    }

}
if (!function_exists('getcityidbyid')) {

    function getcityidbyid($status_id) {
        $ci = & get_instance();

        $ci->load->database();
        $sql = "select city as city_id from country where id='" . $status_id . "' and deleted='N'";
        $query = $ci->db->query($sql);
        $result = $query->row_array();
        return $result['city_id'];
    }

}
if (!function_exists('Bar_code_genreter')) {

    function Bar_code_genreter($bar_code_id = null, $path = null) {
        // Get pararameters that are passed in through $_GET or set to the default value
        $text = (isset($_GET["text"]) ? $_GET["text"] : $bar_code_id);
        $size = (isset($_GET["size"]) ? $_GET["size"] : "80");
        $orientation = (isset($_GET["orientation"]) ? $_GET["orientation"] : "horizontal");
        $code_type = (isset($_GET["codetype"]) ? $_GET["codetype"] : "code128");
        $code_string = "";

        // Translate the $text into barcode the correct $code_type
        if (strtolower($code_type) == "code128") {
            $chksum = 104;
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

            $code_string = "211214" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "codabar") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "-", "$", ":", "/", ".", "+", "A", "B", "C", "D");
            $code_array2 = array("1111221", "1112112", "2211111", "1121121", "2111121", "1211112", "1211211", "1221111", "2112111", "1111122", "1112211", "1122111", "2111212", "2121112", "2121211", "1121212", "1122121", "1212112", "1112122", "1112221");

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ($X = 1; $X <= strlen($upper_text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($upper_text, ($X - 1), 1) == $code_array1[$Y])
                        $code_string .= $code_array2[$Y] . "1";
                }
            }
            $code_string = "11221211" . $code_string . "1122121";
        }

        // Pad the edges of the barcode
        $code_length = 40;
        for ($i = 1; $i <= strlen($code_string); $i++)
            $code_length = $code_length + (integer) (substr($code_string, ($i - 1), 1));

        if (strtolower($orientation) == "horizontal") {
            $img_width = $code_length;
            $img_height = $size;
        } else {
            $img_width = $size;
            $img_height = $code_length;
        }

        $image = imagecreate($img_width, $img_height);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);

        imagefill($image, 0, 0, $white);

        $location = 10;
        for ($position = 1; $position <= strlen($code_string); $position++) {
            $cur_size = $location + ( substr($code_string, ($position - 1), 1) );
            if (strtolower($orientation) == "horizontal")
                imagefilledrectangle($image, $location, 0, $cur_size, $img_height, ($position % 2 == 0 ? $white : $black));
            else
                imagefilledrectangle($image, 0, $location, $img_width, $cur_size, ($position % 2 == 0 ? $white : $black));
            $location = $cur_size;
        }
        // Draw barcode to the screen

        imagejpeg($image, $path, 100);
        //header ('Content-type: image/png');
        //imagepng($image);
        //imagedestroy($image);
    }

}

function barcodeRuntimeBig($bar_code_id) {
    // Get pararameters that are passed in through $_GET or set to the default value
    $text = (isset($_GET["text"]) ? $_GET["text"] : $bar_code_id);
    $size = (isset($_GET["size"]) ? $_GET["size"] : "80");
    $orientation = (isset($_GET["orientation"]) ? $_GET["orientation"] : "horizontal");
    $code_type = (isset($_GET["codetype"]) ? $_GET["codetype"] : "code128");
    $code_string = "";

    // Translate the $text into barcode the correct $code_type
    if (strtolower($code_type) == "code128") {
        $chksum = 104;
        // Must not change order of array elements as the checksum depends on the array's key to validate final code
        $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ($X = 1; $X <= strlen($text); $X++) {
            $activeKey = substr($text, ($X - 1), 1);
            $code_string .= $code_array[$activeKey];
            $chksum = ($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

        $code_string = "211214" . $code_string . "2331112";
    } elseif (strtolower($code_type) == "codabar") {
        $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "-", "$", ":", "/", ".", "+", "A", "B", "C", "D");
        $code_array2 = array("1111221", "1112112", "2211111", "1121121", "2111121", "1211112", "1211211", "1221111", "2112111", "1111122", "1112211", "1122111", "2111212", "2121112", "2121211", "1121212", "1122121", "1212112", "1112122", "1112221");

        // Convert to uppercase
        $upper_text = strtoupper($text);

        for ($X = 1; $X <= strlen($upper_text); $X++) {
            for ($Y = 0; $Y < count($code_array1); $Y++) {
                if (substr($upper_text, ($X - 1), 1) == $code_array1[$Y])
                    $code_string .= $code_array2[$Y] . "1";
            }
        }
        $code_string = "11221211" . $code_string . "1122121";
    }

    // Pad the edges of the barcode
    $code_length = 20;
    for ($i = 1; $i <= strlen($code_string); $i++)
        $code_length = $code_length + (integer) (substr($code_string, ($i - 1), 1));

    if (strtolower($orientation) == "horizontal") {
        $img_width = $code_length;
        $img_height = $size;
    } else {
        $img_width = $size;
        $img_height = $code_length;
    }

    $image = imagecreate($img_width, $img_height);
    $black = imagecolorallocate($image, 0, 0, 0);
    $white = imagecolorallocate($image, 255, 255, 255);

    imagefill($image, 0, 0, $white);

    $location = 10;
    for ($position = 1; $position <= strlen($code_string); $position++) {
        $cur_size = $location + ( substr($code_string, ($position - 1), 1) );
        if (strtolower($orientation) == "horizontal")
            imagefilledrectangle($image, $location, 0, $cur_size, $img_height, ($position % 2 == 0 ? $white : $black));
        else
            imagefilledrectangle($image, 0, $location, $img_width, $cur_size, ($position % 2 == 0 ? $white : $black));
        $location = $cur_size;
    }

    ob_start();

    imagejpeg($image);
    imagedestroy($image);

    $data = ob_get_contents();

    ob_end_clean();

    $image = "<img src='data:image/jpeg;base64," . base64_encode($data) . "'>";
    return $image;
    // Draw barcode to the screen
    //imagejpeg($image,$path,100);	
    //header ('Content-type: image/png');
    //imagepng($image);
    //imagedestroy($image);
}

if (!function_exists('encrypt')) {

    function encrypt($pure_string = null) {
        $dirty = array("+", "/", "=");
        $clean = array("_p_", "_s_", "_e_");
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $_SESSION['iv'] = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, '11', utf8_encode($pure_string), MCRYPT_MODE_ECB, $_SESSION['iv']);
        $encrypted_string = base64_encode($encrypted_string);
        return str_replace($dirty, $clean, $encrypted_string);
    }

}

