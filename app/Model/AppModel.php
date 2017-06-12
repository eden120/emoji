<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	var $assocs = array();
    function expects($array) {
        foreach ($array as $assoc) {
                $type = $this->assocs[$assoc]['type'];
                unset($this->assocs[$assoc]['type']);
                $this->bindModel(
                        array($type =>
                                array($assoc => $this->assocs[$assoc])
                            ),false
                        );
        } 

    }
	
	/**
    * @Date: 15-July-2014
    * @Method : This function doesn't validate the fields passed in an array
    * @Purpose: Validate numerics only
    * @Param: $field
    * @Return: boolean
    **/
	function uninvalidate($fields = array()){
		foreach($fields as $field) {
			if (isset($this->validate[$field])) {
				unset($this->validate[$field]);
			}
		}
	}
}