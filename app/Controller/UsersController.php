<?php

	/**

	* User Controller class
	* PHP versions 5.1.4
	* @date 30-October-2014
	* @Purpose:This controller handles all the functionalities regarding user management.
	* @filesource
	* @revision
	* @version 0.0.1
	**/
	App::uses('Sanitize', 'Utility');
class UsersController extends AppController{
    var $name  = "Users";
   /*
    *
	* Specifies helpers classes used in the view pages
	* @access public
	*/
    public $helpers    	=  array('Html', 'Form', 'Js', 'Session','General','Paginator');
    /**
	* Specifies components classes used
	* @access public
    */
    var $components 	=  array('RequestHandler','Email','Common','Paginator','Upload');
    var $paginate		  =  array();
    var $uses       	=  array('User','Dashboard'); // For Default Model
	/******************************* START FUNCTIONS **************************/
	#_________________________________________________________________________#
    /**
    * @Date: 30-October-2014
    * @Method : beforeFilter
    * @Purpose: This function is called before any other function.
    * @Param: none
    * @Return: none 
    **/
    function beforeFilter(){
		if(!empty($this->params['prefix']) && $this->params['prefix'] == "admin"){
			$this->checkUserSession();
		}else{
			$this->layout    = "layout_front";
		}
		$this->set('common',$this->Common);
    }
    #_________________________________________________________________________#
    /**
    * @Date: 30-October-2014
    * @Method : index
    * @Purpose: This page will render home page
    * @Param: none
    * @Return: none 
    **/
	function index() {
		if($this->Session->read("SESSION_USER") != ""){
			$this->redirect(array('controller'=>'users','action'=>'dashboard'));

		}
		die;
	}
	#_________________________________________________________________________#
    /**
    * @Date: 31-October-2014
    * @Method : admin_index
    * @Purpose: This is the default function of the administrator section for users
    * @Param: none
    * @Return: none 
    **/
#__________________________________________________________________#
	function admin_index(){
		$this->render('admin_login');
		if($this->Session->read("SESSION_ADMIN") != ""){
			$this->redirect(array('controller'=>'users','action'=>'list'));
		}
    }
	#_________________________________________________________________________#



