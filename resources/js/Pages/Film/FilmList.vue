<script setup>
import {onMounted, ref, watch} from "vue";
import {log10} from "chart.js/helpers";
import FilmModal from "@/Components/FilmModal.vue";

const films=ref({})
const detailId=ref()
const check=ref(false)

// Определение пропсов
const props = defineProps({
    film: {
    }
});

watch(
    () => props.film,
    (newValue, oldValue) => {
        if(newValue)
            myFilms()
    }
);

 const myFilms = () => {

  axios.get('favourite/film').then(response=>{
      films.value = response.data.data;
  }).catch(c=>{
      console.log(c)
  });

};

myFilms()

function detail(id) {
    detailId.value = id;
}
     function deleteMyFilm(id)
     {
         let confirmation = confirm('действительно удалить?')
         if (confirmation) {
         axios.delete(`favourite/film/${id}`).then(r=>{
             return films.value.find((item, index, array) => {
                 if (item.id===id)
                     return array.splice(index,1)
             })

         }).catch(c=>{
             console.log(c)})
     }
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
</script>

<template>


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" >
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400" >
            <tr >
                <th scope="col" class="px-6 py-3">
                    Название
                </th>
                <th scope="col" class="px-6 py-3">
                    Год
                </th>
                <th scope="col" class="px-6 py-3">
                    Тип
                </th>
                <th scope="col" class="px-6 py-3">
                    Подробнее
                </th>
                <th scope="col" class="px-6 py-3">
                    Моя оценка
                </th>

            </tr>
            </thead>
            <tbody v-for="(film,key) in films">
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{film.title}}
                </th>
                <td class="px-6 py-4">
                    {{film.year}}
                </td>
                <td class="px-6 py-4">
                    {{film.video_content.title}}
                </td>
                <td class="px-6 py-4">
                    <a @click="detail(key) ; check=!check" href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Подробнее</a>
                </td>
                <td class="px-6 py-4">

                </td>
                <td @click="deleteMyFilm(film.id) "class="px-6 py-4 text-red-500 cursor-pointer">
                    Удалить
                </td>
            </tr>

<!--            <tr v-if=" check && detailId===key"  class="border-gray-300 border-b-2 border-t-2 ">-->
<!--                <td  class="px-6 py-10 font-medium text-gray-900 whitespace-nowrap dark:text-white" >-->
<!--                   <img  :src="film.url" alt="Фильм 2"-->
<!--                    class="w-24 h-32 mr-4 rounded-md  transform hover:scale-150">-->
<!--                </td>-->
<!--                <td class="px-6 py-4 text-black" >-->
<!--                    {{film.description}}-->
<!--                </td>-->
<!--                <td class="px-6 py-4 text-black"  >-->
<!--                    <ul v-for="genre in film.genres">-->
<!--                        <li>-->
<!--                            {{genre.name}}-->
<!--                        </li>-->
<!--                    </ul>-->

<!--                </td>-->

<!--                <td class="px-6 py-4">-->
<!--                    Laptop-->
<!--                </td>-->
<!--            </tr>-->
                    <div v-if=" check && detailId===key" >
                        <div @mouseover="openModal(film)" @mouseleave="closeModal" class="cursor-pointer">
                            {{ film.title }}
                        </div>
                    </div>
            <FilmModal v-if="selectedFilm" :show="showModal" :film="selectedFilm" @close="closeModal" />
            </tbody>
        </table>
    </div>

</template>

<style scoped>

</style>
