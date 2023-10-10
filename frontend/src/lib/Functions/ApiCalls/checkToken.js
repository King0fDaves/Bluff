import { PUBLIC_ORIGIN } from "$env/static/public";

export const checkToken = async (authToken) => {

    const response = await fetch(`${PUBLIC_ORIGIN}/api/token`, {
        method: 'GET',
        headers: {
            'Authorization':`Bearer ${authToken}`,
            "Accept": "application/vnd.api+json",
            "Content-Type": "application/vnd.api+json",
        }
    })

    if(response.ok){
        return true;
    }
    return false
}

export default checkToken;