<?php
/*
Template Name: TYN NEWSLETTER 3
*/

if ( ! is_user_logged_in() ) wp_redirect( home_url() );
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Newsletter TyN</title>
    <meta name="robots" content="noindex, nofollow" />
</head>
<body style="margin: 0; padding: 0;">

<?php while(have_posts()) { the_post();
the_content();
} ?>

</body>
</html>