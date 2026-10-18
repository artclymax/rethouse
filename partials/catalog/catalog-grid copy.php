<div class="catalog-grid">
	<?php if (have_posts()): ?>
		<ul class="catalog-grid__list grid">
			<?php while (have_posts()):
				the_post();
				$image = get_field('hero_image') ?? '';
				?>
				<li class="catalog-grid__item catalog-card-grid">
					<a class="catalog-card-grid__link-wrapper" href="<?= the_permalink() ?>">
						<div class="catalog-card-grid__image image-box">
							<?php if (!empty($image)): ?>
								<?php echo wp_get_attachment_image(
									$image['ID'],
									'large',
									false,
									[
										'class' => 'img',
										'alt' => $image['alt'] ?: ''
									]
								); ?>
							<?php else: ?>
								<?php the_post_thumbnail('full', ['class' => 'obj-fit-contain']); ?>
							<?php endif; ?>
						</div>
						<h3 class="catalog-card-grid__title text-btn">
							<?php the_title(); ?>
						</h3>
						<div class="catalog-card-grid__descr descr text-small">
							<?php the_excerpt(); ?>
						</div>
						<span class="catalog-card-grid__link link-arrow">
							Подробнее
						</span>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>
		<div class="catalog-grid__pagination page-pagination">
			<?php echo mx_pagination($wp_query, '<span class="page-pagination__next page-pagination__prev">Предыдущая<span>', '<span class="page-pagination__btn page-pagination__next">Следующая<span>'); ?>
		</div>
	<?php else: ?>
		<div class="catalog-grid-not-found">
			<?php get_template_part('partials/catalog/resident-counter'); ?>
			<h3 class="catalog-grid-not-found__title title-3">
				По выбранным параметрам ничего не найдено
			</h3>
			<div class="catalog-grid-not-found__descr descr text-small">
				Попробуйте изменить фильтр, поменять категорию или параметры поиска
			</div>
			<a class="catalog-grid-not-found__btn btn" href="<?= esc_url(home_url('/residents/')) ?>">Сбросить фильтры</a>
		</div>
	<?php endif; ?>
</div>