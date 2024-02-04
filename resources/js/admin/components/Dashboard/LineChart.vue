<template>
  <div class="line-chart">
    <Line :options="chartOptions" :data="chartData" />
  </div>
</template>
  
<script setup>
import { toRefs, computed } from 'vue';
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, CategoryScale, PointElement, LinearScale, LineElement } from 'chart.js';
ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale, LineElement, PointElement);

const props = defineProps({
  title: String,
  data: Object,
  type: {
    type: String,
    default: 'day'
  }
})
const { title, data, type } = toRefs(props);

const chartData = computed(() => ({
  labels: data.value?.labels,
  datasets: [{
    data: data?.value?.data,
    label: 'High',
    backgroundColor: '#f87979',
    borderColor: '#f87979',
    tension: 0.3
  }
  ],
}))
const chartOptions = computed(() => ({
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
  },
  responsive: true,
  maintainAspectRatio: false,
  scales: {
    x: {
      title: {
        display: true,
        text: type.value?.toUpperCase()
      }
    },
    y: {
      beginAtZero: true,
      max: Math.max(Math.max.apply(Math, data.value.data), type.value === 'day' ? 10:100),
      title: {
        display: true,
        text: 'Orders'
      },
      ticks: {
        // forces step size to be 50 units
        stepSize: type.value === 'day' ? Math.max(Math.max.apply(Math, data.value.data), type.value === 'day' ? 10:100) < 30 ? 2 : 10 : 20
      }
    }
  }
}))

</script>