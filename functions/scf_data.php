<?php


if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' => 'Контактные данные',
		'menu_title' => 'Контактные данные',
		'menu_slug' => 'opt-contacts',
		'position' => 20,
	));

	//acf_add_options_page(array(
	//	'page_title' => 'Общие поля товаров',
	//	'menu_title' => 'Общие поля товаров',
	//	'menu_slug' => 'opt-products',
	//	'position' => 15,
	//));


	acf_add_options_page(array(
		'page_title' => 'Шапка',
		'menu_title' => 'Шапка',
		'menu_slug' => 'opt-header',
		'position' => 21,
	));

	acf_add_options_page(array(
		'page_title' => 'Подвал / Футер',
		'menu_title' => 'Подвал / Футер',
		'menu_slug' => 'opt-footer',
		'position' => 22,
	));

	acf_add_options_page(array(
		'page_title' => 'Модальные окна',
		'menu_title' => 'Модальные окна',
		'menu_slug' => 'opt-modals',
		'position' => 23,
	));

	acf_add_options_page(array(
		'page_title' => 'Страница благодарности',
		'menu_title' => 'Страница благодарности',
		'menu_slug' => 'opt-thank_you',
		'position' => 24,
	));

	acf_add_options_page(array(
		'page_title' => 'Страница 404',
		'menu_title' => 'Страница 404',
		'menu_slug' => 'opt-page-404',
		'position' => 24,
	));

}

// OPTIONS
add_action('acf/init', function () {
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	// HEADER
	acf_add_local_field_group(array(
		'key' => 'group_header_settings',
		'title' => 'Поля шапки',
		'fields' => array(
			array(
				'key' => 'field_header_info_message',
				'name' => 'header_info_message',
				'type' => 'message',
				'message' => '<b>Логотип</b> - перейдите в Панель управления сайтом > Основные настройки > Логотип сайта. <a href="' . admin_url('/admin.php?page=verda-settings&tab=general') . '" target="_blank">Перейти</a><br/><b>Меню</b> - перейдите в Панель управления сайтом > Меню > Меню шапки. <a href="' . admin_url('/admin.php?page=verda-settings&tab=menus') . '" target="_blank">Перейти</a><br/><b>Контакты</b> - перейдите в Панель управления сайтом > Редактирование контента > Основные секции > Контактные данные. <a href="' . admin_url('/admin.php?page=opt-contacts') . '" target="_blank">Перейти</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			// телефон
			array(
				'key' => 'field_header_phone',
				'label' => 'Телефон в шапке',
				'name' => 'header_phone',
				'type' => 'text',
				'instructions' => 'Если не указывать будут использоваться телефоны из контактных данных',
			),

			// Кнопка
			array(
				'key' => 'field_header_btn',
				'label' => 'Кнопка в шапке',
				'name' => 'header_btn',
				'type' => 'link',
				'instructions' => 'Ссылка на модальное окно (якорь #modal-call) или страницу.',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-header',
				),
			),
		),
	));

	// FOOTER
	acf_add_local_field_group([
		'key' => 'group_footer',
		'title' => 'Футер',
		'fields' => [
			array(
				'key' => 'field_header_info_message',
				'name' => 'header_info_message',
				'type' => 'message',
				'message' => '<b>Логотип</b> - перейдите в Панель управления сайтом > Основные настройки > Логотип сайта. <a href="' . admin_url('/admin.php?page=verda-settings&tab=general') . '" target="_blank">Перейти</a><br/><b>Меню</b> - перейдите в Панель управления сайтом > Меню > Меню шапки. <a href="' . admin_url('/admin.php?page=verda-settings&tab=menus') . '" target="_blank">Перейти</a><br/><b>Контакты</b> - перейдите в Панель управления сайтом > Редактирование контента > Основные секции > Контактные данные. <a href="' . admin_url('/admin.php?page=opt-contacts') . '" target="_blank">Перейти</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			[
				'key' => 'field_footer_company',
				'label' => 'Название компании',
				'name' => 'footer_company',
				'type' => 'text',
				'instructions' => 'Если пусто — берётся из настроек сайта',
			],
			[
				'key' => 'field_footer_descr',
				'label' => 'Описание компании',
				'name' => 'footer_descr',
				'type' => 'textarea',
				'rows' => 3,
				'instructions' => 'Если пусто — берётся из настроек сайта',
				'new_lines' => 'wpautop',
			],
			[
				'key' => 'field_footer_copy',
				'label' => 'Текст копирайта',
				'name' => 'footer_copy',
				'type' => 'text',
				'instructions' => 'Например: "Все права защищены"',
			],
			[
				'key' => 'field_footer_links',
				'label' => 'Ссылки',
				'name' => 'footer_links',
				'type' => 'repeater',
				'instructions' => 'Социальные сети, документы, страницы и т.д.',
				'layout' => 'block',
				'collapsed' => 'field_footer_links_link',
				'button_label' => 'Добавить ссылку',
				'sub_fields' => [
					[
						'key' => 'field_footer_links_link',
						'label' => 'Ссылка',
						'name' => 'footer_links_link',
						'type' => 'link',
					],
				],
			],
			[
				'key' => 'field_footer_subscribe_descr',
				'label' => 'Подписка: описание',
				'name' => 'footer_subscribe_descr',
				'type' => 'textarea',
				'rows' => 2,
				'new_lines' => 'wpautop',
			],
			[
				'key' => 'field_footer_subscribe_form',
				'label' => 'Подписка: форма (шорткод)',
				'name' => 'footer_subscribe_form',
				'type' => 'text',
				'instructions' => 'Например: [contact-form-7 id="123"]',
			],
			[
				'key' => 'field_footer_subscribe_note',
				'label' => 'Подписка: заметка',
				'name' => 'footer_subscribe_note',
				'type' => 'textarea',
				'rows' => 2,
				'instructions' => 'Согласие на обработку данных',
				'new_lines' => 'wpautop',
			],
		],
		'location' => [
			[
				[
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-footer',
				],
			],
		],
	]);

	// CONTACTS
	acf_add_local_field_group(array(
		'key' => 'group_contacts_page',
		'title' => 'Контактные данные',
		'fields' => array(
			array(
				'key' => 'field_contacts_tab_phones',
				'label' => 'Телефон',
				'name' => 'contacts_tab_phones',
				'type' => 'tab',
			),
			array(
				'key' => 'field_contacts_phones',
				'label' => 'Телефоны',
				'name' => 'contacts_phones',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_contact_phone_number',
				'button_label' => 'Добавить телефон',
				'sub_fields' => array(
					array(
						'key' => 'field_contact_phone_number',
						'label' => 'Номер телефона',
						'name' => 'phone',
						'type' => 'text',
					),
					array(
						'key' => 'field_contact_phone_messengers',
						'label' => 'Мессенджеры',
						'name' => 'messengers',
						'type' => 'repeater',
						'layout' => 'table',
						'collapsed' => 'field_contact_messenger_link',
						'button_label' => 'Добавить мессенджер',
						'sub_fields' => array(
							array(
								'key' => 'field_contact_messenger_icon',
								'label' => 'Иконка',
								'name' => 'image',
								'type' => 'image',
							),
							array(
								'key' => 'field_contact_messenger_link',
								'label' => 'Ссылка',
								'name' => 'link',
								'type' => 'link',
							),
						)
					)
				)
			),
			array(
				'key' => 'field_contacts_tab_email',
				'label' => 'Email',
				'name' => 'contacts_tab_email',
				'type' => 'tab',
			),
			array(
				'key' => 'field_contacts_emails',
				'label' => 'Email адреса',
				'name' => 'contacts_emails',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_contact_email_link',
				'button_label' => 'Добавить email',
				'sub_fields' => array(
					array(
						'key' => 'field_contact_email_link',
						'label' => 'Email',
						'name' => 'email',
						'type' => 'email',
					)
				)
			),
			array(
				'key' => 'field_contacts_tab_address_time',
				'label' => 'Адрес и время работы',
				'name' => 'contacts_tab_address_time',
				'type' => 'tab',
			),
			array(
				'key' => 'field_contacts_address',
				'label' => 'Адрес',
				'name' => 'contacts_address',
				'type' => 'wysiwyg',
			),
			array(
				'key' => 'field_contacts_time',
				'label' => 'Время работы',
				'name' => 'contacts_time',
				'type' => 'wysiwyg',
			),
			//array(
			//	'key' => 'field_contacts_tab_messengers',
			//	'label' => 'Мессенджеры и соцсети',
			//	'name' => 'contacts_tab_messengers',
			//	'type' => 'tab',
			//),
			//array(
			//	'key' => 'field_contacts_messengers',
			//	'label' => 'Мессенджеры',
			//	'name' => 'contacts_messengers',
			//	'type' => 'repeater',
			//	'sub_fields' => array(
			//		array(
			//			'key' => 'field_contact_phone_icon',
			//			'label' => 'Иконка',
			//			'name' => 'image',
			//			'type' => 'image',
			//		),
			//		array(
			//			'key' => 'field_contact_phone_link',
			//			'label' => 'Ссылка',
			//			'name' => 'link',
			//			'type' => 'link',
			//		)
			//	)
			//),
			//array(
			//	'key' => 'field_contacts_tab_form',
			//	'label' => 'Форма контактов',
			//	'name' => 'contacts_tab_form',
			//	'type' => 'tab',
			//),
			//[
			//	'key' => 'field_contacts_form_title',
			//	'label' => 'Заголовок формы',
			//	'name' => 'contacts_form_title',
			//	'type' => 'text',
			//],
			//[
			//	'key' => 'field_contacts_form_descr',
			//	'label' => 'Описание формы',
			//	'name' => 'contacts_form_descr',
			//	'type' => 'textarea',
			//	'rows' => '4',
			//	'new_lines' => 'wpautop',
			//],
			//[
			//	'key' => 'field_contacts_form_shortcode',
			//	'label' => 'Шорткод формы',
			//	'name' => 'contacts_form_shortcode',
			//	'type' => 'text',
			//	'instructions' => 'Вставьте шорткод формы, например: [contact-form-7 id="123" title="Форма контактов"]',
			//],
			array(
				'key' => 'field_contacts_tab_map',
				'label' => 'Карта',
				'name' => 'contacts_tab_map',
				'type' => 'tab',
			),
			//[
			//	'key' => 'field_contacts_map_title',
			//	'label' => 'Заголовок карты',
			//	'name' => 'contacts_map_title',
			//	'type' => 'text',
			//],
			[
				'key' => 'field_contacts_map',
				'label' => 'Код карты (iframe)',
				'name' => 'contacts_map',
				'type' => 'textarea',
				'rows' => 4,
				'instructions' => 'Вставьте iframe код из Яндекс.Карт или Google Maps',
			],

			// ==================== БЛОК: СОЦСЕТИ ====================
			array(
				'key' => 'field_contacts_tab_socials',
				'label' => 'Социальные сети',
				'name' => 'contacts_tab_socials',
				'type' => 'tab',
			),
			[
				'key' => 'field_contacts_socials_title',
				'label' => 'Заголовок блока соцсетей',
				'name' => 'contacts_socials_title',
				'type' => 'text',
				'default_value' => 'Мы в соцсетях',
			],
			[
				'key' => 'field_contacts_socials_descr',
				'label' => 'Описание блока соцсетей',
				'name' => 'contacts_socials_descr',
				'type' => 'textarea',
				'rows' => 2,
				'new_lines' => 'wpautop',
				'default_value' => 'Следите за новостями галереи, мероприятиями и новыми материалами.',
			],
			[
				'key' => 'field_contacts_socials',
				'label' => 'Социальные сети',
				'name' => 'contacts_socials',
				'type' => 'repeater',
				'button_label' => 'Добавить соцсеть',
				'collapsed' => 'field_social_text',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_social_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],
					[
						'key' => 'field_social_text',
						'label' => 'Название соцсети',
						'name' => 'text',
						'type' => 'text',
					],
					[
						'key' => 'field_social_url',
						'label' => 'Ссылка',
						'name' => 'url',
						'type' => 'link',
					],
				],
			],
			// ==================== БЛОК: БЫСТРЫЕ СЦЕНАРИИ ====================
			array(
				'key' => 'field_contacts_tab_scenarios',
				'label' => 'Быстрые сценарии',
				'name' => 'contacts_tab_scenarios',
				'type' => 'tab',
			),
			[
				'key' => 'field_contacts_scenarios_section',
				'label' => 'Быстрые сценарии',
				'type' => 'message',
				'message' => '<b>Быстрые сценарии</b><br/>Ссылки с иконками для быстрых действий (забронировать стол, записаться на консультацию и т.д.).',
			],
			[
				'key' => 'field_contacts_scenarios',
				'label' => 'Сценарии',
				'name' => 'contacts_scenarios',
				'type' => 'repeater',
				'button_label' => 'Добавить сценарий',
				'collapsed' => 'field_scenario_text',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_scenario_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],
					[
						'key' => 'field_scenario_link',
						'label' => 'Ссылка',
						'name' => 'link',
						'type' => 'link',
					],
				],
			],
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-contacts'
				)
			)
		),
	));

	// MODALS
	acf_add_local_field_group(array(
		'key' => 'group_opt_modals',
		'title' => 'Глобальные модальные окна',
		'fields' => array(
			array(
				'key' => 'field_modals_list',
				'label' => 'Список модальных окон',
				'name' => 'modals',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_modal_id',
				'button_label' => 'Добавить модальное окно',
				'sub_fields' => array(
					array(
						'key' => 'field_modal_id',
						'label' => 'ID модального окна',
						'name' => 'id',
						'type' => 'text',
						'required' => 1,
						'maxlength' => 50,
						'instructions' => 'Только латиница, цифры, дефис. Пример: <code>order-form</code>. Используется в <code>id</code> и <code>data-modal</code>.',
						'prepend' => '#',
						'character_limit' => 50,
						'allow_custom' => 0,
					),
					array(
						'key' => 'field_modal_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					),
					array(
						'key' => 'field_modal_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'wysiwyg',
					),
					array(
						'key' => 'field_modal_shortcode',
						'label' => 'Шорткод формы',
						'name' => 'shortcode',
						'type' => 'text',
						'placeholder' => '[contact-form-7 id="123"]',
						'instructions' => 'Вставьте шорткод форм (CF7, WPForms, Forminator и свой шорткод).',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-modals',
				),
			),
		),
	));


	// THANK YOU
	acf_add_local_field_group(array(
		'key' => 'flds_opt_thank_you',
		'title' => 'Страница благодарности',
		'fields' => array(
			array(
				'key' => 'field_thank_you_title',
				'name' => 'thank_you_title',
				'label' => 'Заголовок',
				'type' => 'text',
			),
			array(
				'key' => 'field_thank_you_descr',
				'name' => 'thank_you_descr',
				'label' => 'Описание',
				'type' => 'wysiwyg',
			),
			array(
				'key' => 'field_thank_you_btn',
				'name' => 'thank_you_btn',
				'label' => 'Кнопка',
				'type' => 'link',
			),

			array(
				'key' => 'field_thank_you_image',
				'name' => 'thank_you_image',
				'label' => 'Картинка',
				'type' => 'image',
			),

		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-thank_you',
				),
			),
		),
	));

	// PAGE 404 
	acf_add_local_field_group(array(
		'key' => 'flds_opt_page_404',
		'title' => 'Страница 404',
		'fields' => array(
			array(
				'key' => 'field_page_404_title',
				'name' => 'page_404_title',
				'label' => 'Заголовок',
				'type' => 'text',
			),
			array(
				'key' => 'field_page_404_descr',
				'name' => 'page_404_descr',
				'label' => 'Описание',
				'type' => 'wysiwyg',
			),
			array(
				'key' => 'field_page_404_btn',
				'name' => 'page_404_btn',
				'label' => 'Кнопка',
				'type' => 'link',
			),
			array(
				'key' => 'field_page_404_image',
				'name' => 'page_404_image',
				'label' => 'Картинка',
				'type' => 'image',
			),


		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-page-404',
				),
			),
		),
	));

	// product


	// SECTIONS
});


