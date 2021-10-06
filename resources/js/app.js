import { createApp, h } from "vue";
import { App, plugin } from "@inertiajs/inertia-vue3";
import * as Vue from "vue";
import { ZiggyVue } from "ziggy";
import { Ziggy } from './ziggy';
require('./bootstrap');
const el = document.getElementById("app");
window.Vue = Vue;
createApp({
    render: () => h(App, {
        initialPage: JSON.parse(el.dataset.page),
        resolveComponent: require("./componentResolver"),
    })
}).use(plugin)
    .use(ZiggyVue, Ziggy)
    .mount(el);
//# sourceMappingURL=app.js.map