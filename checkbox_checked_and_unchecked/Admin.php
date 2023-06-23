<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends My_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
        	{
        		parent::__construct();
        	    $this->load->model('AdminModel/Adminmodel','AM');	
        		$this->load->model('AdminModel/Tournamentmodel','TM');	
        		if($this->session->userdata('id') != true)
                {
                  redirect('adminlogin/login');
                }
        
        	}
	public function index()
        	{
        	    $data['page_name']='dashboard';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$data['total_sports']=$this->AM->total_sports(); 
        		$data['total_players']=$this->AM->total_players(); 
        		$data['total_team']=$this->AM->total_team(); 
        		$data['total_tournament']=$this->AM->total_tournament(); 
        		$this->load->view('admin/index', $data);
        	}

		public function admin_profile()
        	{
        	    $data['page_name']='admin_profile';
                $data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id'));    
        		$this->load->view('admin/admin_profile', $data);
        	}
		public function change_password()
        	{
        	    $data['page_name']='change_password';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$this->load->view('admin/change_password', $data);
        	}
	public function manage_slider()
        	{
        	    $data['page_name']='manage_slider';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$table = 'tbl_slider';
        		$status = '2';
        		$data['manage_slider']  = $this->selectdata($table,$status);
        		$this->load->view('admin/manage_slider', $data);
        	}
        	
		public function manage_user()
        	{
        	    $data['page_name']='manage_user';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id'));
        		$table = 'tbl_users';
        		$status = '2';
        		$data['manage_state'] = $this->TM->get_states();
        		$data['manage_game'] = $this->AM->get_gamescat();
        		$data['manage_users'] = $this->AM->selectdata_users($table,$status);
        		$data['manage_users']=($data['manage_users'])?$data['manage_users']:'';
        		$this->load->view('admin/manage_user', $data);
        	}
        	
		public function manage_notification()
        	{
        	    $data['page_name']='manage_notification';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$table = 'tbl_notification';
        		$status = '2';
        		$data['manage_notificaion'] = $this->selectdata($table,$status);
        		$this->load->view('admin/manage_notification', $data);
        	}
		public function manage_category()
        	{
        	    $data['page_name']='manage_category';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$table = 'tbl_sportcategory';
        		$status = '2';
        		$data['manage_category'] = $this->selectdata($table,$status);
        		$this->load->view('admin/manage_category', $data);
        	}


	public function manage_sportsname()
        	{
        	    $data['page_name']='manage_sportsname';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id'));
        		$data['sports_category'] = $this->AM->get_sports_category();
        		$table = 'tb_gamecategory';
        		$status = '2';
        		$data['manage_sports'] = $this->selectdata($table,$status);
        		$this->load->view('admin/manage_sportsname', $data);
        	}
		public function manage_player()
        	{
        	    $data['page_name']='manage_player';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id'));
        		$table = 'tbl_teamplayers';
        		$status = '2';
        		$data['manage_players']  = $this->TM->selectdata_teamplyer($table,$status);
        		// echo "<pre>"; print_r($data['manage_players']);exit;
        		$this->load->view('admin/manage_player', $data);
        	}
		public function add_player()
        	{
        	    $data['page_name']='add_player';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$data['sports_name'] = $this->AM->get_sports_type();
        		$data['manage_team'] = $this->AM->get_team();
        		$this->load->view('admin/add_player', $data);
        	}
    	public function update_player($id)
        	{
        	    $data['page_name']='manage_player';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$data['row'] = $this->TM->fetch_player_data($id);
        		$data['manage_team'] = $this->AM->get_team();
        		$this->load->view('admin/update_player', $data);
        	}
        		public function manage_team()
            	{
            	    $data['page_name']='manage_team';
            		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
            		$this->load->view('admin/manage_team', $data);
            	}
		public function create_team()
        	{
        	    $data['page_name']='create_team';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$this->load->view('admin/create_team', $data);
        	}
		public function update_team()
        	{
        	    $data['page_name']='update_team';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$this->load->view('admin/update_team', $data);
        	}
		public function manage_tournament()
        	{
        	    $data['page_name']='manage_tournament';
        		$table = 'tbl_tournament';
        		$status = '2';
        		$data['manage_torunament']  = $this->TM->selectdata($table,$status);
        		$data['sports_name'] = $this->AM->get_gamescat();
        		$data['manage_team'] = $this->AM->get_team();
        		$data['manage_state'] = $this->TM->get_states();
        		// echo '<pre>'; print_r($data['manage_torunament']);exit;
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$this->load->view('admin/manage_tournament', $data);
        	}
		public function create_tournament()
        	{
        	    $data['page_name']='create_tournament';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        // 		$data['sports_name'] = $this->AM->get_sports_type();
             	$data['games_name'] = $this->AM->get_gamescat();
        		$data['manage_team'] = $this->AM->get_team();
        		$data['manage_state'] = $this->AM->get_states_list();
        		$data['manage_city'] = $this->AM->get_city_list();
        // 		echo "<pre>";print_r($data['sports_name']);exit;
        		$this->load->view('admin/create_tournament', $data);
        	}
		public function update_tournament($id=null)
        	{
        	    $data['page_name']='update_tournament';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$data['row'] = $this->TM->fetch_tournament_data($id); 
        		$state_id =$data['row']['state'];
        		$data['sports_name'] = $this->AM->get_sports_type();
        		$data['manage_team'] = $this->AM->get_team();
        		$data['manage_state'] = $this->AM->get_states_list();
        // 		$data['manage_city'] = $this->AM->get_city_list_statewise($state_id);
            	$data['manage_city'] = $this->AM->get_city_list();
        // echo "<pre>";	print_r($data['manage_city'] );exit;
        		$this->load->view('admin/update_tournament', $data);
        	}
		public function app_link()
        	{
        	    $data['page_name']='app_link';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$this->load->view('admin/app_link', $data);
        	}
		public function manage_gallery()
        	{
        	    $data['page_name']='manage_gallery';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$this->load->view('admin/manage_gallery', $data);
        	}
		public function manage_role()
        	{
        	    $data['page_name']='manage_role';
        		$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
        		$this->load->view('admin/manage_role', $data);
        	}

	public function logout()
        	{
        		$this->session->unset_userdata('id');
        		$this->session->unset_userdata('email');
        	    redirect(base_url('adminlogin/login'));
        	 }

	 public function change_profile_image()
	 {
	 if(isset($_POST['submit'])){
			$config['allowed_types'] = 'pdf|gif|jpeg|png|jpg';
			$config['upload_path'] = './uploads/';
			$config['encrypt_name'] = true;
			$this->load->library('upload',$config);
	 if($this->upload->do_upload('image'))
	    {	
			$data= $this->upload->data();
			$post=$this->input->post();
			$image_path = ("uploads/".$data['file_name']);
			$post['image']= $image_path; 
			$uid =$this->session->userdata('id');
			$res =$this->db->where('id',$uid)->update('admin_details',['image'=>$image_path]);
	     if($res)
	   {
		  /*  echo "<script>alert('Image Updated Successfully!');
					 window.location = '".base_url("admin/index")."';
						  </script>";   */
			$this->session->set_flashdata('success','<div class="alert alert-success text-center" id="successMessage">Profile image updated successfully!</div>');
            redirect('admin/admin_profile');
	   }
	 
	   }
   }
	 else{
			/*  echo "<script>alert('Something Went Wrong !');
					 window.location = '".base_url("admin/index")."';
						  </script>"; */
	  $this->session->set_flashdata('error','<div class="alert alert-danger text-center" id="successMessage">Something Went Wrong !</div>');
	  redirect('admin/admin_profile');
				  
	 }
	  
		 
	 }




	 public function update_admin_details()
				{
						if(isset($_POST['submit']))
						{
							$name=$this->input->post('name');
							$mobile=$this->input->post('mobile');
							$address=$this->input->post('address');
							$userid= $this->session->userdata('id');
							$array['name']= $name;
							$array['mobile']= $mobile;
							$array['address']= $address;
							$res=$this->AM->update_admin_profile($userid,$array);
							if($res==1)
								{
									$this->session->set_flashdata('success','<div class="alert alert-success text-center" id="successMessage"> Profile Updated Successfully</div>');
									redirect(base_url()."admin/admin_profile");
								} else{
									$this->session->set_flashdata('error','<div class="alert alert-success text-center" id="successMessage">Someting went wrong</div>');
									redirect(base_url()."admin/admin_profile");
								} 
							
						}


				}
						public function manage_content()
							{
								$data['page_name']='manage_content';
								$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id'));
								$table = ' tbl_contact';
                        		$status = '2';
                        		$data['manage_content'] = $this->selectdata($table,$status);
								$this->load->view('admin/manage_content', $data);
							}
						public function privacy_policy()
							{
								$data['page_name']='privacy_policy';
								$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
                             	$table = 'tbl_privacy';
                                
								if(isset($_POST['submit']))
								{
						
							$id= 1;    
						     $array['title'] = $this->input->post('title');
						     $array['status']=1;
							   $x =$this->UpdateTable($id,$table,$array); 
                            if($x)
                            {
                            $this->session->set_flashdata('success','<div class="alert alert-success text-center" id="successMessage">Data updated successfully</div>');
                            redirect(base_url()."admin/privacy_policy");
                            }
                            else
                            {
                            $this->session->set_flashdata('error','<div class="alert alert-danger text-center" id="successMessage">Unable to update data </div>');
                            redirect(base_url()."admin/privacy_policy");
                            }
                            
								}
								  
                                $status = '2';
        	                 	$data['manage_privacy'] = $this->db->get_where($table,['id'=>1,'status !='=>$status])->row_array();
								$this->load->view('admin/privacy_policy', $data);
							
								
							}
						public function term_condition()
							{
								$data['page_name']='term_condition';
								$data['admin_details']=$this->AM->get_admin_details($this->session->userdata('id')); 
								$table = ' tbl_termcondition';	
								
								if(isset($_POST['submit']))
								{
							 
							 $id= 1;    
						     $array['title'] = $this->input->post('title');
						     $array['status']=1;
							   $x =$this->UpdateTable($id,$table,$array); 
                                    if($x)
                                            {
                                            $this->session->set_flashdata('success','<div class="alert alert-success text-center" id="successMessage">Data updated successfully</div>');
                                            redirect(base_url()."admin/term_condition");
                                            }
                                    else
                                            {
                                            $this->session->set_flashdata('error','<div class="alert alert-danger text-center" id="successMessage">Unable to update data </div>');
                                            redirect(base_url()."admin/term_condition");
                                            }
        								}
                                        $status = '2';
                	                 	$data['manage_termcondition'] = $this->db->get_where($table,['id'=>1,'status !='=>$status])->row_array(); 
        								$this->load->view('admin/term_condition', $data);
							}
