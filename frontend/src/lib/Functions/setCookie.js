import setCookieDate from "./setCookieDate";

const setCookie = (token, date) => { // Sets the cookie
    const theDate = setCookieDate(date)
    document.cookie = `authCookie=${token}; expires=${theDate}; path=/; SameSite=Strict; secure;`;
}

export default setCookie
