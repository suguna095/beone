<?php

class ShipmentManagement_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function alllistData($data = array()) {
        $page_no;
        $limit = 100;
        if (empty($data['page_no'])) {
            $start = 0;
        } else {
            $start = ($data['page_no'] - 1) * $limit;
        }

        if (!empty($data['cityorigin'])) {
            $cityorigin = $data['cityorigin'];
            $this->db->where("origin", $cityorigin);
        }

        if (!empty($data['citydestination'])) {
            $destination = $data['citydestination'];
            $this->db->where("destination", $destination);
        }

        if (!empty($data['customer'])) {
            $customer = $data['customer'];
            $this->db->where("cust_id", $customer);
        }
        if (!empty($data['shelve_number'])) {
            $shelve_number = $data['shelve_number'];
            $this->db->where("shelv_no", $shelve_number);
        }

        if (!empty($data['staff'])) {
            $staff = $data['staff'];
            $this->db->where("user_id", $staff);
        }

        if (!empty($data['search_type'])) {
            $search_type = $data['search_type'];
            if (!empty($data['search_val_data'])) {
                if ($search_type == "AWB") {
                    $this->db->where("slip_no", $data['search_val_data']);
                } else if ($search_type == "SN") {
                    $this->db->where("sender_name", $data['search_val_data']);
                } else if ($search_type == "RE") {
                    $this->db->where("reciever_name", $data['search_val_data']);
                } else if ($search_type == "SE") {
                    $this->db->where("sender_phone", $data['search_val_data']);
                } else if ($search_type == "RP") {
                    $this->db->where("reciever_phone", $data['search_val_data']);
                } else if ($search_type == "BN") {
                    $this->db->where("booking_id", $data['search_val_data']);
                } else if ($search_type == "Email") {
                    $this->db->where("sender_email", $data['search_val_data']);
                }
            }
        }
        if (!empty($data['date_type'])) {
            $date_type = $data['date_type'];
            $dateval = $data['date_val_data'];
            if ($date_type == "c_date") {
                $this->db->where("DATE(entrydate) like  '$dateval%' ");
            } else if ($date_type == "m_date") {
                $this->db->where("DATE(entrydate) like  '$dateval%' ");
            } else if ($date_type == "sch_date") {
                $this->db->where("DATE(entrydate) like  '$dateval%' ");
                $this->db->where("schedule_status", 'Y');
                $this->db->where("schedule_type!=", '');
            }
        }
        if (!empty($data['attempt_search'])) {
            $attempt_search = $data['attempt_search'];
            $this->db->where("d_attempt", $attempt_search);
        }
        if (!empty($data['onhold'])) {
            $onhold = $data['onhold'];
            $this->db->where("refused", $onhold);
        }
        if (!empty($data['main_status'])) {
            $main_status = $data['main_status'];
            $this->db->where("delivered", $main_status);
        }
        if (!empty($data['shipmentStatus'])) {
            $shipmentStatus = $data['shipmentStatus'];
            if ($shipmentStatus == "O") {
                $this->db->where("code NOT IN ('POD', 'RTS') ");
            } else if ($shipmentStatus == "C") {
                
            } else if ($shipmentStatus == "OFD") {
                $this->db->where("code IN ('POD', 'RTS') ");
            }
        }

        if (!empty($data['schedule'])) {
            $schedule = $data['schedule'];
            if ($schedule == "N") {
                $this->db->where("schedule_status IN ('', 'N') ");
            } else if ($schedule == "Y") {
                $this->db->where("schedule_status", $schedule);
            }
        }
        if (!empty($data['fwd_th'])) {
            $fwd_th = $data['fwd_th'];
            $this->db->where("frwd_throw", $fwd_th);
        }

        if (!empty($data['bt_date1'])) {

            $this->db->where("DATE(entrydate)", $data["bt_date1"]);
        }
        if (!empty($data['bt_date2'])) {

            $this->db->where("DATE(entrydate)", $data["bt_date2"]);
        }

