//import 'jarallax/dist/jarallax.min.css';
import "@fancyapps/ui/dist/fancybox/fancybox.css";
//import "aos/dist/aos.css";
import './scss/style.scss';
//!
import { Swiper } from "swiper/bundle";

//import { jarallax } from "jarallax";
import { Fancybox } from "@fancyapps/ui/dist/fancybox/";
//import AOS from "AOS";

import { AutoCalc } from "./js/AutoCalc.js";
import { Menu } from './js/Menu.js';
//import { RunningLine } from './js/RunningLine.js';
//import { BackdropList } from './js/BackdropList.js';
import { Modal } from './js/Modal.js';
import { cookies } from "./js/Cookies.js";
//import { AnimationCounter } from "./js/AnimationCounter.js";
//import HiddenDescr from "./js/HiddenDescr.js";
//import HiddenList from "./js/HiddenList.js";
import { imask } from "./js/imask.js";
import { fileBtn } from "./js/FileBtn.js";
//import { CustomFieldSelect } from "./js/CustomFieldSelect.js";
import { Spoiler } from './js/Spoiler.js';
import { ScrollToTop } from './js/ScrollToTop.js';
import { MXSwiper } from './js/MXSwiper.js';
import { CustomSelect } from './js/CustomSelect.js';
import { Tabs } from './js/Tabs.js';
//import { MapScrollLock } from './js/MapScrollLock.js';
//import { cf7CustomValidation } from './js/cf7-validation.js';
//import { SelectFromAcf } from './js/SelectFromAcf.js';
//import { loadMore } from './js/loadMore.js';
import AirDatepicker from 'air-datepicker';
import 'air-datepicker/air-datepicker.css';
document.querySelectorAll('input.form-input-date')?.forEach(input => {
	new AirDatepicker(input, {
		selectedDates: [new Date()],
		isMobile: true,
		autoClose: true,
		minDate: new Date(),
	});
})
document.querySelectorAll('input.form-input-time')?.forEach(input => {
	new AirDatepicker(input, {
		isMobile: true,
		autoClose: true,
		timepicker: true,
		onlyTimepicker: true
	});
})
//cf7CustomValidation();

// FOR CONTACTS FORM 7
//import "./js/redirect-to-thanks-page.js";


new AutoCalc();
//new CustomFieldSelect({
//	input: '.form-wrapper .cf-select',
//	lastEdit: false
//});
new Menu({
	btn: '.burger-btn', //.burger-btn-icon
	menu: '.header-menu',
	activeClass: 'open-header-menu',
	//closeBtns: ['.menu-close-btn']
})
new Menu({
	btn: '.filter-mobile-btn',
	menu: '.filter',
	activeClass: 'open-filter-menu',
	closeBtns: ['.filter-close-btn']
})
//new Menu({
//	btn: '.header__phone-btn', //.burger-btn-icon
//	menu: '.header-phone-box',
//	activeClass: 'open-phone-box',
//	//closeBtns: ['.menu-close-btn']
//})

//new BackdropList();

new Modal();

//jarallax(document.querySelectorAll('.jarallax'), {
//	speed: 0.2,
//});

cookies();
imask();

Fancybox.bind("[data-fancybox]", {
	placeFocusBack: false
});

//new RunningLine();
new ScrollToTop();

new Spoiler();

//new Spoiler('[data-spoiler]', {
//	onlyOneOpen: true,
//	activeClass: 'is-open',
//});

//new Spoiler('[data-spoiler]', { media: 'max-width: 768px' });

new MXSwiper();
//new Tabs();
new CustomSelect({
	selector: 'select',
	forceSend: true,
});

//new MapScrollLock();
/*
window.addEventListener('scroll', function () {
	const header = document.querySelector('.header');

	if (window.scrollY > 50) {
		header.classList.add('scrolled');
	} else {
		header.classList.remove('scrolled');
		const valueUnits = header.offsetHeight;
		document.querySelector(':root').style.setProperty(`--header-height`, valueUnits + 'px');
	}
});
*/

fileBtn();//

new Tabs();

//document.querySelectorAll('video.wp-video-shortcode').forEach(video => {
//	if (!video.src) {
//		const link = video.querySelector('a');
//		if (link) video.src = link.href;
//	}
//});

