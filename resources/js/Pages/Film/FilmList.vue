<script setup>
import {onMounted, ref, watch} from "vue";
import {log10} from "chart.js/helpers";
import FilmModal from "@/Components/FilmModal.vue";
import FormNumberCounter from "@/Components/FormNumberCounter.vue";

const films = ref({})
const detailId = ref()
const check = ref(false)

// Определение пропсов
const props = defineProps({
    film: {}
});

watch(
    () => props.film,
    (newValue, oldValue) => {
        if (newValue)
            myFilms()
    }
);

const myFilms = () => {

    axios.get('favourite/film').then(response => {
        films.value = response.data.data;
    }).catch(c => {
        console.log(c)
    });

};

myFilms()

function detail(id) {
    detailId.value = id;
}

function estimate(change,film) {
    film.estimate += change;
    axios.patch(`/favourite/film/${film.id}/estimate`, { estimate: film.estimate })
    if (film.estimate < 1) film.estimate = 1;
    if (film.estimate > 10) film.estimate = 10;


}

function deleteMyFilm(id) {
    let confirmation = confirm('действительно удалить?')
    if (confirmation) {
        axios.delete(`favourite/film/${id}`).then(r => {
            return films.value.find((item, index, array) => {
                if (item.id === id)
                    return array.splice(index, 1)
            })

        }).catch(c => {
            console.log(c)
        })
    }
}
function updateEstimate(event, film) {
    // Обновление оценки при ручном вводе
    let value = parseInt(event.target.value);
    if (isNaN(value)) value = 1;
    if (value < 1) value = 1;
    if (value > 10) value = 10;
    film.estimate = value;

    // Отправка данных на сервер
    axios.patch(`/favourite/film/${film.id}/estimate`, { estimate: film.estimate })
        .then(response => {
            console.log(response.data.message);
        })
        .catch(error => {
            console.error(error);
        });
}
const selectedFilm = ref(null);
const showModal = ref(false);
const openModal = (film) => {
    selectedFilm.value = film;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedFilm.value = null;
};

const mar = ref(false)

</script>

