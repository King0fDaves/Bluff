<script>
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher()


    export let slider;
    let allowJokers = slider < 4 ? true:false;


    function closeForm(){
        dispatch('closeForm')
    }

    function host(){
        dispatch('host', {
            slider:slider,
            allowJokers:allowJokers
        })
    }
    
</script>


<button class="closeBtn" on:click={() => {closeForm()}}>
    <i class="fa-solid fa-arrow-left"></i>
</button>

<div class="HostFormInput">
    <span class="HostFormInput__title">Players: {slider}</span>

    <input bind:value={slider} type="range" min="3" max="6"
    on:mousemove={() => {slider < 4 ? allowJokers = true : null}} class="HostFormInput__slider">

</div>

<div class="HostFormInput">
    <span class="HostFormInput__title">Allow Jokers</span>
    <button class="HostFormInput__checkbox {allowJokers ? "checkedBtn":""}  {slider < 4 ? "disable checkedBtn":""}"
    
    on:click={() => {
        if(slider > 3){
            allowJokers = !allowJokers
        }   
    }}> 
        
        <div class="HostFormToggleBtn {allowJokers ? "checked":""} {slider < 4 ? "checked":""}" >
            {#if allowJokers || slider < 4}
                <i class="icon fa-solid fa-check"></i>
            {:else}
                <i class="icon fa-solid fa-xmark"></i>
            {/if}
        </div>
       
    </button>
</div>

<input on:click={() => {host()}} class="HostForm__btn" type="submit" value="Host">

<style lang="scss">

.HostFormInput{
    width: 100%;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 1rem;

}


.HostFormInput__title{
    margin-bottom: 1rem;
}

.HostFormInput__slider{
    -webkit-appearance: none;
    width: 40%;
    background: white;
    outline: none;
    -webkit-transition: .2s;
    transition: opacity .2s;
    height: .19rem;
    border-radius: 2rem;
    padding-left: .25rem;
    padding-right: .25rem;


    &::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background: red;
        cursor: pointer;
        border:  none;

    }

    &::-moz-range-thumb {
        width: 1rem;
        height: 1rem;
        background: red;
        cursor: pointer;
        border:  none;
        border-radius: 50%;

    }
}

.HostFormInput__checkbox{
    height: 2.7rem;
    width: 5rem;
    background: rgb(37, 37, 37);
    border: none;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: flex-start;
    border-radius: 2rem;
    padding: .1rem;
    position: relative;


}

.HostFormToggleBtn{
    position: absolute;
    height: 2.3rem;
    width: 2.3rem;
    border-radius: 50%;
    border: none;
    margin-left: .1rem;
    
    background: rgb(136, 136, 136);
    color: black;
    transition: .4s;
    display: flex;
    display: -ms-flexbox;
    display: -webkit-flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.HostForm__btn{
    width: 8rem;
    height: 2.5rem;
    font-size: 1rem;
    font-family: 'Zekton';
    background: $gradient4;
    border: none;
    color: white;
    text-transform: uppercase;
    letter-spacing: .1rem;

    @media screen and (max-width:400px){
        width: 7rem;
    }
    &:hover{
        background: #131313;
        border: white solid .05rem;

    }
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


.checkedBtn{
    background: red;
}


.checked{
    margin-left: calc(100% - 2.6rem);
    background: black;
    color: white;
    opacity: 1;
    height: 2.3rem;
    width: 2.3rem;
    border: none;
}

.icon{
    font-size: 1.1rem;
}

.disable{
    opacity: .6;
    pointer-events: none;
}

</style>