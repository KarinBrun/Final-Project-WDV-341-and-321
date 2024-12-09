function setCookie(cookieName, cookieValue, expireDays){
    let expires = "";

    if (expireDays){
        const today = new Date();
        today.setTime(today.getTime() + (expireDays * 24 * 60 * 60 * 1000)); //convert days to milliseconds
        expires = "; expires=" + today.toUTCString();
    }

    document.cookie = cookieName + "=" + encodeURIComponent(cookieValue) + expires;
}//end setCookie()

function getCookieValue(name){
    const cookies = document.cookie.split(';');

    for (let cookie of cookies){
        const [cookieName, cookieValue] = cookie.trim().split('=');

        if (cookieName === name){
            return decodeURIComponent(cookieValue);
        }
    }

    return null;
}//end getCookieValue()

function deleteCookie(cookieName){
    document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
}//end deleteCookie()