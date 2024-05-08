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


    const confirmingUserDeletion = ref(false);

    const closeModal = () => {
        confirmingUserDeletion.value = false;

        form.reset();
    };
    const confirmUserDeletion = () => {
        confirmingUserDeletion.value = true;
    };

    const form = useForm({
        title: '',
    });

    const searchFilm = () => {

        axios({
            method: 'get',
            url: '/films',
            params:form.data()

        })
            .then(function (response) {
                console.log(response)
            });

    };
    function Myfilms(){
        axios.get('/favourite/films').then(c=>{

        })
    }
    Myfilms()


</script>

<template>
    <form class="max-w-fit">
    <div class="relative z-0 w-full mb-5 group">
        <input @focus="confirmUserDeletion" type="text" name="title" id="floating_last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
        <label for="title" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
    </div>
        <button> Найти</button>
        <Modal :show="confirmingUserDeletion" @close="closeModal" maxWidth="sm">

            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Введите название фильма
                </h2>
                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="sr-only" />
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
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
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
<!--            <div class="border-gray-300 border-2 mx-2 my-2 mb-2 mr-2 rounded-lg ">-->
<!--                <div class="flex justify-center  ">-->
<!--                    <img   class=" w-full h-24    basis-1/4 "  src="https://i09.fotocdn.net/s128/3992fd8af6924e00/public_pin_l/2898172285.jpg">-->
<!--                    <div class=" basis-2/4  text-center text-lg  font-semibold mx-auto my-auto"> Человек паук</div>-->
<!--                    <div  class=" basis-1/4 mx-auto my-auto"> ryjgrf</div>-->
<!--                </div>-->

<!--            </div>-->

            <div class="border-gray-300 border-2 mx-2 my-2 mb-2 mr-2 rounded-lg ">
            <div class="flex items-center ">
                <!-- Картинка фильма -->
                <img src="https://i09.fotocdn.net/s128/3992fd8af6924e00/public_pin_l/2898172285.jpg" alt="Фильм 2" class="w-20 h-20 mr-4 rounded-md">

                <!-- Название фильма -->
                <h3 class="text-lg font-semibold flex-1">Название фильма 2</h3>

                <!-- Кнопка "Добавить" -->
                <button class="px-4 py-2 bg-blue-500 text-white rounded-md">Добавить</button>
            </div>
            </div>
        </Modal>

    </form>
</template>

<style scoped>

</style>
