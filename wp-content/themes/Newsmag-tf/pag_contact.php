<?php
 /* 
 
 Template Name: Contacto 2
 
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
				<div itemscope itemtype="http://schema.org/Corporation">
				<h1 itemprop="name">TyN Media Group Argentina</h1><br/>
				<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
				<span itemprop="streetAddress">Estados Unidos 3765</span> PB 3. <span itemprop="addressLocality">Ciudad de Buenos Aires</span><br/>
				Código postal (<span itemprop="postalCode">C1228ABO</span>). <span itemprop="addressCountry">Argentina</span><br/>
				Teléfonos: <span itemprop="telephone">+5411 3526-2690</span> / <span itemprop="telephone">+5411 4956-0948</p></p>
				</span>
				</div>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3283.2719839728798!2d-58.420830885010005!3d-34.62256646600216!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcca560d1a5ce3%3A0x80d2f5b49dc72d6f!2sEstados+Unidos+3765%2C+C1228ABO+CABA!5e0!3m2!1ses!2sar!4v1449597760721" width="100%" frameborder="0" width="320" height="320" frameborder="0" style="border:0"></iframe></center>
				<div itemscope itemtype="http://schema.org/Corporation">
				<h1 itemprop="name">TyN Media Group Panamá</h1><br/>
				<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
				<span itemprop="streetAddress">Ave. S. Lewis y Calle Santa Rita, Edificio Plaza Obarrio, 3° Of. 308</span>. Ciudad de <span itemprop="addressLocality">Panamá</span><br/>Apartado Postal <span itemprop="postOfficeBoxNumber">0816.06724</span>. <span itemprop="addressCountry">Panamá</span><br/>
				Teléfono: <span itemprop="telephone">+507 264-5074</p>
				</span>
				</div>
				<center><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.808717300886!2d-79.51623199999999!3d8.989741999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8faca8fde37b46cb%3A0xa1b3c6379bfbc430!2sAve.+Samuel+Lewis!5e0!3m2!1ses!2s!4v1418742803891" width="100%" frameborder="0" width="320" height="320" frameborder="0" style="border:0"></iframe></center>
				
				<h1>Contáctenos</h1>
				<p>Complete el siguiente formulario con sus datos y su mensaje. Le responderemos a la brevedad.</p>
				<?php echo do_shortcode("[contact-form to='gustavom@tynmagazine.com' subject='Contacto desde la Web'][contact-field label='Nombre' type='name' required='1'/][contact-field label='Correo electrónico' type='email' required='1'/][contact-field label='Mensaje' type='textarea' required='1'/][/contact-form]");?>

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
