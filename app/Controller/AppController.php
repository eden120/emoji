<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $session; 
	var $uses       	=  array('User');
	function checkUserSession(){
		$action               = $this->params["action"];
		$controller           =   $this->params["controller"];
		$action_before_login = array('admin_login','admin_forgot_password');
			
			// If User, check User session
			if(!empty($this->params['prefix']) && $this->params['prefix'] == "admin"){			
					
					$this->session  = $this->Session->read("SESSION_ADMIN");
					 		 	
					if(empty($this->session) && in_array($action, $action_before_login) == false){
							$this->Session->setFlash('<div class="alert alert-danger alert-dismissable">
						  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						   Please login into the system.
						</div>');  
							$this->redirect(array('controller'=>'users','action'=>'login'));
							
					}
					
					if(!empty($this->session)){
					   $this->layout    = "layout_admin";
					//   $updatedData = $this->User->find('first', array('conditions'=>array('id'=>Sanitize::escape($this->session['id'])),'fields'=>array('id','name','email','profile_pic_id','address','user_type')));
					   $updatedData = $this->User->find('first', array('conditions'=>array('id'=>Sanitize::escape($this->session['id'])),'fields'=>array('id','email','user_type')));
					//  $updatedData = $this->Talent->find('first', array('conditions'=>array('id'=>Sanitize::escape($this->session['id'])),'fields'=>array('id','user_id','location_served')));
					//pr($updatedData);die;
				     // $this->Session->write("SESSION_ADMIN", array('id'=>$updatedData['User']['id'],'name'=>$updatedData['User']['name'],'profile_pic_id'=>$updatedData['User']['profile_pic_id'],'user_type'=>$updatedData['User']['user_type']));
					 $this->Session->write("SESSION_ADMIN", array('id'=>$updatedData['User']['id'],'user_type'=>$updatedData['User']['user_type']
					 ,'email'=>$updatedData['User']['email']));
					}
				}
	}
	
	public function errorValidation($model = null){
		$errors = $this->$model->validationErrors;
		$result = array();
		foreach($errors as $k=>$err){
			$result[$k] = $err[0];
		}
		return $result;
	}
}
