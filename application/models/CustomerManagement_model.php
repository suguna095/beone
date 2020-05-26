<?php
class CustomerManagement_model extends CI_Model
{
	
	function __construct()  
	{
		parent::__construct();
		
	
	}  
		
	public function getOriginDropData() 
	{
		
		$this->db->select('*'); 
		$this->db->from('country'); 
		$this->db->where("state!=''");
		$this->db->group_by('state');		
		$this->db->where('status','Y'); 
		$this->db->where('deleted','N');
		 $query = $this->db->get();	   
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		} 
	}
	
	public function GetBookingDetailQuery($id=null,$page_no=null)
	{
		$page_no;
          $limit = 50;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
       // $this->db->distinct();   
		$this->db->select('*'); 
		$this->db->from('shipment'); 
        $this->db->where('deleted','N');
		//$this->db->where('delivered in (11,6)');
		$this->db->where('cust_id', $id); 
		//$this->db->order_by('id','DESC');
       //$this->db->limit($limit, $start); 	
	    $this->db->limit($limit, $start); 	
		 $query = $this->db->get();	
  //  echo $this->db->last_query(); die(); 		 
		if($query->num_rows()>0)   
		{
			return $query->result_array();  
		} 
	} 
	
	
	public function DeliverdStatus($main_status=null,$code=null,$Delivered=null)
	{
	$this->db->select('*'); 
		$this->db->from('status_main_cat'); 
        $this->db->where('deleted','N');
		$this->db->where('status','Y');
		$this->db->where('id', $main_status);
		//$this->db->order_by('id','DESC');
       //$this->db->limit($limit, $start); 		
		 $query = $this->db->get();	
    //  echo $this->db->last_query(); 	 
		if($query->num_rows()>0)
		{
			$result= $query->row_array();  
			 return $result['main_status'];
		} 	
	}
	
	public function getShowCustomer($searchfield=null,$page_no)
	{ 
		$page_no;
          $limit = 20;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		 $this->db->select('*');
         $this->db->from('customer');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		 if(!empty($searchfield))
		 {
			$this->db->where("name LIKE '%$searchfield%' or uniqueid LIKE '%$searchfield%' or phone LIKE '%$searchfield%' or email LIKE '%$searchfield%'");
			
		 }
		// $this->db->where('status','Y');
		 $this->db->where('deleted','N');
         $query = $this->db->get();
          ////return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getgetShowCustomerCount($searchfield,$page_no);  
			return $data;
		}
	}
	
	public function getgetShowCustomerCount($searchfield,$page_no)
	{
		 if(!empty($searchfield))
		 {
			$this->db->where('name','uniqueid','phone','email',$searchfield); 
		 }
		   
			$this->db->where('status','Y');
		    $this->db->where('deleted','N');
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('customer');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	

      public function GetExcelCustomer($data=array())
		{
		 $this->db->select('*');
         $this->db->from('customer'); 
         //$this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N'); 
		 $this->db->order_by('id','DESC');
		 //$this->db->where('email', $id);
		
		
         $query = $this->db->get(); 
     //echo $this->db->last_query(); die; 
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		
		}



	public function insertcustomer($data){

           return $this->db->insert('customer',$data);
		//return $this->db->last_query(); die(); 

	}
	public function getcustomerdelete($data=array(),$id=null)
	{
		return $this->db->update('customer',$data,array('id'=>$id));  

	} 
	
	
		public function CheckEmailExist($id=null)
		{
		 $this->db->select('*');
         $this->db->from('customer'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N'); 
		 $this->db->where('email', $id);
		
		
         $query = $this->db->get(); 
     //echo $this->db->last_query(); die; 
		
			return $query->num_rows();
		
		}
	
	public function Getcustomer_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('customer'); 
        // $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
		
		
		public function GetPaymentDetails($data=array())
		{
			if(!empty($data['search_month']) && !empty($data['search_year']))
		   {
			$filter_month=$data['search_month'];
			$filter_year=$data['search_year'];
			$setmonth=$filter_month."-".$filter_year;
			$condition="invoice_month_year='".$setmonth."'";  
			$this->db->where($condition);
		   }
		   
		   	if(!empty($data['search_val']))
		   {
			$this->db->where('invoice_id',$data['search_val']);
			
		   }
			 $this->db->select('*');
			 $this->db->from('shipment_invoice_details'); 
			 $this->db->where('deleted', 'N');
			 $this->db->where('user_id', $data['cusid']);
			
			 $query = $this->db->get();
			// echo $this->db->last_query(); die; 
			  
			if($query->num_rows()>0)
			{
				 return $query->result_array();
			}
		}
		
		
		public function customerUpdate($data=array(),$id=null)  
		{
			return $this->db->update('customer',$data,array('id'=>$id));
			//$this->db->last_query(); die(); 
		}
		public function templateUpdate($data=array(),$id=null)
		{
			return $this->db->update('customer',$data,array('id'=>$id)); 
			$this->db->last_query(); die(); 
		}
		
		
		
		
		
		public function GetAccount($searchfield=null,$page_no)
	{ 
		$page_no;
          $limit = 20;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		 $this->db->select('*');
         $this->db->from('customer');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		 if(!empty($searchfield))
		 {
			$this->db->where("name LIKE '%$searchfield%' or uniqueid LIKE '%$searchfield%' or phone LIKE '%$searchfield%' or email LIKE '%$searchfield%'");
			//$this->db->where('status','Y');
		   // $this->db->where('deleted','N');
		 
		 }
		 
		 
		 else{
			 $this->db->where('id','');
		 }
		 $this->db->where('status','Y');
		    $this->db->where('deleted','N');
         $query = $this->db->get();
          ////return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->GetAccountCount($searchfield,$page_no);  
			return $data;
		}
	}
	
	public function GetAccountCount($searchfield,$page_no) 
	{
		 if(!empty($searchfield))
		 {
			$this->db->where('name','uniqueid','phone','email',$searchfield); 
		 }
		   
			$this->db->where('status','Y');
		    $this->db->where('deleted','N');
			$this->db->select('COUNT(id) as sh_count'); 
			$this->db->from('customer');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	public function Getupdateactivestatus($data=array(),$id=null) 
	{
		return $this->db->update('customer',$data,array('id'=>$id));  
	}
	
	
	public function GetTotalShipment($user_id=null,$invoice_month_year=null) 
	{ 
	if(!empty($user_id))
		 {
		
			$this->db->where("cust_id", $user_id); 
						
		 }
		 if(!empty($invoice_month_year))
		 {
			$this->db->where('year_month_group', $invoice_month_year);
				
		 }	
		 
	$this->db->select('count(id) as totalshipment'); 
	$this->db->from('shipment'); 
	$this->db->where('deleted','N');
	$this->db->where("delivered NOT IN ('1','2') ");

	$query = $this->db->get();	
	//return $this->db->last_query(); die;  	
	if($query->num_rows()>0) 
	{
		 $data=  $query->result_array(); 
	return $data[0]['totalshipment'];			 
	}
	}
	

	
		public function GetMainStatus($delivered=null) 
	{ 

	$this->db->where("id", $delivered); 
		 
	$this->db->select('main_status'); 
	$this->db->from('status_main_cat'); 
	$this->db->where('deleted','N');
	$query = $this->db->get();	
	//return $this->db->last_query(); die;  	
	if($query->num_rows()>0) 
	{
		 $data=  $query->result_array(); 
	return $data[0]['main_status'];			 
	}
	}
	
	
	public function GetTotalCodAmount($user_id=null,$invoice_month_year=null) 
	{ 
	if(!empty($user_id))
		 {
		
			$this->db->where("cust_id", $user_id); 
						
		 }
		 if(!empty($invoice_month_year))
		 {
			$this->db->where('year_month_group', $invoice_month_year);
				
		 }	
		 
	$this->db->select('sum(total_cod_amt) as totalcodamount'); 
	$this->db->from('shipment'); 
	$this->db->where('deleted','N');
	$this->db->where("delivered NOT IN ('1','2','6') ");

	$query = $this->db->get();	
//return $this->db->last_query(); die;  	
	if($query->num_rows()>0) 
	{
		 $data=  $query->result_array(); 
	return $data[0]['totalcodamount'];			 
	}
	}
	
	
	public function getcityname($sender_city=null) 
	{ 
	$this->db->where("id", $sender_city); 
	$this->db->select('city'); 
	$this->db->from('country'); 
	$this->db->where('deleted','N');

	$query = $this->db->get();	
//return $this->db->last_query(); die;  	
	if($query->num_rows()>0) 
	{
		 $data=  $query->result_array(); 
	return $data[0]['city'];			 
	}
	}
	
	
	public function GetCustomerPaymentDetails($data=array()) 
	{ 
	
	       if($data['search_type']!='' || $data['invoice_status']!='')
			{
					//echo "hello"; exit;
					$mode="shipment.mode='".$data['search_type']."' and shipment.delivered='".$data['invoice_status']."' ";	
					$this->db->where($mode);
			}
		   if($data['transfer_status']!='' || $data['transfer_status']!='')
			{ 
					$transfer_status="shipment.cod_paid='".$data['transfer_status']."'";	
					$this->db->where($transfer_status);
			}
			if($data['bt_date1']!='' && $data['bt_date2']!='')
		    {
			$BETWEEN_Date="shipment.entrydate BETWEEN '".$data['bt_date1']."' AND '".$data['bt_date2']."'";
			$this->db->where($BETWEEN_Date);
		    }
	
	        $invoice_id =getInvoiceNumber($data['cusid'],'invoice_id',$data['invoice_month_year']);
	        $this->db->where("shipment_invoice_details.invoice_id ", $invoice_id);
			$this->db->where("shipment.cust_id", $data['cusid']); 
			$this->db->where('shipment.year_month_group', $data['invoice_month_year']);
	        $this->db->select('  shipment.id,shipment.cust_id,shipment.delever_date,shipment.cod_paid,shipment.file_add,shipment.mode,shipment.amount_collected,shipment.total_cod_amt,shipment.slip_no,shipment.entrydate,shipment.booking_mode,shipment.year_month_group,shipment.sender_city,shipment.total_amt,shipment.cod_fees ,shipment.service_charge,shipment.reciever_city,shipment.delivered,shipment.bar_code_number,shipment.reciever_name,shipment_invoice_details.invoice_id,shipment_invoice_details.total_payment,shipment_invoice_details.due_amout,shipment_invoice_details.paid_amount,shipment_invoice_details.invoice_status,shipment_invoice_details.pdf_file,shipment_invoice_details.invoice_id');
			$this->db->from('shipment');
			$this->db->join('shipment_invoice_details', 'shipment_invoice_details.user_id=shipment.cust_id');
			$this->db->where('shipment.deleted','N');
			$this->db->where("shipment.delivered NOT IN ('1','2') ");
			$this->db->where('shipment_invoice_details.deleted','N');
		
			$query = $this->db->get();	
		//echo $this->db->last_query(); 	
			if($query->num_rows()>0) 
			{
				  return $query->result_array(); 
			}
	}
	
	
public function GetSendMail_edit($invoice_id=null) 
		{ 
		 	$this->db->select('  shipment.id,shipment.cust_id,shipment.delever_date,shipment.cod_paid,shipment.file_add,shipment.mode,shipment.amount_collected,shipment.total_cod_amt,shipment.slip_no,shipment.entrydate,shipment.booking_mode,shipment.year_month_group,shipment.sender_city,shipment.total_amt,shipment.cod_fees ,shipment.service_charge,shipment.reciever_city,shipment.delivered,shipment.bar_code_number,shipment.reciever_name,shipment_invoice_details.invoice_id,shipment_invoice_details.total_payment,shipment_invoice_details.due_amout,shipment_invoice_details.paid_amount,shipment_invoice_details.invoice_status,shipment_invoice_details.pdf_file,shipment_invoice_details.invoice_id');
        $this->db->from('shipment');
		$this->db->join('shipment_invoice_details', 'shipment_invoice_details.user_id=shipment.cust_id');
		$this->db->where('shipment.deleted','N');
		$this->db->where("shipment.delivered NOT IN ('1','2') ");
		$this->db->where('shipment_invoice_details.deleted','N');
		 $this->db->where('shipment_invoice_details.invoice_id', $invoice_id);
		
		 
         $query = $this->db->get(); 
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
		public function dataUpdateAddedQry($data){
			$this->db->query($data);
		}
	    
	  public function invoiceDetailsQryData($update_invoice_id=null)
	  {
		  $query=$this->db->query("select total_payment,due_amout,paid_amount from shipment_invoice_details where invoice_id='".$update_invoice_id."' and  deleted='N' ");
		 return  $query->result_array();
	  }
	   public function ShipdatainvociePay($year_month=null,$user_id=null)
	  {
		  $query=$this->db->query("select id,service_charge,total_amt,cod_fees,topay_amount,mode,delivered,reciever_email,sender_email,slip_no from shipment where cust_id='".$user_id."' and amount_collected='N'	and delivered in ('11') and year_month_group='".$year_month."'");
		//echo   $this->db->last_query(); die; 
		 return  $query->result_array();
	  }
	  public function GetratesImportShipDataQry($old_awb_number=null)
	  {
		  $query=$this->db->query("select * from shipment where deleted='N' and slip_no='".$old_awb_number."'");
	  // $this->db->last_query(); 
		 return  $query->result_array();
	  }
	  
	  
	   public function Getzone_price_setDataQry($data=array())
	  {
		  $query=$this->db->query("select * from zone_price_set where carrer_id='0' and cust_id='".$data['cust_id']."' and agent_id='0' and service_id='".$data['sel_service_id']."' and unique_id='".$data['product_type']."' and zone_id_form='".$data['zone_id_form']."' ");
	  // $this->db->last_query(); 
		 return  $query->result_array();
	  }
	   public function Getzone_price_setDataQry_new($data=array(),$zone_id_to=null,$start=null,$end=null)
	  {
		  $query=$this->db->query("select * from zone_price_set where carrer_id='0' and cust_id='".$data['cust_id']."' and agent_id='0' and zone_id_form='".$data['zone_id_form']."' and zone_id_to='".$zone_id_to."'  and service_id='".$data['sel_service_id']."' and start_weight_range='".$start."' and end_weight_range='".$end."' and unique_id='".$data['product_type']."' ");
	  //echo $this->db->last_query(); 
		 return  $query->result_array();
	  }
	   public function Getzone_price_setDataQry_new2($data=array(),$zone_id_to=null,$start=null,$end=null)
	  {
		  $query=$this->db->query("select * from zone_price_set where carrer_id='0' and cust_id='".$data['cust_id']."' and agent_id='0' and zone_id_form='".$data['zone_id_form']."' and zone_id_to='".$zone_id_to."'  and service_id='".$data['sel_service_id']."'  and unique_id='".$data['product_type']."' ");
	  //echo $this->db->last_query(); 
		 return  $query->result_array();
	  }
	  
	   public function GetshowWeightRangeCustomerQry($data=array())
	  {
		  $query=$this->db->query("select id,start_range,end_range from set_weight_range where status='Y' and deleted='N' and unique_id='".$data['product_type']."' and cust_id='".$data['cust_id']."' order by id ASC ");
	  // $this->db->last_query(); 
		 return  $query->result_array();
	  }
	  
	  public function GetweightRangeDetailsPageQry($unique_id=null)
	  {
		  
		  $this->db->select('start_range,end_range');
		  $this->db->from('set_weight_range');
		  $this->db->where('unique_id',$unique_id);
		  $query = $this->db->get(); 
		  return $query->result_array();
	  }
	  public function GetupdateWeightRangeQry($data=array(),$cust_id)
	  {
		  
		  $this->db->delete('set_weight_range',array('cust_id'=>$cust_id));
		  return $this->db->insert_batch('set_weight_range', $data);
	  }
	  public function showZoneDrop() 
		{
			
		 $this->db->select('name,id'); 
         $this->db->from('zone_list'); 
		 $this->db->where('type','C');
		 $this->db->where('deleted','N');
		
		 
		// $this->db->order by('sub_status','ASC') 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
		 public function showserviceDrop() 
		{
			
		 $this->db->select('id,services_name'); 
         $this->db->from('services'); 
		 $this->db->where('s_type','DOM');
		 $this->db->where('deleted','N');
		 $this->db->where('status','Y');
		
		 
		// $this->db->order by('sub_status','ASC') 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
		
		 public function ShowproductTypeDrop() 
		{
			
		 $this->db->select('cat_id,unique_id,cat_name'); 
         $this->db->from('procut_category'); 
		// $this->db->where('s_type','DOM');
		 $this->db->where('deleted','N');
		 $this->db->where('status','Y');
		
		 
		// $this->db->order by('sub_status','ASC') 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
		
		public function GetUpdateCustomerRateByZonesQry($data=array())
		{
			
			
				 $SQL="select * from zone_price_set where cust_id='".$data['cust_id']."' and agent_id='0' and service_id='".$data['sel_service_id']."' and zone_id_form='".$data['zone_id_form']."' and zone_id_to	='".$data['to_zone']."' and unique_id='".$data['product_type']."' and  start_weight_range='".$data['start_range']."' and  end_weight_range='".$data['end_range']."'";
				 $query=$this->db->query($SQL);
			     $userdata=$query->row_array();
				 if($userdata['zone_id_to']==$data['to_zone'])
			     {
					 
					 $update_query="update zone_price_set set price='".$data['value']."' where  cust_id='".$data['cust_id']."' and agent_id='0' and service_id='".$data['sel_service_id']."' and country_id='1' and zone_id_form='".$data['zone_id_form']."' and zone_id_to	='".$data['to_zone']."' and unique_id='".$data['product_type']."' and  start_weight_range='".$data['start_range']."' and  end_weight_range='".$data['end_range']."'"; 
					$this->db->query($update_query);
				 }
				 else
				 {
					   $sql="insert into zone_price_set (service_id, start_weight_range, end_weight_range, price,country_id,zone_id_form,zone_id_to,unique_id,cust_id) values 
				('".$data['sel_service_id']."','".$data['start_range']."','".$data['end_range']."' ,'".$data['value']."', '1','".$data['zone_id_form']."' ,'".$data['to_zone']."' ,'".$data['product_type']."' ,'".$data['cust_id']."')";//exit;
				$this->db->query($sql);
				 }
				 
		}
		
		
		public function GetUpdateCustomerRateByZonesQry_COD($data=array())
		{
			$update_query="update zone_price_set set cod_fees='".$data['value']."' where  cust_id='".$data['cust_id']."' and agent_id='0' and zone_id_form='".$data['zone_id_form']."' and zone_id_to	='".$data['to_zone']."' and service_id='".$data['sel_service_id']."' "; 
					$this->db->query($update_query);
		}
		public function GetUpdateCustomerRateByZonesQry_returnCharge($data=array())
		{
		 $update_query="update zone_price_set set return_fees='".$data['value']."' where  cust_id='".$data['cust_id']."' and agent_id='0' and zone_id_form='".$data['zone_id_form']."' and zone_id_to	='".$data['to_zone']."' and service_id='".$data['sel_service_id']."'"; 
					$this->db->query($update_query);
		}
    
	  
	  
		
}
?>