<script>
    import { createEventDispatcher } from "svelte";
    
    import ValueSetter from "$lib/Game/Selection/ValueSetter/+page.svelte";
    import YourCards from "$lib/Game/Selection/YourCards/+page.svelte";
    import Options from "$lib/Game/Selection/Options/+page.svelte";

    export let selectCard;
    export let cards;
    export let Turn;
    export let yourTurn;

    export let currentCards;


    let cardCount = 0; // The amount of cards selected by the user
       
    let picked = []; // Cards selected by the user

    const dispatch  = createEventDispatcher()
    
    function dropCardSelection(){ // Drops the card selection menu
        dispatch('selectCard', {
            selectCard:false
        })
    }

    function pickCard(event){ // The card picked by the user
        const theCard = event.detail.card
        picked = [...picked, theCard]
        cardCount += 1
        currentCards = currentCards.filter(card => card.id !== theCard.id)
    }
    
    function clear(){  // To remove the cards picked by the user

        if(cardCount > 0){
            currentCards = [...currentCards, ...picked];
            cardCount = 0;
            picked = []
        }
    }

    function place(){ // To place the cards selected by the user to the current stack
 
        if(cardCount > 0){
            dispatch('placeCards', {
                cards:picked
            })

            cardCount = 0;
            picked = []
            
        }
        
    }

</script>


<div class="CardSelection {selectCard ? "bringUpSelection":""}">
    {#if selectCard}


    <div class="TopSelector ">
        <span class="cardCount">
            {cardCount}x
        </span>

        <ValueSetter Turn={Turn} yourTurn={yourTurn} />


        <button class="dropdown" on:click={() => {dropCardSelection()}}>
            <i class="fa-solid fa-chevron-down"></i>
        </button>
    </div>

    <YourCards 
        yourTurn={yourTurn} 
        currentCards={currentCards}
        picked={picked} 
        cardCount={cardCount}
        on:pickCard={pickCard}
    />


    <Options yourTurn={yourTurn} on:clearCards={clear} on:placeCards={place} />

    
   {/if}
</div> 

<style lang="scss">

.CardSelection{
    position: fixed;
    height: 0;
    width: calc(1000px - 2rem);
    background: black;
    bottom: 0;
    padding-left: 1rem;
    padding-right: 1rem;

    display: grid;
    display: -ms-grid;
    display: -moz-grid;
    grid-template-rows: 4rem 1fr;

    @media screen and (max-width: 1000px){
        width: calc(100% - 2rem);
    }
}

.TopSelector{
    grid-row: 1/2;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    height: 100%;
    width: 100%;
    position: relative;
    justify-content: space-evenly;
}

.dropdown{
    width: 3rem;
    height: 3rem;
    background: none;
    justify-self: flex-end;
    right: 1rem;
    border: .15rem solid red;
    border-radius: 50%;
    margin-top: .5rem;
    color: white;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;

    &:hover{
        background: rgb(56, 56, 56);
        border: none;
    }
    
}

.cardCount{
    font-size: 1.3rem;
    align-self: center;
    margin-left: 1rem;
}

.ValueSetter{
    margin: auto;
    width: 12rem;
    height: 100%;
    border-radius: 5rem;
    
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: space-evenly;
    padding: 0;

    
}


.picked{
    border: solid red .15rem;
}

.OptionBtn{            
    height: 3rem;
    width: 5.5rem;
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
    position: absolute;
    z-index: 2;

    bottom: 1rem;


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


.ValueSetter__btn{
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    border: none;
    background: rgb(56, 56, 56);
    color: white;
    font-size: 1.2rem;
    &:hover{
        border: solid red .15rem;;
        background: none;

    }

    font-family: sans-serif;
}


.bringUpSelection{
    height: calc(100vh - 10rem);
    bottom:0;
    padding: 1rem;
}

.dontShow{
    display: none;
}

.disable{
    pointer-events: none;
    opacity: .4;
}

.selected{
    border: solid .15rem red;
    background: none;
}

.clear{
    left: 1.5rem;
}

.place{
    right: 1.5rem;

}

</style>
