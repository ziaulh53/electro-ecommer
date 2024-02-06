<template>
    <div class="text-center text-2xl mb-10">Explore More</div>
    <ECarousel :items="products" :autoplay="false"/>
</template>

<script setup>
import { ref, onMounted, toRefs } from 'vue';
import { useRoute } from 'vue-router';
import { api, productEndpoint } from '../../../api';
import { ECarousel } from '../shared';

const props = defineProps({
    categoryId: String
})

const { categoryId } = toRefs(props);

const route = useRoute();

const loading = ref(false)
const products = ref([])

const getSuggestionProducts = async () => {

    try {
        loading.value = true
        const res = await api.get(productEndpoint.fetchSuggestionProducts, { categoryId: categoryId.value, productId: route.params.id });
        products.value = res?.result;
        loading.value = false
    } catch (error) {
        console.log(error)
    }

}

onMounted(() => {
    getSuggestionProducts()
})
</script>