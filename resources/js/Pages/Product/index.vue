<script>
import {router} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import Product from "@/Pages/Product/product.vue";
import cartTotal from "@/Pages/Product/cart/cartTotal.vue";


export default {
    components: {Product, MainLayout, cartTotal},

    data() {
        return {
            productData: this.products,
            UpdateVisible: false,
            UpdateID: null,
            filter: {
                price: null,
                description: null,
            },
            cart: {
                count: 0,
                total: 0
            }
        }
    },
    methods: {
        router() {
            return router
        },

        countCart(count) {
            console.log(count)
            this.cart.count = count;
        },
        totalProduct() {
            axios.get('/references/product-count',
            ).then((res) => {
                console.log(res)
                this.cart.count = res.data.count;
            }).catch(e => {
                console.log(e)
            })
        },

    },


    props:
        [
            'products',
        ],
    mounted() {
        console.log(this.products)
        this.totalProduct()
    }

}
</script>

<template>

    <MainLayout>
        <cartTotal :count="cart.count"></cartTotal>
        <div
            class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
            v-for="product in productData.data">
            <product :product="product" @countC="countCart"></product>
        </div>


    </MainLayout>

</template>

<style scoped>

</style>