document?.querySelectorAll('.wpcf7-acceptance input[type="checkbox"]')?.forEach(el => {
	el.checked = true;
})

//AOS.init({
//	disable: 'mobile',
//	duration: 600,
//	offset: 0
//});

//new SelectFromAcf('.custom-select-product', {
//	data: '.select-products-data'
//})
//loadMore();

//const modalInputBtns = document.querySelectorAll('[data-modal-input-data]');

//if (modalInputBtns.length) {
//	modalInputBtns.forEach(btn => {
//		btn.addEventListener('click', () => {
//			const inputsService = document.querySelectorAll('.form-input-service');
//			const inputsJobs = document.querySelectorAll('.form-input-job');
//			if (inputsService.length) {
//				inputsService.forEach(input => {
//					const modalTitle = input.closest('.modal')?.querySelector('.modal__title');
//					input.value = input.placeholder + ' ' + btn.getAttribute('data-modal-input-data');
//					if (modalTitle) {
//						input.closest('.form-field--hidden').style.display = 'none';
//						modalTitle.textContent = input.value;
//					}
//				})
//			}
//			if (inputsJobs.length) {
//				inputsJobs.forEach(input => {
//					input.value = input.placeholder + ' ' + btn.getAttribute('data-modal-input-data');
//				})
//			}
//		});
//	})
//}

//const megaMenuItems = document.querySelectorAll('.mega-menu > .menu-item-has-children');
//const megaMenuSubItems = document.querySelectorAll('.mega-menu > .menu-item-has-children > .sub-menu .menu-item-has-children');

//// 1. Обработчик для верхнего уровня
//if (megaMenuItems.length) {
//	megaMenuItems.forEach(item => {
//		item.addEventListener('click', (e) => {
//			// Закрываем все остальные открытые пункты верхнего уровня
//			megaMenuItems.forEach(i => {
//				if (i !== item) i.classList.remove('open-submenu');
//			});
//			// Переключаем текущий
//			item.classList.toggle('open-submenu');
//		});
//	});
//}

//// 2. Обработчик для вложенного уровня (submenu)
//if (megaMenuSubItems.length) {
//	megaMenuSubItems.forEach(item => {
//		item.addEventListener('click', (e) => {
//			// !!! ГЛАВНОЕ ИЗМЕНЕНИЕ !!!
//			// Останавливаем всплытие, чтобы клик не дошел до родителя
//			e.stopPropagation();

//			// Закрываем соседние открытые подменю на этом же уровне
//			// (Это лучше, чем закрывать вообще все подменю на странице)
//			const siblings = item.parentElement.querySelectorAll(':scope > .menu-item-has-children');
//			siblings.forEach(sibling => {
//				if (sibling !== item) sibling.classList.remove('open-submenu');
//			});

//			// Переключаем текущее вложенное меню
//			item.classList.toggle('open-submenu');
//		});
//	});
//}
//AnimationCounter();
//HiddenDescr();
//HiddenList();

//document.addEventListener('DOMContentLoaded', function () {
//	var forms = document.querySelectorAll('.variations_form');

//	forms.forEach(function (form) {

//		// 1. Делегированный клик по кнопкам вариаций
//		form.addEventListener('click', function (e) {
//			var btn = e.target.closest('.variations__btn');
//			if (!btn || !form.contains(btn)) return;

//			e.preventDefault();

//			// Если кнопка уже активна — ничего не делаем (нельзя снять выбор)
//			if (btn.classList.contains('active')) {
//				return;
//			}

//			var attribute = btn.dataset.attribute;
//			var value = btn.dataset.value;

//			// Ищем нативный скрытый select
//			var select = form.querySelector('select[name="attribute_' + attribute + '"]');
//			if (!select) return;

//			// Убираем активность со всех кнопок этой группы
//			var sublist = btn.closest('.variations__sublist');
//			if (sublist) {
//				sublist.querySelectorAll('.variations__btn').forEach(function (b) {
//					b.classList.remove('active', 'selected');
//				});
//			}

//			// Устанавливаем новую активность
//			btn.classList.add('active', 'selected');
//			select.value = value;

//			// Триггерим нативное событие change
//			select.dispatchEvent(new Event('change', { bubbles: true }));
//		});

