<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
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
                                    Applications
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex space-x-3 md:mt-0 md:ml-4">
                    <button @click="showImportModal = true" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Import
                    </button>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Some Thing
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Active
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  Version
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  Channel
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  API level
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                  <span class="sr-only">Delete</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="app in applications">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-6 w-5">
                                            <i :class="app.logo" class="h-10 w-10 rounded-full"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ app.name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ app.description }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                  {{ app.active }}
                                </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                  {{ app.version }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                  {{ app.channel }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                  {{ app.api_level }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                  <Link :href="/applications/+ app.id" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                  <span @click="openDeleteModal(app)" class="text-red-600 hover:text-red-900 cursor-pointer">Delete</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Import Form Modal -->
    <transition
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
        leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <div v-show="showImportModal">
            <FormModal
                @close="showImportModal = false"
                @submit="submitCreateForm"
                :disabled="form.processing"
                title="Import your application"
                submit="Import"
            >
                <template v-slot:body>
                    <form class="pb-4">
                      <div>
                        <div class="sm:hidden">
                          <label for="tabs" class="sr-only">Select a tab</label>
                          <select id="tabs" name="tabs" class="block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                            <option selected @click="currentImportTab = 'url'; form.type = 'url';">Url</option>
                            <option @click="currentImportTab = 'zip'; form.type = 'zip';">Zip</option>
                          </select>
                        </div>
                        <div class="hidden sm:block pb-6">
                          <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                              <a @click="currentImportTab = 'url'; form.type='url';" href="#"
                                 :class="currentImportTab === 'url' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                 class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
                                <svg
                                  :class="currentImportTab === 'url' ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500'"
                                  class="-ml-0.5 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                <span>Url</span>
                              </a>

                              <a @click="currentImportTab = 'zip'; form.type = 'zip';" href="#"
                                 :class="currentImportTab === 'zip' ? 'border-indigo-500 text-indigo-600' : ''"
                                 class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">
                                <svg
                                  :class="currentImportTab === 'zip' ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500'"
                                  class="-ml-0.5 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                                <span>Zip</span>
                              </a>
                            </nav>
                          </div>
                        </div>
                      </div>

                      <div v-show="currentImportTab === 'url'">
                        <label for="app_repository" class="block text-sm font-medium text-gray-700">
                            App Repository
                        </label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                              https://
                            </span>
                            <input type="text" v-model="form.url" name="app_repository" id="app_repository" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300" placeholder="www.github.com/example">
                        </div>
                      </div>
                      <div v-show="currentImportTab !== 'url'">
                        <div class="col-span-3">
                          <label class="block text-sm font-medium text-gray-700">
                            Cover photo
                          </label>
                          <div class="mt-1 border-2 border-gray-300 border-dashed rounded-md px-6 pt-5 pb-6 flex justify-center">
                            <div class="space-y-1 text-center">
                              <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                              </svg>
                              <div class="flex text-sm text-gray-600">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                  <span>Upload a file</span>
                                  <input @change="($e) => form.zip = $e.target.files[0]" id="file-upload" name="file-upload" type="file" accept=".zip,.rar,.7zip" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                              </div>
                              <p class="text-xs text-gray-500">
                                ZIP only
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="mt-2 text-sm text-red-600" v-if="form.errors.message">{{ form.errors.message }}</div>
                    </form>
                </template>
            </FormModal>
        </div>
    </transition>
    <!-- Deletion Modal -->
  <transition
      enter-active-class="ease-out duration-300"
      enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      enter-to-class="opacity-100 translate-y-0 sm:scale-100"
      leave-active-class="ease-in duration-200"
      leave-from-class="opacity-100 translate-y-0 sm:scale-100"
      leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
      <div v-show="showDeleteModal">
        <FormModal
          @close="showDeleteModal = false"
          @submit="submitDeleteForm()"
          title="Delete an application"
          submit="Delete"
        >
          <template v-slot:body>
            <form class="pb-4">
              Are you sure to delete the following application ?
            </form>
          </template>
        </FormModal>
      </div>
  </transition>
</template>

<script lang="ts">
import { defineComponent, toRef, Ref, PropType, reactive, ref } from "vue";
import App from "@/Layouts/App.vue";
import FormModal from "@/Components/Modals/FormModal.vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export interface Application {
  id: number | string,
  name: string,
  description: string,
  type: string,
  logo: string,
  url: string,
  import_type: string,
  options: ApplicationOptions,
  version: string,
  api_level: number,
  active: boolean,
  channel: string
}

export interface ApplicationOptions {
  path: string,
  author: {
    name: string,
    email: string
  }
}

export default defineComponent({
    layout: App,
    components: { FormModal, Link },
    props: {
      applications: {
        type: Array as PropType<Application[]>,
        required: true
      },
    },
    setup(props) {
      let showImportModal = ref(false);
      let currentImportTab = ref('url');
      let activeApplication: Application | null = null;
      let showDeleteModal = ref(false);

      const form = useForm({
        type: 'url',
        url: '',
        zip: File,
      });

      const submitCreateForm = (e: Event) => {
        form.post('/applications', {
          onSuccess: () => {
            showImportModal.value = false;
            form.reset();
          }
        })
      };

      const submitDeleteForm = (e: Event) => {
        Inertia.delete('/applications/'+ activeApplication?.id, {
          onSuccess: () => {
            showDeleteModal.value = false;
          }
        })
      };

      const openDeleteModal = (application: Application) => {
        showDeleteModal.value = true;
        activeApplication = application;
      };

      return {
        form, showDeleteModal, activeApplication, showImportModal, currentImportTab,
        openDeleteModal, submitCreateForm, submitDeleteForm
      };
    },
})
</script>
