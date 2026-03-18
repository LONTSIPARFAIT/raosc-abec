<script setup lang="ts">
import { computed } from 'vue';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  ArcElement
} from 'chart.js';
import { Bar, Line, Pie } from 'vue-chartjs';

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  ArcElement
);

const props = defineProps<{
    type: 'bar' | 'line' | 'pie';
    data: any;
    options?: any;
}>();

const chartOptions = computed(() => ({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: true,
      position: 'bottom',
      labels: {
        usePointStyle: true,
        font: {
            family: 'Poppins',
            size: 10
        }
      }
    }
  },
  ...props.options
}));
</script>

<template>
  <div class="h-full w-full min-h-[300px]">
    <Bar v-if="type === 'bar'" :data="data" :options="chartOptions" />
    <Line v-else-if="type === 'line'" :data="data" :options="chartOptions" />
    <Pie v-else-if="type === 'pie'" :data="data" :options="chartOptions" />
  </div>
</template>
