<?php
$newUrl = "list".$urlString;
$urlArray = array(
	'field' 	=> $search1,
	'value' 	=> $search2,
	'utype' 	=> $search3
);
$this->Paginator->options(array('url'=>$urlArray));
?> 
     <div class="row mt">
                  <div class="col-md-12">
                      <div class="content-panel">
					   <?php echo $this->Form->create('User',array('action'=>'list','method'=>'POST', "class" => "form-inline", "fname" => "listForm", "id" => "mainform","role"=>"form")); ?>
					  
                          <div align="center" class="form-group">
                              &nbsp;&nbsp;&nbsp;<label  for="searchBy"> Search by: </label>
							  
							  <?php
				                  $fieldsArray = array('' => '---','User.email'=> 'Email');
				                  echo $this->Form->input("User.fieldName",array("type"=>"select","class"=>"form-control","style"=>"width:200px;","options"=>$fieldsArray,"label"=>false,"div"=>false,'id'=>'searchBy','empty'=>false));
			                   ?>    
                          </div>
						   <div align="center" class="form-group">
                              &nbsp;&nbsp;&nbsp;<label  for="searchBy"> User Type: </label>
							  
							  <?php
				                  $fieldsArray = array('2' => 'All','2'=> 'User');
				                  echo $this->Form->input("User.user_type",array("type"=>"select","class"=>"form-control","style"=>"width:200px;","options"=>$fieldsArray,"value"=>$search3,"label"=>false,"div"=>false,'id'=>'searchBy','empty'=>false));
			                   ?>    
                          </div>
                          <div align="center" class="form-group">
                              <label  for="search_input"> Search value: </label>
                              
							<?php
					            echo $this->Form->input("User.value1",array("id"=>"search_input","class"=>"form-control","style"=>"width:200px;", "div"=>false, "label"=> false,"value"=>$search2,'placeholder'=>'Value'));
					
				            ?>
                          </div>
						  <div align="center" class="form-group">
						  <?php 
						   
						  echo $this->Form->button("Search", array("type"=>"submit",'class'=>'btn btn-theme','id'=>'search'))."&nbsp;&nbsp;&nbsp;";
						  echo $this->Form->button("Reset",array('type'=>'button','class'=>"btn btn-warning",'div'=>false,'onclick'=>"location.href='".BASE_URL."admin/users/list'"));
						  ?>
						  </div>
                           
                     <?php echo $this->Form->end(); ?>
					   
					   <hr>
					   
                          <table class="table table-striped table-advance table-hover">
	                       
                              <thead>
                              <tr>
							  <th class="table-header-check"><input  type="checkbox" id="toggle-all"> </th>

                                  <th class="hide-mobile">&nbsp;
</i> <?php echo $this->Paginator->sort('User.email','Email');?></th>
 <!--<th>&nbsp;User Type</th> -->
 <th>&nbsp;Login Type</th>
 <th>&nbsp;DOB</th>
              <th class="hide-mobile">
&nbsp;<?php echo $this->Paginator->sort('User.country','Country');?></th>
                                  <th>&nbsp; <?php echo $this->Paginator->sort('User.status', 'Status');?></th>
                                  <th class="hide-tab" >&nbsp;<?php echo $this->Paginator->sort('User.created','created');?>
</th><th class="hide-mobile">&nbsp;Options</th>
                              </tr>
                              </thead>
                              <tbody>
							  <?php foreach($resultData as $result){ 
							  $r_id = $result['User']['id'];
							  ?>
                              <tr>
							  <td><input  class="ids" type="checkbox" email="IDs[]" value="<?php echo $result['User']['id'];?>"/></td>
                                  <td><a href="javascript:void(0);"><?php echo $result['User']['email']; ?></a></td>
                                <!-- <td class="hide-mobile"><?php echo $result['User']['user_type']; ?></td> -->
                                 <td class="hide-mobile"><?php echo $result['User']['login_type']; ?></td>
                                 <td class="hide-mobile"><?php echo $result['User']['dob']; ?></td>
								  <td class="hide-mobile"><?php echo $result['User']['country']; ?></td>


                                  <td>
								  <?php echo ($result['User']['status'] == '1')?'<span class="label label-success label-mini">Active</span>':'<span class="label label-warning label-mini">Deactive</span>' ?>
								  
								  </td>
								   <td class="hide-tab" ><?php echo date(DATE_FORMAT,strtotime($result['User']['created'])); ?></td>
                                  <td class="hide-mobile" >
                                     <!-- <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> -->
                                      <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil-square-o btn btn-primary btn-xs')) ,array('controller'=>'Users','action'=>'edit',$result['User']['id']),
                                    array('title'=>'Edit', 'escape' => false)
                                  ); ?>
                                    <?php echo $this->Form->postLink(
   $this->Html->tag('i', '', array('class' => 'fa fa-institution btn btn-danger btn-xs')),
        array('action' => 'delete', $result['User']['id']),
        array('escape'=>false),
    __('Are you sure you want to delete ?'),
   array('class' => 'btn btn-mini')
);?>
									
								<!--<?php //echo $this->Html->link($this->Html->tag('i', '', array('class' //=> 'fa fa-pencil-square-o btn btn-primary btn-xs')), array('controller'=>'Users','action'=>'delete',$result['User']['id']), null, 'Are you sure you want to delete this?' )?> -->

						               
									 <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye btn btn-primary btn-xs')) ,array('controller'=>'Users','action'=>'view',$result['User']['id']),
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
									  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
										Action
										<span class="caret"></span>
									  </a>
									 <ul class="dropdown-menu">
									 <li><a href="javascript:void(0);" onclick="do_action('Activate','users');">Activate</a></li>
									 <li><a href="javascript:void(0);" onclick="do_action('Deactivate','users');">Deactivate</a></li>
									 <li><a href="javascript:void(0);" onclick="do_action('Delete','users');">Delete</a></li>
									 </ul>
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