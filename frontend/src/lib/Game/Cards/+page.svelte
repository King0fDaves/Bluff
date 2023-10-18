<script>
    import Card from "$lib/Cards/Card/+page.svelte";

    export let theStack;
    export let lastCards;
    export let callCards;
</script>

<div class="Cards">
    
    {#each theStack as card, i}
        <div class="Card" style="--cardPlace:{i+1}">
            <Card 
            
            card={card} showBorder={true} isBack={true} 
            showCount={true} count={theStack.length}
            countDegree={i+1}
            />
        </div> 
    {/each}

    {#if lastCards.length > 0 && callCards}
        {#each lastCards as card, i}
            <div class="Card" style="--cardPlace:{i+1}; z-index:3; --reveal:{i+1};">
                <Card card={card} showBorder={true} isBack={false}  />
            </div>
        {/each}
    {/if}
</div>

<style lang="scss">

.Cards{
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;

    grid-row: 2/3;
}

.Card{

    position: absolute;
    transform: rotate(calc(7deg * var(--cardPlace)));
}

</style>
