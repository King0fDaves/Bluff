<script>
    import Loader from "$lib/Misc/Loader/+page.svelte";
    export let players;
    export let slider;
</script>


<span class="Code">
    E6XJ71
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
    <button on:click={() => {hosted = false}} class="HostForm__btn">
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
    justify-content: space-between;
    align-items:center;
    align-content: flex-start;
    overflow-y: scroll;
    
    max-height: 5rem;
}

.WaitingList__players{
    width: 50%;

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



</style>