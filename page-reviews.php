<?php
/**
 * Template Name: Archive Reviews
 */

get_header();
get_template_part('partials/components/hero-page');
get_template_part('partials/reviews-page');
get_template_part('partials/catalog/catalog-cta', null, ['page_id' => get_page_by_path('reviews', OBJECT, 'page')]);
get_footer(); ?>