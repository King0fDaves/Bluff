<script>
    import numToLetter from "$lib/Functions/numToLetter.js";

    export let value;
    export let suit;
</script>



{#if numToLetter(value) === 6 || numToLetter(value) === 7 || numToLetter(value) === 10}
    <div class="suitContainer col-2-3 row-3-4">
        <img src="/assests/{suit}.png" alt="" class="suit">
    </div>

    <div class="suitContainer col-4-5 row-3-4">
        <img src="/assests/{suit}.png" alt="" class="suit">
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

.col-2-3{
    grid-column: 2/3;
}

.row-3-4{
    grid-row: 3/4;
}

.col-4-5{
    grid-column: 4/5;
}


</style>