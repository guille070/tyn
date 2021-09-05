<!-- intersitial -->
<?php //if (is_super_admin()) {
//$theme_url=get_bloginfo('stylesheet_directory');

if(!isset($_COOKIE['tyn_popup'])) {
setcookie('tyn_popup', true, time()+288000);
$theme_url=get_bloginfo('stylesheet_directory');


?>
<link href="<?=$theme_url;?>/jquery.interstitial.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js" type="text/javascript"></script> 
<script src="<?=$theme_url;?>/jquery.interstitial.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
var $wwidth = $("body").innerWidth();
var $wheight = $("body").innerHeight();

if ($wwidth > 1024){
	$pwidth=1024;
	$pheight=620;
	$link="http://www.tynmagazine.com/popup-tynmag/?res=1024";
	} else if (($wwidth > 759) && ($wwidth < 1199)) {
	$pwidth=760;
	$pheight=480;
	$link="http://www.tynmagazine.com/popup-tynmag/?res=760";
	}else{
	$pwidth=300;
	$pheight=480;
	$link="http://www.tynmagazine.com/popup-tynmag/?res=320";
}


$().interstitial('open', {
'url':$link,
'width':$pwidth,
'height':$pheight
});
});
</script>
<?php }?>