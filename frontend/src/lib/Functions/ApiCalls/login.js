import { PUBLIC_ORIGIN } from "$env/static/public";

export const login = async (params) => {
    const response = await fetch(`${PUBLIC_ORIGIN}/api/login`, {
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

export default login;