add_action('acf/init', 'register_fields');
function register_fields()
{
	$page = get_page_by_path('home', OBJECT, 'page');
	if (function_exists('acf_add_local_field_group')) {
		acf_add_local_field_group([
			'key' => 'group_home_hero',
			'title' => 'Секция "Главный экран"',
			'fields' => [
				[
					'key' => 'field_home_hero_label',
					'label' => 'Метка (над заголовком)',
					'name' => 'home_hero_label',
					'type' => 'text',
				],
				[
					'key' => 'field_home_hero_title',
					'label' => 'Заголовок',
					'name' => 'home_hero_title',
					'type' => 'text',
				],
				[
					'key' => 'field_home_hero_descr',
					'label' => 'Описание',
					'name' => 'home_hero_descr',
					'type' => 'wysiwyg',
				],
				[
					'key' => 'field_home_hero_btn',
					'label' => 'Основная кнопка',
					'name' => 'home_hero_btn',
					'type' => 'link',
				],
				[
					'key' => 'field_home_hero_btn_second',
					'label' => 'Вторая кнопка (контурная)',
					'name' => 'home_hero_btn_second',
					'type' => 'link',
				],
				[
					'key' => 'field_home_hero_image',
					'label' => 'Изображение',
					'name' => 'home_hero_image',
					'type' => 'image',

				],
				[
					'key' => 'field_home_hero_benefits',
					'label' => 'Список преимуществ',
					'name' => 'home_hero_benefits',
					'type' => 'repeater',
					'layout' => 'block',
					'collapsed' => 'field_home_hero_benefit_title',
					'button_label' => 'Добавить преимущество',
					'sub_fields' => [
						[
							'key' => 'field_home_hero_benefit_image',
							'label' => 'Иконка',
							'name' => 'image',
							'type' => 'image',
						],
						[
							'key' => 'field_home_hero_benefit_title',
							'label' => 'Заголовок',
							'name' => 'title',
							'type' => 'text',
						],
						[
							'key' => 'field_home_hero_benefit_descr',
							'label' => 'Описание',
							'name' => 'descr',
							'type' => 'textarea',
							'rows' => 2,
							'new_lines' => 'wpautop',
						],
					],
				],
			],
			'location' => [
				[
					[
						'param' => 'post_template',
						'operator' => '==',
						'value' => 'front-page.php',
					],
				],
			],
		]);
	}
	acf_add_local_field_group([
		'key' => 'group_section_catalog',
		'title' => 'Секция "Каталог"',
		'fields' => [
			[
				'key' => 'field_section_catalog_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Секция каталога материалов</b><br/>Заполните заголовок, описание и добавьте кнопку. Категории подгружаются автоматически из WooCommerce (только родительские).',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_section_catalog_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'section_catalog_label',
				'type' => 'text',
			],
			[
				'key' => 'field_section_catalog_title',
				'label' => 'Заголовок',
				'name' => 'section_catalog_title',
				'type' => 'text',
			],
			[
				'key' => 'field_section_catalog_descr',
				'label' => 'Описание',
				'name' => 'section_catalog_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_section_catalog_btn',
				'label' => 'Кнопка "Перейти в каталог"',
				'name' => 'section_catalog_btn',
				'type' => 'link',
			],
			[
				'key' => 'field_section_catalog_note',
				'label' => 'Заметка (под кнопкой)',
				'name' => 'section_catalog_note',
				'type' => 'text',
				'instructions' => 'Например: "Поиск по категориям и брендам"',
			],
			[
				'key' => 'field_section_catalog_categories',
				'label' => 'Категории',
				'name' => 'section_catalog_categories',
				'type' => 'repeater',
				'instructions' => 'Добавьте категории и перетащите их для изменения порядка. Если ничего не выбрано — будет выведены последние 8 категорий',
				'layout' => 'row',
				'collapsed' => 'field_section_catalog_category_item',
				'button_label' => 'Добавить категорию',
				'sub_fields' => [
					[
						'key' => 'field_section_catalog_category_item',
						'label' => 'Категория',
						'name' => 'category',
						'type' => 'taxonomy',
						'taxonomy' => 'product_cat',
						'field_type' => 'select',
						'return_format' => 'object',
						'allow_null' => 0,
						'multiple' => 0,
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
		],
	]);

	acf_add_local_field_group([
		'key' => 'group_section_cta',
		'title' => 'Секция "CTA"',
		'fields' => [
			[
				'key' => 'field_cta_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'cta_label',
				'type' => 'text',
			],
			[
				'key' => 'field_cta_title',
				'label' => 'Заголовок',
				'name' => 'cta_title',
				'type' => 'text',
			],
			[
				'key' => 'field_cta_descr',
				'label' => 'Описание',
				'name' => 'cta_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_cta_bg_image',
				'label' => 'Фоновое изображение',
				'name' => 'cta_bg_image',
				'type' => 'image',
			],
			[
				'key' => 'field_cta_steps',
				'label' => 'Шаги',
				'name' => 'cta_steps',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_cta_step_title',
				'button_label' => 'Добавить шаг',
				'sub_fields' => [
					[
						'key' => 'field_cta_step_descr',
						'label' => 'Описание шага',
						'name' => 'descr',
						'type' => 'text',
					],
				],
			],
			[
				'key' => 'field_cta_btn',
				'label' => 'Кнопка',
				'name' => 'cta_btn',
				'type' => 'link',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
		],
	]);

	// brands-section
	acf_add_local_field_group([
		'key' => 'group_section_brands',
		'title' => 'Секция "Резиденты / Бренды"',
		'fields' => [
			[
				'key' => 'field_section_brands_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Секция резидентов галереи</b><br/>Заполните заголовок, описание и выберите бренды. Перетаскивайте для изменения порядка. Если список пуст — автоматически покажутся последние 9 брендов.<br> Чтобы добавить резидента, переходите в Боковом меню > Товары > Бренды. <a href="' . admin_url('/edit-tags.php?taxonomy=product_brand&post_type=product') . '" target="_blank">Перейти</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_section_brands_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'section_brands_label',
				'type' => 'text',
			],
			[
				'key' => 'field_section_brands_title',
				'label' => 'Заголовок',
				'name' => 'section_brands_title',
				'type' => 'text',
			],
			[
				'key' => 'field_section_brands_descr',
				'label' => 'Описание',
				'name' => 'section_brands_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_section_brands_btn',
				'label' => 'Основная кнопка',
				'name' => 'section_brands_btn',
				'type' => 'link',
			],
			[
				'key' => 'field_section_brands_btn_second',
				'label' => 'Вторая кнопка (контурная)',
				'name' => 'section_brands_btn_second',
				'type' => 'link',
			],
			[
				'key' => 'field_section_brands_list',
				'label' => 'Бренды',
				'name' => 'section_brands_list',
				'type' => 'repeater',
				'instructions' => 'Добавьте бренды и перетащите их для изменения порядка',
				'layout' => 'row',
				'collapsed' => 'field_section_brands_brand_item',
				'button_label' => 'Добавить бренд',
				'sub_fields' => [
					[
						'key' => 'field_section_brands_brand_item',
						'label' => 'Бренд',
						'name' => 'brand',
						'type' => 'taxonomy',
						'taxonomy' => 'product_brand',
						'field_type' => 'select',
						'return_format' => 'object',
						'allow_null' => 0,
						'multiple' => 0,
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
		],
	]);

	// section-consult 
	acf_add_local_field_group([
		'key' => 'group_section_consult',
		'title' => 'Секция "Консультация"',
		'fields' => [
			[
				'key' => 'field_consult_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'consult_label',
				'type' => 'text',
			],
			[
				'key' => 'field_consult_title',
				'label' => 'Заголовок',
				'name' => 'consult_title',
				'type' => 'text',
			],
			[
				'key' => 'field_consult_descr',
				'label' => 'Описание',
				'name' => 'consult_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_consult_image',
				'label' => 'Изображение (Слева)',
				'name' => 'consult_image',
				'type' => 'image',
			],
			[
				'key' => 'field_consult_features',
				'label' => 'Преимущества (список)',
				'name' => 'consult_features',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_consult_feature_text',
				'button_label' => 'Добавить пункт',
				'sub_fields' => [
					[
						'key' => 'field_consult_feature_text',
						'label' => 'Текст пункта',
						'name' => 'feature_text',
						'type' => 'text',
					],
				],
			],
			[
				'key' => 'field_consult_meta_format',
				'label' => 'Мета: Формат',
				'name' => 'consult_meta_format',
				'type' => 'text',
				'instructions' => 'Например: "Формат: офлайн в Минске"',
			],
			[
				'key' => 'field_consult_meta_duration',
				'label' => 'Мета: Длительность',
				'name' => 'consult_meta_duration',
				'type' => 'text',
				'instructions' => 'Например: "Длительность: 3 часа"',
			],
			[
				'key' => 'field_consult_btn',
				'label' => 'Кнопка',
				'name' => 'consult_btn',
				'type' => 'link',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
		],
	]);

	// section-events
	acf_add_local_field_group([
		'key' => 'group_section_events',
		'title' => 'Секция "События"',
		'fields' => [
			[
				'key' => 'field_section_events_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'section_events_label',
				'type' => 'text',
			],
			[
				'key' => 'field_section_events_title',
				'label' => 'Заголовок',
				'name' => 'section_events_title',
				'type' => 'text',
			],
			[
				'key' => 'field_section_events_descr',
				'label' => 'Описание',
				'name' => 'section_events_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_section_events_btn',
				'label' => 'Кнопка "Посмотреть все"',
				'name' => 'section_events_btn',
				'type' => 'link',
			],
			[
				'key' => 'field_section_events_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => 'Если список пуст — автоматически покажутся последние 4 событий.<br>Добавить чтобы добавить мероприятия перейдите в Панель управления > Записи > Мероприятия. <a href="' . admin_url('/edit.php?post_type=events') . '" target="_blank">Перейти</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_section_events_list',
				'label' => 'События',
				'name' => 'section_events_list',
				'type' => 'repeater',
				'instructions' => 'Добавьте события и перетащите их для изменения порядка',
				'layout' => 'row',
				'collapsed' => 'field_section_events_item',
				'button_label' => 'Добавить событие',
				'sub_fields' => [
					[
						'key' => 'field_section_events_item',
						'label' => 'Событие',
						'name' => 'event',
						'type' => 'post_object',
						'post_type' => ['events'],
						'field_type' => 'select',
						'return_format' => 'object',
						'allow_null' => 0,
						'multiple' => 0,
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-designers-architects.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-schools-partners.php',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-education-careers.php',
				],
			],
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'events',
				],
			],
		],
	]);
	acf_add_local_field_group([
		'key' => 'group_section_about',
		'title' => 'Секция "О компании"',
		'fields' => [
			[
				'key' => 'field_about_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'about_label',
				'type' => 'text',
			],
			[
				'key' => 'field_about_title',
				'label' => 'Заголовок',
				'name' => 'about_title',
				'type' => 'text',
			],
			[
				'key' => 'field_about_descr',
				'label' => 'Описание секции',
				'name' => 'about_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_about_quote',
				'label' => 'Цитата',
				'name' => 'about_quote',
				'type' => 'textarea',
				'rows' => 3,
				'instructions' => 'Короткая цитата или слоган компании',
				'new_lines' => 'wpautop',
			],
			[
				'key' => 'field_about_image',
				'label' => 'Фоновое изображение (справа)',
				'name' => 'about_image',
				'type' => 'image',
			],
			[
				'key' => 'field_about_founder_photo',
				'label' => 'Фото основателя',
				'name' => 'about_founder_photo',
				'type' => 'image',
			],
			[
				'key' => 'field_about_founder_name',
				'label' => 'Имя основателя',
				'name' => 'about_founder_name',
				'type' => 'text',
			],
			[
				'key' => 'field_about_founder_descr',
				'label' => 'Описание основателя',
				'name' => 'about_founder_descr',
				'type' => 'textarea',
				'rows' => 2,
				'instructions' => 'Должность или краткая информация об основателе',
				'new_lines' => 'wpautop',
			],
			[
				'key' => 'field_about_btn',
				'label' => 'Кнопка',
				'name' => 'about_btn',
				'type' => 'link',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
		],
	]);
	acf_add_local_field_group([
		'key' => 'group_contacts',
		'title' => 'Секция "Контакты"',
		'fields' => [
			[
				'key' => 'field_contacts_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Контакты</b> - перейдите в Панель управления сайтом > Редактирование контента > Основные секции > Контактные данные. <a href="' . admin_url('/admin.php?page=opt-contacts') . '" target="_blank">Перейти</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_contacts_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'contacts_label',
				'type' => 'text',
			],
			[
				'key' => 'field_contacts_title',
				'label' => 'Заголовок',
				'name' => 'contacts_title',
				'type' => 'text',
			],
			[
				'key' => 'field_contacts_descr',
				'label' => 'Описание',
				'name' => 'contacts_descr',
				'type' => 'textarea',
				'rows' => 3,
				'new_lines' => 'wpautop',
			],
			[
				'key' => 'field_contacts_image',
				'label' => 'Фоновое изображение (jarallax)',
				'name' => 'contacts_image',
				'type' => 'image',
				'instructions' => 'Изображение с параллакс-эффектом. Используется, если не заполнено поле "Код карты".',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
		],
	]);

	// RESIDENT_PAGE
	acf_add_local_field_group([
		'key' => 'group_section_catalog_cta',
		'title' => 'Секция "CTA каталога"',
		'fields' => [
			[
				'key' => 'field_catalog_cta_title',
				'label' => 'Заголовок',
				'name' => 'catalog_cta_title',
				'type' => 'text',
			],
			[
				'key' => 'field_catalog_cta_descr',
				'label' => 'Описание',
				'name' => 'catalog_cta_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_catalog_cta_image',
				'label' => 'Изображение',
				'name' => 'catalog_cta_image',
				'type' => 'image',
			],
			[
				'key' => 'field_catalog_cta_btn',
				'label' => 'Кнопка',
				'name' => 'catalog_cta_btn',
				'type' => 'link',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'archive-resident.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-reviews.php',
				],
			],
		],
	]);

	// BRAND
	acf_add_local_field_group([
		'key' => 'group_product_brand',
		'title' => 'Бренд (доп. поля)',
		'fields' => [
			[
				'key' => 'field_brand_short_descr',
				'label' => 'Краткое описание',
				'name' => 'brand_short_descr',
				'type' => 'text',
				'instructions' => 'Короткое описание для карточки (например: "Паркетная доска")',
			],
		],
		'location' => [
			[
				[
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'product_brand',
				],
			],
		],
		'position' => 'normal',
		'style' => 'default',
	]);
	// BRAND
	acf_add_local_field_group([
		'key' => 'group_resident_category',
		'title' => 'Категории',
		'fields' => [
			[
				'key' => 'field_resident_category_icon',
				'label' => 'Иконка',
				'name' => 'cat_icon',
				'type' => 'image',
			],
			[
				'key' => 'field_resident_category_card_image',
				'label' => 'Изображение для карточки',
				'name' => 'cat_card_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'resident_category',
				],
			],
		],
		'position' => 'normal',
		'style' => 'default',
	]);

	// RESIDENT
	//acf_add_local_field_group([
	//	'key' => 'group_resident_hero',
	//	'title' => 'Первый экран',
	//	'fields' => [
	//		[
	//			'key' => 'field_resident_hero_image',
	//			'label' => 'Изображение',
	//			'name' => 'hero_image',
	//			'type' => 'image',
	//		],
	//	],
	//	'location' => [
	//		[
	//			[
	//				'param' => 'post_type',
	//				'operator' => '==',
	//				'value' => 'resident',
	//			],
	//		],
	//	],
	//]);
	// EVENTS
	acf_add_local_field_group([
		'key' => 'group_event_fields',
		'title' => 'Дополнительная информация',
		'fields' => [
			[
				'key' => 'field_event_start_date',
				'label' => 'Дата начала',
				'name' => 'event_start_date',
				'type' => 'date_picker',
				'display_format' => 'd F Y',
				'return_format' => 'd F Y',
				'first_day' => 1,
			],
			[
				'key' => 'field_event_duration',
				'label' => 'Длительность',
				'name' => 'event_duration',
				'type' => 'text',
			],
			[
				'key' => 'field_event_format',
				'label' => 'Формат',
				'name' => 'event_format',
				'type' => 'text',
			],
			[
				'key' => 'field_event_location',
				'label' => 'Место проведения',
				'name' => 'event_location',
				'type' => 'text',
			],
			[
				'key' => 'field_event_price',
				'label' => 'Стоимость',
				'name' => 'event_price',
				'type' => 'text',
			],
			[
				'key' => 'field_event_schedule',
				'label' => 'Расписание',
				'name' => 'event_schedule',
				'type' => 'text',
				'placeholder' => '18:30 — 22:00',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'education_career',
				],
			],
		],
	]);

	acf_add_local_field_group([
		'key' => 'group_event_fields_2',
		'title' => 'Дополнительная информация',
		'fields' => [
			[
				'key' => 'field_event_start_date',
				'label' => 'Дата начала',
				'name' => 'event_start_date',
				'type' => 'date_picker',
				'display_format' => 'd F Y',
				'return_format' => 'd F Y',
				'first_day' => 1,
			],
			[
				'key' => 'field_event_start_time',
				'label' => 'Время начала',
				'name' => 'event_start_time',
				'type' => 'text',
			],
			[
				'key' => 'field_event_end_time',
				'label' => 'Время конца',
				'name' => 'event_end_time',
				'type' => 'text',
			],
			[
				'key' => 'field_event_format',
				'label' => 'Формат',
				'name' => 'event_format',
				'type' => 'text',
			],
			[
				'key' => 'field_event_location',
				'label' => 'Место проведения',
				'name' => 'event_location',
				'type' => 'text',
			],
			[
				'key' => 'field_event_price',
				'label' => 'Стоимость',
				'name' => 'event_price',
				'type' => 'text',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'events',
				],
			],
		],
	]);
	// PRODUCT
	acf_add_local_field_group(array(
		'key' => 'group_resident_product_binding',
		'title' => 'Привязка к резиденту',
		'fields' => array(
			array(
				'key' => 'field_resident_brand',
				'label' => 'Бренд-резидент',
				'name' => 'resident_brand',
				'type' => 'relationship',
				'instructions' => 'Выберите резидента (бренд), к которому относится этот товар / курс',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'post_type' => array(
					0 => 'resident',
				),
				'taxonomy' => array(),
				'filters' => array(
					0 => 'search',
					1 => 'post_type',
				),
				'return_format' => 'object',
				'min' => '',
				'max' => 1,
				'elements' => array(
					0 => 'featured_image',
				),
				'bidirectional' => 0,
				'bidirectional_target' => array(),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'education_career',
				),
			),
		),
	));


	// HERO-PAGE
	acf_add_local_field_group([
		'key' => 'group_section_hero_page',
		'title' => 'Первый экран',
		'fields' => [
			[
				'key' => 'field_hero_title',
				'label' => 'Заголовок',
				'name' => 'hero_title',
				'type' => 'textarea',
				'rows' => 3,
				'instructions' => 'Можно использовать HTML-теги и перенос сроки. Для h3 - можно использовать em-тег',
				'new_lines' => 'wpautop',
			],
			[
				'key' => 'field_hero_descr',
				'label' => 'Описание',
				'name' => 'hero_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_hero_image',
				'label' => 'Фоновое изображение',
				'name' => 'hero_image',
				'type' => 'image',
			],
			[
				'key' => 'field_hero_btn',
				'label' => 'Кнопка',
				'name' => 'hero_btn',
				'type' => 'link',
			],
			[
				'key' => 'field_hero_btn_second',
				'label' => 'Кнопка вторая',
				'name' => 'hero_btn_second',
				'type' => 'link',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				],
				[
					'param' => 'page_template',
					'operator' => '!=',
					'value' => 'front-page.php',
				],
			],
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'resident',
				],
			],
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'education_career',
				],
			],
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'events',
				],
			],
		],
	]);
	acf_add_local_field_group([
		'key' => 'group_resident_products_fields',
		'title' => 'Секция товаров',
		'fields' => [
			[
				'key' => 'field_resident_products_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Секция материалов резидента</b><br/>Здесь настраивается заголовок блока с товарами. Сами товары привязываются в карточке товара в поле "Бренд / Резидент". Чтобы добавить товар перейдите в боковом меню > Товары > Добавить товар. <a href="' . admin_url('/edit.php?post_type=product') . '" target="_blank">Перейти</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_resident_products_label',
				'label' => 'Метка секции',
				'name' => 'resident_products_label',
				'type' => 'text',
				'default_value' => 'Материалы и коллекции бренда',
			],
			[
				'key' => 'field_resident_products_title',
				'label' => 'Заголовок секции',
				'name' => 'resident_products_title',
				'type' => 'text',
				'default_value' => 'Материалы бренда',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'resident',
				],
			],
		],
	]);
}

