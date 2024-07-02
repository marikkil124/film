<template>
    <div>
        <div class="flex bg-white pl-1 p-8 mx-auto max-w-7xl">
            <!-- Левая боковая панель -->
            <div class="w-1/5 p-4 bg-white border-r-2 border-gray-200">
                <ul>
                    <li class="text-sm text-center text-sky-500 font-bold mb-4 block py-2 hover:text-blue-500">
                        <a @click="loadPages(MyFilm)">Мои фильмы</a>
                    </li>
                </ul>
            </div>

            <!-- Правая область контента -->
            <div class="w-5/6 p-4">
                <component :is="currentComponent"></component>
            </div>

            <div class="w-2/5 h-screen border-l-2 p-4 bg-white border-gray-200 rounded-lg">
                <div class=" border border-gray-300 bg-gray-300 flex justify-center">
                    Оценки
                </div>
                <ul class="text-center">
                    <li>
                        <div class="text-lg text-gray-500 font-bold mb-2 block py-1">
                            <estimation v-if="loaded" :data="data" :labels="labels"></estimation>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import MyFilm from '@/Pages/Film/MyFilm.vue';
import Estimation from '@/Components/Estimation.vue';

const currentComponent = ref(null);
const labels = ref([]);
const data = ref([]);
const loaded = ref(false);

function loadPages(page) {
    currentComponent.value = page;
    if(page.__name==='MyFilm')
        getEstimatesFilm();
}

function getEstimatesFilm() {
    axios.get('/favourite/film/estimate').then(response => {
        labels.value = Object.keys(response.data.count);
        data.value = Object.values(response.data.count);
        loaded.value = true;
    }).catch(error => {
        console.error('Error fetching estimates:', error);
    });
}



</script>

<style>
a {
    cursor: pointer;
}
</style>
