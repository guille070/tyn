<?php
/*  ----------------------------------------------------------------------------
    footer info content
 */

$td_footer_logo = td_util::get_option('tds_footer_logo_upload');
$td_footer_retina_logo = td_util::get_option('tds_footer_retina_logo_upload');
$td_top_logo = td_util::get_option('tds_logo_upload');
$td_top_retina_logo = td_util::get_option('tds_logo_upload_r');
$td_footer_text = td_util::get_option('tds_footer_text');
$td_footer_email = td_util::get_option('tds_footer_email');

$buffy = '';

$buffy .= '<div class="td-footer-info td-pb-padding-side">';

    // footer logo
    $buffy .= '<div class="footer-logo-wrap">';
        if (!empty($td_footer_logo)) { // if have footer logo
            if (empty($td_footer_retina_logo)) { // if don't have a retina footer logo load the normal logo
                $buffy .= '<a href="' . esc_url(home_url( '/' )) . '"><img src="' . $td_footer_logo . '" alt=""/></a>';
            } else {
                $buffy .= '<a href="' . esc_url(home_url( '/' )) . '"><img class="td-retina-data" src="' . $td_footer_logo . '" data-retina="' . esc_attr($td_footer_retina_logo) . '" alt=""/></a>';
            }
        } else { // if you don't have a footer logo load the top logo
            if (empty($td_top_retina_logo)) {
                $buffy .= '<a href="' . esc_url(home_url( '/' )) . '"><img src="' . $td_top_logo . '" alt=""/></a>';
            } else {
                $buffy .= '<a href="' . esc_url(home_url( '/' )) . '"><img class="td-retina-data" src="' . $td_top_logo . '" data-retina="' . esc_attr($td_top_retina_logo) . '" alt=""/></a>';
            }
        }
    $buffy .= '</div>';

    // footer text
    $buffy .= '<div class="footer-text-wrap">';
        $buffy .= stripslashes($td_footer_text);

        if (!empty($td_footer_email)) {
            $buffy .= '<div class="footer-email-wrap">';
            $buffy .= __td('Contact us') . ': <a href="mailto:' . $td_footer_email  . '">' . $td_footer_email . '</a>';
            $buffy .= '</div>';
        }
    $buffy .= '</div>';

    // social icons
    $buffy .= '<div class="footer-social-wrap td-social-style2">';
        if(td_util::get_option('tds_footer_social') != 'no') {
            //get the socials that are set by user
            $td_get_social_network = td_util::get_option('td_social_networks');

            if(!empty($td_get_social_network)) {
                foreach($td_get_social_network as $social_id => $social_link) {
                    if(!empty($social_link)) {
                        $buffy .= td_social_icons::get_icon($social_link, $social_id, true);
                    }
                }
            }
        }
    $buffy .= '</div>';

$buffy .= '</div>';

echo $buffy;