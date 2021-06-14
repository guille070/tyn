<?php
/*
Template Name: TYN IOT NEWSLETTER
*/

$mes = array("", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
$fecha = date('d') . ' de ' .  $mes[date('n')] . ' de ' . date('Y');


$counter=0;

/* RECUPERAR POSTS DE TYN IOT */
switch_to_blog(11);
$args = array(			
			'post_status'	=> 'publish',
			'numberposts'	=> 50,
			'orderby'  => 'post_date',
			'order'=> 'DESC',			
			);

$myposts = get_posts( $args );
foreach( $myposts as $post ) :	setup_postdata($post);
	$idp= $post->ID;
	$tit[$counter]= get_the_title($idp);
	$url[$counter]= get_permalink($idp);	
	$preimage = wp_get_attachment_image_src( get_post_thumbnail_id($idp), 'thumbnail');
	$post_thumb[$counter]=$preimage[0];
	$preimage = wp_get_attachment_image_src( get_post_thumbnail_id($idp), array(450,315));
	$post_image[$counter]=$preimage[0];	
	$counter=$counter + 1;
endforeach;

restore_current_blog();

?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>Newsletter TyN</title>

<script>
var tit = [<?php echo '"' . $tit[0] . '","' . $tit[1] . '","' . $tit[2] . '","' . $tit[3] . '","' . $tit[4] . '","' . $tit[5] . '","' . $tit[6] . '","' . $tit[7] . '","' . $tit[8] . '","' . $tit[9] . '","' . $tit[10] . '","' . $tit[11] . '","' . $tit[12] . '","' . $tit[13] . '","' . $tit[14] . '","' . $tit[15] . '","' . $tit[16] . '","' . $tit[17] . '","' . $tit[18] . '","' . $tit[19]  . '","' . $tit[20] . '","' . $tit[21] . '","' . $tit[22] . '","' . $tit[23] . '","' . $tit[24] . '","' . $tit[25] . '","' . $tit[26] . '","' . $tit[27] . '","' . $tit[28] . '","' . $tit[29] . '","' . $tit[30] . '","' . $tit[31] . '","' . $tit[32] . '","' . $tit[33] . '","' . $tit[34] . '","' . $tit[35] . '","' . $tit[36] . '","' . $tit[37] . '","' . $tit[38] . '","' . $tit[39] . '","' . $tit[40] . '","' . $tit[41] . '","' . $tit[42] . '","' . $tit[43] . '","' . $tit[44] . '","' . $tit[45] . '","' . $tit[46] . '","' . $tit[47] . '","' . $tit[48] . '","' . $tit[49] . '","' . $tit[50] . '"';?>];
var url = [<?php echo '"' . $url[0] . '","' . $url[1] . '","' . $url[2] . '","' . $url[3] . '","' . $url[4] . '","' . $url[5] . '","' . $url[6] . '","' . $url[7] . '","' . $url[8] . '","' . $url[9] . '","' . $url[10] . '","' . $url[11] . '","' . $url[12] . '","' . $url[13] . '","' . $url[14] . '","' . $url[15] . '","' . $url[16] . '","' . $url[17] . '","' . $url[18] . '","' . $url[19]  . '","' . $url[20] . '","' . $url[21] . '","' . $url[22] . '","' . $url[23] . '","' . $url[24] . '","' . $url[25] . '","' . $url[26] . '","' . $url[27] . '","' . $url[28] . '","' . $url[29] . '","' . $url[30] . '","' . $url[31] . '","' . $url[32] . '","' . $url[33] . '","' . $url[34] . '","' . $url[35] . '","' . $url[36] . '","' . $url[37] . '","' . $url[38] . '","' . $url[39] . '","' . $url[40] . '","' . $url[41] . '","' . $url[42] . '","' . $url[43] . '","' . $url[44] . '","' . $url[45] . '","' . $url[46] . '","' . $url[47] . '","' . $url[48] . '","' . $url[49] . '"';?>];
var img = [<?php echo '"' . $post_image[0] . '","' . $post_image[1] . '","' . $post_image[2] . '","' . $post_image[3] . '","' . $post_image[4] . '","' . $post_image[5] . '","' . $post_image[6] . '","' . $post_image[7] . '","' . $post_image[8] . '","' . $post_image[9] . '","' . $post_image[10] . '","' . $post_image[11] . '","' . $post_image[12] . '","' . $post_image[13] . '","' . $post_image[14] . '","' . $post_image[15] . '","' . $post_image[16] . '","' . $post_image[17] . '","' . $post_image[18] . '","' . $post_image[19]  . '","' . $post_image[20] . '","' . $post_image[21] . '","' . $post_image[22] . '","' . $post_image[23] . '","' . $post_image[24] . '","' . $post_image[25] . '","' . $post_image[26] . '","' . $post_image[27] . '","' . $post_image[28] . '","' . $post_image[29] . '","' . $post_image[30] . '","' . $post_image[31] . '","' . $post_image[32] . '","' . $post_image[33] . '","' . $post_image[34] . '","' . $post_image[35] . '","' . $post_image[36] . '","' . $post_image[37] . '","' . $post_image[38] . '","' . $post_image[39] . '","' . $post_image[40] . '","' . $post_image[41] . '","' . $post_image[42] . '","' . $post_image[43] . '","' . $post_image[44] . '","' . $post_image[45] . '","' . $post_image[46] . '","' . $post_image[47] . '","' . $post_image[48] . '","' . $post_image[49] . '"';?>];
var thumb = [<?php echo '"' . $post_thumb[0] . '","' . $post_thumb[1] . '","' . $post_thumb[2] . '","' . $post_thumb[3] . '","' . $post_thumb[4] . '","' . $post_thumb[5] . '","' . $post_thumb[6] . '","' . $post_thumb[7] . '","' . $post_thumb[8] . '","' . $post_thumb[9] . '","' . $post_thumb[10] . '","' . $post_thumb[11] . '","' . $post_thumb[12] . '","' . $post_thumb[13] . '","' . $post_thumb[14] . '","' . $post_thumb[15] . '","' . $post_thumb[16] . '","' . $post_thumb[17] . '","' . $post_thumb[18] . '","' . $post_thumb[19]  . '","' . $post_thumb[20] . '","' . $post_thumb[21] . '","' . $post_thumb[22] . '","' . $post_thumb[23] . '","' . $post_thumb[24] . '","' . $post_thumb[25] . '","' . $post_thumb[26] . '","' . $post_thumb[27] . '","' . $post_thumb[28] . '","' . $post_thumb[29] . '","' . $post_thumb[30] . '","' . $post_thumb[31] . '","' . $post_thumb[32] . '","' . $post_thumb[33] . '","' . $post_thumb[34] . '","' . $post_thumb[35] . '","' . $post_thumb[36] . '","' . $post_thumb[37] . '","' . $post_thumb[38] . '","' . $post_thumb[39] . '","' . $post_thumb[40] . '","' . $post_thumb[41] . '","' . $post_thumb[42] . '","' . $post_thumb[43] . '","' . $post_thumb[44] . '","' . $post_thumb[45] . '","' . $post_thumb[46] . '","' . $post_thumb[47] . '","' . $post_thumb[48] . '","' . $post_thumb[49] . '"';?>];

</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="http://tynmagazine.com/newsletters/js/ZeroClipboard.js"></script>
<script language="JavaScript">
var clip = null;	

function init() {
clip = new ZeroClipboard.Client();
clip.addEventListener('mouseOver', my_mouse_click);
clip.glue('clip_button');
}

function my_mouse_click(client) {
clip.setText( document.getElementById('wrapper').innerHTML );
}
</script>

</head>
<body style="margin: 0; padding: 0;" onLoad="init()">

<div style="width: 100%; margin: 0; padding: 10px 0 10px; border-bottom: 2px #004F75 solid; position: fixed; top: 0; background: #fff; display: block; height: 120px">
<button id="clip_button" data-clipboard-target="wrapper">Copiar</button>

<table width="1000px" style="margin: 0 auto 0 auto; padding: 0;">
<tr>
<td width="500px">
<select id="Combo1" onchange="UpCombo1()">
<option value="0"><?=$tit[0];?></option>
<option value="1"><?=$tit[1];?></option>
<option value="2"><?=$tit[2];?></option>
<option value="3"><?=$tit[3];?></option>
<option value="4"><?=$tit[4];?></option>
<option value="5"><?=$tit[5];?></option>
<option value="6"><?=$tit[6];?></option>
<option value="7"><?=$tit[7];?></option>
<option value="8"><?=$tit[8];?></option>
<option value="9"><?=$tit[9];?></option>
<option value="10"><?=$tit[10];?></option>
<option value="11"><?=$tit[11];?></option>
<option value="12"><?=$tit[12];?></option>
<option value="13"><?=$tit[13];?></option>
<option value="14"><?=$tit[14];?></option>
<option value="15"><?=$tit[15];?></option>
<option value="16"><?=$tit[16];?></option>
<option value="17"><?=$tit[17];?></option>
<option value="18"><?=$tit[18];?></option>
<option value="19"><?=$tit[19];?></option>
<option value="20"><?=$tit[20];?></option>
<option value="21"><?=$tit[21];?></option>
<option value="22"><?=$tit[22];?></option>
<option value="23"><?=$tit[23];?></option>
<option value="24"><?=$tit[24];?></option>
<option value="25"><?=$tit[25];?></option>
<option value="26"><?=$tit[26];?></option>
<option value="27"><?=$tit[27];?></option>
<option value="28"><?=$tit[28];?></option>
<option value="29"><?=$tit[29];?></option>
<option value="30"><?=$tit[30];?></option>
<option value="31"><?=$tit[31];?></option>
<option value="32"><?=$tit[32];?></option>
<option value="33"><?=$tit[33];?></option>
<option value="34"><?=$tit[34];?></option>
<option value="35"><?=$tit[35];?></option>
<option value="36"><?=$tit[36];?></option>
<option value="37"><?=$tit[37];?></option>
<option value="38"><?=$tit[38];?></option>
<option value="39"><?=$tit[39];?></option>
<option value="40"><?=$tit[40];?></option>
<option value="41"><?=$tit[41];?></option>
<option value="42"><?=$tit[42];?></option>
<option value="43"><?=$tit[43];?></option>
<option value="44"><?=$tit[44];?></option>
<option value="45"><?=$tit[45];?></option>
<option value="46"><?=$tit[46];?></option>
<option value="47"><?=$tit[47];?></option>
<option value="48"><?=$tit[48];?></option>
<option value="49"><?=$tit[49];?></option>
<option value="50"><?=$tit[50];?></option>
</select>

</td>
<td width="500px">
<select id="Combo2" onchange="UpCombo2()">
<option value="0"><?=$tit[0];?></option>
<option value="1" selected><?=$tit[1];?></option>
<option value="2"><?=$tit[2];?></option>
<option value="3"><?=$tit[3];?></option>
<option value="4"><?=$tit[4];?></option>
<option value="5"><?=$tit[5];?></option>
<option value="6"><?=$tit[6];?></option>
<option value="7"><?=$tit[7];?></option>
<option value="8"><?=$tit[8];?></option>
<option value="9"><?=$tit[9];?></option>
<option value="10"><?=$tit[10];?></option>
<option value="11"><?=$tit[11];?></option>
<option value="12"><?=$tit[12];?></option>
<option value="13"><?=$tit[13];?></option>
<option value="14"><?=$tit[14];?></option>
<option value="15"><?=$tit[15];?></option>
<option value="16"><?=$tit[16];?></option>
<option value="17"><?=$tit[17];?></option>
<option value="18"><?=$tit[18];?></option>
<option value="19"><?=$tit[19];?></option>
<option value="20"><?=$tit[20];?></option>
<option value="21"><?=$tit[21];?></option>
<option value="22"><?=$tit[22];?></option>
<option value="23"><?=$tit[23];?></option>
<option value="24"><?=$tit[24];?></option>
<option value="25"><?=$tit[25];?></option>
<option value="26"><?=$tit[26];?></option>
<option value="27"><?=$tit[27];?></option>
<option value="28"><?=$tit[28];?></option>
<option value="29"><?=$tit[29];?></option>
<option value="30"><?=$tit[30];?></option>
<option value="31"><?=$tit[31];?></option>
<option value="32"><?=$tit[32];?></option>
<option value="33"><?=$tit[33];?></option>
<option value="34"><?=$tit[34];?></option>
<option value="35"><?=$tit[35];?></option>
<option value="36"><?=$tit[36];?></option>
<option value="37"><?=$tit[37];?></option>
<option value="38"><?=$tit[38];?></option>
<option value="39"><?=$tit[39];?></option>
<option value="40"><?=$tit[40];?></option>
<option value="41"><?=$tit[41];?></option>
<option value="42"><?=$tit[42];?></option>
<option value="43"><?=$tit[43];?></option>
<option value="44"><?=$tit[44];?></option>
<option value="45"><?=$tit[45];?></option>
<option value="46"><?=$tit[46];?></option>
<option value="47"><?=$tit[47];?></option>
<option value="48"><?=$tit[48];?></option>
<option value="49"><?=$tit[49];?></option>
<option value="50"><?=$tit[50];?></option>
</select>
</td>
</tr>
<tr>
<td width="500px">
<select id="Combo3" onchange="UpCombo3()">
<option value="0"><?=$tit[0];?></option>
<option value="1"><?=$tit[1];?></option>
<option value="2" selected><?=$tit[2];?></option>
<option value="3"><?=$tit[3];?></option>
<option value="4"><?=$tit[4];?></option>
<option value="5"><?=$tit[5];?></option>
<option value="6"><?=$tit[6];?></option>
<option value="7"><?=$tit[7];?></option>
<option value="8"><?=$tit[8];?></option>
<option value="9"><?=$tit[9];?></option>
<option value="10"><?=$tit[10];?></option>
<option value="11"><?=$tit[11];?></option>
<option value="12"><?=$tit[12];?></option>
<option value="13"><?=$tit[13];?></option>
<option value="14"><?=$tit[14];?></option>
<option value="15"><?=$tit[15];?></option>
<option value="16"><?=$tit[16];?></option>
<option value="17"><?=$tit[17];?></option>
<option value="18"><?=$tit[18];?></option>
<option value="19"><?=$tit[19];?></option>
<option value="20"><?=$tit[20];?></option>
<option value="21"><?=$tit[21];?></option>
<option value="22"><?=$tit[22];?></option>
<option value="23"><?=$tit[23];?></option>
<option value="24"><?=$tit[24];?></option>
<option value="25"><?=$tit[25];?></option>
<option value="26"><?=$tit[26];?></option>
<option value="27"><?=$tit[27];?></option>
<option value="28"><?=$tit[28];?></option>
<option value="29"><?=$tit[29];?></option>
<option value="30"><?=$tit[30];?></option>
<option value="31"><?=$tit[31];?></option>
<option value="32"><?=$tit[32];?></option>
<option value="33"><?=$tit[33];?></option>
<option value="34"><?=$tit[34];?></option>
<option value="35"><?=$tit[35];?></option>
<option value="36"><?=$tit[36];?></option>
<option value="37"><?=$tit[37];?></option>
<option value="38"><?=$tit[38];?></option>
<option value="39"><?=$tit[39];?></option>
<option value="40"><?=$tit[40];?></option>
<option value="41"><?=$tit[41];?></option>
<option value="42"><?=$tit[42];?></option>
<option value="43"><?=$tit[43];?></option>
<option value="44"><?=$tit[44];?></option>
<option value="45"><?=$tit[45];?></option>
<option value="46"><?=$tit[46];?></option>
<option value="47"><?=$tit[47];?></option>
<option value="48"><?=$tit[48];?></option>
<option value="49"><?=$tit[49];?></option>
<option value="50"><?=$tit[50];?></option>
</select>

</td>
<td width="500px">
<select id="Combo4" onchange="UpCombo4()">
<option value="0"><?=$tit[0];?></option>
<option value="1"><?=$tit[1];?></option>
<option value="2"><?=$tit[2];?></option>
<option value="3" selected><?=$tit[3];?></option>
<option value="4"><?=$tit[4];?></option>
<option value="5"><?=$tit[5];?></option>
<option value="6"><?=$tit[6];?></option>
<option value="7"><?=$tit[7];?></option>
<option value="8"><?=$tit[8];?></option>
<option value="9"><?=$tit[9];?></option>
<option value="10"><?=$tit[10];?></option>
<option value="11"><?=$tit[11];?></option>
<option value="12"><?=$tit[12];?></option>
<option value="13"><?=$tit[13];?></option>
<option value="14"><?=$tit[14];?></option>
<option value="15"><?=$tit[15];?></option>
<option value="16"><?=$tit[16];?></option>
<option value="17"><?=$tit[17];?></option>
<option value="18"><?=$tit[18];?></option>
<option value="19"><?=$tit[19];?></option>
<option value="20"><?=$tit[20];?></option>
<option value="21"><?=$tit[21];?></option>
<option value="22"><?=$tit[22];?></option>
<option value="23"><?=$tit[23];?></option>
<option value="24"><?=$tit[24];?></option>
<option value="25"><?=$tit[25];?></option>
<option value="26"><?=$tit[26];?></option>
<option value="27"><?=$tit[27];?></option>
<option value="28"><?=$tit[28];?></option>
<option value="29"><?=$tit[29];?></option>
<option value="30"><?=$tit[30];?></option>
<option value="31"><?=$tit[31];?></option>
<option value="32"><?=$tit[32];?></option>
<option value="33"><?=$tit[33];?></option>
<option value="34"><?=$tit[34];?></option>
<option value="35"><?=$tit[35];?></option>
<option value="36"><?=$tit[36];?></option>
<option value="37"><?=$tit[37];?></option>
<option value="38"><?=$tit[38];?></option>
<option value="39"><?=$tit[39];?></option>
<option value="40"><?=$tit[40];?></option>
<option value="41"><?=$tit[41];?></option>
<option value="42"><?=$tit[42];?></option>
<option value="43"><?=$tit[43];?></option>
<option value="44"><?=$tit[44];?></option>
<option value="45"><?=$tit[45];?></option>
<option value="46"><?=$tit[46];?></option>
<option value="47"><?=$tit[47];?></option>
<option value="48"><?=$tit[48];?></option>
<option value="49"><?=$tit[49];?></option>
<option value="50"><?=$tit[50];?></option>
</select>
</td>
</tr>

<tr>
<td width="500px">
<select id="Combo5" onchange="UpCombo5()">
<option value="0"><?=$tit[0];?></option>
<option value="1"><?=$tit[1];?></option>
<option value="2"><?=$tit[2];?></option>
<option value="3"><?=$tit[3];?></option>
<option value="4" selected><?=$tit[4];?></option>
<option value="5"><?=$tit[5];?></option>
<option value="6"><?=$tit[6];?></option>
<option value="7"><?=$tit[7];?></option>
<option value="8"><?=$tit[8];?></option>
<option value="9"><?=$tit[9];?></option>
<option value="10"><?=$tit[10];?></option>
<option value="11"><?=$tit[11];?></option>
<option value="12"><?=$tit[12];?></option>
<option value="13"><?=$tit[13];?></option>
<option value="14"><?=$tit[14];?></option>
<option value="15"><?=$tit[15];?></option>
<option value="16"><?=$tit[16];?></option>
<option value="17"><?=$tit[17];?></option>
<option value="18"><?=$tit[18];?></option>
<option value="19"><?=$tit[19];?></option>
<option value="20"><?=$tit[20];?></option>
<option value="21"><?=$tit[21];?></option>
<option value="22"><?=$tit[22];?></option>
<option value="23"><?=$tit[23];?></option>
<option value="24"><?=$tit[24];?></option>
<option value="25"><?=$tit[25];?></option>
<option value="26"><?=$tit[26];?></option>
<option value="27"><?=$tit[27];?></option>
<option value="28"><?=$tit[28];?></option>
<option value="29"><?=$tit[29];?></option>
<option value="30"><?=$tit[30];?></option>
<option value="31"><?=$tit[31];?></option>
<option value="32"><?=$tit[32];?></option>
<option value="33"><?=$tit[33];?></option>
<option value="34"><?=$tit[34];?></option>
<option value="35"><?=$tit[35];?></option>
<option value="36"><?=$tit[36];?></option>
<option value="37"><?=$tit[37];?></option>
<option value="38"><?=$tit[38];?></option>
<option value="39"><?=$tit[39];?></option>
<option value="40"><?=$tit[40];?></option>
<option value="41"><?=$tit[41];?></option>
<option value="42"><?=$tit[42];?></option>
<option value="43"><?=$tit[43];?></option>
<option value="44"><?=$tit[44];?></option>
<option value="45"><?=$tit[45];?></option>
<option value="46"><?=$tit[46];?></option>
<option value="47"><?=$tit[47];?></option>
<option value="48"><?=$tit[48];?></option>
<option value="49"><?=$tit[49];?></option>
<option value="50"><?=$tit[50];?></option>
</select>

</td>
<td width="500px">
<select id="Combo6" onchange="UpCombo6()">
<option value="0"><?=$tit[0];?></option>
<option value="1"><?=$tit[1];?></option>
<option value="2"><?=$tit[2];?></option>
<option value="3"><?=$tit[3];?></option>
<option value="4"><?=$tit[4];?></option>
<option value="5" selected><?=$tit[5];?></option>
<option value="6"><?=$tit[6];?></option>
<option value="7"><?=$tit[7];?></option>
<option value="8"><?=$tit[8];?></option>
<option value="9"><?=$tit[9];?></option>
<option value="10"><?=$tit[10];?></option>
<option value="11"><?=$tit[11];?></option>
<option value="12"><?=$tit[12];?></option>
<option value="13"><?=$tit[13];?></option>
<option value="14"><?=$tit[14];?></option>
<option value="15"><?=$tit[15];?></option>
<option value="16"><?=$tit[16];?></option>
<option value="17"><?=$tit[17];?></option>
<option value="18"><?=$tit[18];?></option>
<option value="19"><?=$tit[19];?></option>
<option value="20"><?=$tit[20];?></option>
<option value="21"><?=$tit[21];?></option>
<option value="22"><?=$tit[22];?></option>
<option value="23"><?=$tit[23];?></option>
<option value="24"><?=$tit[24];?></option>
<option value="25"><?=$tit[25];?></option>
<option value="26"><?=$tit[26];?></option>
<option value="27"><?=$tit[27];?></option>
<option value="28"><?=$tit[28];?></option>
<option value="29"><?=$tit[29];?></option>
<option value="30"><?=$tit[30];?></option>
<option value="31"><?=$tit[31];?></option>
<option value="32"><?=$tit[32];?></option>
<option value="33"><?=$tit[33];?></option>
<option value="34"><?=$tit[34];?></option>
<option value="35"><?=$tit[35];?></option>
<option value="36"><?=$tit[36];?></option>
<option value="37"><?=$tit[37];?></option>
<option value="38"><?=$tit[38];?></option>
<option value="39"><?=$tit[39];?></option>
<option value="40"><?=$tit[40];?></option>
<option value="41"><?=$tit[41];?></option>
<option value="42"><?=$tit[42];?></option>
<option value="43"><?=$tit[43];?></option>
<option value="44"><?=$tit[44];?></option>
<option value="45"><?=$tit[45];?></option>
<option value="46"><?=$tit[46];?></option>
<option value="47"><?=$tit[47];?></option>
<option value="48"><?=$tit[48];?></option>
<option value="49"><?=$tit[49];?></option>
<option value="50"><?=$tit[50];?></option>
</select>

</td>
</tr>
<tr>
<td width="500px">
<select id="Combo7" onchange="UpCombo7()">
<option value="0"><?=$tit[0];?></option>
<option value="1"><?=$tit[1];?></option>
<option value="2"><?=$tit[2];?></option>
<option value="3"><?=$tit[3];?></option>
<option value="4"><?=$tit[4];?></option>
<option value="5"><?=$tit[5];?></option>
<option value="6" selected><?=$tit[6];?></option>
<option value="7"><?=$tit[7];?></option>
<option value="8"><?=$tit[8];?></option>
<option value="9"><?=$tit[9];?></option>
<option value="10"><?=$tit[10];?></option>
<option value="11"><?=$tit[11];?></option>
<option value="12"><?=$tit[12];?></option>
<option value="13"><?=$tit[13];?></option>
<option value="14"><?=$tit[14];?></option>
<option value="15"><?=$tit[15];?></option>
<option value="16"><?=$tit[16];?></option>
<option value="17"><?=$tit[17];?></option>
<option value="18"><?=$tit[18];?></option>
<option value="19"><?=$tit[19];?></option>
<option value="20"><?=$tit[20];?></option>
<option value="21"><?=$tit[21];?></option>
<option value="22"><?=$tit[22];?></option>
<option value="23"><?=$tit[23];?></option>
<option value="24"><?=$tit[24];?></option>
<option value="25"><?=$tit[25];?></option>
<option value="26"><?=$tit[26];?></option>
<option value="27"><?=$tit[27];?></option>
<option value="28"><?=$tit[28];?></option>
<option value="29"><?=$tit[29];?></option>
<option value="30"><?=$tit[30];?></option>
<option value="31"><?=$tit[31];?></option>
<option value="32"><?=$tit[32];?></option>
<option value="33"><?=$tit[33];?></option>
<option value="34"><?=$tit[34];?></option>
<option value="35"><?=$tit[35];?></option>
<option value="36"><?=$tit[36];?></option>
<option value="37"><?=$tit[37];?></option>
<option value="38"><?=$tit[38];?></option>
<option value="39"><?=$tit[39];?></option>
<option value="40"><?=$tit[40];?></option>
<option value="41"><?=$tit[41];?></option>
<option value="42"><?=$tit[42];?></option>
<option value="43"><?=$tit[43];?></option>
<option value="44"><?=$tit[44];?></option>
<option value="45"><?=$tit[45];?></option>
<option value="46"><?=$tit[46];?></option>
<option value="47"><?=$tit[47];?></option>
<option value="48"><?=$tit[48];?></option>
<option value="49"><?=$tit[49];?></option>
<option value="50"><?=$tit[50];?></option>
</select>

</td>
<td width="500px">
<select id="Combo8" onchange="UpCombo8()">
<option value="0"><?=$tit[0];?></option>
<option value="1"><?=$tit[1];?></option>
<option value="2"><?=$tit[2];?></option>
<option value="3"><?=$tit[3];?></option>
<option value="4"><?=$tit[4];?></option>
<option value="5"><?=$tit[5];?></option>
<option value="6"><?=$tit[6];?></option>
<option value="7" selected><?=$tit[7];?></option>
<option value="8"><?=$tit[8];?></option>
<option value="9"><?=$tit[9];?></option>
<option value="10"><?=$tit[10];?></option>
<option value="11"><?=$tit[11];?></option>
<option value="12"><?=$tit[12];?></option>
<option value="13"><?=$tit[13];?></option>
<option value="14"><?=$tit[14];?></option>
<option value="15"><?=$tit[15];?></option>
<option value="16"><?=$tit[16];?></option>
<option value="17"><?=$tit[17];?></option>
<option value="18"><?=$tit[18];?></option>
<option value="19"><?=$tit[19];?></option>
<option value="20"><?=$tit[20];?></option>
<option value="21"><?=$tit[21];?></option>
<option value="22"><?=$tit[22];?></option>
<option value="23"><?=$tit[23];?></option>
<option value="24"><?=$tit[24];?></option>
<option value="25"><?=$tit[25];?></option>
<option value="26"><?=$tit[26];?></option>
<option value="27"><?=$tit[27];?></option>
<option value="28"><?=$tit[28];?></option>
<option value="29"><?=$tit[29];?></option>
<option value="30"><?=$tit[30];?></option>
<option value="31"><?=$tit[31];?></option>
<option value="32"><?=$tit[32];?></option>
<option value="33"><?=$tit[33];?></option>
<option value="34"><?=$tit[34];?></option>
<option value="35"><?=$tit[35];?></option>
<option value="36"><?=$tit[36];?></option>
<option value="37"><?=$tit[37];?></option>
<option value="38"><?=$tit[38];?></option>
<option value="39"><?=$tit[39];?></option>
<option value="40"><?=$tit[40];?></option>
<option value="41"><?=$tit[41];?></option>
<option value="42"><?=$tit[42];?></option>
<option value="43"><?=$tit[43];?></option>
<option value="44"><?=$tit[44];?></option>
<option value="45"><?=$tit[45];?></option>
<option value="46"><?=$tit[46];?></option>
<option value="47"><?=$tit[47];?></option>
<option value="48"><?=$tit[48];?></option>
<option value="49"><?=$tit[49];?></option>
<option value="50"><?=$tit[50];?></option>
</select>

</td>
</tr>
</table>
</div>
<!-- COMIENZO NEWSLETTER-->
<div id="wrapper" style="margin-top: 170px;">
<body style="margin: 0; padding: 0; height: 100%; width: 100%; background: #fff;">
<div style="margin: 0; padding: 0; background: #fff; height: 100%; width: 100%; font-family: Tahoma, Arial, Verdana, Helvetica, Ubuntu, Sans-serif">
<center>
<!--[if (gte mso 9)|(IE)]>
<table width="660" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td>
<![endif]-->
<table class="container" width="100%" cellpadding="2" cellspacing="2" style="max-width: 660px; background: #fff;">
    <tr>
        <td style="text-align: center; vertical-align: top" height="100">
            <!--[if (gte mso 9)|(IE)]>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
            <![endif]-->
            <div style="width: 310px; display: inline-block; vertical-align: top; height: 95px">
                <table width="100%" height="100%">
                    <tr>
						<td height="100" width="100%" valign="middle">
						<a href="http://www.tyniot.com" alt="TyN IoT Logo" target="_blank"><img src="http://tynmedia.com/newsletters/tyn/logo-iot.png"></a>
						</td>
					</tr> 
                </table>
            </div>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            <td>
            <![endif]-->
            <div style="width: 310px; display: inline-block; vertical-align: top; height: 95px">
                <table width="100%" height="90">
                    <tr>                        
							<td height="50%" style="font-size: 12px; text-transform: uppercase; font-weight: bold; font-family: Tahoma, Verdana, Helvetica, Ubuntu, Sans-serif;"><span id="fecha" style="float: right;"><?=$fecha;?></span></td>
							</tr>
							<tr>
							<td height="50%" valign="bottom" style="float: right;">
							<table border=0 cellpadding=2 cellspacing=0 align="right">
								<tr>
									<td><a href="https://www.facebook.com/tyniot" alt="TyN IoT en Facebook" target="_blank"><img src="http://tynmedia.com/newsletters/tyn/icons/facebook.png"></a></td>
									<td><a href="http://www.twitter.com/tyniot" alt="TyN IoT en Twitter" target="_blank"><img src="http://tynmedia.com/newsletters/tyn/icons/twitter.png"></a></td>
									<td><a href="http://plus.google.com/+Tyniotcom/posts" alt="TyN IoT en Google+" target="_blank"><img src="http://tynmedia.com/newsletters/tyn/icons/googleplus.png"></a></td>
									<td><a href="https://www.youtube.com/channel/UC1RtuzUEAFggqXDwGGZjwJw" alt="TyN Magazine en YouTube" target="_blank"><img src="http://tynmedia.com/newsletters/tyn/icons/youtube.png"></a></td>
									<td><a href="https://flipboard.com/section/tyn-magazine-bC3Tja" alt="TyN Magazine en Flipboard" target="_blank"><img src="http://tynmedia.com/newsletters/tyn/icons/flipboard.png"></a></td>
									<td><a href="https://www.linkedin.com/groups?home=&gid=2066535&trk=groups_most_recent-h-logo" alt="TyN Magazine en Linkedin" target="_blank"><img src="http://tynmedia.com/newsletters/tyn/icons/linkedin.png"></a></td>
									<td><a href="http://www.tyniot.com/feed" alt="Fedd RSS de TyN IoT" target="_blank"><img src="http://tynmedia.com/newsletters/tyn/icons/rss.png"></a></td>
								</tr>
							</table>
							</tr>
				</table>
            </div>
            <!--[if (gte mso 9)|(IE)]>
                    </td>
                </tr>
            </table>
            <![endif]-->
		</td>
	</tr>
	<tr>
        <td style="text-align: center; vertical-align: top;">
			
<!--[if (gte mso 9)|(IE)]>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
            <![endif]-->
            <div style="width: 320px; display: inline-block; vertical-align: top; margin-top: 3px;">
                <table width="310" height="300" bgcolor="#f6f6f6" valign="top">
					<tr>
                        <td height="95" valign="top" style="padding: 5px 5px 0 5px; width: 294px;">
						<h1 id="Titulo1" style="color: #004F75; text-align: left; font-size: 22px; font-family: Arial; font-weight: bold; line-height: 120%; margin: 0"><a style="color: #004F75" href="<?=$url[0];?>"><?=$tit[0];?></a></h1>
						</td>
					</tr>
					<tr>
						<td id="Imagen1" height="200px" valign="top" style="padding: 2px 5px 5px 5px;"><a style="color: #004F75" href="<?=$tit[0];?>"><img src="<?=$post_image[0];?>" width="297" height="208"/></a>
						</td>
                    </tr>
                </table>
            </div>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            <td>
            <![endif]-->
            <div style="width: 320px; display: inline-block; vertical-align: top; margin-top: 3px;">
                <table width="310" height="300" bgcolor="#f6f6f6" valign="top">
				<tr>
                        <td height="95" valign="top" style="padding: 5px 5px 0 5px; width: 294px;">
						<h1 id="Titulo2" style="color: #004F75; text-align: left; font-size: 22px; font-family: Arial; font-weight: bold; line-height: 120%; margin: 0"><a style="color: #004F75" href="<?=$url[1];?>"><?=$tit[1];?></a></h1>
						</td>
					</tr>
					<tr>
						<td id="Imagen2" height="200px" valign="top" style="padding: 2px 5px 5px 5px;"><a href="<?=$url[1];?>"><img src="<?=$post_image[1];?>" width="297" height="208"/></a>
						</td>
                    </tr>
                </table>
            </div>
            <!--[if (gte mso 9)|(IE)]>
                    </td>
                </tr>
            </table>
            <![endif]-->
			</td>
	</tr>
	<tr>
        <td style="text-align: center; vertical-align: top;">
<!--[if (gte mso 9)|(IE)]>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
            <![endif]-->
            <div style="width: 320px; display: inline-block; vertical-align: top; margin-top: 3px;">
                <table width="100%">
                    <tr>
                        <td style="text-aling: center;"><a href='http://104.131.142.242/adserver/www/delivery/ck.php?zoneid=103' target='_blank'><img src='http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=103&amp;cb=INSERT_RANDOM_NUMBER_HERE' border='0' alt='' style="width: 300px; height: 250px;"></a></td>
                    </tr>
                </table>
            </div>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            <td>
            <![endif]-->
            <div style="width: 320px; display: inline-block; vertical-align: top; margin-top: 3px;">
                <table width="310" height="300" bgcolor="#f6f6f6" valign="top">                    
					<tr>
                        <td height="95" valign="top" style="padding: 5px 5px 0 5px;">
						<h1 id="Titulo3" style="color: #004F75; text-align: left; font-size: 22px; font-family: Arial; font-weight: bold; line-height: 120%; margin: 0"><a style="color: #004F75" href="<?=$url[2];?>"><?=$tit[2];?></a></h1></td></tr>
					<tr>
						<td id="Imagen3" height="200px" valign="top" style="padding: 2px 5px 5px 5px;"><a href="<?=$url[2];?>"><img src="<?=$post_image[2];?>" width="297" height="208"/></a>
						</td>
                    </tr>
                </table>
            </div>
            <!--[if (gte mso 9)|(IE)]>
                    </td>
                </tr>
            </table>
            <![endif]-->
		</td>
	</tr>
	<tr>
        <td style="text-align: center; vertical-align: top;">
<!--[if (gte mso 9)|(IE)]>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
            <![endif]-->
            <div style="width: 320px; display: inline-block; vertical-align: top; margin-top: 3px;">
                <table width="310" height="300" bgcolor="#f6f6f6" valign="top">                    
					<tr>
                        <td height="95" valign="top" style="padding: 5px 5px 0 5px;">
							<h1 id="Titulo4" style="color: #004F75; text-align: left; font-size: 22px; font-family: Arial; font-weight: bold; line-height: 120%; margin: 0"><a style="color: #004F75" href="<?=$url[3];?>"><?=$tit[3];?></a></h1></td></tr>
							<tr><td id="Imagen4" height="200px" valign="top" style="padding: 2px 5px 5px 5px;"><a href="<?=$url[3];?>"><img src="<?=$post_image[3];?>" width="297" height="208"/></a>
						</td>
                    </tr>
                </table>
            </div>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            <td>
            <![endif]-->
            <div style="width: 320px; display: inline-block; vertical-align: top; margin-top: 3px;">
                <table width="100%">
                    <tr>
                        <td style="text-aling: center;"><a href='http://104.131.142.242/adserver/www/delivery/ck.php?zoneid=104' target='_blank'><img src='http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=104&amp;cb=INSERT_RANDOM_NUMBER_HERE' border='0' alt='' style="width: 300px; height: 250px;"></a></td>
                    </tr>
                </table>
            </div>
            <!--[if (gte mso 9)|(IE)]>
                    </td>
                </tr>
            </table>
            <![endif]-->
			</td>
	</tr>
	<tr>
        <td style="text-align: center; vertical-align: top;">
<!--[if (gte mso 9)|(IE)]>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
            <![endif]-->
            <div style="width: 320px; display: inline-block; vertical-align: top; margin-top: 3px;">
                <table style="width: 310px; vertical-align: top; font-family: Tahoma, Verdana, Helvetica, Ubuntu, Sans-serif; font-weight: bold; font-size: 14px;" cellpadding="2" bgcolor="#f6f6f6">
				<tr>
					<td id="Imagen5" height="60" valign="top" style="width: 60px; text-align: left"><a href="<?=$url[4];?>"><img src="<?=$post_thumb[4];?>" width="60" height="60"></a></td>
					<td id="Titulo5" height="60" valign="top" style="width: 260px; text-align: left"><a style="color: #004F75" href="<?=$url[4];?>"><span id="Titulo5" style="color: #004F75"><?=$tit[4];?></span></a></td>
				</tr>
				<tr>
					<td id="Imagen6" height="60" valign="top" style="width: 60px; text-align: left"><a href="<?=$url[5];?>"><img src="<?=$post_thumb[5];?>" width="60" height="60"></a></td>
					<td id="Titulo6" height="60" valign="top" style="width: 260px; text-align: left"><a style="color: #004F75" href="<?=$url[5];?>"><span id="Titulo6" style="color: #004F75"><?=$tit[5];?></span></a></td>
				</tr>
				<tr>
					<td id="Imagen7" height="60" valign="top" style="width: 60px; text-align: left"><a href="<?=$url[6];?>"><img src="<?=$post_thumb[6];?>" width="60" height="60"></a></td>
					<td id="Titulo7" height="60" valign="top" style="width: 260px; padding: 0 5px 0 5px; text-align: left"><a style="color: #004F75" href="<?=$url[6];?>"><span id="Titulo7" style="color: #004F75"><?=$tit[6];?></span></a></td>
				</tr>
				<tr>
					<td id="Imagen8" height="60" valign="top" style="width: 60px; text-align: left"><a href="<?=$url[7];?>"><img src="<?=$post_thumb[7];?>" width="60" height="60"></a></td>
					<td id="Titulo8" height="60" valign="top" style="width: 260px; height: 25%; text-align: left"><a style="color: #004F75" href="<?=$url[7];?>"><span id="Titulo8" style="color: #004F75"><?=$tit[7];?></span></a></td>
				</tr>
			</table>
            </div>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            <td>
            <![endif]-->
            <div style="width: 320px; display: inline-block; vertical-align: middle;">
                <table width="100%">
                    <tr>
                        <td align="center"><a href='http://104.131.142.242/adserver/www/delivery/ck.php?zoneid=105' target='_blank'><img src='http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=105&amp;cb=INSERT_RANDOM_NUMBER_HERE' border='0' alt='' style="width: 300px; height: 250px;"></a></td>
                    </tr>
                </table>
            </div>
            <!--[if (gte mso 9)|(IE)]>
                    </td>
                </tr>
            </table>
            <![endif]-->
			</td>
	</tr>
	<tr>
        <td style="text-align: center; vertical-align: top;">
<!--[if (gte mso 9)|(IE)]>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
            <![endif]-->
            <div style="width: 320px; display: inline-block; vertical-align: top;">
                <table width="310">
                    <tr>
                        <td align="center">
						<p style="margin:0; padding: 0; width: 100%; display: block; font-size: 12px; font-weight: bold; margin-bottom: 5px;">UNA PUBLICACI&Oacute;N DE</p>
						<img src="http://tynmedia.com/newsletters/tyn/tynmedia-footer.png"></a>
						</td>
                    </tr>
                </table>
            </div>
            <!--[if (gte mso 9)|(IE)]>
            </td>
            <td>
            <![endif]-->
            <div style="width: 320px; display: inline-block; vertical-align: top;">
                <table width="310">
                    <tr>
                        <td align="center">
						<p style="margin:0; padding: 0; width: 100%; display: block; font-size: 12px;"><b>RED DE SITIOS</b>&nbsp;
						<a style="color: #004F75" href="http://www.tynmagazine.com/" target="blank"><span style="color: #004F75">TYN MAGAZINE</a></span>
						<span style="color: #000">&nbsp;&bull;&nbsp;</span>
						<a style="color: #004F75" href="http://www.tynchannel.com/" target="blank"><span style="color: #004F75">TYN CHANNEL</a>
						<span style="color: #000">&nbsp;&bull;&nbsp;</span>
						<a style="color: #004F75" href="http://www.tyniot.com/" target="blank"><span style="color: #004F75">TYN IoT</span></a>
						<span style="color: #000">&nbsp;&bull;&nbsp;</span>
						<a style="color: #004F75" href="http://www.tynmobile.com/" target="blank"><span style="color: #004F75">TYN MOBILE</span></a>
						<span style="color: #000">&nbsp;&bull;&nbsp;</span>
						<a style="color: #004F75" href="http://www.tynsecurity.com/" target="blank"><span style="color: #004F75">TYN SECURITY</span></a>
						<span style="color: #000">&nbsp;&bull;&nbsp;</span>
						<a style="color: #004F75" href="http://www.tyninvestment.com/" target="blank"><span style="color: #004F75">TYN INVESTMENT</span></a>
						<span style="color: #000">&nbsp;&bull;&nbsp;</span>
						<a style="color: #004F75" href="http://www.tyncloud.com/" target="blank"><span style="color: #004F75">TYN CLOUD</span></a>
						<span style="color: #000">&nbsp;&bull;&nbsp;</span>
						<a style="color: #004F75" href="http://www.tynentrepreneurs.com/" target="blank"><span style="color: #004F75">TYN ENTREPRENEURS</span></a>
						<span style="color: #000">&nbsp;&bull;&nbsp;</span>
						<a style="color: #004F75" href="http://www.tyninvestment.com/" target="blank"><span style="color: #004F75">TYN MOBILE MONEY</span></a>
						<span style="color: #000">&nbsp;&bull;&nbsp;</span>
						<a style="color: #004F75" href="http://www.tynmobilemoney.com/" target="blank"><span style="color: #004F75">TYN BRASIL</span></a></p>
						</td>
                    </tr>
                </table>
            </div>
            <!--[if (gte mso 9)|(IE)]>
                    </td>
                </tr>
            </table>
            <![endif]-->
        </td>
    </tr>
</table>
<!--[if (gte mso 9)|(IE)]>
        </td>
    </tr>
</table>
<![endif]-->
</center>
</div>
</body>
</div>
<!-- FIN NEWSLETTER-->

<script>
function UpCombo1()
{
var e = document.getElementById("Combo1");
var SelCombo1 = e.options[e.selectedIndex].value;
document.getElementById("Titulo1").innerHTML = '<a style="color: #004F75" href="' + url[SelCombo1] + '">' + tit[SelCombo1] + '</a>';
document.getElementById("Imagen1").innerHTML = '<a href="' + url[SelCombo1] + '">' +'<img src="' + img[SelCombo1] + '" style="width: 100%"></a>';
}


function UpCombo2()
{
var e = document.getElementById("Combo2");
var SelCombo2 = e.options[e.selectedIndex].value;
document.getElementById("Titulo2").innerHTML = '<a style="color: #004F75" href="' + url[SelCombo2] + '">' + tit[SelCombo2] + '</a>';
document.getElementById("Imagen2").innerHTML = '<a href="' + url[SelCombo2] + '">' +'<img src="' + img[SelCombo2] + '" style="width: 100%"></a>';
}

function UpCombo3()
{
var e = document.getElementById("Combo3");
var SelCombo3 = e.options[e.selectedIndex].value;
document.getElementById("Titulo3").innerHTML = '<a style="color: #004F75" href="' + url[SelCombo3] + '">' + tit[SelCombo3] + '</a>';
document.getElementById("Imagen3").innerHTML = '<a href="' + url[SelCombo3] + '">' +'<img src="' + img[SelCombo3] + '" style="width: 100%"></a>';
}


function UpCombo4()
{
var e = document.getElementById("Combo4");
var SelCombo4 = e.options[e.selectedIndex].value;
document.getElementById("Titulo4").innerHTML = '<a style="color: #004F75" href="' + url[SelCombo4] + '">' + tit[SelCombo4] + '</a>';
document.getElementById("Imagen4").innerHTML = '<a href="' + url[SelCombo4] + '">' +'<img src="' + img[SelCombo4] + '" style="width: 100%"></a>';
}

function UpCombo5()
{
var e = document.getElementById("Combo5");
var SelCombo5 = e.options[e.selectedIndex].value;
document.getElementById("Titulo5").innerHTML = '<a style="color: #004F75" href="' + url[SelCombo5] + '">' + tit[SelCombo5] + '</a>';
document.getElementById("Imagen5").innerHTML = '<a href="' + url[SelCombo5] + '"><img src="' + thumb[SelCombo5] + '" style="width: 100%"></a>';
}


function UpCombo6()
{
var e = document.getElementById("Combo6");
var SelCombo6 = e.options[e.selectedIndex].value;
document.getElementById("Titulo6").innerHTML = '<a style="color: #004F75" href="' + url[SelCombo6] + '">' + tit[SelCombo6] + '</a>';
document.getElementById("Imagen6").innerHTML = '<a href="' + url[SelCombo6] + '"><img src="' + thumb[SelCombo6] + '" style="width: 100%"></a>';
}

function UpCombo7()
{
var e = document.getElementById("Combo7");
var SelCombo7 = e.options[e.selectedIndex].value;
document.getElementById("Titulo7").innerHTML = '<a style="color: #004F75" href="' + url[SelCombo7] + '">' + tit[SelCombo7] + '</a>';
document.getElementById("Imagen7").innerHTML = '<a href="' + url[SelCombo7] + '"><img src="' + thumb[SelCombo7] + '" style="width: 100%"></a>';
}


function UpCombo8()
{
var e = document.getElementById("Combo8");
var SelCombo8 = e.options[e.selectedIndex].value;
document.getElementById("Titulo8").innerHTML = '<a style="color: #004F75" href="' + url[SelCombo8] + '">' + tit[SelCombo8] + '</a>';
document.getElementById("Imagen8").innerHTML = '<a href="' + url[SelCombo8] + '"><img src="' + thumb[SelCombo8] + '" style="width: 100%"></a>';
}


</script>