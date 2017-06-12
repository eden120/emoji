
<!--  start related-activities -->
	<div id="related-activities">
	<?php $user = $this->Session->read("SESSION_ADMIN"); ?>
		<!--  start related-act-top -->
		<div id="related-act-top">
		<?php echo $this->Html->image(BASE_URL."images/forms/header_related_act.gif", array("alt"=>"Edit",'width'=>"271", 'height'=>"43")); ?>
		</div>
		<!-- end related-act-top -->
		
		<!--  start related-act-bottom -->
		<div id="related-act-bottom">
		
			<!--  start related-act-inner -->
			<div id="related-act-inner">
				<div class="right">
					<h5>Service Management</h5>
          This section is used to manage Services.
		  <div class="lines-dotted-short"></div>
					<ul class="greyarrow">
  					<li>
            <?php
			  echo $this->Html->link("Add Service Provider", array('controller'=>'services','action'=>'add'));
            ?>
            </li> 
			</ul>

				</div>
				<div class="clear"></div>
			</div>
			<!-- end related-act-inner -->
			<div class="clear"></div>
		
		</div>
		<!-- end related-act-bottom -->
	
	</div>
	<!-- end related-activities -->