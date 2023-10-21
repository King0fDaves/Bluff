<script>
    import Stats from "$lib/Game/Stats/+page.svelte";
    import Options from "$lib/Game/Options/+page.svelte";
    import Cards from "$lib/Game/Cards/+page.svelte";
    import cards from "$lib/Stores/TheCards.js";
    import Selection from "$lib/Game/Selection/+page.svelte";
    import CurrentStackStore from "$lib/Stores/CurrentStackStore.js";
    import CurrentLastCardsStore from "$lib/Stores/CurrentLastCardsStore.js";
    import putCards from "$lib/Functions/ApiCalls/Game/Gameplay/putCards.js";
    import callLastStack from "$lib/Functions/ApiCalls/Game/Gameplay/callLastStack.js";
    import checkCall from "$lib/Functions/checkCall.js";


    export let data;

    const playerData = data.player;
   
    let yourTurn = playerData.turn === playerData.room.player_turn; // Decides if the current player should place a card
    
    let theStack = playerData.room.the_stack; // The current stack of cards being played
    
    let lastPlayer = playerData.lastPlayer; // The player who placed the last cards

    let currentPlayer = playerData.currentPlayer;

    let playerId = playerData.id; // The player's turn id

    let currentStack = cards.filter(filterTheStack);      

    let isLastPlayer = playerId === lastPlayer.id;

    CurrentStackStore.subscribe((data) => {
        data = currentStack;
    })

    let lastCards = playerData.room.last_cards; // The last cards placed 

    let currentLastCards = cards.filter(filterLastCards);

    CurrentLastCardsStore.subscribe((data) => {
        data = currentLastCards
    })


    let callCards = false; // Decides if a player called the last player's cards
    let cardValues = getCardValues(currentLastCards); // The literal cards placed  
    let selectCard = false; // If the current player is ready to place cards
    let Turn = {count: playerData.room.turn_count, value:playerData.room.turn_value}; // Keeps Track of what the last card value was and the turn count 
    let myCards =playerData.cards;

    let disableSelect = false;
    let animateCards = false;
    let removeCount = false;


    function filterTheStack(card){
        return theStack.includes(card.id);
    }

    function filterLastCards(card){
        return lastCards.includes(card.id);
    }

    function showCards(event){ // To bring up/down the card seletion panel
        selectCard = event.detail.selectCard
    }
    
    function getCardValues(lastCards){
        let values = [];

        if(lastCards.length > 0){
            const theLastCards = cards.filter(filterLastCards);
            theLastCards.forEach(card => {
                values.push(card.value)
            })
        } 

        return values;
    }
    

    function placeCards(event){ // To add the cards selected by the user to the currentStack

        const theCards = event.detail.cards
        currentLastCards = theCards
        currentStack = [...currentStack, ...theCards]
        selectCard = false
        Turn.count+=1

        cardValues = [];
        let cardIds = [];
    
        currentLastCards.forEach(card => {
            cardValues.push(card.value);
            cardIds.push(card.id);
        });

        const cardInfo = {
            id:playerData.room.id,
            cards:cardIds,
            value:Turn.value
        }

        putCards(data.authToken, cardInfo);

    }

    function flipCards(event){
        callCards = true;
        disableSelect = true;
        removeCount = true;

        theStack = theStack.slice(0, -lastCards.length);

        let callParams = {
            id:playerData.room.id,
            isTruth:checkCall(cardValues, Turn.value),
            callerId:playerData.id
        }

        callLastStack(data.authToken, callParams);

        setTimeout(() => {
            callCards = false;
            
            setTimeout(() => {
                animateCards = true;
                
                Turn.count = 0;
                Turn.value = 3;

                setTimeout(() => {
                    disableSelect = false;
                    currentLastCards = []
                   
                    currentStack = []
                    animateCards = false;
                    removeCount = false;

                }, 3000)

            }, 1000)
           
    
        }, 4000)

    }

</script>

<main class="TheGame">

    <Stats 
        callCards={callCards} Turn={Turn}
        cardValues={cardValues} lastCards={currentLastCards}
        theStack={currentStack} lastPlayer={lastPlayer}
        currentPlayer={currentPlayer} yourTurn={yourTurn}
        playerId={playerId}
    />

    <Cards
        animateCards={animateCards} theStack={currentStack}
        callCards={callCards} lastCards={currentLastCards} 
        removeCount={removeCount}
    />

    <Options
        theStack={currentStack}
        calledCards={!callCards && !disableSelect ? false:true }
        isLastPlayer={isLastPlayer} canCall={lastPlayer.canCall}
        on:selectCard={showCards} on:callCards={flipCards}
     />

    <Selection
        yourTurn={yourTurn} selectCard={selectCard}
        Turn={Turn} cards={cards} myCards={myCards}

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