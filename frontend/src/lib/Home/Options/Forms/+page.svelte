<script>
    import Intro from "./Intro/+page.svelte"
    import ShowFormStore from "$lib/Stores/ShowFormStore.js";    
    import ShowFormContainerStore from "$lib/Stores/ShowFormContainerStore";
    
    export let title;
    export let height;

    let currentHeight = 1;

    let showForm;

    ShowFormStore.subscribe((data) => {
        showForm = data;
    })

    function updateHeight(){
        currentHeight = height
    }

    function displayForm(){
        ShowFormStore.update(currentData => {return true
        })
    }

    function closeForm(){
        ShowFormContainerStore.update(currentData => {return false})
    }
</script>

<div class="FormContainer" style="--heightMult:{!showForm ? 1:currentHeight}">

    {#if !showForm}
       <Intro title={title} 
            on:closeForm={closeForm}
            on:displayForm={displayForm}
            on:updateHeight={updateHeight}
        />
    {:else}
        <slot />
    {/if}

</div>
<style lang="scss">
.FormContainer{
    z-index: 6;
    width: 400px;

    @media screen and (max-width: 430px){
        width: calc(100% - 1.3rem);
    }

    height: calc(15rem * var(--heightMult));
    position: fixed;
    margin: 0;
    padding: 0;
    background: $gradient2;

    @include sharpCorners(2rem);

    
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;


    
    

    
}
</style>