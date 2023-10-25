<script>
    import ShowFormContainerStore from "$lib/Stores/ShowFormContainerStore";
    import { goto } from '$app/navigation';

    export let isWinner;
</script>


<div class="EndContainer">

    <div class="EndMessageContainer">
        <span class="EndMessageContainer__title">
            {#if isWinner}
                You Won 

            {:else}
                You Lost

            {/if}
        </span>

        <button on:click={() => {
            
            ShowFormContainerStore.update(currentData => {
                return false;
            })

            goto('/')
            
        }} class="EndMessageContainer__btn"><i class="fa-solid fa-house"></i></button>

    </div>

</div>

<style lang="scss">
.EndContainer{
    z-index: 6;
    width: 400px;

    @media screen and (max-width: 430px){
        width: calc(100% - 1.3rem);
    }

    height: 15rem;
    margin: 0;
    padding: 0;
    background: $gradient2;

    @include sharpCorners(2rem);

    
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    
    font-family: 'Zekton';
}


.EndMessageContainer{

    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: space-between;
    
    height:calc(100% - 2.5rem);
    width: calc(100% - 2.5rem);
    background: rgb(12, 12, 12);
    padding: 1rem;

    @include sharpCorners(2rem);

    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    justify-content: center;
    flex-direction: column;
    font-family: 'zekton';

        
}

.EndMessageContainer__title{
    font-size: 1.5rem;
    padding: 0;
   
    text-transform: uppercase;
    color: whitesmoke;
    text-align: center;
    letter-spacing: .2rem;
    font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    @include gradientText($gradient3);
    margin: auto;
    margin-top: 3rem;
    margin-bottom: 1rem;


}

.EndMessageContainer__btn{

    width: 8rem;
    height: 2.5rem;
    font-size: 1rem;
    background: $gradient4;
    border: none;
    text-transform: uppercase;
    letter-spacing: .1rem;
    font-size: 1.3rem;
    margin: auto;
    color:white;

    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;

    &:hover{
        background: #131313;
        border: white solid .05rem;
        color: rgb(233, 98, 98);
    }
}

</style>