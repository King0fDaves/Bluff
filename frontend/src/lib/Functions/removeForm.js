import ShowFormContainerStore from "$lib/Stores/ShowFormContainerStore.js";
import ShowFormStore from "$lib/Stores/ShowFormStore.js"

const removeForm = () => { // To remove the form after a user submission
    ShowFormStore.update(currentData => {
        return false;
    })

    ShowFormContainerStore.update(currentData => {
        return false;
    })

}

export default removeForm