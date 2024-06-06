<script setup>
import {nextTick, onMounted, ref} from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {

    if (input.value.hasAttribute('autofocus')) {
        nextTick(() => {
                input.value.focus();
        });
    }

});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        v-model="model"
        ref="input"
        autofocus
        autocomplete="off"
    />
</template>
