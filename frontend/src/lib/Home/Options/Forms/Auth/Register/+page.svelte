<script>
    import { createEventDispatcher } from "svelte";

    import FormLayout from "$lib/Home/Options/Forms/+page.svelte";
    import ShowFormStore from "$lib/Stores/ShowFormStore.js";    
    import handleErrors from "$lib/Functions/handleErrors.js";
    import register from "$lib/Functions/ApiCalls/register.js";
    import setCookie from "$lib/Functions/setCookie.js";
    import removeForm from "$lib/Functions/removeForm.js";

    export let height; 

    const dispatch = createEventDispatcher();

    let username = null;
    let password = null;
    let confirmPassword = null;

    // Errors
    let showError = false;
    let errorMsg = null;


    function closeForm(){
        ShowFormStore.update(currentData => {
            return false
        })
    }

    function handleSubmit(){

        const theError = handleErrors(username, password, confirmPassword);
        
        if(theError.error){

            errorMsg = theError.msg;
            showError = theError.error;

            setTimeout(() => {

                showError = false;
                errorMsg = null;
            
            }, 2000)

        } else {

            signUp()
        }
        
        username = null;
        password = null;
        confirmPassword = null;
    }

    async function signUp(){

        const response = await register({
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
            errorMsg = "Username is in use"
        }
    
    }


</script>

<FormLayout title="Register" height={height}>
    <form class="RegisterForm" on:submit={handleSubmit}>
        <button class="closeBtn" on:click={() => {closeForm()}}>
            <i class="fa-solid fa-arrow-left"></i>
        </button>

        {#if showError}
            <span class="error">
                <i class="fa-solid fa-circle-xmark"></i> 
                {errorMsg}

            </span>
        {/if}

        <input class="RegisterForm__input" bind:value={username} type="text" placeholder="Enter Username">
        <input class="RegisterForm__input" bind:value={password} type="password" placeholder="Enter Password">
        <input class="RegisterForm__input" bind:value={confirmPassword} type="password" placeholder="Confirm Password">

        <input class="RegisterForm__btn" type="submit" value="Sign Up">
    </form>
</FormLayout>

<style lang="scss">
.RegisterForm{
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

.RegisterForm__input{
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

.RegisterForm__btn{
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
    
    width: 100%;
    text-align: center;
    font-size: 1.1rem;
    color: rgb(235, 118, 76);
}

</style>