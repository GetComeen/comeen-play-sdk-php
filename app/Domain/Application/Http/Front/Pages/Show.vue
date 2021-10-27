<template>
  <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
      <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
          {{ application.name }}
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
          {{  application.description }}
        </p>
      </div>
      <div class="flex space-x-3 md:mt-0 md:ml-4">
        <Link as="button" :href="syncUrl(application.id)" type="button" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          Sync
        </Link>
<!--        <button @click="" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">-->
<!--          Sync-->
<!--        </button>-->
        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
          Some Thing
        </button>
      </div>
    </div>
    <div class="grid grid-cols-5 gap-3">
      <div class="col-span-3 border-t border-gray-200">
        <dl>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Name
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{  application.name }}
            </dd>
          </div>
          <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Description
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ application.description }}
            </dd>
          </div>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Type
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ application.type }}
            </dd>
          </div>
          <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Import type
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ application.type }}
            </dd>
          </div>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Version
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ application.version }}
            </dd>
          </div>
          <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              Channel
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ application.channel }}
            </dd>
          </div>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
              API level
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              {{ application.api_level }}
            </dd>
          </div>
        </dl>
      </div>
      <div class="col-span-2">
        <ul class="divide-y divide-gray-200">
          <li v-for="module in application.modules" :key="module.id">
            <a :href="/modules/+ module.id" class="block hover:bg-gray-50">
              <div class="flex items-center px-4 py-4 sm:px-6">
                <div class="min-w-0 flex-1 flex items-center">
                  <div class="flex-shrink-0">
                    <i :class="application.logo"></i>
                  </div>


                  <div class="min-w-0 flex-1 px-4">
                    <div>
                      <p class="text-sm font-medium text-indigo-600 truncate">{{ module.name }}</p>
                      <p class="mt-2 flex items-center text-sm text-gray-500">
                        <!-- Heroicon name: solid/mail -->
                        <span class="">{{  module.description }}</span>
                      </p>
                    </div>

                  </div>
                </div>
                <div>
                  <!-- Heroicon name: solid/chevron-right -->
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {provide, defineComponent, toRef, Ref, PropType, reactive, computed} from "vue";
import App from "@/Layouts/App.vue";
import { Application, Module } from "@/types/generated";
import route from "ziggy";
import { Link } from "@inertiajs/inertia-vue3"

interface thing {
    name: string,
    description: string
}

export default defineComponent({
    layout: App,
    components: { Link },
    props: {
        application: { type: Object as PropType<Application>, required: true },
    },
    setup(props) {
      // const modules = reactive(props.application.modules);
      const syncUrl = computed(appId => route('applications.sync', appId));

      return { syncUrl };
    }
})
</script>
