<script>
    import EndGame from "$lib/Game/EndGame/+page.svelte";
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
    import GameSocket from "$lib/Sockets/GameSocket/+page.svelte";

    export let data;

    let gameEnded = false;

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
    let myCards = playerData.cards;
    let canCall = lastPlayer.canCall;

    let disableSelect = false;
    let animateCards = false;
    let removeCount = false;

    let currentCards = cards.filter(filterCards)
    let winner;


    function filterCards(card){
        return myCards.includes(card.id);
    }

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
    

    async function placeCards(event){ // To add the cards selected by the user to the currentStack

     
        canCall = false,
        yourTurn = false;

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

        const myData = {
            id:playerData.id, 
            name:playerData.user.name,
            cards: myCards.length - theCards.length
        };

        lastPlayer = myData;

        const response = await putCards(data.authToken, cardInfo);
        const responseData = await response.json();
       
        

        currentPlayer = responseData;

    }

    function flipCards(){

        flipTheCards();

        let callParams = {
            id:playerData.room.id,
            isTruth:checkCall(cardValues, Turn.value),
            callerId:playerData.id
        }

        callLastStack(data.authToken, callParams);

        
    }

    function addCards(event){
    
        const theLastPlayer = event.detail.lastPlayer;
        const theCurrentPlayer = event.detail.currentPlayer;
        const theTurn = event.detail.turn;
        const playerId = playerData.id;

        if(theLastPlayer.id !== playerId){
            disableSelect = true

            setTimeout(() => {
                disableSelect = false
            })
        }


        Turn.count = theTurn.count
        Turn.value = theTurn.value

        lastPlayer = theLastPlayer;

        currentPlayer = theCurrentPlayer; 
        isLastPlayer = playerId === lastPlayer.id;

        

        if(playerId != lastPlayer.id){
            
            canCall = true;
            yourTurn = playerData.id == currentPlayer.id;
            
            const theCards = event.detail.cards
            currentLastCards = theCards
            currentStack = [...currentStack, ...theCards]
            selectCard = false

            cardValues = [];
            let cardIds = [];
        
            currentLastCards.forEach(card => {
                cardValues.push(card.value);
                cardIds.push(card.id);
            });
        }

    }

    function callTheCards(event){

        const callerId = event.detail.callerId;
        const playerId = playerData.id;
        const playerPickupId = event.detail.playerPickupId;
        const newCards = event.detail.newCards

        if(playerPickupId === currentPlayer.id){
            currentPlayer.cards = newCards.length
        }

        if(playerPickupId === playerId){

            myCards = newCards; 
            currentCards = cards.filter(filterCards);
        } 

        if(callerId !== playerId){
            flipTheCards()
        }


    }


    function flipTheCards(){

        callCards = true;
        disableSelect = true;
        removeCount = true;

        const flippedStack = theStack.slice(0, -lastCards.length);
        theStack = flippedStack;

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


    function endTheGame(event){
        gameEnded = true;
        winner = event.detail.lastPlayer;


    }   
</script>

{#if gameEnded}
    <div class="EndGame">
        <EndGame isWinner={playerData.id === winner.id}/>
    </div>
{/if}
<main class="TheGame {gameEnded ? "blur":""}">

    <Stats 
        callCards={callCards} Turn={Turn}
        cardValues={cardValues} lastCards={currentLastCards}
        theStack={currentStack} lastPlayer={lastPlayer}
        currentPlayer={currentPlayer} yourTurn={yourTurn}
        playerId={playerId} canCall={canCall}
    />

    <Cards
        animateCards={animateCards} theStack={currentStack}
        callCards={callCards} lastCards={currentLastCards} 
        removeCount={removeCount}
    />

    <Options
        theStack={currentStack}
        calledCards={!callCards && !disableSelect ? false:true }
        isLastPlayer={isLastPlayer} canCall={canCall}
        on:selectCard={showCards} on:callCards={flipCards}
     />

    <Selection
        yourTurn={yourTurn} selectCard={selectCard}
        Turn={Turn} cards={cards}
        currentCards={currentCards}
        on:selectCard={showCards} on:placeCards={placeCards}    
    />


    <GameSocket 
        roomId={playerData.room.id} token={data.authToken}
        cards={cards}

        on:addCards={addCards}  
        on:callCards={callTheCards}
        on:endGame={endTheGame}
    />
</main>

<style lang="scss">

.EndGame{
    position: absolute;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100vh;
    padding: 0;
}

.blur{
    filter: blur(.5rem);
    -webkit-filter: blur(.5rem);
    overflow-y: hidden;
    pointer-events: none;
}

.TheGame{
    max-width: 1000px;
    background: none;
    margin: auto;
    margin-top:0;
    margin-bottom:0;
    padding: 0;

    position: relative;

    display: grid;
    display: -ms-grid;
    display: -moz-grid;
    grid-template-rows: 8rem 1fr 6rem;
}

</style>