// about-media
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_about_media',
		'title' => 'Секция "Описание и Медиа"',
		'fields' => [
			[
				'key' => 'field_about_media_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Медиа-блок</b><br/>Изображение всегда кликабельно. Если загрузите видеофайл — откроется видео в Fancybox. Если нет — откроется увеличенное изображение.',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_about_media_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'about_media_label',
				'type' => 'text',
			],
			[
				'key' => 'field_about_media_title',
				'label' => 'Заголовок',
				'name' => 'about_media_title',
				'type' => 'text',
			],
			[
				'key' => 'field_about_media_descr',
				'label' => 'Описание',
				'name' => 'about_media_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_about_media_image',
				'label' => 'Изображение (превью)',
				'name' => 'about_media_image',
				'type' => 'image',
			],
			[
				'key' => 'field_about_media_video_file',
				'label' => 'Видеофайл (опционально)',
				'name' => 'about_media_video_file',
				'type' => 'file',
				'instructions' => 'Загрузите видео в формате MP4, WebM или OGV. Если пусто — при клике откроется увеличенное изображение.',
				'mime_types' => 'mp4,webm,ogv',
			],
			[
				'key' => 'field_about_media_note',
				'label' => 'Заметка под медиа (опционально)',
				'name' => 'about_media_note',
				'type' => 'textarea',
				'rows' => 2,
				'new_lines' => 'wpautop',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'resident',
				],
			],
		],
	]);
}

