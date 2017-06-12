 <div class="row mt">
                  <div class="col-md-12">
				  <div class="form-panel">
                  	  <h4 class="mb"><?php echo $title_for_layout;?></h4>
					 
					  <?php echo $this->Form->create('Bar',array('action'=>'edit','method'=>'POST','onsubmit' => '',"class"=>"form-horizontal style-form",'enctype' => 'multipart/form-data')); ?>
           
						  
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Bar*</label>
                              <div class="col-sm-6">
                                  
								  <?php
				     echo $this->Form->input("name",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false, 'required'=>true));
                ?> 
                              </div>
                          </div>
						 
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Street*</label>
                              <div class="col-sm-6">
                                  
								  <?php
				     echo $this->Form->input("street",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false, 'required'=>true));
                ?> 
                              </div>
                          </div>
						   <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">City*</label>
                              <div class="col-sm-6">
                                  
								  <?php
				     echo $this->Form->input("city",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false, 'required'=>true));
                ?> 
                              </div>
							  </div>
							   <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">State*</label>
                              <div class="col-sm-6">
                                  
								  <?php
				     echo $this->Form->input("state",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false, 'required'=>true));
                ?> 
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Country*</label>
                              <div class="col-sm-6">
                                  
								  <?php
				     echo $this->Form->input("country",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false, 'required'=>true));
                ?> 
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Description*</label>
                              <div class="col-sm-6">
                                  
								  <?php
				     echo $this->Form->input("description",array("type"=>"textarea","class"=>"form-control","label"=>false,"div"=>false, 'required'=>true));
                ?> 
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Zipcode*</label>
                              <div class="col-sm-6">
                                  
								  <?php
				     echo $this->Form->input("zipcode",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false, 'required'=>true));
                ?> 
                              </div>
                          </div>
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Image*</label>
                              <div class="col-sm-6">
                                  
								  
				    			  <?php
								  echo $this->Form->input('image',array("label"=>false,'type'=>'file','required' => false));
				     ?>
					 
                              </div>
                          </div>
						 
						  <div class="form-group">
						    <div class="col-sm-2">
						    </div>
                              <div class="col-sm-10">
								 <?php echo $this->Form->hidden("id");
								echo $this->Form->button('Save',array('type'=>'submit','class'=>"btn btn-theme",'div'=>false)).'&nbsp;&nbsp;'; 
								echo $this->Form->button('Back',array('type'=>'reset','class'=>"btn btn-theme",'div'=>false,'onclick'=>"location.href='".BASE_URL."admin/bars/list'")); 
								?>
                              </div>
                              
                          </div>
						 
                           
                      <?php echo $this->Form->end(); ?>					  	  
                      
                  </div><!-- /content-panel -->
     </div><!-- /col-md-12 -->
 </div><!-- /row -->