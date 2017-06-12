<?php
$newUrl = "list".$urlString;
$urlArray = array(
	'field' 	=> $search1,
	'value' 	=> $search2,
);
$this->Paginator->options(array('url'=>$urlArray));
?> 
     <div class="row mt">
                  <div class="col-md-12">
                      <div class="content-panel">
					   <?php echo $this->Form->create('Product',array('action'=>'list','method'=>'POST', "class" => "form-inline", "name" => "listForm", "id" => "mainform","role"=>"form")); ?>
					  
                          <div align="center" class="form-group">
                              &nbsp;&nbsp;&nbsp;<label  for="searchBy"> Search by: </label>
							  
							  <?php
				                  $fieldsArray = array('' => '---','Product.name'=> 'Product Name','User.name'=> 'Owner Name');
				                  echo $this->Form->input("Product.fieldName",array("type"=>"select","class"=>"form-control","style"=>"width:200px;","options"=>$fieldsArray,"label"=>false,"div"=>false,'id'=>'searchBy','empty'=>false));
			                   ?>    
                          </div>
						  
                          <div align="center" class="form-group">
                              <label  for="search_input"> Search value: </label>
                              
							<?php
					            echo $this->Form->input("Product.value1",array("id"=>"search_input","class"=>"form-control","style"=>"width:200px;", "div"=>false, "label"=> false,"value"=>$search2,'placeholder'=>'Value'));
					
				            ?>
                          </div>
						  <div align="center" class="form-group">
						  <?php 
						   
						  echo $this->Form->button("Search", array("type"=>"submit",'class'=>'btn btn-theme','id'=>'search'))."&nbsp;&nbsp;&nbsp;";
						  echo $this->Form->button("Reset",array('type'=>'button','class'=>"btn btn-warning",'div'=>false,'onclick'=>"location.href='".BASE_URL."admin/Products/list'"));
						  ?>
						  </div>
                           
                     <?php echo $this->Form->end(); ?>
					   
					   <hr>
					   
                          <table class="table table-striped table-advance table-hover">
	                       
                              <thead>
                              <tr>
							  <th class="table-header-check"><input  type="checkbox" id="toggle-all"> </th>
							   <th><i class="fa fa-user"></i><?php echo $this->Paginator->sort('User.name','Owner Name');?></th>
                                  <th><i class="fa fa-cube"></i><?php echo $this->Paginator->sort('Product.name','Product Name');?> </th>
                                  <th class="hide-mobile"> <?php echo $this->Paginator->sort('Product.type','Type');?></th>
<th class="hide-mobile"><i class="fa fa-file-text"></i> <?php echo $this->Paginator->sort('Product.description','Description');?></th>
<th class="hide-mobile"><i class="fa fa-money"></i>
&nbsp;<?php echo $this->Paginator->sort('Product.price','Price');?></th>
                                  <th><i class="fa fa-picture-o"></i>
&nbsp;Image</th>
                                  <th class="hide-mobile"><i class=" fa fa-edit"></i>&nbsp; <?php echo $this->Paginator->sort('Product.status', 'Status');?></th>
                                  <th class="hide-tab"><i class="fa fa-calendar"></i>&nbsp;<?php echo $this->Paginator->sort('Product.created','created');?>
</th>                       </th><th class="hide-mobile"><i class="fa fa-tasks"></i>&nbsp;Options</th>
                              </tr>
                              </thead>
                              <tbody>
							  <?php foreach($resultData as $result){ 
							  $r_id = $result['Product']['id'];
							  ?>
                              <tr>
							  <td><input  class="ids" type="checkbox" name="IDs[]" value="<?php echo $result['Product']['id'];?>"/></td>
							   <td>
							   <a href="javascript:void(0);"><?php echo $result['User']['name']; ?></a></td>
                                  <td><?php  echo $this->Html->link($result['Product']['name'],
					array('controller'=>'products','action'=>'details',$result['Product']['id']), array('escape'=>false));    ?></td>
                                  <td class="hide-mobile"> <?php echo ($result['Product']['type'] == '1')?'<span class="badge bg-primary">Product</span>':'<span class="badge bg-success">Service</span>' ?> </td>
								  <td class="hide-mobile" ><?php echo $result['Product']['description']; ?></td>
                                  <td class="hide-mobile"><?php echo $result['Product']['price']; ?></td>
                                  <td><?php
								  echo $this->Html->image(array('controller'=>'commons','action'=>'image',$result['Product']['pic_id']),array("class"=>"","alt" => 'profile',"style"=>"max-width:100px")); 
								  ?></td>
								  <td class="hide-mobile">
								  <?php echo ($result['Product']['status'] == '1')?'<span class="label label-success label-mini">Active</span>':'<span class="label label-warning label-mini">Deactive</span>' ?>
								  
								  </td>
								   <td class="hide-tab" ><?php echo date(DATE_FORMAT,strtotime($result['User']['created'])); ?></td>
                                  <td class="hide-mobile" >
                                   
								  <button class="btn btn-danger btn-xs" onclick="do_action('Delete','products',<?php echo $r_id; ?>)"><i class="fa fa-trash-o "></i></button> 
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
									 <li><a href="javascript:void(0);" onclick="do_action('Delete','products');">Delete</a></li>
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