//		// 2. Удаляем нативную ссылку "Сбросить" (чтобы нельзя было сбросить выбор)
//		var resetLink = form.querySelector('.reset_variations');
//		if (resetLink) {
//			resetLink.remove();
//		}

//		// 3. Синхронизация кнопок, когда WC сам меняет селекты
//		// (например, при переходе по прямой ссылке на вариацию)
//		// Слушаем нативное событие change на всех селектах
//		form.querySelectorAll('select[name^="attribute_"]').forEach(function (select) {
//			select.addEventListener('change', function () {
//				syncButtonsWithSelects(form);
//			});
//		});

//		// 4. АВТОВЫБОР: При загрузке страницы триггерим change для всех селектов,
//		// чтобы WC обработал автовыбранную вариацию (обновил цену, разблокировал кнопку)
//		setTimeout(function () {
//			var hasSelection = false;

//			form.querySelectorAll('select[name^="attribute_"]').forEach(function (select) {
//				if (select.value) {
//					hasSelection = true;
//					select.dispatchEvent(new Event('change', { bubbles: true }));
//				}
//			});

//			// Если есть автовыбор, принудительно обновляем форму через WC
//			if (hasSelection && typeof jQuery !== 'undefined') {
//				jQuery(form).trigger('check_variations');
//			}
//		}, 100);
//	});

//	// Функция синхронизации кнопок со значениями селектов
//	function syncButtonsWithSelects(form) {
//		form.querySelectorAll('select[name^="attribute_"]').forEach(function (select) {
//			var attrName = select.getAttribute('name').replace('attribute_', '');
//			var val = select.value;

//			// Убираем активность со всех кнопок этой атрибутки
//			form.querySelectorAll('.variations__btn[data-attribute="' + attrName + '"]').forEach(function (btn) {
//				btn.classList.remove('active', 'selected');
//			});

//			// Если есть значение — активируем соответствующую кнопку
//			if (val) {
//				var targetBtn = form.querySelector('.variations__btn[data-attribute="' + attrName + '"][data-value="' + val + '"]');
//				if (targetBtn) {
//					targetBtn.classList.add('active', 'selected');
//				}
//			}
//		});
//	}
//});

//(function () {
//	'use strict';

//	document.addEventListener('DOMContentLoaded', function () {
//		var forms = document.querySelectorAll('.variations_form');

//		forms.forEach(function (form) {

//			// 1. Делегированный клик по кнопкам вариаций
//			form.addEventListener('click', function (e) {
//				var btn = e.target.closest('.variations__btn');
//				if (!btn || !form.contains(btn)) return;

//				e.preventDefault();

//				if (btn.classList.contains('active')) {
//					return;
//				}

//				var attribute = btn.dataset.attribute;
//				var value = btn.dataset.value;

//				var select = form.querySelector('select[name="attribute_' + attribute + '"]');
//				if (!select) return;

//				var sublist = btn.closest('.variations__sublist');
//				if (sublist) {
//					sublist.querySelectorAll('.variations__btn').forEach(function (b) {
//						b.classList.remove('active', 'selected');
//					});
//				}

//				btn.classList.add('active', 'selected');
//				select.value = value;

//				select.dispatchEvent(new Event('change', { bubbles: true }));
//			});

//			// 2. Удаляем нативную ссылку "Сбросить"
//			var resetLink = form.querySelector('.reset_variations');
//			if (resetLink) {
//				resetLink.remove();
//			}

//			// 3. Синхронизация кнопок со значениями селектов
//			form.querySelectorAll('select[name^="attribute_"]').forEach(function (select) {
//				select.addEventListener('change', function () {
//					syncButtonsWithSelects(form);
//				});
//			});

//			// 4. АВТОВЫБОР при загрузке
//			setTimeout(function () {
//				var hasSelection = false;

//				form.querySelectorAll('select[name^="attribute_"]').forEach(function (select) {
//					if (select.value) {
//						hasSelection = true;
//						select.dispatchEvent(new Event('change', { bubbles: true }));
//					}
//				});

//				if (hasSelection && typeof jQuery !== 'undefined') {
//					jQuery(form).trigger('check_variations');
//				}
//			}, 100);

//			// ========== НОВОЕ: Обновление цены и меток ==========

//			// Сохраняем дефолтную цену родительского продукта
//			var defaultPrice = form.querySelector('.price-value');
//			if (defaultPrice) {
//				defaultPrice.dataset.defaultPrice = defaultPrice.innerHTML;
//			}

