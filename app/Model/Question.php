<?php
/**
* User Model class
*/

App::uses('AppModel', 'Model');
class Question extends AppModel {
    var $name = 'Question';
	
    public $validate = array(
			'ques' => array(
			    'ruleName' => array(
				'rule' => 'notEmpty',
				'message' => "Please Enter question.",
				'required'=>true,
				'last' => true
				),
				
            ),	
			'ans' => array(
				'rule' => 'notEmpty',
				'required'=>true,
				'message' => "Please Enter answer.",
			),
			

		
    );
	
	
    
}
?>