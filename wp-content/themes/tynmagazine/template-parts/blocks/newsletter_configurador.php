<?php

/**
 * Newsletter Configurador Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

setlocale(LC_ALL, 'es_ES');
$fecha = strftime("%e de %B de %Y");
$logo = get_field('img_logo_newsletter', 'option');
$rel_notas = get_field('rel_notas');
$rel_banners = get_field('rel_banners');
?>

<?php if (! is_admin() ){ ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<?php } ?>

<script type="text/javascript">
    function copyToClipboard(element) {
        var $temp = jQuery("<input>");
        jQuery("body").append($temp);
        $temp.val(jQuery(element).html()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>
    
<div style="width: 100%; margin: 0; padding: 10px 0 10px; border-bottom: 2px #c9000a solid; top: 0; background: #fff; display: block; text-align: center;">

    <button onclick="copyToClipboard('#wrapper')">Copiar Newsletter TYN</button>

</div>

<!-- COMIENZO NEWSLETTER-->
<div id="wrapper" style="margin-top: 90px;">
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
						    <a href="<?php echo home_url( '/' ); ?>" target="_blank"><img src="<?php echo $logo['url']; ?>" alt="TyN Magazine Logo"></a>
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
                        <td height="50%" style="font-size: 12px; text-transform: uppercase; font-weight: bold; font-family: Tahoma, Verdana, Helvetica, Ubuntu, Sans-serif;"><span id="fecha" style="float: right;"><?php echo $fecha; ?></span></td>
                        </tr>
                        <tr>
                        <td height="50%" valign="bottom" style="float: right;">
                        <table border=0 cellpadding=2 cellspacing=0 align="right">
                            <tr>
                                <td><a href="http://www.facebook.com/tynmagazine" alt="TyN Magazine en Facebook" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/newsletters/tyn/icons/facebook.png"></a></td>
                                <td><a href="http://www.twitter.com/tynmagazine" alt="TyN Magazine en Twitter" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/newsletters/tyn/icons/twitter.png"></a></td>
                                <td><a href="https://www.youtube.com/channel/UC1RtuzUEAFggqXDwGGZjwJw" alt="TyN Magazine en YouTube" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/newsletters/tyn/icons/youtube.png"></a></td>
                                <td><a href="https://www.linkedin.com/company/tyn-media-group/" alt="TyN Magazine en Linkedin" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/newsletters/tyn/icons/linkedin.png"></a></td>
                                <td><a href="http://www.tynmagazine.com/feed" alt="Fedd RSS de TyN Magazine" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/newsletters/tyn/icons/rss.png"></a></td>
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

    <?php if (!empty($rel_notas)) {

        $i=0;

        foreach($rel_notas as $post_id) { ?>

            <?php if ( $i%2==0 ) { ?>
                <tr>
                <td style="text-align: center; vertical-align: top;">

                <!--[if (gte mso 9)|(IE)]>
                <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td>
                <![endif]-->

                <?php echo theme_print_newsletter_html( $post_id ); ?>

            <?php } ?>

                <?php if ( $i%2==0 ) { ?>
                    <!--[if (gte mso 9)|(IE)]>
                    </td><![endif]-->
                <?php } ?>

                <?php if ( $i%2!==0 ) { ?>
                    <!--[if (gte mso 9)|(IE)]>
                    <td><![endif]-->

                    <?php echo theme_print_newsletter_html( $post_id ); ?>
                    
                <?php } ?>

                <?php if ( $i%2!==0 ) { ?>
                    <!--[if (gte mso 9)|(IE)]>
                    </td><![endif]-->
                <?php } ?>

            <?php if ( ( $i%2!==0 ) || $i == (count($rel_notas)-1) ) { ?>
                    <!--[if (gte mso 9)|(IE)]>
                    </tr>
                    </table>
                    <![endif]-->
                    </td>
                </tr>
            <?php } ?>

            <?php 
            $i++;

        } ?>

    <?php } ?>

    <?php if (!empty($rel_banners)) {
        
        $i=0;

        foreach($rel_banners as $banner_id) { ?>

            <?php if ( $i%2==0 ) { ?>
                <tr>
                <td style="text-align: center; vertical-align: top;">

                <!--[if (gte mso 9)|(IE)]>
                <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td>
                <![endif]-->

                <?php echo theme_print_newsletter_banner( $banner_id ); ?>

            <?php } ?>

                <?php if ( $i%2==0 ) { ?>
                    <!--[if (gte mso 9)|(IE)]>
                    </td><![endif]-->
                <?php } ?>

                <?php if ( $i%2!==0 ) { ?>
                    <!--[if (gte mso 9)|(IE)]>
                    <td><![endif]-->

                    <?php echo theme_print_newsletter_banner( $banner_id ); ?>
                    
                <?php } ?>

                <?php if ( $i%2!==0 ) { ?>
                    <!--[if (gte mso 9)|(IE)]>
                    </td><![endif]-->
                <?php } ?>

            <?php if ( ( $i%2!==0 ) || $i == (count($rel_banners)-1) ) { ?>
                    <!--[if (gte mso 9)|(IE)]>
                    </tr>
                    </table>
                    <![endif]-->
                    </td>
                </tr>
            <?php } ?>

            <?php 
            $i++;

        } ?>

    <?php } ?>
		
	<tr>
        <td style="text-align: center; vertical-align: top;">
        <!--[if (gte mso 9)|(IE)]>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
            <![endif]-->
            
			<p style="margin:0; padding: 0; width: 100%; display: block; font-size: 12px; font-weight: bold; margin-bottom: 5px;">UNA PUBLICACI&Oacute;N DE</p>
			<img src="<?php echo get_template_directory_uri(); ?>/newsletters/tyn/tynmedia-footer.png"></a>
						
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