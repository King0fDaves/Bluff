<script>
    import Card from "$lib/Cards/Card/+page.svelte";


    const size =.55;

    const cards = [
        {value: "J", size:size, suit:"Spade"},
        {value: "Q", size:size, suit:"Heart"},
        {value: "K", size:size, suit:"Diamond"},
        {value:"Joker", size:size, suit:"Diamond"},

    ];

</script>


<div class="Cards" style="height:calc(21rem * {size});">
    {#each cards as card, i}
        <div class="Cards__card" style="z-index:{i+1}">
            <Card card={card} isBack={true} />
        </div>
    {/each}
</div>

<h1 class="text">
    To play you have to <span class="specialText">host</span> or join a game, go to
    <a class="home specialText" href="/"> Home</a>

</h1>





<style lang="scss">
.Cards{
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    justify-content: center;
    margin-top: 3rem;
    position: relative;
}

.Cards__card{
    position: absolute;   
    margin: auto; 
}

.Cards__card:nth-child(1){
    transform: rotate(270deg) ;
}

.Cards__card:nth-child(2){
    transform: rotate(300deg)   ;
}

.Cards__card:nth-child(3){
    transform: rotate(240deg)  ;
}

.Cards__card:nth-child(4){
    transform: rotate(0deg) ;
}

.text{
    text-align: center;
    font-family: $primaryFont;
    width: calc(100% - 10rem);
    margin: auto;
    font-weight: 300;
    margin-top: 2rem;
}

.home{
    text-align: center;
    margin: auto;
    font-size: 3rem;
    color: rgb(252, 84, 84);
    font-family: $customFont;
    
    text-decoration: none;
    &:hover{
        color: white;
        background:none;
    }
}
   

</style>