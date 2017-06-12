<div class="form-panel">

                  	  <h4 class="mb"></i>ADD USER</h4>
                   
                  <?php echo $this->Form->create('User',array('action'=>'add','method'=>'POST','onsubmit'=>'','class'=>'form-horizontal style-form')); ?>   
					  
					  
					     <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">EMAIL</label>
                              <div class="col-sm-10">
							 <?php echo $this->Form->input("email",array("type"=>"email",'placeholder'=>'Enter Email id','class'=>'form-control',"id"=>"","label"=>false,"div"=>false));
							 ?>
                              </div>
                          </div>
						  
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">PASSWORD</label>
                              <div class="col-sm-10">
							 <?php echo $this->Form->input("password",array("type"=>"password",'placeholder'=>'Enter Your Password','class'=>'form-control',"id"=>"","label"=>false,"div"=>false));
							 ?>
                              </div>
                          </div>
						  
						  
						     <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">D.O.B</label>
                              <div class="col-sm-10">
							 <?php echo $this->Form->input("dob",array("type"=>"date",'placeholder'=>'Enter Your D.O.B','class'=>'form-control',"id"=>"","required"=>true,"label"=>false,"div"=>false));
							 ?>
                              </div>
                          </div>
						  
						    <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">COUNTRY</label>
                              <div class="col-sm-10">
							 <?php echo $this->Form->input("country",array("type"=>"text",'placeholder'=>'Enter Your country','class'=>'form-control',"ID"=>"","label"=>false,"div"=>false,"required"=>true));
							 ?>
                              </div>
                          </div>
<!--	
						     <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">PASSWORD</label>
                              <div class="col-sm-10">
							 <?php /* echo $this->Form->input("PASSWORD",array("type"=>"password",'placeholder'=>'Enter Password','class'=>'form-control',"ID"=>"","label"=>false,"div"=>false));
							 ?>
                              </div>
                          </div>
						  
						 <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">USER TYPE</label>
                              <div class="col-sm-10">
					  <?php echo $this->Form->input('USER_TYPE', array('class'=>'form-control',"label"=>'',
                     'options' => array('Employer', 'Jobseeker', 'Hrconsultant'),
                      'values' => array('EMP','JOB','HR'),
	                )
					);
				
				*/	?>
				
                         </div>
                          </div>
    -->                      	
                         
	                         
							
						<br>						
						  <input type="submit" class="btn btn-primary btn-lg" value="Submit">
						  
                     <?php echo $this->Form->end(); ?>
                  </div>
				  