function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for(let i=0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function acceptCookies() {
    setCookie('cookieConsent', 'true', 30);
    document.getElementById('cookie-banner').style.display = 'none';
    location.reload();
}

function refuseCookies() {
    // Supprimer le cookie de consentement (au cas où)
    setCookie('cookieConsent', 'false', 30);

    // Supprimer le cookie 'style' s'il existe
    document.cookie = "style=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

    document.getElementById('cookie-banner').style.display = 'none';
}

function showCookieBanner() {
    document.getElementById('cookie-banner').style.display = 'block';
}

function toggleHeureTable() {
    const table = document.getElementById("heureTable");
    const button = document.getElementById("toggleButton");

    if (table.style.display === "none") {
        table.style.display = "table";
        button.textContent = "Masquer les prévisions par heure";
    } else {
        table.style.display = "none";
        button.textContent = "Afficher les prévisions par heure";
    }
}

window.onload = function() {
    const consent = getCookie('cookieConsent');
    if (consent === null) {
        showCookieBanner();
    }
};