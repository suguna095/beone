<?php
class Login_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
	
	public function GetauthCheck($data=array())
	{
		//print_r($data);
		$user=$data['customer']['username'];
		 $this->db->select('*');
		 $this->db->from('user');
		 $this->db->where("password='".md5($data['customer']['password'])."' and (username = '$user' or email ='$user' )");
			
     // $this->db->where("username='.$data['customer']['username'].' OR email='.$data['customer']['username'].' ");
		//$this->db->where('password', md5($data['customer']['password']));
		$this->db->limit(1);   
         $query = $this->db->get();
       // echo $this->db->last_query(); die;
		if($query->num_rows()>0)
		{
			$row = $query->row_array();
			$city_id=Get_name_country_by_id('city',$row['branch_location']);
			$Array['localSession'] = array(
			'A_USERNAME'=>$row['username'],
			'A_ID'=>$row['id'],
			'A_EMAIL'=>$row['email'],
			'useridadmin'=>$row['id'],
			'adminusertype'=>$row['usertype'],
			'name'=>$row['name'],
			'hub_name'=>$row['hub_name'],
			'user_name'=>$row['name'],
			'privilege'=>$row['privilege'],
			'call_record'=>$row['call_record'],
			'adminbranchlocation'=>$row['branch_location'],
			'adminbranchlocationid'=>$city_id
			);
			$array2=array(
			'A_USERNAME'=>$row['username'],
			'A_ID'=>$row['id'],
			'A_EMAIL'=>$row['email'],
			'useridadmin'=>$row['id'],
			'adminusertype'=>$row['usertype'],
			'name'=>$row['name'],
			'hub_name'=>$row['hub_name'],
			'user_name'=>$row['name'],
			'privilege'=>$row['privilege'],
			'call_record'=>$row['call_record'],
			'adminbranchlocation'=>$row['branch_location'],
			'adminbranchlocationid'=>$city_id
			);
			$this->session->set_userdata($array2);
			$this->session->set_userdata($Array);
			return $Array;
		}
		else
		return false;
		
	}
		
	
	
	
	
	
}
?>