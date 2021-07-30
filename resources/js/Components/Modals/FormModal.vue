<template>
    <div :class="className" class="fixed inset-0 overflow-y-auto" aria-labelledby="form-modal" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="mx-auto flex items-center justify-center">
                        <slot name="header">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ title }}
                            </h3>
                        </slot>
                    </div>
                    <div class="mt-3 sm:mt-5">
                        <slot name="body">
                          Please insert modal body
                        </slot>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <slot name="footer">
                        <button @click="$emit('submit')" :disabled="disabled" type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:col-start-2 sm:text-sm">
                            {{ submit }}
                        </button>
                        <button @click="$emit('close')"
                                type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                            {{ cancel }}
                        </button>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
    name: 'FormModal',
    props: {
        className: { type: String, default: "" },
        title: { type: String, default: "" },
        submit: { type: String, default: "Submit" },
        cancel: { type: String, default: "Cancel"} ,
        disabled: { type: Boolean, default: false },
    },
    emits: ['submit', 'close'],
    data() {
       return {}
    },
    setup() {

    },
    methods: {

    },
})
</script>

<style scoped>

</style>
