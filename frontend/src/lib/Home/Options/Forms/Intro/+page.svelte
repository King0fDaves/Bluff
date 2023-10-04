<script>
    import { createEventDispatcher } from "svelte";
    import Options from "./Options/+page.svelte"

    export let title;


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


<div class="FormIntro">
    <span class="Form__title">{title}</span>
    <Options on:closeForm={closeForm} on:displayForm={displayForm} on:updateHeight={updateHeight}/>
</div>


<style lang="scss">
.FormIntro{
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
    font-family: $primaryFont;



       
        
    }

.Form__title{
    font-size: 1.5rem;
    padding: 0;
    margin-top: 0;
    margin-bottom: 1rem;
    text-transform: uppercase;
    font-family: 'Zekton';
    font-weight: 800;
    color: whitesmoke;
    text-align: center;
    letter-spacing: .2rem;

}
</style>