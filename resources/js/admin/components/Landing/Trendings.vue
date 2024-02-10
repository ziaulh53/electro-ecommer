<template>
    <a-card bordered class="bg-slate-100">
        <div class="font-semibold text-lg mb-2">Trendings Product</div>
        <AddProdTrending :data="trendings || []" :refetch="getTrendings" />
        <div class="grid grid-cols-4 gap-5 mb-5">
            <a-card hoverable v-for="({product}) of trendings">
                <template #cover>
                    <img alt="example" class="h-[200px] object-cover" :src="JSON.parse(product?.colors[0]?.pivot?.images)[0] || '/assets/logo.png'" />
                </template>
                <a-card-meta :title="product?.name" description="This is the description">
                </a-card-meta>
            </a-card>
        </div>
    </a-card>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import AddProdTrending from './AddProdTrending.vue';
import { api } from '../../../api';

const trendings = ref('');
const loading = ref(false);

const getTrendings = async()=>{
    loading.value = true
    try {
        const res = await api.get('admin/trending');
        trendings.value = res.trendings;
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}

onMounted(()=>{
    getTrendings();
})

</script>