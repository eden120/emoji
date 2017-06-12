<div class="main" style="height:90%;">
<div class="text-div-2nd-page">
If your photos are ready, please indicate below where they are located. Once you have located 
your photos and imported them into "Care for My Stuff", each photo will appear on its own page
where you will be able to check off various pieces of information and in your own words 
describe the significance of the item being shown.</div>

<div class="text-div-2nd-page">

You should "title" the item in such a way that it will be identifiable when it appears on the 
alphabetically arranged table of contents. e.g., avoid starting titles with "a" or "the".</div>
<div class="empty"></div>
<div class="iphone-pick-upload">
<div class="iphone-div1">
BROWSE FOR PHOTOS 
</div>
<div class="iphone-div2">
<!--<div class="input-class"> 
<div class="input-box1">
<input name="" type="file" />
</div>
</div>-->

<div id="mulitplefileuploader">Upload</div>
<div id="status"></div>

</div>
</div>
<div style="clear:both"></div>
<span class="text-div-2nd-page" style="font-style:italic; font-size:18px;">You can select multiple pictures to load into photo pages by placing cursor on each selected individual photo, depress and hold CTRL key and then "left click"  You can do this operation for all photos you wish to transfer and then all will be transferred together.</span>




<div class="next-button-box">
<div class="next-button">
<?php echo $this->Html->link("Go To Next Page >","/pages/list_pages"); ?>
</div>
</div>
<div class="empty"></div>
</div>
<script>
$(document).ready(function()
{
var settings = {
    url: base_url+"pages/upload_pics",
    dragDrop:true,
    fileName: "myFile",
	multiple: true,
    allowedTypes:"jpg,png,gif,jpeg",	
    returnType:"json",
	onSuccess:function(files,data,xhr)
    {
        alert((data));
    },
    showDelete:false
}
var uploadObj = $("#mulitplefileuploader").uploadFile(settings);


});
</script>