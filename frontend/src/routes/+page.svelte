<script>
    import Card from "$lib/Cards/Card/+page.svelte";
    import CardFlip from "$lib/Cards/CardFlip/+page.svelte";

    let size = .8;
    const cards = [
        {value: "B", size:size, suit:"Spade"},
        {value: "L", size:size, suit:"Heart"},
        {value: "U", size:size, suit:"Clover"},
        {value: "F", size:size, suit:"Diamond"},
        {value: "F", size:size, suit:"Clover"},
    ]
</script>


<Card />

<div>
    {#each  cards as card, i}
        <CardFlip card={card} time={5} cardCount={cards.length} id={i+1}/>
    {/each}
</div>


<style lang="scss">
div{
    width: 100%;
    display: flex;
}
</style>
