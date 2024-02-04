<template>
  <div class="pie-chart">
    <div class="flex justify-center items-center">
      <span class="mr-2 font-bold text-base">Filter:</span>
      <a-select class="min-w-[300px]" size="large" :value="selectType" :options="options" @change="onSelectType">
      </a-select>
    </div>
    <Doughnut :options="chartOptions" :data="chartData" />
  </div>
</template>
  
<script setup>
import { ref, onMounted } from 'vue';
import { Doughnut } from 'vue-chartjs';
import { Chart as ChartJS, ArcElement, Tooltip, Legend, } from 'chart.js';
import { api, dashboardEndpoint } from '../../api';
ChartJS.register(ArcElement, Tooltip, Legend);

const data = ref({})
const selectType = ref('day');
const categorySellingLoading = ref(false)

const options = [{ value: 'day', label: "Last 7 days" }, { value: 'month', label: 'Last 6 months' }]


const chartData = {
  labels: ['Computer', 'Headphone', 'Mobile'],
  datasets: [{
    data: [8, 12, 18],
    label: "Total order",
    backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16', '#f87979'],
    tension: 0.3
  }
  ],

}
const chartOptions = {
  plugins: {
    filler: {
      propagate: false,
    },
    title: {
      display: true,
      text: (ctx) => title.value
    },
    label: {
      display: false
    }
  },
  interaction: {
    intersect: false,
  }
}

const fetchSellingCategoryStatistics = async () => {
  categorySellingLoading.value = true
  try {
    data.value = await api.get(dashboardEndpoint.getCategorySelling)
  } catch (error) {
    console.log(error)
  }
  categorySellingLoading.value = false
}

const onSelectType = (value) => {
  selectType.value = value;
  fetchSellingCategoryStatistics();
}

onMounted(() => {
  fetchSellingCategoryStatistics()
})

</script>