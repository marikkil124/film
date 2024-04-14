<script>


import {Link} from "@inertiajs/vue3";

export default {
    components: {Link},


    data() {
        return {
            countTotal: this.count,
        }
    },


    props: ['count'],

}
</script>

<template>

    <div class="  absolute top-0 right-0    w-36 h-32 bg-white rounded-lg  ">
        <h1> Корзина</h1>
        Количество {{ count }}
        <div>
            <Link
                :href="route('cart')"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                В корзину
            </Link>
        </div>


    </div>


</template>

<style scoped>

</style>
