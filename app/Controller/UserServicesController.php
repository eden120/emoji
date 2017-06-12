<?php
	/**
	* User Controller class
	* PHP versions 5.1.4
	* @date 24-Dec-2014
	* @Purpose:This controller handles all the functionalities regarding web services.
	* @filesource
	* @revision
	* @version 0.0.1
	**/
         	App::uses('Sanitize', 'Utility');

            class UserServicesController extends AppController {
	
            var $name  =  "Users";
    
    /*
    *
	* Specifies helpers classes used in the view pages
	* @access public
	*/
    
            public $helpers    	=  array();

    /**
	* Specifies components classes used
	* @access public
    */

            var $components 	=  array('RequestHandler','Email','Common','Upload','Paginator');
            var $paginate		=  array();
            var $uses=  array('User','Image','Bar','Drink','History','Tender','Favourite','Location','Payment','Question','City');// For Default Model
       	
#_________________________________________________________________________#

    /**
    * @Date: 24-Dec-2014
    * @Method : beforeFilter
    * @Purpose: This function is called before any other function.
    * @Param: none
    * @Return: none 
    **/

    function beforeFilter(){
	        App::uses('CakeTime', 'Utility'); 
			
			if(!empty($this->data)&&trim($this->data['auth_key']) == API_AUTH_KEY){
				$method = $this->data['method'];
				$this->$method();
			}elseif($this->params["action"] == 'image'){
				 
			}else{
				$result = array('status'=>'0','message'=>"Authenticated key not matched");
				echo json_encode($result);
				die;
			}
    }
 
#_________________________________________________________________________#	


 /**
    * @Date: 24 MAY 2016
    * @Method : register
    * @Purpose: This page will render home page
    * @Param: none
    * @Return: none 
    **/
	function register(){
	
		$saveArray = $this->data;

        $saveArray['deleted'] = 1;	
        

        unset($saveArray['id']);	
		$this->User->set($saveArray);
		$isValidated = $this->User->validates();
			if($isValidated){

				$saveArray['password'] = md5($saveArray['password']);			
			
			      $save=$this->User->save($saveArray,array('validate'=>false));
                         
						$id = $this->User->id;
						
						
						if(!empty($id)){
				
	  			$result = array ('status'=>'1','message'=>"Registered Successfully",'Id' =>                $id,'Email'=>$saveArray['email'],'DOB'=>$saveArray['dob'],'Country'=>$saveArray['country']);
						}else
						{
							$result = array ('status'=>'0','message'=>"Unable to Signup");
						}
			}else{
				    $errors = $this->errorValidation('User');
				    $result = array('status'=>'0','error'=>$errors);
			}
			echo json_encode($result);
			die;
	}
	
	#_________________________________________________________________________#


	/**
    * @Date: 24 May 2016
    * @Method : login
    * @Purpose: This function is used to login user
    * @Param: none
    * @Return: none 
    **/
	 function login()
	 
	 {
		    $saveArray = $this->data;	
		    $this->User->set($saveArray);
			$isvalidated = $this->User->validator()->remove('unique');
		   // $isValidated= $this->User->login_custom_validation();
		   // $isValidated = $this->User->validates();
			if($isvalidated){
				  $password = md5($saveArray['password']);
				  $condition = "email='".$saveArray['email']."' AND password='".$password."' ";	
				  $user = $this->User->find('first', array("conditions" => $condition));
			//pr($user);die;
		//pr($user['User']['verified']);die;
				if(!empty($user)){
					
				       $result=array('status'=>'1','message'=>"Login Successfully",'id' => $user['User']['id'],'Email'=>$user['User']['email'],'DOB'=>$user['User']['dob'],'Country'=>$user['User']['country']);
			
				}else{
					   $result = array('status'=>'0','message'=>'Email or Password is Incorrect');
				}
			}else{
				  $errors = $this->errorValidation('User');
				  $result = array('status'=>'0','error'=>$errors);
			}
		    echo json_encode($result);
	        die;  
	    } 
		
		
			#_________________________________________________________________________#
	
	
	  /**
    * @Date: 24 May 2016
    * @Method : forget_password
    * @Purpose: This Function is used to Recover Password.
    * @Param: none
    * @Return: none 
    **/
	function forget_password(){
		 
		$this->User->set($this->data);
		$this->User->validate = array(
						'email' => array(
					        'rule' => 'notEmpty',
					        'required' => true,
					        'message' => "Enter email."
					  ));
		 	
	  if($this->User->validates()){
			   $condition = "email='".Sanitize::escape($this->data['email'])."' and user_type !=1 AND Deleted = 1";			
			   $emp_details = $this->User->find('first', array("conditions" => $condition, "fields" => array("id","email")));
			   $result = array('status'=>'0',"message"=>"Email id not exist!!");
			   if($emp_details){
				// Reset password
				$resetPassword = rand(100000,999999);
				$subject = "Forgot your Password!";
				// Send mail to User
				$name    = $emp_details['User']['email'];
				$this->Email->to       = trim($emp_details['User']['email']);
				$this->Email->subject  = $subject;
				$this->Email->replyTo  = ADMIN_EMAIL;
				$this->Email->from     = SITE_NAME."<".ADMIN_EMAIL.">";
				$this->Email->fromName = SITE_NAME;
				$this->Email->sendAs   = 'html';
				// set values to be used on email template
				
$message = "Dear <span style='color:#666666'>".$name."</span>,<br/><br/>Your password has been reset successfully.<br/><br/>Please find the following login details:<br/><br/>Email: ".$emp_details['User']['email']."<br/>Password: ".$resetPassword."<br/><br/>Thanks, <br/>Support Team";;

				if ($this->Email->send($message)) {
					$this->User->updateAll(array("password"=>"'".md5($resetPassword)."'"),array("id"=>$emp_details['User']['id']));
					$result = array('status'=>'1',"message"=>"Your password has been reset and successfully sent to your email id.");
				}
					 
			} 

			}else{
				  $errors = $this->errorValidation('User');
				  $result = array('status'=>'0','error'=>$errors);
		        }
			echo json_encode($result);
			die;
  
	}


	/**
		* @Date: 25 May 2016
		* @Method : update device_id
		* @Purpose: This function is used to update Device id.
		* @Param: none
		* @Return: none 
		**/
		
    function device_id(){
		$saveArray = $this->data;
        $this->User->device_custom_validation();		
		$this->User->set($saveArray);
		//$isValidated = $this->User->validates();
			if($saveArray){			
				  $this->User->save($saveArray, array('validate'=>false)); 
				  $id = $this->User->id;
                
				if(!empty($id)){
                // $this->User->updateAll(array("User.device_id='".$saveArray['device_id']."'","User.device_type='".$saveArray['device_type']."'",'User.id ='=>$id));
				
				  $this->User->updateAll(array('device_id' => "'".$saveArray['device_id']."'",'device_type' => "'".$saveArray['device_type']."'"), array('id' => $saveArray['id']));
					$result = array ('status'=>'1','message'=>"Updated Successfully.");
				}else{
				 $result = array ('status'=>'0','message'=>"Unable to Update.");
				}
			}else{
				 
				  $result = array('status'=>'0','error'=>"failed");
			}
			echo json_encode($result);
			die;  
	}
	
	/**
    * @Date: 16th March 2016
    * @Method : LatLng
    * @Purpose: This function is used to update LatLng.
    * @Param: none
    * @Return: none 
    **/

     function LatLng(){
		    $saveArray = $this->data;
            $this->User->edit_custom_validation();		
		    $this->User->set($saveArray);
			$isValidated = $this->User->validates();
			if($isValidated){					
				    $this->User->save($saveArray, array('validate'=>false)); 
				    $id = $this->User->id;
				if(!empty($id)){
					$result = array ('status'=>'1','message'=>"Updated Successfully.");
				}else{
				    $result = array ('status'=>'0','message'=>"Unable to Update.");
				}
			}else{
				    $errors = $this->errorValidation('User');
				    $result = array('status'=>'0','error'=>$errors);
			}
			echo json_encode($result);
			die;  
	}	


/**
    * @Date: 16th March 2016
    * @Method : LatLng
    * @Purpose: This function is used to update LatLng.
    * @Param: none
    * @Return: none 
    **/

     function view_all_bars(){
		      $saveArray = $this->data;
			  if($saveArray['lat'] AND $saveArray['lng']){
					$latitude =  $saveArray['lat'];
                $longitude =  $saveArray['lng'];
				$mile = 10000;
				$a=$this->Bar->virtualFields 
				= array('distance'
				 => '(3966 * acos (cos ( radians('.$latitude.') )
				* cos( radians( Bar.lat ) )
				* cos( radians( Bar.lng ) 
				- radians('.$longitude.') )
				+ sin ( radians('.$latitude.') )
				* sin( radians( Bar.lat ) )))');	
				// $query = "SELECT  *,3956 * 2 * ASIN(SQRT( POWER(SIN(($latitude - lat) * pi()/180 / 2), 2) + COS($latitude * pi()/180) * COS(lat * pi()/180) *POWER(SIN(($longitude - lng) * pi()/180 / 2), 2) )) as distance FROM bars HAVING distance <= 5000000 ORDER by distance ASC;";
					// WHERE distance >= $mile";
			// $e=$this->Bar->query($query);
			// pr($e);die;
			  $find = $this->Bar->find('all',array('conditions' => array(
				'distance <' => $mile),'order' => array('Bar.distance' => 'ASC')));			
				//pr($find);die;
				if(!empty($find)){

				foreach($find as $find){
					//$mi = $find['Bar']['distance'] / 1.609344;
					
			
				$record[]=array('Bar Id'=> $find['Bar']['id'],
				'Bar name'=> $find['Bar']['name'],
				'lat and lng'=>$find['Bar']['lat'].",".$find['Bar']['lng'],
				'Bar distance'=>$find['Bar']['distance'],
				'Bar image'=> BASE_URL."app/webroot/img/".$find['Bar']['image'],);
				}
					$result = array ('status'=>'1','result'=>$record);
				}else{
				    $result = array ('status'=>'0','message'=>"No data.");
				}
			  }
			  else{
				  $result = array ('status'=>'0','message'=>"Please fill all the fileds"); 
			  }
			echo json_encode($result);
			die;  
	}	
	
	
	
