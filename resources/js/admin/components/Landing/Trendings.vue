<template>
    <a-card bordered class="bg-slate-100">
        <div class="font-semibold text-lg mb-2">Trendings Product</div>
        <AddProdTrending :data="trendings || []" :refetch="refetch" />
        <div class="grid grid-cols-4 gap-5 mb-5">
            <a-card hoverable v-for="product of trendings">
                <template #cover>
                    <img alt="example" class="h-[200px] object-cover" :src="product?.colors[0]?.images[0] || '/assets/logo.png'" />
                </template>
                <a-card-meta :title="product?.name" description="This is the description">
                </a-card-meta>
            </a-card>
        </div>
    </a-card>
</template>

<script setup>
import { toRefs } from 'vue';
import AddProdTrending from './AddProdTrending.vue';

const props = defineProps({
    refetch: Function,
    trendings: Array
})

const { trendings, refetch } = toRefs(props)

</script>