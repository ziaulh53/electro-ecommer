<template>
    <Layout>
        <PageTitle title="All orders" />
        <div class="mb-5">
            <OrderFilters :filter-submit="handleSubmitFilter" />
        </div>
        <OrderTable :filter-submit="fetchOrders" :all-orders="allOrders?.orders" :loading="loading" />
        <div class="text-right mt-5">
            <a-pagination :total="totalCount" :limit="1" :current="current" :page-size="15" @change="handleFilter" />
        </div>
    </Layout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Layout } from '../components/Layout';
import { api, orderEndpoint } from '../../api';
import { PageTitle } from '../components/shared';
import { OrderFilters, OrderTable } from '../components/Orders'
const allOrders = ref({});
const loading = ref(false);
const filters = ref({
    startDate: '',
    endDate: '',
    orderId: '',
    status: '',
    email: '',
    phone: ''
})

const current = ref(1)

const totalCount = ref(2);

const fetchOrders = async () => {
    loading.value = true
    try {
        allOrders.value = await api.get('admin/order', { ...filters.value, page: current.value });
        totalCount.value = allOrders.value?.result?.count
    } catch (error) {
        console.log(error)
    }
    loading.value = false;
}

onMounted(() => {
    fetchOrders();
})

const handleSubmitFilter = (filter) => {
    filters.value = {
        ...filter
    }
    console.log(filter)
    fetchOrders();
}
const handleFilter = (page) => {
    current.value = page;
    fetchOrders()
}

</script>