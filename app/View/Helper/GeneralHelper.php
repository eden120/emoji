<?php

App::uses('AppHelper', 'View/Helper');
class GeneralHelper extends AppHelper
{

	
	 //get list of users
	function getuser() {
        App::import("Model","User");
         $this->User= new User;
         $result= $this->User->find('list', array(
         'conditions' => array('status'=>'1'),
         'fields' => array('id','user_name'),
         'order'=>'user_name  ASC'
    ));
         $result = array('' => '--Select--') + $result;
         return $result;
    } 
	
    // get countries List as a dropdown in admin
    function getcountries() {
	
	    $cntArray = array();
	    $cntArray [""]  = "--- Select ---";
	    App::import("Model","Country");
	    $this->Country=& new Country();
	    $country=  $this->Country->find('all', array('fields'=>array('Country.id','Country.country_name')));
	    
	    foreach($country as $cat){ 
		$cntArray[$cat['Country']['id']] = $cat['Country']['country_name'];
	    }	    
	    return $cntArray;
    }

    // This function is called to sort any associated field
    function getsortlink($name = null, $sort = null, $passesArgs = array(),$urlArray = array()) {
	App::import('Helper','Html');
	$this->Html = new HtmlHelper();
	return $this->Html->link($name, array_merge(array(
		'controller' => $this->params['controller'],
		'action' => $this->params['action'],
		'page' => (!empty($passesArgs['page'])?$passesArgs['page']:"1"),
		'sort' => $sort,
		'direction' => (empty($passesArgs['direction']) || $passesArgs['direction'] == 'asc')?'desc' : 'asc',
		'limit' => (!empty($passesArgs['limit'])?$passesArgs['limit']:RECORDS_PER_PAGE)
	),$urlArray));
    }

    //	This function is called to get links of logged in users.
    function getLinkPermission() {
	    
	    App::import("Model","User");
	    $this->User=& new User();
	    
	    $id=$_SESSION['SESSION_ADMIN']['id'];
	    $type=$_SESSION['SESSION_ADMIN']['type'];
	    
	    $this->User->expects( array('AdminPrevilege'));
	    $data = $this->User->find('first',
		array(
			'conditions'=>array('User.id'=>$id, 'type'=>$type),
			'fields' => array('User.id',
						'User.first_name',
						'User.last_name',
						'AdminPrevilege.*'
						)
		)
	   );
			
	return $data;
    }

  /**
    * @Date: 18-Dec-2010
    * @Method : paymentMethods
    * @Purpose: Function to show weights in dropdown menu.
    * @Param: none
    * @Return: none
    **/
	
    function paymentMethods(){
	$data = array(
		"" => " Select ",
		"check" => "Check",
		"credit card" => "Credit Card",
		"cash" => "Cash",
	);
	return $data;
    }


	//to display all static pages
   function pages() {
			App::import("Model","StaticPage");
			$this->StaticPage = new StaticPage();
             $name = array(
				  'conditions' => array(
						'StaticPage.status' =>'1'
				   ),
				   'fields' => array('slug','title')
				   );
				   //print_r($city_name);
			$page = $this->StaticPage->find('list', $name);
			
			return $page;
	}


//get list of Users

	function getUsers(){

		App::import("Model","User");

		$this->User=new User;

		$result=$this->User->find('list', array('conditions'=>array('type' => 'U'),

		'fields' => array('id','username')

		));

		return $result;

	}
	//get list of Users

	function getProspects(){

		App::import("Model","Prospect");

		$this->Prospect=new Prospect;

		$result=$this->Prospect->find('list', array(

		'fields' => array('id','name')

		));

		return $result;

	}


	  //Retrieve category for news
    function getCategory(){
		App::import('Model','NewsCategory');
		$this->NewsCategory= new NewsCategory;
		$result= $this->NewsCategory->find('list',array(
		'conditions'=>array('status'=>'1'),
		'fields'=>array('id','cat'),
		'order'=>'cat ASC'
		));
		$result= array(''=>'---Please Select---') + $result;
		return $result;
	}
	//display Question type in drop down
	function getQues(){
		$ques=array(
		''=>'--Select--',
		'Our Company'=>'Our Company',
		'Product Enquiry'=> 'Product Enquiry',
		'Our Services'=>'Our Services',
		'Brands'=>'Brands'
		);
		return $ques;
	}
	
	  //Retrieve user roles
    function getUserRoles(){
		App::import('Model','Role');
		$this->Role= new Role;
		$result= $this->Role->find('list',array(
		'conditions'=>array('status'=>'1'),
		'fields'=>array('id','role'),
		'order'=>'role ASC'
		));
		return $result;
	}
	
