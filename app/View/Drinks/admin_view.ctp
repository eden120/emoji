<div class="users view">

<h2><?php echo __('Drink'); ?></h2>
<table class="table table-hover">
	<tr>
		<th>Name</th>
		<th>Bar Name</th>
<th>Price</th>
		<th>Description</th>
		<th>Image</th>
	</tr>
	<tr> <?php $id=$drink['Drink']['id']; ?>
		<td><?php echo h($drink['Drink']['name']); ?></td>
		<td><?php echo h($bar['Bar']['name']); ?></td>
<td><?php echo h($drink['Drink']['price']); ?></td>
		<td><?php echo h($drink['Drink']['description']); ?></td>
		<td><img src="<?php echo BASE_URL."app/webroot/img/".$drink['Drink']['img'];?>" class="img-circle" alt="Cinque Terre" height="200" width="200" /></td>
	</tr>
</table>

<?php

echo $this->Html->link('BACK',"javascript:history.back()"); 

?>

</div>