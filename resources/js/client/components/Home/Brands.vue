<template>
    <div v-if="loading" class="col-span-1">
        <EShopSkeleton height="400px" />
    </div>
    <div v-if="!loading" class="col-span-1 border rounded-lg bg-zinc-900 text-white">
        <div class="p-5 ">
            <div class="text-center text-lg text-gray-300 font-bold">Available Brands</div>
            <div class="flex flex-wrap gap-y-10 gap-x-5 mt-5">
                <div v-for="brand of allBrands" :key="brand?._id" class="rounded-3xl">
                    <router-link :to="'/brands/' + brand?._id">
                        <img :src="brand?.logo" class="w-[60px] h-[60px] rounded-3xl object-cover" />
                        <div class="text-center text-xs font-bold text-gray-300 mt-3"> {{ brand?.name }}</div>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { api, landingEndpoint } from '../../../api';
import { EShopSkeleton } from '../shared';

const allBrands = ref({});
const loading = ref(false);

const getAllBrands = async () => {
    loading.value = true
    try {
        const res = await api.get(landingEndpoint.getAllbrands)
        allBrands.value = res?.result
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}
onMounted(() => {
    getAllBrands();
})
</script>