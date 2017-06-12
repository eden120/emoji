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
	

class ApiController extends AppController{
	
    var $name       	=  "Api";
   /*
    *
	* Specifies helpers classes used in the view pages
	* @access public
	*/
    
    public $helpers    	=  array();

    /**
	* Specifies components classes used
	* @access public
    */

    var $components 	=  array('RequestHandler','Paginator','Email','Common','Upload');
    var $paginate		=  array();
    var $uses=  array('User','Category','Image'); // For Default Model
       	
	#_________________________________________________________________________#

    /**
    * @Date: 12-Dec-2014
    * @Method : beforeFilter
    * @Purpose: This function is called before any other function.
    * @Param: none
    * @Return: none 
    **/

    function beforeFilter(){
        
	}
			#_________________________________________________________________________#

			
function all_categories(){
			         if($this->data['auth_key']==123){
				$categories= $this->Category->find('all',array('order' => array('Category.id' => 'asc')));
				//pr($departments);die;
					 if(!empty($categories)){
					foreach($categories as $categorie){
					$result[]=array('category_id'=>$categorie['Category']['id'],'category_name'=>$categorie['Category']['name'],'category_image'=>BASE_URL."img/".$categorie['Category']['image']);
					}
					$result=array('status'=>1,'result'=>$result);
					 }else{
					$result=array('status'=>0,'result'=>'records not exist');	 
					 }
				} else{
			$result = array("status"=>0,"message"=>"Auth key donot match.");
		} 
			$this->set(array(
            'result' => $result,
            '_serialize' =>'result'
        ));
		} 	
	
#_______________________________________________________________________________________________
        function get_category(){
			if($this->data['auth_key']==123){
				$saveArray=$this->data;
				if(!empty($saveArray['category_id'])){
					$condition=array('AND'=>array(
				  "Category.id='".$saveArray['category_id']."'",
				  ));		
				$categorie=$this->Category->find('first',array('conditions'=>$condition));
				if(!empty($categorie))
				{
				$id=$categorie['Category']['id'];
				$con=array('AND'=>array(
				  "Image.category_id='".$id."'",
				  ));
				
				
				$images=$this->Image->find('all',array('conditions'=>$con));
				
				//pr($images);die;
			if(!empty($images)){
				

					foreach($images as $image){
					
					$img[]=array('image_id'=>$image['Image']['id'],'image'=>BASE_URL."img/".$image['Image']['image']
							);
					
					
					}
					
			}
			
			$cat=array('category_id'=>$categorie['Category']['id'],'category_name'=>$categorie['Category']['name']);
			$record=array('category_id'=>$categorie['Category']['id'],'category_name'=>$categorie['Category']['name'],
							'images'=>$img);
							//pr($record);die('k');
		     
			  $result=array('status'=>1,'result'=>$record);
			  //pr($result);die;
					 					
					$nopost=count($img);
					//pr($nopost);die;
					$offset = 0;
                    $limit =10;
                    $totalpage = 0; 
            if($nopost>0){
                 $totalpage = $nopost/$limit;
                 if((int)$totalpage != $totalpage){
                      $totalpage = (int)$totalpage;
                      $totalpage++;
                 }
            }
      
           if(!empty($saveArray['page'])&&$saveArray['page']>1){
                  $offset = ((int)$saveArray['page']-1)*$limit;
            }
       $result = array('status'=>'0','category'=>$cat,'result'=>[],'totalpage'=>$totalpage);
         //  $result = array('status'=>'0','message'=>'Not Found!!','totalpage'=>$totalpage);
      
                if($offset<($totalpage*$limit)){
				   
				   $images=$this->Image->find('all',array('conditions'=>$con,'limit'=>$limit,'offset'=>$offset,'order' => array('Image.id' => 'ASC')));
						   
				  foreach($images as $image){
					
					$result1[]=array('image_id'=>$image['Image']['id'],'image'=>BASE_URL."img/".$image['Image']['image']
							);
					
					
					}
					
					
					           if($result1){
      
                          $result = array('status'=>'1','category'=>$cat,'result'=>$result1,'totalpage'=>$totalpage); 
                         }
                  }   
					
					 }else{
					$result=array('status'=>0,'result'=>'Category id not exist');	 
					 }
					 }else{
			              $result = array("status"=>0,"message"=>"Please enter Category id.");
		             } 
				    }else{
			             $result = array("status"=>0,"message"=>"Auth key donot match.");
		            } 
					$this->set(array(
					'result' => $result,
					'_serialize' =>'result'
                    ));
		} 	
	







}
    
