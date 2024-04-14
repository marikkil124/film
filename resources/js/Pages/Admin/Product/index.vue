<script>
import {router} from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";

export default {
    layout: MainLayout,

    data() {
        return {
            productData: this.products,
            UpdateVisible: false,
            UpdateID: null,
            filter: {
                price: null,
                description: null,
            }
        }
    },
    methods: {
        router() {
            return router
        },
        showUpdate(id) {
            console.log(id)
            this.UpdateID = id
            this.UpdateVisible = !this.UpdateVisible
        },
        updateProduct(product) {
            axios.patch('/admin/products/' + product.id, product).then(() => {

                this.UpdateVisible = false
            })
        },
        deleteProduct(product) {
            let confirmation = confirm('действительно удалить?')
            if (confirmation) {
                axios.delete('/admin/products/' + product.id).then(() => {
                    return this.productData.data.find((item, index, array) => {
                        if (item.id===product.id)
                           return array.splice(index,1)
                    })
                })
            }
        },
        indexProduct() {
            console.log((this.filter.price))
            axios.get('/admin/products/',
                {params: this.filter}
            ).then((res) => {
                this.productData.data = res.data.data
                this.productData.links = res.data.links

            }).catch(e => {
                console.log(e)
            })
        }
    },


    props:
        [
            'products',
        ],
    mounted() {
        console.log(this.filter)
    },
    computed: {
        filteredList: function () {
            console.log(this.products)
            return this.products.data.filter((item, index, array) => {
                if (this.filter.price)
                    return item.price.includes(this.filter.price)
                else if (this.filter.description)
                    return item.description.includes(this.filter.description)
                else
                    return item
            })

        },


    },


}
</script>

<template>

    <div class="flex">

        <div>
            <input v-model="filter.price" class="rounded-full ml-4 mt-10 " placeholder="price">
        </div>
        <div>
            <input v-model="filter.description" class="rounded-full ml-4 mt-10 " placeholder="описание">
        </div>
        <a class="  w-24 h-5 bg-blue-500   text-center text-white text-sm rounded-full"
           @click="indexProduct()"> filter</a>
        <a class="  w-24 h-5 bg-blue-500   text-center text-white text-sm rounded-full"
           @click="filter.price=null,filter.description=null; indexProduct()"> sbros</a>

    </div>
    <div class=" flex justify-between  mt-5 mb-6 ">

        <h1 class="ml-5"> Продукты</h1>

        <a class="  bg-green-800 bg- inline-block text-white text-sm rounded-full"
           :href="route('products.create')">
            Добавить продукт
        </a>
    </div>


    <div class="relative overflow-x-auto ">

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Название
                </th>
                <th scope="col" class="px-6 py-3">
                    Цена
                </th>
                <th>

                </th>
            </tr>
            </thead>
            <tbody v-for="(product) in productData.data">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                <th scope="row"
                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ product.description }}
                </th>
                <td class="px-6 py-4">
                    {{ product.price }}
                </td>
                <td>
                    <div class="flex ">
                        <a @click="deleteProduct(product)"
                           class=" w-16 h-5 bg-red-800  text-center text-white text-sm rounded-full mr-4">
                            Удалить</a>
                        <a class="  w-24 h-5 bg-blue-500   text-center text-white text-sm rounded-full"
                           @click="showUpdate(product.id)"> Обновить</a>
                    </div>
                </td>

            </tr>

            <tr v-if="product.id === UpdateID && UpdateVisible">
                <td>
                    <input v-model="product.description" class=" rounded-full ">
                </td>
                <td>
                    <input v-model="product.price" class=" rounded-full ">
                </td>
                <td>
                    <a class="  w-24 h-5 bg-green-500   text-center text-white text-sm rounded-full"
                       @click="updateProduct(product)"> Обновить</a>
                </td>
            </tr>

            </tbody>
        </table>
        <span class="ml-2" v-for="link in productData.links">
            <a class="bg-sky-500 text-white" :href="link.url">{{ link.label }} </a>
        </span>

    </div>


</template>

<style scoped>

</style>
