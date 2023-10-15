<script>
    import Loader from "$lib/Misc/Loader/+page.svelte";
    import deleteRoom from "$lib/Functions/ApiCalls/Game/deleteRoom.js";

    export let players;
    export let slider;
    export let code;
    export let roomId;
    export let token;


    function removeRoom(){
        deleteRoom(token, {id:roomId});
    }
</script>


<span class="Code">
   Pin: {code}
</span>

<div class="Waiting">
    {#if players.length < slider}
        <Loader />
    {:else}
        <span class="start">Ready</span>
    {/if}

    <p class="PlayerCount">
        {players.length } / {slider}
    </p>

    <div class="WaitingList">
        {#each players as player}
            <span class="WaitingList__players">{player}</span>
        {/each}

    </div>
</div>

<div class="Options">
    <button on:click={removeRoom} class="HostForm__btn">
        Cancel
    </button>
    <button  class="HostForm__btn {players.length < 3 ? "disable":""}">
        Start
    </button>
</div>

<style lang="scss">

.Code{
    font-weight: 600;
    font-size: 1.3rem;
    letter-spacing: .1rem;
    text-transform: uppercase;
}

.Waiting{
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    width: 100%;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.WaitingList{
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    width: calc(80%);
    flex-wrap: wrap;
    flex-direction: row;
    align-items:flex-start;
    align-content: flex-start;
    height: 5rem;

    overflow-y: scroll;
}

.WaitingList__players{
    min-width: 50%;
    margin-bottom: .4rem;

    @media screen and (max-width:400px){
        width: 100%;
        text-align: center;

    }
}

.HostForm__btn{
    width: 8rem;
    height: 2.5rem;
    font-size: 1rem;
    font-family: 'Zekton';
    background: $gradient4;
    border: none;
    color: white;
    text-transform: uppercase;
    letter-spacing: .1rem;

    @media screen and (max-width:400px){
        width: 7rem;
    }
    &:hover{
        background: #131313;
        border: white solid .05rem;

    }
}


::-webkit-scrollbar{
    background: #131313;
}

::-webkit-scrollbar-thumb{
    background: rgb(228, 111, 111);
    border-radius: 1rem;
}



</style>