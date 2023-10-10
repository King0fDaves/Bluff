import { checkToken } from "$lib/Functions/ApiCalls/checkToken.js";

export async function load({ cookies, }) {
    const authToken = cookies.get('authCookie');
    const isValid = await checkToken(authToken);
    
    return {
        isAuthed:isValid,
        authToken:authToken
    }   
}