<template>
    <div class="mb-3">
        <h1 class="text-3xl font-semibold">{{ data?.name }}</h1>
    </div>
    <div class="mb-5">
        <p class="font-semibold">Price: <span
                :class="data?.discountAvailable ? 'text-red-600 font-bold' : 'font-bold'">USD {{
                    data?.discountAvailable ? data?.discountPrice :
                    data?.price }}</span>
            <span v-if="data?.discountAvailable" class="text-gray-500 font-bold">
                <s> USD {{ data?.price }}</s>
            </span>
        </p>
    </div>
    <div class="flex">
        <div class="mr-20">
            <p class="text-gray-500 font-semibold">Category: <span class="text-blue-500"><router-link
                        :to="'/category/' + data?.category?.id">{{
                            data?.category?.name }}</router-link></span>
            </p>
        </div>
        <div class="mr-20">
            <p class="text-gray-500 font-semibold">Brand: <span class="text-blue-500"><router-link
                        :to="'/brands/' + data?.brand?.id">{{
                            data?.brand?.name }}</router-link></span></p>
        </div>
    </div>
    <div v-if="data?.is_variation" class="my-5">
        <span class="text-orange-500"><i class="fa-solid fa-palette"></i></span> Colors:
        <div class="flex mt-2">
            <div v-for="({ colorCode, id }, idx) of data?.colors" :key="id" @click="() => handleSelectColor(idx)"
                :class="(selectedColors?.id === id ? 'border-2 border-black' : 'border border-gray-400') + ' w-[20px] h-[18px] rounded-full mr-2 cursor-pointer'"
                :style="{ background: colorCode }"></div>
        </div>
    </div>
</template>

<script setup>

defineProps({
    data: Object,
    handleSelectColor: Function,
    selectedColors: Object
})
</script>