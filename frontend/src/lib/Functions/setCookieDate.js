
export const setCookieDate  = (time) => { // Sets the expiration date of the cookie
    const expirationDays = time;
    const expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + expirationDays);
    return expirationDate.toUTCString();
}

export default setCookieDate