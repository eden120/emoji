<?php
$newUrl = "list";
?> 
    <div class="row mt">
                  <div class="col-md-12">
                      <div class="content-panel">
					   <?php echo $this->Form->create('Question',array('action'=>$newUrl,'method'=>'POST', "class" => "form-inline", "name" => "listForm", "id" => "mainform","role"=>"form")); ?>
					<hr>
					<table class="table table-striped table-advance table-hover">
	                       
								<thead>
									<tr>
										<th>Question&nbsp; </th>
										<th>Answer&nbsp;</th>
										<th>Options</th>
									</tr>
								</thead>
								<tbody>
								<?php   foreach($resultData as $result){ 
								$r_id = $result['Question']['id'];
								?>
								<tr>
									<td><a href="basic_table.html#"><?php echo $result['Question']['ques']; ?></a></td>
									<td><a href="basic_table.html#"><?php echo $result['Question']['ans']; ?></a></td>
									<td>
										<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o btn btn-primary btn-xs')) ,array('controller'=>'questions','action'=>'edit',$result['Question']['id']),
										array('title'=>'edit', 'escape' => false)
										); ?>
										<button class="btn btn-danger btn-xs" onclick="do_action('Delete','questions',window.location='<?php echo BASE_URL.'admin/questions/delete/'.$r_id; ?>')"><i class="fa fa-trash-o "></i></button>
										<?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye btn btn-primary btn-xs')) ,array('controller'=>'questions','action'=>'view',$result['Question']['id']),
										array('title'=>'View', 'escape' => false)
										); ?>
									</td>
								</tr>
							  <?php } ?>
                               
                              </tbody>
                          </table>
							<div class="row">
								<div class="col-md-9 pull-left">
								  <div id="actions-box">				  
									<div class="btn-group">
									 <!-- <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
										Action
										<span class="caret"></span>
									  </a>
									 <ul class="dropdown-menu">
									 <li><a href="javascript:void(0);" onclick="do_action('Delete','bars');">Delete</a></li>
									 </ul>-->
									</div>
								   </div>
								</div>
								<div class="col-md-2 pull-right"> 
								   <ul class="pager" id="actions-box">
										<?php echo $this->Paginator->prev('&laquo;', array( 'tag' => 'li', 'escape' => false,'class' => false), '<a href="javascript:void(0);">&laquo;</a>', array('class' => 'disabled' ,'tag' => 'li', 'escape' => false));      
				 						echo $this->Paginator->counter(array('format' => '<li>%page%/ %pages%</li>')); 
				 
								   echo $this->Paginator->next('&raquo;', array( 'tag' => 'li', 'escape' => false,'class' => false),'<a href="javascript:void(0);"> &raquo;</a>', array('class' => 'disabled' ,'tag' => 'li', 'escape' => false)); 
												 
								  ?>
								  </ul>
                                 
								</div>
								  
							</div>					
					 	  
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->