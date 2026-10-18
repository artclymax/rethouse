<?php
// Получаем query из аргументов, если передан, иначе используем глобальный
$query = $args['query'] ?? $GLOBALS['wp_query'];

// Получаем количество найденных постов
$found_posts = $query->found_posts ?? 0;

// Формируем правильное склонение слова "резидент"
if ($found_posts === 1) {
	$word = 'резидент';
} elseif ($found_posts > 1 && $found_posts < 5) {
	$word = 'резидента';
} else {
	$word = 'резидентов';
}
?>

<div class="residents-counter label">
	<p class="residents-counter__text">
		Найдено <strong><?php echo esc_html($found_posts); ?></strong> <?php echo esc_html($word); ?>
	</p>
</div>