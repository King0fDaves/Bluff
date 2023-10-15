<script>    
    import { createEventDispatcher } from "svelte";
    import login from "$lib/Functions/ApiCalls/login.js";
    import FormLayout from "$lib/Home/Options/Forms/+page.svelte";
    import ShowFormStore from "$lib/Stores/ShowFormStore.js";    
    import removeForm from "$lib/Functions/removeForm.js"
    import setCookie from "$lib/Functions/setCookie.js";

    export let height;

    const dispatch = createEventDispatcher()

    let username;
    let password;

    let failedAuth = false;
    let emptyFields = false;    
    let showError = false;

    export let data;

    
    function handleSubmit(){

        if(!username || !password){ // Checks if the fields are empty
            showError = true;
            emptyFields = true;
            failedAuth = false;
        } else {
            signIn()
        }
        username = null;     
        password = null;
    }

    
    async function signIn(){

        const response = await login({
            username:username,
            password:password
        })
        
        const responseData = await response.json()

        if(response.ok){
            const token = responseData.data.token;
            
            setCookie(token, 1)

            dispatch('authUser', {
                token: token
            })

            removeForm()
            
        } else {
            showError = true;
            failedAuth = true
        }
        
    }
    

 
</script>

<FormLayout title="Login" height={height}>    
    <form class="LoginForm"  on:submit={handleSubmit}>
    
        <button class="closeBtn" on:click={() => {
            ShowFormStore.update(currentData => {
                return false
            })
        }}>
            <i class="fa-solid fa-arrow-left"></i>
        </button>

        
        {#if showError}
            <span class="error">
                <i class="fa-solid fa-circle-xmark"></i> 
                {#if failedAuth}
                    Incorrect credentials
                {:else if emptyFields}
                    Fill in all fields
                {/if}
            </span>
        {/if}

        <input class="LoginForm__input" bind:value={username} type="text" placeholder="Enter Username">
        <input class="LoginForm__input" bind:value={password} type="password" placeholder="Enter Password">
        <input type="submit" class="LoginForm__btn" value="Sign In">
    </form>
</FormLayout>

<style lang="scss">
.LoginForm{
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
    justify-content: space-evenly;
    align-items: center;
    flex-direction: column;
    font-family: $primaryFont;
}

.closeBtn{
    background: none;
    border: none;
    color: red;
    font-size: 1.5rem;

    &:hover{
        color: white;
    }
}
.LoginForm__input{
    height: 2rem;
    width: 15rem;
    border: none;
    border-bottom: red solid .1rem;
    background: none;
    color: white;
    font-size: 1rem;
    background: none;
    @media screen and (max-width: 430px){
        width: 80%;
    }

    &::placeholder{
        font-family: 'Zekton';
    }
}

.LoginForm__btn{
    width: 8rem;
    height: 2.5rem;
    font-size: 1rem;
    font-family: 'Zekton';
    background: $gradient4;
    border: none;
    color: white;
    text-transform: uppercase;
    letter-spacing: .1rem;

    &:hover{
        background: #131313;
        border: white solid .05rem;

    }
}

.error{
    text-align: left;
    width: 100%;
    margin-left: 7rem;
    font-size: 1.1rem;
    color: rgb(235, 118, 76);

}
</style>