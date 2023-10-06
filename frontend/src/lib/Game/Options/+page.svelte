<script>

    export  let theStack; // The current stack of cards being played
    export let calledCards;

    import { createEventDispatcher } from "svelte";

    const dispatch  = createEventDispatcher()

    function cardSelection(){
        dispatch('selectCard', {
            selectCard:true
        })
    }

    function callCards(){

        if(theStack.length > 0){ // ~~ Setup error message for the user
            dispatch('callCards')
        }
    }

</script>


<div class="Options">
    <button class="OptionsBtn {calledCards ? "disable":""}" style="--size:1" on:click={() => {cardSelection()}}>
        <span class="OptionsBtn__title">Play</span>
    </button>
    
    <button class="OptionsBtn {calledCards ? "disable":""}" style="--size:1"  on:click={() => {callCards()}}>
        <span class="OptionsBtn__title"> Call   </span>
    </button>
</div>


<style lang="scss">

.Options{
    grid-row: 3/4;
    height: 100%;
    width: 100%;

    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;

    justify-content: space-between;


}

.OptionsBtn{
    min-width: calc(7.8rem / var(--size));
    height: calc(3rem / var(--size));
    margin: 1rem;
    font-size: calc(.9rem / var(--size));
    text-transform: uppercase;
    letter-spacing: .05rem;
    border: none;
    background: $gradient2;
    font-family:Arial, Helvetica, sans-serif;

    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    border-radius: 1.5rem;
    text-decoration: none;

    &:hover{
        background: rgb(82, 82, 82);
        cursor: pointer;
    }
}


.OptionsBtn__title{
    height: calc(100% - .3rem);
    width: calc(100% - .3rem);
    background: #000000;
    padding: 0;
    margin: 0;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    border-radius: 1.5rem;   
}

.disable{
    opacity: .5;
    pointer-events: none;
    background:rgb(82, 82, 82);
}
</style>