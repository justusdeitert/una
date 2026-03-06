window.cookieFunctions = {
    deleteCookie(name: string): void {
        document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; SameSite=Lax`;
    },

    setCookie(name: string, value: string, exdays = 12): void {
        const d = new Date();
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/;SameSite=Lax`;
    },

    getCookie(name: string): string {
        const prefix = `${name}=`;
        const cookies = decodeURIComponent(document.cookie).split(';');

        for (const cookie of cookies) {
            const trimmed = cookie.trimStart();
            if (trimmed.startsWith(prefix)) {
                return trimmed.substring(prefix.length);
            }
        }

        return '';
    },

    checkCookie(): boolean {
        return navigator.cookieEnabled;
    },
};
