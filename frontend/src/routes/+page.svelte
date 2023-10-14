<script>
    import TitleStack from "$lib/Home/TitleStack/+page.svelte";
    import Intro from "$lib/Home/Intro/+page.svelte";
    import Options from "$lib/Home/Options/+page.svelte";
    import Creator from "$lib/Home/Creator/+page.svelte";
    import Login from "$lib/Home/Options/Forms/Auth/Login/+page.svelte";
    import Register from "$lib/Home/Options/Forms/Auth/Register/+page.svelte";
    import Join from "$lib/Home/Options/Forms/Game/Join/+page.svelte";
    import Host from "$lib/Home/Options/Forms/Game/Host/+page.svelte";
    import Rules from "$lib/Home/Options/Forms/Game/Rules/+page.svelte";
    import ShowFormContainerStore from "$lib/Stores/ShowFormContainerStore";
    import IsAuthedStore from "$lib/Stores/IsAuthedStore.js"

    export let data;

    let showFormContainer;
    let currentForm = null;

    ShowFormContainerStore.subscribe((data) => {
        showFormContainer = data;
    })

    function showForm(event){
        currentForm = event.detail.form
    }

    function authUser(){
        IsAuthedStore.update(currentData => {
            return true
        })
    }
    
</script>

{#if showFormContainer}
<div class="Forms">
    {#if currentForm.id ===  1}
        <Login on:authUser={authUser} height={currentForm.height} />

    {:else if currentForm.id === 2}
        <Register on:authUser={authUser} height={currentForm.height} />

    {:else if currentForm.id === 3}
        <Host authToken={data.authToken} height={currentForm.height} />
    
    {:else if currentForm.id === 4}
        <Join authToken={data.authToken} height={currentForm.height} />
    
    {:else if currentForm.id === 5}
        <Rules height={currentForm.height} />
    {/if}
</div>
{/if}


<main class="Intro {showFormContainer ? "blur" :""}">
    <TitleStack />
    <Intro />
    <Options on:showForm={showForm} data={data}/>  
    <Creator />  
</main>

<style lang="scss">

.Forms{
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    margin: 0;
    padding: 0;
}

.blur{
    filter: blur(.5rem);
    -webkit-filter: blur(.5rem);
    overflow-y: hidden;
    pointer-events: none;
}
</style>
