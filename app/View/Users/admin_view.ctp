<div class="users view">

<h2><?php echo __('User'); ?></h2>
<table class="table table-hover">
	<tr>
		<th>EMAIL</th>
		<th>D.O.B</th>
		<th>COUNTRY</th>
     	       <th>USER TYPE</th>
		<th>LOGIN TYPE</th>
		
		
		
	</tr>
	<tr> <?php $id=$user['User']['id']; ?>
		<td><?php echo h($user['User']['email']); ?></td>
		<td><?php echo h($user['User']['dob']); ?></td>
		<td><?php echo h($user['User']['country']); ?></td>
		<td><?php echo h($user['User']['user_type']); ?></td>
		<td><?php echo h($user['User']['login_type']); ?></td>
		
		
	</tr>
</table>

<?php

echo $this->Html->link('BACK',"javascript:history.back()"); 

?>

</div>

