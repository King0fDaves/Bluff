<script>
    import FormLayout from "$lib/Home/Options/Forms/+page.svelte";
    import ShowFormStore from "$lib/Stores/ShowFormStore.js";    
    import Create from "./Create/+page.svelte";
    import Wait from "./Wait/+page.svelte";
    import HostSocket from "$lib/Sockets/HostSocket/+page.svelte"
    
    import hostRoom from "$lib/Functions/ApiCalls/Game/hostRoom.js";

    export let height;

    export let authToken;

    let slider = 3;
    let allowJokers;
    let hosted = false;

    let players = []

    let room;

    function closeForm(){
        ShowFormStore.update(currentData => {
            return false
        })
    }

    function addPLayer(event){
        players = [...players, event.detail.newUser]
    }

    async function host(event){
        height = 1;

        slider = event.detail.slider;
        allowJokers = event.detail.allowJokers;

        const roomDetails = {
            playerCount: slider,
            allowJokers:allowJokers
        }

        const response = await hostRoom(authToken, roomDetails)

        
        if(response.ok){

            const responseData = await response.json()
            room = responseData.data[0];
            hosted = true;
            const theHost = room.players[0].user.name
            players = [...players, theHost]
        }

    }   

</script>

<FormLayout title="Host" height={height}>
    <form class="HostForm">
        {#if !hosted}
        
            <Create slider={slider} on:closeForm={closeForm} on:host={host} />
            
        {:else}

           <Wait slider={slider} players={players} code={room.code}/>
           <HostSocket 
           on:addPlayer={addPLayer} token={authToken} roomId={room.id}/>

           
        {/if}


    </form>
</FormLayout>

<style lang="scss">
.HostForm{
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

    .PlayerCount__coloured{
        color: red;
    }
    .start{
        font-size: 1.3rem;
        text-transform: uppercase;
    }
    .Options{
        display: flex;
        display: -ms-flexbox;
        display: -webkit-flex;
        justify-content: space-evenly;
        align-items: center;
        width: 100%;
    }

    

    .HostFormInput{
        width: 100%;
        display: flex;
        display: -ms-flexbox;
        display: -webkit-flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 1rem;
        

        .HostFormInput__title{
            margin-bottom: 1rem;
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

            

        }

        .checkedBtn{
            background: red;
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


    }

    .HostForm__code{
        font-weight: 600;
        font-size: 1.3rem;
        letter-spacing: .1rem;
        text-transform: uppercase;
    }
    .Waiting{
        display: flex;
        display: -ms-flexbox;
        display: -webkit-flex;
        width: 100%;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        .WaitingList{
            display: flex;
            display: -ms-flexbox;
            display: -webkit-flex;
            width: calc(80%);
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: space-between;
            align-items:center;
            align-content: flex-start;
            overflow-y: scroll;
            

            max-height: 5rem;
            .WaitingList__players{
                width: 50%;
                @media screen and (max-width:400px){
                    width: 100%;
                    text-align: center;
  
                }
            }
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
    
    .disable{
        opacity: .6;
        pointer-events: none;
    }
    
    @keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    } 
}

    
</style>