<?php
$url = str_replace('webservice.php','','http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
$auth_key = "123";
?>

<center><b><font color="red"><marquee scrollamount="5" width="40">&lt;&lt;&lt;</marquee>Bar App<marquee scrollamount="5" direction="right" width="40">&gt;&gt;&gt;</marquee></font></b></center><br/>



  REGISTER*
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;"><br/>
	

	Email <input name="email" type="email" /><br/>
	Password <input name="password" type="text" /><br/>
	DOB <input name="dob" type="text" placeholder ="DD-MM-YYYY" /><br/>  
    Country<input name="country" type="text" /><br/>
	
       <input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
       <input name="method" type="hidden" value="register" />
       <input type="submit" value="Signup"/>
</form>


 Login*
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;"><br/>
	
        Email <input name="email" type="text" /><br/>
	    Password <input name="password" type="password" /><br/>
	
        <input name="method" type="hidden" value="login" /><br/>
	    <input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	    <input type="submit" value="Login">
</form>

 Forget Password*
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;"><br/>

	Email <input name="email" type="text" /><br/>

	<input name="method" type="hidden" value="forget_password" /><br/>
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input type="submit" value="Login">
</form>

Update device id.*
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;"><br/>

        id <input  name="id" type = "text"/><br/>
	Device Id<input name="device_id" type="text" /><br/>
	Device Type<select name="device_type" ><option value="I">Iphone</option><option value="A">Android</option>
	</option>
	<br/>

	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="device_id" />
	<input type="submit" value="Signup">
</form>


 Update lat lng*
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">

        id <input  name="id" type = "text"/><br/>
	lat <input name="latitude" type="text" /><br/>
	lng <input name="longitude" type="text" /><br/>

	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="LatLng" />
	<input type="submit" value="Signup">
</form>
View all bars
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
    Current Lat<input  name="lat" type = "text"/><br/>
    Current Lng<input  name="lng" type = "text"/><br/>
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="view_all_bars" />
	<input type="submit" value="Signup">
</form>

Drinks given by bars
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
       Bar id <input  name="id" type = "text"/><br/>
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="drinks_bars" />
	<input type="submit" value="Signup">
</form>

Check time
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
       User id <input  name="userid" type = "text"/><br/>
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="check_time" />
	<input type="submit" value="Signup">
</form>

Bar details
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
       Bar id <input  name="id" type = "text"/><br/>
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="bar_detail" />
	<input type="submit" value="Signup">
</form>

User profile
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
       User id <input  name="id" type = "text"/><br/>
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="user_profile" />
	<input type="submit" value="Signup">
</form>

History 
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
       User id <input  name="id" type = "text"/><br/>
      
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="history" />
	<input type="submit" value="Signup">
</form>


BAR TENDER ACTION
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
       User id <input  name="user_id" type = "text"/><br/>
       Bar id <input  name="barid" type = "text"/><br/>
       Drink id <input  name="drink_id" type = "text"/><br/>
       Mobile Number <input  name="mob_no" type = "text"/><br/>
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="bar_tender_action" />
	<input type="submit" value="Signup">
</form>

  Login with facebook*
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;"><br/>
 

	FB id<input name="fb_id" type="text" /><br/>
	Email <input name="email" type="email" /><br/>
	
       <input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
       <input name="method" type="hidden" value="Facebook_Login" />
       <input type="submit" value="login"/>
</form>

search event
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
	name <input name="name" type="text" /><br/>
	current lat <input name="lat" type="text" /><br/>
	current lng<input name="lng" type="text" /><br/>
	
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="bar_search" />
	<input type="submit" value="submit">
</form>

All city
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="all_city" />
	<input type="submit" value="submit">
</form>

Notification on/off
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
    userid <input name="id" type="number" /><br/>
    status <input name="notification" type="number" /><br/>
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="notification" />
	<input type="submit" value="submit">
</form>

Check Notification
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
    userid <input name="userid" type="number" /><br/>
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="check_notification" />
	<input type="submit" value="submit">
</form>

Payment
<form action = "<?php echo $url;?>userServices/index" method="POST" 
style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
	User id <input name="userid" type="number"  />
	Transaction id(for android) <input name="trans_id" type="text"  />
	stripe_token<input name="stripe_token" type="text"  />
	Payment type <select name="membership_type">
	<option value="1">$10</option>
	<option value="2">$30</option>
	<option value="3">$100</option>
    </select>
	Device type <select name="device_type">
	<option value="A">android</option>
	<option value="I">iphone</option>
	
    </select>
	
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="payment" />
	<input type="submit" value="Show">
</form>


Day left(subscription)
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
    userid <input name="userid" type="number" /><br/>
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="days_left" />
	<input type="submit" value="submit">
</form>

Help screen (Question and Answer)
<form action = "<?php echo $url;?>userServices/index" method="POST" style="border-bottom: 2px solid #333; margin-bottom: 20px; padding-bottom: 20px;">
	<input name="auth_key" type="hidden" value="<?php echo $auth_key; ?>" />
	<input name="method" type="hidden" value="question" />
	<input type="submit" value="submit">
</form>

