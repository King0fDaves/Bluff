<script>
    import { createEventDispatcher } from "svelte";
    import ShowFormContainerStore from "$lib/Stores/ShowFormContainerStore";
    import { logout } from "$lib/Functions/ApiCalls/logout.js";
    import IsAuthedStore from "$lib/Stores/IsAuthedStore.js";
    
    export let data;

    let isAuthed;

    IsAuthedStore.subscribe(data => {
        isAuthed = data
    })

    const checkAuthed = data.isAuthed

    IsAuthedStore.update(() => {
        return checkAuthed
    })

    const dispatch = createEventDispatcher()

    function showForm(form){
        dispatch('showForm', {
            form:form
        })
    }

    function showFormContainer(){
        ShowFormContainerStore.update(currentData => {
            return true
        })
    }

    function signOut(){
        logout(data.authToken)
        isAuthed = false;
        document.cookie ='authCookie=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';

        IsAuthedStore.update(() => {
            return false
        })
    
    }

    const options = [
        {id:1, name:"Login", isAuthed:false, height:1.4},
        {id:2, name:"Register", isAuthed:false, height:1.6},
        {id:3, name:"Host", isAuthed:true, height:1.3},
        {id:4, name:"Join", isAuthed:true, height:1},
        {id:5, name:"Rules", isAuthed:true, height:1.5},
        {id:6, name:"Logout", isAuthed:true},
    ]

</script>

<div class="Options">
    {#each options as option}
        {#if isAuthed  === option.isAuthed}  
            {#if option.id === 6}
                <button class="OptionsBtn" on:click={signOut}>
                    <div class="OptionsBtn__title">
                        {option.name}
                    </div>
                </button>
            {:else}
                <button class="OptionsBtn" 
                on:click={() => [showFormContainer(), showForm(option)]}>
                    <div class="OptionsBtn__title">
                        {option.name}
                    </div>
                </button>
            {/if}
        {/if}
    {/each}
</div>


<style lang="scss">
.Options{
    width: 100%;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}


.OptionsBtn{
    width: 7.5rem;
    height: 3rem;
    margin: 1rem;
    font-size: .9rem;
    text-transform: uppercase;
    letter-spacing: .05rem;
    border: none;
    background: $gradient2;
    font-family:Arial, Helvetica, sans-serif;
    
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    border-radius: 1.5rem;
    text-decoration: none;

    &:hover{
        background: rgb(82, 82, 82);
        cursor: pointer;
    }
}

.OptionsBtn__title{
    height: calc(100% - .3rem);
    width: calc(100% - .3rem);
    background: #000000;
    padding: 0;
    margin: 0;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    border-radius: 1.5rem;
    
}
</style>