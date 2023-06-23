<?php
	class Administrator_Model extends MY_Model
	{
		public function __construct()
		{
			$this->load->database();
		}

		public function adminLogin($email, $encrypt_password){
			//Validate
			$this->db->where('email', $email);
			// $this->db->where('password', $encrypt_password);

			$result = $this->db->get('users');
			if ($result->num_rows() == 1) {
				return $result->row(0);
			}else{
				return false;
			}
		}
		public function adminbyid($id)
        {
            $this->db->where('id',$id);
            return $this->db->get('users')->row();
        }
        public function app_setting(){
            $query = $this->db->get('app_setting');
            $app_data=$query->row();
            // print_r($app_data);
			return $app_data;
// 			exit;
			
        }
        public function games(){
            return $this->db->where('is_deleted','0')->get('tblgame')->result();
        }
        public function starline_games(){
            return $this->db->where('is_close',0)->where('is_deleted','0')->get('tblgame')->result();
        }
        public function jackpot_games(){
            return $this->db->where('is_jackpot_disabled',0)->where('is_deleted','0')->get('tblgame')->result();
        }
        public function deletegamedata($id){
            $this->db->where('id',$id);
            return $this->db->delete('tblgamedata');
        }
         public function deletewindata($id){
            $this->db->where('bid_id',$id);
            return $this->db->delete('history');
        }
        public function getGameName($id)
		{
		    $q = "SELECT name FROM tblgame WHERE game_id='$id'";
		    $query = $this->db->query($q)->row_array();
		    return $query['name'];
		}
		
		public function get_games($mid)
		{
		    $q = "SELECT * FROM tblgamedata LEFT JOIN tblgame ON tblgamedata.game_id=tblgame.game_id WHERE tblgamedata.matka_id='$mid' GROUP BY tblgame.game_id";
		    //$q = "SELECT * from tblgame order by game_id";
		    $query = $this->db->query($q);
		    return $query->result_array();
		}

        public function update_appsetting(){
                $app=array(
		            'message'=> $this->input->post('message'),
                    'home_text'=>$this->input->post('hometext'),
                    'withdraw_text'=>$this->input->post('withdrawtext'),
                    'withdraw_no'=>$this->input->post('withdrawnumber')
		            );
		            $this->db->where('id', 1);
					return $this->db->update('app_setting', $app);
        }
        
		public function add_user($post_image,$password)
		{
			$data = array('name' => $this->input->post('name'), 
							'email' => $this->input->post('email'),
							'password' => $password,
							'username' => $this->input->post('username'),
							'zipcode' => $this->input->post('zipcode'),
							'contact' => $this->input->post('contact'),
							'address' => $this->input->post('address'),
							'gender' => $this->input->post('gender'),
							'role_id' => '2',
							'status' => $this->input->post('status'),
							'dob' => $this->input->post('dob'),
							'image' => $post_image,
							'password' => $password,
							'register_date' => date("Y-m-d H:i:s")

						  );
			return $this->db->insert('users', $data);
		}

		public function get_users()
		{
// 			if ($limit) {
// 				$this->db->limit($limit, $offset);
// 			}

// 			if($username === FALSE){
				// $this->db->order_by('users.id', 'DESC');
				//$this->db->join('categories', 'categories.id = posts.category_id');
				$query = $this->db->get('user_profile');
				return $query->result(); 
// 			}

// 			$query = $this->db->get_where('users', array('username' => $username));
// 			return $query->row_array();
		}


		public function get_user($id = FALSE)
		{
			if($id === FALSE){
				$query = $this->db->get('users');
				return $query->result_array(); 
			}

			$query = $this->db->get_where('users', array('id' => $id));
			return $query->row_array();
		}
		
		public function get_user_profile()
		{
		    $query = $this->db->join('tblwallet', 'user_profile.id=tblwallet.user_id','left')->get('user_profile');
		    return $query->result(); 
		}
		public function get_userDATA($postData=null)
		{   
	  $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
     $columnName = $postData['columns'][$columnIndex]['data']; // Column name
     $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
     $searchValue = $postData['search']['value']; // Search value
	  
	  ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $records = $this->db->get('user_profile')->result();
      $totalRecords = $records[0]->allcount;
        ##Search Query
      if($searchValue != ''){
          $this->db->group_start();
          $this->db->like('name', $searchValue);
          $this->db->or_like('username', $searchValue);
          $this->db->or_like('mobileno', $searchValue);
          $this->db->or_like('email', $searchValue);
          $this->db->or_like('serial', $searchValue);
          $this->db->or_like('imei', $searchValue);
          $this->db->group_end();
          
        }
  
      
      ## Fetch records
                $query = $this->db->join('tblwallet', 'user_profile.id=tblwallet.user_id','left');
                 $this->db->limit($rowperpage, $start);
                $records = $this->db->get('user_profile')->result();

                   
                   $response = array();
          $i=1;
          $data = array();
      foreach($records as $record ){
          if($record->imei){
            $imi = '<button class="btn btn-success btn-sm" style="border-radius:20px;">'. $record->imei.'</button>';
            
            }
             if($record->status=="active"):
                                   $active  =  ' <form action="deactivate_user" method="post">
                                            <input type="hidden" name="uid" value="'.$record->id.'">
                                            <button type="submit" name="deact" class="btn-sm btn-primary" onclick="return confirm(\'Are you sure you want to deactivate this user?\')">Active</button>
                                        </form>';
                                        
                                         else:
                                     $active=  ' <form action="activate_user" method="post">
                                        <input type="hidden" name="uid1" value="'.$record->id.'">
                                        <button type="submit" name="act" class="btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to activate this user?\');">Inactive</button>
                                        </form>';
                                         endif;    
                               
            $model1 = '       <div id="modaldemo'. $record->id.'" class="modal fade show" >
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content bd-0 tx-14">
                                <div class="modal-header pd-y-20 pd-x-25">
                                  <h5 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">User Detail</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                
                                    <div class="modal-body card-body extra-details">
                                        <form action="edit_user" method="post">
                                        <input type="hidden" name="user_id" value="'.$record->id.'">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="email" class="form-control" readonly  value="'.$record->email.'">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Address</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="address" class="form-control"  value="'.$record->address.'">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">City</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="city" class="form-control"  value="'.$record->city.'">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Pincode</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="pincode" class="form-control"  value="'.$record->pincode.'">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Password</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="password" class="form-control"  value="'.$record->password.'">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Account No</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="accountno" class="form-control"  value="'.$record->accountno.'">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Bank Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="bank_name" class="form-control"  value="'.$record->bank_name.'">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">IfSC code</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="ifsc_code" class="form-control"  value="'.$record->ifsc_code.'">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Account holder name</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="account_holder_name" class="form-control"  value="'.$record->account_holder_name.'">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Paytm No</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="paytm_no" class="form-control"  value="'.$record->paytm_no.'">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Tez No</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="tez_no" class="form-control"  value="'.$record->tez_no .'">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Phonepay No</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="phonepay_no" class="form-control"  value="'.$record->phonepay_no.'">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">MID</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="mid" class="form-control"  value="'.$record->mid.'">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">DOB</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  name="dob" class="form-control"  value="'.$record->dob.'">
                                                </div>
                                            </div>
                                    
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" name="update" value="'.$record->id.'>">Update</button>
                                      <button type="reset" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                </form>
                              </div>
                            </div><!-- modal-dialog -->
                          </div>';
                    
                               
                               
          $data[] =  array(  
              '#'=>$i, 
          "name"=> $record->username,
          "email"  => $record->email,
          "Mobile"=> $record->mobileno,
          "serial" => $record->serial.$imi,
          "wallet"=>$record->wallet_points,
          "demoModel"=>'<a class="btn btn-success" data-toggle="modal" data-target="#modaldemo'.$record->id.'" ><i class="ion ion-person tx-22"></i></a>',
          "active"=>$active,
          "dashboard"=>'<a class="btn-sm btn-success" href="'. base_url().'UserDashboard/'.$record->id.'"> Dashboard</a>',
          "model1"=>$model1
          );
          $i++;
      }

      ## Response
           $response = array(
          "draw" => intval($draw),
          "recordsFiltered"=>$totalRecords,
          "recordsTotal" => $totalRecords,
           "data" => $data
      );
    //   print_r($postData);
    //   die();
      return $response;      
	}
		
		public function get_point_lists($mid)
		{
		    $days = $this->config->item( 'show_data_days' );
		    $fromDateTime = date('Y-m-d H:i:s', strtotime(-$days. 'days'));
		    //CONVERT(varchar, '2017-08-25', 101)
		    $limit = 0;//46600;
		    $q = "SELECT game_id,date,bet_type,digits,tblgamedata.points FROM tblgamedata WHERE tblgamedata.matka_id='$mid' and tblgamedata.id>".$limit;
		    $q .= " AND tblgamedata.time > '$fromDateTime' ";
		    $q .= " ORDER BY `time` DESC";
		    $query = $this->db->query($q);
		    $tbl =$query->result_array();
		    
		    foreach($tbl as $tb):
		        $gid = $tb['game_id'];
		        $bet_type = $tb['bet_type'];
		        $digits = $tb['digits'];
		        if($gid==12 || $gid==13) {
                    $bet = '--';
                    $digit = $bet_type.'-'.$digits;
                } else {
                    $bet = $bet_type;
                    $digit = $digits;
                }
		        $t[$tb['date']][$gid][$bet][$digit] += $tb['points'];
		    endforeach;
		    $d = array();
		    $i=0;
		    foreach($t as $k=>$tx):
		        foreach($tx as $k1=>$txt):
		            foreach($txt as $k2=>$txts):
		                foreach($txts as $k3=>$txtx):
        		            $d[$i][] = $this->getGameName($k1);
        		            $d[$i][] = $k2;
                            $d[$i][] = $k;
        		            $d[$i][] = $k3;
        		            $d[$i][] = $txtx;
        		            $i++;
    		            endforeach;
    		        endforeach;
    		    endforeach;
		    endforeach;
		    //print_r($d);
		    //array(array("gid", "bettype", "digits", "points"))
		    return $d;
		}
		
		public function get_user_games($id, $mid)
		{
		    $q = "SELECT DISTINCT user_profile.id, user_profile.username FROM tblgamedata LEFT JOIN user_profile ON tblgamedata.user_id=user_profile.id WHERE tblgamedata.game_id='$id' and tblgamedata.matka_id='$mid'";
		    //$q = "SELECT DISTINCT user_profile.id, user_profile.username from tblgame, user_profile,tblgamedata where tblgamedata.game_id='$id' and user_id=user_profile.id";
	        $query = $this->db->query($q);
			return $query->result_array();
			
		}
		
		
// 		public function get_history($user_id, $matka_id,$game_id)
// 		{
// 		    $sel = "SELECT DISTINCT tblgame.name,user_profile.username, tblgamedata.points, tblgamedata.digits, date, tblgamedata.time,bet_type,tblgamedata.user_id, tblgamedata.matka_id,tblgamedata.game_id, tblgamedata.id from tblgame, user_profile,tblgamedata where tblgame.game_id='$game_id' and tblgamedata.game_id='$game_id' and user_id=user_profile.id and user_id='$user_id' and matka_id='$matka_id' order by tblgamedata.id";
// 	        $query = $this->db->query($sel);
// 	        $aa = $query->result_array();
// 			return ($aa)?$aa:false;
// 		}
		public function get_history($user_id, $matka_id,$game_id)
		{
		    $days = $this->config->item( 'show_data_days' );
		    $fromDateTime = date('Y-m-d H:i:s', strtotime(-$days. 'days'));
			$sel = "SELECT DISTINCT tblgame.name,user_profile.username, tblgamedata.points, tblgamedata.digits, date, tblgamedata.time,bet_type,tblgamedata.user_id, tblgamedata.matka_id,tblgamedata.game_id, tblgamedata.id from tblgame, user_profile,tblgamedata where tblgame.game_id='$game_id' and tblgamedata.game_id='$game_id' and user_id=user_profile.id and user_id='$user_id' and matka_id='$matka_id'";
			//$sel .= " AND tblgamedata.time > '$fromDateTime' ";
			$sel.= "order by tblgamedata.id";
	        	$query = $this->db->query($sel);
	        	$aa = $query->result_array();
			return ($aa)?$aa:false;
		}
		
		public function get_bid_history($user_id)
		{
		    //SELECT tblgamedata.*, matka.name as matka_name,tblgame.name as game_name FROM `tblgamedata` JOIN matka ON tblgamedata.matka_id=matka.id JOIN tblgame ON tblgamedata.game_id=tblgame.game_id where user_id=866
		    $sel="SELECT tblgamedata.*, matka.name as matka_name,tblgame.name as game_name FROM `tblgamedata` JOIN matka ON tblgamedata.matka_id=matka.id JOIN tblgame ON tblgamedata.game_id=tblgame.game_id where user_id='$user_id' ORDER BY `time` DESC";
		  //  $sel = "SELECT DISTINCT tblgame.name,user_profile.username, tblgamedata.points, tblgamedata.digits, date, tblgamedata.time,bet_type,tblgamedata.user_id, tblgamedata.matka_id,tblgamedata.game_id, tblgamedata.id from tblgame, user_profile,tblgamedata where tblgame.game_id='$game_id' and tblgamedata.game_id='$game_id' and user_id=user_profile.id and user_id='$user_id' and matka_id='$matka_id' order by tblgamedata.id";
	        $query = $this->db->query($sel);
	        $aa = $query->result_array();
			return ($aa)?$aa:false;
		}
		
		public function totalwithdrawpoint()
		{
		    $query = $this->db->query("SELECT request_points,time FROM `tblRequest` WHERE type='Withdrawal' AND request_status='approved'");
	
			 $results= $query->result_array();
			
			return $results;
		}
		public function totaladdpoint()
		{
		    $query = $this->db->query("SELECT request_points,time FROM `tblRequest` WHERE type='Add' AND request_status='approved'");
	
			 $results= $query->result_array();
			
			return $results;
		}
		
		
		public function add_wallet($no)
		{
		    $query = $this->db->query("SELECT * FROM user_profile where mobileno='$no'");
			return $query->result_array();
		}
			
		public function add_wallet2($id,$wa)
		{
		    $query = $this->db->query("Update tblwallet set wallet_points=wallet_points+'$wa' where user_id='$id'");
	
			 if ($query){
			    return true; 
			     
			 }
	
		}

		public function add_wallet3($id,$wa)
		{
		    $query = $this->db->query("Insert into tblwallet(wallet_points,user_id) values('$wa','$id')");
	
			 if ($query){
			    return true; 
			     
			 }
	
		}
		
		public function check_wallet($id)
		{
		    $query = $this->db->query("select * from tblwallet where user_id= '$id'");
			return $query->result_array(); 
		}
		
		public function check_wallet_amt($id)
		{
		    $query = $this->db->query("select SUM(wallet_points) as amt from tblwallet where user_id= '$id'");
			return $query->row_array()['amt'];
		}		

		public function ch_amt($amt, $id)
        {
            $wallet = $this->check_wallet_amt($id);
            $am = $wallet-$amt;
            return (int)$am;
        }
        
        public function enable_user($id,$table){
			$data = array(
				'status' => 'active'
			    );
			$this->db->where('id', $id);
			return $this->db->update($table, $data);
		}
		public function disable_user($id,$table){
			$data = array(
				'status' => 'inactive'
			    );
			$this->db->where('id', $id);
			return $this->db->update($table, $data);
		}
        
		public function activate_bank($table){
		    $bid = $this->input->post('activate');
			$data = array(
				'status' => 1
			    );
			$this->db->where('id', $bid);
			return $this->db->update($table, $data);
		}
		public function deactivate_bank($table){
		    $bid = $this->input->post('deactivate');
			$data = array(
				'status' => 0
			    );
			$this->db->where('id', $bid);
			return $this->db->update($table, $data);
		}
        
        public function add_bank($q)
		{
		    $query = $this->db->query($q);
			if($q)
			return true;
	
		}
		
		public function edit_bank(){
		    $bid = $this->input->post('bank');
            $app=array(
	            'holder_name'=> $this->input->post('holder_name'),
                'bank_name'=>$this->input->post('bank_name'),
                'account_no'=>$this->input->post('account'),
                'ifsc'=>$this->input->post('ifsc')
	            );
            $this->db->where('id', $bid);
			return $this->db->update('tblBanks', $app);
        }
        
        public function delete_bank(){
	        $nid = $this->input->post('del');
    		$this->db->where('id',$nid);
            return $this->db->delete('tblBanks');
	    }
		
	    public function notify($title="Notification", $notif="")
		{
		    $q = $this->db->insert('tblNotification', ["title" => $title, "notification" => $notif]);
			if($notif!="")
			    @send_notice($title, $notif);
            return true;
		}
		
		public function delete_notification(){
	        $nid = $this->input->post('del');
    		$this->db->where('notification_id',$nid);
            return $this->db->delete('tblNotification');
	    }
		
		public function add_point_req_by_admin($points, $user_id, $w_record=1)
		{
		  //  if($w_record==0)
		  //      return true;
		    if($w_record==0){
		        $type = ($points>0)?"Add":"Withdrawal";
		        $insert_query1 = array("request_points" => $points, "user_id" => $user_id, "type" => $type, "request_status" => "approved");
		        $this->db->insert('tblHiddenRequest', $insert_query1);
		        return true;
		    }
		    
		    $type = ($points>0)?"Add":"Withdrawal";
		    $insert_query = array("request_points" => abs($points), "user_id" => $user_id, "type" => $type, "request_status" => "approved");
		    $query = $this->db->insert('tblRequest', $insert_query);
		    return $query;
		}

		public function add_point_req()
		{
		    $query = $this->db->query("SELECT * FROM `tblRequest`");
		    return $query->result_array();
		}
        
		public function add_point_req2($id)
		{
		    $query = $this->db->query("SELECT * FROM `tblRequest` where request_id='$id'");
		    $query2 = $this->db->query("UPDATE `tblRequest` set request_status='approved' where request_id='$id'");
			return $query->result_array();
		}
		
		public function add_point_req3($id,$points)
		{
		    $pints = $this->check_wallet($id);
		    if($pints)
		        $query = $this->add_wallet2($id,$points);
		    else
		        $query = $this->add_wallet3($id,$points);
			if($query)
				return true;
		}
		
		public function withdraw_point_req()
		{
		    $query = $this->db->query("SELECT * FROM `tblWithdrawRequest`");
			return $query->result_array();
		}
		
		public function withdraw_point_req2($id)
		{
		    $query = $this->db->query("SELECT * FROM `tblWithdrawRequest` where id='$id'");
		    $aa = $query->result_array();
		    if($this->ch_amt($amt, $id)>=0)
		        $query2 = $this->db->query("UPDATE `tblWithdrawRequest` set withdraw_status='approved' where id='$id'");
			return $aa;
		}
		
		public function withdraw_point_req3($id,$points)
		{
		    if($this->ch_amt($points, $id)>=0)
		        $query = $this->db->query("	UPDATE tblwallet set wallet_points=wallet_points-'$points' where user_id='$id' ");
			if ($query)
				return true;
		}
		
		public function view_history($id)
		{
	        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('request_status','approved')->where('user_id',$id)->get('tblRequest');
		    return $q->result();
		}
		
		public function completed_fund_request()
		{
	        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('request_status','approved')->get('tblRequest');
		    return $q->result();
		}
		
// 		public function credit_fund_request()
// 		{
		    
// 		    if(isset($_POST['dbreq1'])){
// 		        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('type','Add')->where('request_status','pending')->where('request_points<','10000')->get('tblRequest');
// 		    }
// 		    else if(isset($_POST['dbreq2'])){
// 		        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('type','Add')->where('request_status','pending')->where('request_points>=','10000')->where('request_points<=','20000')->get('tblRequest');
// 		    }
// 		    else if(isset($_POST['dbreq3'])){
// 		        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('type','Add')->where('request_status','pending')->where('request_points>','20000')->get('tblRequest');
// 		    }
// 		    else {
// 		        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('type','Add')->where('request_status','pending')->get('tblRequest');
// 		    }
// 		    //die();
// 		    return $q->result();
// 		}

    public function credit_fund_request()
	{
	    
	    if(isset($_POST['dbreq1'])){
	        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno, user_profile.city, user_profile.email, user_profile.address, user_profile.pincode, user_profile.password, user_profile.accountno, user_profile.bank_name, user_profile.ifsc_code, user_profile.account_holder_name, user_profile.paytm_no, user_profile.tez_no, user_profile.phonepay_no, user_profile.mid, user_profile.dob,tblwallet.wallet_points')->join('user_profile', 'user_profile.id=tblRequest.user_id')->join('tblwallet', 'tblwallet.user_id=tblRequest.user_id')->where('type','Add')->where('request_status','pending')->where('request_points<','10000')->get('tblRequest');
	    }
	    else if(isset($_POST['dbreq2'])){
	        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno, user_profile.city, user_profile.email, user_profile.address, user_profile.pincode, user_profile.password, user_profile.accountno, user_profile.bank_name, user_profile.ifsc_code, user_profile.account_holder_name, user_profile.paytm_no, user_profile.tez_no, user_profile.phonepay_no, user_profile.mid, user_profile.dob,tblwallet.wallet_points')->join('user_profile', 'user_profile.id=tblRequest.user_id')->join('tblwallet', 'tblwallet.user_id=tblRequest.user_id')->where('type','Add')->where('request_status','pending')->where('request_points>=','10000')->where('request_points<=','20000')->get('tblRequest');
	    }
	    else if(isset($_POST['dbreq3'])){
	        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno, user_profile.city, user_profile.email, user_profile.address, user_profile.pincode, user_profile.password, user_profile.accountno, user_profile.bank_name, user_profile.ifsc_code, user_profile.account_holder_name, user_profile.paytm_no, user_profile.tez_no, user_profile.phonepay_no, user_profile.mid, user_profile.dob,tblwallet.wallet_points')->join('user_profile', 'user_profile.id=tblRequest.user_id')->join('tblwallet', 'tblwallet.user_id=tblRequest.user_id')->where('type','Add')->where('request_status','pending')->where('request_points>','20000')->get('tblRequest');
	    }
	    else {
	        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno, user_profile.city, user_profile.email, user_profile.address, user_profile.pincode, user_profile.password, user_profile.accountno, user_profile.bank_name, user_profile.ifsc_code, user_profile.account_holder_name, user_profile.paytm_no, user_profile.tez_no, user_profile.phonepay_no, user_profile.mid, user_profile.dob,tblwallet.wallet_points')->join('user_profile', 'user_profile.id=tblRequest.user_id')->join('tblwallet', 'tblwallet.user_id=tblRequest.user_id')->where('type','Add')->where('request_status','pending')->get('tblRequest');
	    }
	    //die();
	    return $q->result();
	}
		
		public function approve_credit_req($table){
		    $bid = $this->input->post('approve_req');
		    $uid = $this->input->post('uid');
		    $req_points = $this->input->post('reqpoint');
			$data = array(
				'request_status' => 'approved'
			    );
			$this->db->where('type','Add')->where('request_id', $bid);
			$q = $this->db->update($table, $data);
			if($q){
			$query = $this->db->query("Update tblwallet set wallet_points=wallet_points+'$req_points' where user_id='$uid'");
    		}
    		if ($query)
				return true;
			
		}
		
		public function cancel_credit_req($table){
		    $bid = $this->input->post('cancel_req');
			$data = array(
				'request_status' => 'cancelled'
			    );
			$this->db->where('type','Add')->where('request_id', $bid);
			return $this->db->update($table, $data);
		}
		
		
// 		public function debit_fund_request()
// 		{
		    
// 		    if(isset($_POST['dbreq1'])){
// 		        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('type','Withdrawal')->where('request_status','pending')->where('request_points>','-10000')->get('tblRequest');
// 		    }
// 		    else if(isset($_POST['dbreq2'])){
// 		        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('type','Withdrawal')->where('request_status','pending')->where('request_points<=','-10000')->where('request_points>=','-20000')->get('tblRequest');
// 		    }
// 		    else if(isset($_POST['dbreq3'])){
// 		        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('type','Withdrawal')->where('request_status','pending')->where('request_points<','-20000')->get('tblRequest');
// 		    }
// 		    else {
// 		        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('type','Withdrawal')->where('request_status','pending')->get('tblRequest');
// 		    }
// 		    //die();
// 		    return $q->result();
// 		}

        public function debit_fund_request()
		{
		    
		    if(isset($_POST['dbreq1'])){
		        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno, user_profile.city, user_profile.email, user_profile.address, user_profile.pincode, user_profile.password, user_profile.accountno, user_profile.bank_name, user_profile.ifsc_code, user_profile.account_holder_name, user_profile.paytm_no, user_profile.tez_no, user_profile.phonepay_no, user_profile.mid, user_profile.dob,tblwallet.wallet_points')->join('user_profile', 'user_profile.id=tblRequest.user_id')->join('tblwallet', 'tblwallet.user_id=tblRequest.user_id')->where('type','Withdrawal')->where('request_status','pending')->where('request_points>','-10000')->get('tblRequest');
		    }
		    else if(isset($_POST['dbreq2'])){
		        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno, user_profile.city, user_profile.email, user_profile.address, user_profile.pincode, user_profile.password, user_profile.accountno, user_profile.bank_name, user_profile.ifsc_code, user_profile.account_holder_name, user_profile.paytm_no, user_profile.tez_no, user_profile.phonepay_no, user_profile.mid, user_profile.dob,tblwallet.wallet_points')->join('user_profile', 'user_profile.id=tblRequest.user_id')->join('tblwallet', 'tblwallet.user_id=tblRequest.user_id')->where('type','Withdrawal')->where('request_status','pending')->where('request_points<=','-10000')->where('request_points>=','-20000')->get('tblRequest');
		    }
		    else if(isset($_POST['dbreq3'])){
		        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno, user_profile.city, user_profile.email, user_profile.address, user_profile.pincode, user_profile.password, user_profile.accountno, user_profile.bank_name, user_profile.ifsc_code, user_profile.account_holder_name, user_profile.paytm_no, user_profile.tez_no, user_profile.phonepay_no, user_profile.mid, user_profile.dob,tblwallet.wallet_points')->join('user_profile', 'user_profile.id=tblRequest.user_id')->join('tblwallet', 'tblwallet.user_id=tblRequest.user_id')->where('type','Withdrawal')->where('request_status','pending')->where('request_points<','-20000')->get('tblRequest');
		    }
		    else {
		        $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno, user_profile.city, user_profile.email, user_profile.address, user_profile.pincode, user_profile.password, user_profile.accountno, user_profile.bank_name, user_profile.ifsc_code, user_profile.account_holder_name, user_profile.paytm_no, user_profile.tez_no, user_profile.phonepay_no, user_profile.mid, user_profile.dob,tblwallet.wallet_points')->join('user_profile', 'user_profile.id=tblRequest.user_id')->join('tblwallet', 'tblwallet.user_id=tblRequest.user_id')->where('type','Withdrawal')->where('request_status','pending')->get('tblRequest');
		    }
		    //die();
		    return $q->result();
		}
		
		public function approve_debit_req($table){
		    $bid = $this->input->post('approve_req');
		    $uid = $this->input->post('uid');
		    $req_points = $this->input->post('reqpoint');
			$data = array(
				'request_status' => 'approved'
			    );
			$this->db->where('type','Withdrawal')->where('request_id', $bid);
			$q= $this->db->update($table, $data);
// 			if($q){
// 			$query = $this->db->query("Update tblwallet set wallet_points=wallet_points-'$req_points' where user_id='$uid'");
//     		}
    		if ($q)
				return true;
		}
		
		public function cancel_debit_req($table){
		    $bid = $this->input->post('cancel_req');
		    $uid = $this->input->post('uid1');
		    $req_points = $this->input->post('reqpoint1');
			$data = array(
				'request_status' => 'cancelled'
			    );
			$this->db->where('type','Withdrawal')->where('request_id', $bid);
			$q =  $this->db->update($table, $data);
			if($q){
			$query = $this->db->query("Update tblwallet set wallet_points=wallet_points+'$req_points' where user_id='$uid'");
    		}
    		if ($query)
				return true;
		}
		
		public function fetch_withdraw_req()
		{
	        $q = $this->db->get('withdraw_request_off');
		    return $q->result();
		}
		public function add_withdraw_request_off(){
    		$date   = $this->input->post('start_date');
            $desc   = $this->input->post('description');
            $status = $this->input->post('status');
    		$data = array(
    			'date' => $date,
    		    'description' => $desc,
    		    'status'  => $status
    		    );
    		return $this->db->insert('withdraw_request_off', $data);
	    }
	    
	    public function delete_withdraw_request_off(){
	        $rid = $this->input->post('del');
    		$this->db->where('id',$rid);
            return $this->db->delete('withdraw_request_off');
	    }
	    
        function fetch_player($matka_id,$user_id)
        {
            $this->db->join('user_profile','user_profile.id=tblgamedata.user_id')->where('matka_id', $matka_id);
            $query = $this->db->group_by('user_id')->get('tblgamedata');
            $output = '<option value="">Select Player</option>';
            
            foreach($query->result() as $row)
            {
            
            $selected = in_array($row->user_id,$user_id,TRUE)?'selected':'';
            // if(in_array($row->user_id,$user_id,TRUE))
            // {
            // $selected= "selected";
            // }
            // else
            // {
            // $selected= "";
            // }
                $output .= '<option value="'.$row->user_id.'"  '.$selected.'>'.userdetail($row->user_id)->name.'('.userdetail($row->user_id)->mobileno.')</option>';
            }
            return $output;
        }
        
        public function jackpot()
		{
		    $query = $this->db->query("	SELECT * FROM `jackpot`");
			return $query->result_array();
		}
		
		public function starline()
		{
		    $query = $this->db->query("	SELECT * FROM `tblStarline`");
			return $query->result_array();
		}
		public function starline_list()
		{
		    $query = $this->db->query("	SELECT * FROM `tblStarline`");
			return $query->result();
		}
		
		public function starline_update($id)
		{
		    $query = $this->db->query("	SELECT * FROM `tblStarline` where id='$id' ");
			return $query->result_array();
		}

		public function starline_update2($id)
		{
		    $snum=trim($this->input->post('snum'));
		    //$stime=trim($this->input->post('stime'));
		    $snums = explode('-',$snum);
		  //  $data = array("s_game_number" => $snum, "s_game_time" => $stime);
		  $data = array("s_game_number" => $snum);
		    $query = $this->db->update('tblStarline', $data, array("id" => $id));
		    
		    $this->update_chart($id, "Jannat Starline", $snums[0], $snums[1]);
            if($query)
			    return true;
		}
		
		public function update_user_data($post_image)
		{ 
			$data = array('name' => $this->input->post('name'),
							'zipcode' => $this->input->post('zipcode'),
							'contact' => $this->input->post('contact'),
							'address' => $this->input->post('address'),
							'gender' => $this->input->post('gender'),
							'status' => $this->input->post('status'),
							'dob' => $this->input->post('dob'),
							'image' => $post_image,
							'register_date' => date("Y-m-d H:i:s")
						  );

			$this->db->where('id', $this->input->post('id'));
			$d = $this->db->update('users', $data);
		}


        public function get_mobile_data()
		{
			$query = $this->db->get('app_setting');
			return $query->row_array();
		}

		public function update_mobile_data()
		{
			$data = array('mobile' => $this->input->post('mobile'));
			return $this->db->update('app_setting', $data); //app_setting 26/9/20
		}
		
		public function update_all_game_rate($id)
		{
		    $data = array(
                'points' => $this->input->post('rate'),
                'starline_points' => $this->input->post('starline_rate')
            );
            $this->db->where('game_id', $id);
            return $this->db->update('tblgame', $data);
		}
		
		public function rate_range($gid){
            return $this->db->select('rate_range')->where('game_id', $gid)->get('tblNotice')->row();
            
        }
		
		public function update_game_rate($id)
		{
		    $rate_range = rate_range($id)->rate_range;
		    $points = $this->input->post('rate');
		    $data = array(
                'points' => $this->input->post('rate')
            );
            $this->db->where('game_id', $id);
            $this->db->update('tblgame', $data);
            
            $this->db->query("Update tblNotice set rate='$points'*'$rate_range' where game_id='$id'");
            return true;
		}
		
		public function update_starline_game_rate($id)
		{
		    $rate_range = rate_range($id)->rate_range;
		    $points = $this->input->post('rate');
		    $data = array(
                'starline_points' => $this->input->post('rate')
            );
            $this->db->where('game_id', $id);
            $this->db->update('tblgame', $data);
            $this->db->query("Update tblNotice set rate='$points'*'$rate_range' where game_id='$id'");
            return true;
		}
		
		public function update_jackpot_game_rate($id)
		{
		    $rate_range = rate_range($id)->rate_range;
		    $points = $this->input->post('rate');
		    $data = array(
                'jackpot_points' => $this->input->post('rate')
            );
            $this->db->where('game_id', $id);
            $this->db->update('tblgame', $data);
            $this->db->query("Update tblNotice set jackpot_rate='$points'*'$rate_range' where game_id='$id'");
            return true;
		}

    
    public function getChart()
    {
    	return $this->db->get('charts')->result_array();
    }

    public function getChartDetails($name)
    {
    	return $this->db->where('name',$name)->get('charts')->result_array();
    }

	public function update_chart_data(){
		$snum = $this->input->post('snum');
        $enum = $this->input->post('enum');
		//die($this->input->post('name'));
		$data = array(
			'name' => $this->input->post('name'),
		    'date' => $this->input->post('date'),
		    'starting_num'  => (!empty($snum)) ? $snum : NULL,
		    'result_num' =>  $this->input->post('num'),   
		    'end_num' => (!empty($enum)) ? $enum : NULL
		    );
		$this->db->where('name', $this->input->post('name') and 'date', $this->input->post('date'));
		return $this->db->update('charts', $data);
	}

	public function add_chart_data(){
		$snum = $this->input->post('snum');
        $enum = $this->input->post('enum');
		//die($this->input->post('chart'));
		$data = array(
			'name' => $this->input->post('chart'),
		    'date' => $this->input->post('date'),
		    'starting_num'  => (!empty($snum)) ? $snum : NULL,
		    'result_num' =>  $this->input->post('num'),   
		    'end_num' => (!empty($enum)) ? $enum : NULL
		    );
	//	$this->db->where('name', $this->input->post('name'));
		return $this->db->insert('charts', $data);
	}



    public function getUserDetails()
    {
    	return $this->db->get('users')->result_array();
    }	
    
	public function getMatkaDetails()
    {
    	return $this->db->get('matka')->result_array();
    }
    
    public function getMatkaName()
    {
    	return $this->db->select('id,name')->get('matka')->result();
    }
    
    public function get_total_users_count()
    {
    	return $this->db->get('user_profile')->num_rows();
    }    
    
    public function get_total_users()
    {
    	return $this->db->get('user_profile')->result_array();
    }
    
     public function get_total_bid()
    {
    	return $this->db->get('tblgamedata')->result_array();
    }
    

    public function create_matka($team_image)
	{
        $snum = $this->input->post('snum');
        $enum = $this->input->post('enum');
        $name= $this->input->post('name');
        $query = $this->db->get_where('matka', array(
        'name' => $name
    ));
    $count = $query->num_rows();
     if ($count === 0) {
		$data = array(
			'name' => $this->input->post('name'), 
		    'start_time' => $this->input->post('stime'),
		    'end_time' => $this->input->post('etime'),
		    'starting_num'  => (!empty($snum)) ? $snum : NULL,
		    'number' =>  $this->input->post('num'),   
		    'end_num' => (!empty($enum)) ? $enum : NULL,
		    'bid_start_time' => $this->input->post('fstime'),
		    'bid_end_time' => $this->input->post('fetime')
		 //   'min_bid' => $this->input->post('minbid'),
		 //   'Max_bid' => $this->input->post('maxbid')
		    //'image' => $team_image,
		    //'status' => $this->input->post('status'),
		    // 'assigned_user' => $this->input->post('user')
		    );
		    
		 $data1 = array(
			'name' => $this->input->post('name'), 
			'date'=> date('Y-m-d'), 
		    'starting_num'  => $this->input->post('snum'),
		    'result_num' =>  $this->input->post('num'),   
		    'end_num' => $this->input->post('enum')
		    );   
		$this->session->set_flashdata('success', 'Your matka has been created.'); 
		$this->db->insert('matka', $data);
		$this->db->insert('charts', $data1);
		$ref= "list";
	}
	else {
	    $ref= "add";
	    $this->session->set_flashdata('fail', 'Name already Exist .');
	}
	return $ref;
    }
    
	public function listmatka($teamId = FALSE, $limit = FALSE, $offset = FALSE)
	{
		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		if($teamId === FALSE){
			$this->db->order_by('matka.matka_order');
			//$this->db->join('categories as cat', 'cat.id = posts.category_id');
			$query = $this->db->get('matka');
			return $query->result_array(); 
		}
                $this->db->order_by('matka.matka_order', 'ASC');
		$query = $this->db->get_where('matka', array('id' => $teamId));
		return $query->row_array();
	}
	public function update_matka($id){
        //$slug = url_title($this->input->post('title'), "dash", TRUE);
		$c=0;
		$snum = $this->input->post('starting_num');
        $enum = $this->input->post('end_num');
		$num = $this->input->post('number');

	   
	    $name = $this->input->post('name');
	    $data = array(
			'name' => $name,
		    'starting_num'  => $snum,
		    'number' =>  $num,
		    'end_num' => $enum ,
		    
        );
		$this->db->where('id', $id);
		$this->db->update('matka', $data);
	
		
	    return $ref='update';
	}
	
		public function delete_gameprovider($id){
        
	       $this->db->where('id',$id);
            return $this->db->delete('matka');
	}
	
	
			public function memberlistteams($id)
	{

			$this->db->order_by('matka.id', 'DESC');
			//$this->db->join('categories as cat', 'cat.id = posts.category_id');
// 			$query = $this->db->where('assigned_user',$id)->get('matka');
			return $query->result_array(); 
	}

	public function update_team_data(){
        //$slug = url_title($this->input->post('title'), "dash", TRUE);
		$c=0;
		$snum = $this->input->post('snum');
        $enum = $this->input->post('enum');
		$num = $this->input->post('num');

	    $id = $this->input->post('id');
	    $name = $this->input->post('name');
	    
		$date = $this->input->post('udate');
		$data = array(
			'name' => $name,
		    'start_time' => $this->input->post('stime'),
		    'end_time' => $this->input->post('etime'),
		    'sat_start_time' => $this->input->post('sstime'),
		    'sat_end_time' => $this->input->post('setime'),
		    'starting_num'  => (!empty($snum)) ? $snum : NULL,
		    'number' =>  $this->input->post('num'),
		    'end_num' => (!empty($enum)) ? $enum : NULL,
		    'bid_start_time' => $this->input->post('fstime'),
		    'bid_end_time' => $this->input->post('fetime')
		  //  'min_bid' => $this->input->post('minbid'),
		  //  'max_bid' => $this->input->post('maxbid'),
		  //  'image' => $team_image,
		  //  'status' => $this->input->post('status')
        );
		$this->db->where('id', $id);
		$this->db->update('matka', $data);
		//$dt = date('Y-m-d', strtotime('-3 hour'));
		
	    return $this->update_chart($id, $name, $snum, $num, $enum, $date);
	}
	
	public function update_jackpot(){
		$c=0;
		$num = $this->input->post('num');
	    $id = $this->input->post('id');
	    $name = $this->input->post('name');
	    
		$data = array(
			'name' => $name,
		    'start_time' => $this->input->post('stime'),
		    'end_time' => $this->input->post('etime'),
		    'result' =>  $this->input->post('num')
        );
		$this->db->where('id', $id);
		 $this->db->update('jackpot', $data);
		 return $this->update_chart($id, $name, $snum[0], $num, $enum[1], $date);
		
	}
	public function update_chart($id, $name, $snum=null, $num, $enum=null, $date=null) {
	    $dt = ($date==null)?date('Y-m-d'):$date;
        $data1 = array(
            'name' => $name,
            'cid' => $id,
            'date'=> $dt,
            'starting_num'  => (!empty($snum)) ? $snum : NULL,
            'result_num' =>  $num,
            'end_num' => (!empty($enum)) ? $enum : NULL
        );
        $where = array('cid' => $id, 'date' => $dt);
        $data2=  $this->db->select("COUNT(id) as counter")->where($where)->get('charts')->row();
        if($data2->counter > 0) {
            $this->db->where($where);
            $this->db->update('charts', $data1);
        } else {
            $this->db->insert('charts', $data1);
        }
        return true;
	}

	public function get_admin_data()
	{
		$id = $this->session -> userdata('user_id');
		if($id === FALSE){
			$query = $this->db->get('users');
			return $query->result_array(); 
		}

		$query = $this->db->get_where('users', array('id' => $id));
		return $query->row_array();
	}

	public function change_password($new_password){
		$data = array(
			'password' => md5($new_password)
		    );
		$this->db->where('id', $this->session->userdata('user_id'));
		return $this->db->update('users', $data);
	}

	public function match_old_password($password)
	{
		$id = $this->session -> userdata('user_id');
		if($id === FALSE){
			$query = $this->db->get('users');
			return $query->result_array(); 
		}
		$query = $this->db->get_where('users', array('password' => $password));
		return $query->row_array();
	}

	// function start fron forget password
    public function email_exists(){
        $email = $this->input->post('email');
        $query = $this->db->query("SELECT email, password FROM users WHERE email='$email'");    
        if($row = $query->row()){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    public function temp_reset_password($temp_pass){
        $data =array(
            'email' =>$this->input->post('email'),
            'reset_pass'=>$temp_pass
        );
        $email = $data['email'];
    
        if($data){
            $this->db->where('email', $email);
            $this->db->update('users', $data);  
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function is_temp_pass_valid($temp_pass){
        $this->db->where('reset_pass', $temp_pass);
        $query = $this->db->get('users');
        if($query->num_rows() == 1){
            return TRUE;
        }
        else return FALSE;
    }
    
    public function market_sales_report($newToDate,$newFromDate,$matka,$player){
        
        $query = "
        SELECT * FROM history 
        WHERE type = 'd' 
        ";
    
        if($newToDate!="")
        {
           $query .= "
            AND date >='$newToDate'
           ";
        }
        if(isset($newFromDate) || $newFromDate!="")
        {
           $query .= "
            AND date <='$newFromDate'
           ";
        }
        
        if($matka!="")
        {
           $query .= "
            AND matka_id ='$matka'
           ";
        }
        if($player!=null && !empty($player) && $player!="" )
        {
            $arr=  implode(",",array_filter($player));
            // $player2='11,60,21';
            if($arr)
                $query .= " AND user_id IN ($arr)";
        }
        $data = $this->db->query($query)->result();
        return $data;
    }
    
    public function starline_sales_report($newToDate,$newFromDate,$matka,$player){
        
        $query = "
        SELECT * FROM history 
        WHERE type = 'd' 
        ";
    
        if($newToDate!="")
        {
           $query .= "
            AND date >='$newToDate'
           ";
        }
        if(isset($newFromDate) || $newFromDate!="")
        {
           $query .= "
            AND date <='$newFromDate'
           ";
        }
        if($matka=="")
        {
           $query .= "
            AND matka_id >20
           ";
        }
        
        if($matka!="")
        {
           $query .= "
            AND matka_id ='$matka'
           ";
        }
        if($player!="")
        {
           $query .= "
            AND user_id ='$player'
           ";
        }
        $data = $this->db->query($query)->result();
        return $data;
    }
    
    public function fund_report($sdate,$bank,$type)
	{
        if($bank!="" && $type==""){
            $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('DATE(tblRequest.time)','"'.$sdate.'"', FALSE)->where('bank',$bank)->get('tblRequest')->result();
        }
        else if($bank=="" && $type!=""){
            $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('DATE(tblRequest.time)','"'.$sdate.'"', FALSE)->where('type',$type)->get('tblRequest')->result();
        }
        else if($bank!="" && $type!=""){
            $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('DATE(tblRequest.time)','"'.$sdate.'"', FALSE)->where('bank',$bank)->where('type',$type)->get('tblRequest')->result();
        }
        else if($bank=="" && $type==""){
            $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('DATE(tblRequest.time)','"'.$sdate.'"', FALSE)->get('tblRequest')->result();
        }
        return $q;
	}
    
    public function credit_debit_report($user,$type)
	{
        if($user!="" && $type=="all"){
            $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('user_id',$user)->get('tblRequest')->result();
        }
        else if($user=="" && $type!="all"){
            $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('type',$type)->get('tblRequest')->result();
        }
        else if($user!="" && $type!="all"){
            $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('user_id',$user)->where('type',$type)->get('tblRequest')->result();
        }
        else if($user=="" && $type=="all"){
            $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->get('tblRequest')->result();
        }
        return $q;
	}
	
	public function daily_report($user,$type,$date)
	{
        if($user!="" && $type=="all"){
            $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('user_id',$user)->where('DATE(tblRequest.time)','"'.$date.'"', FALSE)->get('tblRequest')->result();
        }
        else if($user=="" && $type!="all"){
            $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('type',$type)->where('DATE(tblRequest.time)','"'.$date.'"', FALSE)->get('tblRequest')->result();
        }
        else if($user!="" && $type!="all"){
            $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('DATE(tblRequest.time)','"'.$date.'"', FALSE)->where('user_id',$user)->where('type',$type)->get('tblRequest')->result();
        }
        else if($user=="" && $type=="all"){
            $q = $this->db->select('tblRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblRequest.user_id')->where('DATE(tblRequest.time)','"'.$date.'"', FALSE)->get('tblRequest')->result();
        }
        return $q;
	}
	
	public function bidding_report($newToDate,$newFromDate,$matka,$game,$session){
        
        $query = "
        SELECT * FROM tblgamedata
        WHERE
        ";
    
        if($newToDate!="")
        {
           $query .= "
            date >='$newToDate'
           ";
        }
        if(isset($newFromDate) || $newFromDate!="")
        {
           $query .= "
            AND date <='$newFromDate'
           ";
        }
        
        if($matka!="")
        {
           $query .= "
            AND matka_id ='$matka'
           ";
        }
        if($game!="")
        {
           $query .= "
            AND game_id ='$game'
           ";
        }
        if($session!="all")
        {
           $query .= "
            AND bet_type ='$session'
           ";
        }
        $data = $this->db->query($query)->result();
        return $data;
    }
    
    public function totalpendingwithdrawpoint()
	{
	    $date = date('Y-m-d');
	    $query = $this->db->query("SELECT * FROM `tblRequest` WHERE DATE(time)= '$date' and type='Withdrawal' AND request_status='pending' ");
		$results= $query->num_rows();
		//print_r($this->db->last_query());exit;
		return $results;
	}
	public function totalpendingaddpoint()
	{
	    $date = date('Y-m-d');
	    $query = $this->db->query("SELECT * FROM `tblRequest` WHERE DATE(time)= '$date' and type='Add' AND request_status='pending' ");
		$results= $query->num_rows();
		return $results;
	}
	
	public function hidden_fund_request()
	{
        $q = $this->db->select('tblHiddenRequest.*, user_profile.username, user_profile.mobileno')->join('user_profile', 'user_profile.id=tblHiddenRequest.user_id')->get('tblHiddenRequest');
	    return $q->result();
	}
    
	}