<script>


import {router} from "@inertiajs/vue3";

export default {

    data() {
        return {
            data: {
                description: null,
                price: null,
                imagesR: null,
                errors:
                    {
                        description: null,
                        price: null
                    }
            }
        }
    },
    props:
        [
            'products',
        ],
    mounted() {
        console.log(this.products)
    },
    methods:
        {

            storeProduct() {

                console.log(this.imagesR )
                axios.postForm('/admin/products', {
                    product: {
                        description: this.data.description,
                        price: this.data.price,
                    },
                    images:  this.imagesR// FileList will be unwrapped as sepate fields
                }).then(()=> {
                    router.visit('/admin/products', {method: 'get'})

                }).catch((e => {
                    console.log(e.response.data.errors)
                    if (e.response) {
                        this.data.errors.description = e.response.data.errors['product.description']
                        this.data.errors.price = e.response.data.errors['product.price']
                    }
                }));

            },
            storeImage(e) {
                this.imagesR = Object.values(e.target.files)


            }
        }

}
</script>

<template>
    <div>

        <div class="flex">
            <div class="w-1/4 min-h-screen bg-sky-500">
            </div>
            <div class="w-3/4 bg-gray-100 ">
                <div class="flex justify-between mt-10 mb-6 ">
                    <h1 class="ml-5"> Добавить продукт</h1>

                    <a :href="route('products.index')"
                       class="  bg-gray-400 bg- inline-block text-white text-sm rounded-full ">
                        Назад
                    </a>
                </div>

                <div class="ml-4 ">
                    <div class="mb-4">
                        <input class="rounded-full" placeholder="Название" v-model="data.description">
                        <p v-for="desc in data.errors.description " class="text-red-600">{{ desc }}</p>
                    </div>
                    <div class="mb-4">
                        <input class="rounded-full" placeholder="цена" v-model="data.price">
                        <p v-for="price in data.errors.price" class="text-red-600" v-if="data.errors.price">
                            {{ price }}</p>
                    </div>
                    <div class="mb-4">
                        <input class="rounded-full" type="file" name="image" @change="storeImage" multiple>
                    </div>

                    <a @click="storeProduct" class="  bg-green-800 bg- inline-block text-white text-sm rounded-full ">
                        Добавить
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div>

    </div>
</template>

<style scoped>

</style>
