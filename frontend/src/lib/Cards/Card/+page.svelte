<script>
    import Side from "$lib/Cards/Card/Side/+page.svelte"
    import Suit_1 from "$lib/Cards/Card/Suits/Suit_1/+page.svelte";
    import Suit_2 from "$lib/Cards/Card/Suits/Suit_2/+page.svelte";
    import Suit_3 from "$lib/Cards/Card/Suits/Suit_3/+page.svelte";
    import Suit_4 from "$lib/Cards/Card/Suits/Suit_4/+page.svelte";
    import Suit_5 from "$lib/Cards/Card/Suits/Suit_5/+page.svelte";
    import Suit_6 from "$lib/Cards/Card/Suits/Suit_6/+page.svelte";
    import JokerCard from "$lib/Cards/JokerCard/+page.svelte";
    import BackCard from "$lib/Cards/BackCard/+page.svelte";

    export let card = {
        value:5,
        suit:"Spade",
        size:1
    }

    export let isBack = false;
    export let showBorder = true;
    export let isTitle = false;
    export let count = null;
    export let showCount = false;
    export let countDegree = null;
</script>


<div class="Card {isBack ? "Back":""} {showBorder ? "showBorder":""} {card.value === "Joker" ? "Joker":""}" style="--cardSize:{card.size};">

    {#if isBack}
        <BackCard size={card.size} showCount={showCount} count={count} countDegree={countDegree}/>

    {:else if card.value !== "Joker" && !isBack}
        <Side suit={card.suit}  value={card.value} size={card.size}/>
        <Side suit={card.suit} value={card.value} size={card.size} isLeft={true}/>
        <Suit_1 suit={card.suit} value={card.value} />
        <Suit_2 suit={card.suit} value={card.value} />
        <Suit_3 suit={card.suit} value={card.value} />
        <Suit_4 suit={card.suit} value={card.value} />
        <Suit_5 suit={card.suit} value={card.value} />
        <Suit_6 suit={card.suit} value={card.value} isTitle={isTitle}/>

    {:else if card.value === "Joker"}
        <JokerCard size={card.size} />

    {/if}

</div>
    



<style lang="scss">
.Card{
    position: relative;
    height: calc(var(--cardSize) * 21rem );
    width:calc(var(--cardSize) * 15rem);

    display: grid;
    display: -ms-grid;
    display: -moz-grid;
    
    grid-template-columns: .8fr repeat(3, 1fr) .8fr;
    grid-template-rows: repeat(5, 1fr);

    border-radius: calc(var(--cardSize) * 1rem);;
    margin: 0;
    background: white;
    color: black;
}

.showBorder{
    border: solid .15rem black;
}

.Joker{
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.Back{
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    background: $gradient1;
    position: relative;
        
}
</style>