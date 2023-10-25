<script>
    import { PUBLIC_HOST } from "$env/static/public";
    import { PUBLIC_WEBSOCKET_KEY } from "$env/static/public";
    import { PUBLIC_WEBSOCKET_PORT } from "$env/static/public";
    import { PUBLIC_ENCRYPT_WEBSOCKET } from "$env/static/public";
    import removeForm from "$lib/Functions/removeForm.js";

    import { goto } from '$app/navigation';
    import Echo from "laravel-echo";
    import Pusher from "pusher-js";
    import { onMount, createEventDispatcher } from "svelte";

    const shouldEncrypt = PUBLIC_ENCRYPT_WEBSOCKET === "true" ? true:false;

    export let roomId;
 
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

        });

            
        channel = window.Echo.channel(`public.host`);
    
        channel.subscribed(() => { 
            

        }).listen(".joined-room", (event) => {

            if(event.roomId === roomId){
                
                dispatch('addPlayer', {
                    newUser:event.username
                })
            }

        }).listen(".leave-room", (event) => {

            if(event.roomId === roomId){

                dispatch('removePlayer', {
                    user:event.user
                })
            }
        }).listen('.remove-room', (event) => {

            if(event.roomId === roomId){
                removeForm()
            }
        }).listen('.start-game', (event) => {
            
            if(event.roomId === roomId){
                goto(`/game/${roomId}`)
            }
        })

    });

   
   

</script>
