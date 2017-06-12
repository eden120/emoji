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
				  if(id){
					  data +='&ids[]='+id;  
				  }else{
				   for(i=0;i<ids.length;i++){  
					   data +='&ids[]='+ids[i].value;
				   }
				  }
				$.ajax({
				  type: "POST",
				  url: BASE_URL+'admin/'+controller+'/action',
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