public function Update_Show_Hide_Mobile_Status()
{
$id=$this->input->post('id');
$type=$this->input->post('type');
$button_type=$this->input->post('button_type');
$all=$this->input->post('all');
if($type==1){
    $update_data['team_mobile_status']=$button_type;
    $compare_data1=$this->db->where('type',$type)->where_in('id',$id)->get('tbl_users')->num_rows();
    $compare_data2=$this->db->where('type',$type)->get('tbl_users')->num_rows();
    // print_r($compare_data1."hi");
    // print_r($compare_data2."hi_mm");
    $res=$this->db->where('type',$type)->where_in('id',$id)->update('tbl_users',$update_data);
     if($compare_data1==$compare_data2)
      $this->db->update('app_setting',$update_data);
}elseif($type=="" ){
    $compare_data1=$this->db->where('type in (1,0)')->where_in('id',$id)->get('tbl_users')->num_rows();
    $compare_data2=$this->db->where('type in (1,0)')->get('tbl_users')->num_rows();
    $update_data['team_mobile_status']=$button_type;
    $update_data['player_mobile_status']=$button_type;
    $res=$this->db->where_in('id',$id)->update('tbl_users',$update_data);
    if($compare_data1==$compare_data2)
     $this->db->update('app_setting',$update_data);
}elseif($type==0){
    $update_data['player_mobile_status']=$button_type;
    $compare_data1=$this->db->where('type',$type)->where_in('id',$id)->get('tbl_users')->num_rows();
    $compare_data2=$this->db->where('type',$type)->get('tbl_users')->num_rows();
    $res=$this->db->where('type',$type)->where_in('id',$id)->update('tbl_users',$update_data);
      if($compare_data1==$compare_data2)
       $this->db->update('app_setting',$update_data);
       
}
if($res){
    echo 1;
}else{
    echo 0;
}

}
}
