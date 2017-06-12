<!-- start loginbox -->
	<?php echo $this->Form->create('User',array('action'=>'forgot_password','method'=>'POST','onsubmit' => '',"class"=>"login")); ?>
	<div id="loginbox">
 <h2 class="heading">Forgot Password</h2>
	<!--  start login-inner -->
	<div id="login-inner">
	<?php echo $this->Session->flash(); ?>
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			
		</tr>
	
		<tr>
			<th></th>
			<td valign="top">&nbsp;</td>
		</tr>
		<tr>
			<th></th>
			<td>
			<?php echo $this->Html->link("Back to Login",
						array('controller'=>'users','action'=>'login'),
						array('class'=>' forget_pass','title'=>'Login')
				   	); ?>
			</td>
		</tr>
		</table>
	</div>
 	<!--  end login-inner -->
	<div class="clear"></div>
 </div>
 <!--  end loginbox -->
<?php echo $this->Form->end();?>