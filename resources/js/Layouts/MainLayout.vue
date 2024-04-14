<script >
import {Link, router} from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

export default {
    components: {ApplicationLogo, Link},


    data() {
        return {

            count: 0,


        }
    },
    methods:{

    }

}
</script>

<template>

<div>


    <div class="flex">

        <div class="w-1/4 min-h-screen bg-sky-500">

        </div>

        <div class="w-3/4 bg-gray-100 ">

            <slot></slot>
        </div>


    </div>

</div>


</template>

<style scoped>

</style>
