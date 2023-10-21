import { PUBLIC_ORIGIN } from "$env/static/public";

export const putCards = async (authToken, params) => {
    const response = await fetch(`${PUBLIC_ORIGIN}/api/place-cards`, {
        method: "POST",
        headers: {
            'Authorization':`Bearer ${authToken}`,
            "Accept": "application/vnd.api+json",
            "Content-Type": "application/vnd.api+json",
        },
        body: JSON.stringify({
            id: params.id,
            cards: params.cards,
            value: params.value
        }),
    });


    return response;
}

export default putCards;