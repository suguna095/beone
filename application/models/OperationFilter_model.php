<?php
class OperationFilter_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	
	public function getShowordernotpicked($searchfield=null,$page_no)
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		 $this->db->select('*');
         $this->db->from('shipment');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		 
		  $this->db->where('code','OP');
		 $this->db->where('status','Y');
		 $this->db->where('deleted','N');
         $query = $this->db->get();
          ////return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowordernotpickedCount($searchfield,$page_no);  
			return $data;
		}
	}
	
	public function getShowordernotpickedCount($searchfield,$page_no)
	{
		 if(!empty($searchfield))
		 {
			$this->db->where('name',$searchfield);
		 }
		   
			$this->db->where('status','Y');
		    $this->db->where('deleted','N');
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('shipment');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
	

	public function getShowofdissue($data=array())
	{ 
	
		$page_no;        
		$limit = 100;     
	  if(empty($data['page_no'])){   
		  $start = 0;
	  }else{
		  $start = ($data['page_no']-1)*$limit;
	  }  
	  
		 $compare_date="";
		
		 $start_date=$data['start_date'];
		//pagination stop
		if(!empty($start_date)) {
		$searchfieldArr=explode('T',$start_date);
			 $compare_date=$searchfieldArr[0];
			//$start_date = date('Y-m-d');
	    $date = DateTime::createFromFormat('Y-m-d',$compare_date);
		//print_r($date);
	    $date->modify('-3 day');
		// echo "sssssss"; die;
			$compare_date=$date->format('Y-m-d');
			
		}
		else{
			$start_date = date('Y-m-d');
	    $date = DateTime::createFromFormat('Y-m-d',$start_date);
	    $date->modify('-3 day');
			$compare_date=$date->format('Y-m-d');
		}
		
		//between '".$compare_date."' and  '".$start_date."'
		if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			
			$cond=" and DATE(entry_date) BETWEEN '". date('Y-m-d', strtotime($data['start_date'])). "' and '". date('Y-m-d', strtotime($data['end_date']))."' ";	   

				    
		 }else{
			$cond=" and DATE(entry_date)='".$compare_date."' and YEAR(entry_date)='".date('Y',strtotime($compare_date))."' AND MONTH(entry_date)='".date('m',strtotime($compare_date))."' ";      	

		 }       

	

		 $drsQry1="select slip_no,entry_date from status where  deleted ='N' and code='PUC' ".$cond." "; 
		$query1=$this->db->query($drsQry1);
		//echo $this->db->last_query();
		$drsData1=$query1->result_array();
		
		//print_r($drsData1); 
		//echo '// count pickup'.	count($drsData1);
		// exit();
		if(!empty($drsData1))
		{
			$slipArray1=array();
		foreach($drsData1 as $key1=>$val1)	
		{
			array_push($slipArray1,"'".$val1['slip_no']."'");
			
			}
			//$slipData1=implode(',' ,$slipArray1);
		}
		

		
		if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			
			$cond=" and DATE(drs_date) BETWEEN '". date('Y-m-d', strtotime($data['start_date'])). "' and '". date('Y-m-d', strtotime($data['end_date']))."' ";	   

				    
		 }else{
			$cond=" and DATE(drs_date)>='".$compare_date."' ";      	

		 }     


		 $drsQry="select shipment_id from drs where  deleted ='N' and  delivery_status='N'  ".$cond." "; 
		$query2=$this->db->query($drsQry);
	//	echo $this->db->last_query();  
		$drsData=$query2->result_array();
		if(!empty($drsData))
		{
			$slipArray=array();
			foreach($drsData as $key=>$val)	
			{
				array_push($slipArray,"'".$val['shipment_id']."'");
				
			}
			//print_r($slipArray); die();
			//$slipData=implode(',' ,$slipArray);
			if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('entrydate BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }

		
			$this->db->where("schedule_status!='Y'");
			$this->db->select('*');
			$this->db->from('shipment');
			 $this->db->where('deleted','N');
			 $this->db->where('code','SH');
			 $this->db->where_not_in('slip_no',$slipArray);
			  $this->db->where_in('slip_no',$slipArray1);
			   $this->db->order_by('id','DESC'); 
		
          $query = $this->db->get();
		 $this->db->limit($limit, $start); 
		 $shipmentdata2=$query->result_array();
	//echo $this->db->last_query();          
		}  
		  
		if($query->num_rows()>0)
		{
			$data['result']=$shipmentdata2;
            $data['count']=$this->getShowifdissueCount($searchfield,$page_no,$slipArray,$slipArray1);  
			return $data;
		}
	}


	public function getShowifdissueCount($searchfield,$page_no,$slipArray,$slipArray1)
	{
		//// if(!empty($searchfield))
		 //{
			//$this->db->where('schedule_date',$searchfield);
		 //
		    $this->db->where("schedule_status!='Y'");
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('shipment');
			 $this->db->where('deleted','N');
			 $this->db->where('code','SH');
			 $this->db->where_not_in('slip_no',$slipArray);
			  $this->db->where_in('slip_no',$slipArray1);
			
			   $query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}  
				return 0;
	}


	public function getShowofdissueExcel($data=array())
	{ 
	
		
	

		 /*$drsQry1="select slip_no,entry_date from status where  deleted ='N' and code='PUC' ".$cond." "; 
		$query1=$this->db->query($drsQry1);
		//echo $this->db->last_query();
		$drsData1=$query1->result_array();
		
		//print_r($drsData1); 
		//echo '// count pickup'.	count($drsData1);
		// exit();
		if(!empty($drsData1))
		{
			$slipArray1=array();
		foreach($drsData1 as $key1=>$val1)	
		{
			array_push($slipArray1,"'".$val1['slip_no']."'");
			
			}
			//$slipData1=implode(',' ,$slipArray1);    
		}*/
		

		  


		 $drsQry="select shipment_id from drs where  deleted ='N' and  delivery_status='N'  ".$cond." "; 
		$query2=$this->db->query($drsQry);
	//	echo $this->db->last_query();  
		$drsData=$query2->result_array();
		if(!empty($drsData))
		{
			$slipArray=array();
			foreach($drsData as $key=>$val)	
			{
				array_push($slipArray,"'".$val['shipment_id']."'");
				
			}
			//print_r($slipArray); die();
			//$slipData=implode(',' ,$slipArray);
			

		
			$this->db->where("schedule_status!='Y'");
			$this->db->select('*');
			$this->db->from('shipment');
			 $this->db->where('deleted','N');
			 $this->db->where('code','SH');
			 $this->db->where_not_in('slip_no',$slipArray);
			  $this->db->where_in('slip_no',$slipArray1);
			   $this->db->order_by('id','DESC'); 
		
          $query = $this->db->get();
		 //$this->db->limit($limit, $start);  
		 $shipmentdata2=$query->result_array();
	//echo $this->db->last_query();          
		}  
		  
		if($query->num_rows()>0)
		{
			$data['result']=$shipmentdata2; 
			return $data;
		}
	}




	public function getShowshipment($searchfield=null,$page_no)
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		 $this->db->select('*');
         $this->db->from('shipment');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		  $this->db->where('refused','YES');
		 $this->db->where('code','SH');
		 $this->db->where('deleted','N');
         $query = $this->db->get();
          ////return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowshipmentCount($searchfield,$page_no);  
			return $data;
		}
	}
	
	
	public function getShowshipmentCount($searchfield,$page_no)
	{
		 if(!empty($searchfield))
		 {
			$this->db->where('name',$searchfield);
		 }
		   $this->db->where('refused','YES');
		 $this->db->where('code','SH');
			$this->db->where('status','Y');
		    $this->db->where('deleted','N');
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('shipment');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}


	public function getShowcsaschedule($searchfield=null,$page_no)
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }   
		
		$compare_date="";
		if(!empty($searchfield)) {
              $searchfieldArr=explode('T',$searchfield);
			 $compare_date=$searchfieldArr[0];
	    
	    $date = DateTime::createFromFormat('Y-m-d',$compare_date);
	    $date->modify('-3 day');
	    $compare_date=$date->format('Y-m-d');
		}
		else{
	    $start_date = date('Y-m-d');
	    $date = DateTime::createFromFormat('Y-m-d',$start_date);
	    $date->modify('-3 day');
		$compare_date=$date->format('Y-m-d');

		}
		
		
		//between '".$compare_date."' and  '".$start_date."'
		$drsQry="select slip_no from status where date(entry_date)<='".$compare_date."'  and new_status='4' ";
		$query2=$this->db->query($drsQry);
		$drsData=$query2->result_array();
		
			$slipArray=array();
			
		foreach($drsData as $key=>$val)	
		{
			
			array_push($slipArray,"'".$val['slip_no']."'");
		} 
		
		$this->db->where('deleted','N');
		$this->db->where('call_attempt',0);
		$this->db->where("DATE(shipment.entrydate)<='".$compare_date."'");
		$this->db->where("schedule_status!='Y'");
		$this->db->where_in('slip_no',$slipData);
		$this->db->where_not_in('code',array('POD','RTC','RFDE','RTR','B'));
		 $this->db->select('*');
         $this->db->from('shipment');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		  
		 $this->db->where("code NOT IN ('POD','RYC','RFDE','RTR','B')"); 
		
         $query = $this->db->get();
         //echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowcsascheduleCount($compare_date,$page_no,$slipData);  
			return $data;
		}
	}

	public function getShowcsascheduleCount($searchfield,$page_no,$slipData)
	{
		
		
		   $this->db->where('deleted','N');
		   $this->db->where('call_attempt',0);
		   $this->db->where("DATE(entrydate)<='".$searchfield."'");
		   $this->db->where("schedule_status!='Y'");
		   $this->db->where_in('slip_no',$slipData);
		   $this->db->where_not_in('code',array('POD','RTC','RFDE','RTR','B'));
		   $this->db->select('COUNT(id) as sh_count');
		   $this->db->from('shipment');
			//$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}

	public function getShowcsascheduleExcel()
	{ 
		
		
		/*$compare_date="";
		if(!empty($searchfield)) {
              $searchfieldArr=explode('T',$searchfield);
			 $compare_date=$searchfieldArr[0];
	    
	    $date = DateTime::createFromFormat('Y-m-d',$compare_date);
	    $date->modify('-3 day');
	    $compare_date=$date->format('Y-m-d');
		}
		else{
	    $start_date = date('Y-m-d');
	    $date = DateTime::createFromFormat('Y-m-d',$start_date);
	    $date->modify('-3 day');
		$compare_date=$date->format('Y-m-d');

		}
		
		
		//between '".$compare_date."' and  '".$start_date."'
		$drsQry="select slip_no from status where date(entry_date)<='".$compare_date."'  and new_status='4' ";
		$query2=$this->db->query($drsQry);
		$drsData=$query2->result_array();
		
			$slipArray=array();
			
		foreach($drsData as $key=>$val)	
		{
			
			array_push($slipArray,"'".$val['slip_no']."'");
		} */
		
		$this->db->where('deleted','N');
		$this->db->where('call_attempt',0);
		//$this->db->where("DATE(shipment.entrydate)<='".$compare_date."'");
		$this->db->where("schedule_status!='Y'");
		$this->db->where_in('slip_no',$slipData);
		$this->db->where_not_in('code',array('POD','RTC','RFDE','RTR','B'));
		 $this->db->select('*');
         $this->db->from('shipment');
         $this->db->order_by('id','DESC'); 
		 
		  
		 $this->db->where("code NOT IN ('POD','RYC','RFDE','RTR','B')"); 
		
         $query = $this->db->get();
         //echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
		}
	}

	public function getShowcsalocation($data2=array())
	{ 
		$page_no;        
		$limit = 100;     
		if(empty($data['page_no'])){   
			$start = 0;
		}else{
			$start = ($data['page_no']-1)*$limit;
		}  
		$this->db->where('deleted','N');
		$this->db->where('refused','YES');
		$this->db->where('code','SH');
		  
		 $this->db->select('*');
         $this->db->from('shipment');
        // $this->db->join('status', 'shipment.slip_no = status.slip_no', 'LEFT OUTER');
//$this->db->where("shipment.deleted = 'N' and status. deleted = 'N' and shipment.schedule_status!='Y' and status.code='WAR' and shipment.code NOT IN ('POD','RTC','RFDE','RTR','B')"); 
 if(!empty($data2['start_date']) && !empty($data2['end_date'])){
			
			$date1=explode('T',$data2['start_date']);
			$date2=explode('T',$data2['end_date']);
			$BETWEEN_Date=" DATE(entrydate) BETWEEN '".$date1[0]."' AND '".$date2[0]."'";  
			$this->db->where($BETWEEN_Date); 
		}
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		  
			
         $query = $this->db->get();
         // echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowcsalocationCount($searchfield,$page_no);  
			return $data;
		}
	}


