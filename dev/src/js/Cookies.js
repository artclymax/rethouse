export function cookies() {
	const banner = document.getElementById('cookie-banner');

	if (!banner) return;

	const acceptBtn = document.getElementById('cookie-accept');
	const declineBtn = document.getElementById('cookie-decline');
	const settingsBtn = document.getElementById('cookie-settings'); // Кнопка настроек
	const cookieName = 'cookie_consent';
	const cookieExpireDays = 365;

	// Функции работы с cookie
	function setCookie(name, value, days) {
		const expires = new Date();
		expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
		const cookieValue = encodeURIComponent(value);
		document.cookie = `${name}=${cookieValue}; expires=${expires.toUTCString()}; path=/; SameSite=Lax`;
	}

	function getCookie(name) {
		const nameEQ = name + '=';
		const cookies = document.cookie.split(';');
		for (let i = 0; i < cookies.length; i++) {
			let cookie = cookies[i].trim();
			if (cookie.indexOf(nameEQ) === 0) {
				return decodeURIComponent(cookie.substring(nameEQ.length));
			}
		}
		return null;
	}

	function hideBanner() {
		banner.classList.add('hide');
		banner.setAttribute('aria-hidden', 'true');
		
		// После завершения анимации добавляем display: none
		const handleTransitionEnd = () => {
			if (banner.classList.contains('hide')) {
				banner.style.display = 'none';
			}
			banner.removeEventListener('transitionend', handleTransitionEnd);
		};
		
		banner.addEventListener('transitionend', handleTransitionEnd);
	}

	function showBanner() {
		banner.style.display = ''; // Убираем display: none
		banner.classList.remove('hide');
		banner.setAttribute('aria-hidden', 'false');
	}

	// Проверяем, есть ли уже согласие
	const existingConsent = getCookie(cookieName);
	if (existingConsent) {
		// Если есть согласие, сразу скрываем без анимации
		banner.style.display = 'none';
		banner.setAttribute('aria-hidden', 'true');
		
		// Если пользователь согласился, запускаем аналитику
		if (existingConsent === 'accepted') {
			enableAnalytics();
		}
	}

	// Запуск аналитики (пример)
	function enableAnalytics() {
		// Здесь инициализация Google Analytics, Яндекс.Метрики и т.д.
		// console.log('Analytics enabled');
	}

	// Отключение аналитики (пример)
	function disableAnalytics() {
		// Здесь отключение скриптов аналитики
		// console.log('Analytics disabled');
	}

	// Обработчики кнопок
	if (acceptBtn) {
		acceptBtn.addEventListener('click', function () {
			setCookie(cookieName, 'accepted', cookieExpireDays);
			hideBanner();
			enableAnalytics();
			
			// Dispatch event для других скриптов
			document.dispatchEvent(new CustomEvent('cookieConsentAccepted'));
		});
	}

	if (declineBtn) {
		declineBtn.addEventListener('click', function () {
			setCookie(cookieName, 'declined', cookieExpireDays);
			hideBanner();
			disableAnalytics();
			
			// Dispatch event для других скриптов
			document.dispatchEvent(new CustomEvent('cookieConsentDeclined'));
		});
	}

	// Кнопка настроек (если есть)
	if (settingsBtn) {
		settingsBtn.addEventListener('click', function () {
			showBanner();
		});
	}
}