<?php
class SetUserPrivilege_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
	}  
		
	public function getUserprivilegeData($data=array())   
	{
		 $this->db->select('*');
         $this->db->from('privilege_details'); 
        // $this->db->where('id', $data['user_id']);
		 $this->db->order_by("id", 'asc');
         $query = $this->db->get();
		
			return $query->result_array();
		
	}
	public function GetalluserQry()
	{
		$this->db->where("name!=''");
		 $this->db->select('id,name');
         $this->db->from('user');
		 $this->db->order_by("name", 'asc');
		 $query = $this->db->get();
		 return $query->result_array();
	}
	
	public function setCustomerPrivilageUpdate($data=array())
	{
		
		$query=$this->db->query("select id,privilage_array from set_user_privilage where customer_id='".$data['customer_id']."' and deleted='N'");
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
		{
			$query_data=$query->row_array();
			//echo $query_data['privilage_array']; 
			$privilage_array=explode(',',$query_data['privilage_array']);
			//print_r($privilage_array);
		//	echo $data['privilage_id'];//$privilage_id;
			if(in_array($data['privilage_id'],$privilage_array))
				{
					//echo "xxxxx";
					if($data['onoff_true_false']==false)
						{
							//echo "yyyy";
							foreach (array_keys($privilage_array, $data['privilage_id']) as $key) {
                             unset($privilage_array[$key]);
                             }
							print_r($privilage_array);
									array_values($privilage_array);
						}
						
				}
				
				else
				{
					array_push($privilage_array,$data['privilage_id']);
				}
				
			$insert_privilage_array='';
				
		$insert_privilage_array=implode(',',$privilage_array);
		$insert_privilage_array=rtrim($insert_privilage_array,',');
		$insert_privilage_array=ltrim($insert_privilage_array,',');
		$this->db->update("set_user_privilage",array('privilage_array'=>$insert_privilage_array),array('customer_id'=>$data['customer_id']));
		echo $this->db->last_query();
		return true;		
		}
		else
		{
			$addArray=array('customer_id'=>$data['customer_id'],'privilage_array'=>$data['privilage_id'],);
			$this->db->insert('set_user_privilage', $addArray);
			echo $this->db->last_query();
			return true;
			
		}
	}
	
	
	
	
	
}
?>