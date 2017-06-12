<script type="text/javascript">
$(document).ready(function() {
	$(".fancybox").fancybox({
				'type': 'iframe',
				'autoDimensions' : false,
				'width' :	1000, 
				'height' :	600, 
				'onStart': function(){
     		 	 jQuery("#fancybox-overlay").css({"position":"fixed"});
   			}
		});
});
</script>
<?php
$newUrl = "list".$urlString;
$urlArray = array(
	'field' 	=> $search1,
	'value' 	=> $search2
);
$this->Paginator->options(array('url'=>$urlArray));
?>
<?php echo $this->Form->create('ReportSpam',array('action'=>$newUrl,'method'=>'POST', "class" => "longFieldsForm", "name" => "listForm", "id" => "mainform")); ?>
<!--  start content-table-inner -->
	<div id="content-table-inner">
	<?php $user = $this->Session->read("SESSION_ADMIN"); ?>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
	
	<!--  start table-content  -->
			<div id="table-content">
			<?php echo $this->Session->flash(); ?>
			<table cellspacing="0" cellpadding="4" border="0" align="center" class="top-search" style="margin-left:40px;">
		<tr>
			<td width="14%">
				<b>Search by:</b>
				<?php
				$fieldsArray = array(
				''=> '---',
				'User.username'     => 'User Name',
				'Post.id' => 'Past Id'
				);
				echo $this->Form->input("User.fieldName",array("type"=>"select","class"=>"styledselect","options"=>$fieldsArray,"label"=>false,"div"=>false,'id'=>'searchBy','empty'=>false,'required' => false));
			//	echo $this->Form->select("User.fieldName",$fieldsArray,$search1,array("id"=>"searchBy","label"=>false,"style"=>"width:200px","class"=>"styledselect","empty"=>false,'required' => false),false); ?>
			</td>
			<td width="20%">
				<b>Search value:</b><br/>
				<?php
					echo $this->Form->input("User.value1",array("id"=>"search_input","class"=>"top-search-inp","style"=>"width:200px;", "div"=>false, "label"=> false,"value"=>$search2,'required' => false));
					
				?>
			</td>
			<td width="40%"><br/>
		  		<?php
				echo $this->Form->button("Search", array('class'=>'form-search','id'=>'search','onclick'=>'setSubmitMode(this.id)'))."&nbsp;&nbsp;&nbsp;";
				echo $this->Form->button("Reset",array('type'=>'button','class'=>"form-reset",'div'=>false,'onclick'=>"location.href='".BASE_URL."admin/reportspams/list'"));				
				?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end(); ?>
		<br/>
		<div class="addLinks">
				<?php //echo $this->Html->link("Add New User", array('controller'=>'users','action'=>'add')); ?>
				</div>
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-check"><input  type="checkbox" id="toggle-all"> </th>
					<th class="table-header-repeat line-left minwidth-1"  width="15%"><?php echo $this->Paginator->sort('User.id','User Name');?></th>
                    <th class="table-header-repeat line-left minwidth-1"  width="15%"><?php echo $this->Paginator->sort('Post.id','Post id');?></th>
					<th class="table-header-repeat line-left minwidth-1"  width="30%"><?php echo $this->Paginator->sort('ReportSpam.reason','Reason');?></th>					
					<th class="table-header-repeat line-left minwidth-1"  width="10%"><?php echo $this->Paginator->sort('ReportSpam.status','Status');?></th>					
					<th class="table-header-repeat line-left minwidth-1"  width="25%"><?php echo $this->Paginator->sort('ReportSpam.link_to_post','Link/Content');?></th>					
					<th class="table-header-repeat line-left minwidth-1"  width="20%"><?php echo $this->Paginator->sort('ReportSpam.created','Reported On');?></th>					
					<!--<th class="table-header-options1 line-left" width="13%"><a href="#A">Options</a></th>-->
				</tr>
				<?php  if(count($resultData)>0){
			$i = 1;
			foreach($resultData as $result):
				$class = "";
			//if(!$result['User']['status']%2)$class = "alternate-row"; else $class = "";  ?>
				<tr class="<?php echo $class; ?>">
					<td><input  type="checkbox" name="IDs[]" value="<?php echo $result['ReportSpam']['post_id'];?>"/></td>
					<td><?php echo $result['User']['username']; ?></td>
					<td><?php echo $result['Post']['id']; ?></td>
					<td><?php echo $result['ReportSpam']['reason']; ?></td>
					<!--<td><?php 
							if($result['ReportSpam']['status'] == 'B')
								echo "Blocked"; 
							else
								echo "Un-Blocked";
							?></td>-->
					<td style="text-align:center">
						<?php echo ($result['ReportSpam']['status'] == 'U')?$this->Html->image(BASE_URL."images/table/green.png", array("alt"=>"Un-Blocked")):$this->Html->image(BASE_URL."images/table/red.png", array("alt"=>"Blocked")); ?>
					</td>
					<td><?php echo $result['ReportSpam']['link_to_post']; ?></td>
					<td><?php echo date(DATE_FORMAT,strtotime($result['ReportSpam']['created'])); ?></td>
					<!--<td class="options-width" align="center">
						<?php
						echo $this->Html->link("",array('controller'=>'users','action'=>'edit',$result['User']['id']),array('class'=>'icon-1 ','title'=>'Edit'));
						?>
						<?php
						echo $this->Html->link("",array('controller'=>'users','action'=>'delete',$result['User']['id']),array('class'=>'icon-2 delete','title'=>'Delete'));
						?> 
					
					</td>-->
				</tr>
				<?php $i++ ;
				endforeach; ?>
				<?php } else { ?>
		<tr>
			<td colspan="10" class="no_records_found">No records found</td>
		</tr>
			<?php } ?>
				</table>
				<!--  end product-table................................... --> 
			</div>
			<!--  end content-table  -->
		
			<!--  start actions-box ............................................... -->
		<div id="actions-box">
				<a href="" class="action-slider"></a>
				<div id="actions-box-slider">
					<?php echo $this->Form->submit("Un-Block",array("div"=>false,"class"=>"action-activate","name"=>"publish",'onclick' => "return atleastOneChecked('Un-Block selected records?','admin/reportspams/changeStatus');")); ?>
					<?php echo $this->Form->submit("Block",array("div"=>false,"class"=>"action-deactivate","name"=>"unpublish",'onclick' => "return atleastOneChecked('Block selected records?','admin/reportspams/changeStatus');")); ?>
				</div>
				<div class="clear"></div>
			</div>
			<!-- end actions-box........... -->
			
			<!--  start paging..................................................... -->
			<table border="0" cellpadding="0" cellspacing="0" id="paging-table">
			<tr>
			<td>
				<?php echo $this->Paginator->prev(' ', array('tag' => false,'class' => 'page-left'), null, array('class' => 'page-left')); ?>
				<div id="page-info"><?php echo $this->Paginator->counter(array('format' => ' Page<strong> %page%</strong> / %pages%',"id"=>"page-info")); ?></div>
				<?php echo $this->Paginator->next(' ', array('tag' => false,'class' => 'page-right'), null, array('class' => 'page-right')); ?>
			</td>
			</tr>
			</table>
			<!--  end paging................ -->
			
			<div class="clear"></div>

	</td>
	<td>

	<?php echo $this->element('report_sidebar'); ?>

</td>
</tr>
</table>
 
<div class="clear"></div>
 

</div>
<?php echo $this->Form->end(); ?>
<!--  end content-table-inner  -->