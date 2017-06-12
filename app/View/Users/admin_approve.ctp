<?php
$newUrl = "list".$urlString;
$urlArray = array(
	'field' 	=> $search1,
	'value' 	=> $search2
);
$this->Paginator->options(array('url'=>$urlArray));
?> 
     <div class="row mt">
                  <div class="col-md-12">
                      <div class="content-panel">
					   <?php echo $this->Form->create('User',array('action'=>$newUrl,'method'=>'POST', "class" => "form-inline", "name" => "listForm", "id" => "mainform","role"=>"form")); ?>
					  
                          <div align="center" class="form-group">
                              &nbsp;&nbsp;&nbsp;<label  for="searchBy"> Search by: </label>
							  
							  <?php
				                  $fieldsArray = array('' => '---','User.name'=> 'User Name','User.email'=> 'Email');
				                  echo $this->Form->input("User.fieldName",array("type"=>"select","class"=>"form-control","style"=>"width:200px;","options"=>$fieldsArray,"label"=>false,"div"=>false,'id'=>'searchBy','empty'=>false));
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
                                  <th><i class="fa fa-user"></i>&nbsp;
<?php echo $this->Paginator->sort('User.name','Name');?> </th>
                                  <th><i class="fa fa-envelope"></i>&nbsp;
</i> <?php echo $this->Paginator->sort('User.email','Email');?></th>
                                  <th class="hide-mobile"><i class="fa fa-home"></i>
</i>&nbsp;<?php echo $this->Paginator->sort('User.address','Address');?></th>
                                   
                                  <th class="hide-tab"><i class="fa fa-calendar"></i>&nbsp;<?php echo $this->Paginator->sort('User.created','created');?>
</th><th class="hide-mobile"><i class="fa fa-tasks"></i>&nbsp;Options</th>
                              </tr>
                              </thead>
                              <tbody>
							  <?php foreach($resultData as $result){ 
							  $r_id = $result['User']['id'];
							  ?>
                              <tr>
							  <td><input  class="ids" type="checkbox" name="IDs[]" value="<?php echo $result['User']['id'];?>"/></td>
                                  <td><a href="basic_table.html#"><?php echo $result['User']['name']; ?></a></td>
                                  <td><?php echo $result['User']['email']; ?></td>
                                  <td class="hide-mobile"><?php echo $result['User']['address']; ?></td>
                                  
								   <td class="hide-tab" ><?php echo date(DATE_FORMAT,strtotime($result['User']['created'])); ?></td>
                                  <td class="hide-mobile" >
                                      
									
									  <button class="btn btn-success btn-xs" onclick="do_action('Approve','users',<?php echo $r_id;?>)"><i class="fa fa-check"></i></button>
                                       
                                      <button class="btn btn-danger btn-xs" onclick="do_action('Delete','users',<?php echo $r_id;?>)"><i class="fa fa-trash-o "></i></button>
									    
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
									  
									 <li><a href="javascript:void(0);" onclick="do_action('Approve','users');">Approve</a></li>
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