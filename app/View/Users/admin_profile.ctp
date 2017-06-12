 <?php $session = $this->Session->read("SESSION_ADMIN"); ?>
   
 <script>
 $(document).ready(function(){
	 <?php if($status==2){?>
	 $('#edit_profile').show();
	 $('#profile').hide();
	 <?php }else{ ?>
	     $('#edit_profile').hide();
		  $('#profile').show();
	 <?php } ?>
	 $('#edit_profile_button').click(function(){
		  $('#edit_profile').show();
		  $('#profile').hide();
		 
	 });
	 
		 
		 
		$('#profile_pic').change(function(){
			var file = this.files[0];
			name = file.name;
			size = file.size;
			type = file.type;

			if(file.name.length < 1) {
			}
			else if(file.size > 100000000) {
				alert("File is to big");
			}
			else if(file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/gif' && file.type != 'image/jpeg' ) {
				alert("File doesnt match png, jpg or gif");
			}
			else {
                  var formData = new FormData();
		          formData.append('image', $(this)[0].files[0]);				
	
					$.ajax({
						url: BASE_URL+'admin/commons/upload',  //server script to process data
						type: 'POST',
						success: completeHandler = function(data){
							data = JSON.parse(data);
							if(data.status==1){
							  $('#profile_pic_set').attr('src',data.url);
							   $('#UserProfilePicId').val(data.id);
							}else{
							  alert("Error!!"+data.message);
							}
							 
						},
						error: errorHandler = function(err) {
							alert("Error!!Please try again.");
						},
						// Form data
						data: formData,
						cache: false,
						contentType: false,
						processData: false
					}, 'json');
			}
        });
		 
		 
		 
	 $("#profile_pic_button").click(function(){
       $("#profile_pic").click();
     });
	 
	 $('#change_password').prop('checked',<?php echo $chang_pass; ?>);

	 if($('#change_password').is(':checked')){
	            $(".changePassDiv").show();
		}else{
				$(".changePassDiv").hide();	
		}
	 $('#change_password').change(function(){
		 	if($(this).is(':checked')){
	            $(".changePassDiv").show();
			}else{
				$(".changePassDiv").hide();	
			}
	 });
	 
	 
 })
 
 </script>
 
 <div class="row mt">
                  <div class="col-md-12">
				      
			<div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo ucfirst($session['name']); ?></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> 
				
			<?php	
			echo $this->Html->image(array('controller'=>'commons','action'=>'image',$this->data['User']['profile_pic_id']),array("class"=>"img-circle img-responsive",'id'=>'profile_pic_set',"alt" => 'profile',"style"=>"max-width:200px"))
				
				?>
				 </div>
                
                 
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information" id="profile">
                    <tbody>
                      <tr>
                        <td>Name:</td>
                        <td><?php   echo ucfirst($this->data['User']['name']); ?></td>
                      </tr>
                      <tr>
                        <td>Email:</td>
                        <td><?php   echo ucfirst($this->data['User']['email']);  ?></td>
                      </tr>
                      <tr>
                        <td>Address:</td>
                        <td><?php   echo ucfirst($this->data['User']['address']);  ?></td>
                      </tr>
                   <tr>
				   <td><span class="pull-left">
                            <a href="javascript:void(0);" title="Edit" data-toggle="tooltip" type="button" id="edit_profile_button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                             
                        </span></td><td></td>
				   </tr>
                         
                    </tbody>
                  </table>
				  
				   <?php echo $this->Form->create('User',array('action'=>'profile','method'=>'POST','onsubmit' => '',"class"=>"form-horizontal style-form",'id'=>'edit_profile')); ?>
				  
				  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Name:</td>
                        <td><?php echo $this->Form->input("name",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false, 'required'=>false)); ?> </td>
                      </tr>
                      <tr>
                        <td>Email:</td>
                        <td><?php    echo $this->Form->input("email",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false, 'required'=>false));  ?></td>
                      </tr>
                      <tr>
                        <td>Address:</td>
                        <td><?php    echo $this->Form->input("address",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false, 'required'=>false));  ?></td>
                      </tr>
					  <tr>
                        <td>
						<div style="width:0px;height:0px;overflow:hidden">
                          <input id="profile_pic" type="file" id="fileInput" name="fileInput" />
                        </div>
                        <button id="profile_pic_button"type="button" class="btn btn-primary">Profile Pic</button>
                     </td>
					 <td></td>
                      </tr>
					  
					   <tr>
					   <td>Change Password:</td>
                        <td>
						   <input name="change_pass" id="change_password" type="checkbox" />   
                        </td>
					    
                      </tr>
					  <tr class="changePassDiv">
					   <td>Password:</td>
                        <td>
						          
                                  <?php    echo $this->Form->input("password",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false, 'required'=>false));  ?>
                               
                        </td>
					    
                      </tr>
					  <tr class="changePassDiv">
					   <td>Confirm Password:</td>
                        <td>
						          
                                 <?php    echo $this->Form->input("confirm_password",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false, 'required'=>false));  ?>
                               
                        </td>
					    
                      </tr>
					  
					  
                   <tr>
				   <td><span class="pull-left">
                            <?php  
							    echo $this->Form->hidden("profile_pic_id");
							    echo $this->Form->hidden("id");
								echo $this->Form->button('Update',array('type'=>'submit','class'=>"btn btn-theme",'div'=>false)).'&nbsp;&nbsp;'; 
								echo $this->Form->button('Cancel',array('type'=>'reset','class'=>"btn btn-theme",'div'=>false,'onclick'=>"location.href='".BASE_URL."admin/users/profile'")); 
								?>
                             
                        </span></td><td></td>
				   </tr>
                         
                    </tbody>
                  </table>
				   <?php echo $this->Form->end(); ?>			  
                </div>
              </div>
            </div>
            <div class="panel-footer">
                       
                        
            </div>
					
			</div>		
					  
					  
				 
     </div><!-- /col-md-12 -->
 </div><!-- /row -->