        $this->db->select('*');
        $this->db->from('shipment');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();

//	echo $this->db->last_query(); die();        
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            $data['count'] = $this->alllistDataCount($data);
            return $data;
        }
    }

    public function alllistDataCount($data = array()) {

        if (!empty($data['cityorigin'])) {
            $cityorigin = $data['cityorigin'];
            $this->db->where("origin", $cityorigin);
        }

        if (!empty($data['citydestination'])) {
            $destination = $data['citydestination'];
            $this->db->where("destination", $destination);
        }

        if (!empty($data['customer'])) {
            $customer = $data['customer'];
            $this->db->where("cust_id", $customer);
        }
        if (!empty($data['shelve_number'])) {
            $shelve_number = $data['shelve_number'];
            $this->db->where("shelv_no", $shelve_number);
        }

        if (!empty($data['staff'])) {
            $staff = $data['staff'];
            $this->db->where("user_id", $staff);
        }

        if (!empty($data['search_type'])) {
            $search_type = $data['search_type'];
            if (!empty($data['search_val_data'])) {
                if ($search_type == "AWB") {
                    $this->db->where("slip_no", $data['search_val_data']);
                } else if ($search_type == "SN") {
                    $this->db->where("sender_name", $data['search_val_data']);
                } else if ($search_type == "RE") {
                    $this->db->where("reciever_name", $data['search_val_data']);
                } else if ($search_type == "SE") {
                    $this->db->where("sender_phone", $data['search_val_data']);
                } else if ($search_type == "RP") {
                    $this->db->where("reciever_phone", $data['search_val_data']);
                } else if ($search_type == "BN") {
                    $this->db->where("booking_id", $data['search_val_data']);
                } else if ($search_type == "Email") {
                    $this->db->where("sender_email", $data['search_val_data']);
                }
            }
        }
        if (!empty($data['date_type'])) {
            $date_type = $data['date_type'];
            $dateval = $data['date_val_data'];
            if ($date_type == "c_date") {
                $this->db->where("DATE(entrydate) like  '$dateval%' ");
            } else if ($date_type == "m_date") {
                $this->db->where("DATE(entrydate) like  '$dateval%' ");
            } else if ($date_type == "sch_date") {
                $this->db->where("DATE(entrydate) like  '$dateval%' ");
                $this->db->where("schedule_status", 'Y');
                $this->db->where("schedule_type!=", '');
            }
        }
        if (!empty($data['attempt_search'])) {
            $attempt_search = $data['attempt_search'];
            $this->db->where("d_attempt", $attempt_search);
        }
        if (!empty($data['onhold'])) {
            $onhold = $data['onhold'];
            $this->db->where("refused", $onhold);
        }
        if (!empty($data['main_status'])) {
            $main_status = $data['main_status'];
            $this->db->where("delivered", $main_status);
        }
        if (!empty($data['shipmentStatus'])) {
            $shipmentStatus = $data['shipmentStatus'];
            if ($shipmentStatus == "O") {
                $this->db->where("code NOT IN ('POD', 'RTS') ");
            } else if ($shipmentStatus == "C") {
                
            } else if ($shipmentStatus == "OFD") {
                $this->db->where("code IN ('POD', 'RTS') ");
            }
        }

        if (!empty($data['schedule'])) {
            $schedule = $data['schedule'];
            if ($schedule == "N") {
                $this->db->where("schedule_status IN ('', 'N') ");
            } else if ($schedule == "Y") {
                $this->db->where("schedule_status", $schedule);
            }
        }
        if (!empty($data['fwd_th'])) {
            $fwd_th = $data['fwd_th'];
            $this->db->where("frwd_throw", $fwd_th);
        }

        if (!empty($data['bt_date1'])) {

            $this->db->where("DATE(entrydate)", $data["bt_date1"]);
        }
        if (!empty($data['bt_date2'])) {

            $this->db->where("DATE(entrydate)", $data["bt_date2"]);
        }
        $this->db->select('COUNT(id) as sh_count');
        $this->db->from('shipment');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            return $data[0]['sh_count'];
        }
        return 0;
    }

    public function gettotalValueFromShipment($status_slug = null, $current_date = null, $cust_id = null) {

        $current_date_new = '';
        if ($current_date == 1) {
            $current_date = date('Y-m-d');
            $current_date_new = " and DATE(entrydate)='" . $current_date . "'";
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

        if ($cust_id != '')
            $customer_chartcondition = " and cust_id='$cust_id'";

        $loginQry = "select count(id) as total_shipment from shipment where delivered='" . $main_status . "' and status='Y' and deleted='N' $customer_chartcondition " . $current_date_new;
        $query = $this->db->query($loginQry);
        $userdata = $query->row_array();
        if (!empty($userdata)) {
            $total = $userdata['total_shipment'];
        }
        return $total;
    }

    public function GetshipmentExportDataaHomeQry() {
        $conft = " and DATE(drs.drs_date)='" . date('Y-m-d') . "'";
        $listingQry = "SELECT drs.messanger_id as courier_id,courier_staff.messenger_name,courier_staff.messenger_code,courier_staff.supplier,drs.city_id FROM courier_staff Left Join drs on  courier_staff.cor_id=drs.messanger_id where drs.deleted='N' " . $conft . " group by drs.messanger_id";

        $query = $this->db->query($listingQry);
        $data = $query->result_array();
        return $data;
    }

    public function getDataFromShipmetMonthWise() {
        $shipemtnQry = "SELECT MONTHNAME(entrydate) AS label,COUNT(DISTINCT id) as y FROM shipment where status='Y' and YEAR(entrydate)='" . date('Y') . "' and deleted='N' $custid_condition GROUP BY label order by MONTH(entrydate) ASC ";
        $query = $this->db->query($shipemtnQry);
        $data = $query->result_array();
        return $data;
    }

    public function allDeletedlistData($data = array()) {
        $page_no;
        $limit = 25;
        if (empty($page_no)) {
            $start = 0;
        } else {
            $start = ($page_no - 1) * $limit;
        }

        if (!empty($data['cityorigin'])) {
            $cityorigin = $data['cityorigin'];
            $this->db->where("origin", $cityorigin);
        }

        if (!empty($data['citydestination'])) {
            $destination = $data['citydestination'];
            $this->db->where("destination", $destination);
        }

        if (!empty($data['customer'])) {
            $customer = $data['customer'];
            $this->db->where("cust_id", $customer);
        }
        if (!empty($data['shelve_number'])) {
            $shelve_number = $data['shelve_number'];
            $this->db->where("shelv_no", $shelve_number);
        }

        if (!empty($data['staff'])) {
            $staff = $data['staff'];
            $this->db->where("user_id", $staff);
        }

        if (!empty($data['search_type'])) {
            $search_type = $data['search_type'];
            if (!empty($data['search_val_data'])) {
                if ($search_type == "AWB") {
                    $this->db->where("slip_no", $data['search_val_data']);
                } else if ($search_type == "SN") {
                    $this->db->where("sender_name", $data['search_val_data']);
                } else if ($search_type == "RE") {
                    $this->db->where("reciever_name", $data['search_val_data']);
                } else if ($search_type == "SE") {
                    $this->db->where("sender_phone", $data['search_val_data']);
                } else if ($search_type == "RP") {
                    $this->db->where("reciever_phone", $data['search_val_data']);
                } else if ($search_type == "BN") {
                    $this->db->where("booking_id", $data['search_val_data']);
                } else if ($search_type == "Email") {
                    $this->db->where("sender_email", $data['search_val_data']);
                }
            }
        }
        if (!empty($data['date_type'])) {
            $date_type = $data['date_type'];
            if ($date_type == "c_date") {
                $this->db->where("DATE(entrydate)", $data['date_val_data']);
            } else if ($date_type == "m_date") {
                $this->db->where("DATE(entrydate)", $data["date_val_data"]);
            } else if ($date_type == "sch_date") {
                $this->db->where("DATE(entrydate)", $data["date_val_data"]);
                $this->db->where("schedule_status", 'Y');
                $this->db->where("schedule_type!=", '');
            }
        }
        if (!empty($data['attempt_search'])) {
            $attempt_search = $data['attempt_search'];
            $this->db->where("d_attempt", $attempt_search);
        }
        if (!empty($data['onhold'])) {
            $onhold = $data['onhold'];
            $this->db->where("refused", $onhold);
        }
        if (!empty($data['main_status'])) {
            $main_status = $data['main_status'];
            $this->db->where("delivered", $main_status);
        }
        if (!empty($data['shipmentStatus'])) {
            $shipmentStatus = $data['shipmentStatus'];
            if ($shipmentStatus == "O") {
                $this->db->where("code NOT IN ('POD', 'RTS') ");
            } else if ($shipmentStatus == "C") {
                
            } else if ($shipmentStatus == "OFD") {
                $this->db->where("code IN ('POD', 'RTS') ");
            }
        }

        if (!empty($data['schedule'])) {
            $schedule = $data['schedule'];
            if ($schedule == "N") {
                $this->db->where("schedule_status IN ('', 'N') ");
            } else if ($schedule == "Y") {
                $this->db->where("schedule_status", $schedule);
            }
        }
        if (!empty($data['fwd_th'])) {
            $fwd_th = $data['fwd_th'];
            $this->db->where("frwd_throw", $fwd_th);
        }

        if (!empty($data['bt_date1'])) {

            $this->db->where("DATE(entrydate)", $data["bt_date1"]);
        }
        if (!empty($data['bt_date2'])) {

            $this->db->where("DATE(entrydate)", $data["bt_date2"]);
        }

        $this->db->select('*');
        $this->db->from('shipment');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'Y');
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();

        // echo $this->db->last_query(); die; 
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            $data['count'] = $this->alllistDeletedDataCount($data);
            return $data;
        }
    }

    public function alllistDeletedDataCount($data = array()) {
        if (!empty($data['cityorigin'])) {
            $cityorigin = $data['cityorigin'];
            $this->db->where("origin", $cityorigin);
        }

        if (!empty($data['citydestination'])) {
            $destination = $data['citydestination'];
            $this->db->where("destination", $destination);
        }

        if (!empty($data['customer'])) {
            $customer = $data['customer'];
            $this->db->where("cust_id", $customer);
        }
        if (!empty($data['shelve_number'])) {
            $shelve_number = $data['shelve_number'];
            $this->db->where("shelv_no", $shelve_number);
        }

        if (!empty($data['staff'])) {
            $staff = $data['staff'];
            $this->db->where("user_id", $staff);
        }

        if (!empty($data['search_type'])) {
            $search_type = $data['search_type'];
            if (!empty($data['search_val_data'])) {
                if ($search_type == "AWB") {
                    $this->db->where("slip_no", $data['search_val_data']);
                } else if ($search_type == "SN") {
                    $this->db->where("sender_name", $data['search_val_data']);
                } else if ($search_type == "RE") {
                    $this->db->where("reciever_name", $data['search_val_data']);
                } else if ($search_type == "SE") {
                    $this->db->where("sender_phone", $data['search_val_data']);
                } else if ($search_type == "RP") {
                    $this->db->where("reciever_phone", $data['search_val_data']);
                } else if ($search_type == "BN") {
                    $this->db->where("booking_id", $data['search_val_data']);
                } else if ($search_type == "Email") {
                    $this->db->where("sender_email", $data['search_val_data']);
                }
            }
        }
        if (!empty($data['date_type'])) {
            $date_type = $data['date_type'];
            if ($date_type == "c_date") {
                $this->db->where("DATE(entrydate)", $data['date_val_data']);
            } else if ($date_type == "m_date") {
                $this->db->where("DATE(entrydate)", $data["date_val_data"]);
            } else if ($date_type == "sch_date") {
                $this->db->where("DATE(entrydate)", $data["date_val_data"]);
                $this->db->where("schedule_status", 'Y');
                $this->db->where("schedule_type!=", '');
            }
        }
        if (!empty($data['attempt_search'])) {
            $attempt_search = $data['attempt_search'];
            $this->db->where("d_attempt", $attempt_search);
        }
        if (!empty($data['onhold'])) {
            $onhold = $data['onhold'];
            $this->db->where("refused", $onhold);
        }
        if (!empty($data['main_status'])) {
            $main_status = $data['main_status'];
            $this->db->where("delivered", $main_status);
        }
        if (!empty($data['shipmentStatus'])) {
            $shipmentStatus = $data['shipmentStatus'];
            if ($shipmentStatus == "O") {
                $this->db->where("code NOT IN ('POD', 'RTS') ");
            } else if ($shipmentStatus == "C") {
                
            } else if ($shipmentStatus == "OFD") {
                $this->db->where("code IN ('POD', 'RTS') ");
            }
        }

        if (!empty($data['schedule'])) {
            $schedule = $data['schedule'];
            if ($schedule == "N") {
                $this->db->where("schedule_status IN ('', 'N') ");
            } else if ($schedule == "Y") {
                $this->db->where("schedule_status", $schedule);
            }
        }
        if (!empty($data['fwd_th'])) {
            $fwd_th = $data['fwd_th'];
            $this->db->where("frwd_throw", $fwd_th);
        }

        if (!empty($data['bt_date1'])) {

            $this->db->where("DATE(entrydate)", $data["bt_date1"]);
        }
        if (!empty($data['bt_date2'])) {

            $this->db->where("DATE(entrydate)", $data["bt_date2"]);
        }
        $this->db->select('COUNT(id) as sh_count');
        $this->db->from('shipment');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'Y');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            return $data[0]['sh_count'];
        }
        return 0;
    }

    public function allArchievelistData($data = array()) {
        $page_no;
        $limit = 25;
        if (empty($page_no)) {
            $start = 0;
        } else {
            $start = ($page_no - 1) * $limit;
        }

        if (!empty($data['origin'])) {
            $this->db->where('origin', $data['origin']);
        }

        if ((!empty($data['from_date'])) && (!empty($data['to_date']))) {
            $this->db->where('delever_date BETWEEN "' . date('Y-m-d', strtotime($data['from_date'])) . '" and "' . date('Y-m-d', strtotime($data['to_date'])) . '"');
        }

        if (!empty($data['user_id'])) {
            $this->db->where('user_id', $data['user_id']);
        }

        if (!empty($data['search_type'])) {
            $search_type = $data['search_type'];
            if (!empty($data['search_val_data'])) {
                if ($search_type == "AWB") {
                    $this->db->where("slip_no", $data['search_val_data']);
                } else if ($search_type == "SN") {
                    $this->db->where("sender_name", $data['search_val_data']);
                } else if ($search_type == "RE") {
                    $this->db->where("reciever_name", $data['search_val_data']);
                }
            }
        }


        if (!empty($data['created_date'])) {
            $this->db->where('entrydate', date('Y-m-d', strtotime($data['created_date'])));
        }


        $this->db->select('*');
        $this->db->from('shipment_archive');
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);



        $query = $this->db->get();
        //echo $this->db->last_query(); die(); 
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            $data['count'] = $this->allArchievelistDataCount($data);
            return $data;
        }
    }

    public function allArchievelistDataCount($data = array()) {

        if (!empty($data['origin'])) {
            $this->db->where('origin', $data['origin']);
        }
        if ((!empty($data['from_date'])) && (!empty($data['to_date']))) {
            $this->db->where('delever_date BETWEEN "' . date('Y-m-d', strtotime($data['from_date'])) . '" and "' . date('Y-m-d', strtotime($data['to_date'])) . '"');
        }

        if (!empty($data['user_id'])) {
            $this->db->where('user_id', $data['user_id']);
        }
        if (!empty($data['search_type'])) {
            $search_type = $data['search_type'];
            if (!empty($search_val_data)) {
                if ($search_type == "AWB") {
                    $this->db->where("slip_no", $data['search_val_data']);
                } else if ($search_type == "SN") {
                    $this->db->where("sender_name", $data['search_val_data']);
                } else if ($search_type == "RE") {
                    $this->db->where("reciever_name", $data['search_val_data']);
                }
            }
        }

        if (!empty($data['created_date'])) {
            $this->db->where('entrydate', date('Y-m-d', strtotime($data['created_date'])));
        }


        $this->db->select('COUNT(id) as sh_count');
        $this->db->from('shipment_archive');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            return $data[0]['sh_count'];
        }
        return 0;
    }

    public function allreadydeliverlistData($data = array()) {
        $page_no;
        $limit = 25;
        if (empty($data['page_no'])) {
            $start = 0;
        } else {
            $start = ($data['page_no'] - 1) * $limit;
        }
        if (!empty($data['search_date']) && !empty($data['search_date1'])) {
            $BETWEEN_Date = "drs_date BETWEEN '" . $data['search_date'] . "' AND '" . $data['search_date1'] . "'";
            $this->db->where($BETWEEN_Date);
        }
        if (!empty($data['city_id'])) {
            $city_id = $data['city_id'];
            $this->db->where("city_id in (select id from country where city='$city_id')");
        }
        if (!empty($data['messanger_id'])) {
            $messanger_id = $data['messanger_id'];
            $this->db->where("messanger_id in (select cor_id from courier_staff where messenger_name='$messanger_id')");
        }

        if (!empty($data['messanger_id1'])) {
            $messanger_id1 = $data['messanger_id1'];
            $this->db->where("messanger_id in (select id from supplier where name='$messanger_id1')");
        }

        if (!empty($data['routecode'])) {
            $routecode = $data['routecode'];
            $this->db->where("routecode", $data['routecode']);
        }

        if (!empty($data['drs_unique_id'])) {
            $routecode = $data['drs_unique_id'];
            $this->db->where("drs_unique_id", $data['drs_unique_id']);
        }

        $this->db->select('*');
        $this->db->from('temp_drs');
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            $data['count'] = $this->allreadydeliverlistDataCount($data);
            return $data;
        }
    }

    public function allreadydeliverlistDataCount($data = array()) {
        $this->db->select('COUNT(id) as sh_count');
        $this->db->from('temp_drs');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            return $data[0]['sh_count'];
        }
        return 0;
    }

    public function GetallreadydrsPritqry($drs_unique_id = null) {
        $query = $this->db->query("select shipment.*,temp_drs . *,courier_staff . * from temp_drs left join shipment on temp_drs.shipment_id=shipment.slip_no left join courier_staff on temp_drs.messanger_id=courier_staff.cor_id where temp_drs.drs_unique_id='" . $drs_unique_id . "' and shipment.status='Y' and shipment.deleted='N' and temp_drs.deleted='N' GROUP by temp_drs.shipment_id order by temp_drs.id");
        return $data = $query->result_array();
    }

    public function allAssignShipmentlistData($data = array()) {

        if ($this->session->userdata('privilege') == 'CSA') {
            $condition = "csa_id='" . trim($this->session->userdata('useridadmin')) . "'";
        } else if ($this->session->userdata('privilege') == 'CSM') {
            $condition = "csm_id='" . trim($this->session->userdata('useridadmin')) . "'";
        } else {
            $condition = "csa_id='" . trim($this->session->userdata('useridadmin')) . "'";
        }
        $date_condition = '';

        if ($data['csa_id'] != '') {
            $condition = "csa_id='" . trim($data['csa_id']) . "'";
        } else {
            $condition = "csm_id='" . trim($this->session->userdata('useridadmin')) . "'";
        }

        if ($data['searchdate'] != '') {
            $date_condition = " and DATE(assign_date)='" . $data['searchdate'] . "'";
        }

        if (!empty($date_condition))
            $this->db->where($date_condition);
        if (!empty($condition))
            $this->db->where($condition);
        $this->db->select('*');
        $this->db->from('assigning_shipment');

        $this->db->where("deleted", 'N');



        $query = $this->db->get();
        //echo $this->db->last_query(); die;

        $data['result'] = $query->result_array();
        return $data;
    }

    public function allAssignShipmentlistDataCount($page_no) {


        $this->db->select('COUNT(id) as sh_count');
        $this->db->from('status');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            return $data[0]['sh_count'];
        }
        return 0;
    }

    public function allCustomerData($data = array()) {
        $page_no;
        $limit = 25;
        if (empty($page_no)) {
            $start = 0;
        } else {
            $start = ($page_no - 1) * $limit;
        }
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            return $data;
        }
    }

    public function GetCityRouteDrop($data = array()) {
        $this->db->select('*');
        $this->db->from('country');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query(); die;   

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function GetSupplistDrop($data = array()) {
        $this->db->select('*');
        $this->db->from('courier_staff');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        //$this->db->order_by('id','desc');
        $query = $this->db->get();
        //echo $this->db->last_query(); die;   

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function GetCustlistDrop($data = array()) {
        $this->db->select('*');
        $this->db->from('supplier');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        //$this->db->order_by('id','desc');
        $query = $this->db->get();
        //echo $this->db->last_query(); die;   

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function GetShipment_edit($id = null) {
        $this->db->select('*');
        $this->db->from('shipment');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->where('id', $id);


        $query = $this->db->get();
        // return $this->db->last_query(); die; 

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function getmessangername($searchText = null) {
        $this->db->select('*');
        $this->db->from('courier_staff');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->where('messenger_code!=', '');
        // $this->db->where("messenger_code like '%".$searchText."%'");  


        $query = $this->db->get();
        //return $this->db->last_query(); die; 

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function getshelvename($searchText = null) {
        $this->db->select('*');
        $this->db->from('warehous_shelve_no');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        // $this->db->where("messenger_code like '%".$searchText."%'");  


        $query = $this->db->get();
        //return $this->db->last_query(); die; 

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function getshipmentdelete($data = array(), $id = null) {
        return $this->db->update('shipment', $data, array('id' => $id));
    }

    public function GetShipment_editStatus($id = null) {
        $this->db->select('*');
        $this->db->from('shipment');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->where('id', $id);


        $query = $this->db->get();
        // return $this->db->last_query(); die; 

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function insertShipment($data = array()) {
        return $this->db->insert('shipment', $data);
    }

    public function insertStatus($data = array()) {
        return $this->db->insert('status', $data);
    }

    public function insertAssignShipment($data = array()) {
        return $this->db->insert('assigning_shipment', $data);
    }

    public function updateEditShipment($data = array(), $id = null) {
        return $this->db->update('shipment', $data, array('id' => $id));
    }

    public function UpdateAddFile($data = array(), $id = null) {
        return $this->db->update('shipment', $data, array('id' => $id));
    }

    public function UpdateBulkUpdateFile($data = array(), $id = null) {
        return $this->db->update('shipment', $data, array('slip_no' => $id));
    }

    public function GetalltemplatesQuery($table_id = null) {
        /// $this->db->where('id',$id);

        $this->db->select('*')->from('msg_template');
        if (!empty($table_id))
            $this->db->where("id", $table_id);
        $query = $this->db->get();
        if (!empty($table_id))
            return $query->row_array();
        else
            return $query->result_array();
    }

    public function Getallcountry() {
        /// $this->db->where('id',$id);
        $this->db->select('*')->from('country');
        $this->db->where('city !=', '');
        $this->db->order_by('city', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCustomerDropData() {

        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function getStaffDropData() {

        $this->db->select('*');
        $this->db->from('courier_staff');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function getStatusDropData() {

        $this->db->select('*');
        $this->db->from('status_main_cat');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->group_by('main_status');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function getOriginDropData() {

        $this->db->select('*');
        $this->db->from('country');
        $this->db->where('city!=', '');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function delete($id = null, $data = array()) {
        return $this->db->update('shipment', $data, array('id' => $id));
    }

    public function GetShipmentData($id = null) {
        $this->db->select('*');
        $this->db->from('shipment');
        $this->db->where("booking_id='$id' or id='$id' or slip_no='$id'");


        $query = $this->db->get();
        // return $this->db->last_query(); die; 

        if ($query->num_rows() > 0) {
            $data = $query->row_array();

            return $data;
        }
    }

    public function alllistData1($data = array()) {

        if (!empty($data['main_status'])) {
            if ($data['statusBy'] == 'LAST') {
                $this->db->where("delivered", $data['main_status']);
            }
        }


        if ($data['shipmentStatus'] == 0) {
            $this->db->where("code NOT IN ('POD', 'RTS') ");
        }


        $this->db->select('*');
        $this->db->from('shipment');


        $query = $this->db->get();
        //echo $this->db->last_query(); die; 

        if ($query->num_rows() > 0) {
            $data = $query->result_array();

            return $data;
        }
    }

    public function GetArchieveData($id = null) {
        $this->db->select('*');
        $this->db->from('shipment_archive');
        $this->db->where("booking_id='$id' or id='$id' or slip_no='$id'");


        $query = $this->db->get();
        // return $this->db->last_query(); die; 

        if ($query->num_rows() > 0) {
            $data = $query->row_array();

            return $data;
        }
    }

    public function GetShipmentstatus($id = null) {
        $this->db->select('*');
        $this->db->from('status');
        $this->db->where('slip_no', $id);


        $query = $this->db->get();
        // return $this->db->last_query(); die;  

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function GetArchievestatus($id = null) {
        $this->db->select('*');
        $this->db->from('status_archive');
        $this->db->where('slip_no', $id);
        $this->db->where('deleted', 'N');

        $query = $this->db->get();
        // return $this->db->last_query(); die;  

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function GetCourierStaff($id = null) {
        $this->db->select('*');
        $this->db->from('courier_staff');
        $this->db->where('cor_id', $id);


        $query = $this->db->get();
        //  $this->db->last_query(); die;  

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function GetstatusShipmentDataQry($slipno = null) {
        $query = $this->db->query("select sender_phone,slip_no,destination,reciever_phone,sender_phone,sender_city,origin,reciever_city,DATE(schedule_date) as  schedule_date,delivered,code,refused,sender_name,schedule_status,booking_id,cust_id,frwd_throw from shipment where deleted='N' and (slip_no='" . $slipno . "' || booking_id='" . $slipno . "' )");
        return $query->result_array();
    }

    public function AddedAssigntableData($slipno = null, $csa_id = null) {
        $this->db->query("insert into assigning_shipment(csa_id,csm_id,slip_no) values ('" . $csa_id . "','" . $this->session->userdata('useridadmin') . "','" . preg_replace('/\s+/', '', trim($slipno)) . "')");
    }

    public function UpdateAssigntableData($slipno = null) {
        $this->db->query("update assigning_shipment set deleted='Y'  where  slip_no='" . $slipno . "' and DATE(assign_date) = '" . date('Y-m-d') . "'");
    }

    public function GetassignmentQryData($slipno = null) {
        $query = $this->db->query("select slip_no from assigning_shipment where deleted='N' and slip_no='" . $slipno . "' and DATE(assign_date) = '" . date('Y-m-d') . "'");
        return $query->result_array();
    }

    public function GetshipemtSchedulingHistory($slipno = null) {

        //$this->db->order_by('desc'); 
        $query = $this->db->query("select * from receiver_location_history where awb_no='$slipno' order By id desc");
        //echo $this->db->last_query(); exit;
        return $query->result_array();
    }

    public function allreadydeliverlistData_details($drs_unique_id = null) {
        $query = $this->db->query("select shipment.*,temp_drs.* from temp_drs left join shipment on temp_drs.shipment_id=shipment.slip_no where  temp_drs.drs_unique_id='" . $drs_unique_id . "' and  shipment.status='Y' and temp_drs.deleted='N' and shipment.deleted='N' $dltype_condition");
        //echo $this->db->last_query(); exit;
        return $query->result_array();
    }

    public function allreadydeliverlistExcelData_details($drs_unique_id = null, $date) {
        $query = $this->db->query("select shipment.*,temp_drs.* from temp_drs left join shipment on temp_drs.shipment_id=shipment.slip_no where entrydate='" . $date . "' and temp_drs.drs_unique_id='" . $drs_unique_id . "' and  shipment.status='Y' and temp_drs.deleted='N' and shipment.deleted='N' $dltype_condition");
        //echo $this->db->last_query(); exit;
        return $query->result_array();
    }

    public function PrintawbFilterShip($pickupId) {
        //print_r($pickupId);
        $this->db->select('*');
        $this->db->from('shipment');

        $this->db->where_in('slip_no', $pickupId);

        $this->db->order_by('shipment.id', 'ASC');
        // $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;


        $data = $query->result_array();

        return $data;
    }

    public function PrintawbFilterShip_new($pickupId) {
        //print_r($pickupId);
        $this->db->select('*');
        $this->db->from('shipment');

        $this->db->where_in('slip_no', $pickupId);

        $this->db->order_by('shipment.id', 'ASC');
        // $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;


        $data = $query->result_array();

        return $data;
    }

    public function PrintArcrchieveawbFilterShip($pickupId) {
        //print_r($pickupId);
        $this->db->select('*');
        $this->db->from('shipment_archive');

        $this->db->where_in('slip_no', $pickupId);

        $this->db->order_by('shipment_archive.id', 'ASC');
        // $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;


        $data = $query->result_array();

        return $data;
    }

    public function showTrackDetails($SlipNosArr) {
        //print_r($pickupId);
        $this->db->select('*');
        $this->db->from('shipment');

        $this->db->where_in('slip_no', $SlipNosArr);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;


        $data = $query->result_array();

        return $data;
    }

    public function find_by_slip_no_for_sku($slip_no) {



        $conditions = array(
            'slip_no' => $slip_no
        );
        $this->db->where($conditions);
        $query = $this->db->get('diamention');
        //echo $this->db->last_query(); exit;      
        if ($query->num_rows() > 0) {

            return $query->result();
        }
    }

    public function alllistData_export($limit = null, $start = null, $data = array()) {
        if (!empty($data['cityorigin'])) {
            $cityorigin = $data['cityorigin'];
            $this->db->where("origin", $cityorigin);
        }

        if (!empty($data['citydestination'])) {
            $destination = $data['citydestination'];
            $this->db->where("destination", $destination);
        }

        if (!empty($data['customer'])) {
            $customer = $data['customer'];
            $this->db->where("cust_id", $customer);
        }
        if (!empty($data['shelve_number'])) {
            $shelve_number = $data['shelve_number'];
            $this->db->where("shelv_no", $shelve_number);
        }

        if (!empty($data['staff'])) {
            $staff = $data['staff'];
            $this->db->where("user_id", $staff);
        }

        if (!empty($data['search_type'])) {
            $search_type = $data['search_type'];
            if (!empty($data['search_val_data'])) {
                if ($search_type == "AWB") {
                    $this->db->where("slip_no", $data['search_val_data']);
                } else if ($search_type == "SN") {
                    $this->db->where("sender_name", $data['search_val_data']);
                } else if ($search_type == "RE") {
                    $this->db->where("reciever_name", $data['search_val_data']);
                } else if ($search_type == "SE") {
                    $this->db->where("sender_phone", $data['search_val_data']);
                } else if ($search_type == "RP") {
                    $this->db->where("reciever_phone", $data['search_val_data']);
                } else if ($search_type == "BN") {
                    $this->db->where("booking_id", $data['search_val_data']);
                } else if ($search_type == "Email") {
                    $this->db->where("sender_email", $data['search_val_data']);
                }
            }
        }
        if (!empty($data['date_type'])) {
            $date_type = $data['date_type'];
            if ($date_type == "c_date") {
                $this->db->where("DATE(entrydate)", $data['date_val_data']);
            } else if ($date_type == "m_date") {
                $this->db->where("DATE(entrydate)", $data["date_val_data"]);
            } else if ($date_type == "sch_date") {
                $this->db->where("DATE(entrydate)", $data["date_val_data"]);
                $this->db->where("schedule_status", 'Y');
                $this->db->where("schedule_type!=", '');
            }
        }
        if (!empty($data['attempt_search'])) {
            $attempt_search = $data['attempt_search'];
            $this->db->where("d_attempt", $attempt_search);
        }
        if (!empty($data['onhold'])) {
            $onhold = $data['onhold'];
            $this->db->where("refused", $onhold);
        }
        if (!empty($data['main_status'])) {
            $main_status = $data['main_status'];
            $this->db->where("delivered", $main_status);
        }
        if (!empty($data['shipmentStatus'])) {
            $shipmentStatus = $data['shipmentStatus'];
            if ($shipmentStatus == "O") {
                $this->db->where("code NOT IN ('POD', 'RTS') ");
            } else if ($shipmentStatus == "C") {
                
            } else if ($shipmentStatus == "OFD") {
                $this->db->where("code IN ('POD', 'RTS') ");
            }
        }

        if (!empty($data['schedule'])) {
            $schedule = $data['schedule'];
            if ($schedule == "N") {
                $this->db->where("schedule_status IN ('', 'N') ");
            } else if ($schedule == "Y") {
                $this->db->where("schedule_status", $schedule);
            }
        }
        if (!empty($data['fwd_th'])) {
            $fwd_th = $data['fwd_th'];
            $this->db->where("frwd_throw", $fwd_th);
        }

        if (!empty($data['bt_date1'])) {

            $this->db->where("DATE(entrydate)", $data["bt_date1"]);
        }
        if (!empty($data['bt_date2'])) {

            $this->db->where("DATE(entrydate)", $data["bt_date2"]);
        }
        $this->db->select('`id`, `refused`, `schedule_status`, `schedule_type`, `code`, `schedule_date`, `time_slot`, `area_street`, `area`, `sub_category`, `booking_id`, `user_id`, `sku`, `uniqueid`, `cust_id`, `service_id`, `shippers_ac_no`, `shippers_ref_no`, `nrd`, `slip_no`, `origin`, `next_station`, `destination`, `pieces`, `weight`, `volumetric_weight`, `sender_name`, `recieved_from`, `sender_address`, `sender_zip`, `sender_phone`, `sender_fax`, `sender_email`, `sender_city`, `reciever_name`, `hand_to`, `reciever_address`, `reciever_zip`, `reciever_phone`, `reciever_fax`, `reciever_email`, `reciever_city`, `receiver_image`, `contents`, `declared_charge`, `service_charge`, `packing_charge`, `service_tax`, `valuation_charges`, `other_charges`, `total_amt`, `booking_mode`, `signature_img`, `mode`, `pickup_time`, `pickup_date`, `expected_date`, `entrydate`, `status_describtion`, `delivered`, `status_comment`, `delevered_to`, `delevered_no`, `delever_date`, `delever_time`, `req_delevery_time`, `status`, `deleted`, `in_meni`, `bar_code_img`, `zip_code_image`, `zip_code_number`, `bar_code_number`, `messanger_id`, `total_cod_amt`, `amount_collected`, `cod_paid`, `year_month_group`, `frwd_throw`, `frwd_awb_no`, `missing`, `menifest_location`, `missing_location`, `product_type`, `user_type`, `topay_amount`, `cod_fees`, `pod_fees`, `pod`, `file_add`, `dest_lng`, `dest_lat`, `shipment_all_city`, `shelv_no`, `client_type`, `d_attempt`, `route_code`, `shipping_zone`, `call_attempt`, `fulfillment`, `onHold_Confirm`, `onHold_Date`, `onHold_Days`, `onHold_Reason`, `rated`');
        $this->db->from('shipment');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->order_by('id', 'desc');
        //$this->db->limit($start, $limit);
        $this->db->limit(100);
        $query = $this->db->get();
       // echo $this->db->last_query();die;
        return $query->result_array();
    }

    public function alllDelistData_export($limit = null, $start = null, $data = array()) {
        if (!empty($data['cityorigin'])) {
            $cityorigin = $data['cityorigin'];
            $this->db->where("origin", $cityorigin);
        }

        if (!empty($data['citydestination'])) {
            $destination = $data['citydestination'];
            $this->db->where("destination", $destination);
        }

        if (!empty($data['customer'])) {
            $customer = $data['customer'];
            $this->db->where("cust_id", $customer);
        }
        if (!empty($data['shelve_number'])) {
            $shelve_number = $data['shelve_number'];
            $this->db->where("shelv_no", $shelve_number);
        }

        if (!empty($data['staff'])) {
            $staff = $data['staff'];
            $this->db->where("user_id", $staff);
        }

        if (!empty($data['search_type'])) {
            $search_type = $data['search_type'];
            if (!empty($data['search_val_data'])) {
                if ($search_type == "AWB") {
                    $this->db->where("slip_no", $data['search_val_data']);
                } else if ($search_type == "SN") {
                    $this->db->where("sender_name", $data['search_val_data']);
                } else if ($search_type == "RE") {
                    $this->db->where("reciever_name", $data['search_val_data']);
                } else if ($search_type == "SE") {
                    $this->db->where("sender_phone", $data['search_val_data']);
                } else if ($search_type == "RP") {
                    $this->db->where("reciever_phone", $data['search_val_data']);
                } else if ($search_type == "BN") {
                    $this->db->where("booking_id", $data['search_val_data']);
                } else if ($search_type == "Email") {
                    $this->db->where("sender_email", $data['search_val_data']);
                }
            }
        }
        if (!empty($data['date_type'])) {
            $date_type = $data['date_type'];
            if ($date_type == "c_date") {
                $this->db->where("DATE(entrydate)", $data['date_val_data']);
            } else if ($date_type == "m_date") {
                $this->db->where("DATE(entrydate)", $data["date_val_data"]);
            } else if ($date_type == "sch_date") {
                $this->db->where("DATE(entrydate)", $data["date_val_data"]);
                $this->db->where("schedule_status", 'Y');
                $this->db->where("schedule_type!=", '');
            }
        }
        if (!empty($data['attempt_search'])) {
            $attempt_search = $data['attempt_search'];
            $this->db->where("d_attempt", $attempt_search);
        }
        if (!empty($data['onhold'])) {
            $onhold = $data['onhold'];
            $this->db->where("refused", $onhold);
        }
        if (!empty($data['main_status'])) {
            $main_status = $data['main_status'];
            $this->db->where("delivered", $main_status);
        }
        if (!empty($data['shipmentStatus'])) {
            $shipmentStatus = $data['shipmentStatus'];
            if ($shipmentStatus == "O") {
                $this->db->where("code NOT IN ('POD', 'RTS') ");
            } else if ($shipmentStatus == "C") {
                
            } else if ($shipmentStatus == "OFD") {
                $this->db->where("code IN ('POD', 'RTS') ");
            }
        }

        if (!empty($data['schedule'])) {
            $schedule = $data['schedule'];
            if ($schedule == "N") {
                $this->db->where("schedule_status IN ('', 'N') ");
            } else if ($schedule == "Y") {
                $this->db->where("schedule_status", $schedule);
            }
        }
        if (!empty($data['fwd_th'])) {
            $fwd_th = $data['fwd_th'];
            $this->db->where("frwd_throw", $fwd_th);
        }

        if (!empty($data['bt_date1'])) {

            $this->db->where("DATE(entrydate)", $data["bt_date1"]);
        }
        if (!empty($data['bt_date2'])) {

            $this->db->where("DATE(entrydate)", $data["bt_date2"]);
        }

        $this->db->select('`id`, `refused`, `schedule_status`, `schedule_type`, `code`, `schedule_date`, `time_slot`, `area_street`, `area`, `sub_category`, `booking_id`, `user_id`, `sku`, `uniqueid`, `cust_id`, `service_id`, `shippers_ac_no`, `shippers_ref_no`, `nrd`, `slip_no`, `origin`, `next_station`, `destination`, `pieces`, `weight`, `volumetric_weight`, `sender_name`, `recieved_from`, `sender_address`, `sender_zip`, `sender_phone`, `sender_fax`, `sender_email`, `sender_city`, `reciever_name`, `hand_to`, `reciever_address`, `reciever_zip`, `reciever_phone`, `reciever_fax`, `reciever_email`, `reciever_city`, `receiver_image`, `contents`, `declared_charge`, `service_charge`, `packing_charge`, `service_tax`, `valuation_charges`, `other_charges`, `total_amt`, `booking_mode`, `signature_img`, `mode`, `pickup_time`, `pickup_date`, `expected_date`, `entrydate`, `status_describtion`, `delivered`, `status_comment`, `delevered_to`, `delevered_no`, `delever_date`, `delever_time`, `req_delevery_time`, `status`, `deleted`, `in_meni`, `bar_code_img`, `zip_code_image`, `zip_code_number`, `bar_code_number`, `messanger_id`, `total_cod_amt`, `amount_collected`, `cod_paid`, `year_month_group`, `frwd_throw`, `frwd_awb_no`, `missing`, `menifest_location`, `missing_location`, `product_type`, `user_type`, `topay_amount`, `cod_fees`, `pod_fees`, `pod`, `file_add`, `dest_lng`, `dest_lat`, `shipment_all_city`, `shelv_no`, `client_type`, `d_attempt`, `route_code`, `shipping_zone`, `call_attempt`, `fulfillment`, `onHold_Confirm`, `onHold_Date`, `onHold_Days`, `onHold_Reason`, `rated`');
        $this->db->from('shipment');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'Y');
        $this->db->order_by('id', 'desc');
        $this->db->limit($start, $limit);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

    public function alllArchistData_export($limit = null, $start = null, $data = array()) {
        if (!empty($data['origin'])) {
            $this->db->where('origin', $data['origin']);
        }

        if ((!empty($data['from_date'])) && (!empty($data['to_date']))) {
            $this->db->where('delever_date BETWEEN "' . date('Y-m-d', strtotime($data['from_date'])) . '" and "' . date('Y-m-d', strtotime($data['to_date'])) . '"');
        }

        if (!empty($data['user_id'])) {
            $this->db->where('user_id', $data['user_id']);
        }

        if (!empty($data['search_type'])) {
            $search_type = $data['search_type'];
            if (!empty($data['search_val_data'])) {
                if ($search_type == "AWB") {
                    $this->db->where("slip_no", $data['search_val_data']);
                } else if ($search_type == "SN") {
                    $this->db->where("sender_name", $data['search_val_data']);
                } else if ($search_type == "RE") {
                    $this->db->where("reciever_name", $data['search_val_data']);
                }
            }
        }


        if (!empty($data['created_date'])) {
            $this->db->where('entrydate', date('Y-m-d', strtotime($data['created_date'])));
        }
        $this->db->select('`id`, `refused`, `schedule_status`, `schedule_type`, `code`, `schedule_date`, `time_slot`, `area_street`, `area`, `sub_category`, `booking_id`, `user_id`, `sku`, `uniqueid`, `cust_id`, `service_id`, `shippers_ac_no`, `shippers_ref_no`, `nrd`, `slip_no`, `origin`, `next_station`, `destination`, `pieces`, `weight`, `volumetric_weight`, `sender_name`, `recieved_from`, `sender_address`, `sender_zip`, `sender_phone`, `sender_fax`, `sender_email`, `sender_city`, `reciever_name`, `hand_to`, `reciever_address`, `reciever_zip`, `reciever_phone`, `reciever_fax`, `reciever_email`, `reciever_city`, `receiver_image`, `contents`, `declared_charge`, `service_charge`, `packing_charge`, `service_tax`, `valuation_charges`, `other_charges`, `total_amt`, `booking_mode`, `signature_img`, `mode`, `pickup_time`, `pickup_date`, `expected_date`, `entrydate`, `status_describtion`, `delivered`, `status_comment`, `delevered_to`, `delevered_no`, `delever_date`, `delever_time`, `req_delevery_time`, `status`, `deleted`, `in_meni`, `bar_code_img`, `zip_code_image`, `zip_code_number`, `bar_code_number`, `messanger_id`, `total_cod_amt`, `amount_collected`, `cod_paid`, `year_month_group`, `frwd_throw`, `frwd_awb_no`, `missing`, `menifest_location`, `missing_location`, `product_type`, `user_type`, `topay_amount`, `cod_fees`, `pod_fees`, `pod`, `file_add`, `dest_lng`, `dest_lat`, `shipment_all_city`, `shelv_no`, `client_type`, `d_attempt`, `route_code`, `shipping_zone`, `call_attempt`, `fulfillment`, `onHold_Confirm`, `onHold_Date`, `onHold_Days`');
        $this->db->from('shipment_archive');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->order_by('id', 'desc');
        $this->db->limit($start, $limit);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

}

?>