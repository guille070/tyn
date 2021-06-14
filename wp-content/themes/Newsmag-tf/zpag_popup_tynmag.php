<?php
 /* 
 
 Template Name: Popup TyN Magazine
 
 */
$res=intval(($_GET['res']));
 
if ($res==1024) {
$iframe='<iframe style="margin:0;padding:0;float:left;display:block;" id="a5acbf88" name="a5acbf88" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=251&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="1024" height="586"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a895e131&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=251&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a895e131" border="0" alt="" /></a></iframe>';
}else if ($res==760) {
$iframe='<iframe style="margin:0;padding:0;float:left;display:block;" id="a6ee0b0d" name="a6ee0b0d" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=252&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="760" height="467"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a3cb1cbc&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=252&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a3cb1cbc" border="0" alt="" /></a></iframe>';
}else{
$iframe='<iframe style="margin:0;padding:0;float:left;display:block;" id="abc3242d" name="abc3242d" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=253&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="460"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=aa08179f&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=253&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=aa08179f" border="0" alt="" /></a></iframe>';
}?>
<div style="text-align:right;margin:5px;width:98%;box-sizing:border-box;display:block"><a href="#" onClick="javascript:$().interstitial('close'); return false">CERRAR VENTANA</a></div>
<div style="display:block;width:100%;overflow:hidden;float:left">
<?=$iframe;?>
</div>
