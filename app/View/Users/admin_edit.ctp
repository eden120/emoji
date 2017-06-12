<?php //echo $Item_id;die;

//$a= $this->data['User']['ID'];die;?>

<?php echo $this->Form->create('User',array('enctype'=>'multipart/form-data','class'=>'form-horizontal style-form')); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id',array('type'=>'hidden','class'=>"form-control"));
		echo $this->Form->input('name',array('type'=>'text','class'=>"form-control",'label'=>'NAME'));echo"<br>";
		//echo $this->Form->input('last_name',array('type'=>'text','class'=>"form-control",'label'=>'LAST NAME'));echo"<br>";
		echo $this->Form->input('email',array('type'=>'email','class'=>"form-control",'label'=>'EMAIL'));echo"<br>";
	//	echo $this->Form->input('user_type',array('type'=>'text','class'=>"form-control",'label'=>'USER TYPE'));echo"<br>";
		?>
	</fieldset>
<?php echo $this->Form->hidden("id");
								echo $this->Form->button('Submit',array('type'=>'submit','class'=>"btn btn-theme",'div'=>false)).'&nbsp;&nbsp;'; 
								echo $this->Form->button('Cancel',array('type'=>'reset','class'=>"btn btn-theme",'div'=>false,'onclick'=>"location.href='".BASE_URL."admin/users/list'")); 
								?>
                         


