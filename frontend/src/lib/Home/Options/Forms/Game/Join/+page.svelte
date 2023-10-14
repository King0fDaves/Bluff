<script>
    import FormLayout from "$lib/Home/Options/Forms/+page.svelte";
    import ShowFormStore from "$lib/Stores/ShowFormStore.js";    
    import Loader from "$lib/Misc/Loader/+page.svelte";
    import HostSocket from "$lib/Sockets/HostSocket/+page.svelte";
    import joinRoom from "$lib/Functions/ApiCalls/Game/joinRoom.js";

    export let height;
    export let authToken;

    let joined = false;
    let code;
    let room;

    let playerCount;

    function closeForm(){
        ShowFormStore.update(currentData => {
            return false
        })
    }

    async function join(){
        if(code){

            const response = await joinRoom(authToken, {code:code})
            
            if(response.ok){
                
                const responseData = await response.json();

                room = responseData.data.room
                
                joined = true;

                playerCount = room.players.length + 1;

            } else {
                console.log('Something went wrong')
            }
        }   
    }

</script>

<FormLayout title="Join" height={height}>
    <form class="JoinForm">
        {#if !joined}
            <button class="closeBtn" on:click={() => {closeForm()}}>
                <i class="fa-solid fa-arrow-left"></i>
            </button>

            <input class="JoinForm__input" bind:value={code} type="text" placeholder="Enter Pin">
            <input on:click={join} class="JoinForm__btn" type="submit" value="Join">

        {:else}
            <span class="JoinForm__code">Pin: {code}</span>
            <div class="PlayerCounter">
                <i class="fa-solid fa-users"></i> - {playerCount} / {room.max_player_count}
            </div>
            
            {#if playerCount < room.max_player_count}
                <Loader />
            {:else}
                Ready
            {/if}

            <input on:click={() => {

            }} class="JoinForm__btn" type="submit" value="Leave">
        {/if}

        {#if joined}
            <HostSocket
                token={authToken} roomId={room.id}
                joined={joined} roomCode={code}

                on:addPlayer={() => {playerCount += 1 }}
             />
        {/if}
 
    </form>
</FormLayout>

<style lang="scss">
.JoinForm{
    height: 100%;
    width: 100%;

    height:calc(100% - 2.5rem);
    width: calc(100% - 2.5rem);
    background: rgb(12, 12, 12);
    padding: 1rem;

    @include sharpCorners(2rem);

    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    justify-content: space-evenly;
    align-items: center;
    flex-direction: column;
    font-family: $primaryFont;
    .closeBtn{
        background: none;
        border: none;
        color: red;
        font-size: 1.5rem;

        &:hover{
            color: white;
        }
    }
    .JoinForm__input{
        height: 2rem;
        width: 15rem;
        border: none;
        border-bottom: red solid .1rem;
        background: none;
        color: white;
        font-size: 1rem;
        background: none;
        @media screen and (max-width: 430px){
            width: 80%;
        }

        &::placeholder{
            font-family: 'Zekton';
        }
    }

    .JoinForm__btn{
        width: 8rem;
        height: 2.5rem;
        font-size: 1rem;
        font-family: 'Zekton';
        background: $gradient4;
        border: none;
        color: white;
        text-transform: uppercase;
        letter-spacing: .1rem;

        &:hover{
            background: #131313;
            border: white solid .05rem;

        }
    }

    .JoinForm__code{
        font-weight: 600;
        font-size: 1.3rem;
        letter-spacing: .1rem;
    }
}

.PlayerCounter{
    font-size: 1.4rem;

    .PlayerCounter__count{
        color: red;
    }
}

.loader {
    width: 2rem;
    height: 2rem;
    border: .2rem solid #FFF;
    border-bottom-color: red;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
}

@keyframes rotation {
0% {
    transform: rotate(0deg);
}
100% {
    transform: rotate(360deg);
}
} 
</style>