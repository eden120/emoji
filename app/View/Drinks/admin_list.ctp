<?php
//pr($resultData);die;
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
					   <?php echo $this->Form->create('Drink',array('action'=>$newUrl,'method'=>'POST', "class" => "form-inline", "name" => "listForm", "id" => "mainform","role"=>"form")); ?>
					  
                         <!-- <div align="center" class="form-group">
                              &nbsp;&nbsp;&nbsp;<label  for="searchBy"> Search by: </label>
							  
							  <?php
				                  $fieldsArray = array('' => '---','Drink.name'=> 'Drink Name');
				                  echo $this->Form->input("Drink.fieldName",array("type"=>"select","class"=>"form-control","style"=>"width:200px;","options"=>$fieldsArray,"label"=>false,"div"=>false,'id'=>'searchBy','empty'=>false));
			                   ?>    
                          </div>
                          <div align="center" class="form-group">
                              <label  for="search_input"> Search value: </label>
                              
							<?php
					            echo $this->Form->input("Drink.value1",array("id"=>"search_input","class"=>"form-control","style"=>"width:200px;", "div"=>false, "label"=> false,"value"=>$search2,'placeholder'=>'Value'));
					
				            ?>
                          </div>
						  <div align="center" class="form-group">
						  <?php 
						  echo $this->Form->button("Search", array("type"=>"submit",'class'=>'btn btn-theme','id'=>'search'))."&nbsp;&nbsp;&nbsp;";
						  echo $this->Form->button("Reset",array('type'=>'button','class'=>"btn btn-warning",'div'=>false,'onclick'=>"location.href='".BASE_URL."admin/Drink/list'"));
						  ?>
						  </div>-->
                           
                     <?php echo $this->Form->end(); ?>
					   
					   <hr>
					   
                          <table class="table table-striped table-advance table-hover">
	                       
                               <thead>
                              <tr>
							  <!--<th class="table-header-check"><input  type="checkbox" id="toggle-all"> </th>-->
                                  <th>&nbsp;
<?php echo $this->Paginator->sort('Drink.name','Name');?> </th>
                                  <th>&nbsp;
</i> <?php echo $this->Paginator->sort('Bar.name','Bar Name');?></th>
                          
 <th>&nbsp;
</i> <?php echo $this->Paginator->sort('Bar.price','Price');?></th>
                                 <th class="hide-mobile">&nbsp;Options</th>
                              </tr>
                              </thead>
                              <tbody>
							  <?php   foreach($resultData as $result){ 
							  $r_id = $result['Drink']['id'];
							  ?>
                              <tr>
							 <!-- <td><input  class="ids" type="checkbox" name="IDs[]" value="<?php echo $result['Drink']['id'];?>"/></td>-->
									<td><?php echo $result['Drink']['name']; ?>
									</td>
									<td><?php if($result['Bar']['name']){ echo $result['Bar']['name']; }else{  echo'Self';} ?></td>
						<td><?php echo $result['Drink']['price']; ?>
									</td>
									
								  
                                  <td class="hide-mobile" >
                                       
                                      <button class="btn btn-primary btn-xs" onclick="window.location='<?php echo BASE_URL.'admin/drinks/edit/'.$r_id; ?>';"><i class="fa fa-pencil"></i></button>
                                      <?php echo $this->Form->postLink(
										$this->Html->tag('i', '', array('class' => 'fa fa-institution btn btn-danger btn-xs')),
										array('action' => 'delete', $result['Drink']['id']),
										array('escape'=>false),
										__('Are you sure you want to delete ?'),
									   array('class' => 'btn btn-mini')
									);?>
									  <button class="btn btn-primary btn-xs" onclick="window.location='<?php echo BASE_URL.'admin/drinks/view/'.$r_id; ?>';"><i class="fa fa-eye"></i></button>
                                  </td>
                              </tr>
							  <?php } ?>
                               
                              </tbody>
                          </table>
							<div class="row">
								<div class="col-md-9 pull-left">
								  <div id="actions-box">				  
									<div class="btn-group">
									  <!--<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
										Action
										<span class="caret"></span>
									  </a>
									 <ul class="dropdown-menu">
									 <li><?php echo $this->Form->postLink(
                                $this->Html->tag('i', '', array('class' => 'fa fa-institution btn btn-danger btn-xs')),
                                         array('action' => 'delete', $result['Drink']['id']),
                                                                  array('escape'=>false),
                                                  __('Are you sure you want to delete this ?'),
                                                    array('class' => 'btn btn-mini')
                                                          );?></li>
									 </ul>-->
									</div>
								   </div>
								</div>
								<div class="col-md-2 pull-right"> 
								   <ul class="pager" id="actions-box">
		<?php echo $this->Paginator->prev('&laquo;', array( 'tag' => 'li', 'escape' => false,'class' => false), '<a href="javascript:void(0);">&laquo; </a>', array('class' => 'disabled' ,'tag' => 'li', 'escape' => false));      
				 						echo $this->Paginator->counter(array('format' => '<li>%page%/ %pages%</li>')); 
				 
								   echo $this->Paginator->next('&raquo;', array( 'tag' => 'li', 'escape' => false,'class' => false),'<a href="javascript:void(0);"> &raquo;</a>', array('class' => 'disabled' ,'tag' => 'li', 'escape' => false)); 
												 
								  ?>
								  </ul>
                                 
								</div>
								  
							</div>					
					 	  
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->