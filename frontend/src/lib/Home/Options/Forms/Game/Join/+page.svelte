<script>
    import FormLayout from "$lib/Home/Options/Forms/+page.svelte";
    import ShowFormStore from "$lib/Stores/ShowFormStore.js";    
    import Loader from "$lib/Misc/Loader/+page.svelte";
    export let height;

    let joined = false;
    function closeForm(){
        ShowFormStore.update(currentData => {
            return false
        })
    }

</script>

<FormLayout title="Join" height={height}>
    <form class="JoinForm">
        {#if !joined}
            <button class="closeBtn" on:click={() => {closeForm()}}>
                <i class="fa-solid fa-arrow-left"></i>
            </button>

            <input class="JoinForm__input" type="text" placeholder="Enter Code">
            <input on:click={() => {joined = true}} class="JoinForm__btn" type="submit" value="Join">

        {:else}
            <span class="JoinForm__code">E2MZ90</span>
            <div class="PlayerCounter">
                <i class="fa-solid fa-users"></i> - 3 / 4
            </div>
            <Loader />
            <input on:click={() => {joined = false}} class="JoinForm__btn" type="submit" value="Leave">

        {/if}


    </form>
</FormLayout>

<style lang="scss">
.JoinForm{
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
    .JoinForm__input{
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

    .JoinForm__btn{
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

    .JoinForm__code{
        font-weight: 600;
        font-size: 1.3rem;
        letter-spacing: .1rem;
    }
}

.PlayerCounter{
    font-size: 1.4rem;

    .PlayerCounter__count{
        color: red;
    }
}

.loader {
    width: 2rem;
    height: 2rem;
    border: .2rem solid #FFF;
    border-bottom-color: red;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation 1s linear infinite;
}

@keyframes rotation {
0% {
    transform: rotate(0deg);
}
100% {
    transform: rotate(360deg);
}
} 
</style>