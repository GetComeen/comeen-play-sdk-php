<template>
  <div class="bg-white shadow">
    <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
      <div class="py-6 md:flex md:items-center md:justify-between lg:border-t lg:border-gray-200">
        <div class="flex-1 min-w-0">
          <div class="flex items-center">
            <div>
              <div class="flex items-center">
                <h1 class="ml-3 text-2xl font-bold leading-7 text-gray-900 sm:leading-9 sm:truncate">
                  Settings
                </h1>
              </div>
              <div class="flex items-center">
                <p class="ml-3 mt-1 text-sm text-gray-900">
                  This information will be displayed and used publicly.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    <form @submit.prevent="submit" class="divide-y divide-gray-200 lg:col-span-9">
      <div class="py-6 px-4 sm:p-6 lg:pb-8">
        <div class="flex flex-col lg:flex-row">
          <div class="flex-grow space-y-6">
            <div class="w-3/4 space-y-6">
              <div class="col-span-9">
                <label for="repository_name" class="block text-sm font-medium text-gray-700">
                  Repository name
                </label>
                <div class="mt-1 rounded-md shadow-sm flex">
                  <span class="bg-gray-50 border border-r-0 border-gray-300 rounded-l-md px-3 inline-flex items-center text-gray-500 sm:text-sm">
                    apps.test/
                  </span>
                  <input type="text" v-model="form.repository_name" name="repository_name" id="repository_name" autocomplete="repository_name" class="focus:ring-light-blue-500 focus:border-light-blue-500 flex-grow block w-full min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                  <div class="mt-2 text-sm text-red-600" v-if="form.errors.repository_name">{{ form.errors.repository_name }}</div>
                </div>
              </div>
              <div class="col-span-9">
                <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                <input type="text" v-model="form.author" name="author" id="author" autocomplete="given-name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-light-blue-500 focus:border-light-blue-500 sm:text-sm">
                <div class="mt-2 text-sm text-red-600" v-if="form.errors.author">{{ form.errors.author }}</div>
              </div>

              <div class="col-start-1 col-end-7">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" v-model="form.email" name="email" id="email" autocomplete="family-name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-light-blue-500 focus:border-light-blue-500 sm:text-sm">
                <div class="mt-2 text-sm text-red-600" v-if="form.errors.email">{{ form.errors.email }}</div>
              </div>

              <div class="col-start-1 col-end-7">
                <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                <input type="text" v-model="form.company" name="company" id="company" autocomplete="organization" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-light-blue-500 focus:border-light-blue-500 sm:text-sm">
                <div class="mt-2 text-sm text-red-600" v-if="form.errors.company">{{ form.errors.company }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Privacy section -->
      <div class="pt-6 divide-y divide-gray-200">
        <div class="px-4 sm:px-6">
          <ul class="mt-2 divide-y divide-gray-200">
            <li class="py-4 flex items-center justify-between">
              <div class="flex flex-col">
                <p class="text-sm font-medium text-gray-900" id="active-label">
                  Make repository inactive
                </p>
                <p class="text-sm text-gray-500" id="active-description">
                  When your repository is inactive, the data is no longer accessible from outside.
                </p>
              </div>
              <button type="button"
                      @click="form.active = !form.active"
                      :class="form.active ? 'bg-primary-600' : 'bg-gray-200'"
                      class="bg-gray-200 ml-4 relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-blue-500" role="switch" aria-checked="false" aria-labelledby="active-label" aria-describedby="active-description">
                <span class="sr-only">Use setting</span>
                <span aria-hidden="true"
                      :class="form.active ? 'translate-x-5' : 'translate-x-0'"
                      class="translate-x-0 inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
              </button>
            </li>
          </ul>
        </div>
        <div class="mt-4 py-4 px-4 flex justify-end sm:px-6">
          <button type="button" class="bg-white border border-gray-300 rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-blue-500">
            Cancel
          </button>
          <button @click="submitUpdateForm" type="submit" class="ml-5 bg-primary-500 hover:bg-primary-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-light-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-light-blue-500">
            Save
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script lang="ts">
import {defineComponent, PropType, reactive} from "vue";
import App from "@/Layouts/App.vue";
import {useForm} from '@inertiajs/inertia-vue3';

interface Settings {
  repository_name: string,
  author: string,
  email: string,
  company: string,
  active: string,
}

export default defineComponent({
  layout: App,
  props: {
    settings: {type: Object as PropType<Settings>, required: true},
  },
  setup(props) {
    const settings = reactive(props.settings);
    const form = useForm({
      repository_name: settings.repository_name,
      author: settings.author,
      email: settings.email,
      company: settings.company,
      active: settings.active === '1',
    });

    const submitUpdateForm = () => {
      form.post('/settings');
    };

    return { form, submitUpdateForm }
  },
})
</script>
