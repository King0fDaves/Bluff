<script>
    import FormLayout from "$lib/Home/Options/Forms/+page.svelte";
    import Rule from "./Rule/+page.svelte";

    import ShowFormStore from "$lib/Stores/ShowFormStore.js";    
    export let height;

    const rules = [
        {id:2, name:"Advice", description: "You don't have to be honest about which card/s you place"},
        {id:3, name:"Rule 1", description:"Starting Player can place any card/s of a maximum of 4 cards"},
        {id:4, name:"Rule 2", description:"Next player places card/s equal, one value lower or higher than the previous player's card/s"},
        {id:5, name:"Rule 3.1", description:"Cycle repeats until any player calls 'Bluff' on the last player to place a card"},
        {id:6, name:"Rule 3.2", description:"If the player who placed the last card/s lied they pick up all cards"},
        {id:7, name:"Rule 3.3", description: "If the player who placed the last card/s was honest the one who called Bluff picks up all cards"},
        {id:8, name:"Rule 4", description: "The game resumes with the next player in line to play any card/s of a maximum of 4 cards"},
        {id:1, name:"Rule 5", description: "The game ends when a player has gotten rid of all their cards"},
        {id:9, name:"Joker Cards", description: "Jokers count as any card, they can be stacked with card/s of the same value"},

    ]
    function closeForm(){
        ShowFormStore.update(currentData => {
            return false
        })
    }

</script>

<FormLayout title="Rules" height={height}>
    <div class="RulesForm">
        
        <div class="Rules">
            {#each rules as rule }
                <Rule rule={rule} />
            {/each}
        </div>

        <button class="RulesForm__btn" on:click={() => {closeForm()}}>
            Close
        </button>
        
    </div>
</FormLayout>

<style lang="scss">
.RulesForm{
    height: 100%;
    width: 100%;

    height:calc(100% - 2.5rem);
    width: calc(100% - 2.5rem);
    background: rgb(12, 12, 12);
    padding: 1rem;
    
    @include sharpCorners(2rem);

    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    flex-direction: column;
    font-family: $primaryFont;
}

.Rules{
    width: calc(100% - 2rem);
    padding: 1rem;
    height:calc(100% - 4.5rem);

    overflow-y: scroll;
}

.RulesForm__btn{
    width: 8rem;
    height: 2.5rem;
    font-size: 1rem;
    font-family: 'Zekton';
    background: $gradient4;
    border: none;
    color: white;
    text-transform: uppercase;
    letter-spacing: .1rem;
    justify-self: flex-start;
    position: absolute;
    bottom: 1rem;

    &:hover{
        background: #131313;
        border: white solid .05rem;

    }
}

</style>