import { createApp, h } from "vue";
import { App, plugin } from "@inertiajs/inertia-vue3";
import * as Vue from "vue";
require('./bootstrap');
const el = document.getElementById("app");
window.Vue = Vue;
createApp({
    render: () => h(App, {
        initialPage: JSON.parse(el.dataset.page),
        resolveComponent: require("./componentResolver"),
    })
}).use(plugin)
    .mount(el);
//# sourceMappingURL=app.js.map