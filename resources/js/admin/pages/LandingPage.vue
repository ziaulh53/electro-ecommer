<template>
    <Layout>
        <PageTitle title="Landing page" />
        <Banners v-if="!loading" :banners="banners" :refetch="getBanners"/>
        <Trendings />
    </Layout>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { Banners, Trendings } from '../components/Landing';
import { Layout } from '../components/Layout';
import { PageTitle } from '../components/shared';
import { api } from '../../api';

const banners = ref('');
const loading = ref(false);

const getBanners = async()=>{
    loading.value = true
    try {
        const res = await api.get('admin/banner');
        banners.value = res.banners;
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}

onMounted(()=>{
    getBanners();
})


</script>