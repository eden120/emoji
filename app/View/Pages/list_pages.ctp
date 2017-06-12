<?php //pr($this->Paginator) ?>
<div class="main" style="height:90%;">

<div class="signup-text">
Table of Contents
</div>
<div class="index-first" style="font-size:20px; color:#666666;">
Please click on Page Title to view the detail of individual photo page. No one else other than owner will be able to make changes to information provided on photo pages.
</div>
<div class="blue-box">

<div class="first-box">#</div>
<div class="second-box">ITEM TITLE</div>
<div class="third-box">ADDED ON</div>

</div>

<div class="blue-border">
<?php foreach($result as $row){ ?>
<div class="first-box-blue">
<?php
echo $this->Html->link("Page ".$row['Page']['id'], array('controller'=>'pages','action'=>'detail_page',base64_encode($row['Page']['id'])), array('class'=>'icon-1 info-tooltip','title'=>'Go to Photo Page'));
?>
</div>
<div class="second-box-blue">
<?php
	echo $row['Page']['title'];
?>
</div>
<div class="third-box-blue">
<?php echo date("d/m/Y", strtotime($row['Page']['created'])); ?>
</div>
<?php } ?>

</div>

<div class="pagination-box">
<div class="pagination">
<ul class='pager'>
<?php 
echo $this->Paginator->numbers(array('tag'=>'li','separator'=>''));
?>
</ul>
</div>
</div>


<div class="empty"></div>

<!--<div class="next-button-box">
<div class="next-button">
<?php echo $this->Html->link("Go To Next Page >","/pages/detail_page"); ?>
</div>
</div>-->

</div>
