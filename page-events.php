<?php
/**
 * Template Name: Страница событий
 */
$page = get_page_by_path('events', OBJECT, 'page')->ID;
get_header();
get_template_part('partials/components/hero-page');
get_template_part('partials/events/events-header-bar');
get_template_part('partials/events/featured-events');
get_template_part('partials/events/archive-events');
get_template_part('partials/about/resident-cta', null, ['page_id' => $page]);
get_footer(); ?>