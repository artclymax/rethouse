<?php
/**
 * Template Name: Образование и карьера
 */
$current_page = get_page_by_path('education-career', OBJECT, 'page');
get_header();
get_template_part('partials/components/hero-page');
get_template_part('partials/education/section-offers', null, ['page_id' => $current_page->ID]);
get_template_part('partials/home/section-events', null, ['page_id' => $current_page->ID]);
get_template_part('partials/section-gallery', null, ['page_id' => $current_page->ID]);
get_template_part('partials/education/courses', null, ['page_id' => $current_page->ID]);
get_template_part('partials/education/section-partnership', null, ['page_id' => $current_page->ID]);
get_footer();