		//get clients names from contacts table
	function getclients($id = null){
		 App::import("Model","Contact");
		 $this->Contact = new Contact;
		 (empty($id)) ? $cond = " iscurrent = '1' " : $cond = " iscurrent = '1' OR id = $id ";
		 $result = $this->Contact->find('list',array(
			'fields' => array('id','name'),
			'conditions' =>$cond,
			'order' => 'name ASC'
		 ));
		$result = array('' => '--Select--') + $result;
		return $result;
	}
	
	// get permissions for menus 
    function menu_permissions($controller,$action,$userID) {
		  App::import('Model','Permission');
		  $this->Permission= new Permission;
		  $cond = "WHERE controller='$controller' AND action='$action'";
		  $permissionsResult = $this->Permission->find('first',array(
		   'fields' => array('user_id'),
		   'conditions' => $cond,
		  ));
		  if(!empty($permissionsResult)){
		   $users = explode(",",$permissionsResult['Permission']['user_id']);
			if (in_array($userID,$users)) {
			return true;
		   }
		   else{
			return false;
		   }
		  }
		  return true;
		  
	}
	
	//get project list from projects table
	function getProjects(){
		 App::import("Model","Project");
		 $this->Project = new Project;
		 $result = $this->Project->find('list',array(
			'fields' => array('id','project_name'),
			'conditions' =>array('status'=>'current'),
			'order' => 'project_name ASC'
		 ));
		$result = array('' => '--Select--') + $result;
		return $result;
	}
	
	
   /**
    * @Date: 07-March-2013
    *@Method : getInstructionLists
    *@Purpose: Get an array of links for leads listing
  **/

  function getInstructionLists(){

    return $instLinkArray = array(
									'58' => 	'Client Management',
									'87' => 	'Client Sample Terms & Condition',
									'83' => 	'Client Types',
									'72' =>		'Current Sales Plan',
									'56' =>		'Engagement Model',
									'54' => 	'Freelancing Sites Policy',
									'86' =>		'General Freelancing Sites',
									'53' =>		'Lead Management',
									'89' =>		'Payment Reminder(s)',
									'62' =>		'Project Categories',
									'88' =>		'Sales Credentials',
									'39' =>		'Sales Important URL',
									'64' =>		'Sales Reminder Format(s)',
									'55' =>		'Sales Tips',
									'76' =>		'Sales Traits'
								);
  }
  
  //get all users by roles from users table
	function getUsersByRole($role = null){
		 App::import("Model","User");
		 $this->User = new User;
		 (!empty($role)) ? $str = "and FIND_IN_SET($role,role_id)" : $str = "";
		 $cond = "status = '1' ".$str;
         $result= $this->User->find('list', array(
         'conditions' => $cond,
         'fields' => array('id','user_name'),
         'order'=>'user_name  ASC'
    )); 
		if($this->params["action"]!="admin_add" && $this->params["action"]!="admin_edit"){
         $result = array('' => '--Select--') + $result;
		}
         return $result;

	}
	
		 //get list of users
	function getuserexceptme($id) {
        App::import("Model","User");
         $this->User= new User;
         $result= $this->User->find('list', array(
			 //'conditions' => array('status'=>'1','id !='=>$id),
			 'conditions' => array('status'=>'1'),
			 'fields' => array('id','user_name'),
			 'order'=>'user_name  ASC'
		));
		 if($this->params["controller"]=="projects"){
			$result = array('' => 'Management Cell') + $result;
		 }else{
			$result = array('' => '--Select--') + $result;
		 }
         return $result;
    }
	
	function getFirstLastDates($m = null,$y = null){
		$month= (!empty($m)) ? $m : date('m'); 
		$year= (!empty($y)) ? $y : date('Y'); 
		$lastday = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
		$result =array();
		$result['firstdate'] = $year."-".$month."-01";
		$result['lastdate'] = date($year."-".$month.'-'.$lastday);// this function will give you the number of days in given month(that will be last date of the month) 
		return $result;
	}
	
	//get project list from projects table on the basis of user IDs 
	function getProjectsofuser($userid = null){
		 App::import("Model","Project");
		 $this->Project = new Project;
		 $condition =  "`status`='current' AND (`pm_id` = $userid OR `engineeringuser` = $userid OR `salesfrontuser` =$userid OR `salesbackenduser` = $userid OR FIND_IN_SET($userid,team_id))";
		 $result = $this->Project->find('list',array(
			'fields' => array('id','project_name'),
			'conditions' => $condition,
			'order' => 'project_name ASC'
		 ));
		$result = array('0' => 'Other') + $result;
		return $result;
	}
	