	/**

    * @Date: 31-October-2014

    * @Method : admin_login

    * @Purpose: used for authorizing administrator section

    * @Param: none

    * @Return: none

    **/


function admin_login(){
	$this->layout = "layout_admin_withoutlogin";
	$this->set("title_for_layout", "Login");
		if($this->data){
			$this->User->set($this->data['User']);
			 $this->User->validate = array(
			'email' => array(
				   'rule' => 'notEmpty',
				   'required' => true,
				   'message' => "Enter email."
			));
				if($this->User->validates()){
					$a=1;
				$password    = md5(trim($this->data['User']['password']));
				$condition = "User.email='".Sanitize::escape(trim($this->data['User']['email']))."' AND User.password='".$password."' AND User.user_type='".$a."'";
				$user_details = $this->User->find('first', array("conditions" => $condition));
 				 
					if($user_details){
						$this->Session->write("SESSION_ADMIN", array('id'=>$user_details['User']['id'],'password'=>$user_details['User']['password']));
						$this->redirect(array('controller'=>'users','action'=>'dashboard'));
					}else{
					$this->Session->setFlash('<div class="alert alert-danger alert-dismissable">
						  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>The Email or password you entered is incorrect.</div>');
					}
				}
			}
			
		}

	#_________________________________________________________________________#



    /**

    * @Date: 31-October-2014

    * @Method : admin_dashboard

    * @Purpose: This function is to show Admin dashboard.

    * @Param: none

    * @Return: none 

    **/


    function admin_dashboard(){
		
		$this->set("title_for_layout", "Dashboard");
		$userSession = $this->Session->read("SESSION_ADMIN");
		$condition = "User.deleted=1  ";
		$data['user'] = $this->User->find('count',array('conditions'=>$condition.' AND User.user_type=2'));
		//$dats = $this->Bar->find('all');
		//$data['bars'] = count($dats);
		//$datf = $this->Drink->find('all');
		//$data['drinks'] = count($datf);
		$this->set('data',$data);
		 
    } 
	#_________________________________________________________________________#



    /**

    * @Date: 31-October-2014

    * @Method : admin_forgot_password

    * @Purpose: This function is to reset admin's password.

    * @Param: none

    * @Return: none 

    **/

    /* function admin_forgot_password(){
	 
		    $this->layout = "layout_admin_withoutlogin";
            $this->set("title_for_layout", "Forgot Password");
            $this->pageTitle = "Forgot password";
				 
					$this->User->set($this->data);
					$this->User->validate = array(
						'email' => array(
							   'rule' => 'notEmpty',
							   'required' => true,
							   'message' => "Enter email."
					  ));
					  
					  
					$this->User->validate =array('email' => array('ruleName' => array('rule' => 'notEmpty','message' => "Enter Email.",'required'=>true,'last' => true),
					 'ruleName2' => array('rule' =>'email','message' => "Enter a valid email.")));
					//end('vfsd');
					$isValidated = $this->User->validates();
					
						if($isValidated){
							$condition = "email='".Sanitize::escape($this->data['User']['email'])."' and user_type=1";
						
							$emp_details = $this->User->find('first', array("conditions" => $condition, "fields" => array("id","email")));
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
									if($this->Email->send($message)){
										$this->User->updateAll(array("User.password"=>"'".md5($resetPassword)."'"),array("id"=>$emp_details['User']['id']));
										$result = array('status'=>1,'message'=>"<div class='alert alert-success'>Your password has been reset and successfully sent to your email id.</div>",'type'=>2);
									}else{
										$result = array('status'=>1,'message'=>"<div class='alert alert-danger'>Unable to send email.</div>",'type'=>1);
									}
							
								}else{
					 
									 $result = array('status'=>1,'message'=>"<div class='alert alert-danger'>The email doesn&#39;t exists.</div>",'type'=>1);
								}

						}else{
							
							 $result = array('status'=>0,'error'=>$this->User->validationErrors['email'][0]);
						}
 
				echo json_encode($result);
		        die;
    } */
	
	function admin_forgot_password() {
		 
		
        $this->layout = "layout_admin_withoutlogin";
        $this->set("title_for_layout", "Forgot Password");
        $this->pageTitle = "Forgot password";
        if ($this->data) {
			//pr($this->data);die('dsv');
			
            $this->User->set($this->data);
            //$isValidated = $this->User->validates();
            //unset($isValidated['email']['isUnique']);
            $isValidated = $this->User->validator()->remove('email', 'ruleName2');
            if ($isValidated) {
                $condition = "email='" . Sanitize::escape($this->data['User']['email']) . "' and (user_type = '1')";
                $emp_details = $this->User->find('first', array("conditions" => $condition, "fields" => array("id", "email")));
                
				//pr($emp_details);die('df');
				if ($emp_details) {
                    // Reset password
                    $resetPassword = rand(100000, 999999);
                    $subject = "Forgot your Password!";
                    // Send mail to User
                    $name = $emp_details['User']['email'];
                    $this->Email->to = trim($emp_details['User']['email']);
                    $this->Email->subject = $subject;
                    $this->Email->replyTo = ADMIN_EMAIL;
                    $this->Email->from = SITE_NAME . "<" . ADMIN_EMAIL . ">";
                    $this->Email->fromName = SITE_NAME;
                    $this->Email->sendAs = 'html';
                    // set values to be used on email template
                    $message = "Dear <span style='color:#666666'>" . $name . "</span>,<br/><br/>Your password has been reset successfully.<br/><br/>Please find the following login details:<br/><br/>Email: " . $emp_details['User']['email'] . "<br/>Password: " . $resetPassword . "<br/><br/>Thanks, <br/>Support Team";
                    ;
                    if ($this->Email->send($message)) {
                        $this->User->updateAll(array("password" => "'" . md5($resetPassword) . "'"), array("id" => $emp_details['User']['id']));
                        $this->Session->setFlash("<div class='error-message flash notice'><h4>Your PASSWORD has been reset and successfully sent to your email id.</h4></div>");
                    }
                    $this->redirect(array("action" => "admin_login"));
                } else {
                    $this->Session->setFlash("<div class='error-message flash notice'><h4>The email id doesn't exists.</h4></div>");
					$this->redirect(array("action" => "admin_login"));
                }
            }
        }
		
    }

#________________________________________________________________________________________________________________#

function admin_add(){
//pr($this->data);die;
	    $this->set("title_for_layout", "Add User");
		   $userSession = $this->Session->read("SESSION_ADMIN");
		   $this->set('userSession',$userSession);	
			if($this->data){
			$userData = $this->data['User'];
			//pr($userData);die;
				$this->User->set($userData);
				$isValidated = $this->User->validates();
					if($isValidated){
					//pr($userData);die;
					$userData['password']= md5($userData['password']);
					$userData['user_type']=2;
				
					$userData['dob']= $this->data['User']['dob']['year']."-".$this->data['User']['dob']['day']."-".$this->data['User']['dob']['month'];
					$user = $this->User->save($userData);
						
					//$this->uploadPic($user['User']['id'],false);
				$this->Session->setFlash("User has been created successfully.",'layout_success');
				$this->redirect(array('action' => 'list'));
				}
			   }
	          }

	

	#______________________________________________________________________________________________________________#



    /**

    * @Date: 31-October-2014

    * @Method : admin_ulist

    * @Purpose: This function is to show list of users in system.

    * @Param: none

    * @Return: none 

    **/
	function admin_list(){
		
		$this->set("title_for_layout", "Users Listing");
		$this->set("search1", "");                                 
		$this->set("search2", ""); 
		$search3 = '2,3,4,5'; 
        $this->set("search3", $search3);		
		$criteria = "User.deleted = 1 AND User.user_type !=1 "; //All Searching
		$this->Session->delete('SESSION_SEARCH');
		 
		if(isset($this->data['User']) || !empty($this->params['named'])) {
			if(!empty($this->data['User']['fieldName']) || isset($this->params['named']['field'])){     
				if(trim(isset($this->data['User']['fieldName'])) != ""){  
                   		
					if(trim($this->data['User']['fieldName'])=="User.email"){
					$search1 = "User.email"; 
				}else{
				$search1 = trim($this->data['User']['fieldName']);    
				}			
				}elseif(isset($this->params['named']['field'])){                              
				$search1 = trim($this->params['named']['field']);                             
				}
				$this->set("search1",$search1); 

                				
			}
			 
			  if(!empty($this->data['User']['user_type']) || isset($this->params['named']['utype'])){     
				if(trim(isset($this->data['User']['user_type'])) != ""){ 
                   	 $search3 = $this->data['User']['user_type'];
				}elseif(isset($this->params['named']['utype'])){                              
				  $search3 = trim($this->params['named']['utype']);                             
				}
				$this->set("search3",$search3);
			  }
			if(isset($this->data['User']['value1']) || isset($this->params['named']['value'])){          
				if(isset($this->data['User']['value1'])){                                                          
				$search2 = trim($this->data['User']['value1']);      
				}elseif(isset($this->params['named']['value'])){       
				$search2 = trim($this->params['named']['value']);      
				}                                                      
				$this->set("search2",$search2);                        
			}
			/* Searching starts from here */                                               
			if(!empty($search1) && !empty($search2)){  
				$criteria .= 'AND '.$search1." LIKE '%".Sanitize::escape($search2)."%'"; 

			}else{      
			$this->set("search1","");      
			$this->set("search2","");      
			}
		}
		
		$criteria.=' AND User.user_type in('.$search3.')';
		$this->Session->write('SESSION_SEARCH', $criteria);
		if(isset($this->params['named'])){
			$urlString = "/";
			$completeUrl  = array();
			 
				if(!empty($this->params['named']['page']))
					$completeUrl['page'] = $this->params['named']['page'];
				if(!empty($this->params['named']['sort']))
					$completeUrl['sort'] = $this->params['named']['sort'];
				if(!empty($this->params['named']['direction']))
					$completeUrl['direction'] = $this->params['named']['direction'];
				if(!empty($search1))
					$completeUrl['field'] = $search1;
				if(isset($search2))
					$completeUrl['value'] = $search2;
					foreach($completeUrl as $key=>$value){
					$urlString.= $key.":".$value."/";
					}
		}
		$this->set('urlString',$urlString);
	    // If Admin is login then all records else only logged in user record
		$this->Paginator->settings = array(
		'fields' => array(
        'User.*'
        ),
		'conditions' => array(),
		'group'=>'User.id',
		'page'=> 1,'limit' => RECORDS_PER_PAGE,
		'order' => array('User.email' => 'asc')
		);
	$data = $this->Paginator->paginate('User',$criteria);
	
	$this->set('resultData', $data);
    }
	
	#____________________________________________________________________________________________________________#
	function admin_edit($id = null) {
			$this->set("title_for_layout", "Edit User");
			 $userSession = $this->Session->read("SESSION_ADMIN");
           $this->set('userSession',$userSession);
			
			
			if($this->data){
				//pr($id); die;
			
			if(!empty($this->data)){
				
				
					$saveData = $this->data['User'];
					//pr($userData);
			$saveData['dob']= $this->data['User']['dob']['year']."-".$this->data['User']['dob']['day']."-".$this->data['User']['dob']['month'];
		$updated = $this->User->updateAll(array('User.dob'=>"'".$saveData['dob']."'", 'User.country'=>"'".$saveData['country']."'"),
					                                 array('User.id'=>$id));	
										//pr($updated);die;								 
					if($updated){
						$this->Session->setFlash("User has been updated successfully.",'');
					}else{
							$this->Session->setFlash("Error in update.",'layout_success');
					}
					
					$this->redirect(array('action' => 'list'));
		
				
			}
			}
			
		else if(!empty($id)){
			$this->data = $this->User->find('first', array('conditions'=>array('id'=>Sanitize::escape($id))));
			if(!$this->data){
				$this->redirect(array('action' => 'list'));
			}
		}
			
	}
	
	
	#_____________________________________________________________________________________________________#
	
	public function admin_view($id = null) {
     $userSession = $this->Session->read("SESSION_ADMIN");
	
  $this->set('userSession',$userSession);  
      $this->layout="layout_admin";
   if (!$this->User->exists($id)) {
    throw new NotFoundException(__('Invalid user'));
   }
   $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
    
   $this->set('user', $userdata=$this->User->find('first', $options));//pr($userdata);die;
   //$this->set('adid',$userSession[2]);
  }
	
	
	
	
	#______________________________________________________________________________________________________________#



    /**

    * @Date: 31-October-2014

    * @Method : admin_approve

    * @Purpose: This function is to show list of users in system.

    * @Param: none

    * @Return: none 

    **/
	function admin_approve(){
		if($this->session['user_type'] !=1){
			$this->redirect(array('controller'=>'users','action'=>'dashboard'));
		}
		$this->redirect(array('controller'=>'users','action'=>'dashboard'));
		$this->set("title_for_layout", "Approve Users");
		$this->set("search1", "");                                 
		$this->set("search2", "");                                 
		$criteria = "User.deleted = 1 AND User.approved = 1 AND User.user_type !=1 "; //All Searching
		
		$this->Session->delete('SESSION_SEARCH');
		if(isset($this->data['User']) || !empty($this->params['named'])) {
			if(!empty($this->data['User']['fieldName']) || isset($this->params['named']['field'])){     
				if(trim(isset($this->data['User']['fieldName'])) != ""){  
                   		
					if(trim($this->data['User']['fieldName'])=="User.name"){
					$search1 = "User.name"; 
				}else{
				$search1 = trim($this->data['User']['fieldName']);    
				}			
				}elseif(isset($this->params['named']['field'])){                              
				$search1 = trim($this->params['named']['field']);                             
				}
				$this->set("search1",$search1);                                               
			}
			if(isset($this->data['User']['value1']) || isset($this->params['named']['value'])){          
				if(isset($this->data['User']['value1'])){                                                          
				$search2 = trim($this->data['User']['value1']);      
				}elseif(isset($this->params['named']['value'])){       
				$search2 = trim($this->params['named']['value']);      
				}                                                      
				$this->set("search2",$search2);                        
			}
			/* Searching starts from here */                                               
			if(!empty($search1) && !empty($search2)){  
				$criteria .= 'AND '.$search1." LIKE '%".Sanitize::escape($search2)."%'"; 
				$this->Session->write('SESSION_SEARCH', $criteria);
			}else{      
			$this->set("search1","");      
			$this->set("search2","");      
			}
		}
		if(isset($this->params['named'])){
			$urlString = "/";
			$completeUrl  = array();
				if(!empty($this->params['named']['page']))
					$completeUrl['page'] = $this->params['named']['page'];
				if(!empty($this->params['named']['sort']))
					$completeUrl['sort'] = $this->params['named']['sort'];
				if(!empty($this->params['named']['direction']))
					$completeUrl['direction'] = $this->params['named']['direction'];
				if(!empty($search1))
					$completeUrl['field'] = $search1;
				if(isset($search2))
					$completeUrl['value'] = $search2;
					foreach($completeUrl as $key=>$value){
					$urlString.= $key.":".$value."/";
					}
		}
		$this->set('urlString',$urlString);
	    // If Admin is login then all records else only logged in user record
		$this->Paginator->settings = array(
		'fields' => array(
        'User.*'
        ),
		'conditions' => array(),
		'page'=> 1,'limit' => RECORDS_PER_PAGE,
		'order' => array('User.username' => 'asc')
		);
	   $data = $this->Paginator->paginate('User',$criteria);
	
	   $this->set('resultData', $data);
    }
	#_________________________________________________________________________#
	
	/**
    * @Date: 31-October-2014        
    * @Method : admin_profile    
    * @Purpose: This function is used to change status from admin section
    * @Param: $id                                       
    * @Return: none
    * @Return: none
    **/  
     
	function admin_profile(){ 
	 
	    $this->set("title_for_layout", "Profile");
		$this->set('status',1);
		$this->set('chang_pass','false');
		$data = $this->data;
		if($data){
			$this->set('chang_pass','true');
			if(empty($data['change_pass'])){  
			  $this->User->validate['password']['required'] = false;
			  unset($data['User']['password']);
			  unset($data['User']['confirm_password']);
			  $this->set('chang_pass','false');
			  
			}
			
			$this->User->set($data['User']); 
			 
		    if($this->User->validates()){
			 
				if(!empty($data['change_pass'])){ 
				 $data['User']['password'] = md5($data['User']['password']);
				 $data['User']['confirm_password'] = md5($data['User']['confirm_password']);
			    }
				$this->User->save($data, array('validate'=>false));
				$this->data = $this->User->find('first', array('conditions'=>array('id'=>Sanitize::escape($this->session['id'])),'fields'=>array('id','name','email','profile_pic_id','address','user_type')));
				
				$this->Session->write("SESSION_ADMIN", array('id'=>$this->data['User']['id'],'name'=>$this->data['User']['name'],'profile_pic_id'=>$this->data['User']['profile_pic_id'],'user_type'=>$this->data['User']['user_type']));
				$this->set('chang_pass','false');
				
				$this->Session->setFlash('<div class="alert alert-success">Profile has been updated successfully.</div>');
				  
			}else{
				$this->set('status',2);
			} 
		}else{
			$this->data = $this->User->find('first', array('conditions'=>array('id'=>Sanitize::escape($this->session['id'])),'fields'=>array('id','name','email','profile_pic_id','address')));
		}
			 
	}
	
	
	
	#_________________________________________________________________________#
	
	/**
    * @Date: 31-October-2014        
    * @Method : admin_settings    
    * @Purpose: This function is used to manage admin settings.
    * @Param: $id                                       
    * @Return: none
    * @Return: none
    **/  
     
	/* function admin_settings(){//pr($this->data);die('here');
		$userSession = $this->Session->read("SESSION_ADMIN");
		$this->set('title_for_layout','Admin Settings');
		$savedata = $this->data;
		if($savedata){
			$save = $this->data;
			$id=$userSession['id'];
			$aa=$this->User->find('first',array('conditions'=>array('User.id'=>$id)));
			$this->User->set($save);
			$this->User->validate = array(
			'password' => array(
				   'rule' => 'notEmpty',
				   'required' => true,
				   'message' => "Enter password."
			));
			if($this->User->validates()){
				if($save['User']['password'] == $save['User']['confirm_password'] ){				
					if(!empty($save['User']['confirm_password'])){
					   $savedata['password'] =md5($save ['User']['password']);
					   
					}
					$result = $this->User->updateAll(array('User.password'=>"'".$savedata['password']."'"),array('id'=>$userSession['id']));
					if($result){
						$this->Session->setFlash('<div class="alert alert-success alert-dismissable">
							  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Your details has been updated successfully.</div>');
						$this->redirect(array('action' => 'list'));
					}else{
							$this->Session->setFlash('<div class="alert alert-danger alert-dismissable">
							  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Your details has not been updated.</div>');
					}
				}else{
					$this->Session->setFlash('<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Password you entered does not match with confirmed password.</div>');
					
				}
				
			}
			else{
			
			$this->Session->setFlash('<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>please enter password.</div>');
			
		} 			
		}
		$this->data = $this->User->find('first', array('conditions'=>array('User.id'=>$userSession['id']),'fields'=>array('id')));	
		if(!$this->data){
			$this->redirect(array('action' => 'list'));
		}			
		 
	}
	 */
	function admin_settings() {
		$userSession = $this->Session->read("SESSION_ADMIN");
		$this->set('userSession',$userSession);
		
		$aa=$this->User->find('first',array('conditions'=>array('User.id'=>$userSession['user_type'])));
		//$this->User->session_id = $userSession[0];
		
        $this->set('title_for_layout', 'Change password');
		$pass = $aa['User']['password'];
		//pr($pass);die;
		if(!empty($this->data['User']['old_password'])){
			if(!empty($this->data)){
				$old_psw = md5($this->data['User']['old_password']);
				if($pass == $old_psw){
					if($this->data['User']['password']==$this->data['User']['confirm_password']){
						if ($this->data) {
							$this->User->set($this->data['User']);
							$isValidated = $this->User->validates();
							if ($isValidated) {
								// Update new password
								$result = $this->User->updateAll(array("PASSWORD" => "'".md5(Sanitize::escape($this->data['User']['password']))."'"), array('id' => $userSession));
								if ($result) {
									$this->Session->setFlash('<div class="alert alert-success alert-dismissable">
							  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							   Password changed successfully.
							</div>');
									$this->redirect(array("action" => "settings"));
								}
							}
						}
					}
					else{
					  $this->Session->setFlash('<div class="alert alert-danger alert-dismissable">
							  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							   Password and Confirm password is not matched. 
							</div>');
					   $this->redirect(array('controller'=>'users',"action" => "settings"));
					}
				}else{
					$this->Session->setFlash('<div class="alert alert-danger alert-dismissable">
							  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							   Your old password is incorrect.
							</div>');
				   $this->redirect(array('controller'=>'users',"action" => "settings"));
					
				}
			}
		}
	  
		
    }
	
	#_________________________________________________________________________#
	
	/**
    * @Date: 31-October-2014        
    * @Method : admin_action    
    * @Purpose: This function is used to change status from admin section
    * @Param: $id                                       
    * @Return: none
    * @Return: none
    **/  
     
	function admin_action(){ 
		$data = $this->data; 
		$saveString ='';
		if(!empty($data)){ 
			if(isset($data['ids'])){
				  foreach($data['ids'] as $k=>$v){
					  if($v == 1){
						  unset($data['ids'][$k]);
					  }  
				  }
					$saveString = implode("','",$data['ids']);
			}
			if(!empty($data['action'])&&$data['action'] =='Activate'&&$saveString != ""){ 
					$setValue = array('status' => "'1'");  
					$messageStr = '<div class="alert alert-success">'."Selected user(s) have been activated.".'</div>';
			}elseif(!empty($data['action'])&&$data['action'] =='Deactivate'&&$saveString != ""){
					 $setValue = array('status' => "'2'");
					 $messageStr = '<div class="alert alert-success">'."Selected user(s) have been deactivated.".'</div>';
			}elseif(!empty($data['action'])&&$data['action'] =='Delete'&&$saveString != ""){
				    $setValue = array('deleted' => "'2'");
					$messageStr = '<div class="alert alert-success">'."Selected user(s) have been deleted.".'</div>';
			}elseif(!empty($data['action'])&&$data['action'] =='Approve'&&$saveString != ""){
				    $setValue = array('approved' => "'2'");
					$messageStr = '<div class="alert alert-success">'."Selected user(s) have been approved.".'</div>';
			}
			if($saveString != ""){				
				$this->User->updateAll($setValue,"User.id in ('".$saveString."')");
				$this->Session->setFlash($messageStr);
			}		
		}
        die;			
	}
	 
	  

    /**

    * @Date: 16-March-2016

    * @Method : admin_logout

    * @Purpose: This function is used to destroy admin session.

    * @Param: none

    * @Return: none 

    **/



    function admin_logout(){

		$this->Session->delete("SESSION_ADMIN");

		$this->redirect(array('controller'=>'users','action' => 'login'));

    }
	
	
	/**************
		************
		************
		***************/
		
		
		
		public function admin_delete($id = null) {
			//pr($this->User->id);die('heer');
		$this->User->id = $id;
		$this->User->delete();
		return $this->redirect(array('action' => 'list'));
	}
}