<?php
 /* 
 
 Template Name: staff
 
 */
 
include 'header.php';?>
	<div class="site-content-inner">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
<div class="cat-links"><span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href ="<?=$site_url;?>"><span itemprop="title">Portada</span></a></span>&nbsp;&raquo;&nbsp;<span itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href ="<?=$site_url;?>/contacto/"><span itemprop="title">Contacto</span></a></span></div>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header class="header">
<h1 class="entry-title"><?php the_title(); ?></h1>
</header>
<div style="width: 300px; display: inline-block; margin: 0 auto 1% auto; border: 1px #000 solid;">
<?php 
$img=get_avatar('gustavom@tynmagazine.com', 300);
//$img='http://200.58.118.238/banners/www/images/10bc57240be2d04628c0f0ea38b4a400.jpg';

?>
	<div style="text-align: center; margin: 0 auto 15px auto; width: 150px; height: 150px; border-radius: 100px; -webkit-border-radius: 350px; -moz-border-radius: 350px;	background: url('<?php echo get_avatar('gustavom@tynmagazine.com', 300);?>')  no-repeat; display: block;"></div>
	<h3>Gustavo Martínez</h3>
	<p>Editorial Manger & Founder</br>gustavom@tynmagazine.com</p>

</div>

</article>
	</main><!-- #main -->
		</div><!-- #primary -->
		
<aside id="sidebar2" role="complementary">
<div id="primary" class="widget-area">
<ul class="xoxo">
<?php include $basedir . $idsitio . '/ads2/home-banner-1.txt';?>
<article class="hentry">
<h1 class="widget-title">Ranking de art&iacute;culos</h1>
<?php include get_basedir() . get_sitio() . '/widgets/tabs.php';?>
</article>
<?php include $basedir . $idsitio . '/ads2/home-banner-2.txt';?>
<article class="hentry">
<h1 class="widget-title">Suscribir al newsletter</h1>
<?php include 'form-envialo.php';?>
</article>
<?php include $basedir . $idsitio . '/ads2/home-banner-3.txt';?>
<article class="hentry">
<h1 class="widget-title">Encuesta</h1>
<?php get_poll(); ?>
</article>
<?php include $basedir . $idsitio . '/ads2/home-banner-4.txt';?>
<?php include $basedir . $idsitio . '/ads2/home-banner-5.txt';?>
</ul>
</div>
</aside>		

	</div><!-- .site-content-inner -->

<?php include 'footer.php'; //get_footer(); ?>