<template>


    <div class="">


        <ul class="max-w-md d " v-for="(film,key) in films">
            <li class="pb-3 sm:pb-4">
                <div class="flex items-center space-x-10  rtl:space-x-reverse">
                    <div class="flex overflow-auto">
                        <img class="w-8 h-8 rounded-full" :src="film.url" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p
                            @click="detail(key), check=!check"
                            class="text-sm font-medium text-gray-900 truncate dark:text-white hover:underline hover:text-pink-500 hover:cursor-pointer"
                        >
                            {{ film.title }} /
                            <span class="text-sm text-gray-800">

                                 {{ film.year }}

                            </span>
                        </p>

                        <div
                            v-if="detailId === key && check"
                            class="absolute z-10 flex space-x-4 p-4 w-96 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm"
                        >
                            <div class="flex-none">
                                <img class="w-16 h-16" :src="film.url" alt="Film image"/>
                            </div>
                            <div class="flex-1">
                                <ul class="list-disc list-inside">
                                    <li v-for="genre in film.genres">{{ genre.name }}</li>
                                </ul>
                                <div class="mt-2">
                                    {{ film.description }}
                                </div>

                            </div>
                        </div>
                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                            {{ film.type }}
                        </p>
                    </div>

                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">

                        <form class="max-w-xs mx-auto">
                            <label for="counter-input" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Оценка:</label>
                            <div class="relative flex items-center">
                                <button @click="estimate(-1,film)" type="button" id="decrement-button" data-input-counter-decrement="counter-input" class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                    <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                    </svg>
                                </button>
                                <input type="text" id="counter-input" data-input-counter class="flex-shrink-0 text-gray-900 dark:text-white border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center" placeholder="" :value="film.estimate" required   @input="updateEstimate($event, film)"
                                       min="1"
                                       max="10" />
                                <button  @click="estimate(1,film)" type="button" id="increment-button" data-input-counter-increment="counter-input" class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                    <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                    </svg>
                                </button>
                            </div>
                        </form>

                    </div>
                    <div>
                        <svg @click="deleteMyFilm(film.id)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 fill-red-400 cursor-pointer">
                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                        </svg>

                    </div>
                </div>
            </li>


        </ul>


    </div>


    <!--    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">-->
    <!--        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" >-->
    <!--            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400" >-->
    <!--            <tr >-->
    <!--                <th scope="col" class="px-6 py-3">-->
    <!--                    Название-->
    <!--                </th>-->
    <!--                <th scope="col" class="px-6 py-3">-->
    <!--                    Год-->
    <!--                </th>-->
    <!--                <th scope="col" class="px-6 py-3">-->
    <!--                    Тип-->
    <!--                </th>-->
    <!--                <th scope="col" class="px-6 py-3">-->
    <!--                    Подробнее-->
    <!--                </th>-->
    <!--                <th scope="col" class="px-6 py-3">-->
    <!--                    Моя оценка-->
    <!--                </th>-->

    <!--            </tr>-->
    <!--            </thead>-->
    <!--            <tbody v-for="(film,key) in films">-->
    <!--            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">-->
    <!--                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">-->
    <!--                    {{film.title}}-->
    <!--                </th>-->
    <!--                <td class="px-6 py-4">-->
    <!--                    {{film.year}}-->
    <!--                </td>-->
    <!--                <td class="px-6 py-4">-->
    <!--                    {{film.video_content.title}}-->
    <!--                </td>-->
    <!--                <td class="px-6 py-4">-->
    <!--                    <a @click="detail(key) ; check=!check" href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Подробнее</a>-->
    <!--                </td>-->
    <!--                <td class="px-6 py-4">-->

    <!--                </td>-->
    <!--                <td @click="deleteMyFilm(film.id) "class="px-6 py-4 text-red-500 cursor-pointer">-->
    <!--                    Удалить-->
    <!--                </td>-->
    <!--            </tr>-->

    <!--&lt;!&ndash;            <tr v-if=" check && detailId===key"  class="border-gray-300 border-b-2 border-t-2 ">&ndash;&gt;-->
    <!--&lt;!&ndash;                <td  class="px-6 py-10 font-medium text-gray-900 whitespace-nowrap dark:text-white" >&ndash;&gt;-->
    <!--&lt;!&ndash;                   <img  :src="film.url" alt="Фильм 2"&ndash;&gt;-->
    <!--&lt;!&ndash;                    class="w-24 h-32 mr-4 rounded-md  transform hover:scale-150">&ndash;&gt;-->
    <!--&lt;!&ndash;                </td>&ndash;&gt;-->
    <!--&lt;!&ndash;                <td class="px-6 py-4 text-black" >&ndash;&gt;-->
    <!--&lt;!&ndash;                    {{film.description}}&ndash;&gt;-->
    <!--&lt;!&ndash;                </td>&ndash;&gt;-->
    <!--&lt;!&ndash;                <td class="px-6 py-4 text-black"  >&ndash;&gt;-->
    <!--&lt;!&ndash;                    <ul v-for="genre in film.genres">&ndash;&gt;-->
    <!--&lt;!&ndash;                        <li>&ndash;&gt;-->
    <!--&lt;!&ndash;                            {{genre.name}}&ndash;&gt;-->
    <!--&lt;!&ndash;                        </li>&ndash;&gt;-->
    <!--&lt;!&ndash;                    </ul>&ndash;&gt;-->

    <!--&lt;!&ndash;                </td>&ndash;&gt;-->

    <!--&lt;!&ndash;                <td class="px-6 py-4">&ndash;&gt;-->
    <!--&lt;!&ndash;                    Laptop&ndash;&gt;-->
    <!--&lt;!&ndash;                </td>&ndash;&gt;-->
    <!--&lt;!&ndash;            </tr>&ndash;&gt;-->
    <!--                    <div v-if=" check && detailId===key" >-->
    <!--                        <div @mouseover="openModal(film)" @mouseleave="closeModal" class="cursor-pointer">-->
    <!--                            {{ film.title }}-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--            <FilmModal v-if="selectedFilm" :show="showModal" :film="selectedFilm" @close="closeModal" />-->
    <!--            </tbody>-->
    <!--        </table>-->
    <!--    </div>-->

</template>

<style scoped>

</style>
