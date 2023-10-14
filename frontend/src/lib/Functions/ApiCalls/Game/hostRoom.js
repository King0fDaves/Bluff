import { PUBLIC_ORIGIN } from "$env/static/public";

export const hostRoom = async (authToken, params) => {
    const response = await fetch(`${PUBLIC_ORIGIN}/api/host-room`, {
        method: "POST",
        headers: {
            'Authorization':`Bearer ${authToken}`,
            "Accept": "application/vnd.api+json",
            "Content-Type": "application/vnd.api+json",
        },
        body: JSON.stringify({
            player_count: params.playerCount,
            allow_jokers: params.allowJokers
        }),
    });

    return response
}

export default hostRoom;