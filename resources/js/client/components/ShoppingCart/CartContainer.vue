<template>
    <div class="p-10 border-b-2">
        <div class="flex justify-between border-b pb-8">
            <h1 class="font-semibold text-2xl">Shopping Cart</h1>
            <h2 class="font-semibold text-2xl">{{ allCart.shoppingCart?.length }} Item(s)</h2>
        </div>
        <div class="flex mt-10 mb-5">
            <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Product Details</h3>
            <h3 class="font-semibold text-gray-600 text-xs uppercase w-1/5 text-center">Price</h3>
            <h3 class="font-semibold text-gray-600 text-xs uppercase w-1/5 text-center">Quantity</h3>
            <h3 class="font-semibold text-gray-600 text-xs uppercase w-1/5 text-center">Total</h3>
        </div>
        <div v-for="(cart, idx) of allCart.shoppingCart" :key="idx"
            class="flex items-center relative hover:bg-gray-100 -mx-8 px-6 py-5">
            <SingleCart :cart="cart" />
        </div>
    </div>
    <div class="flex justify-between">
        <router-link to="/" class="font-semibold text-theme-light text-sm mt-10">
            <svg class="fill-current inline mr-2 text-indigo-600 w-4" viewBox="0 0 448 512">
                <path
                    d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
            </svg>
            Continue Shopping
        </router-link>
        <div class="w-1/4 px-8">
            <div class="flex justify-between mt-10 mb-5">
                <span class="font-semibold text-sm uppercase">Subtotal</span>
                <span class="font-semibold text-sm">USD {{ subtotal }}</span>
            </div>
            <div class="flex justify-between mt-10 mb-5">
                <span class="font-semibold text-sm uppercase">Shipping</span>
                <span class="font-semibold text-sm">USD 80</span>
            </div>
            <div class="border-t mt-8">
                <div class="flex font-semibold justify-between py-6 text-sm uppercase">
                    <span>Total cost</span>
                    <span>USD {{ subtotal+80 }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script setup>
import { computed } from 'vue';
import { useCartStore } from '../../../store';
import SingleCart from './SingleCart.vue';


const allCart = useCartStore();

const subtotal = computed(() => getSubTotalPrice(allCart));

const getSubTotalPrice = () => {
    let total = 0;
    allCart.cart?.forEach(element => {
        total += (element?.discountAvailable ? element?.discountPrice : element?.price) * element?.quantity
    })
    return total;
}

</script>

  