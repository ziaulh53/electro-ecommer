<template>
    <div class="flex w-2/5">
        <div class="w-20">
            <img class="h-24" :src="cart?.colors?.images[0]" alt="">
        </div>
        <div class="ml-4">
            <div class="font-bold text-sm mb-5">{{ cart?.name }}</div>
            <div class="text-red-500 text-xs">Color: {{ cart?.colors?.color?.colorName }}</div>
            <!-- <a href="#" class="font-semibold hover:text-red-500 text-gray-500 text-xs">Remove</a> -->
        </div>
    </div>
    <div class="text-center w-1/5 font-semibold text-sm"><span :class="cart?.discountAvailable ? 'text-red-600' : ''">USD {{
        cart?.discountAvailable ? cart?.discountPrice :
        cart?.price }}</span>
        <span v-if="cart?.discountAvailable" class="text-gray-500">
            <s> USD {{ cart?.price }}</s>
        </span>
    </div>
    <div class="flex justify-center w-1/5">
        <button @click="() => cartQuantityDecrease(cart)"><span class="text-gray-600"><i
                    class="fas fa-minus"></i></span></button>

        <input class="mx-2 border text-center w-8" type="text" :value="cart?.quantity">

        <button @click="() => cartQuantityIncrease(cart)"><span class="text-gray-600"><i
                    class="fas fa-plus"></i></span></button>
    </div>

    <div class="text-center w-1/5 font-semibold text-sm">USD {{ (cart?.discountAvailable ? cart?.discountPrice : cart?.price)
        * cart?.quantity }}</div>
    <button @click="() => singleCartItemDelete(cart)" class="absolute text-red-600 right-10">
        <i class="fa-solid fa-xmark"></i>
    </button>
</template>

<script setup>
import { useCartStore } from '../../store';

defineProps({
    cart: Object
})

const { singleCartItemDelete, cartQuantityIncrease, cartQuantityDecrease } = useCartStore();


</script>