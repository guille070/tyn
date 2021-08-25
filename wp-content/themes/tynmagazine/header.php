<!DOCTYPE html>
<html class="wide wow-animation" <?php language_attributes() ?>>
    <head>
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">

        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri() ?>/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri() ?>/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri() ?>/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?php echo get_stylesheet_directory_uri() ?>/favicon/site.webmanifest">
        <link rel="mask-icon" href="<?php echo get_stylesheet_directory_uri() ?>/favicon/safari-pinned-tab.svg" color="#c9000a">
        <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ?>/favicon/favicon.ico">
        <meta name="msapplication-TileColor" content="#c9000a">
        <meta name="msapplication-config" content="<?php echo get_stylesheet_directory_uri() ?>/favicon/browserconfig.xml">
        <meta name="theme-color" content="#c9000a">

        <?php wp_head(); ?>

        <!--[if lt IE 10]>
        <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="<?php echo get_stylesheet_directory_uri() ?>/front/images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
        <script src="<?php echo get_stylesheet_directory_uri() ?>/front/js/html5shiv.min.js"></script>
        <![endif]-->

        <?php theme_options_scripts_head(); ?>
    </head>
    <body <?php body_class() ?>>

        <!-- Page -->
        <div class="text-center page">

            <?php theme_get_header(); ?>

        