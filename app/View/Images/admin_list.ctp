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
					   <?php echo $this->Form->create('Image',array('action'=>'list','method'=>'POST', "class" => "form-inline", "fname" => "listForm", "id" => "mainform","role"=>"form")); ?>
					  
                          <div align="center" class="form-group">
                              &nbsp;&nbsp;&nbsp;<label  for="searchBy"> Search by: </label>
							  
							  <?php
				                  $fieldsArray = array('' => '---','Category.name'=> 'Category Name');
				                  echo $this->Form->input("Category.fieldName",array("type"=>"select","class"=>"form-control","style"=>"width:200px;","options"=>$fieldsArray,"label"=>false,"div"=>false,'id'=>'searchBy','empty'=>false));
			                   ?>    
                          </div>
						   
                          <div align="center" class="form-group">
                              <label  for="search_input"> Search value: </label>
                              
							<?php
					            echo $this->Form->input("Category.value1",array("id"=>"search_input","class"=>"form-control","style"=>"width:200px;", "div"=>false, "label"=> false,"value"=>$search2,'placeholder'=>'Value'));
					
				            ?>
                          </div>
						  <div align="center" class="form-group">
						  <?php 
						   
						  echo $this->Form->button("Search", array("type"=>"submit",'class'=>'btn btn-theme','id'=>'search'))."&nbsp;&nbsp;&nbsp;";
						  echo $this->Form->button("Reset",array('type'=>'button','class'=>"btn btn-warning",'div'=>false,'onclick'=>"location.href='".BASE_URL."admin/images/list'"));
						  ?>
						  </div>
                           
                     <?php echo $this->Form->end(); ?>
					   
					   <hr>
						<h4  style="color:red;">Images In Categories </h4>
                          <table class="table table-striped table-advance table-hover">
	                       
                              <thead>
                              <tr>
							  
							  <th class="hide-mobile"> <?php echo $this->Paginator->sort('Category.name','Category Name');?></th>
							  <th class="hide-mobile"> <?php echo $this->Paginator->sort('Image.category_image','Image');?></th>
             				  <th class="hide-mobile">&nbsp;Options</th>
                              </tr>
                              </thead>
                              <tbody>
							  <?php foreach($resultData as $result){ 
							  $r_id = $result['Category']['id'];
							  ?>
                              <tr>
							  
							      
                                  <td><a href="javascript:void(0);"><?php echo $result['Category']['name']; ?></a></td>
								   <td><a href="javascript:void(0);"> <img src="<?php echo BASE_URL."app/webroot/img/".$result['Image']['image']; ?>" height="60" width="50"></a></td>
                                  
                                  
                                  <td class="hide-mobile" >
                                     <!-- <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> -->
                                      <?php echo $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-pencil btn btn-primary btn-xs')) ,array('controller'=>'categories','action'=>'edit',$result['Category']['id']),
                                    array('title'=>'Edit', 'escape' => false)
                                  ); ?>&nbsp;&nbsp;&nbsp;
                                    <?php echo $this->Form->postLink(
									   $this->Html->tag('i', '', array('class' => 'fa fa-institution btn btn-danger btn-xs')),
											array('action' => 'delete', $result['Category']['id'],'title'=>'Delete'),
											array('escape'=>false,'title'=>'Delete'),
										__('Are you sure you want to delete ?'),
									   array('class' => 'btn btn-mini')
									);?>
									
	                                
								</td>
                              </tr>
							  <?php } ?>
                              
                              </tbody>
                          </table>
							<div class="row">
								
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
<script type="text/javascript">
$(document).ready(function(){
	 
	
	$('a.delete').click(function(){
		if(confirm("Are you sure you want to delete?") == true){
			return true;
		}
		return false;
	});
	
	
	$('#toggle-all').click(function(){		
		var checkboxes = $(this).closest('table').find(':checkbox');
		if($(this).is(':checked')) {
			checkboxes.attr('checked', 'checked');
		} else {
			checkboxes.removeAttr('checked');
		}
	});
	
	$('#fgPwdSmt').click(function(){
 
		$("#fgpwderr").html('');
		$("#fgpwstatus").html('');
		 $.ajax({
           type: "POST",
           url: BASE_URL+'admin/users/forgot_password',
           data: $("#UserForgotPasswordForm").serialize(), // serializes the form's elements.
           success: function(data)
           {   data = JSON.parse(data);
               if(data.status == 0){
				  $("#fgpwderr").html(data.error);
			   }else if(data.status==1){
				   $("#fgpwstatus").html(data.message);
				   
			   }
           }
         });
		
	});
	
	
	
	 
});
 
function do_action(action,controller,id=null){
	
		var ids = $('.ids:checked');
		if(ids.length>0||id){
			if(confirm('Are you sure you want to '+action.toLowerCase()+'?')){
				  var data = 'action='+action;
				  var BASE_URL="<?php echo BASE_URL;?>";
				  if(id){
					  data +='&ids[]='+id;  
				  }else{
				   for(i=0;i<ids.length;i++){  
					   data +='&ids[]='+ids[i].value;
				   }
				  }
				$.ajax({
				  type: "POST",
				  url: BASE_URL+'admin/categories/action',
				  data: data,
				  success: function(resp){
	                  if(action=='Approve'){
						  window.location = BASE_URL+'admin/'+controller+'/pending'  
					  }else{
					    window.location = BASE_URL+'admin/'+controller+'/list'
					  }
									 
				  }
				});
			}
		}else{
			alert('Please select atleast one checkbox.');	
		}
	
}
 
/**
    * @Method : get confirmation 
    * @Purpose:This method is used to get confirmation before proceeding to sone action
    * @Param: message
    * @Return: boolean
**/
function getConfirmation(message)
	{
		var action = confirm(message);
		if(action == true){
		return true;
		}else{
			return false;
		}
	}





/*return hierarchical html list of categories*/

function getChilds(parent_id,menuItems,name,skip_id){	var list_ = '';	for(var index in menuItems){		if(menuItems[index]['Category']['parent_id']==parent_id&&menuItems[index]['Category']['id']!=skip_id){			list_ += '<li><input type="radio" value="'+menuItems[index]['Category']['id']+'" id="cat'+menuItems[index]['Category']['id']+ '" name="'+name+'" onclick="showHideFields(1)"/><label class="not-error-label" for="cat' + menuItems[index]['Category']['id']+ '">'+menuItems[index]['Category']['name']+'</label></li>';			var ll = getChilds(menuItems[index]['Category']['id'], menuItems,name,skip_id);			if(ll.length>0){				list_ += '<li><ul class="cat-sub">'+ ll +'</ul></li>';			}		}	}	return list_;}function showHideFields(val){	if(val==0){		$('#MenuItemDescriptionTr').show();		$('#MenuItemDescription').attr('required',false);	}else{		$('#MenuItemDescriptionTr').show(20);		$('#MenuItemDescription').attr('required',true);	}}
</script>