<div class="users view">
<h2><?php echo __('Question'); ?></h2>
<table class="table table-hover">
	<tr>
		<th>Question</th>
		<th>Answer</th>
	</tr>
	<tr> <?php $id=$question['Question']['id']; ?>
		<td><?php echo h($question['Question']['ques']); ?></td>
		<td><?php echo h($question['Question']['ans']); ?></td>
	</tr>
</table>
<?php
	echo $this->Html->link('BACK',"javascript:history.back()"); 
?>
</div>