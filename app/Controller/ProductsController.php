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
class ProductsController extends AppController{
    var $name       	=  "Products";
    /*
	* Specifies helpers classes used in the view pages
	* @access public
	*/
    public $helpers    	=  array('Html', 'Form', 'Js', 'Session','General','Paginator');
    /**
	* Specifies components classes used
	* @access public
    */
    var $components =  array('RequestHandler','Email','Common','Paginator','Upload');
    var $paginate  =  array();
    var $uses  =  array('User','Category','Option','Product'); // For Default Model
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
 #______________________________________________________________________________________________________________#



    /**

    * @Date: 31-October-2014

    * @Method : admin_ulist

    * @Purpose: This function is to show list of users in system.

    * @Param: none

    * @Return: none 

    **/
	function admin_list(){
		
		if($this->session['user_type'] !=1){		 
			$this->redirect(array('controller'=>'users','action'=>'dashboard'));
		}
		$this->set("title_for_layout", "Users Listing");
		$this->set("search1", "");                                 
		$this->set("search2", ""); 		
		$criteria = "Product.deleted = 1"; 
		$this->Session->delete('SESSION_SEARCH');
		 
		if(isset($this->data['Product']) || !empty($this->params['named'])) {
			if(!empty($this->data['Product']['fieldName']) || isset($this->params['named']['field'])){     
				if(trim(isset($this->data['Product']['fieldName'])) != ""){  
                   		
					if(trim($this->data['Product']['fieldName'])=="Product.name"){
					$search1 = "Product.name"; 
				}else{
				   $search1 = trim($this->data['Product']['fieldName']);    
				}			
				}elseif(isset($this->params['named']['field'])){                              
				   $search1 = trim($this->params['named']['field']);                             
				}
				$this->set("search1",$search1); 

                				
			}
			  
			if(isset($this->data['Product']['value1']) || isset($this->params['named']['value'])){         
				if(isset($this->data['Product']['value1'])){                                                          
				$search2 = trim($this->data['Product']['value1']);      
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
        'Product.*',
		'User.*'
        ),
		'conditions' => array(),
		'joins' => array(array('table' => 'users','alias' => 'User','type' => 'INNER','conditions' => "User.id = Product.user_id AND Product.deleted = 1 AND Product.approved = 2 AND User.status= 1 AND User.deleted= 1")),
		'group'=>'Product.id',
		'page'=> 1,'limit' => RECORDS_PER_PAGE,
		'order' => array('Product.name' => 'asc')
		);
	$data = $this->Paginator->paginate('Product',$criteria);
	$this->set('resultData', $data);
    }

	
	#__________________________________________________________________________________________________#

    /**
    * @Date: 31-October-2014

    * @Method : admin_pending

    * @Purpose: This function is to show list of users in system.

    * @Param: none

    * @Return: none 

    **/
	function admin_pending(){
		if($this->session['user_type'] !=1){		 
			$this->redirect(array('controller'=>'users','action'=>'dashboard'));
		}
		$this->set("title_for_layout", "Products Listing");
		$this->set("search1", "");                                 
		$this->set("search2", ""); 		
		$criteria = "Product.deleted = 1 AND Product.approved = 1 "; //All Searching
		$this->Session->delete('SESSION_SEARCH');
		 
		if(isset($this->data['Product']) || !empty($this->params['named'])) {
			if(!empty($this->data['Product']['fieldName']) || isset($this->params['named']['field'])){     
				if(trim(isset($this->data['Product']['fieldName'])) != ""){  
                   		
					if(trim($this->data['Product']['fieldName'])=="Product.name"){
					$search1 = "Product.name"; 
				}else{
				   $search1 = trim($this->data['Product']['fieldName']);    
				}			
				}elseif(isset($this->params['named']['field'])){                              
				   $search1 = trim($this->params['named']['field']);                             
				}
				$this->set("search1",$search1); 

                				
			}
			  
			if(isset($this->data['Product']['value1']) || isset($this->params['named']['value'])){         
				if(isset($this->data['Product']['value1'])){                                                          
				$search2 = trim($this->data['Product']['value1']);      
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
        'Product.*',
		'User.*'
        ),
		'conditions' => array(),
		'joins' => array(array('table' => 'users','alias' => 'User','type' => 'INNER','conditions' => "User.id = Product.user_id AND Product.deleted = 1 AND User.status= 1 AND User.deleted= 1")),
		'group'=>'Product.id',
		'page'=> 1,'limit' => RECORDS_PER_PAGE,
		'order' => array('Product.name' => 'asc')
		);
	$data = $this->Paginator->paginate('Product',$criteria);
	$this->set('resultData', $data);
    }
	 
	 
	 #_________________________________________________________________________#
	
	/**
    * @Date: 31-October-2014        
    * @Method : admin_details    
    * @Param: $id                                       
    * @Return: none
    * @Return: none
    **/  
     
	function admin_details($id=null){ 
	 
	    $this->set("title_for_layout", "Product Details");
		if($id){
			$this->data = $this->Product->find('first', array('conditions'=>array('Product.id'=>Sanitize::escape($id)),'joins' => array(array('table' => 'users','alias' => 'User','type' => 'INNER','conditions' => "User.id = Product.user_id"),array('table' => 'categories','alias' => 'Category','type' => 'INNER','conditions' => "Category.id = Product.cat_id")),'fields'=>array('*')));
		}
		
		if(empty($this->data)){
			$this->redirect(array('controller'=>'products','action'=>'list'));
			
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
			 if(!empty($data['action'])&&$data['action'] =='Delete'&&$saveString != ""){
				    $setValue = array('deleted' => "'2'");
					$messageStr = '<div class="alert alert-success">'."Selected product(s) have been deleted.".'</div>';
			}elseif(!empty($data['action'])&&$data['action'] =='Approve'&&$saveString != ""){
				    $setValue = array('approved' => "'2'");
					$messageStr = '<div class="alert alert-success">'."Selected product(s) have been approved.".'</div>';
			}
			if($saveString != ""){				
				$this->Product->updateAll($setValue,"Product.id in ('".$saveString."')");
				$this->Session->setFlash($messageStr);
			}		
		}
        die;			
	}
}