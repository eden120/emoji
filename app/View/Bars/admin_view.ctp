<div class="users view">

<h2><?php echo __('Bar'); ?></h2>
<table class="table table-hover">
	<tr>
		<th>Name</th>
		<th>City</th>
		<th>State</th>
        <th>Country</th>
<th>Zipcode</th>
		<th>Description</th>
		<th>Created</th>
		<th>Image</th>
		
		
		
	</tr>
	<tr> <?php $id=$bar['Bar']['id']; ?>
		<td><?php echo h($bar['Bar']['name']); ?></td>
		<td><?php echo h($bar['Bar']['city']); ?></td>
		<td><?php echo h($bar['Bar']['state']); ?></td>
		<td><?php echo h($bar['Bar']['country']); ?></td>
<td><?php echo h($bar['Bar']['zipcode']); ?></td>
		<td><?php echo h($bar['Bar']['description']); ?></td>
		<td><?php echo h($bar['Bar']['created']); ?></td>
		<td>
		    <img src="<?php echo BASE_URL."app/webroot/img/".$bar['Bar']['image'];?>" class="img-circle" alt="Cinque Terre" height="200" width="200" />
		</td>
		
	</tr>
</table>

<?php

echo $this->Html->link('BACK',"javascript:history.back()"); 

?>

</div>

