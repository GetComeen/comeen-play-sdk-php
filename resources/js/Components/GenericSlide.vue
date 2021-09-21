<script lang="ts">
import {defineComponent, h, PropType} from "vue";
import {SlideModule} from "../../../../dynamicscreen-sdk-js/dist";
import * as Vue from 'vue';

export default defineComponent({
  name: "GenericSlide",
  props: {
    module: { type: Object as PropType<SlideModule>, default: "" },
  },
  setup(props, ctx) {

    console.log(props.module, props.module.context)

    //@ts-ignore
    return props.module.setup(h, Vue);
  }
})
</script>

<style scoped>

</style>
