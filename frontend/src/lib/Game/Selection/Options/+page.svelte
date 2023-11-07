<script>
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher()

    export let yourTurn; // Decides if the player can select a card
    
    function clear(){ // Clears all the cards selected by the user
        dispatch('clearCards')
    }

    function place(){ // Places the cards selected by the user to the current stack
        dispatch('placeCards')

    }

</script>

    <button class="clear OptionBtn {!yourTurn ? "disable":""}" on:click={() => {clear()}}>
        <span class="OptionBtn__title">clear</span>
    </button>
    
    <button class="place OptionBtn {!yourTurn ? "disable":""}" on:click={() => {place()}}>
        <span class="OptionBtn__title">place</span>
    </button>
    


<style lang="scss">

.Options{
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: space-between;
    background: none;
    position: relative;
    
}

.OptionBtn{            
    height: 3rem;
    width: 7rem;
    margin: 1rem;
    font-size: .9rem;
    text-transform: uppercase;
    letter-spacing: .05rem;
    border: none;
    background: $gradient2;
    font-family:Arial, Helvetica, sans-serif;

    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    border-radius: 1.5rem;
    text-decoration: none;
    z-index: 2;
    position: absolute;

    bottom: 2rem;

    &:hover{
        background: rgb(82, 82, 82);
        cursor: pointer;
    }

}

.OptionBtn__title{
    height: calc(100% - .3rem);
    width: calc(100% - .3rem);
    background: #000000;
    padding: 0;
    margin: 0;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    border-radius: 1.5rem;
    font-size: .9rem;
    
}

.clear{
    left: 1.5rem;
}

.place{
    right: 1.5rem;

}

.disable{
    pointer-events: none;
    background: rgb(82, 82, 82);
}

</style>