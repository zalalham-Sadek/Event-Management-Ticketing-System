<template>
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
      <i class="fas fa-chart-line text-blue-600 mr-2"></i>
      Revenue Trend
    </h3>
    <div class="h-64">
      <BaseLineChart 
        v-if="chartData && chartData.labels.length > 0"
        :chartData="chartData" 
        :chartOptions="chartOptions" 
      />
      <div v-else class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400">
        <div class="text-center">
          <i class="fas fa-chart-line text-4xl mb-2"></i>
          <p>No revenue data available</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import BaseLineChart from './LineChart.vue'

const props = defineProps({
  monthlyRevenue: {
    type: Array,
    default: () => []
  }
})

const chartData = computed(() => {
  if (!props.monthlyRevenue || props.monthlyRevenue.length === 0) {
    return null
  }

  const labels = props.monthlyRevenue.map(item => {
    const date = new Date(item.year, item.month - 1)
    return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' })
  })

  const data = props.monthlyRevenue.map(item => parseFloat(item.revenue || 0))

  return {
    labels,
    datasets: [{
      label: 'Revenue',
      data,
      borderColor: '#3b82f6',
      backgroundColor: 'rgba(59, 130, 246, 0.1)',
      borderWidth: 2,
      fill: true,
      tension: 0.4
    }]
  }
})

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false
    }
  },
  scales: {
    y: {
      beginAtZero: true,
      ticks: {
        callback: function(value) {
          return '$' + value.toLocaleString()
        }
      }
    }
  }
}
</script>