// gallery
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_gallery',
		'title' => 'Секция "Галерея"',
		'fields' => [
			[
				'key' => 'field_gallery_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'gallery_label',
				'type' => 'text',
			],
			[
				'key' => 'field_gallery_title',
				'label' => 'Заголовок',
				'name' => 'gallery_title',
				'type' => 'text',
			],
			[
				'key' => 'field_gallery_max_slides',
				'label' => 'Максимальное количество отображаемых слайдов',
				'name' => 'gallery_max_slides',
				'type' => 'number',
				'default_value' => 4,
			],
			[
				'key' => 'field_gallery_images',
				'label' => 'Фотографии',
				'name' => 'gallery_images',
				'type' => 'gallery',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'resident',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-education-careers.php',
				],
			],
		],
	]);
}
// resident-events
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_resident_events_section',
		'title' => 'Секция "Курсы от резидента"',
		'fields' => [
			[
				'key' => 'field_resident_events_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Курсы от резидента</b><br/>Курсы автоматически подгружаются из типа записей Образование и карьера, привязанных к этому резиденту. Чтобы добавить событие перейдите в боковом меню > вкладка Курсу. <a href="' . admin_url('/edit.php?post_type=education_career') . '" target="_blank">Перейти</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_resident_events_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'resident_events_label',
				'type' => 'text',
			],
			[
				'key' => 'field_resident_events_title',
				'label' => 'Заголовок',
				'name' => 'resident_events_title',
				'type' => 'text',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'resident',
				],
			],
		],
	]);
}
// resident-contacts
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_resident_contacts',
		'title' => 'Контакты резидента',
		'fields' => [
			[
				'key' => 'field_resident_contacts_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'resident_contacts_label',
				'type' => 'text',
			],
			[
				'key' => 'field_resident_contacts_title',
				'label' => 'Заголовок',
				'name' => 'resident_contacts_title',
				'type' => 'text',
			],
			[
				'key' => 'field_resident_contacts_phones',
				'label' => 'Телефоны',
				'name' => 'resident_contacts_phones',
				'type' => 'repeater',
				'layout' => 'row',
				'collapsed' => 'field_resident_contacts_phone_number',
				'button_label' => 'Добавить телефон',
				'sub_fields' => [
					[
						'key' => 'field_resident_contacts_phone_number',
						'label' => 'Номер телефона',
						'name' => 'phone_number',
						'type' => 'text',
					],
					[
						'key' => 'field_resident_contacts_phone_name',
						'label' => 'Имя контакта',
						'name' => 'phone_name',
						'type' => 'text',
					],
				],
			],
			[
				'key' => 'field_resident_contacts_email',
				'label' => 'Email',
				'name' => 'resident_contacts_email',
				'type' => 'email',
			],
			[
				'key' => 'field_resident_contacts_address',
				'label' => 'Адрес',
				'name' => 'resident_contacts_address',
				'type' => 'textarea',
				'rows' => 2,
				'new_lines' => 'wpautop',
			],
			[
				'key' => 'field_resident_contacts_website',
				'label' => 'Сайт',
				'name' => 'resident_contacts_website',
				'type' => 'url',
			],

			[
				'key' => 'field_resident_contacts_socials',
				'label' => 'Социальные сети',
				'name' => 'resident_contacts_socials',
				'type' => 'repeater',
				'layout' => 'row',
				'collapsed' => 'field_resident_contacts_social_url',
				'button_label' => 'Добавить ссылку',
				'sub_fields' => [
					[
						'key' => 'field_resident_contacts_social_icon',
						'label' => 'Иконка',
						'name' => 'social_icon',
						'type' => 'image',
					],
					[
						'key' => 'field_resident_contacts_social_url',
						'label' => 'Ссылка',
						'name' => 'social_url',
						'type' => 'link',
					],
				],
			],
			[
				'key' => 'field_resident_contacts_map',
				'label' => 'Карта (shortcode или iframe)',
				'name' => 'resident_contacts_map',
				'type' => 'textarea',
				'rows' => 3,
				'instructions' => 'Вставьте shortcode плагина карты или iframe код (Яндекс/Google Maps)',
				'new_lines' => '',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'resident',
				],
			],
		],
		'position' => 'normal',
		'style' => 'default',
	]);
}
// other-residents
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_other_residents_section',
		'title' => 'Секция "Другие резиденты"',
		'fields' => [
			[
				'key' => 'field_other_residents_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Другие резиденты</b><br/>Автоматически выводятся другие резиденты (кроме текущего).',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_other_residents_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'other_residents_label',
				'type' => 'text',
			],
			[
				'key' => 'field_other_residents_title',
				'label' => 'Заголовок',
				'name' => 'other_residents_title',
				'type' => 'text',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'resident',
				],
			],
		],
		'position' => 'normal',
		'style' => 'default',
	]);
}
// resident-form
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_resident_form_section',
		'title' => 'Секция "Форма связи"',
		'fields' => [
			[
				'key' => 'field_resident_form_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'resident_form_label',
				'type' => 'text',
			],
			[
				'key' => 'field_resident_form_title',
				'label' => 'Заголовок',
				'name' => 'resident_form_title',
				'type' => 'text',
			],
			[
				'key' => 'field_resident_form_descr',
				'label' => 'Описание',
				'name' => 'resident_form_descr',
				'type' => 'textarea',
				'rows' => 3,
				'new_lines' => 'wpautop',
			],
			[
				'key' => 'field_resident_form_image',
				'label' => 'Фоновое изображение',
				'name' => 'resident_form_image',
				'type' => 'image',
			],
			[
				'key' => 'field_resident_form_shortcode',
				'label' => 'Форма (шорткод)',
				'name' => 'resident_form_shortcode',
				'type' => 'text',
				'instructions' => 'Вставьте шорткод формы, если необходимо, по умолчанию будет показана общая форма для резидентов',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'resident',
				],
			],
		],
		'position' => 'normal',
		'style' => 'default',
	]);
}
// about-block+cards
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_about_block',
		'title' => 'Секция "О галерее"',
		'fields' => [
			[
				'key' => 'field_about_block_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_about_block_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'about_block_label',
				'type' => 'text',
			],
			[
				'key' => 'field_about_block_title',
				'label' => 'Заголовок',
				'name' => 'about_block_title',
				'type' => 'text',
			],
			[
				'key' => 'field_about_block_descr',
				'label' => 'Описание',
				'name' => 'about_block_descr',
				'type' => 'wysiwyg',
			],


			// ==================== ВКЛАДКА: КАРТОЧКИ ====================
			[
				'key' => 'field_about_block_list_title',
				'label' => 'Заголовок списка карточек',
				'name' => 'about_block_list_title',
				'type' => 'text',
			],
			[
				'key' => 'field_about_block_tab_cards',
				'label' => 'Карточки',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_about_block_cards',
				'label' => 'Список карточек',
				'name' => 'about_block_cards',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_about_block_card_title',
				'button_label' => 'Добавить карточку',
				'sub_fields' => [
					[
						'key' => 'field_about_block_card_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],
					[
						'key' => 'field_about_block_card_title',
						'label' => 'Заголовок карточки',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_about_block_card_descr',
						'label' => 'Описание карточки',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			//[
			//	[
			//		'param' => 'post_type',
			//		'operator' => '==',
			//		'value' => 'resident',
			//	],
			//],
		],
	]);
}
// wishlist-empty
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_wishlist_empty_section',
		'title' => 'Секция "Пустое избранное"',
		'fields' => [
			[
				'key' => 'field_wishlist_empty_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Секция пустого избранного</b><br/>Отображается, когда список желаний пуст. Изображение имеет эффект параллакса.',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_wishlist_empty_image',
				'label' => 'Фоновое изображение',
				'name' => 'wishlist_empty_image',
				'type' => 'image',
				'instructions' => 'Рекомендуемый размер: 800×600px. Имеет эффект параллакса.',
				'return_format' => 'array',
			],
			[
				'key' => 'field_wishlist_empty_title',
				'label' => 'Заголовок',
				'name' => 'wishlist_empty_title',
				'type' => 'text',
			],
			[
				'key' => 'field_wishlist_empty_descr',
				'label' => 'Описание',
				'name' => 'wishlist_empty_descr',
				'type' => 'textarea',
				'rows' => 3,
				'new_lines' => 'wpautop',
			],
			[
				'key' => 'field_wishlist_empty_button',
				'label' => 'Кнопка',
				'name' => 'wishlist_empty_button',
				'type' => 'link',
				'instructions' => 'Выберите страницу или вставьте внешнюю ссылку',
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-wishlist.php',
				],
			],
		],
	]);
}

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_cta_section',
		'title' => 'CTA Секция (Call to Action)',
		'fields' => [
			[
				'key' => 'field_cta_image',
				'label' => 'Фоновое изображение',
				'name' => 'cta_image',
				'type' => 'image',
			],
			[
				'key' => 'field_cta_title',
				'label' => 'Заголовок',
				'name' => 'cta_title',
				'type' => 'text',
			],
			[
				'key' => 'field_cta_descr',
				'label' => 'Описание',
				'name' => 'cta_descr',
				'type' => 'wysiwyg',
				'rows' => 3,
			],
			[
				'key' => 'field_cta_button',
				'label' => 'Кнопка',
				'name' => 'cta_button',
				'type' => 'link',
				'instructions' => 'Выберите страницу или вставьте внешнюю ссылку',

			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-wishlist.php',
				],
			],
		],
	]);
}

