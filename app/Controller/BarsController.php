<?php
	/**
	* Bar Controller class
	* PHP versions 5.1.4
	* @date 01-July-2014
	* @Purpose:This controller handles all the functionalities regarding Bar management.
	* @filesource
	* @revision
	* @version 0.0.1
	**/
	App::uses('Sanitize', 'Utility');

class  BarsController extends AppController
	{
	
    var $name       	=  "Bars";

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
	
    var $uses       	=  array('Bar'); // For Default Model

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

    /**
    * @Date: 11-Aug-2014
    * @Method : admin_list
    * @Purpose: This function is to show list of Categories in system.
    * @Param: none
    * @Return: none 
    **/

	function admin_list(){
		$this->set("title_for_layout", "Bar Listing");		
		$this->set("search1", "");  		
		$this->set("search2", "");		
        $criteria = "Bar.deleted = 1";	
		
		$this->Session->delete('SESSION_SEARCH');
		
		if(isset($this->data['Bar'])){
        $this->Bar->set($this->data['Bar']);
        $isValidated = $this->Bar->validates();
          }
		  
		if(isset($this->data['Bar']) || !empty($this->params['named'])) {
		
		if(!empty($this->data['Bar']['fieldName']) || isset($this->params['named']['field'])){ 
		
        if(trim(isset($this->data['Bar']['fieldName'])) !=""){    
		
            if(trim($this->data['Bar']['fieldName'])=="Bar.name"){
			
				$search1 = "Bar.name"; 
              
            }else{
			
				$search1 = trim($this->data['Bar']['fieldName']);    
				
            }			
                        
        }elseif(isset($this->params['named']['field'])){   
		
			$search1 = trim($this->params['named']['field']);  
			
        }
		
			$this->set("search1",$search1);       
			
		}

		if(isset($this->data['Bar']['value1']) || isset($this->params['named']['value'])){ 
		
			if(isset($this->data['Bar']['value1'])){   
			
				$search2 = trim($this->data['Bar']['value1']);   
				
			}elseif(isset($this->params['named']['value'])){     
			
				$search2 = trim($this->params['named']['value']); 
				
			}        
			
			$this->set("search2",$search2);    
			
			
			
			
			
			
			
		}  
		
      /* Searching starts from here */                                               
      if(!empty($search1) && !empty($search2)){  
	  
		$criteria = 'AND '.$search1." LIKE '%".Sanitize::escape($search2)."%'"; 
		
		$this->Session->write('SESSION_SEARCH', $criteria);
		
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
		
		
		
	
	    // If Admin is login then all records else only logged in user record
		$this->Paginator->settings = array(
		'fields' => array(
        'Bar.*'
        ),
		'conditions' => array(),
		'group'=>'Bar.id',
		'page'=> 1,'limit' => RECORDS_PER_PAGE,
		'order' => array('Bar.name' => 'asc')
		);
	$data = $this->Paginator->paginate('Bar',$criteria);
	
	$this->set('resultData', $data);
    }
	
	
	
	
	
	/**

    * @Date: 10-Jan-2013      

    * @Method : admin_add

    * @Purpose: This function is to add user from admin section.

    * @Param: none

    * @Return: none 

    * @Return: none 

    **/

	function admin_add(){ 
	
	//pr(WWW_ROOT . "img/");die('here');
		$this->set("title_for_layout", "Add Bar");
		//$this->set('bars',$this->Bar->find('list'));
		if ($this->request->is('post')) {
		//Check if image has been uploaded
		$this->Bar->create();
			if(!empty($this->data['Bar']['image']['name']))
            {
                $file=$this->data['Bar']['image'];
                $ary_ext=array('jpg','jpeg','gif','png'); //array of allowed extensions
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
                if(in_array($ext, $ary_ext))
                {   
					$filename=time().$file['name'];
					$des=WWW_ROOT . "img/";
                    move_uploaded_file($file["tmp_name"],$des.$filename );
                    $this->request->data['Bar']['image'] = time().$file['name'];
                }
            } 
			
		$addr=str_replace(' ','+',$this->data['Bar']['name']).","
	.str_replace(' ','+',$this->data['Bar']['street']).",".str_replace(' ','+',$this->data['Bar']['city']).",".
	str_replace(' ','+',$this->data['Bar']['state']).",".str_replace(' ','+',$this->data['Bar']['country']);
		
	//$addr=str_replace(' ','+',$address);
	//pr($addr);die;
		 $Address = urlencode($addr);
		//pr($Address);
		
  $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$Address."&sensor=true";
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $request_url);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $xml = curl_exec($ch);
  $simpleXml = simplexml_load_string($xml);
  $status = $simpleXml->status;
		if($status=="ZERO_RESULTS"){
			 $Lat=0.00;
			 $Lon=0.00;
			 $this->Session->setFlash('<div class="alert alert-success">Please enter valid address</div>');
				 $this->redirect(array(
           'controller'=>'bars',  
           'action' => 'add/'.$this->Bar->getLastInsertId())
            ); 
			 
		}
		else{
      $Lat = $simpleXml->result->geometry->location->lat;
      $Lon = $simpleXml->result->geometry->location->lng;
	  //$Lon= $Lon+1;
      $LatLng = "$Lat,$Lon"; 
	 // echo $LatLng;
		}
		$this->request->data['Bar']['lat']=$Lat;
		$this->request->data['Bar']['lng']=$Lon;
	curl_close($ch);	
		
			if($this->Bar->save($this->request->data)){ 
				$this->Session->setFlash('<div class="alert alert-success">Bar has been created successfully.</div>');
				$this->redirect(array('action' => 'list')); 
			}
			else{
				$this->Session->setFlash('<div class="alert alert-success">Bar has not been created .</div>');
			}
		}
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
	
	function admin_edit($id = null) 
	    {
			//pr($this->data);die;
		$this->set("title_for_layout", "Edit Bar");
		//$this->set('bars',$this->Bar->find('list'));
		if(!empty($this->request->data['Bar']['image']['name']))
            {
                $file=$this->data['Bar']['image'];
                $ary_ext=array('jpg','jpeg','gif','png'); //array of allowed extensions
                   
					$filename=time().$this->data['Bar']['image']['name'];
					$des=WWW_ROOT."/img/";
                    move_uploaded_file($this->data['Bar']['image']["tmp_name"],$des.$filename );
                    $this->request->data['Bar']['image'] = time().$this->data['Bar']['image']['name'];
				
				$saveData = $this->data['Bar'];
					$updated = $this->Bar->updateAll(array('Bar.name'=>"'".$saveData['name']."'",
					'Bar.street'=>"'".$saveData['street']."'",'Bar.city'=>"'".$saveData['city']."'",
					'Bar.description'=>"'".addslashes($saveData['description'])."'",
					'Bar.country'=>"'".$saveData['country']."'",
					'Bar.image'=>"'".$saveData['image']."'",
					'Bar.zipcode'=>"'".$saveData['zipcode']."'",
					'Bar.state'=>"'".$saveData['state']."'"),array('Bar.id'=>$id));	
				if($updated){
					$this->Session->setFlash("Bar has been updated successfully.",'');
					}
					else
					{
						$this->Session->setFlash("Error in update.",'layout_success');
					  }
					$this->redirect(array('action' => 'list'));
            } 
			else{
					if($this->data){
				if(!empty($this->data)){
					//$a=;
					//$YourContent= "'".$saveData['description']."'";
					//$text=str_replace("'","","'".$saveData['description']."'");
					$saveData = $this->data['Bar'];
					$updated = $this->Bar->updateAll(array('Bar.name'=>"'".addslashes($saveData['name'])."'",
					'Bar.street'=>"'".$saveData['street']."'",'Bar.city'=>"'".$saveData['city']."'",
					'Bar.description'=>"'".addslashes($saveData['description'])."'",
					'Bar.country'=>"'".$saveData['country']."'",
					'Bar.zipcode'=>"'".$saveData['zipcode']."'",
					'Bar.state'=>"'".$saveData['state']."'"),array('Bar.id'=>$id));	
					//pr($updated);die;
				if($updated){
					$this->Session->setFlash("Bar has been updated successfully.",'');
					}
					else
					{
						$this->Session->setFlash("Error in update.",'layout_success');
					  }
					$this->redirect(array('action' => 'list'));
				}
			 
			}else if(!empty($id)){
				$this->data = $this->Bar->find('first', array('conditions'=>array('id'=>Sanitize::escape($id))));
				if(!$this->data){
					$this->redirect(array('action' => 'list'));
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
			if(!empty($data['action'])&&$data['action'] =='Delete'&&$saveString != ""){
				    $setValue = array('deleted' => "'2'");
					$messageStr = '<div class="alert alert-success">'."Selected bar(s) have been deleted.".'</div>';
			}else{
				 
			}
			if($saveString != ""){				
				$this->Category->updateAll($setValue,"Bar.id in ('".$saveString."')");
				//$this->Category->updateAll(array('parent_id'=>null),"Category.parent_id in ('".$saveString."')");
				$this->Session->setFlash($messageStr);
			}		
		}
        die;			
	}
	
	
	////
	public function admin_view($id = null) {
     /* $userSession = $this->Session->read("SESSION_ADMIN");
 
          $this->set('userSession',$userSession); */  
          $this->layout="layout_admin";
   if (!$this->Bar->exists($id)) {
    throw new NotFoundException(__('Invalid Bar'));
   }
   $options = array('conditions' => array('Bar.' . $this->Bar->primaryKey => $id));
    
   $this->set('bar', $userdata=$this->Bar->find('first', $options));//pr($userdata);die;
   //$this->set('adid',$userSession[2]);
  }
	/**************
		************
		************
		***************/
		
		
		public function admin_delete($id = null) {
			
		$this->Bar->id = $id;
		$this->Bar->delete();
		return $this->redirect(array('action' => 'list'));
	}
}
