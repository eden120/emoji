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
	class QuestionsController extends AppController{
    var $name  = "questions";
   /*
    *
	* Specifies helpers classes used in the view pages
	* @access public
	*/
    public $helpers    =  array('Html', 'Form', 'Js', 'Session','General','Paginator');
    /**
	* Specifies components classes used
	* @access public
    */
    var $components 	=  array('RequestHandler','Email','Common','Paginator','Upload');
    var $paginate		  =  array();
    var $uses       	=  array('Question'); // For Default Model
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
		$this->paginate = array(
			     'conditions' => array('Question .ques LIKE' => 'a%'),
			     'limit' => 2
		     );
		$resultData = $this->Paginator->paginate('Question');
		$this->set(compact('resultData'));
	         

	}#______________________________________________________________________________________________________________#

/**

    * @Date: 10-Jan-2013      

    * @Method : admin_add

    * @Purpose: This function is to add user from admin section.

    * @Param: none

    * @Return: none 

    * @Return: none 

    **/

	
	
	function admin_add(){ 
	
		$this->set("title_for_layout", "Add Question");
		if ($this->request->is('post')) {
		//Check if image has been uploaded
		$this->Question->create();
			if($this->Question->save($this->request->data)){ 
				$this->Session->setFlash('<div class="alert alert-success">Question has been created successfully.</div>');
				$this->redirect(array('action' => '')); 
			}
			else{
				$this->Session->setFlash('<div class="alert alert-success">Question has not been created .</div>');
			}
		}
    } 
	


#__________________________________________________________________________________________________________#


		function admin_edit($id = null) 
	    {
		$this->set("title_for_layout", "Edit Question");
		
				if($this->data){
				if(!empty($this->data)){
					$saveData = $this->data['Question'];
					$updated = $this->Question->updateAll(array('Question.ques'=>"'".$saveData['ques']."'",
					'Question.ans'=>"'".addslashes($saveData['ans'])."'"),array('Question.id'=>$id));	
				if($updated){
					$this->Session->setFlash("Question has been updated successfully.",'');
					}
					else
					{
						$this->Session->setFlash("Error in update.",'layout_success');
					}
					$this->redirect(array('action' => 'list'));
				}
			 
			}else if(!empty($id)){
				$this->data = $this->Question->find('first', array('conditions'=>array('id'=>Sanitize::escape($id))));
				if(!$this->data){
					$this->redirect(array('action' => 'list'));
				}
			}
		
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
		
		if (!$this->Question->exists($id)) {
			throw new NotFoundException(__('Invalid Question'));
		}
		$options = array('conditions' => array('Question.' . $this->Question->primaryKey => $id));
		$find=$this->Question->find('first', $options);
		$this->set('question', $find);
		
		
	}
#_________________________________________________________________________#
	
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