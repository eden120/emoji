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
class ServicesController extends AppController{
    var $name       	=  "Services";
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
    var $uses       	=  array('User','Service'); // For Default Model
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
			$this->redirect(array('controller'=>'users','action'=>'dashboard','admin'=>true));
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
			$this->redirect(array('controller'=>'services','action'=>'list'));
		}
    }
	 

	#______________________________________________________________________________________________________________#



    /**

    * @Date: 31-October-2014

    * @Method : admin_list

    * @Purpose: This function is to show services listing.

    * @Param: none

    * @Return: none 

    **/
	function admin_list(){
		$this->set("title_for_layout", "Services Listing");
		$this->set("search1", "");                                 
		$this->set("search2", "");                                 
		$criteria = "Service.deleted = 1"; //All Searching
		$this->Session->delete('SESSION_SEARCH');
		if(isset($this->data['Service'])||!empty($this->params['named'])){
			if(!empty($this->data['Service']['fieldName'])||isset($this->params['named']['field'])){     
				if(trim(isset($this->data['Service']['fieldName'])) != ""){  
                   		
					if(trim($this->data['Service']['fieldName'])=="Service.name"){
					$search1 = "Service.name"; 
				}else{
				$search1 = trim($this->data['Service']['fieldName']);    
				}			
				}elseif(isset($this->params['named']['field'])){                              
				$search1 = trim($this->params['named']['field']);                             
				}
				$this->set("search1",$search1);                                               
			}
			
			if(isset($this->data['Service']['value1']) || isset($this->params['named']['value'])){          
				if(isset($this->data['Service']['value1'])){                                                       
				    $search2 = trim($this->data['Service']['value1']);      
				}elseif(isset($this->params['named']['value'])){       
				    $search2 = trim($this->params['named']['value']);      
				}                                                      
				$this->set("search2",$search2);                        
			}
			
			
			if(!empty($search1) && !empty($search2)){  
				$criteria .= ' And '.$search1." LIKE '%".Sanitize::escape($search2)."%'"; 
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
		$this->Paginator->settings = array(
		'fields' => array(
        'Service.*',
        ),
		'conditions' => array(),
		'page'=> 1,'limit' => RECORDS_PER_PAGE,
		'order' => array('Service.id' => 'DESC')
		);
	    $data = $this->Paginator->paginate('Service',$criteria);
	    $this->set('resultData', $data);
		
    } 
 
	/**

    * @Date: 31-October-2014        

    * @Method : admin_delete    

    * @Purpose: This function is used to delete users from admin section.

    * @Param: $id                                       

    * @Return: none

    * @Return: none

    **/  

     

	function admin_delete(){				

		if(isset($this->params['form']['IDs'])){

			$deleteString = implode("','",$this->params['form']['IDs']);
				

		}elseif(isset($this->params['pass'][0]) && $this->params['pass'][0] != ADMIN_ID){

			$deleteString = $this->params['pass'][0];

		}else{

			$this->redirect('list');

		}

		

		if(!empty($deleteString)){



			$this->User->deleteAll("User.id in ('".$deleteString."')");

			$this->Session->setFlash("<div class='success-message flash notice'>User(s) deleted successfully.</div>", 'layout_success');

			$this->redirect('list');

		}

	}

	#_________________________________________________________________________#
	
	/**
    * @Date: 31-October-2014        
    * @Method : admin_ChangeStatus    
    * @Purpose: This function is used to change status from admin section
    * @Param: $id                                       
    * @Return: none
    * @Return: none
    **/  
     
		function admin_changeStatus(){ 
		
				if(isset($this->data['publish'])){ 
				 
					$updateCredentials = 0;
					$setValue = array('status' => "'1'");
					$messageStr = "Selected user(s) have been activated.";
				}elseif(isset($this->data['unpublish'])){
					$updateCredentials = 1;
					$setValue = array('status' => "'0'");
					$messageStr = "Selected user(s) have been deactivated.";
				}
				if(!empty($setValue)){ 
					if(isset($this->data['IDs'])){
					$saveString = implode("','",$this->data['IDs']);
				}
				if($saveString != ""){
					$this->User->updateAll($setValue,"User.id in ('".$saveString."')");
					$this->Session->setFlash($messageStr, 'layout_success');
					$this->redirect('list');   
				}
			}
             $this->redirect('list'); 			
		}
}