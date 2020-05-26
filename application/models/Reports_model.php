<?php

class Reports_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getSupplierDropData() {

        $this->db->select('*');
        $this->db->from('supplier');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function getOriginDropData() {
        $this->db->distinct();
        $this->db->select('city');
        $this->db->from('country');
        $this->db->where('status', 'Y');
        $this->db->where("city!=''");
        $this->db->where('deleted', 'N');
        $this->db->group_by('city');
        $query = $this->db->get();
//echo $this->db->last_query(); die;	 
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function allTransactionReportData($data = array()) {
        $page_no;
        $limit = 100;
        if (empty($data['page_no'])) {
            $start = 0;
        } else {
            $start = ($data['page_no'] - 1) * $limit;
        }

        if (!empty($data['city_id'])) {
            $city_id = $data['city_id'];
            $this->db->where("shipment.destination in (select id from country where city='$city_id')");
        }

        if (!empty($data['main_status'])) {
            if ($data['main_status'] == 11) {
                $this->db->where("drs.delivery_status", 'Y');
            } else {
                $this->db->where("drs.delivery_status", 'N');
            }
        }

        if ((!empty($data['start_date'])) && (!empty($data['end_date']))) {
            $this->db->where('drs.drs_date BETWEEN "' . date('Y-m-d', strtotime($data['start_date'])) . '" and "' . date('Y-m-d', strtotime($data['end_date'])) . '"');
        }


        $this->db->select('drs.shipment_id as slip_no,DATE(drs.drs_date) as status_date,drs.delivery_status,drs.messanger_id,drs.rto_datetime,shipment.booking_id,shipment.origin,shipment.reciever_city,shipment.reciever_name,shipment.reciever_address,shipment.reciever_phone,shipment.mode,shipment.total_cod_amt,shipment.cod_fees,shipment.service_charge,shipment.schedule_status,shipment.refused,shipment.shelv_no,shipment.cust_id,shipment.schedule_date,shipment.schedule_type,shipment.area,shipment.area_street,shipment.time_slot,shipment.dest_lng,shipment.dest_lat');
        $this->db->from('shipment');
        $this->db->join('drs', 'drs.shipment_id=shipment.slip_no');
        $this->db->where('drs.deleted', 'N');
        $this->db->where('drs.delivered', 'Y');
        $this->db->limit($limit, $start);
        $query = $this->db->get();

        //echo $this->db->last_query(); die; 
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            $data['count'] = $this->allTransactionCount($data);
            return $data;
        }
    }

