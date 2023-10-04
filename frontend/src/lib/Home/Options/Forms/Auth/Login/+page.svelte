<script>
    import FormLayout from "$lib/Home/Options/Forms/+page.svelte";
    import ShowFormStore from "$lib/Stores/ShowFormStore.js";    
    export let height
</script>

<FormLayout title="Login" height={height}>
    <form class="LoginForm">
        <button class="closeBtn" on:click={() => {
            ShowFormStore.update(currentData => {
                return false
            })
        }}>
            <i class="fa-solid fa-arrow-left"></i>
        </button>

        <input class="LoginForm__input" type="text" placeholder="Enter Username">
        <input class="LoginForm__input" type="password" placeholder="Enter Password">
        <input class="LoginForm__btn" type="submit" value="Sign In">
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
}

    
</style>