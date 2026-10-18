<?php
/**
 * Template Name: Школам и партнёрам
 */

get_header();
get_template_part('partials/components/hero-page');
get_template_part('partials/about/resident-why');
get_template_part('partials/about/formats');
get_template_part('partials/about/resident-why-it-works');
get_template_part('partials/about/simple-process');
get_template_part('partials/home/section-events');
get_template_part('partials/about/resident-cta', null, ['no-jarallax' => true]);
get_footer();