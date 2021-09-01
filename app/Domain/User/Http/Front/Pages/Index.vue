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
                  Users
                </h1>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-6 flex space-x-3 md:mt-0 md:ml-4">
          <button @click="showCreateModal = true" type="button"
                  class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Add
          </button>
          <button type="button"
                  class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
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
                  User
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Full Name
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Role
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="user in users" :key="user.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <img class="h-10 w-10 rounded-full"
                           src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60"
                           alt="">
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ user.user_name }}
                      </div>
                      <div class="text-sm text-gray-500">
                        {{ user.email }}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ user.full_name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Active
                </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    Admin
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <a href="#" @click="openDeleteModal(user)" class="text-indigo-600 hover:text-indigo-900">Delete</a>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
          <SlideOptions :slide="slide"></SlideOptions>
        </div>
      </div>
    </div>
  </div>

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
        @submit="submitCreateForm"
        @close="showCreateModal = false"
        title="Create a user"
        submit="Create"
      >
        <template v-slot:body>
          <form class="pb-4 space-y-8 divide-y divide-gray-200">
            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
              <div class="sm:col-span-6">
                <label for="user_name" class="block text-sm font-medium text-gray-700">
                  User name
                </label>
                <div class="mt-1">
                  <input type="text" v-model="form.user_name" name="user_name" id="user_name" autocomplete="user-name"
                         class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                  <div class="mt-2 text-sm text-red-600" v-if="form.errors.user_name">{{ form.errors.user_name }}</div>
                </div>
              </div>

              <div class="sm:col-span-6">
                <label for="full_name" class="block text-sm font-medium text-gray-700">
                  Full name
                </label>
                <div class="mt-1">
                  <input type="text" v-model="form.full_name" name="full_name" id="full_name" autocomplete="full-name"
                         class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                  <div class="mt-2 text-sm text-red-600" v-if="form.errors.full_name">{{ form.errors.full_name }}</div>
                </div>
              </div>

              <div class="sm:col-span-6">
                <label for="email" class="block text-sm font-medium text-gray-700">
                  Email address
                </label>
                <div class="mt-1">
                  <input id="email" v-model="form.email" name="email" type="email" autocomplete="email"
                         class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                  <div class="mt-2 text-sm text-red-600" v-if="form.errors.email">{{ form.errors.email }}</div>
                </div>
              </div>

              <transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
              >
                <div class="sm:col-span-6" v-show="!form.generate_password">
                  <label for="password" class="block text-sm font-medium text-gray-700">
                    Password
                  </label>
                  <div class="mt-1">
                    <input id="password" v-model="form.password" name="password" type="password" autocomplete="current-password" :disabled="form.generate_password" required
                           class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <div class="mt-2 text-sm text-red-600" v-if="form.errors.password">{{ form.errors.password }}</div>
                  </div>
                </div>
              </transition>
              <div class="sm:col-span-6 flex items-center justify-between">
                <span class="flex-grow flex flex-col" id="generate_password">
                <span class="text-sm text-gray-500">Generate a random password sent by mail.</span>
                </span>
                <button type="button"
                        @click="form.generate_password = !form.generate_password"
                        :class="form.generate_password ? 'bg-indigo-600' : 'bg-gray-200'"
                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        :aria-pressed="true" aria-labelledby="generate_password">
                  <span class="sr-only">Use setting</span>
                  <span aria-hidden="true"
                        :class="form.generate_password ? 'translate-x-5' : 'translate-x-0'"
                        class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                </button>
              </div>
            </div>
          </form>
        </template>
      </FormModal>
    </div>
  </transition>
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
        class="z-20"
        @submit="submitDeleteForm"
        @close="showDeleteModal = false"
        title="Delete user"
        submit="Confirm"
      >
        <template v-slot:body>
          Are you sure to delete this user ?
        </template>
      </FormModal>
    </div>
  </transition>
</template>

<script lang="ts">
import {defineComponent, PropType, h, defineAsyncComponent } from "vue";
import App from "@/Layouts/App.vue";
import FormModal from "@/Components/Modals/FormModal.vue";
import { Inertia } from '@inertiajs/inertia';
import {useForm} from '@inertiajs/inertia-vue3';

export default defineComponent({
  layout: App,
  components: {
    FormModal
  },
  props: {
    users: {type: Array, required: true},
    errors: {type: Object as PropType<number>}
  },
  data() {
    return {
      slide: {
        name: "Simple Message",
        description: "Show simple message with a title and background color",
        options: null,
      },
      asyncComponentLoadTimeout: 5000,
      showCreateModal: false,
      showDeleteModal: false,
      activeUser: undefined as any,
    }
  },
  setup() {
    const form = useForm({
      user_name: null,
      full_name: null,
      email: null,
      password: null,
      generate_password: false,
    });

    return { form }
  },
  mounted() {

  },
  methods: {
    openDeleteModal(user: null) {
      this.showDeleteModal = true;
      this.activeUser = user;
    },
    submitCreateForm() {
      this.form.post('/users', {
        onSuccess: () => {
          this.form.reset();
          this.showCreateModal = false;
        }
      })
    },
    submitDeleteForm() {
      if (this.activeUser) {
        Inertia.delete('/users/' + this.activeUser.id, {
          onSuccess: () => {
            this.showDeleteModal = false;
            this.activeUser = null;
          }
        })
      }
    }
  }
})
</script>
