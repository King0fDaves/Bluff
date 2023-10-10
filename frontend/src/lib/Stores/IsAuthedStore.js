import { writable } from "svelte/store";

const IsAuthedStore = writable(false);

export default IsAuthedStore;