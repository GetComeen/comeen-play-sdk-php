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
  <div v-if="loaded" class="default shadow mt-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <GenericSlide :module="slideModule"></GenericSlide>
  </div>

</template>
<script lang="ts">

import {inject, defineComponent, PropType, h, defineAsyncComponent, reactive, onMounted, ref} from "vue";
import App from "@/Layouts/App.vue";
import {importComponent, importComponentOptions, importModule} from "@/import";
import { Link } from '@inertiajs/inertia-vue3';
import Loader from "@/Components/Loader.vue";
//@ts-ignore
import GenericSlide from "@/Components/GenericSlide.vue";
import {IModule, ISlideContext, SlideModule, SlideModuleConstructor} from "dynamicscreen-sdk-js";
import * as Vue from "vue";

export default defineComponent({
  layout: App,
  props: {
    module: {type: Object, required: true},
  },
  components: {
    GenericSlide,
    Link,
  },
  setup(props, ctx) {
    const app = props.module.application;
    const url = 'https://ds-golem.eu.ngrok.io/storage/apps/'+ app.type +'/'+ app.version +'/dist/'+ app.name +'.js';
    console.log(url)
    const loaded = ref(false)

    // onMounted(async () => {
    //   const module = await importModule(
    //     app.type + '::' + app.version,
    //     app.name,
    //     url,
    //   ) as IModule
    //   console.log('wait ?')
    //   const constructor = module.default;
    //   let slideModule: SlideModule = new constructor(context);
    //   //@ts-ignore
    //
    //   console.log(slideModule)
    //
    //   setTimeout(() => {
    //     loaded.value = true;
    //   }, 5000)
    // })

    //@ts-ignore
    const context: ISlideContext = reactive({
      guardManager: {

      },
      slide: {
          "display": {
            "id": 131,
            "space_id": 33,
            "name": "Test-application",
            "description": "",
            "api_key": "HQW5vpOYGY6uJ7tFOvGxJrSSxd3VfRKVQxW0NvVpdnOvQyKj",
            "last_seen": "2020-07-27 11:10:32",
            "ip": "10.0.0.213",
            "slides_interval": 5,
            "messages_interval": 5,
            "enabled": true,
            "logo_url": null,
            "logo_media_id": null,
            "created_at": "2019-01-25 10:06:13",
            "updated_at": "2020-11-17 16:31:42",
            "address": "Aeroporto, 33000 Bordeaux, France",
            "lat": 44.837789,
            "lng": -0.57918,
            "scrolling": 1,
            "language": "ca",
            "timezone": "Europe/Paris",
            "player_id": null,
            "allow_unsecure": false,
            "enable_interactive_mode": 0,
            "interactive_slide_id": 1665,
            "currently_on_interactive_mode": false,
            "no_interaction_delay": 2,
            "interactive_mode_invite": 0,
            "interactive_mode_invite_icon": "fas fa-hand-pointer",
            "interactive_mode_invite_title": null,
            "interactive_mode_invite_subtitle": null,
            "orientation": 0,
            "enable_auto_sleep": 0,
            "auto_sleep_time": null,
            "auto_wake_up_time": null,
            "display_profile_id": null,
            "geocoding_id": null,
            "zoning_id": null,
            "remote_board": false,
            "retention_track": 30,
            "unit_system": "metric",
            "clock_format": "24h",
            "maintenance_window": 2,
            "is_connected": false,
            "connection_state": "Déconnecté depuis le Mon 27 Jul à 11:10:32",
            "connection_state_color": "red",
            "connection_state_icon": "far fa-cloud",
            "interactive_mode_slide": null,
            "unsecure_channel": 0,
            "url": "https://display.dynamicscreen.xyz/?api_key=HQW5vpOYGY6uJ7tFOvGxJrSSxd3VfRKVQxW0NvVpdnOvQyKj",
            "ghost_url": "https://display.dynamicscreen.xyz/?api_key=HQW5vpOYGY6uJ7tFOvGxJrSSxd3VfRKVQxW0NvVpdnOvQyKj&ghost",
            "display_metadata": [],
            "player": null,
            "profile": null,
            "logo_media": null,
            "shared_access_token": "ya29.a0ARrdaM9ZM811iQniG_2J7BpQWjx2KNcMa1g5CTiOhuH-c9TP3qt6vEFt23XEQaE-nGiIAvC2dqhDB6r50kdsm6U0sJVRLPfNoxZjmoTu3qiD2qxJeYPKkkLITk6vgHxlR43dnf9CB8tzNfnbiwVNzaisVFgZ_C0"
          },
          "zoning": null,
          "alert": null,
          "slides": [
            {
              "id": 3209,
              "name": "feel_good",
              "type": "dynamicscreen.slides-essentials.image",
              "position": 10,
              "slide_set_id": 236,
              "visible": true,
              "scheduled": 0,
              "begin_date": null,
              "end_date": null,
              "created_at": "2021-08-13 16:41:59",
              "updated_at": "2021-08-13 16:41:59",
              "duration": 5,
              "space_owner": true,
              "original_slide_id": 3209,
              "full_screen": false,
              "trigger_ids": null,
              "data": {
                "module" : {
                  "url": "https://ds-golem.eu.ngrok.io/storage/apps/dynamicscreen.image/0.2.0/dist/Image.js",
                  "identifier": "dynamicscreen.image::0.2.0"
                },
                "media": {
                  "id": 12767,
                  "created_at": "2020-10-13 10:01:38",
                  "updated_at": "2020-10-13 10:01:41",
                  "space_id": 33,
                  "folder_id": 157,
                  "filename": "notre-gamme-de-cafes",
                  "disk": "uploads-s3",
                  "disk_filename": "test-nico/157/hjcWIW5VWhgmWAvV99r6tLwZ9xbfSXT8IlIEeTlo.jpeg",
                  "thumbnail_filename": "test-nico/157/agw1l6Ibi6ZodI8GBs11ZeBjRwkGYbMLPMlvpmsx.webp",
                  "mime": "image/jpeg",
                  "size": 486482,
                  "metadata": [],
                  "uploaded_by": 257,
                  "hash": "91b0c5889f4df7c603848f6c5d9c8c07e397638f",
                  "deleted_at": null,
                  "expired_at": null,
                  "available_at": null,
                  "url": "https://dynamicscreen-uploads-fr.s3.eu-west-3.amazonaws.com/test-nico/157/hjcWIW5VWhgmWAvV99r6tLwZ9xbfSXT8IlIEeTlo.jpeg",
                  "thumbnail_url": "https://dynamicscreen-uploads-fr.s3.eu-west-3.amazonaws.com/test-nico/157/agw1l6Ibi6ZodI8GBs11ZeBjRwkGYbMLPMlvpmsx.webp",
                  "type": "Image JPEG",
                  "size_formatted": "486.48 KB",
                  "icon": "fas fa-image"
                },
                "size": 486482,
                "url": "https://dynamicscreen-uploads-fr.s3.eu-west-3.amazonaws.com/test-nico/157/hjcWIW5VWhgmWAvV99r6tLwZ9xbfSXT8IlIEeTlo.jpeg",
                "hash": "91b0c5889f4df7c603848f6c5d9c8c07e397638f",
                "color": "#000234" +
                  "",
                "media_id": 12767,
                "margin": "0",
                "caption": "",
                "caption_color": "white"
              },
              "page": 1,
              "uid": "13365;1",
              "settings": [],
              "icon": "fa-info-circle",
              "has_active_schedule": false,
              "scrolling": true,
              "has_padding": false,
              "display_offline": true,
              "triggerable": false,
              "trigger_settings": [],
              "medias": []
            },
            {
              "id": 3210,
              "name": "feel_sad",
              "type": "dynamicscreen.slides-essentials.video",
              "position": 11,
              "slide_set_id": 236,
              "visible": true,
              "scheduled": 0,
              "begin_date": null,
              "end_date": null,
              "created_at": "2021-08-13 16:41:59",
              "updated_at": "2021-08-13 16:41:59",
              "duration": 5,
              "space_owner": true,
              "original_slide_id": 3209,
              "full_screen": false,
              "trigger_ids": null,
              "data": {
                "module" : {
                  "url": "https://ds-golem.eu.ngrok.io/storage/apps/dynamicscreen.video/0.2.0/dist/Video.js",
                  "identifier": "dynamicscreen.video::0.2.0"
                },
                "media": {
                  "id": 4703,
                  "created_at": "2019-09-17 14:59:46",
                  "updated_at": "2019-09-17 14:59:57",
                  "space_id": 33,
                  "folder_id": 378,
                  "filename": "wiggly_cat",
                  "disk": "uploads-s3",
                  "disk_filename": "test-nico/378/lvabtu9bWueYXvLyrXEstTfSTxVtHdTeoRPeZa4s.mp4",
                  "thumbnail_filename": null,
                  "mime": "video/mp4",
                  "size": 909312,
                  "url": "https://dynamicscreen-uploads-fr.s3.eu-west-3.amazonaws.com/test-nico/378/lvabtu9bWueYXvLyrXEstTfSTxVtHdTeoRPeZa4s.mp4",
                  "metadata": {
                    "tries": 1,
                    "status": "completed",
                    "stream": {
                      "fps": 30,
                      "codec": "h264",
                      "width": 640,
                      "aspect": 1,
                      "height": 640,
                      "bitrate": 492,
                      "pix_fmt": "yuv420p",
                      "rotation": 0
                    },
                    "duration": 11,
                    "transcoded": true,
                    "job_responses": [
                      {
                        "id": 20284155,
                        "status": "ok"
                      }
                    ]
                  },
                  "uploaded_by": 191,
                  "hash": "eb6cf58ca41656443e09e4ec04179937cf2a8278",
                  "deleted_at": null,
                  "expired_at": null,
                  "available_at": null,
                  "thumbnail_url": null,
                  "type": "Vidéo MP4",
                  "size_formatted": "909.31 KB",
                  "icon": "fas fa-video"
                },
                "size": 909312,
                "url": "https://dynamicscreen-uploads-fr.s3.eu-west-3.amazonaws.com/test-nico/378/lvabtu9bWueYXvLyrXEstTfSTxVtHdTeoRPeZa4s.mp4",
                "hash": "eb6cf58ca41656443e09e4ec04179937cf2a8278",
                "media_id": 4703,
                "volume": "50",
                "mute": "1"
              },
              "page": 1,
              "uid": "13365;1",
              "settings": [],
              "icon": "fa-info-circle",
              "has_active_schedule": false,
              "scrolling": true,
              "has_padding": false,
              "display_offline": true,
              "triggerable": false,
              "trigger_settings": [],
              "medias": []
            },

          ],
          "widgets": [],
          "channels": []
        }
    });

    return {context, app, loaded};
  },
})

</script>

<style>
.default {
  background: blue;
}
</style>
