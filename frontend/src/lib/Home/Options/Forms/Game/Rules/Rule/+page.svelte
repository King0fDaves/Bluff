<script>

    export let rule
</script>

<div class="Rule">
    <h3 class="Rule__title">{rule.name}</h3>
    <p class="Rule__desc">{rule.description}</p>
</div>


<style lang="scss">

.Rule__title{
        font-family: 'Zekton';
        text-transform: uppercase;
        letter-spacing: .1rem;
    }

    .Rule__desc{
        margin-left: 1rem;
    }

   

</style>