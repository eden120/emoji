 <div class="row mt">
                  <div class="col-md-12">
				  <div class="form-panel">
                  	  <h4 class="mb"><?php echo $title_for_layout;?></h4>
					   <h5 class="has-error"><i>Fields marked * are mandatory</i></h5>
					  <?php echo $this->Form->create('Drink',array('action'=>'add','method'=>'POST','onsubmit' => '',"class"=>"form-horizontal style-form","enctype"=> "multipart/form-data")); ?>
           
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Bars Name</label>
                              <div class="col-sm-6">
                                  
				    <?php
					$newCats = array(''=>'Select bars');
					foreach($bars as $k => $v){
					 $newCats[$k] = $v;		
					}
				 
     				$fieldsArray = array('' => 'Select bars','Drink.name'=> 'Drink Name');
				               echo $this->Form->input("Drink.barid",array("type"=>"select","class"=>"form-control","options"=>$newCats,"label"=>false,"div"=>false));
			                  
                    ?> 
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Drink*</label>
                              <div class="col-sm-6">
                                  
								  <?php
				     echo $this->Form->input("name",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false, 'required'=>false));
                ?> 
                              </div>
                          </div>
					  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Price*</label>
                              <div class="col-sm-6">
                                  
								  <?php
				     echo $this->Form->input("price",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false, 'required'=>false));
                ?> 
                              </div>
                          </div>

						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Description*</label>
                              <div class="col-sm-6">
                                  
								  <?php
				     echo $this->Form->input("description",array("type"=>"textarea","class"=>"form-control","label"=>false,"div"=>false, 'required'=>false));
                ?> 
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Image*</label>
                              <div class="col-sm-6">
                                  
								  
				    			  <?php
								  echo $this->Form->input('img',array("label"=>false,'type'=>'file'));
				     ?>
                              </div>
                          </div>
						 
						  <div class="form-group">
						    <div class="col-sm-2">
						    </div>
                              <div class="col-sm-10">
								 <?php echo $this->Form->hidden("id");
								echo $this->Form->button('Add',array('type'=>'submit','class'=>"btn btn-theme",'div'=>false)).'&nbsp;&nbsp;'; 
								
								?>
                              </div>
                              
                          </div>
                           
                      <?php echo $this->Form->end(); ?>					  	  
                      
                  </div><!-- /content-panel -->
     </div><!-- /col-md-12 -->
 </div><!-- /row -->