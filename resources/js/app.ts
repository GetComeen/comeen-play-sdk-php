import { createApp, h } from "vue";
import { App, plugin } from "@inertiajs/inertia-vue3";
import i18next from 'i18next';
import * as Vue from "vue";



require('./bootstrap');

declare global {
  interface Window {
    [key: string]: any
  }
}

const el = document.getElementById("app");
window.Vue = Vue;


createApp({
    render: () => h(App, {
        initialPage: JSON.parse(el!.dataset.page!),
        resolveComponent: require("./componentResolver"),
    })
}).use(plugin)
    .mount(el!);

