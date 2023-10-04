<script>
    import Card from "$lib/Cards/Card/+page.svelte";

    export let card;
    export let time;
    export let cardCount;
    export let id;
    export let isTitle = false;

    const newTime = sixDecFix(time / cardCount);
    let counter = 0;

    let renderTime = time;
    let renderCard = false

    setInterval(() => { // 

      if(counter < newTime){
        let newCount = 1/cardCount;
  
        counter += newCount;
      }   
    }, (1000/cardCount));
    
    setTimeout(() => {
        renderCard = true
    }, (renderTime * 1000) + 300);

    function sixDecFix (decimal){ // Literally programming language error
      if(decimal === 0.6){

        return 0.6000000000000001
      } else {
        return decimal
      }
    }


</script>

<div class="FlipCard {newTime === counter ? "flipCard":""}"
    style="--cardSize:{card.size}; z-index:{id}; --time:{time}s"
>      
    <div class="FlipCardInner {newTime === counter ? "flipCard":""}">

        <div class="Card" style="--cardSize:{card.size};">
            {#if newTime !== counter}
                <Card isBack={true} card={card} /> 
            {:else}
                {#if !renderCard}
                    <Card isBack={true} card={card} />
                {:else}    
                    <Card card={card} isTitle={isTitle} />
                {/if}
            {/if}
        </div>  

    </div>
</div>


<style lang="scss">
.FlipCard{
    position: relative;
    margin-top:var(--top);
    transition: 2s;
    height: calc(var(--cardSize) * 21rem);
    width:calc(var(--cardSize) * 15rem);
    perspective: 1000px; 
    
    background:white;
    padding:0;
    border-radius: 1rem;

    //transform: translateX(calc(4rem * var(--id)));
}

.FlipCardInner {
    position: relative;
    width: 100%;
    height: 100%;
    text-align: center;
    transition: transform 0.8s;
    transform-style: preserve-3d;    
}

.Card{
    -webkit-backface-visibility: hidden; 
    backface-visibility: hidden;
    border-radius: .5rem;


    height: calc(var(--cardSize) * 21rem);
    width:calc(var(--cardSize) * 15rem);


    border-radius: calc(var(--cardSize) * 1rem);;
    margin: 0;
    transform: rotateY(0deg);
    
    position: absolute;
    
    
}

.flipCard{
    animation: flipCard 1s linear calc(var(--time) - 1s) ;
}

</style>