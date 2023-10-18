<script>
    import Stats from "$lib/Game/Stats/+page.svelte";
    import Options from "$lib/Game/Options/+page.svelte";
    import Cards from "$lib/Game/Cards/+page.svelte";
    import cards from "$lib/Stores/TheCards.js";
    import Selection from "$lib/Game/Selection/+page.svelte";

    export let data;

    let Turn = {count:0, value:3}; // Keeps Track of what the last card value was and the turn count 
    let yourTurn = true; // Decides if the current player should place a card
    let theStack = [] ; // The current stack of cards being played
    let callCards = false; // Decides if a player called the last player's cards
    let cardValues = []; // The literal cards placed  
    let lastCards = []; // The last cards placed 
    let selectCard = false; // If the current player is ready to place cards
    
    function showCards(event){ // To bring up/down the card seletion panel
        selectCard = event.detail.selectCard
    }


    function placeCards(event){ // To add the cards selected by the user to the currentStack

        const theCards = event.detail.cards
        lastCards = theCards
        theStack = [...theStack, ...theCards]
        selectCard = false
        Turn.count+=1

        cardValues = []
        lastCards.forEach(card => {
            cardValues.push(card.value)
        });
    }

    function flipCards(event){
        callCards = true

        setTimeout(() => {
            callCards = false;
            theStack = []
            Turn.count = 0;
            Turn.value = 3;
            lastCards = []
    
        }, 4000)
    }

</script>

<main class="TheGame">
    
    <Stats 
        callCards={callCards} Turn={Turn}
        cardValues={cardValues} lastCards={lastCards}
        theStack={theStack}    
    />


    <Cards theStack={theStack} callCards={callCards} lastCards={lastCards} />

    <Options
        yourTurn={yourTurn} theStack={theStack}
        calledCards={callCards}
        on:selectCard={showCards} on:callCards={flipCards}
     />

    <Selection
        yourTurn={yourTurn} selectCard={selectCard}
        Turn={Turn} cards={cards} myCards={data.player.data.cards}

        on:selectCard={showCards} on:placeCards={placeCards}    
    />

</main>

<style lang="scss">
.TheGame{
    height: 100dvh;
    max-width: 1000px;
    background: none;
    margin: auto;
    padding: 0;

    position: relative;

    display: grid;
    display: -ms-grid;
    display: -moz-grid;
    grid-template-rows: 8rem 1fr 6rem;
}


</style>