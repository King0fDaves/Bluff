<script>
    import Card from "$lib/Cards/Card/+page.svelte";

    export let theStack;
    export let lastCards;
    export let callCards;
    export let animateCards = false;
    export let removeCount = false;

</script>

<div class="Cards">

    {#each theStack as card, i}


    <div class="Card {animateCards ? "called":""}" style="--cardPlace:{i+1}; ">
        <Card 
            card={card} showBorder={true} isBack={true} 
            showCount={!removeCount} count={theStack.length}
            countDegree={i+1}
        />
    </div> 


    {/each}

    {#if lastCards.length > 0 && callCards}
        {#each lastCards as card, i}

            <div class="Card {callCards ? "lastCard":""}" style="--cardPlace:{theStack.length - (i)}; z-index:3; --reveal:{i+1};">
                <Card card={card} showBorder={true} isBack={false}  />
            </div>
        {/each}

    {/if}

</div>

<style lang="scss">

.Cards{
    position: fixed;
    width: 1000px;
    height: 50%;
    margin: auto;

    top: 12rem;    
    @media screen and (max-width: 1000px){
        width: 100%;
    } 

     
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    overflow:hidden;

}

.Card{
    position: absolute;
    transform: translateY(100vh);
    animation: addCard 1s ease calc(.1s * var(--cardPlace));
    animation-fill-mode: forwards;
    
}


.lastCard{

    animation: rotateCard 4s cubic-bezier(0.075, 0.82, 0.165, 1);
    transform: rotate(calc(7deg * var(--cardPlace)));

}

.called{
    animation: alignCard 3s cubic-bezier(0.075, 0.82, 0.165, 1) calc(.05s * var(--cardPlace));
    animation-fill-mode: forwards;
}


@keyframes alignCard {
    0% {
        transform: rotate(calc(var(--cardPlace) * 7deg));
    } 
    50% {
        transform: rotate(0deg)

    } 100%{

        transform: translateX(100vw);

    }
}

@keyframes rotateCard{
    0% {
        transform: rotate(0deg)

    } 
    50% {
        transform: rotate(calc(var(--cardPlace) * 45deg ) );
    } 100% {
        transform: rotate(calc(var(--cardPlace) * 7deg )  );
        transform: translateX(100vw);


    }
}


@keyframes addCard {
    0% {
        transform: translateY(100vh);
    } 
    70% {
        transform: rotate(0) rotate(calc(var(--cardPlace) * 7deg ));

    } 100%{

        transform: translateY(0) rotate(calc(var(--cardPlace) * 7deg ));

    }
}


</style>