/**
    * @Date: 16th March 2016
    * @Method : LatLng
    * @Purpose: This function is used to update LatLng.
    * @Param: none
    * @Return: none 
    **/

     function drinks_bars(){
     
		    $saveArray = $this->data;
           // $this->Bar->edit_custom_validation();		
		   // $this->Drink->set($saveArray);
			//$isValidated = $this->Drink->validates();
			if($saveArray){	
            $con= "Drink.barid='".$saveArray['id']."'";			
				  $find=$this->Drink->find('all',array('conditions'=>$con));
			             //pr($find);die;
				if(!empty($find)){

				foreach($find as $find){
				$record[]=array('Drink Id'=> $find['Drink']['id'],
				'Drink name'=> $find['Drink']['name'],
				'Drink Description'=> $find['Drink']['description'],
				'Drink image'=> BASE_URL."app/webroot/img/".$find['Drink']['img'],);
			         }
				
				
					$result = array ('status'=>'1','result'=>$record);
				}else{
				    $result = array ('status'=>'0','message'=>"No record");
				}
			}else{
				    $errors = $this->errorValidation('User');
				    $result = array('status'=>'0','error'=>$errors);
			}
			echo json_encode($result);
			die;  
	}	
	
		
/**
    * @Date: 16th March 2016
    * @Method : LatLng
    * @Purpose: This function is used to update LatLng.
    * @Param: none
    * @Return: none 
    **/
	
	function check_time(){
		    $saveArray = $this->data;
       // pr(date('Y-m-d H:i:s'));die;
			if($saveArray){	
			$condition="Payment.userid='".$saveArray['userid']."'";
				$get=$this->Payment->find('first',array('conditions'=>$condition));
				if(!empty($get)){
					if($get['Payment']['expire_date']<date('Y-m-d')){
							 $result = array ('status'=>'3','message'=>"Your subscription pack is over");
					}
					else{
						$date=date("Y-m-d H:i:s");
						//$a=date("09:56:00");
						//pr((date("09:55:00")<date("H:i:s")));die;
						if((date("09:55:00")<date("H:i:s")) AND (date("10:00:00")>date("H:i:s")) ){
							 $result = array ('status'=>'0','message'=>"You can redeem drink after 10 am");
							
						}
						else{
						   $con=array('AND'=>array(
						  "Tender.user_id='".$saveArray['userid']."'", 
							
						  ));
						 
						  $find=$this->Tender->find('all',array('conditions'=>$con));
						  //pr($find);
						if(!empty($find)){
							foreach($find as $find){
								//pr(date('Y-m-d',strtotime($find['Tender']['datetime'])));
								if(date('Y-m-d',strtotime($find['Tender']['datetime']))==date('Y-m-d')){
									if((date('h:i:s')>date('h:i:s',strtotime($find['Tender']['datetime']))) ){
									
									$result = array ('status'=>'0','message'=>"24 hours is not completed yet");	
								}}
								else{
									$data="'".date('Y-m-d H:i:s')."'";
									
									$a=$this->Tender->updateAll(array(
									'Tender.datetime' => $data),
										array("Tender.user_id='".$saveArray['userid']."'"));
										
										if($a){
											$result = array ('status'=>'1','result'=>"record save");
										}
										else{
											$result = array ('status'=>'0','message'=>"record not save");
										}
								 }
								}
						
					
						
						
						}
						else{
								$saveArray['user_id']=$this->data['userid'];
								$saveArray['datetime']=date("Y-m-d H:i:s");
								$save=$this->Tender->save($saveArray);
								if($save){
								$result = array ('status'=>'1','message'=>"record save");
								}
								else{
								$result = array ('status'=>'0','message'=>"record not save");	
								}
							}
					 }
				
				}
			}
				
				else{
					 $result = array ('status'=>'3','message'=>"Payment is not done yet");
				}
			}
			else{
				    $result = array ('status'=>'0','message'=>"fill all filed.");
				}
			
			echo json_encode($result);
			die;  
	}	
	
	
	/**
    * @Date: 16th March 2016
    * @Method : LatLng
    * @Purpose: This function is used to update LatLng.
    * @Param: none
    * @Return: none 
    **/

     function bar_detail(){
		    $saveArray = $this->data;
           // $this->Bar->edit_custom_validation();		
		    $this->Bar->set($saveArray);
			//$isValidated = $this->Bar->validates();
			if($saveArray){	
$con= "Bar.id='".$saveArray['id']."'";			
				  $find=$this->Bar->find('all',array('conditions'=>$con));
				  
				if(!empty($find)){

				foreach($find as $find){
				$record=array('id'=>$find['Bar']['id'],
								'name'=>$find['Bar']['name'],
								'street'=>$find['Bar']['street'],
								'city'=>$find['Bar']['city'],
								'state'=>$find['Bar']['state'],
								'country'=>$find['Bar']['country'],
								'lat'=>$find['Bar']['lat'],
								'lng'=>$find['Bar']['lng'],
								'zipcode'=>$find['Bar']['zipcode'],
							  'image'=>BASE_URL."app/webroot/img/".$find['Bar']['image'],
				);
				}
					$result = array ('status'=>'1','result'=>$record);
				}else{
				    $result = array ('status'=>'0','message'=>"No data.");
				}
			}else{
				    $errors = $this->errorValidation('Bar');
				    $result = array('status'=>'0','error'=>$errors);
			}
			echo json_encode($result);
			die;  
	}	
	
	/**
    * @Date: 16th March 2016
    * @Method : LatLng
    * @Purpose: This function is used to update LatLng.
    * @Param: none
    * @Return: none 
    **/

     function user_profile(){
		    $saveArray = $this->data;
           // $this->Bar->edit_custom_validation();
			
		    $this->User->set($saveArray);
			$barname="";
			$totalsaving="0";
			$totalvisit="0";
			$month_fav="0";
			$month_saving="0";
			if($saveArray){	
                   $con= "User.id='".$saveArray['id']."'";			
				  $find=$this->User->find('all',array('conditions'=>$con));
				  
				  $con1= "Favourite.user_id='".$saveArray['id']."'";
				  $count=$this->Favourite->find('all',array('conditions'=>$con1,'order'=>array('Favourite.count ASC')));
				  //pr($count);die;
				  if(!empty($count)){
					 // pr($count);
				  foreach($count as $count){
					 // pr($count);
					
				  }
				  $a= $count['Favourite']['barid'];
				  }
				  if(!empty($a)){
				   $con2= "Bar.id='".$a."'";			
				  $bar=$this->Bar->find('first',array('conditions'=>$con2));
				  //pr($bar);
				  $barname=$bar['Bar']['name'];
				  
				  
				  $con3= "History.user_id='".$saveArray['id']."'";			
				  $total=$this->History->find('all',array('conditions'=>$con3,'fields' => array('sum(History.total_saving) AS total')));
				  $totalsaving=$total[0][0]['total'];
				  
				  $con4= "History.user_id='".$saveArray['id']."'";			
				  $total1=$this->History->find('all',array('conditions'=>$con4,'fields' => array('count(History.user_id) AS total')));
				   $totalvisit=$total1[0][0]['total'];
				  
				  }  
				  
				
				
				$fav_month=$this->History->find('all', array(
					'conditions' => array('MONTH(History.created)' => date('n'),'user_id'=>$saveArray['id'])));
					count($fav_month);
				$month_fav=count($fav_month);
				
				
				$a=$this->History->find('all', array(
					'conditions' => array('MONTH(History.created)' => date('n'),'user_id'=>$saveArray['id']),'fields' => array('sum(History.month_total) AS mtotal')));
					//pr($a);die;
					if(!empty($a)){
					$month_saving=$a[0][0]['mtotal'];	
					}
					else{
					$month_saving="0.00";	
					}
				
				if(!empty($find)){

				foreach($find as $find){
					//pr($month_saving);
				$record=array(
							  'email'=>$find['User']['email'],
							  'fav bar'=>$barname,
							  'month saving'=>$month_saving,
							  'total saving'=>$totalsaving,
							  'month visit'=>$month_fav,
							  'total bar visit'=>$totalvisit,
							  'member since'=>date('M d',strtotime($find['User']['created'])),
							  
							  );
				}
					$result = array ('status'=>'1','result'=>$record);
				}else{
				    $result = array ('status'=>'0','message'=>"No record.");
				}
			}else{
				    $errors = $this->errorValidation('User');
				    $result = array('status'=>'0','error'=>$errors);
			}
			echo json_encode($result);
			die;  
	}	
     
	 
	 /**
    * @Date: 16th March 2016
    * @Method : LatLng
    * @Purpose: This function is used to update LatLng.
    * @Param: none
    * @Return: none 
    **/

     function bar_tender_action(){
		    $saveArray = $this->data;
		    $this->History->set($saveArray);
			if($saveArray){	
			
			$con="Drink.id='".$saveArray['drink_id']."'";
			$rate=$this->Drink->find('first',array('conditions'=>$con));
			//pr($rate);die;
			
			$saveArray['price']=$rate['Drink']['price'];
			$saveArray['total_saving']=$rate['Drink']['price'];
			$saveArray['month_total']=$rate['Drink']['price'];
			$save=$this->History->save($saveArray);
			if(!empty($save)){
				 $a=$saveArray['user_id'];
				// $a['datetime']=$saveArray['datetime'];
				
				$time=date('Y-m-d H:i:s');
					$sql = "INSERT INTO tenders (user_id,datetime)
							VALUES ('$a','$time')";
					$this->Tender->query($sql);
			    $condition=array('AND'=>array(
				  "Favourite.user_id='".$saveArray['user_id']."'",
				  "Favourite.barid='".$saveArray['barid']."'",
				  ));
				  $find=$this->Favourite->find('all',array('conditions'=>$condition));
				  //pr($find);die;
				  if(!empty($find)){
					 foreach($find as $find){
						  $count=$find['Favourite']['count']+1;
						$get=$this->Favourite->updateAll(array(
						'Favourite.count' =>$count ,
						),
						array('AND'=>array('Favourite.user_id' =>$saveArray['user_id'] ,
							  'Favourite.barid' =>$saveArray['barid'],
							  
						))); 
					 } 
				  }
				  else{
					  $saveArray['count']=1;
					  $this->Favourite->save($saveArray);
				  }
				$message="";
	      $user2 = $this->User->find('first',array('conditions'=>array('User.id'=>$saveArray['user_id'],'User.notification'=>'1')));
		 //pr($user2);
							if($user2){
							if($user2['User']['device_type']=='A'){
								$deviceIds[]=$user2['User']['device_id'];
								$bar = $this->Bar->find('first',array('conditions'=>array('Bar.id'=>$saveArray['barid'])));
								$barname="";
								if($bar){
									$barname=$bar['Bar']['name'];
								}
					$message =array('message'=>'Send Successfully','noti_for'=>'bar_tender_action','msg'=>'Thanks for visiting '.$barname.'. Your drink is in your hand with in 10 minutes. ');
								//$message =  array('message'=>'Send Successfully');
						
                                
                   $this->Common->android_send_notification($deviceIds,$message);   
                   //$result = array('status'=>'1', 'message'=>$message);
				   }
				   else if($user2['User']['device_type'] == 'I'){
					$deviceIds[]=$user2['User']['device_id'];
					$bar = $this->Bar->find('first',array('conditions'=>array('Bar.id'=>$saveArray['barid'])));
					$barname="";
								if($bar){
									$barname=$bar['Bar']['name'];
								}
					$message =array('message'=>'Send Successfully','noti_for'=>'bar_tender_action','msg'=>'Thanks for visiting '.$barname.'. Your drink is in your hand with in 10 minutes. ');
					 
					// $message =  array('message'=>'Thanks for visiting '.$bar['Bar']['name'].'. Your drink is in your hand with in 10 minutes. ');
                   $this->Common->iphone_send_notification($deviceIds, $message);              
				   }
							}
				$result = array ('status'=>'1','message'=>"Successfully",'notification'=>$message);
			}
			else{
				$result = array ('status'=>'0','message'=>"Fail to save record.");
			}

			}else{
				    $errors = $this->errorValidation('History');
				    $result = array('status'=>'0','error'=>$errors);
			}
			 
	 
	 echo json_encode($result);
			die; 
	 }
	 /**
    * @Date: 16th March 2016
    * @Method : LatLng
    * @Purpose: This function is used to update LatLng.
    * @Param: none
    * @Return: none 
    **/

     function history(){
		    $saveArray = $this->data;
           // $this->Bar->edit_custom_validation();		
		    $this->History->set($saveArray);
			
			if($saveArray){	
            $condition=array('AND'=>array(
				  "History.user_id='".$saveArray['id']."'",
				  
				  ));		
				 // $find=$this->History->find('all',array('conditions'=>$con));
				   $find=$this->History->find('all',array(
					
					'joins' => array(
								array(
									'table' => 'bars',
									'alias' => 'Bar',
									'type' => 'INNER',
									 'conditions' => array( 
													"Bar.id=History.barid"
													) ,
												
								),
								array(
									'table' => 'drinks',
									'alias' => 'Drink',
									'type' => 'INNER',
									 'conditions' => array( 
													"Drink.id = History.drink_id"
													) ,
												
								)
								),'conditions' =>$condition,'fields'=>array('Bar.*','History.*','Drink.*')));
				if(!empty($find)){

				foreach($find as $find){
				$record[]=array('bar name'=>$find['Bar']['name'],
								'bar id'=>$find['Bar']['id'],
								'bar image'=>BASE_URL."app/webroot/img/".$find['Bar']['image'],
				);
				
				}
					$result = array ('status'=>'1','result'=>$record);
				}else{
				    $result = array ('status'=>'0','message'=>"No record.");
				}
			}else{
				    $errors = $this->errorValidation('History');
				    $result = array('status'=>'0','error'=>$errors);
			}
			echo json_encode($result);
			die;  
	}	
     
	
	/**
		* @Date: 9 May 2016
		* @Method : Facebook_Login
		* @Purpose: This function is used to login with facebook and linkedin.
		* @Param: none
		* @Return: none 
		**/

	function Facebook_Login(){
  
        $profile_path = BASE_URL."img/friends/";
        $saveArray=$this->data;
        $saveArray['deleted'] = 1;	

        $this->User->facebook_custom_validation();
        $this->User->set($saveArray);
 
      //  $this->User->validator()->remove('email','checkUnique');

    $condition="User.fb_id='".$saveArray['fb_id']."' AND User.email='".$saveArray['email']."' AND (login_type='Facebook' )";
    $exist_record=$this->User->find('first',array('conditions'=>$condition));
	
    if($exist_record){
                $result=array('status'=>'1','message'=>"success","id"=>$exist_record['User']['id'],'email'=>$exist_record['User']['email']);
    }else{
	    $this->User->validator()->remove('email','checkUnique');
        $isValidated=$this->User->validates();
        if($isValidated){
			$saveArray['login_type']='Facebook';
                $save=$this->User->save($saveArray,array('validate'=>false));
                $user = $save['User'];
  
                $result = array('status'=>'1','result'=>'Register Successfully','id'=>$user['id'],'email'=>$user['email'],'login_type'=>$user['login_type']);
   
        }else{
                $erros=$this->errorValidation('User');
                $result=array('status'=>'0','message'=>$erros);
        }
	}
  echo json_encode($result);
  die;
 }
 /********************************
 *********************************
 ***********************************/
 	
	function bar_search(){
			$saveArray=$this->data;
			
				  
			$name=$this->data['name'];
			if($name==""){
				echo "please enter value";
			}
			else{
			//$QUERY=" SELECT * FROM `users` WHERE name LIKE '$name%' ";
				$latitude =  $saveArray['lat'];
                $longitude =  $saveArray['lng'];
				$mile = 1000000000000;
				$a=$this->Bar->virtualFields 
				= array('distance'
				 => '(3959 * acos (cos ( radians('.$latitude.') )
				* cos( radians( Bar.lat ) )
				* cos( radians( Bar.lng ) 
				- radians('.$longitude.') )
				+ sin ( radians('.$latitude.') )
				* sin( radians( Bar.lat ) )))');
			$con= array('Bar.name LIKE' => "$name%",
						'distance <' => $mile);
	$userExist=$this->Bar->find('all',array('conditions'=>$con));
		//pr($userExist);die;
		if($userExist){
		 foreach($userExist as $user){
				//pr($user);
				$mi = $user['Bar']['distance'] / 1.609344;
			 	$latitude =  $user['Bar']['lat'];
                $longitude =  $user['Bar']['lng'];
				$mile = 1000000000000;
				$lat=$saveArray['lat'];
				$lng=$saveArray['lng'];
				$id=$user['Bar']['id'];
				
				$record[]=array(
					'Bar id'=>$user['Bar']['id'],
					'Bar name'=>$user['Bar']['name'],
					'lat and lng'=>$user['Bar']['lat'].",".$user['Bar']['lng'],
					'Bar distance'=>$mi,
					'Bar pic'=>BASE_URL."app/webroot/img/".$user['Bar']['image'],
					
					
					);
		 }
		 $result=array('status'=>'1','result'=>$record);
		 }
		else{
			$result=array('status'=>'0','message'=>'no data');
			
		}
      
		
		
	}
		echo json_encode($result);
			die;
	}
	/********************************
 *********************************
 ***********************************/
 	
	function all_city(){
			
	$userExist=$this->City->find('all',array('fields' => array('City.*'),'group' => 'City.name'));
		// pr($userExist);die;
		if($userExist){
		 foreach($userExist as $user){
			// pr($user);
				$record[]=array(
					'City id'=>$user['City']['id'],
					'City name'=>$user['City']['name'],
					
					);
		 }
		 $result=array('status'=>'1','result'=>$record);
		 }
		else{
			$result=array('status'=>'0','message'=>'no data');	
		}
      
		echo json_encode($result);
			die;
	}