//			// Слушаем событие found_variation (когда WC находит валидную вариацию)
//			// Используем jQuery, т.к. WC использует jQuery events
//			if (typeof jQuery !== 'undefined') {
//				jQuery(form).on('found_variation', function (event, variation) {
//					//console.log('Found variation:', variation);

//					// Обновляем цену
//					var priceElement = form.querySelector('.price-value');
//					if (priceElement && variation.price_html) {
//						priceElement.innerHTML = variation.price_html;
//					}

//					// Обновляем артикул
//					var skuElement = form.querySelector('.variation-sku');
//					if (skuElement) {
//						skuElement.textContent = variation.sku || 'Нет';
//					}

//					// Обновляем наличие
//					var stockElement = form.querySelector('.variation-stock');
//					if (stockElement) {
//						if (variation.is_in_stock) {
//							if (variation.is_purchasable && variation.in_stock > 0) {
//								stockElement.textContent = variation.in_stock + ' шт.';
//							} else {
//								stockElement.textContent = 'В наличии';
//							}
//						} else {
//							stockElement.textContent = 'Нет в наличии';
//						}
//					}
//				});

//				// Слушаем событие reset_data (когда выбор сброшен)
//				jQuery(form).on('reset_data', function () {
//					//console.log('Variation reset');

//					// Возвращаем дефолтную цену
//					var priceElement = form.querySelector('.price-value');
//					if (priceElement && priceElement.dataset.defaultPrice) {
//						priceElement.innerHTML = priceElement.dataset.defaultPrice;
//					}

//					// Сбрасываем артикул
//					var skuElement = form.querySelector('.variation-sku');
//					if (skuElement) {
//						skuElement.textContent = '-';
//					}

//					// Сбрасываем наличие
//					var stockElement = form.querySelector('.variation-stock');
//					if (stockElement) {
//						stockElement.textContent = '-';
//					}
//				});
//			}
//		});

//		// Функция синхронизации кнопок со значениями селектов
//		function syncButtonsWithSelects(form) {
//			form.querySelectorAll('select[name^="attribute_"]').forEach(function (select) {
//				var attrName = select.getAttribute('name').replace('attribute_', '');
//				var val = select.value;

//				form.querySelectorAll('.variations__btn[data-attribute="' + attrName + '"]').forEach(function (btn) {
//					btn.classList.remove('active', 'selected');
//				});

//				if (val) {
//					var targetBtn = form.querySelector('.variations__btn[data-attribute="' + attrName + '"][data-value="' + val + '"]');
//					if (targetBtn) {
//						targetBtn.classList.add('active', 'selected');
//					}
//				}
//			});
//		}
//	});
//})();
//(function () {
//	'use strict';

//	document.addEventListener('DOMContentLoaded', function () {

//		if (typeof jQuery === 'undefined') {
//			console.warn('[Cart Counter] jQuery не загружен');
//			return;
//		}

//		// Слушаем событие, когда WooCommerce ОБНОВИЛ фрагменты
//		jQuery(document.body).on('wc_fragments_refreshed wc_fragments_loaded added_to_cart removed_from_cart', function () {
//			var counter = document.getElementById('cart-counter');
//			if (!counter) {
//				//console.warn('[Cart Counter] Элемент #cart-counter не найден');
//				return;
//			}

//			var count = parseInt(counter.textContent.trim()) || 0;
//			//console.log('[Cart Counter] Обновлено количество:', count);

//			// Показываем/скрываем счётчик
//			if (count > 0) {
//				counter.style.display = '';
//				// Анимация
//				counter.classList.add('pulse');
//				setTimeout(function () {
//					counter.classList.remove('pulse');
//				}, 400);
//			} else {
//				counter.style.display = 'none';
//			}
//		});

//		// Отладка: смотрим, что возвращает WooCommerce
//		//jQuery(document.body).on('added_to_cart', function (event, fragments, cart_hash) {
//		//	console.log('[Cart Counter] added_to_cart сработал');
//		//	console.log('[Cart Counter] Fragments:', fragments);
//		//});
//	});
//})();

