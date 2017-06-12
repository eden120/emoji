<?php echo $this->Html->css("reveal"); ?>
<?php echo $this->Html->script(array("jquery-1.6.min","jquery.reveal")); ?>
<div class="main-2" style="height:1100px;">
<div class="empty"></div>
<div class="page4-div1">
<div class="page4-div2">

<?php echo $this->Form->create('Page',array('action'=>'detail_page','method'=>'POST')); ?>
<h5 style="margin:5px;"><?php echo $this->data['Page']['title']; ?></h5>
<?php echo $this->Form->input('id',array('type'=>'hidden','readonly'=>true)); ?>
<?php echo $this->Form->input('title',array('type'=>'hidden','readonly'=>true));

$directory=realpath('../../app/webroot/img/ownerItems'). DS;
$files = $common->get_files($directory, "/^".$this->data['Page']['id']."-small"."/i");
?>
<?php echo $this->Html->image(BASE_URL."img/ownerItems/".$files[0], array('width'=>'210','height'=>'220')); ?>

<div class="page4-div2-img">
<h6 style="margin:5px; font-weight:bold; font-size:14px;">Enter Password Below To :</h6>
<div class="empty"></div>
<div class="page4-div2-BTN1">
<div class="page4-div2-BTN1-img">
<?php echo $this->Html->image(BASE_URL."img/lock-128.png", array('width'=>'20','height'=>'20')); ?>
</div>
<div class="page4-div2-BTN1-text">
<h6 style="color:#FFFFFF;">LOCK PAGE</h6>
</div>
<div class="page4-div2-BTN1-checkbox">
<input type="checkbox" value="" id="" disabled=true />
</div>

</div>
<div class="empty"></div>
<div class="page4-div2-BTN2">
<div class="page4-div2-BTN1-img">
<?php echo $this->Html->image(BASE_URL."img/Opened_Lock-128.png", array('width'=>'20','height'=>'20')); ?>
</div>
<div class="page4-div2-BTN1-text">
<h6 style="color:#FFFFFF;">UNLOCK PAGE</h6>
</div>
<div class="page4-div2-BTN1-checkbox">
<input type="checkbox" value="" id="" disabled=true />
</div>



</div>

<div class="empty"></div>
<div class="page-div2-PASS-BOX">
<div class="page-div2-PASS-TEXT">
<h6 style="font-size:12px;">PASSWORD</h6>
</div>

<div>
<input class="page4-div2-PASSWORD" type="text" name="" disabled=true />
</div>

</div>

</div>



</div>

<div class="form-main-box">

<div class="row-box">
<div class="left-text">1. Approximate Date Of Purchase </div>
<div class="right-text-box">
<?php
$date_of_purchase = date('m/d/Y', strtotime($this->data['Page']['date_of_purchase']));
echo $this->Form->input('date_of_purchase',array('type'=>'text', 'class'=>"input left-margin",'div'=>false,'label'=>false,'readonly'=>true,'value'=>$date_of_purchase)); ?>
</div>
</div>

<div class="row-box">
<div class="left-text">2. Where Purchased (City, State, Country) </div>
<div class="right-text-box">
<?php echo $this->Form->input('purchased_from',array('type'=>'text','class'=>"input left-margin", 'div'=>false,'label'=>false,'readonly'=>true)); ?>
</div>
</div>

<div class="row-box">
<div class="left-text">3. Approximate Price Paid (If Gift, Write Gift)       </div>
<div class="right-text-box">
<?php echo $this->Form->input('price',array('type'=>'text','class'=>"input left-margin dollar", 'div'=>false,'label'=>false,'readonly'=>true)); ?>
</div>
</div>

<div class="row-box">
<div class="left-text">4. Reason or occasion for acquisition  </div>
<div class="right-text-box">
<?php echo $this->Form->input('reason',array('type'=>'text','class'=>"input left-margin", 'div'=>false,'label'=>false,'readonly'=>true)); ?>
</div>
</div>

<div class="row-box">
<div class="left-text">5. Estimated value if offered for sale      </div>
<div class="right-text-box"> 
<?php echo $this->Form->input('sale_value',array('type'=>'text','class'=>"input left-margin dollar",'div'=>false,'label'=>false,'readonly'=>true));?>
</div>
</div>

<div class="row-box">
<div class="left-text">6. My Thoughts About What To Do With This Item </div>
<div class="right-text-box"></div>
</div>


<div class="row-box">
<div class="left-text ">
<div class="left-padding">6.1   Sell It And Get What You Can</div>
 </div>
<div class="right-text-box"> 
<?php echo $this->Form->input('sell_it_get',array('type'=>'text','class'=>"input left-margin dollar",'div'=>false,'label'=>false,'readonly'=>true));?>
</div>
</div>

<div class="row-box">
<div class="left-text ">
<div class="left-padding">6.2   Sell It Only If You Get    </div>
 </div>
