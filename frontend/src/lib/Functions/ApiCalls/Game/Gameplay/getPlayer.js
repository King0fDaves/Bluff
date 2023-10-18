import { PUBLIC_ORIGIN } from "$env/static/public";

export const getPlayer = async (authToken, params) => {
    const response = await fetch(`${PUBLIC_ORIGIN}/api/check-room`, {
        method: "POST",
        headers: {
            'Authorization':`Bearer ${authToken}`,
            "Accept": "application/vnd.api+json",
            "Content-Type": "application/vnd.api+json",
        },
        body: JSON.stringify({
            id: params.id,
        }),
    });


    return response;
}

export default getPlayer;