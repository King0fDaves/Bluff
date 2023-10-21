<script>
    export let size;
    export let showCount = false;
    export let count;
    export let countDegree;
</script>

<div class="BackCardSuits" style="--cardSize:{size}">
    <div class="backSuitCont row-2-3 col-2-3">
        <img src="/assests/Clover.png" class="backSuit " alt="suit.png">
    </div>

    <div class="backSuitCont row-2-3 col-4-5">
        <img src="/assests/Spade.png" class="backSuit " alt="suit.png">
    </div>

    <div class="backSuitCont  row-4-5 col-2-3">
        <img src="/assests/Heart.png" class="backSuit redSuit" alt="suit.png">
    </div>

    <div class="backSuitCont row-4-5 col-4-5">
        <img src="/assests/Diamond.png" class="backSuit diamond redSuit" alt="suit.png">
    </div>

</div>
<div class="JokerBorder">
    {#if !showCount}
        <img src="/assests/Joker.png" class="backSuitJoker" alt="suit.png">
    {:else}

        <span class="count" style="--countDegree:-{countDegree} ">{countDegree}</span>
    {/if}
</div>


<style lang="scss">
.BackCardSuits{
    display: grid;
    display: -ms-grid;
    display: -moz-grid;
    position: absolute;
    width: 100%;
    height: 100%;
    
    grid-template-columns: repeat(5, 1fr);
    grid-template-rows: repeat(5, 1fr);
}

.backSuitCont{
    display:flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    justify-content: center;
    align-items: center;
    padding: 0;
    width: 100%;
    height: 100%;
}

.backSuit{
    height:  calc(var(--cardSize) * 2.5rem);
    padding: 0;
    margin: 0;
}

.backSuitJoker{
    height:  calc(var(--cardSize) * 2.25rem);    
}

.diamond{
    height: calc(var(--cardSize) * 2.7rem)
}

.JokerBorder{
        height:  calc(var(--cardSize) * 5rem);    ;
        width:  calc(var(--cardSize) * 5rem);    ;
        background: white;
        display: flex;
        display: -ms-flexbox;
        display: -webkit-flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
    }


.row-2-3{
    grid-row: 2/3;
} 

.col-2-3{
    grid-column: 2/3;
}

.col-4-5{
    grid-column: 4/5;
}

.row-4-5{
    grid-row: 4/5; 
}

.count{
    transform: rotate(calc(7deg * var(--countDegree) ));
    font-size: 1.5rem;
    font-weight: 300;
}
</style>