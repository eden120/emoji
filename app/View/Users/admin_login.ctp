<?php echo $this->Form->create('User',array('controller' => 'users','action'=>'login','method'=>'POST','onsubmit' => '',"class"=>"form-login")); ?>

		        <h2 class="form-login-heading">sign in now</h2>
		        <div class="login-wrap">
				
				<?php echo $this->Form->input("email",array("class"=>"form-control","label"=>false,'placeholder'=>"User ID","div"=>false,'autofocus'=>true,'required'=>false));
               ?><br>
			   <?php echo $this->Form->input("password",array("class"=>"form-control","label"=>false,"div"=>false,'required'=>false,'type'=>'password','placeholder'=>"Password")); ?>		           
		            <label class="checkbox">
		                <span class="pull-right">
		                    <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
		
		                </span>
		            </label></br>
		            <button class="btn btn-theme btn-block"  type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
		            <hr>
		            
		            <!--div class="login-social-link centered">
		            <p>or you can sign in via your social network</p>
		                <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> Facebook</button>
		                <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> Twitter</button>
		            </div>
		            <div class="registration">
		                Don't have an account yet?<br/>
		                <a class="" href="#">
		                    Create an account
		                </a>
		            </div-->
		
		        </div>
		<?php echo $this->Form->end(); ?>
		<?php echo $this->Form->create('User',array('controller' => 'users','action'=>'forgot_password','method'=>'POST','onsubmit' => '',"class"=>"form-login")); ?>
		          <!-- Modal -->
		          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
		              <div class="modal-dialog">
		                  <div class="modal-content">
		                      <div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          <h4 class="modal-title">Forgot Password ?</h4>
		                      </div>
		                      <div class="modal-body">
							  <div id="fgpwstatus"></div>
		                          <p>Enter your e-mail address below to reset your password.</p>
								  <?php echo $this->Form->input("email",array("class"=>"form-control placeholder-no-fix","label"=>false,'placeholder'=>"Email","div"=>false,'autofocus'=>true,'required'=>false,"autocomplete"=>"off")); ?>
		                         <div id="fgpwderr" class="error-message"></div>
		                      </div>
		                      <div class="modal-footer">
		                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		                         <!-- <button id="fgPwdSmt" class="btn btn-theme" type="button">Submit</button>-->
								  <?php echo $this->Form->submit('Submit',array('controller' => 'users','action'=>'forgot_password','class'=>'btn btn-default')); 
								  echo $this->Form->end();
								  ?>
		                      </div>
		                  </div>
		              </div>
		          </div>
		          <!-- modal -->
		<?php echo $this->Form->end(); ?>
		
		 