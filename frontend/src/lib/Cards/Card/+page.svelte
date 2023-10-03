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
    export let size = 1;
    export let value = 'Joker';
    export let suit = "Clover";
    export let colour = "black";
    export let isBack = true;
    export let showBorder = true;
    export let isTitle = false;

</script>


<div class="Card {isBack ? "Back":""} {showBorder ? "showBorder":""} {value === "Joker" ? "Joker":""}" style="--cardSize:{size};">

    {#if isBack}
        <BackCard size={size} />

    {:else if value !== "Joker" && !isBack}
        <Side suit={suit} colour={colour} value={value} size={size}/>
        <Side suit={suit} colour={colour} value={value} size={size} isLeft={true}/>
        <Suit_1 suit={suit} value={value} />
        <Suit_2 suit={suit} value={value} />
        <Suit_3 suit={suit} value={value} />
        <Suit_4 suit={suit} value={value} />
        <Suit_5 suit={suit} value={value} />
        <Suit_6 suit={suit} value={value} isTitle={isTitle}/>

    {:else if value === "Joker"}
        <JokerCard size={size} />

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