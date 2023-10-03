<script>
    import numToLetter from "$lib/Functions/numToLetter.js";

    export let suit;
    export let value;

</script>

{#if numToLetter(value) > 1 && numToLetter(value) < 4}
    <div class="suitContainer col-3-4 row-2-3">
        <img src="/assests/{suit}.png" alt="" class="suit">
    </div>

    <div class="suitContainer col-3-4 row-4-5">
        <img src="/assests/{suit}.png" alt="" class="suit flip">
    </div>
{/if}


<style>

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

.col-3-4{
    grid-column: 3/4;
}

.row-2-3{
    grid-row: 2/3;
}

.row-4-5{
    grid-row: 4/5;
}
</style>