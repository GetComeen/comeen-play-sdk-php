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
                                    Authorizations
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex space-x-3 md:mt-0 md:ml-4">
                    <button @click="showCreateModal = true" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Create
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
                  <div class="mb-6 shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Channel
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Applications
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Active
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
                      <tr v-for="auth in publicAuthorizations">
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-900">
                              {{ auth.name }}
                            </div>
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold">
                                  {{ auth.channel }}
                                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span v-if="!auth.applications.length" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            <Link href="/applications" class="text-primary-600 hover:text-primary-900">*</Link>
                          </span>
                          <span v-else v-for="app in auth.applications" :key="app.id" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            <Link :href="/applications/+ app.id" class="text-primary-600 hover:text-primary-900">{{ app.name }}</Link>
                          </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span :class="auth.active ? 'bg-green-100' : 'bg-red-100'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                            {{ auth.active }}
                          </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                          <span @click="openUpdateModal(auth)" class="text-primary-600 hover:text-primary-900 cursor-pointer">Edit</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                          <span @click="openDeleteModal(auth)" class="text-red-600 hover:text-red-900 cursor-pointer">Delete</span>
                        </td>
                      </tr>

                      <!-- More items... -->
                      </tbody>
                    </table>
                  </div>
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                      <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Channel
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Token
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Applications
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Active
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
                          <tr v-for="auth in privateAuthorizations">
                          <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="text-sm font-medium text-gray-900">
                                {{ auth.name }}
                              </div>
                            </div>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                              {{ auth.channel }}
                            </span>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                              {{ auth.api_token }}
                            </span>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <span v-for="app in auth.applications" :key="app.id" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                              <Link :href="/applications/+ app.id" class="text-primary-600 hover:text-primary-900">{{ app.name }}</Link>
                            </span>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <span :class="auth.active ? 'bg-green-100' : 'bg-red-100'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                              {{ auth.active }}
                            </span>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <span @click="openUpdateModal(auth)" class="text-primary-600 hover:text-primary-900 cursor-pointer">Edit</span>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <span @click="openDeleteModal(auth)" class="text-red-600 hover:text-red-900 cursor-pointer">Delete</span>
                          </td>
                        </tr>

                        <!-- More items... -->
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Create Modal-->
    <transition
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
        leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <div v-show="showCreateModal">
            <FormModal
                @close="showCreateModal = false"
                @submit="submitCreateForm"
                title="Create an authorization"
                submit="Create"
            >
                <template v-slot:body>
                  <form class="pb-4 space-y-8 divide-y divide-gray-200">
                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                      <div class="sm:col-span-6">
                        <label for="name" class="block text-sm font-medium text-gray-700">
                          Name
                        </label>
                        <div class="mt-1">
                          <input type="text" v-model="form.name" name="name" id="name" autocomplete="name"
                                 class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md">
                          <div class="mt-2 text-sm text-red-600" v-if="form.errors.name">{{ form.errors.user_name }}</div>
                        </div>
                      </div>

                      <div class="sm:col-span-6">
                        <label for="channel" class="block text-sm font-medium text-gray-700">
                          Channel
                        </label>
                        <div class="mt-1">
                          <select id="channel" v-model="form.channel" name="channel" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                            <option value="stable">Stable</option>
                            <option value="rc">Release Candidate</option>
                            <option value="beta">Beta</option>
                            <option value="alpha">Alpha</option>
                          </select>
                          <div class="mt-2 text-sm text-red-600" v-if="form.errors.channel">{{ form.errors.channel }}</div>
                        </div>
                      </div>

                      <div class="sm:col-span-6">
                        <label for="applications" class="block text-sm font-medium text-gray-700">
                          Applications
                        </label>
                        <select id="applications" v-model="form.applications" name="applications" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                          <option v-for="app in applications" :key="app.name + app.id" :value="app.id">{{ app.name }}</option>
                        </select>
                      </div>

                      <div class="sm:col-span-6 flex items-center justify-between">
                        <span class="flex-grow flex flex-col" id="generate_password">
                        <label for="active" class="block text-sm font-medium text-gray-700">
                          Enable
                        </label>
                        </span>
                        <button type="button"
                                @click="form.active = !form.active"
                                :class="form.active ? 'bg-primary-600' : 'bg-gray-200'"
                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                :aria-pressed="true" aria-labelledby="activate_authorization">
                          <span class="sr-only">Enable</span>
                          <span aria-hidden="true"
                                :class="form.active ? 'translate-x-5' : 'translate-x-0'"
                                class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                        </button>
                      </div>
                    </div>
                  </form>
                </template>
            </FormModal>
        </div>
    </transition>
