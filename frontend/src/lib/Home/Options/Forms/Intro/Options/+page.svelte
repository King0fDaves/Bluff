
<script>
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher()

    function closeForm(){
        dispatch('closeForm')
    }

    function displayForm(){
        dispatch('displayForm')
    }

    function updateHeight(){
        dispatch('updateHeight')
    }
    
</script>

<div class="FormOptions">
    <button class="FormOptions__btn decline"
     on:click={() => {closeForm()}}>
        <i class=" fa-solid fa-xmark"></i>
    </button>

    <button class="FormOptions__btn accept" 
    on:click={() => [displayForm(), updateHeight()]
    
    }>
        <i class="fa-solid fa-check"></i>
    </button>
</div>

<style lang="scss">
.FormOptions{
        position: absolute;
        align-self: center;
        margin-top: 5rem;
        width: 80%;
        display: flex;
        display: -ms-flexbox;
        display: -webkit-flex;
        justify-content: space-evenly;
    }

.FormOptions__btn{
    font-size: 1.5rem;
    background: none;
    color: white;
    border: none;

    
    &:hover{
        color: white;
    }
}

.accept{
    color: rgb(31, 233, 31);
}

.decline{
    color: red;
}

</style>