<div class="right-text-box"> 
<?php echo $this->Form->input('sell_it_only',array('type'=>'text','class'=>"input left-margin dollar",'div'=>false,'label'=>false,'readonly'=>true));?>
</div>
</div>

<div class="row-box">
<div class="left-text ">
<div class="left-padding">6.3   Offer to relative   </div>
 </div>
<div class="right-text-box"> 
<?php echo $this->Form->input('offer_to_relative',array('type'=>'text','class'=>"input left-margin",'div'=>false,'label'=>false,'readonly'=>true));?>
</div>
</div>

<div class="row-box">
<div class="left-text ">
<div class="left-padding">6.4   Donate To Charity  </div>
 </div>
<div class="right-text-box"> 
<?php echo $this->Form->input('donate',array('type'=>'text','class'=>"input left-margin",'div'=>false,'label'=>false,'readonly'=>true));?>
</div>
</div>

<div class="row-box">
<div class="left-text ">
<div class="left-padding">6.5   Keep as family heirloom </div>
 </div>
<div class="right-text-box"> 
<?php echo $this->Form->input('keep_as_family',array('type'=>'text','class'=>"input left-margin",'div'=>false,'label'=>false,'readonly'=>true));?>
</div>
</div>





<div class="row-box">
<div class="left-text ">
<div class="left-padding">6.6   Other </div>
 </div>
<div class="right-text-box"> 
<?php echo $this->Form->input('other',array('type'=>'text','class'=>"input left-margin",'div'=>false,'label'=>false,'readonly'=>true));?>
</div>
</div>

</div>



</div>
<div class="empty"></div><div class="empty"></div><div class="empty"></div>
<div class="commentry-box">
<div class="commentry-div1">
<div class="commentry-div2">
&nbsp; &nbsp;Commentary...
</div>
<div class="commentry-div3">
<style type="text/css">
			/*body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }*/
			.big-link {text-align: center; text-decoration:none; font-size: 18px; color:#000000f; line-height:50px;}
		</style>
(Click Here For<a href="#" class="big-link" data-reveal-id="myModal" data-animation="fade">
			HELP
		</a>...)
        <div id="myModal" class="reveal-modal">
			<h3 style="font-family:Verdana, Arial, Helvetica, sans-serif; color:#1a72a6;">Help Page</h3>
            
<h6 style="margin-left:20px; font-size:16px; font-family:Verdana, Arial, Helvetica, sans-serif;">Problem</h6>

<p style="margin-left:30px; text-align:justify; font-family:Verdana, Arial, Helvetica, sans-serif;">Users may have trouble finding what they need on the site or they are experiencing problems with one of the site's functionalities. </p>

<h6 style="margin-left:20px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px;">Solution</h6>

<p style="margin-left:30px; text-align:justify; font-family:Verdana, Arial, Helvetica, sans-serif;">Place a link on every page to the Help page where users find help with the most common problems </p>

<h6 style="margin-left:20px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px;">Use when</h6>

<p style="margin-left:30px; text-align:justify; font-family:Verdana, Arial, Helvetica, sans-serif;">On complex site such as Web-based Application or E-commerce Site where users can have to go through a Registration process, or place orders, or do some other complex task users may experience problems and get stuck.</p>
<a class="close-reveal-modal">&#215;</a>
</div>
			
		</div>


<!--(Click Here For <a href="JavaScript:newPopup('index-4.html');">HELP</a>...)-->

<!--<script type="text/javascript">
// Popup window code
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=500,width=700,left=400,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
}
</script>-->
</div>



<div>
<?php echo $this->Form->textarea('comment',array('div'=>false,'label'=>false,'class'=>'commentry-input','style'=>'background:#FFFFFF; border:#1a72a6 solid thin;','readonly'=>true));?>
</div>

</div>
</div>

<div class="empty"></div>
<div class="page4-button-box" style='padding-left:150px;'>

<div class="page4-button-div3" style="width:auto;font-family:verdana, arial, helvetica; font-size:14px;padding-top:44px;">
<?php echo $this->Html->link("Back to Index","/pages/list_pages", array('style'=>'color:#1d74af; text-decoration:underline;')); ?>
</div>

<div class="page4-button-div3">
<div class="button-div3">
<dt style="padding-top:15px; color:#FFFFFF;"><?php
$prevPage = (!empty($paging['prev'])?'/pages/detail_page/'.base64_encode($paging['prev']):'#A');
echo $this->Html->link("Previous Image",$prevPage, array('class'=>'link-class')); ?></dt>
</div>
</div>

<div class="page4-button-div3">
<div class="button-div3">
<dt style="padding-top:15px; color:#FFFFFF;"><?php
$nextPage = (!empty($paging['next'])?'/pages/detail_page/'.base64_encode($paging['next']):'#A');
echo $this->Html->link("Next Image",$nextPage, array('class'=>'link-class')); ?></dt>
</div>
</div>
</div>
</div> </div>
<?php echo $this->Form->end(); ?>