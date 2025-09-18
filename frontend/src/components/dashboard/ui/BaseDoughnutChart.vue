<!-- /components/layout/ui/BaseDoughnutChart.vue -->
<template>
  <div class="relative w-full h-80">
    <canvas ref="canvas"></canvas>
  </div>
</template>

<script setup>
import { onMounted, watch, ref } from 'vue'
import { Chart, DoughnutController, ArcElement, Tooltip, Legend } from 'chart.js'

Chart.register(DoughnutController, ArcElement, Tooltip, Legend)

const props = defineProps({
  chartData: Object,
  chartOptions: Object
})

const canvas = ref(null)
let chartInstance = null

const renderChart = () => {
  if (chartInstance) chartInstance.destroy()
  chartInstance = new Chart(canvas.value, {
    type: 'doughnut',
    data: props.chartData,
    options: props.chartOptions
  })
}

onMounted(renderChart)
watch(() => props.chartData, renderChart, { deep: true })
</script>
