import { redirect } from '@sveltejs/kit';

import { getPlayer } from "$lib/Functions/ApiCalls/Game/Gameplay/getPlayer.js";

export async function load({ cookies, url}) {

    const authToken = cookies.get('authCookie');

    const roomId = url.pathname.slice(6);
    const response = await getPlayer(authToken, {id:roomId});
    const isAllowed = response.ok;
    const playerData = await response.json();


    console.log(playerData.data)

    if(!isAllowed){
       throw redirect(308, '/game');
    }

    return {
        player:playerData.data,
        authToken:authToken
    }   
}