// about-block
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_about_block_section',
		'title' => 'Секция "О галерее"',
		'fields' => [
			[
				'key' => 'field_about_block_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'about_block_label',
				'type' => 'text',
				'default_value' => 'О галерее',
			],
			[
				'key' => 'field_about_block_title',
				'label' => 'Заголовок',
				'name' => 'about_block_title',
				'type' => 'text',
			],
			[
				'key' => 'field_about_block_descr',
				'label' => 'Описание',
				'name' => 'about_block_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_about_block_list_title',
				'label' => 'Заголовок списка карточек (опционально)',
				'name' => 'about_block_list_title',
				'type' => 'text',
				'instructions' => 'Поле не обязательно',
			],
			[
				'key' => 'field_about_block_cards_message',
				'label' => 'Карточки преимуществ',
				'type' => 'message',
				'message' => 'Добавьте карточки с иконками, заголовками и описаниями.',
			],
			[
				'key' => 'field_about_block_cards',
				'label' => 'Карточки',
				'name' => 'about_block_cards',
				'type' => 'repeater',
				'button_label' => 'Добавить карточку',
				'collapsed' => 'field_about_block_card_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_about_block_card_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],
					[
						'key' => 'field_about_block_card_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_about_block_card_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'text',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-private-clients.php',
				],
			],
		],
	]);
}
// about-customers
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_customers_section',
		'title' => 'Секция "Для кого создана галерея"',
		'fields' => [
			[
				'key' => 'field_customers_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'customers_label',
				'type' => 'text',
			],
			[
				'key' => 'field_customers_title',
				'label' => 'Заголовок секции',
				'name' => 'customers_title',
				'type' => 'text',
			],
			[
				'key' => 'field_customers_cards',
				'label' => 'Карточки',
				'name' => 'customers_cards',
				'type' => 'repeater',
				'button_label' => 'Добавить карточку',
				'collapsed' => 'field_customers_card_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_customers_card_image',
						'label' => 'Изображение',
						'name' => 'image',
						'type' => 'image',
					],
					[
						'key' => 'field_customers_card_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => 'wpautop',
					],
					[
						'key' => 'field_customers_card_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 3,
					],
					[
						'key' => 'field_customers_card_link',
						'label' => 'Ссылка "Подробнее"',
						'name' => 'link',
						'type' => 'link',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-designer-consultation.php',
				],
			],
		],
	]);
}
// resident-why-it-works
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_resident_why_it_works',
		'title' => 'Секция "Почему RET HOUSE работает?"',
		'fields' => [
			[
				'key' => 'field_why_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'why_label',
				'type' => 'text',
			],
			[
				'key' => 'field_why_title',
				'label' => 'Заголовок секции',
				'name' => 'why_title',
				'type' => 'text',
			],
			[
				'key' => 'field_why_descr',
				'label' => 'Описание секции',
				'name' => 'why_descr',
				'type' => 'text',
			],
			[
				'key' => 'field_why_cards_message',
				'label' => 'Карточки сравнения',
				'type' => 'message',
				'message' => 'Добавьте карточки для сравнения. Обычно 2 карточки: негативная (недостатки) и позитивная (преимущества).',
			],
			[
				'key' => 'field_why_cards',
				'label' => 'Карточки',
				'name' => 'why_cards',
				'type' => 'repeater',
				'button_label' => 'Добавить карточку',
				'collapsed' => 'field_why_card_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_why_card_image',
						'label' => 'Изображение',
						'name' => 'image',
						'type' => 'image',
					],
					[
						'key' => 'field_why_card_title',
						'label' => 'Заголовок карточки',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_why_card_is_positive',
						'label' => 'Позитивная карточка?',
						'name' => 'is_positive',
						'type' => 'true_false',
						'ui' => 1,
						'default_value' => 0,
						'instructions' => 'Включите, если это карточка с преимуществами (RET HOUSE). Выключите, если с недостатками.',
						'ui_on_text' => 'Преимущества',
						'ui_off_text' => 'Недостатки',
					],
					[
						'key' => 'field_why_card_items',
						'label' => 'Пункты списка',
						'name' => 'items',
						'type' => 'repeater',
						'button_label' => 'Добавить пункт',
						'collapsed' => 'field_why_card_item_text',
						'layout' => 'table',
						'sub_fields' => [
							[
								'key' => 'field_why_card_item_text',
								'label' => 'Текст пункта',
								'name' => 'text',
								'type' => 'text',
							],
						],
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-suppliers-residents.php',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-schools-partners.php',
				],
			],
		],
	]);
}
// for-whom
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_for_whom_section',
		'title' => 'Секция "Как материал начинает работать"',
		'fields' => [
			[
				'key' => 'field_for_whom_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'for_whom_label',
				'type' => 'text',
			],
			[
				'key' => 'field_for_whom_title',
				'label' => 'Заголовок секции',
				'name' => 'for_whom_title',
				'type' => 'text',
				'default_value' => 'Как материал начинает работать в проектах',
			],
			[
				'key' => 'field_for_whom_steps_message',
				'label' => 'Шаги',
				'type' => 'message',
				'message' => 'Добавьте шаги в порядке их выполнения. Нумерация проставляется автоматически.',
			],
			[
				'key' => 'field_for_whom_steps',
				'label' => 'Шаги',
				'name' => 'for_whom_steps',
				'type' => 'repeater',
				'button_label' => 'Добавить шаг',
				'collapsed' => 'field_for_whom_step_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_for_whom_step_title',
						'label' => 'Заголовок шага',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_for_whom_step_descr',
						'label' => 'Описание шага',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 3,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-suppliers-residents.php',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-designers-architects.php',
				],
			],
		],
	]);
}