    public function allTransactionCount($data = array()) {
        if (!empty($data['city_id'])) {
            $city_id = $data['city_id'];
            $this->db->where("shipment.destination in (select id from country where city='$city_id')");
        }

        if (!empty($data['main_status'])) {
            if ($data['main_status'] == 11) {
                $this->db->where("drs.delivery_status", 'Y');
            } else {
                $this->db->where("drs.delivery_status", 'N');
            }
        }

        if ((!empty($data['start_date'])) && (!empty($data['end_date']))) {
            $this->db->where('drs.drs_date BETWEEN "' . date('Y-m-d', strtotime($data['start_date'])) . '" and "' . date('Y-m-d', strtotime($data['end_date'])) . '"');
        }

        $this->db->select('COUNT(shipment.id) as sh_count');
        $this->db->from('shipment');
        $this->db->join('drs', 'drs.shipment_id=shipment.slip_no');
        $this->db->where('drs.deleted', 'N');
        $this->db->where('drs.delivered', 'Y');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            return $data[0]['sh_count'];
        }
        return 0;
    }

    public function allTransactionReportDataExcel() {

        $this->db->select('drs.shipment_id as slip_no,DATE(drs.drs_date) as status_date,drs.delivery_status,drs.messanger_id,drs.rto_datetime,shipment.booking_id,shipment.origin,shipment.reciever_city,shipment.reciever_name,shipment.reciever_address,shipment.reciever_phone,shipment.mode,shipment.total_cod_amt,shipment.cod_fees,shipment.service_charge,shipment.schedule_status,shipment.refused,shipment.shelv_no,shipment.cust_id,shipment.schedule_date,shipment.schedule_type,shipment.area,shipment.area_street,shipment.time_slot,shipment.dest_lng,shipment.dest_lat');
        $this->db->from('shipment');
        $this->db->join('drs', 'drs.shipment_id=shipment.slip_no');
        $this->db->where('drs.deleted', 'N');
        $this->db->where('drs.delivered', 'Y');
        //$this->db->limit($limit, $start);
        $query = $this->db->get();

        // echo $this->db->last_query(); die; 
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();

            return $data;
        }
    }

    public function allOnHoldReportData($data = array()) {
        $page_no;
        $limit = 100;
        if (empty($data['page_no'])) {
            $start = 0;
        } else {
            $start = ($data['page_no'] - 1) * $limit;
        }

        if (!empty($data['main_status'])) {
            $this->db->where("status.code", $data['main_status']);
        }

        if (!empty($data['start_date'])) {
            $this->db->where('status.entry_date', date('Y-m-d', strtotime($data['start_date'])));
        }


        $this->db->select('shipment.*,status.new_status,status.Activites,status.Details,status.comment,status.entry_date as status_date,status.user_id as u_id,status.user_type as u_type');
        $this->db->from('shipment');
        $this->db->join('status', 'status.slip_no=shipment.slip_no');
        $this->db->where('shipment.deleted', 'N');
        $this->db->limit($limit, $start);
        $query = $this->db->get();

        //echo $this->db->last_query(); die; 
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            $data['count'] = $this->allHoldReportCount($data);
            return $data;
        }
    }

    public function allHoldReportCount($data = array()) {

        if (!empty($data['main_status'])) {
            $this->db->where("status.code", $data['main_status']);
        }

        if (!empty($data['start_date'])) {
            $this->db->where('status.entry_date', date('Y-m-d', strtotime($data['start_date'])));
        }

        $this->db->select('COUNT(shipment.id) as sh_count');
        $this->db->from('shipment');
        $this->db->join('status', 'shipment.slip_no=status.slip_no');
        $this->db->where('shipment.deleted', 'N');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            return $data[0]['sh_count'];
        }
        return 0;
    }

    public function GetCustomerDetails($id = null) {
        $this->db->select('customer.company , shipment_paid_amount_details.invoice_id,shipment_paid_amount_details.paid_amount,shipment_paid_amount_details.payment_mode,payment_comment,shipment_paid_amount_details.paid_date');
        $this->db->from('shipment_paid_amount_details');
        $this->db->join('customer', 'customer.id=shipment_paid_amount_details.user_id');
        $this->db->where('shipment_paid_amount_details.deleted', 'N');
        $this->db->where('customer.id', $id);
        $query = $this->db->get();
        //echo $this->db->last_query(); die; 
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function GetPaymentReportDetails($data = array()) {
        
        if ((!empty($data['start_date'])) && (!empty($data['end_date']))) {
            $this->db->where('shipment_paid_amount_details.paid_date BETWEEN "' . date('Y-m-d', strtotime($data['start_date'])) . '" and "' . date('Y-m-d', strtotime($data['end_date'])) . '"');
        }


        $this->db->select('customer.company , shipment_paid_amount_details.invoice_id,shipment_paid_amount_details.paid_amount,shipment_paid_amount_details.payment_mode,payment_comment,shipment_paid_amount_details.paid_date');
        $this->db->from('shipment_paid_amount_details');
        $this->db->join('customer', 'customer.id=shipment_paid_amount_details.user_id');
        $this->db->where('shipment_paid_amount_details.deleted', 'N');
         $query = $this->db->get();
       
        //echo $this->db->last_query();
        //die;
        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            return $data;
        }
    }

}

?>