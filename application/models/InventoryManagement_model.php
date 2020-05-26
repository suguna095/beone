<?php
class InventoryManagement_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

    }

    public function getviewshelve($data = array())
    {
        $page_no;
        $limit = 20;
        if (empty($data['page_no'])) {
            $start = 0;
        } else {
            $start = ($data['page_no'] - 1) * $limit;
        }

        if (!empty($data['city_id'])) {
			$city_id=$data['city_id'];
            $this->db->where("city_id in (select id from country where city='$city_id')");
        }

        $this->db->select('*');
        $this->db->from('warehous_shelve_no'); 
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);

        $query = $this->db->get();
        //  echo $this->db->last_query(); die;

        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            $data['count']  = $this->getviewshelveCount($data);
            return $data;
        }
    }

    public function getviewshelveCount()
    {

        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->select('COUNT(id) as sh_count');
        $this->db->from('warehous_shelve_no');
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            return $data[0]['sh_count'];
        }
        return 0;
    }
  
  public function ShowExcellist($data = array()) 
  {
	  // $this->db->distinct();
        $this->db->select('*');
        $this->db->from('warehous_shelve_no'); 
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->order_by('id', 'DESC');
       $this->db->group_by('id');  

        $query = $this->db->get(); 
		//echo $this->db->last_query(); die; 
		 if ($query->num_rows() > 0) {
            return $query->result_array();  
        }
  }
  
    public function insertShelve($data = array())
    {
        return $this->db->insert('warehous_shelve_no', $data);
    }

    public function getshelvedelete($data = array(), $id = null)
    {
        return $this->db->update('warehous_shelve_no', $data, array('id' => $id));

    }

    public function Getshelve_edit($id = null)
    {
        $this->db->select('*');
        $this->db->from('warehous_shelve_no');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->where('id', $id);

        $query = $this->db->get();
        // return $this->db->last_query(); die;

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function shelveUpdate($data = array(), $id = null)
    {
        return $this->db->update('warehous_shelve_no', $data, array('id' => $id));
        //return $this->db->last_query(); die;
    }

    public function getviewwarehouse()
    {
        $page_no;
        $limit = 20;
        if (empty($page_no)) {
            $start = 0;
        } else {
            $start = ($page_no - 1) * $limit;
        }
        $this->db->select('*');
        $this->db->from('warehous_shelve');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);

        $query = $this->db->get();
        // return $this->db->last_query(); die;

        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            $data['count']  = $this->getviewwarehouseCount($data);
            return $data;
        }
    }

    public function getviewwarehouseCount()
    {

        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->select('COUNT(id) as sh_count');
        $this->db->from('warehous_shelve');
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            return $data[0]['sh_count'];
        }
        return 0;
    }

    public function getwarehousedelete($data = array(), $id = null)
    {
        return $this->db->update('warehous_shelve', $data, array('id' => $id));

    }

    public function insertLocation($data = array())
    {
        return $this->db->insert('warehous_shelve', $data);
    }

    public function Getlocation_edit($id = null)
    {
        $this->db->select('*');
        $this->db->from('warehous_shelve');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->where('id', $id);

        $query = $this->db->get();
        // return $this->db->last_query(); die;

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function locationUpdate($data = array(), $id = null)
    {
        return $this->db->update('warehous_shelve', $data, array('id' => $id));
        //return $this->db->last_query(); die;
    }

    public function GetCityShelveDrop()
    {

        $this->db->select('*');
        $this->db->from('country');
        $this->db->where("city!=''");
        //$this->db->where('main_status','16');

        // $this->db->order by('sub_status','ASC')

        $query = $this->db->get();
        // return $this->db->last_query(); die;

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function warehous_shelveInsert($data = array())
    {
        $this->db->insert('warehous_shelve', $data);
        return $this->db->insert_id();
    }
    public function warehous_shelve_noInsert($data = array())
    {
        $this->db->insert('warehous_shelve_no', $data);

    }

    public function GetsearchShelveNoPageQry($data = array())
    {
        //$page_no;
        $limit = 20;
        if (empty($data['page_no'])) {
            $start = 0;
        } else {
            $start = ($data['page_no'] - 1) * $limit;
        }
        //print_r($data);
        if (!empty($data['destination'])) {
            $condition .= " and destination = '" . $data['destination'] . "' ";
        }
        if (!empty($data['shelv_no'])) {
            $condition .= " and shelv_no= '" . $data['shelv_no'] . "' ";
        }
        $order_by= "group by shelv_no Order by id DESC ";
        $sql3="select shelv_no,destination,slip_no from shipment  where  deleted='N' and code ='SH' and delivered='7' and shelv_no!='' " . $condition . $order_by;
        //$sql4             = $sql3 . " limit " . $limit . "," . $start;
        $selectStatusdata = $this->db->query($sql3);

		//$view_cou_list_limit = $this->db->query($sql4);
		//echo $this->db->last_query();die;
        $fetchData= $selectStatusdata->result_array();
       
        $shelve_array = array();
        foreach ($fetchData as $key => $value) {
            array_push($shelve_array, $fetchData[$key]['shelv_no']);
        }
		if(!empty($shelve_array))
	    {
        //print_r($shelve_array); die; 
        $this->db->select('shelv_no,destination,slip_no');
        $this->db->from('shipment');
         $this->db->where("code", "SH");
         $this->db->where("delivered", 7);
		// if(!empty($shelve_array))
        $this->db->where_in('shelv_no', $shelve_array1);
        $this->db->order_by('shelv_no');
        $query2 = $this->db->get();
		
  //   echo $this->db->last_query();die;  
        

        $fetchData1= $query2->result_array();
       // print_r($fetchData);
        return array($fetchData1);
		}else
		 return array();
        //return $fetchData
    }

    public function GetShelveDetails($shelv_location = null, $shelv_no = null, $city_id = null)
    {
        $this->db->select('*');
        $this->db->from('warehous_shelve_no');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->where('shelv_location', $shelv_location);
        $this->db->where('shelv_no', $shelv_no);
        $this->db->where('city_id', $city_id);
        $query = $this->db->get();
        // return $this->db->last_query(); die;

        return $query->num_rows();

    }

    public function GetLocationDetails($country_id = null, $shelv_location = null, $city_id = null)
    {
        $this->db->select('*');
        $this->db->from('warehous_shelve');
        $this->db->where('status', 'Y');
        $this->db->where('deleted', 'N');
        $this->db->where('country_id', $country_id);
        $this->db->where('shelv_location', $shelv_location);
        $this->db->where('city_id', $city_id);
        $query = $this->db->get();
        // return $this->db->last_query(); die;

        return $query->num_rows();

    }

    public function gettotalShipmentData($data = array())
    {
        $page_no;
        $limit = 100;
        if (empty($page_no)) {
            $start = 0;
        } else {
            $start = ($page_no - 1) * $limit;
        }

        if (!empty($data['shelv_no'])) {
            $shelv_no = $data['shelv_no'];
            $this->db->where("shelv_no", $shelv_no);

        }

        //$this->db->distinct();
        $this->db->select('`id`,`shelv_no`,`slip_no`,`origin`,`destination`,`delever_time`,`d_attempt`,`call_attempt`,`reciever_city`,`pieces`,`sender_name`,`reciever_name`,`mode`,`booking_mode`,`total_cod_amt`,`delivered`,`client_type`,`cod_fees`,`service_charge`,`code`,`schedule_status`,`schedule_type`,`dest_lat`,`dest_lng`,`refused`,`messanger_id`,`schedule_date`,`weight`');
        $this->db->from('shipment');
        $this->db->where("code", 'SH');
        $this->db->where("delivered", '7');
        $this->db->where("deleted", 'N');
        $this->db->limit($limit, $start);
        $query = $this->db->get();

        // echo $this->db->last_query(); die;

        if ($query->num_rows() > 0) {
            $data['result'] = $query->result_array();
            return $data;
        }
    }

}
