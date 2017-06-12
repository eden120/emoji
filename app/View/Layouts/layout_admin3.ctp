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
			$this->Html->image(BASE_URL."images/common/logo.png",array("alt" => SITE_NAME,'width'=> '123px')),
			array('controller'=>'users','action'=>'login'),
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
			$this->Html->image(array('controller'=>'commons','action'=>'image',$session['profile_pic_id']),array("class"=>"img-circle","alt" => 'profile',"style"=>"width:60px")),
			  array('controller'=>'users','action'=>'profile'),
			  array('escape'=>false,'title'=>SITE_NAME)
			  );	
	          ?></p>
              	  <h5 class="centered"><?php echo ucfirst($session['name']); ?></h5>
                  <li class="mt">
			<?php  
			echo $this->Html->link('<i class="fa fa-dashboard"></i>Dashboard',
			  array('controller'=>'users','action'=>'dashboard'),
			  array('escape'=>false,'title'=>SITE_NAME,'class'=>($action=='admin_dashboard')?'active':'')
			  );	
	          ?>
                  </li>
				  
				  
				  
				<li class="sub-menu">
                      <a href="javascript:;" class="<?php echo ($action!='admin_dashboard'&&$controller=='users'?'active':''); ?>" >
                          <i class="fa fa-users"></i>
                          <span>All Users</span>
                      </a>
                      <ul class="sub">
                          <li>
						  <?php
					echo $this->Html->link("List",
					array('controller'=>'users','action'=>'list'), array('class'=>($action=='admin_list'&&$controller=='users')?'active':'','escape'=>false)
					);
					?></li><li>
					<?php
					echo $this->Html->link("Approve",
					array('controller'=>'users','action'=>'approve'), array('class'=>($action=='admin_approve'&&$controller=='users')?'active':'','escape'=>false)
					);
					?> </li>
                      </ul>
                 </li>
				  
				  
				   <li class="sub-menu">
                      <a href="javascript:;" class="<?php echo ($controller=='categories'?'active':''); ?>">
                          <i class="fa fa-th"></i><span>Categories</span>
                      </a>
                      <ul class="sub">
                          <li>
						  <?php
					echo $this->Html->link("List",
					array('controller'=>'categories','action'=>'list'), array('class'=>($action=='admin_list'&&$controller=='categories')?'active':'','escape'=>false)
					);
					?></li><li>
					<?php
					echo $this->Html->link("Add",
					array('controller'=>'categories','action'=>'add'), array('class'=>($action=='admin_add'&&$controller=='categories')?'active':'','escape'=>false)
					);
					?> </li>
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
                  
                  
      <!-- **********************************************************************************************************************************************************
      RIGHT SIDEBAR CONTENT
      *********************************************************************************************************************************************************** -->                  
                  <?php /*
                  <div class="col-lg-3 ds">
                    <!--COMPLETED ACTIONS DONUTS CHART-->
						<h3>NOTIFICATIONS</h3>
                                        
                      <!-- First Action -->
                      <div class="desc">
                      	<div class="thumb">
                      		<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                      	</div>
                      	<div class="details">
                      		<p><muted>2 Minutes Ago</muted><br/>
                      		   <a href="#">James Brown</a> subscribed to your newsletter.<br/>
                      		</p>
                      	</div>
                      </div>
                      <!-- Second Action -->
                      <div class="desc">
                      	<div class="thumb">
                      		<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                      	</div>
                      	<div class="details">
                      		<p><muted>3 Hours Ago</muted><br/>
                      		   <a href="#">Diana Kennedy</a> purchased a year subscription.<br/>
                      		</p>
                      	</div>
                      </div>
                      <!-- Third Action -->
                      <div class="desc">
                      	<div class="thumb">
                      		<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                      	</div>
                      	<div class="details">
                      		<p><muted>7 Hours Ago</muted><br/>
                      		   <a href="#">Brandon Page</a> purchased a year subscription.<br/>
                      		</p>
                      	</div>
                      </div>
                      <!-- Fourth Action -->
                      <div class="desc">
                      	<div class="thumb">
                      		<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                      	</div>
                      	<div class="details">
                      		<p><muted>11 Hours Ago</muted><br/>
                      		   <a href="#">Mark Twain</a> commented your post.<br/>
                      		</p>
                      	</div>
                      </div>
                      <!-- Fifth Action -->
                      <div class="desc">
                      	<div class="thumb">
                      		<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                      	</div>
                      	<div class="details">
                      		<p><muted>18 Hours Ago</muted><br/>
                      		   <a href="#">Daniel Pratt</a> purchased a wallet in your store.<br/>
                      		</p>
                      	</div>
                      </div>

                       <!-- USERS ONLINE SECTION -->
						<h3>TEAM MEMBERS</h3>
                      <!-- First Member -->
                      <div class="desc">
                      	<div class="thumb">
                      		<img class="img-circle" src="assets/img/ui-divya.jpg" width="35px" height="35px" align="">
                      	</div>
                      	<div class="details">
                      		<p><a href="#">DIVYA MANIAN</a><br/>
                      		   <muted>Available</muted>
                      		</p>
                      	</div>
                      </div>
                      <!-- Second Member -->
                      <div class="desc">
                      	<div class="thumb">
                      		<img class="img-circle" src="assets/img/ui-sherman.jpg" width="35px" height="35px" align="">
                      	</div>
                      	<div class="details">
                      		<p><a href="#">DJ SHERMAN</a><br/>
                      		   <muted>I am Busy</muted>
                      		</p>
                      	</div>
                      </div>
                      <!-- Third Member -->
                      <div class="desc">
                      	<div class="thumb">
                      		<img class="img-circle" src="assets/img/ui-danro.jpg" width="35px" height="35px" align="">
                      	</div>
                      	<div class="details">
                      		<p><a href="#">DAN ROGERS</a><br/>
                      		   <muted>Available</muted>
                      		</p>
                      	</div>
                      </div>
                      <!-- Fourth Member -->
                      <div class="desc">
                      	<div class="thumb">
                      		<img class="img-circle" src="assets/img/ui-zac.jpg" width="35px" height="35px" align="">
                      	</div>
                      	<div class="details">
                      		<p><a href="#">Zac Sniders</a><br/>
                      		   <muted>Available</muted>
                      		</p>
                      	</div>
                      </div>
                      <!-- Fifth Member -->
                      <div class="desc">
                      	<div class="thumb">
                      		<img class="img-circle" src="assets/img/ui-sam.jpg" width="35px" height="35px" align="">
                      	</div>
                      	<div class="details">
                      		<p><a href="#">Marcel Newman</a><br/>
                      		   <muted>Available</muted>
                      		</p>
                      	</div>
                      </div>

                        <!-- CALENDAR-->
                        <div id="calendar" class="mb">
                            <div class="panel green-panel no-margin">
                                <div class="panel-body">
                                    <div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
                                        <div class="arrow"></div>
                                        <h3 class="popover-title" style="disadding: none;"></h3>
                                        <div id="date-popover-content" class="popover-content"></div>
                                    </div>
                                    <div id="my-calendar"></div>
                                </div>
                            </div>
                        </div><!-- / calendar -->
                      
                  </div><!-- /col-lg-3 -->
				  */ ?>
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
	echo $this->Html->script(array('bootstrap.min','jquery.dcjqaccordion.2.7','jquery.scrollTo.min','jquery.nicescroll','jquery.sparkline','common-scripts','common-scripts','gritter/js/jquery.gritter','gritter-conf','sparkline-chart','zabuto_calendar','common/functions.js')); ?>
	
	
	
	<script type="text/javascript">
        $(document).ready(function () {
		/*
        var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'Welcome to Dashgum!',
            // (string | mandatory) the text inside the notification
            text: 'Hover me to enable the Close Button. You can hide the left sidebar clicking on the button next to the logo. Free version for <a href="http://blacktie.co" target="_blank" style="color:#ffd777">BlackTie.co</a>.',
            // (string | optional) the image to display on the left
            image: 'assets/img/ui-sam.jpg',
            // (bool | optional) if you want it to fade out on its own or just sit there
            sticky: true,
            // (int | optional) the time you want it to be alive for before fading out
            time: '',
            // (string | optional) the class name you want to apply to that specific message
            class_name: 'my-sticky-class'
        });

        return false; */
        });
	</script>
	
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
