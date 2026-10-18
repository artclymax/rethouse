<?php
/**
 * Template Name: Поставщикам и резидентам
 */

get_header();
get_template_part('partials/components/hero-page');
get_template_part('partials/about/resident-why-it-works');
get_template_part('partials/about/for-whom');
get_template_part('partials/about/resident-format');
get_template_part('partials/about/resident-why');
get_template_part('partials/about/resident-brands');
get_template_part('partials/about/resident-cta', null, ['no-jarallax' => true]);
get_footer();