<!--  <script type="text/javascript">
$(document).ready(function(){
  $('#change_password').attr('checked',true);
  $('#change_password').click(function(){
    if($('#change_password').is(':checked')){
	   $('.change_password').show();
	}else{
	   $('.change_password').hide();
	}
  })
})
</script>  -->

<!--  start content-table-inner -->
	<div class="form-panel">
	<?php echo $this->Form->create('User',array('action'=>'settings','method'=>'POST','onsubmit' => '',"class"=>"form-horizontal tasi-form","enctype" =>"multipart/form-data")); ?>
	<?php echo $this->session->flash(); ?>
		
	<!-- start id-form -->
			
			<!--<td colspan="2" align="right"><b><i>Fields marked <span class="star">*</span> are mandatory</i></b></td>-->
		
		
		<!--<div class="form-group">
			<label class="col-sm-2 col-sm-2 control-label">Username :</label>
				<div class="col-sm-3"><?php
				 //echo $this->Form->input("name",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false));
				?>  	
				</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 col-sm-2 control-label">Email:</label>
				<div class="col-sm-3"><?php
				// echo $this->Form->input("email",array("type"=>"text","class"=>"form-control","label"=>false,"div"=>false));
            ?>  	
            </div>
		</div>
		
			
		<div class="form-group">
			<label class="col-sm-2 col-sm-2 control-label">Change Password :</label>
				<div class="col-sm-3 centered">
				<?php // $this->data['Parents']['password']='';
				// echo $this->Form->input("change_password",array("type"=>"checkbox","id"=>"change_password","label"=>false,"div"=>false,'required'=>true));
            ?>    
            </div>
		</div>		-->
		<div class="form-group change_password">
			<label class="col-sm-2 col-sm-2 control-label">Old Password:</label>
				<div class="col-sm-3">
				<?php 
				echo $this->Form->input("old_password",array("type"=>"password","class"=>"form-control","label"=>false,"div"=>false,'required'=>false));
				?>    
				</div>
		</div>	
		<div class="form-group change_password">
			<label class="col-sm-2 col-sm-2 control-label">New Password:</label>
				<div class="col-sm-3">
				<?php 
				echo $this->Form->input("password",array("type"=>"password","class"=>"form-control","label"=>false,"div"=>false,'required'=>false));
				?>
				</div>
		</div>
		<div class="form-group change_password">
			<label class="col-sm-2 col-sm-2 control-label">Confirm Password:</label>
				<div class="col-sm-3">
				<?php 
				echo $this->Form->input("confirm_password",array("type"=>"password","class"=>"form-control","label"=>false,"div"=>false,'required'=>false));
				?>
				</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-3">
			<?php echo $this->Form->hidden("id");
			echo $this->Form->submit('Submit',array('class'=>"btn btn-theme",'div'=>false))."&nbsp;&nbsp;&nbsp;"; 
			
			?>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
	<!-- end id-form  -->
	<!-- end id-form  -->
	<div class="clear"></div>
	</div>
	<!--  end content-table-inner  -->