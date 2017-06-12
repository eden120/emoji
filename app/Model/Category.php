<?php

/**
 * Category Model class
 */
App::uses('AppModel', 'Model');

class Category extends AppModel {

    public $session_id;
    var $name = 'Category';
    public $validate = array(
	
        'name' => array(
			'length' => array(
                        'rule' => array('maxLength', '40'),
                        'message' => 'Category Name maximum length is 40 characters '
			),
			
		
		'name'=>array(
            'rule'=>'notEmpty',
            'message'=>'Please Enter Name'
        )
        ),
		 'description'=>array(
            'rule'=>'notEmpty',
            'message'=>'Please Enter some Description'
        ),
        'image'=>array(
            'rule'=>'notEmpty',
            'message'=>'Please Upload Image'
        )
		
    );
}