// resident-format
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_resident_format_section',
		'title' => 'Секция "Форматы участия"',
		'fields' => [
			[
				'key' => 'field_resident_format_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'resident_format_label',
				'type' => 'text',
				'default_value' => 'Форматы участия / Для кого подходит',
			],
			[
				'key' => 'field_resident_format_title',
				'label' => 'Заголовок секции',
				'name' => 'resident_format_title',
				'type' => 'text',
				'default_value' => 'Как можно представить бренд в RET HOUSE',
			],
			[
				'key' => 'field_resident_format_descr',
				'label' => 'Описание секции (если необходимо)',
				'name' => 'resident_format_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_resident_format_cards',
				'label' => 'Карточки',
				'name' => 'resident_format_cards',
				'type' => 'repeater',
				'button_label' => 'Добавить карточку',
				'collapsed' => 'field_resident_format_card_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_resident_format_card_image',
						'label' => 'Изображение',
						'name' => 'image',
						'type' => 'image',
					],
					[
						'key' => 'field_resident_format_card_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => 'wpautop',
					],
					[
						'key' => 'field_resident_format_card_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 3,
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-suppliers-residents.php',
				],
			],
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'events',
				],
			],
		],
	]);
}

// resident-why
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_resident_why_section',
		'title' => 'Секция "Кому подходит резидентство"',
		'fields' => [
			[
				'key' => 'field_resident_why_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'resident_why_label',
				'type' => 'text',
				'default_value' => 'Почему RET HOUSE',
			],
			[
				'key' => 'field_resident_why_title',
				'label' => 'Заголовок секции',
				'name' => 'resident_why_title',
				'type' => 'text',
				'default_value' => 'Кому подходит резидентство',
			],
			[
				'key' => 'field_resident_why_cards',
				'label' => 'Карточки',
				'name' => 'resident_why_cards',
				'type' => 'repeater',
				'button_label' => 'Добавить карточку',
				'collapsed' => 'field_resident_why_card_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_resident_why_card_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],
					[
						'key' => 'field_resident_why_card_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_resident_why_card_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 3,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-suppliers-residents.php',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-designers-architects.php',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-private-clients.php',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-schools-partners.php',
				],
			],
		],
	]);
}

// resident-brands
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_resident_brands_section',
		'title' => 'Секция "Резиденты RET HOUSE"',
		'fields' => [
			[
				'key' => 'field_resident_brands_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'resident_brands_label',
				'type' => 'text',
				'default_value' => 'Резиденты RET HOUSE',
			],
			[
				'key' => 'field_resident_brands_title',
				'label' => 'Заголовок секции',
				'name' => 'resident_brands_title',
				'type' => 'text',
				'default_value' => 'Бренды, уже представленные в галерее',
			],
			[
				'key' => 'field_resident_brands_descr',
				'label' => 'Описание (опционально)',
				'name' => 'resident_brands_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_resident_brands_limit',
				'label' => 'Количество брендов',
				'name' => 'resident_brands_limit',
				'type' => 'number',
				'default_value' => -1,
				'instructions' => '-1 = показать все записи resident. Укажите число, если нужно ограничить.',
				'min' => -1,
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-suppliers-residents.php',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-designers-architects.php',
				],
			],
		],
	]);
}


if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_resident_cta_section',
		'title' => 'Секция "CTA Резидентства"',
		'fields' => [
			[
				'key' => 'field_resident_cta_image',
				'label' => 'Фоновое изображение',
				'name' => 'resident_cta_image',
				'type' => 'image',
			],
			[
				'key' => 'field_resident_cta_title',
				'label' => 'Заголовок',
				'name' => 'resident_cta_title',
				'type' => 'text',
				'default_value' => 'Хотите представить бренд в RET HOUSE?',
			],
			[
				'key' => 'field_resident_cta_descr',
				'label' => 'Описание',
				'name' => 'resident_cta_descr',
				'type' => 'textarea',
				'rows' => 3,
				'new_lines' => 'wpautop',
				'default_value' => 'Оставьте заявку — мы обсудим ваш продукт, формат размещения и сценарии присутствия в галерее.',
			],
			[
				'key' => 'field_resident_cta_btn',
				'label' => 'Кнопка',
				'name' => 'resident_cta_btn',
				'type' => 'link',
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-suppliers-residents.php',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-private-clients.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-schools-partners.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-designer-consultation.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-events.php',
				],
			],
		],
	]);
}

// category-section
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_category_section',
		'title' => 'Секция "Категории резидентов"',
		'fields' => [
			[
				'key' => 'field_cat_sec_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'category_section_label',
				'type' => 'text',
				'default_value' => 'Материалы для вашего интерьера',
			],
			[
				'key' => 'field_cat_sec_title',
				'label' => 'Заголовок секции',
				'name' => 'category_section_title',
				'type' => 'text',
				'default_value' => 'Что можно подобрать в RET HOUSE',
			],
			[
				'key' => 'field_cat_sec_image',
				'label' => 'Фоновое изображение',
				'name' => 'category_section_image',
				'type' => 'image',
			],
			[
				'key' => 'field_cat_sec_btn',
				'label' => 'Кнопка',
				'name' => 'category_section_button',
				'type' => 'link',
				'instructions' => 'Ссылка на полный каталог или страницу со всеми категориями.',
				'default_value' => [
					'url' => '/resident/',
					'title' => 'Смотреть все категории',
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-designers-architects.php',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-private-clients.php',
				],
			],
		],
	]);
}

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_clients_order_section',
		'title' => 'Секция "Пространство для встреч с клиентами"',
		'fields' => [
			[
				'key' => 'field_clients_order_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'clients_order_label',
				'type' => 'text',
				'default_value' => 'Пространство для встреч с клиентами',
			],
			[
				'key' => 'field_clients_order_title',
				'label' => 'Заголовок секции',
				'name' => 'clients_order_title',
				'type' => 'text',
				'default_value' => 'Покажите материалы клиенту вживую',
			],
			[
				'key' => 'field_clients_order_descr',
				'label' => 'Описание',
				'name' => 'clients_order_descr',
				'type' => 'wysiwyg',
				'default_value' => 'В RET HOUSE можно обсудить проект, сравнить материалы и показать клиенту реальные фактуры, оттенки и сочетания. Это помогает принимать решения быстрее и увереннее.',
			],
			[
				'key' => 'field_clients_order_features',
				'label' => 'Список преимуществ',
				'name' => 'clients_order_features',
				'type' => 'repeater',
				'button_label' => 'Добавить пункт',
				'collapsed' => 'field_feature_text',
				'layout' => 'table',
				'sub_fields' => [
					[
						'key' => 'field_feature_text',
						'label' => 'Текст пункта',
						'name' => 'feature_text',
						'type' => 'text',
					],
				],
			],
			[
				'key' => 'field_clients_order_btn',
				'label' => 'Кнопка',
				'name' => 'clients_order_button',
				'type' => 'link',
				'default_value' => [
					'url' => '#modal-order',
					'title' => 'Забронировать стол',
				],
			],
			[
				'key' => 'field_clients_order_image',
				'label' => 'Фоновое изображение',
				'name' => 'clients_order_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-designers-architects.php',
				],
			],
		],
	]);
}

// visit-beneftits
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_visit_benefits_section',
		'title' => 'Секция "Преимущества посещения галереи"',
		'fields' => [
			[
				'key' => 'field_visit_benefits_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'visit_benefits_label',
				'type' => 'text',
				'default_value' => 'Преимущества посещения галереи',
			],
			[
				'key' => 'field_visit_benefits_title',
				'label' => 'Заголовок секции',
				'name' => 'visit_benefits_title',
				'type' => 'text',
				'default_value' => 'Увидеть, потрогать, сравнить',
			],
			[
				'key' => 'field_visit_benefits_items',
				'label' => 'Список преимуществ',
				'name' => 'visit_benefits_items',
				'type' => 'repeater',
				'button_label' => 'Добавить преимущество',
				'collapsed' => 'field_visit_benefits_item_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_visit_benefits_item_image',
						'label' => 'Изображение',
						'name' => 'image',
						'type' => 'image',
					],
					[
						'key' => 'field_visit_benefits_item_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_visit_benefits_item_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 3,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-private-clients.php',
				],
			],
		],
	]);
}

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_formats_section',
		'title' => 'Секция "Возможности пространства"',
		'fields' => [
			[
				'key' => 'field_formats_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'formats_label',
				'type' => 'text',
				'default_value' => 'Возможности пространства',
			],
			[
				'key' => 'field_formats_title',
				'label' => 'Заголовок секции',
				'name' => 'formats_title',
				'type' => 'text',
				'default_value' => 'Форматы, которые можно организовать',
			],
			[
				'key' => 'field_formats_items',
				'label' => 'Форматы мероприятий',
				'name' => 'formats_items',
				'type' => 'repeater',
				'button_label' => 'Добавить формат',
				'collapsed' => 'field_formats_item_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_formats_item_image',
						'label' => 'Изображение',
						'name' => 'image',
						'type' => 'image',
					],
					[
						'key' => 'field_formats_item_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_formats_item_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 3,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-schools-partners.php',
				],
			],
		],
	]);
}
// simple-process
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_simple_process_section',
		'title' => 'Секция "Простой процесс"',
		'fields' => [
			[
				'key' => 'field_simple_process_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'simple_process_label',
				'type' => 'text',
				'default_value' => 'Простой процесс',
			],
			[
				'key' => 'field_simple_process_title',
				'label' => 'Заголовок секции',
				'name' => 'simple_process_title',
				'type' => 'text',
				'default_value' => 'Как организовать совместный формат',
			],
			[
				'key' => 'field_simple_process_descr',
				'label' => 'Описание секции (опционально)',
				'name' => 'simple_process_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_simple_process_steps',
				'label' => 'Шаги процесса',
				'name' => 'simple_process_steps',
				'type' => 'repeater',
				'button_label' => 'Добавить шаг',
				'collapsed' => 'field_simple_process_step_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_simple_process_step_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],
					[
						'key' => 'field_simple_process_step_title',
						'label' => 'Заголовок шага',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_simple_process_step_descr',
						'label' => 'Описание шага',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 3,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-schools-partners.php',
				],
			],

			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-designer-consultation.php',
				],
			],

		],
	]);
}

