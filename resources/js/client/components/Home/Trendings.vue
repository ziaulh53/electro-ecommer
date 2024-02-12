<template>
    <router-link :to="'/product/' + data?.id">
        <div class="border-2 rounded-lg bg-gray-200 relative">
            <img :src="JSON.parse(data?.colors[0]?.pivot?.images)[0] || '/assets/poster.jpg'"
                class="h-[200px] w-full object-cover rounded-t-md" />
            <div class="p-4">
                <h6 class="text-base font-bold">{{ data?.name }}</h6>
                <div class="">
                    <p class="font-semibold">Price: ${{ data?.discountAvailable ? data?.discountPrice : data?.price }}
                        <span v-if="data?.discountAvailable" class="text-gray-500 font-semibold">
                            <s>${{ data?.price }}</s>
                        </span>
                    </p>
                </div>
            </div>
            <div v-if="data?.discountAvailable"
                    class="absolute top-2 right-2 text-sm bg-red-500 text-white font-semibold px-2 py-1">
                    Discount
                </div>
            <div v-if="checkAvailability(data?.colors)"
                class="absolute top-2 left-2 text-sm bg-gray-800 rounded-md text-white font-semibold px-2 py-1">
                IN STOCK
            </div>
            <div v-else class="absolute top-2 left-2 text-sm bg-red-600 rounded-md text-white font-semibold px-2 py-1">
                SOLD OUT
            </div>
            <div v-if="data?.newArrival" class="absolute top-1/2 -right-3">
                <img class="w-[68px]" :src="'/assets/tag3.png'" />
            </div>
        </div>
    </router-link>
</template>

<script setup>
defineProps({
    data: Object
})

const checkAvailability = (colors = []) => {
    return Math.max(...colors?.map(item => item?.pivot?.quantity)) > 1 ? true : false
}
</script>