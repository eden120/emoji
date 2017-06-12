 <!DOCTYPE html>
<html lang="en">
  <head>
  <?php echo $this->Html->meta('icon'); ?>
  <title><?php echo $title_for_layout;?></title>
  <?php echo $this->Html->charset('UTF-8'); ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>DASHGUM - Bootstrap Admin Template</title>
	<script>
	 var BASE_URL = '<?php echo BASE_URL; ?>';
	</script>
 <?php
 echo $this->Html->css(array('bootstrap.css','/font-awesome/css/font-awesome.css','style.css','style-responsive.css'));
 echo $this->Html->script(array('jquery.js','common/functions.js'));
  
 ?>
   
  </head>

  <body>
 
	  <div id="login-page">
	  	<div class="container">
<?php echo $this->Session->flash(); 
 echo $this->fetch('content');
 ?>	  	
	  	
	  	</div>
	  </div>

	  
	  	<?php 
	echo $this->Html->script(array('bootstrap.min.js','jquery.backstretch.min.js')); ?>
	  
    <script>
        $.backstretch("<?php echo $this->request->webroot;?>/img/1.png", {speed: 500});
    </script>


  </body>
</html>
