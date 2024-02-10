<template>
    <div class="border bg-white p-5 rounded-md mb-10">
        <div class="flex justify-between mb-5">
            <h2 class="font-semibold text-xl text-theme-color">
                Categories
            </h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
            <router-link v-for="category of allCategories" :to="'/category/' + category?.id" :key="category?.id">
                <div class="border-2 rounded-lg bg-gray-200">
                    <img :src="category?.coverImage || '/assets/poster.jpg'"
                        class="h-[200px] w-full object-cover rounded-t-md" />
                    <div class="p-4">
                        <h6 class="text-base font-bold">{{ category?.name }}</h6>
                    </div>
                </div>
            </router-link>

        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useCategoryStore } from '../../../store';

const categoryStore = useCategoryStore();
const allCategories = computed(()=>categoryStore.category)


</script>