public function getShowcsalocationCount($searchfield,$page_no)
	{
		 if(!empty($searchfield))
		 {
			$this->db->where("schedule_date LIKE '%$searchfield%' ");
		 }
		   
			$this->db->where('deleted','N');
		$this->db->where('refused','YES');
		$this->db->where('code','SH');
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('shipment');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}


	public function getShowcsalocationExcel($data2=array())
	{ 
		 
		$this->db->where('deleted','N');
		$this->db->where('refused','YES');
		$this->db->where('code','SH');
		  
		 $this->db->select('*');
         $this->db->from('shipment');
        // $this->db->join('status', 'shipment.slip_no = status.slip_no', 'LEFT OUTER');
//$this->db->where("shipment.deleted = 'N' and status. deleted = 'N' and shipment.schedule_status!='Y' and status.code='WAR' and shipment.code NOT IN ('POD','RTC','RFDE','RTR','B')"); 
 if(!empty($data2['start_date']) && !empty($data2['end_date'])){
			
			$date1=explode('T',$data2['start_date']);
			$date2=explode('T',$data2['end_date']);
			$BETWEEN_Date=" DATE(entrydate) BETWEEN '".$date1[0]."' AND '".$date2[0]."'";  
			$this->db->where($BETWEEN_Date); 
		}
         $this->db->order_by('id','DESC'); 
		 
		  
			
         $query = $this->db->get();
         // echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
		}
	}




