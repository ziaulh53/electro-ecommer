<template>
    <Layout>
        <div class="my-10">

            <div v-if="cartStore.shoppingCart.length">
                <div class="border-gray-300 p-5 rounded-lg bg-white">
                    <CartContainer />
                </div>
                <div class="text-right mt-10">
                    <router-link :to="isAuthenticated ? '/checkout' : '/signin'">
                        <span class="btn-class cursor-pointer">Checkout</span>
                    </router-link>
                </div>
            </div>
            <div v-else class="flex justify-center">
                You have no cart items
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { Layout } from '../components/Layout';
import { useAuthStore, useCartStore } from '../../store';
import { CartContainer } from '../components/ShoppingCart';
const cartStore = useCartStore();
const { isAuthenticated } = useAuthStore().user;

</script>