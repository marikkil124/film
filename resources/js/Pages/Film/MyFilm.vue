<script setup>
import Modal from "@/Components/Modal.vue";
import {nextTick, ref} from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {router, useForm} from "@inertiajs/vue3";
import ModalSearch from "@/Components/Modal.vue";
import {log10} from "chart.js/helpers";

const confirmingUserDeletion = ref(false);
const films = ref()
const filmId = ref(null)
const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
};
const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};
const check=ref(false)
const form = useForm({
    title: '',
    title_eng: '',
    url: '',
    id:''

});

const searchFilm = () => {
    axios({
        method: 'get',
        url: '/films',
        params: form.data()

    })
        .then(function (response) {
            films.value = response.data

            console.log(films.value)
        });

};

const addFilm = (film) => {
    check.value=true
    filmId.value=film.id



    axios({
        method: 'post',
        url: '/film',
        data: film

    })
        .then(res=> {
            films.value = res.data

            console.log(films.value)
        });

};


function Myfilms() {
    axios.get('/favourite/films').then(c => {

    })
}

Myfilms()


</script>

<template>
    <form class="max-w-fit">
        <div class="relative z-0 w-full mb-5 group">
            <input @focus="confirmUserDeletion" type="text" name="title" id="floating_last_name"
                   class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                   placeholder=" " required/>
            <label for="title"
                   class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last
                name</label>
        </div>
        <button> Найти</button>
        <Modal :show="confirmingUserDeletion" @close="closeModal" maxWidth="md">

            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Введите название фильма
                </h2>
                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="sr-only"/>
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


            <div  v-if="films" class="border-sky-200  bg-gray-50 border-2 mx-2 my-2 mb-2 mr-2 rounded-lg ">

                <div class="overflow-x-auto ">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                        <tr>
                            <th class="px-4 py-2 border-b bg-gray-50"></th>
                            <th class="px-4 py-2 border-b bg-gray-50">Название</th>
                            <th class="px-4 py-2 border-b bg-gray-50">Год</th>
                            <th class="px-4 py-2 border-b bg-gray-50">Тип</th>
                            <th class="px-4 py-2 border-b bg-gray-50"></th>
                        </tr>
                        </thead>
                        <tbody v-for="film in films">
                        <tr>
                            <td class="px-4 py-2 border-b">
                                <img :src="film.url" alt="Фильм 2"
                                     class="w-10 h-10 mr-4 rounded-md transition duration-300 transform hover:scale-150">
                            </td>
                            <td class="px-4 py-2 border-b">{{ film.title }}</td>
                            <td class="px-4 py-2 border-b">{{ film.year }}</td>
                            <td class="px-4 py-2 border-b">{{ film.type }}</td>
                            <td class="px-4 py-2 border-b">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"  class="w-6 h-6 fill-blue-500 cursor-pointer"  v-if="!check  && filmId===null"  @click="addFilm(film)">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6" v-if="check && filmId===film.id" @unload="check=false">
                                    <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                                </svg>



                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>
                <!--            <div class="flex items-center ">-->
                <!--                &lt;!&ndash; Картинка фильма &ndash;&gt;-->
                <!--                <img :src="film.url" alt="Фильм 2" class="w-10 h-10 mr-4 rounded-md transition duration-300 transform hover:scale-150">-->
                <!--                &lt;!&ndash; Название фильма &ndash;&gt;-->
                <!--                <h3 class="text-lg font-semibold flex-1">{{ film.title }}</h3>-->
                <!--                <h3 class="text-lg font-semibold flex-1">{{ film.year }}</h3>-->
                <!--                <h1 class="text-sm font-light  flex-1">Подробнее</h1>-->

                <!--                &lt;!&ndash; Кнопка "Добавить" &ndash;&gt;-->
                <!--                <button class="   py-2 bg-blue-500 text-white rounded-md" @click="addFilm(film)">Добавить</button>-->
                <!--            </div>-->

            </div>
        </Modal>

    </form>
</template>

<style scoped>

</style>
