<?php

/**
 * Category Model class
 */
App::uses('AppModel', 'Model');

class Image extends AppModel {

    public $session_id;
    var $name = 'Image';
    public $validate = array(
        
        
        'image'=>array(
            'rule'=>'notEmpty',
            'message'=>'Please Upload Image'
        )
    );
}