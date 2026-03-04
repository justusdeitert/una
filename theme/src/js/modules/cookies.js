window.cookieFunctions = {};

window.cookieFunctions.deleteCookie = function(name) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; SameSite=Lax';
};

window.cookieFunctions.setCookie = function(name, value, exdays) {
    if (exdays === undefined) {
        exdays = 12;
    }
    let d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = 'expires='+ d.toUTCString();
    document.cookie = name + '=' + value + ';' + expires + ';path=/;SameSite=Lax';
};

window.cookieFunctions.getCookie = function(name) {
    name = name + '=';
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i].trimStart();

        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return '';
};

window.cookieFunctions.checkCookie = function() {
    return navigator.cookieEnabled;
};
