<script>
    import numToLetter from "$lib/Functions/numToLetter.js";
    import getHighest from "$lib/Functions/getHighest.js";
    import getLowest from "$lib/Functions/getLowest.js";

    export let Turn;
    export let currentValue = Turn.value;
    export let yourTurn;

    let clickedBtn = 0;
    let finalValue = currentValue;

    function setValue(){ // Sets the value of the card
        if(Turn.count > 0 ){
            finalValue = currentValue;
            Turn.value = finalValue;

            clickedBtn = 0;
        }
       
    }
    
    function increment(){ // Either increases that value of the cards or provides the highest value
        if(Turn.count === 0){

            const newValue = currentValue + 1
            
            if(newValue > 13){
                currentValue = 1
                Turn.value = 1;

            } else {
                currentValue = newValue
                Turn.value = newValue;
            }

            
        } else {
            clickedBtn = 2
            finalValue = getHighest(currentValue)
            Turn.value = finalValue;

        }
    }

    function decrement(){ // Either decreases that value of the cards or provides the lowest value
        if(Turn.count === 0){
            const newValue = currentValue - 1

            if(newValue < 1){
                currentValue = 13;
                Turn.value = 13;
            } else {
                currentValue = newValue
                Turn.value = newValue;
            }


        } else {
            clickedBtn = 1
            finalValue = getLowest(currentValue)
            Turn.value = finalValue;
        }

    }

</script>


<div class="ValueSetter">

    {#if yourTurn}
    <button class="ValueSetter__btn {clickedBtn === 1 && Turn.count > 0 ? "selected" : ""}"
    on:click={() => {decrement()}}>
        {#if Turn.count > 0}
            {numToLetter(getLowest(currentValue))}
        {:else}
            <i class="fa-solid fa-caret-down"></i>
        {/if}
    </button>
    <button class="ValueSetter__btn {clickedBtn === 0 && Turn.count > 0 ? "selected" : ""}"

    on:click={() => setValue()}>

        {numToLetter(currentValue)}

    </button>

    <button class="ValueSetter__btn {clickedBtn === 2 && Turn.count > 0 ? "selected" : ""}"
    on:click={ () => {increment()}}>

        {#if Turn.count > 0}
            {numToLetter(getHighest(currentValue))}
        {:else}
            <i class="fa-solid fa-caret-up"></i>
        {/if}
    </button>

    {:else}
        <button class="ValueSetter__btn">    
            <i class="fa-solid fa-xmark"></i>
        </button>

        <button class="ValueSetter__btn">
            <i class="fa-solid fa-xmark"></i>
        </button>
        
        <button class="ValueSetter__btn">
            <i class="fa-solid fa-xmark"></i>
        </button>
    {/if}
</div>

<style lang="scss">

.ValueSetter{
    margin: auto;
    width: 12rem;
    height: 100%;
    border-radius: 5rem;
    
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: space-evenly;
    padding: 0;    
}


.ValueSetter__btn{
    width: 3rem;
    height: 3rem;
    border-radius: 50%;
    border: none;
    background: rgb(56, 56, 56);
    color: white;
    font-size: 1.2rem;
    &:hover{
        border: solid red .15rem;;
        background: none;

    }

    font-family: sans-serif;
}


.selected{
    border: solid .15rem red;
    background: none;
}


</style>