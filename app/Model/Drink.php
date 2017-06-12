<?php
/**
* User Model class
*/

App::uses('AppModel', 'Model');
class Drink extends AppModel {
    var $name = 'drinks';
	
    public $validate = array(
			'name' => array(
			    'ruleName' => array(
				'rule' => 'notEmpty',
				'message' => "Please Enter Drink Name.",
				'required'=>true,
				'last' => true
				),
				'ruleName2' => array(
				'rule' => array('checkUnique',array('name','deleted'),false),
				'message' => "Email Already Exists."
				)
            ),	
			'img' => array(
				'rule' => 'notEmpty',
				'required'=>true,
				'message' => "Please Upload Drink Image.",
			),
			
			'price' => array(
			    'ruleName' => array(
				'rule' => 'notEmpty',
				'required'=>true,
				'message' => "Please Enter Drink price.",
				),
				'ruleName2' => array(
				'rule' => 'Numeric',
				'required'=>true,
				'message' => "Please Enter Numeric Price."
				)
				),
			
			    'barid' => array(
				'rule' => 'notEmpty',
				'required'=>true,
				'message' => "Please select Bar name.",
			),	
			
				'description' => array(
				'rule' => 'notEmpty',
				'required'=>true,
				'message' => "Please Enter Drink description",
			     ),

		
    );
	
	
    public function login_custom_validation(){
           unset($this->validate['email']['ruleName2']);
		   $this->validate['dob']['required'] = false;
		   $this->validate['country']['required'] = false;
     } 	
	
	
	public function device_custom_validation(){
           $this->validate['email']['ruleName']['required'] = false;
		   $this->validate['dob']['required'] = false;
		   $this->validate['country']['required'] = false;
		   $this->validate['password']['required'] = false;
		   $this->validate['id'] = array(
				'ruleName' => array(
				'rule' => 'notEmpty',
				'message' => "Id Required."
				),
				'ruleName2' => array(
				'rule' => array('id_exists'),
				'message' => "User Not Exist."
				)
            );
		   $this->validate['device_id'] = array(
				'ruleName' => array(
				'rule' => 'notEmpty',
				'message' => "Device Id Required."
				)
				);
    
	 }
	
	public function edit_custom_validation(){
           $this->validate['email']['ruleName']['required'] = false;
		   $this->validate['dob']['required'] = false;
		   $this->validate['country']['required'] = false;
		   $this->validate['password']['required'] = false;
	       $this->validate['id'] = array(
				'ruleName' => array(
				'rule' => 'notEmpty',
				'message' => "Id Required."
				),
				'ruleName2' => array(
				'rule' => array('id_exists'),
				'message' => "User Not Exist."
				)
            );
		   $this->validate['latitude'] = array(
				'ruleName' => array(
				'rule' => 'notEmpty',
				'message' => "Please Enter Latitude"
				)
				);
			$this->validate['longitude'] = array(
				'ruleName' => array(
				'rule' => 'notEmpty',
				'message' => "Please Enter Longitude"
				)
				);
		  
     }
	
	
	
    public function contact_custom_validation(){		  
		   unset($this->validate['email']['ruleName']);
		   unset($this->validate['email']['ruleName2']);	
		   $this->validate['fname']['required'] = false;
		   $this->validate['lname']['required'] = false;
		   $this->validate['password']['required'] = false;
              $this->validate = array(
		         'id' => array(
				'ruleName' => array(
				'rule' => 'notEmpty',
				'message' => "Id Required."
				),
				'ruleName2' => array(
				'rule' => array('id_exists'),
				'message' => "User Not Exists."
				)
                ),
			    'email' => array(
			    'ruleName2' => array(
				'rule' => array('checkUnique',array('email','deleted'),false),
				'message' => "Email Already Exists."
				 )
				 )
			  );
			  
	 }
	 

	 
	 
	 
	 

 public function facebook_custom_validation(){		  
		   $this->validate['password']['required'] = false;
                    $this->validate['fb_id'] = array(
				'ruleName' => array(
				'rule' => 'notEmpty',
				'message' => " Unique Id Missing."
				),
		 'unique' => array(
                'rule' => 'isUnique',
                'message' => 'This id already exist !!'
				 )
			
            );
		  }
	
	 public function checkUnique($ignoredData,$fields,$or = true) {
          return $this->isUnique($fields,$or);
     }

	 
	  public function verification_custom_validation(){
		   unset($this->validate['email']['ruleName2']);
		   $this->validate['fname']['required'] = false;
		   $this->validate['lname']['required'] = false;
		   $this->validate['email']['ruleName']['required'] = false;
		   $this->validate['password']['required'] = false;
           $this->validate['id'] = array(
				'ruleName' => array(
				'rule' => 'notEmpty',
				'message' => " User Id Required."
				),
			
				'rule2' => array(
				'rule' => array('id_exists'),
				'message' => "User Not Exists."
				)
			
            );
	  }
	  
 
	 /**
    * @Date: 24-MAY-2016
    * @Method : id_exists
    * @Purpose: Check if id of a valid user.
    * @Param: $field, $compare_field
    * @Return: boolean
    **/
	function id_exists($field = array()) {
		 $user = $this->find('first',array('conditions'=>array('id'=>$field['id'])));
		 $result = 'Invalid Id';
        if(!empty($user)&&$user['User']['deleted'] == 1){
			$result = true;
			if($user['User']['user_type']=='S'&&$user['User']['verify'] == 1){
				$result = 'Verification Pending.';
			}
			if($user['User']['status'] == 2){
				$result = 'Disabled by admin.';
			}
	
		}
		return $result;
    }
	 
    /**
    * @Date: 14-Aug-2010
    * @Method : matchPasswords
    * @Purpose: Check if password entered by User is equal to confirm password
    * @Param: $field, $compare_field
    * @Return: boolean
    **/
	function matchPasswords($field = array(),$compare_field = null) {
        foreach($field as $key => $value){
        $v1 = trim($value);
		$v2 = trim($this->data[$this->name][ $compare_field ]);
        if($v1 != "" && $v2 !="" && $v1 != $v2){
            return false; 
        }
         return true;
      }
    }
	
    function oldPasswordexist($field = array()){
        $userId = 	$this->data['User']['user_id'];
        foreach( $field as $key => $value ){
			$v1 = md5(trim($value));
			$result = $this->find('first', array('conditions' => array('id' => $userId, 'password'=>$v1),'fields'=>array('id')));
			if(empty($result['User'])){
				return false; 
			 }
			 return true;
		}
    }
	 
}
?>