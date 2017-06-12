 <?php $session = $this->Session->read("SESSION_ADMIN");
?>
 
 <div class="row mt">
                  <div class="col-md-12">
				      
			<div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo ucfirst($this->data['Product']['name']); ?></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> 
				
			<?php	
			echo $this->Html->image(array('controller'=>'commons','action'=>'image',$this->data['Product']['pic_id']),array("class"=>"img-circle img-responsive",'id'=>'profile_pic_set',"alt" => 'profile',"style"=>"max-width:200px"))
				
				?>
				 </div>
                
                 
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information" id="profile">
                    <tbody>
                      <tr>
                        <td>User Name:</td>
                        <td><?php   echo ucfirst($this->data['User']['name']); ?></td>
                      </tr>
                      <tr>
                        <td>Product Name:</td>
                        <td><?php   echo ucfirst($this->data['Product']['name']);  ?></td>
                      </tr>
					  <tr>
                        <td>Category Name</td>
                        <td><?php echo  $this->data['Category']['name']; ?></td>
                      </tr>
                      <tr>
                        <td>Type</td>
                        <td><?php echo ($this->data['Product']['type'] == '1')?'<span class="badge bg-primary">Product</span>':'<span class="badge bg-success">Service</span>' ?></td>
                      </tr>
					   <tr>
                        <td>Description</td>
                        <td><?php echo  $this->data['Product']['description']; ?></td>
                      </tr>
					     <tr>
                        <td>Price</td>
                        <td><?php echo  $this->data['Product']['price']; ?></td>
                      </tr>
					    
                         
                    </tbody>
                  </table>
				  
				    			  
                </div>
              </div>
            </div>
            <div class="panel-footer">
                       
                        
            </div>
					
			</div>		
					  
					  
				 
     </div><!-- /col-md-12 -->
 </div><!-- /row -->