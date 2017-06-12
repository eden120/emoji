<?php
	/**
	* User Controller class
	* PHP versions 5.1.4
	* @date 12-Dec-2014
	* @Purpose:This controller handles all the functionalities regarding web services.
	* @filesource
	* @revision
	* @version 0.0.1
	**/
	App::uses('Sanitize', 'Utility');

class CommonsController extends AppController {
	
    var $name       	=  "Commons";
    
   /*
    *
	* Specifies helpers classes used in the view pages
	* @access public
	*/
    public $helpers    	=  array('Html', 'Form', 'Js', 'Session','General','Paginator');
    var $components 	=  array('RequestHandler','Email','Common','Paginator','Upload');
    var $paginate		  =  array();
    var $uses       	=  array('User','Image'); // For Default Model
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
		$this->layout    = Null;
		if(!empty($this->params['prefix']) && $this->params['prefix'] == "admin"){
			$this->checkUserSession();
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
		$this->redirect(array('controller'=>'users','action'=>'dashboard'));
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
			$this->redirect(array('controller'=>'users','action'=>'dashboard'));
			die;
    }
 
	#_________________________________________________________________________#

    /**
    * @Date: 28 DEC 2015
    * @Method : image
    * @Purpose: display image
    * @Param: none
    * @Return: none 
    **/
	function admin_image($id=null){
        $img = $this->Image->find('first', array("conditions" =>array('id'=>$id)));

		$img_status = true; 
		$folder = 'images/uploaded/';
            if(!empty($img['Image']['name'])){				
                 $name = $img['Image']['name'];
						if(file_exists($folder.$name)){
							$img_status = false;
							$path = $folder.$name;
						} 
		    }
			
			if($img_status){
				$path = $folder.'Default.*';
				$img = glob($path);
				if (count($img) > 0) {
                    $path = $img[0];
                }else{
                    echo "Default.* image missing.";
					die;
                }
			}
			$response = getimagesize($path);
			header('content-type:'.$response['mime']);
			readfile($path);
			die;
		 
	} 
/**
    * @Date: 28 DEC 2015
    * @Method : upload
    * @Purpose: Upload Image
    * @Param: none
    * @Return: none 
    **/
	function admin_upload(){
		$result = array('stats'=>0,'message'=>'Unable to upload!!'); 
		if(!empty($_FILES['image'])&&$_FILES['image']['size']>0){
				$destination = realpath('../../app/webroot/img/profile_image'). DS;	
				$ext = $this->Common->file_extension($file['name']);
				$filename = $this->session['id'].'_'.time().'.'.strtolower($ext);
			  
					$result = array('stats'=>0,'message'=>'Invalid image!!');
					if(preg_match("/gif|jpg|jpeg|png/i", $ext) > 0){
						if($this->Upload->upload($file, $destination, $filename)){
							$result = array('stats'=>0,'message'=>'Unable to upload!!'); 
							if($this->Image->save(array('name'=>$filename,'user_id'=>$this->session['id']))){
								$result = array('stats'=>1,'id'=>$this->Image->id);
							}
							
						} 
					}
		}
		echo json_encode($result);
		die;
	} 	
}