<!-- Update Modal-->
    <transition
      enter-active-class="ease-out duration-300"
      enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      enter-to-class="opacity-100 translate-y-0 sm:scale-100"
      leave-active-class="ease-in duration-200"
      leave-from-class="opacity-100 translate-y-0 sm:scale-100"
      leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
      <div v-show="showUpdateModal">
        <FormModal
          @close="showUpdateModal = false"
          @submit="submitUpdateForm"
          title="Update an authorization"
          submit="Update"
        >
          <template v-slot:body>
            <form class="pb-4 space-y-8 divide-y divide-gray-200">
              <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-6">
                  <label for="name" class="block text-sm font-medium text-gray-700">
                    Name
                  </label>
                  <div class="mt-1">
                    <input type="text" v-model="form.name" name="name" id="name" autocomplete="name"
                           class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    <div class="mt-2 text-sm text-red-600" v-if="form.errors.name">{{ form.errors.user_name }}</div>
                  </div>
                </div>

                <div class="sm:col-span-6">
                  <label for="channel" class="block text-sm font-medium text-gray-700">
                    Channel
                  </label>
                  <div class="mt-1">
                    <select id="channel" v-model="form.channel" name="channel" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                      <option value="stable">Stable</option>
                      <option value="rc">Release Candidate</option>
                      <option value="beta">Beta</option>
                      <option value="alpha">Alpha</option>
                    </select>
                    <div class="mt-2 text-sm text-red-600" v-if="form.errors.channel">{{ form.errors.channel }}</div>
                  </div>
                </div>

                <div class="sm:col-span-6">
                  <label for="applications" class="block text-sm font-medium text-gray-700">
                    Applications
                  </label>
                  <VueMultiselect
                    v-model="form.applications"
                    tag-placeholder="Add this as new tag"
                    placeholder="Search a tag"
                    label="name" track-by="code"
                    :options="applicationsSelectOptions"
                    :multiple="true"
                    :taggable="true"
                    ></VueMultiselect>
                </div>

                <div class="sm:col-span-6 flex items-center justify-between">
                          <span class="flex-grow flex flex-col">
                          <label for="active" class="block text-sm font-medium text-gray-700">
                            Enable
                          </label>
                          </span>
                  <button type="button"
                          name="active"
                          id="active"
                          @click="form.active = !form.active"
                          :class="form.active ? 'bg-primary-600' : 'bg-gray-200'"
                          class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                          :aria-pressed="true" aria-labelledby="activate_authorization">
                    <span class="sr-only">Enable</span>
                    <span aria-hidden="true"
                          :class="form.active ? 'translate-x-5' : 'translate-x-0'"
                          class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                  </button>
                </div>
              </div>
            </form>
          </template>
        </FormModal>
      </div>
    </transition>
<!-- Delete Modal-->
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
          title="Delete an authorization"
          submit="Delete"
        >
          <template v-slot:body>
            <form class="pb-4">
              Are you sure to delete the following authorization ?
            </form>
          </template>
        </FormModal>
      </div>
    </transition>
</template>

<script lang="ts">
import {defineComponent, PropType, computed, ref } from "vue";
import App from "@/Layouts/App.vue";
import FormModal from "@/Components/Modals/FormModal.vue";
// @ts-ignore
import VueMultiselect from 'vue-multiselect';
import { useForm, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { Application } from "../../../../Application/Http/Front/Pages/Index.vue";

export interface Authorization {
  id: string | number,
  name: string,
  api_token: string,
  channel: CHANNEL,
  active: boolean,
  applications: Application[],
}

export interface ApplicationSelectOption {
  name: string,
  code: number | string,
}

export enum CHANNEL {
  Stable = 'stable',
  ReleaseCandidate = 'rc',
  Beta = 'beta',
  Alpha = 'alpha',
}

type ActiveAuthorization = Authorization | null;
type ApplicationSelectOptionForm = ApplicationSelectOption | string | number;

export default defineComponent({
    layout: App,
    components: { FormModal, VueMultiselect, Link },
    props: {
      authorizations: { type: Array as PropType<Authorization[]>, required: true },
      applications: { type: Array as PropType<Application[]>, required: true },
    },
    setup(props) {
      let showCreateModal = ref(false);
      let showUpdateModal = ref(false);
      let activeAuthorization: ActiveAuthorization = null;

      let showDeleteModal = ref(false);

      let form = useForm({
        name: "",
        channel: "",
        applications: <ApplicationSelectOptionForm[]>[],
        active: true,
      });

      const publicAuthorizations = computed(() => {
        return props.authorizations.filter((auth) => auth.api_token === null)
      });

      const privateAuthorizations = computed(() => {
        return props.authorizations.filter((auth) => auth.api_token !== null)
      });

      const applicationsSelectOptions = computed(() => {
        return props.applications.map((app) => {
          return { name: app.name, code: app.id };
        });
      });

      const submitCreateForm = (() => {
        form.post('/authorizations', {
          onSuccess: () => {
            showCreateModal.value = false;
            form.reset();
          }
        })
      });

      const submitUpdateForm = (() => {
        form
          .transform(data => ({ ...data, applications: data.applications.map((option: ApplicationSelectOptionForm) => (option as ApplicationSelectOption)?.code)}))
          .put('/authorizations/'+ activeAuthorization?.id, {
            onSuccess: () => {
              showUpdateModal.value = false;
              form.reset();
            }
          });
      });

      const openUpdateModal = ((authorization: Authorization) => {
        activeAuthorization = authorization;
        form.name = authorization.name;
        form.applications = authorization.applications.map((app) => {
          return { name: app.name, code: app.id };
        });
        form.channel = authorization.channel;
        form.active = authorization.active;
        showUpdateModal.value = true;
      })
      const openDeleteModal = ((authorization: Authorization) => {
        activeAuthorization = authorization;
        showDeleteModal.value = true;
      })
      const submitDeleteForm = (() => {
        Inertia.delete('/authorizations/'+ activeAuthorization?.id, {
          onSuccess: () => {
            showDeleteModal.value = false;
            activeAuthorization = null;
          }
        })
      })

      return {
        form,
        publicAuthorizations, privateAuthorizations, applicationsSelectOptions,
        submitCreateForm, submitUpdateForm, openUpdateModal, openDeleteModal, submitDeleteForm
      };
    },
})
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