// Thumbs Swiper
//const thumbsSwiper = new Swiper('.product-hero-thumbs', {
//	spaceBetween: 5,
//	slidesPerView: 4,
//	freeMode: true,
//	watchSlidesProgress: true,
//	breakpoints: {
//		768: {
//			spaceBetween: 10,
//		},
//	}
//});

// Main Gallery Swiper
//const gallerySwiper = new Swiper('.product-hero-gallery', {
//	spaceBetween: 10,
//	effect: 'fade',
//	fadeEffect: { crossFade: true },
//	rewind: true,
//	thumbs: {
//		swiper: thumbsSwiper,
//	},
//	navigation: {
//		nextEl: '.product-hero-thumbs__btn-next',
//		prevEl: '.product-hero-thumbs__btn-prev',
//	},
//});

document.addEventListener('DOMContentLoaded', function () {
	const tabContainers = document.querySelectorAll('.courses-tabs');

	tabContainers.forEach(container => {
		const buttons = container.querySelectorAll('.courses-tabs__btn');
		const swiperContainer = container.parentElement.querySelector('.events-swiper');

		if (!swiperContainer) return;
		const swiper = swiperContainer.swiper;

		buttons.forEach(btn => {
			btn.addEventListener('click', function () {
				const targetCategory = this.getAttribute('data-courses-tab');

				// 1. Переключаем активный класс
				buttons.forEach(b => b.classList.remove('active'));
				this.classList.add('active');

				// 2. Фильтруем слайды
				const slides = swiperContainer.querySelectorAll('.swiper-slide');
				let visibleCount = 0;

				slides.forEach(slide => {
					// Получаем строку категорий, разбиваем на массив
					const slideCategoriesStr = slide.getAttribute('data-category') || 'all';
					const slideCategoriesArray = slideCategoriesStr.split(' ');

					// Проверяем: если "all" ИЛИ если массив категорий слайда включает выбранную
					if (targetCategory === 'all' || slideCategoriesArray.includes(targetCategory)) {
						slide.classList.remove('hidden-slide');
						visibleCount++;
					} else {
						slide.classList.add('hidden-slide');
					}
				});

				// 3. Обновляем Swiper
				if (swiper) {
					setTimeout(() => {
						swiper.update();
						if (visibleCount > 0) {
							swiper.slideTo(0, 0); // Возврат к началу
						}
						if (swiper.pagination && swiper.pagination.el) {
							swiper.pagination.update();
						}
					}, 50);
				}
			});
		});
	});
});

document.addEventListener('DOMContentLoaded', function () {
	const faqTabs = document.querySelector('.faq-tabs');
	if (!faqTabs) return;

	const tabButtons = faqTabs.querySelectorAll('.faq-tabs__btn');
	const tabPanels = document.querySelectorAll('.faq-tab-panel');

	tabButtons.forEach(btn => {
		btn.addEventListener('click', function () {
			const targetTabId = this.getAttribute('data-faq-tab');

			// Убираем active у всех кнопок
			tabButtons.forEach(b => b.classList.remove('active'));
			// Добавляем active текущей кнопке
			this.classList.add('active');

			// Скрываем все панели
			tabPanels.forEach(panel => {
				panel.classList.remove('active');
			});

			// Показываем нужную панель
			const activePanel = document.querySelector(`[data-faq-panel="${targetTabId}"]`);
			if (activePanel) {
				activePanel.classList.add('active');
			}

			// Прокрутка к началу секции на мобильных
			if (window.innerWidth < 768) {
				faqTabs.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
			}
		});
	});
});

const allDataBtns = document.querySelectorAll('[data-modal-input-btn]');
document.addEventListener('click', function (e) {
	const inputs = document.querySelectorAll('.form-input-data');
	if (e.target.closest('[data-modal-input-btn]')) {
		const textContent = e.target.closest('[data-modal-input-btn]').getAttribute('data-modal-input-btn');
		inputs.forEach(input => {
			input.value = textContent;
			input.innerText = "«" + textContent + "»";
		})
	} else if (e.target.closest('a')) {
		inputs.forEach(input => {
			input.value = '';
			input.innerText = '';
		})
	}
})

const eventInputData = document.querySelector('[data-event-input-title]');
const inputsData = document.querySelectorAll('[data-event-input-title] .form-input-data');
if (inputsData.length && eventInputData) {
	inputsData.forEach(input => {
		input.value = eventInputData.getAttribute('data-event-input-title');
	})
}
