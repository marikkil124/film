<script setup>
    import Modal from "@/Components/Modal.vue";
    import {nextTick, ref} from "vue";
    import TextInput from "@/Components/TextInput.vue";
    import InputLabel from "@/Components/InputLabel.vue";
    import InputError from "@/Components/InputError.vue";
    import DangerButton from "@/Components/DangerButton.vue";
    import SecondaryButton from "@/Components/SecondaryButton.vue";
    import {router, useForm} from "@inertiajs/vue3";

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
        router.visit('/films',{method: 'get',data: form.data(),onFinish: visit => {
                console.log(visit)
            }, onError: errors => {
                console.log(errors)},})
    };
    function Myfilms(){
        axios.get('/favourite/films').then(c=>{
            console.log(c);
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
        <Modal :show="confirmingUserDeletion" @close="closeModal">
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
        </Modal>

    </form>
</template>

<style scoped>

</style>
