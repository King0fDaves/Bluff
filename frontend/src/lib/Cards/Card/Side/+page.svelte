<script>
    import numToLetter from "$lib/Functions/numToLetter.js"
    export let suit;
    export let value;
    export let isLeft = false;
    export let size;
</script>


<div class="CardSide {isLeft ? "CardLeftSide":"CardRightSide"}" style="--cardSize:{size}">
    {#if isLeft}
        {numToLetter(value)}
    {/if}
    <img src="/assests/{suit}.png" class="CardSide__suit {isLeft ? "left__suit":"right__suit"}" alt="{suit}.png">
    {#if !isLeft}
        <span class="flip">{numToLetter(value)}</span>
    {/if}
</div>


<style lang="scss">

.CardSide{
    
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    justify-content: center;
    flex-direction: column;
    padding: 0;
    align-items: center;
}

.CardSide__suit{
    height: calc(var(--cardSize) * 1.5rem);
    margin: auto;   
    font-family: serif;
}

.left__suit{
    margin-top: 0; 
}
.right__suit{
    margin-bottom: 0;
    transform: rotate(180deg);
}

.CardLeftSide{
    justify-content: flex-start;
    grid-column: 1/2;
    grid-row: 1/6;
    font-family: 'sans-serif';
    font-size: calc(var(--cardSize) * 2rem);
}

.CardRightSide{
    justify-content: flex-end;
    grid-column: 5/6;
    grid-row: 1/6;
    font-family: 'sans-serif';
    font-size: calc(var(--cardSize) * 2rem);
}

.flip{
    transform: rotate(180deg);
}

</style>