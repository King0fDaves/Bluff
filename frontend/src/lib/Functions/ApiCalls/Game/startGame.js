import { PUBLIC_ORIGIN } from "$env/static/public";

export const startGame = async (authToken, params) => {
    const response = await fetch(`${PUBLIC_ORIGIN}/api/start-game`, {
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

    return response
}

export default startGame;