
<script>
    import { createEventDispatcher } from "svelte";
    import Card from "$lib/Cards/Card/+page.svelte";

    const dispatch = createEventDispatcher()

    export let currentCards; // The current cards held by the user
    export let picked; // The cards selected by the player
    export let cardCount; 
    export let yourTurn; // Decides if the current player should place a card

    function selectCard(theCard){ // Is the card being picked by the player
 
        if(picked.length < 4){

            dispatch('pickCard', {
                card:theCard
            })
        }

    }

    let size = .4
    currentCards.forEach( card => {
            card.size = size
    });

    
</script>

<div class="Cards">
    {#each currentCards as card}
        <button class="Cards__btn {!yourTurn ? "disable":""}" on:click={() => {selectCard(card)}}>
            <Card card={card}  isBack={false} />
        </button>
    {/each}
    
        
</div>

<style lang="scss">

.Cards{
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    flex-direction: row;
    flex-wrap: wrap;
    grid-template-rows: 2/3;
    width: 100%;
    height: 100%;
    justify-content: center;
    overflow-y: scroll;
    align-content: flex-start;
    margin-top: 1rem;
}


.Cards__btn{
    border: none;
    padding: 0;
    background: none;
    border-radius: .5rem;
    

    &:hover{
        border: solid rgb(255, 255, 255) .15rem;
    }
}

.disable{
    pointer-events: none;
    opacity: .6;
}
</style>