	//get all skills list
	function getSkills(){
		 App::import("Model","Skill");
		 $this->Skill = new Skill;
         $result= $this->Skill->find('list', array(
         'fields' => array('id','skills'),
         'order'=>'skills  ASC'
    ));
         $result = array('' => '--Select--') + $result;
         return $result;

	}
	
	//changes sql timestamp format to compare
	function expiredTime($modified_date){
                $diff = abs(time()-strtotime($modified_date));
                 if ($diff < 0)$diff = 0;
                 $dl = floor($diff/60/60/24);
                 $hl = floor(($diff - $dl*60*60*24)/60/60);
                 $ml = floor(($diff - $dl*60*60*24 - $hl*60*60)/60);
                 $sl = floor(($diff - $dl*60*60*24 - $hl*60*60 - $ml*60));
               // OUTPUT
			   $hl = ($dl *24)+$hl;
               $return = array('hours'=>$hl, 'minutes'=>$ml, 'seconds'=>$sl);
               return $return;
	}
	
	 //get users except RACI IDs
	function getuserexceptraci() {
         App::import("Model","User");
         $this->User= new User;
         $result= $this->User->find('list', array(
         'conditions' => array('status'=>'1'),
         'fields' => array('id','user_name'),
         'order'=>'user_name  ASC'
    ));
         //$result = array('' => '--Select--') + $result;
         return $result;
    }
	
	 //get designations from setting table
	function getalldesignations() {
         App::import("Model","Setting");
         $this->Setting= new Setting;
         $result = $this->Setting->find('list', array(
         'conditions' => array('id'=>'3'),
         'fields' => array('key','value'),
		));
		
		$resultAry = explode(",",$result['designations']); 
		$finalData = array();
		foreach($resultAry as $k=>$v){
			$val = trim($v," ");
			$finalData[$val] = $val;
		}
		//pr($finalData); die;
        $finalData = array('' => '--Select--') + $finalData;
         return $finalData;
    }
	
	//get salary and designation info for specific id from appraisal tables
	function getInfoFromAppraisal($id = null) {
		App::import("Model","Appraisal");
		 $today = date("Y-m-d");
         $this->Appraisal= new Appraisal;
         $result = $this->Appraisal->find('all', array(
         'conditions' => array('user_id'=>$id,'status'=>'1','effective_from <' =>$today),
         'fields' => array('user_id','new_designaiton','appraised_amount'),
		 'order' => array('effective_from'=>'desc'),
		 'limit'=>1
		));
		return $result;
    }
	 //get list of users ecxept logged in user
	function getuserexceptloggedin($id) {
        App::import("Model","User");
         $this->User= new User;
         $result= $this->User->find('list', array(
			 'conditions' => array('status'=>'1','id !='=>$id),
			 'fields' => array('id','user_name'),
			 'order'=>'user_name  ASC'
		));
		 if($this->params["controller"]=="projects"){
			$result = array('' => 'Management Cell') + $result;
		 }else{
			$result = array('' => '--Select--') + $result;
		 }
         return $result;
    }
	
	// get Client Session info
	function getClientSession(){
		$clientSession = $_SESSION["SESSION_CLIENT"]; 
		return $clientSession;
	}
	function getusername($id){
		 App::import("Model","User");
         $this->User= new User;
         $result= $this->User->find('first', array(
			 'conditions' => array('id'=>$id),
			 'fields' => array('user_name')
		));
		 return $result;
	}
	
	function getCredentialsforUser($idStr){
		 App::import("Model","Credential");
         $this->Credential= new Credential;
		 $result= $this->Credential->find('all', array(
			 'conditions' => "Credential.id in ($idStr)",
			 'fields' => array('Credential.id','Credential.type','Credential.username')
		));
		return $result;
	
	}
	 //get user based upon its key like process_head,hr form settings table
	function getSpecialDesignatedUser($key = null) {
         App::import("Model","Setting");
         $this->Setting= new Setting;
         $result = $this->Setting->find('list', array(
         'conditions' => array('key'=>$key),
         'fields' => array('key','value'),
		));
		
         return $result;
    }
	

    //get list of users
	function getsalesuser() {
        App::import("Model","User");
         $this->User= new User;
         $result= $this->User->find('list', array(
         'conditions' => "status='1' AND role_id LIKE '%5%' AND id != '1'",
         'fields' => array('id','first_name'),
         'order'=>'id  ASC'
    ));
    
	return $result;
    }
	function getCategories(){
		 App::import("Model","Category");
         $this->Category= new Category;
         $result= $this->Category->find('list', array(
         'conditions' => array('parent_id'=>'0'),
         'fields' => array('id','name')
    ));
         $result = array('0' => '--Self--') + $result;
         return $result;
	}
 }
?>