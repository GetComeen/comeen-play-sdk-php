<template>
  <div class="bg-white shadow">
    <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
      <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
        <div class="flex-1 min-w-0">
          <!-- Profile -->
          <!--                    <Breadcrumb />-->
          <div class="flex items-center">
            <div>
              <div class="flex items-center">
                <h1 class="ml-3 text-2xl font-bold leading-7 text-gray-900 sm:leading-9 sm:truncate">
                  {{ bundle.name }}
                </h1>
              </div>
              <div class="flex items-center">
                <p class="ml-3 mt-2 flex items-center text-sm text-gray-500">
                  {{ bundle.description }}
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-6 flex space-x-3 md:mt-0 md:ml-4">
          <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Edit
          </button>
          <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Some Thing
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-white shadow overflow-hidden mt-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
  <ul class="divide-y divide-gray-200">
    <li v-for="app in applications" :key="app.id">
      <a :href="/applications/+ app.id" class="block hover:bg-gray-50">
        <div class="flex items-center px-4 py-4 sm:px-6">
          <div class="min-w-0 flex-1 flex items-center">
            <div class="flex-shrink-0">
              <i :class="app.logo"></i>
            </div>


            <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
              <div>
                <p class="text-sm font-medium text-indigo-600 truncate">{{ app.name }}</p>
                <p class="mt-2 flex items-center text-sm text-gray-500">
                  <!-- Heroicon name: solid/mail -->
                  <span class="truncate">{{  app.description }}</span>
                </p>
              </div>
              <div class="hidden md:block">
                <div>
                  <p class="text-sm text-gray-900">
                    Applied on
                    <time datetime="2020-01-07">January 7, 2020</time>
                  </p>
                  <p class="mt-2 flex items-center text-sm text-gray-500">
                    <!-- Heroicon name: solid/check-circle -->
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Completed phone screening
                  </p>
                </div>
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
</template>

<script lang="ts">
import { defineComponent, computed, PropType } from "vue";
import { Application } from "@/types/generated";
import App from "@/Layouts/App.vue";

interface Bundle {
  name: string,
  description: string,
  applications?: Application[],
}

export default defineComponent({
    layout: App,
    props: {
        bundle: { type: Object as PropType<Bundle>, required: true },
    },
    data() {

    },
    setup(props) {
      const applications = computed(() => {
        return props.bundle.applications;
      });

      return {
        applications
      }
    },
  computed: {

  }
})
</script>
