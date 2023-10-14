<script>
    import { PUBLIC_ORIGIN } from "$env/static/public";
    import { PUBLIC_HOST } from "$env/static/public";
    import { PUBLIC_WEBSOCKET_KEY } from "$env/static/public";
    import { PUBLIC_WEBSOCKET_PORT } from "$env/static/public";

    import Echo from "laravel-echo";
    import Pusher from "pusher-js";
    import { onMount, createEventDispatcher, afterUpdate } from "svelte";

    export let roomId;
 
    let channel;
    const dispatch = createEventDispatcher();

    onMount(() => {

        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: "pusher",
            key: PUBLIC_WEBSOCKET_KEY,
            cluster: "mt1",
            forceTLS: false,
            wsHost: PUBLIC_HOST,
            wsPort: PUBLIC_WEBSOCKET_PORT,
            encrypted: false,
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

        })

    });

   
   

</script>