public function getShowdriver($search_date=null,$to_date=null,$page_no=null)
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }  
		if(!empty($search_date) && !empty($to_date)){
			
			$date1=explode('T',$search_date);
			$date2=explode('T',$to_date);
			$BETWEEN_Date=" DATE(entrydate) BETWEEN '".$date1[0]."' AND '".$date2[0]."'";  
			$this->db->where($BETWEEN_Date); 
		}
		 $this->db->select('*');
         $this->db->from('shipment');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		 $this->db->where('code','OD');
		 $this->db->where('deleted','N'); 
			
         $query = $this->db->get();
          ////return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowdriverCount();  
			
			return $data;
		}
	}


public function getShowdriverCount()
	{
		 if(!empty($searchfield))
		 {
			//$this->db->where('name',$searchfield);
		 }
		    $this->db->where('code','OD');
			//$this->db->where('status','Y');
		    $this->db->where('deleted','N');
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('shipment');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}


	public function getShowdriverExcel()
	{ 
		
		
		 $this->db->select('*');
         $this->db->from('shipment');
         $this->db->order_by('id','DESC'); 
		 $this->db->where('code','OD');
		 $this->db->where('deleted','N'); 
			
         $query = $this->db->get();
          ////return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			
			return $data;
		}
	}


public function getShownotdispatched($data2=array(),$page_no)
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        } 
		if(!empty($data2['search_date']) && !empty($data2['to_date'])){
			$date1=explode('T',$data2['search_date']);
			$date2=explode('T',$data2['to_date']);
			$compare_date=$date1[0];
			$start_date=$date2[0];
			
	}
	else{
		$start_date=date("Y-m-d");
		$date = DateTime::createFromFormat('Y-m-d',$start_date);
	    $date->modify('-1 day');
		$compare_date=$date->format('Y-m-d');
	}
	
	     $awbDatas=getAwb_betweendateStatus($compare_date,$start_date,'5');
		 $this->db->where("DATE(shipment.schedule_date) between '".$compare_date."' and  '".$start_date."'"); 
		
		
		
		if(!empty($awbDatas))
	    {
		 $condition=	" and slip_no NOT  IN (".$awbDatas.")";
		  $this->db->where_not_in('slip_no',$awbDatas);			
		}
		 $this->db->select('*');
         $this->db->from('shipment');
         $this->db->where_not_in('code',array('OP','POD','RTC','RTR','B')); 
		// $this->db->where("code NOT IN ('POD','RYC','RFDE','RTR','B')"); 
		 $this->db->where('schedule_status','Y'); 
		 $this->db->where("refused !='YES'"); 
		 $this->db->where('delivered','11'); 
			 $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
         $query = $this->db->get();
         //echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowdispatchCount($compare_date,$page_no,$awbDatas,$start_date);  
			return $data;
		}
	}


