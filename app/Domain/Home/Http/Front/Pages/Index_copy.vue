<template>
    <div class="text-center py-16 text-green-400">
        Hello {{ name }} ({{ nickname }})
    </div>
</template>

<script lang="ts">
import { defineComponent, toRef, Ref } from "vue";

export default defineComponent({
    props: {
        name: { type: String, required: true },
        nickname: { type: String, required: false },
    },
    setup(props) {
        const name: Ref<string> = toRef(props, "name");

        return {
            name,
        };
    }
})
</script>
