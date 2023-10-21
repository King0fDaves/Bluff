import { PUBLIC_ORIGIN } from "$env/static/public";

export const callLastStack = async (authToken, params) => {
    const response = await fetch(`${PUBLIC_ORIGIN}/api/call-cards`, {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${authToken}`,
            "Accept": "application/vnd.api+json",
            "Content-Type": "application/vnd.api+json",
        },
        body: JSON.stringify({
            id: params.id,
            isTruth: params.isTruth,
            callerId: params.callerId
        }),
    });

    return response;
}

export default callLastStack;