public function getShowdispatchCount($compare_date,$page_no,$awbDatas,$start_date)
	{
		
		$this->db->where("DATE(shipment.schedule_date) between '".$compare_date."' and  '".$start_date."'"); 
		 if(!empty($awbDatas))
	    {
		 $condition=	" and slip_no NOT  IN (".$awbDatas.")";
		  $this->db->where_not_in('slip_no',$awbDatas);			
		}
		    $this->db->where_not_in('code',array('OP','POD','RTC','RTR','B')); 
		// $this->db->where("code NOT IN ('POD','RYC','RFDE','RTR','B')"); 
		 $this->db->where('schedule_status','Y'); 
		 $this->db->where("refused !='YES'"); 
		 $this->db->where('delivered','11'); 
		    $this->db->where('deleted','N');
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('shipment');
			//$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}

	
	public function getShownotdispatchedExcel($data2=array())
	{ 
		
		
		 $this->db->select('*');
         $this->db->from('shipment');
         $this->db->where_not_in('code',array('OP','POD','RTC','RTR','B')); 
		// $this->db->where("code NOT IN ('POD','RYC','RFDE','RTR','B')"); 
		 $this->db->where('schedule_status','Y'); 
		 $this->db->where("refused !='YES'"); 
		 $this->db->where('delivered','11'); 
			 $this->db->order_by('id','DESC'); 
         $query = $this->db->get();
         //echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
		}
	}


	public function getShowupdate($data=array())
	{ 
		$page_no;        
		$limit = 100;     
	  if(empty($data['page_no'])){   
		  $start = 0;
	  }else{
		  $start = ($data['page_no']-1)*$limit;
	  }  
	  if(!empty($data['from_date']) && !empty($data['to_date'])){
			
		$date1=explode('T',$data['from_date']);
		$date2=explode('T',$data['to_date']);
		$BETWEEN_Date=" DATE(schedule_date) BETWEEN '".$date1[0]."' AND '".$date2[0]."'";  
		$this->db->where($BETWEEN_Date); 
	}


		 $this->db->select('*');
         $this->db->from('shipment');
         $this->db->order_by('id','DESC'); 
		 $this->db->where_not_in("code",array('POD','RTC','RFDE','RTR','RFD','OD','B')); 
		 $this->db->where('schedule_status','Y'); 
		 $this->db->limit($limit, $start);	
         $query = $this->db->get();
          ////return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowupdateCount($data);  
			return $data;
		}
	}


