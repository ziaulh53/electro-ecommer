<template>
    <header class="bg-theme-color h-[60px] w-full">
        <div class="h-full px-5 lg:px-20 flex items-center justify-between">
            <router-link to="/"><img :src="'/assets/logo.png'" class="w-[40px]" /></router-link>
            <div class="flex">
                <router-link v-for="category of allCategories" :key="category._id" :to="'/category/' + category._id"
                    class="px-4 py-2  ml-2 text-gray-200 font-[100] hover:bg-slate-600">
                    <span>{{ category?.name }}</span>
                </router-link>
            </div>
            <div>
                <!-- <Dropdown :category="allCategories" /> -->
                <router-link to="/shopping-cart" class="px-4 py-2  mx-2 text-white font-semibold hover:bg-slate-600">
                    <a-badge :count="cartStore.shoppingCart.length">
                        <i class="fa-solid fa-cart-shopping mr-1 text-white text-xl"></i>
                    </a-badge>
                </router-link>
                <UserDropdown v-if="isAuthenticated" />
                <router-link to="/signin" class="px-4 py-2  ml-2 text-white font-semibold hover:bg-slate-600"
                    v-if="!isAuthenticated">
                    <i class="fa-regular fa-user mr-1"></i> <span>Login</span>
                </router-link>
            </div>
        </div>
    </header>
   
</template>

<script setup>
import { onMounted, computed } from 'vue';
import UserDropdown from './Navbar/UserDropown.vue'
import { useAuthStore, useCartStore, useCategoryStore } from '../../../store';

const { isAuthenticated } = useAuthStore().auth;
const categoryStore = useCategoryStore();
const cartStore = useCartStore();

const allCategories = computed(() => categoryStore?.category)

onMounted(() => {
    categoryStore?.fetchCateogries();
})
</script>