<script>
    import numToLetter from "$lib/Functions/numToLetter.js";
    
    export let value;
    export let suit;

</script>


{#if numToLetter(value) > 7}
    <div class="suitContainer col-2-3 row-2-3">
        <img src="/assests/{suit}.png" alt="" class="suit">
    </div>

    <div class="suitContainer col-2-3 row-4-5">
        <img src="/assests/{suit}.png" alt="" class="suit flip">
    </div>

    <div class="suitContainer col-4-5 row-2-3">
        <img src="/assests/{suit}.png" alt="" class="suit">
    </div>

    <div class="suitContainer col-4-5 row-4-5">
        <img src="/assests/{suit}.png" alt="" class="suit flip">
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

.col-4-5{
    grid-column: 4/5;
}

.row-2-3{
    grid-row: 2/3;
}

.row-4-5{
    grid-row: 4/5;
}
</style>