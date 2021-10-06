<template>
  <div :class="className" aria-live="assertive" class="fixed inset-0 z-30 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end">
    <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
      <div class="p-4">
        <div class="flex items-start">
          <div class="flex-shrink-0">
            <i v-if="type === 'success'" class="text-green-400 far fa-check-circle text-xl"></i>
            <i v-if="type === 'error'" class="text-red-400 far fa-times-circle text-xl"></i>
            <i v-if="type === 'warning'" class="text-yellow-400 far fa-exclamation-triangle text-xl"></i>
          </div>
          <div class="ml-3 w-0 flex-1 pt-0.5">
            <p class="text-sm font-medium text-gray-900">
              {{ title }}
            </p>
            <p class="mt-1 text-sm text-gray-500">
              {{ body }}
            </p>
          </div>
          <div class="ml-4 flex-shrink-0 flex">
            <button @click="dismiss()" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
              <span class="sr-only">Close</span>
              <!-- Heroicon name: solid/x -->
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, computed, onMounted, ref} from "vue";


export default defineComponent({
  name: "SimpleNotification",
  props: {
    className: { type: String, default: "" },
    flash: { type: Object, required: true },
    duration: { type: Number, default: 6000 },
    type: { type: String, default: 'success' },
  },
  emits: ['dismiss'],
  data() {
  },
  setup(props, { emit }) {
    let dismissTimeout = 0;

    onMounted(() => {
      dismissTimeout = window.setTimeout(() => emit('dismiss'), props.duration);
    });

    const title = computed(() => {
      return props.flash.title;
    });

    const body = computed(() => {
      return props.flash.content;
    });

    const dismiss = (() => {
      if (dismissTimeout) {
        clearTimeout(dismissTimeout);
      }
      emit('dismiss');
    });

    return {
      dismissTimeout, title, body,
      dismiss,
    }
  },
})
</script>
