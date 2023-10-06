<script>
    import checkCall from "$lib/Functions/checkCall.js"
    import numToLetter from "$lib/Functions/numToLetter.js"


    export let callCards; // Decides if a player called the last player's cards
    export let cardValues; // The literal cards placed by the last player
    export let Turn;
    export let lastCards; // The cards placed by the last player
    export let theStack; // The current stack of cards being played
    
</script>


<div class="Stats">

    <div class="GameStats">
        <div class="cardsPlaced">
            {#if callCards}
                {#each cardValues as card }
                    <span class="cardsPlaced__card">{numToLetter(card)} -</span> 
                {/each}
    
                <span class="calledAns {checkCall(cardValues, Turn.value) ? "truth":"lied"}">
                    {checkCall(cardValues, Turn.value) ? "Truth":"Lied"}
                </span>
    
            {:else}
                <span>
                    {#if Turn.count > 0}
                    {lastCards.length} - {numToLetter(Turn.value)}{lastCards.length > 1 ? "s":""}
                    {:else}
                        New Card
                    {/if}
                </span>
            {/if}
        
        </div>
        
        <div class="cardCount">
            Total Stack -  <span class="cardCount__num">{theStack.length}</span>  
        </div>
    </div>
    

    <div class="Players">
        <span class="Players__player">
            <span class="call">Call -</span> KingOfDaves - 10x   
        </span>
    </div>


</div>


<style lang="scss">

.Stats{
    width: 100%;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    justify-content: space-evenly;
    flex-direction: column;
    padding-top: 1rem;
    font-size: 1.2rem;
    font-family: $primaryFont;
    position: relative;
    grid-column: 1/2;
}

.GameStats{
    width: 100%;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
  
    justify-content: space-between;
}

.Players{
    width: 100%;
    text-align: center;

}

.cardsPlaced{
    width: 50%;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    margin-left: 1rem;
}


.cardsPlaced__card{
    margin-right: .5rem;
}

.cardCount{
    width: 50%;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    justify-content: flex-end;
    margin-right: 1rem;
}

.cardCount__num{
    margin-right: .5rem;
    margin-left: .3rem;
}

.calledAns{
    text-transform: uppercase;
    letter-spacing: .2rem;
}

.lied{
    color: rgb(248, 129, 129);

}

.truth{
    color: rgb(97, 245, 97);
}

.call{
    color: rgb(252, 84, 84);
    text-transform: uppercase;
    font-size: 1.3rem;
}

</style>