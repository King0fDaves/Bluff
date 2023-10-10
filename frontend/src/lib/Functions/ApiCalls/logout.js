import { PUBLIC_ORIGIN } from "$env/static/public";

export const logout = async (authToken) => {

    const response = await fetch(`${PUBLIC_ORIGIN}/api/logout`, {
        method: 'DELETE',
        headers: {
            'Authorization':`Bearer ${authToken}`,
            "Accept": "application/vnd.api+json",
            "Content-Type": "application/vnd.api+json",
        }
    })

    return response
}

export default logout;