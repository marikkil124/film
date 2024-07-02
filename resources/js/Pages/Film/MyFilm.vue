<script setup>
import Modal from "@/Components/Modal.vue";
import {ref, watch} from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {router, useForm} from "@inertiajs/vue3";

import FilmList from "@/Pages/Film/FilmList.vue";

import axios from "axios";

const propFilm=ref({})
const confirmingUserDeletion = ref(false);
const films = ref()

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
};
const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};
const check = ref(false)
const pagination=ref(false)
const form = useForm({
    title: '',
    title_eng: '',
    url: '',
    id: '',

});

const searchFilm = () => {
    axios({
        method: 'get',
        url: '/films',
        params: form.data()

    })
        .then(function (response) {
            films.value = response.data.data
            pagination.value=response.data
            console.log( films.value)

        });

};


const addFilm = (film) => {

    propFilm.value=film
    axios({
        method: 'post',
        url: '/film',
        data: film

    })
        .then(res => {

            film.is_my_film.value = false
            console.log(res)
        });

};



function paginationSearch(url)
{

    axios.get(url).then(response=>{
        films.value = response.data.data
        pagination.value=response.data
    }).catch(c=>{
      })
}




</script>

<template>
    <form class="max-w-fit">
        <div class="relative z-0  mb-5 group">
            <input autocomplete="off" @focus="confirmUserDeletion" type="text" name="title" id="floating_last_name"
                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                   placeholder=" " required/>
            <label for="title"
                   class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">

                Поиск фильма...

            </label>
        </div>

        <Modal :show="confirmingUserDeletion" @close="closeModal" maxWidth="md">

            <div class="p-6">

                <div class="mt-6">
                    <InputLabel for="name" value="name" class="sr-only"/>
                    <TextInput
                        id="name"
                        ref="name"
                        v-model="form.title"
                        type="text"
                        class="mt-1 block w-3/4"
                        placeholder="search"

                    />
                </div>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel</SecondaryButton>
                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="searchFilm"
                    >
                        Search
                    </DangerButton>
                </div>
            </div>


            <div v-if="films" class="border-sky-200  bg-gray-50 border-2 mx-2 my-2 mb-2 mr-2 rounded-lg   ">

                <div class=" items-center">
                    <table class="min-w-full bg-white border border-gray-200 text-center">
                        <thead>
                        <tr>
                            <th class="px-4 py-2 border-b bg-gray-50"></th>
                            <th class="px-4 py-2 border-b bg-gray-50">Название</th>
                            <th class="px-4 py-2 border-b bg-gray-50">name</th>
                            <th class="px-4 py-2 border-b bg-gray-50">Год</th>
                            <th class="px-4 py-2 border-b bg-gray-50">Тип</th>
                            <th class="px-4 py-2 border-b bg-gray-50"></th>
                        </tr>
                        </thead>
                        <tbody v-for="film in films">
                        <tr>
                            <td class=" ml-2 border-b w-20 ">
                                <img :src="film.url"
                                     class=" ml-2  w-16 h-16 mr-4 rounded-md  transform hover:scale-150">
                            </td>
                            <td class=" py-2 border-b">{{ film.title }}</td>
                            <td class=" py-2 border-b">{{ film.title_eng }}</td>
                            <td class=" py-2 border-b">{{ film.year }}</td>
                            <td class=" py-2 border-b">{{ film.type }}</td>
                            <td class=" py-2 border-b">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="w-6 h-6 fill-blue-500 cursor-pointer" v-if="!film.is_my_film "
                                     @click="addFilm(film); film.is_my_film=true">
                                    <path fill-rule="evenodd"
                                          d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="w-6 h-6" v-if="film.is_my_film ">
                                    <path fill-rule="evenodd"
                                          d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z"
                                          clip-rule="evenodd"/>
                                </svg>

                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>


            <div  v-if="films" class="flex flex-col items-center">
                <!-- Help text -->
                <span class="text-sm text-gray-700 dark:text-gray-400">
      Показана <span class="font-semibold text-gray-900 dark:text-white">{{pagination.current_page}}</span>   Страница из <span class="font-semibold text-gray-900 dark:text-white">{{pagination.last_page}}</span></span>
                <div class="inline-flex mt-2 xs:mt-0">
                    <!-- Buttons -->
                    <button @click="paginationSearch(pagination.prev_page_url)" class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 rounded-s hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                        </svg>
                        Prev
                    </button>
                    <button  @click="paginationSearch(pagination.next_page_url)" class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 border-0 border-s border-gray-700 rounded-e hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">

                        Next
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </button>
                </div>
            </div>


        </Modal>

    </form>
    <div class=" flex   ">

        <div class=" flex w-3/4 justify-center ">
            <film-list  :film="propFilm" > </film-list>
        </div>

    </div>

</template>

<style scoped>

</style>
