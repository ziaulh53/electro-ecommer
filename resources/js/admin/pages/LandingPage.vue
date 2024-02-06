<template>
    <Layout>
        <PageTitle title="Landing page" />
        <Banners v-if="!loading" :banners="homeData?.result?.banners" :refetch="getHomePageDetails"/>
        <Trendings v-if="!loading" :trendings="homeData?.result?.trendings" :refetch="getHomePageDetails"/>
    </Layout>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { Banners, Trendings } from '../components/Landing';
import { Layout } from '../components/Layout';
import { PageTitle } from '../components/shared';
import { api, landingAdmin } from '../../api';

const homeData = ref('');
const loading = ref(false);

const getHomePageDetails = async()=>{
    loading.value = true
    try {
        homeData.value = await api.get(landingAdmin.getHomePageData);
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}

onMounted(()=>{
    getHomePageDetails();
})


</script>