// consultation-included
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_consultation_included_section',
		'title' => 'Секция "Консультация включена"',
		'fields' => [
			[
				'key' => 'field_consultation_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'consultation_label',
				'type' => 'text',
				'default_value' => 'Что входит в консультацию',
			],
			[
				'key' => 'field_consultation_title',
				'label' => 'Заголовок секции',
				'name' => 'consultation_title',
				'type' => 'text',
				'default_value' => 'Что мы поможем решить',
			],
			[
				'key' => 'field_consultation_image',
				'label' => 'Фоновое изображение',
				'name' => 'consultation_image',
				'type' => 'image',
				'return_format' => 'array',
			],
			[
				'key' => 'field_consultation_cards',
				'label' => 'Карточки',
				'name' => 'consultation_cards',
				'type' => 'repeater',
				'button_label' => 'Добавить карточку',
				'collapsed' => 'field_consultation_card_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_consultation_card_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',

					],
					[
						'key' => 'field_consultation_card_title',
						'label' => 'Заголовок карточки',
						'name' => 'title',
						'type' => 'text',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-designer-consultation.php',
				],
			],
		],
	]);
}
// results
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_results_section',
		'title' => 'Секция "Результат консультации"',
		'fields' => [
			[
				'key' => 'field_results_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'results_label',
				'type' => 'text',
				'default_value' => 'Результат консультации',
			],
			[
				'key' => 'field_results_title',
				'label' => 'Заголовок секции',
				'name' => 'results_title',
				'type' => 'text',
				'default_value' => 'Что вы получаете после консультации',
			],
			[
				'key' => 'field_results_descr',
				'label' => 'Описание секции',
				'name' => 'results_descr',
				'type' => 'textarea',
				'rows' => 2,
				'new_lines' => 'wpautop',
				'default_value' => 'Мы предлагаем не просто совет, а полноценное партнерство в создании вашего идеального пространства',
			],
			[
				'key' => 'field_results_items',
				'label' => 'Карточки результатов',
				'name' => 'results_items',
				'type' => 'repeater',
				'button_label' => 'Добавить карточку',
				'collapsed' => 'field_results_item_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_results_item_image',
						'label' => 'Изображение (опционально)',
						'name' => 'image',
						'type' => 'image',
					],
					[
						'key' => 'field_results_item_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_results_item_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 3,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-designer-consultation.php',
				],
			],
		],
	]);
}
// experts_section
if (function_exists('acf_add_local_field_group')) {

	// Поля для секции на странице
	acf_add_local_field_group([
		'key' => 'group_experts_section',
		'title' => 'Секция "Наши дизайнеры"',
		'fields' => [
			[
				'key' => 'field_experts_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'experts_label',
				'type' => 'text',
				'default_value' => 'Специалисты RET HOUSE',
			],
			[
				'key' => 'field_experts_title',
				'label' => 'Заголовок секции',
				'name' => 'experts_title',
				'type' => 'text',
				'default_value' => 'Наши дизайнеры',
			],
			[
				'key' => 'field_experts_limit',
				'label' => 'Количество экспертов',
				'name' => 'experts_limit',
				'type' => 'number',
				'default_value' => -1,
				'instructions' => '-1 = показать всех. Укажите число, если нужно ограничить.',
				'min' => -1,
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-designer-consultation.php',
				],
			],
		],
	]);
}
// section-faq
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_faq_section',
		'title' => 'Секция "Частые вопросы"',
		'fields' => [
			[
				'key' => 'field_faq_sec_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'faq_section_label',
				'type' => 'text',
				'default_value' => 'FAQ',
			],
			[
				'key' => 'field_faq_sec_title',
				'label' => 'Заголовок секции',
				'name' => 'faq_section_title',
				'type' => 'text',
				'default_value' => 'Частые вопросы',
			],
			[
				'key' => 'field_faq_sec_btn',
				'label' => 'Кнопка "Посмотреть все"',
				'name' => 'faq_section_button',
				'type' => 'link',
				'instructions' => 'Ссылка на страницу с дополнительной информацией (опционально).',
			],
			[
				'key' => 'field_faq_sec_image',
				'label' => 'Изображение секции',
				'name' => 'faq_section_image',
				'type' => 'image',
			],
			[
				'key' => 'field_faq_questions',
				'label' => 'Вопросы и ответы',
				'name' => 'faq_questions',
				'type' => 'repeater',
				'button_label' => 'Добавить вопрос',
				'collapsed' => 'field_faq_question_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_faq_question_title',
						'label' => 'Вопрос',
						'name' => 'question',
						'type' => 'text',
						'required' => 1,
					],
					[
						'key' => 'field_faq_question_answer',
						'label' => 'Ответ',
						'name' => 'answer',
						'type' => 'textarea',
						'rows' => 3,
						'new_lines' => 'wpautop',
					],
					[
						'key' => 'field_faq_question_is_active',
						'label' => 'Раскрыт по умолчанию?',
						'name' => 'is_active',
						'type' => 'true_false',
						'ui' => 1,
						'default_value' => 0,
						'instructions' => 'Включите только для одного вопроса (обычно первого), чтобы он был открыт при загрузке.',
						'ui_on_text' => 'Да, раскрыт',
						'ui_off_text' => 'Нет, свёрнут',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-designer-consultation.php',
				],
			],
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'education_career',
				],
			],
		],
	]);
}
// consultation-form
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_consultation_form_section',
		'title' => 'Секция "Форма консультации"',
		'fields' => [
			[
				'key' => 'field_consultation_form_title',
				'label' => 'Заголовок секции',
				'name' => 'consultation_form_title',
				'type' => 'text',
				'default_value' => 'Запишитесь на консультацию',
			],
			[
				'key' => 'field_consultation_form_descr',
				'label' => 'Описание',
				'name' => 'consultation_form_descr',
				'type' => 'wysiwyg',
				'default_value' => 'Расскажите, с каким вопросом вы хотите прийти на консультацию. Если есть план БТИ, метраж или фото помещения — прикрепите их, чтобы специалист заранее понял задачу.',
			],
			[
				'key' => 'field_consultation_form_shortcode',
				'label' => 'Шорткод формы',
				'name' => 'consultation_form_shortcode',
				'type' => 'textarea',
				'rows' => 2,
				'instructions' => 'Вставьте сюда шорткод вашей формы. Например: <code>[contact-form-7 id="123" title="Консультация"]</code> или <code>[wpforms id="123"]</code>.',
				'default_value' => '',
			],
			[
				'key' => 'field_consultation_form_image',
				'label' => 'Фоновое изображение',
				'name' => 'consultation_form_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-designer-consultation.php',
				],
			],
		],
	]);
}
// section-offers
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_offers',
		'title' => 'Секция "Возможности для развития"',
		'fields' => [
			[
				'key' => 'field_offers_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'section_offers_label',
				'type' => 'text',
				'default_value' => 'Что предлагает RET HOUSE',
			],
			[
				'key' => 'field_offers_title',
				'label' => 'Заголовок секции',
				'name' => 'section_offers_title',
				'type' => 'text',
				'default_value' => 'Возможности для вашего развития',
			],
			[
				'key' => 'field_offers_items',
				'label' => 'Карточки предложений',
				'name' => 'section_offers_items',
				'type' => 'repeater',
				'button_label' => 'Добавить карточку',
				'collapsed' => 'field_offers_item_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_offers_item_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],
					[
						'key' => 'field_offers_item_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_offers_item_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 3,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-education-careers.php',
				],
			],
		],
	]);
}

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_partnership_section',
		'title' => 'Секция "Партнёрство"',
		'fields' => [
			[
				'key' => 'field_partnership_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Секция "Партнёрство"</b><br/>Отображает заголовок и карточки с призывами к действию (например, "Предложить мероприятие" и "Карьера в RET HOUSE").',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_partnership_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'partnership_label',
				'type' => 'text',
				'default_value' => 'Хотите провести мероприятие в RET HOUSE?',
			],
			[
				'key' => 'field_partnership_title',
				'label' => 'Заголовок секции',
				'name' => 'partnership_title',
				'type' => 'text',
				'default_value' => 'Поделитесь опытом с профессиональным сообществом',
			],
			[
				'key' => 'field_partnership_descr',
				'label' => 'Описание секции',
				'name' => 'partnership_descr',
				'type' => 'wysiwyg',
				'new_lines' => 'wpautop',
				'default_value' => 'Если вы представляете бренд, школу, студию или экспертный проект — можно предложить лекцию, мастер-класс или презентацию.',
			],
			[
				'key' => 'field_partnership_cards',
				'label' => 'Карточки партнёрства',
				'name' => 'partnership_cards',
				'type' => 'repeater',
				'button_label' => 'Добавить карточку',
				'collapsed' => 'field_partnership_card_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_partnership_card_label',
						'label' => 'Метка карточки',
						'name' => 'label',
						'type' => 'text',
					],
					[
						'key' => 'field_partnership_card_title',
						'label' => 'Заголовок карточки',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_partnership_card_descr',
						'label' => 'Описание карточки',
						'name' => 'descr',
						'type' => 'wysiwyg',
					],
					[
						'key' => 'field_partnership_card_btn',
						'label' => 'Кнопка',
						'name' => 'btn',
						'type' => 'link',
					],
					[
						'key' => 'field_partnership_card_image',
						'label' => 'Изображение',
						'name' => 'image',
						'type' => 'image',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-education-careers.php',
				],
			],
		],
	]);
}

// course-audience
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_course_audience',
		'title' => 'Целевая аудитория курса',
		'fields' => [
			[
				'key' => 'field_course_audience_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'course_audience_label',
				'type' => 'text',
				'default_value' => 'Для кого',
			],
			[
				'key' => 'field_course_audience_title',
				'label' => 'Заголовок секции',
				'name' => 'course_audience_title',
				'type' => 'text',
				'default_value' => 'Кому подойдёт курс',
			],
			[
				'key' => 'field_course_audience_items',
				'label' => 'Аудитории',
				'name' => 'course_audience_items',
				'type' => 'repeater',
				'button_label' => 'Добавить аудиторию',
				'collapsed' => 'field_course_audience_item_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_course_audience_item_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],
					[
						'key' => 'field_course_audience_item_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
						'instructions' => 'Например: "Начинающим дизайнерам"',
					],
					[
						'key' => 'field_course_audience_item_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'education_career',
				],
			],
		],
	]);
}

