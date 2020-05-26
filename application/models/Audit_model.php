<?php
class Audit_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
	
		
     public function getviewreason($searchfield=null,$page_no)
	{ 
		$page_no;
          $limit = 20;
        if(empty($page_no))
		{
            $start = 0;
        }
		else
		{
         $start = ($page_no-1)*$limit;
		}
		 $this->db->select('*');
         $this->db->from('add_reasion');
          $this->db->where('delete_status', 'N'); 
		
		 $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getviewreasonCount($searchfield=null,$page_no);  
			return $data;
		}
	}
	
	public function getviewreasonCount($searchfield=null,$page_no)
	{
		   
			//$this->db->where('delete_status', 'N');
			
			$this->db->select('COUNT(id) as sh_count');
			 $this->db->from('add_reasion');
			 $this->db->where('delete_status', 'N'); 
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
		
	public function getviewreasonExcel()
	{
		 $this->db->select('*');
         $this->db->from('add_reasion');
          $this->db->where('delete_status', 'N'); 
		
		 $this->db->order_by('id','DESC'); 
		 $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
	}
		
	public function InsertReason($data=array())
	{
		return $this->db->insert('add_reasion',$data);
		 
		 // $this->db->last_query(); die;
		
	}
	
	public function getreasondelete($data=array(),$id=null)
	{
		return $this->db->update('add_reasion',$data,array('id'=>$id));  

	} 
	
	public function Getreasonlist_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('add_reasion');
         
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
		
		public function ReasonUpdate($data=array(),$id=null)
		{
			return $this->db->update('add_reasion',$data,array('id'=>$id));   
			//return $this->db->last_query(); die; 
		}
		
		 public function getviewaudit($data=array(),$page_no)
	{ 
		
		 $page_no;
          $limit = 50;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        } 
		
		 if(!empty($data['destination']))
		 {
			$destination=$data['destination']; 
			$this->db->where("destination", $destination); 
						
		 }
		 if(!empty($data['audit_status']))
		 {
			$audit_status=$data['audit_status']; 
			$this->db->where("audit_comment", $audit_status); 
						
		 }
		 if(!empty($data['slip_no']))
		 {
			$slip_no=$data['slip_no']; 
			$this->db->where("slip_no", $slip_no); 
						
		 }
		if(!empty($data['hub'])) 
		 {
			$hub=$data['hub']; 
			$this->db->where('destination in (select id from country where state="'.$hub.'")'); 
		 }
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('entry_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 } 
		 
		 $this->db->select('*');
         $this->db->from('audit');
         $this->db->where('id>=', '1'); 
		$this->db->where("shipment_status IN  ('RF','WAR','COP','DO','CNI','RFD','RSD','MC','NA','CNL','RF','CNAD','COP','MW','DO','CNC')");
		 $this->db->order_by('entry_date','DESC');
		 $this->db->limit($limit, $start); 
		  $query = $this->db->get();
		  
	//echo  $this->db->last_query(); die;
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getviewauditCount($data,$page_no);  
			return $data;
		}
	}
	
	public function getviewauditCount($data=array(),$page_no)
	{
		 if(!empty($data['destination']))
		 {
			$destination=$data['destination']; 
			$this->db->where("destination", $destination); 
						
		 }
		 if(!empty($data['audit_status']))
		 {
			$audit_status=$data['audit_status']; 
			$this->db->where("audit_comment", $audit_status); 
						
		 }
		 if(!empty($data['slip_no']))
		 {
			$slip_no=$data['slip_no']; 
			$this->db->where("slip_no", $slip_no); 
						
		 }
		 if(!empty($data['hub']))
		 {
			$hub=$data['hub']; 
			$this->db->where('destination in (select id from country where state="'.$hub.'")');
		 }
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('entry_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
			
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('audit');
			$this->db->where('id>=', '1'); 
			$this->db->where("shipment_status IN  ('RF','WAR','COP','DO','CNI','RFD','RSD','MC','NA','CNL','RF','CNAD','COP','MW','DO','CNC')");
			 $this->db->order_by('entry_date','DESC'); 
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
		
		
		 public function getviewCSaudit($data=array(),$page_no)
	{ 
		$page_no;
          $limit = 50;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        } 
		
		 if(!empty($data['destination']))
		 {
			$destination=$data['destination']; 
			$this->db->where("destination", $destination); 
						
		 }
		 if(!empty($data['audit_status']))
		 {
			$audit_status=$data['audit_status']; 
			$this->db->where("audit_status", $audit_status); 
						
		 }
		 if(!empty($data['slip_no']))
		 {
			$slip_no=$data['slip_no']; 
			$this->db->where("slip_no", $slip_no); 
						
		 }
		if(!empty($data['hub']))
		 {
			$hub=$data['hub']; 
			$this->db->where('destination in (select id from country where state="'.$hub.'")');
		 }
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('entry_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 
		 $this->db->select('*');
         $this->db->from('audit');
         $this->db->where('audit_status!=', 'N'); 
		 $this->db->where("shipment_status IN  ('WAR','CNI','RFD','RSD','RSP','OCA')"); 
		 $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getviewCSauditCount($data);  
			return $data;
		}
	}
	
	public function getviewCSauditCount($data=array()) 
	{
		   
			if(!empty($data['destination']))
		 {
			$destination=$data['destination']; 
			$this->db->where("destination", $destination); 
						
		 }
		 if(!empty($data['audit_status']))
		 {
			$audit_status=$data['audit_status']; 
			$this->db->where("audit_status", $audit_status); 
						
		 }
		 if(!empty($data['slip_no']))
		 {
			$slip_no=$data['slip_no']; 
			$this->db->where("slip_no", $slip_no); 
						
		 }
		if(!empty($data['hub']))
		 {
			$hub=$data['hub']; 
			$this->db->where('destination in (select id from country where state="'.$hub.'")');
		 }
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('entry_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
			
			$this->db->select('COUNT(id) as sh_count');
			 $this->db->from('audit');
			 $this->db->where('audit_status!=', 'N'); 
			$this->db->where("shipment_status IN  ('WAR','CNI','RFD','RSD','RSP','OCA')");
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}	
	
		
		 public function getviewOPaudit($data=array(),$page_no)
	{ 
		$page_no;
          $limit = 50;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        } 
		
		 if(!empty($data['destination']))
		 {
			$destination=$data['destination']; 
			$this->db->where("destination", $destination); 
		 }
		 if(!empty($data['audit_status']))
		 {
			$audit_status=$data['audit_status']; 
			$this->db->where("audit_status", $audit_status); 
						
		 }
		 if(!empty($data['slip_no']))
		 {
			$slip_no=$data['slip_no']; 
			$this->db->where("slip_no", $slip_no); 
						
		 }
		 if(!empty($data['hub']))
		 {
			$hub=$data['hub']; 
			$this->db->where('origin in (select id from country where state="'.$hub.'")');
		 }
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('DATE(entry_date) BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 
		 
		 $this->db->select('*');
         $this->db->from('audit');
         $this->db->where('audit_status!=', 'N'); 
		 $this->db->where("shipment_status IN  ('MC','NA','CNL','RF','CNAD','COP','MW','DO','CNC')"); 
		 $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		
		
		
         $query = $this->db->get();
		 //echo $data; die();
		//echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getviewOPauditCount($data);  
			return $data;
		}
	}
	
	public function getviewOPauditCount($data=array()) 
	{
		  if(!empty($data['destination']))
		 {
			$destination=$data['destination']; 
			$this->db->where("destination", $destination); 
						
		 }
		 if(!empty($data['audit_status']))
		 {
			$audit_status=$data['audit_status']; 
			$this->db->where("audit_status", $audit_status); 
						
		 }
		 if(!empty($data['slip_no']))
		 {
			$slip_no=$data['slip_no']; 
			$this->db->where("slip_no", $slip_no); 
						
		 }
		 if(!empty($data['hub']))
		 {
			$hub=$data['hub']; 
			$this->db->where('origin in (select id from country where state="'.$hub.'")');
		 }
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('DATE(entry_date) BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
			
			$this->db->select('COUNT(id) as sh_count');
			 $this->db->from('audit');
			 $this->db->where('audit_status!=', 'N');   
			$this->db->where("shipment_status IN  ('MC','NA','CNL','RF','CNAD','COP','MW','DO','CNC')"); 
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}	
	
	public function showstatusDrop($data=array())
		{
		 $this->db->select('comment');
         $this->db->from('add_reasion'); 
         $this->db->where('audit_status', $data['astatus']);
		 $this->db->where('audit_type', $data['id']);
		 $this->db->where('delete_status', 'N');
		
		
         $query = $this->db->get();
     // echo $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		}
	
	public function showstatusListDrop($data=array())
		{
		 $this->db->select('comment');
         $this->db->from('add_reasion'); 
        
		 $this->db->where('delete_status', 'N');
		
		
         $query = $this->db->get();
         // echo $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		}
	
public function totalCityList($hub=null)
		{
		 $this->db->select('city');
         $this->db->from('country'); 
         $this->db->where('state',$hub);
		
		
         $query = $this->db->get();
        //echo $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data=  $query->result_array(); 
			$i=0;
			for($i=0;$i<sizeof($data);$i++)
			{
				$cityList[$i]['city'] = $data[$i]['city'];
			}
			return $cityList ; 
		}
		}
		
		
	public function total_pending($data=array())
	{ 
	
		 if(!empty($data['destination']))
		 {
			$destination=$data['destination']; 
			$this->db->where("destination", $destination); 
						
		 }
		 if(!empty($data['audit_status']))
		 {
			$audit_status=$data['audit_status']; 
			$this->db->where("audit_status", $audit_status); 
						
		 }
		 if(!empty($data['slip_no']))
		 {
			$slip_no=$data['slip_no']; 
			$this->db->where("slip_no", $slip_no); 
						
		 }
		 if(!empty($data['hub']))
		 {
			$hub=$data['hub']; 
			$this->db->where('destination in (select id from country where state="'.$hub.'")');
		 }
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('entry_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 
		 
		 $this->db->select('count(id) as total_pending');
         $this->db->from('audit');
         $this->db->where('audit_status', ''); 
		 $this->db->where("shipment_status IN  ('MC','NA','CNL','RF','CNAD','COP','MW','DO','CNC')"); 
		
		
         $query = $this->db->get();
   // echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data=  $query->result_array(); 
			return $data[0]['total_pending'];
		}
	}
	
	public function total_complete($data=array())
	{ 
	
		 if(!empty($data['destination']))
		 {
			$destination=$data['destination']; 
			$this->db->where("destination", $destination); 
						
		 }
		 if(!empty($data['audit_status']))
		 {
			$audit_status=$data['audit_status']; 
			$this->db->where("audit_status", $audit_status); 
						
		 }
		 if(!empty($data['slip_no']))
		 {
			$slip_no=$data['slip_no']; 
			$this->db->where("slip_no", $slip_no); 
						
		 }
		if(!empty($data['hub']))
		 {
			$hub=$data['hub']; 
			$this->db->where('destination in (select id from country where state="'.$hub.'")');
		 }
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('entry_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 
		 
		 $this->db->select('count(id) as total_complete');
         $this->db->from('audit');
         $this->db->where('audit_status!=', '');  
		 $this->db->where("shipment_status IN ('MC','NA','CNL','RF','CNAD','COP','MW','DO','CNC')"); 
		
		
         $query = $this->db->get();
   // echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data=  $query->result_array(); 
			return $data[0]['total_complete'];
		}
	}
	
	
	public function cs_total_pending($data=array())
	{ 
	
		 if(!empty($data['destination']))
		 {
			$destination=$data['destination']; 
			$this->db->where("destination", $destination); 
						
		 }
		 if(!empty($data['audit_status']))
		 {
			$audit_status=$data['audit_status']; 
			$this->db->where("audit_status", $audit_status); 
						
		 }
		 if(!empty($data['slip_no']))
		 {
			$slip_no=$data['slip_no']; 
			$this->db->where("slip_no", $slip_no); 
						
		 }
		 if(!empty($data['hub']))
		 {
			$hub=$data['hub']; 
			$this->db->where('destination in (select id from country where state="'.$hub.'")');
		 }
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('entry_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 
		 
		 $this->db->select('count(id) as total_pending');
         $this->db->from('audit');
         $this->db->where('audit_status', ''); 
		 $this->db->where("shipment_status IN  ('WAR','CNI','RFD','RSD','RSP','OCA')"); 
		
		
         $query = $this->db->get();
   // echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data=  $query->result_array(); 
			return $data[0]['total_pending'];
		}
	}
	
	public function cs_total_complete($data=array())
	{ 
	
		 if(!empty($data['destination']))
		 {
			$destination=$data['destination']; 
			$this->db->where("destination", $destination); 
						
		 }
		 if(!empty($data['audit_status']))
		 {
			$audit_status=$data['audit_status']; 
			$this->db->where("audit_status", $audit_status); 
						
		 }
		 if(!empty($data['slip_no']))
		 {
			$slip_no=$data['slip_no']; 
			$this->db->where("slip_no", $slip_no); 
						
		 }
		 if(!empty($data['hub']))
		 {
			$hub=$data['hub']; 
			$this->db->where('destination in (select id from country where state="'.$hub.'")');
		 }
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('entry_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 
		 
		 $this->db->select('count(id) as total_complete');
         $this->db->from('audit');
         $this->db->where('audit_status!=', '');  
		 $this->db->where("shipment_status IN  ('WAR','CNI','RFD','RSD','RSP','OCA')"); 
		
		
         $query = $this->db->get();
   // echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data=  $query->result_array(); 
			return $data[0]['total_complete'];
		}
	}
	
	
	public function viewaudit_total_pending($data=array())
	{ 
	
		 if(!empty($data['destination']))
		 {
			$destination=$data['destination']; 
			$this->db->where("destination", $destination); 
						
		 }
		 if(!empty($data['audit_status']))
		 {
			$audit_status=$data['audit_status']; 
			$this->db->where("audit_status", $audit_status); 
						
		 }
		 if(!empty($data['slip_no']))
		 {
			$slip_no=$data['slip_no']; 
			$this->db->where("slip_no", $slip_no); 
						
		 }
		if(!empty($data['hub']))
		 {
			$hub=$data['hub']; 
			$this->db->where('destination in (select id from country where state="'.$hub.'")');
		 }
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('entry_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 
		 
		 $this->db->select('count(id) as total_pending');
         $this->db->from('audit');
         $this->db->where('audit_status', ''); 
		 $this->db->where("shipment_status IN  ('RF','WAR','COP','DO','CNI','RFD','RSD','MC','NA','CNL','RF','CNAD','COP','MW','DO','CNC')"); 
		
		
         $query = $this->db->get();
   // echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data=  $query->result_array(); 
			return $data[0]['total_pending'];
		}
	}
	
	public function viewaudit_total_complete($data=array())
	{ 
	
		 if(!empty($data['destination']))
		 {
			$destination=$data['destination']; 
			$this->db->where("destination", $destination); 
						
		 }
		 if(!empty($data['audit_status']))
		 {
			$audit_status=$data['audit_status']; 
			$this->db->where("audit_status", $audit_status); 
						
		 }
		 if(!empty($data['slip_no']))
		 {
			$slip_no=$data['slip_no']; 
			$this->db->where("slip_no", $slip_no); 
						
		 }
		if(!empty($data['hub']))
		 {
			$hub=$data['hub']; 
			$this->db->where('destination in (select id from country where state="'.$hub.'")');
		 }
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('entry_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 
		 
		 $this->db->select('count(id) as total_complete');
         $this->db->from('audit');
         $this->db->where('audit_status!=', '');  
		 $this->db->where("shipment_status IN ('RF','WAR','COP','DO','CNI','RFD','RSD','MC','NA','CNL','RF','CNAD','COP','MW','DO','CNC')"); 
		
		
         $query = $this->db->get();
   // echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data=  $query->result_array(); 
			return $data[0]['total_complete'];
		}
	}
	
	public function updateStatusDetails($data=array(),$id=null)
	{
		return $this->db->update('audit',$data,array('id'=>$id));

	} 
	
	
		public function getadminDetails($useradmin=null) 
	{ 
		   
		
		 $this->db->select('branch_location,name');
         $this->db->from('user');
         $this->db->where('deleted', 'N');
		 $this->db->where('id',$useradmin);
		
         $query = $this->db->get();  
           //return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
	}
	
	  public function showAuditData($id=null)
		{
		 $this->db->select('*');
         $this->db->from('audit'); 
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
	public function getCityCodeDetail($destination=null) 
	{ 
		   
		
		 $this->db->select('city_code');
         $this->db->from('country');
		 $this->db->where('id',$destination);
		
         $query = $this->db->get();  
 //echo $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		
		{
		
			return $query->row_array();
		}
	}
	
	public function getSubStatusDetail($shipment_status=null) 
	{ 
		   
		
		 $this->db->select('sub_status');
         $this->db->from('status_category');
		 $this->db->where('code',$shipment_status);
		
         $query = $this->db->get();  
      //echo $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
		
			return $query->row_array();
		}
	}
	
	public function insertStatus($data=array()) 
		{
			return $this->db->insert('status',$data);  
		}
		
	
	
}
?>