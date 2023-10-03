<script>
    export let size;
    
</script>

<img src="/assests/Joker.png" class="Joker" alt="">
<span class="suitcheckedValue JokerTitle">Joker</span>

<style lang="scss"> 

.Joker{
    height: calc(var(--cardSize) * 4rem);
}

.JokerTitle{
    font-size: calc(var(--cardSize) * 3rem);
    text-decoration: underline;
    text-transform: uppercase;
}

</style>