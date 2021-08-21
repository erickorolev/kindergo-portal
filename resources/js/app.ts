/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// @ts-ignore
import Alpine from 'alpinejs';
// @ts-ignore
window.Alpine = Alpine;

Alpine.start();

import {createApp} from "vue";
import ExampleComponent from "./components/ExampleComponent.vue";
import App from "./App.vue";
import PasswordChangeComponent from "./components/PasswordChangeComponent.vue";

createApp({
    components: {
        ExampleComponent,
        PasswordChangeComponent,
        App
    }
}).mount('#app')
