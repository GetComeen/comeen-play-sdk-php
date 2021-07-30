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
                                    Bundles
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
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="table-auto divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Version
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Path
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
                            <tr v-for="bundle in bundles">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-6 w-5">
                                            <i class="h-10 w-10 fa fa-info-circle rounded-full"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ bundle.name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ bundle.description }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                                    <div class="text-sm text-gray-500">Optimization</div>
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
                                    <Link :href="/bundles/+ bundle.id" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
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
                title="Create your bundle"
                submit="Create"
            >
                <template v-slot:body>
                    <form class="pb-4">
                    </form>
                </template>
            </FormModal>
        </div>
    </transition>
</template>

<script lang="ts">
import { defineComponent, toRef, Ref } from "vue";
import App from "@/Layouts/App.vue";
import FormModal from "@/Components/Modals/FormModal.vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
    layout: App,
    components: { FormModal, Link },
    props: {
      bundles: { type: Array, required: true },
    },
    data() {
      return {
        showCreateModal: false,
        currentImportTab: 'url',
      }
    },
    setup(props) {
        // console.log(props, 'a')
        // const applications: Ref<String> = toRef(props, "applications");

      const form = useForm({
        type: null,
        url: null,
        path: null,
      })

        return {
            form,
        };
    },
    methods: {
        submitCreateForm(e: Event) {
            this.form.post('/bundles', {
              onSuccess: () => {
                this.showCreateModal = false;
                this.form.reset();
              }
            })
        }
    }
})
</script>
