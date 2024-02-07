<template>
    <Layout :loading="loading">
        <div class="mb-2">
            <h2 class="text-2xl font-semibold uppercase">Customers</h2>
            <div class="bg-theme-color h-[2px]"></div>
        </div>
        <div>
            <a-table :dataSource="allusers?.data" :columns="columns"/>
        </div>
    </Layout>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { Layout } from '../components/Layout';
import { api, user } from '../../api';
const allusers = ref('');
const loading = ref('');


onMounted(async () => {
    loading.value= true;
    const res = await api.get(user.getUser);
    allusers.value = res?.users;
    loading.value= false
})

const columns = [
    {
        title: 'Name',
        dataIndex: 'name',
        key: 'name',
        customRender: ({text,record})=>record.firstName+" "+record.lastName
    },
    {
        title: 'Email',
        dataIndex: 'email',
        key: 'email',
    },
  
]



</script>