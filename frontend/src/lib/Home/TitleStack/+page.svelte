<script>
    import CardFlip from "$lib/Cards/CardFlip/+page.svelte";
    
    let size = .55;
    const cards = [
        {id:1, value: "B", size:size, suit:"Spade", height:.8},
        {id:2, value: "L", size:size, suit:"Heart", height:1.3},
        {id:3, value: "U", size:size, suit:"Clover", height:.8},
        {id:4, value: "F", size:size, suit:"Diamond", height:1.5},
        {id:5, value: "F", size:size, suit:"Clover", height:.9},
    ]

</script>


<div class="TitleCards">
    {#each cards as card, i}
        <div style="z-index:{i+1}; --id:{i+1}; margin-top:{card.height * 2}rem" class="TitleCards__card">
            <CardFlip id={i+1} card={card} isTitle={true} time={2} cardCount={cards.length} />
        </div>
    {/each}
</div>

<div class="graphicContainer">
    <img class="graphic" src="Bluff_graphic.png" alt="Bluff_graphic.png"/>
</div>

<style>

.graphicContainer{
    
        width: 100%;
        display: flex;
        display: -ms-flexbox;
        display: -webkit-flex;
        margin-top: 1rem;

    @media screen and (min-width: 541px ) {
        display: none;

    }

    
}

.graphic{
    width: 20rem;
    margin: auto;
    padding: 0;
    align-self: center;

    
}

.TitleCards{
    height: 100%;
    max-width: 400px;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    transform: translateX(-4vw);
    margin: auto;
    
    @media screen and (max-width: 540px) {
        display: none;
    }
}

.TitleCards__card{
    transform: translateX(calc(var(--id) * -2.3rem));
}

</style>