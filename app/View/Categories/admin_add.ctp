 <div class="row mt">
                  <div class="col-md-12">
				  <div class="form-panel">
                  	  <h4 class="mb"><?php echo $title_for_layout;?></h4>
					  
					  <?php echo $this->Form->create('Category',array('action'=>'add','enctype'=>"multipart/form-data",'method'=>'POST','onsubmit' => '',"class"=>"form-horizontal style-form")); ?>
           
						 <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Category Name</label>
                              <div class="col-sm-6">
                                  
			<?php
			 
              echo $this->Form->input('name',array('type'=>'text','class'=>"form-control","label"=>false));echo"<br>";
			                  
             ?> 
                          </div>
                          </div> 
						  <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Category Image *</label>
                              <div class="col-sm-6">
                                  
				<?php
				     echo $this->Form->input("image",array("type"=>"file","class"=>"form-control","label"=>false,"div"=>false, 'required'=>false));
                ?> 
                              </div>
                          </div>
						  <div class="form-group">
						    <div class="col-sm-2">
						    </div>
                              <div class="col-sm-10">
								 <?php echo $this->Form->hidden("id");
								echo $this->Form->button('Add',array('type'=>'submit','class'=>"btn btn-theme",'div'=>false)).'&nbsp;&nbsp;'; 
								echo $this->Form->button('Cancel',array('type'=>'reset','class'=>"btn btn-theme",'div'=>false,'onclick'=>"location.href='".BASE_URL."admin/categories/list'")); 
								?>
                              </div>
                              
                          </div>
                           
                      <?php echo $this->Form->end(); ?>					  	  
                      
                  </div><!-- /content-panel -->
     </div><!-- /col-md-12 -->
 </div><!-- /row -->   
 

 
                           
                     			  	  
                      
                 