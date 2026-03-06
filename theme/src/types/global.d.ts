interface CookieFunctions {
	setCookie(name: string, value: string, exdays?: number): void;
	getCookie(name: string): string;
	deleteCookie(name: string): void;
	checkCookie(): boolean;
}

interface Window {
	cookieFunctions: CookieFunctions;
	themeConfig?: {
		fullpageLicenseKey?: string;
	};
}

declare module 'draggable' {
	export default class Draggable {
		constructor(element: HTMLElement, options?: Record<string, unknown>);
		set(x: number, y: number): void;
	}
}

declare module 'fullpage.js/vendors/scrolloverflow' {}

declare module 'fullpage.js/dist/fullpage' {
	interface FullPageDestination {
		index: number;
	}

	interface FullPageData {
		sectionSelector: string;
	}

	class fullpage {
		constructor(
			selector: string,
			options?: {
				navigation?: boolean;
				navigationPosition?: string;
				responsiveHeight?: number;
				scrollOverflow?: boolean;
				scrollOverflowOptions?: Record<string, unknown>;
				sectionSelector?: string;
				licenseKey?: string;
				lazyLoading?: boolean;
				afterLoad?: () => void;
				afterRender?: () => void;
				onLeave?: (origin: unknown, destination: FullPageDestination, direction: string) => void;
			},
		);
		destroy(type?: string): void;
		reBuild(): void;
		moveTo(section: number): void;
		moveSectionDown(): void;
		moveSectionUp(): void;
		getFullpageData(): FullPageData;
	}

	export default fullpage;
}

declare module 'sidebarjs/lib/umd/sidebarjs' {
	export class SidebarElement {
		constructor(options?: {
			backdropOpacity?: number;
			nativeSwipe?: boolean;
			position?: string;
		});
		open(): void;
		close(): void;
		isVisible(): boolean;
	}
}
