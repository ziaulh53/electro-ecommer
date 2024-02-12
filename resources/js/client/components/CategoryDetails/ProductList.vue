<template>
    <div class="flex justify-between items-center mb-5">
        <h2 class="font-bold text-2xl">{{ data?.name }}</h2>
        <span class="md:hidden"><i class="fa-solid fa-filter text-theme-light"></i></span>
    </div>
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        <router-link v-for="(product,idx) of data?.products" :to="'/product/' + product?.id" :key="product?.id">
            <div
                class="relative border border-gray-400 rounded-lg bg-white shadow-lg overflow-visible group hover:scale-105 transition-all duration-300">
                <img :src="JSON.parse(product?.colors[0]?.pivot?.images)[0] || '/assets/poster.jpg'"
                    class="h-[200px] w-[200px] m-auto object-cover rounded-t-md" />
                <div class="p-4 border-t-2 bg-gray-100">
                    <h6 class="text-base font-bold">{{ product?.name }}</h6>
                    <div>
                        <p class="font-semibold">Price: <span
                                :class="product?.discountAvailable ? 'text-red-600 font-bold' : 'font-bold'">USD {{
                                    product?.discountAvailable ? product?.discountPrice :
                                    product?.price }}</span>
                            <span v-if="product?.discountAvailable" class="text-gray-500 font-bold">
                                <s> USD {{ product?.price }}</s>
                            </span>
                        </p>
                    </div>
                </div>
                <div
                    class="absolute inset-0 bg-black bg-opacity-50 opacity-0 transform scale-0 transition-all duration-300 group-hover:opacity-100 group-hover:scale-100 group-hover:transition-all group-hover:duration-300 flex items-center justify-center">
                    <button class="bg-theme-color text-gray-300 py-2 px-4 rounded-md font-bold">View Details</button>
                </div>
                <div v-if="product?.discountAvailable"
                    class="absolute top-2 right-2 text-sm bg-red-500 text-white font-semibold px-2 py-1">
                    Discount
                </div>
                <div v-if="checkAvailability(product?.colors)"
                    class="absolute top-2 left-2 text-sm bg-gray-800 rounded-md text-white font-semibold px-2 py-1">
                    IN STOCK
                </div>
                <div v-else class="absolute top-2 left-2 text-sm bg-red-600 rounded-md text-white font-semibold px-2 py-1">
                    SOLD OUT
                </div>
                <div v-if="product?.newArrival" class="absolute top-1/2 -right-3">
                    <img class="w-[68px]" :src="'/assets/tag3.png'" />
                </div>
            </div>
        </router-link>
    </div>
</template>
<script setup>
defineProps({
    data: Object
})

const checkAvailability = (colors = []) => {
    return Math.max(...colors?.map(item => item.pivot?.quantity)) > 1 ? true : false
}

</script>