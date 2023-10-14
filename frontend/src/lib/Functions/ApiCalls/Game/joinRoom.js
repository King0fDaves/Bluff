import { PUBLIC_ORIGIN } from "$env/static/public";


export const joinRoom = async (authToken, params) => {
    const response = await fetch(`${PUBLIC_ORIGIN}/api/join-room`, {
        method: "POST",
        headers: {
            'Authorization':`Bearer ${authToken}`,
            "Accept": "application/vnd.api+json",
            "Content-Type": "application/vnd.api+json",
        },
        body: JSON.stringify({
            code: params.code,

        }),
    });

    return response
}

export default joinRoom;