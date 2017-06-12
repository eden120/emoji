<?php
	/**
	* Categorie Controller class
	* PHP versions 5.1.4
	* @date 01-July-2014
	* @Purpose:This controller handles all the functionalities regarding Categorie management.
	* @filesource
	* @revision
	* @version 0.0.1
	**/
	App::uses('Sanitize', 'Utility');

class  CategoriesController extends AppController
	{
	
    var $name       	=  "Categories";

   /*
    *
	* Specifies helpers classes used in the view pages
	* @access public
	*/
    
    public $helpers    	=  array('Html', 'Form', 'Js', 'Session','General');

    /**
	* Specifies components classes used
	* @access public
    */

    var $components 	=  array('RequestHandler','Email','Common','Paginator','Upload');
	
    var $paginate		  =  array();
	
    var $uses       	=  array('Category','Image'); // For Default Model

	/******************************* START FUNCTIONS **************************/



		#_________________________________________________________________________#

    /**
    * @Date: 28-June-2014
    * @Method : beforeFilter
    * @Purpose: This function is called before any other function.
    * @Param: none
    * @Return: none 
    **/

    function beforeFilter(){
	
		if(!empty($this->params['prefix']) && $this->params['prefix'] == "admin"){
		
			$this->checkUserSession();
			
		}
		if($this->session['user_type'] !=1){
			$this->redirect(array('controller'=>'users','action'=>'dashboard'));
		}
		$this->set('common',$this->Common);
		
    }

    #_________________________________________________________________________#

    /**
    * @Date: 18-Apr-2014
    * @Method : index
    * @Purpose: This page will render home page
    * @Param: none
    * @Return: none 
    **/

	function index() {
	
		$this->layout = false;
		
	}

	#_________________________________________________________________________#

    /**
    * @Date: 28-June-2014
    * @Method : admin_index
    * @Purpose: This is the default function of the administrator section for Categories
    * @Param: none
    * @Return: none 
    **/

	function admin_index(){
	
		$this->render('admin_login');
		
		if($this->Session->read("SESSION_ADMIN") != ""){
		
			$this->redirect('dashboard');
			
		}
		
    }

	
	#_________________________________________________________________________#

   

	
	function admin_add(){ 

	   $this->set("title_for_layout", "Add Category");
	   $this->Category->set($this->data);
	  $this->Category->validates();
	  
      if($this->request->is('post')){
		  //pr($this->data);die;
	    $record=$this->Category->find('all');
		$count= count($record);  
		if($count<=2)
		{
		$this->Category->create();
		$gname =$this->data['Category']['name'] ;
		if (!preg_match("/^[a-zA-Z ]*$/",$gname)) 
			{
					$post_id = $id;
					$this->Session->setFlash(__('No special character and numeric is allowed in this field.'));
					return $this->redirect(array('action' => 'add'));
			}
		if(!empty($this->data['Category']['image']['name']))
            {
                $file=$this->data['Category']['image'];
                $ary_ext=array('jpg','jpeg','gif','png'); //array of allowed extensions
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                if(in_array($ext, $ary_ext))
                {   
					$filename=time().$file['name'];
					$des=WWW_ROOT . "img/";
					//pr($des);die;
                    move_uploaded_file($file["tmp_name"],$des.$filename );
                    $this->request->data['Category']['image'] = time().$file['name'];
                }
				else{
					$this->Session->setFlash(__('Invalid Image Format.'));
				return $this->redirect(array('action' => 'add'));
				}
            }  
			if ($this->Category->save($this->request->data)) 
		  { 
			
           $this->Session->setFlash(__('Category has been created successfully.'));
				return $this->redirect(array('action' => 'add'));
		  } 
         else{
				$this->Session->setFlash(__('Category not saved. Please, try again.'));
			} 
		} else{
				$this->Session->setFlash(__('You can not add more than three categories.'));
			} 
			
	  }
             
        
    }
	
	
	#_____________________________________________________________________________________
		/* function admin_list(){
		$userSession = $this->Session->read("SESSION_ADMIN");
		$this->set('userSession',$userSession);	
			$this->layout="layout_admin";
			    $user=$this->Category->find('all');
				$this->set('u',$user);
		} */
		
		function admin_list(){
		
		$userSession = $this->Session->read("SESSION_ADMIN");
		$this->set('userSession',$userSession);  
		$this->layout="layout_admin";
		$this->set("search1", "");                                 
		$this->set("search2", ""); 
		$search3 = '2,3'; 
        $this->set("search3", $search3);		
		$criteria = "Category.deleted =1 "; //All Searching
		$this->Session->delete('SESSION_SEARCH');
		 
		if(isset($this->data['Category']) || !empty($this->params['named'])) {
			if(!empty($this->data['Category']['fieldName']) || isset($this->params['named']['field'])){     
				if(trim(isset($this->data['Category']['fieldName'])) != ""){  
                   		
					if(trim($this->data['Category']['fieldName'])=="Category.name"){
					$search1 = "Category.name"; 
				}else{
				$search1 = trim($this->data['Category']['fieldName']);    
				}			
				}elseif(isset($this->params['named']['field'])){                              
				$search1 = trim($this->params['named']['field']);                             
				}
				$this->set("search1",$search1); 

                				
			}
			 
			  
			if(isset($this->data['Category']['value1']) || isset($this->params['named']['value'])){          
				if(isset($this->data['Category']['value1'])){                                                          
				$search2 = trim($this->data['Category']['value1']);      
				}elseif(isset($this->params['named']['value'])){       
				$search2 = trim($this->params['named']['value']);      
				}                                                      
				$this->set("search2",$search2);                        
			}
			/* Searching starts from here */                                               
			if(!empty($search1) && !empty($search2)){  
				$criteria .= 'AND '.$search1." LIKE '%".($search2)."%'"; 

			}else{      
			$this->set("search1","");      
			$this->set("search2","");      
			}
		}
		//$criteria.=' AND User.user_type in('.$search3.')';
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
        'Category.*'
        ),
		'conditions' => array(),
		'page'=> 1,'limit' => RECORDS_PER_PAGE,
		'order' => array('Category.name' => 'asc')
		);
	   $data = $this->Paginator->paginate('Category',$criteria);
	
	   $this->set('resultData', $data);
	//$this->set('adid',$userSession[2]);
    }
     #_________________________________________________________________________#
	
    /**
    * @Date: 10-Jan-2014     
    * @Method : admin_edit
    * @Purpose: This function is to edit user from admin section.
    * @Param: none
    * @Return: none 
    * @Return: none 
    **/
	
	
	
	function admin_edit($id = null) {
        $this->set("title_for_layout", "Edit Category");
		$userSession = $this->Session->read("SESSION_ADMIN");
		$this->layout="layout_admin";
		
		
		if ($this->data) {
			$gname =$this->data['Category']['name'] ;
		if (!preg_match("/^[a-zA-Z]*$/",$gname)) 
			{
					$post_id = $id;
					$this->Session->setFlash(__('No special character and numeric is allowed in this field.'));
					return $this->redirect(array('action' => 'add'));
			}
				
              $moveData = $this->data['Category'];
              //$this->Category->set($moveData);
			//$this->Move->validator()->remove('image','rule');
	    
                $saveData = $this->data['Category'];
				if(!empty($this->data['Category']['image']['name'])){
					
						$file=$this->data['Category']['image'];
						$ary_ext=array('jpg','jpeg','gif','png'); //array of allowed extensions
						$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
						if(in_array($ext, $ary_ext))
						{   
							$filename=time().$file['name'];
							$des=WWW_ROOT . "img/";
							move_uploaded_file($file["tmp_name"],$des.$filename );
							$this->request->data['Category']['image'] = time().$file['name'];
						
					}else{
						$this->Session->setFlash(__('Invalid Image Format.'));
				        return $this->redirect(array('action' => 'edit'));
					}
				
					$saveData['image'] = $this->request->data['Category']['image'];
					
	
					$updated = $this->Category->updateAll(array('Category.name'=>"'".$saveData['name']."'",
					'Category.image'=>"'".$saveData['image']."'"), array('Category.id'=>$id));
					if($updated){	
						$this->Session->setFlash("Category has been updated successfully.");
						$this->redirect(array('action' => 'list'));
					}else{
						$this->Session->setFlash("Error in update.");
						$this->redirect(array('action' => 'list'));
					}
				
				}else{
				      $saveData = $this->data['Category'];
				$updated = $this->Category->updateAll(array('Category.name'=>"'".$saveData['name']."'"
                                                                    ), array('Category.id'=>$id));
			          $this->Session->setFlash("Category has been updated successfully.");
						$this->redirect(array('action' => 'list'));	
		          }
		}
            
         else if (!empty($id)) {
            $this->data = $this->Category->find('first', array('conditions' => array('id' =>$id)));
            if (!$this->data) {
                $this->redirect(array('action' => 'list'));
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
     
	 public function admin_delete($id = null) {
			  $userSession = $this->Session->read("SESSION_ADMIN");
		      $this->set('userSession',$userSession);	
			  $this->layout="layout_admin";
			//echo $id;die;
		     $this->Category->id = $id;
		     $this->Category->delete();
		    return $this->redirect(array('action' => 'list'));
	}
	
}