<script>
    import numToLetter from "$lib/Functions/numToLetter.js";

    export let value;
    export let suit;
</script>


{#if numToLetter(value) > 3}
    <div class="suitContainer col-2-3 row-5-6">
        <img src="/assests/{suit}.png" alt="" class="suit flip">
    </div>

    <div class="suitContainer col-4-5 row-1-2">
        <img src="/assests/{suit}.png" alt="" class="suit">
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

.col-2-3{
    grid-column: 2/3;
} 

.row-5-6{
    grid-row: 5/6;
}

.col-4-5{
    grid-column: 4/5;
}
.row-1-2{
    grid-row: 1/2;
}

</style>