<template>
  <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900">
        {{ module.name }}
      </h3>
      <p class="mt-1 max-w-2xl text-sm text-gray-500">
        {{  module.description }}
      </p>
    </div>
    <div class="col-span-2 border-t border-gray-200">
      <dl>
        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">
            Name
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{  module.name }}
          </dd>
        </div>
        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">
            Description
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{ module.description }}
          </dd>
        </div>
        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">
            Type
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{ module.type }}
          </dd>
        </div>
        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">
            Application
          </dt>
          <Link :href="/applications/+ module.application.id"><dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{ module.application.name }}
          </dd></Link>
        </div>
        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">
            About
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            Fugiat ipsum ipsum deserunt culpa aute sint do nostrud anim incididunt cillum culpa consequat. Excepteur qui ipsum aliquip consequat sint. Sit id mollit nulla mollit nostrud in ea officia proident. Irure nostrud pariatur mollit ad adipisicing reprehenderit deserunt qui eu.
          </dd>
        </div>
        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">
            Attachments
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
              <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                <div class="w-0 flex-1 flex items-center">
<!--                  <PaperClipIcon class="flex-shrink-0 h-5 w-5 text-gray-400" aria-hidden="true" />-->
                  <span class="ml-2 flex-1 w-0 truncate">
                    resume_back_end_developer.pdf
                  </span>
                </div>
                <div class="ml-4 flex-shrink-0">
                  <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Download
                  </a>
                </div>
              </li>
              <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                <div class="w-0 flex-1 flex items-center">
<!--                  <PaperClipIcon class="flex-shrink-0 h-5 w-5 text-gray-400" aria-hidden="true" />-->
                  <span class="ml-2 flex-1 w-0 truncate">
                    coverletter_back_end_developer.pdf
                  </span>
                </div>
                <div class="ml-4 flex-shrink-0">
                  <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Download
                  </a>
                </div>
              </li>
            </ul>
          </dd>
        </div>
      </dl>
    </div>
<!--    <SlideOptions :slide="context.slide"></SlideOptions>-->
  </div>
  <div class="default shadow mt-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <Slide :context="context"></Slide>
  </div>
</template>
<script lang="ts">

import {defineComponent, PropType, h, defineAsyncComponent } from "vue";
import App from "@/Layouts/App.vue";
import importComponent from "@/import";
import { Link } from '@inertiajs/inertia-vue3';
import Loader from "@/Components/Loader.vue";


interface thing {
    name: string,
    description: string
}

const asyncComponentLoadTimeout = 5000;

export default defineComponent({
    layout: App,
    props: {
        module: { type: Object, required: true },
    },
    components: {
      Link,
      Slide: defineAsyncComponent({
        // image
        // loader: () => importComponent("DynamicScreenLibrary", "https://1346ef55da3b.ngrok.io/dynamicscreen.image/0.2.0/dist/Image.js", asyncComponentLoadTimeout),
        // video
        loader: () => importComponent("DynamicScreenLibrary", "https://40891f4c1f28.ngrok.io/dynamicscreen.video/0.2.0/dist/VideoOptions.js", asyncComponentLoadTimeout),
        // message
        // loader: () => importComponent("DynamicScreenLibrary", "https://1346ef55da3b.ngrok.io/dynamicscreen.message2/0.2.0/dist/SimpleMessage.js", asyncComponentLoadTimeout),
        loadingComponent: Loader,
        errorComponent: h("div", {class: "flex items-center justify-center text-blue-500"}, "Failed to load component"),
        delay: 0,
        timeout: asyncComponentLoadTimeout,
      }),
    },
    data() {
        return {
          context: {
            slide: {
              buildUrl: "https://40891f4c1f28.ngrok.io/dynamicscreen.video/0.2.0/dist/VideoOptions.js",
              data: {
                margin: '1',
                media: {
                  // video unisport
                  url: "https://dynamicscreen-uploads-fr.s3.eu-west-3.amazonaws.com/test-corentin/646/dmGqjlVsujgQ5LJVgGywLjIvRIWRQYZaNLD5OD4U.mp4",
                  // video rocketleague
                  // url: "https://dynamicscreen-uploads-fr.s3.eu-west-3.amazonaws.com/test-corentin/646/XzO1ENr9FRoG7mPSZ9LJ5M5LtG4Ja5RbFx4xa6k6.mp4",
                  // image earth
                  // url: "https://assets.weforum.org/article/image/large_G-u9Rg8kf3ffWB1kNG-xbQBjo9eqdAIWQyxWul08-z4.jpg",
                },
                orientation: 0,
                name: "Image",
                volume: 9,
                description: "Image description yeah",
                background_color: 'green',
                options: null,
                color: "red",
                caption_color: "orange",
                caption: "I'm just a poor caption you know.."
              },
            },
            settings: {
              language: "en",
            }
          },
        }
    },
    mounted() {
      // const script = document.createElement("script");
      // script.src = "https://e449efc12fc8.ngrok.io/dist/Image.js";
      // script.async = true;
      // document.body.appendChild(script);
      console.log('yo')
    },
    setup(props) {
    }
})
</script>
<style>
.default {
  background: blue;
}
</style>
