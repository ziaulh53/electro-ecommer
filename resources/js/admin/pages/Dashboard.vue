<template>
    <Layout>
        <PageTitle title="Dashboard" />
        <div class="grid grid-cols-2 gap-5">
            <a-spin :spinning="sellingLoading">
                <div class="flex justify-center items-center">
                    <span class="mr-2 font-bold text-base">Filter:</span>
                    <a-select class="min-w-[300px]" size="large" :value="selectType" :options="options"
                        @change="onSelectType">
                    </a-select>
                </div>
                <LineChart v-if="data?.result?.labels" title="Last 7 days selling result" :data="data.result"
                    :type="selectType" />
            </a-spin>
            <PieChart title="Category based" type="6months" />
        </div>
    </Layout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { LineChart, PieChart } from '../components/Dashboard';
import { Layout } from '../components/Layout';
import { PageTitle } from '../components/shared';
import { api, dashboardEndpointAdmin } from '../../api';

const data = ref({});
const selectType = ref('day');
const sellingLoading = ref(false)
const options = [{ value: 'day', label: "Last 7 days" }, { value: 'month', label: 'Last 6 months' }]

const fetchSellingStatistics = async () => {
    sellingLoading.value = true
    try {
        data.value = await api.get(dashboardEndpointAdmin.getDashboardData, { type: selectType.value })
    } catch (error) {
        console.log(error)
    }
    sellingLoading.value = false
}


const onSelectType = (value) => {
    selectType.value = value;
    fetchSellingStatistics();
}

onMounted(() => {
    fetchSellingStatistics();
})
</script>