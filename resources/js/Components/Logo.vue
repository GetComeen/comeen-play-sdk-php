<template>
  <div :class="className" class="flex justify-center items-center">
    <img v-if="logoIsUrl" :src="logo" :alt="alt" :class="`${className} w-full h-full rounded-full`">
    <i v-else :class="`${logo} ${className} rounded-full`"></i>
  </div>
</template>

<script lang="ts">
import {defineComponent, computed} from "vue";


export default defineComponent({
  name: "Logo",
  props: {
    className: { type: String, default: "" },
    logo: { type: String, default: "fa fa-info-circle" },
    alt: { type: String, default: "Logo"}
  },
  setup(props) {
    const logoIsUrl = computed(() => props.logo.startsWith('http'))

    return {
      logoIsUrl,
    }
  },
})
</script>
