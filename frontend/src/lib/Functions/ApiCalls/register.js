import { PUBLIC_ORIGIN } from "$env/static/public";

export const register = async (params) => {
    const response = await fetch(`${PUBLIC_ORIGIN}/api/register`, {
        method: "POST",
        headers: {
            "Accept": "application/vnd.api+json",
            "Content-Type": "application/vnd.api+json",
        },
        body: JSON.stringify({
            name: params.username,
            password: params.password,
        }),
    });

    return response
}

export default register;