// course-programs-and-results
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_course_programs_and_results',
		'title' => 'Программа курса и результаты',
		'fields' => [
			[
				'key' => 'field_results_label',
				'label' => 'Метка блока результатов',
				'name' => 'results_label',
				'type' => 'text',
				'default_value' => 'Навыки и результат',
			],
			[
				'key' => 'field_results_title',
				'label' => 'Заголовок блока результатов',
				'name' => 'results_title',
				'type' => 'text',
				'default_value' => 'Чему вы научитесь на курсе',
			],
			[
				'key' => 'field_skills_list',
				'label' => 'Список навыков',
				'name' => 'skills_list',
				'type' => 'repeater',
				'button_label' => 'Добавить навык',
				'collapsed' => 'field_skill_text',
				'layout' => 'table',
				'sub_fields' => [
					[
						'key' => 'field_skill_text',
						'label' => 'Текст навыка',
						'name' => 'skill_text',
						'type' => 'text',
					],
				],
			],
			[
				'key' => 'field_enroll_btn',
				'label' => 'Кнопка "Записаться"',
				'name' => 'enroll_btn',
				'type' => 'link',
			],
			[
				'key' => 'field_programs_label',
				'label' => 'Метка блока программы',
				'name' => 'programs_label',
				'type' => 'text',
				'default_value' => 'Программа',
			],
			[
				'key' => 'field_programs_title',
				'label' => 'Заголовок блока программы',
				'name' => 'programs_title',
				'type' => 'text',
				'default_value' => '4 занятия — от основы до готовой подборки',
			],
			[
				'key' => 'field_programs_list',
				'label' => 'Занятия курса',
				'name' => 'programs_list',
				'type' => 'repeater',
				'button_label' => 'Добавить занятие',
				'collapsed' => 'field_program_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_program_title',
						'label' => 'Заголовок занятия',
						'name' => 'title',
						'type' => 'text',
						'instructions' => 'Например: "Основы декорирования"',
					],
					[
						'key' => 'field_program_descr',
						'label' => 'Описание занятия',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => 'wpautop',
					],
					[
						'key' => 'field_program_image',
						'label' => 'Изображение занятия',
						'name' => 'image',
						'type' => 'image',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'education_career',
				],
			],
		],
	]);
}
// course_cta
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_course_cta',
		'title' => 'CTA блок записи на курс',
		'fields' => [
			[
				'key' => 'field_course_cta_title',
				'label' => 'Заголовок CTA',
				'name' => 'course_cta_title',
				'type' => 'text',
				'default_value' => 'Хотите записаться на курс?',
			],
			[
				'key' => 'field_course_cta_descr',
				'label' => 'Описание CTA',
				'name' => 'course_cta_descr',
				'type' => 'textarea',
				'rows' => 2,
				'default_value' => 'Оставьте заявку — мы свяжемся с вами, расскажем подробности и подтвердим участие.',
			],
			[
				'key' => 'field_course_cta_btn',
				'label' => 'Кнопка записи',
				'name' => 'course_cta_btn',
				'type' => 'link',
			],
			[
				'key' => 'field_course_cta_image',
				'label' => 'Изображение CTA',
				'name' => 'course_cta_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'education_career',
				],
			],
		],
	]);
}

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_event_featured',
		'title' => 'Избранное событие',
		'fields' => [
			[
				'key' => 'field_event_is_featured',
				'label' => 'Избранное',
				'name' => 'event_is_featured',
				'type' => 'true_false',
				'ui' => 1,
				'default_value' => 0,
				'instructions' => 'Включите для события, которое должно отображаться в блоке избранных.',
				'ui_on_text' => 'Да',
				'ui_off_text' => 'Нет',
			],
			[
				'key' => 'field_event_featured_label',
				'label' => 'Метка для избранного',
				'name' => 'event_featured_label',
				'type' => 'text',
				'default_value' => 'Ближайшее событие',
				'instructions' => 'Например: "Ближайшее событие", "СПЕЦИАЛЬНОЕ СОБЫТИЕ"',
				'conditional_logic' => [
					[
						[
							'field' => 'field_event_is_featured',
							'operator' => '==',
							'value' => '1',
						],
					],
				],
			]
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'events',
				],
			],
		],
	]);
}

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_event_content_media',
		'title' => 'Блок контента и картинки',
		'fields' => [
			[
				'key' => 'field_content_media_label',
				'label' => 'Метка (над заголовком)',
				'name' => 'content_media_label',
				'type' => 'text',
			],
			[
				'key' => 'field_content_media_title',
				'label' => 'Заголовок',
				'name' => 'content_media_title',
				'type' => 'text',
			],
			[
				'key' => 'field_content_media_descr',
				'label' => 'Описание',
				'name' => 'content_media_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_content_media_image',
				'label' => 'Изображение',
				'name' => 'content_media_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'events',
				],
			],
		],
	]);
}

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_event_expert_schedule',
		'title' => 'Эксперт и программа встречи',
		'fields' => [
			// ==================== БЛОК: ЭКСПЕРТ ====================
			[
				'key' => 'field_expert_image',
				'label' => 'Фото эксперта',
				'name' => 'expert_image',
				'type' => 'image',
			],
			[
				'key' => 'field_expert_label',
				'label' => 'Метка',
				'name' => 'expert_label',
				'type' => 'text',
				'default_value' => 'Встречу проводит',
			],
			[
				'key' => 'field_expert_name',
				'label' => 'Имя эксперта',
				'name' => 'expert_name',
				'type' => 'text',
			],
			[
				'key' => 'field_expert_about',
				'label' => 'Должность / Кратко',
				'name' => 'expert_about',
				'type' => 'text',
			],
			[
				'key' => 'field_expert_descr',
				'label' => 'Описание эксперта',
				'name' => 'expert_descr',
				'type' => 'textarea',
				'rows' => 3,
				'new_lines' => 'wpautop',
			],

			// ==================== БЛОК: РАСПИСАНИЕ ====================

			[
				'key' => 'field_schedule_title',
				'label' => 'Заголовок блока (Что будет на встрече?)',
				'name' => 'schedule_title',
				'type' => 'text',
				'default_value' => 'Что будет на встрече?',
			],
			[
				'key' => 'field_schedule_items',
				'label' => 'Пункты программы',
				'name' => 'schedule_items',
				'type' => 'repeater',
				'button_label' => 'Добавить пункт',
				'collapsed' => 'field_schedule_item_time',
				'layout' => 'table',
				'sub_fields' => [
					[
						'key' => 'field_schedule_item_time',
						'label' => 'Время',
						'name' => 'time',
						'type' => 'text',
						'width' => '20',
					],
					[
						'key' => 'field_schedule_item_title',
						'label' => 'Событие',
						'name' => 'title',
						'type' => 'text',
						'width' => '80',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'events',
				],
			],
		],
	]);
}

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_event_location',
		'title' => 'Место проведения',
		'fields' => [
			[
				'key' => 'field_location_label',
				'label' => 'Метка',
				'name' => 'location_label',
				'type' => 'text',
				'default_value' => 'Место проведения',
				'placeholder' => 'Например: "Место проведения"',
			],
			[
				'key' => 'field_location_title',
				'label' => 'Название места',
				'name' => 'location_title',
				'type' => 'text',
			],
			[
				'key' => 'field_location_address',
				'label' => 'Адрес',
				'name' => 'location_address',
				'type' => 'text',
			],
			[
				'key' => 'field_location_descr',
				'label' => 'Описание места',
				'name' => 'location_descr',
				'type' => 'textarea',
				'rows' => 4,
				'new_lines' => 'wpautop',
				'placeholder' => 'Описание пространства, где проходит мероприятие.',
			],
			[
				'key' => 'field_location_image',
				'label' => 'Фоновое изображение',
				'name' => 'location_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'events',
				],
			],
		],
	]);
}


if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_event_cta',
		'title' => 'CTA блок события',
		'fields' => [
			[
				'key' => 'field_event_cta_title',
				'label' => 'Заголовок CTA',
				'name' => 'event_cta_title',
				'type' => 'text',
			],
			[
				'key' => 'field_event_cta_descr',
				'label' => 'Описание CTA',
				'name' => 'event_cta_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_event_cta_address',
				'label' => 'Адрес мероприятия',
				'name' => 'event_cta_address',
				'type' => 'text',
			],
			[
				'key' => 'field_event_cta_form_shortcode',
				'label' => 'Шорткод формы',
				'name' => 'event_cta_form_shortcode',
				'type' => 'textarea',
				'rows' => 2,
				'instructions' => 'Вставьте шорткод вашей формы (например, [contact-form-7 id="123"] или [wpforms id="456"]).',
				'default_value' => '[contact-form-7 id="e0c34ff" title="Форма запись на мероприятие"]',
			],
			[
				'key' => 'field_event_cta_image',
				'label' => 'Фоновое изображение',
				'name' => 'event_cta_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'events',
				],
			],
		],
	]);
}

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_faq_form',
		'title' => 'CTA блок формы FAQ',
		'fields' => [
			[
				'key' => 'field_faq_form_title',
				'label' => 'Заголовок CTA',
				'name' => 'faq_form_title',
				'type' => 'text',
			],
			[
				'key' => 'field_faq_form_descr',
				'label' => 'Описание CTA',
				'name' => 'faq_form_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_faq_form_form_shortcode',
				'label' => 'Шорткод формы',
				'name' => 'faq_form_form_shortcode',
				'type' => 'textarea',
				'rows' => 2,
				'instructions' => 'Вставьте шорткод вашей формы (например, [contact-form-7 id="123"] или [wpforms id="456"]).',
				'default_value' => '[contact-form-7 id="52ec5ee" title="Форма страницы вопрос-ответ"]',
			],
			[
				'key' => 'field_faq_form_image',
				'label' => 'Фоновое изображение',
				'name' => 'faq_form_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-faq.php',
				],
			],
		],
	]);
}
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_faq_post_fields',
		'title' => 'Данные вкладки FAQ',
		'fields' => [
			[
				'key' => 'field_faq_image',
				'label' => 'Изображение вкладки',
				'name' => 'faq_image',
				'type' => 'image',
				'instructions' => 'Изображение слева от вопросов.',
			],
			[
				'key' => 'field_faq_questions',
				'label' => 'Вопросы и ответы',
				'name' => 'faq_questions',
				'type' => 'repeater',
				'button_label' => 'Добавить вопрос',
				'collapsed' => 'field_faq_question_title',
				'min' => 0,
				'max' => 0,
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_faq_question_title',
						'label' => 'Вопрос',
						'name' => 'question',
						'type' => 'text',
						'required' => 1,
					],
					[
						'key' => 'field_faq_question_answer',
						'label' => 'Ответ',
						'name' => 'answer',
						'type' => 'wysiwyg',
						'toolbar' => 'basic',
						'media_upload' => 0,
						'tabs' => 'visual',
						'required' => 1,
					],
					[
						'key' => 'field_faq_question_is_active',
						'label' => 'Раскрыт по умолчанию?',
						'name' => 'is_active',
						'type' => 'true_false',
						'ui' => 1,
						'default_value' => 0,
						'instructions' => 'Включите только для одного вопроса.',
						'ui_on_text' => 'Да',
						'ui_off_text' => 'Нет',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'faq',
				],
			],
		],
	]);
}

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_review_fields',
		'title' => 'Данные отзыва',
		'fields' => [
			[
				'key' => 'field_review_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Отзыв</b><br/>Загрузите фото обложку (миниатюра записи) ИЛИ укажите ссылку на видео. Если указано видео — оно откроется при нажатии на фото.',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_review_video_url',
				'label' => 'Ссылка на видео',
				'name' => 'review_video_url',
				'type' => 'file',
				'instructions' => 'Если заполнено — видео откроется в Fancybox при клике на обложку.',
			],
			[
				'key' => 'field_review_position',
				'label' => 'Должность / Статус',
				'name' => 'review_position',
				'type' => 'text',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'reviews',
				],
			],
		],
	]);
}