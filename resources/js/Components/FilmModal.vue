<!-- FilmModal.vue -->
<template>
    <transition name="fade">
        <div v-if="show" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-3/4 max-w-3xl">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">{{ film.title }}</h2>
                    <button @click="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <div>
                    <p><strong>Год:</strong> {{ film.year }}</p>
                    <p><strong>Тип:</strong> {{ film.type }}</p>
                    <!-- Дополнительная информация о фильме -->
                </div>
            </div>
        </div>
    </transition>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    show: Boolean,
    film: Object
});

const emit = defineEmits(['close']);

const closeModal = () => {
    emit('close');
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>
