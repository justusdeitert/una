let allColors: string[] = [];

const getColorPool = (): string[] => {
	if (!navigator.cookieEnabled) return allColors;

	const stored = window.cookieFunctions.getCookie('colors');
	if (!stored) {
		window.cookieFunctions.setCookie('colors', JSON.stringify(allColors));
		return allColors;
	}

	const parsed: string[] = JSON.parse(stored);
	if (parsed.length === 0) {
		window.cookieFunctions.setCookie('colors', JSON.stringify(allColors));
		return allColors;
	}

	return parsed;
};

const pickRandomColor = (): string => {
	const pool = getColorPool();
	return pool[Math.floor(Math.random() * pool.length)];
};

const consumeColor = (color: string): void => {
	if (!navigator.cookieEnabled) return;

	const pool = getColorPool();
	if (pool.length > 1) {
		const index = pool.indexOf(color);
		if (index > -1) pool.splice(index, 1);
		window.cookieFunctions.setCookie('colors', JSON.stringify(pool));
	} else {
		window.cookieFunctions.setCookie('colors', JSON.stringify(allColors));
	}
};

const applyColor = (el: HTMLElement, color: string): void => {
	el.style.color = color;
	el.style.borderColor = color;
	el.querySelectorAll<HTMLElement>('h3, i').forEach((child) => {
		child.style.color = color;
	});
};

const clearColor = (el: HTMLElement): void => {
	el.style.color = '';
	el.style.borderColor = '';
	el.querySelectorAll<HTMLElement>('h3, i').forEach((child) => {
		child.style.color = '';
		child.style.borderColor = '';
	});
};

document.addEventListener('DOMContentLoaded', () => {
	const colorsDataEl = document.getElementById('theme-colors');
	allColors = colorsDataEl ? JSON.parse(colorsDataEl.dataset.colors || '[]') : [];

	// Highlight current menu item and store initial color
	const initialColors = new Map<HTMLElement, string>();
	const currentMenuItem = document.querySelector('.current-menu-item');
	if (currentMenuItem) {
		const color = pickRandomColor();
		currentMenuItem.querySelectorAll<HTMLElement>('a').forEach((a) => {
			a.style.color = color;
			a.style.borderColor = color;
			initialColors.set(a, color);
		});
	}

	// Hover color on links and colored elements
	document
		.querySelectorAll<HTMLElement>('.page-wrapper a, #cookie-notice a, .colored-hover')
		.forEach((el) => {
			const onHover = () => {
				const color = pickRandomColor();
				applyColor(el, color);
				consumeColor(color);
			};

			const onLeave = () => {
				const initial = initialColors.get(el);
				if (initial) {
					applyColor(el, initial);
				} else {
					clearColor(el);
				}
			};

			el.addEventListener('mouseover', onHover);
			el.addEventListener('mouseout', onLeave);
		});

	// Hover overlay on image wrappers
	document.querySelectorAll<HTMLElement>('.image-wrapper').forEach((el) => {
		const onHover = () => {
			const color = pickRandomColor();
			el.classList.add('active');
			const overlay = el.querySelector<HTMLElement>('.hover-overlay');
			if (overlay) overlay.style.backgroundColor = color;
			consumeColor(color);
		};

		const onLeave = () => {
			el.classList.remove('active');
			const overlay = el.querySelector<HTMLElement>('.hover-overlay');
			if (overlay) overlay.style.backgroundColor = '';
		};

		el.addEventListener('mouseover', onHover);
		el.addEventListener('mouseout', onLeave);
	});
});
