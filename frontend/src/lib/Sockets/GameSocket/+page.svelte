<script>
import { PUBLIC_HOST } from "$env/static/public";
import { PUBLIC_WEBSOCKET_KEY } from "$env/static/public";
import { PUBLIC_WEBSOCKET_PORT } from "$env/static/public";
import { PUBLIC_ORIGIN } from "$env/static/public";
import { PUBLIC_ENCRYPT_WEBSOCKET } from "$env/static/public";

import Echo from "laravel-echo";
import Pusher from "pusher-js";
import { onMount, createEventDispatcher } from "svelte";

const shouldEncrypt = PUBLIC_ENCRYPT_WEBSOCKET === "true" ? true:false;

export let roomId;
export let token;
export let cards;

let lastCards = [];
let channel;

const dispatch = createEventDispatcher();


onMount(() => {

    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: "pusher",
        key: PUBLIC_WEBSOCKET_KEY,
        cluster: "mt1",
        forceTLS: shouldEncrypt,
        wsHost: PUBLIC_HOST,
        wsPort: PUBLIC_WEBSOCKET_PORT,
        encrypted: shouldEncrypt,
        enabledTransports: ["ws", "wss"],
        authEndpoint: `${PUBLIC_ORIGIN}/broadcasting/auth`, 
            auth: {
                headers: {
                    Authorization: "Bearer " + token,
                },
            },

    });

        
    channel = window.Echo.join(`presence.room.${roomId}`);

    channel.subscribed(() => { 
        

    }).listen(".place-cards", (event) => {
            
            lastCards = event.lastCards;
            const filteredCards = cards.filter(filterCards);

            dispatch('addCards', {
                'gameEnded':event.gameEnded,
                'lastPlayer':event.lastPlayer,
                'currentPlayer':event.currentPlayer,
                'turn': event.turn,
                'cards':filteredCards
            })  
        
    }).listen(".call-cards", (event) => {
        
        dispatch('callCards', {
            'roomId':event.roomId,
            'theStack':event.theStack,
            'callerId':event.callerId,
            'gameEnded':event.gameEnded,
            'playerPickupId':event.playerPickUpId,
        })

    }).listen(".end-game", (event) => {

        dispatch('endGame', {
            'lastPlayer':event.lastPlayer
        })
    
    })

});

function filterCards(card){
    return lastCards.includes(card.id);
}
</script>
