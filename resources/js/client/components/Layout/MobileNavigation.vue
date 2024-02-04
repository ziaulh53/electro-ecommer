<template>
    <div class="flex justify-between">
        <router-link to="/">
            <div class="flex flex-col items-center">
                <img :src="'/assets/home.png'" class="w-[25px]" />
                <!-- <div class="text-sm text-center">Home</div> -->
            </div>
        </router-link>
        <button @click="openDrawer">
            <div class="flex flex-col items-center">
                <img :src="'/assets/categories.png'" class="w-[25px]" />
                <!-- <div class="text-sm text-center">Categories</div> -->
            </div>
        </button>
        <router-link to="/shopping-cart">
            <div class="flex flex-col items-center">
                <a-badge :count="cartStore.shoppingCart.length">
                    <img :src="'/assets/shopping-bag.png'" class="w-[25px]" />
                </a-badge>
                <!-- <div class="text-sm text-center">Cart</div> -->
            </div>
        </router-link>
        <router-link :to="isAuthenticated ? '/account':'/signin'">
            <div class="flex flex-col items-center">
                <img :src="'/assets/user.png'" class="w-[25px]" />
                <!-- <div class="text-sm text-center">Login</div> -->
            </div>
        </router-link>
    </div>
    <a-drawer height="300px" placement="bottom" :open="open" @close="onClose" :style="{ borderRadius: '15px' }">
        <div class="flex">
            <router-link v-for="category of allCategories" :key="category._id" :to="'/category/' + category._id"
                class="px-4 py-2  ml-2 text-black font-[100] hover:bg-slate-600" @click="onClose">
                <span>{{ category?.name }}</span>
            </router-link>
        </div>
    </a-drawer>
</template>

<script setup>
import { ref } from 'vue';
import { onMounted, computed } from 'vue';
import { useAuthStore, useCartStore, useCategoryStore } from '../../store';


const open = ref(false);

const openDrawer = () => {
    open.value = !open.value;
}
const onClose = () => {
    open.value = false;
};

const { isAuthenticated } = useAuthStore().auth;
const categoryStore = useCategoryStore();
const cartStore = useCartStore();

const allCategories = computed(() => categoryStore.category)

onMounted(() => {
    categoryStore?.fetchCateogries();
})

</script>