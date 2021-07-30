<template>
  <div class="flex items-center justify-center">
  <button type="button" disabled class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
    <i class="fa fa-spinner-third animate-spin h-5 w-5 mr-3 flex items-center justify-center"></i>
    Processing
  </button>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "Loader",
  props: {
    className: { type: String, default: "" },
  },
})
</script>

<style scoped>

</style>
