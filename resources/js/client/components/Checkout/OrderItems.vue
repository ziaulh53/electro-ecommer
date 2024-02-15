<template>
    <div class="bg-white border-2 border-gray-300 shadow-sm rounded-lg p-3">
        <h6 class="text-lg font-semibold mb-6">Order Items</h6>
        <div class="mb-2 border-b-2 pb-2 border-gray-300" v-for="(cart, idx) of cartItems" :key="idx">
            <div class="flex justify-between">
                <div>
                    <p class="text-gray-600 font-bold">{{ cart?.name }}</p>
                    <p v-if="cart?.is_variation">Color: {{ cart?.colors?.colorName }}</p>
                    <p>Price: USD {{ cart?.discountAvailable? cart?.discountPrice:cart?.price  }} X {{ cart?.quantity }}</p>
                    <p>Quantity: {{ cart?.quantity }}</p>
                </div>
                <img :src="cart?.images[0]||'/assets/logo.png'" class="w-[100px] h-[100px]" />
            </div>
        </div>
        <div class="mt-5">
            <div class="flex justify-between items-center">
                <div class="font-bold text-lg">Total Price:</div>
                <div class="w-[62%] h-[1px] bg-gray-600"></div>
                <div class="font-bold text-gray-00">USD {{ totalPrice+80 }}</div>
            </div>

        </div>
    </div>
</template>

<script setup>
defineProps({
    cartItems: Array,
    totalPrice: Number
})

</script>