public function getShowupdateCount($data)
	{
		if(!empty($data['from_date']) && !empty($data['to_date'])){
			
			$date1=explode('T',$data['from_date']);
			$date2=explode('T',$data['to_date']);
			$BETWEEN_Date=" DATE(schedule_date) BETWEEN '".$date1[0]."' AND '".$date2[0]."'";  
			$this->db->where($BETWEEN_Date); 
		}

		  $this->db->where_not_in("code",array('POD','RTC','RFDE','RTR','RFD','OD','B')); 
		   $this->db->where('schedule_status','Y'); 
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('shipment');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	

		public function getShowupdateExcel($data=array())
	{ 
		

		 $this->db->select('*');
         $this->db->from('shipment');
         $this->db->order_by('id','DESC'); 
		 $this->db->where_not_in("code",array('POD','RTC','RFDE','RTR','RFD','OD','B')); 
		 $this->db->where('schedule_status','Y'); 
         $query = $this->db->get();
          ////return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
		}
	}

	
		public function getShowordernotpick($data=array())
	{ 
		
		$page_no;        
		$limit = 100;     
	  if(empty($data['page_no'])){   
		  $start = 0;
	  }else{
		  $start = ($data['page_no']-1)*$limit;
	  }  
	  
		 $compare_date="";
		
		 $start_date=$data['start_date']; 

		if(!empty($start_date)) {
			$searchfieldArr=explode('T',$start_date);
			 $compare_date=$searchfieldArr[0];
			//$compare_date=$searchfield;
		}
		else
		{
			$start_date = date('Y-m-d');
	    	$date = DateTime::createFromFormat('Y-m-d',$start_date);
	   		$date->modify('-4 day');
			$compare_date=$date->format('Y-m-d');
			
		}
		 $this->db->select('*');
         $this->db->from('shipment');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 

		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('entrydate BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }


		  else if(!empty($start_date))
		 {
			$this->db->where("DATE(entrydate)<='".$compare_date."'");
			
		 }
		 
		 //$this->db->where("code NOT IN ('POD','RYC','RFDE','RTR','B')"); 
		  $this->db->where('code','OP');
		  $this->db->where('delivered','N'); 
			
         $query = $this->db->get();
      //echo  $this->db->last_query(); die;
	   
	   
	   
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowordernotpickCount($searchfield,$page_no);  
			return $data;
		}
	}


public function getShowordernotpickCount($searchfield,$page_no)
	{
		  $this->db->where('code','OP');
		  $this->db->where('delivered','N'); 
		  // $this->db->where('schedule_status','Y');  
			$this->db->where('status','Y');
		    $this->db->where('deleted','N');
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('shipment');
			//$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}

	public function getShowordernotpickExcel($data=array())
	{ 
		
	   
		 
		 $this->db->select('*');
         $this->db->from('shipment');
         $this->db->order_by('id','DESC'); 

		

		 
		 //$this->db->where("code NOT IN ('POD','RYC','RFDE','RTR','B')"); 
		  $this->db->where('code','OP');
		  $this->db->where('delivered','N'); 
			
         $query = $this->db->get();
      //echo  $this->db->last_query(); die;
	   
	   
	   
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
		}
	} 



}
?>