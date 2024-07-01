<template>
    <div >
        <div class="flex h-screen bg-white pl-1 p-8 mx-auto  max-w-7xl">
            <!-- Левая боковая панель -->
            <div class="w-1/5  p-4 bg-white border-r-2 border-gray-200   " >

                <ul class="  ">
                    <li class="  text-sm text-center text-sky-500 font-bold mb-4 block py-2 hover:text-blue-500"> <!-- Добавьте класс mr-4 для отступа между элементами -->

                        <a @click="loadPages(MyFilm)" class="">Мои фильмы</a>
                    </li>
                    <!-- Добавьте другие элементы списка здесь -->
                </ul>
            </div>

            <!-- Правая область контента -->
            <div class="w-5/6 p-4     ">
                <component :is="currentComponent" ></component>
            </div>



        </div>
    </div>

</template>

<script setup>
import {reactive, ref} from 'vue';
import { router } from '@inertiajs/vue3'
import MyFilm from "@/Pages/Film/MyFilm.vue"
import Estimation from "@//Components/Estimation.vue"


const currentComponent = ref(null);

function loadPages(page)
{
    currentComponent.value = page;

}




</script>

<style>
/* Стили для примера */
a { cursor: pointer; }
</style>