/********************************
 *********************************
 ***********************************/
 	
	function notification(){
			
	$saveArray=$this->data;
	//pr($saveArray);
		if($saveArray){
			//$saveArray['notification'];
		  $d = $this->User->updateAll(array("notification" => "'".$saveArray['notification']."'"), array("id" => $saveArray['id']));
		  if($d){
		 $result=array('status'=>'1','result'=>"record updated");
		 }
		else{
			$result=array('status'=>'0','message'=>'not update');	
		}
       
		
	}
	else{
		$result=array('status'=>'0','message'=>'please fill all fileds');
	}
echo json_encode($result);
			die;
}

/********************************
 *********************************
 ***********************************/
 	
	function check_notification(){
			
	$saveArray=$this->data;
	//pr($saveArray);
		if($saveArray){
			//$saveArray['notification'];
			$con="User.id='".$saveArray['userid']."'";
		  $d = $this->User->find('first',array("conditions" =>$con));
		  if($d){
		 $result=array('status'=>'1','result'=>"Notification On");
		 }
		else{
			$result=array('status'=>'0','message'=>'Notification Off');	
		}
       
		
	}
	else{
		$result=array('status'=>'0','message'=>'please fill all fileds');
	}
echo json_encode($result);
			die;
}

function payment() { 
   $saveArray = $this->data;
   if($saveArray){
			if($saveArray['membership_type']==1){
			 $nexdate = date("Y-m-d", strtotime("+30 days",time()));
			 $saveArray['expire_date']=$nexdate;
			 $saveArray['membership_type']='1';
			 $price=10;
			}
			if($saveArray['membership_type']==2){
			 $nexdate = date("Y-m-d", strtotime("+90 days",time()));
			 $saveArray['expire_date']=$nexdate;
			  $saveArray['membership_type']='2';
			  $price=30;
			}
			if($saveArray['membership_type']==3){
			 $nexdate = date("Y-m-d", strtotime("+365 days",time()));
			 $saveArray['expire_date']=$nexdate;
			  $saveArray['membership_type']='3';
			  $price=100;
			}
		$find=$this->Payment->find('first',array('conditions'=>array('Payment.userid'=>$saveArray['userid'])));
		//pr($find);
		if(!empty($find)){
			//update code
			if($saveArray['membership_type']==1){
			 $nexdate = date("Y-m-d", strtotime("+30 days",time()));
			 $saveArray['expire_date']=$nexdate;
			 $saveArray['membership_type']='1';
			 $price=10;
			}
			if($saveArray['membership_type']==2){
			 $nexdate = date("Y-m-d", strtotime("+90 days",time()));
			 $saveArray['expire_date']=$nexdate;
			  $saveArray['membership_type']='2';
			  $price=30;
			}
			if($saveArray['membership_type']==3){
			 $nexdate = date("Y-m-d", strtotime("+365 days",time()));
			 $saveArray['expire_date']=$nexdate;
			  $saveArray['membership_type']='3';
			  $price=100;
			}
			if($saveArray['device_type']=='A'){
				$date=date('Y-m-d H:i:s');
				$save= $this->Payment->updateAll(array(
						'Payment.trans_id' =>"'".$saveArray['trans_id']."'",
						'Payment.stripe_token' =>"'".$saveArray['stripe_token']."'",
						'Payment.expire_date' =>"'".$nexdate."'",
						'Payment.membership_type' =>"'".$saveArray['membership_type']."'",
						'Payment.created' =>"'".$date."'",
						),
						array('Payment.userid' => $saveArray['userid']));
				if($save){
					$user2 = $this->User->find('first',array('conditions'=>array('User.id'=>$saveArray['userid'],'User.notification'=>'1')));
		 //pr($user2);
				if($user2){
							if($user2['User']['device_type']=='A'){
								$deviceIds[]=$user2['User']['device_id'];
								// $bar = $this->Bar->find('first',array('conditions'=>array('Bar.id'=>$saveArray['barid'])));
					$message =array('message'=>'Send Successfully','noti_for'=>'subscription','msg'=>'Your are subscribed with Pulchra Society.');
								//$message =  array('message'=>'Send Successfully');
						
                                
                   $this->Common->android_send_notification($deviceIds,$message);   
                   //$result = array('status'=>'1', 'message'=>$message);
				   }
				   
				}
					$result=array('status'=>'1','result'=>'Payment successfull');
				}
				else{
					$result=array('status'=>'0','message'=>'Payment failed');
				}
			}
			elseif($saveArray['device_type']=='I'){ 
			$token = $saveArray['stripe_token'];
				 //secret key
				if($saveArray['membership_type']==1){
			 $nexdate = date("Y-m-d", strtotime("+30 days",time()));
			 $saveArray['expire_date']=$nexdate;
			 $saveArray['membership_type']='1';
			 $price=1000;
			}
			if($saveArray['membership_type']==2){
			 $nexdate = date("Y-m-d", strtotime("+90 days",time()));
			 $saveArray['expire_date']=$nexdate;
			  $saveArray['membership_type']='2';
			  $price=3000;
			}
			if($saveArray['membership_type']==3){
			 $nexdate = date("Y-m-d", strtotime("+365 days",time()));
			 $saveArray['expire_date']=$nexdate;
			  $saveArray['membership_type']='3';
			  $price=10000;
			}
				 $apiKey = 'sk_test_d9cbiC5e1Ske5jTa5dGeV3dM';
				 $curl = curl_init();
				 $name=array(
				   'Authorization: Bearer ' . $apiKey
				  );
			//  pr($saveArray['MEMBERSHIP_TYPE']);die;
			 curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			 curl_setopt($curl, CURLOPT_URL,'https://api.stripe.com/v1/charges');
			 curl_setopt($curl, CURLOPT_POST,1);
			 curl_setopt($curl, CURLOPT_HTTPHEADER,$name);
			 $data=array(
			   "amount" =>$price,
			   "currency" => 'USD',
			   "source" => $token,
			   "description" => 'Testing'
			  );
			 curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
			 $resp = curl_exec($curl);
			  //pr($resp);
			 curl_close($curl);
			 $data=json_decode($resp);
			 //pr($data);
			 if(!isset($data->status))
			 {
			 $data->status='failed';
			 
			 }
			  if($data->status == "succeeded")
			  { 
			  $saveArray['trans_id']= $data->balance_transaction;
			  	$date=date('Y-m-d H:i:s');
				$save= $this->Payment->updateAll(array(
						'Payment.trans_id' =>"'".$saveArray['trans_id']."'",
						'Payment.stripe_token' =>"'".$saveArray['stripe_token']."'",
						'Payment.expire_date' =>"'".$nexdate."'",
						'Payment.membership_type' =>"'".$saveArray['membership_type']."'",
						'Payment.created' =>"'".$date."'",
						),
						array('Payment.userid' => $saveArray['userid']));
				if($save){
					$user2 = $this->User->find('first',array('conditions'=>array('User.id'=>$saveArray['userid'],'User.notification'=>'1')));
		 //pr($user2);
				if($user2){
						if($user2['User']['device_type'] == 'I'){
					$deviceIds[]=$user2['User']['device_id'];
					// $bar = $this->Bar->find('first',array('conditions'=>array('Bar.id'=>$saveArray['barid'])));
					$message =array('message'=>'Send Successfully','noti_for'=>'subscription','msg'=>'Your are subscribed with Pulchra Society.');
					
                   $this->Common->iphone_send_notification($deviceIds, $message);              
				   }
				}
					$result=array('status'=>'1','result'=>'Payment successfull');
				}
				else{
					$result=array('status'=>'0','message'=>'Payment failed');
				}
			}
			}
			
		}
		else{
			
			if($saveArray['device_type']=='A'){
				$save=$this->Payment->save($saveArray);
				if($save){
					$user2 = $this->User->find('first',array('conditions'=>array('User.id'=>$saveArray['userid'],'User.notification'=>'1')));
		 //pr($user2);
				if($user2){
							if($user2['User']['device_type']=='A'){
								$deviceIds[]=$user2['User']['device_id'];
								// $bar = $this->Bar->find('first',array('conditions'=>array('Bar.id'=>$saveArray['barid'])));
					$message =array('message'=>'Send Successfully','noti_for'=>'subscription','msg'=>'Your are subscribed with Pulchra Society.');
								//$message =  array('message'=>'Send Successfully');
						
                                
                   $this->Common->android_send_notification($deviceIds,$message);   
                   //$result = array('status'=>'1', 'message'=>$message);
				   }
				}
					$result=array('status'=>'1','result'=>'Payment successfull');
				}
				else{
					$result=array('status'=>'0','message'=>'Payment failed');
				}
			}
			elseif($saveArray['device_type']=='I'){
				//pr("fsdf");
				 $token = $saveArray['stripe_token'];
				 //secret key
				if($saveArray['membership_type']==1){
			 $nexdate = date("Y-m-d", strtotime("+30 days",time()));
			 $saveArray['expire_date']=$nexdate;
			 $saveArray['membership_type']='1';
			 $price=1000;
			}
			if($saveArray['membership_type']==2){
			 $nexdate = date("Y-m-d", strtotime("+90 days",time()));
			 $saveArray['expire_date']=$nexdate;
			  $saveArray['membership_type']='2';
			  $price=3000;
			}
			if($saveArray['membership_type']==3){
			 $nexdate = date("Y-m-d", strtotime("+365 days",time()));
			 $saveArray['expire_date']=$nexdate;
			  $saveArray['membership_type']='3';
			  $price=10000;
			}
				 $apiKey = 'sk_test_d9cbiC5e1Ske5jTa5dGeV3dM';
				 $curl = curl_init();
				 $name=array(
				   'Authorization: Bearer ' . $apiKey
				  );
			//  pr($saveArray['MEMBERSHIP_TYPE']);die;
			 curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			 curl_setopt($curl, CURLOPT_URL,'https://api.stripe.com/v1/charges');
			 curl_setopt($curl, CURLOPT_POST,1);
			 curl_setopt($curl, CURLOPT_HTTPHEADER,$name);
			 $data=array(
			   "amount" =>$price,
			   "currency" => 'USD',
			   "source" => $token,
			   "description" => 'Testing'
			  );
			 curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
			 $resp = curl_exec($curl);
			  //pr($resp);
			 curl_close($curl);
			 $data=json_decode($resp);
			 //pr($data);
			 if(!isset($data->status))
			 {
			 $data->status='failed';
			 
			 }
			  if($data->status == "succeeded")
			  { 
			  $saveArray['trans_id']= $data->balance_transaction;
			  $save=$this->Payment->save($saveArray);
			  if($save){
				  $user2 = $this->User->find('first',array('conditions'=>array('User.id'=>$saveArray['userid'],'User.notification'=>'1')));
		 //pr($user2);
				if($user2){
					if($user2['User']['device_type'] == 'I'){
					$deviceIds[]=$user2['User']['device_id'];
					// $bar = $this->Bar->find('first',array('conditions'=>array('Bar.id'=>$saveArray['barid'])));
					$message =array('message'=>'Send Successfully','noti_for'=>'subscription','msg'=>'Your are subscribed with Pulchra Society.');
					
                   $this->Common->iphone_send_notification($deviceIds, $message);              
				   }
				}
					$result=array('status'=>'1','result'=>'Payment successfull');
				}
				else{
					$result=array('status'=>'0','message'=>'Payment failed');
				}
			}
			elseif($data->status=="failed")
      { 
       $result = array('status'=>'0',"message" => 'Payment Failed');
      }
		 }
		 }
   }
		echo json_encode($result);
		die;
   }

   function days_left(){
		$saveArray=$this->data;
		if($saveArray){
		$find=$this->Payment->find('first',array('conditions'=>array('Payment.userid'=>$saveArray['userid'])));

		if(!empty($find)){
			//update code
						
				$now = new DateTime();
				$future_date = new DateTime("".$find['Payment']['expire_date']."");

				$interval = $future_date->diff($now);

			$days_left= $interval->format("%a days");
			$result=array('status'=>'1','result'=>'successfull','days_left'=>$days_left);
			}
			else{
				$result=array('status'=>'0','message'=>'no data');
			}
		}
		else{
			$result=array('status'=>'0','message'=>'Please enter userid');
		}
		echo json_encode($result);
		die;
	}
	
	
	 function question(){
		$saveArray=$this->data;
		if($saveArray){
		$find=$this->Question->find('all');

		if(!empty($find)){
			foreach($find as $find){
				$record[]=array(
						  'id'=>$find['Question']['id'],
						  'question'=>$find['Question']['ques'],
						  'ans'=>$find['Question']['ans'],
				);
			}
			$result=array('status'=>'1','result'=>'successfull','data'=>$record);
			}
			else{
				$result=array('status'=>'0','message'=>'no data');
			}
		}
		else{
			$result=array('status'=>'0','message'=>'Please enter userid');
		}
		echo json_encode($result);
		die;
	}
	
	
	

}		
		