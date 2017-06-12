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
	class DrinksController extends AppController{
    var $name  = "Drinks";
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
    var $uses       	=  array('Drink','Bar'); // For Default Model
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
				$password    = md5(trim($this->data['User']['password']));
				$condition = "User.email='".Sanitize::escape(trim($this->data['User']['email']))."' AND User.password='".$password."'";
				$user_details = $this->User->find('first', array("conditions" => $condition));
 				 
					if($user_details){
						$this->Session->write("SESSION_ADMIN", array('id'=>$user_details['User']['id']));
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
		
		 
    }



	#_________________________________________________________________________#



    /**

    * @Date: 31-October-2014

    * @Method : admin_forgot_password

    * @Purpose: This function is to reset admin's password.

    * @Param: none

    * @Return: none 

    **/

    function admin_forgot_password(){
	 
		    $this->layout = false;
				 
					$this->User->set($this->data);
					$this->User->validate = array(
						'email' => array(
							   'rule' => 'notEmpty',
							   'required' => true,
							   'message' => "Enter email."
					  ));
					  
					  
					$this->User->validate =array('email' => array('ruleName' => array('rule' => 'notEmpty','message' => "Enter Email.",'required'=>true,'last' => true),
					 'ruleName2' => array('rule' =>'email','message' => "Enter a valid email.")));
					
					$isValidated = $this->User->validates();
					
						if($isValidated){
							$condition = "email='".Sanitize::escape($this->data['User']['email'])."' and user_type=1";
						
							$emp_details = $this->User->find('first', array("conditions" => $condition, "fields" => array("id","email","name")));
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
    }


	

	#______________________________________________________________________________________________________________#


/**
    * @Date: 11-Aug-2014
    * @Method : admin_list
    * @Purpose: This function is to show list of Categories in system.
    * @Param: none
    * @Return: none 
    **/
	function admin_list(){
		$this->set("title_for_layout", "Drinks Listing");		
		$this->set("search1", "");  		
		$this->set("search2", "");		
        $criteria = "Drink.deleted = 1";	
		$this->Session->delete('SESSION_SEARCH');
		if(isset($this->data['Drink'])){
			$this->Drink->set($this->data['Drink']);
			$isValidated = $this->Drink->validates();
          }
		if(isset($this->data['Drink']) || !empty($this->params['named'])) {
			if(!empty($this->data['Drink']['fieldName']) || isset($this->params['named']['field'])){ 
				if(trim(isset($this->data['Drink']['fieldName'])) !=""){    
					if(trim($this->data['Drink']['fieldName'])=="Drink.name"){
						$search1 = "Drink.name"; 
					}else{
						$search1 = trim($this->data['Drink']['fieldName']);    
					}			
				}elseif(isset($this->params['named']['field']))
				{   
					$search1 = trim($this->params['named']['field']);  
					
				}
				$this->set("search1",$search1);       
			}
			if(isset($this->data['Drink']['value1']) || isset($this->params['named']['value'])){ 
				if(isset($this->data['Drink']['value1'])){   
					$search2 = trim($this->data['Drink']['value1']);   
				}elseif(isset($this->params['named']['value'])){     
					$search2 = trim($this->params['named']['value']); 
				}        
				$this->set("search2",$search2);    
			}
			/* Searching starts from here */                                               
			if(!empty($search1) && !empty($search2)){  
				$criteria = 'AND '.$search1." LIKE '%".Sanitize::escape($search2)."%'"; 
				$cat= $this->Session->write('SESSION_SEARCH', $criteria);
				//pr($cat);die('here');
			}else{      
				$this->set("search1","");      
				$this->set("search2","");    
			}
		//echo "---".$search1; 	echo "---".$search2; die;
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
		// If Admin is login then all records else only loggedin Categorie record
		$this->Paginator->settings = array(
		'joins' => array(
		array('table' => 'bars',
			'alias' => 'Bar',
			'type' => 'INNER',
			"conditions" => 'Drink.barid = Bar.id'
			)
		),
		'fields' => array(
			'Drink.*',
			'Bar.*'
		),
		'conditions' => array(),
		'page'=> 1,'limit' => RECORDS_PER_PAGE,
		'order' => array('Drink.name' => 'asc')
		);
		$data = $this->Paginator->paginate('Drink',$criteria);
		$this->set('resultData', $data);
	}
 #______________________________________________________________________________________________________________#

/**

    * @Date: 10-Jan-2013      

    * @Method : admin_add

    * @Purpose: This function is to add user from admin section.

    * @Param: none

    * @Return: none 

    * @Return: none 

    **/

	
	function admin_add(){ 
		//pr($this->data); die;
	    $this->set("title_for_layout", "Add Drink");
		//pr($this->request->data);die;
		//pr($this->Drink->find('all'));die;
		//$this->loadModel('Bar');
		$this->set('bars',$this->Bar->find('list'));
		
		if($this->data){
		//Check if image has been uploaded
		 $CategorieData = $this->request->data['Drink'];
			if(!empty($this->data['Drink']['img']['name']))
                {
                        $file=$this->data['Drink']['img'];
					$filename=time().$file['name'];
					$des=WWW_ROOT . '/img/';
                    move_uploaded_file($file["tmp_name"],$des.$filename );
                  //  $this->request->data['Drink']['img'] = time().$file['name'];
                                $CategorieData['img'] = $filename;
                        
                }
        
      // $CategorieData['id']=1;
         $ss=$this->Drink->set($CategorieData);
          
			//pr($ss);die();
            if($this->Drink->save($CategorieData)){ 
			
             $this->Session->setFlash('<div class="alert alert-success">Drink has been created successfully.</div>');
			 
             $this->redirect(array('action' => 'list')); 
            }
			else{
				 $this->Session->setFlash('<div class="alert alert-success">Drink has not been created .</div>');
				
			}
        }
    } 
	


#__________________________________________________________________________________________________________#


function admin_edit($id = null) 
	    {
		$this->set("title_for_layout", "Edit Drink");
		$this->set('bars',$this->Bar->find('list'));
		if(!empty($this->request->data['Drink']['img']))
            {
                $file=$this->data['Drink']['img'];
               
                   
					$filename=time().$file['name'];
					$des=WWW_ROOT . '/img/';
                    move_uploaded_file($file["tmp_name"],$des.$filename );
                    $this->request->data['Drink']['img'] = time().$file['name'];
                
				$saveData = $this->data['Drink'];
					$updated = $this->Drink->updateAll(array('Drink.barid'=>"'".$saveData['barid']."'",
					'Drink.name'=>"'".$saveData['name']."'", 'Drink.description'=>"'".addslashes($saveData['description'])."'",
					'Drink.price'=>"'".$saveData['price']."'",'Drink.img'=>"'".$saveData['img']."'"),array('Drink.id'=>$id));	
				if($updated){
					$this->Session->setFlash("Drink has been updated successfully.",'');
					}
					else
					{
						$this->Session->setFlash("Error in update.",'layout_success');
					  }
					$this->redirect(array('action' => 'list'));
            }else{ 
			
					if($this->data){
				if(!empty($this->data)){
					$saveData = $this->data['Drink'];
					$updated = $this->Drink->updateAll(array('Drink.barid'=>"'".$saveData['barid']."'",
					'Drink.name'=>"'".$saveData['name']."'",'Drink.price'=>"'".$saveData['price']."'", 'Drink.description'=>"'".addslashes($saveData['description'])."'"
					),array('Drink.id'=>$id));
				if($updated){
					$this->Session->setFlash("Drink has been updated successfully.",'');
					}
					else
					{
						$this->Session->setFlash("Error in update.",'layout_success');
					  }
					$this->redirect(array('action' => 'list'));
				}
			 
			} if(!empty($id)){
				$this->data = $this->Drink->find('first', array('conditions'=>array('id'=>Sanitize::escape($id))));
				if(!$this->data){
					$this->redirect(array('action' => 'list'));
				}
			}
		}
		
	}






     #_________________________________________________________________________#

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
     
	function admin_settings(){ 
	 
	    $this->set("title_for_layout","Settings");
		 
	   if($this->data){
		foreach($this->data['User'] as $k=> $v){
		   $this->Option->updateAll(array("value"=>$v),array("user_id"=>"1","name"=>$k));
		}   
	   }
	   $this->data = $this->Option->find('all',array('conditions'=>array('user_id'=>1)));
	}
	#_________________________________________________________________________#
	/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		
		if (!$this->Drink->exists($id)) {
			throw new NotFoundException(__('Invalid Drink'));
		}
		$options = array('conditions' => array('Drink.' . $this->Drink->primaryKey => $id));
		$find=$this->Drink->find('first', $options);
		$this->set('drink', $find);
		$bid=$find['Drink']['barid'];
		$options1 = array('conditions' => array("Bar.id='".$bid."'"));
		$this->set('bar', $this->Bar->find('first', $options1));
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
			
		$this->Drink->id = $id;
		$this->Drink->delete();
		return $this->redirect(array('action' => 'list'));
	}
	
}