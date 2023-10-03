<script>
    import numToLetter from "$lib/Functions/numToLetter.js";

    export let value;
    export let suit;
    export let isTitle;

</script>

{#if numToLetter(value) % 2 !== 0 &&  typeof numToLetter(value) !== 'string'}
    <div class="suitContainer col-3-4 row-3-4">
        <img src="/assests/{suit}.png" alt="" class="suit">
    </div>
{:else if typeof numToLetter(value) === 'string' }
    <div class="suitContainer col-3-4 row-3-4">
        <span class="royal  {isTitle ? "titleText":""} {suit === "Diamond" || suit === "Heart" ? "red":""}" >{numToLetter(value)}</span>
    </div>
{/if}


<style lang="scss">
.suitContainer{
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100%;
    position: relative;
}

.suit{
    position: absolute;
    height:70%;
}

.flip{
    transform: rotate(180deg);
}

.red{
    color: red;
}

.royal{
    font-size: calc(var(--cardSize) * 5rem);
    font-family:'Times New Roman', Times, serif;
}

.titleText{
    font-family: $customFont;
}

.col-3-4{
    grid-column: 3/4;
} 

.row-3-4{
    grid-row: 3/4;
}

</style>