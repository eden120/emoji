<?php //common var

$controller = $this->request->params['controller'];
$action = $this->request->params['action'];
$session = $this->Session->read("SESSION_ADMIN");

//common var
?>




<!DOCTYPE html>
<html lang="en">
  <head>
  <?php echo $this->Html->meta('icon'); ?>
  <title><?php echo $title_for_layout;?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin">
	<script>
	 var BASE_URL = '<?php echo BASE_URL; ?>';
	 var RECORDS_PER_PAGE = '<?php echo RECORDS_PER_PAGE; ?>';
	</script>
 
 <?php
 
 echo $this->Html->css(array('bootstrap.css','/font-awesome/css/font-awesome.css','zabuto_calendar.css','/js/gritter/css/jquery.gritter.css','/lineicons/style.css','style.css','style-responsive.css','common.css'));
 
 echo $this->Html->script(array('chart-master/Chart.js','jquery','jquery-1.8.3.min'));
 
 ?>
  
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
			<?php echo $this->Html->link(
			$this->Html->image(BASE_URL."images/common/logo9.png",array("alt" => SITE_NAME,'width'=> '123px')),
			array('controller'=>'users','action'=>'admin_dashboard'),
			array('escape'=>false,'title'=>SITE_NAME,'class'=>"logo")
			);		
	       ?>
             
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li>
					<?php echo $this->Html->link("Logout",
						array('controller'=>'users','action'=>'logout'),
						array('class'=>'logout','title'=>'Logout')
				   	); ?>
					 
            	</ul>
            </div>
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered">
				<?php
		
				echo $this->Html->link(
			//$this->Html->image(array('controller'=>'commons','action'=>'image',$session['profile']),array("class"=>"img-circle","alt" => 'Profile',"style"=>"width:60px")),
					$this->Html->image(BASE_URL."images/common/logo5.png",array("alt" => 'Profile','width'=> '100px')),
			  array('controller'=>'users','action'=>'admin_dashboard'),

			  array('escape'=>false,'title'=>SITE_NAME)
			  );	
	          ?></p>
              	  <h5 class="centered"><?php echo $this->Html->link(
				  
			ucfirst($session['email']),
			  array('controller'=>'users','action'=>'admin_dashboard'),
			  array('escape'=>false,'title'=>SITE_NAME)
			  ); ?></h5>
                  <li class="mt">
			<?php  
			echo $this->Html->link('<i class="fa fa-dashboard"></i>Dashboard',
			  array('controller'=>'users','action'=>'dashboard'),
			  array('escape'=>false,'title'=>SITE_NAME,'class'=>($action=='admin_dashboard')?'active':'')
			  );	
	          ?>
                  </li>
				  
				  
				  
				<!-- <li class="sub-menu">
                      <a href="javascript:;" class="<?php echo ($action=='admin_list'&&$controller=='users'?'active':''); ?>" >
                          <i class="fa fa-users"></i>
                          <span>All Users</span>
                      </a>
                      <ul class="sub">
                          <li>
						  <?php
					echo $this->Html->link("List",
					array('controller'=>'users','action'=>'list'), array('class'=>($action=='admin_list'&&$controller=='users')?'active':'','escape'=>false)
					);
					?></li>
				<li>	<?php
					  echo $this->Html->link("Add",
					   array('controller'=>'users','action'=>'add'), array('class'=>($action=='admin_add'&&$controller=='users')?'active':'','escape'=>false)
					   );
					  ?>  
                      </ul>
                 </li> -->
				  
				  
				   <li class="sub-menu">
                      <a href="javascript:;" class="<?php echo ($controller=='Categories'?'active':''); ?>">
                          <i class="fa fa-th"></i><span>Category</span>
                      </a>
                      <ul class="sub">
                          <li>

                       <?php
					echo $this->Html->link("Add",
					array('controller'=>'Categories','action'=>'add'), array('class'=>($action=='admin_add'&&$controller=='Categories')?'active':'','escape'=>false)
					);
					?>

						  </li><li>
					<?php
					/* echo $this->Html->link("List",
					array('controller'=>'Categories','action'=>'list'), array('class'=>($action=='bar_list'&&$controller=='bars')?'active':'','escape'=>false)
					); */
					?>

					</li>
                      </ul>
                  </li>
				  
				  <li class="sub-menu">
                      <a href="javascript:;" class="<?php echo ($controller=='images'?'active':''); ?>" >
                           <i class="fa fa-list"></i>
                          <span>Images</span>
                      </a>
                      <ul class="sub">
                          <li>
				<?php
					echo $this->Html->link("Add",
					array('controller'=>'images','action'=>'add'), array('class'=>($action=='admin_add'&&$controller=='images')?'active':'','escape'=>false)
					);
					?> 
				    </li><li>
					<?php
					/* echo $this->Html->link("List",
					array('controller'=>'images','action'=>'list'), array('class'=>($action=='admin_list'&&$controller=='images')?'active':'','escape'=>false)
					); */
					?>
					</li>
                      </ul>
                 </li>
				<!--  <li class="sub-menu">
                      <a href="javascript:;" class="<?php echo ($controller=='questions'?'active':''); ?>" >
                           <i class="fa fa-list"></i>
                          <span>How app work</span>
                      </a>
                      <ul class="sub">
                          <li>
						  <?php
					/* echo $this->Html->link("List",
					array('controller'=>'questions','action'=>'list'), array('class'=>($action=='admin_list'&&$controller=='questions')?'active':'','escape'=>false)
					); */
					?></li><li>
					<?php
					echo $this->Html->link("Add",
					array('controller'=>'questions','action'=>'add'), array('class'=>($action=='admin_add'&&$controller=='questions')?'active':'','escape'=>false)
					);
					?> </li>
                      </ul>
                 </li>  -->
				 
				  <li class="sub-menu">
				  <a href="/MyDashboard/admin/users/settings" >
                          <i class="fa fa-cogs"></i>
                          <span>Settings</span>
						  </a>
						  
					<ul class="sub">
							<li><?php
					echo $this->Html->link("Change Password",
					array('controller'=>'users','action'=>'settings'), array('class'=>'top_link')
					);
					?></li>
                         
                      </ul>	  
						  
						  
                  </li>

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">

              <div class="row">
                  <div class="col-lg-12 main-chart">
					<!-- content start -->
					<?php echo $this->Session->flash(); 
                    echo $this->fetch('content');
                       ?>	
					
					<!-- content end -->
					
                  </div><!-- /col-lg-9 END SECTION MIDDLE -->
                   
              </div><! --/row -->
          </section>
      </section>

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
		   &copy; Copyright <?php echo $this->Html->link(SITE_NAME,BASE_URL);?>. All Rights Reserved.
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>
 
	<?php 
	echo $this->Html->script(array('bootstrap.min','jquery.dcjqaccordion.2.7','jquery.scrollTo.min','jquery.nicescroll','jquery.sparkline','common-scripts','common-scripts','gritter/js/jquery.gritter','gritter-conf','morris-0.4.3.min.js','raphael-min.js','sparkline-chart','zabuto_calendar','common/functions.js')); 
	if($action=='admin_dashboard'){
		
		echo $this->Html->script(array('dashboard-graph.js'));
	}
	
	
	?>
	
	
	
	 
	
	<script type="application/javascript">
        $(document).ready(function () {
            $("#date-popover").popover({html: true, trigger: "manual"});
            $("#date-popover").hide();
            $("#date-popover").click(function (e) {
                $(this).hide();
            });
        
            $("#my-calendar").zabuto_calendar({
                action: function () {
                    return myDateFunction(this.id, false);
                },
                action_nav: function () {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [
                    {type: "text", label: "Special event", badge: "00"},
                    {type: "block", label: "Regular event", }
                ]
            });
        });
        
        
        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
		
    </script>
  

  </body>
</html>
