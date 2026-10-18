<?php
/**
 * Template Name: О галерее
 */

get_header();
get_template_part('partials/components/hero-page');
get_template_part('partials/about/about-block');
get_template_part('partials/about/about-customers');
get_template_part('partials/home/cta-section', null, ['class' => 'about-cta-section']);
get_footer();